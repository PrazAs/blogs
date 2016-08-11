<?php
/**
 * Initialize the meta boxes. 
 */
add_action( 'admin_init', 'thb_goodlife_custom_meta_boxes' );

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types
 * in demo-theme-options.php.
 *
 * @return    void
 *
 * @access    private
 * @since     2.0
 */


function thb_goodlife_custom_meta_boxes() {

  /**
   * Create a custom meta boxes array that we pass to 
   * the OptionTree Meta Box API Class.
   */
   
  $post_meta_box = array(  
    'id'          => 'post_settings',
    'title'       => 'Post Settings',
    'pages'       => array( 'post' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
    	array(
    	  'id'          => 'tab1',
    	  'label'       => 'Settings',
    	  'type'        => 'tab'
    	),
    	array(
    	  'label'       => 'Primary Category',
    	  'id'          => 'post-primary-category',
    	  'type'        => 'category_select_auto',
    	  'desc'        => 'If the posts has multiple categories, the one selected here will be used for settings and it appears in the category labels.'
    	),
    	array(
    	  'id'          => 'tab2',
    	  'label'       => 'Standard Post Layout',
    	  'type'        => 'tab'
    	),
    	array(
    	  'id'          => 'post_layout_text',
    	  'label'       => 'About Post Layout Settings',
    	  'desc'        => 'These layouts are used for "Standard" post format.',
    	  'type'        => 'textblock'
    	),
      array(
        'label'       => 'Standard Post Layout',
        'id'          => 'standard-post-detail-style',
        'type'        => 'radio-image',
        'std'         => 'style1'
      ),
      array(
        'label'       => 'Featured Image',
        'id'          => 'standard-featured-image',
        'type'        => 'on_off',
        'desc'        => 'You can choose to hide the featured image.',
        'std'         => 'on',
        'condition'   => 'standard-post-detail-style:is(style1)'
      ),
      array(
        'label'       => 'Featured Image Credit',
        'id'          => 'standard-featured-credit',
        'type'        => 'text',
        'desc'        => 'Featured Image Credit, enter the copyright information for your featured image if needed.',
        'std'         => ''
      ),
      array(
        'id'          => 'tab3',
        'label'       => 'Gallery Post Layout',
        'type'        => 'tab'
      ),
      array(
        'id'          => 'gallery_post_layout_text',
        'label'       => 'About Post Layout Settings',
        'desc'        => 'These layouts are used for "Gallery" post format.',
        'type'        => 'textblock'
      ),
      array(
        'label'       => 'Gallery Post Layout',
        'id'          => 'gallery-post-detail-style',
        'type'        => 'radio-image',
        'std'         => 'style1'
      ),
      array(
        'id'          => 'tab4',
        'label'       => 'Video Post Layout',
        'type'        => 'tab'
      ),
      array(
        'id'          => 'video_post_layout_text',
        'label'       => 'About Post Layout Settings',
        'desc'        => 'These layouts are used for "Video" post format.',
        'type'        => 'textblock'
      ),
      array(
        'label'       => 'Style',
        'id'          => 'video_style',
        'type'        => 'radio',
        'choices'     => array(
        	array(
        		'label'       => 'Dark',
        		'value'       => 'dark'
        	),
        	array(
        		'label'       => 'Light',
        		'value'       => 'light'
        	)
        ),
        'desc'        => 'You can choose between 2 color sets for the video layout.',
        'std'         => 'dark'
      ),
      array(
        'label'       => 'Video URL',
        'id'          => 'post_video',
        'type'        => 'text',
        'desc'        => 'Video URL. You can find a list of websites you can embed here: <a href="http://codex.wordpress.org/Embeds">Wordpress Embeds</a>',
        'std'         => ''
      ),
      array(
        'label'       => 'Is this a Vimeo video?',
        'id'          => 'post_video_vimeo',
        'desc'        => 'This adjustes the widescreen height so that vimeo vidoes are displayed correctly.',
        'std'         => '',
        'type'        => 'checkbox',
        'choices'     => array( 
          array(
            'value'       => 'vimeo',
            'label'       => 'This is a Vimeo video. '
          )
        )
      ),
      array(
        'label'       => 'Display Other Videos bar?',
        'id'          => 'other_videos',
        'type'        => 'on_off',
        'desc'        => 'You can enable the other videos bar here. It displays latest video posts.',
        'std'         => 'on'
      ),
      array(
        'label'       => 'Video Post Layout',
        'id'          => 'video-post-detail-style',
        'type'        => 'radio-image',
        'std'         => 'style2'
      ),
      array(
        'id'          => 'tab5',
        'label'       => 'Review Settings',
        'type'        => 'tab'
      ),
      array(
        'label'       => 'Is this a review post?',
        'id'          => 'is_review',
        'type'        => 'on_off',
        'desc'        => 'Select yes, if you would like to display review settings',
        'std'         => 'off'
      ),
      array(
        'label'       => 'Review Position',
        'id'          => 'post-review-style',
        'type'        => 'radio',
        'choices'     => array(
      		array(
      			'label'       => 'Top Full',
      			'value'       => 'style1'
      		),
      		array(
      			'label'       => 'Top Half',
      			'value'       => 'style2'
      		),
      		array(
      			'label'       => 'Bottom Full',
      			'value'       => 'style3'
      		)
        ),
        'std'		  		=> 'style3',
        'desc'        => 'Where would you like to display the reviews?',
        'condition'   => 'is_review:is(on)'
      ),
      array(
        'label'       => 'Review Title',
        'id'          => 'post_ratings_title',
        'type'        => 'text',
        'desc'        => 'Title of the review',
        'condition'   => 'is_review:is(on)'
      ),
      array(
        'label'       => 'Ratings',
        'id'          => 'post_ratings_percentage',
        'type'        => 'list-item',
        'desc'        => 'Please add ratings to rate this review for',
        'settings'    => array(
          array(
            'label'       => 'Score',
            'id'          => 'feature_score',
            'desc'        => 'Value should be between 0-10',
            'std'         => '5',
            'type'        => 'numeric-slider',
            'min_max_step'=> '0,10,1'
          )
        ),
        'condition'   => 'is_review:is(on)'
      ),
      array(
        'label'       => 'Rating Average',
        'id'          => 'post_ratings_average',
        'type'        => 'text',
        'desc'        => 'Average of the above ratings. You can override it if you want to.',
        'condition'   => 'is_review:is(on)'
      ),
      array(
        'label'       => 'Comments Positive/Negative',
        'id'          => 'post_ratings_comments',
        'type'        => 'list-item',
        'desc'        => 'Please add comments',
        'settings'    => array(
          array(
            'label'       => 'Comment Type',
            'id'          => 'feature_comment_type',
            'type'        => 'radio',
            'desc'        => 'Is this a negative or a positive comment?',
            'choices'     => array(
              array(
                'label'       => 'Positive',
                'value'       => 'positive'
              ),
              array(
                'label'       => 'Negative',
                'value'       => 'negative'
              )
            ),
            'std'         => 'negative'
          ),
        ),
        'condition'   => 'is_review:is(on)'
      ),
    )
  );
  
  $post_meta_box_video = array(
    
    'id'          => 'post_meta_video',
    'title'       => 'Video Settings',
    'pages'       => array( 'post' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
      
    )
  );
  
  $post_meta_box_sidebar_gallery = array(
    'id'        => 'meta_box_sidebar_gallery',
    'title'     => 'Gallery',
    'pages'     => array('post'),
    'context'   => 'side',
    'priority'  => 'low',
    'fields'    => array(
      array(
        'id' => 'pp_gallery_slider',
        'type' => 'gallery',
        'desc' => '',
        'post_type' => 'post'
      )
     )
   );
  
  /**
   * Register our meta boxes using the 
   * ot_register_meta_box() function.
   */
   
  ot_register_meta_box( $post_meta_box );
	ot_register_meta_box( $post_meta_box_video );
	ot_register_meta_box( $post_meta_box_sidebar_gallery);
}