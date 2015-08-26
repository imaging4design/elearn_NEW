<h1 class="gridHeader strong">Add Schools</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('subscribers_con/select_access_codes', 'Review Codes', array('class' => 'butSmall butRight'));
		echo anchor('subscribers_con/access_code_form', 'Create Codes', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_admin_form', 'School Admin', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_school_details', 'Search Schools', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_student_details', 'Search Students', array('class' => 'butSmall butBack'));
	?>
	
	<h1 class="greyArrow textOrange"><strong>Edit School List</strong></h1>
  <p>Complete the fields to add / edit a school</p>
  
  <?php echo form_open('subscribers_con/add_school'); ?>

	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
	
	<fieldset>
	<legend>ENTER NEW SCHOOL NAME</legend>
	  <input type="text" name="school" id="school" style="width:40%;" value="<?php echo set_value('school'); ?>" />
	  
	  <input type="submit" id="submit" value="Add School" class="butSmall" />
	</fieldset>
	
  <?php 
	if( isset($message))
	{
		echo $message;
	}
	
	echo form_close(); 
	?>
  
  
  <?php echo form_open('subscribers_con/update_school'); ?>
  
	<div id="container">

	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

	<fieldset>
	<legend>EDIT CURRENT SCHOOL NAME</legend>
		<!--Displays a list of ALL Schools // admin_helper-->
		<?php echo schools_dropdown('', '', 'Select School'); // See topic_helper ?>

		<!--Find the Sub Topic to dynamically populate the 'subTopic' field - from find_subTopic( $data ) // admin_helper-->
		<label for"newSchoolName"><strong>Change School Name to:</strong></label>
		<input name="newSchoolName" type="text" id="newSchoolName" size="40" value="<?php echo set_value('newSchoolName'); ?>" />

		<input type="submit" id="edit_submit" value="Update School" class="butSmall" />
	</fieldset>

	<div class="containerArea" style="margin-top:10px;"></div>

	</div>
  
  <?php 
		echo form_close(); 
	?>
  
</div>



<!--JQUERY AJAX UPDATE SCRIPT-->
<script type="text/javascript">

$(function() {

$('#edit_submit').click(function() {
$('#container').append('<img src="<?php echo base_url() . '/images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token = $('#token').val();
	var schoolID = $('#schoolID').val();
	var newSchoolName = $('#newSchoolName').val();
	
	
	$.ajax({
		url: '<?php echo base_url() . 'subscribers_con/update_school'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&schoolID=' + schoolID
		+ '&newSchoolName=' + newSchoolName,
		
		success:    function(result) {
				
								$('#response').remove();
								$('.containerArea').append('<span id="response">' + result + '</span>');
								$('#loading').fadeOut(500, function() {
									$(this).remove();
								});
								
						}
				});
		
		return false;
		
	});
	
	});
</script>