<style>
  :root {
    --ean-bg: #f8fafc;
    --ean-card: #ffffff;
    --ean-border: #e2e8f0;
    --ean-text: #1e293b;
    --ean-muted: #94a3b8;
    --ean-accent: #3b82f6;
    --ean-radius: 8px;
    --ean-shadow: 0 1px 3px rgba(0,0,0,.06);
  }

  .eans-panel {
    background: var(--ean-card);
    border-radius: var(--ean-radius);
    box-shadow: var(--ean-shadow);
    border: 1px solid var(--ean-border);
    overflow: hidden;
  }

  .eans-panel .panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--ean-border);
    background: var(--ean-card);
  }

  .eans-panel .panel-body {
    padding: 20px;
  }

  .ean-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    background: var(--ean-card);
  }

  .ean-table thead {
    background: #f1f5f9;
  }

  .ean-table th {
    padding: 10px 12px;
    text-align: left;
    font-weight: 600;
    color: var(--ean-text);
    border-bottom: 2px solid var(--ean-border);
    white-space: nowrap;
  }

  .ean-table td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--ean-border);
    vertical-align: middle;
    color: var(--ean-text);
  }

  .ean-table tbody tr:hover {
    background: #f8fafc;
  }

  .ean-code {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    letter-spacing: 1px;
    color: #1e293b;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 4px;
    display: inline-block;
  }

  .ean-producto-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
    background: #dbeafe;
    color: #1e40af;
  }

  .ean-producto-vacio {
    color: var(--ean-muted);
    font-style: italic;
    font-size: 12px;
  }

  .btn-ean {
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
    background: var(--ean-accent);
    color: #fff;
  }

  .btn-ean:hover {
    background: #2563eb;
    color: #fff;
  }

  .btn-ean-outline {
    background: transparent;
    color: var(--ean-text);
    border: 1px solid var(--ean-border);
  }

  .btn-ean-outline:hover {
    background: #f1f5f9;
    color: var(--ean-text);
    border-color: #cbd5e1;
  }

  .modal-ean .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
  }

  .modal-ean .modal-header {
    border-radius: 12px 12px 0 0;
    background: var(--ean-accent);
    color: #fff;
    padding: 16px 20px;
    border-bottom: none;
  }

  .modal-ean .modal-header .close {
    color: #fff;
    opacity: .75;
  }

  .modal-ean .modal-header .close:hover {
    opacity: 1;
  }

  .modal-ean .modal-body {
    padding: 24px 20px;
  }

  .modal-ean .modal-footer {
    border-top: 1px solid var(--ean-border);
    padding: 14px 20px;
  }

  .modal-ean .form-control {
    border-radius: 6px;
    border: 1px solid var(--ean-border);
    padding: 8px 12px;
    font-size: 13px;
  }

  .modal-ean .form-control:focus {
    border-color: var(--ean-accent);
    box-shadow: 0 0 0 3px rgba(59,130,246,.15);
  }

  .modal-ean .input-group-addon {
    background: #f1f5f9;
    border: 1px solid var(--ean-border);
    border-radius: 6px 0 0 6px;
    color: var(--ean-muted);
  }

  .modal-ean .input-group .form-control {
    border-radius: 0 6px 6px 0;
  }

  @media (max-width: 767px) {
    .ean-table {
      display: block;
    }

    .ean-table thead {
      display: none;
    }

    .ean-table tbody,
    .ean-table tr,
    .ean-table td {
      display: block;
    }

    .ean-table tr {
      margin-bottom: 12px;
      padding: 14px;
      border: 1px solid var(--ean-border);
      border-radius: 8px;
      background: var(--ean-card);
      box-shadow: var(--ean-shadow);
    }

    .ean-table td {
      padding: 6px 0;
      border-bottom: none;
      text-align: left;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 8px;
    }

    .ean-table td::before {
      content: attr(data-label);
      font-weight: 600;
      color: var(--ean-muted);
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .eans-panel .panel-header {
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
      <i class="fa fa-barcode"></i> EAN
    </h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">EAN</li>
    </ol>

  </section>

  <section class="content">

    <div class="eans-panel">

      <div class="panel-header">

        <button class="btn-ean" data-toggle="modal" data-target="#modalAgregarEan">
          <i class="fa fa-plus"></i> Agregar EAN
        </button>

      </div>

      <div class="panel-body">

        <table class="ean-table table table-bordered table-striped dt-responsive tablaEans" width="100%">

          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Código EAN</th>
              <th>Descripción</th>
              <th>Producto asociado</th>
              <th>Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>

        </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR EAN
======================================-->

<div id="modalAgregarEan" class="modal fade modal-ean" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title"><i class="fa fa-barcode"></i> Agregar EAN</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <!-- CÓDIGO EAN -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>

                <input type="text" class="form-control input-lg" name="nuevoCodigoEan" id="nuevoCodigoEan" placeholder="Código EAN (solo números)" pattern="[0-9]+" required>

                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary btn-flat btn-lg btn-scanner-codigo" data-target-input="#nuevoCodigoEan" title="Escanear con la cámara">
                    <i class="fa fa-camera"></i>
                  </button>
                </span>

              </div>

            </div>

            <!-- DESCRIPCIÓN -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-tag"></i></span>

                <input type="text" class="form-control input-lg" name="nuevaDescripcionEan" placeholder="Descripción" required>

              </div>

            </div>

            <!-- PRODUCTO ASOCIADO -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                <select class="form-control input-lg" name="nuevoIdProductoEan">

                  <option value="">— Sin producto asociado —</option>

                  <?php

                  $itemP = null;
                  $valorP = null;
                  $ordenP = "descripcion";

                  $productosLista = ControladorProductos::ctrMostrarProductos($itemP, $valorP, $ordenP);

                  if(is_array($productosLista)){
                    foreach ($productosLista as $key => $value) {
                      echo '<option value="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'">'
                          .htmlspecialchars($value["codigo"], ENT_QUOTES, 'UTF-8').' — '
                          .htmlspecialchars($value["descripcion"], ENT_QUOTES, 'UTF-8')
                          .'</option>';
                    }
                  }

                  ?>

                </select>

              </div>

              <p class="help-block" style="margin-top:6px;font-size:11px;color:#94a3b8;">
                Opcional: asociar este EAN a un producto del catálogo.
              </p>

            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn-ean btn-ean-outline" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn-ean">Guardar EAN</button>

        </div>

      </form>

      <?php

        $crearEan = new ControladorEans();
        $crearEan -> ctrCrearEan();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR EAN
======================================-->

<div id="modalEditarEan" class="modal fade modal-ean" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title"><i class="fa fa-pencil"></i> Editar EAN</h4>

        </div>

        <div class="modal-body">

          <div class="box-body">

            <input type="hidden" name="editarIdEan" id="editarIdEan">

            <!-- CÓDIGO EAN -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>

                <input type="text" class="form-control input-lg" id="editarCodigoEan" name="editarCodigoEan" pattern="[0-9]+" required>

                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary btn-flat btn-lg btn-scanner-codigo" data-target-input="#editarCodigoEan" title="Escanear con la cámara">
                    <i class="fa fa-camera"></i>
                  </button>
                </span>

              </div>

            </div>

            <!-- DESCRIPCIÓN -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-tag"></i></span>

                <input type="text" class="form-control input-lg" id="editarDescripcionEan" name="editarDescripcionEan" required>

              </div>

            </div>

            <!-- PRODUCTO ASOCIADO -->
            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                <select class="form-control input-lg" id="editarIdProductoEan" name="editarIdProductoEan">

                  <option value="">— Sin producto asociado —</option>

                  <?php

                  if(is_array($productosLista)){
                    foreach ($productosLista as $key => $value) {
                      echo '<option value="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'">'
                          .htmlspecialchars($value["codigo"], ENT_QUOTES, 'UTF-8').' — '
                          .htmlspecialchars($value["descripcion"], ENT_QUOTES, 'UTF-8')
                          .'</option>';
                    }
                  }

                  ?>

                </select>

              </div>

            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn-ean btn-ean-outline" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn-ean">Guardar cambios</button>

        </div>

      </form>

      <?php

        $editarEan = new ControladorEans();
        $editarEan -> ctrEditarEan();

      ?>

    </div>

  </div>

</div>

<?php

  $eliminarEan = new ControladorEans();
  $eliminarEan -> ctrEliminarEan();

?>
