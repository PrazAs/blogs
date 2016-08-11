<?php
// thb Single Ad
class widget_multiplead extends WP_Widget {
	function __construct() {
		$widget_ops = array(
		'classname'   => 'widget_multiplead',
		'description' => esc_html__('Display 125x125 ads','goodlife')
		);
		
		parent::__construct(
			'thb_multiplead_widget',
			esc_html__( 'Fuel Themes - 125x125 Ads' , 'goodlife' ),
			$widget_ops
		);
			
		$this->defaults = array( 'title' => 'Widget Title' );
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$ad_code1 = $instance['ad_code1'];
		$ad_code2 = $instance['ad_code2'];
		$ad_code3 = $instance['ad_code3'];
		$ad_code4 = $instance['ad_code4'];
		echo $before_widget;
		echo ($title ? $before_title . $title . $after_title : '');
		?>
			<div class="row">
				<?php if ($ad_code1) { ?>
					<div class="small-6 columns"><?php echo do_shortcode($ad_code1); ?></div>
				<?php } ?>
				<?php if ($ad_code2) { ?>
					<div class="small-6 columns"><?php echo do_shortcode($ad_code2); ?></div>
				<?php } ?>
				<?php if ($ad_code3) { ?>
					<div class="small-6 columns"><?php echo do_shortcode($ad_code3); ?></div>
				<?php } ?>
				<?php if ($ad_code4) { ?>
					<div class="small-6 columns"><?php echo do_shortcode($ad_code4); ?></div>
				<?php } ?>
			</div>
		<?php
		echo $after_widget;
		
		wp_reset_query();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['ad_code1'] = $new_instance['ad_code1'];
		$instance['ad_code2'] = $new_instance['ad_code2'];
		$instance['ad_code3'] = $new_instance['ad_code3'];
		$instance['ad_code4'] = $new_instance['ad_code4'];
		return $instance;
	}
	function form($instance) {
		$defaults = $this->defaults;
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		<p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
      <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
		 <label for="<?php echo $this->get_field_id( 'ad_code1' ); ?>">Ad Code 1:</label>
		 <textarea class="widefat" rows="4" id="<?php echo $this->get_field_id( 'ad_code1' ); ?>" name="<?php echo $this->get_field_name( 'ad_code1' ); ?>" style="width:100%;"><?php echo $instance['ad_code1']; ?></textarea>
		</p>
		<p>
		 <label for="<?php echo $this->get_field_id( 'ad_code2' ); ?>">Ad Code 1:</label>
		 <textarea class="widefat" rows="4" id="<?php echo $this->get_field_id( 'ad_code2' ); ?>" name="<?php echo $this->get_field_name( 'ad_code2' ); ?>" style="width:100%;"><?php echo $instance['ad_code2']; ?></textarea>
		</p>
		<p>
		 <label for="<?php echo $this->get_field_id( 'ad_code3' ); ?>">Ad Code 1:</label>
		 <textarea class="widefat" rows="4" id="<?php echo $this->get_field_id( 'ad_code3' ); ?>" name="<?php echo $this->get_field_name( 'ad_code3' ); ?>" style="width:100%;"><?php echo $instance['ad_code3']; ?></textarea>
		</p>
		<p>
		 <label for="<?php echo $this->get_field_id( 'ad_code4' ); ?>">Ad Code 1:</label>
		 <textarea class="widefat" rows="4" id="<?php echo $this->get_field_id( 'ad_code4' ); ?>" name="<?php echo $this->get_field_name( 'ad_code4' ); ?>" style="width:100%;"><?php echo $instance['ad_code4']; ?></textarea>
		</p>
	<?php
	}
}
function widget_multiplead_init() {
	register_widget('widget_multiplead');
}
add_action('widgets_init', 'widget_multiplead_init');

?>