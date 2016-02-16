<?php 	$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;	global $wpdb;	global $post;?><?php do_action( 'before' ); ?><?php if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 	return "Please active woocommerce plugin first!";}	$args = array( 'post_type' => 'product', 'posts_per_page' => $number );	$args['meta_query'] = array();						$args['meta_query'][] = array(		'key' => '_featured',		'value' => 'yes'	);	$loop = new WP_Query( $args );	$i = 0;	$j = 0;	$k = 0;	if ( $loop->have_posts() ) {?><div id="<?php echo $widget_id; ?>" class="sw-feature-product">	<ul>	<?php		while ( $loop -> have_posts() ) : $loop -> the_post();		global $product, $post, $wpdb, $average;		$count = $wpdb->get_var("			SELECT COUNT(meta_value) FROM $wpdb->commentmeta			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID			WHERE meta_key = 'rating'			AND comment_post_ID = $post->ID			AND comment_approved = '1'			AND meta_value > 0		");		$rating = $wpdb->get_var("			SELECT SUM(meta_value) FROM $wpdb->commentmeta			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID			WHERE meta_key = 'rating'			AND comment_post_ID = $post->ID			AND comment_approved = '1'		");	?>		<li class="clearfix">			<div class="item-img">				<a href="<?php the_permalink(); ?>"><?php if( has_post_thumbnail() ){  echo get_the_post_thumbnail( $loop->post->ID, 'shop_thumbnail' ); }else{ echo woocommerce_placeholder_img( 'shop_thumbnail' ); } ?></a>			</div>			<div class="item-content">				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>                <p><?php echo $product->get_price_html(); ?></p>				<?php					if( $count > 0 ){						$average = number_format($rating / $count, 1);				?>					<div class="star"><span style="width: <?php echo ($average*13).'px'; ?>"></span></div>									<?php } else { ?>									<div class="star"></div>									<?php } ?>				<div class="review">					<span><?php echo $count; ?> <?php _e(' review(s) ', 'yatheme'); ?></span>				</div>			</div>		</li>	<?php 		endwhile;		wp_reset_query();	?>	</ul></div><?php } ?>