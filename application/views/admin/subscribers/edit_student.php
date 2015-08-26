<h1 class="gridHeader strong">Edit Student</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('subscribers_con/select_access_codes', 'Review Codes', array('class' => 'butSmall butRight'));
		echo anchor('subscribers_con/access_code_form', 'Create Codes', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_admin_form', 'School Admin', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_form', 'Edit School List', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_school_details', 'Search Schools', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_student_details', 'Search Students', array('class' => 'butSmall butBack'));
	?>
	
	<h1 class="greyArrow textOrange"><strong>Edit Student</strong></h1>
  <p>Complete the fields to edit student details</p>
  
  <?php echo form_open('subscribers_con/update_student'); ?>

    <div id="container">
    
    <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
    <input type="hidden" name="studentID" id="studentID" value="<?php echo $student->studentID; ?>" />
    
    <fieldset>
    <legend>EDIT STUDENT DETAILS</legend>
    
    <?php schools_dropdown($student->schoolID, $student->school, $student->school) ?>
    
      <label for="name"><strong>Student Name:</strong></label>
      <input type="text" name="first_name" id="first_name" style="width:40%;" value="<?php echo $student->first_name; ?>" />
      <input type="text" name="last_name" id="last_name" style="width:40%;" value="<?php echo $student->last_name; ?>" />
      
      <label for="name"><strong>Student Email:</strong></label>
      <input type="text" name="email" id="email" style="width:40%;" value="<?php echo $student->email; ?>" />
      
      <input type="checkbox" name="blockUser" id="blockUser" value="1" <?php if($student->blockUser == 'true') { echo 'checked = \"checked\"'; } ?> /> Block User<br />

      <label for="notes"><strong>Notes for Student:</strong></label>
      <textarea name="notes" id="notes" rows="3" cols="80"><?php echo $student->notes; ?></textarea>

    </fieldset>
    
    <div class="containerArea">
      <input type="submit" id="submit" value="Update Student" class="butSmall" />
    </div>
    
    </div>
    
  <?php echo form_close(); ?>

  
</div>



<!--JQUERY AJAX UPDATE SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#container').append('<img src="<?php echo base_url() . '/images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token = $('#token').val();
	var studentID = $('#studentID').val();
	var schoolID = $('#schoolID').val();
	var first_name = $('#first_name').val();
	var last_name = $('#last_name').val();
	var email = $('#email').val();
	var blockUser = document.getElementById('blockUser').checked;
	var notes = $('#notes').val();
	
	
	$.ajax({
		url: '<?php echo base_url() . 'subscribers_con/update_student'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&studentID=' + studentID
		+ '&schoolID=' + schoolID
		+ '&first_name=' + first_name
		+ '&last_name=' + last_name
		+ '&email=' + email
		+ '&blockUser=' + blockUser
		+ '&notes=' + notes,
		
		success: 	function(result) {
				
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