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
<div class="widget-the-blog">
	<?php foreach ($list as $post){?>
	<div class="widget-post">
		<div class="widget-post-inner">
			<?php if (get_the_post_thumbnail( $post->ID )) {?>
			<div class="widget-thumb">
				<a href="<?php echo post_permalink($post->ID)?>"><?php echo get_the_post_thumbnail($post->ID, 'thumbnail');?></a>
			</div>
			<?php } ?>
			<div class="widget-caption">
				<div class="widget-title">
					<a href="<?php echo post_permalink($post->ID)?>"><?php echo $post->post_title;?></a>
				</div>
				<div class="widget-meta">
					<?php $author = get_userdata($post->post_author)?>
					By <a href="<?php echo get_author_posts_url($post->post_author);?>"><?php echo $author->data->user_login?></a>, <?php echo date('d-m-Y', strtotime($post->post_date))?>
				</div>
				<a class="widget-read-more" href="<?php echo post_permalink($post->ID)?>"><i class="icon-circle-arrow-right"></i><span>Read More</span></a>
			</div>
		</div>
	</div>
	<?php }?>
	<div class="widget-view-category"><a href="<?php echo get_category_link($category)?>">See More <i class="icon-double-angle-right"></i></a></div>
</div>
<?php }?>