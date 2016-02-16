<footer class="footer" role="contentinfo">
	<div class="container">
		<div class="row">
		<?php if (is_active_sidebar_YA('footer1') || is_active_sidebar_YA('footer')): ?>
			<?php if (is_active_sidebar_YA('footer1')){ ?>
				<div class="col-lg-5 col-md-5 col-sm-5 sidebar-footer-left">
					<?php dynamic_sidebar('footer1'); ?>
				</div>
			<?php } if (is_active_sidebar_YA('footer')){ ?>
				<div class="col-lg-7 col-md-7 col-sm-7 sidebar-footer-right">
					<div class="row">
						<?php dynamic_sidebar('footer'); ?>
					</div>
				</div>
			<?php } ?>
		<?php endif; ?>
		</div>
	</div>
</footer>
<?php if(ya_options()->getCpanelValue('back_active') == '1') { ?>
<a id="ya-totop" href="#" ></a>
<?php }?>
<?php 
	$check_popup 	= ya_options()-> getCpanelValue( 'popup_active' ); 
	$popup_content 	= ya_options()-> getCpanelValue( 'popup_content' ); 
	if( $check_popup == 1 ){
?>
<style type="text/css">
    .fancybox-custom .fancybox-skin {
        box-shadow: 0 0 50px #222;
    }
.box-newsletter{display: none;}

</style>
<script type="text/javascript">

	jQuery(document).ready(function() {

		var check_cookie = jQuery.cookie('newsletter_popup');
		if(check_cookie == null || check_cookie == 'shown') {
			 popupNewsletter();
		 }
		jQuery('#box-newsletter input#popup_check').on('click', function(){
			if(jQuery(this).parent().find('input:checked').length){        
				var check_cookie = jQuery.cookie('newsletter_popup');
			   if(check_cookie == null || check_cookie == 'shown') {
					jQuery.cookie('newsletter_popup','dontshowitagain');            
				}
				else
				{
					jQuery.cookie('newsletter_popup','shown');
					popupNewsletter();
				}
			} else {
				jQuery.cookie('newsletter_popup','shown');
			}
		}); 
	});

	function popupNewsletter() {
		jQuery.fancybox({
			'padding': '0px',
			'type': 'inline',
			'href': '#box-newsletter'
		});
		jQuery('#box-newsletter').trigger('click');
		jQuery('#box-newsletter').parents('#fancybox-wrap').addClass('popup-fancy');
	};
	 
</script>
<div class="box-newsletter" id="box-newsletter">
    <?php echo do_shortcode($popup_content); ?>
</div>
<?php } ?>