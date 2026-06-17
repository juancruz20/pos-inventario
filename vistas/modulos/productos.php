<style>
  :root {
    --pr-bg: #f8fafc;
    --pr-card: #ffffff;
    --pr-border: #e2e8f0;
    --pr-text: #1e293b;
    --pr-muted: #94a3b8;
    --pr-accent: #3b82f6;
    --pr-radius: 8px;
    --pr-shadow: 0 1px 3px rgba(0,0,0,.06);
  }

  .productos-panel {
    background: var(--pr-card);
    border-radius: var(--pr-radius);
    box-shadow: var(--pr-shadow);
    border: 1px solid var(--pr-border);
    overflow: hidden;
  }

  .productos-panel .panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--pr-border);
    background: var(--pr-card);
  }

  .productos-panel .panel-body {
    padding: 20px;
  }

  .prod-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    background: var(--pr-card);
  }

  .prod-table thead {
    background: #f1f5f9;
  }

  .prod-table th {
    padding: 10px 12px;
    text-align: left;
    font-weight: 600;
    color: var(--pr-text);
    border-bottom: 2px solid var(--pr-border);
    white-space: nowrap;
  }

  .prod-table td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--pr-border);
    vertical-align: middle;
    color: var(--pr-text);
  }

  .prod-table tbody tr:hover {
    background: #f8fafc;
  }

  .btn-moderno {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    font-size: 13px;
    font-weight: 500;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: .15s ease;
    text-decoration: none;
    background: var(--pr-accent);
    color: #fff;
  }

  .btn-moderno:hover {
    background: #2563eb;
    color: #fff;
  }

  .btn-moderno-sm {
    padding: 5px 12px;
    font-size: 12px;
  }

  .btn-moderno-outline {
    background: transparent;
    color: var(--pr-text);
    border: 1px solid var(--pr-border);
  }

  .btn-moderno-outline:hover {
    background: #f1f5f9;
    color: var(--pr-text);
    border-color: #cbd5e1;
  }

  .btn-moderno-danger {
    background: #ef4444;
  }

  .btn-moderno-danger:hover {
    background: #dc2626;
  }

  .modal-moderno .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
  }

  .modal-moderno .modal-header {
    border-radius: 12px 12px 0 0;
    background: var(--pr-accent);
    color: #fff;
    padding: 16px 20px;
    border-bottom: none;
  }

  .modal-moderno .modal-header .close {
    color: #fff;
    opacity: .75;
  }

  .modal-moderno .modal-header .close:hover {
    opacity: 1;
  }

  .modal-moderno .modal-body {
    padding: 24px 20px;
  }

  .modal-moderno .modal-footer {
    border-top: 1px solid var(--pr-border);
    padding: 14px 20px;
  }

  .modal-moderno .form-control {
    border-radius: 6px;
    border: 1px solid var(--pr-border);
    padding: 8px 12px;
    font-size: 13px;
  }

  .modal-moderno .form-control:focus {
    border-color: var(--pr-accent);
    box-shadow: 0 0 0 3px rgba(59,130,246,.15);
  }

  .modal-moderno .input-group-addon {
    background: #f1f5f9;
    border: 1px solid var(--pr-border);
    border-radius: 6px 0 0 6px;
    color: var(--pr-muted);
  }

  .modal-moderno .input-group .form-control {
    border-radius: 0 6px 6px 0;
  }

  .img-thumbnail.previsualizar {
    border-radius: 6px;
    border: 1px solid var(--pr-border);
    padding: 4px;
  }

  @media (max-width: 767px) {
    .prod-table {
      display: block;
    }

    .prod-table thead {
      display: none;
    }

    .prod-table tbody,
    .prod-table tr,
    .prod-table td {
      display: block;
    }

    .prod-table tr {
      margin-bottom: 12px;
      padding: 14px;
      border: 1px solid var(--pr-border);
      border-radius: 8px;
      background: var(--pr-card);
      box-shadow: var(--pr-shadow);
    }

    .prod-table td {
      padding: 6px 0;
      border-bottom: none;
      text-align: left;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 8px;
    }

    .prod-table td::before {
      content: attr(data-label);
      font-weight: 600;
      color: var(--pr-muted);
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .productos-panel .panel-header {
      flex-direction: column;
      align-items: stretch;
    }
  }
</style>

<?php

if(!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] != "ok"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar productos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar productos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="productos-panel">

      <div class="panel-header">
  
        <button class="btn-moderno" data-toggle="modal" data-target="#modalAgregarProducto">
          
          <i class="fa fa-plus"></i> Agregar producto

        </button>

      </div>

      <div class="panel-body">
        
       <table class="prod-table table table-bordered table-striped dt-responsive tablaProductos" width="100%">
        
        <thead>
         
          <tr>
           
<th style="width:10px">#</th>
            <th>Imagen</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Existencias</th>
            <th>Actualizar existencias</th>
            <th>Precio de venta</th>
            <th>Agregado</th>
            <th>Acciones</th>
           
          </tr> 

        </thead>      

       </table>

        <input type="hidden" value="<?php echo htmlspecialchars($_SESSION['perfil'], ENT_QUOTES, 'UTF-8'); ?>" id="perfilOculto">

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->

<div id="modalAgregarProducto" class="modal fade modal-moderno" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar producto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>
                  
                  <option value="">Selecionar categoría</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($value["categoria"], ENT_QUOTES, 'UTF-8').'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar código" required>

                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary btn-flat btn-lg btn-scanner-codigo" data-target-input="#nuevoCodigo" title="Escanear con la cámara">
                    <i class="fa fa-camera"></i>
                  </button>
                </span>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción" required>

              </div>

            </div>

             <!-- ENTRADA PARA STOCK -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" name="nuevoStock" placeholder="Existencias" required>

              </div>

            </div>

             <!-- ENTRADAS PARA ALERTAS DE STOCK -->

             <div class="form-group">

              <label class="control-label" style="font-weight:500;font-size:13px;color:#475569;display:block;margin-bottom:8px;">
                <i class="fa fa-bell"></i> Alertas de existencias por producto
              </label>

              <div class="row">

                <div class="col-xs-6">
                  <div class="input-group" title="Cuando las existencias estén en este valor o menos, se muestra en ROJO">
                    <span class="input-group-addon" style="background:#fee2e2;color:#dc2626;"><i class="fa fa-exclamation-triangle"></i></span>
                    <input type="number" class="form-control input-lg" id="nuevoStockMinimo" name="nuevoStockMinimo" min="0" step="1" placeholder="Mínimo (rojo)" value="10" required>
                  </div>
                </div>

                <div class="col-xs-6">
                  <div class="input-group" title="Cuando las existencias estén en este valor o menos (y mayor al mínimo), se muestra en AMARILLO">
                    <span class="input-group-addon" style="background:#fef3c7;color:#d97706;"><i class="fa fa-exclamation"></i></span>
                    <input type="number" class="form-control input-lg" id="nuevoStockMedio" name="nuevoStockMedio" min="0" step="1" placeholder="Medio (amarillo)" value="15" required>
                  </div>
                </div>

              </div>

              <p class="help-block" style="margin-top:6px;font-size:11px;color:#94a3b8;">
                Existencias por encima del valor medio se mostrarán en verde.
              </p>

            </div>

             <!-- ENTRADA PARA PRECIO VENTA -->

             <div class="form-group">

                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                  <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de venta" required>

                </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">

              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="nuevaImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn-moderno btn-moderno-outline" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn-moderno">Guardar producto</button>

        </div>

      </form>

        <?php

          $crearProducto = new ControladorProductos();
          $crearProducto -> ctrCrearProducto();

        ?>  

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->

<div id="modalEditarProducto" class="modal fade modal-moderno" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar producto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg"  name="editarCategoria" readonly required>
                  
                  <option id="editarCategoria"></option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" readonly required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required>

              </div>

            </div>

             <!-- ENTRADA PARA STOCK -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" required>

              </div>

            </div>

             <!-- ENTRADAS PARA ALERTAS DE STOCK -->

             <div class="form-group">

              <label class="control-label" style="font-weight:500;font-size:13px;color:#475569;display:block;margin-bottom:8px;">
                <i class="fa fa-bell"></i> Alertas de existencias por producto
              </label>

              <div class="row">

                <div class="col-xs-6">
                  <div class="input-group" title="Cuando las existencias estén en este valor o menos, se muestra en ROJO">
                    <span class="input-group-addon" style="background:#fee2e2;color:#dc2626;"><i class="fa fa-exclamation-triangle"></i></span>
                    <input type="number" class="form-control input-lg" id="editarStockMinimo" name="editarStockMinimo" min="0" step="1" placeholder="Mínimo (rojo)" required>
                  </div>
                </div>

                <div class="col-xs-6">
                  <div class="input-group" title="Cuando las existencias estén en este valor o menos (y mayor al mínimo), se muestra en AMARILLO">
                    <span class="input-group-addon" style="background:#fef3c7;color:#d97706;"><i class="fa fa-exclamation"></i></span>
                    <input type="number" class="form-control input-lg" id="editarStockMedio" name="editarStockMedio" min="0" step="1" placeholder="Medio (amarillo)" required>
                  </div>
                </div>

              </div>

              <p class="help-block" style="margin-top:6px;font-size:11px;color:#94a3b8;">
                Existencias por encima del valor medio se mostrarán en verde.
              </p>

            </div>

             <!-- ENTRADA PARA PRECIO VENTA -->

             <div class="form-group">

                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span> 

                  <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" placeholder="Precio de venta" required>

                </div>

            </div>

            <!-- ENTRADA PARA DETALLE COMPRA -->

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">

              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="editarImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="imagenActual" id="imagenActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn-moderno btn-moderno-outline" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn-moderno">Guardar cambios</button>

        </div>

      </form>

        <?php

          $editarProducto = new ControladorProductos();
          $editarProducto -> ctrEditarProducto();

        ?>      

    </div>

  </div>

</div>

<?php

  $eliminarProducto = new ControladorProductos();
  $eliminarProducto -> ctrEliminarProducto();

?>
