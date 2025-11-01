# Database Connection Issue - How to Fix

## Problem

You're getting: `password authentication failed for user 'neondb_owner'`

This means the database credentials in your `.env` file are incorrect or have changed.

## Solutions

### Option 1: Get Fresh Credentials from Neon (Recommended)

1. **Go to Neon Dashboard**: https://console.neon.tech
2. **Select your project**: "Joshuageek" or whatever you named it
3. **Click "Connection Details"** or "Connect"
4. **Copy the connection string** - it looks like:
   ```
   postgresql://username:password@host/database?sslmode=require
   ```
5. **Update your `.env` file**:
   ```bash
   nano .env
   ```
   Replace the DATABASE_URL line with the new connection string

### Option 2: Reset Database Password in Neon

1. Go to Neon Dashboard
2. Select your project
3. Go to Settings → Reset Password
4. Copy the new password
5. Update your `.env` file with the new password

### Option 3: Test Connection Manually

Try connecting with psql to verify the credentials:

```bash
# Test the connection
psql "postgresql://neondb_owner:npg_dv2JozS3htaH@ep-gentle-poetry-add1h74y-pooler.us-east-1.aws.neon.tech/neondb?sslmode=require"
```

If this fails, your credentials are definitely wrong.

### Option 4: Use a Local PostgreSQL Database (For Development)

If you want to work locally first:

1. **Install PostgreSQL locally**:

   ```bash
   sudo apt install postgresql postgresql-contrib
   ```

2. **Create a database**:

   ```bash
   sudo -u postgres createdb joshuageek
   sudo -u postgres psql -c "CREATE USER myuser WITH PASSWORD 'mypassword';"
   sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE joshuageek TO myuser;"
   ```

3. **Update `.env` for local**:

   ```
   DATABASE_URL="postgresql://myuser:mypassword@localhost:5432/joshuageek"
   ```

4. **Run migrations**:
   ```bash
   php migrations/migrate.php up
   ```

## Quick Fix Steps

```bash
# 1. Get your correct connection string from Neon console
# 2. Update .env file
nano .env

# 3. Update the DATABASE_URL line with the correct credentials
# It should look like:
# DATABASE_URL="postgresql://user:CORRECT_PASSWORD@host/database?sslmode=require"

# 4. Test the connection
php migrations/migrate.php status

# 5. Run migrations
php migrations/migrate.php up

# 6. Verify tables were created
psql $DATABASE_URL -c "\dt"
```

## What Happens After You Fix It

Once your database credentials are correct:

1. Run `php migrations/migrate.php status` - should show 4 pending migrations
2. Run `php migrations/migrate.php up` - will create all tables
3. Run `psql $DATABASE_URL -c "\dt"` - should show:
   - users
   - therapists
   - booking_submissions
   - questionnaire_responses
   - migrations (tracking table)

## Need Help?

The most common issue is that:

- The password in Neon changed
- The connection string was copied incorrectly
- There are extra spaces or quotes in the .env file

**Fix**: Get a fresh connection string from Neon console and update your `.env` file.
