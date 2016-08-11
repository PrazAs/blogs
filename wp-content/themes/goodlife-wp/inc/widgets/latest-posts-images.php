<?php
// thb latest Posts w/ Images
class widget_latestimages extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_latestimages',
			'description' => esc_html__('Display latest posts with images','goodlife')
		);
		
		parent::__construct(
			'thb_latestimages_widget',
			esc_html__( 'Fuel Themes - Latest Posts' , 'goodlife' ),
			$widget_ops
		);
				
		$this->defaults = array( 'title' => 'Latest Posts', 'show' => '3', 'style' => 'style2' );
	}

       function widget($args, $instance) {
               extract($args);
               $title = apply_filters('widget_title', $instance['title']);
               $show = $instance['show'];
							 $style = $instance['style'] ? $instance['style'] : 'style2';
               $args = array(
               		'post_type'=>'post', 
               		'post_status' => 'publish', 
               		'ignore_sticky_posts' => 1,
               		'no_found_rows' => true,
               		'posts_per_page' => $show
               	);
               $latest_posts = new WP_Query( $args );

               echo $before_widget;
               echo ($title ? $before_title . $title . $after_title : '');
               echo '<ul>';
               while  ($latest_posts->have_posts()) : $latest_posts->the_post();
               	if ($style == 'style3') {
               		echo '<li>';
               		get_template_part( 'inc/poststyles/style1-meta-nocat' );
               		echo '</li>';
               	} else if ($style == 'style2') {
               		echo '<li>';
               		get_template_part( 'inc/poststyles/photo-listing' );
               		echo '</li>';
               	} else {
               		get_template_part( 'inc/poststyles/thumbnail-listing' );
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
               $instance['style'] = strip_tags( $new_instance['style'] );

               return $instance;
       }
       function form($instance) {
               $defaults = $this->defaults;
               $instance = wp_parse_args( (array) $instance, $defaults );
               $style = $instance['style']; ?>

							<p>
								<label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
								<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
							</p>
							<p>
								<label for="<?php echo $this->get_field_id('style1'); ?>">
									<input id="<?php echo $this->get_field_id('style1'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="radio" value="style1" <?php if($style === 'style1' || !$style){ echo 'checked="checked"'; } ?> /> Style 1
								</label><br>
								<label for="<?php echo $this->get_field_id('style2'); ?>">
									<input id="<?php echo $this->get_field_id('style2'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="radio" value="style2" <?php if($style === 'style2'){ echo 'checked="checked"'; } ?> /> Style 2
								</label><br>
								<label for="<?php echo $this->get_field_id('style3'); ?>">
									<input id="<?php echo $this->get_field_id('style3'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="radio" value="style3" <?php if($style === 'style3'){ echo 'checked="checked"'; } ?> /> Style 3
								</label>
							</p>
							<p>
								<label for="<?php echo $this->get_field_id( 'name' ); ?>">Number of Posts:</label>
								<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo $instance['show']; ?>" style="width:100%;" />
							</p>
   <?php
       }
}
function widget_latestimages_init()
{
       register_widget('widget_latestimages');
}
add_action('widgets_init', 'widget_latestimages_init');

?>