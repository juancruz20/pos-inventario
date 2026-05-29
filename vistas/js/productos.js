$(".tablaProductos").on("click", ".btnEditarProducto", function () {
  var idProducto = $(this).attr("idProducto");
  $.ajax({
    url: "ajax/productos.ajax.php",
    type: "POST",
    data: { idProducto: idProducto, editarProducto: true },
    dataType: "json",
    success: function (respuesta) {
      $("#editarCodigo").val(respuesta["codigo"]);
      $("#editarDescripcion").val(respuesta["descripcion"]);
      $("#editarStock").val(respuesta["stock"]);
      $("#editarPrecioVenta").val(respuesta["precio_venta"]);
      var categoriaNombre = respuesta["categoria"] || respuesta["id_categoria"];
      $("#editarCategoria").html("<option value='" + respuesta["id_categoria"] + "'>" + categoriaNombre + "</option>");
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

$("#modalAgregarProducto").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
  $(".previsualizar").attr("src", "vistas/img/productos/default/anonymous.png");
});

$("#modalEditarProducto").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
  $(".previsualizar").attr("src", "vistas/img/productos/default/anonymous.png");
});

$(".tablaProductos").on("click", ".btnEliminarProducto", function () {
  var idProducto = $(this).attr("idProducto");
  var codigo = $(this).attr("codigo");
  var imagen = $(this).attr("imagen");
  swal({
    title: "¿Está seguro de eliminar?",
    text: "¡El producto no podrá ser recuperado!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then(function (result) {
    if (result.value) {
      window.location = "index.php?ruta=productos&idProducto=" + idProducto + "&codigo=" + codigo + "&imagen=" + imagen;
    }
  });
});

$(".tablaProductos").on("click", ".btn-actualizar-stock", function () {
  var id = $(this).data("id");
  var input = $(this).closest(".input-group").find(".input-actualizar-stock");
  var cantidad = parseInt(input.val());
  if (isNaN(cantidad) || cantidad === 0) {
    swal({ type: "error", title: "Ingrese una cantidad válida", showConfirmButton: true });
    return;
  }
  $.ajax({
    url: "ajax/actualizar-stock.ajax.php",
    type: "POST",
    data: { idProducto: id, cantidad: cantidad },
    dataType: "json",
    success: function (r) {
      if (r == "ok") {
        swal({ type: "success", title: "Stock actualizado", showConfirmButton: true }).then(function () {
          location.reload();
        });
      } else if (r == "stock_negativo") {
        swal({ type: "error", title: "El stock no puede ser negativo", showConfirmButton: true });
      } else {
        swal({ type: "error", title: "Error al actualizar stock", showConfirmButton: true });
      }
    },
  });
});
