$.validator.setDefaults({
  submitHandler: function () {
    return true;
  }
});

$(document).ready(function (e) {
  $('#userForm').validate({
    rules: {
      fullname: {
        onkeyup: false,
        required: true,
        minlength: 3
      },
      email: {
        onkeyup: false,
        required: true,
        email: true,
//        remote: {
//          url: "api/check/email/",
//          type: "get",
//          data: {
//            uid: function () {
//              var uid = $('input[name=uid]').val();
//              return uid;
//            }
//          }
//        }
      },
      username: {
        onkeyup: false,
        required: true,
        minlength: 3,
//        remote: {
//          url: "api/check/user/",
//          type: "get",
//          data: {
//            uid: function () {
//              var uid = $('input[name=uid]').val();
//              return uid;
//            }
//          }
//        }
      },
      password: {
        onkeyup: false,
        required: true,
        minlength: 8
      },
      confirm: {
        required: true,
        minlength: 8,
        equalTo: $('input[name=password]')
      }
    },
    messages: {
      username:
              {
                required: "Please enter username.",
                remote: jQuery.validator.format("{0} is already taken.")
              },
      email:
              {
                required: "Please enter email address.",
                email: "Please enter a valid email address.",
                remote: jQuery.validator.format("{0} already registered.")
              }
    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      // Add `has-feedback` class to the parent div.form-group
      // in order to add icons to inputs
      element.parents(".col-xs-12").addClass("has-feedback");

      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }

      // Add the span element, if doesn't exists, and apply the icon classes to it.
      if (!element.next("span")[ 0 ]) {
        $("<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
      }
    },
    success: function (label, element) {
      // Add the span element, if doesn't exists, and apply the icon classes to it.
      if (!$(element).next("span")[ 0 ]) {
        $("<span class='glyphicon glyphicon-ok form-control-feedback'></span>").insertAfter($(element));
      }
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parents(".col-xs-12").addClass("has-error").removeClass("has-success");
      $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parents(".col-xs-12").addClass("has-success").removeClass("has-error");
      $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
    }
  });
});

$(document).ready(function (e) {
  $('#uploadResumeForm').validate({
    rules: {
      email1: {
        onkeyup: false,
        required: true,
        email: true
      }
    },
    messages: {
      email1:
              {
                required: "Please enter email address.",
                email: "Please enter a valid email address.",
                remote: jQuery.validator.format("{0} already registered.")
              }
    },
    errorElement: "em",
    errorPlacement: function (error, element) {
      // Add the `help-block` class to the error element
      error.addClass("help-block");
      // Add `has-feedback` class to the parent div.form-group
      // in order to add icons to inputs
	  element.parents("div.form-group").addClass("has-feedback");
      if (element.prop("type") === "checkbox") {
        error.insertAfter(element.parent("label"));
      } else {
        error.insertAfter(element);
      }

      // Add the span element, if doesn't exists, and apply the icon classes to it.
      if (!element.next("span")[ 0 ]) {
        $("<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
      }
    },
    success: function (label, element) {
      // Add the span element, if doesn't exists, and apply the icon classes to it.
      if (!$(element).next("span")[ 0 ]) {
        $("<span class='glyphicon glyphicon-ok form-control-feedback'></span>").insertAfter($(element));
      }
    },
    highlight: function (element, errorClass, validClass) {
      $(element).parent("div").addClass("has-error").removeClass("has-success");
      $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).parent("div").addClass("has-success").removeClass("has-error");
      $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
    }
  });
});