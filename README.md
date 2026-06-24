# Online Voting System

PHP/MySQL web app for student elections.

## Prerequisites

- PHP 7.4+ with MySQLi enabled
- MySQL 5.7+ (or MariaDB equivalent)
- Web server (Apache/Nginx or local stack like XAMPP)

## Database Setup

This repository now includes an SQL migration script:

- `migrations/001_initial_schema.sql`

Run it with:

```bash
mysql -u root -p < migrations/001_initial_schema.sql
```

The app expects these default DB settings in `utils/connection.php`:

- host: `localhost`
- user: `root`
- password: ``
- database: `votingsystem`

## App Configuration

Update `config/website_info.php` for your environment:

- `APP_URL`
- sender email credentials for activation emails
- reCAPTCHA keys

## Run Locally

1. Place the project in your web server root.
2. Import the migration SQL above.
3. Open the app in your browser.
