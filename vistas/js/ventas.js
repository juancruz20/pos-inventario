var baseVentas = {};

baseVentas.agregarProducto = function () {
  var codigo = $("#nuevoCodigo").val();
  if (codigo == "") {
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
      } else {
        swal({ type: "error", title: "El producto no existe", showConfirmButton: true, confirmButtonText: "Cerrar" });
      }
    },
  });
};

baseVentas.listarProductos = function (producto) {
  var fila = `
    <div class="row" style="padding:10px; margin:0; background:#f9f9f9; border-bottom:1px solid #ddd;">
      <div class="col-xs-6" style="padding-right:3px;">
        <div class="input-group input-group-sm">
          <span class="input-group-addon">${producto["descripcion"]}</span>
          <input type="text" class="form-control ingresoPrecio" value="${producto["precio_venta"]}" data-id="${producto["id"]}" data-stock="${producto["stock"]}" readonly>
        </div>
      </div>
      <div class="col-xs-3" style="padding:0 3px;">
        <input type="number" class="form-control input-sm ingresoCantidad" value="1" min="1" data-stock="${producto["stock"]}">
      </div>
      <div class="col-xs-3" style="padding-left:3px;">
        <button type="button" class="btn btn-danger btn-xs quitarProducto"><i class="fa fa-times"></i></button>
      </div>
    </div>`;
  $(".nuevoProducto").append(fila);

  var stock = parseInt(producto["stock"]);
  var stockActual = stock;

  $(".ingresoCantidad").off("change").on("change", function () {
    var cant = parseInt($(this).val()) || 1;
    var disp = parseInt($(this).data("stock"));
    if (cant > disp) {
      swal({ type: "error", title: "Stock insuficiente. Disponible: " + disp, showConfirmButton: true, confirmButtonText: "Cerrar" });
      $(this).val(disp);
    }
    baseVentas.sumarTotalPrecios();
    baseVentas.agregarImpuesto();
  });

  $(".quitarProducto").off("click").on("click", function () {
    $(this).closest(".row").remove();
    baseVentas.sumarTotalPrecios();
    baseVentas.agregarImpuesto();
  });

  baseVentas.sumarTotalPrecios();
  baseVentas.agregarImpuesto();
};

baseVentas.sumarTotalPrecios = function () {
  var total = 0;
  $(".ingresoPrecio").each(function () {
    var precio = parseFloat($(this).val()) || 0;
    var cantidad = parseInt($(this).closest(".row").find(".ingresoCantidad").val()) || 1;
    total += precio * cantidad;
  });
  if ($("#checkRopaPredeterminada").is(":checked")) {
    var ropaPrecio = parseFloat($("#ropaPrecio").val()) || 0;
    total += ropaPrecio;
  }
  $("#nuevoTotalVenta").val(total.toFixed(2));
};

baseVentas.agregarImpuesto = function () {
  var total = 0;
  $(".ingresoPrecio").each(function () {
    var precio = parseFloat($(this).val()) || 0;
    var cantidad = parseInt($(this).closest(".row").find(".ingresoCantidad").val()) || 1;
    total += precio * cantidad;
  });
  if ($("#checkRopaPredeterminada").is(":checked")) {
    var ropaPrecio = parseFloat($("#ropaPrecio").val()) || 0;
    total += ropaPrecio;
  }
  var iva = total * 0.19;
  var neto = total - iva;
  $("#nuevoPrecioImpuesto").val(iva.toFixed(2));
  $("#nuevoPrecioNeto").val(neto.toFixed(2));
  $("#totalVenta").val(total.toFixed(2));
};

$(".btnAgregarProducto").on("click", function () {
  baseVentas.agregarProducto();
});

$("#nuevoCodigo").on("keydown", function (e) {
  if (e.keyCode == 13) {
    e.preventDefault();
    baseVentas.agregarProducto();
    $("#nuevoCodigo").val("");
  }
});

$(".formularioVenta").on("submit", function () {
  var productos = [];
  var items = $(".nuevoProducto").children(".row");
  items.each(function () {
    var precio = parseFloat($(this).find(".ingresoPrecio").val()) || 0;
    var cantidad = parseInt($(this).find(".ingresoCantidad").val()) || 1;
    var id = $(this).find(".ingresoPrecio").data("id");
    var desc = $(this).find(".ingresoPrecio").attr("value");
    var stock = $(this).find(".ingresoPrecio").data("stock");
    productos.push({
      id: id,
      descripcion: desc,
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
      descripcion: "Ropa predeterminada",
      precio_venta: ropaPrecio,
      precio: ropaPrecio,
      cantidad: 1,
      total: ropaPrecio,
      stock: 9999,
    });
  }
  $("#listaProductos").val(JSON.stringify(productos));
  $("#nuevoTotalVenta").prop("readonly", false);
});

$("#checkRopaPredeterminada").on("change", function () {
  if ($(this).is(":checked")) {
    $("#ropaPrecioGroup").show();
  } else {
    $("#ropaPrecioGroup").hide();
    $("#ropaPrecio").val(0);
  }
  baseVentas.sumarTotalPrecios();
  baseVentas.agregarImpuesto();
});

$("#ropaPrecio").on("input", function () {
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
