<div class="band-grey">
	<div class="container">
		<div class="row">

			<div class="col-sm-12 col-full">

				<h2>Order a School Subscription</h2>
				<div class="multiseparator vc_custom"></div>


					<h3 class="bold">School Sign Up</h3>
					<p>To order an eLearnEconomics school subscription, please fill out and submit the form below. Once your order has been processed, you will receive (via email) a full set of instructions along with your teacher admin and student login details.</p>



				<div class="row">

					<div class="col-sm-12">

						<?php echo form_open('items/school_order', array('class' => 'bg_sign_up')); ?>

						<fieldset class="well well-trans">

							<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

							<div class="row">
								<div class="col-md-6">
									<div class="form-group-lg">
										<label>Select your School:</label>
										<?php echo schools_dropdown(set_select('schoolID'), set_value('schoolID'), 'List of New Zealand Schools'); ?>
									</div>
								</div><!-- ENDS col -->

								<div class="col-md-6">
									<div class="form-group-lg">
										<label>If your school is not listed - enter your school below:</label>
										<input type="text" name="other_school" class="form-control" id="other_school" value="<?php echo set_value('other_school'); ?>" />
									</div>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-6">
									<div class="form-group-lg">
										<label>First Name</label>
										<input type="text" name="first_name" class="form-control" id="first_name" size="36" value="<?php echo set_value('first_name'); ?>" required />
									</div>
								</div><!-- ENDS col -->

								<div class="col-md-6">
									<div class="form-group-lg">
										<label>Last Name</label>
										<input type="text" name="last_name" class="form-control" id="last_name" size="36" value="<?php echo set_value('last_name'); ?>" required />
									</div>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-6">
									<div class="form-group-lg">
										<label>Contact Email:</label>
										<input type="text" name="email" class="form-control" id="email" size="36" value="<?php echo set_value('email'); ?>" required />
									</div>
								</div><!-- ENDS col -->

								<div class="col-md-6">
									<div class="form-group-lg">
										<label>Contact Phone:</label>
										<input type="text" name="phone" id="phone" class="form-control" size="36" value="<?php echo set_value('phone'); ?>" required />
									</div>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-6">
									<div class="form-group-lg">
										<label>Preferred Password for Generic login:</label>
										<input type="text" name="genPassword" class="form-control" id="genPassword" size="36" value="<?php echo set_value('genPassword'); ?>" required />
									</div>
								</div><!-- ENDS col -->

								<div class="col-md-6">
									<div class="form-group-lg">
										<label>Preferred Password for Teacher Access:</label>
										<input type="text" name="teachPassword" class="form-control" id="teachPassword" size="36" value="<?php echo set_value('teachPassword'); ?>" required />
									</div>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-6">
									<div class="form-group-lg">
										<label>No. of additional students required @ $14.95 per student</label>
										<input type="text" name="num_students" class="form-control" id="num_students" size="3" value="<?php echo set_value('num_students'); ?>" />
									</div>
								</div><!-- ENDS col -->

								<div class="col-md-6">
									<div class="form-group-lg">
										<label>Order Number (Optional)</label>
										<input type="text" name="order_num" class="form-control" id="order_num" size="36" value="<?php echo set_value('order_num'); ?>" />
									</div>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-12">
									<label>
										<input type="checkbox" name="school_licence" value="1" <?php echo set_checkbox('school_licence', '1'); ?>> $289.50 (Incl GST) includes 10 x individual student access codes plus generic code.
									</label>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-12">
									<label>
										<input type="checkbox" name="conf_order" value="1"> Confirm Order Details
									</label>
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->


							<div class="row">
								<div class="col-md-12">
									<br>
									<input type="submit" class="btn btn-lg btn-red" id="submit" value="Place Order" />
								</div><!-- ENDS col -->
							</div><!-- ENDS row -->

	
						</fieldset>



						<?php 
						if( isset($error))
						{
							echo $error;
						}
						echo form_close(); 
						?>

					</div><!-- ENDS col -->

				</div><!-- ENDS row -->

			</div><!--ENDS col-->


			

		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->