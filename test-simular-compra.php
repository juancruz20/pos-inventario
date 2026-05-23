<?php
/**
 * TEST: Simular compra completa
 * Detecta errores en el flujo de crear-venta
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "=== TEST: SIMULAR COMPRA ===\n\n";

// 1. Iniciar sesion como admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["iniciarSesion"] = "ok";
$_SESSION["id"] = 1;
$_SESSION["nombre"] = "Administrador";
$_SESSION["usuario"] = "admin";
$_SESSION["perfil"] = "Administrador";
$_SESSION["foto"] = "";

echo "[OK] Sesion iniciada como Admin (id=1)\n";

// 2. Incluir archivos del sistema
$base = __DIR__;
require_once "$base/controladores/plantilla.controlador.php";
require_once "$base/controladores/usuarios.controlador.php";
require_once "$base/controladores/categorias.controlador.php";
require_once "$base/controladores/productos.controlador.php";
require_once "$base/controladores/clientes.controlador.php";
require_once "$base/controladores/ventas.controlador.php";
require_once "$base/modelos/usuarios.modelo.php";
require_once "$base/modelos/categorias.modelo.php";
require_once "$base/modelos/productos.modelo.php";
require_once "$base/modelos/clientes.modelo.php";
require_once "$base/modelos/ventas.modelo.php";

echo "[OK] Archivos del sistema cargados\n";

// 3. Verificar conexion DB
try {
    $db = Conexion::conectar();
    echo "[OK] Conexion DB establecida\n";
} catch (Exception $e) {
    echo "[ERROR] Conexion DB: " . $e->getMessage() . "\n";
    exit(1);
}

// 4. Verificar productos disponibles
$productos = [
    61 => ['desc' => 'Pañales Niños', 'precio' => 17, 'stock_actual' => 0],
    65 => ['desc' => 'babysec', 'precio' => 1.4, 'stock_actual' => 0],
    67 => ['desc' => 'Gorros de lana', 'precio' => 5000, 'stock_actual' => 0],
];
foreach ($productos as $id => &$info) {
    $stmt = $db->prepare("SELECT stock, precio_venta FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $info['stock_actual'] = $row['stock'];
        $info['precio'] = $row['precio_venta'];
        echo "[OK] Producto id=$id '{$info['desc']}': stock={$row['stock']}, precio={$row['precio_venta']}\n";
    } else {
        echo "[ERROR] Producto id=$id no encontrado en DB\n";
        exit(1);
    }
}
unset($info);

// 5. Obtener ultimo codigo de venta
$stmt = $db->query("SELECT MAX(codigo) as ultimo FROM ventas");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$nuevoCodigo = ($row['ultimo'] ?? 10000) + 1;
echo "[OK] Nuevo codigo de venta: $nuevoCodigo\n";

// 6. Verificar cliente "Venta Rapida"
$stmt = $db->prepare("SELECT * FROM clientes WHERE id = 16");
$stmt->execute();
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
if ($cliente) {
    echo "[OK] Cliente: {$cliente['nombre']} (id={$cliente['id']}), compras actuales={$cliente['compras']}\n";
} else {
    echo "[ERROR] Cliente id=16 no encontrado\n";
}

// 7. Construir JSON de productos igual que ventas.js
$listaProductos = [
    [
        "id" => 67,
        "descripcion" => "Gorros de lana",
        "precio" => 5000,
        "cantidad" => 38,
        "total" => 190000,
        "stock" => 39,
    ],
    [
        "id" => 65,
        "descripcion" => "babysec",
        "precio" => 1.4,
        "cantidad" => 500,
        "total" => 700,
        "stock" => 1440,
    ],
    [
        "id" => 61,
        "descripcion" => "Pañales Niños",
        "precio" => 17,
        "cantidad" => 200,
        "total" => 3400,
        "stock" => 997,
    ],
    [
        "id" => 0,
        "descripcion" => "sueter",
        "precio_venta" => 50000,
        "precio" => 50000,
        "cantidad" => 1,
        "total" => 50000,
        "stock" => 9999,
    ],
];

$totalCalculado = 190000 + 700 + 3400 + 50000; // 244100
$ivaCalculado = $totalCalculado * 0.19; // 46379
$netoCalculado = $totalCalculado - $ivaCalculado; // 197721

echo "[OK] JSON productos construido\n";
echo "    Total: $totalCalculado, IVA: $ivaCalculado, Neto: $netoCalculado\n";

// 8. Preparar POST data como si viniera del formulario
$_POST["nuevaVenta"] = (string)$nuevoCodigo;
$_POST["idVendedor"] = "1";
$_POST["seleccionarCliente"] = "16";
$_POST["listaProductos"] = json_encode($listaProductos);
$_POST["nuevoPrecioImpuesto"] = (string)$ivaCalculado;
$_POST["nuevoPrecioNeto"] = (string)$netoCalculado;
$_POST["totalVenta"] = (string)$totalCalculado;
$_POST["listaMetodoPago"] = "Efectivo";

echo "[OK] POST data preparado\n\n";

// 9. Ejecutar ctrCrearVenta() y capturar todo
echo "=== EJECUTANDO ctrCrearVenta() ===\n\n";

ob_start();
try {
    $controlador = new ControladorVentas();
    $controlador->ctrCrearVenta();
    $output = ob_get_clean();
    
    // Buscar errores en el output
    if (strpos($output, 'error') !== false || strpos($output, 'Error') !== false) {
        echo "[ALERTA] Posible error detectado en la respuesta:\n";
        echo strip_tags($output) . "\n";
    } else {
        echo "[OK] ctrCrearVenta() ejecutado sin errores aparentes\n";
    }
    
    if (trim($output)) {
        echo "[DEBUG] Output: " . substr(strip_tags($output), 0, 500) . "\n";
    }
    
} catch (Exception $e) {
    ob_end_clean();
    echo "[ERROR] Excepcion en ctrCrearVenta(): " . $e->getMessage() . "\n";
    echo "[ERROR] Trace: " . $e->getTraceAsString() . "\n";
    // Verificar si la transaccion fue revertida
    try {
        $dbCheck = Conexion::conectar();
        if ($dbCheck->inTransaction()) {
            $dbCheck->rollBack();
            echo "[INFO] Transaccion revertida manualmente\n";
        }
    } catch (Exception $e2) {
        echo "[INFO] No habia transaccion activa para revertir\n";
    }
}

// 10. Verificar resultado en DB
echo "\n=== VERIFICACION EN BASE DE DATOS ===\n\n";

// Verificar venta creada
$stmt = $db->prepare("SELECT * FROM ventas WHERE codigo = ?");
$stmt->execute([$nuevoCodigo]);
$ventaCreada = $stmt->fetch(PDO::FETCH_ASSOC);

if ($ventaCreada) {
    echo "[OK] Venta codigo={$ventaCreada['codigo']} CREADA exitosamente!\n";
    echo "    ID: {$ventaCreada['id']}\n";
    echo "    Cliente: {$ventaCreada['id_cliente']}\n";
    echo "    Vendedor: {$ventaCreada['id_vendedor']}\n";
    echo "    Total: {$ventaCreada['total']}\n";
    echo "    Neto: {$ventaCreada['neto']}\n";
    echo "    Impuesto: {$ventaCreada['impuesto']}\n";
    echo "    Metodo pago: '{$ventaCreada['metodo_pago']}'\n";
    
    // Verificar productos guardados
    $productosGuardados = json_decode($ventaCreada['productos'], true);
    echo "    Productos en venta: " . count($productosGuardados) . "\n";
    foreach ($productosGuardados as $p) {
        echo "      - {$p['descripcion']}: {$p['cantidad']} x {$p['precio']} = {$p['total']}\n";
    }
} else {
    echo "[ERROR] Venta NO fue creada en la DB\n";
}

// Verificar stock actualizado
echo "\n--- Verificacion de stocks ---\n";
$idsVerificar = [67, 65, 61];
$stmt = $db->prepare("SELECT id, descripcion, stock, ventas FROM productos WHERE id = ?");
foreach ($idsVerificar as $id) {
    $stmt->execute([$id]);
    $p = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($p) {
        echo "    {$p['descripcion']} (id={$p['id']}): stock={$p['stock']}, ventas={$p['ventas']}\n";
    }
}

// Verificar cliente actualizado
$stmt = $db->prepare("SELECT id, nombre, compras, ultima_compra FROM clientes WHERE id = 16");
$stmt->execute();
$clienteActualizado = $stmt->fetch(PDO::FETCH_ASSOC);
if ($clienteActualizado) {
    echo "\n--- Cliente actualizado ---\n";
    echo "    {$clienteActualizado['nombre']}: compras={$clienteActualizado['compras']}, ultima_compra={$clienteActualizado['ultima_compra']}\n";
}

// Verificar si el metodo de pago se guardo correctamente (BUG conocido)
if ($ventaCreada && empty($ventaCreada['metodo_pago'])) {
    echo "\n[BUG DETECTADO] metodo_pago esta vacio en la DB!\n";
    echo "    El campo 'listaMetodoPago' no se esta enviando correctamente desde el frontend.\n";
    echo "    El select usa name='nuevoMetodoPago' pero el controlador lee \$_POST['listaMetodoPago'].\n";
}

echo "\n=== TEST COMPLETADO ===\n";
