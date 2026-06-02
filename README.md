# POS Inventario

Sistema POS/Inventario con AdminLTE, PHP y MySQL.

## Requisitos

- PHP 7.4+
- MySQL 5.7+
- Servidor web (Apache, Nginx)

## Instalación local (XAMPP)

1. Clonar el repositorio:
   ```
   git clone https://github.com/juancruz20/pos-inventario.git
   ```

2. Mover la carpeta a `C:\xampp\htdocs\pos\`

3. Importar la base de datos:
   - Abrir phpMyAdmin: `http://localhost/phpmyadmin`
   - Click en la pestaña **Importar**
   - Seleccionar el archivo `pos.sql` (incluido en el proyecto)
   - Click en **Continuar**
   - El script crea automáticamente la base `pos`, todas las tablas, índices y datos iniciales

4. (Opcional) Configurar conexión: editar `config.php` con los datos de tu base de datos. Por defecto usa `root` sin contraseña en `localhost`.

5. Acceder: `http://localhost/pos`

> Ver `INSTALAR.txt` para instrucciones detalladas.

## Despliegue en InfinityFree

1. Crear cuenta en https://app.infinityfree.com/
2. Crear un nuevo hosting
3. Subir todos los archivos por FTP
4. En el panel de control, crear una base de datos MySQL
5. Importar `pos.sql` en la base de datos
6. Editar `config.php` con los datos de conexión de InfinityFree
7. La URL será: `https://tu-sitio.infinityfreeapp.com`

## Usuarios por defecto

- Administrador: `admin` / `admin`
- Vendedor: `vendedor` / `vendedor`

## Tecnologías

- AdminLTE 2.x
- Bootstrap 3
- PHP PDO
- MySQL
- jQuery
- DataTables
- Morris.js
