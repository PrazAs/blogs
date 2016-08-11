<?php 
	$vars = $wp_query->query_vars;
	$thb_excerpts = array_key_exists('thb_excerpts', $vars) ? $vars['thb_excerpts'] : false;
?>
<article itemscope itemtype="http://schema.org/Article" <?php post_class('post style3'); ?> role="article">
	<?php if ( has_post_thumbnail() ) { ?>
	<figure class="post-gallery max-height">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php the_post_thumbnail('goodlife-latest-short', array('itemprop'=>'image')); ?>
			<?php do_action('thb_post_review_circle','small'); ?>
		</a>
	</figure>
	<?php } ?>
	<header class="post-title entry-header">
		<?php the_title('<h5 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h5>'); ?>
	</header>
	<?php do_action('thb_PostMeta', true, true, false, false, false ); ?>
	<?php if ($thb_excerpts !== 'no') { ?>
	<div class="post-content entry-content small">
		<?php echo thb_excerpt(150, '&hellip;'); ?>
	</div>
	<?php do_action('thb_PostMeta', false, false, true, true, false ); ?>
	<?php } ?>
</article>