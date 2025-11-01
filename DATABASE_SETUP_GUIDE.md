# Local vs Remote Database Setup Guide

## Current Setup Options

You have three ways to work with databases:

### Option 1: Use Neon (Remote) - Currently Active ✅

- Already configured in your `.env`
- No local PostgreSQL needed
- Perfect for production

### Option 2: Use Local PostgreSQL

- Install PostgreSQL on your machine
- Faster for development
- Works offline

### Option 3: Switch Between Both

- Use local for development
- Use Neon for production
- Easy to switch

---

## 🚀 Quick Setup for Local Database

### Step 1: Install PostgreSQL Locally

```bash
# Install PostgreSQL
sudo apt update
sudo apt install postgresql postgresql-contrib

# Start PostgreSQL service
sudo systemctl start postgresql
sudo systemctl enable postgresql
```

### Step 2: Create Your Local Database

```bash
# Switch to postgres user and create database
sudo -u postgres psql -c "CREATE DATABASE joshuageek;"

# Create a user (replace 'yourpassword' with your password)
sudo -u postgres psql -c "CREATE USER joshuauser WITH PASSWORD 'yourpassword';"

# Grant privileges
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE joshuageek TO joshuauser;"
sudo -u postgres psql -c "ALTER DATABASE joshuageek OWNER TO joshuauser;"
```

### Step 3: Create Environment Files

Create **TWO** environment files:

#### `.env.local` (for local development)

```bash
# Local Database Configuration
DATABASE_URL="postgresql://joshuauser:yourpassword@localhost:5432/joshuageek"

# Application Settings
APP_ENV=development
APP_DEBUG=true
```

#### `.env.production` (for Neon/production)

```bash
# Neon Database Configuration
DATABASE_URL="postgresql://neondb_owner:your_neon_password@ep-xxx.us-east-1.aws.neon.tech/neondb?sslmode=require"

# Application Settings
APP_ENV=production
APP_DEBUG=false
```

### Step 4: Use a Symlink to Switch

```bash
# Use local database
ln -sf .env.local .env

# Use production database
ln -sf .env.production .env
```

---

## 🎯 Easy Switch Script

Let me create a script to switch between databases easily:

```bash
# Switch to local
./switch-db.sh local

# Switch to production
./switch-db.sh production

# Check current database
./switch-db.sh status
```

---

## 📝 What Files You Can Remove

### Safe to Remove (Old SQL files - we have migrations now):

```bash
# These are now replaced by migration files
# BUT keep them as backup/documentation if you want
config/sql/user.sql              # Now: migrations/*_create_users_table.php
config/sql/therapist.sql         # Now: migrations/*_create_therapists_table.php
config/sql/booking_submissions.sql
config/sql/questionnaire_responses.sql
```

**Recommendation**: Keep the SQL files as documentation, but use migrations for actual changes.

### Do NOT Remove:

```bash
config/db.php                    # Database connection (needed!)
migrations/                      # All migration files (needed!)
.env                            # Environment config (needed!)
vendor/                         # Dependencies (needed!)
```

---

## 🔄 Complete Local Database Setup

### Quick Commands:

```bash
# 1. Install PostgreSQL
sudo apt install postgresql postgresql-contrib

# 2. Create database and user
sudo -u postgres psql << 'EOF'
CREATE DATABASE joshuageek;
CREATE USER joshuauser WITH PASSWORD 'dev_password_123';
GRANT ALL PRIVILEGES ON DATABASE joshuageek TO joshuauser;
ALTER DATABASE joshuageek OWNER TO joshuauser;
\q
EOF

# 3. Create local env file
cat > .env.local << 'EOF'
DATABASE_URL="postgresql://joshuauser:dev_password_123@localhost:5432/joshuageek"
APP_ENV=development
APP_DEBUG=true
EOF

# 4. Use local database
cp .env.local .env

# 5. Test connection
php test-db-connection.php

# 6. Run migrations
php migrations/migrate.php up

# 7. Verify tables created
psql -U joshuauser -d joshuageek -c "\dt"
```

---

## 🎨 Recommended Workflow

### Development (Local):

```bash
# Switch to local
cp .env.local .env

# Make changes, create migrations
php migrations/migrate.php create "add_new_feature"

# Edit migration file
nano migrations/*_add_new_feature.php

# Run migration locally
php migrations/migrate.php up

# Test your app
php -S localhost:8000
```

### Deploy to Production (Neon):

```bash
# Switch to production
cp .env.production .env

# Test connection
php test-db-connection.php

# Run migrations
php migrations/migrate.php up

# Push code to git
git add migrations/
git commit -m "Add new feature"
git push
```

---

## 📊 Database Comparison

| Feature      | Local PostgreSQL  | Neon (Remote)          |
| ------------ | ----------------- | ---------------------- |
| Speed        | ⚡ Very Fast      | 🌐 Network dependent   |
| Offline Work | ✅ Yes            | ❌ No                  |
| Setup        | 🔧 Manual install | ☁️ Already done        |
| Cost         | 💰 Free           | 💰 Free tier available |
| Production   | ⚠️ Need hosting   | ✅ Ready               |
| Backups      | 🔧 Manual         | ✅ Automatic           |

---

## 🎯 My Recommendation

**Best Setup**: Use **BOTH**

1. **Local for development**:
   - Fast
   - Works offline
   - Can break things safely
2. **Neon for production**:
   - Already configured
   - Automatic backups
   - Accessible from anywhere

**To switch**: Just copy the right env file:

```bash
cp .env.local .env      # Local dev
cp .env.production .env # Production
```

---

## 🚨 Current Status

Your Neon database is **working** ✅

**Next Steps**:

### If you want to use Neon (easier, already working):

```bash
# Just run migrations
php migrations/migrate.php up

# Check tables
php test-db-connection.php
```

### If you want to set up local database:

```bash
# Install PostgreSQL
sudo apt install postgresql postgresql-contrib

# Run the setup commands above

# Then run migrations
php migrations/migrate.php up
```

**You can do both!** Set up local for development, keep Neon for production.
