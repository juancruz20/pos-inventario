var url = window.location.href;
var ruta = url.split("?ruta=");
if (ruta.length > 1) {
  var menu = ruta[1].split("&");
  $('.sidebar-menu li a[href="' + menu[0] + '"]')
    .closest("li")
    .addClass("active");
}

$(".abrirXML").on("click", function () {
  var archivo = $(this).attr("archivo");
  window.open(archivo, "_blank");
});
