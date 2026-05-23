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
      { data: 0 },
      { data: 1 },
      { data: 2 },
      { data: 3 },
      { data: 4 },
      { data: 5 },
      { data: 6 },
      { data: 7 },
      { data: 8 },
      { data: 9 },
      { data: 10 },
    ],
    order: [[0, "asc"]],
    responsive: true,
    autoWidth: false,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
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
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
  });
}
