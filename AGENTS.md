# AGENTS.md — Laravel API Backend

## Project role

This repository is the backend API for the new admin platform.

- Laravel is backend-only.
- Vue lives in a separate frontend repository.
- Do not add Blade product pages, Vite frontend assets, Livewire, or Inertia here.
- API contracts are versioned under `/api/v1`.

## Stack boundary

- PHP: 8.4
- Framework: Laravel 13
- Database: MySQL
- Cache / queue / session: Redis
- Local infrastructure: `docker-compose.dev.yml`

## Routing boundary

Routes are grouped by client surface:

```text
routes/api.php          version shell and shared API middleware
routes/api/admin.php    admin console APIs under /api/v1/admin/*
routes/api/app.php      app/mobile APIs under /api/v1/app/*
```

Do not mix admin and app contracts in the same route file. If a behavior differs by client, create separate endpoints or separate Resources.

## Code architecture

Use this request flow:

```text
Route
  -> Controller
  -> FormRequest
  -> Action
  -> Service / Eloquent Model / Query
  -> API Resource
  -> JSON response
```

Layer rules:

- Controllers are thin HTTP adapters.
- FormRequest classes own input validation.
- Actions own one application use case.
- Services own shared domain logic and third-party integrations.
- Eloquent models own table mapping, casts, relationships, and focused scopes.
- Query classes are only for complex reusable reads.
- Jobs own slow or retryable work.
- Policies/Gates own authorization.

## API response contract

Use real HTTP status codes.

Success:

```json
{
  "data": {},
  "meta": {}
}
```

Error:

```json
{
  "message": "Human readable message.",
  "code": "MACHINE_READABLE_CODE",
  "trace_id": "request-id",
  "errors": {}
}
```

Do not reintroduce the old Webman `code/msg/data` envelope unless an explicit compatibility layer is requested.

## Performance stance

- Keep the API stateless.
- Push slow work to Redis queues.
- Use Scheduler for cron-like work.
- Add Horizon when queue visibility is needed.
- Consider Octane only after state leakage and long-running process safety are tested.
- Keep debug-only tooling out of production hot paths.

## Verification before completion

Before claiming backend work is complete, run the narrowest relevant commands:

```powershell
composer validate --strict
php artisan route:list --path=api
php artisan test
.\vendor\bin\pint.bat --test
```

For schema work, also run:

```powershell
php artisan migrate:status
```

