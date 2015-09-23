<div class="band-grey">
	<div class="container results">
		<div class="row">
			<div class="col-lg-12 col-full">


				<h2>Teachers Admin - Screen Reports</h2>
				<div class="multiseparator vc_custom"></div>


				<div class="well well-trans">


					<div class="row">
						<div class="col-md-6">

							<?php
							// Use this form for reordering the results
							// i.e. By Topic / Results / Num Tests
							// This is jQuery on(change) function - see bottom of page
							if( $this->uri->segment(3))
							{

								echo form_open('teachers/view_student/' . $this->uri->segment(3));

								echo '<fieldset>';

								echo '<h3>Breakdown by Month</h3>';

									echo '<input type="hidden" name="token" id="token" value="'.$token.'" />';

									// Need these for sticky values on date drop down menu
									if( $this->input->post('month'))
									{
										$month = $this->input->post('month');
										$month_full = $this->input->post('month');
									}
									else
									{
										$month = date('M');
										$month_full = date('F');
									}

									echo '<div class="form-group-lg">';
										echo '<label for="month">Select Month</label>';
										echo monthDropdown($value=$month, $selected=$month, $label=$month_full);
									echo '<div>';

									echo '<div class="form-group-lg">';
										echo '<label for="order">Select Filter</label>';
										echo orderDropdown($value='', $selected='', $label='Order Results by');
									echo '<div>';

									echo anchor('teachers/refresh_class_students', 'Select a Student', array('class' => 'btn btn-sm btn-red')) . '<br /><br />';

									//echo '<input type="submit" name="submit" id="submit" value="View Students" />';

								echo '</fieldset>';


								if( isset($error))
								{
									echo $error;
								}

								echo form_close();
							}

							?>

						</div><!-- ENDS col -->



						<div class="col-md-6">

							<?php
							// Use this form for reordering the results
							// i.e. By Topic / Results / Num Tests
							// This is jQuery on(change) function - see bottom of page
							if( $this->uri->segment(3))
							{

								echo form_open('teachers/results_by_topic/' . $this->uri->segment(3));

								echo '<fieldset>';

								echo '<h3>12 Month Breakdown</h3>';

									echo '<input type="hidden" name="token" id="token" value="'.$token.'" />';

									echo '<div class="form-group-lg">';
										echo '<label for="topic">View individual student progressions per topic over 12 months</label>';
										//echo dropDownTopics('', '', 'List of Topics'); // See admin_helper
										echo topicsWithResultsStudents('', '', 'Select Topic'); // See section_helper
									echo '<div>';

									echo anchor('teachers/refresh_class_students', 'Select a Student', array('class' => 'btn btn-sm btn-red'));

									//echo '<input type="submit" name="submit" id="submit" value="View Students" />';

								echo '</fieldset>';

								if( isset($error2))
								{
									echo $error2;
								}

								echo form_close();
							}

							?>

						</div><!-- ENDS col -->
					</div><!-- ENDS row -->


			
				
						


					<?php
					/*************************************************************************************************************************************************************************/
					// THIS SECTION SHOWS A FULL LIST OF STUDENT NAMES IN THE SELECTED CLASS (all with hyperlinks)
					/*************************************************************************************************************************************************************************/
					$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$letters = str_split($alphabet);
					$set_letter = FALSE;

					// $month = date('M');
					// $n_month = 'n_' . date('M');

					// Display full list of topics in alphabetical order with letter (A, B, C) as heading
					if( isset($students))
					{
						$results = count($students);
						$per_column = ceil($results/3);
						
						$i = 0;
						

						echo '<div class="row topics-list">';
							echo '<div class="col-sm-4">';

								/*************************************************************************/
								// Loop through each topic alphbetically
								/*************************************************************************/
								foreach($students as $row):
								
									 if($i == $per_column)
									 {
										echo '</div><div class="col-sm-4">';
										$i = 0;
									 }
								 
										/*************************************************************************/
										// Break topics up by each letter of alphabet - Use letter (A, B, C ..) as label
										/*************************************************************************/
										foreach($letters as $letter):

										// Convert last name to uppercase (otherwise the $alphabet array() being uppercase will miss the lowercase names)
										$name = strtoupper($row->last_name);
										
										$segments = array( 'teachers/view_student/' . $row->studentID);

											if( substr($name, 0, 1) == $letter )
											{
												// Only show new alpha letter at the start of each alpha category
												$alpha_header = ( $set_letter != $letter ) ? $letter  . '<div class="multiseparator vc_custom"></div>' : ''; 

												// Display alpha letter (i.e., A, B, C ...)
												echo '<h3 class="text-redLight">' . $alpha_header . '</h3>';
												
												// Display list of student names ...
												if($row->studentID)
												{
													// Completed at least one test ...
													echo '<p>' . anchor( $segments, '<strong>' . strtoupper($row->last_name) . ', ' . $row->first_name .'</strong>', array('class' => 'non strong') ) . '<br />';
													echo '<small>'.$row->email.'</small></p>';
												}
												else
												{
													// NOT completed any tests ...
													echo '<p><span class="text-greyLight">' . strtoupper($row->last_name) . ', ' . $row->first_name . '</span></br />';
													echo '<small class="text-greyLight">'.$row->email.'</small></p>';
												}

												// Save alpha letter as var to test against looped through version above
												$set_letter = $letter; 
											}
											
										endforeach;
										
										/*************************************************************************/
									 
									 $i++;
									 
								endforeach;
						
							echo '</div>';
						echo '</div>';
					

					}

					if( ! isset($students) && ! $this->uri->segment(3))
					{
						echo '<h4 class="text-redLight">No students found in this class.</h4>';
					}	
					?>






					<div class="row">
						<div class="col-md-12">
							<?php
								if( ! $this->uri->segment(3))
								{
									echo '<br /><p><small>* Students with their names greyed out indicate they have NOT completed any test topics in '.date('Y').'</small></p>';
								}
							?>
						</div><!--ENDS col-->
					</div><!--ENDS row-->






					<?php
					/*************************************************************************************************************************************************************************/
					// THIS SECTION SHOWS THE RESULTS FOR INDIVIDUAL STUDENTS IN A CLASS -> FOR 'ALL WORK / TOPICS' BY MONTH
					/*************************************************************************************************************************************************************************/
					if( isset($single_student))
					{

						echo '<div class="gridPadding textPadding">';

						// Show performance rating guage
						echo '<div class="rating-container">';
							echo '<span class="poor rating">&nbsp;</span> Poor';
							echo '<span class="good rating">&nbsp;</span> Satisfactory';
							echo '<span class="satisfactory rating">&nbsp;</span> Good';
							echo '<span class="excellent rating">&nbsp;</span> Excellent';
						echo '</div>';

						

						$month = ($this->input->post('month')) ? $this->input->post('month') : date('M'); // Initiate default month if not POSTed

						if( isset($student_details))
						{
							// These just display the label for which order is selected
							if($this->input->post('order') ==3)
							{
								$order = '(by No. OF TESTS COMPLETED)';
							}
							elseif($this->input->post('order') ==2)
							{
								$order = '(by BEST RESULTS)';
							}
							else
							{
								$order = '(by TOPIC NAME)';
							}

							echo '<h3>' . ucwords($student_details->first_name) . ' ' . strtoupper($student_details->last_name) . '<br />';
							echo '<small>' . $order . ' - ' . $month . ' / ' . date('Y') . '</small></h3>';
						}

						// Initiate these vars to prevent errors
						// Default month will be current month!
						if( $this->input->post('month'))
						{
							$month = $this->input->post('month');
							$n_month = 'n_' . $this->input->post('month');
						}
						else
						{
							$month = date('M');
							$n_month = 'n_' . date('M');
						}
						
						$total = 0;
						$num = 0;

					
						foreach($single_student as $row):

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
											echo '<p><strong>' . strtoupper($row->topic) . '</strong> <br />Last Test: (' . $row->test_date . ') <span class="text-redLight">(' . $row->$n_month . ')</span> ' . $average_score_percent . '%</p>';
										echo '</div>';
										echo '<div class="col-md-8">';
											echo '<span class="guage-container">';
												echo '<span class="guage poor " style="width:0%;"></span>'; // Don't display any progress bar!
											echo '</span>';
										echo '</div>';
										
									echo '</div><!-- ENDS row -->';
								}
								else
								{
									echo '<div class="row result">';

										echo '<div class="col-md-4">';
											echo '<p><strong>' . strtoupper($row->topic) . '</strong> <br />Last Test: (' . $row->test_date . ') - (' . $row->$n_month . ') ' . $average_score_percent . '%</p>';
										echo '</div>';
										echo '<div class="col-md-8">';
											echo '<span class="guage-container">';
											echo '<span class="guage '.$div_colour.'" style="width:' . $average_score_percent . '%;"></span><span class="guage-line"></span>';
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



						echo '</div>';
					}

					?>





					<div class="gridPadding textPadding">

					<?php
					/*************************************************************************************************************************************************************************/
					// THIS SECTION SHOWS THE RESULTS FOR INDIVIDUAL STUDENTS BY SINGLE TOPICS - DISPLAYS FULL 12 MONTH BREAKDOWN LIST!!!
					/*************************************************************************************************************************************************************************/

					//****************************************************//
					// Start showing / formating the results
					//****************************************************//
					if( isset($topic_results) && $this->input->post('token'))
					{
						
						// Show performance rating guage
						echo '<div class="rating-container">';
							echo '<span class="poor rating">&nbsp;</span> Poor';
							echo '<span class="good rating">&nbsp;</span> Satisfactory';
							echo '<span class="satisfactory rating">&nbsp;</span> Good';
							echo '<span class="excellent rating">&nbsp;</span> Excellent';
						echo '</div>';


						echo '<h2>' . ucwords($student_details->first_name) . ' ' . strtoupper($student_details->last_name) . '</h2>';
						echo '<h3>' . strtoupper($topic->topic) . '</h3>';
						echo '<p><small>LAST TEST DATE: <strong class="text-redLight">' . $topic_results->test_date . '</strong></small></p>';


						// Initiate these vars to prevent errors
						$month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
						$n_month = array('n_Jan', 'n_Feb', 'n_Mar', 'n_Apr', 'n_May', 'n_Jun', 'n_Jul', 'n_Aug', 'n_Sep', 'n_Oct', 'n_Nov', 'n_Dec');
						$total = 0;
						$min_tests = FALSE;


					

						for ($i = 0, $num = count($month); $i < $num; $i++):

							$total = $topic_results->$month[$i]; // get average value
							$average = ($total/5); // get average value
							$average_score_percent = ($average * 10); // round up to 10

							

							/**********************************************************/
							// Work out colour coded div progress bar
							// See section_helper.php
							$div_colour = resultColourCodes($average_score_percent);
							/**********************************************************/
							
							

							if($topic_results->$n_month[$i] <5) // if total number to tests completed if less than 5 - show 'Not Enough Data'
							{
								$min_tests = ( date('M') == $month[$i] && $average_score_percent) ? ' - Min of 5 tests required.' : '';

								echo '<div class="row result">';

									echo '<div class="col-md-2">';
										echo '<p>' . $month[$i] . ' ' . date('Y') . ' <span class="text-redLight">(' . $topic_results->$n_month[$i] . ') </span> ' . $average_score_percent . '% </p>';
									echo '</div>';
									echo '<div class="col-md-10">';
										echo '<span class="guage-container">';
											echo '<span class="guage poor " style="width:0%;"></span>'; // Don't display any progress bar!
										echo '</span>';
									echo '</div>';
									
								echo '</div><!-- ENDS row -->';
							}
							else
							{

								echo '<div class="row result">';

									echo '<div class="col-md-2">';
										echo '<p>' . $month[$i] . ' ' . date('Y') . ' (' . $topic_results->$n_month[$i] . ') ' . $average_score_percent . '% </p>';
									echo '</div>';
									echo '<div class="col-md-10">';
										echo '<span class="guage-container">';
										echo '<span class="guage '.$div_colour.'" style="width:' . $average_score_percent . '%;"></span><span class="guage-line"></span>';
										echo '</span>';
									echo '</div>';
									
								echo '</div><!-- ENDS row -->';
							}


							$total = 0; // Reset $total back to '0'

						endfor;


					}

					?>


					</div>


				</div><!-- ENDS well well-trans -->


			</div><!-- ENDS col -->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->


<script type="text/javascript">
	
// Submit form when onChange radion button #flash_opt
(function(){
	
	//$("#submit_But").hide(); // Hide submit but

	$(".month").on('change', function () {
		this.form.submit();
	});

	$(".order").on('change', function () {
		this.form.submit();
	});

	$("#topic").on('change', function () {
		this.form.submit();
	});
	

})();


</script>