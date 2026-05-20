$(".btnEditarCategoria").on("click", function () {
  var idCategoria = $(this).attr("idCategoria");
  $.ajax({
    url: "ajax/categorias.ajax.php",
    type: "POST",
    data: { idCategoria: idCategoria, editarCategoria: true },
    dataType: "json",
    success: function (respuesta) {
      $("#editarCategoria").val(respuesta["categoria"]);
      $("#idCategoria").val(respuesta["id"]);
    },
  });
});

$("#modalAgregarCategoria").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
});

$("#modalEditarCategoria").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
});

$(".btnEliminarCategoria").on("click", function () {
  var idCategoria = $(this).attr("idCategoria");
  swal({
    title: "¿Está seguro de eliminar?",
    text: "¡La categoría no podrá ser recuperada!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then(function (result) {
    if (result.value) {
      window.location = "index.php?ruta=categorias&idCategoria=" + idCategoria;
    }
  });
});
