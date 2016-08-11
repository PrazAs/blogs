<?php

function thb_post_review_circle($size = 'small') {
	$id = get_the_ID();
	if (get_post_meta($id, 'is_review', TRUE) == 'on') {
		$average_score = get_post_meta($id, 'post_ratings_average', TRUE); 
		
		if ($size == 'small') {
			$w = 50;
			$r = 23;
			$x = 25;	
			$pi = 2 * 3.14 * $r;
			$percent = $pi - (($pi / 10) * $average_score);
		} else {
			$w = 90;
			$r = 42;
			$x = 45;	
			$pi = 2 * 3.14 * $r;
			$percent = 15 * $average_score;
		}
		?>
		<figure class="circle_rating <?php echo esc_attr($size); ?>">
			<span><?php echo esc_attr($average_score); ?></span>
			<svg width="<?php echo esc_attr($w); ?>" height="<?php echo esc_attr($w); ?>" viewBox="0 0 <?php echo esc_attr($w); ?> <?php echo esc_attr($w); ?>" version="1.1" xmlns="http://www.w3.org/2000/svg">
			  <circle class="circle_base" r="<?php echo esc_attr($r); ?>" cx="<?php echo esc_attr($x); ?>" cy="<?php echo esc_attr($x); ?>" fill="transparent" stroke-dasharray="<?php echo esc_attr($pi); ?>" stroke-dashoffset="0"></circle>
			 	<circle class="circle_perc" r="<?php echo esc_attr($r); ?>" cx="<?php echo esc_attr($x); ?>" cy="<?php echo esc_attr($x); ?>" fill="transparent" stroke-dasharray="<?php echo esc_attr($pi); ?>" stroke-dashoffset="<?php echo esc_attr($pi); ?>" data-dashoffset="<?php echo esc_attr($percent); ?>"></circle>
			</svg>
		</figure>
		<?php
	}
}
add_action( 'thb_post_review_circle', 'thb_post_review_circle', 10, 2 );

function thb_post_review_average() {
	$id = get_the_ID();
	if (get_post_meta($id, 'is_review', TRUE) == 'on') {
		$average_score = get_post_meta($id, 'post_ratings_average', TRUE); 
		echo '<span class="ave">'.esc_attr($average_score).'</span>';
	}
}
add_action( 'thb_post_review_average', 'thb_post_review_average' );

function thb_post_review() {
	$id = get_the_ID();
	if (get_post_meta($id, 'is_review', TRUE) == 'on') {
		$review_title = get_post_meta($id, 'post_ratings_title', TRUE);
		$comments = get_post_meta($id, 'post_ratings_comments', TRUE);
		$features = get_post_meta($id, 'post_ratings_percentage', TRUE); 
		$average_score = get_post_meta($id, 'post_ratings_average', TRUE); 
		$review_style = get_post_meta($id, 'post-review-style', true);
		?>
		<aside class="post-review <?php echo esc_attr($review_style); ?>">
			<div class="post-review-content">
				<?php if ($review_title) { ?><h6><?php echo esc_attr($review_title); ?></h6><?php } ?>
				<ul>
				<?php if ($features) { foreach($features as $feature) {
					?>
					
					<li>
						<div class="row">
							<div class="small-12 medium-9 columns"><?php echo esc_attr($feature['title']); ?></div>
							<div class="small-12 medium-3 columns hide-for-small"><?php echo esc_attr($feature['feature_score']); ?></div>
						</div>
						<div class="progress">
							<span data-width="<?php echo 10*$feature['feature_score'] ?>"></span>
						</div>
					</li>
					
		
				<?php } } ?>
				</ul>
			</div>
			<div class="post-review-content">
				<div class="row">
					<div class="small-12 medium-9 columns">
						<div class="row">
							<div class="small-12 <?php if($review_style !== 'style2') { ?> medium-6<?php } ?> columns comment_section">
								<span class="post_comment"><?php _e('The Good', 'goodlife'); ?></span>
								<?php if ($comments) { foreach($comments as $comment) { ?>
									<?php if ($comment['feature_comment_type'] == 'positive') { ?>
									<p class="positive"><?php echo esc_attr($comment['title']); ?></p>
									<?php } ?>
								<?php } } ?>
							</div>
							<div class="small-12 <?php if($review_style !== 'style2') { ?> medium-6<?php } ?> columns comment_section">
								<span class="post_comment"><?php _e('The Bad', 'goodlife'); ?></span>
								<?php if ($comments) { foreach($comments as $comment) { ?>
									<?php if ($comment['feature_comment_type'] == 'negative') { ?>
									<p class="negative"><?php echo esc_attr($comment['title']); ?></p>
									<?php } ?>
								<?php } }?>
							</div>
						</div>
					</div>
					<div class="small-12 <?php if($review_style !== 'style2') { ?> medium-3<?php } ?> columns">
						<figure class="average"><?php echo esc_attr($average_score); ?></figure>
					</div>
				</div>
			</div>
		</aside>
		<?php
	}
}
add_action( 'thb_post_review', 'thb_post_review' );