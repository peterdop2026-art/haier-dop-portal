# Laravel Migration Plan (XAMPP + MySQL)

This repo currently runs **React (Vite)** + **NestJS** + **PostgreSQL**.
We are starting a migration to **Laravel (PHP)** + **MySQL (XAMPP)** without breaking the current working app.

## Current status (done)
- A new Laravel app has been scaffolded in: `laravel/`
- PHP CLI extension **fileinfo** was enabled (required by Laravel).
- Laravel dependencies installed (prod deps) and `APP_KEY` generated.

## Key decision (you choose)
### Option A — Full PHP UI (recommended if you want “everything in Laravel/PHP”)
- Use **Blade** templates for:
  - User login, signup, request form, my-requests
  - Admin login, dashboard, admin my-requests
- Pros: pure Laravel/PHP, simplest XAMPP deployment
- Cons: re-build UI (React screens will not be reused)

### Option B — Keep current React UI, replace backend with Laravel API
- Keep frontend React, but API comes from Laravel (use Laravel Sanctum/JWT)
- Pros: fastest migration (reuse UI)
- Cons: not “pure PHP”, still a JS SPA

## Data model mapping (NestJS → Laravel)
### Tables
- `users`
  - `id`, `sap_id`, `email`, `password_hash`, `created_at`, `updated_at`
- `admins`
  - `id`, `email`, `password_hash`, `created_at`, `updated_at`
- `dop_requests`
  - `id`, `user_id` nullable, `admin_id` nullable
  - `work_order`, `current_dop`, `dop_to_update`, `serial_number`, `reason`
  - `case_type` enum (`customer`, `dealer`)
  - `warranty_card_url` nullable, `invoice_url` nullable
  - `status` enum (`pending`, `approved`, `rejected`)
  - `submitted_at`

### File uploads
- Store files on disk under Laravel: `storage/app/public/uploads/`
- Serve them via: `php artisan storage:link` (public symlink)
- Save only file paths in DB:
  - `warranty_card_url` and `invoice_url`

## Endpoint mapping (what we will recreate)
### Auth
- User login (sapId + password)
- Admin login (email + password)
- Logout for each role

### DOP Requests
- `POST /dop-requests` (multipart, warrantyCard + invoice)
- `GET /dop-requests/my`
- `GET /dop-requests` (admin only)
- `PUT /dop-requests/{id}/status` (admin only)

## Recommended migration order
1. Configure Laravel `.env` for XAMPP MySQL
2. Create migrations + models + seed admin
3. Implement auth (user + admin) + middleware/guards
4. Implement requests CRUD + uploads + serving
5. Implement UI (Blade or React) and verify flows
6. Remove old NestJS backend when Laravel is feature-complete

## How you run the new Laravel app (dev)
From `laravel/`:
- `php artisan serve` (or configure Apache vhost in XAMPP)

