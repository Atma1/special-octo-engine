# API Backend

This is a Laravel API backend project implementing employee management system with authentication.

### ✅ Prerequisites

- PHP 8.1 and Laravel 9 or higher are required.
- A running MySQL/MariaDB database

## 🚀 Features

- **Authentication**: Login/Logout with token-based authentication
- **Division Management**: Get all divisions with search functionality
- **Employee Management**: CRUD operations for employees
- **API Documentation**: RESTful API documentation using scribe and scala

## 📄 API Documentation
Link to API Documentation
[Click here.](https://special-octo-engine-production.up.railway.app/docs)

## 🔧 Setup Instructions

1. **Install Dependencies:**
   ```bash
   composer install
   ```

2. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup:**
   - Configure your database in `.env` file
   - Run migrations and seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Install Dependencies:**
   ```bash
   composer require laravel/sanctum
   composer require knuckleswtf/scribe
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   ```

5. **Run Server:**
   ```bash
   php artisan serve
   ```

## Technologies Used

- Laravel 11
- MySQL/MariaDB
- Laravel Sanctum
- Eloquent ORM
- Request Validation
