<?php
// thb Category Posts
class widget_categoryposts extends WP_Widget {
	function __construct() {
		$widget_ops = array(
		'classname'   => 'widget_categoryposts',
		'description' => esc_html__('Display category posts in a list','goodlife')
		);
		
		parent::__construct(
			'thb_categoryposts_widget',
			esc_html__( 'Fuel Themes - Category Posts' , 'goodlife' ),
			$widget_ops
		);
			
		$this->defaults = array( 'title' => 'Widget Title', 'show' => '3', 'category' => '', 'thumbs' => 'thumbs-no');
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$show = $instance['show'];
		$category = $instance['category'];
		$thumbs = $instance['thumbs'];
		
		$args = array(
			'cat' => $category,
			'post_type'=>'post', 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => 1,
			'no_found_rows' => true,
			'posts_per_page' => $show
		);
	
		$posts = new WP_Query( $args );
		
		echo $before_widget;
		echo ($title ? $before_title . $title . $after_title : '');
		$counts = 0;
		while  ($posts->have_posts()) : $posts->the_post(); 
			if ($counts == 0) {
					get_template_part( 'inc/poststyles/style3');
					$counts++;
					echo '<ul class="category-posts-'.$category.' '.($thumbs !== "thumbs-yes" ? "point-list" : "" ).'">';
			} else {
				if ($thumbs == 'thumbs-yes') {
					get_template_part( 'inc/poststyles/thumbnail-listing');
				} else {
					get_template_part( 'inc/poststyles/listing');
				}
			}
		endwhile;
		echo '</ul>';
		echo $after_widget;
		
		wp_reset_query();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show'] = strip_tags( $new_instance['show'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['thumbs'] = strip_tags( $new_instance['thumbs'] );
		return $instance;
	}
	function form($instance) {
		$defaults = $this->defaults;
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$thumbs = $instance['thumbs'];
		$categories = get_categories(); ?>
		
		<p>
		 <label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
		 <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		
		<p>
		 <label for="<?php echo $this->get_field_id( 'category' ); ?>">Category:</label>
		 <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" style="width:100%;">
		 	<?php foreach( $categories as $category) { ?>
		 	<option value="<?php echo $category->cat_ID; ?>" <?php if ($category->cat_ID == $instance['category']) { echo 'selected="selected"';} ?>><?php echo $category->cat_name; ?></option>
		 	<?php } ?>
		 </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('thumbs-yes'); ?>">
				<input id="<?php echo $this->get_field_id('thumbs-yes'); ?>" name="<?php echo $this->get_field_name('thumbs'); ?>" type="radio" value="thumbs-yes" <?php if($thumbs === 'thumbs-yes' || !$thumbs){ echo 'checked="checked"'; } ?> /> Show Thumbnails
			</label><br>
			<label for="<?php echo $this->get_field_id('thumbs-no'); ?>">
				<input id="<?php echo $this->get_field_id('thumbs-no'); ?>" name="<?php echo $this->get_field_name('thumbs'); ?>" type="radio" value="thumbs-no" <?php if($thumbs === 'thumbs-no'){ echo 'checked="checked"'; } ?> /> No Thumbnails
			</label>
		</p>
		<p>
		 <label for="<?php echo $this->get_field_id( 'show' ); ?>">Number of Posts:</label>
		 <input id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo $instance['show']; ?>" style="width:100%;" />
		</p>
	<?php
	}
}
function widget_categoryposts_init() {
	register_widget('widget_categoryposts');
}
add_action('widgets_init', 'widget_categoryposts_init');

?>