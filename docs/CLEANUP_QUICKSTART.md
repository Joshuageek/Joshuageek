# 🚀 Quick Start - Code Cleanup

## What This Does

Reorganizes your codebase from this mess:

```
❌ 30+ files in root/
❌ Mixed concerns
❌ Hard to find things
```

To this clean structure:

```
✅ pages/ - All pages organized by role
✅ public/ - Public entry points
✅ includes/ - Shared code
✅ Easy to navigate!
```

## How to Use

### 1. Preview Changes (Safe - No Changes Made)

```bash
php tools/organize-structure.php --dry-run
# or just
php tools/organize-structure.php
```

**This will show you:**

- What files will move
- Where they will go
- What paths will be updated
- No actual changes made!

### 2. Apply Changes (Creates Backup First)

```bash
php tools/organize-structure.php --execute
```

**This will:**

- ✅ Create automatic backup (`.backup_20250101123456/`)
- ✅ Move files to new structure
- ✅ Update all include/require paths
- ✅ Create redirect files (old URLs still work!)
- ✅ Remove duplicate files
- ✅ Generate complete report

### 3. Undo If Needed

```bash
php tools/organize-structure.php --rollback
```

**This will:**

- Restore everything from backup
- Put files back where they were
- No harm done!

---

## What Gets Moved

### Authentication → `public/auth/`

```
login.php              → public/auth/login.php
signup.php             → public/auth/signup.php
logout.php             → public/auth/logout.php
forgot-pwd.php         → public/auth/forgot-password.php
reset-password.php     → public/auth/reset-password.php
choose_role.php        → public/auth/choose-role.php
```

### Client Pages → `pages/client/`

```
client-dashboard.php   → pages/client/dashboard.php
booking.php            → pages/client/booking.php
question.php           → pages/client/questionnaire.php
notes.php              → pages/client/notes.php
paywall.php            → pages/client/paywall.php
```

### Therapist Pages → `pages/therapist/`

```
therapist-dashboard.php → pages/therapist/dashboard.php
signthera.php          → pages/therapist/registration.php
```

### Admin Pages → `pages/admin/`

```
admin-dashboard.php    → pages/admin/dashboard.php
admin/*.php            → pages/admin/*.php (all files)
```

### Public Pages → `pages/public/`

```
about.php              → pages/public/about.php
contact.php            → pages/public/contact.php
clinic.php             → pages/public/clinic.php
```

### Shared Code → `includes/`

```
header.php             → includes/layouts/header.php
footer.php             → includes/layouts/footer.php
constants.php          → includes/helpers/constants.php
```

---

## Example Output

```bash
$ php tools/organize-structure.php --dry-run

╔════════════════════════════════════════════════════════╗
║     Code Structure Organizer                          ║
╚════════════════════════════════════════════════════════╝

🔍 DRY RUN MODE - No files will be changed
   Run with --execute to apply changes

📦 Would create backup at: /home/dsn/Work/Joshuageek/.backup_20250101123456

📁 Creating new directory structure...
   → Would create: public/auth/
   → Would create: pages/client/
   → Would create: pages/therapist/
   → Would create: pages/admin/
   → Would create: pages/public/
   → Would create: includes/layouts/
   → Would create: includes/helpers/

📝 Moving files to new locations...
   → login.php
      to public/auth/login.php
   → signup.php
      to public/auth/signup.php
   [... more files ...]

📂 Moving directories...
   → admin/users.php
      to pages/admin/users.php
   [... more files ...]

🔧 Updating file paths in code...
   → Would update include/require paths
   → Would update relative links

🔀 Creating redirect files (for backward compatibility)...
   → Would create redirect files in old locations

🔍 Checking for duplicate files...
   → Would remove duplicate: admin/my_patients.php

╔════════════════════════════════════════════════════════╗
║     Reorganization Summary                            ║
╚════════════════════════════════════════════════════════╝

Files moved: 35
Paths updated: 28
Duplicates removed: 1

✅ Dry run complete!
   Run with --execute to apply these changes
```

---

## Safety Features

### ✅ Automatic Backup

- Creates timestamped backup before any changes
- Keeps original files safe
- Can rollback anytime

### ✅ Redirect Files

- Old URLs still work!
- Automatically redirects to new location
- No broken links

### ✅ Path Updates

- Automatically updates include/require statements
- Fixes relative paths
- Everything still works!

### ✅ Rollback Capability

- One command to undo everything
- Restores from backup
- Safe to experiment

---

## After Reorganization

Your new clean structure:

```
Joshuageek/
├── public/
│   └── auth/           ✅ All login/signup pages
│
├── pages/
│   ├── client/         ✅ Client dashboard & features
│   ├── therapist/      ✅ Therapist pages
│   ├── admin/          ✅ All admin pages
│   └── public/         ✅ Public pages (about, contact)
│
├── includes/
│   ├── layouts/        ✅ Header, footer, sidebar
│   └── helpers/        ✅ Functions, constants
│
├── config/             ✅ Configuration
├── migrations/         ✅ Database migrations
├── vendor/             ✅ Composer packages
└── index.php           ✅ Homepage (stays in root)
```

---

## Troubleshooting

### "File not found" errors

- Old URLs now redirect automatically
- Update bookmarks to new locations
- Check `.reorganization_manifest.json` for mapping

### Include/require errors

- Script auto-updates paths
- If you find one missed, update manually:

  ```php
  // Old
  include('header.php');

  // New
  include(__DIR__ . '/../../includes/layouts/header.php');
  ```

### Want to undo everything?

```bash
php tools/organize-structure.php --rollback
```

---

## Next Steps

After cleanup:

1. **Test everything**

   - Visit all pages
   - Check login/signup
   - Test admin functions

2. **Update documentation**

   - Update README with new structure
   - Document new file locations

3. **Git commit**

   ```bash
   git add .
   git commit -m "Reorganize code structure for better maintainability"
   ```

4. **Clean up old redirect files** (optional)
   - Once you're confident, remove redirect files
   - Update all hardcoded paths
   - Full migration complete!

---

## Questions?

- **Is this safe?** Yes! Automatic backup + rollback capability
- **Will URLs break?** No! Redirect files keep old URLs working
- **Can I customize?** Yes! Edit `tools/organize-structure.php`
- **Takes how long?** ~5 seconds to execute

**Ready to clean up your code?**

```bash
# Step 1: Preview
php tools/organize-structure.php

# Step 2: Apply
php tools/organize-structure.php --execute

# Step 3: Celebrate! 🎉
```
