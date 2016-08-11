<?php function thb_selection() {
	$id = get_queried_object_id();
	ob_start();
?>
/* Options set in the admin page */
body { 
	<?php thb_typeecho(ot_get_option('title_type'), false, 'Poppins'); ?>
	color: <?php echo ot_get_option('text_color'); ?>;
}
.post .post-content p,
.post .post-content ul,
.post .post-content ol {
	<?php thb_typeecho(ot_get_option('body_type'), false, 'Droid Serif'); ?>
}
.titlefont, body, h1, h2, h3, h4, h5, h6, blockquote, .subheader, .post-review ul li, .post-review .comment_section p:before, .post-review .post_comment, .subcategory_container ul li a, .featured_image_credit {
	<?php thb_typeecho(ot_get_option('title_type'), false, 'Poppins'); ?>	
}
/* Sub Header */
<?php if ($subheader_bg = ot_get_option('subheader_bg')) { ?>
.subheader {
	<?php thb_bgecho($subheader_bg); ?>
}
.subheader.dark ul > li .sub-menu,
.subheader.light ul > li .sub-menu {
	background: <?php echo thb_adjustColorLightenDarken($subheader_bg['background-color'], -8); ?>;
}
<?php } ?>
/* Header */
@media only screen and (min-width: 48.063em) {
	.header {
		<?php thb_paddingecho(ot_get_option('header_spacing')); ?>
	}
}
.header {
	<?php thb_bgecho(ot_get_option('header_bg')); ?>
}

/* Header Item Colors */
<?php if ($menu_color_dark = ot_get_option('menu_color_dark')) { ?>
.header.header--dark .sf-menu > li > a {
	color: <?php echo esc_attr($menu_color_dark); ?>;
}
@media only screen and (min-width: 48.063em) {
	.header.header--dark #quick_wishlist_icon path {
		stroke: <?php echo esc_attr($menu_color_dark); ?>;
	}
	.header.header--dark #quick_search_icon, 
	.header.header--dark #quick_cart_icon {
		fill: <?php echo esc_attr($menu_color_dark); ?>;
	}
}
<?php } ?>
<?php if ($menu_color_light = ot_get_option('menu_color_light')) { ?>
.header.header--light .sf-menu > li > a {
	color: <?php echo esc_attr($menu_color_light); ?>;
}
@media only screen and (min-width: 48.063em) {
	.header.header--light #quick_wishlist_icon path {
		stroke: <?php echo esc_attr($menu_color_light); ?>;
	}
	.header.header--light #quick_search_icon, 
	.header.header--light #quick_cart_icon {
		fill: <?php echo esc_attr($menu_color_light); ?>;
	}
}
<?php } ?>
/* Logo Height */
@media only screen and (min-width: 64.063em) {
.header .logo .logoimg {
	max-height: <?php thb_measurementecho(ot_get_option('logo_height'), array('50', 'px')); ?>;
}
}
/* Menu */
/*<?php if ($menu_bg = ot_get_option('menu_bg')) { ?>
.menu-holder.style1.dark {
	<?php thb_bgecho(ot_get_option('menu_bg')); ?>
}
<?php } ?>*/
/* Colors */
<?php if ($accent_color = ot_get_option('accent_color')) { ?>
a:hover, .menu-holder ul li.menu-item-mega-parent .thb_mega_menu_holder .thb_mega_menu li.active a,.menu-holder ul li.sfHover > a, .subcategory_container .thb-sibling-categories li a:hover,label small, .more-link, .comment-respond .comment-reply-title small a, .btn.accent, .button.accent, input[type=submit].accent, .btn.accent-transparent, .button.accent-transparent, input[type=submit].accent-transparent, .category_title.search span, .video_playlist .video_play.video-active .post-title h6, .menu-holder.dark ul li .sub-menu a:hover, .menu-holder.dark ul.sf-menu > li > a:hover {
  color: <?php echo esc_attr($accent_color); ?>;
}
ul.point-list li:before, ol.point-list li:before, .post .article-tags .tags-title, .post.post-overlay .post-gallery .counts,
.post-review ul li .progress span, .post-review .average, .category-title.style1 .category-header, .widget.widget_topreviews .style1 li .progress, .btn.black:hover, .button.black:hover, input[type=submit].black:hover, .btn.white:hover, .button.white:hover, input[type=submit].white:hover, .btn.accent-transparent:hover, .button.accent-transparent:hover, input[type=submit].accent-transparent:hover, #scroll_totop:hover, .subheader.fixed > .row .progress {
	background-color: <?php echo esc_attr($accent_color); ?>;
}
.menu-holder ul li.menu-item-mega-parent .thb_mega_menu_holder, .btn.black:hover, .button.black:hover, input[type=submit].black:hover, .btn.accent, .button.accent, input[type=submit].accent, .btn.white:hover, .button.white:hover, input[type=submit].white:hover, .btn.accent-transparent, .button.accent-transparent, input[type=submit].accent-transparent {
	border-color: <?php echo esc_attr($accent_color); ?>;
}
.post .article-tags .tags-title:after {
	border-left-color: <?php echo esc_attr($accent_color); ?>;
}
.circle_rating .circle_perc {
	stroke: <?php echo esc_attr($accent_color); ?>;
}
.header .quick_search.active .quick_search_icon {
	fill: <?php echo esc_attr($accent_color); ?>;
}
.post .post-content p a {
	border-color: <?php echo thb_adjustColorLightenDarken($accent_color, -50); ?>;
	-moz-box-shadow: inset 0 -5px 0 <?php echo thb_adjustColorLightenDarken($accent_color, -50); ?>;
	-webkit-box-shadow: inset 0 -5px 0 <?php echo thb_adjustColorLightenDarken($accent_color, -50); ?>;
	box-shadow: inset 0 -5px 0 <?php echo thb_adjustColorLightenDarken($accent_color, -50); ?>;
}
.post .post-content p a:hover {
	background: <?php echo thb_adjustColorLightenDarken($accent_color, -50); ?>;
}

<?php } ?>
<?php if ($reading_indicator_color = ot_get_option('reading_indicator_color')) { ?>
.subheader.fixed > .row .progress {
	background: <?php echo esc_attr($reading_indicator_color); ?>;
}
<?php } ?>
<?php if ($sidebar_widget_title_color = ot_get_option('sidebar_widget_title_color')) { ?>
.widget > strong {
	color: <?php echo esc_attr($sidebar_widget_title_color); ?>;
	border-color: <?php echo esc_attr($sidebar_widget_title_color); ?>;
}
<?php } ?>
<?php if ($footer_widget_title_color = ot_get_option('footer_widget_title_color')) { ?>
#footer.dark .widget > strong,
#footer .widget > strong {
	color: <?php echo esc_attr($footer_widget_title_color); ?>;
	border-color: rgba(<?php echo thb_hex2rgb($footer_widget_title_color); ?>, .55);
}
<?php } ?>

/* Measurements */
<?php if ($widget_padding = ot_get_option('widget_padding')) { ?>
.widget {
	<?php thb_spacingecho($widget_padding, false, 'padding'); ?>;
}
<?php } ?>

/* Menu */
<?php if ($menu_margin = ot_get_option('header_menu_margin')) { ?>
@media only screen and (min-width: 80em) {
	.menu-holder ul.sf-menu > li {
		margin-right: <?php echo esc_attr($menu_margin[0].$menu_margin[1]); ?>;
	}
}
<?php } ?>
<?php if ($menu_left = ot_get_option('menu_left_type')) { ?>
.menu-holder ul.sf-menu > li > a {
	<?php thb_typeecho($menu_left); ?>	
}
<?php } ?>
<?php if ($submenu_left = ot_get_option('menu_left_submenu_type')) { ?>
.menu-holder ul li .sub-menu li a,
.menu-holder ul li.menu-item-mega-parent .thb_mega_menu_holder .thb_mega_menu li > a {
	<?php thb_typeecho($submenu_left); ?>	
}
<?php } ?>

/* Mobile Menu */
<?php if ($menu_mobile = ot_get_option('menu_mobile_type')) { ?>
.mobile-menu li a {
	<?php thb_typeecho($menu_mobile); ?>	
}
<?php } ?>
<?php if ($submenu_mobile = ot_get_option('menu_mobile_submenu_type')) { ?>
.mobile-menu .sub-menu li a {
	<?php thb_typeecho($submenu_mobile); ?>	
}
<?php } ?>

/* Category Colors */
<?php 
	$categories = get_terms( 'category', array( 'hide_empty' => false ) ); 
	foreach ($categories as $category) {
		$cat_id = $category->term_id;
		$color = ot_get_option('category_colors_'. $cat_id);
		$header_bg = absint( get_term_meta( $cat_id, 'thb_header_id', true ) );
		if ($color) {	
		?>
			.header .menu-holder ul.sf-menu > li.menu-item-category-<?php echo esc_attr($cat_id); ?> > a:hover,
			.menu-holder.style1 ul.sf-menu > li.menu-item-category-<?php echo esc_attr($cat_id); ?> > a:hover,
			.menu-holder ul li.menu-item-mega-parent .thb_mega_menu_holder .thb_mega_menu li.menu-item-category-<?php echo esc_attr($cat_id); ?> > a:hover,
			.menu-holder ul li.menu-item-mega-parent .thb_mega_menu_holder .thb_mega_menu li.menu-item-category-<?php echo esc_attr($cat_id); ?>.active > a,
			.menu-holder ul li .sub-menu li.menu-item-category-<?php echo esc_attr($cat_id); ?> > a:hover,
			.post .single_category_title.category-link-<?php echo esc_attr($cat_id); ?> {
				color: <?php echo esc_attr($color); ?>;
			}
			.menu-holder ul.sf-menu > li.menu-item-category-<?php echo esc_attr($cat_id); ?> > a + .thb_mega_menu_holder {
				border-color: <?php echo esc_attr($color); ?>;
			}
			.post .single_category_title.category-boxed-link-<?php echo esc_attr($cat_id); ?>.boxed-link,
			.category_title.cat-<?php echo esc_attr($cat_id); ?>:before,
			.category-title.style1 .category-header.cat-<?php echo esc_attr($cat_id); ?> {
				background-color: <?php echo esc_attr($color); ?>;
			}
		<?php
		}
		if ($header_bg) {
			$image = wp_get_attachment_url( $header_bg );	
			?>
			.category-title.style1 .category-header.cat-<?php echo esc_attr($cat_id); ?> {
				background-image: url(<?php echo esc_attr($image); ?>);
			}
			<?php
		}
	}
?>

/* Widgets */
<?php if ($widget_bg = ot_get_option('widget_bg')) { ?>
.widget:not(.widget_singlead) {
	<?php thb_bgecho($widget_bg); ?>
}
[role="main"] .widget.widget_categoryslider .slick-nav {
	<?php thb_bgecho($widget_bg); ?>
}
<?php } ?>
<?php if ($footer_bg = ot_get_option('footer_bg')) { ?>
/* Footer */
#footer {
	<?php thb_bgecho($footer_bg); ?>
}
#footer .widget.widget_categoryslider .slick-nav {
	<?php thb_bgecho($footer_bg); ?>
}
<?php } ?>
/* Sub-Footer */
#subfooter {
	<?php thb_bgecho(ot_get_option('subfooter_bg')); ?>
}
/* Sub-Footer Logo Height */
@media only screen and (min-width: 48.063em) {
	#subfooter .subfooter-menu-holder .logolink .logoimg {
		max-height: <?php thb_measurementecho(ot_get_option('subfooter_logo_height'), array('25', 'px')); ?>;
	}
}
/* Extra CSS */
<?php 
echo ot_get_option('extra_css');
?>
<?php 
	$out = ob_get_contents();
	if (ob_get_contents()) ob_end_clean();
	// Remove comments
	$out = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $out);
	// Remove space after colons
	$out = str_replace(': ', ':', $out);
	// Remove whitespace
	$out = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $out);
	
	return $out;
}