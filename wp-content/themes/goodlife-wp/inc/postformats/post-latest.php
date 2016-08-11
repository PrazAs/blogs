<!-- Start Related Posts -->
<?php
  $postId = get_the_id();
  
  $args = array(
  	'post_type'=>'post', 
  	'post_status' => 'publish', 
  	'ignore_sticky_posts' => 1,
  	'no_found_rows' => true,
  	'post__not_in' => array($postId),
  	'posts_per_page' => ot_get_option('related_count', 8)
  );
  
  $related_posts = new WP_Query( $args );
?>
<?php if ($related_posts->have_posts()) : ?>
<aside class="related-posts cf hide-on-print">
	<h4 class="related-title"><?php _e( 'Latest News', 'goodlife' ); ?></h4>
	<div class="row">
  <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>             
    <div class="small-6 medium-6 large-3 columns">
    	<?php get_template_part( 'inc/poststyles/style1' ); ?>
    </div>
  <?php endwhile; ?>
  </div>
</aside>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
<!-- End Related Posts -->