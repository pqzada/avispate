<?php
/**
 * Plugin Name.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */

/**
 * Plugin class.
 *
 * TODO: Rename this class to a proper name for your plugin.
 *
 * @package Plugin_Name
 * @author  Your Name <email@example.com>
 */
class Plugin_Tab_Content {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'plugin-tab-content';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	
	public $options = array();
	
	private $layout = 1;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		if ( is_admin() ){
			// Add the options page and menu item.
			add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		
			add_action( 'admin_init', array( $this, 'page_init' ) );
		}

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Define custom functionality. Read more about actions and filters: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		add_action( 'TODO', array( $this, 'action_method_name' ) );
		add_filter( 'TODO', array( $this, 'filter_method_name' ) );

		add_shortcode('tab_content', array($this, 'shortcode'));
		
		//allows us to run the shortcode in widgets
		add_filter( 'widget_text', 'do_shortcode' );
		
		$this->options = get_option('sw_tab_content');
		
		add_action('wp_ajax_nopriv_sw_tab_content_callback', array($this,'sw_tab_content_callback'));
		add_action('wp_ajax_sw_tab_content_callback', array($this,'sw_tab_content_callback'));
		
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}
		
		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		} 
		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_register_style('lightbox_css', get_template_directory_uri() . '/assets/css/jquery.fancybox.css', array(), null);
		if (!wp_style_is('lightbox_css')) {
			wp_enqueue_script('lightbox_css-js');
		} 
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/public.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		//wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
		wp_register_script('lightbox_js', get_template_directory_uri() . '/assets/js/jquery.fancybox.pack.js', array('jquery'), null, false);
		if (!wp_script_is('lightbox_js')) {
			wp_enqueue_script('lightbox_js-js');
		}
		wp_enqueue_script( 'sw-tab-content-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
		
		// in javascript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
		wp_localize_script( 'sw-tab-content-script', 'sw_tab_content_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * TODO:
		 *
		 * Change 'Page Title' to the title of your plugin admin page
		 * Change 'Menu Text' to the text for menu item for the plugin settings page
		 * Change 'plugin-tab-content' to the name of your plugin
		 */
		$this->plugin_screen_hook_suffix = add_menu_page(
			__( 'Tab Content', $this->plugin_slug ),
			__( 'Tab Content', $this->plugin_slug ),
			'administrator',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);
		
	}
	
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// TODO: Define your action hook callback here
		
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}
	
	public function sw_trim_words( $text, $num_words = 30, $more = null ) {
		$text = strip_shortcodes( $text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		return wp_trim_words($text, $num_words, $more);
	}
	public function shortcode($atts) {
		
		//require_once( plugin_dir_path( __FILE__ ) . 'image.php' );
		
		$options = get_option('sw_tab_content');
		
		$count_item = isset($options['count_item']) ? intval($options['count_item']) : 5;
		$max_length = isset($options['max_length']) ? intval($options['max_length']) : 30;
		$first_tab  = isset($options['first_tab'])  ? intval($options['first_tab']) : 1;
		$layout     = isset($options['layout'])  ? intval($options['layout']) : 1;
		$colums  	= isset($options['colums'])  ? $options['colums'] : 'span6';
		
		$colums     = isset($atts['colums'])  ? $atts['colums'] : $colums;
		$layout     = isset($atts['layout'])  ? intval($atts['layout']) : $layout;
		$max_length = isset($atts['max_length'])  ? intval($atts['max_length']) : $max_length;
		$caption 	= isset($atts['caption'])  ? $atts['caption'] : 'true';
		
		$data_colums = 'data-colums="' . $colums . '"';
		
		if ( $layout == 1 ) {
			require 'views/public.php';
		} else 
			require 'views/layout_'. $layout .'.php';
		
		$html = '';
		$html .= '<div class="sw-tab-content sw-tab-content-layout'. 
					$layout .'" data-layout="'. $layout .'" '. $data_colums .
					' data-max-length="'.$max_length.'" data-caption="'. $caption .'">';
		
		if (isset($options['catid'])) {

			if ( $first_tab - 2 == -1) {
				$active = 'class="active"';
			} else
				$active = '';
			
			/*Nav Tabs*/
			$html .= '<ul class="nav nav-tabs" id="sw-tab-content">';
			
			$all = implode(',', $options['catid']);
			
			$html .= '<li '. $active .'><a data-tab-load="ajax" data-toggle="tab" data-catid="'. $all .'" data-start="0" href="#catid-all">All</a></li>';
			
			foreach ($options['catid'] as $key => $catid) {
				if ($options['first_tab']-2 == $key) {
					$active = 'class="active"';
				} else $active = '';
				
				$html .= '<li '. $active .'><a data-tab-load="ajax" data-toggle="tab" data-catid="'. $catid .'" data-start="0" href="#catid-'. $catid .'">'. get_cat_name($catid) .'</a></li>';	
			}
			$html .= '</ul>';
			/*---------End Nav Tabs------------*/
			
			$html .= '<div class="tab-content" style="position: relative; min-height: 200px">';
			
				//$html .= '<div id="loading"></div>';
				
				/* Tab All Pane*/
				if ( $first_tab - 2 == -1) {
					$active = 'active';
				} else
					$active = '';
				
				$html .= ' <div class="tab-pane '. $active  .'" id="catid-all">';
				
					$html .= '<div id="carousel-catid-all" class="carousel slide carousel-catid">';
					
						$html .= '<div class="carousel-inner">';
						
						$posts = get_posts(array('category' => $all, 'numberposts' => -1));
						
						for ( $start = 0; $start * $count_item < count($posts); $start++ ) {
								
							if ( $start == 0 ) {
								$active = 'active';
							} else
								$active = '';
								
							$html .= '<div id="catid-all-page-'. $start .'" class="item '. $active .'">';
						
							if ( $first_tab - 2 == -1 && $start == 0 ) {
								$html .= tab_content_html($all, $start, $colums, $max_length, $caption);
							}
							$html .= '</div>';
						}
						
						$html .= '</div>'; /* End Carousel-inner */
					
						/* Pagination */
						$html .= '<div class="sw-pagination">';
							$html .= '<div class="sw-pagination-inner">';
								$html .= '<a class="carousel-control left" href="#carousel-catid-all" data-slide="prev" data-load="ajax"><span class="icon-caret-left"></span></a>';
									
								$html .= '<ol class="carousel-indicators">';
								for ( $key = 0; $key * $count_item <  count($posts); $key++ ) {
								
									if ($key == 0) {
										$active = 'class="active"';
									} else $active = '';
									
									$pagination = $key + 1;
									
									$html .= '<li '. $active .' data-load="ajax" data-catid="'. $all .'" data-start="'. $key .'" data-target="#carousel-catid-all" data-slide-to="'. $key .'">'. $pagination .'</li>';
								}
								$html .= '</ol>';
									
								$html .= '<a class="carousel-control right" href="#carousel-catid-all" data-slide="next" data-load="ajax"><span class="icon-caret-right"></span></a>';
							$html .= '</div>';
						$html .= '</div>';
						/* ---------- End Pagination ------------ */
					
					$html .= '</div>'; /* End Carousel */
					
				$html .= '</div>';
				/* ----------End Tab All Pane--------------*/
				
				
			foreach ($options['catid'] as $key => $catid) {
				
				if ( $first_tab - 2 == $key ) {
					$active = 'active';
				} else 
					$active = '';
			
				/* Tab Pane*/
				$html .= ' <div class="tab-pane '. $active  .'" id="catid-'. $catid .'">';
				
					$html .= '<div id="carousel-catid-'. $catid .'" class="carousel slide carousel-catid">';
						
						$html .= '<div class="carousel-inner">';

						$posts = get_posts(array('category' => $catid, 'numberposts' => -1));
						
						for ( $start = 0; $start * $count_item < count($posts); $start++ ) {
							
							if ( $start == 0 ) {
								$active = 'active';
							} else 
								$active = '';
							
							$html .= '<div id="catid-'. $catid .'-page-'. $start .'" class="item '. $active .'">';
								
								if ( $first_tab - 2 == $key && $start == 0 ) {
									$html .= tab_content_html($catid, $start, $colums, $max_length, $caption);
								}
							$html .= '</div>';
						}
						
						$html .= '</div>'; /* End Carousel-inner */
						
						/* Pagination */
						$html .= '<div class="sw-pagination">';
							$html .= '<div class="sw-pagination-inner">';
								$html .= '<a class="carousel-control left" href="#carousel-catid-'. $catid .'" data-slide="prev" data-load="ajax"><span class="icon-caret-left"></span></a>';
								
								$html .= '<ol class="carousel-indicators">';
								for ( $key = 0; $key * $count_item <  count($posts); $key++ ) {
									
									if ($key == 0) {
										$active = 'class="active"';
									} else $active = '';
									
									$pagination = $key + 1;
									
									$html .= '<li '. $active .' data-load="ajax" data-catid="'. $catid .'" data-start="'. $key .'" data-target="#carousel-catid-'. $catid .'" data-slide-to="'. $key .'">'. $pagination .'</li>';
								}
								$html .= '</ol>';
								
								$html .= '<a class="carousel-control right" href="#carousel-catid-'. $catid .'" data-slide="next" data-load="ajax"><span class="icon-caret-right"></span></a>';
							$html .= '</div>';
						$html .= '</div>';
						/* ---------- End Pagination ------------ */
						
					$html .= '</div>'; /* End Carousel */
					
				$html .= '</div>';
				/* ----------End Tab Pane--------------*/
			}
			
			$html .= '</div>'; /* End Tab Content */
		}
		$html .= '</div>';
		
		return $html;
	}
	
    public function page_init() {		
        register_setting( 'sw_tab_content_option_group', 'sw_tab_content', array( $this, 'check_ID' ) );
            
 		add_settings_section(
            'setting_section_id',
            'Setting',
            array( $this, 'print_section_info' ),
            'sw-tab-content-setting-admin'
        );	
        
       add_settings_field(
	        'catid',
	        'Categories',
	        array( $this, 'create_catid_field' ),
	        'sw-tab-content-setting-admin',
	        'setting_section_id'
  		);

       add_settings_field(
	       'count_item',
	       'Items Per Page',
	       array( $this, 'create_count_item' ),
	       'sw-tab-content-setting-admin',
	       'setting_section_id'
   		);
       
       add_settings_field(
	       'max_length',
	       'Max Description Length',
	       array( $this, 'create_max_length' ),
	       'sw-tab-content-setting-admin',
	       'setting_section_id'
    	);
       
       add_settings_field(
	       'first_tab',
	       'First Tab Display',
	       array( $this, 'create_first_tab' ),
	       'sw-tab-content-setting-admin',
	       'setting_section_id'
       	);
       
       add_settings_field(
	       'layout',
	       'Layout',
	       array( $this, 'create_layout' ),
	       'sw-tab-content-setting-admin',
	       'setting_section_id'
  		);
       
       add_settings_field(
	       'colums',
	       'Colums of Layout 2',
	       array( $this, 'create_colums' ),
	       'sw-tab-content-setting-admin',
	       'setting_section_id'
   		);     
         
       add_settings_field(
	       'width',
	       'Width',
	       array( $this, 'create_width' ),
	       'sw-tab-content-setting-admin',
	       'setting_section_id'
     	);
       add_settings_field(
	       'height',
	       'Height',
	       array( $this, 'create_height' ),
	       'sw-tab-content-setting-admin',
	       'setting_section_id'
    	);
       add_settings_field(
	       'crop',
	       'Crop',
	       array( $this, 'create_crop' ),
	       'sw-tab-content-setting-admin',
	       'setting_section_id'
   		);
       
    }
	
    public function check_ID( $input ) {
		
    	if (!isset($input['catid'])) {
    		$input['catid'] = array();
    	}
    	
    	if (!isset($input['count_item'])) {
    		$input['count_item'] = 4;
    	}
    	
    	if (!isset($input['max_length'])) {
    		$input['max_length'] = 50;
    	}
    	
    	if (!isset($input['first_tab'])) {
    		$input['first_tab'] = 2;
    	}
    	
    	if (!isset($input['layout'])) {
    		$input['layout'] = 1;
    	}

    	if (!isset($input['colums'])) {
    		$input['colums'] = 'span6';
    	}
    	
    	if (!isset($input['width'])) {
    		$input['width'] = 600;
    	}
    	
    	if (!isset($input['height'])) {
    		$input['height'] = 400;
    	}
    	
    	return $input;
    }
    
    public function print_section_info(){
    	print 'Enter your setting below:';
    }
    
    /* Render */
	public function create_catid_field() {
		$options = $this->options;
		
		if (isset($options['catid'])) {
			$ids = $options['catid'];
		} else $ids = array();
		
		$categories = get_categories();
		
		echo '<select id="sw_tab_content-catid" name="sw_tab_content[catid][]" multiple="multiple">';
			foreach ($categories as $category) {
				if (in_array($category->cat_ID, $ids)) {
					$select = ' selected="selected" ';
				} else $select = '';
				
				echo '<option value="' . $category->cat_ID . '" '. $select .'>' . $category->cat_name . '</option>';
			}
		echo '</select>';
	}
	
	public function create_count_item(){
		$option = isset($this->options['count_item']) ? $this->options['count_item'] : 5;
		
		?><input type="text" id="input_count_item" name="sw_tab_content[count_item]" value="<?php echo $option; ?>" /><?php
	}
	
	public function create_max_length(){
		$option = isset($this->options['max_length']) ? $this->options['max_length'] : 50;
	
		?><input type="text" id="input_max_length" name="sw_tab_content[max_length]" value="<?php echo $option; ?>" /><?php
	}
	
	public function create_first_tab(){
		$option = isset($this->options['first_tab']) ? $this->options['first_tab'] : '';
	
		?><input type="text" id="input_first_tab" name="sw_tab_content[first_tab]" value="<?php echo $option; ?>" /><?php
	}

	public function create_width(){
		$option = isset($this->options['width']) ? $this->options['width'] : '';
	
		?><input type="text" id="input_width" name="sw_tab_content[width]" value="<?php echo $option; ?>" /><?php
	}
	
	public function create_height(){
		$option = isset($this->options['height']) ? $this->options['height'] : '';
	
		?><input type="text" id="input_height" name="sw_tab_content[height]" value="<?php echo $option; ?>" /><?php
	}

	public function create_crop(){
		$option = isset($this->options['crop']) ? 'checked="checked"' : '';
	
		?><input type="checkbox" id="input_crop" name="sw_tab_content[crop]" <?php echo $option; ?> /><?php
	}
	
	public function create_layout(){
		$option = isset($this->options['layout']) ? $this->options['layout'] : 1;
		
		$layout = array(
			'1' => 'Default',
			'2' => 'Layout 2',
		);
		?>
		<select id="sw_tab_content-layout" name="sw_tab_content[layout]">
			<?php 
				foreach ($layout as $k => $name) {
					if ( $option== $k) {
						$selected = ' selected="selected"';
					} else 
						$selected = '';
					?>
					<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
			<?php } ?>
		</select>
	<?php 
	}

	public function create_colums(){
		$option = isset($this->options['colums']) ? $this->options['colums'] : 'span6';
	
		$layout = array(
				'span6' => '2',
				'span4' => '3',
				'span3' => '4',
				'span2' => '6',
		);
		?>
			<select id="sw_tab_content-colums" name="sw_tab_content[colums]">
				<?php 
					foreach ($layout as $k => $name) {
						if ( $option== $k) {
							$selected = ' selected="selected"';
						} else 
							$selected = '';
						?>
						<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
				<?php } ?>
			</select>
		<?php 
	}
		
	public function sw_tab_content_callback() {

		$layout     = isset($_POST['layout'])  ? intval($_POST['layout']) : 1;

		if ( $layout == 1 ) {
			require 'views/public.php';
		} else
			require 'views/layout_'. $layout .'.php';
		
		$catid = $_POST['catid'];
		$start = intval( $_POST['start'] );
		$cols = $_POST['colums'];
		$max_length = intval( $_POST['max_length'] );
		$caption = $_POST['caption'];//var_dump($caption);
		echo tab_content_html($catid, $start, $cols, $max_length, $caption);
		
		exit();
	}
	
	public function sw_resize_url($attachment_id, $instance){
	
		$file = get_attached_file($attachment_id);
	
		$img_url = wp_get_attachment_url($attachment_id);
		$header_response = get_headers($img_url, 1);
		if ( strpos( $header_response[0], "404" ) == false ){
			// we have the actual image size, but might need to further constrain it if content_width is narrower
			$name   = 'sw_resize';
			$width  = isset($instance['width']) ? $instance['width'] : 600;
			$height = isset($instance['height']) ? $instance['height'] : 400;
			$crop   = isset($instance['crop']) ? $instance['crop'] : false;
		
			$resized_file = image_make_intermediate_size( $file, $width, $height, $crop);
			$img_url_basename = wp_basename($img_url);
	
			$img_url = str_replace($img_url_basename, $resized_file['file'], $img_url);
			
		}else{
			$img_url = get_template_directory_uri().'/assets/img/placeholder/medium.png';
		}
	
		return $img_url;
	}
	
}