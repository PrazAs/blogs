<?php 
	$thb_ads_header = ot_get_option('thb_ads_header'); 
	$header_boxed = (ot_get_option('header_boxed') == 'on' ? 'boxed' : '');
	$header_color = ot_get_option('header_color', 'light');
	$menu_color = ot_get_option('menu_color', 'light');
	$general_boxed = (ot_get_option('general_boxed') == 'on' ? 'boxed' : '');
?>
<!-- Start Header -->
<header class="header style1 <?php echo esc_attr($header_boxed. ' ' .$header_color); ?>" role="banner">
	<div class="row">
		<div class="small-2 columns text-left mobile-icon-holder">
			<a href="#" data-target="open-menu" class="mobile-toggle"><i class="fa fa-bars"></i></a>
		</div>
		<div class="small-8 large-4 columns logo">
			<div>
				<?php if (ot_get_option('thb_logo')) { $logo = ot_get_option('thb_logo'); } else { $logo = THB_THEME_ROOT. '/assets/img/logo.png'; } ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="logolink">
					<img src="<?php echo esc_url($logo); ?>" class="logoimg" alt="<?php bloginfo('name'); ?>"/>
				</a>
			</div>
		</div>
		<div class="small-2 columns text-right mobile-share-holder">
			<div>
			<?php do_action( 'thb_quick_search' ); ?>
			</div>
		</div>
		<div class="small-12 large-8 columns thb-a">
			<?php if ($thb_ads_header) { echo do_shortcode($thb_ads_header); } ?>
		</div>
	</div>
</header>
<!-- End Header -->
<div id="navholder" class="<?php echo esc_attr($menu_color.'-menu'); ?> <?php echo esc_attr($general_boxed); ?>">
	<div class="row">
		<div class="small-12 columns">
			<nav class="menu-holder style1 <?php echo esc_attr($menu_color); ?>" id="menu_width">
				<?php if (has_nav_menu('nav-menu')) { ?>
				  <?php wp_nav_menu( array( 'theme_location' => 'nav-menu', 'depth' => 3, 'container' => false, 'menu_class' => 'sf-menu style1', 'walker' => new thb_MegaMenu_tagandcat_Walker  ) ); ?>
				<?php } else if ( current_user_can( 'edit_theme_options' ) ) { ?>
				    <ul class="sf-menu style1">
				        <li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php esc_html_e( 'Please assign a menu', 'goodlife' ); ?></a></li>
				    </ul>
				<?php } ?>
				<?php if (has_nav_menu('secondary-menu')) { ?>
					<div class="secondary-holder">
						<a href="#" title="<?php echo esc_attr('Secondary Menu', 'goodlife'); ?>" class="secondary-toggle"><i class="fa fa-bars"></i></a>
						<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'depth' => 2, 'container' => false, 'menu_class' => 'sf-menu style1 secondary'  ) ); ?>
					</div>
				<?php } ?>
			</nav>
		</div>
	</div>
</div>