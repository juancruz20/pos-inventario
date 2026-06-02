<style>
:root {
  --ev-bg: #f8fafc;
  --ev-card: #ffffff;
  --ev-border: #e2e8f0;
  --ev-text: #0f172a;
  --ev-muted: #64748b;
  --ev-accent: #3b82f6;
  --ev-radius: 12px;
  --ev-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
}

.ev-card {
  background: var(--ev-card);
  border: 1px solid var(--ev-border);
  border-radius: var(--ev-radius);
  box-shadow: var(--ev-shadow);
  margin-bottom: 24px;
  overflow: hidden;
}

.ev-card-header {
  padding: 12px 20px;
  border-bottom: 1px solid var(--ev-border);
  background: #f8fafc;
}

.ev-card-body {
  padding: 20px;
}

.ev-card-footer {
  padding: 12px 20px;
  border-top: 1px solid var(--ev-border);
  background: #f8fafc;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}

.ev-card-body .form-group {
  margin-bottom: 14px;
}

.ev-card-body .form-control {
  border: 1px solid var(--ev-border);
  border-radius: 8px;
  font-size: 13px;
  padding: 8px 12px;
  height: auto;
  line-height: 1.5;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
  box-shadow: none;
}

.ev-card-body .form-control:focus {
  border-color: var(--ev-accent);
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.ev-card-body .input-group-addon {
  background: #f1f5f9;
  border: 1px solid var(--ev-border);
  border-right: none;
  border-radius: 8px 0 0 8px;
  color: var(--ev-muted);
  font-size: 13px;
  padding: 8px 12px;
  min-width: 36px;
  text-align: center;
}

.ev-card-body .input-group .form-control:not(:first-child) {
  border-left: none;
  border-radius: 0 8px 8px 0;
}

.ev-card-body .input-group .input-group-addon:last-child {
  border-left: none;
  border-right: 1px solid var(--ev-border);
  border-radius: 0 8px 8px 0;
  background: #f1f5f9;
}

.ev-card-body .input-group-addon .btn {
  margin: -6px -8px;
  padding: 4px 10px;
  font-size: 12px;
  border-radius: 6px;
}

.ev-card-body .btn,
.ev-card-footer .btn {
  border-radius: 8px;
  font-size: 13px;
  padding: 8px 16px;
  transition: all 0.15s ease;
  font-weight: 500;
}

.ev-card-body .btn-primary,
.ev-card-footer .btn-primary {
  background: var(--ev-accent);
  border: 1px solid var(--ev-accent);
  color: #fff;
}

.ev-card-body .btn-primary:hover,
.ev-card-footer .btn-primary:hover {
  background: #2563eb;
  border-color: #2563eb;
}

.ev-card-body .btn-danger {
  background: #ef4444;
  border: 1px solid #ef4444;
  color: #fff;
}

.ev-card-body .btn-danger:hover {
  background: #dc2626;
  border-color: #dc2626;
}

.ev-card-body .btn-block {
  display: block;
  width: 100%;
}

.ev-card-body select.form-control {
  appearance: auto;
  padding: 8px 12px;
}

.ev-card-body .table {
  font-size: 13px;
  margin-bottom: 0;
}

.ev-card-body .table th {
  padding: 10px 12px;
  border-bottom: 2px solid var(--ev-border);
  font-weight: 600;
  color: var(--ev-text);
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  background: transparent;
}

.ev-card-body .table td {
  padding: 10px 12px;
  border-bottom: 1px solid var(--ev-border);
  vertical-align: middle;
}

.ev-card-body .input-lg {
  font-size: 14px;
  padding: 10px 14px;
}

.ev-card-body .input-group .input-lg {
  font-size: 14px;
  padding: 10px 14px;
}

.ev-card-body hr {
  margin: 16px 0;
  border: 0;
  border-top: 1px solid var(--ev-border);
}

@media (max-width: 767px) {
  .ev-card-body {
    padding: 14px;
  }

  .ev-card-header {
    padding: 10px 14px;
  }

  .ev-card-footer {
    padding: 10px 14px;
  }
}
</style>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Editar venta
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Editar venta</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      
      <div class="col-lg-5 col-xs-12">
        
        <div class="ev-card">
          
          <div class="ev-card-header"></div>

          <form role="form" method="post" class="formularioVenta">

            <div class="ev-card-body">
  
              <div class="ev-form-section">

                <?php

                    if(!isset($_GET["idVenta"])){
                        echo '<script>window.location="ventas";</script>';
                        return;
                    }

                    $item = "id";
                    $valor = $_GET["idVenta"];

                    $venta = ControladorVentas::ctrMostrarVentas($item, $valor);

                    if(!$venta){
                        echo '<script>window.location="ventas";</script>';
                        return;
                    }

                    $itemUsuario = "id";
                    $valorUsuario = $venta["id_vendedor"];

                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemCliente = "id";
                    $valorCliente = $venta["id_cliente"];

                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                    $porcentajeImpuesto = ($venta["neto"] > 0) ? $venta["impuesto"] * 100 / $venta["neto"] : 0;


                ?>

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo htmlspecialchars($vendedor["nombre"], ENT_QUOTES, 'UTF-8'); ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo htmlspecialchars($vendedor["id"], ENT_QUOTES, 'UTF-8'); ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                   <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo htmlspecialchars($venta["codigo"], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>

                    <option value="<?php echo htmlspecialchars($cliente["id"], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($cliente["nombre"], ENT_QUOTES, 'UTF-8'); ?></option>

                    <?php

                      $item = null;
                      $valor = null;

                      $categorias = ControladorClientes::ctrMostrarClientes($item, $valor);

                       foreach ($categorias as $key => $value) {

                         echo '<option value="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($value["nombre"], ENT_QUOTES, 'UTF-8').'</option>';

                       }

                    ?>

                    </select>
                    
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar cliente</button></span>
                  
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 

                <div class="form-group row nuevoProducto">

                <?php

                $listaProducto = json_decode($venta["productos"], true);

                foreach ($listaProducto as $key => $value) {

                  $item = "id";
                  $valor = $value["id"];
                  $orden = "id";

                  $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

                  if(!$respuesta) continue;

                  $stockAntiguo = $respuesta["stock"] + $value["cantidad"];
                  
                  echo '<div class="row" style="padding:5px 15px">
            
                        <div class="col-xs-6" style="padding-right:0px">
            
                          <div class="input-group">
                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>

                            <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>

                          </div>

                        </div>

                        <div class="col-xs-3">
              
                          <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>

                        </div>

                        <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                   
                            <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["precio_venta"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>
    
                          </div>
                
                        </div>

                      </div>';
                }


                ?>

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-primary btn-block visible-xs btnAgregarProducto">Agregar producto</button>

                <hr>

                <div class="row">

                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                  
                  <div class="col-xs-8 pull-right">
                    
                    <table class="table">

                      <thead>

                        <tr>
                          <th>Impuesto</th>
                          <th>Total</th>      
                        </tr>

                      </thead>

                      <tbody>
                      
                        <tr>
                          
                          <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" value="<?php echo htmlspecialchars($porcentajeImpuesto, ENT_QUOTES, 'UTF-8'); ?>" required>

                               <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="<?php echo htmlspecialchars($venta["impuesto"], ENT_QUOTES, 'UTF-8'); ?>" required>

                               <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="<?php echo htmlspecialchars($venta["neto"], ENT_QUOTES, 'UTF-8'); ?>" required>

                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                        
                            </div>

                          </td>

                           <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo htmlspecialchars($venta["neto"], ENT_QUOTES, 'UTF-8'); ?>"  value="<?php echo htmlspecialchars($venta["total"], ENT_QUOTES, 'UTF-8'); ?>" readonly required>

                              <input type="hidden" name="totalVenta" value="<?php echo htmlspecialchars($venta["total"], ENT_QUOTES, 'UTF-8'); ?>" id="totalVenta">
                              
                        
                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

                <hr>

                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                <div class="form-group row">
                  
                  <div class="col-xs-6" style="padding-right:0px">
                    
                     <div class="input-group">
                  
                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="TC">Tarjeta Crédito</option>
                        <option value="TD">Tarjeta Débito</option>                  
                      </select>    

                    </div>

                  </div>

                  <div class="cajasMetodoPago"></div>

                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">

                </div>

                <br>
      
              </div>

          </div>

          <div class="ev-card-footer">

            <button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>

          </div>

        </form>

        <?php

          $editarVenta = new ControladorVentas();
          $editarVenta -> ctrEditarVenta();
          
        ?>

        </div>
            
      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 col-xs-12 product-table-mobile hidden-print">
        
        <div class="ev-card">

          <div class="ev-card-header">
            <button type="button" class="btn btn-primary btn-block visible-xs" data-toggle="collapse" data-target="#productTableCollapse">
              <i class="fa fa-table"></i> Productos disponibles
            </button>
          </div>

          <div class="ev-card-body collapse in" id="productTableCollapse">
            
            <table class="table table-bordered table-striped dt-responsive tablaVentas">
               
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

          <div>

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
