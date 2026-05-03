# Local Infrastructure

The API is designed for MySQL + Redis. The current `.env` may still use SQLite for quick local bootstrapping, but new development should move to the MySQL/Redis profile.

## Recommended local services

```powershell
docker compose -f docker-compose.dev.yml up -d
```

## `.env` profile

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=13306
DB_DATABASE=admin_laravel
DB_USERNAME=admin_laravel
DB_PASSWORD=secret

CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=16379
```

## Production notes

- Run PHP-FPM or Octane behind Nginx.
- Run queue workers under Supervisor.
- Run the Laravel scheduler as one cron entry.
- Keep Redis separate from MySQL.
- Never expose the project root; expose only `public/`.
