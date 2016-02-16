<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
	return;
global $product, $post, $wpdb, $average;
$count = $wpdb->get_var("
	SELECT COUNT(meta_value) FROM $wpdb->commentmeta
	LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
	WHERE meta_key = 'rating'
	AND comment_post_ID = $post->ID
	AND comment_approved = '1'
	AND meta_value > 0
");

$rating = $wpdb->get_var("
	SELECT SUM(meta_value) FROM $wpdb->commentmeta
	LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
	WHERE meta_key = 'rating'
	AND comment_post_ID = $post->ID
	AND comment_approved = '1'
");
?>
<div class="reviews-content">
	<?php
		if( $count > 0 ){
			$average = number_format($rating / $count, 1);
	?>
		<div class="star"><span style="width: <?php echo ($average*12).'px'; ?>"></span></div>
		
	<?php } else { ?>
	
		<div class="star"></div>
		
	<?php } ?>
		<div class="review">
			<span><?php echo $count; ?> review(s) </span>
<!--			<a href="--><?php //the_permalink(); ?><!--"> Add Review</a>-->
		</div>
</div>