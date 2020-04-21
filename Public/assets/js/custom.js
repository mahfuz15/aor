$(function() {
    
 //scroll
  $('#hotmailer a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      var $off;
      if($(window).width() > 767 ){
            $off=74;
      }else{
        $off=50;
      }

      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - $off)}, 1200);
        return false;
      }
    }
  });   

  //swiper slider activation

  var mySwiper = new Swiper ('.swiper-container.template-chooser', {
      slidesPerView: 5,
      spaceBetween: 30,
      observer: true,
      observeParents: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },

      // Navigation arrows
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },

   });


  $('.form-control').focusout(function(e) {
    if($(this).val()) {
        $(this).parent('.form-group').addClass('valued');
      }else{
        $(this).parent('.form-group').removeClass('valued');
      }

    $(this).removeClass('focus');
    $(this).parent('.form-group').removeClass('focus');
  });

  $('.form-control').focusin(function(e) {
    $(this).addClass('focus');
    $(this).parent('.form-group').addClass('focus');
  });

  // font-awesome pseudo elem
  FontAwesomeConfig = { searchPseudoElements: true };


  // select2

    $('.select2').select2();

    $('.select2-tags').select2({
      tags: true,
    });


 //datetimepicker
  $(".form_datetime").datetimepicker({
       format: "dd MM yyyy - HH:ii P",
       showMeridian: true,
       autoclose: true,
       todayBtn: true,
       pickerPosition: "top-right",
       startView: 'decade',
       todayHighlight: true,
       // useCurrent: false,
       // minDate: moment()
   });

  var d = new Date();

  var month = d.getMonth()+1;
  var day = d.getDate();

  var today = d.getFullYear() + '-' +
      ((''+month).length<2 ? '0' : '') + month + '-' +
      ((''+day).length<2 ? '0' : '') + day;
  
 $('.form_datetime').datetimepicker('setStartDate',today);


    

    $('.form_datetime').datetimepicker().on('dp.change', function (e) {
        // var incrementDay = moment(new Date(e.date));
        // incrementDay.add(1, 'days');
    });


    // label

    $('.mail-label .dropdown-menu .svg-inline--fa').on('click', function(e) {
      e.preventDefault();

      var clss = $(this).data('color');
      console.log(clss);
      $('.mail-label.show .dropdown-toggle .svg-inline--fa').removeClass('f-def f-red f-yellow f-green f-grey f-blue f-cyan f-b4');
      $('.mail-label.show .dropdown-toggle .svg-inline--fa').addClass(clss);

    });




    //preview icon changed

    $('.mail-preview .btn').on('click', function(e) {
      
      $('#popup-modal').on('show.bs.modal', function(e) {
         
          // $('.mail-preview .btn').removeClass('btn-outline-dark');
          // $('.mail-preview .btn').addClass('btn-dark');
          $('.mail-preview .btn .svg-inline--fa').removeClass('fa-eye');
          $('.mail-preview .btn .svg-inline--fa').addClass('fa-eye-slash');
      });
      
    });


    // close popupreset

    $('#popup-modal').on('hide.bs.modal', function(e) {
        // $('.mail-preview .btn').removeClass('btn-dark');
        // $('.mail-preview .btn').addClass('btn-outline-dark');
        $('.mail-preview .btn .svg-inline--fa').removeClass('fa-eye-slash');
        $('.mail-preview .btn .svg-inline--fa').addClass('fa-eye');
        
    });

    //emailer template

    $('body').on('click', function (e) {
          if (!$('.template-handaller').is(e.target)  && $('.template-handaller').has(e.target).length === 0 && $('.show').has(e.target).length === 0) {
              $('#template-handaller').collapse('hide'); 
          }

      });


     $('#mailcc-group').on('show.bs.collapse', function() {
       $('.msg-con').addClass('cc');
     });
     
     $('#mailcc-group').on('hidden.bs.collapse', function() {
        $('.msg-con').removeClass('cc');
        $('#mailcc-group .select2-tags').html('').select2({tags: true,});
     });

     $('#mailbcc-group').on('show.bs.collapse', function() {
       $('.msg-con').addClass('bcc');
     });

    $('#mailbcc-group').on('hidden.bs.collapse', function() {
       $('.msg-con').removeClass('bcc');
       $('#mailbcc-group .select2-tags').html('').select2({tags: true,});
     });

    var ww = $(window).width();
    console.log(ww);
    if(ww < 1200){
      $('.wrap').addClass('sidebar-collapse');
    }else{
      $('.wrap').removeClass('sidebar-collapse');
    }

    $('#attachMenu').on('click', function(e) {
      e.preventDefault();
      $('.drag-drop').addClass('active');
    });

    $('.drag-drop').on('click', function (e) {
          if (!$('.drag-drop-area-bg').is(e.target)  && $('.drag-drop-area-bg').has(e.target).length === 0 && $('.active').has(e.target).length === 0) {
              $('.drag-drop').removeClass('active'); 
          }

      });

    

    
    

});


$(window).on('resize', function(){
  
  var ww = $(window).width();
  console.log(ww);
  if(ww < 1200){
    $('.wrap').addClass('sidebar-collapse');
  }else{
    $('.wrap').removeClass('sidebar-collapse');
  }

});




