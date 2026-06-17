(function () {
  "use strict";

  const ScannerCodigo = {
    modalCargado: false,
    instancia: null,
    escaneando: false,

    _asegurarModal: function () {
      if (this.modalCargado) return;
      const html = [
        '<div class="modal fade" id="modalScannerCodigo" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">',
        '  <div class="modal-dialog modal-dialog-centered">',
        '    <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">',
        '      <div class="modal-header" style="background:#2563EB; color:white; padding:16px 20px;">',
        '        <h4 class="modal-title" style="font-size:16px; font-weight:600; font-family:Inter,sans-serif;"><i class="fa fa-camera" style="margin-right:8px;"></i> Escanear codigo de barras</h4>',
        '        <button type="button" class="close btn-cerrar-scanner" aria-label="Cerrar" style="color:white; opacity:0.8; font-size:24px;"><span>&times;</span></button>',
        '      </div>',
        '      <div class="modal-body text-center" style="padding:20px; font-family:Inter,sans-serif;">',
        '        <div id="scanner-reader" style="width:100%; max-width:400px; margin:0 auto; border-radius:12px; overflow:hidden;"></div>',
        '        <p id="scanner-status" class="text-muted" style="font-size:13px; margin-top:12px;">Iniciando camara...</p>',
        '        <p class="text-muted" style="font-size:11px; margin-top:6px;">Apunta al codigo de barras del producto.</p>',
        '      </div>',
        '    </div>',
        '  </div>',
        '</div>'
      ].join("\n");
      $("body").append(html);
      this.modalCargado = true;

      const self = this;
      $(document).on("click", "#modalScannerCodigo .btn-cerrar-scanner", function () {
        self.cerrar();
      });
      $("#modalScannerCodigo").on("hidden.bs.modal", function () {
        self._detener();
      });
    },

    _getCameraConfig: function () {
      // Try back camera first, then front camera
      if (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices) {
        return { facingMode: "environment" };
      }
      // Fallback: just try any camera
      return undefined;
    },

    abrir: function (opts) {
      const self = this;
      const op = opts || {};
      const onScan = typeof op.onScan === "function" ? op.onScan : null;

      this._asegurarModal();
      $("#scanner-status")
        .removeClass("text-danger text-success")
        .addClass("text-muted")
        .text("Iniciando camara...");
      $("#modalScannerCodigo").modal("show");

      if (typeof Html5Qrcode === "undefined") {
        $("#scanner-status")
          .removeClass("text-muted")
          .addClass("text-danger")
          .html("<i class='fa fa-exclamation-triangle'></i> La libreria de camara no esta cargada. Recarga la pagina.");
        return;
      }

      // Check if browser supports camera
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        $("#scanner-status")
          .removeClass("text-muted")
          .addClass("text-danger")
          .html("<i class='fa fa-exclamation-triangle'></i> Tu navegador no soporta acceso a la camara.<br><small style='margin-top:6px;display:block;'>Prueba con Chrome, Firefox o Edge.</small>");
        return;
      }

      $("#scanner-reader").empty();
      try {
        this.instancia = new Html5Qrcode("scanner-reader");
      } catch (e) {
        $("#scanner-status")
          .removeClass("text-muted")
          .addClass("text-danger")
          .html("<i class='fa fa-exclamation-triangle'></i> No se pudo iniciar la camara: " + (e && e.message ? e.message : e));
        return;
      }

      const config = { fps: 10, qrbox: { width: 280, height: 150 }, aspectRatio: 1.777 };

      // Try back camera first
      this.instancia
        .start(
          { facingMode: "environment" },
          config,
          function (decodedText) {
            if (!self.escaneando) return;
            self.escaneando = false;
            $("#scanner-status")
              .removeClass("text-muted text-danger")
              .addClass("text-success")
              .html("<i class='fa fa-check-circle'></i> Codigo detectado!");
            if (onScan) {
              try {
                onScan(decodedText);
              } catch (e) {
                console.error("ScannerCodigo onScan error:", e);
              }
            }
            setTimeout(function () {
              self.cerrar();
            }, 300);
          },
          function () {}
        )
        .then(function () {
          self.escaneando = true;
          $("#scanner-status")
            .removeClass("text-muted text-danger")
            .html("<i class='fa fa-camera'></i> Apunta al codigo de barras");
        })
        .catch(function (err) {
          // Back camera failed, try front camera
          self._intentarCamaraFrontal(config, onScan, err);
        });
    },

    _intentarCamaraFrontal: function (config, onScan, originalError) {
      const self = this;
      // Try with any available camera (front)
      self.instancia
        .start(
          { facingMode: "user" },
          config,
          function (decodedText) {
            if (!self.escaneando) return;
            self.escaneando = false;
            $("#scanner-status")
              .removeClass("text-muted text-danger")
              .addClass("text-success")
              .html("<i class='fa fa-check-circle'></i> Codigo detectado!");
            if (onScan) {
              try {
                onScan(decodedText);
              } catch (e) {
                console.error("ScannerCodigo onScan error:", e);
              }
            }
            setTimeout(function () {
              self.cerrar();
            }, 300);
          },
          function () {}
        )
        .then(function () {
          self.escaneando = true;
          $("#scanner-status")
            .removeClass("text-muted text-danger")
            .html("<i class='fa fa-camera'></i> Apunta al codigo de barras (camara frontal)");
        })
        .catch(function (err2) {
          // Both cameras failed
          self._mostrarErrorCamara(originalError, err2);
        });
    },

    _mostrarErrorCamara: function (errBack, errFront) {
      var raw = "";
      if (errFront && (errFront.message || errFront)) {
        raw = String(errFront.message || errFront);
      } else if (errBack && (errBack.message || errBack)) {
        raw = String(errBack.message || errBack);
      }

      var msg = "No se pudo acceder a la camara.";
      var detail = "";

      if (/Permission|NotAllowed|denied|security|Permission denied/i.test(raw)) {
        msg = "Permiso de camara denegado";
        detail = "Habilita el permiso de camara en la configuracion de tu navegador.";
      } else if (/NotFound|not found|Requested device|DevicesNotFound/i.test(raw)) {
        msg = "No se detecto ninguna camara";
        detail = "Verifica que tu dispositivo tenga camara disponible.";
      } else if (/secure|https/i.test(raw)) {
        msg = "Se requiere HTTPS";
        detail = "La camara solo funciona en conexiones seguras (HTTPS).";
      } else if (/Overconstrained|Constraints/i.test(raw)) {
        msg = "Camara no compatible";
        detail = "Tu camara no cumple los requisitos minimos.";
      } else if (raw) {
        detail = "Error: " + raw;
      }

      $("#scanner-status")
        .removeClass("text-muted text-success")
        .addClass("text-danger")
        .html("<i class='fa fa-exclamation-triangle'></i> " + msg +
          (detail ? "<br><small style='margin-top:6px;display:block;'>" + detail + "</small>" : ""));
    },

    cerrar: function () {
      $("#modalScannerCodigo").modal("hide");
      this._detener();
    },

    _detener: function () {
      const self = this;
      this.escaneando = false;
      if (!this.instancia) {
        $("#scanner-reader").empty();
        return;
      }
      const inst = this.instancia;
      this.instancia = null;
      try {
        if (inst.isScanning) {
          inst
            .stop()
            .then(function () {
              try { inst.clear(); } catch (e) {}
              $("#scanner-reader").empty();
            })
            .catch(function () {
              try { inst.clear(); } catch (e) {}
              $("#scanner-reader").empty();
            });
        } else {
          try { inst.clear(); } catch (e) {}
          $("#scanner-reader").empty();
        }
      } catch (e) {
        try { inst.clear(); } catch (e) {}
        $("#scanner-reader").empty();
      }
    }
  };

  window.ScannerCodigo = ScannerCodigo;
})();
