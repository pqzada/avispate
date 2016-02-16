<?php
/**
 * Theme wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */

function ya_template_path() {
	return YA_Wrapping::$main_template;
}

function ya_sidebar_path() {
	return YA_Wrapping::sidebar();
}

add_filter('template_include', array('YA_Wrapping', 'wrap'), 99);


/* Style Background */
function style_bg(){ 
	
	$img =  ya_options()->getCpanelValue('bg_img');
	$color = ya_options()->getCpanelValue('bg_color');
	$repeat = ya_options()->getCpanelValue('bg_repeat');
	
	$img = isset($img) ? $img : '';
	$color = isset($color) ? $color : '';
	$repeat = isset($repeat) ? 'repeat' : 'no-repeat';
	
	if ( !empty($img) && strpos($img, 'bg-demo') === false ) {
		
	} elseif ( !empty($img) && strpos($img, 'bg-demo') == 0 ) {
		$img = get_template_directory_uri() . '/assets/img/' . $img . '.png';
	}
	
	if (strpos($color, '#') != 0) {
		$color = '#' . $color;
	} 
	?>

	<style>
		body{
			background-image: url('<?php echo $img; ?>');
			background-color: <?php echo $color; ?>;
			background-repeat: <?php echo $repeat; ?>;
		}
	</style>
	
	<?php 
	
	return '';
}
add_filter('wp_head', 'style_bg');


/**
 * Page titles
 */
function ya_title() {
	if (is_home()) {
		if (get_option('page_for_posts', true)) {
			echo get_the_title(get_option('page_for_posts', true));
		} else {
			_e('Latest Posts', 'yatheme');
		}
	} elseif (is_archive()) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if ($term) {
			echo $term->name;
		} elseif (is_post_type_archive()) {
			echo get_queried_object()->labels->name;
		} elseif (is_day()) {
			printf(__('Daily Archives: %s', 'yatheme'), get_the_date());
		} elseif (is_month()) {
			printf(__('Monthly Archives: %s', 'yatheme'), get_the_date('F Y'));
		} elseif (is_year()) {
			printf(__('Yearly Archives: %s', 'yatheme'), get_the_date('Y'));
		} elseif (is_author()) {
			printf(__('Author Archives: %s', 'yatheme'), get_the_author());
		} else {
			single_cat_title();
		}
	} elseif (is_search()) {
		printf(__('Search Results for <small>%s</small>', 'yatheme'), get_search_query());
	} elseif (is_404()) {
		_e('Not Found', 'yatheme');
	} else {
		the_title();
	}
}

/**
 * Show an admin notice if .htaccess isn't writable
 */
function ya_htaccess_writable() {
	if (!is_writable(get_home_path() . '.htaccess')) {
		if (current_user_can('administrator')) {
			add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>" . sprintf(__('Please make sure your <a href="%s">.htaccess</a> file is writable ', 'yatheme'), admin_url('options-permalink.php')) . "</p></div>';"));
		}
	}
}
add_action('admin_init', 'ya_htaccess_writable');

/**
 * Return WordPress subdirectory if applicable
 */
function wp_base_dir() {
	preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);
	if (count($matches) === 3) {
		return end($matches);
	} else {
		return '';
	}
}

/**
 * Opposite of built in WP functions for trailing slashes
 */
function leadingslashit($string) {
	return '/' . unleadingslashit($string);
}

function unleadingslashit($string) {
	return ltrim($string, '/');
}

function add_filters($tags, $function) {
	foreach($tags as $tag) {
		add_filter($tag, $function);
	}
}

function is_element_empty($element) {
	$element = trim($element);
	return empty($element) ? false : true;
}

function is_customize(){
	return isset($_POST['customized']) && ( isset($_POST['customize_messenger_chanel']) || isset($_POST['wp_customize']) );
}

function is_ajax_sw(){
	return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


/**
 * Check widget display
 * */
function check_wdisplay ($widget_display){
	
	$YA_Menu_Checkbox = new YA_Menu_Checkbox;
	if ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'all' ) {
		return true;
	}else{
	if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
		if(  isset($widget_display['display_language']) && strcmp($widget_display['display_language'], ICL_LANGUAGE_CODE) != 0  ){
			return false;
		}
	}
	if ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'if_selected' ) {
		
		if (isset($widget_display['checkbox'])) {
			
			if (isset($widget_display['checkbox']['users'])) {
				global $user_ID;
				
				foreach ($widget_display['checkbox']['users'] as $key => $value) {
					
					if ( ($key == 'login' && $user_ID) || ($key == 'logout' && !$user_ID) ){
						
						if (isset($widget_display['checkbox']['general'])) {
							foreach ($widget_display['checkbox']['general'] as $key => $value) {
								$is = 'is_'.$key;
								if ( $is() === true ) return true;
							}
						}
						
						if (isset($widget_display['taxonomy-slugs'])) {
							
							$taxonomy_slugs = preg_split('/[\s,]/', $widget_display['taxonomy-slugs']);
							foreach ($taxonomy_slugs as $slug) {is_post_type_archive('product_cat');
								if (!empty($slug) && is_tax($slug) === true) {
									return true;
								}
							}
						
						}
						
						if (isset($widget_display['post-type'])) {
							$post_type = preg_split('/[\s,]/', $widget_display['post-type']);
							
							foreach ($post_type as $type) {
								if(is_archive()){
									if (!empty($type) && is_post_type_archive($type) === true) {
										return true;
									}
								}
								
								if($type!=PRODUCT_TYPE)
								{
									if(!empty($type) && $type==PRODUCT_DETAIL_TYPE && is_single() && get_post_type() != 'post'){
										return true;
									}else if (!empty($type) && is_singular($type) === true) {
										return true;
									}
									
								}	
							}
						}
						
						if (isset($widget_display['catid'])) {
							$catid = preg_split('/[\s,]/', $widget_display['catid']);
							foreach ($catid as $id) {
								if (!empty($id) && is_category($id) === true) {
									return true;
								}
							}
								
						}
						
						if (isset($widget_display['postid'])) {
							$postid = preg_split('/[\s,]/', $widget_display['postid']);
							foreach ($postid as $id) {
								if (!empty($id) && (is_page($id) === true || is_single($id) === true) ) {
									return true;
								}
							}
						
						}
						
						if (isset($widget_display['checkbox']['menus'])) {
							
							foreach ($widget_display['checkbox']['menus'] as $menu_id => $item_ids) {
								
								if ( $YA_Menu_Checkbox->is_menu_item_active($menu_id, $item_ids) ) return true;
							}
						}
					}
				}
			}
			
			return false;
			
		} else return false ;
		
	} elseif ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'if_no_selected' ) {
		
		if (isset($widget_display['checkbox'])) {
			
			if (isset($widget_display['checkbox']['users'])) {
				global $user_ID;
				
				foreach ($widget_display['checkbox']['users'] as $key => $value) {
					if ( ($key == 'login' && $user_ID) || ($key == 'logout' && !$user_ID) ) return false;
				}
			}
			
			if (isset($widget_display['checkbox']['general'])) {
				foreach ($widget_display['checkbox']['general'] as $key => $value) {
					$is = 'is_'.$key;
					if ( $is() === true ) return false;
				}
			}

			if (isset($widget_display['taxonomy-slugs'])) {
				$taxonomy_slugs = preg_split('/[\s,]/', $widget_display['taxonomy-slugs']);
				foreach ($taxonomy_slugs as $slug) {
					if (!empty($slug) && is_tax($slug) === true) {
						return false;
					}
				}
			
			}
			
			if (isset($widget_display['post-type'])) {
				$post_type = preg_split('/[\s,]/', $widget_display['post-type']);
				
				foreach ($post_type as $type) {
					if(is_archive()){
						if (!empty($type) && is_post_type_archive($type) === true) {
							return true;
						}
					}
					
					if($type!=PRODUCT_TYPE)
					{
						if(!empty($type) && $type==PRODUCT_DETAIL_TYPE && is_single() && get_post_type() != 'post'){
							return true;
						}else if (!empty($type) && is_singular($type) === true) {
							return true;
						}
						
					}	
				}
			}
			
			
			
			if (isset($widget_display['catid'])) {
				$catid = preg_split('/[\s,]/', $widget_display['catid']);
				foreach ($catid as $id) {
					if (!empty($id) && is_category($id) === true) {
						return false;
					}
				}
					
			}
			
			if (isset($widget_display['postid'])) {
				$postid = preg_split('/[\s,]/', $widget_display['postid']);
				foreach ($postid as $id) {
					if (!empty($id) && (is_page($id) === true || is_single($id) === true)) {
						return false;
					}
				}
			
			}
			
			if (isset($widget_display['checkbox']['menus'])) {
							
				foreach ($widget_display['checkbox']['menus'] as $menu_id => $item_ids) {
					
					if ( $YA_Menu_Checkbox->is_menu_item_active($menu_id, $item_ids) ) return false;
				}
			}			
		} else return false ;
	}
	}
	return true ;
}



function check_wdisplayxxx ($widget_display){
		
	if ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'if_selected' ) {
		
		if (isset($widget_display['checkbox'])) {
			
			if (isset($widget_display['checkbox']['users'])) {
				global $user_ID;
				
				foreach ($widget_display['checkbox']['users'] as $key => $value) {
					if ( ($key == 'login' && $user_ID) || ($key == 'logout' && !$user_ID) ){
					
						if (isset($widget_display['checkbox']['general'])) {
							foreach ($widget_display['checkbox']['general'] as $key => $value) {
								$is = 'is_'.$key;
								if ( $is() === true ) return true;
							}
						}
						
						if (isset($widget_display['checkbox']['cats'])) {
							foreach ($widget_display['checkbox']['cats'] as $catid => $cat_name) {
								if ( is_category($catid) === true ) return true;
							}
						}
						
						if (isset($widget_display['checkbox']['pages'])) {
							foreach ($widget_display['checkbox']['pages'] as $pageid => $page_name) {
								if ( is_page($pageid) === true ) return true;
							}
						}
					}
				}
			}
			
			return false;
			
		} else return false ;
		
	} elseif ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'if_no_selected' ) {
		
		if (isset($widget_display['checkbox'])) {
			
			if (isset($widget_display['checkbox']['users'])) {
				global $user_ID;
				
				foreach ($widget_display['checkbox']['users'] as $key => $value) {
					if ($key == 'login' && $user_ID) return false;
					if ($key == 'logout' && !$user_ID) return false;
				}
			}
			
			if (isset($widget_display['checkbox']['general'])) {
				foreach ($widget_display['checkbox']['general'] as $key => $value) {
					$is = 'is_'.$key;
					if ( $is() === true ) return false;
				}
			}
			
			if (isset($widget_display['checkbox']['cats'])) {
				foreach ($widget_display['checkbox']['cats'] as $catid => $cat_name) {
					if ( is_category($catid) === true ) return false;
				}
			}
			
			if (isset($widget_display['checkbox']['pages'])) {
				foreach ($widget_display['checkbox']['pages'] as $pageid => $page_name) {
					if ( is_page($pageid) === true ) return false;
				}
			}
		}
	} else return true;
	
	return true ;
}


/**
 *  Is active sidebar
 * */
function is_active_sidebar_YA($index) {
	global $wp_registered_widgets;
	
	$index = ( is_int($index) ) ? "sidebar-$index" : sanitize_title($index);
	$sidebars_widgets = wp_get_sidebars_widgets();
	if (!empty($sidebars_widgets[$index])) {
		foreach ($sidebars_widgets[$index] as $i => $id) {
			$id_base = preg_replace( '/-[0-9]+$/', '', $id );
			
			if ( isset($wp_registered_widgets[$id]) ) {
				$widget = new WP_Widget($id_base, $wp_registered_widgets[$id]['name']);

				if ( preg_match( '/' . $id_base . '-([0-9]+)$/', $id, $matches ) )
					$number = $matches[1];
					
				$instances = get_option($widget->option_name);
				
				if ( isset($instances) && isset($number) ) {
					$instance = $instances[$number];
					
					if ( isset($instance['widget_display']) && check_wdisplay($instance['widget_display']) == false ) {
						unset($sidebars_widgets[$index][$i]);
					}
				}
			}
		}
		
		if ( empty($sidebars_widgets[$index]) ) return false;
		
	} else return false;
	
	return true;
}	
	
/**
 * Get Social share
 * */
    function get_social() {
	global $post;
	
	$social['social-share'] = ya_options()->getCpanelValue('social-share');
	$social['social-share-fb'] = ya_options()->getCpanelValue('social-share-fb');
	$social['social-share-tw'] = ya_options()->getCpanelValue('social-share-tw');
	$social['social-share-in'] = ya_options()->getCpanelValue('social-share-in');
	$social['social-share-go'] = ya_options()->getCpanelValue('social-share-go');
	//$social['social-share-pi'] = ya_options()->getCpanelValue('social-share-pi');
	
	if (!$social['social-share']) return false;
	
	//$options = $this->get_wp_social_share_options();
	$permalinked = urlencode(get_permalink($post->ID));
	$spermalink = get_permalink($post->ID);
	$title = urlencode($post->post_title);
	$stitle = $post->post_title;
	
	$data = '<div class="social-share">';
	$data .= '<style type="text/css">
				.social-share{
					display: table;
				    margin: 5px;
				    width: 100%;
				}
				.social-share-item{
					float: left;
				}
				.social-share-fb{
					margin-right: 25px;
                }
			</style>';
	
	if ($social['social-share-fb']) {
		$data .='<div class="social-share-fb social-share-item" >';
		$data .= '<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, \'script\', \'facebook-jssdk\'));</script>';
		$data .= '<div class="fb-like" data-href="'.$spermalink.'" data-send="true" data-layout="button_count" data-width="200" data-show-faces="false"></div>';
		$data .= '</div> <!--Facebook Button-->';
	}
		
	if ($social['social-share-tw']) {
		$data .='<div class="social-share-twitter social-share-item" >
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="'. $spermalink .'" data-text="'.$stitle.'" data-count="horizontal">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
				</div> <!--Twitter Button-->';
	}
	
	if ($social['social-share-go']) {
		$data .= '<div class="social-share-google-plus social-share-item">
					<!-- Place this tag where you want the +1 button to render -->
					<div class="g-plusone" data-size="medium" data-href="'. $permalinked .'"></div>
		
					<!-- Place this render call where appropriate -->
					<script type="text/javascript">
					  (function() {
						var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
						po.src = "https://apis.google.com/js/plusone.js";
						var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
				</div> <!--google plus Button-->';
	}
	
	if ($social['social-share-in']) {
		$data .= '<div class="social-share-linkedin social-share-item">
					<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
					<script type="IN/Share" data-url="'. $permalinked .'" data-counter="right"></script>
				</div> <!--linkedin Button-->';
	}

//	if ($social['social-share-pi']) {
//		$data .= '<div class="social-share-pinterest social-share-item">
//					<a href="//pinterest.com/pin/create/button/?url='.$permalinked.'" data-pin-do="buttonPin" data-pin-config="beside"><img src="#" alt="test"></a>
//					<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
//				</div> <!--pinterest Button-->';
//	}
	$data .= '</div>';
	echo $data;

}


/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://twitter.github.com/bootstrap/components.html#media
 */

function ya_get_avatar($avatar) {
	$avatar = str_replace("class='avatar", "class='avatar pull-left media-object", $avatar);
	return $avatar;
}
add_filter('get_avatar', 'ya_get_avatar');

function ya_custom_direction(){
	global $wp_locale;
	$opt_direction = ya_options()->getCpanelValue('text_direction');
	$opt_direction = strtolower($opt_direction);
	if ( in_array($opt_direction, array('ltr', 'rtl')) ){
		$wp_locale->text_direction = $opt_direction;
	} else {
		// default by $wp_locale->text_direction;
	}
}
add_filter( 'wp', 'ya_custom_direction' );

function ya_navbar_class(){
	$classes = array( 'navbar' );

	if ( 'static' != ya_options()->getCpanelValue('navbar_position') )
		$classes[]	=	ya_options()->getCpanelValue('navbar_position');

	if ( ya_options()->getCpanelValue('navbar_inverse') )
		$classes[]	=	'navbar-inverse';

	apply_filters( 'ya_navbar_classes', $classes );

	echo 'class="' . join( ' ', $classes ) . '"';
}

function ya_content_class(){
	$classes = array( 'content' );
	
	$all_sidebars = array_merge(ya_sidebar_left(), ya_sidebar_right());
	
	$all_sidebars = array_unique($all_sidebars);
	
	$span	 = 12;
	$span_md = 12;
	$span_sm = 12;
	foreach ($all_sidebars as $sb){
		if ( !is_active_sidebar_YA($sb) ){
			continue;
		}
		$sb_expand_field	 = 'sidebar_'.$sb.'_expand';
		$sb_expand_field_md	 = 'sidebar_'.$sb.'_expand_md';
		$sb_expand_field_sm	 = 'sidebar_'.$sb.'_expand_sm';
		$sb_expand_value	 = ya_options()->getCpanelValue($sb_expand_field);
		$sb_expand_value_md	 = ya_options()->getCpanelValue($sb_expand_field_md);
		$sb_expand_value_sm	 = ya_options()->getCpanelValue($sb_expand_field_sm);
		$span -= (int)$sb_expand_value;
		$span_md -= (int)$sb_expand_value_md;
		$span_sm -= (int)$sb_expand_value_sm;
	}
	if ( $span <= 0 || $span_md <= 0 || $span_sm <= 0 ){
		$classes[] = 'col-lg-12 col-md-12 col-sm-12';
	} else {
		$classes[] = 'col-lg-'.$span.' col-md-'.$span_md.' col-sm-'.$span_sm;
	}
	
	echo 'class="' . join( ' ', $classes ) . '"';
}

/**
 * Count Page Hits in WordPress
 * */
function count_page_hits() {
   if(is_singular()) {
      global $post;
      $count = get_post_meta($post->ID, 'count_page_hits', true);
      $newcount = $count + 1;

      update_post_meta($post->ID, 'count_page_hits', $newcount);
   }
}
add_action('wp_head', 'count_page_hits');


function ya_sidebar_left(){
	$layout = ya_options()->getCpanelValue('theme_layout');
	$side_left = array();
	
	if ( preg_match('/sm/', $layout) ){
		$side_left[] = 'primary';
	} else if ( preg_match('/[l|r]+.?m/', $layout) ){
		for ( $i = 0; $i < strlen($layout); $i++ ){
			if ($layout[$i]=='m') break;
			if ($layout[$i]=='l') $side_left[] = 'left';
			if ($layout[$i]=='r') $side_left[] = 'right';
		}
	}
	return apply_filters('ya_sidebar_left', $side_left);
}

function ya_sidebar_right(){
	$layout = ya_options()->getCpanelValue('theme_layout');
	$side_right = array();

	if ( preg_match('/ms/', $layout) ){
		$side_right[] = 'primary';
	} else if ( preg_match('/m.?[l|r]+/', $layout) ){
		$push = 0;
		for ( $i = 0; $i < strlen($layout); $i++ ){
			if ($layout[$i]=='m') {
				$push = 1;
				continue;
			} else {
				if ( $push ){
					if ($layout[$i]=='l') $side_right[] = 'left';
					if ($layout[$i]=='r') $side_right[] = 'right';
				}
			}
		}
	}
	return apply_filters('ya_sidebar_right', $side_right);
}


function ya_typography_css(){
	$styles = '';
	if ( ya_options()->getCpanelValue('google_webfonts') ):
		
		$webfonts_assign = ya_options()->getCpanelValue('webfonts_assign');
		$styles = '<style>';
		if ( $webfonts_assign == 'headers' ){
			$styles .= 'h1, h2, h3, h4, h5, h6 {';
		} else if ( $webfonts_assign == 'custom' ){
			$custom_assign = ya_options()->getCpanelValue('webfonts_custom');
			$custom_assign = trim($custom_assign);
			if (!$custom_assign) return '';
			$styles .= $custom_assign . ' {';
		} else {
			$styles .= 'body, input, button, select, textarea, .search-query {';
		}
		$styles .= 'font-family: ' . ya_options()->getCpanelValue('google_webfonts') . ' !important;}</style>';
	endif;
	return $styles;
}

function ya_typography_css_cache(){
	$data = get_transient( 'ya_typography_css' );
	//if ( $data === false ) {
		$data = ya_typography_css();
		set_transient( 'ya_typography_css', $data, 3600 * 24 );
	//}
	echo $data;
}
add_action( 'wp_head', 'ya_typography_css_cache', 12, 0 );

function ya_typography_css_cache_reset(){
	delete_transient( 'ya_typography_css' );
	ya_typography_css_cache();
}
//add_action( 'customize_preview_init', 'ya_typography_css_cache_reset' );


function ya_typography_webfonts(){
	if ( ya_options()->getCpanelValue('google_webfonts') ):
		$webfont_weight = array();
		$webfont				= ya_options()->getCpanelValue('google_webfonts');
		$webfont_weight			= ya_options()->getCpanelValue('webfonts_weight');
		$font_weight = '';
		if( empty($webfont_weight) ){
			$font_weight = '400';
		}
		else{
			foreach( $webfont_weight as $i => $wf_weight ){
				( $i < 1 )?	$font_weight .= '' : $font_weight .= ',';
				$font_weight .= $wf_weight;
			}
		}
		$f = strlen($webfont);
		if ($f > 3){
			$webfontname = str_replace( ' ', '+', $webfont );
			return '<link href="http://fonts.googleapis.com/css?family=' . $webfontname . ':' . $font_weight . '" rel="stylesheet">';
		}
	endif;
}

function ya_typography_webfonts_cache(){
	$data = get_transient( 'ya_typography_webfont' );
	//if ( $data === false ) {
		$data = ya_typography_webfonts();
		set_transient( 'ya_typography_webfont', $data, 0 );
	//}
	echo $data;
}
add_action( 'wp_head', 'ya_typography_webfonts_cache', 11, 0 );


function ya_typography_webfonts_cache_reset(){
	delete_transient( 'ya_typography_webfont' );
	ya_typography_webfonts_cache();
}
//add_action( 'customize_preview_init', 'ya_typography_webfonts_cache_reset' );


function ya_custom_header_scripts() {
	if ( ya_options()->getCpanelValue('advanced_head') ){
		echo ya_options()->getCpanelValue('advanced_head');
	}
}
add_action( 'wp_head', 'ya_custom_header_scripts', 200 );

function add_favicon(){
	if ( ya_options()->getCpanelValue('favicon') ){
		echo '<link rel="shortcut icon" href="' . ya_options()->getCpanelValue('favicon') . '" />';
	}
}
add_action('wp_head', 'add_favicon');
function get_entry_content_asset( $post_id )
	{
		global $post;
		$post = get_post( $post_id );
		
		$content = apply_filters ("the_content", $post->post_content);
		//print_r($content);
		$value=preg_match('/<div class=\"entry\-content\-asset\">(.*?)<\/div>/s',$content,$results);
		if($value){
			return $results[0];
		}else{
			return '';
		}
	}
function excerpt($limit) {
  $excerpt = explode(' ', get_the_content(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}
/*Product Meta*/
add_action("admin_init", "post_init");
add_action( 'save_post', 'product_save_meta', 10, 1 );
function post_init(){
	add_meta_box("product_meta", "Product Meta", "product_meta", "product", "normal", "low");
}	
function product_meta(){
	global $post;
	$value = get_post_meta( $post->ID, 'new_product', true );
	$recommend_product = get_post_meta( $post->ID, 'recommend_product', true );
?>
	<p><label><b>Recommend Product:</b></label> &nbsp;&nbsp;
	<input type="checkbox" name="recommend_product" value="yes" <?php if(esc_attr($recommend_product) == 'yes'){ echo "CHECKED"; }?> /></p>
<?php }
function product_save_meta(){
	global $post;
	if( isset( $_POST['recommend_product'] ) && $_POST['recommend_product'] != '' ){
		update_post_meta($post->ID, 'recommend_product', $_POST['recommend_product']);
	}else{
		return;
	}
}
/*end product meta*/
remove_action( 'get_product_search_form', 'get_product_search_form', 10);
add_action('get_product_search_form', 'search_product_form', 10);
function search_product_form( ){
	//do_action( 'get_product_search_form'  );
	$search_form_template = locate_template( 'product-searchform.php' );
	if ( '' != $search_form_template  ) {
		require $search_form_template;
		return;
	}

	$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div class="product-search">
			<div class="product-search-inner">
				<input type="text" class="search-text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search for products', 'yatheme' ) . '" />
				<input type="submit" class="search-submit" id="searchsubmit" value="'. esc_attr__( 'Go', 'yatheme' ) .'" />
				<input type="hidden" name="post_type" value="product" />
			</div>
		</div>
	</form>';

	return apply_filters( 'search_product_form', $form );
}

add_filter( 'image_downsize', 'hello_img', 1, 3 );

function hello_img($value, $id, $size = 'medium')
{
	
	$img_url = wp_get_attachment_url($id);
	$meta = wp_get_attachment_metadata($id);
	$width = $height = 0;
	$is_intermediate = false;
	$img_url_basename = wp_basename($img_url);

	// try for a new style intermediate size
	if ( $intermediate = image_get_intermediate_size($id, $size) ) {
		$img_url = str_replace($img_url_basename, $intermediate['file'], $img_url);
		$width = $intermediate['width'];
		$height = $intermediate['height'];
		$is_intermediate = true;
	}
	elseif ( $size == 'thumbnail' ) {
		// fall back to the old thumbnail
		if ( ($thumb_file = wp_get_attachment_thumb_file($id)) && $info = getimagesize($thumb_file) ) {
			$img_url = str_replace($img_url_basename, wp_basename($thumb_file), $img_url);
			$width = $info[0];
			$height = $info[1];
			$is_intermediate = true;
		}
	}
	if ( !$width && !$height && isset( $meta['width'], $meta['height'] ) ) {
		// any other type: use the real image
		$width = $meta['width'];
		$height = $meta['height'];
	}
	if ( $img_url) {
		$header_response = get_headers($img_url, 1);
		if ( strpos( $header_response[0], "404" ) == false ){
			// we have the actual image size, but might need to further constrain it if content_width is narrower
			list( $width, $height ) = image_constrain_size_for_editor( $width, $height, $size );
			return array( $img_url, $width, $height, $is_intermediate );
		}else{
			$html = get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png';
			return array( $html, $width, $height, $is_intermediate );
		}
	}
	return false;

}
add_filter('body_class','ya_layout_class');
function ya_layout_class($classes) {
	$header = ya_options()->getCpanelValue('box_layout');
	if($header == 'box'){
		$classes[] = 'boxed';
	}
	// return the $classes array
	return $classes;
}
/*minicart via Ajax*/
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
 
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	
	ob_start();
	
	?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.wrapp-minicart').css({'display':'none','z-index':'-9999'});
            var item=parseInt(jQuery('.top-minicart a.cart-contents .minicart-number').text());

            jQuery('.top-minicart,.wrapp-minicart').hover(function(){
                if(item != '')
                {
                    jQuery('.wrapp-minicart').css('z-index','9999');
                    jQuery('.wrapp-minicart').stop().fadeIn(300);
                }
                else{
                    jQuery('.wrapp-minicart').css({'display':'none','z-index':'-9999'});
                }

            },function(){
                jQuery('.wrapp-minicart').stop().fadeOut(300);
            });
//            jQuery('body').click(function(){
//                jQuery('.wrapp-minicart').stop().fadeOut(300);
//            });
        });
    </script>
	<div class="top-form top-form-minicart">
	<div class="top-minicart pull-right">
		<span><?php _e('My Cart','yatheme');?></span>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'yatheme'); ?>"><?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span>'; _e('item(s)', 'yatheme');?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	</div>
        <div class="wrapp-minicart ">
            <div class="minicart-padding">
            <ul class="minicart-content">
                <?php foreach($woocommerce->cart->cart_contents as $cart_item): ?>
                    <li>
                        <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                            <?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
                            <?php echo get_the_post_thumbnail($thumbnail_id, 'shop_thumbnail'); ?>
                            <div class="cart-desc">
                                <span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
                                <div class="block-qty">
                                    <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?>
                                    <span class="product-quantity">Qty:<?php echo '<span class="quantity">'.$cart_item['quantity'].'</span>'; ?></span>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php
                endforeach;
                ?>
            </ul>
            <div class="cart-checkout">
                <div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><?php _e('Go To Cart', 'yatheme'); ?></a></div>
                <div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Check Out', 'yatheme'); ?></a></div>
            </div>
        </div>
        </div>
	</div>
	</div>
	<?php
	$fragments['.top-form-minicart'] = ob_get_clean();
	return $fragments;
	
}

/*
add_filter('post_thumbnail_html', 'my_thumbnail_html', 10, 5);

function my_thumbnail_html( $html, $post_id = null, $size = 'post-thumbnail', $attr = '' ){
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$size = apply_filters( 'post_thumbnail_size', $size );
	if ( $post_thumbnail_id ) {
		do_action( 'begin_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size ); // for "Just In Time" filtering of all of wp_get_attachment_image()'s filters
		if ( in_the_loop() )
			update_post_thumbnail_cache();
			$images = wp_get_attachment_image_src( $post_thumbnail_id, $size );
			$header_response = get_headers($images[0], 1);
			if ( strpos( $header_response[0], "404" ) == false ){
				$html = wp_get_attachment_image( $post_thumbnail_id, $size, false, $attr );
				do_action( 'end_fetch_post_thumbnail_html', $post_id, $post_thumbnail_id, $size );
			}else{
				$html = '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$attr.'.jpg" alt="" />';
			}
	} else {
		$html = '';
	}
	return $html;
}
function placeholder_images( $image, $size ){
	$header_response = get_headers($image, 1);
	if ( strpos( $header_response[0], "404" ) == false ){
		echo '<img src="'.$image.'" alt="" />';
	}else{
		echo '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.jpg" alt="" />';
	}
}

*/