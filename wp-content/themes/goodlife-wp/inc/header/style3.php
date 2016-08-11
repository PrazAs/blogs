<?php 
	$header_boxed = (ot_get_option('header_boxed') == 'on' ? 'boxed' : '');
	$header_color = ot_get_option('header_color', 'light');
?>
<!-- Start Header -->
<header class="header style3 <?php echo esc_attr($header_boxed. ' ' .$header_color); ?>" role="banner">
	<div class="row">
		<div class="small-2 columns text-left mobile-icon-holder">
			<a href="#" data-target="open-menu" class="mobile-toggle"><i class="fa fa-bars"></i></a>
		</div>
		<div class="small-8 large-12 columns logo">
			<div id="menu_width">
				<?php if (ot_get_option('thb_logo')) { $logo = ot_get_option('thb_logo'); } else { $logo = THB_THEME_ROOT. '/assets/img/logo.png'; } ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="logolink">
					<img src="<?php echo esc_url($logo); ?>" class="logoimg" alt="<?php bloginfo('name'); ?>"/>
				</a>
				<nav class="menu-holder">
					<?php if (has_nav_menu('nav-menu')) { ?>
					  <?php wp_nav_menu( array( 'theme_location' => 'nav-menu', 'depth' => 3, 'container' => false, 'menu_class' => 'sf-menu style3', 'walker' => new thb_MegaMenu_tagandcat_Walker ) ); ?>
					<?php } else if ( current_user_can( 'edit_theme_options' ) ) { ?>
					    <ul class="sf-menu style3">
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
		<div class="small-2 columns text-right mobile-share-holder">
			<div>
			<?php do_action( 'thb_quick_search' ); ?>
			</div>
		</div>
	</div>
</header>
<!-- End Header -->