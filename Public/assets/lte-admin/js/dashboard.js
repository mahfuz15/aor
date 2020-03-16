$(function () {
    if ($('#recentMailBox').length > 0) {
        $.getJSON("api/mailbox/recent", function (data) {
            console.log(data);
            $('#recentMailBox').parents('.box-body').siblings('.overlay').fadeOut();
            $("#dataTemplate").tmpl(data).appendTo("#recentMailBox");
        });
    }
    if ($('#recentSubscriber').length > 0) {
        $.getJSON("api/subscriber/recent", function (data) {

            $('#recentSubscriber').parents('.box-body').siblings('.overlay').fadeOut();
            $("#subscriberTemplate").tmpl(data).appendTo("#recentSubscriber");
        });
    }
});