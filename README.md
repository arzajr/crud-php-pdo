# Mini Retos PHP

Mini proyecto desarrollado para practicar los fundamentos de PHP, HTTP, MySQL y PDO mediante la creación de un CRUD completo.

El proyecto permite crear, consultar, modificar y eliminar ideas almacenadas en una base de datos MySQL.

---

## Tecnologías utilizadas

- PHP
- Apache
- MySQL
- PDO
- HTML5
- CSS
- Bootstrap 5

---

## Entorno

El proyecto está desarrollado utilizando XAMPP.

Configuración utilizada:

- Apache: puerto `80`
- MySQL: puerto `3308`
- Host MySQL: `localhost`
- Usuario: `root`
- Contraseña: vacía
- Base de datos: `php_pruebas`

---

## Instalación

### 1. Requisitos

Es necesario tener instalado:

- XAMPP
- PHP
- Apache
- MySQL

### 2. Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
```

Copiar el proyecto dentro de:

```text
xampp/htdocs/
```

### 3. Configurar MySQL

Iniciar Apache y MySQL desde XAMPP.

El servidor MySQL utiliza el puerto `3308`.

Ejecutar el archivo `database.sql` desde phpMyAdmin o desde MySQL.

Este archivo crea la base de datos y la tabla necesarias para el proyecto.

### 4. Configurar la conexión

La conexión se encuentra en `db.php`.

```php
$dsn = "mysql:host=localhost;port=3308;dbname=php_pruebas";
$user = 'root';
$pass = '';
```

### 5. Acceder al proyecto

Con Apache iniciado:

```text
http://localhost/mini-retos-php/
```

---

# Funcionamiento del proyecto

El proyecto implementa un CRUD:

| Operación | SQL | Archivo |
|---|---|---|
| Crear | `INSERT` | `guardar.php` |
| Leer | `SELECT` | `index.php` |
| Modificar | `UPDATE` | `modificar.php` |
| Eliminar | `DELETE` | `eliminar.php` |

La información se almacena en MySQL y PHP utiliza PDO para comunicarse con la base de datos.

---

# Flujo de una petición HTTP

Cuando el usuario interactúa con el formulario, se produce un flujo similar a:

```text
Navegador
    ↓
Petición HTTP
    ↓
Apache
    ↓
PHP
    ↓
PDO
    ↓
MySQL
    ↓
PDO
    ↓
PHP
    ↓
Respuesta HTTP
    ↓
Navegador
```

El navegador envía una petición HTTP al servidor.

Apache recibe la petición y ejecuta el código PHP correspondiente.

PHP procesa los datos y, cuando necesita consultar o modificar información, utiliza PDO para comunicarse con MySQL.

MySQL ejecuta la consulta y devuelve el resultado a PHP.

PHP genera la respuesta, normalmente HTML, y Apache la devuelve al navegador.

El navegador recibe la respuesta y construye el DOM.

---

# GET y POST

HTTP permite utilizar diferentes métodos para indicar qué tipo de operación se quiere realizar.

## GET

Se utiliza principalmente para solicitar información.

Los parámetros pueden formar parte de la URL y PHP puede acceder a ellos mediante:

```php
$_GET
```

## POST

Se utiliza para enviar datos al servidor, por ejemplo los datos introducidos en un formulario.

PHP puede acceder a ellos mediante:

```php
$_POST
```

En este proyecto los formularios CRUD utilizan `POST` para enviar datos al servidor.

---

# PDO

PDO (`PHP Data Objects`) proporciona una interfaz para trabajar con bases de datos desde PHP.

La conexión se realiza mediante:

```php
$pdo = new PDO($dsn, $user, $pass);
```

El resultado es un objeto PDO que permite ejecutar consultas contra MySQL.

## `query()`

Permite ejecutar directamente una consulta SQL completa:

```php
$ideas = $pdo->query("SELECT * FROM ideas");
```

## `prepare()`

Permite preparar una consulta utilizando parámetros:

```php
$stmt = $pdo->prepare(
    "INSERT INTO ideas(texto) VALUES (:texto)"
);
```

Después se proporcionan los valores:

```php
$stmt->execute([
    'texto' => $texto
]);
```

Utilizar consultas preparadas permite separar la estructura SQL de los valores recibidos y ayuda a prevenir SQL Injection.

---

# Obtener resultados

PDO proporciona diferentes métodos para recuperar los resultados.

## `fetch()`

Obtiene una única fila:

```php
$idea = $stmt->fetch(PDO::FETCH_ASSOC);
```

Si no encuentra ninguna fila, devuelve `false`.

## `fetchAll()`

Obtiene todas las filas:

```php
$ideas = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

Si no existen resultados, devuelve un array vacío.

`PDO::FETCH_ASSOC` hace que cada fila se obtenga como un array asociativo:

```php
[
    'id' => 1,
    'texto' => 'Aprender PHP'
]
```

---

# CRUD

El CRUD representa las cuatro operaciones básicas sobre los datos:

```text
CREATE → INSERT
READ   → SELECT
UPDATE → UPDATE
DELETE → DELETE
```

## CREATE

`guardar.php` recibe el texto mediante `POST`, lo valida y ejecuta un `INSERT`.

## READ

`index.php` ejecuta un `SELECT` y muestra las ideas almacenadas.

## UPDATE

`modificar.php` recibe el `id` y el nuevo texto y ejecuta un `UPDATE`.

El `id` identifica exactamente qué fila debe modificarse.

## DELETE

`eliminar.php` recibe el `id` y ejecuta un `DELETE`.

El `WHERE id = :id` evita eliminar todas las filas de la tabla.

---

# Validación de datos

La validación se realiza en el servidor.

Aunque el HTML pueda utilizar atributos como `required`, el servidor no debe confiar en la validación del navegador.

Por ejemplo:

```php
$texto = trim($_POST['texto']);
```

`trim()` elimina espacios al principio y al final del texto.

Después se puede comprobar si está vacío:

```php
if ($texto === '') {
    // Error
}
```

También se utiliza:

```php
isset($_POST['texto'])
```

para comprobar que el campo existe en la petición.

---

# Prevención de duplicados

El proyecto comprueba si ya existe una idea con el mismo texto antes de insertarla.

Para ello se utiliza una consulta `SELECT` y posteriormente:

```php
fetch()
```

Si existe una fila, se considera que la idea está duplicada.

Además, la columna `texto` tiene una restricción `UNIQUE` en MySQL:

```sql
texto VARCHAR(255) NOT NULL UNIQUE
```

Esto proporciona una segunda capa de protección directamente en la base de datos.

---

# Seguridad

## SQL Injection

Las consultas que reciben datos del usuario utilizan consultas preparadas:

```php
$stmt = $pdo->prepare(
    "UPDATE ideas SET texto = :texto WHERE id = :id"
);
```

Los valores se proporcionan posteriormente mediante:

```php
$stmt->execute([
    'texto' => $texto,
    'id' => $id
]);
```

Esto evita introducir directamente los datos del usuario dentro de la consulta SQL.

## XSS

Los datos almacenados en la base de datos deben escaparse antes de mostrarse en HTML.

Se utiliza:

```php
htmlspecialchars(
    $idea['texto'],
    ENT_QUOTES,
    'UTF-8'
)
```

De esta forma, un texto como:

```html
<script>alert('XSS')</script>
```

se muestra como texto en lugar de ejecutarse como JavaScript.

La protección se realiza al mostrar los datos, no al almacenarlos.

---

# Sesiones

PHP permite conservar información entre diferentes peticiones HTTP mediante sesiones.

Para iniciar o recuperar una sesión:

```php
session_start();
```

Los datos se almacenan en:

```php
$_SESSION
```

En este proyecto se utilizan para implementar mensajes temporales después de realizar una operación.

Por ejemplo:

```php
$_SESSION['mensaje'] = [
    'tipo' => 'success',
    'texto' => 'Idea guardada correctamente'
];
```

Después se realiza una redirección.

`index.php` recupera el mensaje, lo muestra y finalmente lo elimina:

```php
unset($_SESSION['mensaje']);
```

El flujo es:

```text
guardar.php
    ↓
Guardar mensaje en $_SESSION
    ↓
Redirección
    ↓
index.php
    ↓
Mostrar mensaje
    ↓
unset()
```

---

# Excepciones y errores

PDO se configura para lanzar excepciones cuando se produce un error:

```php
$pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);
```

Las operaciones que pueden producir errores se pueden controlar mediante:

```php
try {
    // Código que puede producir una excepción
} catch (PDOException $e) {
    // Gestión del error
}
```

En caso de error, el mensaje técnico puede registrarse mediante:

```php
error_log($e->getMessage());
```

El usuario recibe un mensaje genérico en lugar de mostrarle información interna de la aplicación o de la base de datos.

---

# Redirecciones HTTP

Después de procesar una operación `POST`, el proyecto utiliza:

```php
header('Location: index.php');
exit();
```

`header()` establece una cabecera HTTP indicando al navegador que debe realizar una nueva petición hacia `index.php`.

`exit()` detiene la ejecución del script PHP.

Por tanto, una redirección no significa simplemente que PHP empiece a ejecutar `index.php` en la misma petición.

El flujo es:

```text
POST /guardar.php
        ↓
guardar.php procesa los datos
        ↓
INSERT
        ↓
Respuesta HTTP de redirección
        ↓
Navegador realiza un nuevo GET
        ↓
GET /index.php
        ↓
SELECT
        ↓
HTML
```

Este patrón se conoce como **Post/Redirect/Get (PRG)**.

Una de sus ventajas es evitar que al actualizar la página el navegador vuelva a enviar el formulario mediante `POST`.

---

# Arquitectura actual

Actualmente el proyecto sigue una arquitectura sencilla basada en PHP en el servidor:

```text
                  Navegador
                     │
                     │ HTTP
                     ▼
                  Apache
                     │
                     ▼
                    PHP
                     │
                     │ PDO
                     ▼
                   MySQL
                     │
                     ▼
                    PHP
                     │
                     ▼
             Respuesta HTTP
                     │
                     ▼
                  Navegador
```

Cada acción del CRUD tiene su propio archivo PHP:

```text
index.php       → consultar y mostrar
guardar.php     → crear
modificar.php   → actualizar
eliminar.php    → eliminar
db.php          → conexión con MySQL
```

---

# Próximos pasos

Una vez consolidado el CRUD con PHP y PDO, el siguiente paso del proyecto será incorporar JavaScript y estudiar `fetch()`.

El objetivo será pasar progresivamente de un flujo basado en redirecciones:

```text
Formulario
    ↓
PHP
    ↓
Redirección
    ↓
HTML
```

a un flujo asíncrono:

```text
Formulario
    ↓
JavaScript
    ↓
fetch()
    ↓
PHP
    ↓
PDO
    ↓
MySQL
    ↓
Respuesta
    ↓
JavaScript
    ↓
DOM
```
