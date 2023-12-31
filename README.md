# Radiocúbito Monitor

Radiocúbito Monitor es una web app para el monitoreo de sitios web.
Permite realizar monitoreos en intervalos de segundos, minutos u horas.
Y envía notificaciones por email cuando un sitio se reporta caído.

## Instalación

### Requisitos

- Un servidor con PHP versión 8.1 o superior y Node.js versión 16 o superior
- Una base de datos

### Obtener el código fuente e instalar las dependencias

```bash
git clone https://github.com/radiocubito/monitor.git
cd monitor
composer install --no-dev
npm install
```

### Configuración

A continuación, tendrás que crear una base de datos y proporcionar las credenciales dentro del archivo `.env`. Consulta la [documentación de Laravel](https://laravel.com/docs/10.x/database#configuration) para obtener más información sobre cómo hacerlo. Puedes copiar el archivo `.env.example` para empezar y generar una clave para la aplicación:

```bash
cp .env.example .env
php artisan key:generate --force
```

Además, en el archivo `.env`, establece el controlador de queue a `database`.

### Compilación de assets y migraciones

Después de eso, todo está listo para compilar los assets y ejecutar las migraciones.

```bash
npm run build
php artisan migrate
```

### Arrancar la aplicación

Ejecutar el _queue worker_.

```bash
php artisan queue:work
```

Iniciar el _short scheduler_.

```bash
php artisan short-schedule:run
```

Por último, puedes iniciar el servidor de desarrollo cuando sea necesario.

```bash
php artisan serve
```
