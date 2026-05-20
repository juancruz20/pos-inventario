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
      $("#editarPassword").val(respuesta["password"]);
      $("#editarPerfil").val(respuesta["perfil"]);
      $("#idUsuario").val(respuesta["id"]);
      $("#imagenActual").val(respuesta["imagen"]);
      if (respuesta["imagen"] != "") {
        $(".previsualizar").attr("src", respuesta["imagen"]);
      }
    },
  });
});

$(".nuevaImagen").on("change", function () {
  var reader = new FileReader();
  reader.readAsDataURL(this.files[0]);
  reader.onload = function (e) {
    $(".previsualizar").attr("src", e.target.result);
  };
});

$("#modalAgregarUsuario").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
  $(".previsualizar").attr("src", "vistas/img/usuarios/default/anonymous.png");
});

$("#modalEditarUsuario").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
  $(".previsualizar").attr("src", "vistas/img/usuarios/default/anonymous.png");
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
