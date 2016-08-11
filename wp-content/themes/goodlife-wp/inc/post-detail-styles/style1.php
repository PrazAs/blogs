<?php
	$id = get_the_ID();
	$review_style = get_post_meta($id, 'post-review-style', true);
	$fixed = ot_get_option('article_fixed_sidebar', 'on'); 
	$featured_image = get_post_meta($id, 'standard-featured-image', true);
	$featured_image_credit = get_post_meta($id, 'standard-featured-credit', true);
	
	$vars = $wp_query->query_vars;
	$thb_ajax = array_key_exists('thb_ajax', $vars) ? $vars['thb_ajax'] : false;
?>
<div class="row post-detail-row top-padding"<?php if ($fixed == 'on') { ?> data-equal=">.columns" data-row-detection="true"<?php } ?>>
	<div class="small-12 medium-8 columns">

	  <article itemscope itemtype="http://schema.org/Article" <?php post_class('post blog-post'); ?> id="post-<?php the_ID(); ?>" role="article" data-id="<?php the_ID(); ?>" data-url="<?php the_permalink(); ?>">
	  	<header class="post-title entry-header">
	  		<?php do_action( 'thb_DisplaySingleCategory', false); ?>
	  		<?php the_title('<h1 class="entry-title" itemprop="name headline">', '</h1>' ); ?>
	  		<?php do_action('thb_PostMeta', true, true, true, true, true ); ?>
	  	</header>
	  	<?php if ( has_post_thumbnail() && $featured_image != 'off') { ?>
	  	<figure class="post-gallery">
	  		<?php the_post_thumbnail('goodlife-post-style1', array('itemprop'=>'image')); ?>
	  		<?php if ($featured_image_credit) { ?>
	  			<figcaption class="featured_image_credit"><?php echo esc_attr($featured_image_credit); ?></figcaption>
	  		<?php } ?>
	  	</figure>
	  	<?php } ?>
	  	<div class="share-container">
		  	<?php do_action('thb_social_article_detail_vertical', false, true, 'hide-for-small'); ?>
			  <div class="post-content-container">
					<div class="post-content entry-content cf">
						<?php if ($review_style !== 'style3') { do_action('thb_post_review' ); } ?>
			    	<?php the_content(); ?>
			    	<?php if ( is_single()) { wp_link_pages(); } ?>
			    	
					</div>
				</div>
			</div>
			<?php if ($review_style === 'style3') { do_action('thb_post_review' ); } ?>
			<?php get_template_part( 'inc/postformats/post-end' ); ?>
	  </article>

		<?php if (!$thb_ajax) { ?>
			<?php comments_template('', true); ?>
		<?php } ?>
	</div>
	<?php get_sidebar('single'); ?>
</div>
<?php if (!$thb_ajax) { ?>
	<?php if(ot_get_option('related_posts') !== 'off') { ?>
	<div class="row">
		<div class="small-12 columns">
			<?php get_template_part( 'inc/postformats/post-latest' ); ?>
		</div>
	</div>
	<?php } ?>
<?php } ?>
