var baseVentas = {};

baseVentas.formatearPrecioVisual = function (valor) {
  var numero = parseFloat(valor);
  if (isNaN(numero)) {
    return "0";
  }

  return numero.toFixed(2).replace(/\.00$/, "").replace(/(\.\d)0$/, "$1");
};

baseVentas.agregarProductoPorCodigo = function () {
  var $inputCodigo = $("#nuevoCodigo");

  if (!$inputCodigo.length) {
    return;
  }

  var codigo = $.trim($inputCodigo.val());

  if (codigo === "") {
    swal({ type: "error", title: "Ingrese un código de producto", showConfirmButton: true, confirmButtonText: "Cerrar" });
    return;
  }

  $.ajax({
    url: "ajax/productos.ajax.php",
    type: "POST",
    data: { codigoProducto: codigo, agregarProducto: true },
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        baseVentas.listarProductos(respuesta);
        $inputCodigo.val("");
      } else {
        swal({ type: "error", title: "El producto no existe", showConfirmButton: true, confirmButtonText: "Cerrar" });
      }
    },
  });
};

baseVentas.listarProductos = function (producto) {
  if (!producto) {
    return;
  }

  var idProducto = parseInt(producto["id"], 10) || 0;
  var descripcion = $.trim(String(producto["descripcion"] || "Producto"));
  var precio = parseFloat(producto["precio_venta"]) || 0;
  var stock = parseInt(producto["stock"], 10) || 0;
  var precioVisual = baseVentas.formatearPrecioVisual(precio);

  var $filaExistente = $('.nuevoProducto .producto-item-venta[data-id="' + idProducto + '"]');
  if ($filaExistente.length) {
    var $cantidadExistente = $filaExistente.find(".ingresoCantidad");
    var nuevaCantidad = (parseInt($cantidadExistente.val(), 10) || 1) + 1;
    if (stock > 0 && nuevaCantidad > stock) {
      nuevaCantidad = stock;
      swal({ type: "error", title: "Stock insuficiente. Disponible: " + stock, showConfirmButton: true, confirmButtonText: "Cerrar" });
    }
    $cantidadExistente.val(nuevaCantidad).trigger("change");
    return;
  }

  var fila = `
    <div class="row producto-item-venta" data-id="${idProducto}">
      <div class="col-xs-7" style="padding-right:4px;">
        <div class="input-group">
          <span class="input-group-addon producto-descripcion-caja" title="${descripcion}">${descripcion}</span>
          <input type="text" class="form-control ingresoPrecio" value="${precioVisual}" data-id="${idProducto}" data-stock="${stock}" data-descripcion="${descripcion}" readonly>
        </div>
      </div>
      <div class="col-xs-3" style="padding:0 4px;">
        <input type="number" class="form-control ingresoCantidad" value="1" min="1" data-stock="${stock}">
      </div>
      <div class="col-xs-2" style="padding-left:4px;">
        <button type="button" class="btn btn-danger btn-xs quitarProducto"><i class="fa fa-times"></i></button>
      </div>
    </div>`;
  $(".nuevoProducto").show().append(fila);

  baseVentas.sumarTotalPrecios();
  baseVentas.agregarImpuesto();
};

baseVentas.sumarTotalPrecios = function () {
  var total = 0;

  $(".nuevoProducto .producto-item-venta").each(function () {
    var precio = parseFloat($(this).find(".ingresoPrecio").val()) || 0;
    var cantidad = parseInt($(this).find(".ingresoCantidad").val(), 10) || 1;
    total += precio * cantidad;
  });

  if ($("#checkRopaPredeterminada").is(":checked")) {
    var ropaPrecio = parseFloat($("#ropaPrecio").val()) || 0;
    total += ropaPrecio;
  }

  $("#nuevoTotalVenta").val(total.toFixed(2));
};

baseVentas.agregarImpuesto = function () {
  var total = parseFloat($("#nuevoTotalVenta").val()) || 0;
  var iva = total * 0.19;
  var neto = total - iva;

  $("#nuevoPrecioImpuesto").val(iva.toFixed(2));
  $("#nuevoPrecioNeto").val(neto.toFixed(2));
  $("#totalVenta").val(total.toFixed(2));
};

baseVentas.obtenerDescripcionRopa = function () {
  var $descripcionRopa = $("#ropaDescripcion");
  if ($descripcionRopa.length) {
    var descripcion = $.trim($descripcionRopa.val());
    return descripcion !== "" ? descripcion : "ropa";
  }

  return "Concepto extra";
};

baseVentas.actualizarEstadoRopa = function () {
  var activo = $("#checkRopaPredeterminada").is(":checked");
  $("#ropaPrecioGroup").toggle(activo);

  var $descripcionRopa = $("#ropaDescripcion");
  if ($descripcionRopa.length) {
    $descripcionRopa.prop("disabled", !activo);
  }

  $("#ropaPrecio").prop("disabled", !activo);

  if (!activo) {
    if ($descripcionRopa.length) {
      $descripcionRopa.val("ropa");
    }
    $("#ropaPrecio").val(0);
  }
};

$(".btnAgregarProducto").on("click", function () {
  baseVentas.agregarProductoPorCodigo();
});

$(".tablaVentas, .tablaProductosVenta").on("click", ".agregarProducto", function () {
  var idProducto = $(this).attr("idProducto");

  $.ajax({
    url: "ajax/productos.ajax.php",
    type: "POST",
    data: { idProducto: idProducto },
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        baseVentas.listarProductos(respuesta);
      } else {
        swal({ type: "error", title: "Producto no encontrado", showConfirmButton: true, confirmButtonText: "Cerrar" });
      }
    },
  });
});

$("#nuevoCodigo").on("keydown", function (e) {
  if (e.keyCode === 13) {
    e.preventDefault();
    baseVentas.agregarProductoPorCodigo();
  }
});

$(document).on("change", ".ingresoCantidad", function () {
  var cantidad = parseInt($(this).val(), 10) || 1;
  var stock = parseInt($(this).data("stock"), 10) || 0;

  if (cantidad < 1) {
    cantidad = 1;
  }

  if (stock > 0 && cantidad > stock) {
    swal({ type: "error", title: "Stock insuficiente. Disponible: " + stock, showConfirmButton: true, confirmButtonText: "Cerrar" });
    cantidad = stock;
  }

  $(this).val(cantidad);

  baseVentas.sumarTotalPrecios();
  baseVentas.agregarImpuesto();
});

$(document).on("click", ".quitarProducto", function () {
  var $fila = $(this).closest(".producto-item-venta");
  if (!$fila.length) {
    $fila = $(this).closest(".row");
  }
  $fila.remove();

  if ($(".tablaProductosVenta").length && $(".nuevoProducto .producto-item-venta").length === 0) {
    $(".nuevoProducto").hide();
  }

  baseVentas.sumarTotalPrecios();
  baseVentas.agregarImpuesto();
});

$(".formularioVenta").on("submit", function () {
  var productos = [];

  $(".nuevoProducto .producto-item-venta").each(function () {
    var $fila = $(this);
    var precio = parseFloat($fila.find(".ingresoPrecio").val()) || 0;
    var cantidad = parseInt($fila.find(".ingresoCantidad").val(), 10) || 1;
    var id = parseInt($fila.find(".ingresoPrecio").data("id"), 10) || 0;
    var descripcion = $.trim($fila.find(".producto-descripcion-caja").text());
    if (descripcion === "") {
      descripcion = $.trim(String($fila.find(".ingresoPrecio").data("descripcion") || "Producto"));
    }
    var stock = parseInt($fila.find(".ingresoPrecio").data("stock"), 10) || 0;

    productos.push({
      id: id,
      descripcion: descripcion,
      precio: precio,
      cantidad: cantidad,
      total: precio * cantidad,
      stock: stock,
    });
  });

  if ($("#checkRopaPredeterminada").is(":checked")) {
    var ropaPrecio = parseFloat($("#ropaPrecio").val()) || 0;
    productos.push({
      id: 0,
      descripcion: baseVentas.obtenerDescripcionRopa(),
      precio_venta: ropaPrecio,
      precio: ropaPrecio,
      cantidad: 1,
      total: ropaPrecio,
      stock: 9999,
    });
  }

  $("#listaProductos").val(JSON.stringify(productos));
  $("#listaMetodoPago").val($("#nuevoMetodoPago").val());
  $("#nuevoTotalVenta").prop("readonly", false);
});

$("#checkRopaPredeterminada").on("change", function () {
  baseVentas.actualizarEstadoRopa();
  baseVentas.sumarTotalPrecios();
  baseVentas.agregarImpuesto();
});

$("#ropaPrecio").on("input", function () {
  baseVentas.sumarTotalPrecios();
  baseVentas.agregarImpuesto();
});

$("#ropaDescripcion").on("input", function () {
  baseVentas.sumarTotalPrecios();
  baseVentas.agregarImpuesto();
});

$(".btnImprimirFactura").on("click", function () {
  var codigo = $(this).attr("codigoVenta");
  window.open("extensiones/tcpdf/pdf/factura.php?codigo=" + codigo, "_blank");
});

$(".btnVerVenta").on("click", function () {
  var idVenta = $(this).attr("idVenta");
  $.ajax({
    url: "ajax/ventas.ajax.php",
    type: "POST",
    data: { idVenta: idVenta, verVenta: true },
    dataType: "json",
    success: function (respuesta) {
      $("#modalVerVenta .modal-body").html("");
      var html = "<table class='table table-bordered'>";
      html += "<tr><th>Producto</th><th>Cant</th><th>Precio</th><th>Total</th></tr>";
      var productos = JSON.parse(respuesta["productos"]);
      $.each(productos, function (i, p) {
        html += "<tr><td>" + p.descripcion + "</td><td>" + p.cantidad + "</td><td>$ " + parseFloat(p.precio).toFixed(2) + "</td><td>$ " + parseFloat(p.total).toFixed(2) + "</td></tr>";
      });
      html += "</table>";
      $("#modalVerVenta .modal-body").html(html);
    },
  });
});

$("#nuevoTotalVenta").on("input", function () {
  var total = parseFloat($(this).val()) || 0;
  var iva = total * 0.19;
  var neto = total - iva;
  $("#nuevoPrecioImpuesto").val(iva.toFixed(2));
  $("#nuevoPrecioNeto").val(neto.toFixed(2));
  $("#totalVenta").val(total.toFixed(2));
});

baseVentas.actualizarEstadoRopa();
if ($(".tablaProductosVenta").length && $(".nuevoProducto .producto-item-venta").length === 0) {
  $(".nuevoProducto").hide();
}
baseVentas.sumarTotalPrecios();
baseVentas.agregarImpuesto();