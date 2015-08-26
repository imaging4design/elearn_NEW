<h1 class="gridHeader_purple">Where do I rank on the Results Leaderboard?</h1>


<div class="gridPaddingTop">


<!--DISPLAY FORM ONE-->
<?php echo form_open('results/leaders_school'); ?>

	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

	<fieldset>
	<legend class="purple">SHOW OVERALL RESULTS FOR</legend>

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
		
		//echo dropDownTopics($id, $id, $topic_name) . '&nbsp;'; // See admin_helper

		echo dropDownLeaderboardTopics($id, $id, $topic_name) . '&nbsp;'; // See admin_helper


		$month = date('M'); // Get current Month - for 'value'
		$month_full = date('F'); // Get current Month - for 'label'
		echo monthDropdown($value=$month, $selected=$month, $label=$month_full);

		?>

		<!--<input type="submit" name="sub_topic" value="View Results" />-->
	
	</fieldset>

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

</div>





<div class="grid_5 alpha textPadding">

<?php
// Initiate $num_rows, as this will count the number of ($results_school) records
$num_rows = 0;

//******************************************************************************************************************************************************************************//
// DISPLAY LEADERBOARD RESULTS FOR 'LOGGED IN' SCHOOL
//******************************************************************************************************************************************************************************//
if( isset($results_school))
{
	
	echo '<h5 class="bold textOrange">' . $topic->topic . '</h5>';
	echo '<h2 class="bold">' . $school_name->school . '</h2>';

	$count = 1;

	// Get $month from either form POST value (above) or current month (default)
	$month = ( $this->input->post('month') ) ? $this->input->post('month') : date('M');


	foreach($results_school as $row):

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

		$medal = array(
			'src' => $medal_colour,
			'alt' => 'eLearn Economics',
			'width' => '20',
			'height' => '20',
			'style' => 'float:left; margin:0 5px 0 0;'
		);

		$medals = array('1', '2', '3');

		$percent = ($row->$month / 50) * 100;

		if(in_array( $count, $medals ))
		{
			echo '<h4>' . img($medal) . '<span class="bold"> ' . $row->first_name . ' ' . strtoupper($row->last_name) . '</span> (' . $percent . '%)</h4>';
			echo '<div class="horzLine_small"></div>';
		}
		else
		{
			echo '<p>' . $count . '. <span class="bold"> ' . $row->first_name . ' ' . strtoupper($row->last_name) . '</span> (' . $percent . '%)</p>';
			echo '<div class="horzLine_small"></div>';
		}


	$count++;
	$num_rows++; //Counts the number of ($results_school) records

	endforeach;

}

	// Display message - No Results Found if query empty
	if( ($this->input->post('topic') or $this->uri->segment(3) ) && $num_rows === 0)
	{
		// If $num_rows === 0, display 'No results found'
		echo '<h4 class="bold textOrange">No (school) results for this topic/month!</h4>';
		echo '<p>Please try another Topic and/or Month ...</p>';
	}

?>

<br />
</div>



<div class="grid_7 alpha textPadding">





<?php
// Initiate $num_rows, as this will count the number of ($results_school) records
$num_rows2 = 0;

//******************************************************************************************************************************************************************************//
// DISPLAY LEADERBOARD RESULTS FOR 'ALL' NATIONAL SCHOOLS
//******************************************************************************************************************************************************************************//

if( isset($results_national) )
{
	$flag = array(
		'src' => $this->css_path_url . 'main/misc/medal_nz.png',
		'alt' => 'eLearn Economics',
		'width' => '45',
		'height' => '30',
		'style' => 'float:left; margin:0 5px 0 0;'
	);

	echo '<h5 class="bold textOrange">' . $topic->topic . '</h5>';
	echo '<h2 class="bold">National Leaderboard' . img($flag) . '</h2>';

	$count = 1;

	// Get $month from either form POST value (above) or current month (default)
	$month = ( $this->input->post('month') ) ? $this->input->post('month') : date('M');


	foreach($results_national as $row):

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

		$medal = array(
			'src' => $medal_colour,
			'alt' => 'eLearn Economics',
			'width' => '20',
			'height' => '20',
			'style' => 'float:left; margin:0 5px 0 0;'
		);

		$medals = array('1', '2', '3');

		$percent = ($row->$month / 50) * 100;

		if( in_array($count, $medals ))
		{
			echo '<h4>' . img($medal) . '<span class="bold"> ' . $row->first_name . ' ' . strtoupper($row->last_name) . '</span> - ' . $row->school . ' (' . $percent . '%)</h4>';
			echo '<div class="horzLine_small"></div>';
		}
		else
		{
			echo '<p>' . $count . '. <span class="bold"> ' . $row->first_name . ' ' . strtoupper($row->last_name) . '</span> - ' . $row->school . ' (' . $percent . '%)</p>';
			echo '<div class="horzLine_small"></div>';
		}

		
	$count++;
	$num_rows2++; //Counts the number of ($results_school) records

	endforeach;
}

	// Display message - No Results Found if query empty
	if( ($this->input->post('topic') or $this->uri->segment(3) ) && $num_rows2 === 0)
	{
		// If $num_rows === 0, display 'No results found'
		echo '<h4 class="bold textOrange">No (national) results for this topic/month!</h4>';
		echo '<p>Please try another Topic and/or Month ...</p>';
	}

?>

<br />
</div>


<div class=" gridPadding textPadding">

	<!--DISPLAY INSTRUCTIONS-->
	<h4><span class="attention bold">RESULTS LEADERBOARD:<br />For your results to appear on the leaderboard, you need to turn this feature 'On' in the options page <?php echo anchor('section/edit_options', 'HERE'); ?></span></h4>
	<p>
		&bull; Results are ordered by highest percentage (%) score for the month selected.<br />
		&bull; Where two or more students have the same (%) score, the student who has completed the most tests in that topic (for the month) will rank higher.<br />
		&bull; You must complete at least five tests in the selected topic to be listed on the leaderboard.
	</p>

</div>


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