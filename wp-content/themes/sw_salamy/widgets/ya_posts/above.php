<?php 
if (!isset($instance['category'])){
	$instance['category'] = 0;
}
extract($instance);

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
	'exclude' => $exclude,
	'post_status' => 'publish',
	'numberposts' => $numberposts
);

$list = get_posts($default);
//var_dump($list);
if (count($list)>0){
?>
<div class="widget-above">
	<div class="above-content clearfix">
		<?php foreach ($list as $post){
		$price = get_post_meta($post->ID, '_regular_price', true);
		print_r($price);
		?>
		<div class="above-detail">
			<div class="widget-post">
				<div class="widget-title">
					<h4><a href="#"><?php echo $post->post_title;?></a></h4>
				</div>
				<div class="widget-content">
					<?php 
					if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
						$content = explode($matches[0], $post->post_content, 2);
						$content = $content[0];
					} else {
						$content = self::ya_trim_words($post->post_content, $length, ' ');
					}
					echo $content;
					?>
				</div>
			</div>
		</div>
		<?php }?>
	</div>
</div>
<?php }?>