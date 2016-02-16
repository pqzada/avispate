<?php 	global $woocommerce;	$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;	$query_args = array(    		'posts_per_page' => $number,    		'post_status' 	 => 'publish',    		'post_type' 	 => 'product',    		'meta_key' 		 => 'total_sales',    		'orderby' 		 => 'meta_value_num',    		'no_found_rows'  => 1,    	);    	$query_args['meta_query'] = $woocommerce->query->get_meta_query();    	if ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) {    		$query_args['meta_query'][] = array(			    'key'     => '_price',			    'value'   => 0,			    'compare' => '>',			    'type'    => 'DECIMAL',			);    	}		$r = new WP_Query($query_args);		if ( $r->have_posts() ) {?><div id="<?php echo $widget_id; ?>" class="sw-best-seller-product">	<ul>	<?php		while ( $r -> have_posts() ) : $r -> the_post();		global $product, $post, $wpdb, $average;		$count = $wpdb->get_var("			SELECT COUNT(meta_value) FROM $wpdb->commentmeta			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID			WHERE meta_key = 'rating'			AND comment_post_ID = $post->ID			AND comment_approved = '1'			AND meta_value > 0		");		$rating = $wpdb->get_var("			SELECT SUM(meta_value) FROM $wpdb->commentmeta			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID			WHERE meta_key = 'rating'			AND comment_post_ID = $post->ID			AND comment_approved = '1'		");	?>		<li class="clearfix">			<div class="item-img">				<a href="<?php the_permalink(); ?>"><?php if( has_post_thumbnail() ){  echo get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ); }else{ echo woocommerce_placeholder_img( 'shop_thumbnail' ); } ?></a>			</div>			<div class="item-content">				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>                <p><?php echo $product->get_price_html(); ?></p>				<?php					if( $count > 0 ){						$average = number_format($rating / $count, 1);				?>					<div class="star"><span style="width: <?php echo ($average*13).'px'; ?>"></span></div>									<?php } else { ?>									<div class="star"></div>									<?php } ?>				<div class="review">					<span><?php echo $count; ?> <?php _e(' review(s) ', 'yatheme'); ?></span><!--					<a href="--><?php //the_permalink(); ?><!--">--><?php //_e('Add Review', 'yatheme'); ?><!--</a>-->				</div>			</div>		</li>	<?php 		endwhile;		wp_reset_query();	?>	</ul></div><?php } ?>