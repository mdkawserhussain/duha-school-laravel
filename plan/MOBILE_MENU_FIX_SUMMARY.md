# Mobile Menu Fix Summary

## Root Cause
The mobile menu failed to open when scrolled due to two closing mechanisms firing on the same tap:
- A global document-level click handler closed the menu when the click target was outside the header.
- `@click.away` on the overlay container also closed the menu when the initial tap was interpreted as an outside click.

Scroll-driven header repositioning (`top` adjustments on scroll) increased the chance of this race when not at the very top, so the open tap was immediately followed by an outside-close event.

## What Changed

1. Stop immediate outside-close after open
- Added a short `justOpened` debounce and `@click.stop`/`@touchstart.stop.prevent` on the hamburger.
- Removed `@click.away` from the overlay; we now close via overlay background click/touch and the document handler.

2. Freeze header repositioning while menu is open
- Scroll handlers bail out when `mobileMenuOpen` is true, preventing layout shifts during activation.

3. Lock background scroll during menu open
- Toggle `menu-open` on `html`/`body` to apply `overflow: hidden`, `touch-action: none`, and `overscroll-behavior: contain`.

4. Touch and visual feedback
- Hamburger button gains a subtle active ring/background when open.
- Overlay supports both click and touch to close.

## Files Modified

- `resources/views/components/header.blade.php`
  - Added `justOpened` flag and improved document click logic.
  - Added `@click.stop` and `@touchstart.stop.prevent` on the hamburger.
  - Removed `@click.away` from overlay; added `id` attributes for trigger and overlay.
  - Paused scroll-driven positioning while menu is open.
  - Toggled `menu-open` class on `html`/`body` when the menu opens/closes.

- `resources/css/app.css`
  - Added `html.menu-open, body.menu-open` scroll lock rules.
  - Added `.mobile-menu { will-change: transform; }` to improve animation smoothness.

## Validation & Testing

- Verify menu opens/closes at both top of page and when scrolled.
- Check background scroll is frozen while the menu is open and resumes on close.
- Confirm hamburger button visual feedback (ring/background) on activation.
- iOS Safari: ensure taps reliably open the menu when scrolled; check overlay closes on touch.
- Android Chrome: confirm no accidental close during open; transitions remain smooth.

## Manual Test Checklist

- Tap hamburger at different scroll offsets (0px, 200px, 1000px).
- Tap rapidly to open/close; ensure no flicker or immediate re-close.
- Tap outside (page background) to close; tap within the panel should not close.
- Scroll inside the menu panel; background should not scroll.
- Rotate device (portrait/landscape) and re-test opens/closes.
- Screen readers: `aria-expanded` reflects state; overlay receives focus and Escape closes.

## Notes

This fix is purposely scoped to mobile menu behavior. Broader hero `100vh/100vw` and global `overflow: hidden` rules remain unchanged and should be addressed separately if they affect layout on some devices.

