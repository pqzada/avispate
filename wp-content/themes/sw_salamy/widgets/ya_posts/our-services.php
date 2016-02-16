<?php 
if (!isset($instance['category'])){
	$instance['category'] = 0;
}
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
//var_dump($list);
if (count($list)>0){
?>
<div class="widget-our-services">
	<div class="service-content clearfix">
		<?php 
		foreach ($list as $post){
		?>
		<div class="service-detail">
			<div class="widget-post">
				<?php 
				if (get_the_post_thumbnail( $post->ID )) {?>
					<div class="widget-thumb">
						<a href="<?php echo post_permalink($post->ID)?>"><?php echo get_the_post_thumbnail($post->ID, 'medium'); ?></a>
					</div>
				<?php } ?>
				<div class="widget-title">
					<h4><a href="<?php echo post_permalink($post->ID)?>"><?php echo $post->post_title;?></a></h4>
				</div>
				<a class="widget-read-more btn btn-default" href="<?php echo post_permalink($post->ID)?>"><i class="icon-caret-right"></i>Detail</a>
			</div>
		</div>
		<?php }?>
	</div>
</div>
<?php }

?>