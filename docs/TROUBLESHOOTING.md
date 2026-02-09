# Troubleshooting Guide

This document contains solutions to common issues encountered in the TPT application.

---

## Table of Contents

1. [Alpine/WireUI/Livewire Console Errors](#alpinewireuilivewire-console-errors)

---

## Alpine/WireUI/Livewire Console Errors

### Problem

Console shows multiple errors like:
- `Alpine Expression Error: wireui_notifications is not defined`
- `Alpine Expression Error: wireui_dialog is not defined`
- `Alpine Expression Error: notifications is not defined`
- `Alpine Expression Error: show is not defined`
- `Uncaught ReferenceError: wireui_notifications is not defined`

### Cause

**Script loading order is incorrect.** WireUI needs to register its Alpine components BEFORE `Alpine.start()` is called. If `Alpine.start()` runs first, WireUI's components (`wireui_notifications`, `wireui_dialog`, etc.) won't be available.

### Solution

#### 1. Modify `resources/js/app.js`

Remove or comment out `Alpine.start()` - it will be called manually in the layout:

```javascript
import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'

Alpine.plugin(collapse)
window.Alpine = Alpine;

// Don't auto-start Alpine - let it be started after WireUI registers its components
// Alpine.start() will be called in the layout after @wireUiScripts
```

#### 2. Update the Blade Layout

Ensure scripts are loaded in this exact order at the end of `<body>`:

```blade
    @livewireScripts
    <script src="{{ mix('js/app.js') }}"></script>
    @wireUiScripts
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.Alpine.start();
        });
    </script>
</body>
```

Styles should be in `<head>`:

```blade
<head>
    <!-- ... other head content ... -->
    @livewireStyles
    @wireUiStyles
</head>
```

#### 3. Rebuild Assets

After modifying `app.js`, rebuild the assets:

```bash
npm run dev
# or for production
npm run production
```

#### 4. Clear Laravel Cache

```bash
php artisan view:clear
php artisan cache:clear
```

#### 5. Hard Refresh Browser

Press `Ctrl+Shift+R` (Windows/Linux) or `Cmd+Shift+R` (Mac) to clear browser cache.

### Script Loading Order Explanation

| Order | Script | Purpose |
|-------|--------|---------|
| 1 | `@livewireScripts` | Loads Livewire JavaScript |
| 2 | `app.js` | Imports Alpine, sets `window.Alpine` (but doesn't start) |
| 3 | `@wireUiScripts` | Registers WireUI components with Alpine |
| 4 | `Alpine.start()` | Starts Alpine after all components are registered |

### Files Modified

- `resources/js/app.js` - Removed `Alpine.start()`
- `resources/views/components/layout/applicant.blade.php` - Fixed script order
- `resources/views/components/layout/admin.blade.php` - Fixed script order
- `resources/views/components/layout/ordinary.blade.php` - Fixed script order + removed duplicate `</body>` tag
- `resources/views/layouts/app.blade.php` - Fixed script order
- `resources/views/layouts/guest.blade.php` - Fixed script order

### Important Notes

- **Livewire refresh won't cause issues**: `Alpine.start()` only runs once on initial page load (DOMContentLoaded). Livewire uses DOM morphing (AJAX updates), not full page reloads. Livewire and Alpine are designed to work together.
- **All layouts must be updated**: If you create a new layout that uses Alpine/WireUI/Livewire, follow the same script order pattern.

### Date Fixed

2026-02-09

---

## Adding New Troubleshooting Entries

When documenting a new fix, include:
1. **Problem** - Error messages or symptoms
2. **Cause** - Root cause explanation
3. **Solution** - Step-by-step fix
4. **Files Modified** - List of changed files
5. **Date Fixed** - When the fix was applied
