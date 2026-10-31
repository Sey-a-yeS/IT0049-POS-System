# TFA6 Documentation Screenshot Checklist

Capture real evidence from the committed TFA6 version. Do not include `.env` passwords, application keys, database credentials, private logs, or fabricated screenshots. Keep page URLs or terminal commands visible where useful.

| Order | Figure title | What to capture | Suggested caption |
| --- | --- | --- | --- |
| 1 | Dedicated Database Configuration | `.env.example` or a redacted database configuration, never the private `.env` | Counterpoint uses a dedicated TFA6 database |
| 2 | Customer Migration | `create_customers_table` migration showing required fields and lengths | Laravel migration defines the TFA2 customer schema |
| 3 | User Migration | Existing users migration showing unique `username` and `full_name` | Laravel migration adapts the users table safely |
| 4 | Migration Result | `php artisan migrate` and `php artisan migrate:status` output | TFA6 tables were created by migrations |
| 5 | Repeatable Seeder | `CounterpointSampleSeeder.php` and `php artisan db:seed` output | Five fictional records per directory are seeded without truncation |
| 6 | Database Tables | MySQL table list and redacted `DESCRIBE customers` / `DESCRIBE users` output | Both database tables and the username constraint exist |
| 7 | Database Records | Table results showing five customer and five user sample rows | Sample records are stored in the database |
| 8 | Eloquent Models | `Customer.php` and `User.php` | Account data is represented by Eloquent models |
| 9 | Controller Queries | CustomerController and UserController `index()` methods | Both directories retrieve records through models |
| 10 | Customer Accounts Page | `/customers` in the browser with five rows | Customer Accounts displays database-backed records |
| 11 | User Accounts Page | `/users` in the browser with five rows | User Accounts displays database-backed records |
| 12 | Blade Rendering | Customer and user Blade `@foreach` loops | Views render escaped Eloquent attributes |
| 13 | Routes and Tests | `php artisan route:list` and `php artisan test` output | Four routes and database-backed tests pass |
| 14 | GitHub Project | The published repository tree after approval and push | Source, migrations, seeder, and README are submitted |
| 15 | Hosted Application | Real HTTPS `/`, `/about`, `/customers`, and `/users` after deployment | Hosted TFA6 matches the submitted code |

Before submitting, verify the hosted application is live and the repository contains raw source files, migrations, seeder, README, and no private credentials. The GitHub and hosted figures are pending until those links actually exist and have been checked.
