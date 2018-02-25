window.$ = window.jQuery = require('jquery');

require('./fontawesome-all');

$(function() {
    if (typeof UseScripts !== 'undefined' && UseScripts.includes('loadDataAjax')) {
        require('./loadDataAjax');
    }

    let width = $(window).width();

    function toggleHeaderFixed () {
        if (width > 980) {
            if ($(window).scrollTop() > 91) {
                $('.header').addClass('header--fixed');
                $('.main').css('padding-top', '90px');
            } else {
                $('.header').removeClass('header--fixed');
                $('.main').css('padding-top', '0');
            }
        } else if ($('.header').hasClass('header--fixed')) {
            $('.header').removeClass('header--fixed');
            $('.main').css('padding-top', '0');
        }
    }

    $(window).scroll(function () {
        toggleHeaderFixed();
    });

    $(window).on('resize', function(){
        if (width !== $(this).width()) {
            width = $(this).width();
        }
        toggleHeaderFixed();
    });
});