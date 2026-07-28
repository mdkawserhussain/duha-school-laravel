# Mobile Menu Investigation - Step by Step Analysis

## Problem Statement
Mobile menu opens and closes perfectly when page is at the top (transparent navbar) but does NOT open when user scrolls.

## Step 1: Understanding the Component Structure

### Header Element (Line 66-136)
- **Position**: `fixed top-0 left-0 w-full z-50`
- **Dynamic top position**: Changes based on scroll state and announcement bar
- **Alpine.js data**: `scrolled`, `mobileMenuOpen`, `hasAnnouncement`, `announcementHeight`

### Hamburger Button (Line 328-341)
- **Location**: Inside mobile nav container (`lg:hidden`)
- **Click handler**: `@click="mobileMenuOpen = !mobileMenuOpen"` (NO `.stop` modifier)
- **Z-index**: `z-[60]` relative to header
- **Pointer events**: Explicitly set to `auto`
- **Styles**: `pointer-events: auto; z-index: 60;`

### Mobile Menu Overlay (Line 345-483)
- **Z-index**: `z-[100]`
- **Click away**: `@click.away="mobileMenuOpen = false"` (Line 355)
- **Background overlay**: `@click="mobileMenuOpen = false"` (Line 356)

### Document Click Listener (Line 130-134)
```javascript
document.addEventListener('click', (e) => {
    if (mobileMenuOpen && !$el.contains(e.target)) {
        mobileMenuOpen = false;
    }
});
```

## Step 2: Analyzing Event Flow

### When Page is at Top (WORKS)
1. User clicks hamburger button
2. Click event fires on button
3. Event bubbles up to document
4. Document listener checks: `mobileMenuOpen && !$el.contains(e.target)`
   - At this point, `mobileMenuOpen` is still `false` (not yet toggled)
   - Condition evaluates to `false && true` = `false`
   - Nothing happens
5. Alpine.js processes `@click` handler
6. `mobileMenuOpen = !mobileMenuOpen` → `mobileMenuOpen = true`
7. Menu opens ✅

### When Page is Scrolled (DOESN'T WORK)
**Hypothesis**: Something is different about the event flow when scrolled.

## Step 3: Key Differences When Scrolled

### Header Position Changes
- **At top**: `top: {announcementHeight}px` (e.g., `top: 40px`)
- **When scrolled**: `top: 0` (set via `header.style.setProperty('top', '0', 'important')`)

### Scroll Handler (Line 104-111)
```javascript
window.addEventListener('scroll', () => {
    scrolled = window.pageYOffset > 50;
    if (scrolled) {
        header.style.setProperty('top', '0', 'important');
    } else {
        updateHeight();
    }
});
```

**CRITICAL FINDING**: The scroll handler runs on EVERY scroll event, potentially multiple times per second.

## Step 4: Potential Issues

### Issue #1: Event Timing Race Condition
**Theory**: When scrolled, the scroll handler might be running at the same time as the click event, causing Alpine.js reactivity to be in an inconsistent state.

**Evidence**:
- Scroll handler updates `scrolled` state
- Scroll handler modifies DOM (`header.style.setProperty`)
- This happens synchronously during scroll events
- Click event might fire during a scroll event

**Test**: Add `console.log` to verify timing

### Issue #2: Document Click Listener Interference
**Theory**: The document click listener might be interfering differently when scrolled.

**Analysis**:
- Document listener checks `!$el.contains(e.target)`
- `$el` is the `<header>` element
- Hamburger button is inside header, so `$el.contains(e.target)` should be `true`
- BUT: If Alpine.js hasn't processed the click yet, `mobileMenuOpen` is still `false`, so listener does nothing
- This should work the same way at top and when scrolled

**Conclusion**: Document listener is NOT the issue.

### Issue #3: Z-Index Stacking Context
**Theory**: When scrolled, something might be overlaying the hamburger button.

**Analysis**:
- Header: `z-50`
- Announcement bar: `z-60` (but hidden when scrolled via `x-show="!scrolled"`)
- Mobile nav container: `z-[60]` (relative to header)
- Hamburger button: `z-[60]` with `pointer-events: auto`

**Potential Issue**: When announcement bar hides, does it create a stacking context issue?

**Test**: Check if announcement bar is actually blocking clicks when scrolled (it shouldn't, as `x-show` sets `display: none`)

### Issue #4: Alpine.js Reactivity During Scroll
**Theory**: Alpine.js might be in the middle of updating reactive properties when the click happens.

**Analysis**:
- Scroll handler updates `scrolled` state
- Header `:style` binding depends on `scrolled`
- When `scrolled` changes, Alpine.js updates the header styles
- If click happens during this update, Alpine.js might not process it correctly

**Evidence Needed**: Check if Alpine.js click handlers fire when clicked during scroll

### Issue #5: CSS Transition Interference
**Theory**: The `transition-all duration-300` on the header might interfere with click events.

**Analysis**:
- Header has `transition-all duration-300`
- When scrolled, background color and box shadow change
- These transitions might affect pointer events

**Test**: Check if disabling transitions fixes the issue

## Step 5: Most Likely Root Cause

Based on the analysis, the most likely issue is **Issue #4: Alpine.js Reactivity During Scroll**.

### Why This Happens:
1. User scrolls → scroll handler fires
2. `scrolled` state changes from `false` to `true`
3. Alpine.js starts updating header styles (background color, box shadow)
4. User clicks hamburger button DURING this update
5. Alpine.js is busy updating styles and doesn't process the click handler immediately
6. OR: The click handler fires but the state update is queued behind the style updates
7. Menu doesn't open

### Why It Works at Top:
- At top, `scrolled` is `false` and stable
- No ongoing style updates when click happens
- Alpine.js processes click handler immediately
- Menu opens

## Step 6: Verification Steps

### Step 6.1: Add Debug Logging
Add console.log statements to verify timing:
```javascript
// In hamburger button click handler
@click="console.log('Hamburger clicked, scrolled:', scrolled); mobileMenuOpen = !mobileMenuOpen; console.log('mobileMenuOpen after toggle:', mobileMenuOpen)"

// In scroll handler
window.addEventListener('scroll', () => {
    console.log('Scroll event, pageYOffset:', window.pageYOffset);
    scrolled = window.pageYOffset > 50;
    console.log('scrolled state:', scrolled);
    // ...
});
```

### Step 6.2: Check if Click Handler Fires
Verify that the Alpine.js click handler is actually being called when scrolled.

### Step 6.3: Check State Updates
Verify that `mobileMenuOpen` is actually being toggled when clicked while scrolled.

### Step 6.4: Test with Scroll Handler Disabled
Temporarily disable the scroll handler to see if menu opens when scrolled.

## Step 7: Potential Solutions

### Solution 1: Debounce Scroll Handler
Prevent scroll handler from running too frequently:
```javascript
let scrollTimeout;
window.addEventListener('scroll', () => {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
        scrolled = window.pageYOffset > 50;
        if (scrolled) {
            header.style.setProperty('top', '0', 'important');
        } else {
            updateHeight();
        }
    }, 10);
});
```

### Solution 2: Use requestAnimationFrame for Scroll Updates
Ensure scroll updates happen at the right time:
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

### Solution 3: Prevent Scroll Handler During Menu Interaction
Skip scroll handler when menu is open or being opened:
```javascript
window.addEventListener('scroll', () => {
    if (mobileMenuOpen) return; // Skip updates when menu is open
    scrolled = window.pageYOffset > 50;
    // ...
});
```

### Solution 4: Use `.stop` Modifier on Hamburger Button
Prevent event bubbling to ensure click handler processes first:
```html
@click.stop="mobileMenuOpen = !mobileMenuOpen"
```

### Solution 5: Separate Scroll State from Style Updates
Use Alpine.js `$watch` to handle style updates separately from scroll detection:
```javascript
this.$watch('scrolled', (value) => {
    if (value) {
        header.style.setProperty('top', '0', 'important');
    } else {
        updateHeight();
    }
});
```

## Step 8: Recommended Fix

**Primary Fix**: Combine Solution #2 (requestAnimationFrame) + Solution #4 (.stop modifier)

**Why**:
- `requestAnimationFrame` ensures scroll updates happen at the right time in the render cycle
- `.stop` modifier ensures click handler processes before document listener
- This addresses both timing and event propagation issues

## Next Steps
1. Add debug logging to verify the root cause
2. Implement the recommended fix
3. Test on actual device/browser
4. Verify menu opens correctly at both top and when scrolled

