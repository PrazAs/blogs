<article itemscope itemtype="http://schema.org/Article" <?php post_class('post style1 solo'); ?> role="article">
	<?php if ( has_post_thumbnail() ) { ?>
	<figure class="post-gallery">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php the_post_thumbnail('goodlife-latest-short', array('itemprop'=>'image')); ?>
			<?php do_action('thb_post_review_circle','small'); ?>
		</a>
	</figure>
	<?php } ?>
	<aside class="post-category"><?php do_action( 'thb_DisplaySingleCategory', false); ?></aside>
	<header class="post-title entry-header">
		<?php the_title('<h6 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h6>'); ?>
	</header>
	<?php do_action('thb_PostMeta', false, false, false, false, false ); ?>
</article>