# Laravel Project Setup Guide

## System Requirements

Make sure your system meets the following requirements:

- **PHP**: Version 8.1 or higher
- **Composer**: Dependency manager for PHP
- **Laravel**: Version 11
- **Web Server**: Apache, Nginx, or Laravel’s built-in server
- **Database**: MySQL
- **Redis**: Optional, for caching

---

## Project Setup Instructions

### Step 1: Clone the Repository

```bash
git clone https://github.com/mohit-gh/streamify.git
cd streamify
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configure Environment

Copy the example environment file and update the settings:

```bash
cp .env.example .env
```

Edit the `.env` file to set up database credentials and other configurations.

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Run Database Migrations

```bash
php artisan migrate
```

### Step 6: Start the Development Server

Start the Laravel server and access your application locally:

```bash
php artisan serve
```

Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## Running Tests

### : Execute Tests

Run unit and feature tests:

```bash
## Unit Test
php artisan test --filter DataStreamServiceTest

## Feature Test
php artisan test --filter DataStreamControllerTest
```

---

## Caching Setup

### Step 1: Configure Cache Driver

Set the caching driver in `.env`:

```env
CACHE_DRIVER=redis
```

### Step 2: Clear Cache

Clear cached data when necessary:

```bash
php artisan cache:clear
```

---

## Troubleshooting Common Issues

- **File Permissions**: Ensure `storage` and `bootstrap/cache` directories are writable:

  ```bash
  chmod -R 775 storage bootstrap/cache
  ```

- **Environment Configuration**: Double-check `.env` for missing or incorrect values.

- **Database Connection Errors**: Verify database credentials and confirm the database server is running.

---

## Additional Useful Commands

- **Run Migrations**:

  ```bash
  php artisan migrate
  ```

- **Clear Configuration Cache**:

  ```bash
  php artisan config:clear
  ```

