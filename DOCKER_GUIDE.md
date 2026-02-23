# 🐳 Laravel Dockerization Guide (No Local PHP/Composer)

This guide explains how to set up a Laravel project using Docker when you don't have PHP or Composer installed on your host machine.

## 📁 Recommended Structure
```text
.
├── Dockerfile              # PHP-FPM configuration
├── docker-compose.yml      # Orchestration of all services
├── nginx/
│   └── default.conf        # Nginx configuration
└── src/                    # Your Laravel source code
```

---

## 🛠 1. Create the Docker Configuration

### Dockerfile
Create a `Dockerfile` to build your PHP environment:
```dockerfile
FROM php:8.4-fpm-alpine

# Install system packages
RUN apk add --no-cache \
    bash git unzip libpq-dev oniguruma-dev icu-dev curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql intl

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Set permissions
RUN mkdir -p storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

CMD ["php-fpm"]
```

### Nginx Config
Create `nginx/default.conf`:
```nginx
server {
    listen 80;
    index index.php index.html;
    root /var/www/html/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

---

## 🚀 2. Initialize a New Project

If you are starting from scratch and have no files in `src/`:

1.  **Build the application image**:
    ```bash
    docker compose build app
    ```

2.  **Create the Laravel project**:
    ```bash
    docker compose run --rm app composer create-project laravel/laravel .
    ```

3.  **Correct Permissions** (if needed):
    ```bash
    sudo chown -R $USER:$USER src/
    ```

---

## ⚡ 3. Running the Environment

1.  **Start all services**:
    ```bash
    docker compose up -d
    ```

2.  **Verify status**:
    ```bash
    docker compose ps
    ```

---

## 🏗 4. Common Laravel Commands via Docker

Since you don't have PHP locally, everything must run through `docker compose exec`:

| Action | Command |
| :--- | :--- |
| **Run Migrations** | `docker compose exec app php artisan migrate` |
| **Rollback Migrations** | `docker compose exec app php artisan migrate:rollback` |
| **Install Package** | `docker compose exec app composer require <package>` |
| **Generate Key** | `docker compose exec app php artisan key:generate` |
| **Run Tests** | `docker compose exec app php artisan test` |
| **Clear Cache** | `docker compose exec app php artisan optimize:clear` |

---

## 🗄 5. Database & Tools

-   **App URL**: `http://localhost:3535` (Check your `docker-compose.yml` for port mapping)
-   **PgAdmin**: `http://localhost:5050`
-   **Inside .env**:
    -   `DB_HOST=postgres`
    -   `DB_PORT=5432`
    -   `DB_DATABASE=my_db`
    -   `DB_USERNAME=reddcs`
    -   `DB_PASSWORD=reddcs`
