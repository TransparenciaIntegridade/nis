jQuery(document).ready(function(){

/*-----------------------------------------------------------------------------------*/
/*  Fade Effect
/*-----------------------------------------------------------------------------------*/
	jQuery('.button-menu, .widget_tj_twitter, .single-share').fadeIn('1000');

/*-----------------------------------------------------------------------------------*/
/*  Search Form (Popup)
/*-----------------------------------------------------------------------------------*/
    $('.header-search > .icon-search').click(function(){
       	$('.search-form').slideDown('', function() {});
     	$('.header-search > .icon-search').toggleClass('active');
     	$('.header-search > .icon-remove').toggleClass('active');
    });

    $('.header-search > .icon-remove').click(function(){
       	$('.search-form').slideUp('', function() {});
     	$('.header-search > .icon-search').toggleClass('active');
     	$('.header-search > .icon-remove').toggleClass('active');
    });

/*-----------------------------------------------------------------------------------*/
/*  Header Social Icons
/*-----------------------------------------------------------------------------------*/
    $('.header-social-icons a').tipsy({fade: true});

/*-----------------------------------------------------------------------------------*/
/*	jQuery Superfish Menu
/*-----------------------------------------------------------------------------------*/
    function init_nav(){
        jQuery('ul.nav').superfish({ 
	        delay:       1000,                             // one second delay on mouse out 
	        animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
	        speed:       'fast'                           // faster animation speed 
    	});
    }
    init_nav();

    /*---Center Nav Sub Menus---*/

	jQuery('.nav li ul').each(function(){
	
		li_width = jQuery(this).parent('li').width();
		li_width = li_width / 2;
		li_width = 100 - li_width - 10;
		
		jQuery(this).css('margin-left', - li_width);
	
	});
	
    /*  Make Video/Audio Responsive - Portfolio ----------------------*/
    function zilla_resize_media() {
        if( $().jPlayer && $('.format-video .jp-jplayer').length ){

            $(window).resize(function(){
                $('.format-video .jp-jplayer').each(function(){
                    var player = $(this),
                        orig_width = player.attr('data-orig-width'),
                        orig_height = player.attr('data-orig-height'),
                        new_width = orig_width,
                        new_height = orig_height,
                        win_width = $(window).width();

                    // Set responsive width breakpoints here
                    if( win_width <= 992 ) {
                        new_width = 600;
                    }
                    if( win_width <= 600 ) {
                        new_width = 240;
                    }

                    new_height = Math.round((new_width / orig_width) * orig_height);

                    if(player.hasClass('jp-jplayer')) { 
                        player.jPlayer('option', 'size', { width: new_width, height: new_height });
                    }
                    if(player.hasClass('embed-video')) {
                        player.width(new_width).height(new_height);
                    }
                });
            });
            $(window).trigger('resize'); // inital resize
        }
    }
    zilla_resize_media();
    
/*-----------------------------------------------------------------------------------*/
/*	Back To Top
/*-----------------------------------------------------------------------------------*/
	var topLink = jQuery('#back-to-top');

	function junkie_backToTop(topLink) {
		
		if(jQuery(window).scrollTop() > 0) {
			topLink.fadeIn(200);
		} else {
			topLink.fadeOut(200);
		}
	}
	
	jQuery(window).scroll( function() {
		junkie_backToTop(topLink);
	});
	
	topLink.find('a').click( function() {
		jQuery('html, body').stop().animate({scrollTop:0}, 500);
		return false;
	});
	
/*-----------------------------------------------------------------------------------*/
/*	Toggle Primary Navigation Menu on Mobile
/*-----------------------------------------------------------------------------------*/
	$('#toggle').click(function() {
	    $('#primary-nav .nav').slideToggle(400);
	    $(this).toggleClass("active");
	    
	    return false;
	    
	});
	
	function mobilemenu() {
	    
	    var windowWidth = $(window).width();
	
	    if( typeof window.orientation === 'undefined' ) {
	        $('#primary-nav .nav').removeAttr('style');
	    }
	
	    if( windowWidth < 1000 ) {
	        $('#primary-nav .nav').addClass('mobile-menu');
	    }
	    
	}
	
	mobilemenu();
	
	$(window).resize(function() {
	    mobilemenu();
	});

})