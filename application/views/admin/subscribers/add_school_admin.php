<h1 class="gridHeader strong">Add School User</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('subscribers_con/select_access_codes', 'Review Codes', array('class' => 'butSmall butRight'));
		echo anchor('subscribers_con/access_code_form', 'Create Codes', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_form', 'Edit School List', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_school_details', 'Search Schools', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_student_details', 'Search Students', array('class' => 'butSmall butBack'));
	?>
	
<h1 class="greyArrow textOrange"><strong>School Admin</strong></h1>
  <p>Complete the fields to set up a school user</p>
  
  <?php echo form_open('subscribers_con/add_school_admin'); ?>
  
  	<div id="container">
  
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      
      <fieldset>
      <legend>SET UP SCHOOL MASTER ADMIN</legend>
      
        <div style="width:100%; display:inline-block;">
          <!--Displays a list of ALL Schools // admin_helper-->
	<?php echo schools_dropdown('', '', 'Select School'); // See admin_helper ?>
        </div>
        
        <div style="width:50%; float:left;">
          <label for"name_first"><strong>First Name:</strong></label>
          <input type="text" name="name_first" id="name_first" size="38" value="<?php echo set_value('name_first'); ?>" />
        
          <label for"name_last"><strong>Last Name:</strong></label>
          <input type="text" name="name_last" id="name_last" size="38" value="<?php echo set_value('name_last'); ?>" />
        </div>
        
        <div style="width:50%; float:left;">
          <label for"email"><strong>Contact Email:</strong></label>
          <input type="text" name="email" id="email" size="40" value="<?php echo set_value('email'); ?>" />

          <label for"phone"><strong>Contact Phone:</strong></label>
          <input type="text" name="phone" id="phone" size="20" value="<?php echo set_value('phone'); ?>" />
        </div>
        
      </fieldset> 
      
      <fieldset>
      <legend>CREATE TEACHER ADMIN LOGIN</legend> 
        
        <div style="width:50%; float:left;">
          <label for"admin_user"><strong>Username </strong>(Teacher):</label>
          <input type="text" name="admin_user" id="admin_user" size="38" value="<?php echo set_value('admin_user'); ?>" />
        </div>
        
        <div style="width:50%; float:left;">
          <label for"admin_pass"><strong>Password </strong>(Teacher):</label>
          <input type="text" name="admin_pass" id="admin_pass" size="38" value="<?php echo set_value('admin_pass'); ?>" />
        </div>
      
      </fieldset>
      
      <fieldset>
      <legend>CREATE (GENERIC) STUDENT LOGIN</legend> 
        
        <div style="width:50%; float:left;">
          <label for"student_user"><strong>Username </strong>(Student):</label>
          <input type="text" name="student_user" id="student_user" size="38" value="<?php echo set_value('student_user'); ?>" />
        </div>
        
        <div style="width:50%; float:left;">
          <label for"student_pass"><strong>Password </strong>(Student):</label>
          <input type="text" name="student_pass" id="student_pass" size="38" value="<?php echo set_value('student_pass'); ?>" />
        </div>
      
      </fieldset>
        
        <input type="submit" id="edit_submit" value="Add School Admin" class="butSmall" />
      
      
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
	var name_first = $('#name_first').val();
	var name_last = $('#name_last').val();
	var email = $('#email').val();
	var phone = $('#phone').val();
	var admin_user = $('#admin_user').val();
	var admin_pass = $('#admin_pass').val();
	var student_user = $('#student_user').val();
	var student_pass = $('#student_pass').val();
	
	
	$.ajax({
		url: '<?php echo base_url() . 'subscribers_con/add_school_admin'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&schoolID=' + schoolID
		+ '&name_first=' + name_first
		+ '&name_last=' + name_last
		+ '&email=' + email
		+ '&phone=' + phone
		+ '&admin_user=' + admin_user
		+ '&admin_pass=' + admin_pass
		+ '&student_user=' + student_user
		+ '&student_pass=' + student_pass,
		
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