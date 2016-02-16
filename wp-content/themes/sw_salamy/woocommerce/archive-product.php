<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		 global $post;
		do_action('woocommerce_before_main_content');
	?>
		<div class="products-wrapper">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		
			<div class="listing-title">
			
				<h1><span><?php woocommerce_page_title(); ?></span></h1>
				
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>
			<div class="products-nav">
				<ul class="respl-view respl-option" data-option-key="layoutMode">
					<li class="view-grid sel">
						<a data-rl_value="fitRows" href="#content"><i class="icon-th"></i></a>
					</li>
					<li class="view-list">
						<a data-rl_value="straightDown" href="#content"><i class="icon-list-ul"></i></a>
					</li>
				</ul>
			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			</div>
			<div class="clear"></div>
			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
			<div class="clear"></div>
			<div class="products-nav">
				<ul class="respl-view respl-option" data-option-key="layoutMode">
					<li class="view-grid sel">
						<a data-rl_value="fitRows" href="#content"><i class="icon-th"></i></a>
					</li>
					<li class="view-list">
						<a data-rl_value="straightDown" href="#content"><i class="icon-list-ul"></i></a>
					</li>
				</ul>
			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>
			</div>
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
	</div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action('woocommerce_sidebar');
	?>

<?php get_footer('shop'); ?>
<script language="JavaScript">
//<![CDATA[
jQuery(document).ready(function($){
	;(function(element){
	var $respl = $(element);
	var $container = $('.products-loop', $respl);
	$container.imagesLoaded( function(){
			$container.isotope({
				containerStyle: {
		    					position: 'relative',
		    	    			height: 'auto',
		    	    			overflow: 'visible'
		    	    		  },
				itemSelector : '.product',
		      	layoutMode: 'fitRows',
				sortAscending: true
			});
		 

		if ( $.browser.msie  && parseInt($.browser.version, 10) <= 8){
			//nood
		}else{
			$(window).resize(function() {
				$container.isotope('reLayout');
			});
	    }
		_opTionSets();
		function _opTionSets(){
			var $optionSets = $('.products-nav .respl-option', $respl),
				$optionLinks = $optionSets.find('a');
				$optionLinks.each(function(){
				$(this).click(function(){
					var $this = $(this);
					var $optionSet = $this.parents('.respl-option');
			  
					$this.parent().addClass('sel').siblings().removeClass('sel');				
				
					
					// make option object dynamically, i.e. { filter: '.my-filter-class' }
					var options = {},
						key = 'layoutMode',
						value = $this.attr('data-rl_value');
					// parse 'false' as false boolean
					value = value === 'false' ? false : value;
					options[ key ] = value;
					if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
					  // changes in layout modes need extra logic
					  changeLayoutMode( $this, options )
					} else {
					  // otherwise, apply new options
					  $container.isotope( options );
					}
				
				return false ;
			   });
			});
		}
	      // change layout
	      function changeLayoutMode( $link, options ) {
	          if(options.layoutMode == 'straightDown'){
				 $('.products-wrapper',$respl).css('overflow','hidden');
	        	 $('.products-loop', $respl).removeClass('products-grid').addClass('products-list');
	        	 $container.isotope('reLayout');
	         }else{
				 $('.products-wrapper',$respl).removeAttr('style');
	        	 $('.products-loop', $respl).removeClass('products-list').addClass('products-grid');
	        	 $container.isotope('reLayout');
	         }
	      }

	   });
	})('#content');
});
  
    jQuery( document ).ready(function() {
        jQuery('ul.orderby.order-dropdown li ul').hide(); //hover in
        jQuery("ul.orderby.order-dropdown li span.current-li-content,ul.orderby.order-dropdown li ul").hover(function() {
            jQuery('ul.orderby.order-dropdown li ul').stop().fadeIn("fast");
        }, function() {
            jQuery('ul.orderby.order-dropdown li ul').stop().fadeOut("fast");
        });


    });
//]]>	
</script>