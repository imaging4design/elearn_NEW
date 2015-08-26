<div class="container">
	<div class="row">
		<div class="col-sm-12 col-full">

			<h2>Edit Options</h2>
			<div class="multiseparator vc_custom"></div>

			<?php echo form_open('section/edit_options', array('class' => 'bg_sign_up')); ?>

				<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
				<input type="hidden" name="studentID" id="studentID" value="<?php echo $details->studentID; ?>" />


				<h3>EDIT OPTIONS for <strong><?php echo strtoupper($details->first_name . ' ' . $details->last_name); ?></strong></h3>

				<p>If you have changed schools or wish to update your email address, please email <?php echo safe_mailto('info@elearneconomics.com', 'SUPPORT'); ?> with your request.</p>


		</div><!-- ENDS col -->
	</div><!-- ENDS row -->

	<div class="row">
		<div class="col-sm-6">

			<div class="form-group">
				<label><strong>Email (Username):</strong></label>
					<?php echo $details->email; ?>
			</div>

			<div class="form-group">
				<label><strong>School:</strong></label>
					<?php echo $details->school; ?>
			</div>

			<p>
				<small>By default your results are hidden, but if you wish to see how you compare with fellow students from both your school and nationally - check 'Yes'</small>
			</p>

		</div><!-- ENDS col -->

		<div class="col-sm-6">

			<p>Show my results on the Leader Board</p>

			<div class="form-group">

				<div class="checkbox">
					<label>
						<input type="radio" name="leaderboard" value="1" <?php if($details->leaderboard == '1') { echo 'checked = \"checked\"'; } ?> /> Yes
					</label>
				</div>
			
				<div class="checkbox">
					<label>
						<input type="radio" name="leaderboard" value="0" <?php if($details->leaderboard == '0') { echo 'checked = \"checked\"'; } ?> /> No
					</label>
				</div>
			</div>


			

			<input type="submit" id="submit" value="Update Details" class="btn btn-md btn-red" />
		

		<?php 
			if( isset($error))
			{
				echo '<p><strong>' . $error . '</strong></p>';
			}

			echo form_close(); 
		?>


		</div>



		



		</div><!--ENDS col-->
	</div><!--ENDS row-->
</div><!--ENDS container-->


