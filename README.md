# Laravel User Management CRUD Exercise
<p align="center"> <a href="https://laravel.com" target="_blank"> <img src="https://laravel.com/img/logomark.min.svg" width="100" alt="Laravel Logo"> </a> </p>
 Objective



## Objective

This project fulfills a technical task requiring the implementation of a basic user management system using Laravel 11+. The primary goal was to demonstrate backend development skills by building a full CRUD (Create, Read, Update, Delete) application for users, adhering to TDD and basic DDD principles.

## Features Implemented

*   ✅ **Complete CRUD Functionality:** Allows creating, viewing (list & details), updating, and deleting users.
*   ✅ **Image Upload for Profile Pictures:** Users can upload JPG, PNG, or GIF images (max 2MB) as their profile picture during creation or update. Images are stored using Laravel's public disk and displayed appropriately. Old images are deleted on update/user deletion.
*   ✅ **Predefined Country List & Validation:** Country selection uses a dropdown list populated from `config/countries.php`. Backend validation ensures only valid country codes are accepted.
*   **Required User Fields:** Handles Name, Surname, Email, Phone, Country, Gender, Password (with confirmation).
*   **Server-Side Validation:** Robust validation using dedicated Form Request classes (`StoreUserRequest`, `UpdateUserRequest`).
*   **Testing:** Developed following Test-Driven Development (TDD) using PHPUnit. Includes feature tests covering all CRUD operations, image upload, and country validation (9 tests, 45 assertions passing).

## Tech Stack

*   PHP 8.1+
*   Laravel 11.x
*   Database (Tested with SQLite `:memory:` for tests, requires MySQL/MariaDB/Postgres etc. for development/production via `.env`)
*   Composer
*   PHPUnit

## Setup and Installation

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/lucasvalenca1/tech-task1.git
    cd tech-task1
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    ```

3.  **Environment Configuration:**
    *   Copy the example environment file: `cp .env.example .env` (or `copy` on Windows CMD)
    *   Generate the application key: `php artisan key:generate`
    *   Edit the `.env` file: Configure `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`. Ensure the database exists. Set `APP_URL`.

4.  **Database Migration:**
    ```bash
    php artisan migrate
    ```

5.  **Storage Link:**
    ```bash
    php artisan storage:link
    ```
    *(Run terminal as Administrator if permissions issues occur)*

6.  **Serve the Application:**
    ```bash
    php artisan serve
    ```
    Access at `http://localhost:8000` (or your configured URL).

## Running Tests

Execute the full test suite:

```bash
php artisan test



