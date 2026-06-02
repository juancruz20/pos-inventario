<?php

/**
 * Configuracion del sistema POS.
 *
 * DB_HOST usa 127.0.0.1 en vez de "localhost" para que el cliente
 * MySQL use TCP en todas las plataformas (en Linux/Mac "localhost"
 * intenta usar socket, lo que falla en algunas instalaciones).
 *
 * Para otra PC, editar estos valores segun el entorno:
 *   - XAMPP estandar:   localhost / root / (vacio) / pos
 *   - Hosting gratuito: cambiar host, usuario, password y nombre de BD
 */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'pos');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Clave y metodo para cifrado simetrico de campos sensibles.
 * Cambiar CLAVE_CIFRADO en cada instalacion para mayor seguridad.
 */
define('CLAVE_CIFRADO', 'posClaveMaestra2026Segura!');
define('METODO_CIFRADO', 'aes-256-cbc');

/**
 * Mostrar errores en pantalla solo si DEBUG esta activado.
 * Una vez el sistema este en produccion, dejar DEBUG en false.
 */
define('DEBUG', false);
