<style>.wpvq-wpvq_notice_addons_1{display:none;}</style>
<div class="wrap">
	<h2>
		WP Viral Quiz - 
		<strong><?php _e("Awesome Addons", 'wpvq'); ?></strong>
	</h2>

	<hr />

	<div class="vq-medium">
		<p>
			<?php _e("You can get awesome addons for WP Viral Quiz, and add new features to your site. If you need support, <a href=\"https://www.ohmyquiz.io/support/\" target=\"_blank\">contact us</a>.", 'wpvq'); ?>
		</p>
	</div>

	<?php if (wpvq_get_licence() == ''): ?>
		<div class="vq-medium">
			<div class="wpvq-need-licence">
				<p>
					<?php _e("You need to <strong>put a valid Envato Purchase Code</strong> on the WP Viral Quiz settings page to access the awesome addons page.", 'wpvq'); ?>
				</p>
				<p>
					<a href="<?php echo admin_url( 'admin.php?page=wp-viral-quiz-settings'); ?>#update">
						<button class="button button-primary">Put your Envato Purchase Code</button>
					</a>
				</p>
			</div>
		</div>		
	<?php else: ?>
		<div class="vq-medium">
			<div class="wpvq-addon-block">
				<h3><?php _e("WP Viral Quiz - Analytics", 'wpvq'); ?></h3>
				<div class="vq-content">
					<p style="text-align: center;">
						<img src="http://wpvq.institut-pandore.com/official-resources/addons/analytics-banner.jpg" alt="Analytics Addon" />
					</p>
					<p>
						<strong><?php _e("Track players on your site like a boss, with Google Analytics.", 'wpvq'); ?></strong>
					</p>
					<p>
						<?php _e("See how many people play your quizzes, how many time they spend on your site, what do they do after a quiz, how many people shares on social media, etc.", 'wpvq'); ?>
					</p>
					<p>
						<?php _e("Use each awesome features of Google Analytics to track your players.", 'wpvq'); ?>
					</p>
					<hr />
					<p class="vq-status">
						<?php if (wpvq_is_addon_active('wp-viral-quiz-analytics')): ?>
							<span style="color:green;display:block;margin-bottom:10px;"><span class="wpvq-led-green"></span> <?php _e("The plugin is enabled on your blog.", 'wpvq'); ?></span>

							<?php $url = esc_url(add_query_arg(array('page' => 'wp-viral-quiz', 'element' => 'analytics'))); ?>
							<a href="<?php echo $url; ?>">
								<button class="button button-primary"><span class="dashicons dashicons-migrate" style="margin-top:4px;"></span> <strong><?php _e("Configure the plugin", 'wpvq'); ?></strong></button>
							</a>
						<?php else: ?>
							<?php if (wpvq_is_addon_installed('wp-viral-quiz-analytics')): ?>
								<div style="margin:0px; padding:0px;">
									<?php _e("Ho, it seems the plugin is installed on your blog <strong>but it's not enabled</strong>.", 'wpvq'); ?><br />
									<a href="plugins.php" target="_blank">
										<button class="button button-primary button-green"><span class="dashicons dashicons-yes" style="margin-top:4px;"></span> <strong><?php _e("Enable the plugin", 'wpvq'); ?></strong></button>
									</a>
								</div>
							<?php else: ?>
								<div style="margin:0px; padding:0px;">
									<p class="wpvq-paytweet-bloc">
										<span class="wpvq-price">
											<strong><?php _e("Price :", 'wpvq'); ?></strong> <?php _e("free, pay with a tweet", 'wpvq'); ?>.
										</span>
										<br />
										<a href="https://twitter.com/intent/tweet?url=http://codecanyon.net/item/wordpress-viral-quiz-buzzfeed-quiz-builder/11178623&text=I%20really%20love%20my%20Wordpress%20Quiz%20Plugin%20!%20Try%20it,%20it%27s%20awesome%20%3A%20" class="wpvq-pay-tweet">
											<img src="<?php echo plugins_url( 'img/pay-with-a-tweet-blue.png', __FILE__ ); ?>" alt="Pay with a tweet button" />
										</a>
									</p>
									<div class="wpvq-download-button">
										<p>
											<?php _e("Thank you so much ! <3", 'wpvq'); ?>
										</p>
										<p>
											<a href="http://wpvq.institut-pandore.com/update-analytics.php?action=get&url=<?php echo get_site_url(); ?>&secret=<?php echo wpvq_get_licence(); ?>" target="_blank">
												<button class="button button-primary"><span class="dashicons dashicons-migrate" style="margin-top:4px;"></span> <strong><?php _e("Download the plugin", 'wpvq'); ?></strong></button>
											</a>
										</p>
										<p style="color:blue;font-weight:bold;">
											<?php _e("Once you have downloaded the file, install it like any other plugin <strong>and come back here</strong>.", 'wpvq'); ?>
										</p>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>

		<?php if (true): ?>
		<div class="vq-medium" style="margin-top:18px;">
			<div class="wpvq-addon-block">
				<h3><?php _e("WP Viral Quiz - Save Answers", 'wpvq'); ?></h3>
				<div class="vq-content">
					<p style="text-align: center;">
						<img src="http://wpvq.institut-pandore.com/official-resources/addons/save-answers-banner.jpg" alt="Save Answers Addon" />
					</p>
					<p>
						<strong><?php _e("Save answers of each player when they end a quiz.", 'wpvq'); ?></strong>
					</p>
					<p>
						<?php _e("Learn more things about your players, by saving all their answers.", 'wpvq'); ?>
					</p>
					<hr />
					<p class="vq-status">
						<?php if (wpvq_is_addon_active('wp-viral-quiz-save-answers')): ?>
							<span style="color:green;display:block;margin-bottom:10px;"><span class="wpvq-led-green"></span> <?php _e("The plugin is enabled on your blog.", 'wpvq'); ?></span>

							<?php $url = esc_url(add_query_arg(array('page' => 'wp-viral-quiz', 'element' => 'save-answers'))); ?>
							<a href="<?php echo $url; ?>">
								<button class="button button-primary"><span class="dashicons dashicons-migrate" style="margin-top:4px;"></span> <strong><?php _e("Configure the plugin", 'wpvq'); ?></strong></button>
							</a>
						<?php else: ?>
							<?php if (wpvq_is_addon_installed('wp-viral-quiz-save-answers')): ?>
								<div style="margin:0px; padding:0px;">
									<?php _e("Ho, it seems the plugin is installed on your blog <strong>but it's not enabled</strong>.", 'wpvq'); ?><br />
									<a href="plugins.php" target="_blank">
										<button class="button button-primary button-green"><span class="dashicons dashicons-yes" style="margin-top:4px;"></span> <strong><?php _e("Enable the plugin", 'wpvq'); ?></strong></button>
									</a>
								</div>
							<?php else: ?>
								<div style="margin:0px; padding:0px;">
									<p class="wpvq-paytweet-bloc">
										<span class="wpvq-price">
											<strong><?php _e("Price :", 'wpvq'); ?></strong> <?php _e("free", 'wpvq'); ?>.
										</span>
									</p>
									<div class="wpvq-download-button" style="display:block;">
										<p>
											<a href="http://wpvq.institut-pandore.com/update-save-answers.php?action=get&url=<?php echo get_site_url(); ?>&secret=<?php echo wpvq_get_licence(); ?>" target="_blank">
												<button class="button button-primary"><span class="dashicons dashicons-migrate" style="margin-top:4px;"></span> <strong><?php _e("Download the plugin", 'wpvq'); ?></strong></button>
											</a>
										</p>
										<p style="color:blue;font-weight:bold;">
											<?php _e("Once you have downloaded the file, install it like any other plugin <strong>and come back here</strong>.", 'wpvq'); ?>
										</p>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
		<?php endif ?>
	<?php endif; ?>
</div>


<script>     
	//Twitter Widgets JS
	window.twttr = (function (d,s,id) {
	 var t, js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
	js.src="https://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
	return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
	}(document, "script", "twitter-wjs"));

	//Once twttr is ready, bind a callback function to the tweet event
	twttr.ready(function(twttr) {       
	    twttr.events.bind('tweet', function (event) {
	        jQuery('.wpvq-download-button').show();
	        jQuery('.wpvq-paytweet-bloc').hide();
	    });
	});
</script>