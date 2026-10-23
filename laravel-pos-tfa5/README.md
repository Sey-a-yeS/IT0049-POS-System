# Counterpoint POS — Laravel TFA5

This standalone Laravel application recreates the four pages from IT0049 TFA1 for Technical Formative Assessment 5. It demonstrates routes, controllers, shared Blade layouts, and static PHP arrays as temporary account data. The records are fictional. There is no login, CRUD, sales workflow, or database dependency for the four pages.

## Requirements

- PHP 8.2 or newer with Laravel's required extensions
- Composer 2
- A free local port (the instructions below use 8083)

## Local setup

```bash
cd laravel-pos-tfa5
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8083
```

Open `http://127.0.0.1:8083/`. If using this address instead of `localhost`, set `APP_URL=http://127.0.0.1:8083` in `.env` for consistent generated URLs. The project CSS is served directly from `public/css/app.css`; Node, npm, and Vite are not required.

`.env.example` uses `SESSION_DRIVER=file`, `CACHE_STORE=file`, and `QUEUE_CONNECTION=sync`. No MySQL installation, migration run, or seed is needed for these pages. Keep `.env` private.

## Routes and MVC structure

| Route | Name | Controller action | View |
| --- | --- | --- | --- |
| `/` | `home` | `PageController@index` | `pages.home` |
| `/about` | `about` | `PageController@about` | `pages.about` |
| `/customers` | `customers.index` | `CustomerController@index` | `customers.index` |
| `/users` | `users.index` | `UserController@index` | `users.index` |

Routes live in `routes/web.php`. `PageController` chooses the two informational views. `CustomerController` and `UserController` each declare five local PHP records inside `index()` and pass them to their respective Blade views. Both directories use `@foreach` and escaped `{{ ... }}` output. The shared layout at `resources/views/layouts/app.blade.php` uses `route()` for every navigation link.

The standard Laravel `app/Models`, `database/migrations`, and `database/seeders` structure remains in the starter. Its default migrations are framework scaffolding only; they are not used by these four pages. An application database export would misrepresent this assessment, so none is included.

## Verification

```bash
php artisan --version
php artisan route:list
php artisan test
```

The focused feature tests check all four pages, navigation links, controller data, and rendering with an invalid database configuration. The repository also contains a TFA5 implementation report and documentation screenshot checklist.

## Hosting

Use a PHP hosting service that supports this Laravel version and Composer. Deploy this directory as its own application and set the web document root to `laravel-pos-tfa5/public`, not the repository root. On the host:

1. Run `composer install --no-dev --optimize-autoloader` in the application directory.
2. Create a private `.env` based on `.env.example` with `APP_ENV=production`, `APP_DEBUG=false`, the real HTTPS `APP_URL`, and a generated `APP_KEY` (`php artisan key:generate`).
3. Keep `SESSION_DRIVER=file`, `CACHE_STORE=file`, and `QUEUE_CONNECTION=sync`. Give the PHP process write access to `storage/` and `bootstrap/cache/`.
4. Configure HTTPS, Laravel's rewrite rules, and the `public/` document root. Then run `php artisan optimize` and verify all four routes and the CSS asset on the real URL.
5. Enter the actual hosted URL in the assessment submission only after it has been opened and tested.

The four pages do not need MySQL or persistent user data. This repository does not claim that a hosted version is live.

## Security and troubleshooting

- The displayed names, emails, phone numbers, and usernames are fictional examples.
- Do not commit `.env`, credentials, `vendor/`, logs, sessions, or caches.
- If pages return 404, set the document root to `public/` and enable rewrite rules.
- If the app cannot write caches or compiled views, grant the web user write access to `storage/` and `bootstrap/cache/`.
- If generated links use the wrong host or port, correct `APP_URL` in `.env` and run `php artisan config:clear`.
- If Composer cannot access its registry, retry with working network access; do not substitute a fake framework install.
