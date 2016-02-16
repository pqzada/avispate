<?php  
if (!isset($instance['categories'])){
	$instance['categories'] = 0;
}

$instance['count'] = isset($instance['count']) ? intval($instance['count']) : 3 ;
$instance['number_display'] = isset($instance['number_display']) ? intval($instance['number_display']) : 4 ;
$instance['number'] = isset($instance['number']) ? intval($instance['number']) : 5 ;
$instance['length'] = isset( $instance['length'] ) ? intval($instance['length']) : 25;
extract($instance);

$default = array(
	'orderby' => $orderby,
	'order' => $order,
	'number' => $number,
	'include' => implode(',', $categories),
	'exclude' => $exclude
);

$list = get_categories($default);

if (count($list) > 0){
?>

<div id="ya-categories-taste" class="carousel slide">
	<!-- Carousel items -->
	<div class="carousel-inner">
			<?php 
				foreach ( $list as $i => $category ){
					
					if($i%$number_display==0){?>
					<div class="item <?php if($i==0){ echo " active";}?> "> 
					<?php }?>
					<?php 
						$args = array(
								'numberposts' => $count,
								'category' => $category->cat_ID
							);
							
						$posts = get_posts($args);
					?>
					<div class="ya-category">
						<?php foreach ($posts as $k => $post) { ?>
							<div class="ya-post">
								<div class="ya-post-title"><h4><a href="<?php echo get_post_permalink($post->ID)?>"><?php echo $post->post_title?></a></h4></div>
								<div class="ya-post-desc"><?php echo self::ya_trim_words($post->post_content, $length, ' '); ?></div>
								<?php if ( $k==0 && get_the_post_thumbnail($post->ID) ) {?>
								<div class="ya-post-thumb"><?php echo get_the_post_thumbnail($post->ID); ?></div>
								<?php } ?>
							</div>
						<?php }?>
						<div class="ya-see-more"><a href="<?php echo get_category_link($category); ?>">see more</a></div>
					</div>
					<?php if(($i+1)%$number_display==0 || $i+1 == count($list)){ 
							echo '</div>'; }?>  
						
				<?php }?>
	</div><!-- .carousel-inner -->
	 <!-- Carousel nav -->
	<a class="carousel-control left" href="#ya-categories-taste" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#ya-categories-taste" data-slide="next">&rsaquo;</a>
</div>
<?php }?>