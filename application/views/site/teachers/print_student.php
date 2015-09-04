<div class="band-grey">
	<div class="container results">
		<div class="row">
			<div class="col-lg-12 col-full">


				<h2>Print Reports - Students</h2>
				<div class="multiseparator vc_custom"></div>


				<div class="well well-trans">



					<h3>Click on student name to download report</h3>
					<p><small>* Students with their names greyed out have NOT completed any test topics in <?php echo date('Y'); ?></small></p>


					<div>

						<?php
						// Use this form for reordering the results
						// i.e. By Topic / Results / Num Tests
						// This is jQuery on(change) function - see bottom of page
						if( $this->uri->segment(3))
						{
							echo '<h3 class="bold">&nbsp;</h3>';
							echo '<p class="bold">View individual student progressions per topic over 12 months.</p>';

							echo form_open('teachers_topic_pdf/results_PDF/' . $this->uri->segment(3));
							//echo form_open('teachers_topic_pdf/results_PDF/');

							echo '<fieldset>';

							echo '<legend class="purple">SINGLE STUDENT - ALL RESULTS</legend>';

								echo '<input type="hidden" name="token" id="token" value="'.$token.'" />';
								echo '<input type="hidden" name="studentID" id="studentID" value="'.$this->uri->segment(3).'" />';

								echo '<label></label>';
								echo anchor('teachers/refresh_class_students_print', 'See All Students', array('style' => 'float:right;'));

								echo '<input type="submit" name="submit" id="submit" value="Download Report" />';

							echo '</fieldset>';

							echo form_close();
						}

						?>

					</div>





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
										
										$segments = array( 'teachers_stud_pdf/results_PDF/' . $row->studentID);

											if( substr($name, 0, 1) == $letter )
											{
												// Only show new alpha letter at the start of each alpha category
												$alpha_header = ( $set_letter != $letter ) ? $letter  . '<div class="multiseparator vc_custom"></div>' : ''; 

												// Display alpha letter (i.e., A, B, C ...)
												echo '<h3 class="text-redLight">' . $alpha_header . '</h3>';

												//if( $row->$n_month)
												if($row->studentID)
												{
													echo '<h5>' . anchor( $segments, '<strong>' . strtoupper($row->last_name) . '</strong>, ' . $row->first_name, array('class' => 'non strong') ) . '</h5>';
													echo '<h6>'.$row->email.'</h6>';
												}
												else
												{
													echo '<h5 style="margin-bottom:0;"><span class="text-greyLight">' . strtoupper($row->last_name) . ', ' . $row->first_name . '</span></h5>';
													echo '<h6 class="text-greyLight">'.$row->email.'</h6>';
												}


												echo '<div class="underLine"></div>';
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
						echo '<h3 class="text-redLight">No students found in this class.</h3>';
					}	
					?>

				</div><!-- ENDS well well-trans -->

			</div><!-- ENDS col -->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->



<script type="text/javascript">
	
// Submit form when onChange radion button #flash_opt
(function(){
	
	//$("#submit_But").hide(); // Hide submit but

	$("#topic").on('change', function () {
		this.form.submit();
	});
	

})();


</script>