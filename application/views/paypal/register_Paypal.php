<div class="band-grey">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-full">


				<h2>Complete your PayPal Registration</h2>
				<div class="multiseparator vc_custom"></div>
				<p>Complete the form below, then proceed to the login page.</p>

				<?php 
					if( isset($error)) { echo $error; 	}
				?>


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


				<div class="row">
					<div class="col-sm-12">

						<?php echo form_open('paypal/add_member/' . $this->uri->segment(3), array('class' => 'bg_sign_up')); ?>

						<fieldset class="well well-trans">

							<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
							<input type="hidden" name="txn_id" id="txn_id" value="<?php echo $this->session->userdata('txn_id'); ?>" />


							<div class="row">
								<div class="col-md-6">
									<div class="form-group-lg">
										<label for="first_name">First Name</label>
										<input type="text" class="form-control" name="first_name" id="first_name" size="36" value="<?php echo set_value('first_name'); ?>" />
									</div>
								</div><!-- ENDS col -->

								<div class="col-md-6">
									<div class="form-group-lg">
										<label for="last_name">Last Name</label>
										<input type="text" class="form-control" name="last_name" id="last_name" size="36" value="<?php echo set_value('last_name'); ?>" />
									</div>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-4">
									<div class="form-group-lg">
										<label for="email">Email (Username)</label>
										<input type="text" class="form-control" name="email" id="email" size="36" value="<?php echo set_value('email', $email->email) ?>" />
									</div>
								</div><!-- ENDS col -->

								<div class="col-md-4">
									<div class="form-group-lg">
										<label for="password">Password</label>
										<input type="password" class="form-control" name="password" id="password" size="36" value="<?php echo set_value('password'); ?>" />
									</div>
								</div><!-- ENDS col -->

								<div class="col-md-4">
									<div class="form-group-lg">
										<label for="conf_password">Confirm Password</label>
										<input type="password" class="form-control" name="conf_password" id="conf_password" size="36" value="<?php echo set_value('conf_password'); ?>" />
									</div>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-6">
									<div class="form-group-lg">
										<label for="schoolID">Schools List</label>
										<?php
										// Display schools drop down list
										echo schools_dropdown(set_select('schoolID'), set_value('schoolID'), 'Select School');
										?>
									</div>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-6">
									<label for="season">My School Year begins:</label><br>
									<?php

										// Display Northern or Southern hemisphere - when school begins year! 
										$south = array(
											'name' => 'season',
											'id' => 'season',
											'value' => '0',
											'checked' => FALSE,
											'style' => 'margin: 10px 10px 0 0',
										);

										$north = array(
											'name' => 'season',
											'id' => 'season',
											'value' => '1',
											'checked' => FALSE,
											'style' => 'margin: 0 10px 0 0',
										);

										echo '<label>';
											echo form_radio($south) . 'January (Southern Hemisphere)';
										echo '</label><br>';
										echo '<label>';
											echo form_radio($north) . 'July (Northern Hemisphere)';
										echo '</label>';
									?>
								</div><!-- ENDS col -->

								<div class="col-md-6">
									<label for="subscribe">Subscribe to Newsletter Updates</label>
									<div class="form-group-lg radio">
										<label>
											<input type="radio" name="subscribe" value="1" checked> Yes &nbsp; &nbsp;
										</label>
									
										<label>
											<input type="radio" name="subscribe" value="0"> No
										</label>
									</div>
								</div><!-- ENDS col -->

							</div><!--ENDS row-->
					
						
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group-lg radio">
										<input type="submit" id="submit" value="Submit Membership" class="btn btn-lg btn-red" />
									</div>
								</div><!--ENDS col-->
							</div><!--ENDS row-->

							
						</fieldset><!-- ENDS well well-trans -->

						<?php echo form_close(); ?>


					</div><!-- ENDS col -->
				</div><!-- ENDS row -->

			</div><!-- ENDS col -->


		</div><!-- ENDS row -->


		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-grey-->
