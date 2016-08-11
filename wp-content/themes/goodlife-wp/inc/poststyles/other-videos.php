<?php 
	$vars = $wp_query->query_vars;
	$video_style = array_key_exists('video_style', $vars) ? $vars['video_style'] : false;
?>
<article itemscope itemtype="http://schema.org/Article" <?php post_class('post video-others '.$video_style.'-color'); ?> role="article">
	<figure class="post-gallery">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
			<?php the_post_thumbnail('goodlife-video-others', array('itemprop'=>'image')); ?>
		</a>
	</figure>
	<header class="post-title entry-header">
		<?php the_title('<h6 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h6>'); ?>
	</header>
</article>