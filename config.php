<?php

/**
 * Configuracion de conexion a la base de datos.
 * Editar estos valores segun el entorno donde se instale el sistema.
 *
 * Valores por defecto asumidos en una instalacion XAMPP estandar:
 *   - Host:      localhost
 *   - Usuario:   root
 *   - Password:  (vacio)
 *   - Base:      pos
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'pos');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Clave y metodo utilizados para cifrar campos sensibles (ej. contrasenas
 * que se almacenan con cifrado simetrico ademas del hash bcrypt).
 * Cambiar CLAVE_CIFRADO en cada instalacion para mayor seguridad.
 */
define('CLAVE_CIFRADO', 'posClaveMaestra2026Segura!');
define('METODO_CIFRADO', 'aes-256-cbc');
