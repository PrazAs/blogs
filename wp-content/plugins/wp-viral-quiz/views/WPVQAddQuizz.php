<?php global $vqData; ?>

<div class="wrap">

	<div class="vq-medium">

		<h1>
			<?php if ($vqData['quizId'] == NULL): ?>
				<?php _e('Build a new', 'wpvq'); ?>
			<?php else: ?>
				<?php _e('Edit your', 'wpvq'); ?>
			<?php endif; ?>

			<strong>
				<?php echo WPVQGame::getNiceTypeFromClass($vqData['type'], true) ?> <?php _e("Quiz", 'wpvq'); ?>
			</strong>

			<br />
			<div class="wpvq-tooltip">
				<small class="wpvq-title-readonly">
					<i class="fa fa-tag"></i> 
					<strong><?php _e("Title :", 'wpvq'); ?></strong> 
					<span class="wpvq-title-label"><?php echo ($vqData['quizName']) ? $vqData['quizName']:'Untitled Quiz'; ?></span>
				</small>
				<span class="wpvq-tooltip-content">
			        <?php _e("You can change the title in the Settings Tab.", 'wpvq'); ?>
			    </span>
			</a>
		</h1>
		<br />

		<!-- Callback referer message -->
		<?php if (isset($_GET['referer']) && $_GET['referer'] == 'update'): ?>
			<div id="message" class="updated below-h2">
				<p> <?php _e("Quiz has been updated.",'wpvq'); ?></p>
			</div>
		<?php endif ?>

		<?php 
			// Default active tab
			$defaultActiveTab = 'appreciations';
			if ($vqData['type'] == 'WPVQGameTrueFalse'):
				$defaultActiveTab = 'questions';
			endif;
		?>

		<?php 
			// Tab links
			$activeTab = htmlentities((isset($_GET['tab'])) ? $_GET['tab']:$defaultActiveTab);
			$tab_url['appreciations'] = esc_url(add_query_arg(array('tab' => 'appreciations'), remove_query_arg(array('referer'))));
			$tab_url['questions'] = esc_url(add_query_arg(array('tab' => 'questions'), remove_query_arg(array('referer'))));
			$tab_url['configuration'] = esc_url(add_query_arg(array('tab' => 'configuration'), remove_query_arg(array('referer')))); 
		?>

		<h2 id="wpvq-navbar" class="nav-tab-wrapper hide-if-no-js">
			<a href="<?php echo $tab_url['appreciations']; ?>" class="nav-tab <?php if($activeTab == 'appreciations'): ?>nav-tab-active<?php endif; ?>" style="outline: 0px;"><?php if($vqData['type'] == 'WPVQGameTrueFalse') _e("Appreciations", 'wpvq'); elseif($vqData['type'] == 'WPVQGamePersonality') _e("Personalities", 'wpvq'); ?></a>
			<a href="<?php echo $tab_url['questions']; ?>" class="nav-tab <?php if($activeTab == 'questions'): ?>nav-tab-active<?php endif; ?>" style="outline: 0px;"><?php _e("Questions/answers", 'wpvq'); ?></a>
			<a href="<?php echo $tab_url['configuration']; ?>" class="nav-tab <?php if($activeTab == 'configuration'): ?>nav-tab-active<?php endif; ?>" style="outline: 0px;"><?php _e("Settings", 'wpvq'); ?></a>
		</h2>

		<br />

		<?php if ($activeTab == 'configuration'): ?>

			<form action="<?php echo esc_url(add_query_arg(array('noheader' => true))); ?>" method="POST">

				<!-- Validation + hidden fields -->
				<div id="wpvq-global-settings-addquiz">

					<h3 class="dashicons-before dashicons-admin-generic"> <?php _e("Settings", 'wpvq'); ?> — <?php _e("Configure your quiz like a boss", 'wpvq'); ?></h3>
					<p>
						<?php _e("Enable some exciting features and improve your quiz's virality !", 'wpvq'); ?>
					</p>

					<div class="vq-bloc">
						<h4 class="wpvq-global-settings-addquiz"><?php _e("Display & Gameplay", 'wpvq'); ?></h4>
						<div class="vq-content">
							<table class="form-table">
								<tbody>
									<tr>
										<th scope="row">
											<?php _e("The Quiz's Title", 'wpvq'); ?>
										</th>
										<td>
											<input type="text" name="quizName" style="width:100%;" placeholder="<?php _e("Type your quiz's title here", 'wpvq'); ?>" value="<?php echo ($vqData['quizName'] == '') ? 'Untitled Quiz':$vqData['quizName']; ?>" />
										</td>
									</tr>
									<tr>
										<th scope="row">
											<?php _e("What skin do you want", 'wpvq'); ?> :
										</th>
										<td>
											<select name="skin" id="wpvq-skin">
												<option value="buzzfeed" <?php if($vqData['skin'] == 'buzzfeed'):?>selected<?php endif; ?>><?php _e("The BuzzFeed Skin", 'wpvq'); ?></option>
												<option value="flat" <?php if($vqData['skin'] == 'flat'):?>selected<?php endif; ?>><?php _e("A Modern Flat Skin", 'wpvq'); ?></option>
												<option value="custom" <?php if($vqData['skin'] == 'custom'):?>selected<?php endif; ?>><?php _e("Custom Skin (use wpvq-custom.css in your root theme dir.)", 'wpvq'); ?></option>
											</select>
										</td>
									</tr>

									<tr style="border-top:1px dashed #dedede;">
										<th scope="row">
											<?php _e("Display Random Questions ?", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-randomQuestionsCheckbox">
												<input type="checkbox" id="wpvq-randomQuestionsCheckbox" name="isRandomQuestions"  value="1" <?php if ($vqData['isRandomQuestions']): ?>checked="checked"<?php endif; ?> /> 
												<span id="wpvq-randomQuestionsFields"><?php _e("and show only", 'wpvq'); ?> <input type="text" id="wpvq-randomQuestions" name="randomQuestions" value="<?php echo ($vqData['randomQuestions'] != -1) ? $vqData['randomQuestions']:''; ?>" style="width:60px; text-align:center;" placeholder="XX" /> <?php _e('questions (put 999 for "all")', 'wpvq'); ?></span>
											</label>
										</td>
									</tr>

									<tr>
										<th scope="row">
											<?php _e("Random order for answers ?", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-isRandomAnswers">
												<input type="checkbox" id="wpvq-isRandomAnswers" name="isRandomAnswers" value="1" <?php if ($vqData['isRandomAnswers']): ?>checked="checked"<?php endif; ?> />
												<?php _e("Yes, shuffle the answers for each question", 'wpvq'); ?>
											</label>
										</td>
									</tr>

									<tr style="border-top:1px dashed #dedede;">
										<th scope="row">
											<?php _e("\"Start quiz\" button ?", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-extraOptionSqueezePage">
												<input type="hidden" name="wpvqExtraOptions[squeezePage]" value="0" />

												<input type="checkbox" id="wpvq-extraOptionSqueezePage" name="wpvqExtraOptions[squeezePage]" value="1" <?php if (WPVQGame::extraOptionIsTrue($vqData['extraOptions'], 'squeezePage')): ?>checked="checked"<?php endif; ?> />
												
												<?php _e("User need to click a button to start the quiz", 'wpvq'); ?>
											</label>
										</td>
									</tr>

									<tr>
										<th scope="row">
											<?php _e("\"Play again\" button ?", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-playAgain">
												<input type="checkbox" id="wpvq-playAgain" name="playAgain" value="1" <?php if ($vqData['meta']['playAgain']): ?>checked="checked"<?php endif; ?> />
												<?php _e("Display a \"Play Again\" button at the end of the quiz", 'wpvq'); ?>
											</label>
										</td>
									</tr>

									<tr>
										<th scope="row">
											<?php _e("Redirect users at the end of the quiz ?", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-redirectionPage">
												<input type="text" id="wpvq-redirectionPage" name="redirectionPage" value="<?php if (isset($vqData['meta']['redirectionPage'])) echo $vqData['meta']['redirectionPage']; ?>" placeholder="http://www..........." style="width:250px;" />
												<a href="https://www.ohmyquiz.io/knowledgebase/redirect-user-another-page-end-quiz/" target="_blank"><?php _e("More info here.", 'wpvq'); ?></a>
											</label>
										</td>
									</tr>
									
									<?php if ($vqData['type'] == 'WPVQGameTrueFalse'): ?>
										<!-- Hide True/false answers, for TriviaQuiz only -->
										<tr style="border-top:1px dashed #dedede;">
											<th scope="row">
												<?php _e("Hide right/wrong answers ?", 'wpvq'); ?>
											</th>
											<td>
												<label for="wpvq-hideRightWrong">
													<input type="checkbox" id="wpvq-hideRightWrong" name="hideRightWrong" value="1" <?php if (isset($vqData['meta']['hideRightWrong']) && $vqData['meta']['hideRightWrong']): ?>checked="checked"<?php endif; ?> />
													<?php _e("Hide right/wrong answsers until the end of the quiz", 'wpvq'); ?>
												</label>
											</td>
										</tr>
									<?php endif ?>

									<!-- Refresh browser feature -->
									<tr style="border-top:1px dashed #dedede;">
										<th scope="row">
											<?php _e("Refresh browser on page changes", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-extraOptionRefreshBrowser">
												<input type="hidden" name="wpvqExtraOptions[refreshBrowser]" value="0" />

												<input type="checkbox" id="wpvq-extraOptionRefreshBrowser" name="wpvqExtraOptions[refreshBrowser]" value="1" <?php if (WPVQGame::extraOptionIsTrue($vqData['extraOptions'], 'refreshBrowser')): ?>checked="checked"<?php endif; ?> />
												
												<?php _e("Refresh browser when changing quiz page (cool for pageviews++)", 'wpvq'); ?>
											</label>
										</td>
									</tr>

									<!-- Force "next button" -->
									<tr>
										<th scope="row">
											<?php _e("\"Continue\" button between pages", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-extraOptionForceContinueButton">
												<input type="hidden" name="wpvqExtraOptions[forceContinueButton]" value="0" />

												<input type="checkbox" id="wpvq-extraOptionForceContinueButton" name="wpvqExtraOptions[forceContinueButton]" value="1" <?php if (WPVQGame::extraOptionIsTrue($vqData['extraOptions'], 'forceContinueButton')): ?>checked="checked"<?php endif; ?> />
												
												<?php _e("Force user to click on \"Continue\" between each page", 'wpvq'); ?>
											</label>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="vq-bloc">
						<h4 class="wpvq-global-settings-addquiz"><?php _e("Virality", 'wpvq'); ?></h4>
						<div class="vq-content">
							<table class="form-table">
								<tbody>
									<tr>
										<th scope="row">
											<?php _e("People have to share the quiz to see their results :", 'wpvq'); ?>
										</th>
										<td>
											<select id="vq-forceShare" name="forceToShare">
												<option value="" <?php if (empty($vqData['forceToShare'])): ?>selected<?php endif; ?>>Disabled</option>
												<option value="facebook" <?php if (in_array('facebook', $vqData['forceToShare'])): ?>selected<?php endif; ?>><?php _e("Yes, they have to share on Facebook", 'wpvq'); ?></option>
											</select>
										</td>
									</tr>

									<tr>
										<th scope="row">
											<?php _e("Share buttons", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-showSharing">
												<input type="checkbox" id="wpvq-showSharing" name="showSharing" value="1" <?php if ($vqData['showSharing'] == 1): ?>checked="checked"<?php endif; ?> />
												<?php _e("Display share buttons at the end of the quiz", 'wpvq'); ?> (Facebook, Twitter, Google+)
											</label>
										</td>
									</tr>

									<tr style="border-top:1px dashed #dedede;">
										<th scope="row">
											<?php _e("Promote the plugin", 'wpvq'); ?>
										</th>
										<td>
											<label for="wpvq-showCopyright">
												<input type="checkbox" id="wpvq-showCopyright" name="showCopyright" value="1" <?php if ($vqData['showCopyright'] == 1): ?>checked="checked"<?php endif; ?> />
												Show a very small label to help us to promote our plugin (thanks <3)
											</label>
										</td>
									</tr>


								</tbody>
							</table>
						</div>
					</div>


					<div class="vq-bloc">
						<h4 class="wpvq-global-settings-addquiz"><?php _e("Marketing Services", 'wpvq'); ?></h4>
						
						<div class="vq-content">

							<div class="wpvq-onoffswitch" data-select-section="1">
								<label><?php _e("Ask player informations at the end", 'wpvq'); ?></label>
								<input type="checkbox" name="askInformations_section" <?php if(!empty($vqData['askInformations'])): ?>checked<?php endif; ?> />
							</div>					

							<div class="wpvq-settings-askinfo-content">
								<div data-section="1">
									<table class="form-table">
										<tbody>
											<tr>
												<th scope="row">
													<?php _e("Capture e-mails", 'wpvq'); ?>
												</th>
												<td>
													<label for="wpvq-askInformations-email" style="width:270px;display:block;">
														<input type="checkbox" id="wpvq-askInformations-email" name="askInformations[]" value="email" <?php if (in_array('email', $vqData['askInformations'])): ?>checked="checked"<?php endif; ?> />
														<?php _e("People have to give their e-mail", 'wpvq'); ?>
													</label>
												</td>
											</tr>
											
											<tr>
												<th scope="row">
													<?php _e("Capture names", 'wpvq'); ?>
												</th>
												<td>
													<label for="wpvq-askInformations-nickname">
														<input type="checkbox" id="wpvq-askInformations-nickname" name="askInformations[]" value="nickname" <?php if (in_array('nickname', $vqData['askInformations'])): ?>checked="checked"<?php endif; ?> />
														<?php _e("People have to give their first name", 'wpvq'); ?>
													</label>
												</td>
											</tr>

											<tr>
												<th scope="row">
													<?php _e("Is it optional ?", 'wpvq'); ?>
												</th>
												<td>
													<label for="wpvq-askInformations-optional">
														<input type="checkbox" id="wpvq-askInformations-optional" name="askInformations[]" value="optional" <?php if (in_array('optional', $vqData['askInformations'])): ?>checked="checked"<?php endif; ?> />
														<?php _e("People can ignore", 'wpvq'); ?>
													</label>
												</td>
											</tr>
										</tbody>
									</table>

									<div class="wpvq-settings-askinfo-mailchimp-content" wpvq-data-section="1">
										<div class="wpvq-onoffswitch" data-select-sub-section="1">
											<label><?php _e("Enable Mailchimp Synchronisation", 'wpvq'); ?></label>
										    <input type="checkbox" name="askInformations_mailchimp_section" <?php if(isset($vqData['meta']['mailchimp'])): ?>checked<?php endif; ?> />
										    <span style="float:right;"><a href="https://www.ohmyquiz.io/knowledgebase/configure-mailchimp-synchronisation/" target="_blank"><?php _e("(Learn to configure) ", 'wpvq'); ?></a></span>
										</div>

										<div class="wpvq-settings-sub-content" data-sub-section="1">
											<table class="form-table">
												<tbody>
													<tr>
														<th scope="row">
															<?php _e("API Key", 'wpvq'); ?>
														</th>
														<td>
															<label for="mailchimp_apiKey">
																<input type="text" id="wpvq-mailchimp-apiKey" name="mailchimp_apiKey" value="<?php echo isset($vqData['meta']['mailchimp']['apiKey']) ? $vqData['meta']['mailchimp']['apiKey']:''; ?>" placeholder="" style="width:270px;" />
															</label>
														</td>
													</tr>
													<tr>
														<th scope="row">
															<?php _e("List ID", 'wpvq'); ?>
														</th>
														<td>
															<label for="wpvq-mailchimp_listId">
																<input type="text" id="wpvq-mailchimp-listId" name="mailchimp_listId" value="<?php echo isset($vqData['meta']['mailchimp']['listId']) ? $vqData['meta']['mailchimp']['listId']:''; ?>" placeholder="" style="width:270px;" />									
															</label>
														</td>
													</tr>
													<tr>
														<th scope="row">
															<?php _e("Firstname Field name", 'wpvq'); ?>
														</th>
														<td>
															<label for="mailchimp_firstNameField">
																<input type="text" id="wpvq-mailchimp-firstNameField" name="mailchimp_firstNameField" value="<?php echo isset($vqData['meta']['mailchimp']['firstNameField']) ? $vqData['meta']['mailchimp']['firstNameField']:''; ?>" placeholder="<?php _e("Optional", 'wpvq'); ?>" style="width:270px;" />												
															</label>
														</td>
													</tr>
													<tr>
														<th scope="row">
															<?php _e("Result Field name", 'wpvq'); ?>
														</th>
														<td>
															<label for="mailchimp_resultField">
																<input type="text" id="wpvq-mailchimp-resultField" name="mailchimp_resultField" value="<?php echo isset($vqData['meta']['mailchimp']['resultField']) ? $vqData['meta']['mailchimp']['resultField']:''; ?>" placeholder="<?php _e("Optional", 'wpvq'); ?>" style="width:270px;" />												
															</label>
														</td>
													</tr>
													<tr>
														<th scope="row">
															<?php _e("Double Opt-In ?", 'wpvq'); ?>
														</th>
														<td>
															<label for="mailchimp_doubleOptin">
																<input type="checkbox" id="wpvq-mailchimp-firstNameField" name="mailchimp_doubleOptin" <?php echo (isset($vqData['meta']['mailchimp']['doubleOptin']) && $vqData['meta']['mailchimp']['doubleOptin'] == 1) ? 'checked':''; ?> />												
															</label>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="wpvq-settings-askinfo-aweber-content" wpvq-data-section="2">
										<div class="wpvq-onoffswitch" data-select-sub-section="2">
											<label><?php _e("Enable Aweber Synchronisation", 'wpvq'); ?></label>
										    <input type="checkbox" name="askInformations_aweber_section" <?php if(isset($vqData['meta']['aweber'])): ?>checked<?php endif; ?> />
										    <span style="float:right;"><a href="https://www.ohmyquiz.io/knowledgebase/enable-aweber-synchronisation/" target="_blank"><?php _e("(Learn to configure)", 'wpvq'); ?></a></span>
										</div>

										<div class="wpvq-settings-sub-content" data-sub-section="2">
											<table class="form-table">
												<tbody>
													<tr>
														<th scope="row">
															<?php _e("Auth Code", 'wpvq'); ?>
														</th>
														<td>
															<label for="aweber_authCode">
																<input type="text" id="wpvq-aweber-authCode" name="aweber_authCode" value="" placeholder="" style="width:200px;" /> 

																<span style="font-size:19px;"><i id="wpvq-generate-aweber-creds" class="fa fa-floppy-o" aria-hidden="true"></i></span>
															</label>
															<br />
															<label for="aweber_accessKeys">
																<input type="text" id="wpvq-aweber-accessKeys" name="aweber_accessKeys" value="<?php echo isset($vqData['meta']['aweber']['accessKeys']) ? $vqData['meta']['aweber']['accessKeys']:''; ?>" placeholder="<?php _e("Waiting for auth code...", 'wpvq'); ?>" style="width:200px;" readonly/>

																<span id="wpvq-access-key-status-fail" style="color:orange;<?php if(isset($vqData['meta']['aweber']['accessKeys'])): ?>display:none;<?php endif; ?>"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>

																<span id="wpvq-access-key-status-ok" style="color:green;<?php if(!isset($vqData['meta']['aweber']['accessKeys'])): ?>display:none;<?php endif; ?>"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
															</label>
														</td>
													</tr>
													<tr>
														<th scope="row">
															<?php _e("List ID", 'wpvq'); ?>
														</th>
														<td>
															<label for="wpvq-aweber_listId">
																<input type="text" id="wpvq-aweber-listId" name="aweber_listId" value="<?php echo isset($vqData['meta']['aweber']['listId']) ? $vqData['meta']['aweber']['listId']:''; ?>" placeholder="Format: aw......" style="width:270px;" />									
															</label>
														</td>
													</tr>
													<tr>
														<th scope="row">
															<?php _e("Result Field name", 'wpvq'); ?>
														</th>
														<td>
															<label for="aweber_resultField">
																<input type="text" id="wpvq-aweber-resultField" name="aweber_resultField" value="<?php echo isset($vqData['meta']['aweber']['resultField']) ? $vqData['meta']['aweber']['resultField']:''; ?>" placeholder="<?php _e("Optional", 'wpvq'); ?>" style="width:270px;" />												
															</label>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="vq-bloc">
						<h4 class="wpvq-global-settings-addquiz"><?php _e("Ads & Content Management", 'wpvq'); ?></h4>
						
						<div class="vq-content">

							<div class="wpvq-protip"><?php _e("You can also configure global ads & content (for all your quizzes)", 'wpvq'); ?> <a href="admin.php?page=wp-viral-quiz-settings"><?php _e("using the settings page", 'wpvq'); ?></a>.
								<?php _e("The settings below don't overwrite global settings. They run both simultaneously.", 'wpvq'); ?>
							</div>

							<hr style="margin:15px 0;">

							<div class="wpvq-onoffswitch" data-select-section="2">
								<label><?php _e("Add custom ads/content around this quiz", 'wpvq'); ?></label>
								<input type="checkbox" name="adscontent_section" 
									<?php if(
											WPVQGame::extraOptionIsTrue($vqData['extraOptions'], 'adscontentBefore') ||
											WPVQGame::extraOptionIsTrue($vqData['extraOptions'], 'adscontentAfter') ||
											WPVQGame::extraOptionIsTrue($vqData['extraOptions'], 'adscontentAboveResult') ||
											WPVQGame::extraOptionIsTrue($vqData['extraOptions'], 'adscontentIntoResult')
												): ?>
										checked
									<?php endif; ?> 
								/> <span class="vq-badge vq-badge-neutral"><span class="dashicons dashicons-yes"></span><?php _e("HTML + [shortcodes] allowed", 'wpvq'); ?></span>
							</div>					

							<div class="wpvq-settings-adscontent-content">
								<div data-section="2">
									<table class="form-table">
										<tbody>
											<tr>
												<th scope="row">
													<?php _e("Just before the quiz", 'wpvq'); ?>
												</th>
												<td>
													<label for="wpvq-askInformations-email">
														<textarea name="wpvqExtraOptions[adscontentBefore]" id="" style="width:350px;"><?php echo stripslashes(WPVQGame::getExtraOption($vqData['quizId'], 'adscontentBefore')); ?></textarea>
													</label>
												</td>
											</tr>
											<tr>
												<th scope="row">
													<?php _e("Just after the quiz", 'wpvq'); ?>
												</th>
												<td>
													<label for="wpvq-askInformations-email">
														<textarea name="wpvqExtraOptions[adscontentAfter]" id="" style="width:350px;"><?php echo stripslashes(WPVQGame::getExtraOption($vqData['quizId'], 'adscontentAfter')); ?></textarea>
													</label>
												</td>
											</tr>
											<tr>
												<th scope="row">
													<?php _e("Above the result area (when a quiz is finished)", 'wpvq'); ?>
												</th>
												<td>
													<label for="wpvq-askInformations-email">
														<textarea name="wpvqExtraOptions[adscontentAboveResult]" id="" style="width:350px;"><?php echo stripslashes(WPVQGame::getExtraOption($vqData['quizId'], 'adscontentAboveResult')); ?></textarea>
													</label>
												</td>
											</tr>
											<tr>
												<th scope="row">
													<?php _e("Just after the text in the result area", 'wpvq'); ?>
												</th>
												<td>
													<label for="wpvq-askInformations-email">
														<textarea name="wpvqExtraOptions[adscontentIntoResult]" id="" style="width:350px;"><?php echo stripslashes(WPVQGame::getExtraOption($vqData['quizId'], 'adscontentIntoResult')); ?></textarea>
													</label>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="activeTab" value="<?php echo $activeTab; ?>" />
				<input type="hidden" name="type" value="<?php echo $vqData['type']; ?>" />
				<input type="hidden" name="quizId" value="<?php echo $vqData['quizId']; ?>" />

				<p class="area-wpvq-submit-tab">
					<button type="submit" class="button button-primary wpvq-submit-tab"><i class="fa fa-check-circle"></i> &nbsp; <?php _e("Save the configuration", 'wpvq'); ?></button>
				</p>
			</form>

		<?php elseif ($activeTab == 'questions'): ?>

			<form action="<?php echo esc_url(add_query_arg(array('noheader' => true))); ?>" method="POST">

				<?php if ($vqData['type'] == 'WPVQGamePersonality'): ?>
					<h3 class="dashicons-before dashicons-welcome-write-blog"> <?php _e("Step", 'wpvq'); ?> 2/2 — <?php _e("Add some questions & answers to your quiz", 'wpvq'); ?></h3>
				<?php else: ?>
					<h3 class="dashicons-before dashicons-welcome-write-blog"> <?php _e("Add some questions & answers to your quiz", 'wpvq'); ?></h3>
				<?php endif; ?>
				
				<p>
					<?php _e("You can add picture for each question and answer, it makes your quiz more fun and viral.", 'wpvq'); ?>
				</p>
				<p class="wpvq-protip">
					<strong><?php _e("Protip To Make The Perfect Quiz :", 'wpvq'); ?></strong> <br/>
					<?php _e("If you use pictures to illustrate the answers, each picture should be at least 300px * 300px.", 'wpvq'); ?>
				</p>
			
				<!-- Questions wrapper -->
				<div id="vq-questions">
					<?php if ($vqData['quizId'] != NULL): ?>
						<?php echo $vqData['parsedView']; ?>
					<?php endif ?>
				</div>

				<!-- Add question button -->
				<div class="vq-add-question">+ <?php _e("Add a new question", 'wpvq'); ?></div>

				<!-- Hidden fields -->
				<input type="hidden" name="activeTab" value="<?php echo $activeTab; ?>" />
				<input type="hidden" name="type" value="<?php echo $vqData['type']; ?>" />
				<input type="hidden" name="quizId" value="<?php echo $vqData['quizId']; ?>" />

				<!-- If we need to delete some existing stuff -->
				<input type="hidden" name="deleteQuestions" value="" />
				<input type="hidden" name="deleteAnswers" value="" />

				<hr style="border:0px; border-bottom:4px dashed #dedede;margin:25px 0;">

				<p class="area-wpvq-submit-tab">
					<button type="submit" class="button button-primary wpvq-submit-tab"><i class="fa fa-check-circle"></i> &nbsp; <?php _e("Save the questions", 'wpvq'); ?></button>
				</p>
			</form>
			
		<?php else: /* == appreciations */ ?>

			<form action="<?php echo esc_url(add_query_arg(array('noheader' => true))); ?>" method="POST">
				<?php if ($vqData['type'] == 'WPVQGamePersonality'): ?>
					<div id="step-personalities">
						<h3 class="dashicons-before dashicons-id-alt"> <?php _e("Step", 'wpvq'); ?> 1/2 — <?php _e("Create some personalities for your quiz", 'wpvq'); ?></h3>
						<p>
							<?php _e("If you put a picture in your personality descriptions", 'wpvq'); ?>, 
							<?php _e("it will be used in the Facebook share box.", 'wpvq'); ?>
							<br /><a href="https://www.ohmyquiz.io/knowledgebase/can-set-picture-facebook-share-dialog/" target="_blank"><?php _e("See what it means.", 'wpvq'); ?></a>
						</p>
						<div id="vq-list-personalities">
							<?php if ($vqData['quizId'] != NULL): ?>
								<?php echo $vqData['parsedViewAppreciations']; ?>
							<?php endif ?>
						</div>

						<div class="vq-add-personality">+ <?php _e("Add a new personality", 'wpvq'); ?></div>
					</div>
				<?php endif; ?>
			
				<?php if ($vqData['type'] == 'WPVQGameTrueFalse'): ?>
					<div>
						<h3 class="dashicons-before dashicons-awards">&nbsp;<?php _e("Quiz results depending on the score", 'wpvq'); ?></h3>
						<p>
							<?php _e("Write something to people depending on their score.", 'wpvq'); ?> 
							<?php _e("If you put a picture in an appreciation", 'wpvq'); ?>, 
							<?php _e("it will be used in the Facebook share box.", 'wpvq'); ?>
							<a href="https://www.ohmyquiz.io/knowledgebase/can-set-picture-facebook-share-dialog/" target="_blank"><?php _e("See what it means.", 'wpvq'); ?></a>
						</p>

						<div class="wpvq-truefalse-appreciations-example wpvq-protip">
							<p>
								<strong><?php _e("An example", 'wpvq'); ?></strong>, <?php _e("for a quiz with 10 questions", 'wpvq'); ?> :
							</p>
							<ul>
								<li><span style="font-weight:600;"><?php _e("Less than 4 points", 'wpvq'); ?></span> (= 0, 1, 2, 3) : "<?php _e("you are bad. Just bad.", 'wpvq'); ?>"</li>
								<li><span style="font-weight:600;"><?php _e("Less than 8 points", 'wpvq'); ?></span> (= 4, 5, 6, 7) : "<?php _e("Hum okay, not bad!", 'wpvq'); ?>"</li>
								<li><span style="font-weight:600;"><?php _e("Less than 10 points", 'wpvq'); ?></span> (= 8, 9) : "<?php _e("Really nice, good game.", 'wpvq'); ?>"</li>
								<li><span style="font-weight:600;"><?php _e("Less than 11 points", 'wpvq'); ?></span> (= 10) : "<?php _e("Perfect! You are a real rockstar!", 'wpvq'); ?>"</li>
							</ul>
						</div>

						<div id="vq-list-appreciations">
							<?php if ($vqData['quizId'] != NULL): ?>
								<?php echo $vqData['parsedViewAppreciations']; ?>
							<?php endif ?>
						</div>
						<div class="vq-add-appreciation">+ <?php _e("Add a new appreciation", 'wpvq'); ?></div>
					</div>
				<?php endif; ?>

				<!-- If we need to delete some existing stuff -->
				<input type="hidden" name="deleteAppreciations" value="" />

				<!-- Hidden fields -->
				<input type="hidden" name="activeTab" value="<?php echo $activeTab; ?>" />
				<input type="hidden" name="type" value="<?php echo $vqData['type']; ?>" />
				<input type="hidden" name="quizId" value="<?php echo $vqData['quizId']; ?>" />

				<hr style="border:0px; border-bottom:4px dashed #dedede;margin:25px 0;">

				<p class="area-wpvq-submit-tab">
					<button type="submit" class="button button-primary wpvq-submit-tab"><i class="fa fa-check-circle"></i> &nbsp; <?php _e("Save the appreciations", 'wpvq'); ?></button>
				</p>
			</form>

		<?php endif; // switch $_GET['tab'] ?>

	</div>

	<!-- Floating Div with shortcuts -->
	<div id="wpvq-fixed-shortcuts">
		<h3><?php _e("Shortcuts :", 'wpvq'); ?></h3>
		<ul>
			<?php if ($activeTab == 'questions'): ?>
				<li class="wpvq-shortcuts-minimize-all"><i class="fa fa-minus-square-o"></i> <?php _e("Minimize all the questions", 'wpvq'); ?></li>
				<li class="wpvq-shortcuts-expand-all"><i class="fa fa-plus-square-o"></i> <?php _e("Expand all the questions", 'wpvq'); ?></li>
			<?php endif; ?>
			<li class="wpvq-shortcuts-scroll-to-top"><i class="fa fa-arrow-up"></i> <?php _e("Scroll to the begining", 'wpvq'); ?></li>
			<li class="wpvq-shortcuts-scroll-to-bottom"><i class="fa fa-arrow-down"></i> <?php _e("Scroll to the end", 'wpvq'); ?></li>
		</ul>
	</div>

</div>


<script type="text/javascript">

	// Quiz Type
	var vqDataQuizType = '<?php echo $vqData['type']; ?>';
	// Show miniatures ?
	var wpvq_showMiniature = <?php echo ($vqData['showMiniature']) ? "true":"false"; ?>;
	var wpvq_needSave 		= false; // prevent from closing window without saving

	// Template var
	var wpvq_template_question		= <?php echo json_encode($vqData['template']['question']); ?>;
	var wpvq_template_answer		= <?php echo json_encode($vqData['template']['answer']); ?>;
	var wpvq_template_multipliers	= <?php echo json_encode($vqData['template']['multipliers']); ?>;
	var wpvq_template_appreciation	= <?php echo json_encode($vqData['template']['appreciation']); ?>;
	var wpvq_template_personality	= <?php echo json_encode($vqData['template']['personality']); ?>;

	// CKE Editor : add <p> (1) or not (2) ?
	var wpvq_cke_enterMode = <?php echo apply_filters('wpvq_cke_enterMode', 1); ?>;
	CKEDITOR.config.mathJaxLib = '//cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML';

	// General JS var
	<?php if($vqData['quizId'] == NULL): ?>
		var questionIndex 		=  1;
		var answersIndex 		=  [];
		var appreciationIndex 	=  1;
	<?php else: ?>
		var questionIndex 		=  <?php echo $vqData['JS_questionIndex']; ?>;
		var answersIndex 		=  <?php echo $vqData['JS_answersIndex']; ?>;
		var appreciationIndex 	=  <?php echo $vqData['JS_appreciationIndex']; ?>;
	<?php endif; ?>

	// TrueFalse Quiz
	<?php if ($vqData['type'] == 'WPVQGameTrueFalse'): ?>
		<?php if($vqData['quizId'] == NULL): ?>
			var vqAppreciations 		=  [];
		<?php else: ?>
			var vqAppreciations 		=  '';
		<?php endif; ?>
	<?php endif; ?>


</script>