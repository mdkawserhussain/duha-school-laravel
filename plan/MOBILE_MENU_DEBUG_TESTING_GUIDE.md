# Mobile Menu Debug Testing Guide

## How to Test

1. **Open browser developer console** (F12 or right-click → Inspect → Console tab)

2. **Test at Top of Page (Should Work)**
   - Scroll to top of page
   - Click hamburger button
   - Check console logs:
     - Should see: `[DEBUG] Hamburger clicked - scrolled: false, mobileMenuOpen before: false`
     - Should see: `[DEBUG] mobileMenuOpen after: true`
     - Menu should open ✅

3. **Test When Scrolled (Currently Broken)**
   - Scroll down past 50px
   - Click hamburger button
   - Check console logs:
     - **What to look for:**
       - Does `[DEBUG] Hamburger clicked` appear?
       - If YES: Click handler is firing, but menu might not be opening
       - If NO: Click handler is NOT firing (element might be blocked)
     - Check scroll logs:
       - Are scroll events firing rapidly?
       - Is `mobileMenuOpen` being set/unset during scroll?

## Expected Console Output

### When Clicking at Top (Working)
```
[DEBUG] Document click - mobileMenuOpen: false, contains target: true, target: <button>
[DEBUG] Hamburger clicked - scrolled: false, mobileMenuOpen before: false
[DEBUG] mobileMenuOpen after: true
```

### When Clicking While Scrolled (Broken)
**Scenario A: Click handler not firing**
```
[DEBUG] Scroll event - pageYOffset: 100, scrolled: true, wasScrolled: true, mobileMenuOpen: false
[DEBUG] Scroll event - pageYOffset: 101, scrolled: true, wasScrolled: true, mobileMenuOpen: false
(No hamburger click log appears)
```

**Scenario B: Click handler fires but menu doesn't open**
```
[DEBUG] Scroll event - pageYOffset: 100, scrolled: true, wasScrolled: true, mobileMenuOpen: false
[DEBUG] Document click - mobileMenuOpen: false, contains target: true, target: <button>
[DEBUG] Hamburger clicked - scrolled: true, mobileMenuOpen before: false
[DEBUG] mobileMenuOpen after: true
[DEBUG] Scroll event - pageYOffset: 100, scrolled: true, wasScrolled: true, mobileMenuOpen: true
[DEBUG] Document click - mobileMenuOpen: true, contains target: false, target: <div>
[DEBUG] Closing menu - clicked outside
```

## What Each Log Tells Us

### `[DEBUG] Hamburger clicked`
- **If present**: Click handler is firing ✅
- **If absent**: Element is blocked or handler not attached ❌

### `[DEBUG] mobileMenuOpen after: true`
- **If true**: State is being set correctly ✅
- **If false**: Toggle is not working ❌

### `[DEBUG] Document click - contains target: false`
- **If false after hamburger click**: Event is bubbling and document listener might be interfering
- **If true**: Document listener should not interfere

### `[DEBUG] Scroll event` frequency
- **If firing rapidly**: Scroll handler might be interfering with click handler
- **If firing occasionally**: Scroll handler timing is probably fine

## Common Issues to Look For

### Issue 1: Click Handler Not Firing
**Symptoms**: No `[DEBUG] Hamburger clicked` log appears
**Possible Causes**:
- Element is blocked by another element (z-index issue)
- Pointer events disabled
- Element not in DOM when clicked

### Issue 2: State Toggles But Menu Doesn't Open
**Symptoms**: `mobileMenuOpen after: true` but menu stays closed
**Possible Causes**:
- Alpine.js `x-show` not reacting to state change
- CSS hiding the menu
- Z-index issue with menu overlay

### Issue 3: Menu Opens Then Immediately Closes
**Symptoms**: `mobileMenuOpen after: true` followed by `Closing menu - clicked outside`
**Possible Causes**:
- Document click listener firing immediately after toggle
- Event bubbling causing `@click.away` to fire
- Scroll event triggering during click

### Issue 4: Scroll Events Interfering
**Symptoms**: Scroll events firing during/right after hamburger click
**Possible Causes**:
- Scroll handler updating state during click
- Alpine.js reactivity queue getting blocked

## Next Steps Based on Results

### If click handler doesn't fire:
- Check z-index stacking
- Check pointer-events CSS
- Verify element is in DOM

### If click handler fires but menu doesn't open:
- Check Alpine.js reactivity
- Verify `x-show` directive
- Check CSS display/visibility

### If menu opens then closes immediately:
- Add `.stop` modifier to hamburger button
- Fix document click listener logic
- Prevent scroll handler during menu interaction

### If scroll events are interfering:
- Use `requestAnimationFrame` for scroll updates
- Debounce scroll handler
- Skip scroll updates when menu is open

