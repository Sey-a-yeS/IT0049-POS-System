# Counterpoint POS — Laravel TFA5 to TFA6

Counterpoint began as the four-page, static-array Laravel exercise for IT0049 Technical Formative Assessment 5. TFA6, **From Arrays to Eloquent**, keeps those routes and the original visual design while moving the Customer Accounts and User Accounts data into a dedicated database. It uses Laravel migrations, an idempotent sample seeder, Eloquent models, controllers, and Blade `@foreach` views. The records are fictional. There is no authentication, account CRUD, or sales functionality.

The original TFA5 implementation remains in Git history at commit `411b0aa`.

## Requirements

- PHP 8.2 or newer and the extensions required by Laravel, including `pdo_mysql` for the documented MySQL setup; `pdo_sqlite` is used by the isolated tests.
- Composer 2 and a local MySQL/MariaDB server.
- Port 8083 free for the Artisan development server.

## Local setup

From this application directory:

```bash
composer install
cp .env.example .env
```

Create a **new dedicated** database named `counterpoint_tfa6_db` on your own MySQL server. Do not use another assessment's database. Set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` privately in `.env`. The tracked `.env.example` contains a local example and no secret. Then run:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan migrate:status
php artisan route:list
php artisan test
php artisan serve --host=127.0.0.1 --port=8083
```

Open `http://127.0.0.1:8083/`. Set `APP_URL` in `.env` to the actual local URL if you use a different host or port. CSS is served directly from `public/css/app.css`; Node, npm, and Vite are not needed for these pages. The seeder uses `updateOrCreate`, so running `php artisan db:seed` again updates only the five identified sample records instead of duplicating them. It does not truncate tables or remove unrelated rows.

Do not use `migrate:fresh` on a database you need to keep. For a new installation, `migrate` creates the schema without touching other databases.

## Routes and MVC data flow

| URL | Route name | Controller action | View |
| --- | --- | --- | --- |
| `/` | `home` | `PageController@index` | `pages.home` |
| `/about` | `about` | `PageController@about` | `pages.about` |
| `/customers` | `customers.index` | `CustomerController@index` | `customers.index` |
| `/users` | `users.index` | `UserController@index` | `users.index` |

`routes/web.php` defines all four controller routes. `CustomerController` queries `App\Models\Customer`; `UserController` queries `App\Models\User`. Both order records by ID and pass Eloquent collections to their views. The views use escaped Blade output and `@foreach`; when a table is empty they display a readable message. Navigation uses named `route()` links in the shared layout. Home and About do not query the database, but the two account pages do.

## Database schema and sample data

The TFA2 schema was checked against the historical `database/pos_db.sql` in commit `28702a5`. The TFA6 customers table has `id`, `full_name` (100, required), `email` (100, required), `phone` (20, nullable), and required `created_at`. The users table has `id`, `username` (50, required and unique), `full_name` (100, required), and required `created_at`. The existing Laravel users migration retains nullable `email`, `email_verified_at`, `password`, and `remember_token` fields for framework compatibility; no password is seeded or authentication route added. The original TFA2 schema has no role or status columns, so the TFA6 staff table shows the three fields it can actually retrieve: ID, username, and full name.

Schema files: `database/migrations/0001_01_01_000000_create_users_table.php` and `database/migrations/2026_10_31_000001_create_customers_table.php`. `database/seeders/CounterpointSampleSeeder.php` supplies five fictional customers and five fictional users, preserving the TFA5 names. `database/seeders/DatabaseSeeder.php` invokes it. The application uses migrations and a seeder rather than a SQL export.

## Tests

`php artisan test` uses SQLite `:memory:` through `phpunit.xml`, not the local MySQL database. The feature tests cover migrations, username uniqueness, repeatable seeding, Eloquent-backed rendering, escaped output, empty states, all routes, navigation, and the database-independent Home and About pages. No test truncates the working MySQL database.

## Independent hosting

The official submission requires both raw project files on GitHub and a live hosted link. This repository does not claim the site is deployed. Use a PHP-capable host with a **persistent MySQL/MariaDB database** (or a deliberately adapted persistent SQLite volume) and set the web document root to this application's `public/` directory. A host with an ephemeral filesystem must not keep its only database in a local SQLite file.

1. Deploy this Laravel directory independently; do not reuse the GROOVE service or database.
2. Run `composer install --no-dev --optimize-autoloader` with the required PHP extensions.
3. Provide a private production `.env` or platform environment variables: `APP_NAME`, `APP_ENV=production`, `APP_DEBUG=false`, a generated `APP_KEY`, the real HTTPS `APP_URL`, `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `SESSION_DRIVER=file`, `CACHE_STORE=file`, and `QUEUE_CONNECTION=sync`.
4. Ensure the web process can write `storage/` and `bootstrap/cache/`. Keep `.env`, logs, sessions, caches, and database credentials out of Git.
5. Run `php artisan migrate --force` and then `php artisan db:seed --force` against the verified dedicated production database. Run `php artisan optimize` after environment configuration.
6. Configure HTTPS and Laravel rewrite rules, then test all four routes and `public/css/app.css` on the real domain. Submit the hosted URL only after these checks pass.

The deployment procedure is preparation, not evidence of a live site. Hosting and GitHub publication remain user-controlled.
