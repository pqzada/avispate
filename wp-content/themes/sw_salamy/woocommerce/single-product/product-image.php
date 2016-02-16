<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

$new_product = get_post_meta( $post->ID, 'new_product', true );
?>
<div class="product-images col-lg-5">

	<div id="flexslider-product" class="flexslider">
	  <ul class="slides">
	    <?php if ( has_post_thumbnail() ) : ?>

		<?php endif; ?>
	    <?php
			$attachments = $product->get_gallery_attachment_ids();
			
			if ($attachments) {

				foreach ( $attachments as $key => $attachment ) { ?>
					
					<li>
						<?php if ($product->is_on_sale()) : ?>

							<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'woocommerce' ).'</span>', $post, $product); ?>

						<?php endif; ?>
						<a href="<?php echo wp_get_attachment_url( $attachment ) ?> " rel="prettyPhoto[product-gallery]" class="zoom"><?php echo wp_get_attachment_image( $attachment, 'full' ); ?></a>
						
						<?php
							if( $new_product == 'yes' ){
								echo '<span class="new-product"></span>';
							}
						?>
					</li>
				
				<?php 
				}

			} else { 
				
				$image_id = get_post_thumbnail_id(); $image_url = wp_get_attachment_image_src($image_id,'large', true); ?>
				
				<li>
					<?php if ($product->is_on_sale()) : ?>

						<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'woocommerce' ).'</span>', $post, $product); ?>

					<?php endif; ?>
					<a title="<?php the_title(); ?>" href="<?php echo $image_url[0];  ?>" rel="prettyPhoto[product-gallery]" class="zoom"><?php the_post_thumbnail('full'); ?></a>
				</li>
				
			<?php } ?> 
		
	  </ul>				  
	</div>

	<?php do_action('woocommerce_product_thumbnails'); ?>
	
<script tyle="text/javascript">
	jQuery(document).ready(function(){
	  jQuery("#flex-thumbnail").flexslider({
		animation: "slide",
		controlNav: false,
		itemMargin: 10,
		animationLoop: false,
		slideshow: false,
		itemWidth: 85,				
		asNavFor: "#flexslider-product"
	  });

	  jQuery("#flexslider-product").flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: "#flex-thumbnail",
		start: function(slider){
		  jQuery("body").removeClass("loading");
		}
	  });
	});
</script>
</div>
