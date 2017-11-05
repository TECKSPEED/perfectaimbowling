jQuery(document).ready(function (jQuery) {
    jQuery("div.w-nav-button.menu-button").click(function () {
        if(jQuery(this).hasClass('w--open')){
            jQuery(this).removeClass('w--open');
            jQuery("nav.w-nav-menu.nav-menu").removeClass("w--nav-menu-open");
            jQuery("body").removeClass('locked');
        }
        else{
            jQuery(this).addClass("w--open");
            jQuery("nav.w-nav-menu.nav-menu").addClass("w--nav-menu-open");
            jQuery("body").addClass('locked');
        }
    });

    jQuery("ul#primary-menu.menu li, ul#mobile.menu li").each(function (e) {
        if(jQuery(this).find("ul.sub-menu a").length > 0) {
            jQuery(this).addClass("has-sub");
        }
    });

    jQuery(window).resize( function (){
        jQuery("nav.w-nav-menu.nav-menu").removeClass("w--nav-menu-open");
        jQuery("div.w-nav-button.menu-button").removeClass("w--open");
        jQuery("li.menu-item.showing").removeClass("showing");
        jQuery("body").removeClass('locked');
        if(jQuery(window).width() < 992) {
            jQuery(".mobile-menu").css("display", "block");
            jQuery(".mobile-menu-logo").css("display", "block");
            jQuery(".desktop-menu").css("display", "none");
        }
        else {
            jQuery(".mobile-menu").css("display", "none");
            jQuery(".mobile-menu-logo").css("display", "none");
            jQuery(".desktop-menu").css("display", "block");
        }
    });

    if(jQuery(window).width() < 992) {
        jQuery(".mobile-menu").css("display", "block");
        jQuery(".mobile-menu-logo").css("display", "block");
        jQuery(".desktop-menu").css("display", "none");
    }
    else {
        jQuery(".mobile-menu").css("display", "none");
        jQuery(".mobile-menu-logo").css("display", "none");
        jQuery(".desktop-menu").css("display", "block");
    }

    jQuery("li.menu-item").each( function() {
        if(jQuery(this).find("> ul").length > 0){
            jQuery(this).find("> a").click(function(e) {
                if(jQuery(this).parent().is(".showing")) {
                    jQuery(this).parent().removeClass("showing");
                }
                else {
                    jQuery("li.menu-item.showing").removeClass("showing");
                    jQuery(this).parent().addClass("showing");
                }
                e.preventDefault();
                e.stopPropagation();

            });
        }
    });
    jQuery("body").click(function(e) {
        if(!jQuery(e.target).is("li.menu-item") && !jQuery(e.target).is("li.menu-item *")) {
            jQuery("li.menu-item.showing").removeClass("showing");
        }
    });

    jQuery( "#tabs" ).tabs();
    jQuery("#accordion").accordion({
        collapsible: true,
		active: false,
		heightStyle: "content"
	});

    jQuery(".product-filter-section").on("click", function() {
        jQuery(".product-filter-content").toggle("slide");
    });


    jQuery(".featured-product").matchHeight();
    jQuery(".staff-member").matchHeight();
    jQuery(".matchHeight").matchHeight();

    jQuery(function() {
        jQuery('.featured-product-container').Lazy({
            scrollDirection: 'vertical',
            effect: 'fadeIn',
            visibleOnly: true,
        });
    });

    jQuery(".home-page-slider").slick({
		arrows: false,
		autoplay: true,
		autoplaypeed: 9000,
		slidesToScroll: 1,
		pauseOnHover: true,
		draggable: true,
		swipe: true,
		swipeToSlide: true,
		touchMove: true
	});

    jQuery(".slide-product-content").slick({
        arrows: true,
        autoplay: true,
        dots: true,
        pauseOnHover: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    pauseOnHover:  true,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    pauseOnHover:  true,
                    arrows: false,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 467,
                settings: {
                    slidesToShow: 1,
                    dots: false,
                    arrows: false,
                    slidesToScroll: 1
                }
            }]
    });

    jQuery("#primary-menu li a").addClass("hvr-underline-from-center");

    //unbind the original scroll and resize
    //jQuery(window).unbind('scroll');
    //jQuery(window).unbind('resize');
    //reassign jQuery to jQuery
    //jQuery = jQuery;

//this jquery function return the elements offset relative to the window bounds
    jQuery.fn.relativeOffset = function () {
        var offset = {
            left : 0,
            top : 0
        };
        offset.left = jQuery(this).get (0).getBoundingClientRect ().left;
        offset.top =  jQuery(this).get (0).getBoundingClientRect ().top;
        return offset;
    };

//this function returns true/false based on the breakpoint
    jQuery.fn.stickyHeader = function () {
        return jQuery(window).width () <= 992;
    };

//triggered on every scroll
    jQuery(window).scroll (function (e) {
        //check for the filters element, only perform logic if it exists
        var filters = jQuery('.product-filter-section');
        if (filters.get (0) !== undefined) {
            //get the reference to the element we will watch, at first it will be sub main
            var tracked = jQuery('.sub-main');
            var breadCrumbs = jQuery('.breadcrumb-container');
            //if there are breadcrumbs, use those instead
            if (breadCrumbs.get (0) !== undefined && breadCrumbs.is(':visible')) {
                tracked = breadCrumbs;
            }
            //calculate the scroll offset
            var scrollOffset = tracked.relativeOffset ().top + tracked.outerHeight (true);
            //on desktop, the threshold is 0
            var windowReferenceOffset = 0;
            //on mobile, the threshold is the height of the header
            if (jQuery(window).stickyHeader ()) {
                windowReferenceOffset = jQuery('.header-container').outerHeight (true);
            }
            //check if the scroll offset is less than or equal to the threshold
            if (scrollOffset <= windowReferenceOffset) {
                //add sticky if it isn't already
                if (!filters.is ('.sticky')) {
                    filters.addClass ('sticky');
                }
                //add padding top to the subpage container
                jQuery('.product-subpage-container').css('padding-top', filters.outerHeight (true) + 'px');
            } else {
                //remove sticky if it is
                if (filters.is ('.sticky')) {
                    filters.removeClass ('sticky');
                }
                //remove padding top from subpage container
                jQuery('.product-subpage-container').css('padding-top', '');
            }
        }
    });

//get the initial window width
    window.retainedWidth = jQuery(window).width ();

//triggered on resize
    jQuery(window).resize (function (e) {
        //check if new window width is different than the initial
        if (jQuery(window).width () != window.retainedWidth) {
            //if window width is different, trigger the scroll function
            window.retainedWidth = jQuery(window).width ();
            jQuery(window).scroll ();
        }
    });


    /*//Lock the body if the filter is open
    jQuery('.product-filter-accordion .ui-accordion-header').on("click", function() {
        if(jQuery('body').hasClass('locked')) {
            jQuery('body').removeClass('locked');
        } else
            jQuery('body').addClass('locked');
    });*/

    if(jQuery('.filter-component-container').find('.price_slider_wrapper')) {
        jQuery(this).removeClass('w-col-small-6').removeClass('w-col-tiny-6');
        jQuery(this).addClass('w-col-small-12').addClass('w-col-tiny-12');
    }

    WebFont.load({
        google: {
            families: ["Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","PT Serif:400,400italic,700,700italic"]
        }
    });

    var youtube = document.querySelectorAll( ".youtube" );
    for (var i = 0; i < youtube.length; i++) {
        // thumbnail image source.
        var source = "https://img.youtube.com/vi/"+ youtube[i].dataset.embed +"/sddefault.jpg";
        // Load the image asynchronously
        var image = new Image();
        image.src = source;
        image.addEventListener( "load", function() {
            youtube[ i ].appendChild( image );
        }( i ) );
        youtube[i].addEventListener( "click", function() {
            var iframe = document.createElement( "iframe" );
            iframe.setAttribute( "frameborder", "0" );
            iframe.setAttribute( "allowfullscreen", "" );
            iframe.setAttribute( "src", "https://www.youtube.com/embed/"+ this.dataset.embed +"?rel=0&showinfo=0&autoplay=0" );
            this.innerHTML = "";
            this.appendChild( iframe );
        } );
    }

    //Add plus and minus to quantity
    jQuery('.quantity').on('click', '.plus', function(e) {
        var input = jQuery(this).prev('input.qty');
        var val = parseInt(input.val());
        var step = input.attr('step');
        step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
        input.val( val + step ).change();
    });
    jQuery('.quantity').on('click', '.minus',
        function(e) {
            var input = jQuery(this).next('input.qty');
            var val = parseInt(input.val());
            var step = input.attr('step');
            step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
            if (val > 0) {
                input.val( val - step ).change();
            }
        });

});


