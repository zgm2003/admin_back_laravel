# Backend-only Laravel Runtime

This repository is a Laravel backend API. It intentionally does not contain the admin Vue application.

## Local development

Start infrastructure:

```powershell
docker compose -f docker-compose.dev.yml up -d
```

Run migrations:

```powershell
php artisan migrate
```

Start the API:

```powershell
composer run dev
```

Optional workers:

```powershell
composer run queue
composer run schedule
```

## API surfaces

```text
GET /api/v1/health
GET /api/v1/admin/health
GET /api/v1/app/health
```

Future business routes must live under one of the client surfaces:

```text
/api/v1/admin/*
/api/v1/app/*
```

Do not add product pages, Blade templates, Vite entrypoints, or npm frontend scripts to this backend repository.
