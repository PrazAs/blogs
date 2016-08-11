<?php global $vqData; ?>

<?php
	$url_create_quiz_truefalse = esc_url(remove_query_arg(array('id', 'referer', 'noheader'), add_query_arg(array('element'=>'quiz','action'=>'add', 'type' => 'WPVQGameTrueFalse'))));
	$url_create_quiz_personality = esc_url(remove_query_arg(array('id', 'referer', 'noheader'), add_query_arg(array('element'=>'quiz','action'=>'add', 'type'=> 'WPVQGamePersonality'))));
?>

<div class="wrap">
	<h2>
		WP Viral Quiz
		<a href="<?php echo $url_create_quiz_truefalse; ?>" class="add-new-h2"><?php _e("Create a \"Trivia\" Quiz",'wpvq'); ?></a>
		<a href="<?php echo $url_create_quiz_personality; ?>" class="add-new-h2"><?php _e("Create a \"Personality\" Quiz",'wpvq'); ?></a>
	</h2>

	<?php if (isset($_GET['referer']) && $_GET['referer'] == 'duplicate'): ?>
		<div id="message" class="updated below-h2">
			<p> <?php _e("Quiz has been duplicated.",'wpvq'); ?></p>
		</div>
	<?php endif ?>

	<?php if (isset($_GET['referer']) && $_GET['referer'] == 'remove'): ?>
		<div id="message" class="updated below-h2">
			<p> <?php _e("Quiz has been removed.",'wpvq'); ?></p>
		</div>
	<?php endif ?>

	<?php if (isset($_GET['referer']) && $_GET['referer'] == 'create'): ?>
		<div id="message" class="updated below-h2">
			<p> <?php _e("A new quiz has been created.",'wpvq'); ?></p>
		</div>
	<?php endif ?>

	<?php if (isset($_GET['referer']) && $_GET['referer'] == 'imported'): ?>
		<div id="message" class="updated below-h2">
			<p> <?php _e("The pack has been imported.",'wpvq'); ?></p>
		</div>
	<?php endif ?>

	<table id="vq-quizzes-list" class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th class="manage-column column-title"><?php _e("Title",'wpvq'); ?></th>
				<th class="manage-column column-date"><?php _e("Type",'wpvq'); ?></th>
				<th class="manage-column column-author"><?php _e("Author",'wpvq'); ?></th>
				<th class="manage-column column-date"><?php _e("Created on",'wpvq'); ?></th>
				<th class="manage-column column-date"><?php _e("Last Update",'wpvq'); ?></th>
				<th class="manage-column "><?php _e("Shortcode",'wpvq'); ?></th>
			</tr>
		</thead>
			<?php $i=0; foreach($vqData['quizzes'] as $qs): ?>
				<?php

					$user 	=  $qs->getUser(); 
					$nonce 	=  wp_create_nonce( 'delete_wpvquizz_' . $qs->getId());

					$url_edit_quiz 		 =  esc_url(remove_query_arg(array('referer', 'noheader'), add_query_arg(array('element' => 'quiz', 'action' => 'edit', 'id' => $qs->getId()))));
					$url_delete_quiz 	 =  esc_url(remove_query_arg(array('referer'), add_query_arg(array('element' => 'quiz', 'action' => 'delete', 'id' => $qs->getId(), 'wp_nonce' => $nonce, 'noheader' => true))));
					$url_duplicate_quiz  =  esc_url(remove_query_arg(array('referer'), add_query_arg(array('element' => 'quiz', 'action' => 'duplicate', 'id' => $qs->getId(), 'wp_nonce' => $nonce, 'noheader' => true))));
					$url_export_quiz  	 =  esc_url(remove_query_arg(array('referer'), add_query_arg(array('element' => 'quiz', 'action' => 'export', 'id' => $qs->getId(), 'wp_nonce' => $nonce, 'noheader' => true))));

					if ($i%2 != 0) {
						$alternate = '';
					} else {
						$alternate = 'alternate';
					}

				?>

				<tr class="<?php echo $alternate; ?>">
					<td class="post-title page-title column-title">
						<a href="<?php echo $url_edit_quiz; ?>">
							<strong style="display:inline;"><?php echo stripslashes($qs->getName()); ?></strong> 
						</a>
						<div class="row-actions visible">
							<span class="edit"><a href="<?php echo $url_edit_quiz; ?>"><?php _e("Update",'wpvq'); ?></a></span> | 
							<span class="duplicate"><a href="<?php echo $url_duplicate_quiz; ?>" onclick="return confirm('Do you really want to duplicate this quiz ?');"><?php _e("Duplicate",'wpvq'); ?></a></span> |
							<span class="export"><a href="<?php echo $url_export_quiz; ?>"><?php _e("Export",'wpvq'); ?></a></span> | 
							<span class="trash"><a href="<?php echo $url_delete_quiz; ?>" class="submitdelete" onclick="return confirm('Do you really want to delete this quiz ? Players database will be also deleted if exists.');"><?php _e("Delete",'wpvq'); ?></a></span>
						</div>
					</td>
					<td>
						<span class="vq-badge vq-badge-primary"><?php echo $qs->getNiceType(true); ?> <?php _e("Quiz",'wpvq'); ?></span>
					</td>
					<td><?php echo $user->user_nicename; ?></td>
					<td><?php echo date('d/m/Y', $qs->getDateCreation()); ?></td>
					<td><?php echo $qs->getNiceDateUpdate(); ?></td>
					<td>
						<?php if (current_user_can('edit_posts')): ?>
							<code class="wpvq-shortcode-quiz">[viralQuiz id=<?php echo $qs->getId(); ?>]</code>	
							<br />
							<span class="dashicons dashicons-welcome-add-page"></span>Create a new  
							<a href="post-new.php?wpvq_shortcode_id=<?php echo $qs->getId(); ?>&wpvq_quiz_title=<?php echo $qs->getName(); ?>" target="_blank">post</a> / 
							<a href="post-new.php?post_type=page&wpvq_shortcode_id=<?php echo $qs->getId(); ?>&wpvq_quiz_title=<?php echo $qs->getName(); ?>" target="_blank">page</a>.
						<?php else: ?>
							<span style="color:#cc3f31;">
								<?php _e("<strong>You can't publish a quiz by yourself</strong>. <br />Ask an admin.", 'wpvq'); ?>
							</span>
						<?php endif; ?>
					</td>
				</tr>
			<?php $i++; endforeach; ?>			
		<?php if ($i==0): ?>
			<tr class="no-items">
				<td class="colspanchange">
					<?php _e("You haven't created any quiz yet !", 'wpvq'); ?><br />
					<?php _e("Click on a \"<b>Create Button</b>\" just above to begin.",'wpvq'); ?>
				</td>
			</tr>
		<?php endif; ?>
	</table>

	<?php if (current_user_can('edit_posts')): ?>
	<!-- IMPORT : Admin only -->
		<div class="wpvq-import-field">
			<h4 style="margin-bottom:5px;"><?php _e("Upload one (or several) quiz pack", 'wpvq'); ?></h4>
			<button class="button wpvq-import-pack"><?php _e("Upload and import quiz pack(s)", 'wpvq'); ?></button>
			<div class="wpvq-import-loader"><img src="<?php echo WPVQ_PLUGIN_URL; ?>/views/img/loader-import.gif" alt="Loading..." /></div>
		</div>
	<?php endif; ?>

	<!-- Pagination -->
	<?php if ($vqData['pagesCount'] > 0): ?>
		<ul class="wpvq-list-pages">
			<li style="font-weight:bold;"><?php _e("Pages", 'wpvq'); ?> :</li>
			<?php for($i=0; $i<$vqData['pagesCount']; $i++): ?>
				<?php $wpvq_url_pagination = esc_url(remove_query_arg(array('id', 'referer', 'noheader'), add_query_arg(array('page'=> 'wp-viral-quiz', 'wpvq_pagination' => $i)))); ?>
				<li class="<?php if ($vqData['currentPage'] == $i): ?>wpvq-current-page<?php endif ?>"><a href="<?php echo $wpvq_url_pagination; ?>"><?php echo ($i+1); ?></a></li>
			<?php endfor; ?>
		</ul>
	<?php endif ?>

	<div class="vq-medium">
		<div id="vq-doc">
			<hr />
			<h2><?php _e("Questions you may ask about this plugin",'wpvq'); ?></h2>
			<p>
				<?php _e("Do not forget to take a look at the official F.A.Q : ", 'wpvq'); ?>
				<a href="https://www.ohmyquiz.io/faq" target="_blank">www.ohmyquiz.io/faq</a>
			</p>
			<h3>1. <?php _e("What is a \"Trivia\" quiz ?",'wpvq'); ?></h3>
			<p>
				<?php _e("When playing a Trivia quiz, people have to give the right answer for each of your questions.
				At the end, they can share their score with their friends on social media." ,'wpvq'); ?>

				<?php _e("Examples : " ,'wpvq'); ?>
			</p>
			<ul>
				<li><?php _e("How Much Do You Actually Know About <code>#RandomTopic</code>",'wpvq'); ?></li>
				<li><?php _e("Can You Answer These Basic <code>#RandomTopic</code> Questions?",'wpvq'); ?></li>
				<li><a href="https://demo.ohmyquiz.io/official/how-well-do-you-know-the-game-of-thrones-houses/" target="_blank"><?php _e("Click here to see an example.",'wpvq'); ?></a></li>
			</ul>

			<h3>2. <?php _e("What is a \"Personality\" quiz ?",'wpvq'); ?></h3>
			<p>
				<?php _e("By playing a Personality quiz, people have to answer questions about them, their behavor, what they like, etc. 
					At the end, you tell them which kind of people they are.",'wpvq'); ?>

			<?php _e("Examples : " ,'wpvq'); ?>
			</p>
			<ul>
				<li><?php _e("Which <code>#RandomTVShow</code> Character Are You?",'wpvq'); ?></li>
				<li><?php _e("What Does Your <code>#RandomStuff</code> Say About Your Personality?",'wpvq'); ?></li>
				<li><a href="https://demo.ohmyquiz.io/official/plan-summer-vacation/" target="_blank"><?php _e("Click here to see an example.",'wpvq'); ?></a></li>
			</ul>

			<h3>3. <?php _e("How to insert a quiz in my article or page ?",'wpvq'); ?></h3>
			<p>
				<?php _e("Just look at the <code>shortcode column</code> in the main table above. Copy and paste this shortcode to the content of your page/post, and save it ! The quiz will appear on the page.",'wpvq'); ?>
			</p>

			<h3>4. <?php _e("I need help / I need a new feature / I need a pizza",'wpvq'); ?></h3>
			<p>
				<?php _e("About the pizza, we have already eaten it, sorry. But if you need something else, feel free to contact us", 'wpvq'); ?> <a href="https://www.ohmyquiz.io/support/" target="_blank"><?php _e("by clicking here", 'wpvq'); ?></a> (<?php _e("in french or english",'wpvq'); ?>).
			</p>
		</div>
	</div>
</div>
