
jQuery(document).ready(function($) {
	$('.sw-search').fancybox();
    $('.carousel-catid').carousel({
        interval: 0
    });
   
    $('[data-tab-load=ajax]').on('click', function() {
    	sw_click_ajax( $(this) );
    });
    
    $('body').append('<div id="loading"></div>');
    
    function sw_click_ajax( $element ) {
    	
    	$catid = $element.attr('data-catid'); 
		$start = $element.attr('data-start');
		$layout = $('.sw-tab-content').attr('data-layout');
		$cols = $('.sw-tab-content').attr('data-colums');
		$max_length = $('.sw-tab-content').attr('data-max-length');
		$caption   = $('.sw-tab-content').attr('data-caption');
		if ( typeof $catid != 'undefined' && typeof $start != 'undefined' ) {
			
			var $id = $('#catid-'+ $catid +'-page-'+ $start); 
			
			if($catid.search(',') > 0){
				$id = $('#catid-all-page-'+ $start); 
			}
			
			if( $id.html() == ''){
				
				$( document ).ajaxStart(function() {
					$( "#loading" ).show();
				});
				
				$( document ).ajaxStop(function() {
					$( "#loading" ).hide();
				});
				
				var data = {
					action: 'sw_tab_content_callback',
					catid: $catid,
					start: $start,
					layout: $layout,
					colums: $cols,
					max_length: $max_length,
					caption: $caption
				};
				// We can also pass the url value separately from ajaxurl for front end AJAX implementations
				jQuery.post(sw_tab_content_object.ajax_url, data, function(response) {
					$id.html(response);
				});
			}
		}
		
    }
	
    $.extend($.fn.carousel.Constructor.prototype, {
    	
    	slide: function (type, next) {
	        var $active = this.$element.find('.item.active')
	          , $next = next || $active[type]()
	          , isCycling = this.interval
	          , direction = type == 'next' ? 'left' : 'right'
	          , fallback  = type == 'next' ? 'first' : 'last'
	          , that = this
	          , e
	
	        this.sliding = true
	
	        isCycling && this.pause()
	
	        $next = $next.length ? $next : this.$element.find('.item')[fallback]()
	
	        e = $.Event('slide', {
	          relatedTarget: $next[0]
	        , direction: direction
	        })
	
	        if ($next.hasClass('active')) return
	
	        if (this.$indicators.length) {
	          this.$indicators.find('.active').removeClass('active')
	          this.$element.one('slid', function () {
	            var $nextIndicator = $(that.$indicators.children()[that.getActiveIndex()])
	            $nextIndicator && $nextIndicator.addClass('active');
	            
	            sw_click_ajax($nextIndicator);
	            
	          })
	        }
	
	        if ($.support.transition && this.$element.hasClass('slide')) {
	          this.$element.trigger(e)
	          if (e.isDefaultPrevented()) return
	          $next.addClass(type)
	          $next[0].offsetWidth // force reflow
	          $active.addClass(direction)
	          $next.addClass(direction)
	          this.$element.one($.support.transition.end, function () {
	            $next.removeClass([type, direction].join(' ')).addClass('active')
	            $active.removeClass(['active', direction].join(' '))
	            that.sliding = false
	            setTimeout(function () { that.$element.trigger('slid') }, 0)
	          })
	        } else {
	          this.$element.trigger(e)
	          if (e.isDefaultPrevented()) return
	          $active.removeClass('active')
	          $next.addClass('active')
	          this.sliding = false
	          this.$element.trigger('slid')
	        }
	
	        isCycling && this.cycle();
	        
	        return this;
	      }
	        
    });
   	
});