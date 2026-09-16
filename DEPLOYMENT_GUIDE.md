# 🚀 ParsPack Cloud Hosting Deployment Guide for Laravel E-Commerce

This step-by-step guide walks you through deploying your modern Laravel E-Commerce Web Application on **ParsPack Cloud Hosting** (Standard Linux cPanel / DirectAdmin / Custom Cloud Server).

---

## 📋 Prerequisites on ParsPack Hosting
1. **PHP Version:** PHP 8.2 or 8.3 (Enable via cPanel `Select PHP Version` or DirectAdmin `PHP Selector`).
2. **PHP Extensions:** Ensure `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `curl`, `fileinfo`, `zip`, `bcmath`, `json` are enabled.
3. **Database:** Create a MySQL database and user via ParsPack cPanel / DirectAdmin database management.

---

## 📁 Step 1: Uploading Application Files

You can upload files using **cPanel File Manager**, **FTP (FileZilla)**, or **Git / SSH**.

### Option A: Hosting Root Setup (Recommended Security Structure)
1. Upload the entire application folder to your account root (e.g., `/home/username/varen/`).
2. Copy or symlink the content of the `public/` directory into your domain's public root (`public_html`).
3. Modify `public_html/index.php` paths to point to the parent application folder:
   ```php
   require __DIR__.'/../varen/vendor/autoload.php';
   (require_once __DIR__.'/../varen/bootstrap/app.php')->handleRequest(Request::capture());
   ```

### Option B: Direct `public_html` Deployment with Root `.htaccess`
If you place all files directly inside `public_html/`:
- Ensure the included `.htaccess` file in the root directory is active.
- It safely routes traffic to `public/` and blocks direct browser access to `.env`, `storage/logs`, and system configuration files.

---

## ⚙️ Step 2: Configure Environment Variables (`.env`)

1. Copy `.env.example` to `.env` in your project root:
   ```bash
   cp .env.example .env
   ```
2. Open `.env` and fill in your ParsPack Database & Domain credentials:
   ```env
   APP_NAME="Varen Store"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-parspack-domain.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_parspack_dbname
   DB_USERNAME=your_parspack_dbuser
   DB_PASSWORD=your_parspack_dbpassword

   # Payment Gateway (Zarinpal or Mock)
   PAYMENT_GATEWAY=zarinpal
   ZARINPAL_MERCHANT_ID=XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX
   ZARINPAL_SANDBOX=false
   ```

---

## 🔑 Step 3: Application Key & Database Migration

If you have SSH terminal access on ParsPack:
```bash
# 1. Generate Application Key
php artisan key:generate

# 2. Run Database Migrations & Seeders
php artisan migrate --seed --force

# 3. Create Storage Symlink
php artisan storage:link
```

*Note: The seeder creates an initial administrator account:*
- **Email:** `admin@varen.com`
- **Password:** `AdminSecret123!`

*If SSH access is disabled on your hosting plan:*
1. Run `php artisan migrate:generate` locally or export the MySQL SQL dump.
2. Import the SQL file via **phpMyAdmin** on ParsPack.

---

## 🔒 Step 4: Storage & Directory Permissions

Ensure the server web user has write permissions for `storage` and `bootstrap/cache`:
```bash
chmod -R 775 storage bootstrap/cache
```

---

## ⚡ Step 5: Optimization for Production

Run these Laravel performance optimization commands on ParsPack:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## 💳 Step 6: Payment Gateway Verification

1. Verify that incoming callbacks from ZarinPal reach `https://your-domain.com/checkout/callback/{order}`.
2. If testing in sandbox mode, set `ZARINPAL_SANDBOX=true` in `.env`.

---

## 🛡️ Summary of Architecture Highlights

- **Clean Code & Service Layer:** Controllers are light and decoupled from payment logic or inventory management.
- **No Node.js Server Needed:** Built with CDN-based Tailwind CSS & Alpine.js, perfectly suited for standard Linux shared/cloud hosting without npm compilers.
- **Multi-Level Categories & Attributes:** Supports nested navigation and dynamic key-value product attributes.
- **Transactional Stock Management:** Deducts stock safely using DB transactions to prevent double-selling.
