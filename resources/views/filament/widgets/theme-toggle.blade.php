<div class="flex items-center gap-2" x-data>
    <button
        type="button"
        aria-label="Toggle theme"
        x-on:click="(() => {
            const current = window.Alpine.store('theme');
            const next = current === 'dark' ? 'light' : 'dark';
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: next }));
        })()"
        class="fi-theme-toggle inline-flex items-center justify-center rounded-full p-2 bg-white dark:bg-aisd-gold/5 dark:text-white"
        x-bind:class="{ 'bg-aisd-gold text-aisd-midnight': window.Alpine?.store('theme') === 'dark' }">
        <svg x-show="window.Alpine?.store('theme') === 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m8.464-8.464h-1M3.536 12H2.536M17.657 6.343l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 000 14 7 7 0 000-14z" />
        </svg>
        <svg x-show="window.Alpine?.store('theme') !== 'dark'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
        </svg>
    </button>
</div>
