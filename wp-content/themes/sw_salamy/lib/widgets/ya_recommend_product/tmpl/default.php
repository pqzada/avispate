<?php 	global $woocommerce;	$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;		$args = array(	'post_type'		=> 'product',	'meta_key'		=> 'recommend_product',	'meta_value'	=> 'yes',	'showposts'		=> $number );	$loop = new wp_query( $args );	if( $loop -> have_posts() ) {	?>	<div id="<?php echo $widget_id; ?>" class="sw-recommend-product">		<ul>			<?php while ($loop->have_posts()) : $loop->the_post();			global $product, $post, $wpdb, $average;			$count = $wpdb->get_var("				SELECT COUNT(meta_value) FROM $wpdb->commentmeta				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID				WHERE meta_key = 'rating'				AND comment_post_ID = $post->ID				AND comment_approved = '1'				AND meta_value > 0			");			$rating = $wpdb->get_var("				SELECT SUM(meta_value) FROM $wpdb->commentmeta				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID				WHERE meta_key = 'rating'				AND comment_post_ID = $post->ID				AND comment_approved = '1'			");			?>			<li class="clearfix">				<div class="item-img">					<a href="<?php the_permalink(); ?>"><?php if( has_post_thumbnail() ){  echo get_the_post_thumbnail( $loop->post->ID, 'shop_thumbnail' ); }else{ echo woocommerce_placeholder_img( 'shop_thumbnail' ); } ?></a>				</div>				<div class="item-content">					<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>					<p><?php echo $product->get_price_html(); ?></p>					<?php						if( $count > 0 ){							$average = number_format($rating / $count, 1);					?>						<div class="star"><span style="width: <?php echo ($average*13).'px'; ?>"></span></div>											<?php } else { ?>											<div class="star"></div>											<?php } ?>										<div class="review">						<span><?php echo $count; ?> <?php _e(' review(s)', 'yatheme'); ?></span>					</div>				</div>			</li>			<?php endwhile; ?>		</ul>	</div><?php}?>