<?php
// thb shared Posts w/ Images
class widget_sharedimages extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_sharedimages',
			'description' => esc_html__('Display most shared posts with images','goodlife')
		);
		
		parent::__construct(
			'thb_sharedimages_widget',
			esc_html__( 'Fuel Themes - Most Shared Posts' , 'goodlife' ),
			$widget_ops
		);
				
		$this->defaults = array( 'title' => 'Most Shared', 'show' => '3' );
	}

       function widget($args, $instance) {
               extract($args);
               $title = apply_filters('widget_title', $instance['title']);
               $show = $instance['show'];
               
               $args = array(
               		'nopaging' => 0, 
               		'post_type'=>'post', 
               		'post_status' => 'publish', 
               		'ignore_sticky_posts' => 1,
               		'no_found_rows' => true,
               		'suppress_filters' => 0,
               		'posts_per_page' => $show,
               		'meta_key' => 'thb_pssc_counts',  
               		'orderby' => 'meta_value_num'
               	);
              
               $posts = new WP_Query( $args );

               echo $before_widget;
               echo ($title ? $before_title . $title . $after_title : '');
               echo '<ul>';
               $counts = 0;
               while  ($posts->have_posts()) : $posts->the_post();
	               $counts++; 
	               $postmeta = array(false,false,true,false,false);
	               set_query_var( 'counts', $counts);
	               set_query_var( 'postmeta', $postmeta );
	               get_template_part( 'inc/poststyles/thumbnail-listing' );
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

               return $instance;
       }
       function form($instance) {
               $defaults = $this->defaults;
               $instance = wp_parse_args( (array) $instance, $defaults ); ?>

               <p>
                       <label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
                       <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
               </p>

               <p>
                       <label for="<?php echo $this->get_field_id( 'name' ); ?>">Number of Posts:</label>
                       <input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo $instance['show']; ?>" style="width:100%;" />
               </p>
   <?php
       }
}
function widget_sharedimages_init()
{
       register_widget('widget_sharedimages');
}
add_action('widgets_init', 'widget_sharedimages_init');

?>