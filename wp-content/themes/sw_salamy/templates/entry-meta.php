<div class="meta-inner">
	<?php $category = get_the_category();?>
	<ul>
		<li class="single-publish"><?php echo date( 'd F Y',strtotime($post->post_date)); ?></li> 
		<li class="single-author"><?php _e('Author', 'yatheme'); ?>: <?php the_author_posts_link(); ?></li>
	</ul>
</div>
