# Estructura del Proyecto
Si hay cualquier problema con el env esta este de respaldo .envexample

## Versiones utilizadas:
- **Laravel Framework**: 12.14.1
- **Composer**: 2.8.9 (2025-05-13 14:01:37)
- **PHP**: 8.2.12 (`C:\xampp\php\php.exe`)
- **XAMPP**: xampp-windows-x64-8.2.12-0-VS16-installer
- **laravel/sanctum**: v4.1.1

## Pasos de configuración:

- Instalar dependencias con Composer
   composer install

- Activar MySQL y Apache en XAMPP
    Abre el XAMPP Control Panel.
    Inicia Apache y MySQL.

- Crear base de datos en phpMyAdmin
    Accede a http://localhost/phpmyadmin.
    Crea una base de datos con el siguiente nombre:
    DB_DATABASE=fitrack

- Ejecutar migraciones con datos de prueba
    php artisan migrate:refresh --seed

- Realizar Docuemmtacion
    php artisan l5-swagger:generate

- Iniciar el servidor de desarrollo
    php artisan serve

## Carpetas improtantes
- database : migrations ,seeders
- routes : api.php ,web.php
- app :Models , Http (Controllers,Requests)