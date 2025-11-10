# Database Migrations Changelog

All notable database schema changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [Unreleased]

### Planned

- Messages/chat table for therapist-client communication
- Payments and billing tables
- Therapist availability scheduling
- Client goals tracking
- Session notes and reports

---

## [1.0.0] - 2025-11-01

### Added - Initial Migration System

#### Infrastructure

- **Migration System**: Complete database migration framework
  - `Migration.php` - Base migration class with helper methods
  - `migrate.php` - CLI runner for managing migrations
  - `seed.php` - Database seeder for sample data
  - Full documentation in `migrations/README.md`

#### Core Tables (Migrated from existing SQL)

- **users** (Migration: `20251101000001_create_users_table.php`)

  - User accounts and authentication
  - Supports multiple roles: client, therapist, admin
  - Google OAuth integration support
  - Indexes on email, google_id, role, created_on

- **therapists** (Migration: `20251101000002_create_therapists_table.php`)

  - Therapist profile information
  - License and credential storage
  - Specialization tracking
  - JSONB language support
  - Foreign key to users table
  - Indexes on user_id, specialization, created_at

- **booking_submissions** (Migration: `20251101000003_create_booking_submissions_table.php`)

  - Appointment booking requests
  - Status tracking (pending, confirmed, cancelled)
  - Indexes on email, date, status, created_at

- **questionnaire_responses** (Migration: `20251101000004_create_questionnaire_responses_table.php`)
  - Client intake questionnaire data
  - Therapy goals and preferences
  - Foreign key to users table
  - Indexes on user_id, submitted_at

#### New Tables

- **sessions** (Migration: `20251101000005_create_sessions_table.php`)

  - Therapy session tracking
  - Links clients with therapists
  - Appointment scheduling
  - Session type and status tracking
  - Session notes storage
  - Indexes on user_id, therapist_id, appointment_date, status, created_at

- **notifications** (Migration: `20251101000006_create_notifications_table.php`)

  - User notification system
  - Read/unread tracking
  - Notification types (info, warning, reminder, etc.)
  - Optional link to relevant pages
  - Composite index on (user_id, is_read)
  - Indexes on user_id, is_read, created_at

- **activity_logs** (Migration: `20251101000007_create_activity_logs_table.php`)
  - System activity tracking
  - User action logging
  - IP address and user agent capture
  - JSONB metadata storage for flexible data
  - GIN index on metadata for fast JSON queries
  - Indexes on user_id, action, created_at

#### Database Features

- PostgreSQL-specific features utilized:
  - SERIAL primary keys
  - JSONB data type for flexible storage
  - GIN indexes for JSON queries
  - CASCADE foreign key constraints
  - Timestamp defaults
  - CHECK constraints for enum-like behavior

#### Documentation

- `migrations/README.md` - Comprehensive migration system documentation
- `MIGRATION_QUICKSTART.md` - Quick start guide
- `MIGRATIONS_INSTALL.md` - Installation and setup guide
- `MIGRATIONS_COMPLETE.md` - Complete feature summary
- `CHANGELOG.md` - This file

---

## Migration Statistics

### Total Migrations: 7

- Core tables: 4
- New tables: 3
- Tracking table: 1 (auto-created)

### Total Tables: 8

- users
- therapists
- booking_submissions
- questionnaire_responses
- sessions
- notifications
- activity_logs
- migrations

### Total Indexes: 25+

All tables have appropriate indexes for query performance

---

## How to Use This Changelog

### When Creating New Migrations

1. Create your migration:

   ```bash
   php migrations/migrate.php create "description_of_change"
   ```

2. After running the migration, update this changelog:

   ```markdown
   ## [Unreleased]

   ### Added

   - **table_name** (Migration: `YYYYMMDDHHmmss_description.php`)
     - Description of what this table does
     - Key features or columns
     - Any special indexes or constraints
   ```

3. Commit both the migration and changelog:
   ```bash
   git add migrations/ CHANGELOG.md
   git commit -m "Add table_name table for feature"
   ```

### When Deploying to Production

1. Move changes from [Unreleased] to a dated version:

   ```markdown
   ## [1.1.0] - 2025-11-15

   ### Added

   - Feature that was added
   ```

2. Create a git tag:
   ```bash
   git tag v1.1.0
   git push origin v1.1.0
   ```

---

## Change Categories

Use these categories when updating the changelog:

- **Added** - New tables, columns, indexes, or features
- **Changed** - Modifications to existing database structures
- **Deprecated** - Features that will be removed in future versions
- **Removed** - Tables, columns, or features that were deleted
- **Fixed** - Bug fixes in migrations or schema
- **Security** - Security-related changes

---

## Example Entry Format

```markdown
## [1.1.0] - 2025-11-15

### Added

- **messages** (Migration: `20251115100000_create_messages_table.php`)
  - Direct messaging between clients and therapists
  - Read/unread status tracking
  - Message threading support
  - Indexes on sender_id, recipient_id, created_at
  - Foreign keys to users table with CASCADE delete

### Changed

- **therapists** (Migration: `20251115110000_add_bio_to_therapists.php`)
  - Added `bio` TEXT column for therapist biography
  - Added `years_experience` INTEGER column
  - Added index on years_experience

### Fixed

- **sessions** (Migration: `20251115120000_fix_session_status_constraint.php`)
  - Updated status CHECK constraint to include 'rescheduled' option
  - Maintained backwards compatibility
```

---

## Version History

- **v1.0.0** (2025-11-01) - Initial migration system with 7 core tables
- Future versions will be added here as they are deployed

---

_This changelog helps track database schema evolution and makes it easier to_
_understand when and why changes were made to the database structure._
