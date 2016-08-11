<?php global $vqData; ?>
<?php $url_show_players = esc_url( remove_query_arg(array('action', 'noheader')) ); ?>

<div class="wrap">
	<h2>
		WP Viral Quiz - 
		<strong><?php _e("Players Database", 'wpvq'); ?></strong>
	</h2>

	<?php if (isset($_GET['referer']) && $_GET['referer'] == 'remove'): ?>
		<div id="message" class="updated below-h2">
			<p> <?php _e("Player has been removed.",'wpvq'); ?></p>
		</div>
	<?php endif ?>

	<?php if (isset($_GET['referer']) && $_GET['referer'] == 'removeAll'): ?>
		<div id="message" class="updated below-h2">
			<p> <?php _e("All players for this quiz have been removed.",'wpvq'); ?></p>
		</div>
	<?php endif ?>

	<hr />

	<p class="wpvq-protip">
		<strong>Protip for Marketers :</strong> <br>
		You can display the number of players of a quiz everywhere you want on your blog, <strong>using the following shortcode</strong> :
		<code>[viralQuizAnalytics id=XX fake=YY]</code><br />
		Replace XX with a quiz's ID, and YY with a start value if you want to cheat.
	</p>
	<!-- Default view of the page -->
	<?php if (!$vqData['showTable']): ?>
		<table id="vq-quizzes-list" class="wp-list-table widefat fixed posts">
			<thead>
				<tr>
					<th class="manage-column column-title"><?php _e("Title",'wpvq'); ?></th>
					<th class="manage-column column-date"><?php _e("Type",'wpvq'); ?></th>
					<th class="manage-column column-date"><?php _e("Created on",'wpvq'); ?></th>
					<th class="manage-column column-date"><?php _e("Number of players",'wpvq'); ?></th>
				</tr>
			</thead>
				<?php $i=0; foreach($vqData['quizzes'] as $qs): ?>
					<tr class="<?php echo $alternate; ?>">
						<td class="post-title page-title column-title">
							<strong style="display:inline;"><?php echo stripslashes($qs->getName()); ?></strong> 
							<div class="row-actions visible">
								<?php $url_analytics =  esc_url(add_query_arg(array('wpvq_quizId' => $qs->getId()))); ?>
								<?php if ($i%2 == 0) {
										$alternate = '';
									} else {
										$alternate = 'alternate';
									} ?>
								<span class="edit"><a href="<?php echo $url_analytics; ?>"><i class="fa fa-line-chart"></i> <?php _e("Get more data",'wpvq'); ?></a></span>
							</div>
						</td>
						<td>
							<span class="vq-badge vq-badge-primary"><?php echo $qs->getNiceType(true); ?> <?php _e("Quiz",'wpvq'); ?></span>
						</td>
						<td><?php echo date('d/m/Y', $qs->getDateCreation()); ?></td>
						<td><?php echo ($numberOfPlayers = $qs->countPlayersFromDB()); ?> <i class="fa fa-users"></i></td>
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

		<!-- Pagination -->
		<?php if ($vqData['pagesCount'] > 0): ?>
			<ul class="wpvq-list-pages">
				<li style="font-weight:bold;"><?php _e("Pages", 'wpvq'); ?> :</li>
				<?php for($i=0; $i<$vqData['pagesCount']; $i++): ?>
					<?php $wpvq_url_pagination = esc_url(remove_query_arg(array('wpvq_quizId', 'id', 'referer', 'noheader'), add_query_arg(array('page'=> 'wp-viral-quiz-players', 'wpvq_pagination' => $i)))); ?>
					<li class="<?php if ($vqData['currentPage'] == $i): ?>wpvq-current-page<?php endif ?>"><a href="<?php echo $wpvq_url_pagination; ?>"><?php echo ($i+1); ?></a></li>
				<?php endfor; ?>
			</ul>
		<?php endif ?>

	<?php endif ?>

	<!-- Show more data view -->
	<?php if ($vqData['showTable']): ?>
		
		<?php if ($vqData['players']->countPlayers() > 0): ?>
			<p style="margin:20px 0;">
				<strong><?php _e("Total", 'wpvq'); ?> :</strong> <?php echo $vqData['players']->countPlayers(); ?> <?php _e("players", 'wpvq'); ?> | 
				<a href="<?php echo $vqData['exportUrl']; ?>" target="_blank"><?php _e("Export the table to a CSV file", 'wpvq'); ?></a> | 

				<?php $remove_all_link = esc_url(remove_query_arg(array('id', 'referer'), add_query_arg(array('noheader' => 1, 'element'=>'players','action'=>'remove', 'playerId' => 'all')))); ?>
				<a href="<?php echo $remove_all_link; ?>" onClick="return confirm('<?php _e('Do you really want to delete them ?', '', 'wpvq'); ?>');"><?php _e("Delete all players for this quiz", 'wpvq'); ?></a>
			</p>
		<?php else: ?>
			<p></p>
		<?php endif; ?>

		<!-- HTML Pagination (blank if 1 page only) -->
		<?php $htmlPagination = ''; ?>
		<?php if ($players->getPagesCount() > 1): ?>
			<?php ob_start(); ?>
			<p style="margin-bottom:2px;font-size:.9em;margin-top:0px;margin-left:1px;">
				<strong><?php _e("Pages", 'wpvq'); ?> :</strong>
				<?php for ($i = 1; $i <= $players->getPagesCount(); $i++): ?>
					<a href="admin.php?page=wp-viral-quiz-players&wpvq_quizId=<?php echo $quizId; ?>&wpvq_page=<?php echo $i ?>">
					<?php if ($vqData['page'] == $i): ?><strong><?php endif ?>
						<?php echo $i; ?><?php if ($vqData['page'] == $i): ?></strong><?php endif ?></a>
					<?php if ($i != $players->getPagesCount()) echo " -"; // between each page number ?>
				<?php endfor; ?>
			</p>
			<?php $htmlPagination = ob_get_contents(); ob_end_clean(); ?>
		<?php endif; ?>

		<?php echo $htmlPagination; ?>

		<table id="vq-quizzes-list" class="wp-list-table widefat fixed posts">
			<thead>
				<tr>
					<th class="manage-column column-author"><?php _e("People",'wpvq'); ?></th>
					<th class="manage-column column-date"><?php _e("Result",'wpvq'); ?></th>				
					<th class="manage-column column-date"><?php _e("Date",'wpvq'); ?></th>		
					<th class="manage-column column-date"><?php _e("Meta",'wpvq'); ?></th>		
				</tr>
			</thead>
				<?php $i=0; foreach ($vqData['players']->getPlayers() as $index => $player): 

					if ($i%2 != 0) {
						$alternate = '';
					} else {
						$alternate = 'alternate';
					}
				?>
					<tr class="<?php echo $alternate; ?>">
						<td class="post-title page-title column-title">
							<strong>
								<?php $remove_player_link = esc_url(remove_query_arg(array('id', 'referer'), add_query_arg(array('noheader' => 1, 'element'=>'players','action'=>'remove', 'playerId' => $player['id'])))); ?>
								<a href="<?php echo $remove_player_link; ?>"><span class="dashicons dashicons-no-alt"></span></a>
								<?php echo ($player['nickname'] != '') ? htmlspecialchars($player['nickname']):__("Anonymous", 'wpvq'); ?>
							</strong>
							<span style="font-size:.8em;"><?php echo ($player['email'] != '') ? htmlspecialchars($player['email']):''; ?></span>
						</td>
						<td><?php echo htmlspecialchars($player['result']); ?></td>
						<td><?php printf( __("%s ago", 'wpvq'), human_time_diff($player['date']) ); ?></td>
						<td>
							<?php 
								foreach ($player['meta'] as $key => $value):
									$value = apply_filters('wpvq_meta_column_loop', $value, $key);
							?>
									<strong><?php echo $key ?></strong> : 
									<?php echo (is_array($value)) ? print_r($value, true) : $value; ?>
									<hr />
							<?php 
								endforeach; 
							?>

							<?php if (empty($player['meta'])): ?>
								/
							<?php endif ?>
						</td>
					</tr>
				<?php if ($i == 100) break; ?>
				<?php $i++; endforeach; ?>
			<?php if ($vqData['players']->countPlayers() == 0): ?>
				<tr class="no-items">
					<td class="colspanchange">
						<?php _e("No one has played this quiz yet!", 'wpvq'); ?><br />
					</td>
				</tr>
			<?php endif; ?>
		</table>

		<?php echo $htmlPagination; ?>
		<hr />

		<p style="font-style:italic;">
			<strong><?php _e("Informations about anonymous players :", 'wpvq'); ?></strong><br />
			<?php _e("If your quiz asks for first name/email at the end, \"anonymous players\" are people which don't fill the form and leave the page.", 'wpvq'); ?>
		</p>

	<?php endif; ?>

</div>

