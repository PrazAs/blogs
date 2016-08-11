<?php
// thb Single Ad
class widget_singlead extends WP_Widget {
	function __construct() {
		$widget_ops = array(
		'classname'   => 'widget_singlead',
		'description' => esc_html__('Display a single advertisement','goodlife')
		);
		
		parent::__construct(
			'thb_singlead_widget',
			esc_html__( 'Fuel Themes - Single Ad' , 'goodlife' ),
			$widget_ops
		);
			
		$this->defaults = array( 'ad_code' => '' );
	}

	function widget($args, $instance) {
		extract($args);
		$ad_code = $instance['ad_code'];
		echo $before_widget;
		echo do_shortcode($ad_code);
		echo $after_widget;
		
		wp_reset_query();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['ad_code'] = $new_instance['ad_code'];
		return $instance;
	}
	function form($instance) {
		$defaults = $this->defaults;
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		
		<p>
		 <label for="<?php echo $this->get_field_id( 'ad_code' ); ?>">Ad Code:</label>
		 <textarea class="widefat" rows="8" id="<?php echo $this->get_field_id( 'ad_code' ); ?>" name="<?php echo $this->get_field_name( 'ad_code' ); ?>" style="width:100%;"><?php echo $instance['ad_code']; ?></textarea>
		</p>
	<?php
	}
}
function widget_singlead_init() {
	register_widget('widget_singlead');
}
add_action('widgets_init', 'widget_singlead_init');

?>