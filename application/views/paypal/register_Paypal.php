<h1 class="gridHeader_grey">Complete Your Registration</h1>

<div class="gridPadding textPadding">

<?php
	// TEMPORARY DISPLAY ONLY
	// THIS CAN BE ROMOVED LATER
	// DISPLAYS THE DATA SENT FROM PAYPAL!!!!!!
	if( $this->session->flashdata('error') )
	{
		echo '<p>' . $this->session->flashdata('error') . '</p>';
	}
	
	// KEEP THIS THOUGH
	if( $this->session->flashdata('success') )
	{
		echo '<p>' . $this->session->flashdata('success') . '</p>';
	}

	//echo '<p>Name: ' . $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name') . '</p>';
	//echo '<p>Member Email: ' . $this->session->userdata('member_email') . '</p>';
	//echo '<p>Payer Email: ' . $this->session->userdata('payer_email') . '</p>';
	//echo '<p>Txn_id: ' . $this->session->userdata('txn_id') . '</p>';

	//echo '<p>Key Code: ' . $this->session->userdata('key_check') .'</p>';

?>


<?php echo form_open('paypal/add_member/' . $this->uri->segment(3), array('class' => 'bg_sign_up')); ?>

	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
	<input type="hidden" name="txn_id" id="txn_id" value="<?php echo $this->session->userdata('txn_id'); ?>" />

	<fieldset>
	<legend>STUDENT INFORMATION</legend>

	 <div style="width:50%; float:left;">
		<label>First Name</label>
		<input type="text" name="first_name" id="first_name" size="36" value="<?php echo set_value('first_name'); ?>" />
		<label>Last Name</label>
		<input type="text" name="last_name" id="last_name" size="36" value="<?php echo set_value('last_name'); ?>" />
	</div>

	<div style="width:50%; float:left;">
		<label>Email (Username)</label>
		<input type="text" name="email" id="email" size="36" value="<?php echo set_value('email', $email->email) ?>" />
		<label>Password</label>
		<input type="password" name="password" id="password" size="36" value="<?php echo set_value('password'); ?>" />
		<label>Confim Password</label>
		<input type="password" name="conf_password" id="conf_password" size="36" value="<?php echo set_value('conf_password'); ?>" />
	</div>
	</fieldset>

	<fieldset>
	<legend>SCHOOL &AMP; NEWSLETTER</legend>

	<div style="width:50%; float:left;">
	<label>Schools List</label>
		<?php
		// Display schools drop down list
		echo schools_dropdown(set_select('schoolID'), set_value('schoolID'), 'Select School');
		?>
	</div>

	

	<div style="width:50%; float:right;">
		<label>Subscribe to Newsletter Updates</label>

		<label>
			<input type="radio" name="subscribe" value="1" checked> Yes
		</label>
		<label>
			<input type="radio" name="subscribe" value="0"> No
		</label>
	</div>

	<input type="submit" id="submit" value="Submit Membership" class="butSmall" />
	</fieldset>
	

<?php 
	if( isset($error)) 
	{ 
		echo $error; 	
	}
	
	echo form_close(); ?>

</div>