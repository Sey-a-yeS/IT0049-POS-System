# IT0049 Midterm Point-of-Sale System

This repository contains **The Complete Point-of-Sale System**, developed for the IT0049 — Web System Technologies Midterm Project. It extends the original TFA1–TFA4 CodeIgniter application into one database-backed management console for products, customers, staff, authentication, stock-controlled sales, and sales history.

## Features

- Authenticated operations dashboard using real database totals and recent sales
- Product create, list, edit, archive, stock tracking, and prepared product images
- Customer create, list, edit, validation, and safe archive
- Staff create, list, edit, archive, password hashing, and prepared avatars
- Session authentication with protected GET and POST management routes
- Single-product sales with optional customers and authenticated staff attribution
- Authoritative server-side totals using the product price stored in MySQL
- Transactional, concurrency-safe inventory deduction that prevents overselling
- Joined sales history with product, customer, staff, quantity, total, and timestamp
- CSRF-protected forms, escaped output, responsive layouts, and local placeholders

Archiving is used instead of physical deletion so product, customer, and staff names remain available to historical sales. The minimal `is_archived` columns are intentional extensions to the professor's four-table schema.

## Technology stack

- CodeIgniter 4 (tested locally with 4.7.4)
- PHP 8.2 or newer (tested locally with PHP 8.5.10)
- MySQL or MariaDB using the MySQLi driver
- Server-rendered HTML, project CSS, and small progressive-enhancement JavaScript
- CodeIgniter Image with the PHP GD extension

## Requirements

- PHP 8.2+
- Composer 2
- MySQL 8+ or a compatible MariaDB release
- PHP extensions required by CodeIgniter, including `intl`, `mbstring`, `mysqli`, and `gd`
- A web server whose document root can point to `public/`
- Write permission for `writable/`, `public/uploads/avatars/`, and `public/uploads/products/`

## Local installation

1. Enter the application directory and install dependencies:

   ```bash
   cd pos-system
   composer install
   ```

2. Create the untracked environment file:

   ```bash
   cp env .env
   ```

3. Configure your own local values in `.env`:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   app.indexPage = ''

   database.default.hostname = 127.0.0.1
   database.default.database = pos_db
   database.default.username = your_mysql_user
   database.default.password = your_mysql_password
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

   `.env` is ignored by Git. Do not put database credentials, plaintext passwords, or production secrets in tracked files.

4. Reproduce the database from the tracked SQL setup:

   ```bash
   mysql --host=127.0.0.1 --port=3306 -u your_mysql_user -p < database/pos_db.sql
   ```

   The import creates `products`, `customers`, `users`, and `sales`, their three sales foreign keys, five sample products, five sample customers, and five sample staff records. Sample staff passwords initially contain an unusable locked marker—not a shared demo password or a real credential.

   When upgrading an existing TFA database instead, preserve it and run:

   ```bash
   php spark migrate
   ```

5. Initialize credentials privately in an interactive terminal:

   ```bash
   php spark auth:set-password --all
   ```

   Or initialize one staff account:

   ```bash
   php spark auth:set-password username_here
   ```

   The command requires at least 12 characters, hides input, confirms it, and stores only a `password_hash()` result. No working password is included in this repository.

6. Ensure runtime and upload directories are writable by the PHP process:

   ```bash
   chmod 755 writable public/uploads/avatars public/uploads/products
   ```

7. Start the development server:

   ```bash
   php spark serve
   ```

8. Open [http://localhost:8080/login](http://localhost:8080/login) and sign in with a staff credential you initialized.

## Main routes

| Method | Route | Access | Purpose |
| --- | --- | --- | --- |
| GET | `/login` | Public | Login form |
| POST | `/login` | Public + CSRF | Authenticate staff |
| GET | `/about` | Public | Project and developer information |
| POST | `/logout` | Authenticated + CSRF | Destroy the login session |
| GET | `/` | Authenticated | Operations dashboard |
| GET/POST | `/products...` | Authenticated + CSRF on POST | Product management and archive |
| GET/POST | `/customers...` | Authenticated + CSRF on POST | Customer management and archive |
| GET/POST | `/users...` | Authenticated + CSRF on POST | Staff management and archive |
| GET | `/sales/new` | Authenticated | Record Sale form |
| POST | `/sales` | Authenticated + CSRF | Atomically record a sale |
| GET | `/sales` | Authenticated | Joined sales history |

Run `php spark routes` for the complete route table. Automatic routing is disabled.

## Management workflows

### Products

Product forms validate a required 100-character name, nonnegative two-decimal price, and nonnegative integer stock. Optional JPG/PNG images are checked for upload size, extension, MIME type, and genuine image content, assigned random filenames, and prepared to 720 × 540 pixels. Only the filename is stored. Archived products are hidden from the catalog and cannot be sold, but remain linked to old sales.

### Customers

Customer forms validate required names and email format and preserve non-sensitive input after validation failures. Archived customers no longer appear in new-sale choices, while historical transactions retain their customer reference. A sale may also be recorded as walk-in with no customer.

### Staff

Staff creation requires a unique username, full name, and confirmed password of at least 12 characters. Passwords are hashed before storage. On edit, a blank password keeps the existing hash. Optional JPG/PNG avatars use genuine-image validation, random filenames, and a 256 × 256 prepared image. The current authenticated account cannot archive itself.

### Record Sale and inventory safety

The browser preview is informational only. `SaleService` reloads the active product, uses the database price, calculates the total in decimal cents, and gets `sold_by` from the authenticated session. Within one database transaction it performs a conditional stock decrement (`stock_quantity >= requested quantity`) and inserts exactly one sale. Any invalid relation, insufficient stock, or database failure rolls back the operation. Redirect-after-success prevents refresh-based duplicate submission.

### Sales History

`SaleModel` retrieves sales with joined product, customer, and staff names in one query and sorts newest first. Walk-in sales receive a clear label. Archived related records remain visible because rows are deactivated rather than deleted.

## MVC structure

```text
app/
├── Commands/SetUserPassword.php
├── Controllers/{Auth,Pages,Products,Customers,Users,Sales}.php
├── Filters/AuthFilter.php
├── Models/{Product,Customer,User,Sale}Model.php
├── Services/SaleService.php
├── Database/Migrations/
└── Views/{auth,products,customers,users,sales,templates}/
database/pos_db.sql
public/
├── assets/{css,images,js}/
└── uploads/{avatars,products}/
```

Controllers handle requests and validation, Models own database queries, `SaleService` owns transactional stock logic, `AuthFilter` enforces access, and Views contain presentation only—no raw SQL.

## Upload storage

- Product files: `public/uploads/products/`
- Staff avatars: `public/uploads/avatars/`
- Generated uploads are ignored by Git; `.gitkeep` preserves required directories.
- Missing files use tracked local placeholders.
- A real host must provide persistent storage for both upload directories across deployments.

## Security considerations

- All management GET and POST routes require an active staff session.
- Global CSRF filtering protects state-changing forms.
- Login uses `password_verify()` and regenerates the session ID.
- Logout is POST-only and destroys the session.
- Archived/deleted-session staff are rejected by `AuthFilter`.
- Views escape database and request output.
- Password fields are never repopulated, and hashes are never displayed.
- Uploaded files are restricted to validated images and generated filenames.
- Sales ignore browser-supplied totals or staff IDs.
- `.env`, generated uploads, cache files, and secrets must stay out of Git.

## Production deployment

Local verification is not proof of a live deployment. For a PHP/MySQL host:

1. Point the site document root to this repository's `public/` directory.
2. Install production Composer dependencies with `composer install --no-dev --optimize-autoloader`.
3. Provide a private production `.env` with `CI_ENVIRONMENT = production`, the real HTTPS `app.baseURL`, and host database credentials.
4. Enable `app.forceGlobalSecureRequests = true` and secure cookies (`cookie.secure = true`, `cookie.httponly = true`, `cookie.samesite = Lax`) after HTTPS is active.
5. Import `database/pos_db.sql` into a new database or back up an existing database before running `php spark migrate`.
6. Initialize passwords privately with `php spark auth:set-password`; do not publish credentials.
7. Grant the web process write permission to `writable/` and both upload directories.
8. Confirm the host retains uploaded files between releases and includes them in backups.
9. Verify URL rewriting from the included `public/.htaccess`, HTTPS, sessions, CSRF, database connectivity, uploads, logs, and error pages on the actual host.
10. Keep development error pages and the debug toolbar disabled in production.

## Troubleshooting

- **Database connection error:** confirm MySQL is running and the `.env` host, port, database, user, and password are correct.
- **Login always fails:** run the interactive `php spark auth:set-password username_here` command for an active account.
- **Images fail to upload:** enable GD, check PHP `upload_max_filesize`/`post_max_size`, and make both upload directories writable. The application limit is 2 MB.
- **Routes return 404:** point the document root to `public/`, enable rewrite support, and verify `app.baseURL`.
- **CSRF error after a long-open form:** reload the form to obtain a fresh token.
- **Migration error:** confirm the existing TFA customer/user tables are present and back up the database before retrying.

## Repository and submission notes

- `database/pos_db.sql` is the clean, reproducible database setup.
- The archive columns are documented safety extensions and do not replace any official field.
- Never commit `.env`, live password hashes, real credentials, generated uploads, database backups containing private data, or `writable/` runtime artifacts.
- Git commit, push, and hosted deployment are separate owner-controlled steps; local testing does not imply any of them occurred.
