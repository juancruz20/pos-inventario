<?php
/**
 * Instalador automatico del sistema POS.
 *
 * USO:
 *   1. Colocar la carpeta pos/ dentro de C:\xampp\htdocs\
 *   2. Abrir en el navegador: http://localhost/pos/install.php
 *   3. Click en "Instalar base de datos"
 *   4. (Opcional) Borrar este archivo despues de instalar
 *
 * Tambien funciona desde CLI:
 *   php install.php --auto
 */

if(php_sapi_name() === 'cli' && !isset($_SERVER['HTTP_HOST'])){
    if(in_array('--auto', $argv ?? [], true)){
        $_POST['instalar'] = '1';
        $_POST['auto'] = '1';
    }
}

require_once __DIR__ . "/config.php";

$mensaje = '';
$estado = '';
$auto = !empty($_POST['auto']);

if(isset($_POST['instalar'])){

    $errores = [];

    if(!extension_loaded('pdo_mysql')){
        $errores[] = 'La extension PDO MySQL no esta habilitada en PHP.';
    }
    if(!extension_loaded('openssl')){
        $errores[] = 'La extension OpenSSL no esta habilitada en PHP.';
    }
    if(!extension_loaded('gd')){
        $errores[] = 'La extension GD no esta habilitada en PHP (necesaria para imagenes).';
    }

    if(empty($errores)){
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8";
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            $sql = file_get_contents(__DIR__ . "/pos.sql");
            if($sql === false){
                throw new Exception("No se pudo leer el archivo pos.sql");
            }

            $sqlLimpio = preg_replace('/^\s*--.*$/m', '', $sql);
            $sqlLimpio = preg_replace('/\/\*!.*?\*\//s', '', $sqlLimpio);

            $sentencias = array_filter(array_map('trim', explode(';', $sqlLimpio)));
            foreach($sentencias as $sentencia){
                if($sentencia === '') continue;
                $pdo->exec($sentencia);
            }

            try {
                $pdo->exec("USE `" . DB_NAME . "`");
            } catch (Exception $e) {
            }

            file_put_contents(__DIR__ . "/vistas/img/productos/.gitkeep", "");
            file_put_contents(__DIR__ . "/vistas/img/usuarios/.gitkeep", "");

            $estado = 'ok';
            $mensaje = "Base de datos instalada correctamente.\n\n"
                     . "Credenciales por defecto:\n"
                     . "  Administrador: admin / admin\n"
                     . "  Vendedor:      vendedor / vendedor\n\n"
                     . "Abre http://localhost/pos para entrar al sistema.";

        } catch (Exception $e) {
            $estado = 'error';
            $mensaje = "Error: " . $e->getMessage();
        }
    } else {
        $estado = 'error';
        $mensaje = implode("\n", $errores);
    }
}

if($auto){
    echo $estado . "\n" . $mensaje . "\n";
    exit($estado === 'ok' ? 0 : 1);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Instalador POS Inventario</title>
<style>
  body{font-family:'Segoe UI',Arial,sans-serif;background:#f4f6f9;color:#333;max-width:680px;margin:50px auto;padding:0 20px}
  h1{color:#1e3a5f;border-bottom:3px solid #3c8dbc;padding-bottom:10px}
  .card{background:#fff;border-radius:6px;box-shadow:0 2px 4px rgba(0,0,0,.1);padding:30px;margin-top:20px}
  .ok{color:#0f7e2d;background:#e6f7eb;border-left:4px solid #0f7e2d;padding:15px;border-radius:4px;white-space:pre-line}
  .err{color:#a02020;background:#fdeaea;border-left:4px solid #a02020;padding:15px;border-radius:4px;white-space:pre-line}
  .info{background:#eaf3fb;border-left:4px solid #3c8dbc;padding:15px;border-radius:4px;margin-bottom:20px;font-size:14px}
  .info code{background:#d6e6f3;padding:2px 6px;border-radius:3px;font-size:13px}
  .btn{display:inline-block;background:#3c8dbc;color:#fff;border:none;padding:12px 28px;font-size:15px;border-radius:4px;cursor:pointer;text-decoration:none}
  .btn:hover{background:#2a6a96}
  table{width:100%;border-collapse:collapse;margin-top:15px;font-size:14px}
  td{padding:6px 10px;border-bottom:1px solid #eee}
  td:first-child{font-weight:bold;color:#555;width:40%}
  .ok-row{color:#0f7e2d}
  .err-row{color:#a02020}
  a.link{color:#3c8dbc}
</style>
</head>
<body>
<h1>Instalador POS Inventario</h1>

<?php if($estado === 'ok'): ?>

  <div class="card">
    <div class="ok"><?= htmlspecialchars($mensaje) ?></div>
    <p style="margin-top:25px">
      <a class="btn" href="index.php">Entrar al sistema</a>
    </p>
    <p style="margin-top:30px;font-size:13px;color:#888">
      <strong>Importante:</strong> por seguridad, elimina el archivo <code>install.php</code> ahora que la instalacion esta completa.
    </p>
  </div>

<?php else: ?>

  <div class="card">
    <div class="info">
      <strong>Configuracion actual en <code>config.php</code>:</strong>
      <table>
        <tr><td>Host</td><td><?= htmlspecialchars(DB_HOST) ?>:<?= htmlspecialchars(DB_PORT) ?></td></tr>
        <tr><td>Base de datos</td><td><?= htmlspecialchars(DB_NAME) ?></td></tr>
        <tr><td>Usuario</td><td><?= htmlspecialchars(DB_USER) ?></td></tr>
        <tr><td>Contraseña</td><td><?= DB_PASS === '' ? '(vacio)' : '********' ?></td></tr>
      </table>
    </div>

    <p>Este instalador va a:</p>
    <ul>
      <li>Crear la base de datos <code><?= htmlspecialchars(DB_NAME) ?></code></li>
      <li>Importar todas las tablas, indices y datos iniciales desde <code>pos.sql</code></li>
      <li>Dejar el sistema listo para usar</li>
    </ul>

    <p style="color:#a02020"><strong>Atencion:</strong> si la base de datos ya existe, sera borrada y reemplazada por una instalacion limpia.</p>

    <form method="post" style="margin-top:25px">
      <button class="btn" type="submit" name="instalar" value="1">Instalar base de datos</button>
    </form>

    <?php if($estado === 'error'): ?>
      <div class="err" style="margin-top:25px"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

  </div>

<?php endif; ?>

</body>
</html>
