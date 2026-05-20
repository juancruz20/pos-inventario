$(".btnEditarCliente").on("click", function () {
  var idCliente = $(this).attr("idCliente");
  $.ajax({
    url: "ajax/clientes.ajax.php",
    type: "POST",
    data: { idCliente: idCliente },
    dataType: "json",
    success: function (respuesta) {
      $("#idCliente").val(respuesta["id"]);
      $("#editarCliente").val(respuesta["nombre"]);
      $("#editarDocumentoId").val(respuesta["documento"]);
      $("#editarEmail").val(respuesta["email"]);
      $("#editarTelefono").val(respuesta["telefono"]);
      $("#editarDireccion").val(respuesta["direccion"]);
      $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);

      var tipo = respuesta["tipo_comprobante"] || "B";
      $(".editar-tipo-comprobante .tipo-comprobante").css("border-color", "transparent");
      $('.editar-tipo-comprobante .tipo-comprobante[data-tipo="' + tipo + '"]').css("border-color", "#333");
      $("#editarTipoComprobante").val(tipo);

      var totalVentas = parseFloat(respuesta["total_ventas"]) || 0;
      var tipoSugerido = "C";
      if (totalVentas > 100000) {
        tipoSugerido = "A";
      } else if (totalVentas > 50000) {
        tipoSugerido = "B";
      }
      if (totalVentas > 0) {
        $('.editar-tipo-comprobante .tipo-comprobante[data-tipo="' + tipoSugerido + '"]').css("border-color", "#333");
        $("#editarTipoComprobante").val(tipoSugerido);
      }
    },
  });
});

$(".seleccionar-tipo").on("click", function () {
  var container = $(this).closest(".nuevo-tipo-comprobante, .editar-tipo-comprobante");
  container.find(".tipo-comprobante").css("border-color", "transparent");
  $(this).css("border-color", "#333");
  var tipo = $(this).data("tipo");
  var prefix = container.hasClass("nuevo-tipo-comprobante") ? "nuevo" : "editar";
  $("#" + prefix + "TipoComprobante").val(tipo);
});

$("#modalAgregarCliente").on("hidden.bs.modal", function () {
  $(this).find("form")[0].reset();
  $(".nuevo-tipo-comprobante .tipo-comprobante").css("border-color", "transparent");
  $('.nuevo-tipo-comprobante .tipo-comprobante[data-tipo="B"]').css("border-color", "#333");
  $("#nuevoTipoComprobante").val("B");
});
