<h1 class="gridHeader">Teacher Administration</h1>

<div class="gridPadding textPadding">


	<?php echo form_open('main/login_teach'); ?>

	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

	<fieldset>
	<legend>TEACHER LOGIN</legend>

	<span class="marginBot"><span class="textOrange bold">NOTE: </span>Please keep your teacher admin login details secure.</span>

		<label>Username:</label>
		<input type="text" name="admin_user" id="admin_user" size="30" value="<?php echo set_value('admin_user'); ?>">

		<label>Password:</label>
		<input type="password" name="admin_pass" id="admin_pass" size="30" value="<?php echo set_value('admin_pass'); ?>">

		<label></label>
		<input type="submit" name="submit" id="submit" value="LOGIN" />

	</fieldset>

	<?php
	// Display success / error message
	if( $this->input->post('submit') && $this->session->userdata('login_teach') == 'fail' )
	{
		echo '<div class="message_error">Incorrect login details - please try again</div>';
	}

	echo form_close(); 
	?>

	<?php echo form_close(); ?>

  
</div>