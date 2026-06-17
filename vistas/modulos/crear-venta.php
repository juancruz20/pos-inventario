<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Crear venta
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Crear venta</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="create-venta-grid">

      <!--=====================================
      FORMULARIO
      ======================================-->
      
      <div class="create-venta-form">
        
        <div class="box box-success">
          
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Nueva Venta</h3>
          </div>

          <form role="form" method="post" class="formularioVenta">

            <div class="box-body">

              <!-- VENDEDOR Y CÓDIGO -->
              
              <div class="row">
                <div class="col-xs-7">
                  <div class="form-group">
                    <label>Vendedor</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                      <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo htmlspecialchars($_SESSION["nombre"], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                      <input type="hidden" name="idVendedor" value="<?php echo htmlspecialchars($_SESSION["id"], ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                  </div>
                </div>
                <div class="col-xs-5">
                  <div class="form-group">
                    <label>Código</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <?php
                      $item = null;
                      $valor = null;
                      $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
                      if(!$ventas){
                        echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="10001" readonly>';
                      }else{
                        $value = end($ventas);
                        $codigo = $value["codigo"] + 1;
                        echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="'.htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8').'" readonly>';
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- CLIENTE -->

              <div class="form-group">
                <label>Cliente</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-users"></i></span>
                  <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>
                  <?php
                    $item = null;
                    $valor = null;
                    $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
                    $idVentaRapida = null;
                    foreach ($clientes as $c) {
                      if ($c["nombre"] == "Venta Rápida") {
                        $idVentaRapida = $c["id"];
                        break;
                      }
                    }
                    foreach ($clientes as $key => $value) {
                      $selected = ($value["id"] == $idVentaRapida) ? ' selected' : '';
                      echo '<option value="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'"'.htmlspecialchars($selected, ENT_QUOTES, 'UTF-8').'>'.htmlspecialchars($value["nombre"], ENT_QUOTES, 'UTF-8').'</option>';
                    }
                  ?>
                  </select>
                  <span class="input-group-addon cliente-addon-boton"><button type="button" class="btn btn-default cliente-boton-agregar" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar</button></span>
                </div>
              </div>

              <!-- CONCEPTO EXTRA (múltiples filas) -->

              <div class="form-group concepto-extra-block" style="margin-bottom:8px;">
                <div class="concepto-extra-header" style="margin-bottom:6px;">
                  <i class="fa fa-plus-circle"></i>
                  <span>Agregar concepto extra</span>
                </div>
                <div class="concepto-extra-list" id="conceptoExtraList">
                  <div class="concepto-extra-row" data-row="1">
                    <input type="text" class="form-control concepto-extra-desc" placeholder="Descripción (Ej: Ropa)" maxlength="60">
                    <div class="input-group concepto-extra-price">
                      <span class="input-group-addon" style="background:#f4f4f4;color:#999;font-weight:600;">$</span>
                      <input type="number" class="form-control concepto-extra-precio" placeholder="0" step="any" min="0">
                    </div>
                    <button type="button" class="btn btn-primary btn-sm concepto-extra-agregar" title="Agregar a la venta">
                      <i class="fa fa-plus"></i> Agregar
                    </button>
                    <button type="button" class="btn btn-default btn-sm concepto-extra-quitar" title="Quitar esta fila" disabled>
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <button type="button" class="btn btn-link btn-xs concepto-extra-add-fila" style="padding:2px 0; margin-top:4px;">
                  <i class="fa fa-plus"></i> Agregar otra fila
                </button>
              </div>
              
              <div class="nuevoProducto"></div>
              <input type="hidden" id="listaProductos" name="listaProductos">

              <!-- MÉTODO DE PAGO Y TOTAL -->

              <hr>

              <div class="form-group row payment-row">
                
                <div class="col-xs-6 objetoMetodoPago" style="padding-right:0px">
                  <label>Método de pago</label>
                   <div class="input-group">
                    <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                      <option value="Efectivo" selected>Efectivo</option>
                      <option value="TR">Transferencia</option>
                      <option value="TC">Tarjeta Crédito</option>
                      <option value="TD">Tarjeta Débito</option>
                    </select>
                  </div>
                  <div class="form-group nuevoMetodoPagoDetalle" style="display:none; margin-top:10px; margin-bottom:0;">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                      <input type="tel" class="form-control" id="nuevoMetodoPagoDetalle" name="nuevoMetodoPagoDetalle" placeholder="Número de teléfono de la transferencia" maxlength="20" pattern="[0-9+\-\s()]{6,20}">
                    </div>
                  </div>
                  <div class="cajasMetodoPago"></div>
                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">
                  <input type="hidden" id="listaMetodoPagoDetalle" name="listaMetodoPagoDetalle">
                </div>

                <div class="col-xs-6 objetoTotalVenta" style="padding-left:0px">
                  <label>Total</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                    <input type="text" class="form-control" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="00000" maxlength="7" readonly required>
                  </div>
                  <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="0" required>
                  <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="0" required>
                  <input type="hidden" name="totalVenta" id="totalVenta">
                </div>

              </div>

            </div>

          <div class="box-footer">
            <div class="accionesVentaDerecha">
              <div class="checkbox">
                <label><input type="checkbox" value="1" name="impresion"><i class="fa fa-print"></i> Imprimir Ticket</label>
              </div>
              <button type="submit" class="btn btn-primary pull-right btn-submit-desktop"><i class="fa fa-check"></i> Guardar venta</button>
            </div>
          </div>

        </form>

        <?php
          $guardarVenta = new ControladorVentas();
          $guardarVenta -> ctrCrearVenta();
        ?>

        </div>
            
      </div>

      <!--=====================================
      BUSCADOR Y PRODUCTOS
      ======================================-->

      <div class="create-venta-table">

        <div class="box box-warning">

          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-search"></i> Buscar producto</h3>
          </div>

          <div class="box-body">

            <!-- BUSCADOR (mismo input, CSS reubica en movil) -->
            <div class="search-row-wrapper">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                <input type="text" class="form-control" id="nuevoCodigo"
                       placeholder="Escanear o escribir el codigo del producto y presionar Enter"
                       autocomplete="off">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary btn-scanner-codigo" data-target-input="#nuevoCodigo" title="Escanear con la camara">
                    <i class="fa fa-camera"></i>
                  </button>
                  <button type="button" class="btn btn-success btnAgregarProducto" title="Agregar producto">
                    <i class="fa fa-plus"></i> Agregar
                  </button>
                </span>
              </div>
            </div>

            <!-- CONTAINER PARA CARDS DE PRODUCTOS (MOVIL) -->
            <div id="productosCardsContainer" class="productos-cards-container"></div>

            <!-- TABLA DE PRODUCTOS (DESKTOP) -->
            <div class="desktop-products-table">
              <table class="table table-bordered table-striped dt-responsive tablaProductosVenta" width="100%">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Imagen</th>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Existencias</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>

        </div>

      </div>

    </div>

    <!-- BARRA INFERIOR FIJA (MOVIL) -->
    <div class="mobile-bottom-bar">
      <div class="bar-total">
        Total: <span class="total-amount">$0</span>
      </div>
      <div class="bar-actions">
        <button type="button" class="btn-finalizar" id="btnFinalizarVenta">
          <i class="fa fa-check"></i> Finalizar Venta
        </button>
      </div>
    </div>
   
  </section>

</div>

<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar documento" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" required>

              </div>

            </div>

             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cliente</button>

        </div>

      </form>

      <?php

        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearCliente();

      ?>

    </div>

  </div>

</div>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  /* ============================================
     DESIGN TOKENS
     ============================================ */
  :root {
    --pos-primary: #2563EB;
    --pos-primary-dark: #1D4ED8;
    --pos-success: #22C55E;
    --pos-danger: #EF4444;
    --pos-bg: #F8FAFC;
    --pos-text: #0F172A;
    --pos-text-secondary: #64748B;
    --pos-border: #E2E8F0;
    --pos-radius: 16px;
    --pos-radius-sm: 12px;
    --pos-radius-xs: 8px;
    --pos-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
    --pos-shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
    --pos-shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
    --pos-transition: 150ms ease;
    --pos-gap: 16px;
  }

  .content-wrapper { font-family: 'Inter', sans-serif; }

  /* ============================================
     DESKTOP LAYOUT (BASE)
     ============================================ */
  .create-venta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--pos-gap);
    align-items: start;
  }

  .create-venta-table { position: sticky; top: 10px; }
  .create-venta-table .box-body { padding: 0; }
  .create-venta-table .table { margin-bottom: 0; }

  .desktop-products-table {}
  .productos-cards-container { display: none; }

  .mobile-bottom-bar { display: none; }

  .btn-submit-desktop {}

  /* ============================================
     CONCEPTO EXTRA (DESKTOP)
     ============================================ */
  .concepto-extra-row {
    display: flex;
    gap: 4px;
    align-items: center;
    margin-bottom: 4px;
  }
  .concepto-extra-row .form-control { flex: 1; min-width: 0; }
  .concepto-extra-row .concepto-extra-desc { flex: 1 1 auto; min-width: 120px; }
  .concepto-extra-row .concepto-extra-quitar:disabled { opacity: 0.4; cursor: not-allowed; }

  .concepto-extra-price { width: 120px; flex-shrink: 0; }
  .concepto-extra-list { margin-top: 6px; }

  .concepto-extra-header {
    font-weight: 600;
    color: #444;
    font-size: 13px;
  }
  .concepto-extra-header i { color: #f39c12; }

  .concepto-extra-block {
    background: #fafbfc;
    border: 1px solid #e8e8e8;
    border-radius: 4px;
    padding: 8px 10px;
  }

  /* ============================================
     BOX FOOTER (DESKTOP)
     ============================================ */
  .box-footer .accionesVentaDerecha {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    flex-wrap: wrap;
  }
  .box-footer .checkbox {
    margin: 0;
    padding: 6px 12px;
    background: #f9f9f9;
    border: 1px solid #e0e3e5;
    border-radius: 4px;
    cursor: pointer;
    user-select: none;
  }
  .box-footer .checkbox label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 24px;
    cursor: pointer;
    font-size: 13px;
  }
  .box-footer .checkbox label input[type="checkbox"] {
    width: 17px;
    height: 17px;
    cursor: pointer;
  }
  .box-footer .checkbox:active { background: #f0f0f0; }

  /* ============================================
     PRODUCTOS AGREGADOS (DESKTOP)
     ============================================ */
  .nuevoProducto { display: none; margin-top: 8px; }

  .nuevoProducto .producto-item-venta {
    margin: 0 0 10px 0;
    padding: 0;
  }
  .nuevoProducto .producto-item-venta .producto-descripcion-caja {
    display: flex;
    align-items: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    background: #fff;
    color: #222;
    font-weight: 600;
    border: 1px solid #c0c4c8;
    border-left: 3px solid #3c8dbc;
    height: 36px;
    padding: 0 10px;
    border-radius: 3px;
    cursor: default;
    font-size: 13px;
  }

  .nuevoProducto .producto-item-venta .form-control {
    background: #f9f9f9;
    border-color: #d2d6de;
  }

  .nuevoProducto .producto-item-venta .quitarProducto {
    margin-top: 0;
    padding: 7px 12px;
    font-size: 13px;
  }
  .nuevoProducto .producto-item-venta .ingresoCantidad {
    border-color: #3c8dbc;
    color: #1f4e79;
    background: #f7fbff;
    font-weight: 600;
    text-align: center;
  }
  .nuevoProducto .producto-item-venta .ingresoCantidad:focus {
    border-color: #2b7cb8;
    box-shadow: 0 0 0 2px rgba(60,141,188,0.16);
  }

  /* ============================================
     PAYMENT ROW (DESKTOP)
     ============================================ */
  .payment-row {
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 10px;
    flex-wrap: wrap;
  }
  .payment-row .objetoMetodoPago { flex: 1 1 140px; max-width: 200px; }
  .payment-row .objetoTotalVenta { flex: 1 1 160px; max-width: 200px; }
  .payment-row .objetoTotalVenta .input-group { width: 100%; }

  /* ============================================
     PRODUCTOS DISPONIBLES - filas compactas (DESKTOP)
     ============================================ */
  .create-venta-table .tablaProductosVenta thead > tr > th {
    padding: 7px 8px;
    font-size: 14px;
    line-height: 1.2;
  }
  .create-venta-table .tablaProductosVenta tbody > tr > td {
    padding: 5px 8px;
    font-size: 14px;
    line-height: 1.25;
    vertical-align: middle;
  }
  .create-venta-table .tablaProductosVenta tbody > tr > td img {
    width: 30px;
    height: 30px;
    object-fit: contain;
  }
  .create-venta-table .tablaProductosVenta .btn {
    padding: 4px 9px;
    font-size: 13px;
    line-height: 1.4;
  }
  .create-venta-table .tablaProductosVenta .agregarProducto {
    min-width: 74px;
    font-weight: 600;
    height: 34px;
    line-height: 32px;
    padding: 0 10px;
    font-size: 12px;
  }

  /* ============================================
     BOTTOM BAR FIJA (BASE - oculta en desktop)
     ============================================ */
  .mobile-bottom-bar {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background: #fff;
    border-top: 1px solid var(--pos-border);
    padding: 12px 16px;
    box-shadow: 0 -4px 6px -1px rgba(0,0,0,0.1);
    align-items: center;
    gap: 12px;
  }
  .mobile-bottom-bar .bar-total {
    flex: 1;
    font-size: 18px;
    font-weight: 700;
    color: var(--pos-text);
  }
  .mobile-bottom-bar .bar-total .total-amount { color: var(--pos-primary); }
  .mobile-bottom-bar .bar-actions { flex: 1; display: flex; justify-content: flex-end; }
  .mobile-bottom-bar .btn-finalizar {
    background: var(--pos-primary);
    color: #fff;
    border: none;
    border-radius: var(--pos-radius-sm);
    padding: 14px 28px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background var(--pos-transition);
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .mobile-bottom-bar .btn-finalizar:active { background: var(--pos-primary-dark); transform: scale(0.98); }

  /* ============================================
     TABLET (768px - 1023px)
     ============================================ */
  @media (min-width: 768px) and (max-width: 1023px) {
    .create-venta-grid { grid-template-columns: 1fr 1fr; }
    .productos-cards-container { grid-template-columns: 1fr 1fr; }
    .desktop-products-table { display: none; }
    .mobile-bottom-bar { display: none; }
    .btn-submit-desktop { display: block; }
  }

  /* ============================================
     MOBILE (<= 767px)
     ============================================ */
  @media (max-width: 767px) {

    /* === LAYOUT === */
    .create-venta-grid { grid-template-columns: 1fr; }
    .create-venta-table { position: static; margin-top: 0; }
    .create-venta-table .box-body { padding: 16px; }
    .desktop-products-table { display: none; }
    .mobile-bottom-bar { display: flex; }
    .btn-submit-desktop { display: none; }
    .content-wrapper .content { padding-bottom: 80px; }

    /* === HEADER === */
    .content-header h1 { font-size: 20px; font-weight: 600; }
    .content-header .breadcrumb { display: none; }

    /* === BOX OVERRIDES === */
    .box { border-radius: var(--pos-radius); border: none; box-shadow: var(--pos-shadow); margin-bottom: 12px; }
    .box-header { background: #fff; border-radius: var(--pos-radius) var(--pos-radius) 0 0; }
    .box-header .box-title { font-size: 15px; font-weight: 600; color: var(--pos-text); }
    .box-body { padding: 16px; }

    /* === SEARCH FIELD === */
    .search-row-wrapper .input-group { position: relative; }
    .search-row-wrapper .form-control {
      height: 52px;
      font-size: 16px;
      border-radius: var(--pos-radius-sm);
      border: 2px solid var(--pos-border);
      padding: 0 16px 0 44px;
      transition: border-color var(--pos-transition), box-shadow var(--pos-transition);
    }
    .search-row-wrapper .form-control:focus {
      border-color: var(--pos-primary);
      box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    .search-row-wrapper .input-group-addon {
      position: absolute;
      left: 0; top: 0; bottom: 0;
      width: 44px;
      display: flex; align-items: center; justify-content: center;
      background: transparent; border: none;
      color: var(--pos-text-secondary); font-size: 16px; z-index: 2;
      border-radius: var(--pos-radius-sm) 0 0 var(--pos-radius-sm);
    }
    .search-row-wrapper .input-group-btn { display: flex; }
    .search-row-wrapper .btn-scanner-codigo {
      flex: 0 0 52px; height: 52px;
      border-radius: 0;
      background: #fff; border: 2px solid var(--pos-border);
      border-left: none; border-right: none;
      color: var(--pos-text); font-size: 18px;
      display: flex; align-items: center; justify-content: center;
      transition: all var(--pos-transition);
    }
    .search-row-wrapper .btn-scanner-codigo:active { background: var(--pos-bg); transform: scale(0.96); }
    .search-row-wrapper .btnAgregarProducto {
      flex: 1; height: 52px;
      border-radius: 0 var(--pos-radius-sm) var(--pos-radius-sm) 0;
      font-size: 15px; font-weight: 600;
      background: var(--pos-success); border: none; color: #fff;
      transition: all var(--pos-transition);
      white-space: nowrap;
    }
    .search-row-wrapper .btnAgregarProducto:active { transform: scale(0.97); }

    /* === CLIENTE DROPDOWN === */
    #seleccionarCliente {
      height: 52px; font-size: 15px;
      border-radius: var(--pos-radius-sm);
      border: 2px solid var(--pos-border);
      padding: 0 36px 0 16px;
      -webkit-appearance: none; -moz-appearance: none; appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748B' viewBox='0 0 16 16'%3E%3Cpath d='M4.5 6l3.5 3.5L11.5 6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 16px;
      transition: border-color var(--pos-transition);
    }
    #seleccionarCliente:focus {
      border-color: var(--pos-primary);
      box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
      outline: none;
    }
    .cliente-addon-boton { padding: 0; width: auto; }
    .cliente-boton-agregar {
      height: 52px; padding: 0 16px;
      border-radius: 0 var(--pos-radius-sm) var(--pos-radius-sm) 0;
      font-size: 14px; font-weight: 500;
      background: var(--pos-primary); color: #fff; border: none;
    }

    /* === VENDEDOR / CODIGO === */
    .create-venta-form .row > .col-xs-7,
    .create-venta-form .row > .col-xs-5 { width: 100%; float: none; }
    .formularioVenta .input-group > .form-control {
      height: 48px; border-radius: var(--pos-radius-sm);
      font-size: 15px; border: 2px solid var(--pos-border);
    }
    .formularioVenta .input-group > .form-control:focus {
      border-color: var(--pos-primary);
      box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    .formularioVenta .input-group > .input-group-addon {
      border-radius: var(--pos-radius-sm) 0 0 var(--pos-radius-sm);
      border: 2px solid var(--pos-border); border-right: none;
      background: var(--pos-bg); color: var(--pos-text-secondary);
    }
    .formularioVenta .form-group { margin-bottom: 12px; }

    /* === CONCEPTO EXTRA === */
    .concepto-extra-block {
      background: var(--pos-bg);
      border: 1px solid var(--pos-border);
      border-radius: var(--pos-radius-sm);
      padding: 14px;
    }
    .concepto-extra-header { font-size: 14px; }
    .concepto-extra-row { flex-wrap: wrap; gap: 8px; }
    .concepto-extra-row .concepto-extra-desc {
      flex: 1 1 100%; height: 48px;
      border-radius: var(--pos-radius-xs);
      border: 2px solid var(--pos-border);
    }
    .concepto-extra-row .concepto-extra-price { width: 100%; }
    .concepto-extra-row .concepto-extra-price .form-control {
      height: 48px; border-radius: var(--pos-radius-xs);
      border: 2px solid var(--pos-border);
    }
    .concepto-extra-row .concepto-extra-agregar,
    .concepto-extra-row .concepto-extra-quitar {
      height: 48px; min-width: 48px;
      border-radius: var(--pos-radius-xs);
    }

    /* === PRODUCTOS SUGERIDOS (CARDS) === */
    .productos-cards-container {
      display: grid;
      grid-template-columns: 1fr;
      gap: 12px;
      margin-top: 14px;
    }
    .producto-sugerido-card {
      background: #fff;
      border: 1px solid var(--pos-border);
      border-radius: var(--pos-radius);
      padding: 14px;
      box-shadow: var(--pos-shadow);
      transition: all var(--pos-transition);
    }
    .producto-sugerido-card:active { transform: scale(0.98); box-shadow: var(--pos-shadow-md); }
    .card-producto-top { display: flex; gap: 12px; align-items: flex-start; }
    .card-producto-img-wrap {
      width: 56px; height: 56px;
      border-radius: var(--pos-radius-xs);
      overflow: hidden; background: var(--pos-bg);
      flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
    }
    .card-producto-img-wrap img { width: 100%; height: 100%; object-fit: contain; }
    .card-producto-info { flex: 1; min-width: 0; }
    .card-producto-nombre {
      font-size: 15px; font-weight: 600;
      color: var(--pos-text); line-height: 1.3; margin-bottom: 4px;
    }
    .card-producto-stock { font-size: 13px; color: var(--pos-text-secondary); }
    .card-producto-stock.alto { color: var(--pos-success); }
    .card-producto-stock.bajo { color: var(--pos-danger); }
    .card-producto-bottom {
      display: flex; justify-content: space-between;
      align-items: center; margin-top: 10px;
    }
    .card-producto-precio { font-size: 18px; font-weight: 700; color: var(--pos-text); }
    .card-btn-agregar {
      background: var(--pos-primary); color: #fff; border: none;
      border-radius: var(--pos-radius-xs); padding: 10px 18px;
      font-size: 14px; font-weight: 600; cursor: pointer;
      transition: all var(--pos-transition);
    }
    .card-btn-agregar:active { background: var(--pos-primary-dark); transform: scale(0.96); }

    /* === PRODUCTOS AGREGADOS (CARDS) === */
    .nuevoProducto { display: none; margin-top: 14px; }
    .nuevoProducto .producto-item-venta {
      background: #fff;
      border: 1px solid var(--pos-border);
      border-radius: var(--pos-radius);
      padding: 14px;
      box-shadow: var(--pos-shadow);
      margin-bottom: 10px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .nuevoProducto .producto-item-venta .card-item-top {
      display: flex; justify-content: space-between;
      align-items: flex-start; gap: 8px;
    }
    .nuevoProducto .producto-item-venta .producto-descripcion-caja {
      font-size: 15px; font-weight: 600;
      color: var(--pos-text); background: none; border: none;
      height: auto; padding: 0;
      white-space: normal; flex: 1;
    }
    .nuevoProducto .producto-item-venta .quitarProducto {
      background: var(--pos-danger); color: #fff; border: none;
      width: 36px; height: 36px; border-radius: 50%; min-width: 36px;
      display: flex; align-items: center; justify-content: center;
      font-size: 14px; transition: all var(--pos-transition);
    }
    .nuevoProducto .producto-item-venta .quitarProducto:active { transform: scale(0.9); }
    .nuevoProducto .producto-item-venta .card-item-bottom {
      display: flex; align-items: center; justify-content: space-between;
    }
    .nuevoProducto .producto-item-venta .ingresoPrecio {
      font-size: 16px; font-weight: 700;
      color: var(--pos-primary); background: none; border: none;
      height: auto; padding: 0; width: auto; text-align: left;
    }
    .qty-controls {
      display: flex; align-items: center;
      background: var(--pos-bg); border-radius: var(--pos-radius-xs);
      border: 1px solid var(--pos-border);
    }
    .qty-btn {
      width: 40px; height: 40px; border: none; background: transparent;
      font-size: 18px; font-weight: 600; color: var(--pos-text);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: background var(--pos-transition);
    }
    .qty-btn:active { background: var(--pos-border); }
    .qty-btn.minus { color: var(--pos-danger); }
    .qty-btn.plus { color: var(--pos-success); }
    .qty-value {
      width: 40px; text-align: center;
      font-size: 16px; font-weight: 600;
      border: none; background: transparent; height: 40px;
      -moz-appearance: textfield;
    }
    .qty-value::-webkit-outer-spin-button,
    .qty-value::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    /* Hide desktop col-xs layout in mobile card mode */
    .nuevoProducto .producto-item-venta [class*="col-xs-"] { display: none; }

    /* === PAYMENT ROW === */
    .payment-row { flex-direction: column; gap: 12px; }
    .payment-row .objetoMetodoPago,
    .payment-row .objetoTotalVenta { flex: 1 1 100%; max-width: 100%; }
    .payment-row label { font-size: 14px; font-weight: 500; margin-bottom: 6px; }
    #nuevoMetodoPago {
      height: 52px; font-size: 15px;
      border-radius: var(--pos-radius-sm);
      border: 2px solid var(--pos-border);
    }
    #nuevoMetodoPago:focus {
      border-color: var(--pos-primary);
      box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    #nuevoTotalVenta {
      height: 52px; font-size: 20px; font-weight: 700;
      border-radius: var(--pos-radius-sm);
      background: var(--pos-primary); color: #fff;
      border: none; text-align: center;
    }
    .nuevoMetodoPagoDetalle .form-control {
      height: 48px; border-radius: var(--pos-radius-sm);
      border: 2px solid var(--pos-border);
    }

    /* === FOOTER === */
    .box-footer .accionesVentaDerecha {
      flex-direction: column; align-items: stretch;
    }
    .box-footer .checkbox {
      padding: 12px 16px; text-align: center;
      border-radius: var(--pos-radius-xs);
    }
    .box-footer .checkbox label { font-size: 15px; gap: 10px; justify-content: center; }
    .box-footer .btn { width: 100%; padding: 12px; font-size: 15px; border-radius: var(--pos-radius-sm); }
  }

  /* ============================================
     VERY SMALL SCREENS (<= 400px)
     ============================================ */
  @media (max-width: 400px) {
    .card-producto-img-wrap { width: 48px; height: 48px; }
    .card-producto-precio { font-size: 16px; }
    .mobile-bottom-bar .btn-finalizar { padding: 12px 20px; font-size: 14px; }
    .qty-btn { width: 36px; height: 36px; font-size: 16px; }
    .qty-value { width: 36px; height: 36px; font-size: 14px; }
  }
</style>

<script>
if ($(".tablaProductosVenta").length) {
  $(".tablaProductosVenta").DataTable({
    processing: true,
    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      search: "Buscar:",
      emptyTable: "Ningún dato disponible en esta tabla",
      info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      paginate: {
        next: "Siguiente",
        previous: "Anterior"
      }
    },
    ajax: "ajax/datatable-productos.ajax.php",
    columns: [
      { data: 0 },
      { data: 1 },
      { data: 2 },
      { data: 3 },
      { data: 5 },
      {
        data: 10,
        render: function (data, type, row) {
          var htmlBotones = typeof data === "string" ? data : "";
          var match = htmlBotones.match(/idProducto=['\"](\d+)['\"]/);
          if (!match && row && row[6]) {
            match = String(row[6]).match(/data-id=['\"](\d+)['\"]/);
          }
          var id = match ? match[1] : "";
          if (!id) {
            return "";
          }
          return '<button class="btn btn-primary btn-xs agregarProducto" idProducto="' + id + '">Agregar</button>';
        }
      }
    ],
    order: [[0, "asc"]],
    responsive: true,
    autoWidth: false,
  });
}
</script>