# TODO - Supabase Storage Integration for Complaints Evidence

- [x] Update `config/services.php` with Supabase config keys.
- [x] Update `app/Http/Controllers/ComplaintController.php` to upload evidence files to Supabase Storage bucket (`evidence`) instead of local disk.
- [x] Update `resources/views/complaints/index.blade.php` to render evidence images from Supabase public URLs/paths safely.
- [ ] Run critical-path testing:
  - [ ] Submit complaint with image
  - [ ] Verify image path/URL stored in DB
  - [ ] Verify admin on another device can view uploaded image
