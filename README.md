# Job Tracker — Backend

A REST API for tracking job applications, built with Laravel and PostgreSQL. Built as a learning project to gain hands-on experience with PHP and Laravel, alongside a separate Vue frontend.

## Overview

This is a pure API backend (no Blade views) that powers a personal job application tracker — the kind of tool you'd actually use to keep track of where you've applied, current status, salary expectations, and notes, rather than a spreadsheet. It's paired with a separate Vue 3 + TypeScript frontend ([job-tracker-frontend](https://github.com/maxkemzi/job-tracker-frontend)).

The project was built specifically to develop real PHP/Laravel fundamentals — authentication, Eloquent ORM, database migrations, REST API design, and authorization — after prior experience primarily in JavaScript/TypeScript full-stack development.

## Features

- **Token-based authentication** via Laravel Sanctum — register, login, logout
- **Full CRUD for job applications** — create, list, update, and delete applications
- **Per-user data isolation** — every application belongs to a specific user; authorization policies ensure users can only access their own data
- **Status tracking** — applications move through a defined lifecycle (applied, screening, interview, technical, offer, rejected)
- **Input validation** — server-side validation on every endpoint, covering required fields, formats, and enum constraints
- **RESTful API design** — resourceful routes following Laravel conventions (`GET/POST/PUT/DELETE /api/applications`)

## Tech Stack

- [Laravel 12](https://laravel.com/) — PHP framework
- [PHP 8.3+](https://www.php.net/)
- [PostgreSQL](https://www.postgresql.org/) — database
- [Laravel Sanctum](https://laravel.com/docs/sanctum) — API token authentication
- [Eloquent ORM](https://laravel.com/docs/eloquent) — database modeling and queries

## Architecture Highlights

**Authorization via Policies** — rather than repeating ownership checks across every controller method, application access control is centralized in an `ApplicationPolicy`, checked via `$this->authorize()`. This keeps controllers focused on request/response handling while authorization logic lives in one place.

**API-only design** — this backend has no Blade views, no frontend asset pipeline, and no session-based web routes. It exists purely to serve JSON over `/api/*`, consumed by a completely separate frontend application — a clean separation that mirrors how many real-world SPA + API architectures are structured.

**Consistent validation and error handling** — every mutating endpoint validates input against explicit rules before touching the database, returning clear JSON error responses (401 for authentication failures, 403 for authorization failures, 422 for validation failures) rather than leaking framework-level error pages.

## Getting Started

### Prerequisites

- PHP 8.3+
- Composer
- PostgreSQL

### Installation

```bash
git clone https://github.com/maxkemzi/job-tracker-backend.git
cd job-tracker-backend
composer install
cp .env.example .env
php artisan key:generate
```

### Environment Variables

Configure your `.env` file with your PostgreSQL connection:

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=job_tracker
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### Database setup

```bash
php artisan migrate
```

### CORS configuration

Update `config/cors.php` to allow your frontend's origin:

```php
'allowed_origins' => ['http://localhost:5173'],
```

### Run locally

```bash
php artisan serve
```

The API will be available at `http://localhost:8000/api`.

## API Endpoints

### Auth

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/auth/register` | Create a new account |
| POST | `/api/auth/login` | Log in and receive an access token |
| POST | `/api/auth/logout` | Revoke the current access token *(requires auth)* |

### Applications

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/applications` | List the authenticated user's applications |
| POST | `/api/applications` | Create a new application |
| GET | `/api/applications/{id}` | View a single application |
| PUT | `/api/applications/{id}` | Update an application |
| DELETE | `/api/applications/{id}` | Delete an application |

All `/api/applications/*` endpoints require authentication and are scoped to the requesting user.

## Frontend

The companion Vue frontend for this API is available at [job-tracker-frontend](https://github.com/maxkemzi/job-tracker-frontend).

## Author

**Maksym Kyrychenko**
Full Stack Developer based in Riga, Latvia
[Portfolio](https://maxkemzi.com) · [GitHub](https://github.com/maxkemzi)
