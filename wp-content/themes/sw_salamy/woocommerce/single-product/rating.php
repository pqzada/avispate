<?php
/*
	single product rating
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
		<a href="#reviews" class="woocommerce-review-link" rel="nofollow"><?php printf( _n( '%s vote', '%s vote(s)', $count, 'woocommerce' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?></a>
</div>