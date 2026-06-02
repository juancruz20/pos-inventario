# POS Inventario

Sistema POS/Inventario con AdminLTE, PHP y MySQL.

## Instalacion rapida (XAMPP)

1. Clonar el repositorio:
   ```
   git clone https://github.com/juancruz20/pos-inventario.git
   ```

2. Mover la carpeta a `C:\xampp\htdocs\pos\`

3. Iniciar XAMPP (Apache + MySQL)

4. **Opcion automatica:** abrir `http://localhost/pos/install.php` y hacer click en "Instalar base de datos"

   **Opcion manual:** importar `pos.sql` desde phpMyAdmin (pestaña Importar)

5. Acceder al sistema: `http://localhost/pos`

> Ver `INSTALAR.txt` para instrucciones detalladas.

## Despliegue en hosting

1. Subir todos los archivos por FTP al hosting
2. Crear una base de datos MySQL en el panel del hosting
3. Importar `pos.sql` o usar el instalador
4. Editar `config.php` con los datos de conexion del hosting
5. Acceder al sistema

## Usuarios por defecto

- Administrador: `admin` / `admin`
- Vendedor: `vendedor` / `vendedor`

## Configuracion

Editar `config.php` para ajustar la conexion a la base de datos:

```php
define('DB_HOST', '127.0.0.1');   // o el host del hosting
define('DB_PORT', '3306');
define('DB_NAME', 'pos');
define('DB_USER', 'root');
define('DB_PASS', '');
```

`DEBUG` controla si se muestran errores PHP en pantalla (false en produccion).

## Requisitos PHP

- PHP 7.4 o superior
- Extensiones: `pdo_mysql`, `openssl`, `gd`
- (Todas vienen habilitadas por defecto en XAMPP)

## Estructura

```
ajax/            Endpoints AJAX (DataTables, CRUD, stock)
controladores/   Logica de negocio (MVC)
extensiones/     TCPDF (PDF) y dependencias Composer
helpers/         Funciones auxiliares
modelos/         Acceso a datos (MVC)
vistas/          UI: plantilla, modulos, plugins, dist
config.php       Configuracion general
install.php      Instalador automatico
pos.sql          Base de datos portable
```

## Tecnologias

- AdminLTE 2.x
- Bootstrap 3
- PHP PDO
- MySQL / MariaDB
- jQuery
- DataTables
- Morris.js
- TCPDF
- mike42/escpos-php
