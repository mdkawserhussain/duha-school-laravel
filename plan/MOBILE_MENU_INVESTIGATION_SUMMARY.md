# Mobile Menu Investigation Summary

## Problem
Mobile menu opens/closes perfectly at top of page (transparent navbar) but **does NOT open** when user scrolls.

## Investigation Steps Completed

### Step 1: Code Structure Analysis ✅
- Identified hamburger button click handler: `@click="mobileMenuOpen = !mobileMenuOpen"` (no `.stop` modifier)
- Identified document-level click listener that closes menu on outside clicks
- Identified scroll handler that updates header position and `scrolled` state
- Identified mobile menu overlay with `@click.away` directive

### Step 2: Event Flow Analysis ✅
**At Top (Works)**:
1. Click hamburger → Alpine.js processes `@click` → `mobileMenuOpen = true` → Menu opens

**When Scrolled (Broken)**:
- Same flow should work, but something is interfering

### Step 3: Key Differences Identified ✅

1. **Header Position Changes**
   - At top: `top: {announcementHeight}px`
   - When scrolled: `top: 0` (set via `setProperty` with `!important`)

2. **Scroll Handler Runs Frequently**
   - Scroll handler fires on every scroll event
   - Updates `scrolled` state synchronously
   - Modifies DOM (`header.style.setProperty`)
   - Could interfere with Alpine.js reactivity

3. **No Event Propagation Control**
   - Hamburger button lacks `.stop` modifier
   - Click event bubbles to document
   - Document listener might interfere

### Step 4: Debug Logging Added ✅
Added console.log statements to track:
- Hamburger button clicks
- Scroll events and state changes
- Document click events
- Menu state changes

## Most Likely Root Causes (Ranked)

### 1. **Alpine.js Reactivity Queue Blocking** (Most Likely)
**Theory**: When scrolled, the scroll handler updates `scrolled` state frequently. Alpine.js queues these updates. When user clicks hamburger, the click handler's state update gets queued behind scroll updates, causing delay or failure.

**Evidence**:
- Scroll handler runs synchronously on every scroll event
- Updates Alpine.js reactive state (`scrolled`)
- Modifies DOM directly (`header.style.setProperty`)
- No debouncing or `requestAnimationFrame` usage

**Fix**: Use `requestAnimationFrame` for scroll updates to ensure they happen at the right time in the render cycle.

### 2. **Event Timing Race Condition** (Likely)
**Theory**: Click event fires during or immediately after a scroll event. The scroll handler's DOM manipulation (`setProperty` with `!important`) might cause a reflow that interferes with click event processing.

**Evidence**:
- Scroll handler modifies DOM synchronously
- No timing control (no `requestAnimationFrame` or debouncing)
- Click might fire during scroll event processing

**Fix**: Use `requestAnimationFrame` or debounce scroll handler.

### 3. **Document Click Listener Interference** (Possible)
**Theory**: The document click listener fires before Alpine.js processes the hamburger click handler. When scrolled, something about the event timing causes the document listener to close the menu immediately after it opens.

**Evidence**:
- Document listener checks `mobileMenuOpen && !$el.contains(e.target)`
- Hamburger button is inside header, so `contains` should be true
- BUT: If event timing is off, document listener might fire after toggle but before menu renders

**Fix**: Add `.stop` modifier to hamburger button to prevent event bubbling.

### 4. **CSS Transition Interference** (Less Likely)
**Theory**: The `transition-all duration-300` on header might interfere with pointer events when scrolled.

**Evidence**:
- Header has `transition-all duration-300`
- Background color and box shadow change when scrolled
- Transitions might affect click event timing

**Fix**: Unlikely to be the issue, but could test by disabling transitions.

## Recommended Fixes (In Order)

### Fix #1: Use requestAnimationFrame for Scroll Updates (HIGH PRIORITY)
```javascript
window.addEventListener('scroll', () => {
    requestAnimationFrame(() => {
        scrolled = window.pageYOffset > 50;
        if (scrolled) {
            header.style.setProperty('top', '0', 'important');
        } else {
            updateHeight();
        }
    });
});
```

**Why**: Ensures scroll updates happen at the right time in the render cycle, preventing interference with click handlers.

### Fix #2: Add .stop Modifier to Hamburger Button (HIGH PRIORITY)
```html
@click.stop="mobileMenuOpen = !mobileMenuOpen"
```

**Why**: Prevents event bubbling to document listener, ensuring Alpine.js processes the click handler first.

### Fix #3: Prevent Scroll Handler During Menu Interaction (MEDIUM PRIORITY)
```javascript
window.addEventListener('scroll', () => {
    if (mobileMenuOpen) return; // Skip updates when menu is open
    requestAnimationFrame(() => {
        scrolled = window.pageYOffset > 50;
        // ...
    });
});
```

**Why**: Prevents scroll handler from interfering when menu is open or being opened.

### Fix #4: Debounce Scroll Handler (LOW PRIORITY - if Fix #1 doesn't work)
```javascript
let scrollTimeout;
window.addEventListener('scroll', () => {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
        requestAnimationFrame(() => {
            scrolled = window.pageYOffset > 50;
            // ...
        });
    }, 10);
});
```

**Why**: Reduces frequency of scroll handler execution, but `requestAnimationFrame` should be sufficient.

## Testing Plan

1. **Add debug logging** ✅ (Done)
2. **Test in browser**:
   - Open console
   - Test at top (should work)
   - Test when scrolled (check logs)
   - Identify which scenario matches the behavior
3. **Apply Fix #1** (requestAnimationFrame)
4. **Test again** - if still broken, apply Fix #2
5. **Test again** - if still broken, apply Fix #3
6. **Remove debug logging** once fixed

## Expected Behavior After Fixes

- Menu should open when clicking hamburger at top ✅ (already works)
- Menu should open when clicking hamburger when scrolled ✅ (should work after fixes)
- Menu should close when clicking outside ✅ (already works)
- Menu should close when clicking overlay background ✅ (already works)
- Scroll handler should not interfere with menu interaction ✅ (should work after fixes)

## Files Modified

1. `resources/views/components/header.blade.php`
   - Added debug logging to hamburger button click handler
   - Added debug logging to scroll handlers
   - Added debug logging to document click listener

## Next Steps

1. **Test with debug logging** to confirm root cause
2. **Apply Fix #1** (requestAnimationFrame) - most likely to fix the issue
3. **Apply Fix #2** (.stop modifier) - good practice regardless
4. **Test thoroughly** on actual device/browser
5. **Remove debug logging** once confirmed fixed

