/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
    var w = window, d = document, e = d.documentElement, g = d.getElementsByTagName('body')[0],
        x = w.innerWidth || e.clientWidth || g.clientWidth, y = w.innerHeight || e.clientHeight || g.clientHeight;
    return {width: x, height: y};
}

// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
    var timers = {};
    return function (callback, ms, uniqueId) {
        if (!uniqueId) {
            uniqueId = "Don't call this twice without a uniqueId";
        }
        if (timers[uniqueId]) {
            clearTimeout(timers[uniqueId]);
        }
        timers[uniqueId] = setTimeout(callback, ms);
    };
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;

/*
 * Put all your regular jQuery in here.
*/

jQuery(document).ready(function ($) {
    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active');
        $(this).toggleClass('active');
        $('body').toggleClass('no-scroll')
    });
    $('#play-video').on('click', function(ev) {
        $(this).fadeToggle();
        $("#video")[0].src += "&autoplay=1";
        ev.preventDefault();

    });
    if (viewport.width > 991) {
        $(window).scroll(function () {
            var sticky = $('#header-tools'),
                scroll = $(window).scrollTop();

            if (scroll >= 165) sticky.addClass('fixed');
            else sticky.removeClass('fixed');
        });
    }
    $("a:not(.nav-link):not(.collapse-link):not(.menu-item a)").on('click', function(event) {

        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            $('html, body').animate({
                scrollTop: jQuery(hash).offset().top
            }, 800, function(){

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
    $(".holder-clickable-self,.fep-odd-even > div,.fep-per-message").click(function() {
        window.location = $(this).find("a").attr("href");
        return false;
    });
    $(".holder-clickable.blank").click(function() {
        window.open($(this).find("a").attr("href"));
        return false;
    });
    $("a.collapse-link").click(function() {
        $(this).closest("li").toggleClass('is-open')
    });

    //$('.searchandfilter ul select').addClass('selectpicker');
    //$('.fep-form-field-fep-message-to input,#message_title').removeAttr('placeholder');
    // Floating Labels

    var onClass = "on",
        showClass = "show";

    $("input,textarea, select")
        .bind("checkval", function () {
            var label = $(this).prev("label");
            var labelContainer = $(this).closest(".fep-form-field");


            if (this.value) {
                label.addClass(showClass);
                labelContainer.addClass(showClass);
            } else {
                label.removeClass(showClass);
                labelContainer.removeClass(showClass);
            }
        })
        .on("keyup", function ()
        {
            $(this).trigger("checkval");
        })
        .on("focus", function ()
        {
            $(this).prev("label").addClass(onClass);
            $(this).closest(".fep-form-field").addClass(onClass);
        })
        .on("blur", function ()
        {
            $(this).prev("label").removeClass(onClass);
            $(this).closest(".fep-form-field").removeClass(onClass);
        })
        .trigger("checkval");

    $('.select-container select').change(function() {
        if ($(this).val())
            $(this).closest(".select-container").addClass(showClass);
        else
            $(this).closest(".select-container").removeClass(showClass);
    });

    $('.select-container').each(function () {
        if ($(this).find('select').val())
            $(this).addClass(showClass);
    });

    // Floating Labels Gravity Forms

    $('li.gfield .gfield_label').click(function(){
        $(this).next('.ginput_container').find('input[type="text"], textarea').focus();
    });

    $('.ginput_container input[type="text"], .ginput_container textarea').focus(function(){
        $(this).closest('.ginput_container').prev('.gfield_label').addClass('show');
    })
        .blur(function(){
            if( $(this).val() === "" ){
                $(this).closest('.ginput_container').prev('.gfield_label').removeClass('show');
            }
        });

    $('.ginput_container input[type="text"], .ginput_container textarea').each(function(){
        if( $(this).val() !== "" ){
            $(this).closest('.ginput_container').prev('.gfield_label').addClass('show');
        }
    });
    if (viewport.width < 992) {
        var allPanels = $('.main-menu .sub-menu').hide();
        $('.main-menu .sub-menu').parent('.menu-item-has-children').find('> a').click(function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            allPanels.slideUp();
            allPanels.removeClass('is-open');
            if ($(this).next().is(':hidden')){
                $(this).next().slideDown(500);
                $(this).next('.children').addClass('is-open');
                $(this).next('.sub-menu').addClass('is-open');
            } else {
                $(this).next().slideUp(500);
                $(this).next('.children').removeClass('is-open');
                $(this).next('.sub-menu').removeClass('is-open');
            }

            return false;
        });
    }

    var testimonialSlider = $('#testimonial-slider');
    if (testimonialSlider.length) {
        testimonialSlider.slick({
            dots: true,
            infinite: false,
            // variableWidth: true,
            arrows: false,
            // waitForAnimate: false,
            pauseOnHover: false,
            autoplay: true,
            autoplaySpeed: 4000,
            // speed: 800,
            fade: false,
            slidesToShow: 1,
            rtl: true,
        });
        $('#testimonial-slider').show();
    }


});
/* end of as page load scripts */