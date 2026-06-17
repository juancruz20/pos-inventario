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
  var isMobile = window.innerWidth <= 767;

  var $filaExistente = $('.nuevoProducto .producto-item-venta[data-id="' + idProducto + '"]');
  if ($filaExistente.length) {
    var $cantidadExistente = $filaExistente.find(".ingresoCantidad");
    var nuevaCantidad = (parseInt($cantidadExistente.val(), 10) || 1) + 1;
    if (stock > 0 && nuevaCantidad > stock) {
      nuevaCantidad = stock;
      swal({ type: "error", title: "Existencias insuficientes. Disponible: " + stock, showConfirmButton: true, confirmButtonText: "Cerrar" });
    }
    $cantidadExistente.val(nuevaCantidad).trigger("change");
    return;
  }

  var fila;
  if (isMobile) {
    fila = '<div class="producto-item-venta" data-id="' + idProducto + '">' +
      '<div class="card-item-top">' +
        '<span class="producto-descripcion-caja" title="' + descripcion + '">' + descripcion + '</span>' +
        '<button type="button" class="btn quitarProducto"><i class="fa fa-times"></i></button>' +
      '</div>' +
      '<div class="card-item-bottom">' +
        '<input type="text" class="form-control ingresoPrecio" value="' + precioVisual + '" data-id="' + idProducto + '" data-stock="' + stock + '" data-descripcion="' + descripcion + '" readonly>' +
        '<div class="qty-controls">' +
          '<button type="button" class="qty-btn minus" data-action="minus"><i class="fa fa-minus"></i></button>' +
          '<input type="number" class="qty-value ingresoCantidad" value="1" min="1" data-stock="' + stock + '">' +
          '<button type="button" class="qty-btn plus" data-action="plus"><i class="fa fa-plus"></i></button>' +
        '</div>' +
      '</div>' +
    '</div>';
  } else {
    fila = '<div class="row producto-item-venta" data-id="' + idProducto + '">' +
      '<div class="col-xs-4" style="padding-right:4px;">' +
        '<span class="form-control producto-descripcion-caja" title="' + descripcion + '">' + descripcion + '</span>' +
      '</div>' +
      '<div class="col-xs-3" style="padding:0 4px;">' +
        '<input type="text" class="form-control ingresoPrecio" value="' + precioVisual + '" data-id="' + idProducto + '" data-stock="' + stock + '" data-descripcion="' + descripcion + '" readonly>' +
      '</div>' +
      '<div class="col-xs-3" style="padding:0 4px;">' +
        '<input type="number" class="form-control ingresoCantidad" value="1" min="1" data-stock="' + stock + '">' +
      '</div>' +
      '<div class="col-xs-2" style="padding-left:4px;">' +
        '<button type="button" class="btn btn-danger btn-xs quitarProducto"><i class="fa fa-times"></i></button>' +
      '</div>' +
    '</div>';
  }

  $(".nuevoProducto").show().append(fila);

  baseVentas.syncBottomBar();
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

  $("#nuevoTotalVenta").val(total.toFixed(2));
  baseVentas.syncBottomBar();
};

// Genera el HTML de una nueva fila vacía de concepto extra.
baseVentas.filaConceptoVacia = function () {
  var existentes = $(".concepto-extra-list .concepto-extra-row").length;
  var nuevoIndex = existentes + 1;
  return (
    '<div class="concepto-extra-row" data-row="' + nuevoIndex + '">' +
      '<input type="text" class="form-control concepto-extra-desc" placeholder="Descripción (Ej: Ropa)" maxlength="60">' +
      '<div class="input-group concepto-extra-price">' +
        '<span class="input-group-addon" style="background:#f4f4f4;color:#999;font-weight:600;">$</span>' +
        '<input type="number" class="form-control concepto-extra-precio" placeholder="0" step="any" min="0">' +
      '</div>' +
      '<button type="button" class="btn btn-primary btn-sm concepto-extra-agregar" title="Agregar a la venta">' +
        '<i class="fa fa-plus"></i> Agregar' +
      '</button>' +
      '<button type="button" class="btn btn-default btn-sm concepto-extra-quitar" title="Quitar esta fila">' +
        '<i class="fa fa-times"></i>' +
      '</button>' +
    '</div>'
  );
};

// Actualiza el estado del botón "Quitar" en cada fila
// (queda deshabilitado cuando hay una sola fila).
baseVentas.refrescarBotonesQuitar = function () {
  var total = $(".concepto-extra-list .concepto-extra-row").length;
  $(".concepto-extra-list .concepto-extra-quitar").each(function () {
    var $btn = $(this);
    var $row = $btn.closest(".concepto-extra-row");
    if (total <= 1) {
      $btn.prop("disabled", true);
    } else {
      $btn.prop("disabled", false);
    }
  });
};

// Lee los datos de una fila y agrega el concepto como producto a la venta.
baseVentas.agregarConceptoExtra = function ($row) {
  if (!$row || !$row.length) {
    return false;
  }
  var descripcion = $.trim($row.find(".concepto-extra-desc").val());
  var precio = parseFloat($row.find(".concepto-extra-precio").val()) || 0;

  if (descripcion === "") {
    swal({
      type: "warning",
      title: "Ingrese una descripción para el concepto extra",
      showConfirmButton: true,
      confirmButtonText: "Cerrar",
    });
    $row.find(".concepto-extra-desc").focus();
    return false;
  }
  if (!(precio > 0)) {
    swal({
      type: "warning",
      title: "Ingrese un precio mayor a 0",
      showConfirmButton: true,
      confirmButtonText: "Cerrar",
    });
    $row.find(".concepto-extra-precio").focus();
    return false;
  }

  var idUnico = "concepto-" + Date.now() + "-" + Math.floor(Math.random() * 1000);
  baseVentas.listarProductos({
    id: idUnico,
    descripcion: descripcion,
    precio_venta: precio,
    precio: precio,
    stock: 9999,
    cantidad: 1,
    total: precio,
  });

  // Limpia la fila para que el usuario pueda cargar otro concepto.
  $row.find(".concepto-extra-desc").val("").focus();
  $row.find(".concepto-extra-precio").val("");
  return true;
};

baseVentas.agregarImpuesto = function () {
  var total = parseFloat($("#nuevoTotalVenta").val()) || 0;
  var iva = total * 0.19;
  var neto = total - iva;

  $("#nuevoPrecioImpuesto").val(iva.toFixed(2));
  $("#nuevoPrecioNeto").val(neto.toFixed(2));
  $("#totalVenta").val(total.toFixed(2));
};

// === SYNC BOTTOM BAR ===
baseVentas.syncBottomBar = function () {
  var total = parseFloat($("#nuevoTotalVenta").val()) || 0;
  var formatted = "$" + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  $(".mobile-bottom-bar .total-amount").text(formatted);
};

// === BOTTOM BAR SUBMIT ===
$(document).on("click", "#btnFinalizarVenta", function () {
  $(".formularioVenta").submit();
});

// === QTY +/- HANDLERS ===
$(document).on("click", ".qty-btn", function () {
  var $btn = $(this);
  var $input = $btn.closest(".qty-controls").find(".ingresoCantidad");
  var current = parseInt($input.val(), 10) || 1;
  var stock = parseInt($input.data("stock"), 10) || 0;
  var action = $btn.data("action");

  if (action === "plus") {
    current++;
    if (stock > 0 && current > stock) {
      current = stock;
      swal({ type: "error", title: "Existencias insuficientes. Disponible: " + stock, showConfirmButton: true, confirmButtonText: "Cerrar" });
    }
  } else if (action === "minus") {
    current--;
    if (current < 1) current = 1;
  }

  $input.val(current).trigger("change");
});

// === PRODUCT SUGGESTION CARDS (MOBILE) ===
baseVentas.cargarProductosCards = function () {
  var $container = $("#productosCardsContainer");
  if (!$container.length || window.innerWidth > 767) return;

  $container.html('<div style="text-align:center;padding:20px;color:#999;"><i class="fa fa-spinner fa-spin"></i> Cargando productos...</div>');

  $.ajax({
    url: "ajax/datatable-productos.ajax.php",
    type: "POST",
    dataType: "json",
    success: function (data) {
      if (!data || !data.data || !data.data.length) {
        $container.html('<div style="text-align:center;padding:20px;color:#999;">No hay productos disponibles</div>');
        return;
      }

      var html = '';
      var items = data.data;
      var limit = Math.min(items.length, 20);
      for (var i = 0; i < limit; i++) {
        var row = items[i];
        var img = row[1] || '';
        var desc = row[3] || 'Producto';
        var stock = parseInt(row[5], 10) || 0;
        var stockClass = stock > 10 ? 'alto' : 'bajo';
        var idMatch = '';
        var actionHtml = row[10] || '';
        var idArr = actionHtml.match(/idProducto=['"](\d+)['"]/);
        if (idArr) idMatch = idArr[1];
        if (!idMatch) continue;

        var precioRaw = row[7] || '';
        var precioMatch = String(precioRaw).replace(/<[^>]*>/g, '').replace(/[^0-9.,]/g, '').replace(',', '.');
        var precioNum = parseFloat(precioMatch) || 0;
        var precioFmt = "$" + precioNum.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        html += '<div class="producto-sugerido-card">' +
          '<div class="card-producto-top">' +
            '<div class="card-producto-img-wrap">' + img + '</div>' +
            '<div class="card-producto-info">' +
              '<div class="card-producto-nombre">' + desc + '</div>' +
              '<div class="card-producto-stock ' + stockClass + '">Stock: ' + stock + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="card-producto-bottom">' +
            '<span class="card-producto-precio">' + precioFmt + '</span>' +
            '<button class="card-btn-agregar agregarProducto" idProducto="' + idMatch + '">' +
              '<i class="fa fa-plus"></i> Agregar' +
            '</button>' +
          '</div>' +
        '</div>';
      }
      $container.html(html);
    },
    error: function () {
      $container.html('<div style="text-align:center;padding:20px;color:#EF4444;">Error al cargar productos</div>');
    }
  });
};

$(".btnAgregarProducto").on("click", function () {
  baseVentas.agregarProductoPorCodigo();
});

$("#nuevoCodigo").on("keydown", function (e) {
  if (e.key === "Enter" || e.keyCode === 13) {
    e.preventDefault();
    baseVentas.agregarProductoPorCodigo();
  }
});

$(document).on("click", ".btn-scanner-codigo", function () {
  var $btn = $(this);
  var selector = $btn.attr("data-target-input");
  if (!selector) return;
  if (typeof window.ScannerCodigo === "undefined") {
    swal({
      type: "error",
      title: "El esc\u00e1ner de c\u00e1mara no est\u00e1 disponible",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    });
    return;
  }
  window.ScannerCodigo.abrir({
    onScan: function (codigo) {
      var $input = $(selector);
      if (!$input.length) return;
      $input.val(codigo).trigger("change");
      $input.focus();
    }
  });
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

// Mostrar/ocultar el campo de teléfono cuando el método de pago
// es "Transferencia" (TR). Para los demás métodos se oculta y se vacía.
baseVentas.actualizarCampoTransferencia = function () {
  var metodo = $("#nuevoMetodoPago").val();
  var $detalle = $(".nuevoMetodoPagoDetalle");
  var $input = $("#nuevoMetodoPagoDetalle");
  if (metodo === "TR") {
    $detalle.show();
    $input.prop("required", true);
  } else {
    $detalle.hide();
    $input.prop("required", false);
    $input.val("");
  }
};
$("#nuevoMetodoPago").on("change", function () {
  baseVentas.actualizarCampoTransferencia();
});
baseVentas.actualizarCampoTransferencia();

// Evitar que la tecla Enter envíe el formulario "Crear Venta".
// Por defecto, al presionar Enter dentro de cualquier input se dispara
// el submit del form. Aquí se bloquea esa acción; el único Enter que
// debe seguir funcionando es el del campo de código (#nuevoCodigo),
// que ya tiene su propio handler arriba y se ejecuta antes de burbujear.
$(document).on("keydown", ".formularioVenta", function (e) {
  if (e.key === "Enter" || e.keyCode === 13) {
    var target = e.target;
    var tag = (target && target.tagName ? target.tagName : "").toLowerCase();
    if (tag === "textarea") {
      return true;
    }
    e.preventDefault();
    return false;
  }
});

$(document).on("change", ".ingresoCantidad", function () {
  var cantidad = parseInt($(this).val(), 10) || 1;
  var stock = parseInt($(this).data("stock"), 10) || 0;

  if (cantidad < 1) {
    cantidad = 1;
  }

  if (stock > 0 && cantidad > stock) {
    swal({ type: "error", title: "Existencias insuficientes. Disponible: " + stock, showConfirmButton: true, confirmButtonText: "Cerrar" });
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
  baseVentas.syncBottomBar();
});

$(".formularioVenta").on("submit", function () {
  baseVentas.syncBottomBar();
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

  $("#listaProductos").val(JSON.stringify(productos));
  $("#listaMetodoPago").val($("#nuevoMetodoPago").val());
  $("#listaMetodoPagoDetalle").val($.trim($("#nuevoMetodoPagoDetalle").val() || ""));
  $("#nuevoTotalVenta").prop("readonly", false);
});

$(".btnImprimirFactura").on("click", function () {
  var codigo = $(this).attr("codigoVenta");
  window.open("extensiones/tcpdf/pdf/factura.php?codigo=" + codigo, "_blank");
});

$("#nuevoTotalVenta").on("input", function () {
  var total = parseFloat($(this).val()) || 0;
  var iva = total * 0.19;
  var neto = total - iva;
  $("#nuevoPrecioImpuesto").val(iva.toFixed(2));
  $("#nuevoPrecioNeto").val(neto.toFixed(2));
  $("#totalVenta").val(total.toFixed(2));
  baseVentas.syncBottomBar();
});

// Handlers del bloque "Concepto extra" (múltiples filas)
$(document).on("click", ".concepto-extra-agregar", function () {
  var $row = $(this).closest(".concepto-extra-row");
  baseVentas.agregarConceptoExtra($row);
});

$(document).on("click", ".concepto-extra-quitar", function () {
  var $row = $(this).closest(".concepto-extra-row");
  var total = $(".concepto-extra-list .concepto-extra-row").length;
  if (total <= 1) {
    swal({
      type: "info",
      title: "Debe quedar al menos una fila",
      showConfirmButton: true,
      confirmButtonText: "Cerrar",
    });
    return;
  }
  $row.remove();
  baseVentas.refrescarBotonesQuitar();
});

$(document).on("click", ".concepto-extra-add-fila", function () {
  $(".concepto-extra-list").append(baseVentas.filaConceptoVacia());
  baseVentas.refrescarBotonesQuitar();
  // Foco en la nueva fila para escribir la descripción.
  $(".concepto-extra-list .concepto-extra-row:last .concepto-extra-desc").focus();
});

// Enter sobre la descripción o el precio -> dispara el botón Agregar de esa fila.
$(document).on("keydown", ".concepto-extra-desc, .concepto-extra-precio", function (e) {
  if (e.key === "Enter" || e.keyCode === 13) {
    e.preventDefault();
    var $row = $(this).closest(".concepto-extra-row");
    baseVentas.agregarConceptoExtra($row);
  }
});

baseVentas.refrescarBotonesQuitar();
if ($(".tablaProductosVenta").length && $(".nuevoProducto .producto-item-venta").length === 0) {
  $(".nuevoProducto").hide();
}
baseVentas.sumarTotalPrecios();
baseVentas.agregarImpuesto();
baseVentas.syncBottomBar();

// Load product cards on mobile
if (window.innerWidth <= 767) {
  baseVentas.cargarProductosCards();
}

// Reload cards on resize (debounced)
var resizeTimer;
$(window).on("resize", function () {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function () {
    if (window.innerWidth <= 767) {
      baseVentas.cargarProductosCards();
    } else {
      $("#productosCardsContainer").empty();
    }
  }, 300);
});