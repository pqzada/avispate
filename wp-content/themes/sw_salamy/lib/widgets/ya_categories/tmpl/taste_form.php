<?php
$categoriesid = isset( $instance['categories'] )    ? $instance['categories'] : 0;
$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
$count     = isset( $instance['count'] ) ? intval($instance['count']) : 5;
$number_display    = isset( $instance['number_display'] ) ? intval($instance['number_display']) : 3;
$number     = isset( $instance['number'] ) ? intval($instance['number']) : 5;
$length     = isset( $instance['length'] ) ? intval($instance['length']) : 25;

$exclude    = isset( $instance['exclude'] ) ? strip_tags($instance['exclude']) : 0;

?>

<p>
	<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories Name', 'yatheme')?></label>
	<br />
	<?php echo $this->category_select('categories', array('allow_select_all' => true, 'multiple' => true), $categoriesid); ?>
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
		id="<?php echo $this->get_field_id('order'); ?>"
		name="<?php echo $this->get_field_name('order'); ?>">
		<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
		<?php } ?>>
			<?php _e('Descending', 'yatheme')?>
		</option>
		<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"
		<?php } ?>>
			<?php _e('Ascending', 'yatheme')?>
		</option>
	</select>
</p>
<p>
	<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Counts Posts', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('count'); ?>"
		name="<?php echo $this->get_field_name('count'); ?>" type="text"
		value="<?php echo esc_attr($count); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('number_display'); ?>"><?php _e('Number Display', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('number_display'); ?>"
		name="<?php echo $this->get_field_name('number_display'); ?>" type="text"
		value="<?php echo esc_attr($number_display); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Categories', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('number'); ?>"
		name="<?php echo $this->get_field_name('number'); ?>" type="text"
		value="<?php echo esc_attr($number); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Exclude', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('exclude'); ?>"
		name="<?php echo $this->get_field_name('exclude'); ?>" type="text"
		value="<?php echo esc_attr($exclude); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'yatheme')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('length'); ?>"
		name="<?php echo $this->get_field_name('length'); ?>" type="text"
		value="<?php echo esc_attr($length); ?>" />
</p>