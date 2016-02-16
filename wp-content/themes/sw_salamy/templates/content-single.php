<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
	<?php $pfm = get_post_format();?>
    <header>
      <h2 class="entry-title"><?php the_title(); ?></h2>
      <div class="meta">
      	<div class="meta-inner">
			<?php $category = get_the_category();?>
			<ul>
				<li class="single-author"><?php _e('Author', 'yatheme'); ?>: <?php the_author_posts_link(); ?></li>
				<li class="single-publish"><?php _e('Published', 'yatheme'); ?>: <?php echo date( 'd F Y',strtotime($post->post_date)); ?></li> 
				<li class="single-category"><?php _e('Category', 'yatheme'); ?>: <?php foreach($category as $cat){ echo '<a href="'.get_category_link( $cat->term_id ).'">'.$cat->name.'</a>'; }?></li>
			</ul>
		</div>
      </div>
    </header>
    <div class="entry-content">
	<?php if( $pfm == '' || $pfm == 'image' ){?>
	  <?php if( has_post_thumbnail() ){ ?>
	  <div class="single-thumb">
		<?php the_post_thumbnail(); ?>
	  </div>
	  <?php } }?>
      <?php the_content(); ?>
	  <!-- Tag -->
	  <?php if(get_the_tag_list()) { ?>
	  <div class="single-tag">
			<?php echo get_the_tag_list('<span>Tags: </span>',', ','');  ?>
	  </div>
	  <?php } ?>
	  <!-- Social -->
	  <?php get_social(); ?>
	  <!-- Relate Post -->
	  <?php 
			global $post;
			global $related_term;
			$categories = get_the_category($post->ID);								
			$category_ids = array();
			foreach($categories as $individual_category) {$category_ids[] = $individual_category->term_id;}
			if ($categories) {
			$related = array(
				'category__in' => $category_ids,
				'post__not_in' => array($post->ID),
				'showposts'=>3,
				'orderby'	=> 'rand',	
				'ignore_sticky_posts'=>1
			   );
		?>
	  <div class="single-post-relate">
		<h3><?php _e('Related Posts:'); ?></h3>
		<div class="row">
		<?php
			$related_term = new WP_Query($related);
			while($related_term -> have_posts()):$related_term -> the_post();
		?>
			<div class="col-lg-4 col-md-4 col-sm-4">
				<div class="item-relate-img">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
				</div>
				<div class="item-relate-content">
					<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<p>
						<?php
							$text = strip_shortcodes( $post->post_content );
							$text = apply_filters('the_content', $text);
							$text = str_replace(']]>', ']]&gt;', $text);
							$content = wp_trim_words($text, 10,'...');
							echo $content;
						?>
					</p>
				</div>
			</div>
		<?php
			endwhile;
			wp_reset_query();
		?>
		</div>
	  </div>
	  <?php } ?>
      <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'yatheme' ), 'after' => '</div>' ) ); ?>
    </div>
	<nav>
    	<ul class="pager">
      		<li class="previous"><?php previous_post_link( '%link', __( '<span class="icon-circle-arrow-left"></span> %title', 'yatheme' ), true );?></li>
      		<li class="next"><?php next_post_link( '%link', __( '%title <span class="icon-circle-arrow-right "></span>', 'yatheme' ), true ); ?></li>
    	</ul>
  	</nav>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
