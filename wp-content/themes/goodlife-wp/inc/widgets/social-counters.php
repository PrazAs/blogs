<?php
// thb Social counter
class widget_socialcounter extends WP_Widget { 

	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_socialcounter',
			'description' => esc_html__('Display a Social Counter','goodlife')
		);
		
		parent::__construct(
			'thb_socialcounter_widget',
			esc_html__( 'Fuel Themes - Social Counter' , 'goodlife' ),
			$widget_ops
		);
				
		$this->defaults = array( 'title' => 'Follow Us', 'style' => 'style1' );
	}
	
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title'] );
		$twitter = $instance['Twitter'];
		$facebook = $instance['Facebook'];
		$instagram = $instance['Instagram'];
		$google = $instance['Google'];
		$youtube = isset($instance['Youtube']) ? $instance['Youtube'] : false;
		$vimeo = isset($instance['Vimeo']) ? $instance['Vimeo'] : false;
		$style = isset($instance['style']) ? $instance['style'] : 'style1';
		$debug = isset($instance['Debug']) ? $instance['Debug'] : false;
		// Output
		echo $before_widget;
		echo ($title ? $before_title . $title . $after_title : '');
		?>
		
			<ul class="<?php echo esc_attr($style); ?>">
				<?php if ($facebook) { ?>
				<li><a href="http://facebook.com/<?php echo ot_get_option('facebook_page_username'); ?>" class="facebook" target="_blank"><i class="fa fa-facebook"></i> <?php do_action('thb_fbLikeCount', ot_get_option('facebook_page_id'), $debug); ?> <em><?php _e('Likes', 'goodlife'); ?></em> <span><?php _e('LIKE', 'goodlife'); ?></span></a></li>
				<?php } ?>
				<?php if ($twitter) { ?>
				<li><a href="http://twitter.com/<?php echo ot_get_option('twitter_bar_username'); ?>" class="twitter" target="_blank"><i class="fa fa-twitter"></i> <?php do_action('thb_twFollowerCount', $debug); ?> <em><?php _e('Followers', 'goodlife'); ?></em> <span><?php _e('FOLLOW', 'goodlife'); ?></span></a></li>
				<?php } ?>
				<?php if ($instagram) { ?>
				<li><a href="http://instagram.com/<?php echo ot_get_option('instagram_username'); ?>" class="instagram" target="_blank"><i class="fa fa-instagram"></i> <?php do_action('thb_insFollowerCount'); ?> <em><?php _e('Followers', 'goodlife'); ?></em> <span><?php _e('FOLLOW', 'goodlife'); ?></span></a></li>
				<?php } ?>
				<?php if ($google) { ?>
				<li><a href="https://plus.google.com/<?php echo ot_get_option('gp_username'); ?>" class="google-plus" target="_blank"><i class="fa fa-google-plus"></i> <?php do_action('thb_gpFollowerCount', $debug); ?> <em><?php _e('Fans', 'goodlife'); ?></em> <span><?php _e('LIKE', 'goodlife'); ?></span></a></li>
				<?php } ?>
				<?php if ($youtube) { ?>
				<?php 
					$type = ot_get_option('yt_type'); 
				  $type = ($type == 'username' ? 'user' : $type);
				?>
				<li><a href="https://youtube.com/<?php echo esc_attr($type); ?>/<?php echo ot_get_option('yt_id'); ?>" class="youtube" target="_blank"><i class="fa fa-youtube"></i> <?php do_action('thb_ytLikeCount'); ?> <em><?php _e('Subscribers', 'goodlife'); ?></em> <span><?php _e('SUBSCRIBE', 'goodlife'); ?></span></a></li>
				<?php } ?>
				<?php if ($vimeo) { ?>
				<li><a href="https://vimeo.com/channels/<?php echo ot_get_option('vimeo_channel'); ?>" class="vimeo" target="_blank"><i class="fa fa-vimeo"></i> <?php do_action('thb_vimeoLikeCount'); ?> <em><?php _e('Followers', 'goodlife'); ?></em> <span><?php _e('Follow', 'goodlife'); ?></span></a></li>
				<?php } ?>
			</ul>
		<?php
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		$instance['Twitter'] = strip_tags( $new_instance['Twitter'] );
		$instance['Facebook'] = strip_tags( $new_instance['Facebook'] );
		$instance['Instagram'] = strip_tags( $new_instance['Instagram'] );
		$instance['Google'] = strip_tags( $new_instance['Google'] );
		$instance['Youtube'] = strip_tags( $new_instance['Youtube'] );
		$instance['Vimeo'] = strip_tags( $new_instance['Vimeo'] );
		$instance['Debug'] = strip_tags( $new_instance['Debug'] );
		return $instance;
	}
	// Settings form
	function form($instance) {
		$defaults = array(
			'Twitter' => false,
			'Facebook' => false,
			'Instagram' => false,
			'Google' => false,
			'Youtube' => false,
			'Vimeo' => false,
			'Debug' => false,
			'title' => 'Follow Us',
			'style' => 'style1'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$style = $instance['style'];
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('style1'); ?>">
					<input id="<?php echo $this->get_field_id('style1'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="radio" value="style1" <?php if($style === 'style1' || !$style){ echo 'checked="checked"'; } ?> /> Style 1
				</label><br>
				<label for="<?php echo $this->get_field_id('style2'); ?>">
					<input id="<?php echo $this->get_field_id('style2'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="radio" value="style2" <?php if($style === 'style2'){ echo 'checked="checked"'; } ?> /> Style 2
				</label>
			</p>
			<p>
		    <input id="<?php echo $this->get_field_id('Twitter'); ?>" name="<?php echo $this->get_field_name('Twitter'); ?>" type="checkbox" <?php if ($instance['Twitter']) { ?>checked="checked" <?php } ?> />
		    <label for="<?php echo $this->get_field_id('Twitter'); ?>"><?php _e('Display Twitter Counter?', 'goodlife'); ?></label>
		    <small><?php _e('Please make sure you fill out the settings inside Theme Options -> Twitter Oauth for Twitter Counts', 'goodlife'); ?></small>
			</p>
			<p>
			  <input id="<?php echo $this->get_field_id('Facebook'); ?>" name="<?php echo $this->get_field_name('Facebook'); ?>" type="checkbox" <?php if ($instance['Facebook']) { ?>checked="checked" <?php } ?> />
			  <label for="<?php echo $this->get_field_id('Facebook'); ?>"><?php _e('Display Facebook Counter?', 'goodlife'); ?></label>
			  <small><?php _e('Please make sure you fill out the settings inside Theme Options -> Facebook Oauth for Facebook Counts', 'goodlife'); ?></small>
			</p>
			<p>
			  <input id="<?php echo $this->get_field_id('Instagram'); ?>" name="<?php echo $this->get_field_name('Instagram'); ?>" type="checkbox" <?php if ($instance['Instagram']) { ?>checked="checked" <?php } ?> />
			  <label for="<?php echo $this->get_field_id('Instagram'); ?>"><?php _e('Display Instagram Counter?', 'goodlife'); ?></label>
			  <small><?php _e('Please make sure you fill out the settings inside Theme Options -> Instagram Oauth for Instagram Counts', 'goodlife'); ?></small>
			</p>
			<p>
			  <input id="<?php echo $this->get_field_id('Google'); ?>" name="<?php echo $this->get_field_name('Google'); ?>" type="checkbox" <?php if ($instance['Google']) { ?>checked="checked" <?php } ?> />
			  <label for="<?php echo $this->get_field_id('Google'); ?>"><?php _e('Display Google+ Counter?', 'goodlife'); ?></label>
			  <small><?php _e('Please make sure you fill out the settings inside Theme Options -> Google+ Oauth for Google Counts', 'goodlife'); ?></small>
			</p>
			<p>
			  <input id="<?php echo $this->get_field_id('Youtube'); ?>" name="<?php echo $this->get_field_name('Youtube'); ?>" type="checkbox" <?php if ($instance['Youtube']) { ?>checked="checked" <?php } ?> />
			  <label for="<?php echo $this->get_field_id('Youtube'); ?>"><?php _e('Display Youtube Counter?', 'goodlife'); ?></label>
			  <small><?php _e('Please make sure you fill out the settings inside Theme Options -> Youtube Oauth for Youtube Counts', 'goodlife'); ?></small>
			</p>
			<p>
			  <input id="<?php echo $this->get_field_id('Vimeo'); ?>" name="<?php echo $this->get_field_name('Vimeo'); ?>" type="checkbox" <?php if ($instance['Vimeo']) { ?>checked="checked" <?php } ?> />
			  <label for="<?php echo $this->get_field_id('Vimeo'); ?>"><?php _e('Display Vimeo Counter?', 'goodlife'); ?></label>
			  <small><?php _e('Please make sure you fill out the settings inside Theme Options -> Vimeo for Vimeo Counts', 'goodlife'); ?></small>
			</p>
			<p>
			  <input id="<?php echo $this->get_field_id('Debug'); ?>" name="<?php echo $this->get_field_name('Debug'); ?>" type="checkbox" <?php if ($instance['Debug']) { ?>checked="checked" <?php } ?> />
			  <label for="<?php echo $this->get_field_id('Debug'); ?>"><?php _e('Debug Mode', 'goodlife'); ?></label>
			  <small><?php _e('Enable this to see what is returned from social network sites.', 'goodlife'); ?></small>
			</p>
    <?php
	}
}
function widget_socialcounter_init()
{
	register_widget('widget_socialcounter');
}
add_action('widgets_init', 'widget_socialcounter_init');

?>