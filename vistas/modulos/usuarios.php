<?php

if($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<style>
:root {
  --us-bg: #f4f6f9;
  --us-card: #ffffff;
  --us-border: #e8eaed;
  --us-text: #202124;
  --us-muted: #5f6368;
  --us-accent: #3b82f6;
  --us-radius: 8px;
  --us-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

.usuarios-panel {
  background: var(--us-card);
  border-radius: var(--us-radius);
  box-shadow: var(--us-shadow);
  overflow: hidden;
}

.usuarios-panel .box-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--us-border);
  display: flex;
  align-items: center;
}

.usuarios-panel .box-body {
  padding: 0;
}

.user-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  font-size: 14px;
}

.user-table thead th {
  background: #f8f9fa;
  color: var(--us-muted);
  font-weight: 600;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 12px 16px;
  border-bottom: 2px solid var(--us-border);
  text-align: left;
}

.user-table thead th:first-child {
  border-radius: var(--us-radius) 0 0 0;
}

.user-table thead th:last-child {
  border-radius: 0 var(--us-radius) 0 0;
}

.user-table tbody tr {
  transition: background 0.15s ease;
}

.user-table tbody tr:hover {
  background: #f1f5f9;
}

.user-table tbody tr:not(:last-child) td {
  border-bottom: 1px solid var(--us-border);
}

.user-table td {
  padding: 10px 16px;
  color: var(--us-text);
  vertical-align: middle;
}

.user-table td[data-label="Foto"] {
  text-align: center;
}

.user-table th:last-child,
.user-table td:last-child {
  white-space: nowrap;
}

.user-table .btn-group {
  display: inline-flex;
  gap: 4px;
}

.btnActivar.btn-success {
  background: #22c55e;
  border: none;
  color: #fff;
  padding: 4px 14px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.btnActivar.btn-success:hover {
  background: #16a34a;
}

.btnActivar.btn-danger {
  background: #ef4444;
  border: none;
  color: #fff;
  padding: 4px 14px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}

.btnActivar.btn-danger:hover {
  background: #dc2626;
}

.btnEditarUsuario {
  background: #f59e0b;
  border: none;
  color: #fff;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 13px;
  cursor: pointer;
  transition: all 0.2s;
  line-height: 1;
}

.btnEditarUsuario:hover {
  background: #d97706;
}

.btnEliminarUsuario {
  background: #ef4444;
  border: none;
  color: #fff;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 13px;
  cursor: pointer;
  transition: all 0.2s;
  line-height: 1;
}

.btnEliminarUsuario:hover {
  background: #dc2626;
}

.modal-content {
  border: none;
  border-radius: 12px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

.modal-header {
  border-radius: 12px 12px 0 0;
  padding: 16px 20px;
}

.modal-header .close {
  color: #fff;
  opacity: 0.8;
}

.modal-header .close:hover {
  opacity: 1;
}

.modal-title {
  font-weight: 600;
  font-size: 18px;
}

.modal-body {
  padding: 24px;
}

.modal-footer {
  border-top: 1px solid var(--us-border);
  padding: 16px 20px;
}

.btn-primary {
  background: var(--us-accent);
  border: none;
  padding: 8px 20px;
  border-radius: 6px;
  font-weight: 500;
  transition: all 0.2s;
}

.btn-primary:hover {
  background: #2563eb;
}

@media (max-width: 767px) {
  .user-table thead {
    display: none;
  }
  .user-table,
  .user-table tbody,
  .user-table tr,
  .user-table td {
    display: block;
    width: 100%;
  }
  .user-table tr {
    background: var(--us-card);
    border-radius: var(--us-radius);
    margin-bottom: 10px;
    padding: 12px 16px;
    border: 1px solid var(--us-border);
    box-shadow: var(--us-shadow);
  }
  .user-table tr:nth-child(even) {
    background: #fafafa;
  }
  .user-table td {
    border: none !important;
    padding: 6px 0 6px 120px !important;
    position: relative;
    font-size: 14px;
    min-height: 28px;
  }
  .user-table td:before {
    content: attr(data-label);
    position: absolute;
    left: 0;
    top: 6px;
    font-weight: 600;
    font-size: 11px;
    color: var(--us-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .user-table td[data-label="Foto"] {
    padding-left: 0 !important;
    text-align: left;
  }
  .user-table td[data-label="Foto"]:before {
    display: none;
  }
  .user-table td[data-label="Acciones"] {
    padding-left: 0 !important;
    margin-top: 8px;
  }
  .user-table td[data-label="Acciones"]:before {
    display: none;
  }
  .user-table td[data-label="#"] {
    display: none;
  }
  .user-table .btn-group {
    display: flex;
    gap: 8px;
  }
  .user-table .btn-group .btn {
    flex: 1;
    padding: 10px 12px;
    font-size: 13px;
  }
}
</style>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar usuarios
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar usuarios</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="usuarios-panel">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
          
          Agregar usuario

        </button>

      </div>

      <div class="box-body">
        
       <table class="user-table tablas usuarios-table" width="100%">
          
        <thead>
          
          <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Usuario</th>
           <th>Foto</th>
           <th>Perfil</th>
           <th>Estado</th>
           <th>Último login</th>
           <th>Acciones</th>

          </tr> 

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;

        $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

       foreach ($usuarios as $key => $value){
          
            echo '  <tr>
                     <td data-label="#">'.($key+1).'</td>
                     <td data-label="Nombre">'.htmlspecialchars($value["nombre"], ENT_QUOTES, 'UTF-8').'</td>
                     <td data-label="Usuario">'.htmlspecialchars($value["usuario"], ENT_QUOTES, 'UTF-8').'</td>';

                   if($value["foto"] != ""){

                     echo '<td data-label="Foto"><img src="'.htmlspecialchars($value["foto"], ENT_QUOTES, 'UTF-8').'" class="img-thumbnail" width="40px"></td>';

                   }else{

                     echo '<td data-label="Foto"><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';

                   }

                   echo '<td data-label="Perfil">'.htmlspecialchars($value["perfil"], ENT_QUOTES, 'UTF-8').'</td>';

                   if($value["estado"] != 0){

                     echo '<td data-label="Estado"><button class="btn btn-success btn-xs btnActivar" idUsuario="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'" estadoUsuario="0">Activado</button></td>';

                   }else{

                     echo '<td data-label="Estado"><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'" estadoUsuario="1">Desactivado</button></td>';

                   }             

                   echo '<td data-label="Último login">'.htmlspecialchars($value["ultimo_login"], ENT_QUOTES, 'UTF-8').'</td>
                    <td data-label="Acciones">

                     <div class="btn-group">
                         
                       <button class="btn btn-warning btnEditarUsuario" idUsuario="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>

                       <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'" fotoUsuario="'.htmlspecialchars($value["foto"], ENT_QUOTES, 'UTF-8').'" usuario="'.htmlspecialchars($value["usuario"], ENT_QUOTES, 'UTF-8').'"><i class="fa fa-times"></i></button>

                     </div>  

                    </td>

                  </tr>';
        }


        ?> 

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR USUARIO (SIN ESPECIAL)
======================================-->

<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar usuario</h4>

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

                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoUsuario" placeholder="Ingresar usuario" id="nuevoUsuario" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA CONTRASEÑA -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-lock"></i></span> 

                <input type="password" class="form-control input-lg" name="nuevoPassword" placeholder="Ingresar contraseña" required>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR SU PERFIL (SIN ESPECIAL) -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control input-lg" name="nuevoPerfil">
                  
                  <option value="">Selecionar perfil</option>

                  <option value="Administrador">Administrador</option>

                  <option value="Vendedor">Vendedor</option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR FOTO</div>

              <input type="file" class="nuevaFoto" name="nuevaFoto">

              <p class="help-block">Peso máximo de la foto 2MB</p>

              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar usuario</button>

        </div>

        <?php

          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR USUARIO (SIN ESPECIAL)
======================================-->

<div id="modalEditarUsuario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar usuario</h4>

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

                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL USUARIO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" id="editarUsuario" name="editarUsuario" value="" readonly>

              </div>

            </div>

            <!-- ENTRADA PARA LA CONTRASEÑA -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-lock"></i></span> 

                <input type="password" class="form-control input-lg" id="editarPassword" name="editarPassword" placeholder="Escriba la nueva contraseña">

                <span class="input-group-addon" id="togglePassword" style="cursor:pointer; background:#fff;">
                  <i class="fa fa-eye-slash"></i>
                </span>

                <input type="hidden" id="passwordActual" name="passwordActual">

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR SU PERFIL (SIN ESPECIAL) -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control input-lg" name="editarPerfil">
                  
                  <option value="" id="editarPerfil"></option>

                  <option value="Administrador">Administrador</option>

                  <option value="Vendedor">Vendedor</option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR FOTO</div>

              <input type="file" class="nuevaFoto" name="editarFoto">

              <p class="help-block">Peso máximo de la foto 2MB</p>

              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizarEditar" width="100px">

              <input type="hidden" name="fotoActual" id="fotoActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Modificar usuario</button>

        </div>

     <?php

          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarUsuario = new ControladorUsuarios();
  $borrarUsuario -> ctrBorrarUsuario();

?>
