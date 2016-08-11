<?php 
	$vars = $wp_query->query_vars;
	$counts = array_key_exists('counts', $vars) ? $vars['counts'] : false;
	$extra_class = array_key_exists('extra_class', $vars) ? $vars['extra_class'] : false;
	$title_size = array_key_exists('title_size', $vars) ? $vars['title_size'] : false;
	$image_size = array_key_exists('image_size', $vars) ? $vars['image_size'] : false;
	$image_class = array_key_exists('image_class', $vars) ? $vars['image_class'] : false;
?>
<article itemscope itemtype="http://schema.org/Article" <?php post_class('post post-overlay '.$extra_class); ?> role="article">
	<figure class="post-gallery">
		<?php if ($counts) { ?>
			<span class="counts"><?php echo esc_attr($counts); ?></span>
		<?php } ?>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php the_post_thumbnail('goodlife-'.$image_size, array('itemprop'=>'image', 'class'=> $image_class)); ?>
			<?php do_action('thb_post_review_circle','small'); ?>
		</a>
		<header class="post-title entry-header">
			<aside class="post-category"><?php do_action( 'thb_DisplaySingleCategory', true); ?></aside>
			<?php the_title('<'.$title_size.' class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></'.$title_size.'>'); ?>
			<?php do_action('thb_PostMeta', true, true, false, false, false ); ?>
		</header>
	</figure>
</article>