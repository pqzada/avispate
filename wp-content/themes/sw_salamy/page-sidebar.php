<?php
/*
Template Name: Page width Sidebar
*/
?>
<div class="main">
	<?php 
	if (!is_front_page() ) {
		if ( function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs">', '</div>');
		}
	}
	get_template_part('templates/content', 'page')
	?>	
</div>