<div class="container">
	<div class="row">
		<div class="col-sm-12 col-full">
			
			<h2>The Leader Board</h2>
			<div class="multiseparator vc_custom"></div>


				<div class="row">
					<div class="col-sm-6">

						<!--DISPLAY FORM ONE-->
						<?php echo form_open('results/leaders_school'); ?>

							<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

							<h3>SHOW OVERALL RESULTS FOR</h3>

								<?php
								// Create conditional vars for dropDownTopics() function
								// These will auto populate the 'month' drop down menu
								if( isset($topic))
								{
									$id = $topic->topicID;
									$topic_name = $topic->topic;
								}
								else
								{
									$id = '';
									$topic_name = 'Select Topic';
								}
								
								echo dropDownLeaderboardTopics($id, $id, $topic_name) . '&nbsp;'; // See admin_helper

								?>

							
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

				</div><!-- ENDS row -->


		</div><!-- ENDS col -->
	</div><!-- ENDS row -->







	<div class="row">
		<div class="col-sm-6">

			<?php
			//******************************************************************************************************************************************************************************//
			// DISPLAY LEADERBOARD RESULTS FOR 'LOGGED IN' SCHOOL
			//******************************************************************************************************************************************************************************//

			// Initiate $num_rows, as this will count the number of ($results_school) records
			$num_rows = 0;


			// Display Topic and School Name
			if( isset( $topic ))
			{
				echo '<h3>' . $topic->topic . '</h3>';
				echo '<h2>' . $school_name->school . '</h2>';
			}


			// Create month arrays => NOTE reverse order, as we want to show results from oldest to newest
			$month = array('Dec', 'Nov', 'Oct', 'Sep', 'Aug', 'Jul', 'Jun', 'May', 'Apr', 'Mar', 'Feb', 'Jan');
			$n_month = array('n_Dec', 'n_Nov', 'n_Oct', 'n_Sep', 'n_Aug', 'n_Jul', 'n_Jun', 'n_May', 'n_Apr', 'n_Mar', 'n_Feb', 'n_Jan');


			for ($i = 0, $num = count($month); $i < $num; $i++):

				if( isset($results_school[$i]))
				{

					$count = 1; // Required for setting $medals

					// Display month
					echo '<h3>' . strtoupper($month[$i]) . '</h3>';

					foreach($results_school[$i] as $row):

						
						// Work out medals for top 3 positions
						if($count == 1)
						{
							$medal_colour = $this->css_path_url . 'main/misc/medal_gold.png';
						}
						elseif($count == 2)
						{
							$medal_colour = $this->css_path_url . 'main/misc/medal_silver.png';
						}
						else
						{
							$medal_colour = $this->css_path_url . 'main/misc/medal_bronze.png';
						}

						// Get medal img properties
						$medal = array(
							'src' => $medal_colour,
							'alt' => 'eLearn Economics',
							'width' => '20',
							'height' => '20',
							'style' => 'float:left; margin:0 5px 0 0;'
						);


						// Allocate medals to top 3 positions
						$medals = array('1', '2', '3');

						// Convert raw score to a % percentage
						$percent = ($row->$month[$i] / 50) * 100;

						// Loop through and echo out results (show medal icons for top 3)
						if( in_array($count, $medals ))
						{
							echo '<p>' . img($medal) . '<span> ' . ucwords($row->first_name) . ' ' . strtoupper($row->last_name) . '</span> - (' . $percent . '%)</p>';
						}
						else
						{
							echo '<p>' . $count . '. <span> ' . ucwords($row->first_name) . ' ' . strtoupper($row->last_name) . '</span> - (' . $percent . '%)</p>';
						}

						
						$count++;
						$num_rows++; //Counts the number of ($results_school) records

					endforeach;


				}

			endfor;


				// Display message - No Results Found if query empty
				if( ($this->input->post('topic') or $this->uri->segment(3) ) && $num_rows === 0)
				{
					// If $num_rows === 0, display 'No results found'
					echo '<h4 class="bold textOrange">No results posted yet.</h4>';
					echo '<h6>A minimum of 5 tests is required to appear on the Leaderboard. You must also select <strong>\'YES\'</strong> to <strong>\'Show my results on the Leaderboard\'</strong> in your My Options Tab.</h6>';
				}


			?>

		
		</div><!-- ENDS col -->

	

		<div class="col-sm-6">

			<?php
			//******************************************************************************************************************************************************************************//
			// DISPLAY LEADERBOARD RESULTS FOR ALL NATIONAL SCHOOLS
			//******************************************************************************************************************************************************************************//

			// Initiate $num_rows, as this will count the number of ($results_school) records
			$num_rows = 0;


			// National Flag icon properties
			$flag = array(
				'src' => $this->css_path_url . 'main/misc/medal_nz.png',
				'alt' => 'eLearn Economics',
				'width' => '45',
				'height' => '30',
				'style' => 'float:left; margin:0 5px 0 0;'
			);


			// Display Topic and National Flag icon
			if( isset($topic))
			{
				echo '<h3>' . $topic->topic . '</h3>';
				echo '<h2>National Leaderboard' . img($flag) . '</h2>';
			}


			// Create month arrays => NOTE reverse order, as we want to show results from oldest to newest
			$month = array('Dec', 'Nov', 'Oct', 'Sep', 'Aug', 'Jul', 'Jun', 'May', 'Apr', 'Mar', 'Feb', 'Jan');
			$n_month = array('n_Dec', 'n_Nov', 'n_Oct', 'n_Sep', 'n_Aug', 'n_Jul', 'n_Jun', 'n_May', 'n_Apr', 'n_Mar', 'n_Feb', 'n_Jan');

			for ($i = 0, $num = count($month); $i < $num; $i++):

				if( isset($results_national[$i]))
				{
					
					$count = 1; // Required for setting $medals

					// Display month
					echo '<h3>' . strtoupper($month[$i]) . '</h3>';

					foreach($results_national[$i] as $row):


						// Work out medals for top 3 positions
						if($count == 1)
						{
							$medal_colour = $this->css_path_url . 'main/misc/medal_gold.png';
						}
						elseif($count == 2)
						{
							$medal_colour = $this->css_path_url . 'main/misc/medal_silver.png';
						}
						else
						{
							$medal_colour = $this->css_path_url . 'main/misc/medal_bronze.png';
						}

						// Get medal img properties
						$medal = array(
							'src' => $medal_colour,
							'alt' => 'eLearn Economics',
							'width' => '20',
							'height' => '20',
							'style' => 'float:left; margin:0 5px 0 0;'
						);


						// Allocate medals to top 3 positions
						$medals = array('1', '2', '3');

						// Convert raw score to a % percentage
						$percent = ($row->$month[$i] / 50) * 100;

						// Loop through and echo out results (show medal icons for top 3)
						if( in_array($count, $medals ))
						{
							echo '<p>' . img($medal) . '<span> ' . ucwords($row->first_name) . ' ' . strtoupper($row->last_name) . '</span> - ' . $row->school . ' (' . $percent . '%)</p>';
						}
						else
						{
							echo '<p>' . $count . '. <span> ' . ucwords($row->first_name) . ' ' . strtoupper($row->last_name) . '</span> - ' . $row->school . ' (' . $percent . '%)</p>';
						}

						$count++;
						$num_rows++; //Counts the number of ($results_school) records

					endforeach;


				}

			endfor;


				// Display message - No Results Found if query empty
				if( ($this->input->post('topic') or $this->uri->segment(3) ) && $num_rows === 0)
				{
					// If $num_rows === 0, display 'No results found'
					echo '<h4>No results posted yet.</h4>';
					echo '<h6>A minimum of 5 tests is required to appear on the Leaderboard. You must also select <strong>\'YES\'</strong> to <strong>\'Show my results on the Leaderboard\'</strong> in your My Options Tab.</h6>';
				}

			?>


		</div><!-- ENDS col -->

	</div><!-- ENDS row -->



	<div class="row">
		<div class="col-sm-12">

			<!--DISPLAY INSTRUCTIONS-->
			<h3><strong>RESULTS LEADER BOARD:</strong> Information:</h3>
			<ul>
				<li> Results are ordered by highest percentage (%) score for the month selected.</li>
				<li> Where two or more students have the same (%) score, the student who has completed the most tests in that topic (for the month) will rank higher.</li>
				<li> You must complete at least five tests in the selected topic to be listed on the leader board.</li>
			</ul>

			<?php
				// Only display link to 'Options' page if user is a paid member
				$link = ( $this->session->userdata( 'member_type' ) == 'paid_member' ) ? anchor('section/edit_options', 'MY OPTIONS') : 'MY OPTIONS';
			?>
			<p><strong>If you wish to appear on the leader board you must opt in on the start page under <?php echo $link; ?></strong></p>

		</div><!--ENDS col-->
	</div><!--ENDS row-->


</div><!--ENDS container-->




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
	

})();


</script>