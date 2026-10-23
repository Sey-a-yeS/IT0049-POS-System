# IT0049 — Web System Technologies Assessments

This repository collects the completed IT0049 Technical Formative Assessments, Technical Summative Assessments, and previous Midterm POS project in one navigable default-branch layout.

Each directory is a standalone application. The earlier assessments use CodeIgniter 4; TFA5 uses Laravel. Install dependencies from inside the application you want to run.

No application in this repository is claimed to be publicly deployed. The source and setup instructions are provided for local review.

## Repository overview

| Directory | Assessment | Description | Preserved source branch |
|---|---|---|---|
| [`pos-system/`](pos-system/) | TFA1–TFA4 | Point-of-sale account-management application culminating in authenticated customer and staff workflows | [`main` snapshot at `6a61396`](https://github.com/Sey-a-yeS/IT0049-TFA1-POS-System/tree/6a61396f20b6e9e0987fddd8dca2bb874792c757) |
| [`tasks-for-today/`](tasks-for-today/) | TSA1–TSA2 | Task management application with public task views and authenticated create, edit, and archive workflows | [`tsa2-tasks-for-today` at `390d4a0`](https://github.com/Sey-a-yeS/IT0049-TFA1-POS-System/tree/390d4a0172de3ad14fb7b87b8b20a5a6145521e0) |
| [`previous-midterm-pos/`](previous-midterm-pos/) | Previous Midterm Project | Complete POS implementation with products, customers, staff, authentication, transactional sales, inventory control, and sales history | [`midterm-pos-acceptance` at `931e2ce`](https://github.com/Sey-a-yeS/IT0049-TFA1-POS-System/tree/931e2cee9126dc974881b454fe74efb277a7cd20) |
| [`laravel-pos-tfa5/`](laravel-pos-tfa5/) | TFA5 | Four-page Laravel POS demonstration with static customer and staff arrays | This integration branch |

The three original branch histories remain available. The organized directory layout is prepared separately so the assessments can eventually be reviewed directly from the default `main` branch after approval and publication.

## Directory navigation

```text
IT0049-TFA1-POS-System/
├── README.md
├── pos-system/             # Technical Formative Assessments 1–4
├── tasks-for-today/        # Technical Summative Assessments 1–2
├── previous-midterm-pos/   # Previous Midterm POS application
└── laravel-pos-tfa5/       # Technical Formative Assessment 5
```

Every application directory has its own framework entry point, dependencies, source, and README.

### TFA5 Laravel POS

Open [`laravel-pos-tfa5/`](laravel-pos-tfa5/) for the Laravel rebuild of the original TFA1 four-page exercise. Named routes render `/`, `/about`, `/customers`, and `/users` through `PageController`, `CustomerController`, and `UserController`. The account controllers provide five fictional static records each; Blade `@foreach` renders their tables. These pages do not require a database. Unlike the earlier CodeIgniter TFA1, this application uses Laravel's `routes/web.php`, controller actions, and Blade layout/view conventions.

To run it locally:

```bash
cd laravel-pos-tfa5
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8083
```

See [`laravel-pos-tfa5/README.md`](laravel-pos-tfa5/README.md) for full setup and deployment guidance. The TFA5 implementation report and screenshot checklist are at the repository root. Hosting is pending until an actual HTTPS deployment is tested.

## Technical Formative Assessments

### TFA1–TFA4 Point-of-Sale system

Open [`pos-system/`](pos-system/) for the TFA application progression. The preserved final TFA4 snapshot includes:

- database-backed customer and staff-account management;
- validated create and edit workflows;
- staff avatar upload handling;
- password hashing and session authentication;
- protected customer/staff routes and CSRF-protected forms.

Detailed setup and route documentation: [`pos-system/README.md`](pos-system/README.md)

Assessment references:

- [`pos-system/documentation/IT0049 - TFA2 - VICENCIO.pdf`](pos-system/documentation/IT0049%20-%20TFA2%20-%20VICENCIO.pdf)
- [`pos-system/documentation/IT0049 - TFA3 - VICENCIO.pdf`](pos-system/documentation/IT0049%20-%20TFA3%20-%20VICENCIO.pdf)

Database resources:

- [`pos-system/database/pos_db.sql`](pos-system/database/pos_db.sql)
- [`pos-system/database/pos_db_export.sql`](pos-system/database/pos_db_export.sql)

## Technical Summative Assessments

### TSA1–TSA2 Tasks for Today

Open [`tasks-for-today/`](tasks-for-today/) for the summative assessment application. The preserved TSA2 snapshot includes:

- public Today, All Tasks, Profile, and About pages;
- session-based login and logout;
- authenticated task creation and editing;
- soft archival instead of physical deletion;
- server-side validation, CSRF protection, and escaped output.

Detailed setup and route documentation: [`tasks-for-today/README.md`](tasks-for-today/README.md)

Assessment reference:

- [`tasks-for-today/documentation/TSA1 - VICENCIO.pdf`](tasks-for-today/documentation/TSA1%20-%20VICENCIO.pdf)

Database resource:

- [`tasks-for-today/database/tasks_today_db.sql`](tasks-for-today/database/tasks_today_db.sql)

## Previous Midterm Project

Open [`previous-midterm-pos/`](previous-midterm-pos/) for the earlier Midterm POS implementation. It extends the formative POS work with:

- product, customer, and staff management;
- staff authentication and protected management routes;
- product images and staff avatars;
- transactional stock-controlled sales;
- relational sales history that retains archived record names.

Detailed setup, schema, routes, and security notes: [`previous-midterm-pos/README.md`](previous-midterm-pos/README.md)

Database resource:

- [`previous-midterm-pos/database/pos_db.sql`](previous-midterm-pos/database/pos_db.sql)

## General local setup

The exact setup for each project is documented in that project's README. The following common workflow applies to the three earlier CodeIgniter applications; TFA5 needs no database and uses Artisan as shown above.

1. Enter exactly one application directory.
2. Install that application's locked Composer dependencies.
3. Copy its tracked `env` template to the ignored `.env` file.
4. Configure a dedicated local database and application URL.
5. Import the database SQL file or follow the application's migration instructions.
6. Initialize any required login password through the documented CLI command.
7. Start the CodeIgniter development server.

Example:

```bash
cd pos-system
composer install
cp env .env
# Configure .env and import the database described in pos-system/README.md
php spark serve
```

Run only one application on port 8080 at a time, or assign different ports and matching `app.baseURL` values. Each application should use its own database.

## Application-specific setup references

| Application | Database setup | Credential initialization |
|---|---|---|
| TFA1–TFA4 POS | Import `pos-system/database/pos_db.sql` or follow its migration guidance | `php spark auth:set-password username_here` from `pos-system/` |
| TSA1–TSA2 Tasks | Import `tasks-for-today/database/tasks_today_db.sql` or follow its migration guidance | `php spark auth:set-password isaiahvicencio` from `tasks-for-today/` |
| Previous Midterm POS | Import `previous-midterm-pos/database/pos_db.sql` or follow its migration guidance | `php spark auth:set-password username_here` from `previous-midterm-pos/` |

Passwords are deliberately not included. Each command prompts privately and stores only a password hash.

## Branch preservation

The original assessment branches remain the authoritative historical snapshots:

| Branch | Preserved commit | Purpose |
|---|---:|---|
| `main` | `6a61396` | TFA1–TFA4 progression before repository organization |
| `tsa2-tasks-for-today` | `390d4a0` | TSA1–TSA2 application |
| `midterm-pos-acceptance` | `931e2ce` | Previous Midterm POS application |

The integration work does not rewrite or delete these histories. A separate backup branch also records the original `main` commit before organization.

## Security and repository hygiene

- Real `.env` files, credentials, sessions, logs, caches, Composer `vendor/` directories, and generated uploads are excluded from version control.
- Tracked `env` files are configuration templates and do not contain working application passwords.
- Database setup files intentionally avoid publishing usable login credentials.
- Install dependencies independently inside each application.
- Never point a web server at the repository root; when running one application, its document root should be that application's `public/` directory.

## Repository status

This organized layout is intended for review from the default branch after its integration commit has been inspected and explicitly approved for publication. The original project branches remain available for commit-by-commit history and comparison.
