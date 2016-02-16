<?php 
	$default = array(
		'post_type' => 'testimonial',
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	$list = new WP_Query( $default );
	if ( count($list) > 0 ){
	$i = 0;
	$j = 0;
	$k = 0;
?>
	<div id="<?php echo $widget_id; ?>" class="testimonial-slider carousel slide">
		<ul class="carousel-indicators">
			<?php while ( $list->have_posts() ) : $list->the_post();?>
				<?php if( $j % 3 == 0 ) {  $k++;?>
				<li class="<?php if( $j == 0 ){ echo 'active'; } ?>" data-slide-to="<?php echo $k-1; ?>" data-target="#<?php echo $widget_id; ?>">  
				<?php }  if( ( $j+1 ) % 3 == 0 || ( $j+1 ) == $numberposts ){?>
				</li>
			<?php
				}
					
				$j++; 
			?>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</ul>
		<div class="carousel-inner">
			<?php 					
				while($list->have_posts()): $list->the_post();
				global $post;
				$au_name = get_post_meta( $post->ID, 'au_name', true );
				$au_url  = get_post_meta( $post->ID, 'au_url', true );
				$au_info = get_post_meta( $post->ID, 'au_info', true );
				if( $i % 3 == 0 ){ 
			?>
				<div class="item <?php if( $i == 0 ){ echo 'active'; } ?>">
				<div class="row">
			<?php } ?>
					<div class="item-inner col-lg-12">
						<?php if( has_post_thumbnail() ){ ?>
							<div class="item-image">
								<a href="<?php echo $au_url; ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
							</div>
							<div class="item-content">
								<div class="item-desc">
									<?php 
										$text = get_the_content($post->ID);
										$content = wp_trim_words($text, $length);
										echo $content;
									?>
								</div>
								<div class="item-info">
									<h4><?php echo $au_name; ?> - <?php echo $au_info; ?></h4>
								</div>
							</div>
						<?php } ?>
					</div>
			<?php if( ( $i+1 )%3==0 || ( $i+1 ) == $numberposts ){?> </div></div><?php } ?>
			<?php $i++; endwhile; wp_reset_query(); ?>
		</div>
	</div>
<?php	
}
?>