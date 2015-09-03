<div class="band-grey">
	<div class="container results">
		<div class="row">
			<div class="col-lg-12 col-full">

				<h2>Create &amp; Edit Class Groups</h2>
				<div class="multiseparator vc_custom"></div>

				<div class="well well-trans">



					<h3>Setting Class Messages</h3>
					<p>This section allows you as a teacher to set instructions for your class. When students from your class log in, they are presented with this message.</p>
					
					<ul>
						<li>Select the class group you wish to set a message for.</li>
						<li>Click 'Save Message'.</li>
					</ul>

					<?php echo form_open('teachers/update_class_message', array('class' => 'bg_classes')); ?>

						<fieldset>

						<h3>YOUR CLASS MESSAGE</h3>

							<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

							<div class="form-group-lg">
								<label for="class_message">Enter the message you would like to present to your students when they login: (leave blank for no message)</label>
								<textarea cols="80" rows="10" class="form-control" name="class_message" id="class_message"><?php echo $class_message->message; ?></textarea>
							<div>

							<input type="submit" name="submit" class="btn btn-lg btn-red" id="submit" value="Save Message" />

						</fieldset>

					<?php 
					if( isset( $message ) ) 
					{ 
						echo $message;
					}

					echo form_close(); 
					?>


				</div><!-- ENDS well well-trans -->


			</div><!-- ENDS col -->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->