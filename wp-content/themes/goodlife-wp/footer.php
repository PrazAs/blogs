<?php 
	$footer = ot_get_option('footer');
	$footer_columns = ot_get_option('footer_columns', 'threecolumns');
	$footer_color = ot_get_option('footer_color', 'dark');
	$footer_boxed = (ot_get_option('footer_boxed') == 'on' ? 'boxed' : '');

	$subfooter = ot_get_option('subfooter');
	$subfooter_boxed = (ot_get_option('subfooter_boxed') == 'on' ? 'boxed' : '');
	$subfooter_color = ot_get_option('subfooter_color', 'light');
	$subfooter_logo_switch = ot_get_option('subfooter_logo_switch');
	$subfooter_logo = ot_get_option('subfooter_logo');
?>
		</div><!-- End role["main"] -->
			
			<?php if ($footer != 'off') { ?>
			<!-- Start Footer -->
			<footer id="footer" role="contentinfo" class="<?php echo esc_attr($footer_color.' '.$footer_boxed); ?>">
			  	<div class="row">
			  		<?php if ($footer_columns == 'fourcolumns') { ?>
				    <div class="small-12 medium-6 large-3 columns">
				    	<?php dynamic_sidebar('footer1'); ?>
				    </div>
				    <div class="small-12 medium-6 large-3 columns">
				    	<?php dynamic_sidebar('footer2'); ?>
				    </div>
				    <div class="small-12 medium-6 large-3 columns">
					    <?php dynamic_sidebar('footer3'); ?>
				    </div>
				    <div class="small-12 medium-6 large-3 columns">
					    <?php dynamic_sidebar('footer4'); ?>
				    </div>
				    <?php } elseif ($footer_columns == 'threecolumns') { ?>
				    <div class="small-12 medium-4 large-4 columns">
				    	<?php dynamic_sidebar('footer1'); ?>
				    </div>
				    <div class="small-12 medium-4 large-4 columns">
				    	<?php dynamic_sidebar('footer2'); ?>
				    </div>
				    <div class="small-12 medium-4 large-4 columns">
				        <?php dynamic_sidebar('footer3'); ?>
				    </div>
				    <?php } elseif ($footer_columns == 'twocolumns') { ?>
				    <div class="small-12 medium-6 large-6 columns">
				    	<?php dynamic_sidebar('footer1'); ?>
				    </div>
				    <div class="small-12 medium-6 large-6 columns">
				    	<?php dynamic_sidebar('footer2'); ?>
				    </div>
				    <?php } elseif ($footer_columns == 'doubleleft') { ?>
				    <div class="small-12 medium-4 large-6 columns">
				    	<?php dynamic_sidebar('footer1'); ?>
				    </div>
				    <div class="small-12 medium-4 large-3 columns">
				    	<?php dynamic_sidebar('footer2'); ?>
				    </div>
				    <div class="small-12 medium-4 large-3 columns">
				        <?php dynamic_sidebar('footer3'); ?>
				    </div>
				    <?php } elseif ($footer_columns == 'doubleright') { ?>
				    <div class="small-12 medium-4 large-3 columns">
				    	<?php dynamic_sidebar('footer1'); ?>
				    </div>
				    <div class="small-12 medium-4 large-3 columns">
				    	<?php dynamic_sidebar('footer2'); ?>
				    </div>
				    <div class="small-12 medium-4 large-6 columns">
				        <?php dynamic_sidebar('footer3'); ?>
				    </div>
				    <?php } elseif ($footer_columns == 'fivecolumns') { ?>
				    <div class="small-12 medium-6 large-2 columns">
				    	<?php dynamic_sidebar('footer1'); ?>
				    </div>
				    <div class="small-12 medium-6 large-3 columns">
				    	<?php dynamic_sidebar('footer2'); ?>
				    </div>
				    <div class="small-12 medium-6 large-2 columns">
				    	<?php dynamic_sidebar('footer3'); ?>
				    </div>
				    <div class="small-12 medium-6 large-3 columns">
				    	<?php dynamic_sidebar('footer4'); ?>
				    </div>
				    <div class="small-12 large-2 columns">
				    	<?php dynamic_sidebar('footer5'); ?>
				    </div>
				    <?php } elseif ($footer_columns == 'onecolumns') { ?>
				    <div class="small-12columns">
				    	<?php dynamic_sidebar('footer1'); ?>
				    </div>
				    <?php } ?>
			    </div>
			</footer>
			<!-- End Footer -->
			<?php } ?>
			<?php if ($subfooter != 'off') { ?>
			<!-- Start Sub Footer -->
			<footer id="subfooter" role="contentinfo" class="<?php echo esc_attr($subfooter_color. ' ' .$subfooter_boxed); ?>">
				<div class="row">
					<div class="small-12 columns">
						<div class="subfooter-menu-holder text-center">
							<?php if ($subfooter_logo_switch == 'on') { ?>
								<a href="<?php echo esc_url(home_url('/')); ?>" class="logolink">
									<img src="<?php echo esc_url($subfooter_logo); ?>" class="logoimg" alt="<?php bloginfo('name'); ?>"/>
								</a>
							<?php } ?>
							<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'depth' => 1, 'container' => 'div', 'container_class' => 'subfooter-menu', 'menu_class' => 'footer-menu' ) ); ?>
	
							<p><?php echo esc_html(ot_get_option('copyright','Copyright 2015 Fuel Themes. All RIGHTS RESERVED.')); ?> </p>
						</div>
					</div>
				</div>
			</footer>
			<!-- End Sub Footer -->
			<?php } ?>
	</section> <!-- End #content-container -->

</div> <!-- End #wrapper -->
<?php if (ot_get_option('scroll_totop') != 'off') { ?>
	<a href="#" id="scroll_totop"><i class="fa fa-angle-up"></i></a>
<?php } ?>

<?php 
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	 wp_footer(); 
?>
</body>
</html>