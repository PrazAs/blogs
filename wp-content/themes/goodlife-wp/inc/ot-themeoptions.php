<?php
/**
 * Initialize the options before anything else. 
 */
add_action( 'admin_init', 'thb_goodlife_custom_theme_options', 1 );

/**
 * Theme Mode demo code of all the available option types.
 *
 * @return    void
 *
 * @access    private
 * @since     2.0
 */
function thb_goodlife_custom_theme_options() {
  
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Create a custom settings array that we pass to 
   * the OptionTree Settings API Class.
   */
  $custom_settings = array(
    'sections'        => array(
      array(
        'title'       => 'General',
        'id'          => 'general'
      ),
      array(
        'title'       => 'Header Settings',
        'id'          => 'header'
      ),
      array(
        'title'       => 'Category Settings',
        'id'          => 'category_settings'
      ),
      array(
        'title'       => 'Customization',
        'id'          => 'customization'
      ),
      array(
        'title'       => 'Advertisements',
        'id'          => 'advertising'
      ),
      array(
        'title'       => 'Footer Settings',
        'id'          => 'footer'
      ),
      array(
        'title'       => 'Misc',
        'id'          => 'misc'
      ),
      array(
        'title'       => 'Demo Content',
        'id'          => 'import'
      )
    ),
    'settings'        => array(
    	array(
    	  'id'          => 'general_tab1',
    	  'label'       => 'General',
    	  'type'        => 'tab',
    	  'section'     => 'general'
    	),
    	array(
    	  'label'       => 'Boxed',
    	  'id'          => 'general_boxed',
    	  'type'        => 'on_off',
    	  'desc'        => 'This is mainly used to contain article headers especially if you have pageskin advertisements. Header & Footer have their own boxed settings.',
    	  'std'         => 'off',
    	  'section'     => 'general'
    	),
    	array(
    	  'label'       => 'Lazy Load Images',
    	  'id'          => 'lazy_load',
    	  'type'        => 'on_off',
    	  'desc'        => 'If enabled, images will only be loaded when they come to view.',
    	  'std'         => 'on',
    	  'section'     => 'general'
    	),
    	array(
    	  'label'       => 'Scroll to Top Arrow',
    	  'id'          => 'scroll_totop',
    	  'type'        => 'on_off',
    	  'desc'        => 'You can disable scroll to top arrow from here',
    	  'std'         => 'on',
    	  'section'     => 'general'
    	),
    	array(
    	  'label'       => 'Use Relative Dates?',
    	  'id'          => 'relative_dates',
    	  'type'        => 'on_off',
    	  'desc'        => 'This will display dates as "1 day ago", etc.',
    	  'std'         => 'on',
    	  'section'     => 'general'
    	),
      array(
        'id'          => 'general_tab2',
        'label'       => 'Social Sharing',
        'type'        => 'tab',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Sharing buttons',
        'id'          => 'sharing_buttons',
        'type'        => 'checkbox',
        'desc'        => 'You can choose which social networks to display and get counts from. Please visit <strong>Theme Options > Misc</strong> to fill out application details for the social media sites you choose.',
        'choices'     => array(
          array(
            'label'       => 'Facebook',
            'value'       => 'facebook'
          ),
          array(
            'label'       => 'Twitter',
            'value'       => 'twitter'
          ),
          array(
            'label'       => 'Pinterest',
            'value'       => 'pinterest'
          ),
          array(
            'label'       => 'Google Plus',
            'value'       => 'google-plus'
          ),
          array(
            'label'       => 'Linkedin',
            'value'       => 'linkedin'
          )
        ),
        'section'     => 'general'
      ),
      array(
        'label'       => 'Disable OG: Tags',
        'id'          => 'general_disable_og_tags',
        'type'        => 'on_off',
        'desc'        => 'If you want, you can disable the theme added Facebook OG tags if you are using a plugin like Yoast SEO or similar.',
        'std'         => 'off',
        'section'     => 'general'
      ),
      array(
        'id'          => 'general_tab3',
        'label'       => 'Articles',
        'type'        => 'tab',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Display Reading Indicator?',
        'id'          => 'reading_indicator',
        'type'        => 'on_off',
        'desc'        => 'You can disable the reading progress indicator here. You can also change its color from customization tab.',
        'std'         => 'on',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Infinite loading on Article Pages',
        'id'          => 'infinite_load',
        'type'        => 'on_off',
        'desc'        => 'You can disable infinite scrolling on article pages',
        'std'         => 'on',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Latest Posts',
        'id'          => 'related_posts',
        'type'        => 'on_off',
        'desc'        => 'You can disable latest posts on article pages',
        'std'         => 'on',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Number of Latest Posts',
        'id'          => 'related_count',
        'type'        => 'text',
        'desc'        => 'Number of latest posts to show, default is 6.',
        'section'     => 'general',
        'condition'   => 'related_posts:is(on)'
      ),
      array(
        'label'       => 'Fixed Sidebars',
        'id'          => 'article_fixed_sidebar',
        'type'        => 'on_off',
        'desc'        => 'You can disable fixed sidebars on article pages',
        'std'         => 'on',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Previous / Next Articles',
        'id'          => 'article_prevnext',
        'type'        => 'on_off',
        'desc'        => 'You can disable previous / next article links here',
        'std'         => 'on',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Limit Previous / Next Articles to same category?',
        'id'          => 'article_prevnext_samecat',
        'type'        => 'on_off',
        'desc'        => 'Prev/Next articles will be limited to articles sharing the same categories',
        'std'         => 'off',
        'section'     => 'general',
        'condition'   => 'article_prevnext:is(on)'
      ),
      array(
        'label'       => 'Author Information',
        'id'          => 'article_author',
        'type'        => 'on_off',
        'desc'        => 'You can disable author information on article pages',
        'std'         => 'on',
        'section'     => 'general'
      ),
      array(
        'id'          => 'general_tab4',
        'label'       => 'Article Meta',
        'type'        => 'tab',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Select Post Meta to <strong>HIDE</strong>',
        'id'          => 'post_meta',
        'type'        => 'checkbox',
        'desc'        => 'You can choose to <strong>hide</strong> certain post meta here. This will remove the selected post meta globally. These are the small text under post post titles.',
        'choices'     => array(
          array(
            'label'       => 'Author',
            'value'       => 'author'
          ),
          array(
            'label'       => 'Post Date',
            'value'       => 'post-date'
          ),
          array(
            'label'       => 'Shares',
            'value'       => 'shares'
          ),
          array(
            'label'       => 'Comments',
            'value'       => 'comments'
          ),
          array(
            'label'       => 'Views',
            'value'       => 'views'
          )
        ),
        'section'     => 'general'
      ),
      array(
        'id'          => 'general_tab5',
        'label'       => 'Mobile Menu',
        'type'        => 'tab',
        'section'     => 'general'
      ),
      array(
        'label'       => 'Menu Footer',
        'id'          => 'menu_footer',
        'type'        => 'textarea',
        'desc'        => 'This content appears at the bottom of the mobile menu. You can use your shortcodes here.',
        'rows'        => '4',
        'section'     => 'general'
      ),
      array(
        'id'          => 'header_tab1',
        'label'       => 'Header Settings',
        'type'        => 'tab',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Header Style',
        'id'          => 'header_style',
        'type'        => 'radio',
        'desc'        => 'You can choose different header styles here',
        'choices'     => array(
          array(
            'label'       => 'Style 1',
            'value'       => 'style1'
          ),
          array(
            'label'       => 'Style 2',
            'value'       => 'style2'
          ),
          array(
            'label'       => 'Style 3',
            'value'       => 'style3'
          )
        ),
        'std'         => 'style1',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Header Color',
        'id'          => 'header_color',
        'type'        => 'radio',
        'desc'        => 'You can choose your header color here. This changes the icon and links colors inside the header. You can also change your header background from "Customization"',
        'choices'     => array(
          array(
            'label'       => 'Light',
            'value'       => 'light'
          ),
          array(
            'label'       => 'Dark',
            'value'       => 'dark'
          )
        ),
        'std'         => 'light',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Menu Color',
        'id'          => 'menu_color',
        'type'        => 'radio',
        'desc'        => 'You can choose your menu color here. This changes the background and links colors of the menu. You can also change your menu background from "Customization"',
        'choices'     => array(
          array(
            'label'       => 'Light',
            'value'       => 'light'
          ),
          array(
            'label'       => 'Dark',
            'value'       => 'dark'
          )
        ),
        'std'         => 'light',
        'section'     => 'header',
        'condition'   => 'header_style:is(style1)'
      ),
      array(
        'label'       => 'Boxed',
        'id'          => 'header_boxed',
        'type'        => 'on_off',
        'desc'        => 'Would you like to use the boxed style?',
        'std'         => 'off',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Fixed Header',
        'id'          => 'header_fixed',
        'type'        => 'on_off',
        'desc'        => 'You can enable/disable the fixed header functionality here.',
        'std'         => 'on',
        'section'     => 'header'
      ),
      array(
        'id'          => 'header_menu_margin',
        'label'       => 'Top Level Menu Item spacing',
        'desc'        => 'If you want to fit more menu items to the given space, you can decrease the margin between them here. The default margin is 20px',
        'std'         => '',
        'type'        => 'measurement',
        'section'     => 'header'
      ),
//      array(
//        'label'       => 'Header Search',
//        'id'          => 'header_search',
//        'type'        => 'on_off',
//        'desc'        => 'Would you like to display the search icon in the header?',
//        'section'     => 'header',
//        'std'         => 'on',
//        'condition'   => 'header_style:is(style1,style3)'
//      ),
      array(
        'id'          => 'header_tab2',
        'label'       => 'Sub-Header Settings',
        'type'        => 'tab',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Display Sub-Header',
        'id'          => 'subheader',
        'type'        => 'on_off',
        'desc'        => 'Would you like to display the Sub-Header?',
        'std'         => 'on',
        'section'     => 'header',
      ),
      array(
        'label'       => 'Boxed',
        'id'          => 'subheader_boxed',
        'type'        => 'on_off',
        'desc'        => 'Would you like to use the boxed style?',
        'std'         => 'off',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Sub-Header Full Width',
        'id'          => 'subheader_grid',
        'type'        => 'on_off',
        'desc'        => 'You can enable/disable the full-width behaviour of the subheader here.',
        'std'         => 'on',
        'section'     => 'header',
        'condition'   => 'subheader_boxed:is(off)'
      ),
      array(
        'label'       => 'Sub-Header Color',
        'id'          => 'subheader_color',
        'type'        => 'radio',
        'desc'        => 'You can choose different header styles here',
        'choices'     => array(
          array(
            'label'       => 'Style 1',
            'value'       => 'style1'
          ),
          array(
            'label'       => 'Style 2',
            'value'       => 'style2'
          ),
          array(
            'label'       => 'Style 3',
            'value'       => 'style3'
          )
        ),
        'std'         => 'style1',
        'section'     => 'header'
       ),
       array(
        'label'       => 'Sub-Header Color',
        'id'          => 'subheader_color',
        'type'        => 'radio',
        'desc'        => 'You can choose your subheader color here. You can also change your subheader background from "Customization"',
        'choices'     => array(
          array(
            'label'       => 'Light',
            'value'       => 'light'
          ),
          array(
            'label'       => 'Dark',
            'value'       => 'dark'
          )
        ),
        'std'         => 'light',
        'section'     => 'header',
        'condition'   => 'subheader:is(on)'
      ),
      array(
        'label'       => 'Language Switcher',
        'id'          => 'subheader_ls',
        'type'        => 'on_off',
        'desc'        => 'Would you like to display the language switcher in the sub-header? <small>Requires that you have WPML installed. <a href="https://wpml.org/?aid=85928&affiliate_key=PIP3XupfKQOZ">You can purchase WPML here.</a></small>',
        'section'     => 'header',
        'std'         => 'off',
        'condition'   => 'subheader:is(on)'
      ),
      array(
        'label'       => 'Search Icon',
        'id'          => 'subheader_search',
        'type'        => 'on_off',
        'desc'        => 'Would you like to display the search icon/form?',
        'section'     => 'header',
        'std'         => 'off',
        'condition'   => 'subheader:is(on)'
      ),
      array(
        'id'          => 'header_tab4',
        'label'       => 'Social Links in Sub-Header',
        'type'        => 'tab',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Display Dropdown or Icons?',
        'id'          => 'social_links_style',
        'type'        => 'radio',
        'desc'        => 'You can choose either dropdown or icons',
        'choices'     => array(
          array(
            'label'       => 'Dropdown',
            'value'       => 'style1'
          ),
          array(
            'label'       => 'Icons',
            'value'       => 'style2'
          )
        ),
        'std'         => 'style1',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Facebook Link',
        'id'          => 'fb_link_header',
        'type'        => 'text',
        'desc'        => 'Facebook profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Pinterest Link',
        'id'          => 'pinterest_link_header',
        'type'        => 'text',
        'desc'        => 'Pinterest profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Twitter Link',
        'id'          => 'twitter_link_header',
        'type'        => 'text',
        'desc'        => 'Twitter profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Google Plus Link',
        'id'          => 'googleplus_link_header',
        'type'        => 'text',
        'desc'        => 'Google Plus profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Linkedin Link',
        'id'          => 'linkedin_link_header',
        'type'        => 'text',
        'desc'        => 'Linkedin profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Instagram Link',
        'id'          => 'instragram_link_header',
        'type'        => 'text',
        'desc'        => 'Instagram profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Xing Link',
        'id'          => 'xing_link_header',
        'type'        => 'text',
        'desc'        => 'Xing profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Tumblr Link',
        'id'          => 'tumblr_link_header',
        'type'        => 'text',
        'desc'        => 'Tumblr profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Vkontakte Link',
        'id'          => 'vk_link_header',
        'type'        => 'text',
        'desc'        => 'Vkontakte profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'SoundCloud Link',
        'id'          => 'soundcloud_link_header',
        'type'        => 'text',
        'desc'        => 'SoundCloud profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Dribbble Link',
        'id'          => 'dribbble_link_header',
        'type'        => 'text',
        'desc'        => 'Dribbbble profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'RSS Link',
        'id'          => 'rss_link_header',
        'type'        => 'text',
        'desc'        => 'RSS Feed link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'YouTube Link',
        'id'          => 'youtube_link_header',
        'type'        => 'text',
        'desc'        => 'Youtube profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Spotify Link',
        'id'          => 'spotify_link_header',
        'type'        => 'text',
        'desc'        => 'Spotify profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Behance Link',
        'id'          => 'behance_link_header',
        'type'        => 'text',
        'desc'        => 'Behance profile/page link',
        'section'     => 'header'
      ),
      array(
        'label'       => 'DeviantArt Link',
        'id'          => 'deviantart_link_header',
        'type'        => 'text',
        'desc'        => 'DeviantArt profile/page link',
        'section'     => 'header'
      ),
      array(
        'id'          => 'header_tab3',
        'label'       => 'Logo Settings',
        'type'        => 'tab',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Logo Upload',
        'id'          => 'thb_logo',
        'type'        => 'upload',
        'desc'        => 'You can upload your own logo here. Since this theme is retina-ready, <strong>please upload a double size image.</strong> The image should be maximum 100 pixels in height.',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Logo Height',
        'id'          => 'logo_height',
        'type'        => 'measurement',
        'desc'        => 'You can modify the logo height from here. This is maximum height, so your logo may get smaller depending on spacing inside header',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Fixed Header Logo Upload',
        'id'          => 'fixedlogo',
        'type'        => 'upload',
        'desc'        => 'You can upload your own logo here. Since this theme is retina-ready, <strong>please upload a double size image.</strong> The image should be maximum 100 pixels in height.',
        'section'     => 'header'
      ),
      array(
        'label'       => 'Fixed Header Logo Height',
        'id'          => 'fixedlogo_height',
        'type'        => 'measurement',
        'desc'        => 'You can modify the logo height from here. This is maximum height, so your logo may get smaller depending on spacing inside header',
        'section'     => 'header'
      ),
      array(
        'id'          => 'category_settings_tab1',
        'label'       => 'Category Pages',
        'type'        => 'tab',
        'section'     => 'category_settings'
      ),
      array(
        'label'       => 'Category Title Style',
        'id'          => 'category_title_style',
        'type'        => 'radio',
        'desc'        => 'Which style would you like to use for category titles?',
        'choices'     => array(
          array(
            'label'       => 'Style 1',
            'value'       => 'style1'
          ),
          array(
            'label'       => 'Style 2',
            'value'       => 'style2'
          )
        ),
        'std'         => 'style1',
        'section'     => 'category_settings'
      ),
      array(
        'label'       => 'Category Siblings',
        'id'          => 'category_siblings',
        'type'        => 'on_off',
        'desc'        => 'Would you like to display the category siblings?',
        'std'         => 'on',
        'section'     => 'category_settings'
      ),
      array(
        'label'       => 'Category Listing Style',
        'id'          => 'category_list_style',
        'type'        => 'radio',
        'desc'        => 'Which style would you like to use for category post listings?',
        'choices'     => array(
          array(
            'label'       => 'Style 1 - Default',
            'value'       => 'style2'
          ),
          array(
            'label'       => 'Style 2 - Grid',
            'value'       => 'style3'
          )
        ),
        'std'         => 'style2',
        'section'     => 'category_settings'
      ),
      array(
        'id'          => 'category_settings_tab2',
        'label'       => 'Category Colors',
        'type'        => 'tab',
        'section'     => 'category_settings'
      ),
      array(
        'label'       => 'Category Colors',
        'id'          => 'category_colors',
        'type'        => 'category_colorpicker',
        'desc'        => '',
        'section'     => 'category_settings'
      ),
      array(
        'id'          => 'category_settings_tab3',
        'label'       => 'Category Sidebars',
        'type'        => 'tab',
        'section'     => 'category_settings'
      ),
      array(
        'label'       => 'Category Sidebars',
        'id'          => 'category_sidebars',
        'type'        => 'category_sidebar_select',
        'desc'        => '',
        'section'     => 'category_settings'
      ),
      array(
        'id'          => 'category_settings_tab4',
        'label'       => 'Category Headers',
        'type'        => 'tab',
        'section'     => 'category_settings'
      ),
      array(
        'label'       => 'Category Grids',
        'id'          => 'category_grids',
        'type'        => 'category_grid_select',
        'desc'        => 'Category Grid selection',
        'choices'     => array(
        	'grid' => array(
        		array(
        		  'label'       => 'No Grid',
        		  'value'       => ''
        		),
        		array(
        		  'label'       => 'Style 1',
        		  'value'       => 'style1'
        		),
        		array(
        		  'label'       => 'Style 2',
        		  'value'       => 'style2'
        		),
        		array(
        		  'label'       => 'Style 3',
        		  'value'       => 'style3'
        		)		
        	),
					'title' => array(
						array(
						  'label'       => 'Title Position',
						  'value'       => ''
						),
						array(
						  'label'       => 'Top Left',
						  'value'       => 'top-title'
						),
						array(
						  'label'       => 'Center Center',
						  'value'       => 'center-title'
						),
						array(
						  'label'       => 'Bottom Left',
						  'value'       => 'bottom-title'
						)
					),
					'overlay' => array(
						array(
						  'label'       => 'Overlay Style',
						  'value'       => ''
						),
						array(
						  'label'       => 'Standard',
						  'value'       => 'standard'
						),
						array(
						  'label'       => 'Technology',
						  'value'       => 'technology'
						)
					)
        ),
        'std'         => '',
        'section'     => 'category_settings'
      ),
      array(
        'id'          => 'misc_tab1',
        'label'       => 'General',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Extra CSS',
        'id'          => 'extra_css',
        'type'        => 'css',
        'desc'        => 'Any CSS that you would like to add to the theme.',
        'section'     => 'misc'
      ),
	  array(
        'id'          => 'misc_tab12',
        'label'       => '404 Page',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
	  array(
        'label'       => '404 Page Image',
        'id'          => '404-image',
        'type'        => 'upload',
        'desc'        => 'This will change the actual 404 image in the middle.',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'misc_tab',
        'label'       => 'Facebook OAuth',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Facebook Page ID',
        'id'          => 'facebook_page_id',
        'type'        => 'text',
        'desc'        => 'Facebook Page ID, you can use <a href="http://findmyfbid.com/" target="_blank">this page</a> to find your id',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Facebook Username',
        'id'          => 'facebook_page_username',
        'type'        => 'text',
        'desc'        => 'Your Facebook page username',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Facebook App ID',
        'id'          => 'facebook_app_id',
        'type'        => 'text',
        'desc'        => 'Facebook Application ID, available <a href="https://developers.facebook.com/apps/" target="_blank">here</a>',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Facebook App Secret',
        'id'          => 'facebook_app_secret',
        'type'        => 'text',
        'desc'        => 'Facebook Application Secret, available <a href="https://developers.facebook.com/apps/" target="_blank">here</a>',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'misc_tab2',
        'label'       => 'Twitter OAuth',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'twitter_text',
        'label'       => 'About the Twitter Settings',
        'desc'        => 'You should fill out these settings if you want to use the Twitter related widgets or Visual Composer Elements',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Twitter Username',
        'id'          => 'twitter_bar_username',
        'type'        => 'text',
        'desc'        => 'Your Twitter Username',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Consumer Key',
        'id'          => 'twitter_bar_consumerkey',
        'type'        => 'text',
        'desc'        => 'Visit <a href="https://dev.twitter.com/apps">this link</a> in a new tab, sign in with your account, click on Create a new application and create your own keys in case you dont have already',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Consumer Secret',
        'id'          => 'twitter_bar_consumersecret',
        'type'        => 'text',
        'desc'        => 'Visit <a href="https://dev.twitter.com/apps">this link</a> in a new tab, sign in with your account, click on Create a new application and create your own keys in case you dont have already',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Access Token',
        'id'          => 'twitter_bar_accesstoken',
        'type'        => 'text',
        'desc'        => 'Visit <a href="https://dev.twitter.com/apps">this link</a> in a new tab, sign in with your account, click on Create a new application and create your own keys in case you dont have already',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Access Token Secret',
        'id'          => 'twitter_bar_accesstokensecret',
        'type'        => 'text',
        'desc'        => 'Visit <a href="https://dev.twitter.com/apps">this link</a> in a new tab, sign in with your account, click on Create a new application and create your own keys in case you dont have already',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'misc_tab3',
        'label'       => 'Instagram OAuth',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'instagram_text',
        'label'       => 'About the Instagram Settings',
        'desc'        => 'You should fill out these settings if you want to use the Instagram related VC elements or widgets',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Instagram ID',
        'id'          => 'instagram_id',
        'type'        => 'text',
        'desc'        => 'Your Instagram ID, you can find your ID from here: <a href="http://www.otzberg.net/iguserid/">http://www.otzberg.net/iguserid/</a>',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Instagram Username',
        'id'          => 'instagram_username',
        'type'        => 'text',
        'desc'        => 'Your Instagram Username',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Access Token',
        'id'          => 'instagram_accesstoken',
        'type'        => 'text',
        'desc'        => 'Visit <a href="http://instagr.am/developer/register/">this link</a> in a new tab, sign in with your Instagram account, click on Create a new application and create your own keys in case you dont have already. After that, you can get your Access Token using <a href="http://labs.themeinity.com/plugins/tools/instagram/">http://labs.themeinity.com/plugins/tools/instagram/</a>',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'misc_tab4',
        'label'       => 'Google+ OAuth',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'gp_text',
        'label'       => 'About the Google+ Settings',
        'desc'        => 'You should fill out these settings if you want to use the Google+ related VC elements or widgets',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Google+ Username',
        'id'          => 'gp_username',
        'type'        => 'text',
        'desc'        => 'Your Google+ Username with leading <strong>+</strong>,',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Google+ API Key',
        'id'          => 'gp_apikey',
        'type'        => 'text',
        'desc'        => 'Visit <a href="https://console.developers.google.com/project">https://console.developers.google.com/project</a> using your Google account, click on the Create Project button and fill the form to create a project. ',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'misc_tab6',
        'label'       => 'YouTube OAuth',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Type',
        'id'          => 'yt_type',
        'type'        => 'radio',
        'desc'        => 'Is this a channel or a user?',
        'choices'     => array(
        	array(
        	  'label'       => 'Channel',
        	  'value'       => 'channel'
        	),
          array(
            'label'       => 'Username',
            'value'       => 'username'
          )
        ),
        'std'         => 'channel',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Username or Channel ID',
        'id'          => 'yt_id',
        'type'        => 'text',
        'desc'        => 'Your Youtube Username ID or Channel ID',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Youtube API Key',
        'id'          => 'yt_apikey',
        'type'        => 'text',
        'desc'        => 'Visit <a href="https://console.developers.google.com/project">https://console.developers.google.com/project</a> using your Google account, click on the Create Project button and fill the form to create a project. Inside your project go to APIs & auth > APIs and turn on the YouTube Data API',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'misc_tab7',
        'label'       => 'Vimeo',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Vimeo Channel Name',
        'id'          => 'vimeo_channel',
        'type'        => 'text',
        'desc'        => 'Please enter your Vimeo channel name (example: "staffpicks")',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'misc_tab8',
        'label'       => 'Create Additional Sidebars',
        'type'        => 'tab',
        'section'     => 'misc'
      ),
      array(
        'id'          => 'sidebars_text',
        'label'       => 'About the sidebars',
        'desc'        => 'All sidebars that you create here will appear both in the Widgets Page(Appearance > Widgets), from where you will have to configure them, and in the pages, where you will be able to choose a sidebar for each page',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'misc'
      ),
      array(
        'label'       => 'Create Sidebars',
        'id'          => 'sidebars',
        'type'        => 'list-item',
        'desc'        => 'Please choose a unique title for each sidebar!',
        'section'     => 'misc',
        'settings'    => array(
          array(
            'label'       => 'ID',
            'id'          => 'id',
            'type'        => 'text',
            'desc'        => 'Please write a lowercase id, with <strong>no spaces</strong>'
          )
        )
      ),
      array(
        'label'       => 'Select Your Demo',
        'id'          => 'demo-select',
        'type'        => 'radio-image',
        'desc'        => '',
        'std'         => '0',
        'section'     => 'import'
      ),
      array(
        'id'          => 'demo_import',
        'label'       => 'About Importing Demo Content',
        'desc'        => '
        <div id="thb-import-messages"></div>
        <p style="text-align:center;"><a class="button button-primary button-hero" id="import-demo-content" href="#">Import Demo Content</a><br /><br />
        <small>Please press only once, and wait till you get the success message above.<br />If you \'re having trouble with import, please see: <a href="https://fuelthemes.ticksy.com/article/2706/">What To Do If Demo Content Import Fails</a></p>',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'import'
      ),
      array(
        'id'          => 'customization_tab0',
        'label'       => 'Colors',
        'type'        => 'tab',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Accent Color',
        'id'          => 'accent_color',
        'type'        => 'colorpicker',
        'desc'        => 'Change the accent color used throughout the theme',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Reading Indicator Color',
        'id'          => 'reading_indicator_color',
        'type'        => 'colorpicker',
        'desc'        => 'Change the reading_indicator color used on article pages',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Sidebar Widget Title Color',
        'id'          => 'sidebar_widget_title_color',
        'type'        => 'colorpicker',
        'desc'        => 'Change the title colors of the widgets on the sidebars',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Footer Widget Title Color',
        'id'          => 'footer_widget_title_color',
        'type'        => 'colorpicker',
        'desc'        => 'Change the title colors of the widgets inside the footer',
        'section'     => 'customization'
      ),
      array(
        'id'          => 'customization_tab2',
        'label'       => 'Typography',
        'type'        => 'tab',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Font Subsets',
        'id'          => 'font_subsets',
        'type'        => 'radio',
        'desc'        => 'You can add additional character subset specific to your language.',
        'choices'     => array(
        	array(
        	  'label'       => 'No Subset',
        	  'value'       => 'no-subset'
        	),
          array(
            'label'       => 'Greek',
            'value'       => 'greek'
          ),
          array(
            'label'       => 'Cyrillic',
            'value'       => 'cyrillic'
          ),
          array(
            'label'       => 'Vietnamese',
            'value'       => 'vietnamese'
          )
        ),
        'std'         => 'no-subset',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Title Typography',
        'id'          => 'title_type',
        'type'        => 'typography',
        'desc'        => 'Font Settings for the titles',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Body Text Typography',
        'id'          => 'body_type',
        'type'        => 'typography',
        'desc'        => 'Font Settings for general body font',
        'section'     => 'customization'
      ),
	  array(
        'label'       => 'Main Menu Typography',
        'id'          => 'menu_left_type',
        'type'        => 'typography',
        'desc'        => 'Font Settings for the main menu',
        'section'     => 'customization'
      ),
	  array(
        'label'       => 'Main Menu Submenu Typography',
        'id'          => 'menu_left_submenu_type',
        'type'        => 'typography',
        'desc'        => 'Font Settings for the submenu elements of the main menu',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Mobile Menu Typography',
        'id'          => 'menu_mobile_type',
        'type'        => 'typography',
        'desc'        => 'Font Settings for the mobile menu',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Mobile Menu Submenu Typography',
        'id'          => 'menu_mobile_submenu_type',
        'type'        => 'typography',
        'desc'        => 'Font Settings for the submenu elements of the mobile menu',
        'section'     => 'customization'
      ),
      array(
        'id'          => 'customization_tab3',
        'label'       => 'Backgrounds',
        'type'        => 'tab',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Sub-Header Background',
        'id'          => 'subheader_bg',
        'type'        => 'background',
        'desc'        => 'Background settings for the sub-header',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Header Background',
        'id'          => 'header_bg',
        'type'        => 'background',
        'desc'        => 'Background settings for the header',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Menu Background',
        'id'          => 'menu_bg',
        'type'        => 'background',
        'desc'        => 'Background settings for the menu. Works with Style1 header',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Footer Background',
        'id'          => 'footer_bg',
        'type'        => 'background',
        'desc'        => 'Background settings for the footer.',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Sub-Footer Background',
        'id'          => 'subfooter_bg',
        'type'        => 'background',
        'desc'        => 'Background settings for the sub-footer.',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Widget Background',
        'id'          => 'widget_bg',
        'type'        => 'background',
        'desc'        => 'Background settings for the sidebar widgets.',
        'section'     => 'customization'
      ),
      array(
        'id'          => 'customization_tab4',
        'label'       => 'Measurements',
        'type'        => 'tab',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Widget Padding',
        'id'          => 'widget_padding',
        'type'        => 'spacing',
        'desc'        => 'You can modify the sidebar widget padding here',
        'section'     => 'customization'
      ),
      array(
        'label'       => 'Page Skin Content',
        'id'          => 'thb_ads_pageskin',
        'type'        => 'textarea',
        'desc'        => 'Content of the pageskin to be displayed below the header',
        'section'     => 'advertising'
      ),
      array(
        'label'       => 'Header Ad',
        'id'          => 'thb_ads_header',
        'type'        => 'textarea-simple',
        'desc'        => 'This content appears next to the logo',
        'rows'        => '4',
        'section'     => 'advertising'
      ),
      array(
        'label'       => 'Display Header Ad on mobile?',
        'id'          => 'thb_ads_header_mobile',
        'type'        => 'on_off',
        'desc'        => 'If you want, you can display the header ad on mobile.',
        'std'         => 'off',
        'section'     => 'advertising'
      ),
      array(
        'id'          => 'footer_tab1',
        'label'       => 'Footer',
        'type'        => 'tab',
        'section'     => 'footer'
      ),
      array(
        'label'       => 'Display Footer',
        'id'          => 'footer',
        'type'        => 'on_off',
        'desc'        => 'Would you like to display the Footer?',
        'std'         => 'on',
        'section'     => 'footer'
      ),
      array(
        'label'       => 'Boxed',
        'id'          => 'footer_boxed',
        'type'        => 'on_off',
        'desc'        => 'Would you like to use the boxed style?',
        'std'         => 'off',
        'section'     => 'footer',
        'condition'   => 'footer:is(on)'
      ),
	  	array(
	  	  'label'       => 'Footer Columns',
	  	  'id'          => 'footer_columns',
	  	  'type'        => 'radio-image',
	  	  'desc'        => 'You can change the layout of footer columns here',
	  	  'std'         => 'threecolumns',
	  	  'section'     => 'footer',
	  	  'condition'   => 'footer:is(on)'
	  	),
	  	array(
	  	  'label'       => 'Footer Color',
	  	  'id'          => 'footer_color',
	  	  'type'        => 'radio',
	  	  'desc'        => 'You can choose your footer color here. You can also change your footer background from "Customization"',
	  	  'choices'     => array(
	  	    array(
	  	      'label'       => 'Light',
	  	      'value'       => 'light'
	  	    ),
	  	    array(
	  	      'label'       => 'Dark',
	  	      'value'       => 'dark'
	  	    )
	  	  ),
	  	  'std'         => 'dark',
	  	  'section'     => 'footer',
	  	  'condition'   => 'footer:is(on)'
	  	),
	  	array(
	  	  'id'          => 'footer_tab2',
	  	  'label'       => 'Sub Footer',
	  	  'type'        => 'tab',
	  	  'section'     => 'footer'
	  	),
	  	array(
	  	  'label'       => 'Display Sub Footer',
	  	  'id'          => 'subfooter',
	  	  'type'        => 'on_off',
	  	  'desc'        => 'Would you like to display the Sub Footer?',
	  	  'std'         => 'on',
	  	  'section'     => 'footer'
	  	),
	  	array(
	  	  'label'       => 'Boxed',
	  	  'id'          => 'subfooter_boxed',
	  	  'type'        => 'on_off',
	  	  'desc'        => 'Would you like to use the boxed style?',
	  	  'std'         => 'off',
	  	  'section'     => 'footer',
	  	  'condition'   => 'subfooter:is(on)'
	  	),
	  	array(
	  	  'label'       => 'Sub-Footer Color',
	  	  'id'          => 'subfooter_color',
	  	  'type'        => 'radio',
	  	  'desc'        => 'You can choose your sub-footer color here. You can also change your sub-footer background from "Customization"',
	  	  'choices'     => array(
	  	    array(
	  	      'label'       => 'Light',
	  	      'value'       => 'light'
	  	    ),
	  	    array(
	  	      'label'       => 'Dark',
	  	      'value'       => 'dark'
	  	    )
	  	  ),
	  	  'std'         => 'dark',
	  	  'section'     => 'footer',
	  	  'condition'   => 'subfooter:is(on)'
	  	),
	  	array(
	  	  'label'       => 'Display Sub Footer Logo',
	  	  'id'          => 'subfooter_logo_switch',
	  	  'type'        => 'on_off',
	  	  'desc'        => 'Would you like to display the Sub Footer?',
	  	  'std'         => 'on',
	  	  'section'     => 'footer',
	  	  'condition'   => 'subfooter:is(on)'
	  	),
	  	array(
	  	  'label'       => 'Sub Footer Logo',
	  	  'id'          => 'subfooter_logo',
	  	  'type'        => 'upload',
	  	  'desc'        => 'You can upload your own subfooter logo here. Since this theme is retina-ready, <strong>please upload a double size image.</strong>',
	  	  'section'     => 'footer',
	  	  'condition'   => 'subfooter:is(on),subfooter_logo_switch:is(on)'
	  	),
	  	array(
	  	  'label'       => 'Sub Footer Logo Height',
	  	  'id'          => 'subfooter_logo_height',
	  	  'type'        => 'measurement',
	  	  'desc'        => 'You can modify the subfooter logo height from here. This is maximum height, so your logo may get smaller depending on screen size',
	  	  'section'     => 'footer',
	  	  'condition'   => 'subfooter:is(on),subfooter_logo_switch:is(on)'
	  	),
      array(
        'label'       => 'Copyright Text',
        'id'          => 'copyright',
        'type'        => 'text',
        'desc'        => 'Copyright Text at the bottom left',
        'section'     => 'footer',
        'condition'   => 'subfooter:is(on)'
      )
    )
  );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
}
/**
 * Category Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_category_select_auto' ) ) {
  
  function ot_type_category_select_auto( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    /* format setting outer wrapper */
    echo '<div class="format-setting type-category-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
      
      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';
      
      /* format setting inner wrapper */
      echo '<div class="format-setting-inner">';
      
        /* build category */
        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
        
        /* get category array */
        $categories = get_categories( apply_filters( 'ot_type_category_select_query', array( 'hide_empty' => false ), $field_id ) );
        
        echo '<option value="auto">' . __( 'Auto Select a Category', 'option-tree' ) . '</option>';
        
        /* has cats */
        if ( ! empty( $categories ) ) {
          foreach ( $categories as $category ) {
            echo '<option value="' . esc_attr( $category->term_id ) . '"' . selected( $field_value, $category->term_id, false ) . '>' . esc_attr( $category->name ) . '</option>';
          }
        } else {
          echo '<option value="">' . __( 'No Categories Found', 'option-tree' ) . '</option>';
        }
        
        echo '</select>';
      
      echo '</div>';
    
    echo '</div>';
    
  }
  
}

/**
 * Category Colorpicker option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_category_colorpicker' ) ) {
  
  function ot_type_category_colorpicker( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    $args = array(
    	'type'                     => 'post',
    	'child_of'                 => 0,
    	'parent'                   => '',
    	'orderby'                  => 'name',
    	'order'                    => 'ASC',
    	'hide_empty'               => 0,
    	'hierarchical'             => 0,
    	'exclude'                  => '',
    	'include'                  => '',
    	'number'                   => '',
    	'taxonomy'                 => 'category',
    	'pad_counts'               => false 
    
    );
    global $sitepress;
    
    if ($sitepress) {
    	remove_filter('terms_clauses', array($sitepress, 'terms_clauses'));
    }
    $categories = get_terms( 'category', array( 'hide_empty'    => false ) );

    foreach ($categories as $category) {
    	$field_id = 'category_colors_'.$category->term_id;
    	$field_name = 'option_tree[category_colors_'.$category->term_id.']';
    	$field_value = ot_get_option($field_id);
    	
    	/* format setting outer wrapper */
	    echo '<div class="format-setting type-colorpicker has-desc format-settings">';
	      
	      /* description */
	      echo '<div class="description">Category color for "' . $category->name . '"</div>';
	      
	      /* format setting inner wrapper */
	      echo '<div class="format-setting-inner">'; 
	        
	        /* build colorpicker */  
	        echo '<div class="option-tree-ui-colorpicker-input-wrap">';
	          
	          /* colorpicker JS */      
	          echo '<script>jQuery(document).ready(function($) { OT_UI.bind_colorpicker("' . esc_attr( $field_id ) . '"); });</script>';
	        
	          /* input */
	          echo '<input type="text" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input cp_input ' . esc_attr( $field_class ) . '" autocomplete="off" />';
	              
	          /* set border color */
	          $border_color = in_array( $field_value, array( '#FFFFFF', '#FFF', '#ffffff', '#fff' ) ) ? '#ccc' : esc_attr( $field_value );
	          
	          echo '<div id="cp_' . esc_attr( $field_id ) . '" class="cp_box"' . ( $field_value ? " style='background-color:" . esc_attr( $field_value ) . "; border-color:$border_color;'" : '' ) . '></div>';
	        
	        echo '</div>';
	      
	      echo '</div>';
	
	    echo '</div>';
    }
    
    
  }
  
}
/**
 * Category Sidebar Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_category_sidebar_select' ) ) {
  
  function ot_type_category_sidebar_select( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );
    
    /* verify a description */
    $has_desc = $field_desc ? true : false;
    
    $args = array(
    	'type'                     => 'post',
    	'child_of'                 => 0,
    	'parent'                   => '',
    	'orderby'                  => 'name',
    	'order'                    => 'ASC',
    	'hide_empty'               => 0,
    	'hierarchical'             => 0,
    	'exclude'                  => '',
    	'include'                  => '',
    	'number'                   => '',
    	'taxonomy'                 => 'category',
    	'pad_counts'               => false 
    
    );
    global $sitepress;
    
    if ($sitepress) {
    	remove_filter('terms_clauses', array($sitepress, 'terms_clauses'));
    }
    $categories = get_terms( 'category', array( 'hide_empty'    => false ) );
		
		/* get the registered sidebars */
    global $wp_registered_sidebars;

    $sidebars = array();
    foreach( $wp_registered_sidebars as $id=>$sidebar ) {
      $sidebars[ $id ] = $sidebar[ 'name' ];
    }

    /* filters to restrict which sidebars are allowed to be selected, for example we can restrict footer sidebars to be selectable on a blog page */
    $sidebars = apply_filters( 'ot_recognized_sidebars', $sidebars );
    $sidebars = apply_filters( 'ot_recognized_sidebars_' . $field_id, $sidebars );
    
    foreach ($categories as $category) {
    	$field_id = 'category_sidebars_'.$category->term_id;
    	$field_name = 'option_tree[category_sidebars_'.$category->term_id.']';
    	$field_value = ot_get_option($field_id);
    	
    	/* format setting outer wrapper */
	    echo '<div class="format-setting type-sidebar-select has-desc">';
	      
	      /* description */
	       echo '<div class="description">Sidebar for "' . $category->name . '"</div>';
	      
	      /* format setting inner wrapper */
	      echo '<div class="format-setting-inner">';
	      
	        /* build page select */
	        echo '<select name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" class="option-tree-ui-select ' . $field_class . '">';
	
	
	        /* has sidebars */
	        if ( count( $sidebars ) ) {
	          echo '<option value="">-- ' . __( 'Choose Sidebar', 'option-tree' ) . ' --</option>';
	          foreach ( $sidebars as $id => $sidebar ) {
	            echo '<option value="' . esc_attr( $id ) . '"' . selected( $field_value, $id, false ) . '>' . esc_attr( $sidebar ) . '</option>';
	          }
	        } else {
	          echo '<option value="">' . __( 'No Sidebars', 'option-tree' ) . '</option>';
	        }
	        
	        echo '</select>';
	        
	      echo '</div>';
	      
	    echo '</div>';
    }
    
    
  }
  
}

/**
 * Category Grid Select option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_category_grid_select' ) ) {
  
  function ot_type_category_grid_select( $args = array() ) {
    
    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;
    $grid_choices = $field_choices['grid'];
    $title_choices = $field_choices['title'];
    $overlay_choices = $field_choices['overlay'];

    $categories = get_terms( 'category', array( 'hide_empty'    => false ) );
    
    foreach ($categories as $category) {
    	/* Grid Style */
    	$grid_id = 'category_grids_'.$category->term_id;
    	$grid_name = 'option_tree[category_grids_'.$category->term_id.']';
    	$grid_value = ot_get_option($grid_id);
    	
    	/* Title Style */
    	$title_id = 'category_grids_title_'.$category->term_id;
    	$title_name = 'option_tree[category_grids_title_'.$category->term_id.']';
    	$title_value = ot_get_option($title_id);
    	
    	/* Overlay Style */
    	$overlay_id = 'category_grids_overlay_'.$category->term_id;
    	$overlay_name = 'option_tree[category_grids_overlay_'.$category->term_id.']';
    	$overlay_value = ot_get_option($overlay_id);
    	
	    /* format setting outer wrapper */
	    echo '<div class="format-setting type-select ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
	      
	      /* description */
	      echo '<div class="description">Grid for "' . $category->name . '"</div>';

	      /* filter choices array */
	      $grid_choices = apply_filters( 'ot_type_select_choices', $grid_choices, $field_id );
	      $title_choices = apply_filters( 'ot_type_select_choices', $title_choices, $field_id );
	      $overlay_choices = apply_filters( 'ot_type_select_choices', $overlay_choices, $field_id );
	      
	      /* format setting inner wrapper */
	      echo '<div class="format-setting-inner">';
	      
	        /* build select - 1*/
	        echo '<select name="' . esc_attr( $grid_name ) . '" id="' . esc_attr( $grid_id ) . '" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
	        foreach ( (array) $grid_choices as $choice ) {
	          if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
	            echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( $grid_value, $choice['value'], false ) . '>' . esc_attr( $choice['label'] ) . '</option>';
	          }
	        }
	        echo '</select>';
	        /* build select - 2 */
	        echo '<select name="' . esc_attr( $title_name ) . '" id="' . esc_attr( $title_id ) . '" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
	        foreach ( (array) $title_choices as $choice ) {
	          if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
	            echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( $title_value, $choice['value'], false ) . '>' . esc_attr( $choice['label'] ) . '</option>';
	          }
	        }
	        echo '</select>';
	        /* build select - 3 */
	        echo '<select name="' . esc_attr( $overlay_name ) . '" id="' . esc_attr( $overlay_id ) . '" class="option-tree-ui-select ' . esc_attr( $field_class ) . '">';
	        foreach ( (array) $overlay_choices as $choice ) {
	          if ( isset( $choice['value'] ) && isset( $choice['label'] ) ) {
	            echo '<option value="' . esc_attr( $choice['value'] ) . '"' . selected( $overlay_value, $choice['value'], false ) . '>' . esc_attr( $choice['label'] ) . '</option>';
	          }
	        }
	        echo '</select>';
	      echo '</div>';
	    
	    echo '</div>';
    
    }
    
  }
  
}