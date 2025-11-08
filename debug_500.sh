#!/bin/bash

echo "=== Laravel 500 Error Debugging Script ==="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in Laravel root
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Please run this script from Laravel root directory.${NC}"
    exit 1
fi

echo -e "${YELLOW}1. Clearing all caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
echo -e "${GREEN}✓ Caches cleared${NC}"
echo ""

echo -e "${YELLOW}2. Checking PHP syntax...${NC}"
find app -name "*.php" -exec php -l {} \; | grep -v "No syntax errors"
echo -e "${GREEN}✓ PHP syntax check complete${NC}"
echo ""

echo -e "${YELLOW}3. Checking storage permissions...${NC}"
if [ -w "storage" ]; then
    echo -e "${GREEN}✓ storage/ is writable${NC}"
else
    echo -e "${RED}✗ storage/ is NOT writable${NC}"
    echo "  Run: chmod -R 775 storage"
fi

if [ -w "bootstrap/cache" ]; then
    echo -e "${GREEN}✓ bootstrap/cache/ is writable${NC}"
else
    echo -e "${RED}✗ bootstrap/cache/ is NOT writable${NC}"
    echo "  Run: chmod -R 775 bootstrap/cache"
fi
echo ""

echo -e "${YELLOW}4. Checking .env file...${NC}"
if [ -f ".env" ]; then
    echo -e "${GREEN}✓ .env file exists${NC}"
    if grep -q "APP_KEY=" .env && ! grep -q "APP_KEY=$" .env; then
        echo -e "${GREEN}✓ APP_KEY is set${NC}"
    else
        echo -e "${RED}✗ APP_KEY is not set${NC}"
        echo "  Run: php artisan key:generate"
    fi
else
    echo -e "${RED}✗ .env file not found${NC}"
    echo "  Copy .env.example to .env and configure it"
fi
echo ""

echo -e "${YELLOW}5. Checking latest error log...${NC}"
if [ -f "storage/logs/laravel.log" ]; then
    echo -e "${YELLOW}Last 20 lines of error log:${NC}"
    tail -n 20 storage/logs/laravel.log
else
    echo -e "${YELLOW}No error log found${NC}"
fi
echo ""

echo -e "${YELLOW}6. Rebuilding cache for production...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓ Cache rebuilt${NC}"
echo ""

echo -e "${YELLOW}7. Checking database connection...${NC}"
php artisan migrate:status 2>&1 | head -n 5
echo ""

echo -e "${GREEN}=== Debugging complete ===${NC}"
echo ""
echo "If error persists, check:"
echo "  1. storage/logs/laravel.log for detailed error"
echo "  2. Server error logs (Apache/Nginx)"
echo "  3. PHP version (should be 8.1+)"
echo "  4. Composer dependencies: composer install --no-dev"

