<?php
	if(preg_match_all('/\[gallery(.*?)?\]/', get_post($instance['post_id'])->post_content, $matches)){
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
			if (!wp_style_is('ya_photobox_css')){
				wp_enqueue_style('ya_photobox_css');
			}
			
			if (!wp_enqueue_script('photobox_js')){
				wp_enqueue_script('photobox_js');
			}
			
			static $key = 0;
			$key++;
?>
				
			<div id="widget-photobox-gallery-<?php echo $key; ?>" class="carousel widget-photobox-gallery slide">
				
				<!-- Carousel items -->
				<div class="carousel-inner">
					<?php 
						$ids = explode(',', $ids);
						
						foreach ( $ids as $i => $id ){
							if($i%12==0){?>
							<div class="item <?php if($i==0){ echo " active";}?> "> 
							<?php }?>
								<a href="<?php echo wp_get_attachment_url($id); ?>">
									<?php echo wp_get_attachment_image($id); ?>
								</a>
							<?php if(($i+1)%12==0 || $i+1 == count($ids)){ echo '</div>'; }?>  
					<?php }?>
				</div><!-- .carousel-inner -->
				<div class="carousel-button">
					<ol class="carousel-indicators">
						<?php for ($i=0; $i*12 < count($ids); $i++){?>
							<li class="<?php if ($i==0) echo "active";?>" data-slide-to="<?php echo $i;?>" data-target="#widget-photobox-gallery-<?php echo $key; ?>"></li>
						<?php }?>
					</ol>
				</div>
			</div>
	<?php 
			add_action('wp_footer', array($this, 'add_script_gallery'), 50);
		} 
	}
	?>