
# MINI-RETOS-PHP

Proyecto práctico de aprendizaje y experimentación con PHP, MySQL, PDO y JavaScript.

El objetivo es desarrollar pequeños ejercicios que permitan comprender progresivamente cómo funciona el desarrollo web del lado del servidor y cómo se comunica con el navegador.

## Tecnologías utilizadas

- **PHP:** procesamiento de solicitudes HTTP y lógica del servidor.
- **MySQL:** almacenamiento y gestión de datos.
- **PDO:** conexión con la base de datos y ejecución de consultas SQL.
- **HTML5:** estructura de la aplicación.
- **CSS3 / Bootstrap 5:** presentación e interfaz.
- **JavaScript:** manipulación del DOM y gestión de eventos.
- **Fetch API:** comunicación asíncrona entre navegador y servidor.
- **JSON:** intercambio de información entre PHP y JavaScript.
- **Git / GitHub:** control de versiones.

## Proyecto actual: CRUD de ideas

Aplicación web que permite gestionar una colección de ideas mediante las operaciones CRUD:

| Operación | Descripción |
|---|---|
| CREATE | Registrar nuevas ideas. |
| READ | Consultar las ideas almacenadas. |
| UPDATE | Modificar ideas existentes. |
| DELETE | Eliminar ideas. |

### Versiones del proyecto

**`main` — CRUD tradicional**

Primera implementación utilizando formularios HTML, solicitudes POST, procesamiento PHP, PDO y redirecciones.

**`crud-fetch` — CRUD asíncrono**

Evolución de la aplicación para incorporar JavaScript y Fetch API, permitiendo enviar solicitudes a PHP y actualizar el DOM sin recargar la página.

Esta versión se encuentra actualmente en desarrollo.

## Estructura del proyecto

```text
MINI-RETOS-PHP/
│
├── db.php
├── index.php
├── guardar.php
├── modificar.php
├── eliminar.php
├── script.js
└── README.md
```

## Configuración del entorno

Proyecto desarrollado utilizando XAMPP.

Configuración local utilizada:

- Apache: puerto `80`.
- MySQL: puerto `3308`.
- Base de datos: `php_pruebas`.

### Crear la base de datos

```sql
CREATE DATABASE php_pruebas;
```

### Crear la tabla

```sql
USE php_pruebas;

CREATE TABLE ideas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    texto VARCHAR(255) NOT NULL UNIQUE
);
```

### Conexión PDO

La conexión se configura en `db.php`.

```php
$dsn = "mysql:host=localhost;port=3308;dbname=php_pruebas";
$user = "root";
$pass = "";
```

Estos parámetros corresponden al entorno local de desarrollo y pueden necesitar modificaciones en otros equipos.

## Objetivos de aprendizaje

- Comprender el ciclo de vida de una solicitud HTTP.
- Diferenciar los métodos GET y POST.
- Aprender a trabajar con sesiones en PHP.
- Utilizar PDO y consultas preparadas.
- Implementar operaciones CRUD.
- Comprender la comunicación entre PHP y MySQL.
- Manipular elementos del DOM mediante JavaScript.
- Gestionar eventos y formularios.
- Utilizar Fetch API para realizar solicitudes asíncronas.
- Intercambiar información mediante JSON.
- Aplicar buenas prácticas de validación y seguridad, incluyendo la prevención de SQL Injection y XSS.

## Estado del proyecto

- [x] CRUD tradicional con PHP y PDO.
- [x] Validación básica de datos.
- [x] Consultas preparadas.
- [x] Gestión de respuestas mediante JSON para inserción y modificación.
- [x] Primera integración de Fetch API para insertar ideas.
- [ ] Finalizar representación dinámica de las filas.
- [ ] Implementar modificación asíncrona.
- [ ] Implementar eliminación asíncrona.
- [ ] Completar validaciones y gestión de errores.
- [ ] Finalizar el CRUD completamente asíncrono.

---

Proyecto personal de aprendizaje. Cada funcionalidad se desarrolla progresivamente para comprender su funcionamiento antes de avanzar a la siguiente.
