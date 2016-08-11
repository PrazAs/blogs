<?php 
	$vars = $wp_query->query_vars;
	$image_class = array_key_exists('image_class', $vars) ? $vars['image_class'] : false;
?>
<article itemscope itemtype="http://schema.org/Article" <?php post_class('post post-overlay center-title'); ?> role="article">
	<figure class="post-gallery">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail('goodlife-widget-photo-vertical', array('itemprop'=>'image', 'class' => $image_class)); ?>
		</a>
		<header class="post-title entry-header">
			<aside class="post-category"><?php do_action( 'thb_DisplaySingleCategory', true); ?></aside>
			<?php the_title('<h5 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h5>'); ?>
			<?php do_action('thb_PostMeta', true, true, false, false, false ); ?>
		</header>

	</figure>
</article>