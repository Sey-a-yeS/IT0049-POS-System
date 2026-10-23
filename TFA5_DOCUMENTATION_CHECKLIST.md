# TFA5 Documentation Screenshot Checklist

Capture real screenshots after installing and running `laravel-pos-tfa5`. Keep the browser URL visible where practical. Do not use mockups as evidence.

| Order | Screenshot | What it should demonstrate | Suggested caption |
| --- | --- | --- | --- |
| 1 | Terminal: `php artisan --version` | Installed Laravel version | Laravel application and Artisan version |
| 2 | Terminal: `php artisan route:list` | Four named controller routes | Required home, about, customer, and user routes |
| 3 | Home page at `/` | Landing identity and links to both directories | Counterpoint POS landing page |
| 4 | About page at `/about` | Laravel, MVC, static arrays, educational scope | About the Laravel TFA5 application |
| 5 | Customer Accounts at `/customers` | Five records and all required columns | Customer directory rendered from a controller array |
| 6 | User Accounts at `/users` | Five records, roles, and readable status labels | Staff directory rendered from a controller array |
| 7 | Controller source and Blade source | Static arrays in controllers and `@foreach` in views | Laravel MVC data flow |
| 8 | Narrow browser viewport | Usable navigation and horizontal table scroll | Responsive account directory |
| 9 | Terminal: `php artisan test` | Passing automated tests | Four-page feature test results |
| 10 | Hosted browser URL, once deployed | Real HTTPS application and loaded assets | Live TFA5 Laravel application |

Before submission, confirm the screenshots match the committed code and include the GitHub repository link and the verified hosted link required by the professor.
