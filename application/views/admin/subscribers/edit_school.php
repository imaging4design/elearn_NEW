<h1 class="gridHeader strong">Edit Schools</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('subscribers_con/select_access_codes', 'Review Codes', array('class' => 'butSmall butRight'));
		echo anchor('subscribers_con/access_code_form', 'Create Codes', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_admin_form', 'School Admin', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_form', 'Edit School List', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_school_details', 'Search Schools', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_student_details', 'Search Students', array('class' => 'butSmall butBack'));
	?>
	
	<h1 class="greyArrow textOrange"><strong>Edit Admin</strong></h1>
  <p>Complete the fields to edit school admin details</p>
  
  <?php echo form_open('subscribers_con/update_school_admin'); ?>

    <div id="container">
    
    <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
    <input type="hidden" name="schoolUserID" id="schoolUserID" value="<?php echo $school->id; ?>" />
    
    <fieldset>
    <legend>EDIT SCHOOL MASTER ADMIN</legend>
    
    <div style="width:50%; float:left;">
      <label for="name"><strong>First Name:</strong></label>
      <input type="text" name="name_first" id="name_first" size="38" value="<?php echo $school->name_first; ?>" />
      
      <label for="name"><strong>Last Name:</strong></label>
      <input type="text" name="name_last" id="name_last" size="38" value="<?php echo $school->name_last; ?>" />
    </div>
    
    <div style="width:50%; float:left;">  
      <label for="name"><strong>School Email:</strong></label>
      <input type="text" name="email" id="email" size="38" value="<?php echo $school->email; ?>" />

      <label for"phone"><strong>Contact Phone:</strong></label>
      <input type="text" name="phone" id="phone" size="20" value="<?php echo $school->phone; ?>" />
    </div>
      
    </fieldset>
    
    <fieldset>
    <legend>EDIT TEACHER ADMIN LOGIN</legend> 
      
      <div style="width:50%; float:left;">
        <label for"admin_user"><strong>Username </strong>(Teacher):</label>
        <input type="text" name="admin_user" id="admin_user" size="38" value="<?php echo $school->admin_user; ?>" />
      </div>
      
      <div style="width:50%; float:left;">
        <label for"admin_pass"><strong>Password </strong>(Teacher):</label>
        <input type="text" name="admin_pass" id="admin_pass" size="38" value="<?php echo set_value('student_pass'); ?>" />

        <input type="hidden" name="hid_admin_pass" id="hid_admin_pass" value="<?php echo $school->admin_pass; ?>" />
      </div>
    
    </fieldset>
    
    <fieldset>
    <legend>EDIT (GENERIC) STUDENT LOGIN</legend> 
      
      <div style="width:50%; float:left;">
        <label for"student_user"><strong>Username </strong>(Student):</label>
        <input type="text" name="student_user" id="student_user" size="38" value="<?php echo $school->student_user; ?>" />
      </div>
      
      <div style="width:50%; float:left;">
        <label for"student_pass"><strong>Password </strong>(Student):</label>
        <input type="text" name="student_pass" id="student_pass" size="38" value="<?php echo set_value('student_pass'); ?>" />

        <input type="hidden" name="hid_student_pass" id="hid_student_pass" value="<?php echo $school->student_pass; ?>" />
      </div>
    
    </fieldset>

    <fieldset>
	<legend>ADDITIONAL OPTIONS</legend>

	<div style="width:50%; float:left;">
    	<label for="name"><strong>User Status:</strong></label>
	 	<input type="checkbox" name="block_user" id="block_user" value="1" <?php if($school->block_user == 'true') { echo 'checked = \"checked\"'; } ?> /> Block User
	</div>

	<div style="width:50%; float:left;">
	    <label for="notification"><strong>Email Notification:</strong></label>
	    <input type="checkbox" name="notification" id="notification" value="1" <?php echo set_checkbox('notification', '1'); ?> /> Tick, to send email of updated details to school
	</div>

    </fieldset>
    
    
    
    <div class="containerArea">
      <input type="submit" id="submit" value="Update School Admin" class="butSmall" />
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
	var schoolUserID = $('#schoolUserID').val();
	var name_first = $('#name_first').val();
	var name_last = $('#name_last').val();
	var email = $('#email').val();
	var phone = $('#phone').val();
	var admin_user = $('#admin_user').val();
	var admin_pass = $('#admin_pass').val();
	var hid_admin_pass = $('#hid_admin_pass').val();
	var student_user = $('#student_user').val();
	var student_pass = $('#student_pass').val();
	var hid_student_pass = $('#hid_student_pass').val();
	var block_user = document.getElementById('block_user').checked;
	var notification = document.getElementById('notification').checked;
	
	
	$.ajax({
		url: '<?php echo base_url() . 'subscribers_con/update_school_admin'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&schoolUserID=' + schoolUserID
		+ '&name_first=' + name_first
		+ '&name_last=' + name_last
		+ '&email=' + email
		+ '&phone=' + phone
		+ '&admin_user=' + admin_user
		+ '&admin_pass=' + admin_pass
		+ '&hid_admin_pass=' + hid_admin_pass
		+ '&student_user=' + student_user
		+ '&student_pass=' + student_pass
		+ '&hid_student_pass=' + hid_student_pass
		+ '&block_user=' + block_user
		+ '&notification=' + notification,
		
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