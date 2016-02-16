<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */
?>
<!-- This file is used to markup the public facing aspect of the plugin. -->
<?php 
	
function tab_content_html( $catid = '', $start = 0, $cols = '', $max_length = 30, $cation = true ) {
	
	$html = '';
	
	$options = get_option('sw_tab_content');
	
	$count_item = isset($options['count_item']) ? intval($options['count_item']) : 5;
	//$max_length = isset($options['max_length']) ? intval($options['max_length']) : 30;
	
	$posts = get_posts(array('category' => $catid, 'numberposts' => $count_item, 'offset' => $start*$count_item ));
	
	$html .= '<div class="item-inner">';
	
	foreach ( $posts as $post ) {
		
		$html .= '<div class="item-content">';
			$Plugin_Tab_Content = new Plugin_Tab_Content;
			$options = get_option('sw_tab_content');
			if (has_post_thumbnail($post->ID)) {
				$html .= '<div class="sw-thumb">';
				
					$attachment_id   =  get_post_thumbnail_id($post->ID);
					
					$html .= '<img alt="" src="' . $Plugin_Tab_Content->sw_resize_url($attachment_id, $options) . '">';
					
					$html .= '<div class="sw-mask"><div class="sw-mask-inner">
								<a class="sw-link sw-icon" title="'. $post->post_title .'" href="'. get_permalink($post->ID) .'"><span class="icon-link"></span></a>
								<a class="sw-search sw-icon" title="Zoom" href="'. wp_get_attachment_url($attachment_id) .'" rel="prettyPhoto[portfolio]"><span class="icon-search"></span></a></div></div>';
				$html .= '</div>';
			}
			
			$html .= '<div class="sw-content">';
				$html .= '<div class="sw-title"><h4><a href="'. get_permalink($post->ID) .'">'. $post->post_title .'</a></h4></div>';
				$html .= '<div class="sw-meta">';
					$html .= '<span class="sw-date">'. date( 'd F Y',strtotime($post->post_date)) .'</span>';
					$html .= '<div class="sw-category"><span class="icon-briefcase"></span>Category: '. get_the_category_list(', ','', $post->ID) .'</div>';
				$html .= '</div>';
				$html .= '<div class="sw-desc">';					
					
					if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
						$content = explode($matches[0], $post->post_content, 2);
						$content = $content[0];
					} else {
						$content = $Plugin_Tab_Content->sw_trim_words($post->post_content,$max_length);
					}
					
					$html .= $content;
					//$html .= '<a href="'. get_permalink($post->ID) .'"> Read more</a>';
				$html .= '</div>';

			$html .= '</div>';
			
		$html .= '</div>';
	}
	
	$html .= '</div>';
	
	return $html;
}
