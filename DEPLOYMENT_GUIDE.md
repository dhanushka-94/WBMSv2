# 🚀 DN WASSIP Production Deployment Guide

## 🌐 Server Information
- **Domain:** https://erp.dunwassip.com
- **System:** Dunsinane Estate Water Supply and Management System
- **Repository:** https://github.com/dhanushka-94/WBMSv2.git

---

## 📋 Step 1: Server Requirements

### Minimum Requirements
- **PHP:** 8.1 or higher
- **Database:** MySQL 5.7+ or MariaDB 10.3+
- **Memory:** 512MB RAM minimum
- **Storage:** 2GB disk space
- **SSL Certificate:** Required for HTTPS

### Required PHP Extensions
```
php-mysql
php-mbstring
php-xml
php-curl
php-zip
php-gd
php-json
php-bcmath
php-tokenizer
php-fileinfo
php-openssl
```

---

## ⚠️ **CRITICAL: Composer Dependencies**

**Laravel applications require the `vendor/` folder with all PHP dependencies. Since most shared hosting providers don't have Composer installed, you MUST upload the vendor folder.**

### Option A: Download Pre-built Package (Recommended)
1. **Contact developer** for a complete package with vendor folder included
2. **Or download from GitHub releases** if available

### Option B: Build Locally (If you have PHP + Composer)
1. **Download the project** locally
2. **Run:** `composer install --no-dev --optimize-autoloader`
3. **Upload the entire project** including the generated `vendor/` folder

### Option C: Web-based Composer (Advanced)
Some hosting providers offer Composer in control panel. Check if yours does.

**⚠️ WARNING:** Without the vendor folder, you'll get "HTTP ERROR 500" and missing autoload.php errors.

---

## 📁 Step 2: File Upload Process

### Method 1: Direct Download from GitHub (Recommended)
1. **Access your hosting control panel**
2. **Navigate to File Manager**
3. **Go to your domain's public folder** (usually `public_html` or `www`)
4. **Download repository as ZIP:**
   ```
   https://github.com/dhanushka-94/WBMSv2/archive/refs/heads/master.zip
   ```
5. **Extract the ZIP file**
6. **Move all contents from `WBMSv2-master/` to your domain root**

### Method 2: FTP Upload
1. **Download repository ZIP** from GitHub
2. **Extract locally**
3. **Upload all files** via FTP to your domain folder
4. **Ensure proper file permissions**

---

## 🔧 Step 3: Environment Configuration

### Create .env file
Create a new file named `.env` in your root directory with this content:

```env
APP_NAME="Dunsinane Estate Water Supply and Management System"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=Asia/Colombo
APP_URL=https://erp.dunwassip.com

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# DATABASE CONFIGURATION - UPDATE THESE VALUES
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.dunwassip.com

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# EMAIL CONFIGURATION - UPDATE THESE VALUES
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@dunwassip.com"
MAIL_FROM_NAME="DN WASSIP System"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

---

## 🗄️ Step 4: Database Setup

### 4.1 Create Database
1. **Access your hosting control panel**
2. **Go to MySQL Databases or Database Manager**
3. **Create a new database** (e.g., `dunwassip_db`)
4. **Create a database user** with full privileges
5. **Update .env file** with database credentials

### 4.2 Database Structure
The system will automatically create tables when you run the setup.

---

## 🔐 Step 5: Security Setup

### 5.1 Generate Application Key
Since you don't have terminal access, use this online tool:
1. **Visit:** https://laravel-key-generator.com/
2. **Generate a new key**
3. **Copy the key** (starts with `base64:`)
4. **Update .env file:** `APP_KEY=base64:your_generated_key`

### 5.2 File Permissions
Set these permissions via your hosting file manager:
```
storage/ folder: 755 or 777
bootstrap/cache/ folder: 755 or 777
public/ folder: 755
All PHP files: 644
```

---

## 🌐 Step 6: Web Server Configuration

### 6.1 Document Root
**IMPORTANT:** Point your domain to the `public` folder, not the root folder.

**If you can't change document root:**
1. **Move all contents** from `public/` to your domain root
2. **Edit `index.php`** in domain root:
   ```php
   require __DIR__.'/vendor/autoload.php';
   $app = require_once __DIR__.'/bootstrap/app.php';
   ```

### 6.2 .htaccess File
Ensure `.htaccess` exists in your domain root:
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## 🚀 Step 7: Initial Setup

### 7.1 First Visit
1. **Visit:** https://erp.dunwassip.com
2. **If you see errors,** check the error logs in your hosting control panel

### 7.2 Database Migration
**Option A: Web-based Setup**
Create a setup file `setup.php` in your domain root:

```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

// Run migrations
echo "<h2>Running Database Migrations...</h2>";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->call('migrate', ['--force' => true]);
echo "<p>✅ Migrations completed!</p>";

// Seed database
echo "<h2>Seeding Database...</h2>";
$kernel->call('db:seed', ['--force' => true]);
echo "<p>✅ Database seeded!</p>";

echo "<h2>✅ Setup Complete!</h2>";
echo "<p><a href='/'>Visit Your Application</a></p>";
echo "<p><strong>IMPORTANT:</strong> Delete this setup.php file for security!</p>";
```

**Visit:** https://erp.dunwassip.com/setup.php
**Then DELETE the setup.php file**

---

## 👤 Step 8: Admin Account

### Default Admin Credentials
```
Email: admin@dunsinane.lk
Password: password123
```

**IMPORTANT:** Change the password immediately after first login!

---

## ✅ Step 9: Verification Checklist

### Test These Features:
- [ ] ✅ Homepage loads correctly
- [ ] ✅ Login with admin credentials
- [ ] ✅ Dashboard displays properly
- [ ] ✅ Customer management works
- [ ] ✅ Water meter management works
- [ ] ✅ Billing system functions
- [ ] ✅ Reports generate correctly
- [ ] ✅ API endpoints respond (test with Postman)
- [ ] ✅ Logo displays correctly
- [ ] ✅ Browser title shows full system name

### API Testing URLs:
```
Health Check: https://erp.dunwassip.com/api/v1/health
App Info: https://erp.dunwassip.com/api/v1/app-info
Login: https://erp.dunwassip.com/api/v1/login
```

---

## 🔧 Step 10: Post-Deployment Configuration

### 10.1 Email Configuration
1. **Update MAIL_* settings** in .env
2. **Test email** functionality in system settings

### 10.2 Backup Setup
1. **Schedule regular database backups**
2. **Backup uploaded files** in storage/app/public
3. **Keep .env file secure**

### 10.3 SSL Certificate
1. **Ensure SSL is active** for https://erp.dunwassip.com
2. **Force HTTPS redirects** if not automatic

---

## 🚨 Troubleshooting

### Common Issues:

**1. 500 Internal Server Error**
- Check file permissions (storage/ and bootstrap/cache/ should be 755/777)
- Verify .env file exists and has correct syntax
- Check error logs in hosting control panel

**2. Database Connection Error**
- Verify database credentials in .env
- Ensure database exists
- Check if database user has proper privileges

**3. Blank Page**
- Enable error display temporarily: `APP_DEBUG=true`
- Check PHP error logs
- Verify all PHP extensions are installed

**4. CSS/JS Not Loading**
- Check if assets exist in public/ folder
- Verify .htaccess file is present
- Clear browser cache

**5. Permission Denied**
- Set storage/ folder to 777 permissions
- Set bootstrap/cache/ folder to 777 permissions

---

## 📞 Support Information

**System Developed By:**
**Olexto Digital Solutions (Pvt) Ltd**

For technical support or deployment assistance:
- **Email:** info@olexto.com
- **Website:** https://www.olexto.com

---

## 🎯 Success Metrics

Once deployed successfully, you should have:
- ✅ Professional water billing management system
- ✅ Complete customer and meter management
- ✅ Automated billing and reports
- ✅ Mobile API backend (22 endpoints)
- ✅ Secure admin panel
- ✅ Custom WASSIP branding
- ✅ Production-ready configuration

**Final URL:** https://erp.dunwassip.com
**Admin Login:** admin@dunsinane.lk / password123

Remember to change the default password after first login! 