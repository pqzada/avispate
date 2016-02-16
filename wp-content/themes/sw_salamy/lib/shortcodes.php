<?php
	function ya_shortcode_css() {
		wp_enqueue_style('yashortcode_css', get_template_directory_uri().'/assets/css/shortcode_admin.css');
	}
	add_action('admin_enqueue_scripts', 'ya_shortcode_css');
class YA_Shortcodes{
	protected $supports = array();

	protected $tags = array( 'icon', 'button', 'alert', 'bloginfo', 'slideshow', 'googlemaps', 'tabs', 'collapses', 'columns', 'row', 'col', 'code', 'breadcrumb', 'pricing','tooltip','modal','recent_posts','gallery_image');

	public function __construct(){
		add_action('admin_head', array($this, 'mce_inject') );
		add_filter('the_content', array($this, 'fix_shortcodes') );
		$this->add_shortcodes();
	}

	public function mce_inject(){
		global $typenow;
		// check user permissions
		if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
		return;
		}
			// verify the post type
		if( ! in_array( $typenow, array( 'post', 'page' ) ) )
			return;
		// check if WYSIWYG is enabled
		if ( get_user_option('rich_editing') == 'true') {
			add_filter( 'mce_external_plugins', array($this, 'mce_external_plugins') );
			add_filter( 'mce_buttons', array($this,'mce_buttons') );
		}
	}
	
	public function mce_external_plugins($plugin_array) {
		$wp_version = get_bloginfo( 'version' );
		if ( version_compare( $wp_version, '3.9', '>=' ) ) {
			$plugin_array['ya_shortcodes'] = get_template_directory_uri().'/assets/js/ya_shortcodes_tinymce.js';
		}else{
			$plugin_array['ya_shortcodes'] = get_template_directory_uri().'/assets/js/ya_shortcodes_tinymce_old.js';
		}
		return $plugin_array;
	}
	
	public function mce_buttons($buttons) {
		array_push($buttons, "ya_shortcodes");
		return $buttons;
	}
	
	public function add_shortcodes(){
		if ( is_array($this->tags) && count($this->tags) ){
			foreach ( $this->tags as $tag ){
				add_shortcode($tag, array($this, $tag));
			}
		}
	}
	
	function fix_shortcodes($content){
		$array = array (
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']',
			'<br />[' => '['
		);
		$content = strtr($content, $array);
		return $content;
	}
	
	function code($attr, $content) {
		$html = '';
		$html .= '<pre>';
		$html .= $content;
		$html .= '</pre>';
		
		return $html;
	}
	
	function icon( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'tag' => 'span',
				'name' => '*',
				'class' => '',
				'color' => ''
			), $atts )
		);
		$attributes = array();
	
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		
		if ( !preg_match('/icon-/', $name) ){
			$name = 'icon-'.$name;
		}
		array_unshift($classes, $name);
		
		$classes = array_unique($classes);
		
		$attributes[] = 'class="'.implode(' ', $classes).'"';
		
		if ( !empty($color) ){
			$attributes[] = 'style="color: '.$color.';"';
		}
		
		// Code
		return "<$tag ".implode(' ', $attributes)."></$tag>";
	}
	
	public function button( $atts, $content = null ){
		// Attributes
		extract( shortcode_atts(
			array(
				'id' => '',
				'tag' => 'span',
				'class' => '',
				'target' => '',
				'type' => '',
				'href' => '#'
			), $atts )
		);
		$attributes = array();
		
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		if ( !preg_match('/btn-/', $type) ){
			$type = 'btn-'.$type;
		}
		array_unshift($classes, 'btn btn-default', $type);
		$classes = array_unique($classes);
		$attributes[] = 'class="'.implode(' ', $classes).'"';
		
		if ( !empty($id) ){
			$attributes[] = 'id="'.esc_attr($id).'"';
		}
		
		if ( !empty($target) ){
			if ( 'a' == $tag ){
				$attributes[] = 'target="'.esc_attr($target).'"';
			} else {
				// html5
				$attributes[] = 'data-target="'.esc_attr($target).'"';
			}
		}
		
		if ( 'a' == $tag ){
			$attributes[] = 'href="'.esc_attr($href).'"';
		}
		
		return "<$tag ".implode(' ', $attributes).">".do_shortcode($content)."</$tag>";
	}
	
	/**
	 * Alert
	 * */
	public function alert($atts, $content = null ){

		extract(shortcode_atts(array(
				'tag' => 'div',
				'class' => '',
				'dismiss' => 'true',
				'type' => ''
			), $atts)
		);
		
		$attributes = array();
		$attributes[] = $tag;
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		
		if ( !preg_match('/alert-/', $type) ){
			$type = 'alert-'.$type;
		}
		
		array_unshift($classes, 'alert', $type);
		$classes = array_unique($classes);
		$attributes[] = 'class="'.implode(' ', $classes).'"';
		
		$html = '';
		$html .= '<'.implode(' ', $attributes).'>';
		
		if ($dismiss == 'true') {
			$html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		}
		$html .= do_shortcode($content);
		$html .= '</'.$tag.'>';
		return $html;
	}


	/**
	 * Bloginfo
	 * */
	function bloginfo( $atts){
		extract( shortcode_atts(array(
				'show' => 'wpurl',
				'filter' => 'raw'
			), $atts)
		);
		$html = '';
		$html .= get_bloginfo($show, $filter);

		return $html;
	}
	
		
	/**
	 * Slideshow
	 * */
	public function slideshow($attr){
		static $priority = 0;
		$post = get_post();

		static $instance = 0;
		$instance++;

		if (!empty($attr['ids'])) {
			if (empty($attr['orderby'])) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		$output = apply_filters('post_gallery', '', $attr);

		if ($output != '') {
			return $output;
		}

		if (isset($attr['orderby'])) {
			$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
			if (!$attr['orderby']) {
				unset($attr['orderby']);
			}
		}

		if (is_array($attr) ) {
				
			foreach ($attr as $key => $att){
				$att = trim($att);
				if (empty($att)) unset( $attr[$key] );
			}
		}

		extract(shortcode_atts(array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => '',
				'icontag'    => '',
				'caption'    => 'true',
				'size'       => 'medium',
				'interval'	 => '5000',
				'event'		 => 'slide',
				'class'		 => '',
				'include'    => '',
				'exclude'    => ''
			), $attr)
		);

		$id = intval($id);

		if ($order === 'RAND') {
			$orderby = 'none';
		}

		if (!empty($include)) {
			$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

			$attachments = array();
			foreach ($_attachments as $key => $val) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif (!empty($exclude)) {
			$attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
		} else {
			$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
		}

		if (empty($attachments)) {
			return '';
		}
		
		//wp_enqueue_script('ya_shortcode');
		
		$classes =array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		$classes[] = trim($event);
		array_unshift($classes, 'shortcode-slideshow');
		$classes = array_unique($classes);
		$classes = implode(' ', $classes);
		
		$slideshow_id = 'yaSlideshow-'.$priority;
		
		$script = '';
		$script .= '<script type="text/javascript">';
		
		if ($priority == 0) $script .= 'yaSlideshow = {};';
		
		$script .= 'yaSlideshow['.$priority.'] = {';
		$script .= 		'interval: ' .$interval;
		$script .= '};';
		$script .= '</script>';
		$html = '';
		$html .= $script;
		$html .= '<div class="row"><div class="carousel '.$classes.'" id="'.$slideshow_id.'" >';
		$html .= '<ol class="carousel-indicators">';
		for ($i=0; $i< count($attachments); $i++){
			$active = '';
			if ($i==0) $active = 'active';
			$html .= '<li data-slide-to="'.$i.'" data-target="#'.$slideshow_id.'" class="'.$active.'"></li>';
		}
		$html .= '</ol>';
		$html .= '<div class="carousel-inner">';
		$i = 0;
		foreach ($attachments as $attachment){
			$active = '';
			if ($i==0) $active = 'active';
			 
			$html .= '<div class="item '.$active.'">';
			$html .= wp_get_attachment_image($attachment->ID, $size);

			if ($caption == 'true') {
				$html .= '<div class="carousel-caption">';
				$html .= '<h4>'.$attachment->post_title.'</h4>';
				$content = trim($attachment->post_content);
				if (!empty($content)) {
					$html .= ' <p>'.$content.'</p>';
				}
				$html .= '</div>';
			}

			$html .= '</div>';
			$i++;
		}
		$html .= '</div>';
		$html .= '<a data-slide="prev" href="#'.$slideshow_id.'" class="left carousel-control">‹</a>
				<a data-slide="next" href="#'.$slideshow_id.'" class="right carousel-control">›</a>';
		$html .= '</div></div>';
		 
		add_action('wp_footer', array($this, 'slideshow_script'), 50 );
		$priority++;
		
		return $html;
	}

	public function slideshow_script() {
	
		if ( !wp_script_is('bootstrap_js')) {
			wp_enqueue_scripts('bootstrap_js');
		}
		?>
		<script type="text/javascript">
			<!--
			//yaslideshow = {};
			jQuery(document).ready(function($) {
				//console.log(yaSlideshow);
				$.each(yaSlideshow, function(key, value) {
					$('#yaSlideshow-'+key).carousel({
						interval: value['interval']
					});
				});
			});
			//-->
		</script>
		<?php
	}
	
	
	/**
	 * Google Maps
	 */
	function googlemaps($atts, $content = null) {
		extract(shortcode_atts(array(
		"title" => '',
		"location" => '',
		"width" => '100%', //leave width blank for responsive designs
		"height" => '300',
		"zoom" => 10,
		"align" => '',
		), $atts));

		// load scripts
		wp_enqueue_script('ya_googlemap',  get_template_directory_uri() . '/assets/js/ya_googlemap.js', array('jquery'), '', true);
		wp_enqueue_script('ya_googlemap_api', 'https://maps.googleapis.com/maps/api/js?sensor=false', array('jquery'), null, true);

		$output = '<div id="map_canvas_'.rand(1, 100).'" class="googlemap" style="height:'.$height.'px;width:100%">';
		$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
		$output .= '<input class="location" type="hidden" value="'.$location.'" />';
		$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
		$output .= '<div class="map_canvas"></div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * Tabs
	 * */
	public function tabs( $atts , $content = null ) {
		static $key = 0;
		
		if (is_array($atts) ) {
				
			foreach ($atts as $k => $att){
				$att = trim($att);
				if (empty($att)) unset( $atts[$k] );
			}
		}
		$yaTab_id = 'yaTab-'.$key;
		extract(shortcode_atts(array(
				'tag' => 'div',
				'class' => 'tabbable',
				'position' => 'top'
			), $atts));
		$atts['id'] = $yaTab_id;
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		array_unshift($classes, 'tabbable');
		
		if ( $position == 'left' ) array_unshift($classes, 'tabs-left');
		elseif ( $position == 'right' ) array_unshift($classes, 'tabs-right');
		elseif ($position == 'bottom') array_unshift($classes, 'tabs-below');
		
		$classes = array_unique($classes);
		$classes = ' class="'.implode(' ', $classes).'"';
		
		$html = '';
		$html .= '<'.$tag.$classes.' id="'.$yaTab_id.'">';
		$html .= self::get_tab($atts, $content);
		$html .= '</'.$tag.'>';
		$key++;
		
		return $html;
	}
	
	
	protected function get_tab($atts, $content){
		
		if (preg_match_all('/\[(\[?)(tab)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/', $content, $m)) {
			$titles = array();
			$contents = array();
			for ($i=0; $i<count($m[0]); $i++) {
				extract(shortcode_atts( array(
									'title' => 'Tab '.$i
								), shortcode_parse_atts($m[3][$i])
							)
						);
				$titles[] = $title;
				$contents[] = $m[5][$i];
			}
		
			$header = '<ul class="nav nav-tabs">';
			foreach ($titles as $i => $title){
				$class = '';
				if ($i == 0) $class .= ' class="active"';
				$header .= '<li '.$class.'><a data-toggle="tab" href="#'.$atts['id'].$i.'">'.$title.'</a></li>';
			}
			$header .= '</ul>';
			
			$body = '<div class="tab-content">';
			foreach ($contents as $i => $content){
				$class = 'tab-pane';
				if ($i == 0) $class .= ' active';
				$class = 'class="'.$class.'"';
				$body .= '<div '.$class.' id="'.$atts['id'].$i.'">'.do_shortcode($content).'</div>';
			}
			$body .= '</div>';
			
			$html = '';
			if ($atts['position'] == 'bottom') {
				$html .= $body.$header;
			} else $html .= $header.$body;
		}
		
		return $html;
	}
	
	
	/**
	 * Collapse
	 * */

	public function collapses( $atts, $content = NULL ){
		static $key = 0;

		if (is_array($atts) ) {
				
			foreach ($atts as $k => $att){
				$att = trim($att);
				if (empty($att)) unset( $atts[$k] );
			}
		}

		$collapse_id = 'yaCollapse-'.$key ;
		extract(shortcode_atts(array(
				'class' => '',
				'tag'   => 'div'
			), $atts));
		$atts['id'] = $collapse_id;
		
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		array_unshift($classes, 'panel-group');
		$classes = array_unique($classes);
		$html = '';
		$html .= '<'.$tag.' id="'.$collapse_id.'" class="'.implode(' ', $classes).'">';
		$html .= self::get_collapse($atts, $content);
		$html .= '</'.$tag.'>';
		$key++;
		
		return $html;
	}

	function get_collapse( $atts, $content = NULL ) {

		$html = '';
		if (preg_match_all('/\[(\[?)(collapse)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/', $content, $m)) {
			$titles = array();
			$contents = array();
			for ($i=0; $i<count($m[0]); $i++) {
				extract(shortcode_atts( array(
								'title' => 'Collapse '.$i
							), shortcode_parse_atts($m[3][$i])
						)
					);
				$content = $m[5][$i];
			
				if ($i == 0) {
					$in = 'in';
					$active = 'active';
				} else {
					$in = '';
					$active = '';
				}
				$html .= '<div class="panel panel-default '.$active.'">';
				$html .= '<div class="panel-heading">
							<a href="#'.$atts['id'].$i.'"
								data-parent="#'.$atts['id'].'"
								data-toggle="collapse"
								class="accordion-toggle">'.$title.'
							</a>
						</div>';
				$html .= '<div class="panel-collapse collapse '.$in.'" id="'.$atts['id'].$i.'">
							<div class="panel-body">
								'.do_shortcode($content).'
							</div>
						</div>';
				$html .= '</div>';
			}
		}
		
		return $html;
	}

	
	/**
	 * Column
	 * */
	public function row( $atts, $content = null ){
		extract( shortcode_atts( array(
			'class' => '',
			'tag'   => 'div',
			'type'  => ''
		), $atts) );
		$row_class = 'row';
		
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		
		array_unshift($classes, $row_class);
		$classes = array_unique($classes);
		$classes = ' class="'. implode(' ', $classes).'"';
		return "<$tag ". $classes . ">" . do_shortcode($content) . "</$tag>";
	}
	
	public function col( $atts, $content = null ){
		extract( shortcode_atts( array(
			'class' 	=> '',
			'tag'   	=> 'div',
			'large'  	=> '12',
			'medium'	=> '12',
			'small'		=> '12',
			'xsmall'	=> '12'
		), $atts) );
		$col_class  = !empty($large)  ? "col-lg-$large"   : 'col-lg-12';
		$col_class .= !empty($medium) ? " col-md-$medium" : ' col-md-12';
		$col_class .= !empty($small)  ? " col-sm-$small"  : ' col-sm-12';
		$col_class .= !empty($xsmall) ? " col-xs-$xsmall" : ' col-xs-12';
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		array_unshift($classes, $col_class);
		$classes = array_unique($classes);
		$classes = ' class="'. implode(' ', $classes).'"';
		return "<$tag ". $classes . ">" . do_shortcode($content) . "</$tag>";
	}
	
	public function breadcrumb ($atts){
		
		extract(shortcode_atts(array(
				'class' => 'breadcumbs',
				'tag'  => 'div'
			), $atts));
			
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		$classes = ' class="' . implode(' ', $classes) . '" ';
		
		$before = '<' . $tag . $classes . '>';
		$after  = '</' . $tag . '>';
		
		$ya_breadcrumb = new YA_Breadcrumbs;
		return $ya_breadcrumb->breadcrumb( $before, $after, false );
	}
}
new YA_Shortcodes();


/**
 * This class handles the Breadcrumbs generation and display
 */
class YA_Breadcrumbs {

	/**
	 * Wrapper function for the breadcrumb so it can be output for the supported themes.
	 */
	function breadcrumb_output() {
		$this->breadcrumb( '<div class="breadcumbs">', '</div>' );
	}

	/**
	 * Get a term's parents.
	 *
	 * @param object $term Term to get the parents for
	 * @return array
	 */
	function get_term_parents( $term ) {
		$tax     = $term->taxonomy;
		$parents = array();
		while ( $term->parent != 0 ) {
			$term      = get_term( $term->parent, $tax );
			$parents[] = $term;
		}
		return array_reverse( $parents );
	}

	/**
	 * Display or return the full breadcrumb path.
	 *
	 * @param string $before  The prefix for the breadcrumb, usually something like "You're here".
	 * @param string $after   The suffix for the breadcrumb.
	 * @param bool   $display When true, echo the breadcrumb, if not, return it as a string.
	 * @return string
	 */
	function breadcrumb( $before = '', $after = '', $display = true ) {
		$options = array('breadcrumbs-home' => 'Home', 'breadcrumbs-blog-remove' => false, 'post_types-post-maintax' => '0');
		
		global $wp_query, $post;

		$on_front  = get_option( 'show_on_front' );
		$blog_page = get_option( 'page_for_posts' );

		$links = array(
			array(
				'url'  => get_home_url(),
				'text' => ( isset( $options['breadcrumbs-home'] ) && $options['breadcrumbs-home'] != '' ) ? $options['breadcrumbs-home'] : __( 'Home', 'yatheme' )
			)
		);

		if ( ( $on_front == "page" && is_front_page() ) || ( $on_front == "posts" && is_home() ) ) {

		} else if ( $on_front == "page" && is_home() ) {
			$links[] = array( 'id' => $blog_page );
		} else if ( is_singular() ) {
			if ( get_post_type_archive_link( $post->post_type ) ) {
				$links[] = array( 'ptarchive' => $post->post_type );
			}
			
			if ( 0 == $post->post_parent ) {
				if ( isset( $options['post_types-post-maintax'] ) && $options['post_types-post-maintax'] != '0' ) {
					$main_tax = $options['post_types-post-maintax'];
					$terms    = wp_get_object_terms( $post->ID, $main_tax );
					
					if ( count( $terms ) > 0 ) {
						// Let's find the deepest term in this array, by looping through and then unsetting every term that is used as a parent by another one in the array.
						$terms_by_id = array();
						foreach ( $terms as $term ) {
							$terms_by_id[$term->term_id] = $term;
						}
						foreach ( $terms as $term ) {
							unset( $terms_by_id[$term->parent] );
						}

						// As we could still have two subcategories, from different parent categories, let's pick the first.
						reset( $terms_by_id );
						$deepest_term = current( $terms_by_id );

						if ( is_taxonomy_hierarchical( $main_tax ) && $deepest_term->parent != 0 ) {
							foreach ( $this->get_term_parents( $deepest_term ) as $parent_term ) {
								$links[] = array( 'term' => $parent_term );
							}
						}
						$links[] = array( 'term' => $deepest_term );
					}

				}
			} else {
				if ( isset( $post->ancestors ) ) {
					if ( is_array( $post->ancestors ) )
						$ancestors = array_values( $post->ancestors );
					else
						$ancestors = array( $post->ancestors );
				} else {
					$ancestors = array( $post->post_parent );
				}

				// Reverse the order so it's oldest to newest
				$ancestors = array_reverse( $ancestors );

				foreach ( $ancestors as $ancestor ) {
					$links[] = array( 'id' => $ancestor );
				}
			}
			$links[] = array( 'id' => $post->ID );
		} else {
			if ( is_post_type_archive() ) {
				$links[] = array( 'ptarchive' => get_post_type() );
			} else if ( is_tax() || is_tag() || is_category() ) {
				$term = $wp_query->get_queried_object();

				if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent != 0 ) {
					foreach ( $this->get_term_parents( $term ) as $parent_term ) {
						$links[] = array( 'term' => $parent_term );
					}
				}

				$links[] = array( 'term' => $term );
			} else if ( is_date() ) {
				$bc = __( 'Archives for', 'framework' );
				
				if ( is_day() ) {
					global $wp_locale;
					$links[] = array(
						'url'  => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ),
						'text' => $wp_locale->get_month( get_query_var( 'monthnum' ) ) . ' ' . get_query_var( 'year' )
					);
					$links[] = array( 'text' => $bc . " " . get_the_date() );
				} else if ( is_month() ) {
					$links[] = array( 'text' => $bc . " " . single_month_title( ' ', false ) );
				} else if ( is_year() ) {
					$links[] = array( 'text' => $bc . " " . get_query_var( 'year' ) );
				}
			} elseif ( is_author() ) {
				$bc = __( 'Archives for', 'framework' );
				$user    = $wp_query->get_queried_object();
				$links[] = array( 'text' => $bc . " " . esc_html( $user->display_name ) );
			} elseif ( is_search() ) {
				$bc = __( 'You searched for', 'framework' );
				$links[] = array( 'text' => $bc . ' "' . esc_html( get_search_query() ) . '"' );
			} elseif ( is_404() ) {
				$crumb404 = __( 'Error 404: Page not found', 'framework' );
				$links[] = array( 'text' => $crumb404 );
			}
		}
		
		$output = $this->create_breadcrumbs_string( $links );

		if ( $display ) {
			echo $before . $output . $after;
			return true;
		} else {
			return $before . $output . $after;
		}
	}

	/**
	 * Take the links array and return a full breadcrumb string.
	 *
	 * Each element of the links array can either have one of these keys:
	 *       "id"            for post types;
	 *    "ptarchive"  for a post type archive;
	 *    "term"         for a taxonomy term.
	 * If either of these 3 are set, the url and text are retrieved. If not, url and text have to be set.
	 *
	 * @link http://support.google.com/webmasters/bin/answer.py?hl=en&answer=185417 Google documentation on RDFA
	 *
	 * @param array  $links   The links that should be contained in the breadcrumb.
	 * @param string $wrapper The wrapping element for the entire breadcrumb path.
	 * @param string $element The wrapping element for each individual link.
	 * @return string
	 */
	function create_breadcrumbs_string( $links, $wrapper = 'ul', $element = 'li' ) {
		global $paged;
		
		$output = '';

		foreach ( $links as $i => $link ) {

			if ( isset( $link['id'] ) ) {
				$link['url']  = get_permalink( $link['id'] );
				$link['text'] = strip_tags( get_the_title( $link['id'] ) );
			}

			if ( isset( $link['term'] ) ) {
				$link['url']  = get_term_link( $link['term'] );
				$link['text'] = $link['term']->name;
			}

			if ( isset( $link['ptarchive'] ) ) {
				$post_type_obj = get_post_type_object( $link['ptarchive'] );
				$archive_title = $post_type_obj->labels->menu_name;
				$link['url']  = get_post_type_archive_link( $link['ptarchive'] );
				$link['text'] = $archive_title;
			}
			
			$link_class = '';
			if ( isset( $link['url'] ) && ( $i < ( count( $links ) - 1 ) || $paged ) ) {
				$link_output = '<a href="' . esc_url( $link['url'] ) . '" >' . esc_html( $link['text'] ) . '</a><span class="divider">/</span>';
			} else {
				$link_class = ' class="active" ';
				$link_output = '<span>' . esc_html( $link['text'] ) . '</span>';
			}
			
			$element = esc_attr(  $element );
			$element_output = '<' . $element . $link_class . '>' . $link_output . '</' . $element . '>';
			
			$output .=  $element_output;
			
			$class = ' class="breadcrumb" ';
		}

		return '<' . $wrapper . $class . '>' . $output . '</' . $wrapper . '>';
	}

}

global $yabreadcrumb;
$yabreadcrumb = new YA_Breadcrumbs();

if ( !function_exists( 'ya_breadcrumb' ) ) {
	/**
	 * Template tag for breadcrumbs.
	 *
	 * @param string $before  What to show before the breadcrumb.
	 * @param string $after   What to show after the breadcrumb.
	 * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
	 * @return string
	 */
	function ya_breadcrumb( $before = '', $after = '', $display = true ) {
		global $yabreadcrumb;
		return $yabreadcrumb->breadcrumb( $before, $after, $display );
	}
}

/*
 * Pricing Table
 * @since v1.0
 *
 */
 
/*main*/
if( !function_exists('pricing_table_shortcode') ) {
	function pricing_table_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'style' => 'style1',
		), $atts ) );
		
	   return '<div class="pricing-table clearfix '.$style.'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode( 'pricing_table', 'pricing_table_shortcode' );
}

/*section*/
if( !function_exists('pricing_shortcode') ) {
	function pricing_shortcode( $atts, $content = null, $style_table) {
		
		extract( shortcode_atts( array(
			'style' =>'style1',
			'size' => 'one-five',
			'featured' => 'no',
			'description'=>'',
			'plan' => 'Basic',
			'cost' => '$20',
			'per' => 'month',
			'button_url' => '',
			'button_text' => 'Purchase',
			'button_target' => 'self',
			'button_rel' => 'nofollow'
		), $atts ) );
		
		//set variables
		$featured_pricing = ( $featured == 'yes' ) ? 'most-popular' : NULL;
		
		//start content1  
		$pricing_content1 ='';
		$pricing_content1 .= '<div class="pricing pricing-'. $size .' '. $featured_pricing . '">';
				$pricing_content1 .= '<div class="header">'. $plan. '</div>';
				$pricing_content1 .= '<div class="price">'. $cost .'/'. $per .'</div>';
			$pricing_content1 .= '<div class="pricing-content">';
				$pricing_content1 .= ''. $content. '';
			$pricing_content1 .= '</div>';
			if( $button_url ) {
				$pricing_content1 .= '<a href="'. $button_url .'" class="signup" target="_'. $button_target .'" rel="'. $button_rel .'" '.'>'. $button_text .'</a>';
			}
		$pricing_content1 .= '</div>';
		//start content2  
		$pricing_content2 ='';
		$pricing_content2 .= '<div class="pricing pricing-'. $size .' '. $featured_pricing . '">';
			$pricing_content2 .= '<div class="header"><h3>'. $plan. '</h3><span>'.$description.'</span></div>';
				
			$pricing_content2 .= '<div class="pricing-content">';
				$pricing_content2 .= ''. $content. '';
			$pricing_content2 .= '</div>';
			$pricing_content2 .= '<div class="price"><span class="span-1">'. $cost .'</span><span class="span-2">'. $per .'</span></div>';
			if( $button_url ) {
				$pricing_content2 .= '<a href="'. $button_url .'" class="signup" target="_'. $button_target .'" rel="'. $button_rel .'" '.'>'. $button_text .'</a>';
			}
		$pricing_content2 .= '</div>';
		if($style == 'style1'){
			return $pricing_content1;
		}
		else{
			return $pricing_content2;
		}
	}
	
	add_shortcode( 'pricing', 'pricing_shortcode' );
}
/*
 * Tooltip
 * @since v1.0
 *
 */
 function tooltip($attr, $content = null) {
            ob_start();
            ?>
            <a href="#" data-toggle="tooltip" data-placement="<?php echo trim($attr['orient']) ?>" title="<?php echo trim($attr['content']) ?>" class="ya-tooltip"><?php echo $content;?></a>
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }
add_shortcode('ya_tooltip', 'tooltip');

/*
 * Modal
 * @since v1.0
 *
 */
 
function modal($attr, $content = null) {
            ob_start();
			$tag_id = 'myModal_'.rand().time();
			?>
			<a href="#<?php echo $tag_id; ?>" role="button" class="btn btn-default" data-toggle="modal"><?php echo trim($attr['label']) ?></a>
 
			<!-- Modal -->
			<div id="<?php echo $tag_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel"><?php echo trim($attr['header']) ?></h3>
						</div>
						<div class="modal-body">
							<?php echo $content; ?>
						</div>
						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php echo trim($attr['close']) ?></button>
							<button class="btn btn-primary"><?php echo trim($attr['save']) ?></button>
						</div>
					</div>
				</div>
			</div>
            
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }
add_shortcode('ya_modal', 'modal');

/*
 * Recent posts shortcode
 *
 */
 

function recent_posts( $atts ) {
	extract( shortcode_atts( array( 'limit' => 6, 'title' =>'Recent posts', 'num_column'=> 3, 'id' => 3), $atts ) );
	global $post;
	$numbers = ceil( 12 / $num_column);
	$q = new WP_Query( 'posts_per_page=' . $limit );
	$list  = '<div class="widget-title-sidebar"><h3>'.$title.'</h3>';
	$list .= '<hr></div>';
	$list .= '<div class="sw-latestnews latest-blog">';
	$list .= '<div id="myCarousel-'.$id.'" class="carousel slide ">';
	$list .= '<ol class="carousel-indicators">';
		for ($i=0; $i * $num_column < $limit; $i++){
		$list .= '<li class="';
		if ($i==0) {
			$list .= 'active';
		}
		$list .= '" data-slide-to="'.$i.'" data-target="#myCarousel-'.$id.'"><span class="icon-circle"></span></li>';
		}
	$list .= '</ol>';
	$list .= '<div class="carousel-inner">';
	$j = 0;
	while ( $q->have_posts() ): $q->the_post();
			
			if($j % $num_column == 0){
				$list .= '<div class="item ';
				if($j == 0)
				{$list .='active ';} 
				$list .='row">';
			}

		$list .= '<div class="sw-widget-item col-lg-'.$numbers.' col-md-'.$numbers.' col-sm-'.$numbers.'"><div class="sw-item-inner">'; 
				$list .= '<div class="sw-thumb">';
				if (has_post_thumbnail()) {
					$list .='<a href="'.get_permalink().'">'.get_the_post_thumbnail($post->ID,'thumbnail').'</a>';
				}else{
					$list .='<a href="'.get_permalink().'"><img src="'.get_template_directory_uri().'/assets/img/medium.png" alt="No Thumb"/></a>';
				}
			$list .='</div>';
			$list .= '<div class="sw-caption"><h4 class="sw-title">';
			$list .= '<a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
			$list .= '<div class="sw-meta"><div class="sw-date">Published: '. get_the_date().'</div>';
			$list .='<div class="sw-comment">';
			$count_comment = get_comments_number($post->comment_count); 
			if ($count_comment > 1) {
				$list .='<i class="icon-comment"></i> ' . $count_comment . ' comments';
			}else 
			$list .='<i class="icon-comment"></i> ' . $count_comment . ' comment';
			$list .='</div></div>';
			$list .='<div class="sw-content">'.get_the_excerpt().'</div></div></div></div>';
			if(($j+1)% $num_column == 0 || $j+1 == $limit){ 
			$list .='</div>';
			}
			$j ++;
	endwhile;
	wp_reset_query();

	return $list . '</div></div></div>';
}

add_shortcode( 'ya-recent-posts', 'recent_posts' );



