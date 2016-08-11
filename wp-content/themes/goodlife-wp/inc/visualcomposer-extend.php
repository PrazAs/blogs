<?php

// Shortcodes 
$shortcodes = THB_THEME_ROOT_ABS.'/vc_templates/';
$files = glob($shortcodes.'/thb_?*.php');
foreach ($files as $filename)
{
	require get_template_directory().'/vc_templates/'.basename($filename);
}

/* Visual Composer Mappings */

// Adding animation to columns
vc_add_param("vc_column", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Enable Fixed Content",
	"param_name" => "fixed",
	"value" => array(
		"" => "true"
	),
	"description" => "If you enable this, this column will be fixed. You must also enable 'Equal Height Columns' inside parent row settings."
));
vc_add_param("vc_column", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Animation",
	"admin_label" => true,
	"param_name" => "animation",
	"value" => array(
		"None" => "",
		"Left" => "animation right-to-left",
		"Right" => "animation left-to-right",
		"Top" => "animation bottom-to-top",
		"Bottom" => "animation top-to-bottom",
		"Scale" => "animation scale",
		"Fade" => "animation fade-in"
	),
	"description" => ""
));
vc_add_param("vc_column_inner", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => "Animation",
	"admin_label" => true,
	"param_name" => "animation",
	"value" => array(
		"None" => "",
		"Left" => "animation right-to-left",
		"Right" => "animation left-to-right",
		"Top" => "animation bottom-to-top",
		"Bottom" => "animation top-to-bottom",
		"Scale" => "animation scale",
		"Fade" => "animation fade-in"
	),
	"description" => ""
));

// Add parameters to rows
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Disable Column Padding",
	"param_name" => "column_padding",
	"value" => array(
		"" => "false"
	),
	"description" => "You can have columns without spaces using this option"
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Disable Row Padding",
	"param_name" => "row_padding",
	"value" => array(
		"" => "true"
	),
	"description" => "If you enable this, this row won't leave padding on the sides"
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Enable Full Width",
	"param_name" => "thb_full_width",
	"value" => array(
		"" => "true"
	),
	"description" => "If you enable this, this row will fill the screen"
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Equal-height Columns",
	"param_name" => "equal_height",
	"value" => array(
		"" => "true"
	),
	"description" => "You can have columns with same height using this option"
));
vc_add_param("vc_row_inner", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Disable Column Padding",
	"param_name" => "column_padding",
	"value" => array(
		"" => "false"
	),
	"description" => "You can have columns without spaces using this option"
));
vc_add_param("vc_row_inner", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Remove Row Padding",
	"param_name" => "row_padding",
	"value" => array(
		"" => "true"
	),
	"description" => "If you enable this, this row won't leave padding on the sides"
));
vc_add_param("vc_row_inner", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Enable Max Width",
	"param_name" => "max_width",
	"value" => array(
		"" => "true"
	),
	"description" => "If you enable this, this row will not fill the container."
));
vc_add_param("vc_row_inner", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => "Equal-height Columns",
	"param_name" => "equal_height",
	"value" => array(
		"" => "true"
	),
	"description" => "You can have columns with same height using this option"
));

// Remove parameters
vc_remove_param( "vc_row", "full_width" );
vc_remove_param( "vc_row", "content_placement" );

// Button shortcode
vc_map( array(
	"name" => esc_html__("Button", 'goodlife'),
	"base" => "thb_button",
	"icon" => "thb_vc_ico_button",
	"class" => "thb_vc_sc_button",
	"category" => "by Fuel Themes",
	"params" => array(
		array(
		  "type" => "vc_link",
		  "heading" => "link",
		  "param_name" => "link",
		  "description" => "Enter url for link",
		  "admin_label" => true,
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon',
			'value' => 'fa fa-adjust', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Full Width",
			"param_name" => "full_width",
			"value" => array(
				"" => "true"
			),
			"description" => "If enabled, this will make the button fill it's container",
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Button color",
			"param_name" => "color",
			"value" => array(
				"Accent Color" => "accent",
				"Black" => "black",
				"White" => "white",
				"Accent Transparent" => "accent-transparent",
				"White Transparent" => "white-transparent",
				"Black Transparent" => "black-transparent"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Animation",
			"param_name" => "animation",
			"value" => array(
				"None" => "",
				"Left" => "animation right-to-left",
				"Right" => "animation left-to-right",
				"Top" => "animation bottom-to-top",
				"Bottom" => "animation top-to-bottom",
				"Scale" => "animation scale",
				"Fade" => "animation fade-in"
			),
			"description" => ""
		)
	),
	"description" => "Add an animated button"
) );

// Gap shortcode
vc_map( array(
	"name" => esc_html__("Gap", 'goodlife'),
	"base" => "thb_gap",
	"icon" => "thb_vc_ico_gap",
	"class" => "thb_vc_sc_gap",
	"category" => "by Fuel Themes",
	"params" => array(
		array(
		  "type" => "textfield",
		  "heading" => "Gap Height",
		  "param_name" => "height",
		  "admin_label" => true,
		  "description" => "Enter height of the gap in px."
		)
	),
	"description" => "Add a gap to seperate elements"
) );

// Image shortcode
vc_map( array(
	"name" => "Image",
	"base" => "thb_image",
	"icon" => "thb_vc_ico_image",
	"class" => "thb_vc_sc_image",
	"category" => "by Fuel Themes",
	"params" => array(
		array(
			"type" => "attach_image", //attach_images
			"class" => "",
			"heading" => "Select Image",
			"param_name" => "image",
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Full Width?",
			"param_name" => "full_width",
			"value" => array(
				"" => "true"
			),
			"description" => "If selected, the image will always fill its container"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Animation",
			"param_name" => "animation",
			"value" => array(
				"None" => "",
				"Left" => "animation right-to-left",
				"Right" => "animation left-to-right",
				"Top" => "animation bottom-to-top",
				"Bottom" => "animation top-to-bottom",
				"Scale" => "animation scale",
				"Fade" => "animation fade-in"
			),
			"description" => ""
		),
		array(
		  "type" => "textfield",
		  "heading" => "Image size",
		  "param_name" => "img_size",
		  "description" => "Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size."
		),
		array(
		  "type" => "dropdown",
		  "heading" => "Image alignment",
		  "param_name" => "alignment",
		  "value" => array("Align left" => "left", "Align right" => "right", "Align center" => "center"),
		  "description" => "Select image alignment."
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Link to Full-Width Image?",
			"param_name" => "lightbox",
			"value" => array(
				"" => "true"
			)
		),
		array(
		  "type" => "vc_link",
		  "heading" => "Image link",
		  "param_name" => "img_link",
		  "description" => "Enter url if you want this image to have link.",
		  "dependency" => Array('element' => "lightbox", 'is_empty' => true)
		)
	),
	"description" => "Add an animated image"
) );

// Instagram
vc_map( array(
	"name" => esc_html__("Instagram", 'goodlife'),
	"base" => "thb_instagram",
	"icon" => "thb_vc_ico_instagram",
	"class" => "thb_vc_sc_instagram",
	"category" => "by Fuel Themes",
	"params"	=> array(
	  
	  array(
	      "type" => "textfield",
	      "heading" => "Username",
	      "param_name" => "username",
	      "admin_label" => true,
	      "description" => "Instagram Username"
	  ),
	  array(
	      "type" => "textfield",
	      "heading" => "Number of Photos",
	      "param_name" => "number",
	      "description" => "Number of Instagram Photos to retrieve"
	  ),
		array(
			"type" => "dropdown",
			"heading" => "Columns",
			"param_name" => "columns",
			"value" => array(
				'Six Columns' => "6",
				'Five Columns' => "5",
				'Four Columns' => "4",
				'Three Columns' => "3",
				'Two Columns' => "2"
			)
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Disable Column Padding",
			"param_name" => "column_padding",
			"value" => array(
				"" => "false"
			),
			"description" => "You can have columns without spaces using this option"	
		)
	),
	"description" => "Add Instagram Photos"
) );

// Posts Carousel
vc_map( array(
	"name" => esc_html__("Posts Carousel", 'goodlife'),
	"base" => "thb_postcarousel",
	"icon" => "thb_vc_ico_postcarousel",
	"class" => "thb_vc_sc_postcarousel",
	"category" => "by Fuel Themes",
	"params"	=> array(
		array(
		  "type" => "dropdown",
		  "heading" => "Title Position",
		  "param_name" => "title_position",
		  "value" => array(
		  	'Top Left' => "top-title",
		  	'Center Center' => "center-title",
		  	'Bottom Left' => "bottom-title"
		  ),
		  "description" => "Select the title position."
		),
		array(
			"type" => "dropdown",
			"heading" => "Columns",
			"param_name" => "columns",
			"value" => array(
				'Five Columns' => "5",
				'Four Columns' => "4",
				'Three Columns' => "3"
			),
			"description" => "Select the layout."
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Margin",
			"param_name" => "margin",
			"value" => array(
				"" => "true"
			),
			"description" => "If enabled, this will space out the posts.",
		),
		array(
			"type" => "dropdown",
			"heading" => "Post Source",
			"param_name" => "source",
			"value" => array(
				'Most Recent' => "most-recent",
				'By Category' => "by-category",
				'By Post ID' => "by-id",
				'By Tag' => "by-tag",
				'By Share Count' => "by-share",
				'By Author' => "by-author",
				'Top Reviews' => "top-reviews",
				'Latest Reviews' => "latest-reviews"
				),
			"admin_label" => true,
			"description" => "Select the source of the posts you'd like to show."
		),
		array(
		  "type" => "checkbox",
		  "heading" => "Post Categories",
		  "param_name" => "cat",
		  "value" => thb_blogCategories(),
		  "description" => "Which categories would you like to show?",
		  "dependency" => Array('element' => "source", 'value' => array('by-category'))
		),
		array(
		  "type" => "textfield",
		  "class" => "",
		  "heading" => "Number of posts",
		  "param_name" => "item_count",
		  "value" => "4",
		  "description" => "The number of posts to show.",
		  "dependency" => Array('element' => "source", 'value' => array('by-category', 'by-tag', 'by-share', 'by-author', 'most-recent'))
		),
		array(
		  "type" => "textfield",
		  "heading" => "Excluded Tag IDs",
		  "param_name" => "excluded_tag_ids",
		  "description" => "Enter the tag ids you would like to exclude from the most recent posts separated by comma",
		  "dependency" => Array('element' => "source", 'value' => array('most-recent'))
		),
		array(
		  "type" => "textfield",
		  "heading" => "Excluded Category IDs",
		  "param_name" => "excluded_cat_ids",
		  "description" => "Enter the category ids you would like to exclude from the most recent posts separated by comma",
		  "dependency" => Array('element' => "source", 'value' => array('most-recent'))
		),
		array(
		  "type" => "textfield",
		  "heading" => "Post IDs",
		  "param_name" => "post_ids",
		  "description" => "Enter the post IDs you would like to display seperated by comma",
		  "dependency" => Array('element' => "source", 'value' => array('by-id'))
		),
		array(
		  "type" => "textfield",
		  "heading" => "Tag slugs",
		  "param_name" => "tag_slugs",
		  "description" => "Enter the tag slugs you would like to display seperated by comma",
		  "dependency" => Array('element' => "source", 'value' => array('by-tag'))
		),
		array(
		  "type" => "textfield",
		  "heading" => "Author IDs",
		  "param_name" => "author_ids",
		  "description" => "Enter the Author IDs you would like to display seperated by comma",
		  "dependency" => Array('element' => "source", 'value' => array('by-author'))
		),
		array(
		  "type" => "textfield",
		  "heading" => "Offset",
		  "param_name" => "offset",
		  "description" => "You can offset your post with the number of posts entered in this setting",
		  "dependency" => Array('element' => "source", 'value' => array('most-recent', 'by-category', 'by-tag', 'by-author'))
		),
		array(
		  "type" => "dropdown",
		  "heading" => "Color",
		  "param_name" => "color",
		  "value" => array(
		  	'Light' => "light",
		  	'Dark' => "dark"
		  ),
		  "description" => "This changes color of the pagination bullets and navigation arrows."
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Pagination",
			"param_name" => "pagination",
			"value" => array(
				"" => "true"
			),
			"description" => "If enabled, this will show pagination circles underneath",
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Navigation Arrows",
			"param_name" => "navigation",
			"value" => array(
				"" => "true"
			),
			"description" => "If enabled, this will show navigation arrows on the side",
		)
	),
	"description" => "Display Posts from your blog in a Carousel"
) );

// Posts Category
vc_map( array(
	"name" => esc_html__("Posts Category", 'goodlife'),
	"base" => "thb_postcategory",
	"icon" => "thb_vc_ico_postcategory",
	"class" => "thb_vc_sc_postcategory",
	"category" => "by Fuel Themes",
	"params"	=> array(
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Display Category Title?",
			"param_name" => "title",
			"value" => array(
				"" => "true"
			),
			"description" => "If selected, the category title will be displayed on top"
		),
		array(
		    "type" => "dropdown",
		    "heading" => "Style",
		    "param_name" => "style",
		    "admin_label" => true,
		    "value" => array(
		    	'Style 1' => "style1",
		    	'Style 2' => "style2",
		    	'Style 3' => "style3",
		    	'Style 4' => "style4",
		    	'Style 5' => "style5",
		    	'Style 6' => "style6",
		    	'Style 6 - Fashion' => "style6-fashion",
		    	'Style 7' => "style7",
		    	'Style 8' => "style8"
		    ),
		    "description" => "This changes the style of the posts"
		),
		array(
		  "type" => "dropdown",
		  "heading" => "Post Categories",
		  "param_name" => "cat",
		  "value" => thb_blogCategories(),
		  "description" => "Which category would you like to show?"
		),
		array(
		  "type" => "textfield",
		  "heading" => "Excluded Tag IDs",
		  "param_name" => "excluded_tag_ids",
		  "description" => "Enter the tag ids you would like to exclude separated by comma"
		),
		array(
		  "type" => "textfield",
		  "heading" => "Number of posts",
		  "param_name" => "item_count",
		  "value" => "",
		  "description" => "The number of posts to show.<small>Minium 3</small>",
		  "dependency" => Array('element' => "style", 'value' => array('style6', 'style6-fashion', 'style7'))
		),
		array(
		  "type" => "textfield",
		  "heading" => "Offset",
		  "param_name" => "offset",
		  "description" => "You can offset your post with the number of posts entered in this setting"
		)
	),
	"description" => "Display a Category with posts"
) );

// Posts Grid
vc_map( array(
	"name" => esc_html__("Posts Grid", 'goodlife'),
	"base" => "thb_postgrid",
	"icon" => "thb_vc_ico_postgrid",
	"class" => "thb_vc_sc_postgrid",
	"category" => "by Fuel Themes",
	"params"	=> array(
		array(
		    "type" => "dropdown",
		    "heading" => "Style",
		    "param_name" => "style",
		    "admin_label" => true,
		    "value" => array(
		    	'Style 1' => "style1",
		    	'Style 2' => "style2",
		    	'Style 3' => "style3"
		    ),
		    "description" => "This changes the layouts of the grids"
		),
		array(
		  "type" => "dropdown",
		  "heading" => "Display Excerpts?",
		  "param_name" => "thb_excerpts",
		  "value" => array(
		  	'Yes' => "yes",
		  	'No' => "no"
		  ),
		  "description" => "Select if you would like to display the excerpts.",
		  "dependency" => Array('element' => "style", 'value' => array('style2'))
		),
	  array(
	  	"type" => "dropdown",
	  	"heading" => "Post Source",
	  	"param_name" => "source",
	  	"value" => array(
	  		'Most Recent' => "most-recent",
	  		'By Category' => "by-category",
	  		'By Post ID' => "by-id",
	  		'By Tag' => "by-tag",
	  		'By Author' => "by-author",
	  	),
	  	"std" => "most-recent",
	  	"admin_label" => true,
	  	"description" => "Select the source of the posts you'd like to show."
	  ),
	  array(
	    "type" => "checkbox",
	    "heading" => "Post Categories",
	    "param_name" => "cat",
	    "value" => thb_blogCategories(),
	    "description" => "Which categories would you like to show?",
	    "dependency" => Array('element' => "source", 'value' => array('by-category'))
	  ),
	  array(
	    "type" => "textfield",
	    "class" => "",
	    "heading" => "Number of posts",
	    "param_name" => "item_count",
	    "value" => "4",
	    "description" => "The number of posts to show.",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent','by-category', 'by-tag', 'by-share', 'by-author'))
	  ),
	  
	  array(
      "type" => "dropdown",
      "heading" => "Pagination Style",
      "param_name" => "pagination",
      "value" => array(
      	'Regular Pagination' => "style1",
      	'Ajax Load More' => "style2"
      ),
      "description" => "This changes the layouts of the grids",
      "dependency" => Array('element' => "source", 'value' => array('most-recent'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Post IDs",
	    "param_name" => "post_ids",
	    "description" => "Enter the post IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-id'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Tag slugs",
	    "param_name" => "tag_slugs",
	    "description" => "Enter the tag slugs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-tag'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Author IDs",
	    "param_name" => "author_ids",
	    "description" => "Enter the Author IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-author'))
	  ),
	  array(
	      "type" => "dropdown",
	      "heading" => "Columns",
	      "param_name" => "columns",
	      "admin_label" => true,
	      "value" => array(
	      	'Four Columns' => "4",
	      	'Three Columns' => "3",
	      	'Two Columns' => "2"
	      ),
	      "description" => "Select the layout of the posts.",
	      "dependency" => Array('element' => "style", 'value' => array('style2'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Featured Posts (Enlarged Post Image)",
	    "param_name" => "featured_index",
	    "description" => "Enter the number for which posts to show as Featured (For ex, entering 1,3,5 will make those posts appear larger, these are not post IDs, just the number in which they appear)",
	    "dependency" => Array('element' => "style", 'value' => array('style1', 'style3'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Offset",
	    "param_name" => "offset",
	    "description" => "You can offset your post with the number of posts entered in this setting",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent', 'by-category', 'by-tag', 'by-author'))
	  ),
	),
	"description" => "Display your posts in different grid layouts."
) );

// Posts Grid Carousel
vc_map( array(
	"name" => esc_html__("Posts Grid Carousel", 'goodlife'),
	"base" => "thb_postgrid_carousel",
	"icon" => "thb_vc_ico_postgrid_carousel",
	"class" => "thb_vc_sc_postgrid_carousel",
	"category" => "by Fuel Themes",
	"params"	=> array(
	  array(
	      "type" => "dropdown",
	      "heading" => "Style",
	      "param_name" => "style",
	      "admin_label" => true,
	      "value" => array(
	      	'Style 1' => "style1",
	      	'Style 2' => "style2",
	      	'Style 3' => "style3"
	      ),
	      "description" => "This changes the layouts of the grids"
	  ),
	  array(
	    "type" => "dropdown",
	    "heading" => "Title Position",
	    "param_name" => "title_position",
	    "value" => array(
	    	'Top Left' => "top-title",
	    	'Center Center' => "center-title",
	    	'Bottom Left' => "bottom-title"
	    ),
	    "description" => "Select the layout."
	  ),
	  array(
	    "type" => "dropdown",
	    "heading" => "Overlay Style",
	    "param_name" => "overlay_style",
	    "value" => array(
	    	'Standard' => "standard",
	    	'Technology' => "technology"
	    ),
	    "description" => "Select the layout."
	  ),
	  array(
	  	"type" => "dropdown",
	  	"heading" => "Post Source",
	  	"param_name" => "source",
	  	"value" => array(
	  		'Most Recent' => "most-recent",
	  		'By Category' => "by-category",
	  		'By Post ID' => "by-id",
	  		'By Tag' => "by-tag",
	  		'By Author' => "by-author",
	  	),
	  	"std" => "most-recent",
	  	"admin_label" => true,
	  	"description" => "Select the source of the posts you'd like to show."
	  ),
	  array(
	    "type" => "checkbox",
	    "heading" => "Post Categories",
	    "param_name" => "cat",
	    "value" => thb_blogCategories(),
	    "description" => "Which categories would you like to show?",
	    "dependency" => Array('element' => "source", 'value' => array('by-category'))
	  ),
	  array(
	    "type" => "textfield",
	    "class" => "",
	    "heading" => "Number of posts",
	    "param_name" => "item_count",
	    "value" => "4",
	    "description" => "The number of posts to show.",
	    "dependency" => Array('element' => "source", 'value' => array('by-category', 'by-tag', 'by-share', 'by-author', 'most-recent'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Excluded Tag IDs",
	    "param_name" => "excluded_tag_ids",
	    "description" => "Enter the tag ids you would like to exclude from the most recent posts separated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Excluded Category IDs",
	    "param_name" => "excluded_cat_ids",
	    "description" => "Enter the category ids you would like to exclude from the most recent posts separated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Post IDs",
	    "param_name" => "post_ids",
	    "description" => "Enter the post IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-id'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Tag slugs",
	    "param_name" => "tag_slugs",
	    "description" => "Enter the tag slugs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-tag'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Author IDs",
	    "param_name" => "author_ids",
	    "description" => "Enter the Author IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-author'))
	  ),
	  array(
	  	"type" => "checkbox",
	  	"class" => "",
	  	"heading" => "Pagination",
	  	"param_name" => "pagination",
	  	"value" => array(
	  		"" => "true"
	  	),
	  	"description" => "If enabled, this will show pagination circles underneath",
	  ),
	  array(
	  	"type" => "checkbox",
	  	"class" => "",
	  	"heading" => "Navigation Arrows",
	  	"param_name" => "navigation",
	  	"value" => array(
	  		"" => "true"
	  	),
	  	"description" => "If enabled, this will show navigation arrows on the side",
	  )
	),
	"description" => "Display different grid layouts inside a carousel"
) );

// Posts Slider
vc_map( array(
	"name" => esc_html__("Posts Slider", 'goodlife'),
	"base" => "thb_postslider",
	"icon" => "thb_vc_ico_postslider",
	"class" => "thb_vc_sc_postslider",
	"category" => "by Fuel Themes",
	"params"	=> array(
	  array(
	      "type" => "dropdown",
	      "heading" => "Type",
	      "param_name" => "style",
	      "value" => array(
					'Style 1 (Fashion)' => "style1",
					'Style 2 (Overlay Title)' => "style2"
	      ),
	      "admin_label" => true,
	      "description" => "Select the slider style."
	  ),
	  array(
	    "type" => "dropdown",
	    "heading" => "Title Position",
	    "param_name" => "title_position",
	    "value" => array(
	    	'Top Left' => "top-title",
	    	'Center Center' => "center-title",
	    	'Bottom Left' => "bottom-title"
	    ),
	    "description" => "Select the title position.",
	    "dependency" => Array('element' => "style", 'value' => array('style2'))
	  ),
	  array(
	  	"type" => "dropdown",
	  	"class" => "",
	  	"heading" => "Title Size",
	  	"param_name" => "title_size",
	  	"value" => array(
	  		"H4" => "h4",
	  		"H3" => "h3"
	  	),
	  	"description" => "",
	  	"dependency" => Array('element' => "style", 'value' => array('style2'))
	  ),
	  array(
	  	"type" => "dropdown",
	  	"heading" => "Post Source",
	  	"param_name" => "source",
	  	"value" => array(
	  		'Most Recent' => "most-recent",
	  		'By Category' => "by-category",
	  		'By Post ID' => "by-id",
	  		'By Tag' => "by-tag",
	  		'By Share Count' => "by-share",
	  		'By Author' => "by-author",
	  		),
	  	"admin_label" => true,
	  	"description" => "Select the source of the posts you'd like to show."
	  ),
	  array(
	    "type" => "checkbox",
	    "heading" => "Post Categories",
	    "param_name" => "cat",
	    "value" => thb_blogCategories(),
	    "description" => "Which categories would you like to show?",
	    "dependency" => Array('element' => "source", 'value' => array('by-category'))
	  ),
	  array(
	    "type" => "textfield",
	    "class" => "",
	    "heading" => "Number of posts",
	    "param_name" => "item_count",
	    "value" => "4",
	    "description" => "The number of posts to show.",
	    "dependency" => Array('element' => "source", 'value' => array('by-category', 'by-tag', 'by-share', 'by-author', 'most-recent'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Excluded Tag IDs",
	    "param_name" => "excluded_tag_ids",
	    "description" => "Enter the tag ids you would like to exclude from the most recent posts separated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Excluded Category IDs",
	    "param_name" => "excluded_cat_ids",
	    "description" => "Enter the category ids you would like to exclude from the most recent posts separated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Post IDs",
	    "param_name" => "post_ids",
	    "description" => "Enter the post IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-id'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Tag slugs",
	    "param_name" => "tag_slugs",
	    "description" => "Enter the tag slugs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-tag'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Author IDs",
	    "param_name" => "author_ids",
	    "description" => "Enter the Author IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-author'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Offset",
	    "param_name" => "offset",
	    "description" => "You can offset your post with the number of posts entered in this setting",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent', 'by-category', 'by-tag', 'by-author'))
	  ),
	  array(
	  	"type" => "checkbox",
	  	"class" => "",
	  	"heading" => "Pagination",
	  	"param_name" => "pagination",
	  	"value" => array(
	  		"" => "true"
	  	),
	  	"description" => "If enabled, this will show pagination circles underneath",
	  ),
	  array(
	  	"type" => "checkbox",
	  	"class" => "",
	  	"heading" => "Navigation Arrows",
	  	"param_name" => "navigation",
	  	"value" => array(
	  		"" => "true"
	  	),
	  	"description" => "If enabled, this will show navigation arrows on the side",
	  )
	),
	"description" => "Display Posts from your blog in a Slider"
) );

// Posts Trending Bar
vc_map( array(
	"name" => esc_html__("Posts Trending Bar", 'goodlife'),
	"base" => "thb_posttrendingbar",
	"icon" => "thb_vc_ico_posttrendingbar",
	"class" => "thb_vc_sc_posttrendingbar",
	"category" => "by Fuel Themes",
	"params"	=> array(
	  array(
	  	"type" => "dropdown",
	  	"heading" => "Post Source",
	  	"param_name" => "source",
	  	"value" => array(
	  		'Most Recent' => "most-recent",
	  		'By Category' => "by-category",
	  		'By Post ID' => "by-id",
	  		'By Tag' => "by-tag",
	  		'By Author' => "by-author",
	  	),
	  	"std" => "most-recent",
	  	"admin_label" => true,
	  	"description" => "Select the source of the posts you'd like to show."
	  ),
	  array(
	    "type" => "checkbox",
	    "heading" => "Post Categories",
	    "param_name" => "cat",
	    "value" => thb_blogCategories(),
	    "description" => "Which categories would you like to show?",
	    "dependency" => Array('element' => "source", 'value' => array('by-category'))
	  ),
	  array(
	    "type" => "textfield",
	    "class" => "",
	    "heading" => "Number of posts",
	    "param_name" => "item_count",
	    "value" => "4",
	    "description" => "The number of posts to show.",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent','by-category', 'by-tag', 'by-share', 'by-author'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Post IDs",
	    "param_name" => "post_ids",
	    "description" => "Enter the post IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-id'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Tag slugs",
	    "param_name" => "tag_slugs",
	    "description" => "Enter the tag slugs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-tag'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Author IDs",
	    "param_name" => "author_ids",
	    "description" => "Enter the Author IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-author'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Offset",
	    "param_name" => "offset",
	    "description" => "You can offset your post with the number of posts entered in this setting",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent', 'by-category', 'by-tag', 'by-author'))
	  )
	),
	"description" => "Display your posts in scrolling trending bar."
) );

// Button shortcode
vc_map( array(
	"name" => esc_html__("Title", 'goodlife'),
	"base" => "thb_title",
	"icon" => "thb_vc_ico_title",
	"class" => "thb_vc_sc_title",
	"category" => "by Fuel Themes",
	"params" => array(
		array(
		    "type" => "dropdown",
		    "heading" => "Type",
		    "param_name" => "style",
		    "value" => array(
		    	'Style 1 (Left aligned with border)' => "style1",
		    	'Style 2 (Center aligned with icon)' => "style2",
		    	),
		    "admin_label" => true,
		    "description" => "Select the title style."
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'js_composer' ),
			'param_name' => 'icon',
			'value' => 'fa fa-adjust', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => true, // default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'description' => esc_html__( 'Select icon from library.', 'js_composer' ),
			"dependency" => Array('element' => "style", 'value' => array('style2'))
		),
		array(
		  "type" => "textfield",
		  "class" => "",
		  "heading" => "Title",
		  "param_name" => "title",
		  "value" => "",
		  "description" => "The title text"
		)
	),
	"description" => "Add a title to your sections"
) );

// Video Playlist
vc_map( array(
	"name" => esc_html__("Video Playlist", 'goodlife'),
	"base" => "thb_videos",
	"icon" => "thb_vc_ico_videos",
	"class" => "thb_vc_sc_videos",
	"category" => "by Fuel Themes",
	"params"	=> array(
		array(
		    "type" => "dropdown",
		    "heading" => "Style",
		    "param_name" => "style",
		    "admin_label" => true,
		    "value" => array(
		    	'Horizontal' => "style1",
		    	'Vertical' => "style2"
		    ),
		    "description" => "This changes the style of the playlist"
		),
		array(
			"type" => "dropdown",
			"heading" => "Columns",
			"param_name" => "columns",
			"value" => array(
				'Six Columns' => "6",
				'Five Columns' => "5",
				'Four Columns' => "4"
			),
			"dependency" => Array('element' => "style", 'value' => array('style2'))
		),
		array(
	    "type" => "dropdown",
	    "heading" => "Color",
	    "param_name" => "color",
	    "admin_label" => true,
	    "value" => array(
	    	'Dark' => "dark",
	    	'Light' => "light"
	    ),
	    "description" => "This changes the color of the playlist"
		),
	  array(
	  	"type" => "dropdown",
	  	"heading" => "Post Source",
	  	"param_name" => "source",
	  	"value" => array(
	  		'Most Recent' => "most-recent",
	  		'By Category' => "by-category",
	  		'By Tag' => "by-tag",
	  		'By Author' => "by-author",
	  	),
	  	"std" => "most-recent",
	  	"admin_label" => true,
	  	"description" => "Select the source of the posts you'd like to show."
	  ),
	  array(
	    "type" => "checkbox",
	    "heading" => "Post Categories",
	    "param_name" => "cat",
	    "value" => thb_blogCategories(),
	    "description" => "Which categories would you like to show?",
	    "dependency" => Array('element' => "source", 'value' => array('by-category'))
	  ),
	  array(
	    "type" => "textfield",
	    "class" => "",
	    "heading" => "Number of posts",
	    "param_name" => "item_count",
	    "value" => "4",
	    "description" => "The number of posts to show."
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Tag slugs",
	    "param_name" => "tag_slugs",
	    "description" => "Enter the tag slugs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-tag'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Author IDs",
	    "param_name" => "author_ids",
	    "description" => "Enter the Author IDs you would like to display seperated by comma",
	    "dependency" => Array('element' => "source", 'value' => array('by-author'))
	  ),
	  array(
	    "type" => "textfield",
	    "heading" => "Offset",
	    "param_name" => "offset",
	    "description" => "You can offset your post with the number of posts entered in this setting",
	    "dependency" => Array('element' => "source", 'value' => array('most-recent', 'by-category', 'by-tag', 'by-author'))
	  ),
	),
	"description" => "Display your video posts in a playlist"
) );