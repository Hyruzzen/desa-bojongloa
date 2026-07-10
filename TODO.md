# TODO - File Manager Dashboard UI

- [x] Update `resources/views/layouts/app.blade.php` to match File Manager Dashboard design:
  - [x] Soft teal-blue background
  - [x] Left white minimal sidebar with consistent gray icons
  - [x] User profile section at bottom
  - [x] Sticky/affixed sidebar (does not scroll with main content)
  - [x] Header: “My Folders” + subtitle, icons on the right, and “+” action button
  - [x] Add hamburger button to show/hide sidebar (mobile)

- [x] Update `resources/views/dashboard.blade.php` to match required dashboard sections:
  - [x] Top 3 folder summary cards with gradient icons + green progress bars
  - [x] Big multi-color bar chart (Mon-Sun + value labels 2514/825/789)
  - [x] “Photos” and “Videos” favorite cards with counts and avatar stack
  - [x] Right sidebar section inside dashboard: storage donut (65% Used) + “Other Folders” list
  - [x] Add graceful fallbacks when category data is fewer than expected
- [ ] Run quick sanity check (manual):
  - [ ] `php artisan serve` and verify `/dashboard` loads without Blade errors
  - [ ] Verify charts render and layout matches reference

