<h1 class="gridHeader">Screen reports for class: <span class="non_bold"><?php echo get_class_name( $this->session->userdata('classID') ); ?></span></h1>

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

	<legend>SELECT YOUR CLASS</legend>

	<div style="width:50%; float:left;">

		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
		<input type="hidden" name="current_URL" id="current_URL" value="<?php echo $this->uri->segment(2); ?>" />

		<?php
		// Set $class to current session -> classID
		$current_class = get_class_name( $this->session->userdata('classID'));
		// Display class list dropdown menu (with current selected class)
		echo classDropdown($this->session->userdata('classID'), $this->session->userdata('classID'), $current_class, $this->session->userdata('school') ); 
		?>

	</div>

	<div style="width:50%; float:right;">

		<h3 class="bold"><?php echo get_class_name( $this->session->userdata('classID') ); ?></h3>
		<h4>
			<?php 
				if( $this->session->userdata('classID') )
				{
					echo anchor('teachers/class_message_form', 'Set a class message'); 
				}
			?>
		</h4>

	</div>



	

	</fieldset>

<?php echo form_close(); ?>



<?php
/*
|-----------------------------------------------------------------------------------------------------------------
| Hide everything else on page until they select a class (therefore creating a session 'classID' )
|-----------------------------------------------------------------------------------------------------------------
*/
$hide_me = ( ! $this->session->userdata('classID') ) ? 'display:none;' : '';

?>


<div class="grid_6 alpha gridPadding textPadding" style="<?php echo $hide_me; ?>">

	<?php
	/************************************************************************************************************/
	// This form will retrieve ALL results for a single topic/month for an entire class group
	/************************************************************************************************************/
	echo form_open('teachers/view_month', array('class' => 'bg_computer')); // THIS SHOWS RESULTS ON PAGE!!

	?>

		<fieldset>

		<legend>TOPICS BY CLASS / MONTH</legend>

			<label>View your class results for each topic and month</label>
			<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

			<?php 
			echo dropDownTopics('', '', 'Select Topic'); // See admin_helper
			?>

			<label>Select Month</label>

			<?php
			$month = date('M'); // Get current Month - for 'value'
			$month_full = date('F'); // Get current Month - for 'label'

			echo monthDropdown($value=$month, $selected=$month, $label=$month_full);
			?>
			
			<label></label>
			<input type="submit" name="submit" id="submit" value="View Results" />

		</fieldset>


	<?php 
	if( isset($error))
	{
		echo $error;
	}
	echo form_close(); ?>

</div>





<div class="grid_6 omega gridPadding textPadding" style="<?php echo $hide_me; ?>">

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

	<legend>VIEW INDIVIDUAL STUDENTS</legend>

		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

		<label>View individual students results for each month</label>
		<input type="submit" name="submit" id="submit" value="View Students" />

	</fieldset>


	<?php
	if( isset($error2))
	{
		echo $error2;
	}
		
	echo form_close();

	?>

	
	<!-- Display Teachers access button to the Leaderboard -->
	<span class="genericBut genOrange"><?php echo anchor('results/leaders_school', 'The Leader Board'); ?></span>


</div>


<div style="clear:both;"></div>








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



<script type="text/javascript">
	
	// Submit form when onChange 'drop down'
	(function(){
		
		$("#classID").on('change', function () {
			this.form.submit();
		});
		

	})();


</script>