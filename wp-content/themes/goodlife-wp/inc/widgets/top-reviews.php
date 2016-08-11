<?php
// thb shared Posts w/ Images
class widget_topreviews extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'widget_topreviews',
			'description' => esc_html__('Display top review posts','goodlife')
		);
		
		parent::__construct(
			'thb_topreviews_widget',
			esc_html__( 'Fuel Themes - Top Reviews' , 'goodlife' ),
			$widget_ops
		);
				
		$this->defaults = array( 'title' => 'Top Reviews', 'show' => '5', 'style' => 'style1' );
	}

       function widget($args, $instance) {
               extract($args);
               $title = apply_filters('widget_title', $instance['title']);
               $show = $instance['show'];
               $style = $instance['style'];
               $args = array(
               		'post_type'=>'post', 
             			'post_status' => 'publish', 
             			'ignore_sticky_posts' => 1,
             			'no_found_rows' => true,
               		'posts_per_page' => $show,
               		'meta_key' => 'post_ratings_average',
               		'orderby' => 'meta_value_num'
                );
               $posts = new WP_Query( $args );

               echo $before_widget;
               echo ($title ? $before_title . $title . $after_title : '');
               
               $counts = 0;
               while  ($posts->have_posts()) : $posts->the_post();

               	if ($counts == 0) {
               		get_template_part( 'inc/poststyles/photo-listing');
               		$counts++;
               		echo '<ul class="'.$style.'">';
               	} else {
               		$ave = get_post_meta(get_the_id(), 'post_ratings_average', TRUE); 
               		if ($style == 'style2') {
               		?>
               			<li>
               				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> <span><?php echo esc_attr($ave); ?></span></a>
               			</li>
               		<?php 
               		} else {
               			?>
             					<li class="post">
             						<div class="progress" data-width="<?php echo esc_attr($ave * 10); ?>"></div>
             						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
             							<?php the_title(); ?>
             						</a>
             						<?php do_action('thb_PostMeta', true, true, false, false, false ); ?>
             						<span class="ave"><?php echo esc_attr($ave); ?></span>
             					</li>
             				<?php 
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
						 	    </label>
							 </p>
               <p>
	               <label for="<?php echo $this->get_field_id( 'name' ); ?>">Number of Posts:</label>
	               <input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo $instance['show']; ?>" style="width:100%;" />
               </p>
   <?php
       }
}
function widget_topreviews_init()
{
       register_widget('widget_topreviews');
}
add_action('widgets_init', 'widget_topreviews_init');

?>