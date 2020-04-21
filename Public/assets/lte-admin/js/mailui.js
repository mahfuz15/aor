function initGridResize() {
    var bsClass = "col-sm-1 col-sm-2 col-sm-3 col-sm-4 col-sm-5 col-sm-6 col-sm-7 col-sm-8 col-sm-9 col-sm-10 col-sm-11 col-sm-12";
    $('.column-resize').resizable({
        handles: 'e',
        create: function (e, ui) {
            var parentW = $(this).parent().width();
        },
        start: function (e, ui) {
        },
        stop: function (e, ui) {
            setCookie('__mailbox-pan-preference', this.col, 365);
        },
        resize: function (e, ui) {
            var thiscol = $(this);
            var thatcol = $('#mail-body-container');
            var container = thiscol.parent();
            var containerW = thiscol.parent().outerWidth();
            var cellPercentWidth = 100 * ui.originalElement.outerWidth() / container.innerWidth();
            ui.originalElement.css('width', cellPercentWidth + '%');

            var Colnum = getClosest(gridsystem, cellPercentWidth);
            var ThatColnum = getClosest(gridsystem, (100 - cellPercentWidth));

            var thiscol = $(this);
            if (Colnum <= ThatColnum && Colnum > 1) {
                thiscol.removeClass(bsClass).addClass('col-sm-' + Colnum);
                thatcol.removeClass(bsClass).addClass('col-sm-' + ThatColnum);
                this.col = Colnum;
            }
            thiscol.css("width", '');
            thatcol.css("width", '');
        }
    });
    var colNum = getCookie('__mailbox-pan-preference');
    if (colNum !== null) {
        colNum = parseInt(colNum);
        if (colNum > 1 && colNum < 7) {
            $('#mail-list-container').removeClass(bsClass).addClass('col-sm-' + colNum);
            $('#mail-body-container').removeClass(bsClass).addClass('col-sm-' + (12 - colNum));
        }
    }
}


var gridsystem = [{
        grid: 8.33333333,
        col: 1
    }, {
        grid: 16.66666667,
        col: 2
    }, {
        grid: 25,
        col: 3
    }, {
        grid: 33.33333333,
        col: 4
    }, {
        grid: 41.66666667,
        col: 5
    }, {
        grid: 50,
        col: 6
    }, {
        grid: 58.33333333,
        col: 7
    }, {
        grid: 66.66666667,
        col: 8
    }, {
        grid: 75,
        col: 9
    }, {
        grid: 83.33333333,
        col: 10
    }, {
        grid: 100,
        col: 11
    }, {
        grid: 91.66666667,
        col: 12
    }, {
        grid: 10000,
        col: 10000
    }];

function getClosest(arr, value) {
    var closest, mindiff = null;
    for (var i = 0; i < arr.length; ++i) {
        var diff = Math.abs(arr[i].grid - value);
        if (mindiff === null || diff < mindiff) {
            closest = i;
            mindiff = diff;
        } else {
            return arr[closest]['col'];
        }
    }
    return null;
}


function resizeMsgWindows() {
    var headerHeight = $('.main-header').outerHeight();
    var notificationHeight = $('.notification-container').length > 0 ? $('.notification-container').outerHeight() + 10 : 0;
    var contentHeaderHeight = $('.content-header').outerHeight();
    var listBoxHeaderHeight = $('#campaign-msg-list-box .box-header').outerHeight();
    var listBoxFooterHeight = $('#campaign-msg-list-box .box-footer').outerHeight();
    var topOffset = headerHeight + contentHeaderHeight;
    var windowHeight = $(window).height();
    var campaignMsgListHeight = Math.floor(windowHeight - (topOffset + notificationHeight + listBoxHeaderHeight + listBoxFooterHeight));
    $('#campaign-message-list').height(campaignMsgListHeight);
    var listBoxHeight = $('#campaign-msg-list-box').outerHeight();
    var campaignMsgBoxHeight = listBoxHeight;
    var msgsBoxHeaderHeight = $('#mail-body-container-box .box-header').outerHeight();
    var msgsBoxBodyOffset = ($('#mail-body-container-box .box-body').outerHeight() - $('#mail-body-container-box .box-body').height());
    var msgsBoxFooterHeight = $('#mail-body-container-box .box-footer').outerHeight();
    var msgsenderInfoHeight = $('#mail-body-container-box .message-sender-info-container').outerHeight();
    var msgContainerHeight = $('.messagebox-message').outerHeight();
    var campaignSummaryBoxHeight = $('#campaign-summary-container').length > 0 ? Math.ceil($('#campaign-summary-container').outerHeight()) : 0;
    var campaignMsgSectionsTotalHeight = topOffset + notificationHeight + msgsBoxHeaderHeight + msgsBoxBodyOffset + msgsenderInfoHeight + campaignSummaryBoxHeight + msgsBoxFooterHeight;
    var campaignMsgHeight = Math.floor(windowHeight - campaignMsgSectionsTotalHeight);
    $('#message-preview-container').data('pre-height', campaignMsgHeight);
    $('#message-preview-container').data('height', $('#message-preview-container').outerHeight());
    if (msgContainerHeight > campaignMsgHeight) {
        $('#message-expand-btn').removeClass('hide');
        $('#message-preview-container').css('height', campaignMsgHeight + 'px');
        $('#mail-body-container-box .box-body').css('max-height', campaignMsgListHeight + 'px');
        removeLoader();
    } else {
        removeLoader();
    }
}
$(window).resize(function () {
    resizeMsgWindows();
});

$('#message-expand-btn').click(function () {
    var campaignMsgPreviewHeight = $('#message-preview-container').data('pre-height');
    var campaignMsgHeight = $('#message-preview-container').data('height');
    var campaignMsgContainerHeight = $('.messagebox-message').outerHeight() + $('.message-expand-btn').outerHeight() + 10;
    console.log(campaignMsgContainerHeight);
    if ($(this).parent('.message-container').hasClass('message-expanded')) {
        $(this).parent('.message-container').removeClass('message-expanded');
        $('#message-preview-container').height(campaignMsgPreviewHeight);
        $(this).find('i.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
        $(this).find('small').text('See full message');
    } else {
        $(this).parent('.message-container').addClass('message-expanded');
        $('#message-preview-container').css('height', campaignMsgContainerHeight + 'px');
        $(this).find('i.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
        $(this).find('small').text('Hide message');
    }

});


function getValueByName(data, name, id = 0) {
    var value;
    $(data).each(function (i, item) {
        if (item.name == name) {
            if (id > 0 && item.id == id) {
                value = item.data;
                return value;
            }
            if (id == 0) {
                value = item.data;
                return value;
            }
        }
    });
    return value;
}
$(function () {
    initGridResize();
    resizeMsgWindows();
});
