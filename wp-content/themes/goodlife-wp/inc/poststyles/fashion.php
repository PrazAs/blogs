<?php 
	$vars = $wp_query->query_vars;
	$extra_class = array_key_exists('extra_class', $vars) ? $vars['extra_class'] : false;
	$title_size = array_key_exists('title_size', $vars) ? $vars['title_size'] : false;
	$image_size = array_key_exists('image_size', $vars) ? $vars['image_size'] : false;
	$excerpt = array_key_exists('excerpt', $vars) ? $vars['excerpt'] : false;
	$image_class = array_key_exists('image_class', $vars) ? $vars['image_class'] : false;
?>
<article itemscope itemtype="http://schema.org/Article" <?php post_class('post post-fashion '.$extra_class); ?> role="article">
	<figure class="post-gallery no-video-icon no-gallery-icon">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php the_post_thumbnail('goodlife-'.$image_size, array('itemprop'=>'image', 'class'=> $image_class)); ?>
			<?php do_action('thb_post_review_circle','small'); ?>
		</a>
		<div class="post-title-container">
			<aside class="post-category"><?php do_action( 'thb_DisplaySingleCategory', false); ?></aside>
			<header class="post-title entry-header">
				<?php the_title('<'.$title_size.' class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></'.$title_size.'>'); ?>
			</header>
			<?php do_action('thb_PostMeta', true, true, false, false, false ); ?>
			<?php if ($excerpt) { ?>
			<div class="post-content entry-content small">
				<?php echo thb_excerpt(200, '&hellip;'); ?>
			</div>
			<?php do_action('thb_PostMeta', false, false, true, true, false ); ?>
			<?php } ?>
		</div>
	</figure>
</article>