<article itemscope itemtype="http://schema.org/Article" <?php post_class('post post-overlay photo-listing'); ?> role="article">
	<figure class="post-gallery">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php the_post_thumbnail('goodlife-widget-photo', array('itemprop'=>'image')); ?>
			<?php do_action('thb_post_review_circle','small'); ?>
		</a>
		<header class="post-title entry-header">
			<?php the_title('<h5 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h5>'); ?>
			<?php do_action('thb_PostMeta', true, true, false, false, false ); ?>
		</header>

	</figure>
</article>