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
      
      Administrar clientes
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar clientes</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="clientes-toolbar">
      <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
        <i class="fa fa-plus"></i> Agregar cliente
      </button>
    </div>

    <div class="clientes-grid">

    <?php

      $item = null;
      $valor = null;
      $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

      foreach ($clientes as $key => $value) {

        $tc = $value["tipo_comprobante"] ?? "B";
$badgeColor = $tc == "A" ? "#27ae60" : ($tc == "B" ? "#f39c12" : "#e74c3c");

        echo '<div class="cliente-card">
          <div class="cliente-card-header">
            <div class="cliente-card-nombre">
              <i class="fa fa-user"></i> '.$value["nombre"].'
            </div>
            <div class="cliente-card-acciones">
              <button class="btn btn-warning btn-xs btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';
              if($_SESSION["perfil"] == "Administrador"){
                echo '<button class="btn btn-danger btn-xs btnEliminarCliente" idCliente="'.$value["id"].'"><i class="fa fa-times"></i></button>';
              }
            echo '</div>
          </div>
          <div class="cliente-card-body">
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-key"></i> Documento</span>
              <span class="cliente-card-value">'.$value["documento"].'</span>
            </div>
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-envelope"></i> Email</span>
              <span class="cliente-card-value">'.$value["email"].'</span>
            </div>
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-phone"></i> Teléfono</span>
              <span class="cliente-card-value">'.$value["telefono"].'</span>
            </div>
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-map-marker"></i> Dirección</span>
              <span class="cliente-card-value">'.$value["direccion"].'</span>
            </div>
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-calendar"></i> Nacimiento</span>
              <span class="cliente-card-value">'.$value["fecha_nacimiento"].'</span>
            </div>
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-file-text"></i> Comprobante</span>
              <span class="cliente-card-value"><span class="badge-tipo" style="background:'.$badgeColor.'">'.$tc.'</span></span>
            </div>
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-shopping-cart"></i> Compras</span>
              <span class="cliente-card-value">'.$value["compras"].'</span>
            </div>
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-clock-o"></i> Última compra</span>
              <span class="cliente-card-value">'.$value["ultima_compra"].'</span>
            </div>
            <div class="cliente-card-row">
              <span class="cliente-card-label"><i class="fa fa-sign-in"></i> Ingreso</span>
              <span class="cliente-card-value">'.$value["fecha"].'</span>
            </div>
          </div>
        </div>';

      }

    ?>

    </div>

  </section>

</div>

<style>
  .clientes-toolbar {
    margin-bottom: 16px;
  }

  .clientes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 14px;
  }

  .cliente-card {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    overflow: hidden;
  }

  .cliente-card-header {
    background: #3c8dbc;
    color: #fff;
    padding: 10px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .cliente-card-nombre {
    font-size: 15px;
    font-weight: 600;
  }

  .cliente-card-nombre i {
    margin-right: 6px;
    opacity: 0.8;
  }

  .cliente-card-acciones .btn {
    margin-left: 4px;
    border-radius: 4px;
  }

  .cliente-card-body {
    padding: 6px 0;
  }

  .cliente-card-row {
    display: flex;
    padding: 7px 14px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 13px;
    align-items: center;
  }

  .cliente-card-row:last-child {
    border-bottom: none;
  }

  .cliente-card-label {
    flex: 0 0 120px;
    color: #888;
    font-weight: 500;
  }

  .cliente-card-label i {
    width: 16px;
    text-align: center;
    margin-right: 4px;
    color: #aaa;
  }

  .cliente-card-value {
    flex: 1;
    color: #333;
    word-break: break-word;
  }

  .badge-tipo {
    display: inline-block;
    color: #fff;
    padding: 2px 10px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 13px;
    min-width: 28px;
    text-align: center;
  }

  @media (max-width: 767px) {
    .clientes-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

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

                <input type="text" class="form-control input-lg" name="nuevoFechaNacimiento" placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div>

             <!-- TIPO DE COMPROBANTE -->

            <div class="form-group nuevo-tipo-comprobante">

              <label style="display:block; margin-bottom:8px; font-weight:bold;">Tipo de comprobante</label>

              <div class="row" style="margin:0">

                <div class="col-xs-4" style="padding:0 3px;">
                  <div class="tipo-comprobante seleccionar-tipo" data-tipo="A" style="background:#27ae60; color:#fff; text-align:center; padding:12px 0; border-radius:4px; cursor:pointer; font-size:18px; font-weight:bold; border:3px solid transparent;">
                    A
                  </div>
                </div>

                <div class="col-xs-4" style="padding:0 3px;">
                  <div class="tipo-comprobante seleccionar-tipo" data-tipo="B" style="background:#f39c12; color:#fff; text-align:center; padding:12px 0; border-radius:4px; cursor:pointer; font-size:18px; font-weight:bold; border:3px solid transparent;">
                    B
                  </div>
                </div>

                <div class="col-xs-4" style="padding:0 3px;">
                  <div class="tipo-comprobante seleccionar-tipo" data-tipo="C" style="background:#e74c3c; color:#fff; text-align:center; padding:12px 0; border-radius:4px; cursor:pointer; font-size:18px; font-weight:bold; border:3px solid transparent;">
                    C
                  </div>
                </div>

              </div>

              <input type="hidden" name="nuevoTipoComprobante" id="nuevoTipoComprobante" value="B">

            </div>
  
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

<!--=====================================
MODAL EDITAR CLIENTE
======================================-->

<div id="modalEditarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar cliente</h4>

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

                <input type="text" class="form-control input-lg" name="editarCliente" id="editarCliente" required>
                <input type="hidden" id="idCliente" name="idCliente">
              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="editarDocumentoId" id="editarDocumentoId" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="editarEmail" id="editarEmail" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion"  required>

              </div>

            </div>

             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
            
            <div class="form-group">
               
              <div class="input-group">
               
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control input-lg" name="editarFechaNacimiento" id="editarFechaNacimiento"  data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div>

             <!-- TIPO DE COMPROBANTE -->

            <div class="form-group editar-tipo-comprobante">

              <label style="display:block; margin-bottom:8px; font-weight:bold;">Tipo de comprobante</label>

              <div class="row" style="margin:0">

                <div class="col-xs-4" style="padding:0 3px;">
                  <div class="tipo-comprobante seleccionar-tipo" data-tipo="A" style="background:#27ae60; color:#fff; text-align:center; padding:12px 0; border-radius:4px; cursor:pointer; font-size:18px; font-weight:bold; border:3px solid transparent;">
                    A
                  </div>
                </div>

                <div class="col-xs-4" style="padding:0 3px;">
                  <div class="tipo-comprobante seleccionar-tipo" data-tipo="B" style="background:#f39c12; color:#fff; text-align:center; padding:12px 0; border-radius:4px; cursor:pointer; font-size:18px; font-weight:bold; border:3px solid transparent;">
                    B
                  </div>
                </div>

                <div class="col-xs-4" style="padding:0 3px;">
                  <div class="tipo-comprobante seleccionar-tipo" data-tipo="C" style="background:#e74c3c; color:#fff; text-align:center; padding:12px 0; border-radius:4px; cursor:pointer; font-size:18px; font-weight:bold; border:3px solid transparent;">
                    C
                  </div>
                </div>

              </div>

              <input type="hidden" name="editarTipoComprobante" id="editarTipoComprobante" value="B">

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

      <?php

        $editarCliente = new ControladorClientes();
        $editarCliente -> ctrEditarCliente();

      ?>

    

    </div>

  </div>

</div>

<?php

  $eliminarCliente = new ControladorClientes();
  $eliminarCliente -> ctrEliminarCliente();

?>


