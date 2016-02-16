<?php
$categoryid 	= isset( $instance['category'] )    ? $instance['category'] : 0;
$orderby    	= isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
$order      	= isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
$length     	= isset( $instance['length'] )      ? intval($instance['length']) : 25;
$background     = isset( $instance['background'] ) ? strip_tags($instance['background']) : '';
$animation     = isset( $instance['animation'] )      ? strip_tags($instance['animation']) : '';
?>

<p>
	<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category Name', 'yatheme')?></label>
	<br />
	<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
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
		<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"
		<?php } ?>>
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
	<label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e("Select Animation", 'yatheme')?></label>
	<br/>
	<?php 
		$arr_animation = array(
		'default'=>'default',
		'Zoom'=>'zoom',
		'Fade'=>'fades',
		'Rotate'=>'rotates'
		);  
	  
	?>
	 <select class="widefat"
		id="<?php echo $this->get_field_id('animation'); ?>"
		name="<?php echo $this->get_field_name('animation'); ?>">
		<?php foreach($arr_animation as $eas): ?>
			  <option value="<?php echo $eas;?>" <?php if ( $animation == $eas ){?> selected="selected" <?php } ?>>
				<?php _e($eas , 'yatheme') ?>
			</option>
		<?php endforeach;?>                
	</select>
	<?php print_r( $animation );?>         
</p>
