# ✅ YES! You Can Use SQL Files to Create Migrations

Great question! I've created a tool that converts your SQL files directly into migration files.

## What I Created

### New Tool: `sql-to-migration.php`

A converter that:

- ✅ Reads your SQL files from `config/sql/`
- ✅ Converts MySQL syntax → PostgreSQL automatically
- ✅ Generates proper migration files
- ✅ Handles indexes, foreign keys, and constraints
- ✅ Creates rollback (down) methods

## Quick Examples

### Convert All SQL Files

```bash
php migrations/sql-to-migration.php --all
```

This finds all `.sql` files in `config/sql/` and converts them to migrations!

### Convert Single File

```bash
php migrations/sql-to-migration.php config/sql/therapist.sql
```

### Preview Before Converting

```bash
php migrations/sql-to-migration.php --preview config/sql/therapist.sql
```

Shows you what the conversion will look like without creating files.

## What It Converts

The tool automatically handles these MySQL → PostgreSQL conversions:

| From (MySQL)               | To (PostgreSQL)           |
| -------------------------- | ------------------------- |
| `INT(11) AUTO_INCREMENT`   | `SERIAL PRIMARY KEY`      |
| `TINYINT(1)`               | `BOOLEAN`                 |
| `ENUM('yes','no')`         | `VARCHAR(10) CHECK (...)` |
| `LONGTEXT` with json_valid | `JSONB`                   |
| `current_timestamp()`      | `CURRENT_TIMESTAMP`       |
| Backticks `                | Removed                   |

## Example Conversion

**Your SQL file** (`config/sql/therapist.sql`):

```sql
CREATE TABLE IF NOT EXISTS therapists (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  internet_connection ENUM('yes','no') NOT NULL,
  consent_verification TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
);
```

**Generated Migration** (`migrations/20251101000001_create_therapists_table.php`):

```php
<?php
require_once __DIR__ . '/Migration.php';

class CreateTherapistsTable extends Migration
{
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS therapists (
              id SERIAL PRIMARY KEY,
              user_id INTEGER NOT NULL,
              internet_connection VARCHAR(10) CHECK (internet_connection IN ('yes', 'no')) NOT NULL,
              consent_verification BOOLEAN NOT NULL DEFAULT FALSE
            );
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS therapists CASCADE";
        $this->execute($sql);
    }
}
```

## Two Workflows Available

### Workflow 1: Convert Existing SQL Files

```bash
# Convert all your existing SQL files
php migrations/sql-to-migration.php --all

# Run the migrations
php migrations/migrate.php up
```

### Workflow 2: Keep Using SQL Files

```bash
# 1. Write your changes in SQL
nano config/sql/new_table.sql

# 2. Convert to migration
php migrations/sql-to-migration.php config/sql/new_table.sql

# 3. Run migration
php migrations/migrate.php up

# 4. Commit both
git add config/sql/new_table.sql migrations/*.php
```

## Your Existing SQL Files

I checked your `config/sql/` directory. You have:

1. ✅ `user.sql` - Already PostgreSQL format
2. ✅ `therapist.sql` - MySQL format (needs conversion)
3. ✅ `booking_submissions.sql` - Already PostgreSQL format
4. ✅ `questionnaire_responses.sql` - Already PostgreSQL format

## Try It Now!

### See What Would Be Generated

```bash
# Preview the therapist table conversion
php migrations/sql-to-migration.php --preview config/sql/therapist.sql
```

### Convert and Create Migration Files

```bash
# Convert all SQL files
php migrations/sql-to-migration.php --all

# Check what was created
ls -lh migrations/*_create_*_table.php

# See migration status
php migrations/migrate.php status
```

## Benefits

✅ **Keep Your SQL Files** - Use them as documentation  
✅ **Automatic Conversion** - MySQL → PostgreSQL handled for you  
✅ **Version Control** - Migrations track when changes were made  
✅ **Rollback Ready** - Down methods auto-generated  
✅ **Team Friendly** - Everyone can use the same workflow

## Documentation

- **Full Guide**: `migrations/SQL_TO_MIGRATION.md`
- **Migration Docs**: `migrations/README.md`
- **Quick Start**: `MIGRATION_QUICKSTART.md`

## Summary

**Yes!** You can absolutely use your SQL files to create migrations. The tool I created:

1. Reads your SQL files
2. Converts MySQL → PostgreSQL automatically
3. Generates proper migration files
4. Handles indexes, constraints, and foreign keys
5. Creates rollback methods

You can either:

- Convert all existing SQL files once: `php migrations/sql-to-migration.php --all`
- Or keep writing SQL and convert as needed: `php migrations/sql-to-migration.php <file>`

**Both workflows are supported!** 🎉
