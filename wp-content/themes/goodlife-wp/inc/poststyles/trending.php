<article itemscope itemtype="http://schema.org/Article" <?php post_class('post trending'); ?> role="article">
	<header class="post-title entry-header">
		<aside class="post-category"><?php do_action( 'thb_DisplaySingleCategory', true); ?></aside>
		<?php the_title('<h6 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h6>'); ?>
		<?php do_action('thb_PostMeta', false, false, false, false, false); ?>
	</header>
</article>