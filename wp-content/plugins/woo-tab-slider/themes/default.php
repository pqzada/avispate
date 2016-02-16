<?php 
	if (!isset($instance['category'])){
		$instance['category'] = array();
	}
	
	extract($instance);
	$tag_id = 'sj_woo_tab_'.rand().time();
?>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($){
		;(function(element){
			var $element = $(element);
			var $loading = $('.spt-loadding',$element);
				$loading.remove();
				$element.removeClass('pre-load');
		})('#<?php echo $tag_id; ?>')
	});
//]]>	
</script>
<!--[if lt IE 9]><div class="sj-simpletabs pre-load  msie lt-ie9" id="<?php echo $tag_id; ?>" ><![endif]--> 
<!--[if IE 9]><div class="sj-simpletabs pre-load msie" id="<?php echo $tag_id; ?>" ><![endif]-->
<!--[if gt IE 9]><!--><div class="sj-woo-tab pre-load " id="<?php echo $tag_id; ?>" ><!--<![endif]-->
	<div class="spt-wrap" style="position:relative;">
		<ul class="nav nav-tabs">
		<?php
			foreach($category as $key => $cat){
				$terms = get_term_by('id', $cat, 'product_cat');				
		?>
			<li class="<?php if($key == 0){echo 'active'; }?>">
				<a href="#<?php echo 'category_'.$cat; ?>" data-toggle="tab">
					<?php echo $terms->name; ?>
				</a>
			</li>			
		<?php } ?>
		</ul>
		<div class="tab-content">
			<?php
				foreach($category as $key => $cat){
				$default = array(
					'post_type' => 'product',
					'tax_query'	=> array(
					array(
						'taxonomy'	=> 'product_cat',
						'field'		=> 'id',
						'terms'		=> $cat)),
					'orderby' => $orderby,
					'order' => $order,
					'post_status' => 'publish',
					'showposts' => $numberposts
				);
				$list = new WP_Query( $default );
				do_action( 'before' ); 
			?>
			<div class="tab-pane<?php if($key == 0){echo ' active'; }?>" id="<?php echo 'category_'.$cat; ?>">
				<div id="<?php echo 'category_id_'.$cat; ?>" class="woo-tab-container-slider">
					<div class="page-button">
						<ul class="control-button preload">
							<li class="preview">Prev</li>
							<li class="next">Next</li>
						</ul>		
					</div>
					<?php 
					$count_items = 0;
					if($numberposts >= $list->found_posts){$count_items = $list->found_posts; }else{$count_items = $numberposts;}
					//var_dump($list);
					if($columns > $count_items){
						$columns = $count_items;
					}
					
					if($columns1 > $count_items){
						$columns1 = $count_items;
					}
					
					if($columns2 > $count_items){
						$columns2 = $count_items;
					}
					
					if($columns3 > $count_items){
						$columns3 = $count_items;
					}
					
					if($columns4 > $count_items){
						$columns4 = $count_items;
					}
					
					$deviceclass_sfx = 'preset01-'.$columns.' '.'preset02-'.$columns1.' '.'preset03-'.$columns2.' '.'preset04-'.$columns3.' '.'preset05-'.$columns4;
					
					?>
					<div class="slider not-js cols-6 <?php echo $deviceclass_sfx; ?>" id="<?php echo 'slider_'.$cat; ?>">
						<div class="vpo-wrap">
							<div class="vp">
								<div class="vpi-wrap">
								<?php 
									$i = 0;
									while($list->have_posts()): $list->the_post();
									global $product, $post, $wpdb, $average;
									if( $i % 2 == 0 ){
								?>
									<div class="item">
								<?php } ?>
										<div class="item-wrap">							
											<?php if(has_post_thumbnail()){ ?>
												<div class="item-img item-height">
													<div class="item-img-info products-thumb">
														<a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>">
															<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
														</a>
														<?php 
														$nonce = wp_create_nonce("sw_quickviewproduct_nonce");
														$link = admin_url('admin-ajax.php?ajax=true&amp;action=sw_quickviewproduct&amp;post_id='.$product->id.'&amp;nonce='.$nonce);
														$linkcontent ='<a href="'. $link .'" data-fancybox-type="ajax" class="fancybox fancybox.ajax">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View', 'yatheme' ) ).'</a>';
														echo $linkcontent;
														?>
													</div>
												</div>
											<?php } ?>
											<div class="item-content">
												<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
												<div class="item-desc">
													<?php 
														$content = $post->post_excerpt;
														echo $this->ya_trim_words($content, $length, '...');
													?>
												</div>
												<div class="item-bottom clearfix">
													<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
														sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
															esc_url( $product->add_to_cart_url() ),
															esc_attr( $product->id ),
															esc_attr( $product->get_sku() ),
															$product->is_purchasable() ? 'add_to_cart_button' : '',
															esc_attr( $product->product_type ),
															esc_html( $product->add_to_cart_text() )
														),
													$product );
													$count = $wpdb->get_var("
														SELECT COUNT(meta_value) FROM $wpdb->commentmeta
														LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
														WHERE meta_key = 'rating'
														AND comment_post_ID = $post->ID
														AND comment_approved = '1'
														AND meta_value > 0
													");

													$rating = $wpdb->get_var("
														SELECT SUM(meta_value) FROM $wpdb->commentmeta
														LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
														WHERE meta_key = 'rating'
														AND comment_post_ID = $post->ID
														AND comment_approved = '1'
													");
													?>
													<div class="reviews-content">
														<?php
															if( $count > 0 ){
																$average = number_format($rating / $count, 1);
														?>
															<div class="star"><span style="width: <?php echo ($average*13).'px'; ?>"></span></div>
															
														<?php } else { ?>
														
															<div class="star"></div>
															
														<?php } ?>
															<div class="item-number-rating">
																<?php echo $count; _e(' review(s)', 'yatheme');?>
															</div>
													</div>
												</div>
											</div>											
										</div>
										<?php if( ( $i+1 )%2== 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
								<?php $i++; endwhile; wp_reset_query();?>
								</div>
							</div>
						</div>
					</div>			
				</div>
			</div>
			<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function($){
					;(function(element){
						var $element = $(element);
						var $slider = $('#<?php echo 'slider_'.$cat; ?>', $element)
						jQuery('#<?php echo 'slider_'.$cat; ?>', $element).responsiver({
							interval: <?php echo $interval; ?>,
							speed: <?php echo $speed; ?>,
							start: <?php echo $start -1;?>,	
							step: <?php echo $scroll; ?>,
							circular: true,
							preload: true,
							fx: '<?php echo $effect; ?>',
							pause: '<?php echo $hover; ?>',
							control:{
								prev: '#<?php echo 'category_id_'.$cat; ?> .control-button li[class="preview"]',
								next: '#<?php echo 'category_id_'.$cat; ?> .control-button li[class="next"]'
							},
							getColumns: function(element){
								var match = $(element).attr('class').match(/cols-(\d+)/);
								if (match[1]){
									var column = parseInt(match[1]);
								} else {
									var column = 1;
								}
								if (!column) column = 1;
								return column;
							}          
						});
								<?php if($swipe == 'yes') {	?>
									$slider.touchSwipeLeft(function(){
										$slider.responsiver('next');
										}
									);
									$slider.touchSwipeRight(function(){
										$slider.responsiver('prev');
										}
									);
								<?php } ?>
						$('.control-button',$element).removeClass('preload');
					})('#<?php echo 'category_id_'.$cat; ?>');
				});
			//]]>
			</script>
			<?php
			} 
			?>
		</div>
	</div>
</div>