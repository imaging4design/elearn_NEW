<div class="band-grey">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-full">

				<h2>Register with a Student Access Code</h2>
				<div class="multiseparator vc_custom"></div>
				<p>Fill in your details below, including your <span class="text-redLight">'Student Access Code'</span> to register for eLearnEconomics.</p>

				<?php 
					if( isset($error)) { echo $error; 	}
					if( isset($code_error)) { echo $code_error; }
				?>

				<?php
					// TEMPORARY DISPLAY ONLY
					if( $this->session->flashdata('error') )
					{
						echo '<h4>' . $this->session->flashdata('error') . '</h4>';
					}
				?>

				<div class="row">

					<div class="col-sm-12">

						<?php echo form_open('add_member_codes/', array('class' => 'bg_sign_up')); ?>

						<fieldset class="well well-trans">

						

						<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />



						<div class="row">
							<div class="col-md-4">
								<div class="form-group-lg">
									<label for="access_code">Student Access Code</label>
									<input type="text" class="form-control" name="access_code" id="access_code" placeholder="Access Code" value="<?php echo set_value('access_code'); ?>" required>
								</div>
							</div><!-- ENDS col -->

							<div class="col-md-4">
								<div class="form-group-lg">
									<label for="first_name">First Name</label>
									<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?php echo set_value('first_name'); ?>" required>
								</div>
							</div><!-- ENDS col -->

							<div class="col-md-4">
								<div class="form-group-lg">
									<label for="last_name">Last Name</label>
									<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo set_value('last_name'); ?>" required>
								</div>
							</div><!-- ENDS col -->
						</div><!-- ENDS row -->



						<div class="row">
							<div class="col-md-12">
								<div class="form-group-lg">
									<label for="email">Email (Username)</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Email (Username)" value="<?php echo set_value('email'); ?>" required>
								</div>
							</div><!-- ENDS col -->
						</div><!-- ENDS row -->


						<div class="row">
							<div class="col-md-6">
								<div class="form-group-lg">
									<label for="password">Password</label>
									<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo set_value('password'); ?>" required>
								</div>
							</div><!-- ENDS col -->
							
							<div class="col-md-6">
								<div class="form-group-lg">
									<label for="conf_password">Confim Password</label>
									<input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Confirm Password" value="<?php echo set_value('conf_password'); ?>" required>
								</div>
							</div><!-- ENDS col -->
						</div><!-- ENDS row -->


						<div class="row">
							<div class="col-md-6">
								<div class="form-group-lg">
									<label for="conf_password">Select School</label>
									<?php
										// Display schools drop down list
										echo schools_dropdown(set_select('schoolID'), set_value('schoolID'), 'Select School');
									?>
								</div>
							</div><!-- ENDS col -->

							<div class="col-md-6">
								<label>Subscribe to Newsletter Updates</label>
								<div class="form-group-lg radio">
									<label>
										<input type="radio" name="subscribe" value="1" checked> Yes &nbsp; &nbsp;
									</label>
								
									<label>
										<input type="radio" name="subscribe" value="0"> No
									</label>
								</div>
							</div><!-- ENDS col -->
						</div><!-- ENDS row -->


						<div class="row">
							<div class="col-sm-12">
								<div class="form-group-lg radio">
									<input type="submit" id="submit" value="Register Now" class="btn btn-lg btn-red" />
								</div>
							</div><!--ENDS col-->
						</div><!--ENDS row-->

						</fieldset>

						<p>*Once registered, you will be directed to the login page.</p>

					<?php echo form_close(); ?>
						
					</div><!-- ENDS col -->
				</div><!-- ENDS row -->

			</div><!-- ENDS col -->


		</div><!-- ENDS row -->


		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->