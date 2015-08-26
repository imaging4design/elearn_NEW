<h1 class="gridHeader_purple">Teachers Admin - PRINT Reports</h1>

<div class="gridPadding textPadding">

	<h3 class="bold">Screen/Print reports for individual students</h3>
	<p class="bold">* Students with their names greyed out indicate they have NOT completed any test topics in <?php echo date('Y'); ?></p>
</div>


<div class="grid_6 omega textPadding">

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
			
			$segments = array( 'teachers_stud_pdf/results_PDF/' . $row->studentID);

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







<script type="text/javascript">
	
// Submit form when onChange radion button #flash_opt
(function(){
	
	//$("#submit_But").hide(); // Hide submit but

	$("#topic").on('change', function () {
		this.form.submit();
	});
	

})();


</script>