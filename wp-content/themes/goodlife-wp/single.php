<?php get_header(); ?>
<?php 
	$infinite = ot_get_option('infinite_load', 'on');
?>
<div id="infinite-article" data-infinite="<?php echo esc_attr($infinite); ?>" class="<?php echo esc_attr($infinite); ?>">
	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
		<?php
			$id = get_the_ID();
			$format = get_post_format();
			if ($format == 'video' ){
				$post_style = get_post_meta($id, 'video-post-detail-style', true) ? get_post_meta($id, 'video-post-detail-style', true) : 'style1';
				get_template_part( 'inc/post-detail-styles/'.$format.'-'.$post_style );
			} else if ($format == 'gallery' ){
				$post_style = get_post_meta($id, 'gallery-post-detail-style', true) ? get_post_meta($id, 'gallery-post-detail-style', true) : 'style1';
				get_template_part( 'inc/post-detail-styles/'.$format.'-'.$post_style );
			} else {
				$post_style = get_post_meta($id, 'standard-post-detail-style', true) ? get_post_meta($id, 'standard-post-detail-style', true) : 'style1';
				get_template_part( 'inc/post-detail-styles/'.$post_style );
			}
		?>
	<?php endwhile; else : endif; ?>
</div>
<?php get_footer(); ?>
