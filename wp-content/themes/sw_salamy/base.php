<?php get_template_part('templates/head'); ?>
<?php $box_layout = ya_options()->getCpanelValue('box_layout'); ?>
<body <?php body_class(); ?>>
	<div class="body-wrapper<?php echo ( $box_layout == 'box' )? ' box-layout' : '';?>">

	<?php if(!is_404()):?>
		<?php do_action('get_header'); ?>
			<?php get_template_part('templates/header'); ?>

			<section id="main" role="document">
				<?php
					if (!is_front_page() ) {
						if (function_exists('ya_breadcrumb')){
							ya_breadcrumb('<div class="breadcrumbs"><div class="container">', '</div></div>');
						} 
					}
				?>
				<div class="container">
					<?php if (is_active_sidebar_YA('above-main')) { ?>
						<div class="sidebar-above-main">
							<div class="row">
								<?php dynamic_sidebar('above-main'); ?>
							</div>
						</div>
					<?php } ?>
					<div class="row">
						<?php 
						if ($left_sidebars = ya_sidebar_left())
							foreach ($left_sidebars as $sidebar)
								get_template_part('templates/sidebar', $sidebar);
						?>
						
						<section id="contents" <?php ya_content_class(); ?> role="main">
						
							<?php if (is_active_sidebar_YA('above')) { ?>
								<div class="sidebar-above">
									<?php dynamic_sidebar('above'); ?>
								</div>
							<?php } ?>
							
							<?php include ya_template_path(); ?>
							
							<?php if (is_active_sidebar_YA('below')) { ?>
								<div class="sidebar-below">
									<?php dynamic_sidebar('below'); ?>
								</div>
							<?php } ?>
							
						</section>
						
						<?php
						if ($right_sidebars = ya_sidebar_right())
							foreach ($right_sidebars as $sidebar)
							get_template_part('templates/sidebar', $sidebar);
						?>
					</div>
					<?php if (is_active_sidebar_YA('below-main')) { ?>
						<div class="sidebar-below-main">
							<div class="row">
								<?php dynamic_sidebar('below-main'); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</section>
			<?php get_template_part('templates/footer'); ?>
			
		<?php if (is_active_sidebar_YA('floating') ){ ?>
			<div class="floating">
				<?php dynamic_sidebar('floating');  ?>
			</div>
		<?php } ?>
		<?php wp_footer(); ?>
		<?php else :?>
		<?php get_template_part('404');?>
		<?php endif;?>
	
	</div>
</body>
</html>