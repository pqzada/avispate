<div class="ya-index main">
	<?php 
	if (is_active_sidebar_YA('above')) {
		dynamic_sidebar('above');
	}
	get_template_part('templates/content');
	?>
</div>