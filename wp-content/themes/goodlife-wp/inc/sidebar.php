<?php
function thb_register_sidebars() {
	register_sidebar(array('name' => esc_html__('Blog Sidebar','goodlife'), 'id' => 'blog', 'description' => esc_html__('The sidebar visible in the blog page','goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Article Sidebar','goodlife'), 'id' => 'single', 'description' => esc_html__('The sidebar visible in the article page','goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Category Sidebar','goodlife'), 'id' => 'category', 'description' => esc_html__('The sidebar visible in the category pages','goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Author Sidebar','goodlife'), 'id' => 'author', 'description' => esc_html__('The sidebar visible in the author pages','goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Footer Column 1', 'goodlife'), 'id' => 'footer1', 'description' => esc_html__('Footer - first column', 'goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Footer Column 2', 'goodlife'), 'id' => 'footer2', 'description' => esc_html__('Footer - second column', 'goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Footer Column 3', 'goodlife'), 'id' => 'footer3', 'description' => esc_html__('Footer - third column', 'goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Footer Column 4', 'goodlife'), 'id' => 'footer4', 'description' => esc_html__('Footer - forth column', 'goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Footer Column 5', 'goodlife'), 'id' => 'footer5', 'description' => esc_html__('Footer - fifth column', 'goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
	
	register_sidebar(array('name' => esc_html__('Footer Column 6', 'goodlife'), 'id' => 'footer6', 'description' => esc_html__('Footer - sixth column', 'goodlife'), 'before_widget' => '<div id="%1$s" class="widget cf %2$s">', 'after_widget' => '</div>', 'before_title' => '<strong>', 'after_title' => '</strong>'));
}
add_action( 'widgets_init', 'thb_register_sidebars' );
function thb_sidebar_setup() {
	$sidebars = ot_get_option('sidebars');
	if(!empty($sidebars)) {
		foreach($sidebars as $sidebar) {
			register_sidebar( array(
				'name' => $sidebar['title'],
				'id' => $sidebar['id'],
				'description' => '',
				'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<strong>',
				'after_title' => '</strong>',
			));
		}
	}
}
add_action( 'after_setup_theme', 'thb_sidebar_setup' );
?>