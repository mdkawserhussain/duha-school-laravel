#!/usr/bin/env python3
"""Deploy git-tracked changes to production over SFTP (shell-free host).

Modes
  delta (default, push events):
      Applies git diff --name-status BEFORE..AFTER:
        A / C / M / T -> upload (atomic tmp + rename, mode preserved)
        D             -> delete remote file
        R             -> delete old path, upload new path
      BEFORE may be empty/zero (initial push, manual dispatch): a safe
      connectivity probe runs instead of any file modification.
  full (manual dispatch only):
      Uploads every git-tracked file. Never deletes. Use after verifying
      production parity (untouched files such as .env, vendor/, node_modules/,
      storage runtime, .gradebak* remain untouched on the server in all modes).

Environment
  SFTP_HOST, SFTP_USERNAME, SFTP_PASSWORD   (required)
  SFTP_PORT      default 22
  SFTP_BASE      default /home/duhaisco/public_html
"""

import argparse
import os
import posixpath
import stat as stat_module
import subprocess
import sys


def sh(args: list) -> str:
    out = subprocess.run(args, capture_output=True, text=True)
    if out.returncode != 0:
        raise RuntimeError(f"{args[0]} failed: {out.stderr.strip()}")
    return out.stdout


def valid_sha(sha: str | None) -> bool:
    if not sha:
        return False
    sha = sha.lower()
    if set(sha) == {"0"}:
        return False
    return len(sha) >= 7 and all(c in "0123456789abcdef" for c in sha)


def ensure_safety(rel: str) -> str:
    """Validate a REPO-RELATIVE target path (never absolute, never escaping)."""
    rel = rel.strip().replace("\\", "/")
    if not rel or rel.startswith("/") or rel.startswith("~"):
        raise RuntimeError(f"unsafe path rejected: {rel!r}")
    parts = rel.split("/")
    if not all(p and p not in (".", "..") for p in parts):
        raise RuntimeError(f"unsafe path rejected: {rel!r}")
    return rel


def parse_delta(before: str, after: str) -> list:
    raw = sh(["git", "diff", "--name-status", "-z", "-M", before, after, "--"])
    tokens = [t for t in raw.split("\0") if t]
    ops = []
    i = 0
    while i < len(tokens):
        st = tokens[i]
        i += 1
        kind = "".join(ch for ch in st if ch.isalpha())
        old = tokens[i]
        i += 1
        if kind in ("R", "C"):
            new = tokens[i]
            i += 1
            if kind == "R":
                ops.append(("R", old, new))
            else:
                ops.append(("A", new, None))
        elif kind == "A":
            ops.append(("A", old, None))
        elif kind == "M":
            ops.append(("M", old, None))
        elif kind == "T":
            ops.append(("T", old, None))
        elif kind == "D":
            ops.append(("D", old, None))
        else:
            raise RuntimeError(f"unhandled git status {st!r} for {old!r}")
    return ops


class Deployer:
    def __init__(self):
        import paramiko

        self.paramiko = paramiko
        base = os.environ.get("SFTP_BASE", "/home/duhaisco/public_html").strip()
        base_parts = base.split("/")
        if not base.startswith("/") or any(p in (".", "..") for p in base_parts):
            raise RuntimeError(f"unsafe SFTP_BASE rejected: {base!r}")
        self.base = base.rstrip("/")
        client = paramiko.SSHClient()
        client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        client.connect(
            hostname=os.environ["SFTP_HOST"],
            port=int(os.environ.get("SFTP_PORT", "22")),
            username=os.environ["SFTP_USERNAME"],
            password=os.environ["SFTP_PASSWORD"],
            look_for_keys=False,
            allow_agent=False,
            timeout=20,
            banner_timeout=20,
            auth_timeout=20,
        )
        self.sftp = client.open_sftp()
        self._keepalive = client
        self.mkdir_cache: set = {self.base}
        self.uploaded = self.deleted = self.skipped = 0
        self.failures: list = []

    def remote(self, rel: str) -> str:
        return f"{self.base}/{rel}"

    def mkdirs(self, rel: str):
        parent = posixpath.dirname(self.remote(rel))
        if parent in self.mkdir_cache:
            return
        cur = ""
        for p in parent.strip("/").split("/"):
            cur = f"{cur}/{p}"
            if cur in self.mkdir_cache:
                continue
            try:
                self.sftp.stat(cur)
            except FileNotFoundError:
                self.sftp.mkdir(cur)
            self.mkdir_cache.add(cur)
        self.mkdir_cache.add(parent)

    def upload(self, rel: str):
        rel = ensure_safety(rel)
        if not os.path.isfile(rel):
            self.failures.append(f"missing in-commit file: {rel}")
            return
        dest = self.remote(rel)
        self.mkdirs(rel)
        try:
            st_mode = self.sftp.stat(dest).st_mode & 0o777
        except FileNotFoundError:
            st_mode = 0o644
        tmp = dest + ".ghdeploy-tmp"
        try:
            self.sftp.put(rel, tmp)
            try:
                self.sftp.posix_rename(tmp, dest)
            except (OSError, IOError):
                try:
                    self.sftp.remove(dest)
                except FileNotFoundError:
                    pass
                self.sftp.rename(tmp, dest)
            self.sftp.chmod(dest, st_mode)
            if self.sftp.stat(dest).st_size != os.path.getsize(rel):
                raise RuntimeError("size mismatch after upload")
            self.uploaded += 1
        except Exception as e:
            self.failures.append(f"upload failed {rel}: {e}")

    def delete(self, rel: str):
        rel = ensure_safety(rel)
        dest = self.remote(rel)
        try:
            st = self.sftp.stat(dest)
        except FileNotFoundError:
            self.skipped += 1
            return
        try:
            if stat_module.S_ISDIR(st.st_mode):
                self.failures.append(f"refusing to delete directory as file: {rel}")
                return
            self.sftp.remove(dest)
            self.deleted += 1
        except Exception as e:
            self.failures.append(f"delete failed {rel}: {e}")

    def probe(self):
        self.sftp.stat(self.base)
        print(f"PROBE OK: base {self.base} reachable")

    def close(self):
        clean = not self.failures
        try:
            self.sftp.close()
        finally:
            self._keepalive.close()
        print(f"\nSUMMARY: uploads={self.uploaded} deletes={self.deleted} skipped={self.skipped} failures={len(self.failures)}")
        for f in self.failures:
            print(f"FAILURE: {f}")
        return clean


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument("--mode", choices=["delta", "full"], default="delta")
    ap.add_argument("--before", default="")
    ap.add_argument("--after", default="")
    args0 = ap.parse_args()

    required = ["SFTP_HOST", "SFTP_USERNAME", "SFTP_PASSWORD"]
    missing = [k for k in required if not os.environ.get(k)]
    if missing:
        print(f"MISSING SECRETS: {missing} — set them as repository secrets")
        return 2

    d = Deployer()
    try:
        if args0.mode == "full":
            tracked = [p for p in sh(["git", "ls-files"]).splitlines() if p]
            print(f"FULL mode: {len(tracked)} tracked files -> upload all")
            for p in tracked:
                d.upload(p)
        else:
            if not valid_sha(args0.before) or not valid_sha(args0.after):
                print(f"DELTA probe: BEFORE={args0.before!r} AFTER={args0.after!r} unavailable")
                d.probe()
                print("No file operations performed. (Initial push or manual run — "
                      "real deltas deploy on push, or dispatch with mode=full after parity audit.)")
            else:
                ops = parse_delta(args0.before, args0.after)
                print(f"DELTA {args0.before[:8]}..{args0.after[:8]}: {len(ops)} changes")
                for op in ops:
                    kind, o, n = op
                    if kind == "R":
                        d.delete(o)
                        d.upload(n)
                    else:
                        (d.delete if kind == "D" else d.upload)(o)
    finally:
        ok = d.close()
    return 0 if ok else 1


if __name__ == "__main__":
    sys.exit(main())
