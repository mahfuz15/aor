$(function() {
   // var documentTitle = document.title;
   // var currentOrder = queryString('order', $('[data-order-default]').data('order'));
   // var currentSort = queryString('sort', 'asc');

   // $('[data-order]').each(function () {
   //     var element = $(this);
   //     prepareTH(element, currentOrder);
   //     orderIcon(element, currentOrder, currentSort);
   // });

   // setPerPage();
   // $('#perPage').change(function () {
   //     resetPerPage($(this).val());
   // });

   // setInterval(function () {
   //     $('.blink').each(function() {
   //         $(this).toggleClass('label-danger label-info');
   //     });
       
   //     if(totalNotifications){
   //         if(document.title === documentTitle){
   //             document.title = '(' + totalNotifications + ')'  + ' new notifications !';
   //         }else{
   //             document.title = documentTitle;
   //         }
   //     }
   // }, 1000);

  
   
   

});


function prepareTH(element, currentOrder) {
    if (element.data('order') === currentOrder) {
        element.addClass('info');
    }
    element.addClass('relative');
}

function orderIcon(element, currentOrder, currentSort) {
    var column = element.data('order');
    var upButtonClass = '';
    var downButtonClass = '';
    if (column === currentOrder && 'desc' === currentSort) {
        upButtonClass = 'text-green';
    } else if (column === currentOrder && 'asc' === currentSort) {
        downButtonClass = 'text-green';
    }

    element.append('<i class="fa fa-caret-up up-btn ' + upButtonClass + '" aria-hidden="true" onclick="reFilter(\'' + column + '\', \'desc\')"></i><i class="fa fa-caret-down down-btn ' + downButtonClass + '" aria-hidden="true" onclick="reFilter(\'' + column + '\')"></i>');
}

function reFilter(filter, sort = 'asc') {
    var url = window.location.href.replace(location.search, '');
    var queries = queryString();
    var qString = [];

    queries.order = filter;
    queries.sort = sort;

    $.each(queries, function (key, value) {
        qString.push(key + '=' + value);
    });

    qString = qString.join('&');

    window.location.href = url + '?' + qString;
}

function manipulateQueryString(manipulator) {
    var queries = queryString();
    var qString = [];

    $.each(manipulator, function (mkey, mvalue) {
        queries[mkey] = mvalue;
    });

    $.each(queries, function (qkey, qvalue) {
        qString.push(qkey + '=' + qvalue);
    });

    return qString.join('&');
}

function queryString(target = false, defaultVal = false) {
    var query = window.location.search.substring(1);
    var vars = query.split('&');
    if (vars == "") {
        if (target) {
            return defaultVal;
        }
        return {};
    }
    var length = vars.length;
    var queryObject = {};
    for (var i = 0; i < length; i++) {
        var pair = vars[i].split('=');
        if (target && pair[0] === target) {
            return pair[1];
        }
        queryObject[pair[0]] = pair[1];

    }
    if (target) {
        return defaultVal;
    }
    //console.log(queryObject);
    return queryObject;
}

function fullUrl() {
    return window.location.href;
}

function realUrl() {
    return  fullUrl().replace(location.search, '');
}

function setPerPage() {
    $('#perPage').val(queryString('perPage', '10'));
}
function resetPerPage(value) {
    var newQstring = manipulateQueryString({'perPage': value});

    window.location.href = realUrl() + '?' + newQstring;
}


