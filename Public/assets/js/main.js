$(function ($) {

  // .arrow-toogle

  // var targetId = $('.arrow-toogle').attr('data-target');
  // console.log(targetId);

  // $(targetId).on('show.bs.dropdown', function(e) {
  // 	$('.arrow-toogle').addClass('active');
  // 	console.log(targetId);
  // });

  // $(targetId).on('hidden.bs.dropdown', function(e) {
  // 	$('.arrow-toogle').removeClass('active');
  // });

  // hotlist
  $('.edit-control .editBtn').click(function (e) {
    $(this).parent().prev('.hide').removeClass('hide');
    $(this).closest('.edit-control').addClass('hide');
    if (jQuery.fn.select2) {
      $(this).parent().prev('.select2-edit').select2();
    }
    //$(this).closest('.select2-edit').select2();
    e.preventDefault();
  });
//
//  $('.hotlist-table .collapse').on('show.bs.collapse', function (e) {
//    $('.collapse').collapse('hide');
//
//    var id = $(this).attr('id');
//    $('#' + id).parents().addClass('active');
//  });
//
//  $('.hotlist-table .collapse').on('hidden.bs.collapse', function (e) {
//    var id = $(this).attr('id');
//    $('#' + id).parents().removeClass('active');
//
//  });
//
//  $('.name a').on('click', function (e) {
//    // $(this).addClass('open');
//  });
//
//  var currentUrl = location.protocol + '//' + location.host + location.pathname; //window.location.href
//  //currentUrl = currentUrl.replace(/\/edit\/\d/, "s");
//  //currentUrl = currentUrl.replace(/\/(?=[^\/]*$)/, '');
//  if (currentUrl.substr(-1) === '/') {
//    //currentUrl = currentUrl.substr(0, currentUrl.length - 1);
//  }
//  //console.log(currentUrl);
//  //console.log($('.hotlist-navbar ul.nav li a[href="'+currentUrl+'"]').parent('li'));
//  $('.hotlist-navbar a[href$="' + currentUrl + '"').parent().addClass('active');
//  currentUrl = currentUrl.replace(BASE_URL, '');
//  $('.hotlist-navbar a[href$="' + currentUrl + '"').parent().addClass('active');
//
//  // Validator
//
//  $.validator.setDefaults({ignore: ":hidden:not(select)"});
//  $.validator.setDefaults({ignore: ":hidden:not(.chosen-select)"});
//  $.validator.setDefaults({ignore: ":hidden:not(.chosen-select-no-single)"});
//  $.validator.setDefaults({
//    highlight: function (element) {
//      $(element)
//              .closest('.form-req')
//              .removeClass('has-success')
//              .addClass('has-error');
//    },
//    unhighlight: function (element) {
//      $(element)
//              .closest('.form-req')
//              .removeClass('has-error')
//              .addClass('has-success');
//    }
//
////  });
//
//  $('.formvalidate').each(function () {
//
//
//    $(this).validate({
//      ignore: [],
//      onfocusout: function (element) {
//        this.element(element);
//      },
//      rules: {
//        fullname: {
//          required: true,
//          minlength: 6,
//        },
//        email: {
//          required: true,
//          email: true
//        },
//        phoneno: {
//          required: true,
//        },
//        workstatus: {
//          required: true,
//        },
//        etype: {
//          required: true
//        },
//        "skills[]": "required"
//        ,
//        experience: {
//          required: true
//        },
//        category: {
//          required: true
//        },
//        location: {
//          required: true
//        },
//        relocation: {
//          required: true
//        },
//        coverletter: {
//          required: true
//        },
////				resumeupload: {
////					required: true
////				},
//        cname: {
//          required: true
//        },
//        orgType: {
//          required: true
//        },
//        contactName: {
//          required: true
//        },
//        contactEmail: {
//          required: true
//        },
//        contactNo: {
//          required: true
//        },
//        message: {
//          required: true,
//          minlength: 20,
//        },
//        username: {
//          required: true,
//        },
//        password: {
//          required: true,
//        },
//        company: {
//          required: true,
//        },
//        name: {
//          required: true,
//          minlength: 6,
//        },
//        role: {
//          required: true
//        },
//        company_email: {
//          required: true,
//          email: true
//        },
//        phone: {
//          required: true
//        },
//        website: {
//          required: true
//        },
//        address: {
//          required: true
//        },
//        fax: {
//          required: true
//        },
//        logo: {
//          required: true
//        },
//        tagline: {
//          required: true
//        },
//        title: {
//          required: true
//        },
//        description: {
//          required: true,
//          minlength: 20,
//        },
//        editor: {
//          required: true
//        },
//        copyright: {
//          required: true
//        }
//
//      },
//
//      messages: {
//
//        fullname: {
//          required: "Please write your full name",
//          minlength: "Please Enter more that 6 character"
//        },
//        email: {
//          required: "Please Enter an email address",
//          email: "Please enter a <em>valid</em> email address"
//        },
//        phoneno: {
//          required: "Please specify Phone number"
//        },
//        workstatus: {
//          required: 'Please select your work status'
//        },
//        etype: {
//          required: 'Please selcet employment type '
//        },
//        "skills[]": "Write down your skill"
//        ,
//        experience: {
//          required: 'Please selcet your experience'
//        },
//        category: {
//          required: 'Please select category'
//        },
//        location: {
//          required: 'Please write your address'
//        },
//        relocation: {
//          required: 'Please write relocation address'
//        },
//        coverletter: {
//          required: 'Please write your cover letter'
//        },
//        // resumeupload: {
//        //   required: 'Please Upload your resume'
//        // },
//        cname: {
//          required: 'Write your Company Name'
//        },
//        orgType: {
//          required: 'Please specify type of organization/Company'
//        },
//        contactName: {
//          required: 'Please specify name'
//        },
//        contactEmail: {
//          required: 'Please write contact email'
//        },
//        contactNo: {
//          required: 'Please write contact no'
//        },
//        message: {
//          required: "Please write your message",
//          minlength: "Please ,a litle bit more details"
//        },
//        username: {
//          required: "Please write your username"
//        },
//        password: {
//          required: "Please write your password"
//        },
//        company: {
//          required: "Write your Company Name"
//        },
//        name: {
//          required: "Please write your name",
//          minlength: "Please Enter more that 6 character"
//        },
//        role: {
//          required: "Please write your role"
//        },
//        company_email: {
//          required: "Please enter comany email",
//          email: "Please enter a valid email"
//        },
//        phone: {
//          required: "Please enter phone no"
//        },
//        website: {
//          required: "Please enter website address"
//        },
//        address: {
//          required: "Please enter your address"
//        },
//        fax: {
//          required: "Please enter fax no"
//        },
//        logo: {
//          required: "Please upload a logo"
//        },
//        tagline: {
//          required: "Please write nice slogan"
//        },
//        title: {
//          required: "Please write down title"
//        },
//        description: {
//          required: "Please write description",
//          minlength: "Please ,a litle bit more details"
//        },
//        editor: {
//          required: "Please specify editor name"
//        },
//        copyright: {
//          required: "please write copyright info"
//        }
//
//
//      },
//
//      errorPlacement: function (error, element) {
//        element.parents('.form-req').append(error);
//      }
//
//    });
//  });


//  //show upload file names
//
//  $(".resumeupload").change(function (e) {
//    $(this).parents(".form-group").find("span.fake-input").empty();
//    var files = $(this)[0].files;
//    // console.log(files);
//    for (var i = 0; i < files.length; i++) {
//      $(this).parents(".form-group").find("span.fake-input").append(files[i].name);
//    }
//
//    var type = files[0].name;
//    // console.log(type);
//
//
//    type = type.split('.').pop().toLowerCase();
//
//    console.log(type);
//
//    var accept = ['doc', 'docx', 'pdf', 'rtf'];
//
//    // console.log(accept);
//
//    if (jQuery.inArray(type, accept) == -1) {
//      console.log('not match');
//      $(this).val('');
//      // alert('Please upload doc,docx,pdf,rtf  file');
//      $('#popup-modal .modal-body').addClass('text-center');
//      $('#popup-modal .modal-body').html('Please Upload Doc, Docx,Pdf,Rtf Format file.');
//      $('#popup-modal').modal('show');
//
//      // $(this).closest('.form-group').addClass('has-error');
//      // console.log( $(this) );
//      // $(this).closest('.form-group').find('.form-validation').text('Please upload doc,docx,pdf,rtf file');
//      $(this).closest('.form-group').find('span.fake-input').text('Upload resume');
//      // console.log( $(this) );
//    } else {
//      // console.log('match');
//      // $(this).closest('.form-group').removeClass('has-error');
//      // $(this).closest('.form-group').find('.form-validation').empty();
//
//    }
//  });


  $('#popup-modal').on('hidden.bs.modal', function (e) {
    $('#popup-modal .modal-body').removeClass('text-center');
  });

  $('.formvalidate').on('submit', function (e) {
    // e.preventDefault();
    $(this).addClass('working');

    if ($('.working .form-group').hasClass('has-error')) {
      $("html, body").stop().animate({scrollTop: $('.working .has-error').offset().top - 100}, 600);
      e.preventDefault();
      // return false;
    }

    $(this).removeClass('working');

  });




  $('.btn-add').hover(function (e) {
    $(this).parent('.multitple').addClass('active');
    // $('.multitple.active .btn').tooltip('show');
  });

  $('.multitple .target').on('mouseleave', function (e) {
    $('.multitple').removeClass('active');

  });

  $('.modal').on('hide.bs.modal', function (e) {
    $('.multitple').removeClass('active');

  });

  // $('[data-toggle="tooltip"]').tooltip('show');

  $('.dash-search .input-group').on('focusout click', function (e) {
    $('.dash-search').removeClass('focusing');
  });

  $('.dash-search .input-group ').on('focusin click', function (e) {
    //console.log('jgjf ');
    $('.dash-search').addClass('focusing');
  });



  $('.VS-search-box-wrapper').on('focusout', function (e) {
    e.preventDefault();
    var cs = $(this).children().find('.search_input').length;
    if (cs > 1) {
      $('.VS-search-box-wrapper').addClass('vs-working');
    } else {
      $('.VS-search-box-wrapper').removeClass('vs-working');
    }

  });

});

// Custom Alert Dialogs

alertify.defaults = {
  autoReset: true,
  basic: false,
  closable: true,
  closableByDimmer: false,
  frameless: false,
  maintainFocus: true,
  maximizable: true,
  modal: true,
  movable: true,
  moveBounded: false,
  overflow: true,
  padding: true,
  pinnable: true,
  pinned: true,
  preventBodyShift: false,
  resizable: false,
  startMaximized: false,
  transition: 'pulse',
  notifier: {
    delay: 7,
    position: 'bottom-left',
    closeButton: true
  },
  glossary: {
    title: 'Message',
    ok: 'OK',
    cancel: 'Cancel'
  },
  theme: {
    input: 'ajs-input',
    ok: 'ajs-ok',
    cancel: 'ajs-cancel'
  }
};
if (!alertify.settingsDialog) {
//alertify.genericDialog || alertify.dialog('settingsDialog', function () {
  alertify.dialog('settingsDialog', function factory() {
    return {
      main: function (content) {
        this.htmlContent = content;
        this.setContent(content);
      },
//    main: function (config) {
//      if (config === undefined || config == null || config.containerSelector == null) {
//        this.setContent(config);
//        alertify.error('Settings dialog not configured correctly!');
//      } else {
//        var contentElement = document.querySelectorAll(config.containerSelector);
////        console.log(contentElement.innerHTML);
////        this.setContent(contentElement.innerHTML);
//      }
//      console.log(contentElement[0].childNodes);
//      console.log(contentElement instanceof window.HTMLElement);
////      this.settings = config;
//    },
      setup: function () {
        return {
          buttons: [
            {
              text: 'Ok',
              key: 13,
              invokeOnClose: true,
              className: alertify.defaults.theme.ok,
              scope: 'primary',
              element: 2
            },
            {
              text: 'Cancel',
              key: 27,
              invokeOnClose: false,
              className: alertify.defaults.theme.cancel,
              scope: 'auxiliary',
              element: 1
            }
          ],
          focus: {
            element: 0,
            select: true
          },
          options: {
            closable: false,
            closableByDimmer: false,
            basic: false,
            maximizable: false,
            resizable: false,
            padding: true
          }
        };
      },
      build: function () {
        this.elements.content.style.minHeight = 'inherit';
        this.elements.dialog.style.maxHeight = '100%';
      },
      settings: {
        containerSelector: null,
        title: null,
        message: null,
        labels: null,
        height: 'auto',
        onok: null,
        oncancel: null,
        defaultFocus: null,
        settingsFormName: null,
        reverseButtons: null
      },
      callback: function (closeEvent) {
//      console.log(closeEvent);
        var returnValue;
        switch (closeEvent.index) {
          case 0:
            this.settings.formdata = 'formdata';
            if (typeof this.get('onok') === 'function') {
              returnValue = this.get('onok').call(this, closeEvent, this.getFormdata());
              if (typeof returnValue !== 'undefined') {
                closeEvent.cancel = !returnValue;
              }
            }
            break;
          case 1:
            if (typeof this.get('oncancel') === 'function') {
              returnValue = this.get('oncancel').call(this, closeEvent);
              if (typeof returnValue !== 'undefined') {
                closeEvent.cancel = !returnValue;
              }
            }
            break;
        }
      },
      settingUpdated: function (key, oldValue, newValue) {
        switch (key) {
          case 'title':
            this.set('title', newValue);
            break;
          case 'message':
            this.set('message', newValue);
            break;
          case 'height':
            this.elements.body.style.minHeight = newValue;
            break;
          case 'labels':
            if ('ok' in newValue && this.__internal.buttons[0].element) {
              this.__internal.buttons[0].text = newValue.ok;
              this.__internal.buttons[0].element.innerHTML = newValue.ok;
            }
            if ('cancel' in newValue && this.__internal.buttons[1].element) {
              this.__internal.buttons[1].text = newValue.cancel;
              this.__internal.buttons[1].element.innerHTML = newValue.cancel;
            }
            break;
          case 'reverseButtons':
            if (newValue === true) {
              this.elements.buttons.primary.appendChild(this.__internal.buttons[0].element);
            } else {
              this.elements.buttons.primary.appendChild(this.__internal.buttons[1].element);
            }
            break;
          case 'defaultFocus':
            this.__internal.focus.element = newValue === 'ok' ? 0 : 1;
            break;
          case 'settingsFormName':
            this.getFormdata();
            break;
        }
      },
      hooks: {
        onshow: function () {
//        console.log('onshow');
        },
        onclose: function () {
          this.setContent('');
          document.body.appendChild(this.htmlContent);
          this.htmlContent = null;
//        console.log('onclose');
        },
        onupdate: function () {
//        console.log('onupdate');
        }
      },
      getFormdata: function () {
        if (this.settings.settingsFormName === undefined) {
          return false;
        }
        var form = document.getElementsByName(this.settings.settingsFormName)[0];
        if (form === undefined) {
          return false;
        }

        var elements = form.elements;
        if (elements.length === 0) {
          return false;
        }
        var formValues = {};

        for (var i = 0; i < elements.length; i++) {
          switch (elements[i].type) {
            case "checkbox":
            case "radio":
              if (elements[i].checked) {
                formValues[elements[i].name] = elements[i].value;
              }
              break;
            case "password":
              formValues[elements[i].name] = elements[i].checked;
              break;
            case "textarea":
            case "text":
            case "email":
            case "select":
            default:
              formValues[elements[i].name] = elements[i].value;
              break;
          }
        }
        return formValues;
      }
    };
  });
}

$(function () {
  if (isJsonString($('#notification_message_object').val())) {
    var notificationMessage = JSON.parse($('#notification_message_object').val());
    if (notificationMessage.length > 0) {
//        console.log($('#notification_message_object').data('notify-position'));
        if($('#notification_message_object').data('notify-position') !== undefined){
           alertify.set('notifier','position', $('#notification_message_object').data('notify-position')); 
        }
        if($('#notification_message_object').data('notify-delay') !== undefined){
           alertify.set('notifier','delay', parseInt($('#notification_message_object').data('notify-delay'))); 
        }

      showNotifications(notificationMessage);
    }
  }
});

function showNotifications(notificationObject) {
  $(notificationObject).each(function (i, item) {
    switch (item.type) {
      case 'success':
        alertify.success(item.message);
        break;
      case 'info':
        alertify.message(item.message, 0);
        break;
      case 'warning':
        alertify.warning(item.message);
        break;
      case 'danger':
        alertify.error(item.message);
        break;
    }
  });
}