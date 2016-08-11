<?php 
	$fixed_header = ot_get_option('header_fixed');
	$subheader_search = ot_get_option('subheader_search');
	$subheader_color = ot_get_option('subheader_color', 'light');
?>
<?php if ($fixed_header !== 'off') { ?>
<!-- Start Fixed Header -->
<div class="subheader fixed show-for-large-up <?php echo esc_attr($subheader_color); ?>">
	<?php if (is_single()) { ?>
		<div class="row full-width-row">
			<div class="medium-8 columns logo">
				<div>
					<?php if (ot_get_option('fixedlogo')) { $logo = ot_get_option('fixedlogo'); } else { $logo = THB_THEME_ROOT. '/assets/img/fixedlogo.png'; } ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="logolink">
						<img src="<?php echo esc_url($logo); ?>" class="logoimg" alt="<?php bloginfo('name'); ?>"/>
					</a>
					<span class="page-title" id="page-title"><?php the_title(); ?></span>
				</div>
			</div>
			<div class="medium-4 columns">
				<?php do_action('thb_social_article_detail_vertical', false, false); ?>
			</div>
			<?php if(ot_get_option('reading_indicator', 'on') !== 'off') { ?>
				<span class="progress"></span>
			<?php } ?>
		</div>
		
	<?php } else { ?>
		<div class="row full-width-row">
			<div class="small-12 large-3 columns logo small-only-text-center">
				<div>
				<?php if (ot_get_option('fixedlogo')) { $logo = ot_get_option('fixedlogo'); } else { $logo = THB_THEME_ROOT. '/assets/img/fixedlogo.png'; } ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="logolink">
					<img src="<?php echo esc_url($logo); ?>" class="logoimg" alt="<?php bloginfo('name'); ?>"/>
				</a>
				</div>
			</div>
			<div class="large-6 columns text-center">
				<nav class="menu-holder">
					<?php if (has_nav_menu('nav-menu')) { ?>
					  <?php wp_nav_menu( array( 'theme_location' => 'nav-menu', 'depth' => 3, 'container' => false, 'menu_class' => 'sf-menu', 'walker' => new thb_MegaMenu_tagandcat_Walker ) ); ?>
					<?php } else if ( current_user_can( 'edit_theme_options' ) ) { ?>
					    <ul class="sf-menu">
					        <li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php esc_html_e( 'Please assign a menu', 'goodlife' ); ?></a></li>
					    </ul>
					<?php } ?>
				</nav>
			</div>
			<div class="large-3 columns">
				<ul class="sf-menu right-menu text-right">
				<?php do_action( 'thb_social_header' ); ?>
					<?php if (ot_get_option('subheader_ls') == 'on') { do_action( 'thb_language_switcher' ); } ?>
					<?php if ($subheader_search != 'off') {
						echo '<li>';
							do_action( 'thb_quick_search' );
						echo  '</li>'; } 
					?>
				</ul>
			</div>
		</div>
	<?php } ?>
</div>
<!-- End Fixed Header -->
<?php } ?>