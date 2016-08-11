<?php
// thb most viewed Posts w/ Images
class widget_viewedimages extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_viewedimages',
			'description' => esc_html__('Display most viewed posts with images','goodlife')
		);
		
		parent::__construct(
			'thb_viewedimages_widget',
			esc_html__( 'Fuel Themes - Most Viewed Posts with Images' , 'goodlife' ),
			$widget_ops
		);
				
		$this->defaults = array( 'title' => 'Most Viewed', 'show' => '3' );
	}

       function widget($args, $instance) {
           extract($args);
           $title = apply_filters('widget_title', $instance['title']);
           $show = $instance['show'];
						$args = array(
							'post_type'=>'post', 
							'post_status' => 'publish', 
							'ignore_sticky_posts' => 1,
							'no_found_rows' => true,
							'post__in' => thb_most_viewed(7,$show),
							'orderby' => 'post__in'
						);
           $posts = new WP_Query( $args );
					
           echo $before_widget;
           echo $before_title . $title; 
            echo '<span class="thb_listing" data-type="views" data-count="'.$show.'">';
            	echo '<a href="#" data-time="7" class="active">'.esc_html__('WEEK', 'goodlife').'</a>';
            	echo '<a href="#" data-time="30">'.esc_html__('MONTH', 'goodlife').'</a>';
            	echo '<a href="#" data-time="365">'.esc_html__('ALL', 'goodlife').'</a>';
            echo '</span>';
           echo $after_title;
           if (thb_most_viewed(7,$show)) {
	           echo '<ul>';
	           $counts = 0;
	           while  ($posts->have_posts()) : $posts->the_post();
	         	  $counts++; 
	         	  $postmeta = array(false,false,false,false,true);
	         	 	set_query_var( 'counts', $counts);
	         	 	set_query_var( 'postmeta', $postmeta );
	         	 	get_template_part( 'inc/poststyles/thumbnail-listing' );
	         	 endwhile;
	           echo '</ul>';
           } else {
           	 _e('No Stats to show', 'goodlife');
           }
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
function widget_viewedimages_init()
{
       register_widget('widget_viewedimages');
}
add_action('widgets_init', 'widget_viewedimages_init');

?>