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

										<div class="form-group-lg">

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
								<h3>1. Select Your Class</h3>
								<p><small>To begin viewing on-screen or downloadable reports or to edit your class, first choose your class group from the drop-down menu.</small></p>
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
								<h3>2. View Class Reports</h3>
								<p><small>Select a 'Topic' and corresponding month that you wish to view the report of. A graphical chart will display the results of every student within your class that has completed one or more multi-choice tests for the topic. A student must complete a minimum of 5 tests for a progress bar displaying their % average score to appear.</small></p>
							</div><!-- ENDS col -->

						</div><!-- ENDS row -->



						<hr class="small">



						<div class="row">
							<div class="col-md-12">

								<?php
								/*************************************************************************************************************************************************************************/
								// THIS SECTION SHOWS THE RESULTS FOR ALL STUDENTS IN A CLASS -> BY TOPIC
								/*************************************************************************************************************************************************************************/
								if( isset($results))
								{

									//****************************************************************************//
									// PERFORMANCE KEY
									//****************************************************************************//
									if( isset($topic) && $this->input->post('token'))
									{
										// Show performance rating guage
										echo '<div class="rating-container">';
											echo '<span class="poor rating">&nbsp;</span> Poor';
											echo '<span class="good rating">&nbsp;</span> Satisfactory';
											echo '<span class="satisfactory rating">&nbsp;</span> Good';
											echo '<span class="excellent rating">&nbsp;</span> Excellent';
										echo '</div>';

										echo '<h2>' . strtoupper($topic->topic) . '</h2>';
										echo '<div class="multiseparator vc_custom"></div>';
									}

									

									// Initiate these vars to prevent errors
									$month = $this->input->post('month');
									$n_month = 'n_' . $this->input->post('month');
									$total = 0;
									$num = 0;


									// Display Topic Name and selected month
									echo '<h3 class="bold">' . $topic->topic . ' <span class="bold textOrange">[' . $month . ' - ' . date('Y') . ']</span></h3>';

									
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
													
													echo '<div class="row result">';

														echo '<div class="col-md-4">';
															echo '<p><strong>' . strtoupper($row->last_name) . '</span>, ' . $row->first_name . '</strong> <span class="text-redLight">(' . $row->$n_month . ')</span> ' . $average_score_percent . '%</p>';
														echo '</div>';

														echo '<div class="col-md-8">';
															echo '<span class="guage-container">';
																echo '<span class="guage poor" style="width:0%;"></span>';
															echo '</span>';
														echo '</div>';
														
													echo '</div><!-- ENDS row -->';
												
												} else {
													
													echo '<div class="row result">';

														echo '<div class="col-md-4">';
															echo '<p><strong>' . strtoupper($row->last_name) . ', ' . $row->first_name . '</strong> (' . $row->$n_month . ') ' . $average_score_percent . '%</p>';
														echo '</div>';

														echo '<div class="col-md-8">';
															echo '<span class="guage-container">';
																echo '<span class="guage ' . $div_colour . ' " style="width:' . $average_score_percent . '%;"></span><span class="guage-line"></span>';
															echo '</span>';
														echo '</div>';

													echo '</div><!-- ENDS row -->';
												}
												
											}

											if($average_score_percent >0)
											{
												$num++;
											}


										endforeach;

									echo '<hr class="small">';
									
								}

								?>



							</div><!-- ENDS col -->
						</div><!-- ENDS row -->



						



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
								<h3>3. View Individual Student Reports</h3>
								<p><small>To view a progress report of an individual student, click the 'View Students' button and then click on the name of the student you wish to access. Monthly breakdowns and full yearl summaries are available. </small></p>
								<p><small>Click the 'Leaderboard' button to view where your students are placed against others within your school and nationally.</small></p>
							</div><!-- ENDS col -->

						</div><!-- ENDS row -->


						</div><!-- ENDS $hide_mw -->


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