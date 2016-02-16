<?php
$latest_posts    		= isset( $instance['latest_posts'] ) ? intval($instance['latest_posts']) : 5;
$popular_posts    		= isset( $instance['popular_posts'] ) ? intval($instance['popular_posts']) : 5;
$length    		= isset( $instance['length'] ) ? intval($instance['length']) : 20;
?>


<p>Number of popular posts to show:<br><input  style="width: 200px;" type="text" value="<?php echo $popular_posts?>" name="<?php echo $this->get_field_name('latest_posts'); ?>" id="latest_posts" /></p>
<p>Number of recent posts to show:<br><input  style="width: 200px;" type="text" value="<?php echo $latest_posts?>" name="<?php echo $this->get_field_name('popular_posts'); ?>" id="popular_posts" /></p>

<p>Lenght excerpt posts to show:<br><input  style="width: 200px;" type="text" value="<?php echo $length?>" name="<?php echo $this->get_field_name('length'); ?>" id="length" /></p>
