<?php
/**
 * Enqueue scripts and stylesheets
 *
 */

function ya_scripts() {
	
	// register styles
	// wp_register_style('bootstrap_css', get_template_directory_uri() . '/assets/css/bootstrap.min.css', false, null);
	// wp_register_style('fonticons_css', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array('bootstrap_css'), null);
	//wp_register_style('bootstrap_gallery_css', get_template_directory_uri() . '/assets/css/bootstrap-image-gallery.css', array(), null);
	
	$scheme = ya_options()->getCpanelValue('scheme');
	if ($scheme){
		$app_css = get_template_directory_uri() . '/assets/css/app-'.$scheme.'.css';
	} else {
		$app_css = get_template_directory_uri() . '/assets/css/app-default.css';
	}
	wp_register_style('ya_photobox_css', get_template_directory_uri() . '/assets/css/photobox.css', array(), null);
	wp_register_style('layout_css', get_template_directory_uri() . '/assets/css/isotope.css', array(), null);
	wp_register_style('yatheme_css', $app_css, array(), null);
    wp_register_style('flexslider_css', get_template_directory_uri() . '/assets/css/flexslider.css', array(), null);
	wp_register_style('lightbox_css', get_template_directory_uri() . '/assets/css/jquery.fancybox.css', array(), null);
	wp_register_style('yatheme_responsive_css', get_template_directory_uri() . '/assets/css/app-responsive.css', array('yatheme_css'), null);

	// register script

	wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr-2.6.2.min.js', false, null, false);
	wp_register_script('bootstrap_js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), null, true);
	wp_register_script('gallery_load_js', get_template_directory_uri() . '/assets/js/load-image.min.js', array('bootstrap_js'), null, true);
	wp_register_script('bootstrap_gallery_js', get_template_directory_uri() . '/assets/js/bootstrap-image-gallery.min.js', array('gallery_load_js'), null, true);
    wp_register_script('flexslider_js', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), null, true);
	wp_register_script('photobox_js', get_template_directory_uri() . '/assets/js/photobox.js', array('jquery'), null, true);
	wp_register_script('plugins_js', get_template_directory_uri() . '/assets/js/plugins.js', array('jquery'), null, true);
	wp_register_script('layout_js', get_template_directory_uri() . '/assets/js/isotope.min.js', array('jquery'), null, false);
	wp_register_script('lightbox_js', get_template_directory_uri() . '/assets/js/jquery.fancybox.pack.js', array('jquery'), null, false);
	wp_register_script('yatheme_js', get_template_directory_uri() . '/assets/js/main.js', array('bootstrap_js', 'plugins_js'), null, true);

	// enqueue script & style
	if ( !is_admin() ){
		wp_enqueue_script('lightbox_js');
		wp_enqueue_style('yatheme_css');
		wp_enqueue_style('lightbox_css');
		wp_enqueue_script('flexslider_js');
        wp_enqueue_style('flexslider_css');
		
		if (ya_options()->getCpanelValue('responsive_support')){
		//	wp_enqueue_style('bootstrap_responsive_css');
			wp_enqueue_style('yatheme_responsive_css');
		}
		
		// is_rtl() && wp_enqueue_style('bootstrap_rtl_css');
		// Load style.css from child theme
		if (is_child_theme()) {
			wp_enqueue_style('yatheme_child_css', get_stylesheet_uri(), false, null);
		}
	}
	
	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	 if( is_tax('product_cat') || is_post_type_archive('product') ){
		 wp_enqueue_script('layout_js');
		 wp_enqueue_style('layout_css');
	 }
	
	$is_category = is_category() && !is_category('blog');
	if ( !is_admin() ){
		wp_enqueue_script('modernizr');
		wp_enqueue_script('yatheme_js');
        wp_enqueue_script('pie_js');
	}

}
add_action('wp_enqueue_scripts', 'ya_scripts', 100);

function ya_google_analytics() { ?>
<script>
	var _gaq=[['_setAccount','<?php echo ya_options()->getCpanelValue('google_analytics_id'); ?>'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
    
</script>
<?php }
if ( ya_options()->getCpanelValue('google_analytics_id') ) {
	add_action('wp_footer', 'ya_google_analytics', 20);
}
