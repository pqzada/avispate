<?php 
	$colorset = ya_options()->getCpanelValue('scheme');
?>
<header id="header" role="banner" class="header">
    <div class="header-msg">
        <div class="container">
        <?php if (is_active_sidebar_YA('top')) {?>
            <div id="sidebar-top" class="sidebar-top">
                <?php dynamic_sidebar('top'); ?>
            </div>
        <?php }?>
        </div>
    </div>
	<div class="container">
		<div class="top-header">
			<div class="ya-logo pull-left">
				<a  href="<?php echo home_url() ?>">
						<?php if(ya_options()->getCpanelValue('sitelogo')){ ?>
							<img src="<?php echo ya_options()->getCpanelValue('sitelogo'); ?>" alt="<?php bloginfo('name'); ?>"/>
						<?php }else{
							if ($colorset){$logo = get_template_directory_uri().'/assets/img/logo-'.$colorset.'.png';}
							else $logo = get_template_directory_uri().'/assets/img/logo-default.png';
						?>
							<img src="<?php echo $logo ?>" alt="<?php bloginfo('name'); ?>"/>
						<?php } ?>
				</a>
			</div>
			<?php if (is_active_sidebar_YA('top-header')) {?>
				<div id="sidebar-top-header" class="sidebar-top-header">
						<?php dynamic_sidebar('top-header'); ?>
				</div>
			<?php }?>
		</div>
	</div>
</header>
<?php if ( has_nav_menu('primary_menu') ) {?>
	<!-- Primary navbar -->
<section id="main-menu" class="main-menu">
	<nav id="primary-menu" class="primary-menu" role="navigation">
		<div class="container">
			<div class="mid-header clearfix">
				<a href="#" class="phone-icon-menu"></a>
				<div class="navbar-inner navbar-inverse">
						<?php
							$menu_class = 'nav navbar-nav nav-pills';
							if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
								$menu_class .= ' nav-mega';
							} else $menu_class .= ' nav-css';
						?>
						<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $menu_class)); ?>
				</div>
				<?php if (is_active_sidebar_YA('top-menu')) {?>
					<div id="sidebar-top-menu" class="sidebar-top-menu">
							<?php dynamic_sidebar('top-menu'); ?>
					</div>
				<?php }?>
			</div>
		</div>
	</nav>
</section>
	<!-- /Primary navbar -->
<?php } ?>
<?php if ( is_active_sidebar_YA('banner') ): ?>
<div class="banner" id="banner">
	<div class="container">
		<?php dynamic_sidebar('banner'); ?>
	</div>
</div>
<?php endif; ?>

