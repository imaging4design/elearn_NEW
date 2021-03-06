<div class="band-topic-sections">
	<div class="container results">
		<div class="row">
			<div class="col-lg-12 col-full">

				<h2>Results Summary: <?php echo $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?></h2>
				<div class="multiseparator vc_custom"></div>

			</div>
		</div><!--ENDS row-->



		<div class="row">
			<div class="col-lg-6 col">

			<!--DISPLAY FORM ONE-->
				<?php echo form_open('results/results_by_topic'); ?>

					<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

					<h3>12 MONTH BREAKDOWN</h3>

					<?php
						$id = '';
						$topic_name = 'List of Topics';
						
						//echo dropDownTopics($id, $id, $topic_name); // See section_helper
						echo topicsWithResultsStudents($id, $id, $topic_name); // See section_helper
					?>

					<!--<input type="submit" name="sub_topic" value="Results by Topic" style="display:block;"/>-->
					

				<?php
				//****************************************************//
				// Display form errors
				//****************************************************//
					if( isset($topic_error))
					{
						echo $topic_error;
					}
					
					echo form_close(); 
				?>

			</div><!-- ENDS col -->

			<div class="col-lg-6 col">

				<!--DISPLAY FORM TWO-->
				<?php echo form_open('results/results_by_month', array('class' => 'bg_calendar')); ?>

					<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

					<h3>RESULTS PER MONTH</h3>

					<div class="row">
						<div class="col-sm-6">

							<?php 
								echo orderDropdown($value='topic', $selected='topic', $label='Order By'); 
							?>
						</div><!-- ENDS col -->

						<div class="col-sm-6">

							<?php
								$month = date('M'); // Get current Month - for 'value'
								$month_full = date('F'); // Get current Month - for 'label'
								echo monthDropdown($value=$month, $selected=$month, $label=$month_full); 
							?>
						</div><!-- ENDS col -->
					</div><!-- ENDS row -->

					<!--<input type="submit" name="sub_month" value="Results by Month" style="display:block;"/>-->
					

				<?php
				//****************************************************//
				// Display form errors
				//****************************************************//
					if( isset($month_error)) 
					{ 
						echo $month_error; 
					}
					echo form_close(); 
				?>
			</div><!-- ENDS col -->

		</div><!--ENDS row-->



	</div><!-- ENDS container -->
</div><!-- ENDS band-topic-sections -->



<div class="band-white">
	<div class="container results">
		<div class="row">
			<div class="col-lg-12">

				<?php
					//****************************************************************************//

					// DISPLAY RESULTS BY SINGLE TOPIC - SHOWS ALL 12 MONTHS RESULTS!

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

						echo '<h2>' . anchor('section/multi_choice/' . $topic->topicID, 'Take a Test', array( 'class'=>'btn btn-sm btn-red' )) . '<br class="marBot20 visible-xs"> ' . strtoupper($topic->topic) . '</h2>';
						echo '<div class="multiseparator vc_custom"></div>';
					}

				
			echo '</div><!-- ENDS col -->';
		echo '</div><!-- ENDS row -->';



		echo '<div class="row">';
			echo '<div class="col-lg-12">';

				//****************************************************//
				// Start showing / formating the results
				//****************************************************//
				if( isset($results) && $this->input->post('token'))
				{
					
					// Initiate these vars to prevent errors
					$month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
					$n_month = array('n_Jan', 'n_Feb', 'n_Mar', 'n_Apr', 'n_May', 'n_Jun', 'n_Jul', 'n_Aug', 'n_Sep', 'n_Oct', 'n_Nov', 'n_Dec');
					$total = 0;
					$min_tests = FALSE;


					echo '<p>Last test completed on: <strong>' . $results->test_date . '</strong></p>';


					for ($i = 0, $num = count($month); $i < $num; $i++):

						$total = $results->$month[$i]; // get average value
						$average = ($total/5); // get average value
						$average_score_percent = ($average * 10); // round up to 10


						/**********************************************************/
						// Work out colour coded div progress bar
						// See section_helper.php
						$div_colour = resultColourCodes($average_score_percent);
						/**********************************************************/
							

			echo '</div><!-- ENDS col -->';
		echo '</div><!-- ENDS row -->';


					if( $results->$n_month[$i] < 5 ) // if total number to tests completed if less than 5 - show 'Not Enough Data'
					{
						$min_tests = ( date('M') == $month[$i] && $average_score_percent) ? ' - Min of 5 tests required.' : '';

						echo '<div class="row result">';

							echo '<div class="col-md-2">';
								echo '<p><strong>' . $month[$i] . ' ' . date('Y') . '</strong> <span class="text-redLight">(' . $results->$n_month[$i] . ')</span> ' . $average_score_percent . '%</p>';
							echo '</div>';
							echo '<div class="col-md-10">';
								echo '<span class="guage-container">';
									echo '<span class="guage poor " style="width:0%;"></span>'; // Don't display any progress bar!
								echo '</span>';
							echo '</div>';
							
						echo '</div><!-- ENDS row -->';

					} else {

						echo '<div class="row result">';

							echo '<div class="col-md-2">';
								echo '<p><strong>' . $month[$i] . ' ' . date('Y') . '</strong> (' . $results->$n_month[$i] . ') ' . $average_score_percent . '%</p>';
							echo '</div>';
							echo '<div class="col-md-10">';
								echo '<span class="guage-container">';
									echo '<span class="guage '.$div_colour.'" style="width:' . $average_score_percent . '%;"></span><span class="guage-line"></span>';
								echo '</span>';
							echo '</div>';
							
						echo '</div>';
					}


			echo '<div class="row">';
				echo '<div class="col-lg-12">';


						$total = 0; // Reset $total back to '0'

					endfor;



				}

				//****************************************************//
				// Display 'No results message' if no results found
				//****************************************************//
				if( $this->input->post('sub_topic') && ( ! isset($results) && ! isset($topic_error) ) )
				{
					echo '<h4 class="bold">! No results found !</h4>';
				}

				echo '</div>';
			echo '</div>';

				?>





		<div class="row">
			<div class="col-lg-12">


				<?php
				//****************************************************************************//

				// DISPLAY RESULTS BY SELECTED MONTH - SHOWS ALL TOPICS STUDIED THAT MONTH!

				//****************************************************************************//
				if( isset($months) && $this->input->post('token'))
				{
					// Show performance rating guage
					echo '<div class="rating-container">';
						echo '<span class="poor rating">&nbsp;</span> Poor';
						echo '<span class="good rating">&nbsp;</span> Satisfactory';
						echo '<span class="satisfactory rating">&nbsp;</span> Good';
						echo '<span class="excellent rating">&nbsp;</span> Excellent';
					echo '</div>';

				}

				//****************************************************//
				// Start showing / formating the results
				//****************************************************//
				if( isset($months) && $this->input->post('token'))
				{
					
					// Initiate these vars to prevent errors
					$month = $this->input->post('month');
					$n_month = 'n_' . $this->input->post('month');
					$total = 0;
					$counter = 0; // Need this to display 'No results message' at bottom.

					// Display heading as to what results are ordered by
					if($this->input->post('order') ==3)
					{
						$order = '(by No. of Tests Completed)';
					}
					elseif($this->input->post('order') ==2)
					{
						$order = '(by Best Results)';
					}
					else
					{
						$order = '(by Topic Name)';
					}

					echo '<h3 class="bold">' . $month . ' / ' . date('Y') . ' ' . $order . '</h3>';


						foreach($months as $row):

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

										echo '<div class="col-md-6">';
											echo '<p><strong>' . strtoupper($row->topic) . '</strong><br class="visible-xs"> <span class="text-redLight">(' . $row->$n_month . ')</span> ' . $average_score_percent . '%</p>';
										echo '</div>';
										echo '<div class="col-md-6">';
											echo '<span class="guage-container">';
												echo '<span class="guage poor " style="width:0%;"></span>'; // Don't display any progress bar!
											echo '</span>';
										echo '</div>';
										
									echo '</div><!-- ENDS row -->';

								}
								else
								{
								
									echo '<div class="row result">';

										echo '<div class="col-md-6">';
										echo '<p><strong>' . strtoupper($row->topic) . '</strong><br class="visible-xs"> (' . $row->$n_month . ' - Last Test: ' . $row->test_date . ') ' . $average_score_percent . '%</p>';
										echo '</div>';
										echo '<div class="col-md-6">';
											echo '<span class="guage-container">';
												echo '<span class="guage '.$div_colour.'" style="width:' . $average_score_percent . '%;"></span><span class="guage-line"></span>';
											echo '</span>';
										echo '</div>';
										
									echo '</div>';

								}
									
							}

							if($average_score_percent >0)
							{
								$counter++;
							}

						endforeach;


				}

				//****************************************************//
				// Display 'No results message' if no results found
				//****************************************************//
				if( $this->input->post('sub_month') && ( $counter ==0 && ! isset($month_error) ) )
				{
					echo '<h4 class="bold">! No results found for this Month !</h4>';
				}
				?>






				<!--DISPLAY INSTRUCTIONS-->
				<br><h3>RESULTS SUMMARY <span class="text-redLight">(Information):</span></h3>

				<p>Each progress bar shows your average multi-choice test score (as %) for the <span class="bold">LAST FIVE TESTS</span> completed in the topic. (Each time you take a topic test, your oldest result is dropped and your newest result added - then your five latest test results are divided to show your average score).</p>

				<p><span class="text-redLight"><strong>NOTE:</strong></span> For progress results to be shown, you must complete at least five multi-choice tests (answering a minimum of 10 questions) in each topic.</p>

				<br>

				

				<div align="center">

					<h3>PDF Report <span class="text-redLight">(Month by Month)</span></h3>

					<!--DISPLAY DOWNLOAD PDF REPORT-->
					<?php echo form_open('students_pdf/results_PDF', array('style' => 'background:none;')); ?>

						<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
						<input type="hidden" name="studentID" id="studentID" value="<?php echo $this->session->userdata('studentID'); ?>" />
						<input type="submit" name="report" value="&#xf019; Download" class="btn btn-md btn-red fa-fa" />

					<?php echo form_close(); ?>

				</div>

			</div><!-- ENDS col -->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->



<script type="text/javascript">

	$('.guage-container').hide();

	var explode = function(){
		$('.guage-container').show(900);
		//$('.guage-container').toggle("guage", { direction: "left" }, 1000);
	};
	setTimeout(explode, 300);

</script>


<script type="text/javascript">
	
// Submit form when onChange radion button #flash_opt
(function(){
	
	//$("#submit_But").hide(); // Hide submit but

	$("#topic").on('change', function () {
		this.form.submit();
	});

	$("#month").on('change', function () {
	 	this.form.submit();
	});

	$("#order").on('change', function () {
	 	this.form.submit();
	});

})();


</script>