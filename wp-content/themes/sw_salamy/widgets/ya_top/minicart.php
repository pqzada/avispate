<?php do_action( 'before' ); ?>
<?php if ( (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || (in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ))) ) { ?>
<?php global $woocommerce; ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.wrapp-minicart').css({'display':'none','z-index':'-9999'});
        var item=parseInt(jQuery('.top-minicart a.cart-contents .minicart-number').text());

        jQuery('.top-minicart,.wrapp-minicart').hover(function(){
            if(item != '')
            {
                jQuery('.wrapp-minicart').css('z-index','9999');
                jQuery('.wrapp-minicart').stop().fadeIn(300);
            }
            else{
                jQuery('.wrapp-minicart').css({'display':'none','z-index':'-9999'});
        }

        },function(){
            jQuery('.wrapp-minicart').stop().fadeOut(300);
        });
//        jQuery('body').click(function(){
//            jQuery('.wrapp-minicart').stop().fadeOut(300);
//        });
        });
    </script>
<div class="top-form top-form-minicart pull-right">
	<div class="top-minicart pull-right">
		<span><?php _e('My Cart','yatheme');?></span>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'yatheme'); ?>"><?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span>'; _e('item(s)', 'yatheme');?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	</div>
    <div class="wrapp-minicart">
        <div class="minicart-padding">
	<ul class="minicart-content">
	<?php foreach($woocommerce->cart->cart_contents as $cart_item): ?>
		<li>
			<a href="<?php echo get_permalink($cart_item['product_id']); ?>">
				<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
				<?php echo get_the_post_thumbnail($thumbnail_id, 'shop_thumbnail'); ?>
                <div class="cart-desc">
                    <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                    <div class="block-qty">
                        <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?>
                        <span class="product-quantity">Qty:<?php echo '<span class="quantity">'.$cart_item['quantity'].'</span>'; ?></span>
                    </div>
                </div>
			</a>
		</li>
	<?php
	endforeach;
	?>
	</ul>
	<div class="cart-checkout">
		<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('Go To Cart', 'yatheme'); ?></a></div>
		<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Check Out', 'yatheme'); ?></a></div>
	</div>
        </div>
    </div>
</div>
<?php } ?>