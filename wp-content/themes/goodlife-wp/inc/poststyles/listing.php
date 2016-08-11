<li itemscope itemtype="http://schema.org/Article" <?php post_class('post listing'); ?> role="article">
	<header class="post-title entry-header">
		<?php the_title('<h6 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h6>'); ?>
	</header>
	<?php the_post_thumbnail('goodlife-widget-photo', array('class'=> 'hide', 'itemprop'=>'image')); ?>
	<?php do_action('thb_PostMeta', true, true, false, false, false ); ?>
</li>