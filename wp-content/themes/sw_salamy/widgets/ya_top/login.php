<div class="ya-login">
	<div class="row">
		<?php if ( ! is_user_logged_in() ) {  ?> 
		<div class="welcom-mes col-lg-8 col-md-7 col-sm-6">
			<span><?php _e('Welcome Msg', 'yatheme'); ?></span>
		</div>
		<div class="col-lg-4 col-md-5 col-sm-6">
			<div class="top-form top-form-account">
				<a href="<?php echo get_permalink( woocommerce_get_page_id( 'myaccount' ) ); ?>"> <?php _e('My Account', 'yatheme'); ?> </a>
			</div>
			<div class="top-form top-form-login" id="login-<?php echo $widget_id; ?>">
				<div class="top-form-content">
					<div class="top-login">
						<a href="javascript:void(0);"><span><?php _e('Login', 'yatheme'); ?> </span></a>
					</div>
					<div class="login-content">
					<div class="padding-login-content">
						<?php get_template_part('woocommerce/myaccount/login-form'); ?>
					</div>
					</div>
				</div>
			</div> 
			<div class="top-form top-form-register">
				<div class="top-form-content">
					<div class="top-register">
						<a href="javascript:void(0);"><span><?php _e('Register', 'yatheme'); ?> </span></a>
					</div>
					<div class="register-content">
						<?php get_template_part('woocommerce/myaccount/register-form'); ?>
					</div>
				</div>
			</div>
			<div class="top-form top-form-checkout">
				<a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Checkout', 'yatheme'); ?></a>
			</div>
		</div>
		<?php } else{?>
		<div class="top-form top-form-logined col-lg-12 col-md-12 col-sm-12">
			<?php 
				$user_id = get_current_user_id();
				$user_info = get_userdata( $user_id );	
			?>
			<?php _e('Welcome ', 'yatheme'); ?> <?php echo $user_info-> user_nicename;  ?>
			<a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>"><?php _e('Check Out', 'yatheme'); ?></a>
			<a href="<?php echo get_permalink( woocommerce_get_page_id( 'myaccount' ) ); ?>"> <?php _e('My account', 'yatheme'); ?>  </a>
			<a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout"><?php _e('Logout', 'yatheme'); ?></a
		</div>
		<?php } ?>
	</div>
</div>