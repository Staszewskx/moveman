"use strict";

/*---------------------------------------------*
 * SETTINGS
 ---------------------------------------------*/

var hide_menu = false;
var wowAnimation = true;

jQuery(document).ready(function ($) {
    "use strict";


    /*---------------------------------------------*
     * STICKY HIDE NAVIGATION 
     ---------------------------------------------*/

    var windowWidth = $(window).width();
    if (windowWidth > 767) {

        if (hide_menu === true) {
            $('.navbar').addClass('hide-nav').hide();
            $(window).scroll(function () {
                if ($(this).scrollTop() > 200) {
                    $('.hide-nav').fadeIn(500).addClass('navbar');

                } else {
                    $('.hide-nav').fadeOut(500).removeClass('navbar');
                }
            });
        }
    }
    if (windowWidth < 719) {
        jQuery('.navbar-collapse a').click(function () {
            jQuery('.navbar-collapse').collapse('toggle');
        });
    }

    /*---------------------------------------------*
     * STICKY TRANSPARENT NAVIGATION 
     ---------------------------------------------*/

    $.localScroll();

    /*---------------------------------------------*
     * STICKY TRANSPARENT NAVIGATION 
     ---------------------------------------------*/

    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('glyphicon-minus glyphicon-plus');
    }

    $('.panel-group').on('hidden.bs.collapse shown.bs.collapse', toggleChevron);

    /*---------------------------------------------*
     * Counter 
     ---------------------------------------------*/

    $('.statistic-counter').counterUp({
        delay: 10,
        time: 2000
    });

    /*---------------------------------------------*
     * WOW
     ---------------------------------------------*/
    var wow = new WOW({
        mobile: false // trigger animations on mobile devices (default is true)
    });

    if (wowAnimation === true) {
        wow.init();
    }

    /*---------------------------------------------*
     * Map
     ---------------------------------------------*/
    $('.map-wrapper iframe').each(function (i, iframe) {
        $(iframe).parent().hover(// make inactive on hover
            function () {
                $(iframe).css('pointer-events', 'none');
            }).click(// activate on click
            function () {
                $(iframe).css('pointer-events', 'auto');
            }).trigger('mouseover'); // make it inactive by default as well
    });

    /*---------------------------------------------*
     * Contact Form
     ---------------------------------------------*/

    var $form = $('#contactform');
    var $button = $('#contactform button');
    var buttonText = $button.text();
    var $message = $('#message');

    $form.on('submit', function () {
        $button.text($button.data('loading-text'));
        $button.prop('disabled', true);
        $.ajax({
            url: "/scripts/contact.php",
            method: "POST",
            data: $form.serialize()
        }).always(function (response) {
            $message.html(response);
            $button.text(buttonText);
            $button.prop('disabled', false);
        });
        return false;
    });

    /*---------------------------------------------*
     * iPad Detection
     ---------------------------------------------*/

    var isiOS = ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)));
    if (isiOS) {
        $(document.body).addClass('iOS');
    }

});