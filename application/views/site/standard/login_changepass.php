<h1 class="gridHeader">Reset Password</h1>

<div class="gridPadding textPadding">


<?php echo form_open('main/reset_password', array('class' => 'bg_sign_up')); ?>

<div id="container">

	<?php
		// Set and keep the temp_code
		$temp_code = ( $this->session->userdata('temp_code') ) ? $this->session->userdata('temp_code') : $this->uri->segment(3);
	?>

	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
	<input type="hidden" name="temp_code" id="temp_code" value="<?php echo $temp_code; ?>" />

	<fieldset>

		<legend>RESET YOUR PASSWORD</legend>

		If you have since remembered your password, please go <?php echo anchor('main/login', 'HERE'); ?> to login (your existing password will remain)<br /><br />

		<label>Username (Email):</label>
		<input type="text" name="username" id="username" size="36" value="<?php echo set_value('username'); ?>" />

		<label>(Change) Password:</label>
		<input type="password" name="password" id="password" size="36" value="<?php echo set_value('password'); ?>" />

		<label>Confim (Change) Password:</label>
		<input type="password" name="conf_password" id="conf_password" size="36" value="<?php echo set_value('conf_password'); ?>" />

		<div class="containerArea">
		<input type="submit" id="submit" value="Reset Password" />
		</div>

	</fieldset>

</div>
	
<?php 

if( isset($error))
{
	echo $error;
}
echo form_close(); ?>

</div>