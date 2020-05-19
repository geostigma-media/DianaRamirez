$("#btnAgendarCita").click(function () {
  $("#preguntas").hide();
  $("#agendarCita").show();
});
$("#btnPreguntas").click(function () {
  $("#preguntas").show();
  $("#agendarCita").hide();
});
let choices = ["00", "30"];
let $input = $(".clock").clockpicker({
  default: "now",
  placement: "top",
  align: "right",
  donetext: "Listo",
  autoclose: false,
  twelvehour: true,
  vibrate: true,
  fromnow: 0,
  toggleView: "hours",
  afterShow: function () {
    $(".clockpicker-minutes")
      .find(".clockpicker-tick")
      .filter(function (index, element) {
        return !($.inArray($(element).text(), choices) != -1);
      })
      .remove();
  },
});
$("#hora").change(function () {
  let fecha = $("#fecha").val();
  let hora = $("#hora").val();
  let horafecha_pm_am = fecha + " " + hora;
  let horafechacorrecta = horafecha_pm_am.slice(0, -2);

  $("#date_start").val(horafechacorrecta);
});
if ($("#cita").length) {
  $("#cita").validate({
    onkeyup: false,
    rules: {
      nombre: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      fecha: {
        required: true,
      },
      hora: {
        required: true,
      },
    },
    /*submitHandler: function (form) {
      $("#enviar").prop("disabled", true);
      $.ajax({
        type: "POST",
        url: "calendario.php",
        data: $("#cita").serialize(),
      }).done(function (data) {
        form.reset();
        //window.location.replace("https://dcrsalazar.com");
        alert("Su cita se agendo con exito");
        $("#enviar").prop("disabled", false);
      });
    },*/
  });
}
jQuery.extend(jQuery.validator.messages, {
  required: "Este campo es obligatorio.",
  remote: "Por favor, rellena este campo.",
  email: "Por favor, escribe una dirección de correo válida",
  url: "Por favor, escribe una URL válida.",
  date: "Por favor, escribe una fecha válida.",
  dateISO: "Por favor, escribe una fecha (ISO) válida.",
  number: "Por favor, escribe un número entero válido.",
  digits: "Por favor, escribe sólo dígitos.",
  creditcard: "Por favor, escribe un número de tarjeta válido.",
  equalTo: "Por favor, escribe el mismo valor de nuevo.",
  accept: "Por favor, escribe un valor con una extensión aceptada.",
  maxlength: jQuery.validator.format(
    "Por favor, no escribas más de {0} caracteres."
  ),
  minlength: jQuery.validator.format(
    "Por favor, no escribas menos de {0} caracteres."
  ),
  rangelength: jQuery.validator.format(
    "Por favor, escribe un valor entre {0} y {1} caracteres."
  ),
  range: jQuery.validator.format(
    "Por favor, escribe un valor entre {0} y {1}."
  ),
  max: jQuery.validator.format(
    "Por favor, escribe un valor menor o igual a {0}."
  ),
  min: jQuery.validator.format(
    "Por favor, escribe un valor mayor o igual a {0}."
  ),
});
