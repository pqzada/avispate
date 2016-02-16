<?php 
	global $product, $woocommerce, $woocommerce_loop;
	$upsells = $product->get_upsells();
	if( count($upsells) == 0 || is_archive() ) return ;
	add_image_size('slider-thumb', 270, 430, true);
	
	if( $category != 0 ){
	$default = array(
		'post_type' => 'product',
		'tax_query'	=> array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'		=> 'id',
			'terms'		=> $category)),
		'orderby' => $orderby,
		'order' => $order,
		'include' => $include,
		'post__in'   => $upsells,
		'exclude' => $exclude,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	}else{
		$default = array(
			'post_type' => 'product',
			'orderby' => $orderby,
			'post__in'   => $upsells,
			'order' => $order,
			'post_status' => 'publish',
			'showposts' => $numberposts
		);
	}
	$list = new WP_Query( $default );
	do_action( 'before' ); 
	if ( (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || (in_array( 'jigoshop/jigoshop.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ))) ) { 
	if ( count($list) > 0 ){
		$tag_id ='sj_woo_slider_'.rand().time();
	?>
        <div class="box-upsell-title">
            <h2><?php echo $title1; ?></h2>
            <p> <?php echo $desc; ?></p>
<img id="slide-img-1" src="<?php bloginfo('template_directory'); ?>/assets/img/hr-up-sell.png" class="slide" alt="" />			
        </div>
	<div id="<?php echo $tag_id; ?>" class="sj-woo-container-slider" style="<?php if( $anchor == "bottom" ){ echo "margin-bottom:40px;"; }?>">
			<div class="page-button">
				<ul class="control-button preload">
					<li class="preview"></li>
					<li class="next"></li>
				</ul>		
			</div>		
		<?php 
		$count_items = 0;
		if($numberposts >= $list->found_posts){$count_items = $list->found_posts; }else{$count_items = $numberposts;}
		//var_dump($list);
		if($columns > $count_items){
			$columns = $count_items;
		}
		
		if($columns1 > $count_items){
			$columns1 = $count_items;
		}
		
		if($columns2 > $count_items){
			$columns2 = $count_items;
		}
		
		if($columns3 > $count_items){
			$columns3 = $count_items;
		}
		
		if($columns4 > $count_items){
			$columns4 = $count_items;
		}
		
		$deviceclass_sfx = 'preset01-'.$columns.' '.'preset02-'.$columns1.' '.'preset03-'.$columns2.' '.'preset04-'.$columns3.' '.'preset05-'.$columns4;
		
		?>
		<div class="slider not-js cols-6 <?php echo $deviceclass_sfx; ?>">
			<div class="vpo-wrap">
				<div class="vp">
					<div class="vpi-wrap">
					<?php while($list->have_posts()): $list->the_post();global $product, $post, $wpdb, $average;?>
						<div class="item">
							<div class="item-wrap">							
								<?php if(has_post_thumbnail()){ ?>
								<div class="item-img item-height">
									<div class="item-img-info products-thumb">
										<a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>">
											<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
											<?php if ( $price_html = $product->get_price_html() ) : ?>
												<span class="price"><?php echo $price_html; ?></span>
											<?php endif; ?>
										</a>
										<?php
											$nonce = wp_create_nonce("sw_quickviewproduct_nonce");
											$link = admin_url('admin-ajax.php?ajax=true&action=sw_quickviewproduct&post_id='.$product->id.'&nonce='.$nonce);
											$linkcontent ='<a href="'. $link .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'yatheme' ) ).'</a>';
											echo $linkcontent;
										?>
									</div>
								</div>
								<?php } ?>
								<div class="item-content">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<div class="item-desc">
										<?php 
											$content = $post->post_excerpt;
											echo $this->ya_trim_words($content, $length, '...');
										?>
									</div>
									<div class="item-bottom clearfix">
										<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
											sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
												esc_url( $product->add_to_cart_url() ),
												esc_attr( $product->id ),
												esc_attr( $product->get_sku() ),
												$product->is_purchasable() ? 'add_to_cart_button' : '',
												esc_attr( $product->product_type ),
												esc_html( $product->add_to_cart_text() )
											),
										$product );
										$count = $wpdb->get_var("
											SELECT COUNT(meta_value) FROM $wpdb->commentmeta
											LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
											WHERE meta_key = 'rating'
											AND comment_post_ID = $post->ID
											AND comment_approved = '1'
											AND meta_value > 0
										");

										$rating = $wpdb->get_var("
											SELECT SUM(meta_value) FROM $wpdb->commentmeta
											LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
											WHERE meta_key = 'rating'
											AND comment_post_ID = $post->ID
											AND comment_approved = '1'
										");
										?>
										<div class="reviews-content">
											<?php
												if( $count > 0 ){
													$average = number_format($rating / $count, 1);
											?>
												<div class="star"><span style="width: <?php echo ($average*13).'px'; ?>"></span></div>
												
											<?php } else { ?>
											
												<div class="star"></div>
												
											<?php } ?>
												<div class="item-number-rating">
													<?php echo $count; _e(' review(s)', 'yatheme');?>
												</div>
										</div>
									</div>
								</div>											
							</div>
						</div>
					<?php endwhile; wp_reset_query();?>
					</div>
				</div>
			</div>
		</div>		
	</div>
	<script type="text/javascript">
		//<![CDATA[
			jQuery(document).ready(function($){
				;(function(element){
					var $element = $(element);
					var $slider = $('.slider', $element)
					jQuery('.slider', $element).responsiver({
						interval: <?php echo $interval; ?>,
						speed: <?php echo $speed; ?>,
						start: <?php echo $start-1; ?>,	
						step: <?php echo $scroll; ?>,
						circular: true,
						preload: true,
						fx: '<?php echo $effect; ?>',
						pause: '<?php echo $hover; ?>',
						control:{
							prev: '#<?php echo $tag_id;?> .control-button li[class="preview"]',
							next: '#<?php echo $tag_id;?> .control-button li[class="next"]'
						},
						getColumns: function(element){
							var match = $(element).attr('class').match(/cols-(\d+)/);
							if (match[1]){
								var column = parseInt(match[1]);
							} else {
								var column = 1;
							}
							if (!column) column = 1;
							return column;
						}          
					});
						<?php if($swipe == 'yes') {	?>
							$slider.touchSwipeLeft(function(){
								$slider.responsiver('next');
								}
							);
							$slider.touchSwipeRight(function(){
								$slider.responsiver('prev');
								}
							);
						<?php } ?>
					$('.control-button',$element).removeClass('preload');
				})('#<?php echo $tag_id; ?>');
			});
		//]]>
		</script>
<?php
} }
?>