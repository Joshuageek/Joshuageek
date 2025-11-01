# SQL to Migration Converter

This tool automatically converts your SQL files into proper migration files, handling MySQL to PostgreSQL conversion automatically.

## Why Use This Tool?

Instead of manually creating migration files, you can:

1. Write or keep your SQL files in `config/sql/`
2. Run the converter to generate migration files automatically
3. The tool handles MySQL → PostgreSQL conversion for you

## Features

- ✅ Converts MySQL syntax to PostgreSQL
- ✅ Handles AUTO_INCREMENT → SERIAL
- ✅ Converts ENUM to VARCHAR with CHECK constraints
- ✅ Converts TINYINT(1) to BOOLEAN
- ✅ Converts JSON validation to JSONB
- ✅ Preserves indexes and foreign keys
- ✅ Generates proper rollback (down) methods
- ✅ Preview mode to check conversion before creating files

## Usage

### Convert All SQL Files

```bash
php migrations/sql-to-migration.php --all
```

This will:

- Find all `.sql` files in `config/sql/`
- Convert each to a migration file
- Place them in the `migrations/` directory with timestamps

### Convert Single File

```bash
php migrations/sql-to-migration.php config/sql/users.sql
```

### Preview Conversion (Without Creating Files)

```bash
php migrations/sql-to-migration.php --preview config/sql/therapist.sql
```

This shows you:

- Original MySQL SQL
- Converted PostgreSQL SQL
- What the migration file name would be

### Get Help

```bash
php migrations/sql-to-migration.php --help
```

## Conversion Examples

### MySQL AUTO_INCREMENT → PostgreSQL SERIAL

**Input (MySQL):**

```sql
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  PRIMARY KEY (id)
);
```

**Output (PostgreSQL):**

```sql
CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255)
);
```

### ENUM → VARCHAR with CHECK

**Input (MySQL):**

```sql
CREATE TABLE therapists (
  internet_connection ENUM('yes','no') NOT NULL
);
```

**Output (PostgreSQL):**

```sql
CREATE TABLE IF NOT EXISTS therapists (
  internet_connection VARCHAR(10) CHECK (internet_connection IN ('yes', 'no')) NOT NULL
);
```

### TINYINT(1) → BOOLEAN

**Input (MySQL):**

```sql
CREATE TABLE therapists (
  consent_verification TINYINT(1) NOT NULL DEFAULT 0,
  consent_data TINYINT(1) NOT NULL DEFAULT 1
);
```

**Output (PostgreSQL):**

```sql
CREATE TABLE IF NOT EXISTS therapists (
  consent_verification BOOLEAN NOT NULL DEFAULT FALSE,
  consent_data BOOLEAN NOT NULL DEFAULT TRUE
);
```

### JSON Validation → JSONB

**Input (MySQL):**

```sql
CREATE TABLE therapists (
  languages LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin
    NOT NULL CHECK (json_valid(languages))
);
```

**Output (PostgreSQL):**

```sql
CREATE TABLE IF NOT EXISTS therapists (
  languages JSONB NOT NULL
);
```

## Workflow Example

### Option 1: Start with SQL Files

```bash
# 1. Create your SQL file
echo "CREATE TABLE posts (
  id INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  content TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);" > config/sql/posts.sql

# 2. Convert to migration
php migrations/sql-to-migration.php config/sql/posts.sql

# 3. Review the generated migration
cat migrations/*_create_posts_table.php

# 4. Run the migration
php migrations/migrate.php up
```

### Option 2: Convert All Existing SQL Files

```bash
# Convert all SQL files at once
php migrations/sql-to-migration.php --all

# Check what was created
php migrations/migrate.php status

# Run all migrations
php migrations/migrate.php up
```

## Advanced Usage

### Adding Foreign Keys

If your SQL file includes foreign keys:

```sql
CREATE TABLE sessions (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

The converter will automatically convert this to PostgreSQL format:

```sql
CREATE TABLE IF NOT EXISTS sessions (
  id SERIAL PRIMARY KEY,
  user_id INTEGER NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Custom Modifications

After generating a migration, you can edit it to add custom logic:

```bash
# Generate base migration
php migrations/sql-to-migration.php config/sql/users.sql

# Edit the generated file
nano migrations/*_create_users_table.php

# Add custom indexes, constraints, or seed data in the up() method
```

## Tips

1. **Preview First**: Always preview before converting to see what changes will be made

   ```bash
   php migrations/sql-to-migration.php --preview config/sql/tablename.sql
   ```

2. **Keep SQL Files**: Don't delete your original SQL files - they serve as documentation

3. **Review Generated Migrations**: Always review the generated migration files before running them

4. **Test Locally**: Test migrations on a development database first

5. **Version Control**: Commit both SQL files and generated migrations to git

## Troubleshooting

### "Table already exists" Error

If you already have migration files for a table:

1. Delete the old migration file, or
2. Use a different timestamp by waiting a second between conversions

### Conversion Issues

If the converter doesn't handle a specific SQL syntax:

1. Use `--preview` to see the output
2. Manually edit the generated migration file
3. Or create a migration manually using `php migrations/migrate.php create "name"`

### Complex SQL Not Converting Properly

For complex SQL with stored procedures, triggers, or views:

1. Generate a base migration using the converter
2. Manually edit the migration file to add the complex parts
3. Test thoroughly

## Integration with Existing Workflow

### If You Have Existing SQL Files

```bash
# 1. Convert all existing SQL files
php migrations/sql-to-migration.php --all

# 2. Check status
php migrations/migrate.php status

# 3. If tables already exist, mark migrations as executed
# See MIGRATIONS_COMPLETE.md for instructions

# 4. Run new migrations only
php migrations/migrate.php up
```

### If You Want to Keep Using SQL Files

You can continue using SQL files for documentation:

```bash
# 1. Write your changes in SQL file
nano config/sql/new_feature.sql

# 2. Convert to migration
php migrations/sql-to-migration.php config/sql/new_feature.sql

# 3. Run migration
php migrations/migrate.php up

# 4. Commit both files
git add config/sql/new_feature.sql migrations/*_new_feature.php
git commit -m "Add new feature table"
```

## Supported Conversions

| MySQL                      | PostgreSQL                           |
| -------------------------- | ------------------------------------ |
| INT(n)                     | INTEGER                              |
| AUTO_INCREMENT             | SERIAL                               |
| TINYINT(1)                 | BOOLEAN                              |
| ENUM('a','b')              | VARCHAR(10) CHECK (col IN ('a','b')) |
| LONGTEXT (with json_valid) | JSONB                                |
| current_timestamp()        | CURRENT_TIMESTAMP                    |
| PRIMARY KEY (id)           | PRIMARY KEY (in column definition)   |
| Backticks `                | Removed                              |

## What Gets Generated

Each migration file includes:

```php
<?php
require_once __DIR__ . '/Migration.php';

class CreateTableNameTable extends Migration
{
    public function up()
    {
        $sql = "
            -- Your PostgreSQL CREATE TABLE statement
            -- Includes indexes
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
            DROP TABLE IF EXISTS table_name CASCADE;
        ";

        $this->execute($sql);
    }
}
```

## See Also

- `migrations/README.md` - Migration system documentation
- `MIGRATION_QUICKSTART.md` - Quick start guide
- `MIGRATIONS_COMPLETE.md` - Complete feature guide

---

**Now you can maintain your schema in SQL files and automatically generate migrations!** 🚀
