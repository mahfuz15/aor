$(document).on("click", '.popup', function (e) {
//console.log('huh');

    var $this = $(this);
    var remote = $this.attr('href');
    if (remote) {
        if ($this.hasClass('open-window')) {
            window.open(remote, "Popup", "width=1160,height=600,resizable,scrollbars=yes,status=1");
        } else {
            switch (popupType(remote)) {
                case 'iframe':
                    $('#popup-modal .modal-body').html('<iframe src="' + remote + '" width="100%" height="600" id="iframePopup"></iframe>');
                    break;
                case 'youtube':
                    $('#popup-modal .modal-body').html('<iframe src="' + remote + '" width="100%" height="400" id="iframePopup"></iframe>');
                    break;
                case 'image':
                    $('#popup-modal .modal-body').html('<img src="' + remote + '" class="img-responsive img-center" id="iframePopup"></iframe>');
                    break;
                case 'site':
                default:
                    remote += (remote.indexOf('?') > -1) ? '&' : '?';
                    remote += 'format=raw';
                    $.get(remote, 
                        function( data, success, dataType ) {
                            if(dataType.getResponseHeader('Content-Type') == 'application/json'){
                                if(data['redirect'] != undefined){
                                    window.location = data['redirect'];
                                } else {
                                    console.log(data);
                                }
                            } else {
                                $('#popup-modal .modal-body').html(data);
                            }
                        }
                    );                    
//                    $('#popup-modal .modal-body').load(remote);
                    break;
            }
            if ($this.hasClass('popup-lg')) {
                if (!$('#popup-modal .modal-dialog').hasClass('modal-lg')) {
                    $('.modal-dialog').addClass('modal-lg');
                }
            } else {
                $('.modal-dialog').removeClass('modal-lg');
            }

            if ($this.data('modal-style') !== undefined && $this.data('modal-style') !== null || $this.data('modal-style') != "") {
                $('.modal-dialog').addClass($this.data('modal-style'));
            }

            if ($this.hasClass('popup-no-header') || $this.data('title') === undefined || $this.data('title') === null || $this.data('title') == "") {
                $('.modal-dialog .modal-header').addClass('hide');
            } else {
                $('.modal-dialog .modal-header').removeClass('hide');
                if ($this.data('title') != "") {
                    $('.modal-dialog .modal-header .header-title').text($this.data('title'));
                }
            }
            $('#popup-modal').modal('show');
        }
        e.preventDefault();
    }
});

function popupType(url) {
    //console.log(url);
    var yt = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    var re = new RegExp(window.location.hostname, 'g');
    var img = /\.(jpeg|jpg|gif|png)$/;
    if (url.match(yt)) {
        return 'youtube';
    } else if (getParameterByName('format', url) == 'iframe') {
        return 'iframe';
    } else if (url.match(img)) {
        return 'image';
    } else if (url.match(re)) {
        return 'site';
    } else {
        return 'site';
    }
}

function getParameterByName(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
$('#popup-modal').on('hidden.bs.modal', function () {
    $('#popup-modal .modal-body').html('Loading, Please wait...');
});

function isURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return pattern.test(str);
}

$('.confirm-click').click(function (e) {

    var $this = $(this);
    var remote = $this.attr('href');
    var headline = 'Are you sure?';

    if (remote) {
        remote += (remote.indexOf('?') > -1) ? '&' : '?';
        remote += 'format=raw';
        if ($this.data('headline')) {
            headline = $this.data('headline');
        }

        $('#popup-modal .modal-body').html('<div class="small-dialog-headline"><h2>' + headline + '</h2></div>' +
                '<div class="small-dialog-content text-center"><a href="' + remote + '" class="button text-center">Confirm</a></div>');

        $('.modal-dialog .modal-header').addClass('hide');
        $('#popup-modal').modal('show');
    }
    e.preventDefault();
});
