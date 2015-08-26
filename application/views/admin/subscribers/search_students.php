<h1 class="gridHeader strong">Search Students</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('subscribers_con/select_access_codes', 'Review Codes', array('class' => 'butSmall butRight'));
		echo anchor('subscribers_con/access_code_form', 'Create Codes', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_admin_form', 'School Admin', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_form', 'Edit School List', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_school_details', 'Search Schools', array('class' => 'butSmall butBack'));
	?>
  
  
	<h1 class="greyArrow textOrange"><strong>Search Students</strong></h1>
  <p>Enter the students last name</p>
  
  
  <?php echo form_open('subscribers_con/get_student_details'); ?>
  
  <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
  
  <fieldset>
  <legend>SEARCH FOR STUDENT</legend>
    <input type="text" name="studentID" id="studentID" size="60" />
    <!--DON'T REMOVE id="athlete" (required for auto-populate!)-->
  
  <input type="submit" id="submit" value="View Details" class="butSmall" />
  </fieldset>
  
  <?php 
	if( isset(  $this->error_student ))
	{ 
		echo $this->error_student; 
	}
	
	echo form_close(); 
	?>
  
  
  <div class="containerArea">
  
<?php

$blocked = FALSE;

if( isset( $student ))
{
	
	$pay_type = ($student->pay_method == 1) ? 'PayPal' : 'Code';

	echo '<h3 class="textBottom" id="name"><strong>' . ucwords( $student->first_name ) . ' ' . strtoupper( $student->last_name ) . '</strong></h3>';
	
	echo '<table width="880px" border="0" cellspacing="0" cellpadding="0">';
		echo '<tr>';
			echo '<td><strong>&nbsp;</strong></td>';
			echo '<td><strong>Email (Username)</strong></td>';
			echo '<td><strong>Date Joined</strong></td>';
			echo '<td><strong>Pay Type</strong></td>';
			echo '<td><strong>School</strong></td>';
			echo '<td><strong>Course</strong></td>';
			echo '<td><strong>Blocked</strong></td>';
		echo '</tr>';
		
		$blocked = ($student->blockUser == 'false') ? 'No' : 'Yes';
		
		echo '<tr>';
			echo '<td>' . anchor('subscribers_con/edit_student/' . $student->studentID, 'EDIT') . '</td>';
			echo '<td>' . safe_mailto($student->email, $student->email) . '</td>';
			echo '<td>' . $student->created_at . '</td>';
			echo '<td>' . $pay_type . '</td>';
			echo '<td>' . $student->school . '</td>';
			echo '<td>' . $student->course . '</td>';
			echo '<td>' . $blocked . '</td>';
		echo '</tr>';
	echo '</table>';
}


?>

</div>
	
	
</div>

<script>
(function(){
					
	//Hides the table when starting new search
	$('#studentID').one("focus", function() {
		$('table').hide();
		$('#name').hide();
	});

})();
</script>

								
<!--JQUERY FOR AUTO-COMPLETE STUDENTS FUNCTION-->
<script type="text/javascript">
$(document).ready(function() {
													 
	$(function() {
						 
		$("#studentID").autocomplete({
			source: function(request, response) {
				$.ajax({ url: "<?php echo site_url('admin/subscribers_con/get_auto_students'); ?>",
				data: { students: $("#studentID").val()},
				dataType: "json",
				type: "POST",
				success: function(data){
					response(data);
				}
			});
				
		},
		minLength: 2
		});
		
	});
	
});
</script>


<!--JAVASCRIPT - USED TO ALTERNATE THE COLOUR OF TABLE ROWS ABOVE-->
<script>
	$('tr:even').css('background', '#FAFAFA');
</script>