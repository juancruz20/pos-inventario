$("#daterange-btn").on("apply.daterangepicker", function (ev, picker) {
  var inicio = picker.startDate.format("YYYY-MM-DD");
  var fin = picker.endDate.format("YYYY-MM-DD");
  window.location = "index.php?ruta=reportes&fechaInicial=" + inicio + "&fechaFinal=" + fin;
});
