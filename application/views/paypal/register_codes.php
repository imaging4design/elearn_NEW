<div class="container">
	<div class="row">
		<div class="col-sm-9 col-full">

			<h2>Register with a Student Access Code</h2>
			<div class="multiseparator vc_custom"></div>
		

			<?php
				// TEMPORARY DISPLAY ONLY
				if( $this->session->flashdata('error') )
				{
					echo '<h4>' . $this->session->flashdata('error') . '</h4>';
				}
			?>


			<?php echo form_open('add_member_codes/', array('class' => 'bg_sign_up')); ?>

				<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

				<fieldset>
				<legend>STUDENT INFORMATION</legend>

				Fill in your details below, including your <span class="bold">'Student Access Code'</span> to register for eLearnEconomics.<br /><br />

				 <div style="width:50%; float:left;">
					<label>STUDENT ACCESS CODE:</label>
					<input type="text" name="access_code" id="access_code" size="36" value="<?php echo set_value('access_code'); ?>" />
					<label>First Name</label>
					<input type="text" name="first_name" id="first_name" size="36" value="<?php echo set_value('first_name'); ?>" />
					<label>Last Name</label>
					<input type="text" name="last_name" id="last_name" size="36" value="<?php echo set_value('last_name'); ?>" />
				</div>

				<div style="width:50%; float:left;">
					<label>Email (Username)</label>
					<input type="text" name="email" id="email" size="36" value="<?php echo set_value('email') ?>" />
					<label>Password</label>
					<input type="password" name="password" id="password" size="36" value="<?php echo set_value('password'); ?>" />
					<label>Confim Password</label>
					<input type="password" name="conf_password" id="conf_password" size="36" value="<?php echo set_value('conf_password'); ?>" />
				</div>
				</fieldset>

				<fieldset>
				<legend>SCHOOL / COURSE INFORMATION</legend>

				<div style="width:50%; float:left;">
				<label>School List</label>
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
				<div>This will take you to the 'Login' page where you can access the site.</div>
				</fieldset>
				

			<?php 
				if( isset($error)) { echo $error; 	}
				if( isset($code_error)) { echo $code_error; }
				
				echo form_close(); 
			?>



		</div><!--ENDS col-->

		<div class="col-sm-3 sidebar">
			
			<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>

		</div><!--ENDS col-->

	</div><!--ENDS row-->
</div><!--ENDS container-->