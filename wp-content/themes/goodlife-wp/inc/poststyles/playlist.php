<?php 
	$id = get_the_ID();
	$embed = get_post_meta($id , 'post_video', TRUE);
	$vars = $wp_query->query_vars;
	$color = array_key_exists('color', $vars) ? $vars['color'] : false;
	$active = array_key_exists('active', $vars) ? $vars['active'] : false;
	$image_class = array_key_exists('image_class', $vars) ? $vars['image_class'] : false;
?>
<article itemscope itemtype="http://schema.org/Article" <?php post_class('post listing '.$color.'-color'); ?> role="article">
	<a href="#" class="video_play <?php echo esc_attr($active); ?>" data-video-url="<?php echo esc_attr($embed); ?>" data-post-id="<?php the_ID(); ?>">
		<?php if ( has_post_thumbnail() ) { ?>
		<figure class="post-gallery no-video-icon">
				<?php the_post_thumbnail('post-thumbnail', array('itemprop'=>'image', 'class' => $image_class)); ?>
		</figure>
		<?php } ?>
		<div class="listing-content">
			<header class="post-title entry-header">
				<?php the_title('<h6 class="entry-title" itemprop="name headline">', '</h6>'); ?>
			</header>
			<?php do_action('thb_PostMeta', false, false, false, false, true ); ?>
		</div>
	</a>
</article>