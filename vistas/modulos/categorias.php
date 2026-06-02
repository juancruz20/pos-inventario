<?php

if(!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] != "ok"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<style>
  :root {
    --cat-bg: #f8f9fb;
    --cat-surface: #ffffff;
    --cat-border: #eef0f2;
    --cat-text: #1a1d23;
    --cat-text-muted: #7c8291;
    --cat-accent: #3b82f6;
    --cat-accent-hover: #2563eb;
    --cat-danger: #ef4444;
    --cat-danger-hover: #dc2626;
    --cat-success: #10b981;
    --cat-radius: 8px;
    --cat-shadow: 0 1px 2px rgba(0,0,0,0.04), 0 1px 4px rgba(0,0,0,0.02);
  }

  .categorias-panel {
    background: var(--cat-surface);
    border-radius: var(--cat-radius);
    box-shadow: var(--cat-shadow);
    overflow: hidden;
  }

  .categorias-panel .panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--cat-border);
  }

  .categorias-panel .panel-header h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: var(--cat-text);
    letter-spacing: -0.01em;
  }

  .categorias-panel .panel-header h3 i {
    color: var(--cat-accent);
    margin-right: 6px;
  }

  .btn-cat-primary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    font-size: 13px;
    font-weight: 500;
    border: none;
    border-radius: 6px;
    background: var(--cat-accent);
    color: #fff;
    cursor: pointer;
    transition: background 0.15s, box-shadow 0.15s;
  }
  .btn-cat-primary:hover { background: var(--cat-accent-hover); box-shadow: 0 1px 4px rgba(59,130,246,0.25); }
  .btn-cat-primary i { font-size: 12px; }

  .cat-table-wrap {
    overflow-x: auto;
  }

  .cat-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }

  .cat-table thead th {
    padding: 10px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: var(--cat-text-muted);
    background: var(--cat-bg);
    border-bottom: 1px solid var(--cat-border);
    white-space: nowrap;
  }

  .cat-table tbody tr {
    transition: background 0.12s;
  }
  .cat-table tbody tr:hover {
    background: #f4f6fa;
  }

  .cat-table tbody td {
    padding: 10px 16px;
    border-bottom: 1px solid var(--cat-border);
    vertical-align: middle;
    color: var(--cat-text);
  }

  .cat-table .col-id {
    width: 48px;
    color: var(--cat-text-muted);
    font-size: 12px;
  }

  .cat-table .col-name {
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.01em;
  }

  .cat-table .col-actions {
    width: 100px;
    text-align: right;
  }

  .cat-actions {
    display: inline-flex;
    gap: 4px;
  }

  .btn-cat-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    transition: background 0.12s, transform 0.1s;
    color: #fff;
  }
  .btn-cat-action:active { transform: scale(0.94); }

  .btn-cat-action.edit {
    background: #f59e0b;
  }
  .btn-cat-action.edit:hover { background: #d97706; }

  .btn-cat-action.delete {
    background: var(--cat-danger);
  }
  .btn-cat-action.delete:hover { background: var(--cat-danger-hover); }

  .cat-empty {
    padding: 40px 20px;
    text-align: center;
    color: var(--cat-text-muted);
    font-size: 13px;
  }
  .cat-empty i {
    font-size: 28px;
    display: block;
    margin-bottom: 8px;
    opacity: 0.4;
  }

  /* Ajuste modal compacto */
  .modal-cat .modal-content {
    border-radius: 10px;
    border: none;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
  }
  .modal-cat .modal-header {
    background: var(--cat-accent);
    color: #fff;
    border-radius: 10px 10px 0 0;
    padding: 14px 18px;
  }
  .modal-cat .modal-header h4 {
    font-size: 15px;
    font-weight: 600;
  }
  .modal-cat .modal-header .close {
    color: #fff;
    opacity: 0.7;
  }
  .modal-cat .modal-header .close:hover { opacity: 1; }
  .modal-cat .modal-body { padding: 18px; }
  .modal-cat .modal-footer {
    padding: 12px 18px;
    border-top: 1px solid var(--cat-border);
  }
  .modal-cat .form-control {
    border-radius: 6px;
    border: 1px solid var(--cat-border);
    padding: 8px 12px;
    font-size: 13px;
  }
  .modal-cat .form-control:focus {
    border-color: var(--cat-accent);
    box-shadow: 0 0 0 2px rgba(59,130,246,0.12);
  }

  @media (max-width: 767px) {
    .categorias-panel .panel-header {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }
    .cat-table thead th,
    .cat-table tbody td {
      padding: 8px 10px;
      font-size: 12px;
    }
    .cat-table .col-actions { width: 70px; }
    .btn-cat-action { width: 26px; height: 26px; font-size: 11px; }
  }
</style>

<div class="content-wrapper">

  <section class="content-header">
    <h1>Administrar categorías</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar categorías</li>
    </ol>
  </section>

  <section class="content">

    <div class="categorias-panel">

      <div class="panel-header">
        <h3><i class="fa fa-tags"></i> Categorías</h3>
        <button class="btn-cat-primary" data-toggle="modal" data-target="#modalAgregarCategoria">
          <i class="fa fa-plus"></i> Agregar categoría
        </button>
      </div>

      <div class="cat-table-wrap">
        <table class="cat-table">
          <thead>
            <tr>
              <th class="col-id">#</th>
              <th class="col-name">Categoría</th>
              <th class="col-actions">Acciones</th>
            </tr>
          </thead>
          <tbody>

          <?php
            $item = null;
            $valor = null;
            $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

            if ($categorias && count($categorias) > 0):
              foreach ($categorias as $key => $value):
          ?>
            <tr>
              <td class="col-id"><?= $key + 1 ?></td>
              <td class="col-name"><?= htmlspecialchars($value["categoria"], ENT_QUOTES, 'UTF-8') ?></td>
              <td class="col-actions">
                <div class="cat-actions">
                  <button class="btn-cat-action edit btnEditarCategoria"
                    idCategoria="<?= htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8') ?>"
                    data-toggle="modal" data-target="#modalEditarCategoria"
                    title="Editar">
                    <i class="fa fa-pencil"></i>
                  </button>
                  <?php if ($_SESSION["perfil"] == "Administrador"): ?>
                  <button class="btn-cat-action delete btnEliminarCategoria"
                    idCategoria="<?= htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8') ?>"
                    title="Eliminar">
                    <i class="fa fa-times"></i>
                  </button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php
              endforeach;
            else:
          ?>
            <tr>
              <td colspan="3">
                <div class="cat-empty">
                  <i class="fa fa-inbox"></i>
                  No hay categorías registradas
                </div>
              </td>
            </tr>
          <?php endif; ?>

          </tbody>
        </table>
      </div>

    </div>

  </section>

</div>

<!-- MODAL AGREGAR CATEGORÍA -->
<div id="modalAgregarCategoria" class="modal fade modal-cat" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Agregar categoría</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nombre de la categoría</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-th"></i></span>
              <input type="text" class="form-control" name="nuevaCategoria" placeholder="Ej: Ropa" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar categoría</button>
        </div>
        <?php
          $crearCategoria = new ControladorCategorias();
          $crearCategoria -> ctrCrearCategoria();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDITAR CATEGORÍA -->
<div id="modalEditarCategoria" class="modal fade modal-cat" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Editar categoría</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nombre de la categoría</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-th"></i></span>
              <input type="text" class="form-control" name="editarCategoria" id="editarCategoria" required>
              <input type="hidden" name="idCategoria" id="idCategoria" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
        <?php
          $editarCategoria = new ControladorCategorias();
          $editarCategoria -> ctrEditarCategoria();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
  $borrarCategoria = new ControladorCategorias();
  $borrarCategoria -> ctrBorrarCategoria();
?>
