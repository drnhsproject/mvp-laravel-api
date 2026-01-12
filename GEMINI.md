# Project Overview

This is a Laravel 12 project. It appears to be a web application with a backend powered by PHP and a frontend built with Vite and Tailwind CSS. The project uses Composer to manage PHP dependencies and NPM for frontend packages.

# Building and Running

## Initial Setup

To get the project running for the first time, run the following command:

```bash
composer run setup
```

This will:
1. Install PHP dependencies with `composer install`.
2. Create a `.env` file from `.env.example`.
3. Generate an application key with `php artisan key:generate`.
4. Run database migrations with `php artisan migrate --force`.
5. Install frontend dependencies with `npm install`.
6. Build frontend assets with `npm run build`.

## Development

To start the development servers for both the backend and frontend, run:

```bash
composer run dev
```

This will start the following processes concurrently:
- `php artisan serve`: The Laravel development server.
- `php artisan queue:listen --tries=1`: The Laravel queue worker.
- `php artisan pail --timeout=0`: The Laravel log tailer.
- `npm run dev`: The Vite development server for frontend assets.

## Testing

To run the test suite, use the following command:

```bash
composer run test
```

This will clear the configuration cache and then run the tests using `php artisan test`.

# Development Conventions

Based on the file structure and configuration files, this project follows standard Laravel development conventions.

- **Backend:**
    - Application logic is located in the `app` directory.
    - Routes are defined in the `routes` directory.
    - Database migrations, factories, and seeders are in the `database` directory.
- **Frontend:**
    - Frontend assets (CSS, JavaScript) are located in the `resources` directory.
    - The `vite.config.js` file is used to configure the Vite asset bundler.
    - Tailwind CSS is used for styling, configured via `tailwind.config.js`.
- **Testing:**
    - Tests are located in the `tests` directory, separated into `Feature` and `Unit` tests.
    - The project uses PHPUnit for testing.
