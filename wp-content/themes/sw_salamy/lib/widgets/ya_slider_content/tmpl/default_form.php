<?php
$categoryid 	= isset( $instance['category'] )    ? $instance['category'] : 0;
$include     	= isset( $instance['include'] ) ? strip_tags($instance['include']) : 0;
$exclude    	= isset( $instance['exclude'] ) ? strip_tags($instance['exclude']) : 0;
$orderby    	= isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
$order      	= isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
$length     	= isset( $instance['length'] )      ? intval($instance['length']) : 25;
$height     	= isset( $instance['height'] )      ? intval($instance['height']) : 535;
$interval     	= isset( $instance['interval'] )      ? intval($instance['interval']) : 4000;
$hover_stop     = isset( $instance['hover_stop'] )      ? strip_tags($instance['hover_stop']) : 'false';
$auto_play      = isset( $instance['auto_play'] )      ? strip_tags($instance['auto_play']) : 'true';
$full_width     = isset( $instance['full_width'] )      ? strip_tags($instance['full_width']) : 'true';
$background     = isset( $instance['background'] ) ? strip_tags($instance['background']) : '';
$thumbnail      = isset( $instance['thumbnail'] )      ? strip_tags($instance['thumbnail']) : '';
$number_thumb   = isset( $instance['number_thumb'] )      ? intval($instance['number_thumb']) : 4;
?>

<p>
	<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category Name', 'yatheme')?></label>
	<br />
	<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
</p>

<p>
	<label for="<?php echo $this->get_field_id('include'); ?>"><?php _e('Include Posts ID', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('include'); ?>"
		name="<?php echo $this->get_field_name('include'); ?>" type="text"
		value="<?php echo esc_attr($include); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Exclude Posts ID', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('exclude'); ?>"
		name="<?php echo $this->get_field_name('exclude'); ?>" type="text"
		value="<?php echo esc_attr($exclude); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'yatheme')?></label>
	<br />
	<?php $allowed_keys = array('name' => 'Name', 'author' => 'Author', 'date' => 'Date', 'title' => 'Title', 'modified' => 'Modified', 'parent' => 'Parent', 'ID' => 'ID', 'rand' =>'Rand', 'comment_count' => 'Comment Count'); ?>
	<select class="widefat"
		id="<?php echo $this->get_field_id('orderby'); ?>"
		name="<?php echo $this->get_field_name('orderby'); ?>">
		<?php
		$option ='';
		foreach ($allowed_keys as $value => $key) :
			$option .= '<option value="' . $value . '" ';
			if ($value == $orderby){
				$option .= 'selected="selected"';
			}
			$option .=  '>'.$key.'</option>';
		endforeach;
		echo $option;
		?>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'yatheme')?></label>
	<br />
	<select class="widefat"
		id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
		<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
		<?php } ?>>
			<?php _e('Descending', 'yatheme')?>
		</option>
		<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
			<?php _e('Ascending', 'yatheme')?>
		</option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('numberposts'); ?>"name="<?php echo $this->get_field_name('numberposts'); ?>" type="text"
		value="<?php echo esc_attr($number); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
		value="<?php echo esc_attr($length); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('background'); ?>"><?php _e('Background', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('background'); ?>" name="<?php echo $this->get_field_name('background'); ?>" 
		type="text"	value="<?php echo esc_attr($background); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" 
		type="text"	value="<?php echo esc_attr($height); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" type="text"	
		value="<?php echo esc_attr($interval); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('hover_stop'); ?>"><?php _e('Hover stop', 'yatheme')?></label>
	<br />
	<select class="widefat"
		id="<?php echo $this->get_field_id('hover_stop'); ?>" name="<?php echo $this->get_field_name('hover_stop'); ?>">
		<option value="false" <?php if ($hover_stop=='false'){?> selected="selected"
		<?php } ?>>
			<?php _e('False', 'yatheme')?>
		</option>
		<option value="true" <?php if ($hover_stop=='true'){?> selected="selected"	<?php } ?>>
			<?php _e('True', 'yatheme')?>
		</option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('auto_play'); ?>"><?php _e('Auto Play', 'yatheme')?></label>
	<br />
	<select class="widefat"
		id="<?php echo $this->get_field_id('auto_play'); ?>" name="<?php echo $this->get_field_name('auto_play'); ?>">
		<option value="false" <?php if ($auto_play=='false'){?> selected="selected"
		<?php } ?>>
			<?php _e('False', 'yatheme')?>
		</option>
		<option value="true" <?php if ($auto_play=='true'){?> selected="selected"	<?php } ?>>
			<?php _e('True', 'yatheme')?>
		</option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('full_width'); ?>"><?php _e('Full Width', 'yatheme')?></label>
	<br />
	<select class="widefat"
		id="<?php echo $this->get_field_id('full_width'); ?>" name="<?php echo $this->get_field_name('full_width'); ?>">
		<option value="false" <?php if ($full_width=='false'){?> selected="selected"
		<?php } ?>>
			<?php _e('False', 'yatheme')?>
		</option>
		<option value="true" <?php if ($full_width=='true'){?> selected="selected"	<?php } ?>>
			<?php _e('True', 'yatheme')?>
		</option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e("Show Thumbnail", 'yatheme')?></label>
	<br/>
	 <select class="widefat"
		id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>">
			 <option value="1" <?php if ( $thumbnail == 1 ){?> selected="selected" <?php } ?>>
				<?php _e("Yes" , 'yatheme') ?>
			</option>
			<option value="0" <?php if ( $thumbnail == 0 ){?> selected="selected" <?php } ?>>
				<?php _e("No" , 'yatheme') ?>
			</option>    
	</select>    
</p>

<p>
	<label for="<?php echo $this->get_field_id('number_thumb'); ?>"><?php _e('Number thumbnail', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('number_thumb'); ?>" name="<?php echo $this->get_field_name('number_thumb'); ?>" type="text"	
		value="<?php echo esc_attr($number_thumb); ?>" />
</p>
