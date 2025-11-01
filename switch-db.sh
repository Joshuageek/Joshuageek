#!/bin/bash

# Database Environment Switcher
# Easily switch between local and production databases

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}╔════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   Database Environment Switcher        ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════╝${NC}"
echo ""

COMMAND=${1:-status}

case $COMMAND in
    local)
        if [ ! -f .env.local ]; then
            echo -e "${YELLOW}⚠️  .env.local not found!${NC}"
            echo ""
            echo "Creating template .env.local file..."
            cat > .env.local << 'EOF'
# Local Database Configuration
DATABASE_URL="postgresql://joshuauser:dev_password_123@localhost:5432/joshuageek"

# Application Settings
APP_ENV=development
APP_DEBUG=true
EOF
            echo -e "${GREEN}✅ Created .env.local${NC}"
            echo ""
            echo "Please edit .env.local with your local database credentials:"
            echo "  nano .env.local"
            echo ""
            echo "Then run: ./switch-db.sh local"
            exit 0
        fi
        
        cp .env.local .env
        echo -e "${GREEN}✅ Switched to LOCAL database${NC}"
        echo ""
        echo "Testing connection..."
        php test-db-connection.php
        ;;
    
    production|prod|neon)
        if [ ! -f .env.production ]; then
            echo -e "${YELLOW}⚠️  .env.production not found!${NC}"
            echo ""
            echo "Creating from current .env..."
            cp .env .env.production
            echo -e "${GREEN}✅ Created .env.production${NC}"
        fi
        
        cp .env.production .env
        echo -e "${GREEN}✅ Switched to PRODUCTION database (Neon)${NC}"
        echo ""
        echo "Testing connection..."
        php test-db-connection.php
        ;;
    
    status)
        if [ ! -f .env ]; then
            echo -e "${RED}❌ No .env file found!${NC}"
            exit 1
        fi
        
        echo -e "${BLUE}Current Database Configuration:${NC}"
        echo ""
        
        # Extract database URL
        DB_URL=$(grep "^DATABASE_URL=" .env | cut -d'"' -f2)
        
        if [[ $DB_URL == *"localhost"* ]]; then
            echo -e "  Environment: ${GREEN}LOCAL${NC}"
        elif [[ $DB_URL == *"neon.tech"* ]]; then
            echo -e "  Environment: ${YELLOW}PRODUCTION (Neon)${NC}"
        else
            echo -e "  Environment: ${BLUE}CUSTOM${NC}"
        fi
        
        # Parse connection details
        if [[ $DB_URL =~ postgresql://([^:]+):([^@]+)@([^:/]+):?([0-9]*)/([^?]+) ]]; then
            USER="${BASH_REMATCH[1]}"
            HOST="${BASH_REMATCH[3]}"
            PORT="${BASH_REMATCH[4]:-5432}"
            DB="${BASH_REMATCH[5]}"
            
            echo "  Host: $HOST"
            echo "  Port: $PORT"
            echo "  Database: $DB"
            echo "  User: $USER"
        fi
        
        echo ""
        echo "Available environment files:"
        [ -f .env.local ] && echo -e "  ${GREEN}✓${NC} .env.local (local database)" || echo -e "  ${RED}✗${NC} .env.local (not found)"
        [ -f .env.production ] && echo -e "  ${GREEN}✓${NC} .env.production (Neon database)" || echo -e "  ${RED}✗${NC} .env.production (not found)"
        
        echo ""
        echo "To switch databases:"
        echo "  ./switch-db.sh local       - Switch to local database"
        echo "  ./switch-db.sh production  - Switch to Neon database"
        ;;
    
    setup-local)
        echo -e "${BLUE}Setting up local PostgreSQL database...${NC}"
        echo ""
        
        # Check if PostgreSQL is installed
        if ! command -v psql &> /dev/null; then
            echo -e "${YELLOW}PostgreSQL not found. Installing...${NC}"
            sudo apt update
            sudo apt install -y postgresql postgresql-contrib
        else
            echo -e "${GREEN}✓${NC} PostgreSQL is installed"
        fi
        
        # Create database and user
        echo ""
        echo "Creating database 'joshuageek' and user 'joshuauser'..."
        
        sudo -u postgres psql << 'EOSQL'
-- Drop if exists (for clean setup)
DROP DATABASE IF EXISTS joshuageek;
DROP USER IF EXISTS joshuauser;

-- Create fresh
CREATE DATABASE joshuageek;
CREATE USER joshuauser WITH PASSWORD 'dev_password_123';
GRANT ALL PRIVILEGES ON DATABASE joshuageek TO joshuauser;
ALTER DATABASE joshuageek OWNER TO joshuauser;

\c joshuageek
GRANT ALL ON SCHEMA public TO joshuauser;
EOSQL
        
        echo -e "${GREEN}✅ Local database created!${NC}"
        echo ""
        
        # Create .env.local if it doesn't exist
        if [ ! -f .env.local ]; then
            cat > .env.local << 'EOF'
# Local Database Configuration
DATABASE_URL="postgresql://joshuauser:dev_password_123@localhost:5432/joshuageek"

# Application Settings
APP_ENV=development
APP_DEBUG=true
EOF
            echo -e "${GREEN}✅ Created .env.local${NC}"
        fi
        
        # Switch to local
        cp .env.local .env
        echo -e "${GREEN}✅ Switched to local database${NC}"
        echo ""
        
        # Test connection
        echo "Testing connection..."
        php test-db-connection.php
        
        echo ""
        echo -e "${GREEN}Local database is ready!${NC}"
        echo ""
        echo "Next steps:"
        echo "  1. Run migrations: php migrations/migrate.php up"
        echo "  2. Start developing!"
        ;;
    
    test)
        echo "Testing current database connection..."
        echo ""
        php test-db-connection.php
        ;;
    
    *)
        echo "Usage: ./switch-db.sh [command]"
        echo ""
        echo "Commands:"
        echo "  local         - Switch to local database"
        echo "  production    - Switch to production (Neon) database"
        echo "  status        - Show current database configuration"
        echo "  setup-local   - Install and configure local PostgreSQL"
        echo "  test          - Test current database connection"
        echo ""
        echo "Examples:"
        echo "  ./switch-db.sh local       # Use local database"
        echo "  ./switch-db.sh production  # Use Neon database"
        echo "  ./switch-db.sh status      # Check current setup"
        ;;
esac
