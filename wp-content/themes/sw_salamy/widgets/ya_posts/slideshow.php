<?php 
if (!isset($instance['category'])){
	$instance['category'] = 0;
}

$instance['interval'] = isset($instance['interval']) ? intval($instance['interval']) : 5000;

extract($instance);

$default = array(
	'category' => $category,
	'orderby' => $orderby,
	'order' => $order,
	'include' => $include,
	'exclude' => $exclude,
	'post_status' => 'publish',
	'numberposts' => $numberposts
);

$list = get_posts($default);

if (!wp_style_is('cslider_css')) {
	wp_enqueue_style('cslider_css');
}
if (!wp_script_is('cslider_js')) {
	wp_enqueue_script('cslider_js');
}

if ( count($list) > 0 ){
?>
	<div id="<?php echo $this->id; ?>" class="da-slider">
		<?php 
		foreach ( $list as $i => $post ) { ?>
			<div class="da-slide paral-slide<?php if( $i < 3){echo $i+1;} else{echo '1';} ?>">
				<div class="da-slide-title"><a href="<?php echo get_permalink($post); ?>"><?php echo $post->post_title; ?></a></div>
				<div class="da-slide-content">
					<p>
					<?php 
						if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
							$content = explode($matches[0], $post->post_content, 2);
							$content = $content[0];
							echo $content;
						} else {
							echo self::ya_trim_words( $post->post_content, $length, ' ' );
						}
					?>
					</p>
					<?php
					if( $i == 2 ){ ?>
						<a href="<?php echo get_permalink($post); ?>" class="readmore">Read more</a>
					<?php }	?>
				</div>				
				<?php if ( has_post_thumbnail($post->ID) ) {?>
					<div class="da-img"><?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?></div>
				<?php } ?>
			</div>
		<?php } ?>
		<nav class="da-arrows">
			<span class="da-arrows-prev"></span>
			<span class="da-arrows-next"></span>
		</nav>
	</div>
	<?php 
	add_action('wp_footer', array($this, 'add_script_slideshow'), 50);
}?>
