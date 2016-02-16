<?php
add_theme_support( 'woocommerce' );
/*


add_filter( 'woocommerce_variable_price_html', 'sw_price_html', 100, 2 );
function sw_price_html( $price, $product ){
	$variation_id = get_post_meta( get_the_id(), '_min_regular_price_variation_id', true );
	$price        = get_post_meta( $variation_id, '_regular_price', true );
	return $price;
}*/
/*remove woo breadcrumb*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/*add second thumbnail loop product*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'sw_woocommerce_template_loop_product_thumbnail', 10 );
	function sw_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $post;
		$html = '';
		$id = get_the_ID();
		$gallery = get_post_meta($id, '_product_image_gallery', true);
		$attachment_image = '';
		if(!empty($gallery)) {
			$gallery = explode(',', $gallery);
			$first_image_id = $gallery[0];
			$attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image back'));
		}
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
		if ( has_post_thumbnail() ){
			if( $attachment_image ){
				$html .= '<div class="product-thumb-hover">';
				$html .= get_the_post_thumbnail( $post->ID, $size );
				$html .= $attachment_image;
				$html .= '</div>';
			}else{
				$html .= get_the_post_thumbnail( $post->ID, $size );
			}
			return $html;
		}elseif( wc_placeholder_img_src() ){
			$html .= wc_placeholder_img( $size );
			return $html;
		}
	}
	function sw_woocommerce_template_loop_product_thumbnail(){
		echo sw_product_thumbnail();
	}
/*add price to product image*/
add_action( 'woocommerce_before_shop_loop_item_title', 'sw_woocommerce_image_price', 15 );
function sw_woocommerce_image_price(){
	wc_get_template( 'loop/price.php' );
}

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
/*
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'sw_woocommerce_template_single_excerpt', 35 );
function sw_woocommerce_template_single_excerpt() {
	wc_get_template( 'single-product/short-description.php' );
}
*/
/*filter order*/
function sw_addURLParameter($url, $paramName, $paramValue) {
     $url_data = parse_url($url);
     if(!isset($url_data["query"]))
         $url_data["query"]="";

     $params = array();
     parse_str($url_data['query'], $params);
     $params[$paramName] = $paramValue;
     $url_data['query'] = http_build_query($params);
     return sw_build_url($url_data);
}


function sw_build_url($url_data) {
 $url="";
 if(isset($url_data['host']))
 {
	 $url .= $url_data['scheme'] . '://';
	 if (isset($url_data['user'])) {
		 $url .= $url_data['user'];
			 if (isset($url_data['pass'])) {
				 $url .= ':' . $url_data['pass'];
			 }
		 $url .= '@';
	 }
	 $url .= $url_data['host'];
	 if (isset($url_data['port'])) {
		 $url .= ':' . $url_data['port'];
	 }
 }
 if (isset($url_data['path'])) {
	$url .= $url_data['path'];
 }
 if (isset($url_data['query'])) {
	 $url .= '?' . $url_data['query'];
 }
 if (isset($url_data['fragment'])) {
	 $url .= '#' . $url_data['fragment'];
 }
 return $url;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action('woocommerce_before_shop_loop', 'sw_woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_shop_loop', 'sw_woocommerce_pagination', 35);
add_action('woocommerce_after_shop_loop', 'sw_woocommerce_catalog_ordering', 5);

function sw_woocommerce_pagination() {
	wc_get_template( 'loop/pagination.php' );
}

function sw_woocommerce_catalog_ordering() {
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$query_string = '?'.$_SERVER['QUERY_STRING'];

	// replace it with theme option
	if($data['woo_items']) {
		$per_page = $data['woo_items'];
	} else {
		$per_page = 12;
	}

	$pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	$po = !empty($params['product_order'])  ? $params['product_order'] : 'asc';
	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering clearfix">';

	$html .= '<div class="orderby-order-container">';

	$html .= '<ul class="orderby order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><span class="current-li-content"><a>'.__('Sort by', 'yatheme').'</a></span></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pob == 'default') ? 'current': '').'"><a href="'.sw_addURLParameter($query_string, 'product_orderby', 'default').'">'.__('Sort by ', 'yatheme').__('Default', 'yatheme').'</a></li>';
	$html .= '<li class="'.(($pob == 'name') ? 'current': '').'"><a href="'.sw_addURLParameter($query_string, 'product_orderby', 'name').'">'.__('Sort by ', 'yatheme').__('Name', 'yatheme').'</a></li>';
	$html .= '<li class="'.(($pob == 'price') ? 'current': '').'"><a href="'.sw_addURLParameter($query_string, 'product_orderby', 'price').'">'.__('Sort by ', 'yatheme').__('Price', 'yatheme').'</a></li>';
	$html .= '<li class="'.(($pob == 'date') ? 'current': '').'"><a href="'.sw_addURLParameter($query_string, 'product_orderby', 'date').'">'.__('Sort by ', 'yatheme').__('Date', 'yatheme').'</a></li>';
	$html .= '<li class="'.(($pob == 'rating') ? 'current': '').'"><a href="'.sw_addURLParameter($query_string, 'product_orderby', 'rating').'">'.__('Sort by ', 'yatheme').__('Rating', 'yatheme').'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';

	$html .= '<ul class="sort-count order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'.__('12', 'yatheme').'</a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.sw_addURLParameter($query_string, 'product_count', $per_page).'">'.$per_page.'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.sw_addURLParameter($query_string, 'product_count', $per_page*2).'">'.($per_page*2).'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.sw_addURLParameter($query_string, 'product_count', $per_page*3).'">'.($per_page*3).'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	$html .= '</div>';
	
	$html .= '<ul class="order">';
	if($po == 'desc'):
	$html .= '<li class="desc"><a href="'.sw_addURLParameter($query_string, 'product_order', 'asc').'"><i class="icon-arrow-up"></i></a></li>';
	endif;
	if($po == 'asc'):
	$html .= '<li class="asc"><a href="'.sw_addURLParameter($query_string, 'product_order', 'desc').'"><i class="icon-arrow-down"></i></a></li>';
	endif;
	$html .= '</ul>';

	$html .= '</div>';
	
	echo $html;
}


add_action('woocommerce_get_catalog_ordering_args', 'sw_woocommerce_get_catalog_ordering_args', 20);
function sw_woocommerce_get_catalog_ordering_args($args)
{
	global $woocommerce;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	$po = !empty($params['product_order'])  ? $params['product_order'] : 'asc';

	switch($pob) {
		case 'date':
			$orderby = 'date';
			$order = 'desc';
			$meta_key = '';
		break;
		case 'price':
			$orderby = 'meta_value_num';
			$order = 'asc';
			$meta_key = '_price';
		break;
		case 'popularity':
			$orderby = 'meta_value_num';
			$order = 'desc';
			$meta_key = 'total_sales';
		break;
		case 'title':
			$orderby = 'title';
			$order = 'asc';
			$meta_key = '';
		break;
		case 'default':
		default:
			$orderby = 'menu_order title';
			$order = 'asc';
			$meta_key = '';
		break;
	}

	switch($po) {
		case 'desc':
			$order = 'desc';
		break;
		case 'asc':
			$order = 'asc';
		break;
		default:
			$order = 'asc';
		break;
	}

	$args['orderby'] = $orderby;
	$args['order'] = $order;
	$args['meta_key'] = $meta_key;

	if( $pob == 'rating' ) {
		$args['orderby']  = 'menu_order title';
		$args['order']    = $po == 'desc' ? 'desc' : 'asc';
		$args['order']	  = strtoupper( $args['order'] );
		$args['meta_key'] = '';

		add_filter( 'posts_clauses', 'sw_order_by_rating_post_clauses' );
	}

	return $args;
}
add_filter('loop_shop_per_page', 'sw_loop_shop_per_page');
function sw_loop_shop_per_page()
{
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	if($data['woo_items']) {
		$per_page = $data['woo_items'];
	} else {
		$per_page = 12;
	}

	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	return $pc;
}
/*********QUICK VIEW PRODUCT**********/

add_action("wp_ajax_sw_quickviewproduct", "sw_quickviewproduct");
add_action("wp_ajax_nopriv_sw_quickviewproduct", "sw_quickviewproduct");
function sw_quickviewproduct(){
	
	$productid = (isset($_REQUEST["post_id"]) && $_REQUEST["post_id"]>0) ? $_REQUEST["post_id"] : 0;
	
	$query_args = array(
		'post_type'	=> 'product',
		'p'			=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query($query_args);
	if($r->have_posts()){ 

		while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
			global $product;
			ob_start();
			woocommerce_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw);
	echo $output;exit();
}
?>