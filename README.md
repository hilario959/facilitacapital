# Facilita Capital

Sitio de Facilita Capital en Laravel. El contenido público (textos, colores e imágenes) se edita desde el administrador, y las solicitudes de la calculadora entran a un tablero kanban.

## Requisitos

- PHP 8.3+
- Composer
- MySQL en DBngin (`127.0.0.1:3306`, usuario `root`, sin contraseña)

## Arranque local

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Crea la base `facilitacapital` en DBngin, define `ADMIN_PASSWORD` en `.env` y luego:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

- Sitio: http://localhost:8000
- Administrador: http://localhost:8000/admin

El usuario administrador sale de `ADMIN_EMAIL` y `ADMIN_PASSWORD`.

## Correo

En local el correo de confirmación queda en `storage/logs/laravel.log` (`MAIL_MAILER=log`). Para enviarlo de verdad, configura SMTP en `.env` (`MAIL_MAILER=smtp`, host, puerto, usuario y contraseña) y `MAIL_FROM_ADDRESS`.
