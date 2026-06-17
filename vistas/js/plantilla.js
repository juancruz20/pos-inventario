var url = window.location.href;
var ruta = url.split("?ruta=");
if (ruta.length > 1) {
  var menu = ruta[1].split("&");
  var $item = $('.sidebar-menu li a[href="' + menu[0] + '"]');
  $item.closest("li").addClass("active");
  // Activar el treeview padre para que el submenu se vea
  $item.parents("li.treeview").addClass("active").addClass("menu-open");
  $item.parents("li.treeview").children(".treeview-menu").show();
}

$(".abrirXML").on("click", function () {
  var archivo = $(this).attr("archivo");
  window.open(archivo, "_blank");
});

// =====================================================================
// DataTables: idioma español por defecto (global, sin dependencia de CDN)
// Aplica a TODAS las tablas DataTable actuales y futuras.
// =====================================================================
if (window.jQuery && jQuery.fn && jQuery.fn.dataTable) {
  jQuery.extend(true, jQuery.fn.dataTable.defaults, {
    language: {
      processing:     "Procesando...",
      lengthMenu:     "Mostrar _MENU_ registros",
      zeroRecords:    "No se encontraron resultados",
      emptyTable:     "Ningún dato disponible en esta tabla",
      info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
      infoFiltered:   "(filtrado de un total de _MAX_ registros)",
      infoPostFix:    "",
      search:         "Buscar:",
      url:            "",
      infoThousands:  ",",
      loadingRecords: "Cargando...",
      paginate: {
        first:    "Primero",
        last:     "Último",
        next:     "Siguiente",
        previous: "Anterior",
      },
      aria: {
        sortAscending:  ": Activar para ordenar la columna de manera ascendente",
        sortDescending: ": Activar para ordenar la columna de manera descendente",
      },
      buttons: {
        copy:   "Copiar",
        colvis: "Visibilidad de columnas",
      },
    },
  });
}

if ($(".tablaProductos").length) {
  $(".tablaProductos").DataTable({
    processing: true,
    ajax: {
      url: "ajax/datatable-productos.ajax.php",
      data: function (d) {
        d.perfilOculto = $("#perfilOculto").val();
      },
    },
    columns: [
      { data: 0, title: "#" },
      { data: 1, title: "Imagen" },
      { data: 2, title: "C\u00f3digo" },
      { data: 3, title: "Descripci\u00f3n" },
      { data: 4, title: "Categor\u00eda" },
      { data: 5, title: "Stock" },
      { data: 6, title: "Control Stock" },
      { data: 7, title: "Precio Venta" },
      { data: 8, title: "Fecha" },
      { data: 9, title: "Acciones" },
    ],
    order: [[0, "asc"]],
    responsive: true,
    autoWidth: false,
    rowCallback: function (row, data) {
      var labels = ["#", "Imagen", "C\u00f3digo", "Descripci\u00f3n", "Categor\u00eda", "Stock", "Control Stock", "Precio Venta", "Fecha", "Acciones"];
      $(row).children("td").each(function (i) {
        if (labels[i]) $(this).attr("data-label", labels[i]);
      });
    }
  });
}

if ($(".tablaEans").length) {
  $(".tablaEans").DataTable({
    processing: true,
    ajax: "ajax/datatable-eans.ajax.php",
    columns: [
      { data: 0, title: "#" },
      { data: 1, title: "C\u00f3digo EAN" },
      { data: 2, title: "Descripci\u00f3n" },
      { data: 3, title: "Producto asociado" },
      { data: 4, title: "Fecha" },
      { data: 5, title: "Acciones" },
    ],
    order: [[0, "asc"]],
    responsive: true,
    autoWidth: false,
    rowCallback: function (row, data) {
      var labels = ["#", "C\u00f3digo EAN", "Descripci\u00f3n", "Producto asociado", "Fecha", "Acciones"];
      $(row).children("td").each(function (i) {
        if (labels[i]) $(this).attr("data-label", labels[i]);
      });
    }
  });
}

if ($(".tablaVentas").length) {
  $(".tablaVentas").DataTable({
    processing: true,
    ajax: "ajax/datatable-ventas.ajax.php",
    columns: [
      { data: 0 },
      { data: 1 },
      { data: 2 },
      { data: 3 },
      { data: 4 },
      { data: 5 },
    ],
    order: [[0, "asc"]],
    responsive: true,
    autoWidth: false,
  });
}
