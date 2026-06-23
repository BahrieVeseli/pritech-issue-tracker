# PRITECH Issue Tracker

Mini issue tracker built with Laravel 13 for the PRITECH technical task.

## What is included

- Projects CRUD with `start_date` and `deadline`
- Issues CRUD with filters by status, priority, tag, and text search
- Tags create/list with unique names
- Comments loaded and created via AJAX
- Tag attach/detach without page reload
- Bonus: issue members pivot, basic auth, and project policy

## Tech stack

- Laravel 13
- MySQL
- Blade
- Vanilla JavaScript
- Pest feature tests

## Setup

1. Copy `.env.example` to `.env`
2. Set your MySQL credentials
3. Run:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate --seed
npm run build
```

## Run locally

```bash
php artisan serve
npm run dev
```

## Demo users

- `owner@example.com`
- `member@example.com`

Password for both seeded users: `password`

## Notes

- Use `owner@example.com` to test project ownership rules.
- The seeded data is intentionally clean and demo-friendly.
- Tests cover the main CRUD and AJAX flows.
