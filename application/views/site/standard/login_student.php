<!-- Starts Member Login (Both Students and Teachers) -->
<div class="band-grey">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-full">

				

				<?php
					
					if( $this->session->userdata('code_message') )
					{
						echo '<h2 class="center textOrange marginTop"><strong>' . $this->session->userdata('code_message') . '</strong></h2>';
					}

				?>
				
			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->




	<!-- Starts Students login -->
	<div class="container">
		<div class="row">

			<!-- Student Login panel -->
			<div class="col-sm-6">

				<h2>Premium Login</h2>
				<p><small>Login here if you have paid for an individual student membership.</small></p>
				<div class="multiseparator vc_custom"></div>
				

				<?php 

					echo form_open('main/login_member_student'); ?>

						<fieldset class="well well-trans">

							

							<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

							<div class="form-group-lg">
								<label for="username">Username (email):</label>
								<input type="text" class="form-control" name="username" id="username" size="35" value="<?php echo set_value('username'); ?>" placeholder="Username">
							</div>

							<div class="form-group-lg">
								<label>Password:</label>
								<input type="password" class="form-control" name="password" id="password" size="35" value="<?php echo set_value('password'); ?>" placeholder="Password">
							</div>
							<br>
							<button type="submit" id="edit_submit" class="btn btn-lg btn-red btn-block">LOGIN</button>
							
							<div class="text-center marTop20"><small>Forgot Password? - <?php echo anchor('main/login_lostpass_form', 'Click Here'); ?></small></div>

						</fieldset>

						<?php
						// Display success / error message
						if( $this->session->userdata('login_attempt') == 'fail' )
						{
							echo '<div class="message_error">Incorrect login details - please try again</div>';
						}

					echo form_close(); 
				?>
				
			</div><!--ENDS col-->


			<!-- Teachers Login panel -->
			<div class="col-sm-6">

				<h2>Guest Login</h2>
				<p><small>Login here if you have a username and password from your school.</small></p>
				<div class="multiseparator vc_custom"></div>

				<?php

					echo form_open('main/login_guest_student', array('class' => 'bg_lock')); ?>

						<fieldset class="well well-trans">

							<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

							<div class="form-group-lg">
								<label>Username:</label>
								<input type="text" class="form-control" name="student_user" id="student_user" size="35" value="<?php echo set_value('student_user'); ?>" placeholder="Username">
							</div>
							
							<div class="form-group-lg">
								<label>Password:</label>
								<input type="password" class="form-control" name="student_pass" id="student_pass" size="35" value="<?php echo set_value('student_pass'); ?>" placeholder="Password">
							</div>
							<br>
							<button type="submit" id="edit_submit2" class="btn btn-lg btn-grey btn-block">LOGIN</button>

							<div class="text-center marTop20"><small>Lost your school password? Please ask your teacher.</small></div>

						</fieldset>

						<?php
						// Display success / error message
						if( $this->session->userdata('login_attempt2') == 'fail' )
						{
							echo '<div class="message_error">Incorrect login details - please try again</div>';
						}

					echo form_close(); 
				?>
				
			</div><!--ENDS col-->

		</div><!--ENDS row-->
	</div><!--ENDS container-->




	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<?php

					if($this->session->userdata('code_message')) // This located in 'paypal' controller 'add_member_codes()' function
					{
						echo '<p>THANK YOU! You have successfully signed up to eLearn Economics. <br />Please login using the \'MEMBER STUDENTS\' panel (top left)</p>';
					}
					else
					{
						echo '<h5 class="text-redLight"><strong>SIGN UP WITH A SCHOOL ACCESS CODE!</strong></h5> <p>If you have been given an Access Code to subscribe through your school ' . anchor('add_member_codes', '<strong>CLICK HERE</strong>') . ' to register. <br>Once registered, login as a full member using your username and password.</p>';
					}

					// Unset $this->session->userdata('code_message')
					$this->session->unset_userdata('code_message');

				?>

				<?php
				// TEACHERS LOGIN LINK
					echo anchor('main/login_teach', 'TEACHER LOGIN', array('class' => 'btn btn-lg btn-red pull-right hidden-xs'));
					echo anchor('main/login_teach', 'TEACHER LOGIN', array('class' => 'btn btn-lg btn-red center-block visible-xs'));
				?>
				
			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->

</div><!-- ENDS band-white -->

