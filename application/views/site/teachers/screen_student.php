<h1 class="gridHeader">Teachers Admin - Screen Reports (screen_student.php)</h1>

<div class="grid_6 alpha gridPadding textPadding">

	<?php
	if( ! $this->uri->segment(3))
	{
		echo '<p class="bold">* Students with their names greyed out indicate they have NOT completed any test topics in '.date('Y').'</p>';
	}

	// Use this form for reordering the results
	// i.e. By Topic / Results / Num Tests
	// This is jQuery on(change) function - see bottom of page
	if( $this->uri->segment(3))
	{

		echo form_open('teachers/view_student/' . $this->uri->segment(3));

		echo '<fieldset>';

		echo '<legend>BREAKDOWN BY MONTH</legend>';

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

			echo '<label>View ALL test results completed by a student per month</label>';
			echo monthDropdown($value=$month, $selected=$month, $label=$month_full); 

			echo '&nbsp;';

			echo orderDropdown($value='', $selected='', $label='Order Results by');

			echo '<label></label>';
			echo anchor('teachers/refresh_class_students', 'See All Students', array('style' => 'float:right;'));

			//echo '<input type="submit" name="submit" id="submit" value="View Students" />';

		echo '</fieldset>';


		if( isset($error))
		{
			echo $error;
		}

		echo form_close();
	}

	?>

</div>



<div class="grid_6 omega gridPadding textPadding">

	<?php
	// Use this form for reordering the results
	// i.e. By Topic / Results / Num Tests
	// This is jQuery on(change) function - see bottom of page
	if( $this->uri->segment(3))
	{

		echo form_open('teachers/results_by_topic/' . $this->uri->segment(3));

		echo '<fieldset>';

		echo '<legend>12 MONTH BREAKDOWN</legend>';

			echo '<input type="hidden" name="token" id="token" value="'.$token.'" />';

			echo '<label>View individual student progressions per topic over 12 months</label>';
			//echo dropDownTopics('', '', 'List of Topics'); // See admin_helper
			echo topicsWithResultsStudents('', '', 'Select Topic'); // See section_helper

			echo '<label></label>';
			echo anchor('teachers/refresh_class_students', 'See All Students', array('style' => 'float:right;'));

			//echo '<input type="submit" name="submit" id="submit" value="View Students" />';

		echo '</fieldset>';

		if( isset($error2))
		{
			echo $error2;
		}

		echo form_close();
	}

	?>

</div>


<div style="clear:both;"></div>








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
	echo '<div class="textPadding">';

	$results = count($students);
	$per_column = ceil($results/3);
	
	$i = 0;
	echo '<table cellspacing="0" cellpadding="0" border="0" width="100%" >';
	echo '<tr valign="top">';
	echo '<td width=33%>';
	
	/*************************************************************************/
	// Loop through each topic alphbetically
	/*************************************************************************/
	foreach($students as $row):
	
		 if($i == $per_column)
		 {
			echo '</td><td width=33%>';
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
					$alpha_header = ( $set_letter != $letter ) ? $letter : ''; 
					// Display alpha letter (i.e., A, B, C ...)
					echo '<h4 class="bold textOrange" style="margin:0;">' . $alpha_header . '</h4>';
					// Display Topic Name
					//echo '<h5>' . anchor( $segments, '<span class="bold">' . strtoupper($row->last_name) . '</span>, ' . $row->first_name, array('class' => 'non strong') ) . '</h5>';

					//if( $row->$n_month)
					if($row->studentID)
					{
						echo '<h5 style="margin-bottom:0;">' . anchor( $segments, '<span class="bold">' . strtoupper($row->last_name) . '</span>, ' . $row->first_name, array('class' => 'non strong') ) . '</h5>';
						echo '<h6>'.$row->email.'</h6>';
					}
					else
					{
						echo '<h5 style="margin-bottom:0;"><span class="bold textLightGrey">' . strtoupper($row->last_name) . ', ' . $row->first_name . '</span></h5>';
						echo '<h6 class="bold textLightGrey">'.$row->email.'</h6>';
					}


					echo '<div class="underLine"></div>';
					// Save alpha letter as var to test against looped through version above
					$set_letter = $letter; 
				}
				
			endforeach;
			
			/*************************************************************************/
		 
		 $i++;
		 
	endforeach;
	
	echo '</td>';
	echo '</tr>';
	echo '</table>';

	echo '<br /></div>';

}

if( ! isset($students) && ! $this->uri->segment(3))
{
	echo '<h4 class="bold textOrange marginLeft">No students found in this class.</h4>';
}	
?>




<?php
/*************************************************************************************************************************************************************************/
// THIS SECTION SHOWS THE RESULTS FOR INDIVIDUAL STUDENTS IN A CLASS -> FOR 'ALL WORK / TOPICS' BY MONTH
/*************************************************************************************************************************************************************************/
if( isset($single_student))
{

	echo '<div class="gridPadding textPadding">';

	$score_guage = array(
			'src' => $this->css_path_url . 'main/misc/score_guage.png',
			'alt' => 'eLearn Economics',
			'width' => '400',
			'height' => '25',
			'style' => 'float:right; margin:5px 30px 0 0;'
		);

	echo img($score_guage);
	

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

		echo '<span class="bold studentLabel">' . ucwords($student_details->first_name) . ' ' . strtoupper($student_details->last_name) . '</span>';
		echo '<h4 class="bold">' . $order . ' - ' . $month . ' / ' . date('Y') . '</h4>';
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

	echo '<ul id="chart">';
	
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
					echo 	'<li>' . strtoupper($row->topic) . ' | <span class="bold textOrange">(Nil %)</span> | Tests: <span class="bold">' . $row->$n_month . ' </span>(5 Test required for average) | Last Test: <span class="bold">(' . $row->test_date . ')</span></li>';
					echo 	'<li title="'.$average_score_percent.'" class="codeGrey">
							<span class="bar"></span>
							<span class="percent"></span>
						</li>';
				}
				else
				{
					echo 	'<li>' . strtoupper($row->topic) . ' | <span class="bold textOrange">(' . $average_score_percent . '%)</span> | Tests: <span class="bold">' . $row->$n_month . '</span> | Last Test: <span class="bold">(' . $row->test_date . ')</span></li>';
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
	
	// Show graphic of score guage
	$score_guage = array(
		'src' => $this->css_path_url . 'main/misc/score_guage.png',
		'alt' => 'eLearn Economics',
		'width' => '400',
		'height' => '25',
		'style' => 'float:right; margin:5px 30px 0 0;'
	);

	echo img($score_guage);

	echo '<span class="bold studentLabel">' . ucwords($student_details->first_name) . ' ' . strtoupper($student_details->last_name) . '</span>';
	echo '<h4 class="bold">' . strtoupper($topic->topic) . ' - Last Test: <span class="bold textOrange">' . $topic_results->test_date . '</span></h4>';


	// Initiate these vars to prevent errors
	$month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
	$n_month = array('n_Jan', 'n_Feb', 'n_Mar', 'n_Apr', 'n_May', 'n_Jun', 'n_Jul', 'n_Aug', 'n_Sep', 'n_Oct', 'n_Nov', 'n_Dec');
	$total = 0;
	$min_tests = FALSE;


	

	echo '<ul id="chart">';

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

				echo 	'<li>' . $month[$i] . ' ' . date('Y') . ' | Tests: <span class="bold">(' . $topic_results->$n_month[$i] . ')</span>'.$min_tests.'</li>';
				echo 	'<li title="'.$average_score_percent.'" class="codeGrey">
						<span class="bar"></span>
						<span class="percent"></span>
					</li>';
			}
			else
			{
				//echo '<p>' . $month[$i] . ' ' . date('Y') . ' | <span class="bold textOrange">' . $average_score_percent . '%</span> | Tests: <span class="bold">' . $topic_results->$n_month[$i] . '</span></p>';
				//echo '<div class="guage guage_grey">';
				//echo '<div class=" ' . $div_colour . ' " style="width:' . $average_score_percent . '%;"></div>';
				//echo '</div>';

				echo 	'<li>' . $month[$i] . ' ' . date('Y') . ' | <span class="bold textOrange">' . $average_score_percent . '%</span> | Tests: <span class="bold">' . $topic_results->$n_month[$i] . '</span></li>';
				echo 	'<li title="'.$average_score_percent.'" class="'.$div_colour.'">
						<span class="bar"></span>
						<span class="percent"></span>
					</li>';
			}


			$total = 0; // Reset $total back to '0'

		endfor;

	echo '</ul>';

}

?>


</div>






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