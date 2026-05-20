$(".btnEditarUsuario").on("click", function () {
  var idUsuario = $(this).attr("idUsuario");

  $.ajax({
    url: "ajax/usuarios.ajax.php",
    type: "POST",
    data: { idUsuario: idUsuario, editarUsuario: true },
    dataType: "json",
    success: function (respuesta) {
      $("#editarNombre").val(respuesta["nombre"]);
      $("#editarUsuario").val(respuesta["usuario"]);
      $("#editarPassword").val("");
      $("#passwordActual").val(respuesta["password"]);
      $("#editarPassword").attr("type", "password");
      $("#togglePassword i").removeClass("fa-eye").addClass("fa-eye-slash");
      $("#editarPerfil").val(respuesta["perfil"]);
      $("#fotoActual").val(respuesta["foto"]);

      if (respuesta["foto"] != "") {
        $(".previsualizarEditar").attr("src", respuesta["foto"]);
      } else {
        $(".previsualizarEditar").attr("src", "vistas/img/usuarios/default/anonymous.png");
      }
    },
  });
});

$(document).on("click", "#togglePassword", function () {
  var input = $("#editarPassword");
  var icon = $(this).find("i");
  var mostrarPassword = input.attr("type") === "password";

  input.attr("type", mostrarPassword ? "text" : "password");
  icon.toggleClass("fa-eye", mostrarPassword);
  icon.toggleClass("fa-eye-slash", !mostrarPassword);
});

$(".nuevaFoto").on("change", function () {
  var reader = new FileReader();
  var archivo = this.files[0];
  var $input = $(this);

  if (!archivo) {
    return;
  }

  reader.readAsDataURL(archivo);
  reader.onload = function (e) {
    if ($input.attr("name") === "editarFoto") {
      $(".previsualizarEditar").attr("src", e.target.result);
    } else {
      $(".previsualizar").attr("src", e.target.result);
    }
  };
});

$("#modalAgregarUsuario").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
  $(".previsualizar").attr("src", "vistas/img/usuarios/default/anonymous.png");
});

$("#modalEditarUsuario").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
  $("#editarPassword").attr("type", "password");
  $("#togglePassword i").removeClass("fa-eye").addClass("fa-eye-slash");
  $(".previsualizarEditar").attr("src", "vistas/img/usuarios/default/anonymous.png");
});

$(".btnEliminarUsuario").on("click", function () {
  var idUsuario = $(this).attr("idUsuario");
  var imagen = $(this).attr("imagen");

  swal({
    title: "¿Está seguro de eliminar?",
    text: "¡El usuario no podrá ser recuperado!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then(function (result) {
    if (result.value) {
      window.location = "index.php?ruta=usuarios&idUsuario=" + idUsuario + "&imagen=" + imagen;
    }
  });
});