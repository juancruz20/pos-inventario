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

              <!-- CONCEPTO EXTRA -->

              <div class="form-group" id="ropaPredeterminada" style="margin-bottom:8px;">
                <div class="extra-toggle">
                  <label class="extra-toggle-label">
                    <input type="checkbox" id="checkRopaPredeterminada">
                    <span class="extra-toggle-ui">
                      <i class="fa fa-plus-circle"></i>
                      <span>Agregar concepto extra</span>
                    </span>
                  </label>
                </div>
                <div class="concepto-extra-inputs" id="ropaPrecioGroup" style="display:none;">
                  <div class="concepto-extra-row">
                    <input type="text" class="form-control" id="ropaDescripcion" placeholder="Ej: Ropa" maxlength="60">
                    <div class="input-group concepto-extra-price">
                      <span class="input-group-addon" style="background:#f4f4f4;color:#999;font-weight:600;">$</span>
                      <input type="number" class="form-control" id="ropaPrecio" placeholder="0" step="any" min="0">
                    </div>
                  </div>
                </div>
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
                  <div class="cajasMetodoPago"></div>
                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">
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
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Guardar venta</button>
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
      TABLA DE PRODUCTOS
      ======================================-->

      <div class="create-venta-table">
        
        <div class="box box-warning">

          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-cubes"></i> Productos disponibles</h3>
          </div>

          <div class="box-body">
            
            <table class="table table-bordered table-striped dt-responsive tablaProductosVenta" width="100%">
               
               <thead>

                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>

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

<style>
  /* ============================================
     LAYOUT: GRID
     ============================================ */
  .create-venta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    align-items: start;
  }

  .create-venta-table {
    position: sticky;
    top: 10px;
  }
  .create-venta-table .box-body { padding: 0; }
  .create-venta-table .table { margin-bottom: 0; }

  .tablaProductosVenta td:last-child {
    height: 36px;
    vertical-align: middle;
  }
  .tablaProductosVenta .agregarProducto {
    min-width: 74px;
    font-weight: 600;
    height: 34px;
    line-height: 32px;
    padding: 0 10px;
    font-size: 12px;
  }

  /* ============================================
     CONCEPTO EXTRA TOGGLE
     ============================================ */
  .extra-toggle { margin-bottom: 8px; }

  .extra-toggle-label {
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
  }
  .extra-toggle-label input[type="checkbox"] { display: none; }

  .extra-toggle-ui {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border: 1px dashed #ccc;
    border-radius: 6px;
    font-size: 13px;
    color: #888;
    transition: all 0.2s;
    background: #fafafa;
  }
  .extra-toggle-ui i { color: #f39c12; font-size: 15px; }

  .extra-toggle-label input:checked + .extra-toggle-ui {
    border-color: #f39c12;
    background: #fff8e6;
    color: #f39c12;
    font-weight: 600;
  }
  .extra-toggle-label input:checked + .extra-toggle-ui i { color: #e67e22; }

  .concepto-extra-row {
    display: flex;
    gap: 4px;
    align-items: center;
  }
  .concepto-extra-row .form-control { flex: 1; min-width: 0; }
  .concepto-extra-row #ropaDescripcion { flex: 0 0 220px; max-width: 220px; }

  .concepto-extra-price {
    width: 140px;
    flex-shrink: 0;
  }

  .concepto-extra-inputs {
    margin-top: 8px;
  }

  /* Box footer - print checkbox & save button */
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
  .box-footer .checkbox:active {
    background: #f0f0f0;
  }

  /* ============================================
     PRODUCTOS AGREGADOS
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
     PAYMENT ROW
     ============================================ */
  .payment-row {
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 10px;
    flex-wrap: wrap;
  }
  .payment-row .objetoMetodoPago {
    flex: 1 1 140px;
    max-width: 200px;
  }
  .payment-row .objetoTotalVenta {
    flex: 1 1 160px;
    max-width: 200px;
  }
  .payment-row .objetoTotalVenta .input-group { width: 100%; }

  /* ============================================
     MOBILE (<= 767px)
     ============================================ */
  @media (max-width: 767px) {
    .formularioVenta { --venta-control-height: 40px; }

    /* Input group sizing */
    .formularioVenta .input-group > .form-control,
    .formularioVenta .input-group > .input-group-addon,
    .formularioVenta .cliente-boton-agregar {
      height: var(--venta-control-height);
    }
    .formularioVenta .input-group > .input-group-addon {
      padding-top: 0;
      padding-bottom: 0;
      vertical-align: middle;
    }
    .formularioVenta .cliente-addon-boton {
      padding: 0;
      width: 90px;
    }
    .formularioVenta .cliente-boton-agregar {
      border-radius: 0;
      width: 100%;
      padding: 0 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
    }
    .formularioVenta .form-control,
    .formularioVenta .input-group-addon {
      box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .formularioVenta .form-control:focus {
      box-shadow: 0 0 0 2px rgba(60,141,188,0.12);
      border-color: #8ab8d6;
    }
    .formularioVenta select.form-control {
      box-shadow: 0 1px 3px rgba(60,141,188,0.08);
    }
    .formularioVenta input[type="number"].form-control {
      box-shadow: 0 1px 3px rgba(39,174,96,0.08);
    }

    #ropaDescripcion { box-shadow: 0 1px 3px rgba(243,156,18,0.08); }
    .concepto-extra-price { width: 120px; }

    /* Payment row: side by side on mobile */
    .payment-row {
      flex-wrap: nowrap;
      gap: 8px;
    }
    .payment-row .objetoMetodoPago {
      flex: 1 1 auto;
      max-width: 55%;
      padding-left: 0;
      padding-right: 0;
    }
    .payment-row .objetoTotalVenta {
      flex: 0 0 auto;
      max-width: 45%;
      padding-left: 0;
      padding-right: 0;
    }
    .payment-row label { font-size: 11px; margin-bottom: 2px; }
    .payment-row .input-group { margin-bottom: 0; }

    /* Product items row */
    .nuevoProducto .producto-item-venta {
      display: flex;
      align-items: center;
      gap: 4px;
      margin-bottom: 8px !important;
      padding: 0 2px;
    }
    .nuevoProducto .producto-item-venta [class*="col-xs-"] {
      float: none;
      margin-bottom: 0 !important;
      padding: 0 !important;
    }
    .nuevoProducto .producto-item-venta .col-xs-4 {
      flex: 1 1 auto;
      min-width: 0;
    }
    .nuevoProducto .producto-item-venta .col-xs-3 {
      flex: 0 0 65px;
      max-width: 65px;
      width: 65px !important;
    }
    .nuevoProducto .producto-item-venta .col-xs-2 {
      flex: 0 0 40px;
      max-width: 40px;
      width: 40px !important;
    }
    .nuevoProducto .producto-item-venta .form-control {
      height: var(--venta-control-height);
      padding: 6px 8px;
      font-size: 13px;
      margin-bottom: 0 !important;
      border-color: #c0c4c8;
    }
    .nuevoProducto .producto-item-venta .ingresoCantidad {
      font-weight: 600;
      text-align: center;
      border-color: #3c8dbc;
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
      border-radius: 3px;
      height: var(--venta-control-height);
      padding: 0 8px;
      font-size: 13px;
      cursor: default;
    }
    .nuevoProducto .producto-item-venta .ingresoPrecio {
      text-align: right;
      background: #f9f9f9;
    }
    .nuevoProducto .producto-item-venta .quitarProducto {
      width: 40px;
      height: var(--venta-control-height);
      padding: 0 !important;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  }

  @media (max-width: 400px) {
    .nuevoProducto .producto-item-venta {
      gap: 2px;
      padding: 0 1px;
    }
    .nuevoProducto .producto-item-venta .col-xs-3 {
      flex-basis: 64px;
      max-width: 64px;
      width: 64px !important;
    }
    .nuevoProducto .producto-item-venta .col-xs-4 {
      flex-shrink: 1;
      min-width: 0;
    }
    .nuevoProducto .producto-item-venta .producto-descripcion-caja {
      font-size: 11px;
      padding: 0 6px;
      line-height: calc(var(--venta-control-height) - 2px);
    }
    .nuevoProducto .producto-item-venta .ingresoPrecio {
      font-size: 12px;
    }
  }

  /* Mobile: footer checkbox bigger */
  @media (max-width: 767px) {
    .box-footer .accionesVentaDerecha {
      flex-direction: column;
      align-items: stretch;
    }
    .box-footer .checkbox {
      padding: 12px 16px;
      text-align: center;
    }
    .box-footer .checkbox label {
      font-size: 15px;
      gap: 10px;
      justify-content: center;
    }
    .box-footer .checkbox label input[type="checkbox"] {
      width: 20px;
      height: 20px;
    }
    .box-footer .btn {
      width: 100%;
      padding: 10px;
      font-size: 15px;
    }
  }

  @media (max-width: 991px) {
    .create-venta-grid { grid-template-columns: 1fr; }
    .create-venta-table { position: static; margin-top: 0; }
  }
</style>

<script>
if ($(".tablaProductosVenta").length) {
  $(".tablaProductosVenta").DataTable({
    processing: true,
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
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
  });
}
</script>