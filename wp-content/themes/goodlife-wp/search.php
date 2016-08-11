<?php get_header(); ?>
<div class="row top-padding" data-equal=">.equal" data-row-detection="true">
	<section class="small-12 medium-8 columns equal">
		<div class="category_title no-border search">
			<h4><?php _e( 'Search Results For', 'goodlife' ); ?>: <span><?php the_search_query(); ?></span></h4>
		</div>
	  <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'inc/poststyles/style2' ); ?>
	  <?php endwhile; ?>
	  <?php the_posts_pagination(array(
	  	'prev_text' 	=> '<span>'.esc_html__( "&larr;", 'goodlife' ).'</span>',
	  	'next_text' 	=> '<span>'.esc_html__( "&rarr;", 'goodlife' ).'</span>',
	  	'mid_size'		=> 2
	  )); ?>
	  <?php else : ?>
	    <?php get_template_part( 'inc/loop/notfound' ); ?>
	  <?php endif; ?>
	</section>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>