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

```
> **Important Note:**  
> The **Delete** button for a project is only visible to the user who created that project.  
> If the currently authenticated user is not the project owner, the delete option will not be displayed.
```
