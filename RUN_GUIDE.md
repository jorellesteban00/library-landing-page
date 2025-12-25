# 🚀 Library CMS - Run Guide

A quick reference guide to get the Library CMS up and running.

---

## ⚡ Quick Start (One Command)

If you're setting up for the first time, run:

```bash
composer run setup
php artisan storage:link
```

Then start the development server:

```bash
composer run dev
```

Visit: **http://127.0.0.1:8000**

---

## 📋 Prerequisites

Make sure you have the following installed:

| Requirement   | Version   | Check Command          |
|---------------|-----------|------------------------|
| PHP           | >= 8.2    | `php -v`               |
| Composer      | Latest    | `composer -V`          |
| Node.js       | >= 18.x   | `node -v`              |
| NPM           | Latest    | `npm -v`               |
| MySQL/MariaDB | 8.0+ / 10.4+ | `mysql --version`   |

---

## 🛠️ Manual Setup Steps

### 1. Install Dependencies

```bash
# PHP dependencies
composer install

# JavaScript dependencies
npm install
```

### 2. Environment Configuration

```bash
# Create .env file from example
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup

**Option A: SQLite (Default - Simplest)**

The default `.env.example` uses SQLite. Just create the database file:

```bash
touch database/database.sqlite
```

**Option B: MySQL (Recommended for Production)**

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_cms
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database in MySQL:

```sql
CREATE DATABASE library_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Run Migrations & Seed Data

```bash
# Run database migrations
php artisan migrate

# Seed with sample data (includes admin user)
php artisan db:seed

# Create storage symlink (IMPORTANT for file uploads)
php artisan storage:link
```

### 5. Build Frontend Assets

```bash
# For development (with hot reload)
npm run dev

# For production
npm run build
```

---

## 🏃 Running the Application

### Development Mode (Recommended)

This runs all services concurrently (server, queue, logs, vite):

```bash
composer run dev
```

### Individual Services

Run each service separately if needed:

```bash
# Laravel development server
php artisan serve

# Vite dev server (in separate terminal)
npm run dev

# Queue worker (in separate terminal)
php artisan queue:listen

# Log viewer (in separate terminal)
php artisan pail
```

---

## 🔑 Default Login Credentials

| Role     | Email               | Password  |
|----------|---------------------|-----------|
| Admin    | admin@library.com   | admin123  |

⚠️ **Change the default password after first login!**

---

## 🧪 Running Tests

```bash
# Run all tests
php artisan test

# Or using composer script
composer run test
```

---

## 🧹 Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Refresh database (WARNING: destroys all data)
php artisan migrate:fresh --seed

# Check routes
php artisan route:list

# Code formatting
./vendor/bin/pint
```

---

## 📁 Project Structure

```
library-landing-page/
├── app/                    # Application code
│   ├── Http/Controllers/   # Controllers
│   ├── Models/             # Eloquent models
│   └── Policies/           # Authorization policies
├── config/                 # Configuration files
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── public/                 # Public assets (entry point)
├── resources/
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript
│   └── views/              # Blade templates
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
├── storage/                # File storage
└── tests/                  # Test files
```

---

## 🔧 Troubleshooting

### "Vite manifest not found" error
```bash
npm run build
```

### "Storage symlink not found"
```bash
php artisan storage:link
```

### "Permission denied" on storage (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

### Database connection issues
1. Verify database credentials in `.env`
2. Ensure MySQL/MariaDB service is running
3. Try: `php artisan config:clear`

### "Class not found" errors
```bash
composer dump-autoload
```

---

## 🌐 URLs

| URL                        | Description            |
|----------------------------|------------------------|
| http://127.0.0.1:8000      | Homepage               |
| http://127.0.0.1:8000/login | Staff Login           |
| http://127.0.0.1:8000/staff | Staff Dashboard       |
| http://127.0.0.1:8000/api   | API Base URL          |

---

## 📚 Additional Resources

- Full documentation: See `README.md`
- API documentation: See `README.md#web-api-implementation`
- Laravel Docs: https://laravel.com/docs

---

Happy coding! 🎉
