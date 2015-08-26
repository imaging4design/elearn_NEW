<h1 class="gridHeader_purple">Print reports for class: <span class="non_bold"><?php echo get_class_name( $this->session->userdata('classID') ); ?></span></h1>

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

	<legend class="purple">SELECT YOUR CLASS</legend>

	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
	<input type="hidden" name="current_URL" id="current_URL" value="<?php echo $this->uri->segment(2); ?>" />

	<?php
	// Set $class to current session -> classID
	$current_class = get_class_name( $this->session->userdata('classID'));
	// Display class list dropdown menu (with current selected class)
	echo classDropdown($this->session->userdata('classID'), $this->session->userdata('classID'), $current_class, $this->session->userdata('school') ); 
	?>

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
	echo form_open('teachers_pdf/results_PDF', array('class' => 'bg_printer')); // THIS PRINTS A PDF!!
	?>

		<fieldset>

			<legend class="purple">CLASS REPORT FULL YEAR</legend>

			<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

			<label>Shows ALL students monthly progressions for topics <br />studied in <?php echo date('Y') ?></label>
			<input type="submit" name="submit" id="submit" value="Download Report" />

		</fieldset>


	<?php 
	if( isset($error))
	{
		echo $error;
	}
	echo form_close();
	?>

</div>


<div class="grid_6 omega gridPadding textPadding" style="<?php echo $hide_me; ?>">

	<?php
	/************************************************************************************************************/
	// This form will first display a full list of students in a single class group
	// Then each student can be clicked to view their entire results for the current month
	/************************************************************************************************************/
	echo form_open('teachers/show_class_students_print', array('class' => 'bg_printer'));

	
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

		<legend class="purple">STUDENT REPORTS FULL YEAR</legend>

		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

		<label>Print individual students results for each month</label>
		<input type="submit" name="submit" id="submit" value="View Students" />

	</fieldset>


	<?php
	if( isset($error2))
	{
		echo $error2;
	}
		
	echo form_close(); 

	?>

</div>


<div style="clear:both;"></div>






<script type="text/javascript">
	
// Submit form when onChange radion button #flash_opt
(function(){
	
	// Submit form when onChange 'drop down'
	(function(){
		$("#classID").on('change', function () {
			this.form.submit();
		});
	})();


	$("#order").on('change', function () {
		this.form.submit();
	});

	$(".month").on('change', function () {
		this.form.submit();
	});

})();


</script>