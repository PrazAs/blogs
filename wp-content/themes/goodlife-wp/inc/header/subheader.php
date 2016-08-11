<?php 
	$subheader = ot_get_option('subheader');
	$subheader_grid = ot_get_option('subheader_grid');
	$subheader_color = ot_get_option('subheader_color', 'light');
	$subheader_search = ot_get_option('subheader_search');
	$subheader_boxed = (ot_get_option('subheader_boxed') == 'on' ? 'boxed' : '');
?>
<?php if ($subheader != 'off') { ?>
<!-- Start Sub Header -->
<div class="subheader show-for-large-up <?php echo esc_attr($subheader_color. ' ' .$subheader_boxed); ?>">
	<div class="row<?php if ($subheader_grid == 'on') { ?> full-width-row<?php } ?>">
		<div class="small-12 medium-6 large-7 columns">
			<nav class="subheader-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'subheader-menu', 'depth' => 2, 'menu_class' => 'sf-menu', 'container' => false ) ); ?>
			</nav>
		</div>
		<div class="small-12 medium-6 large-5 columns text-right">
			<ul class="sf-menu right-menu">
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
</div>
<!-- End Sub Header -->
<?php } ?>