<?php 
	$posttags = get_the_tags(); 
	$article_author = ot_get_option('article_author', 'on'); 
	$article_prevnext = ot_get_option('article_prevnext', 'on'); 
?>
<?php if (!empty($posttags)) { ?>
<footer class="article-tags entry-footer">
	<span class="tags-title"><?php _e('Tags', 'goodlife'); ?></span> 
	<?php
	if ($posttags) {
		$return = '';
		foreach($posttags as $tag) {
			$return .= '<a href="'. get_tag_link($tag->term_id).'" title="'. get_tag_link($tag->name).'" class="tag-link">' . $tag->name . '</a> ';
		}
		echo substr($return, 0, -1);
	} ?>
</footer>
<?php } ?>
<?php if ($article_author == 'on') { ?> 
<section class="post-author">
	<?php do_action('thb_author'); ?>
</section>
<?php } ?>
<?php do_action('thb_social_article_detail'); ?>
<?php if ($article_prevnext == 'on') { ?> 
<?php do_action('thb_post_nav'); ?>
<?php } ?>