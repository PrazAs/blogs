<?php 
	$vars = $wp_query->query_vars;
	$counts = array_key_exists('counts', $vars) ? $vars['counts'] : false;
	$postmeta = array_key_exists('postmeta', $vars) ? $vars['postmeta'] : false;
?>
<li itemscope itemtype="http://schema.org/Article" <?php post_class('post listing'); ?> role="article">
	<?php if ( has_post_thumbnail() ) { ?>
	<figure class="post-gallery">
		<?php if ($counts) { ?>
			<span class="counts"><?php echo esc_attr($counts); ?></span>
		<?php } ?>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php the_post_thumbnail('post-thumbnail', array('itemprop'=>'image')); ?>
		</a>
	</figure>
	<?php } ?>
	<div class="listing-content">
		<?php if(has_category()) { ?>
			<aside class="post-category"><?php do_action( 'thb_DisplaySingleCategory', false); ?></aside>
		<?php } ?>
		<header class="post-title entry-header">
			<?php the_title('<h6 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h6>'); ?>
		</header>
		<?php if ($postmeta) { ?>
		<?php do_action('thb_PostMeta', $postmeta[0], $postmeta[1], $postmeta[2], $postmeta[3], $postmeta[4]  ); ?>
		<?php } else { ?>
		<?php do_action('thb_PostMeta', true, true, false, false, false ); ?>
		<?php } ?>
	</div>
</li>