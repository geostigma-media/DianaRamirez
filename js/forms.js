var forms = function () {

  var project_form = $("#project-form");
  var contact_form = $("#contact-form");


  var sendProjectForm = function () {


    if (project_form.valid()) {
      $("#btn-send-project-form").prop('disabled', true);

      $.ajax({
          type: "POST",
          url: "https://dcrsalazar.com/enviar.php",
          data: project_form.serialize()
        })
        .done(function (data) {
          project_form[0].reset();
          console.log(data);

          $("#btn-send-project-form").prop('disabled', false);

          $(".alert").fadeIn();
          setTimeout(function () {
            $(".alert").slideUp();
          }, 4000);


        });
    } else {

    }
  }


  var sendContactForm = function () {

    if (contact_form.valid()) {

      $("#btn-send-contact-form").prop('disabled', true);

      $.ajax({
          type: "POST",
          url: "https://dcrsalazar.com/enviar.php",
          data: contact_form.serialize()
        })
        .done(function (data) {
          contact_form[0].reset();
          console.log(data);


          $("#btn-send-contact-form").prop('disabled', false);

          $(".alert").fadeIn();
          setTimeout(function () {
            $(".alert").slideUp();
          }, 4000);

        });
    } else {

    }
  }

  /* Validación */
  var setValidationFormProject = function () {

    project_form.validate({
      onsubmit: false,
      errorElement: 'span',
      errorClass: 'has-error',
      rules: {
        nombre: {
          required: true
        },
        telefono: {
          required: true,
          digits: true
        },
        correo: {
          required: true,
          email: true
        },

      },
      errorPlacement: function (error, element) { // render error placement for each input type
        var parent = $(element).closest(".form-group");
        var cont = $(element).parent(".input-group");

        parent.addClass('has-error');

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

  }

  var setValidationContactProject = function () {

    contact_form.validate({
      onsubmit: false,
      errorElement: 'span',
      errorClass: 'has-error',
      rules: {
        nombre: {
          required: true
        },
        correo: {
          required: true,
          email: true
        },
        telefono: {
          required: true,
          digits: true
        },
        mensaje: {
          required: true
        },

      },

      success: function (element) {
        element.closest(".form-group").removeClass("has-error");
      },
    });

  }


  return {
    init: function () {

      $("#btn-send-project-form").click(sendProjectForm);
      $("#btn-send-contact-form").click(sendContactForm);

      setValidationFormProject();
      setValidationContactProject();
    }

  }
}();


$(document).ready(function () {
  forms.init();
});
