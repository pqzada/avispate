<?php 
	$instance	=	wp_parse_args( (array) $instance, array(
		'post_id'	=>	0,
	) );
	$gallery_posts = get_posts( array(
		'numberposts'	=>	-1,
		'tax_query'		=>	array(
			array(
				'taxonomy'	=>	'post_format',
				'field'		=>	'slug',
				'terms'		=>	array( 'post-format-gallery' )
			)
		)
	) );
	
	if ( empty( $gallery_posts ) ) {
		echo '<p class="description">'. sprintf( __( 'No galleries have been created yet. <a href="%s">Create some</a>.', 'yatheme' ), admin_url( 'post-new.php' ) ) . '</p>';
		return;
	}
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php _e( 'Select Gallery:', 'yatheme' ); ?></label>
		<select name="<?php echo $this->get_field_name( 'post_id' ); ?>" id="<?php echo $this->get_field_id( 'post_id' ); ?>" class="widefat">
			<?php foreach ( $gallery_posts as $gallery_post ) {
				echo '<option value="' . $gallery_post->ID . '"' . selected( $instance['post_id'], $gallery_post->ID ) .'>' . $gallery_post->post_title . '</option>';
			} ?>
		</select>
	</p>