# Laravel Admin API Architecture

This project is a Laravel 13 backend API. It is not a Blade, Livewire, Inertia, or Vite application.

## Target stack

- Backend: Laravel 13, PHP 8.4
- Database: MySQL
- Cache / queue: Redis
- Frontend: independent Vue application
- API style: RESTful JSON over `/api/v1`

## Backend-only stance

Laravel owns only the backend API and backend workers. The Vue frontend lives in its own project and consumes versioned REST APIs.

Removed from the Laravel runtime:

- Blade product pages
- Vite frontend build
- Tailwind frontend entry
- Laravel Mix / laravel-vite-plugin style assets
- npm-based dev server orchestration

Kept in Laravel:

- RESTful API routes
- FormRequest validation
- API Resources
- Eloquent models
- Policies / Gates
- Jobs / queues
- Scheduler
- Redis cache/session/queue
- MySQL persistence

## API route groups

Different clients must not share a route pile. Routes are grouped by API version and client surface:

```text
/api/v1/health          shared platform health
/api/v1/admin/*         admin console APIs
/api/v1/app/*           app/mobile APIs
```

Route files follow the same split:

```text
routes/api.php          version shell and shared middleware
routes/api/admin.php    admin API surface
routes/api/app.php      app API surface
```

Each group can later own different middleware, rate limits, authentication guards, response resources, and service boundaries. Shared capabilities should live below the group only when the contract is truly identical.

## Internal request flow

```text
Route
  -> Controller
  -> FormRequest
  -> Action
  -> Service / Eloquent Model / Query
  -> API Resource
  -> JSON response
```

## Layer rules

- Controllers are HTTP adapters only.
- FormRequest classes own input validation.
- Actions own application use cases.
- Services own shared domain logic and integrations.
- Eloquent models own table mapping, casts, relationships, and focused scopes.
- Query classes are used only for complex reusable reads.
- Jobs own long-running or retryable work.
- Events and listeners decouple cross-domain side effects.

## API contract

Success responses use real HTTP status codes and this shape:

```json
{
  "data": {},
  "meta": {}
}
```

Error responses use real HTTP status codes and this shape:

```json
{
  "message": "Human readable message.",
  "code": "MACHINE_READABLE_CODE",
  "trace_id": "request-id",
  "errors": {}
}
```

Do not copy the old Webman `code/msg/data` envelope unless a specific compatibility layer is intentionally added.

## Performance stance

- Keep Laravel as a stateless API backend.
- Do not ship Blade, Livewire, or Inertia for the main admin product.
- Queue slow work through Redis queues.
- Use Horizon for queue visibility when Redis queue load becomes real.
- Use route/config cache in production.
- Consider Octane only after the API is clean and state leakage risks are tested.
- Keep Telescope and Pulse out of the hot production path unless explicitly enabled for observability.

## Service boundary direction

Start as a clean modular API backend. Extract services only around real boundaries:

- Identity: users, auth, roles, permissions, tenants.
- System: settings, uploads, notifications, audit logs.
- Payment: orders, transactions, wallet, reconciliation.
- AI: model calls, long jobs, streaming, cost tracking.
- Realtime: WebSocket / broadcasting.

Do not split by database table. Split by operational boundary.
