/* global BASE_URL */

$(document).ready(function () {
    $('#state').on('change', function () {
        var stateName = $(this).val();

        $("#city").empty();
        $("#zip").html('<option value="0" disabled selected>Select City first</option>');
        $('#zip').trigger("chosen:updated");

        if (stateName) {
            $.ajax({
                type: 'GET',
                url: BASE_URL + 'api/geo?state=' + encodeURI(stateName),

                success: function (html) {
                    //console.log(BASE_URL + 'api/geo?state=' + encodeURI(stateName));
                    //console.log(JSON.stringify(html));

                    if (html.length != 0) {
                        $("#city").html('<option value="0" disabled selected>Select City</option>');
                        $.each(html, function (i, item) {
                            var city = html[i].city;
                            $('#city').append($('<option>', {
                                value: city,
                                text: city
                            }));
                        });

                        $('#city-placeholder').removeClass('hide');
                    } else {
                        $('#city').html('<option value="0" disabled selected>Select Another State</option>');
                    }

                    $('#city').trigger("chosen:updated");
                }
            });
        } else {
            $('#city').html('<option  value="0" disabled selected>Select State first</option>').trigger("chosen:updated");
            $('#zip').html('<option  value="0" disabled selected>Select City first</option>').trigger("chosen:updated");
        }
    });

    $('#city').on('change', function () {
        var cityName = $(this).val();

        $("#zip").empty();

        if (cityName) {
            $.ajax({
                type: 'GET',
                url: BASE_URL + 'api/geo?city=' + encodeURI(cityName),

                success: function (html) {
                    //console.log(BASE_URL + 'api/geo?state=' + encodeURI(cityName));
                    //console.log(JSON.stringify(html));

                    if (html.length != 0) {
                        $("#zip").html('<option value="0" disabled selected>Select Zip</option>');
                        $.each(html, function (i, item) {
                            var zip = html[i].zipcode;
                            var id = html[i].id;
                            $('#zip').append($('<option>', {
                                value: id,
                                text: zip
                            }));
                        });

                        $('#zip-placeholder').removeClass('hide');
                    } else {
                        $('#zip').html('<option  value="0" disabled selected>Select Another City</option>');
                    }

                    $('#zip').trigger("chosen:updated");
                }
            });
        } else {
            $('#zip').html('<option  value="0" disabled selected>Select Another City</option>').trigger("chosen:updated");
        }
    });


    function updateNotificationBar() {
        var notificationCount = 0;

        $.ajax({
            type: 'GET',
            url: BASE_URL + 'api/notifications',

            success: function (html) {
//                console.log(JSON.stringify(html));
                if (html && html.length != 0) {
                    notificationCount = html.length;
                    updateNotification(notificationCount);

                    $('.notification-bell').each(function () {
                        var note_bell = $(this).find('.notification_count');
                        if (note_bell.length) {
                            note_bell.html(notificationCount);
                        } else {
                            $(this).append('<span class="badge blink alt notification_count">' + notificationCount + '</span>');
                        }
                    });

                    $('#notification_drawer').empty();
                    $('#allNotification').html('<a href="' + BASE_URL + 'notifications" >View all (' + notificationCount + ')</a>');

                    $.each(html, function (i, item) {

                        $('#notification_drawer').append('<div class="single-noti">' +
                                '<div class="noti_msg">' +
                                '<a href="' + item.link + '">'
                                + item.text +
                                '</a>' +
                                '<small class="noti_time">' + item.time + ' ago</small>' +
                                '</div>' +
                                '</div>');
                    });

                } else {
                    $('#notification_drawer').empty();
                    $('#notification_drawer').html('<div class="single-noti"><div class="noti_msg">No Notification Awaits For You !</div>');
                    $('#allNotification').html('<a href="' + BASE_URL + 'notifications" >View all</a>');
                    $('.notification_count').each(function () {
                        $(this).remove();
                    });
                    updateNotification(0);
                }
            }

        });

    }

    var documentTitle = document.title;

    setInterval(function () {
        updateNotificationBar();
        
        if (totalNotifications < 1) {
            $('.blink').each(function () {
                $(this).remove();
            });

            document.title = documentTitle;
        }
    }, 5000);

    setInterval(function () {
        if (totalNotifications > 0) {
            $('.blink').each(function () {
                $(this).toggleClass('alt');
            });


            if (document.title === documentTitle) {
                document.title = '(' + totalNotifications + ')' + ' New Notifications !';
            } else {
                document.title = documentTitle;
            }
        }
    }, 1000);


    function updateNotification(notifications) {
        totalNotifications = notifications;
    }


    $('#daterange-filter').daterangepicker({
        ranges: {
            'All': [moment().subtract(17, 'years'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 3 Days': [moment().subtract(2, 'days'), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        format: 'YYYY-MM-DD',
        separator: ' | '
    }
//    , function (start, end, label) {
//        console.log("New date range selected: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD') + " (predefined range: " + label + ")");
//    }
    );

});