(function($) {
    jQuery('.phone-icon-search').click(function(){
        jQuery('.iphone-search-form').toggle("slide");
    });
	jQuery('ul.orderby.order-dropdown li ul').hide(); //hover in
    jQuery("ul.orderby.order-dropdown li span.current-li-content,ul.orderby.order-dropdown li ul").hover(function() {
        jQuery('ul.orderby.order-dropdown li ul').stop().fadeIn("fast");
    }, function() {
        jQuery('ul.orderby.order-dropdown li ul').stop().fadeOut("fast");
    });

    jQuery('.orderby-order-container ul.sort-count li ul').hide();
    jQuery('.sort-count.order-dropdown li span.current-li,.orderby-order-container ul.sort-count li ul').hover(function(){
        jQuery('.orderby-order-container ul.sort-count li ul').stop().fadeIn("fast");

    },function(){
        jQuery('.orderby-order-container ul.sort-count li ul').stop().fadeOut("fast");
    });

//  jQuery(".box-newsletter").center();



    jQuery('.list-unstyled')
        .find('li:gt(4)') //you want :gt(4) since index starts at 0 and H3 is not in LI
        .hide()
        .end()
        .each(function(){
            if($(this).children('li').length > 4){ //iterates over each UL and if they have 5+ LIs then adds Show More...
                $(this).append(
                    $('<li><a>See more   +</a></li>')
                        .addClass('showMore')
                        .click(function(){
                            if($(this).siblings(':hidden').length > 0){
                                $(this).html('<a>See less   -</a>').siblings(':hidden').show();
                            }else{
                                $(this).html('<a>See more   +</a>').show().siblings('li:gt(4)').hide();
                            }
                        })
                );
            }
        });
    /*Form search iP*/




    jQuery('a.phone-icon-menu').click(function(){
       var temp= jQuery('.navbar-inner.navbar-inverse').toggle( "slide" );
    });
	$('.ya-tooltip').tooltip();
	// fix accordion heading state
	$('.accordion-heading').each(function(){
		var $this = $(this), $body = $this.siblings('.accordion-body');
		if (!$body.hasClass('in')){
			$this.find('.accordion-toggle').addClass('collapsed');
		}
	});

	// twice click
	$(document).on('click.twice', '.open [data-toggle="dropdown"]', function(e){
		var $this = $(this), href = $this.attr('href');
		e.preventDefault();
		window.location.href = href;
		return false;
	});

    $('#cpanel').collapse();

    $('#cpanel-reset').on('click', function(e) {

    	if (document.cookie && document.cookie != '') {
    		var split = document.cookie.split(';');
    		for (var i = 0; i < split.length; i++) {
    			var name_value = split[i].split("=");
    			name_value[0] = name_value[0].replace(/^ /, '');

    			if (name_value[0].indexOf(cpanel_name)===0) {
    				$.cookie(name_value[0], 1, { path: '/', expires: -1 });
    			}
    		}
    	}

    	location.reload();
    });

	$('#cpanel-form').on('submit', function(e){
		var $this = $(this), data = $this.data(), values = $this.serializeArray();

		var checkbox = $this.find('input:checkbox');
		$.each(checkbox, function() {

			if( !$(this).is(':checked') ) {
				name = $(this).attr('name');
				name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

				$.cookie( name , 0, { path: '/', expires: 7 });
			}

		})

		$.each(values, function(){
			var $nvp = this;
			var name = $nvp.name;
			var value = $nvp.value;

			if ( !(name.indexOf(cpanel_name + '[')===0) ) return ;

			//console.log('name: ' + name + ' -> value: ' +value);
			name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

			$.cookie( name , value, { path: '/', expires: 7 });

		});

		location.reload();

		return false;

	});

	$('a[href="#cpanel-form"]').on( 'click', function(e) {
		var parent = $('#cpanel-form'), right = parent.css('right'), width = parent.width();

		if ( parseFloat(right) < -10 ) {
			parent.animate({
				right: '0px',
			}, "slow");
		} else {
			parent.animate({
				right: '-' + width ,
			}, "slow");
		}

		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		} else $(this).addClass('active');

		e.preventDefault();
	});
/*
$(window).on("load resize",function(){
	$('.nav-mega').each(function(){
		var $menu = $(this), $menu_dim = {
			left: $menu.offset().left,
			width: $menu.width()
		};
		//console.log( $menu );
		//console.log( $menu_dim );

		$('.dropdown', $menu).each(function(){
			var $parent_dim = {
				left: $(this).offset().left,
				width: $(this).outerWidth(true)
			};
			//console.log( $(this) );
			//console.log( $parent_dim );

			$dropdown = $('.dropdown-menu', this);
			if ( $dropdown.length ){
				var $drop_dim = {
					left: $dropdown.offset().left,
					width: $dropdown.outerWidth(true)
				}
				if ( $drop_dim.width > $menu_dim.width ){
					$drop_dim_left = $menu_dim.left - $parent_dim.left - ($drop_dim.width-$menu_dim.width)/2;
					$dropdown.css({left: $drop_dim_left});
				} else {
					var overright = overleft = false;
					// over right
					if ( $parent_dim.left + $drop_dim.left + $drop_dim.width > $menu_dim.left + $menu_dim.width){
						var $drop_dim_by_right = - $parent_dim.left - $drop_dim.width + $menu_dim.left + $menu_dim.width;
						overright = true;
					} else if ( $parent_dim.left + $parent_dim.width - $drop_dim.width < $menu_dim.left ){
						var $drop_dim_by_left = $menu_dim.left - $parent_dim.left;
						overleft = true;
					}
					//console.log( $dropdown );
					//console.log( $drop_dim );
					//overleft && console.log('->toleft: '+ $drop_dim_by_right );
					//overright && console.log('->toright: '+ $drop_dim_by_right );
					//console.log('------------------------------------------------------------------');
					if ( overright ){
						$dropdown.css({left: $drop_dim_by_right});
					} else if ( overleft ){
						$dropdown.css({left: $drop_dim_by_left});
					}
				}
			}
		});
		// $menu.on('hover');
		// console.log( $menu_dim );
	});
});
*/
/*Product listing select box*/
	jQuery('.catalog-ordering .orderby .current-li a').html(jQuery('.catalog-ordering .orderby ul li.current a').html());
	jQuery('.catalog-ordering .sort-count .current-li a').html(jQuery('.catalog-ordering .sort-count ul li.current a').html());
/*currency Selectbox*/
	$('.currency_switcher li a').click(function(){
		$current = $(this).attr('data-currencycode');
		jQuery('.currency_w > li > a').html($current);
	});
	
/*Quickview*/
	jQuery('.fancybox').fancybox({
		'width'     : 800,
		'height'   : 'auto',
		'autoSize' : false
	});
/*lavalamp*/
	$.fn.lavalamp = function(options){
		var defaults = {
    			elm_class: 'active',
				durations: 400
 		    },
            settings = $.extend(defaults, options);
		this.each( function(){
			var elm = ('> li');
			var current_check = $(elm, this).hasClass( settings.elm_class );
			current = elm + '.' + settings.elm_class;
			if( current_check ){
				var $this=jQuery(this), left0 = $(this).offset().left, dleft0 = $(current, this).offset().left - left0, dwidth0 = $('>ul>li.active', this).width();
				$(this).append('<div class="floatr"></div>');
				var $lava = jQuery('.floatr', $this), move = function(l, w){
					$lava.stop().animate({
						left: l,
						width: w
					}, {
						duration: settings.durations,
						easing: 'linear'
					});
				};
				
				var $li = jQuery('>li', this);
				//console.log( $li );
				// 1st time
				
				move(dleft0, dwidth0);
				$lava.show();
				$li.hover(function(e){
					var dleft = $(this).offset().left - left0;
					var dwidth = $(this).width();
					//console.log(dleft);
					move(dleft, dwidth);
				}, function(e){
					move(dleft0, dwidth0);
				});	
			}
		});
	}
	jQuery(document).ready(function(){
		var currency_show = jQuery('ul.currency_switcher li a.active').html();
		jQuery('.currency_to_show').html(currency_show);	
		jQuery('.nav-css').lavalamp();
		jQuery('.megaMenu').lavalamp({
			elm_class: 'current-menu-parent'
		});
		jQuery('.megaMenu').lavalamp({
			elm_class: 'current-menu-item'
		});
	}); 
/*end lavalamp*/
	jQuery(function($){
	// back to top
	$("#ya-totop").hide();
	$(function () {
		var wh = $(window).height();
		var whtml = $(document).height();
		$(window).scroll(function () {
			if ($(this).scrollTop() > whtml/10) {
					$('#ya-totop').fadeIn();
				} else {
					$('#ya-totop').fadeOut();
				}
			});
		$('#ya-totop').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
			});
	});
	// end back to top
	}); 
	
}(jQuery));



