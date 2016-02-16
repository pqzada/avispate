<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */
?>

<div class="wrap">
    <?php screen_icon(); ?>
    <h2>Tab Content</h2>			
    <form method="post" action="options.php">
        <?php
			// This prints out all hidden setting fields
		    settings_fields( 'sw_tab_content_option_group' );	
		    do_settings_sections( 'sw-tab-content-setting-admin' );
		?>
        <?php submit_button(); ?>
    </form>
</div>