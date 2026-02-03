# Deployment Guide

## Prerequisites

### Server Requirements

- **OS:** Ubuntu 20.04+ / CentOS 8+ / Windows Server
- **Web Server:** Nginx or Apache
- **PHP:** 8.0.2 or higher
- **Database:** MySQL 5.7+ or MariaDB 10.3+
- **Node.js:** 16+ (for asset compilation and Puppeteer)
- **Composer:** 2.x
- **Git:** For deployment

### PHP Extensions

```bash
# Required extensions
php-bcmath
php-ctype
php-fileinfo
php-json
php-mbstring
php-openssl
php-pdo
php-pdo-mysql
php-tokenizer
php-xml
php-gd
php-zip
php-curl
```

---

## Local Development Setup

### Step 1: Clone Repository

```bash
git clone [repository-url] tptv3
cd tptv3
```

### Step 2: Install Dependencies

```bash
# PHP dependencies
composer install

# Node.js dependencies
npm install
```

### Step 3: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure .env

```env
APP_NAME=TPT
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tptv3
DB_USERNAME=root
DB_PASSWORD=

# For Google OAuth
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Step 5: Database Setup

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE tptv3;"

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed
```

### Step 6: Storage Link

```bash
php artisan storage:link
```

### Step 7: Build Assets

```bash
# Development
npm run dev

# Watch mode
npm run watch

# Production
npm run production
```

### Step 8: Start Server

```bash
php artisan serve
```

Access at: `http://localhost:8000`

---

## Production Deployment

### Step 1: Server Preparation

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y nginx mysql-server php8.1-fpm php8.1-mysql \
    php8.1-mbstring php8.1-xml php8.1-bcmath php8.1-curl \
    php8.1-zip php8.1-gd nodejs npm git composer

# Install Puppeteer dependencies (for PDF generation)
sudo apt install -y chromium-browser libnss3 libatk1.0-0 libatk-bridge2.0-0 \
    libcups2 libdrm2 libxkbcommon0 libxcomposite1 libxdamage1 \
    libxfixes3 libxrandr2 libgbm1 libasound2
```

### Step 2: Clone & Setup Application

```bash
# Create web directory
sudo mkdir -p /var/www/tptv3
sudo chown -R $USER:www-data /var/www/tptv3

# Clone repository
cd /var/www
git clone [repository-url] tptv3
cd tptv3

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run production

# Setup environment
cp .env.example .env
php artisan key:generate
```

### Step 3: Configure Production .env

```env
APP_NAME=TPT
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tptv3_production
DB_USERNAME=tptv3_user
DB_PASSWORD=secure_password_here

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"

GOOGLE_CLIENT_ID=your-production-client-id
GOOGLE_CLIENT_SECRET=your-production-client-secret
GOOGLE_REDIRECT_URI=https://your-domain.com/auth/google/callback
```

### Step 4: Database Setup

```bash
# Create MySQL user and database
sudo mysql -u root -p << EOF
CREATE DATABASE tptv3_production;
CREATE USER 'tptv3_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON tptv3_production.* TO 'tptv3_user'@'localhost';
FLUSH PRIVILEGES;
EOF

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed --force
```

### Step 5: Permissions

```bash
# Set proper permissions
sudo chown -R www-data:www-data /var/www/tptv3
sudo chmod -R 755 /var/www/tptv3
sudo chmod -R 775 /var/www/tptv3/storage
sudo chmod -R 775 /var/www/tptv3/bootstrap/cache

# Create storage link
php artisan storage:link
```

### Step 6: Nginx Configuration

Create `/etc/nginx/sites-available/tptv3`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name your-domain.com www.your-domain.com;

    root /var/www/tptv3/public;
    index index.php;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/your-domain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/your-domain.com/privkey.pem;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/json application/xml;

    # Handle requests
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to .htaccess
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|pdf|woff|woff2)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # Upload size limit
    client_max_body_size 10M;
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/tptv3 /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Step 7: SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Auto-renewal is set up automatically
```

### Step 8: Optimize Laravel

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### Step 9: Queue Worker (Optional)

For background job processing, create a systemd service:

Create `/etc/systemd/system/tptv3-worker.service`:

```ini
[Unit]
Description=TPT Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
WorkingDirectory=/var/www/tptv3
ExecStart=/usr/bin/php /var/www/tptv3/artisan queue:work --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
```

Enable and start:

```bash
sudo systemctl enable tptv3-worker
sudo systemctl start tptv3-worker
```

---

## Google OAuth Setup

### Create Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com)
2. Create new project or select existing
3. Enable Google+ API and Google OAuth2 API

### Configure OAuth Consent Screen

1. Go to APIs & Services → OAuth consent screen
2. Select "External" user type
3. Fill in application details:
   - App name: TPT Examination System
   - User support email: your@email.com
   - Authorized domains: your-domain.com
   - Developer contact: your@email.com

### Create OAuth Credentials

1. Go to APIs & Services → Credentials
2. Create Credentials → OAuth client ID
3. Application type: Web application
4. Name: TPT Web Client
5. Authorized redirect URIs:
   - Development: `http://localhost:8000/auth/google/callback`
   - Production: `https://your-domain.com/auth/google/callback`

6. Save Client ID and Client Secret to .env

---

## Puppeteer Setup for PDF Generation

### Server Installation

```bash
# Install Chrome dependencies
sudo apt install -y chromium-browser

# Set environment variable for Puppeteer
echo "PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser" >> /var/www/tptv3/.env
```

### Puppeteer Configuration

In `config/browsershot.php` or directly in code:

```php
Browsershot::html($html)
    ->setOption('args', ['--no-sandbox', '--disable-setuid-sandbox'])
    ->setChromePath('/usr/bin/chromium-browser')
    ->pdf();
```

---

## Backup Strategy

### Database Backup

```bash
# Create backup script
cat > /var/www/tptv3/backup.sh << 'EOF'
#!/bin/bash
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/var/backups/tptv3"
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u tptv3_user -p'password' tptv3_production > $BACKUP_DIR/db_$TIMESTAMP.sql

# Files backup
tar -czf $BACKUP_DIR/storage_$TIMESTAMP.tar.gz /var/www/tptv3/storage/app

# Keep only last 7 days
find $BACKUP_DIR -mtime +7 -delete
EOF

chmod +x /var/www/tptv3/backup.sh
```

### Schedule with Cron

```bash
# Add to crontab
crontab -e

# Daily backup at 2 AM
0 2 * * * /var/www/tptv3/backup.sh
```

### Using Laravel Snapshots

```bash
# Create snapshot
php artisan snapshot:create "before_update_$(date +%Y%m%d)"

# List snapshots
php artisan snapshot:list

# Load snapshot (if needed)
php artisan snapshot:load snapshot_name
```

---

## Update/Deployment Workflow

### Standard Update Process

```bash
cd /var/www/tptv3

# Enable maintenance mode
php artisan down

# Pull latest changes
git pull origin main

# Install dependencies
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Clear and rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Rebuild frontend assets
npm install
npm run production

# Disable maintenance mode
php artisan up
```

### Quick Deployment Script

Create `deploy.sh`:

```bash
#!/bin/bash
set -e

echo "Starting deployment..."

cd /var/www/tptv3

echo "Enabling maintenance mode..."
php artisan down

echo "Pulling latest changes..."
git pull origin main

echo "Installing composer dependencies..."
composer install --optimize-autoloader --no-dev

echo "Running migrations..."
php artisan migrate --force

echo "Clearing caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Building assets..."
npm install
npm run production

echo "Restarting queue worker..."
sudo systemctl restart tptv3-worker

echo "Disabling maintenance mode..."
php artisan up

echo "Deployment complete!"
```

---

## Monitoring & Logs

### Log Locations

```bash
# Laravel logs
/var/www/tptv3/storage/logs/laravel.log

# Nginx logs
/var/log/nginx/access.log
/var/log/nginx/error.log

# PHP-FPM logs
/var/log/php8.1-fpm.log

# Queue worker logs
journalctl -u tptv3-worker
```

### Log Rotation

Laravel automatically rotates logs daily. Configure in `config/logging.php`:

```php
'daily' => [
    'driver' => 'daily',
    'path' => storage_path('logs/laravel.log'),
    'level' => 'debug',
    'days' => 14,
],
```

---

## Troubleshooting

### Common Issues

**1. 500 Error on Production**
```bash
# Check logs
tail -f /var/www/tptv3/storage/logs/laravel.log

# Fix permissions
sudo chown -R www-data:www-data /var/www/tptv3/storage
sudo chmod -R 775 /var/www/tptv3/storage
```

**2. Session Issues**
```bash
# Clear session files
php artisan session:table
php artisan migrate
```

**3. Queue Not Processing**
```bash
# Check worker status
sudo systemctl status tptv3-worker

# Restart worker
sudo systemctl restart tptv3-worker
```

**4. PDF Generation Fails**
```bash
# Check Chrome is installed
which chromium-browser

# Test Puppeteer
cd /var/www/tptv3
node -e "require('puppeteer').launch({args: ['--no-sandbox']}).then(b => { console.log('OK'); b.close(); })"
```

**5. Google OAuth Not Working**
- Verify redirect URI matches exactly
- Check GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in .env
- Clear config cache: `php artisan config:clear`

---

## Security Checklist

- [ ] APP_DEBUG=false in production
- [ ] HTTPS enabled (SSL certificate)
- [ ] Database password is strong
- [ ] .env file not in version control
- [ ] Storage directory not publicly accessible
- [ ] Regular security updates applied
- [ ] Backup strategy in place
- [ ] Firewall configured (ports 80, 443 only)
- [ ] Fail2ban installed for SSH protection

---

*Last Updated: February 2026*
