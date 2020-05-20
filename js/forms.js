$(function () {
  $.datepicker.regional["es"] = {
    closeText: "Cerrar",
    prevText: "< Ant",
    nextText: "Sig >",
    currentText: "Hoy",
    monthNames: [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Septiembre",
      "Octubre",
      "Noviembre",
      "Diciembre",
    ],
    monthNamesShort: [
      "Ene",
      "Feb",
      "Mar",
      "Abr",
      "May",
      "Jun",
      "Jul",
      "Ago",
      "Sep",
      "Oct",
      "Nov",
      "Dic",
    ],
    dayNames: [
      "Domingo",
      "Lunes",
      "Martes",
      "Miércoles",
      "Jueves",
      "Viernes",
      "Sábado",
    ],
    dayNamesShort: ["Dom", "Lun", "Mar", "Mié", "Juv", "Vie", "Sáb"],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
    weekHeader: "Sm",
    dateFormat: "yy-mm-dd",
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: "",
  };
  $.datepicker.setDefaults($.datepicker.regional["es"]);
  $("#fecha").datepicker({
    dateFormat: "yy-mm-dd",
  });
});
var forms = (function () {
  var project_form = $("#project-form");
  var contact_form = $("#contact-form");

  var sendProjectForm = function () {
    if (project_form.valid()) {
      alert("este");
      $("#btn-send-project-form").prop("disabled", true);

      $.ajax({
        type: "POST",
        url: "https://dcrsalazar.com/enviar.php",
        data: project_form.serialize(),
      }).done(function (data) {
        project_form[0].reset();
        $("#btn-send-project-form").prop("disabled", false);
        $(".alert").fadeIn();
        setTimeout(function () {
          $(".alert").slideUp();
        }, 4000);
      });
    }
  };

  var sendContactForm = function () {
    if (contact_form.valid()) {
      $("#btn-send-contact-form").prop("disabled", true);
      let mensaje = $("#message").val();
      let date_start = $("#date_start").val();
      if (mensaje != "") {
        $.ajax({
          type: "POST",
          //url: "https://dcrsalazar.com/enviar.php",
          url: "enviar.php",
          data: contact_form.serialize(),
        }).done(function (data) {
          contact_form[0].reset();
          $("#btn-send-contact-form").prop("disabled", false);
          $(".alert-pregunta").fadeIn();
          setTimeout(function () {
            $(".alert-pregunta").slideUp();
          }, 4000);
        });
      }
      if (date_start != "") {
        $.ajax({
          type: "POST",
          //url: "https://dcrsalazar.com/enviar.php",
          url: "sendcita.php",
          data: contact_form.serialize(),
        }).done(function (data) {
          console.log(data);
          let error = data.replace("<br />", "ERROR");
          //console.log(error);
          let validacionError = error.slice(0, -189);
          console.log(validacionError);

          if (validacionError == "ERROR") {
            //console.log("entro al malo");
            $(".alert-error").fadeIn();
            $("#btn-send-contact-form").prop("disabled", false);
            setTimeout(function () {
              $(".alert-error").slideUp();
            }, 4000);
          } else {
            //console.log("entro al bueno");
            contact_form[0].reset();
            $("#btn-send-contact-form").prop("disabled", false);
            $("#date_start").val("");
            $(".alert-cita").fadeIn();
            $("#btnpagar").show();
            setTimeout(function () {
              $(".alert-cita").slideUp();
            }, 4000);
          }
        });
      }
    }
  };

  /* Validación */
  var setValidationFormProject = function () {
    project_form.validate({
      onsubmit: false,
      errorElement: "span",
      errorClass: "has-error",
      rules: {
        nombre: {
          required: true,
        },
        telefono: {
          required: true,
          digits: true,
        },
        correo: {
          required: true,
          email: true,
        },
      },
      errorPlacement: function (error, element) {
        // render error placement for each input type
        var parent = $(element).closest(".form-group");
        var cont = $(element).parent(".input-group");

        parent.addClass("has-error");

        if (cont.size() > 0) {
          cont.after(error);
        } else {
          element.after(error);
        }
      },
      success: function (element) {
        element.closest(".form-group").removeClass("has-error");
      },
    });
  };

  var setValidationContactProject = function () {
    contact_form.validate({
      onsubmit: false,
      errorElement: "span",
      errorClass: "has-error",
      rules: {
        nombre: {
          required: true,
        },
        correo: {
          required: true,
          email: true,
        },
        telefono: {
          required: true,
          digits: true,
        },
        mensaje: {
          required: true,
        },
      },

      success: function (element) {
        element.closest(".form-group").removeClass("has-error");
      },
    });
  };

  return {
    init: function () {
      $("#btn-send-project-form").click(sendProjectForm);
      $("#btn-send-contact-form").click(sendContactForm);

      setValidationFormProject();
      setValidationContactProject();
    },
  };
})();

$(document).ready(function () {
  forms.init();
});
