<div class="band-grey">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-full">

					<h2>Screen reports: <?php echo get_class_name( $this->session->userdata('classID') ); ?></h2>
					<p>
						This section allows you to view individual students or complete class results either on-screen or as downloadable PDFs.
					</p>
					<div class="multiseparator vc_custom"></div>


					<?php
						// Hide everything else on page until they select a class (therefore creating a session 'classID' )
						$hide_me = ( ! $this->session->userdata('classID') ) ? 'display:none;' : '';
					?>


					<div class="well well-trans">

						<div class="row">
							<div class="col-md-4">

								<?php
								/*
								|-----------------------------------------------------------------------------------------------------------------
								| THIS IS THE MASTER 'SET YOU CLASS' DROP DOWN MENU
								| WHY? So the teacher doesn't have to constantly keep selecting their class in the teacher admin section!
								|-----------------------------------------------------------------------------------------------------------------
								*/
								echo form_open('teachers/set_class');
								?>

									<fieldset>

										<div class="form-group-sm">

											<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
											<input type="hidden" name="current_URL" id="current_URL" value="<?php echo $this->uri->segment(2); ?>" />

											<label>Select a class from</label>

											<?php

												// Set $class to current session -> classID
												$current_class = get_class_name( $this->session->userdata('classID'));
												// Display class list dropdown menu (with current selected class)
												echo classDropdown($this->session->userdata('classID'), $this->session->userdata('classID'), $current_class, $this->session->userdata('school') ); 
												
												if( $this->session->userdata('classID') )
												{
													echo anchor('teachers/class_message_form', '<strong>Create Class Message</strong>', array('class'=>'btn btn-sm btn-red btn-block'));
												}
											?>

										</div><!-- ENDS form-group-lg -->

									</fieldset>

								<?php echo form_close(); ?>
								
							</div><!-- ENDS col -->


							<div class="col-md-8">
								<p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec bibendum purus eu ex imperdiet, quis semper felis pulvinar. Phasellus imperdiet id massa nec vehicula. Aenean at lobortis justo, in ultricies purus. Duis vel luctus tortor. Integer a ante arcu. Mauris pellentesque egestas convallis. Integer vel magna et purus pretium feugiat quis quis eros. Sed faucibus, ipsum ut placerat pellentesque, orci sem tincidunt sem, sit amet facilisis felis risus in eros. Morbi euismod volutpat nibh, mattis accumsan magna volutpat quis. Praesent convallis at lectus sollicitudin euismod. Etiam sem arcu, efficitur vitae purus id, cursus consequat eros. </small></p>
							</div><!-- ENDS col -->

						</div><!-- ENDS row -->



						<hr class="small">


						<div style="<?php echo $hide_me; ?>"><!-- HIDE BELOW IF CLASS NOR SELECTED -->
						

						<div class="row">	
							<div class="col-md-4">

								<div class="form-group-sm">

									<?php
									/************************************************************************************************************/
									// This form will retrieve ALL results for a single topic/month for an entire class group
									/************************************************************************************************************/
									echo form_open('teachers/view_month', array('class' => 'bg_computer')); // THIS SHOWS RESULTS ON PAGE!!

									?>

										<fieldset>


											<label>View class results - topic and month</label>
											<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

											<?php 
												echo dropDownTopics('', '', 'Select Topic'); // See admin_helper
											?>

											

											<?php
												$month = date('M'); // Get current Month - for 'value'
												$month_full = date('F'); // Get current Month - for 'label'

												echo monthDropdown($value=$month, $selected=$month, $label=$month_full);
											?>
											
											<input type="submit" name="submit" class="btn btn-sm btn-red btn-block" id="submit" value="View Results" />

										</fieldset>


									<?php 
										if( isset($error))
										{
											echo $error;
										}
										echo form_close(); 
									?>

								</div><!-- ENDS form-group-lg -->

								<hr class="small visible-xs">
							
							</div><!-- ENDS col -->


							<div class="col-md-8">
								<p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec bibendum purus eu ex imperdiet, quis semper felis pulvinar. Phasellus imperdiet id massa nec vehicula. Aenean at lobortis justo, in ultricies purus. Duis vel luctus tortor. Integer a ante arcu. Mauris pellentesque egestas convallis. Integer vel magna et purus pretium feugiat quis quis eros. Sed faucibus, ipsum ut placerat pellentesque, orci sem tincidunt sem, sit amet facilisis felis risus in eros. Morbi euismod volutpat nibh, mattis accumsan magna volutpat quis. Praesent convallis at lectus sollicitudin euismod. Etiam sem arcu, efficitur vitae purus id, cursus consequat eros. </small></p>
							</div><!-- ENDS col -->

						</div><!-- ENDS row -->



						<hr class="small">



						<div class="row">
							<div class="col-md-4">

								<div class="form-group-lg">

									<?php
									/************************************************************************************************************/
									// This form will first display a full list of students in a single class group
									// Then each student can be clicked to view their entire results for the current month
									/************************************************************************************************************/
									echo form_open('teachers/show_class_students', array('class' => 'bg_computer'));

									
									// Set the default label / value for the Class dropdown menu
									// i.e. Remember the Teacher/Class name so we don't have to reselect!
									// Used in classDropdown($value, $selected, $label) below
									if( isset($class) && $this->session->userdata('classID'))
									{
										$value = $this->session->userdata('classID');
										$selected = $this->session->userdata('classID');
										$label = $class->class_name;
									}
									else
									{
										$value = '';
										$selected = ''; 
										$label = 'Classes for '. $this->session->userdata('school');
									}
									/****************************************************************************/

									?>

									<fieldset>

										<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

										<label>View individual students results for each month</label>

										<input type="submit" name="submit" class="btn btn-sm btn-red btn-block" id="submit" value="View Students" />
										<br><br>

										<!-- Display Teachers access button to the Leaderboard -->
										<?php echo anchor('results/leaders_school', 'Leader Board', array('class'=>'btn btn-sm btn-red btn-block')); ?>

									</fieldset>

									<?php

										if( isset($error2)) { echo $error2; }
										echo form_close();

									?>

								</div><!-- ENDS form-group-lg -->

								<hr class="small visible-xs">

							</div><!-- ENDS col -->


							<div class="col-md-8">
								<p><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec bibendum purus eu ex imperdiet, quis semper felis pulvinar. Phasellus imperdiet id massa nec vehicula. Aenean at lobortis justo, in ultricies purus. Duis vel luctus tortor. Integer a ante arcu. Mauris pellentesque egestas convallis. Integer vel magna et purus pretium feugiat quis quis eros. Sed faucibus, ipsum ut placerat pellentesque, orci sem tincidunt sem, sit amet facilisis felis risus in eros. Morbi euismod volutpat nibh, mattis accumsan magna volutpat quis. Praesent convallis at lectus sollicitudin euismod. Etiam sem arcu, efficitur vitae purus id, cursus consequat eros. </small></p>
							</div><!-- ENDS col -->

						</div><!-- ENDS row -->


						</div><!-- ENDS $hide_mw -->







					<?php
					/*************************************************************************************************************************************************************************/
					// THIS SECTION SHOWS THE RESULTS FOR ALL STUDENTS IN A CLASS -> BY TOPIC
					/*************************************************************************************************************************************************************************/
					if( isset($results))
					{
						echo '<div class="gridPadding textPadding" style="margin-top:-20px;">';


						$score_guage = array(
								'src' => $this->css_path_url . 'main/misc/score_guage.png',
								'alt' => 'eLearn Economics',
								'width' => '400',
								'height' => '25',
								'style' => 'float:right; margin:5px 30px 0 0;'
							);

						echo img($score_guage);

						

						// Initiate these vars to prevent errors
						$month = $this->input->post('month');
						$n_month = 'n_' . $this->input->post('month');
						$total = 0;
						$num = 0;


						// Display Topic Name and selected month
						echo '<h3 class="bold">' . $topic->topic . ' <span class="bold textOrange">[' . $month . ' - ' . date('Y') . ']</span></h3>';

						echo '<ul id="chart">';
						
							foreach($results as $row):

								$total = $row->$month; // get average value
								$average = ($total/5); // get average value
								$average_score_percent = ($average * 10); // round up to 10


								/**********************************************************/
								// Work out colour coded div progress bar
								// See section_helper.php
								$div_colour = resultColourCodes($average_score_percent);
								/**********************************************************/

								
								if( $average_score_percent !=0)
								{
									if($row->$n_month <5) // if total number to tests completed if less than 5 - show 'Not Enough Data'
									{
										echo 	'<li>' . strtoupper($row->last_name) . '</span>, ' . $row->first_name . ' | '.$average_score_percent.'% - less than 5 Tests | Tests: <span class="bold">' . $row->$n_month . '</li>';
										echo 	'<li title="'.$average_score_percent.'" class="codeGrey">
												<span class="bar"></span>
												<span class="percent"></span>
											</li>';
									}
									else
									{
										echo 	'<li>' . strtoupper($row->last_name) . ', ' . $row->first_name . ' | <span class="bold textOrange">'.$average_score_percent.'%</span> | Tests: <span class="bold">' . $row->$n_month . '</span></li>';
										echo 	'<li title="'.$average_score_percent.'" class="'.$div_colour.'">
												<span class="bar"></span>
												<span class="percent"></span>
											</li>';
									}
									
								}

								if($average_score_percent >0)
								{
									$num++;
								}


							endforeach;

						echo '</ul>';
						

						echo '</div>';
					}

					?>

					</div><!-- ENDS well well-trans -->

			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!-- ENDS band-white -->


<script type="text/javascript">
	
	// Submit form when onChange 'drop down'
	(function(){
		
		$("#classID").on('change', function () {
			this.form.submit();
		});
		

	})();


</script>