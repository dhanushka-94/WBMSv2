# 🚨 URGENT FIX: HTTP ERROR 500 - Missing vendor/autoload.php

## 🎯 Problem
You're getting this error on https://erp.dunwassip.com:
```
PHP Warning: require(/home/www/erp.dunwassip.com/public/../vendor/autoload.php): Failed to open stream: No such file or directory
```

## ⚡ Root Cause
The `vendor/` folder is missing from your server. Laravel applications require this folder with all PHP dependencies.

---

## 🔧 IMMEDIATE SOLUTIONS

### Option 1: Upload Complete Package (RECOMMENDED)

**Download the complete package:**
- **File:** `DN-WASSIP-COMPLETE.tar.gz` (45MB) - **THIS INCLUDES THE VENDOR FOLDER**
- **Location:** Your local project directory

**Steps:**
1. **Delete everything** from your server's domain folder
2. **Upload and extract** `DN-WASSIP-COMPLETE.tar.gz`
3. **Set file permissions:**
   - `storage/` folder: 755 or 777
   - `bootstrap/cache/` folder: 755 or 777
4. **Create .env file** (see below)
5. **Visit:** https://erp.dunwassip.com

### Option 2: Upload Only Vendor Folder (QUICK FIX)

**If you want to keep your current files:**
1. **Locate the `vendor/` folder** in your local project
2. **Upload the entire `vendor/` folder** to your server's domain root
3. **Ensure the path is:** `/home/www/erp.dunwassip.com/vendor/`
4. **Check that autoload.php exists:** `/home/www/erp.dunwassip.com/vendor/autoload.php`

---

## 📄 Essential .env File

Create a file named `.env` in your domain root with this content:

```env
APP_NAME="Dunsinane Estate Water Supply and Management System"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=Asia/Colombo
APP_URL=https://erp.dunwassip.com

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

# UPDATE THESE DATABASE VALUES
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

# EMAIL CONFIGURATION
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@dunwassip.com"
MAIL_FROM_NAME="DN WASSIP System"

VITE_APP_NAME="${APP_NAME}"
```

---

## 🔑 Generate Application Key

**Visit this tool:** https://laravel-key-generator.com/
1. **Click "Generate Key"**
2. **Copy the key** (starts with `base64:`)
3. **Replace** `YOUR_GENERATED_KEY_HERE` in .env file

---

## 🗄️ Database Setup

### 1. Create Database
- **Access your hosting control panel**
- **Create MySQL database** (e.g., `dunwassip_db`)
- **Create database user** with full privileges
- **Update .env file** with database credentials

### 2. Run Database Setup
**Upload this file as `setup.php` to your domain root:**

```php
<?php
// Temporary setup script - DELETE after use!
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

echo "<h1>🚀 DN WASSIP Database Setup</h1>";

try {
    echo "<h2>Running Database Migrations...</h2>";
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->call('migrate', ['--force' => true]);
    echo "<p>✅ Migrations completed!</p>";

    echo "<h2>Seeding Database...</h2>";
    $kernel->call('db:seed', ['--force' => true]);
    echo "<p>✅ Database seeded!</p>";

    echo "<h2>✅ Setup Complete!</h2>";
    echo "<p><a href='/'>🎯 Visit Your Application</a></p>";
    echo "<hr>";
    echo "<h3>🔐 Default Admin Login:</h3>";
    echo "<p><strong>Email:</strong> admin@dunsinane.lk</p>";
    echo "<p><strong>Password:</strong> password123</p>";
    echo "<hr>";
    echo "<p><strong>⚠️ IMPORTANT:</strong> Delete this setup.php file for security!</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database credentials in .env file</p>";
}
?>
```

**Visit:** https://erp.dunwassip.com/setup.php
**Then DELETE the setup.php file**

---

## ✅ Verification Steps

1. **Visit:** https://erp.dunwassip.com
2. **Should see:** Login page with WASSIP logo
3. **Login with:**
   - Email: admin@dunsinane.lk
   - Password: password123
4. **Test API:** https://erp.dunwassip.com/api/v1/health

---

## 🚨 If Still Getting Errors

### Check These:

1. **File Permissions:**
   ```
   storage/ folder: 755 or 777
   bootstrap/cache/ folder: 755 or 777
   ```

2. **Verify autoload.php exists:**
   ```
   /home/www/erp.dunwassip.com/vendor/autoload.php
   ```

3. **Check .env file:**
   - File exists in domain root
   - Database credentials are correct
   - APP_KEY is set

4. **Enable debugging temporarily:**
   ```
   APP_DEBUG=true
   ```
   (Remember to set back to false after fixing)

---

## 📞 Emergency Contact

**Developer:** Olexto Digital Solutions (Pvt) Ltd
**Support:** The vendor folder and complete package are ready in your local project directory.

**Files Ready for Upload:**
- ✅ `DN-WASSIP-COMPLETE.tar.gz` (45MB) - Complete package with vendor
- ✅ `vendor/` folder - Just the dependencies
- ✅ Updated deployment guide

---

## 🎯 Expected Result

After fixing:
- ✅ https://erp.dunwassip.com loads properly
- ✅ Professional water billing system
- ✅ Admin login works
- ✅ 22 API endpoints functional
- ✅ WASSIP branding displayed
- ✅ Mobile app backend ready 