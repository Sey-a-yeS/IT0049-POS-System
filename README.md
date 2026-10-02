# Tasks for Today Management System

## Project

This CodeIgniter 4 application was developed by **Isaiah Ezekiel P. Vicencio** for **IT0049 - Web System Technologies, Technical Summative Assessment 1**.

The system presents today's tasks, the complete task schedule, and one database-backed user profile through a clear MVC flow:

```text
MySQL database -> CodeIgniter Model -> Controller -> View -> HTML response
```

## Features

- Welcome page showing only tasks scheduled for the current date
- All Tasks page showing every task ordered by `task_date`
- Profile page showing the single demonstration user
- Static About page identifying the developer
- Database access through `TaskModel` and `UserModel`
- Explicit routes and reusable responsive page templates

## Requirements

- PHP 8.2 or newer
- Composer
- MySQL or MariaDB
- PHP extensions required by CodeIgniter 4, including `intl`, `mbstring`, and `mysqli`

## Installation

1. Enter the project directory:

   ```bash
   cd pos-system
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create the local environment file if it does not already exist:

   ```bash
   cp env .env
   ```

4. Configure the application and database connection in `.env`:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   app.indexPage = ''

   database.default.hostname = 127.0.0.1
   database.default.database = tasks_today_db
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

   Change the username, password, or port to match your local database installation. `.env` is ignored by Git and must not be committed.

5. Import the included database setup:

   ```bash
   mysql --host=127.0.0.1 --port=3306 -u root -p < database/tasks_today_db.sql
   ```

   The SQL file creates `tasks_today_db`, creates the required `tasks` and `users` tables, inserts nine tasks across three dates relative to the import date, and inserts exactly one user.

6. Start the development server:

   ```bash
   php spark serve
   ```

7. Open [http://localhost:8080/](http://localhost:8080/).

## Routes

| Method | URL | Controller method | Purpose |
| --- | --- | --- | --- |
| GET | `/` | `Tasks::today` | Tasks scheduled for today |
| GET | `/tasks` | `Tasks::index` | All tasks ordered by date |
| GET | `/profile` | `Users::index` | Single database user |
| GET | `/about` | `Pages::about` | Project and developer information |

## Database schema

The reproducible database setup is located at:

```text
database/tasks_today_db.sql
```

### `tasks`

- `id`
- `title`
- `status`
- `task_date`
- `created_at`

### `users`

- `id`
- `username`
- `full_name`
- `email`
- `created_at`

## MVC structure

```text
app/
|-- Config/Routes.php
|-- Controllers/
|   |-- Pages.php
|   |-- Tasks.php
|   `-- Users.php
|-- Models/
|   |-- TaskModel.php
|   `-- UserModel.php
`-- Views/
    |-- tasks/index.php
    |-- templates/
    |-- about.php
    |-- home.php
    `-- profile.php
database/
`-- tasks_today_db.sql
public/
`-- assets/css/style.css
```

- `TaskModel::findForDate()` filters tasks by the supplied date using CodeIgniter Model/Query Builder methods.
- `TaskModel::findAllOrdered()` retrieves all tasks ordered by `task_date`.
- `UserModel` retrieves the single demonstration user for the Profile page.
- Controllers prepare database records for the views.
- Views render the supplied records and do not contain SQL queries.

## Security and repository notes

- Do not commit `.env` or database credentials.
- Composer dependencies in `vendor/` are excluded and can be restored with `composer install`.
- Runtime files under `writable/` are excluded.
- The application intentionally does not include authentication, passwords, roles, or CRUD functionality.
