<div class="gridPadding textPadBoth">

  <h1 class="greyArrow strong textOrange">Administration</h1>
  
  <?php
	echo form_open('admin/login_con/validate_login');
	
	// Adds hidden CSRF unique token
	// This will be verified in the controller against
	// the $this->session->userdata('token') before
	// returning any results data
	echo form_hidden('token', $token);
	?>
  
  <fieldset>
  <legend>LOGIN DETAILS</legend>
  
    <label for"username"><strong>Username:</strong></label>
    <input type="text" name="ad_username" id="ad_username" value="<?php echo set_value('ad_username'); ?>" />
  
    <label for"password"><strong>Password:</strong></label>
    <input type="password" name="ad_password" id="ad_password" value="<?php echo set_value('ad_password'); ?>" />
    
  </fieldset>
  
  <input type="submit" name="submit" id="submit" value="Login" style="display:inline;" class="butSmall" />
	
	<?php
	//Display failed login attempt mesage ...
	if( $this->session->userdata('login_attempt') == 'fail' )
	{
		echo '<span class="message_error">Incorrect login details</span>';
	}
	
	echo form_close();
	?>

</div>