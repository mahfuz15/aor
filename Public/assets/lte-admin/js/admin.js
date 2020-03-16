$(function () {
    $('#filter').find('select').change(function (e) {
        $(this).closest('form').submit();
    });

    $('#filterForm').find('select').change(function (e) {
        $('#filterForm').submit();
    });

    $('.quickSubmit').find('select').change(function (e) {
        $(this).closest('form').submit();
    });

    $('.edit-control .editBtn').click(function (e) {
        $(this).parent().prev('.hide').removeClass('hide');
        $(this).closest('.edit-control').addClass('hide');
        if (jQuery.fn.select2) {
            $(this).parent().prev('.select2-edit').select2();
        }
        //$(this).closest('.select2-edit').select2();
        e.preventDefault();
    });
    $('#message-modal').modal('show');

    var format = getParameterByName('format');
    //console.log(format);
    if (format == 'iframe') {
        $('.content-wrapper').removeClass();
    }

    var currentUrl = location.protocol + '//' + location.host + location.pathname; //window.location.href
    currentUrl = currentUrl.replace(/\/edit\/\d/, "s");
    //currentUrl = currentUrl.replace(/\/(?=[^\/]*$)/, '');
    if (currentUrl.substr(-1) === '/') {
        currentUrl = currentUrl.substr(0, currentUrl.length - 1);
    }
    $('.sidebar-menu a[href$="' + currentUrl + '"').parents('.treeview').addClass('active');
    $('.sidebar-menu a[href$="' + currentUrl + '"').parent().addClass('active');

    if ($('body').hasClass('sidebar-expand-on-hover')) {
        $.AdminLTE.pushMenu.expandOnHover();
    }
    //$.AdminLTE.options.sidebarExpandOnHover = true;
    //console.log($.AdminLTE.options.sidebarExpandOnHover);

});
