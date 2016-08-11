<?php global $wp_embed; ?>
<?php 
	$id = get_the_ID();
	$embed = get_post_meta($id , 'post_video', TRUE);
	$vimeo = get_post_meta($id , 'post_video_vimeo', TRUE); 
	$other_videos = get_post_meta($id , 'other_videos', TRUE); 
	$video_style = get_post_meta($id , 'video_style', TRUE) ? get_post_meta($id , 'video_style', TRUE) : 'dark'; 
	
	$vars = $wp_query->query_vars;
	$thb_ajax = array_key_exists('thb_ajax', $vars) ? $vars['thb_ajax'] : false;
?>
<div class="post-detail-row">
  <article itemscope itemtype="http://schema.org/Article" <?php post_class('post blog-post '.$video_style.'-color'); ?> id="post-<?php the_ID(); ?>" role="article" data-id="<?php the_ID(); ?>" data-url="<?php the_permalink(); ?>">
  	<figure class="post-gallery video-format-post">
  		<div class="row">
  			<div class="small-12 large-12 columns">
  				<div class="video-container">
  				<?php if ($embed !='') { ?>
  				  <?php echo $wp_embed->run_shortcode('[embed]'.$embed.'[/embed]'); ?>
  				<?php } ?>
  				</div>
  				<header class="post-title entry-header">
  					<?php do_action( 'thb_DisplaySingleCategory', false); ?>
  					<?php the_title('<h1 class="entry-title" itemprop="name headline">', '</h1>' ); ?>
  					<?php do_action('thb_PostMeta', true, true, true, true, true ); ?>
  				</header>
					<div class="post-content entry-content cf medium">
						<?php the_content(); ?>
						<?php if ( is_single()) { wp_link_pages(); } ?>
					</div>
  				<?php do_action('thb_social_article_detail_simple'); ?>
  			</div>
  		</div>
  	</figure>
  </article>
	<?php if ($other_videos !== 'off') { ?>
		<!-- Start Other Videos -->
		<?php
		  $postId = get_the_id();
		  
		  $args = array(
		  	'post_type'=>'post', 
		  	'post_status' => 'publish', 
		  	'ignore_sticky_posts' => 1,
		  	'no_found_rows' => true,
		  	'post__not_in' => array($postId),
		  	'posts_per_page' => 6,
		  	'tax_query' => array(
		  	    array(                
		  	        'taxonomy' => 'post_format',
		  	        'field' => 'slug',
		  	        'terms' => array(
		  	            'post-format-video'
		  	        ),
		  	        'operator' => 'IN'
		  	    )
		  	)
		  );
		  
		  $other_videos = new WP_Query( $args );
		?>
		<?php if ($other_videos->have_posts()) : ?>
		<aside class="other_videos <?php echo esc_attr($video_style.'-color'); ?>">
			<div class="row" data-equal=">.columns">
			  <?php while ($other_videos->have_posts()) : $other_videos->the_post(); ?>             
			    <div class="small-6 medium-4 large-2 columns">
			    	<?php 
			    		set_query_var( 'video_style', $video_style );
			    		get_template_part( 'inc/poststyles/other-videos' ); 
			    	?>
			    </div>
			  <?php endwhile; ?>
		  </div>
		</aside>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
		<!-- End Other Videos -->
	<?php } ?>
	<?php if (!$thb_ajax) { ?>
	<div class="row">
		<div class="small-12 large-12 columns">
				<?php comments_template('', true); ?>
		</div>
	</div>
	<?php } ?>
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