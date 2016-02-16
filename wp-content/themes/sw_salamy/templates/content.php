<?php //!is_front_page() && get_template_part('templates/page', 'header'); ?>
<h1><?php echo ya_title(); ?></h1>
<?php if (!have_posts()) : ?>
<?php get_template_part('templates/no-results'); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
<?php 
	global $post;
	$count = get_post_meta($post->ID, 'count_page_hits', true);
 ?>

	<div id="post-<?php the_ID();?>" <?php post_class(); ?>>
		<div class="entry">
			<?php if (get_the_post_thumbnail()){?>
			<div class="entry-thumb">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("medium")?></a>
				<div class="entry-thumb-meta">
					<div class="entry-comment">
						<?php echo ($post->comment_count >1 )? $post->comment_count.' Comments' : $post->comment_count.' Comment'  ?>
					</div>
					<div class="entry-post-view">
						<?php echo ( $count > 1 )? $count.' Views' : $count.' View';?>
					</div>
				</div>
			</div>
			<?php }?>
			<div class="entry-content">
				<div class="entry-title">
					<h3>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
					</h3>
				</div>
				<div class="entry-meta">
				<?php get_template_part('templates/entry-meta'); ?>
				</div>
				<div class="entry-summary">
					<?php echo excerpt(50); ?>
				</div>
				<p><?php _e('Categories', 'yatheme'); ?>: <?php the_category(' '); ?></p>
			</div>
		</div>
	</div>
<?php endwhile; ?>

<?php get_template_part('templates/pagination'); ?>
