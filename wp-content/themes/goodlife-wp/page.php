<?php get_header(); ?>
<?php $VC = class_exists('WPBakeryVisualComposerAbstract'); ?>

<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
<article <?php post_class('post post-detail'); ?> id="post-<?php the_ID(); ?>">
	<div class="post-content">
		<?php if ($VC) { ?>
			<?php the_content('Read More'); ?>
		<?php } else { ?>
			<div class="row">
				<div class="small-12 columns">
					<header class="post-title page-title">
						<?php the_title('<h1 class="entry-title" itemprop="name headline">', '</h1>' ); ?>
					</header>
					<div class="post-content no-vc">
					<?php the_content('Read More');?>
					</div>
					<?php 
						if ( comments_open() || get_comments_number() ) :
							comments_template('', true);
						endif;
					?>
				</div>
			</div>
		<?php } ?>
	</div>
</article>
<?php endwhile; else : endif; ?>
<?php get_footer(); ?>