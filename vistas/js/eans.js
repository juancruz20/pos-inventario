/*=============================================
EDITAR EAN
=============================================*/

$(".tablaEans").on("click", ".btnEditarEan", function () {
  var idEan = $(this).attr("idEan");
  $.ajax({
    url: "ajax/eans.ajax.php",
    type: "POST",
    data: { idEan: idEan },
    dataType: "json",
    success: function (respuesta) {
      $("#editarIdEan").val(respuesta["id"]);
      $("#editarCodigoEan").val(respuesta["codigo_ean"]);
      $("#editarDescripcionEan").val(respuesta["descripcion"]);
      $("#editarIdProductoEan").val(respuesta["id_producto"] != null ? respuesta["id_producto"] : "");
    },
  });
});

/*=============================================
ELIMINAR EAN
=============================================*/

$(".tablaEans").on("click", ".btnEliminarEan", function () {
  var idEan = $(this).attr("idEan");
  swal({
    title: "¿Está seguro de eliminar este EAN?",
    text: "¡El EAN no podrá ser recuperado!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then(function (result) {
    if (result.value) {
      window.location = "index.php?ruta=eans&idEan=" + idEan;
    }
  });
});

/*=============================================
RESET MODALES
=============================================*/

$("#modalAgregarEan").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
});
