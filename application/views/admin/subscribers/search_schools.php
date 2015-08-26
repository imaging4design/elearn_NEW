<h1 class="gridHeader strong">Search Schools</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('subscribers_con/select_access_codes', 'Review Codes', array('class' => 'butSmall butRight'));
		echo anchor('subscribers_con/access_code_form', 'Create Codes', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_admin_form', 'School Admin', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_form', 'Edit School List', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_student_details', 'Search Students', array('class' => 'butSmall butBack'));
	?>

	<h1 class="greyArrow textOrange"><strong>Search Schools</strong></h1>
  <p>Select a school from the drop down menu</p>
  
  
  <?php echo form_open('subscribers_con/get_school_details'); ?>
  
  <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
  
  <fieldset>
  <legend>SEARCH FOR SCHOOL</legend>
    <label for="studentID"><strong>Search Current Member Schools:</strong></label>
    <?php echo mem_schools_dropdown($value='', $selected='', $label='Select School'); ?>
    
    <input type="submit" id="submit" value="View Details" class="butSmall" />
  </fieldset>
  
  <?php 
	if( isset(  $this->error_school ))
	{ 
		echo $this->error_school; 
	}
	
	echo form_close(); 
?>

  
<div class="containerArea">

  
<?php
// Display the key contact persons details that the school eLearn account was set up under
if( isset( $school ))
{
	
	echo '<h3 class="textBottom"><strong>' . $school->school . '</strong></h3>';
	
	echo '<table width="880" border="0" cellspacing="0" cellpadding="0">';
		echo '<tr>';
			echo '<td>&nbsp;</td>';
			echo '<td><strong>Teacher Name</strong></td>';
			echo '<td><strong>Email</strong></td>';
			echo '<td><strong>Admin User</strong></td>';
			echo '<td><strong>Student User</strong></td>';
			echo '<td><strong>Date Joined</strong></td>';
			echo '<td><strong>Blocked</strong></td>';
		echo '</tr>';
					
		$blocked = ($school->block_user == 'false') ? 'No' : 'Yes';
	
		echo '<tr>';
			echo '<td>' . anchor('subscribers_con/edit_school/' . $school->schoolAdminID, 'EDIT') . '</td>';
			echo '<td>' . ucwords( $school->name_first ) . ' ' . strtoupper( $school->name_last ) . '</td>';
			echo '<td>' . safe_mailto($school->email, $school->email) . '</td>';
			echo '<td>' . $school->admin_user . '</td>';
			echo '<td>' . $school->student_user . '</td>';
			echo '<td>' . $school->created_at . '</td>';
			echo '<td>' . $blocked . '</td>';
		echo '</tr>';
	echo '</table>';
	
}

?>


<?php
// Display ALL students form the selected school (First name, Last name and email address)
if( isset( $schoolStudents ))
{
	
	echo '<h3 class="textBottom"><strong>List of Students - ('.count( $schoolStudents ).') Total</strong></h3>';

	echo '<table width="880" border="0" cellspacing="0" cellpadding="0">';

		echo '<tr>';
			echo '<td width="20"><strong>Edit</strong></td>';
			echo '<td width="200"><strong>Student Name</strong></td>';
			echo '<td><strong>Email Address</strong></td>';
		echo '<tr>';

		foreach ($schoolStudents as $row) {

			$blocked = ( $row->blockUser === 'true' ) ? '<span class="textOrange"> (BLOCKED)</span>' : '';

			echo '<tr>';
			echo '<td width="20">' . anchor('subscribers_con/edit_student/' . $row->studentID, 'EDIT') . '</td>';
			echo '<td width="200">' . strtoupper( $row->last_name ) . ', ' . ucwords( strtolower($row->first_name) ) . '</td>';
			echo '<td>' . $row->email . ' ' . $blocked . '</td>';

			echo '</tr>';

		}

	echo '</table>';
	
}

?>

</div>


</div>

<!--JAVASCRIPT - USED TO ALTERNATE THE COLOUR OF TABLE ROWS ABOVE-->
<script>
	$('tr:even').css('background', '#FAFAFA');
</script>