<?php
// thb Post Slider
class widget_postslider extends WP_Widget {
	function __construct() {
		$widget_ops = array(
		'classname'   => 'widget_postslider',
		'description' => esc_html__('Display posts in a slider by Post ID','goodlife')
		);
		
		parent::__construct(
			'thb_postslider_widget',
			esc_html__( 'Fuel Themes - Post Slider' , 'goodlife' ),
			$widget_ops
		);
			
		$this->defaults = array( 'title' => 'Widget Title', 'ids' => '' );
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$ids = $instance['ids'];
		$post_id_array = explode(',', $ids);
		$args = array(
			'post_type'=>'post', 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => 1,
			'no_found_rows' => true,
			'post__in' => $post_id_array,
			'posts_per_page' => 99,
			'orderby' => 'post__in'
		);
	
		$posts = new WP_Query( $args );
		
		echo $before_widget;
		echo ($title ? $before_title . $title . $after_title : '');
		echo '<div class="slick text-center" data-columns="1" data-pagination="false" data-navigation="true">';
		while  ($posts->have_posts()) : $posts->the_post(); 
			set_query_var( 'image_class', 'no-lazy-load' );
			get_template_part( 'inc/poststyles/photo-listing-vertical' );
		endwhile;
		echo '</div>';
		echo $after_widget;
		
		wp_reset_query();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['ids'] = strip_tags( $new_instance['ids'] );
		return $instance;
	}
	function form($instance) {
		$defaults = $this->defaults;
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$categories = get_categories(); ?>
		
		<p>
		 <label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
		 <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
		 <label for="<?php echo $this->get_field_id( 'ids' ); ?>">Post IDs seperated by comma:</label>
		 <input id="<?php echo $this->get_field_id( 'ids' ); ?>" name="<?php echo $this->get_field_name( 'ids' ); ?>" value="<?php echo $instance['ids']; ?>" style="width:100%;" />
		</p>
	<?php
	}
}
function widget_postslider_init() {
	register_widget('widget_postslider');
}
add_action('widgets_init', 'widget_postslider_init');

?>