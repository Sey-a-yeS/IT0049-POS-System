# CodeIgniter 4 POS System

## IT0049 Technical Formative Assessment 4

This Point-of-Sale application was developed for **IT0049 - Web System Technologies** and extended for **Technical Formative Assessment 4: Who's Allowed In? Sessions and Authentication**.

TFA4 preserves the TFA3 customer and staff-account workflows while requiring an authenticated staff session for every customer and user management page. The public Home, About, and Login pages remain available without authentication.

## Features

- Database-backed Customer Accounts and User Accounts
- Validated customer and user create/edit workflows from TFA3
- Optional JPG/PNG avatar upload with a 2 MB limit and a local placeholder
- Password hashes stored in `users.password` using PHP `password_hash()`
- Login verification using PHP `password_verify()`
- Session ID regeneration after a successful login
- CodeIgniter `AuthFilter` protection on all customer/user GET and POST routes
- POST-only, CSRF-protected logout that destroys the authenticated session
- CSRF protection on every form and escaped output in views
- Short session-based delay after repeated unsuccessful login attempts
- No-store response headers on protected account-management pages

Passwords are not created or edited in the ordinary User Accounts forms. A local CLI command initializes credentials deliberately without echoing password input.

## Requirements

- PHP 8.2 or newer
- Composer
- MySQL or MariaDB
- PHP extensions required by CodeIgniter 4, including `intl`, `mbstring`, `mysqli`, and `gd`
- Write access to `writable/` and `public/uploads/avatars/`

## Local installation

1. Enter the project directory:

   ```bash
   cd pos-system
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create the local environment file:

   ```bash
   cp env .env
   ```

4. Configure the application URL and your own local MySQL connection in `.env`:

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

   `.env` is ignored by Git. Never commit it or copy private credentials into tracked documentation.

5. Import the reproducible database setup:

   ```bash
   mysql --host=127.0.0.1 --port=3306 -u your_mysql_user -p < database/pos_db.sql
   ```

   The setup contains the TFA3 customer/user data, the existing `avatar` column, and the TFA4 nullable `password VARCHAR(255)` column. Tracked SQL files intentionally contain `NULL` password values so no usable password hashes or credentials are published.

   For an existing TFA3 database instead of a fresh import, apply the migration:

   ```bash
   php spark migrate
   ```

6. Initialize every existing staff password locally:

   ```bash
   php spark auth:set-password --all
   ```

   The command prompts separately for each existing username, requires at least 12 characters, hides terminal input, confirms each password, and stores only `password_hash()` output. It does not print or retain plaintext passwords. To initialize or change one user later, run:

   ```bash
   php spark auth:set-password username_here
   ```

   A newly created User Account cannot sign in until this local command has initialized its password. This avoids a shared or hard-coded default credential.

7. Ensure the avatar upload directory is writable:

   ```bash
   chmod 755 public/uploads/avatars
   ```

8. Start the local development server:

   ```bash
   php spark serve
   ```

9. Open [http://localhost:8080/](http://localhost:8080/) and use `/login` for staff access.

## Routes and access rules

| Method | URL | Access | Purpose |
| --- | --- | --- | --- |
| GET | `/` | Public | Home |
| GET | `/about` | Public | About |
| GET | `/login` | Public | Login form |
| POST | `/login` | Public + CSRF | Validate credentials and create session |
| POST | `/logout` | Authenticated + CSRF | Destroy session and return to Login |
| GET | `/customers` | Authenticated | Customer Accounts |
| GET | `/customers/new` | Authenticated | New Customer form |
| POST | `/customers` | Authenticated + CSRF | Create customer |
| GET | `/customers/{id}/edit` | Authenticated | Edit Customer form |
| POST | `/customers/{id}` | Authenticated + CSRF | Update customer |
| GET | `/users` | Authenticated | User Accounts |
| GET | `/users/new` | Authenticated | New User form |
| POST | `/users` | Authenticated + CSRF | Create user |
| GET | `/users/{id}/edit` | Authenticated | Edit User/avatar form |
| POST | `/users/{id}` | Authenticated + CSRF | Update user/avatar |

Unauthenticated protected GET requests remember the requested customer/user path and redirect to `/login`. After successful authentication, the application returns to that safe internal path. Unauthenticated writes are stopped by the Filter and are never executed.

## Authentication workflow

1. `Auth::authenticate()` validates non-empty username/password input.
2. `UserModel` retrieves only the fields needed for authentication.
3. `password_verify()` compares the submitted password with the stored hash.
4. Invalid usernames and passwords receive the same general error message.
5. Successful login regenerates the session ID and stores only the user ID, username, and login-state flag.
6. `AuthFilter` checks that login state before the protected controller runs.
7. Logout is a POST request with a CSRF token; it removes authentication state, destroys the session, and redirects to `/login`.

The login form never repopulates the password. Customer/User listings and edit controllers explicitly exclude the password column, and no view displays a hash.

## Existing TFA3 workflows

- New Customer validates full name and email and preserves non-sensitive old input after failure.
- Edit Customer updates the selected database record through `CustomerModel`.
- New User validates required fields and unique usernames; it does not ask for an authentication password.
- Edit User preserves an unchanged username and supports an optional avatar replacement.
- Avatar files use random filenames, image validation, centered square preparation, and the local placeholder fallback.

## Database and source structure

```text
app/
|-- Commands/SetUserPassword.php
|-- Config/
|   |-- Filters.php
|   `-- Routes.php
|-- Controllers/
|   |-- Auth.php
|   |-- Customers.php
|   |-- Pages.php
|   `-- Users.php
|-- Database/Migrations/2026-10-08-143500_AddPasswordToUsers.php
|-- Filters/AuthFilter.php
|-- Models/
|   |-- CustomerModel.php
|   `-- UserModel.php
`-- Views/
    |-- auth/login.php
    |-- customers/
    |-- users/
    `-- templates/
database/
|-- pos_db.sql
`-- pos_db_export.sql
public/
|-- assets/
`-- uploads/avatars/
```

Controllers coordinate validation and workflows, Models perform database access, the Filter enforces route access, and Views render supplied data without SQL.

## Deployment requirements

The assessment requires a hosted working application; `localhost:8080` is only local verification. Deployment is a separate manual step and must not be performed without the owner's authorization.

For hosting:

- Point the web document root to `public/`, not the repository root.
- Use a production MySQL database and private environment variables.
- Set `CI_ENVIRONMENT = production`.
- Set the real HTTPS `app.baseURL` and enable `app.forceGlobalSecureRequests = true`.
- Enable secure session/CSRF cookies with `cookie.secure = true`; retain `cookie.httponly = true` and `cookie.samesite = Lax`.
- Keep `.env`, database credentials, password hashes, and demo plaintext credentials out of Git.
- Make `writable/` and `public/uploads/avatars/` writable by the web process.
- Run `php spark migrate` and initialize hosted demo credentials privately with `php spark auth:set-password`.
- Disable development debug output and confirm login/logout over HTTPS.

Do not publish demo credentials in this README or in a public SQL export.

## Repository notes

- `database/pos_db.sql` is the concise reproducible setup.
- `database/pos_db_export.sql` is the structure/data export without password hashes.
- `.env` and generated avatar uploads are ignored by Git.
- The clean TFA3 commit `0cc3377` is the restore point before TFA4 changes.
- GitHub push and hosted deployment are not implied by local implementation; verify both separately before submission.
