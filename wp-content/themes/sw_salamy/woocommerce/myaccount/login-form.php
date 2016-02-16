<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<div class="login-form">
	<form action="<?php echo get_permalink( woocommerce_get_page_id( 'myaccount' ) ); ?>" method="post" class="login">
		<div class="input-group">
			<span class="input-group-addon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-user.png" alt="user"/></span>
			<input type="text" class="form-control input-text username" name="username" id="username" placeholder="Username" />
		</div>
		<div class="input-group">
			<span class="input-group-addon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-key.png" alt="password"/></span>
			<input class="form-control input-text password" type="password" placeholder="Password" name="password" id="password" />
		</div>
		<div class="clear"></div>
		<p class="form-row">
			<label for="rememberme">
				<input id="rememberme" type="checkbox" value="forever" name="rememberme">
                <?php _e('Remember me?', 'yatheme'); ?>
			</label>
		</p>
		<p class="form-row">
			<?php wp_nonce_field( 'woocommerce-login' ); ?>
			<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />
		</p>
	</form>
</div>
<div class="clear"></div>
<p class="lost_password">
	<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Forgot your password?', 'woocommerce' ); ?></a>
	<a href="#"><?php _e( 'Sign up for a free account', 'woocommerce' ); ?></a>
</p>
	
<?php do_action('woocommerce_after_cphone-icon-login ustomer_login_form'); ?>