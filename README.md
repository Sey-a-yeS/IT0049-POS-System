# CodeIgniter 4 POS System

## Project

This Point-of-Sale application was developed for **IT0049 - Web System Technologies** and extended for **Technical Formative Assessment 3: Making It Editable — Forms, Validation, and File Upload**.

The application uses CodeIgniter MVC throughout:

```text
Browser -> Route -> Controller -> Model -> MySQL -> View
```

## Features

- Database-backed Customer Accounts and User Accounts listings
- Customer creation with server-side validation and preserved old input
- User creation with required and unique username validation
- Customer and user edit/update workflows
- Optional user avatar upload during editing
- JPG/PNG validation with a 2 MB maximum
- Safe random avatar filenames
- Display-ready square avatar preparation using CodeIgniter's Image service
- Local placeholder image when an avatar is unavailable
- CSRF-protected forms and escaped output
- Redirect-after-success workflows to prevent duplicate submissions on refresh

The application intentionally does not include authentication, passwords, roles, deletion, registration, or unrelated CRUD features.

## Requirements

- PHP 8.2 or newer
- Composer
- MySQL or MariaDB
- PHP extensions required by CodeIgniter 4, including `intl`, `mbstring`, `mysqli`, and `gd`
- Write access to `public/uploads/avatars/`

## Installation and setup

1. Enter the project directory:

   ```bash
   cd pos-system
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create the local environment file if needed:

   ```bash
   cp env .env
   ```

4. Configure the application and database connection in `.env`:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   app.indexPage = ''

   database.default.hostname = 127.0.0.1
   database.default.database = pos_db
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

   Change the connection values for your own MySQL installation. `.env` is ignored by Git and must not be committed.

5. Import the database setup:

   ```bash
   mysql --host=127.0.0.1 --port=3306 -u root -p < database/pos_db.sql
   ```

   The setup recreates the required `customers` and `users` tables. The TFA3 `users` schema includes a nullable `avatar VARCHAR(255)` column that stores a generated filename only.

6. Ensure the avatar directory is writable by the web server:

   ```bash
   chmod 755 public/uploads/avatars
   ```

7. Start CodeIgniter:

   ```bash
   php spark serve
   ```

8. Open [http://localhost:8080/](http://localhost:8080/).

## Application routes

| Method | URL | Purpose |
| --- | --- | --- |
| GET | `/` | Home |
| GET | `/about` | About |
| GET | `/customers` | Customer Accounts |
| GET | `/customers/new` | New Customer form |
| POST | `/customers` | Validate and create customer |
| GET | `/customers/{id}/edit` | Edit Customer form |
| POST | `/customers/{id}` | Validate and update customer |
| GET | `/users` | User Accounts |
| GET | `/users/new` | New User form |
| POST | `/users` | Validate and create user |
| GET | `/users/{id}/edit` | Edit User and avatar form |
| POST | `/users/{id}` | Validate and update user/avatar |

## Customer workflows

### New Customer

Open `/customers/new`. Full name and email are required, and the email must be valid. Phone is optional. Invalid submissions display validation errors and preserve all submitted values. Valid records are inserted through `CustomerModel` and redirected to Customer Accounts.

### Edit Customer

Use the Edit action from Customer Accounts. Existing values are pre-filled. Validation uses the same required-name and valid-email rules. A successful submission updates the existing ID through `CustomerModel` and redirects to the listing.

## User workflows

### New User

Open `/users/new`. Username and full name are required. Username uniqueness is validated server-side using the `users.username` field, with the database UNIQUE constraint retained as additional protection.

### Edit User

Use the Edit action from User Accounts. Existing username and full name are pre-filled. An unchanged username is accepted, while a username used by another record is rejected. Selecting no avatar preserves the existing avatar filename.

### Avatar upload

- Avatar upload is optional and available on User Edit.
- The form uses `multipart/form-data`.
- Only valid JPG/JPEG and PNG images are accepted.
- Maximum size is 2 MB.
- Files are checked using CodeIgniter upload and image validation rules.
- A random safe filename is generated; the original client filename is not used.
- CodeIgniter's GD Image service prepares a centered square image up to 256 × 256 pixels without enlarging smaller images.
- Prepared files are stored in `public/uploads/avatars/`.
- Only the generated filename is stored in `users.avatar`.
- Missing or invalid stored files display `public/assets/images/avatar-placeholder.svg` instead of a broken image.

## Database files

- `database/pos_db.sql` — concise reproducible setup with the TFA3 avatar column.
- `database/pos_db_export.sql` — MySQL-generated export of the verified working database.

## MVC structure

```text
app/
|-- Config/Routes.php
|-- Controllers/
|   |-- Customers.php
|   |-- Pages.php
|   `-- Users.php
|-- Models/
|   |-- CustomerModel.php
|   `-- UserModel.php
`-- Views/
    |-- customers/
    |   |-- edit.php
    |   |-- form.php
    |   |-- index.php
    |   `-- new.php
    |-- users/
    |   |-- edit.php
    |   |-- form.php
    |   |-- index.php
    |   `-- new.php
    `-- templates/
public/
|-- assets/images/avatar-placeholder.svg
`-- uploads/avatars/
```

Controllers handle validation and workflows, Models perform inserts and updates, and Views render supplied data without SQL queries.

## Security and repository notes

- CSRF protection is enabled and forms include CSRF tokens.
- User-provided and database-provided values are escaped in views.
- `.env` and real credentials are not committed.
- Generated user uploads are ignored by Git; `.gitkeep` preserves the upload directory.
- Deployments must point the web document root to `public/` and provide write permission for the avatar directory.
