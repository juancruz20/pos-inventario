# POS System - Checkpoint

## Project Context
- **Root**: C:\xampp\htdocs\pos
- **Platform**: XAMPP on Windows
- **Tech**: PHP, MySQL, JavaScript, Bootstrap, Morris.js, TCPDF

## Completed Changes

### Fix: Inventario sincronización con ventas (CRÍTICO)
- `controladores/ventas.controlador.php`:
  - **ctrCrearVenta()**: Stock se calcula SIEMPRE desde DB (`stock_actual - cantidad`), no desde frontend. Validación de stock negativo con throw Exception. `array_push(totalProductosComprados)` movido DESPUÉS del `if(id==0) continue` para no inflar `compras` del cliente.
  - **ctrEditarVenta()**: Ambos loops (revert + apply) con `array_push` después de `if(id==0) continue`. Validación de stock negativo en loop de aplicar. Excepciones si producto no existe en DB.
  - **ctrEliminarVenta()**: `array_push` después de `if(id==0) continue`. Excepción si producto no existe.
- Concepto extra (id=0) nunca toca inventario ni ventas de productos.
- Transacciones con rollback automático en errores.
- `ventas.js`: No requiere cambios — ya envía id=0 correctamente para concepto extra.

### Venta Rápida as Default Client
- `vistas/modulos/crear-venta.php`: Selected "Venta Rápida" as default via DB lookup in `<select id="id_cliente">`
- `vistas/js/ventas.js`: Verified default client logic

### Products - Removed "Permitir productos sin stock"
- `vistas/modulos/crear-venta.php`: Removed `#permitirStock` checkbox
- `vistas/js/ventas.js`: Removed `permitirStock` variable, checked `stock` and `stock_actual` conditions, removed `.permitir-stock` reference, removed `permitirStock()` function
- `vistas/dist/css/estilos.css`: Removed `.permitir-stock` CSS rule

### Total Input - Max 7 digits, smaller width
- `vistas/modulos/crear-venta.php`: `maxlength="7"`, removed `input-lg`, class `form-control` only
- `vistas/dist/css/estilos.css`: `#totalPagar{max-width:160px!important;display:inline-block!important}`

### Efectivo Payment - Removed cash input and change field
- `vistas/modulos/crear-venta.php`: Removed `#divEfectivo` (cash input, change field, efectivo pago label)
- `vistas/dist/css/estilos.css`: Removed `#divEfectivo` CSS block

### Payment Method + Total Side by Side
- `vistas/modulos/crear-venta.php`: Wrapped `#select-pago` in col-xs-6, `#total` in col-xs-6, same `.row`
- Removed `#pago_efectivo`

### Equal Width Columns
- `vistas/modulos/crear-venta.php`: Both main sections use `col-lg-6 col-md-6 col-xs-12`

### Products - Removed "Precio de lista" and "Utilizar porcentaje"
- `vistas/modulos/productos.php`: Removed `#nuevoPrecio` and `#editarPrecio` fields, removed `#nuevoPorcentaje` and `#editarPorcentaje`, removed JS calculation logic
- `vistas/js/productos.js`: Removed handlers for `#nuevoPrecio`, `#editarPrecio`, `#nuevoPorcentaje`, `#editarPorcentaje`, removed `editarPrecioVenta()`, `nuevoPrecioVenta()`, `validarPrecioVenta()`, `calcularPrecio()` functions

### Sales Listing - Removed "Neto" column
- `vistas/modulos/ventas.php`: Removed `Neto` column from thead, tfoot, and `btnVerVenta` modal
- `vistas/js/ventas.js`: Removed `Neto` from modal display in `btnVerVenta`

### XML Download Replaced with Excel
- `vistas/modulos/ventas.php`: XML button replaced with Excel button `<a href="extensiones/tcpdf/pdf/descargar-reporte.php">`
- `controladores/ventas.controlador.php`: Added `ctrDescargarReporte()` method using `PhpSpreadsheet`

### PDF Inline Mode
- `extensiones/tcpdf/pdf/factura.php`: Changed `$pdf->Output('factura.pdf', 'D')` to `'I'`
- `extensiones/tcpdf/pdf/factura-ticket.php`: Changed `$pdf->Output('factura.pdf', 'D')` to `'I'`

### Invoice Types A/B/C for Clients
- `modelos/clientes.modelo.php`: INSERT/UPDATE include `tipo_comprobante`
- `controladores/clientes.controlador.php`: Validates `tipo_comprobante`; added `ctrTotalVentasCliente()`
- `ajax/clientes.ajax.php`: Returns `tipo_comprobante` and `total_ventas` on edit
- `vistas/modulos/clientes.php`: 3 colored cards (A=primary, B=warning, C=success), auto-complete on edit
- `vistas/js/clientes.js`: Auto-complete logic based on total sales (>100k→A, >50k→B, else C)

### Tipo Comprobante Column in Clientes Table
- `vistas/modulos/clientes.php`: Added column in thead/tfoot/datatable

### Removed "Configurar tipo de factura" from Dashboard
- `vistas/modulos/inicio.php`: Removed the button/link

### Products - Removed "Detalle compra" column
- `vistas/modulos/productos.php`: Removed from thead, modal edit form, hidden inputs
- `vistas/js/productos.js`: Cleaned up references
- `ajax/datatable-productos.ajax.php`: Removed from response

### Sales - Added "Detalle compra" column
- `vistas/modulos/ventas.php`: Added column showing product descriptions from `detalle_compra` in JSON

### Low Stock Alert Widget
- `vistas/modulos/inicio.php`: Included `productos-stock-bajo.php`
- `vistas/modulos/inicio/productos-stock-bajo.php`: Created widget with box-danger, products-list with images, color-coded stock labels (verde/amarillo/rojo), CSS pulse-alert & stock-shake animations controlled by `.activo` class
- `vistas/dist/css/estilos.css`: Added stock animation CSS, `setTimeout` removes `.activo` class after 30s
- `controladores/productos.controlador.php`: Added `ctrMostrarProductosBajoStock()`
- `modelos/productos.modelo.php`: Added `mdlMostrarProductosBajoStock()` query (stock <= stock_minimo)
- Changed "uds" to "unidades" in stock labels; widget always visible

### Line Charts - Redesigned
- `vistas/modulos/reportes/grafico-ventas.php`: Two Morris.js line charts (monthly + daily) side by side, `pointSize: 0`, `lineWidth: 4`, solid lines, no points/markers
- Removed neto vs impuesto chart

### Navbar User Icon Alignment
- `vistas/dist/css/responsive.css`: Added flexbox `.main-header .navbar { display: flex; align-items: center; }`

### Actualizar Stock Column
- `vistas/modulos/productos.php`: Added "Actualizar stock" column in thead
- `ajax/datatable-productos.ajax.php`: Renders `<input type="number">` + `<button class="btn btn-xs btn-primary btn-actualizar-stock">`
- `ajax/actualizar-stock.ajax.php`: New AJAX endpoint
- `controladores/productos.controlador.php`: Added `ctrActualizarStock()` — sums input value to current stock
- `modelos/productos.modelo.php`: Added `mdlActualizarProducto()` for stock update
- `vistas/js/productos.js`: Handler for `btn-actualizar-stock` click

### Ropa de Forma Predeterminada
- `vistas/modulos/crear-venta.php`: Added checkbox `#ropaPredeterminada` + price input `#ropaPrecio` below client select, in `col-xs-6` each, same row
- `vistas/js/ventas.js`:
  - Toggle checkbox enables/disables price input
  - `sumarTotalPrecios()`: Reads `#ropaPrecio` value, adds if checked
  - `agregarImpuesto()`: Includes ropa in IVA calculation
  - `listarProductos()`: Adds `{"id": 0, "descripcion": "Ropa predeterminada", "precio_venta": ropaPrecio, ...}` to JSON
- `controladores/ventas.controlador.php`: 4 product loops use `if($value["id"] == 0) continue;` (crear, editar revert, editar aplicar, eliminar)

## Pending DB Migrations
```sql
ALTER TABLE productos ADD detalle_compra TEXT NOT NULL AFTER precio_venta;
ALTER TABLE clientes ADD tipo_comprobante VARCHAR(1) NOT NULL DEFAULT 'B' AFTER fecha_nacimiento;
```

## Key Architectural Notes
- Products with `id==0` in JSON = "Ropa predeterminada", skipped in all ventas controller loops
- Invoice type auto-complete thresholds: >100000 → A, >50000 → B, else C
- Low stock CSS animations stop after 30s via `setTimeout`
- Excel export via `ctrDescargarReporte()` through `descargar-reporte.php`
- XML download handler code still exists at top of `ventas.php` but no UI trigger

## Session 2026-05-20 - UI Redesign & Bugfixes

### crear-venta.php
- Redesigned layout with CSS Grid (2 columns on desktop, 1 on mobile)
- Reordered fields: Vendedor+Código row, Cliente, Concepto extra toggle, payment+total
- Product table uses `tablaProductosVenta` class with custom DataTable init loading from `datatable-productos.ajax.php`
- "Agregar" buttons in table have 28px height (matches stock input height)
- `.nuevoProducto` container hidden in DOM for JS product tracking
- Removed product code text input (products added only from table)
- Removed "Productos disponibles" mobile button

### Concepto extra
- Custom toggle UI with dashed border (orange when active)
- Description input + price input side by side with 4px gap
- Placeholder: "Ej: Ropa"

### clientes.php
- Replaced table with card layout using CSS Grid
- `.clientes-grid` with `grid-template-columns: repeat(auto-fill, minmax(340px, 1fr))`
- Removed dual desktop/mobile views

### ventas.php
- Fixed PHP Warning line 141: `$respuestaCliente["nombre"]` when client deleted → ternary fallback "Eliminado"
- Same fix for `$respuestaUsuario["nombre"]`

### Global CSS (estilos.css)
- Added placeholder alignment: `text-align: left !important` for all inputs

### Files changed this session:
- `vistas/modulos/crear-venta.php` - Major layout restructure, DataTable init, style block
- `vistas/modulos/clientes.php` - Card grid layout
- `vistas/modulos/ventas.php` - Null safety for cliente/usuario names
- `vistas/js/ventas.js` - Updated table selector to include `.tablaProductosVenta`
- `vistas/dist/css/estilos.css` - Placeholder alignment
- `vistas/dist/css/responsive.css` - Minor mobile layout tweaks

