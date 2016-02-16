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
<div class="widget-post-format">
	<div class="widget-pformat-content clearfix">
		<?php 
		foreach ($list as $post){
			if (has_post_format('video', $post)) {
				$icon = 'icon-film';
			} elseif (has_post_format('image', $post)) {
				$icon = 'icon-picture';
			} elseif (has_post_format('gallery', $post)) {
				$icon = 'icon-camera';
				
				if(preg_match_all('/\[gallery(.*?)?\]/', $post->post_content, $matches)){
					$attrs = array();
					if (count($matches[1])>0){
						foreach ($matches[1] as $m){
							$attrs[] = shortcode_parse_atts($m);
						}
					}
					if (count($attrs)> 0){
						foreach ($attrs as $attr){
							if (is_array($attr) && array_key_exists('ids', $attr)){
								$ids = $attr['ids'];
								break;
							}
						}
					}
			
					if (isset($ids)) {	
						if (!wp_style_is('bootstrap_gallery_css')){
							wp_enqueue_style('bootstrap_gallery_css');
						}
						if (!wp_style_is('bootstrap_gallery_js')){
							wp_enqueue_script('bootstrap_gallery_js');
						}
						$ids = explode(',', $ids);
					}
				}			
						
			}else $icon = 'icon-pencil';
		?>
		<div class="widget-pformat-detail">
			<div class="widget-post">
				<div class="widget-title">
					<h4><a href="<?php echo post_permalink($post->ID)?>"><i <?php echo 'class="'.$icon.'"'; ?>></i><?php echo $post->post_title;?></a></h4>
				</div>
				<?php 
				if (has_post_format('gallery', $post) && isset($ids)){ ?>
					<div class="post-format-Carousel carousel slide" id="carousel-<?php echo $post->ID; ?>">
						<div class="carousel-inner">
							<?php foreach ($ids as $i => $id){?>
							<div class="item <?php if ($i==0)echo "active";?>">
								<a href="<?php echo get_permalink($id); ?>"><?php echo wp_get_attachment_image($id); ?></a>
							</div>
							<?php }?>
						</div>
						<div class="carousel-button">
							<ol class="carousel-indicators">
								<?php foreach ($ids  as $i => $id){?>
									<li class="<?php if ($i==0) echo "active";?>" data-slide-to="<?php echo $i;?>" data-target="#carousel-<?php echo $post->ID; ?>"></li>
								<?php }?>
							</ol>
						</div>
						<a class="left carousel-control" data-slide="prev" href="#carousel-<?php echo $post->ID; ?>"><i class="icon-angle-left"></i></a>
						<a class="right carousel-control" data-slide="next" href="#carousel-<?php echo $post->ID; ?>"><i class=" icon-angle-right"></i></a>
					</div>
				<?php } if ( has_post_format('video', $post) ){?>
					<div class="widget-thumb second-effect">
						<?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
						<a href="<?php echo post_permalink($post->ID)?>" class="info video-info" title="Full Image">&nbsp;</a>
						<div class="mask"></div>
					</div>
				<?php }elseif (get_the_post_thumbnail( $post->ID )) {?>
					<div class="widget-thumb second-effect">
						<?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
						<a href="<?php echo post_permalink($post->ID)?>" class="info" title="Full Image">Full Image</a>
						<div class="mask">
						</div>
					</div>
				<?php } ?>
				<div class="widget-caption">
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
				<div class="widget-meta">
					<?php $author = get_userdata($post->post_author)?>
					<div class="widget-author"><i class="icon-user"></i><a href="<?php echo get_author_posts_url($post->post_author);?>"><?php echo $author->data->user_login; ?></a></div>
					<div class="widget-comment"><i class="icon-comments"></i><?php echo $post->comment_count; ?></div>
				</div>
				<a class="widget-read-more btn btn-default" href="<?php echo post_permalink($post->ID)?>"><i class="icon-caret-right"></i>Detail</a>
			</div>
		</div>
		<?php }?>
	</div>
</div>
<?php }

?>