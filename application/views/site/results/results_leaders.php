<div class="band-topic-sections">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-full">
				
				<h2>The Leader Board</h2>
				<div class="multiseparator vc_custom"></div>


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


					<?php //if( isset($topic)) { ?>

						<!--DISPLAY INSTRUCTIONS-->				
						
						

						<?php
							// Only display link to 'Options' page if user is a paid member
							$link = ( $this->session->userdata( 'member_type' ) == 'paid_member' ) ? anchor('section/edit_options', 'MY OPTIONS', array('class'=>'btn btn-lg btn-red')) : 'MY OPTIONS';
						?>
						<p><strong>If you wish to appear on the leader board you must 'opt in' under My Options ...  </strong></p>
						<?php echo $link; ?>

					<?php //} ?>


			</div><!-- ENDS col -->
		</div><!-- ENDS row -->
	</div><!-- ENDS container -->
</div><!-- ENDS band-white -->




<div class="band-white">
	<div class="container">

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
					echo '<h3>' . $school_name->school . '</h3>';
					echo '<h2>' . $topic->topic . '</h2>';
					echo '<div class="multiseparator vc_custom"></div>';
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

						echo '<ul class="leaders-list">';

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
								'style' => 'float:left; margin:2px 5px 0 0;'
							);


							// Allocate medals to top 3 positions
							$medals = array('1', '2', '3');

							// Convert raw score to a % percentage
							$percent = ($row->$month[$i] / 50) * 100;

							// Loop through and echo out results (show medal icons for top 3)
							if( in_array($count, $medals ))
							{
								echo '<li>' . img($medal) . '<span> ' . ucwords($row->first_name) . ' ' . strtoupper($row->last_name) . '</span> - (' . $percent . '%)</li>';
							}
							else
							{
								echo '<li>' . $count . '. <span> ' . ucwords($row->first_name) . ' ' . strtoupper($row->last_name) . '</span> - (' . $percent . '%)</li>';
							}

							
							$count++;
							$num_rows++; //Counts the number of ($results_school) records

						endforeach;

						echo '</ul>';
					}

				endfor;


					// Display message - No Results Found if query empty
					if( ($this->input->post('topic') or $this->uri->segment(3) ) && $num_rows === 0)
					{
						// If $num_rows === 0, display 'No results found'
						echo '<h4>No results posted yet.</h4>';
						echo '<p>A minimum of 5 tests is required to appear on the Leaderboard. You must also select <strong>\'YES\'</strong> to <strong>\'Show my results on the Leaderboard\'</strong> in your My Options Tab.</p>';
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

				// Display Topic and National Flag icon
				if( isset($topic))
				{
					
					echo '<br class="visible-xs">';
					echo '<h3>National Leaderboard </h3>';
					echo '<h2>' . $topic->topic . '</h2>';
					echo '<div class="multiseparator vc_custom"></div>';
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

						echo '<ul class="leaders-list">';

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
								'style' => 'float:left; margin:2px 5px 0 -4px;'
							);


							// Allocate medals to top 3 positions
							$medals = array('1', '2', '3');

							// Convert raw score to a % percentage
							$percent = ($row->$month[$i] / 50) * 100;

							// Loop through and echo out results (show medal icons for top 3)
							if( in_array($count, $medals ))
							{
								echo '<li>' . img($medal) . '<span> &nbsp;' . ucwords($row->first_name) . ' ' . strtoupper($row->last_name) . '</span> - ' . $row->school . ' (' . $percent . '%)</li>';
							}
							else
							{
								echo '<li>' . $count . '. <span> &nbsp;' . ucwords($row->first_name) . ' ' . strtoupper($row->last_name) . '</span> - ' . $row->school . ' (' . $percent . '%)</li>';
							}

							$count++;
							$num_rows++; //Counts the number of ($results_school) records

						endforeach;

						echo '</ul>';

					}

				endfor;


					// Display message - No Results Found if query empty
					if( ($this->input->post('topic') or $this->uri->segment(3) ) && $num_rows === 0)
					{
						// If $num_rows === 0, display 'No results found'
						echo '<h4>No results posted yet.</h4>';
						echo '<p>A minimum of 5 tests is required to appear on the Leaderboard. You must also select <strong>\'YES\'</strong> to <strong>\'Show my results on the Leaderboard\'</strong> in your My Options Tab.</p>';
					}

				?>


			</div><!-- ENDS col -->

		</div><!-- ENDS row -->



		<div class="row">
			<div class="col-sm-12 col-full">

				<!--DISPLAY INSTRUCTIONS-->
				<h2>How it Works</h2>
				<ul>
					<li> Results are ordered by highest percentage (%) score for the month selected.</li>
					<li> Where two or more students have the same (%) score, the student who has completed the most tests in that topic (for the month) will rank higher.</li>
					<li> You must complete at least five tests in the selected topic to be listed on the leader board.</li>
				</ul>

			</div><!--ENDS col-->
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

	$("#month").on('change', function () {
	 	this.form.submit();
	});
	

})();


</script>