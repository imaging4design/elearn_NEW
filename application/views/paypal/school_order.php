<div class="band-white">
	<div class="container">
		<div class="row">

			<div class="col-sm-9 col-full">

				<h2>Order a School Subscription</h2>
				<div class="multiseparator vc_custom"></div>


					<h3 class="bold">School Sign Up</h3>
					<p>To order an eLearnEconomics school subscription, please fill out and submit the form below. Once your order has been processed, you will receive (via email) a full set of instructions along with your teacher admin and student login details.</p>

				<?php echo form_open('items/school_order', array('class' => 'bg_sign_up')); ?>

					<fieldset>

						<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

						<legend>YOUR SCHOOL DETAILS</legend>

						<div>
							<label>Select your School:</label>
							<?php echo schools_dropdown(set_select('schoolID'), set_value('schoolID'), 'List of New Zealand Schools'); ?>
						</div>

						<div style="width:50%; float:left;">

							<label>If your school is not listed - enter your school below:</label>
							<input type="text" name="other_school" id="other_school" size="36" value="<?php echo set_value('other_school'); ?>" />

							<label>First Name</label>
							<input type="text" name="first_name" id="first_name" size="36" value="<?php echo set_value('first_name'); ?>" />

							<label>Last Name</label>
							<input type="text" name="last_name" id="last_name" size="36" value="<?php echo set_value('last_name'); ?>" />

							<label>Contact Email:</label>
							<input type="text" name="email" id="email" size="36" value="<?php echo set_value('email'); ?>" />

							<label>Contact Phone:</label>
							<input type="text" name="phone" id="phone" size="36" value="<?php echo set_value('phone'); ?>" />

						</div>


						<div style="width:50%; float:right;">

							<label>Preferred Password for Generic login:</label>
							<input type="text" name="genPassword" id="genPassword" size="36" value="<?php echo set_value('genPassword'); ?>" />

							<label>Preferred Password for Teacher Access:</label>
							<input type="text" name="teachPassword" id="teachPassword" size="36" value="<?php echo set_value('teachPassword'); ?>" />

							<label>Order Number (Optional)</label>
							<input type="text" name="order_num" id="order_num" size="36" value="<?php echo set_value('order_num'); ?>" />

							<label style="padding:20px 0;">
								<input type="checkbox" name="school_licence" value="1" <?php echo set_checkbox('school_licence', '1'); ?>> $289.50 (Incl GST) includes 10 x individual student access codes plus generic code.
							</label>

							<label>Number of additional students required @ $14.95 per student</label>
							<input type="text" name="num_students" id="num_students" size="3" value="<?php echo set_value('num_students'); ?>" />
							
						</div>

						<div style="width:50%; float:left; clear:both; padding-top:15px;">
							<label>
								<input type="checkbox" name="conf_order" value="1"> Confirm Order Details
							</label>

							<input type="submit" id="submit" value="Send Order" />
						</div>
						

					</fieldset>



				<?php 
				if( isset($error))
				{
					echo $error;
				}
				echo form_close(); 
				?>

			</div><!--ENDS col-->


			<div class="col-sm-3 sidebar">

				<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>

			</div><!--ENDS col-->

		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->