# README - Prueba Técnica de Desarrollo Web Completa

## Descripción del Proyecto

Aplicación web para la gestión y visualización de piezas registradas en Minucia. Permite la autenticación de usuarios, registro de piezas con selects anidados (proyecto → bloque → pieza), actualización de datos y generación de reportes visuales. Backend con Laravel 10, frontend con Vue 3 usando Inertia.js para la integración.

---

## Usuarios y contraseñas

-   Martin@gmail.com 12345678
-   Ejemplo@gmail.com 12345678
-   Gabriel@gmail.com 12345678
-   Luis@gmail.com 12345678
-   Sergio@gmail.com 12345678

## Tecnologías Utilizadas

-   **Backend:** Laravel 10, Eloquent ORM
-   **Frontend:** Vue.js 3 (Composition API)
-   **Base de Datos:** SQLite
-   **Autenticación:** Laravel Sanctum
-   **Estilos:** Tailwind CSS
-   **Notificaciones:** Vue Toastification
-   **Rutas:** Inertia.js

---

## Estructura del Proyecto

-   **app/Models:** Modelos de base de datos (Project, Block, Piece, User)
-   **app/Http/Controllers:** Controladores para manejar la lógica de negocio
-   **database/migrations:** Migraciones para estructura BD
-   **resources/js/Components:** Componentes Vue reutilizables
-   **routes/web.php:** Definición de rutas y middleware

---

## Configuración del Proyecto

### Requisitos Previos

-   PHP 8.1+
-   Composer
-   Node.js y npm
-   SQLite

### Instalación paso a paso

```bash
# Clonar repositorio
git clone [https://github.com/Martin10123/prueba-tecnica-2025---cotecmar.git]
cd [PRUEBA-TECNICA-COTECMAR]

# Instalar dependencias PHP y JS
composer install
npm install

# Configurar entorno
cp .env.example .env
# Editar .env para configurar DB_CONNECTION=sqlite
# y DB_DATABASE con ruta absoluta a database.sqlite

# Crear archivo base de datos SQLite
touch database/database.sqlite

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Construir assets
npm run build

# Iniciar servidor de desarrollo
php artisan serve
```
