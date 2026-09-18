# CodeIgniter 4 POS System

## Project description

This repository contains the first version of a basic Point-of-Sale (POS) system built with CodeIgniter 4. It was created for **Technical Formative Assessment 1** in **IT0049 - Web System Technologies**.

The project demonstrates explicit routing, controllers, views, passing data from controllers to views, static PHP arrays, `foreach` loops, and navigation. It intentionally does not include authentication, CRUD operations, or database integration.

## Main features

- Responsive landing page with links to account directories
- About page explaining the application's learning objectives
- Customer Accounts table with full name, email, and phone fields
- User Accounts table with username, full name, and role fields
- Shared header, navigation, footer, and responsive visual design
- Explicit GET routes with automatic routing disabled
- Escaped dynamic output in the account views

## CodeIgniter MVC structure

Each request follows the basic CodeIgniter MVC flow:

```text
Route -> Controller -> Data -> View -> HTML response
```

For the account directories, the flow is:

```text
Route -> Controller -> Static PHP array -> View -> foreach -> HTML table
```

- **Routes** connect a URL to a controller method.
- **Controllers** prepare the page title and any record data.
- **Views** receive that data and render the HTML response.
- **Public assets** contain the stylesheet served by the web server.

## Required routes

| Method | URL | Controller method |
| --- | --- | --- |
| GET | `/` | `Pages::index` |
| GET | `/about` | `Pages::about` |
| GET | `/customers` | `Customers::index` |
| GET | `/users` | `Users::index` |

## Requirements

- PHP 8.2 or newer
- Composer 2
- PHP extensions required by CodeIgniter 4, including `intl` and `mbstring`

The exact PHP requirement can also be checked in `composer.json`.

## Installation

1. Clone the repository and enter the project directory.
2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create the local environment file:

   ```bash
   cp env .env
   ```

4. Open `.env`, set the development environment, and configure the base URL:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   app.indexPage = ''
   ```

   The `.env` file is ignored by Git and should not be committed.

5. Start the CodeIgniter development server:

   ```bash
   php spark serve
   ```

6. Open [http://localhost:8080/](http://localhost:8080/) in a browser.

## Project structure

```text
app/
|-- Config/Routes.php           Explicit application routes
|-- Controllers/
|   |-- Pages.php               Home and About pages
|   |-- Customers.php           Static customer records
|   `-- Users.php               Static staff records
`-- Views/
    |-- templates/              Shared header and footer
    |-- customers/index.php     Customer table and foreach loop
    |-- users/index.php         User table and foreach loop
    |-- home.php                Landing page
    `-- about.php               About page
public/
`-- assets/css/style.css        Shared responsive styles
```

## Static arrays and data fields

No database is used in this assessment. Customer and user records are temporary static PHP arrays declared inside their respective controller `index()` methods. The controllers pass those arrays to the views, where PHP `foreach` loops render the table rows.

Each customer record contains:

- `full_name`
- `email`
- `phone`

Each user record contains:

- `username`
- `full_name`
- `role`

A future version could replace these arrays with models and database records, but database functionality is intentionally outside the scope of this first assessment.
