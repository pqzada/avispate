<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ){
	$woocommerce_loop['loop'] = 0;
}
if( $woocommerce_loop['loop'] % 3 == 0 ){
	$woocommerce_loop['loop'] = 0;
}
$classes = 'product-col-'.$woocommerce_loop['loop'];
$woocommerce_loop['loop']++;
// Ensure visibility
if ( ! $product->is_visible() )
	return;
	
?>
<li <?php post_class($classes); ?>>
	<div class="products-entry clearfix">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="products-thumb">
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
				$nonce = wp_create_nonce("sw_quickviewproduct_nonce");
				$link = admin_url('admin-ajax.php?ajax=true&amp;action=sw_quickviewproduct&amp;post_id='.$product->id.'&amp;nonce='.$nonce);
				$linkcontent ='<a href="'. $link .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'yatheme' ) ).'</a>';
				echo $linkcontent;
			?>
		</div>
		
		<div class="products-content">
			<h3><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h3>
			<?php wc_get_template( 'loop/price.php' );?>
			<p class="short-description"><?php echo excerpt(25); ?></p>
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
            <?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );

            ?>
		</div>
	</div>
</li>