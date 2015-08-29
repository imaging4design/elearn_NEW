<div class="band-topic-sections">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-full options">

				<h2>Leaderboard Options</h2>
				<div class="multiseparator vc_custom"></div>
				<p>By default your results are hidden, but if you wish to see how you compare with fellow students from both your school and nationally - check 'Yes'.</p>

			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->


<div class="band-white">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-full options">

				<?php echo form_open('section/edit_options', array('class' => 'bg_sign_up')); ?>

					<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
					<input type="hidden" name="studentID" id="studentID" value="<?php echo $details->studentID; ?>" />

					

					<p><strong><?php echo $details->first_name; ?></strong>, do you wish to have your results displayed on the leaderboard?</p>


					<div class="form-group">

						<div class="radio">
							<label>
								<input type="radio" name="leaderboard" value="1" <?php if($details->leaderboard == '1') { echo 'checked = \"checked\"'; } ?> />
								Yes
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" name="leaderboard" value="0" <?php if($details->leaderboard == '0') { echo 'checked = \"checked\"'; } ?> />
								No
							</label>
						</div>

					</div><!-- ENDS form-group -->






					<input type="submit" id="submit" value="Update" class="btn btn-lg btn-red" />

					<?php 
						if( isset($error))
						{
							echo '<p><strong>' . $error . '</strong></p>';
						}

						echo form_close(); 
					?>

					<br>

					<p><strong>NOTE: </strong> If you have changed schools or wish to update your email address, please email <?php echo safe_mailto('info@elearneconomics.com', 'SUPPORT'); ?> with your request.</p>


			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->