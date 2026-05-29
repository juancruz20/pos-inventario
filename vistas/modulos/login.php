<div class="login-box" style="background: transparent; box-shadow: none; border-radius: 20px;">
  
  <div class="login-logo">
    <h1 style="color: white; font-weight: 700; font-size: 42px; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); letter-spacing: 2px;">Bienvenido</h1>
  </div>

  <div class="login-box-body" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 20px; border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37); color: white; padding: 30px 20px;">
    
    <p class="login-box-msg" style="font-size: 18px; font-weight: 300; margin-bottom: 25px; color: white;">Ingrese sus credenciales</p>

    <form method="post" id="loginForm">
      <!-- Campo Usuario -->
      <div class="form-group" style="position: relative;">
        <span class="glyphicon glyphicon-user" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #3c8dbc; font-size: 18px; z-index: 3;"></span>
        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required style="background: rgba(255,255,255,0.9); border: none; border-radius: 30px; padding: 12px 20px 12px 42px; height: 45px;">
      </div>

      <!-- Campo Contraseña -->
      <div class="form-group" style="position: relative;">
        <span class="glyphicon glyphicon-lock" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #3c8dbc; font-size: 18px; z-index: 3;"></span>
        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required style="background: rgba(255,255,255,0.9); border: none; border-radius: 30px; padding: 12px 20px 12px 42px; height: 45px;">
      </div>

      <div class="row" style="margin: 20px 0 10px; display: flex; align-items: center;">
        <div style="flex: 1;">
          <label style="color: #fff; font-weight: 400; cursor: pointer; display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" style="width: 16px; height: 16px; cursor: pointer; accent-color: #3c8dbc;"> Recordarme
          </label>
        </div>
        <div>
          <a href="#" id="btnRecuperar" style="color: rgba(255,255,255,0.85); font-size: 13px; text-decoration: underline; white-space: nowrap;">¿Olvidaste tu contraseña?</a>
        </div>
      </div>

      <div id="recuperarForm" style="display: none; margin-top: 20px;">
        <div class="form-group" style="position: relative;">
          <span class="glyphicon glyphicon-envelope" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #3c8dbc; font-size: 18px; z-index: 3;"></span>
          <input type="email" class="form-control" placeholder="Correo electrónico" id="emailRecuperar" name="emailRecuperar" disabled style="background: rgba(255,255,255,0.9); border: none; border-radius: 30px; padding: 12px 20px 12px 42px; height: 45px;">
        </div>
        <button type="button" class="btn btn-default btn-block" style="border-radius: 30px; border: 1px solid white; color: white; background: transparent; padding: 8px; font-weight: bold;">Recuperar</button>
        <p style="margin-top: 10px; font-size: 12px; text-align: center; color: rgba(255,255,255,0.8);">Se enviará un enlace a su correo</p>
      </div>

      <div class="row" style="margin-top: 20px;">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="border-radius: 30px; background: #3c8dbc; border: none; padding: 10px; font-size: 16px; font-weight: bold; letter-spacing: 2px;">ENTRAR</button>
        </div>
      </div>

      <?php
        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();
      ?>
    </form>

  </div>
</div>

<!-- Estilos globales para el login -->
<style>
  body.login-page {
    background: linear-gradient(135deg, #3c8dbc 0%, #00a65a 100%) !important;
    margin: 0;
    padding: 0;
    height: 100vh;
  }
  .login-page .wrapper, .login-page .main-header, .login-page .content-wrapper {
    background: transparent !important;
  }
  .login-box {
    margin-top: 6%;
  }
  .form-control:focus {
    box-shadow: none;
    border-color: #fff;
  }
  ::-webkit-input-placeholder {
    color: #666 !important;
  }
  ::-moz-placeholder {
    color: #666 !important;
  }
  :-ms-input-placeholder {
    color: #666 !important;
  }
  :-moz-placeholder {
    color: #666 !important;
  }
  .login-logo {
    margin-bottom: 15px;
  }


</style>

<script>
$("#btnRecuperar").click(function(e){
  e.preventDefault();
  var $recuperarForm = $("#recuperarForm");
  var $emailRecuperar = $("#emailRecuperar");
  $recuperarForm.slideToggle(200, function(){
    var visible = $recuperarForm.is(":visible");
    $emailRecuperar.prop("disabled", !visible);
    $emailRecuperar.prop("required", visible);
    if(!visible){
      $emailRecuperar.val("");
    }
  });
});
</script>