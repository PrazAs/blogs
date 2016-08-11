<?php
	$id = get_the_ID();
	$attachments = get_post_meta($id, 'pp_gallery_slider', TRUE);
	$attachment_array = explode(',', $attachments);
	$length = sizeof($attachment_array);
	$permalink = get_permalink();
	$page = isset($page) ? $page : '0';
	
	$vars = $wp_query->query_vars;
	$thb_ajax = array_key_exists('thb_ajax', $vars) ? $vars['thb_ajax'] : false;
?>
<div class="row post-detail-row top-padding" data-equal=".equal, .sidebar" data-row-detection="true">
	<div class="small-12 medium-8 columns equal">
		  <article itemscope itemtype="http://schema.org/Article" <?php post_class('post blog-post'); ?> id="post-<?php the_ID(); ?>" role="article" data-id="<?php the_ID(); ?>" data-url="<?php the_permalink(); ?>">
		  	<header class="post-title entry-header">
		  		<?php do_action( 'thb_DisplaySingleCategory', false); ?>
		  		<?php the_title('<h1 class="entry-title" itemprop="name headline">', '</h1>' ); ?>
		  		<?php do_action('thb_PostMeta', true, true, true, true, true ); ?>
		  	</header>
		  	<div class="row" data-equal=">.columns">
			  	<div class="small-12 medium-7 columns">
				  	<figure class="post-gallery gallery-format-post vertical">
				  		
				  		<?php 
				  			if ( '' != get_option('permalink_structure') ) {
				  			    // using pretty permalinks, append to url
				  			    $prev = user_trailingslashit( $permalink . ($page - 1) );
				  			    $next = user_trailingslashit( $permalink . ($page + 1) );
				  			  } else {
				  			    $prev = add_query_arg( array ('page' => $page - 1), $permalink );
				  			    $next = add_query_arg( array ('page' => $page + 1), $permalink );
				  			  }
				  		?>
				  		<?php if ( $page != '0') { ?>
				  			<a href="<?php echo esc_attr($prev); ?>" class="slick-nav slick-prev hide-for-large-up"><i class="fa fa-angle-left"></i></a>
				  		<?php } ?>
				  		<?php if ( $page + 1 != $length) { ?>
				  			<a href="<?php echo esc_attr($next); ?>" class="slick-nav slick-next hide-for-large-up"><i class="fa fa-angle-right"></i></a>
				  		<?php } ?>
				  		<?php echo wp_get_attachment_image($attachment_array[$page], 'goodlife-gallery-vertical'); ?>
				  	</figure>
			  	</div>
			  	<div class="small-12 medium-5 columns table">
			  		<div>
				  		<?php $image = get_post($attachment_array[$page]); ?>
				  		<?php if ($image->post_title) { ?>
				  			<header class="post-title">
				  				<h4 itemprop="name headline"><?php echo esc_attr($image->post_title); ?></h4>
				  			</header>
				  		<?php } ?>
				  		<?php if ($image->post_excerpt) { ?>
				  			<div class="post-content entry-content cf medium">
				  				<?php echo apply_filters('the_excerpt', $image->post_excerpt); ?>
				  			</div>
				  		<?php } ?>
			  		</div>
			  	</div>
		  	</div>
		  	
		  	<aside class="gallery-pagination">
		  		<?php if ( $page != '0') { ?>
		  			<a href="<?php echo esc_attr($prev); ?>" class="slick-nav slick-prev"><i class="fa fa-angle-left"></i></a>
		  		<?php } ?>
		  		<?php echo esc_html__('photo ', 'goodlife') . '<span>'. esc_attr($page + 1) .'</span>' . esc_html__(' of ', 'goodlife') . esc_attr($length); ?>
		  		<?php if ( $page + 1 != $length) { ?>
		  			<a href="<?php echo esc_attr($next); ?>" class="slick-nav slick-next"><i class="fa fa-angle-right"></i></a>
		  		<?php } ?>
		  	</aside>
				<?php get_template_part( 'inc/postformats/post-end' ); ?>
		  </article>

		<?php comments_template('', true); ?>
	</div>
	<?php get_sidebar('single'); ?>
	<?php if (!$thb_ajax) { ?>
		<?php if(ot_get_option('related_posts') !== 'off') { ?>
		<div class="small-12 columns">
			<?php get_template_part( 'inc/postformats/post-latest' ); ?>
		</div>
		<?php } ?>
	<?php } ?>
</div>