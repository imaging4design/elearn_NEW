<div class="band-grey">
	<div class="container results">
		<div class="row">
			<div class="col-lg-12 col-full">


				<h2>Create &amp; Edit Class Groups</h2>
				<div class="multiseparator vc_custom"></div>


				<div class="well well-trans">
					

					<div class="row">
						<div class="col-md-6">

								<h3 class="bold">Creating Class Groups</h3>
								<p class="bold">This section allows you as a teacher to move your students into class groups to make it easier to monitor their progress.</p>
								<ul>
									<li>Create a new class by entering your (teacher) name or class name</li>
									<li>Click 'Create Now'</li>
								</ul>

							<?php echo form_open('teachers/create_class', array('class' => 'bg_classes')); ?>

								<fieldset>

									<h3>CREATE A NEW CLASS GROUP</h3>

									<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

									<div class="form-group-lg">
										<label for="class_name">Enter a Class Name (e.g. Mr Jones or Class 4JR):</label>
										<input type="text" name="class_name" class="form-control"  id="class_name" value="<?php echo set_value('class_name'); ?>" placeholder="New Class Name" required>
									</div>

									<input type="submit" name="submit" class="btn btn-lg btn-red btn-block fa-fa" id="submit" value="&#xf067; Create Now" />

								</fieldset>

							<?php 
								if( isset($message)) { echo $message; }

								echo form_close(); 
							?>

						</div><!-- ENDS col -->


					
						<div class="col-md-6">

							<h3>Editing Class Groups</h3>
							<p>This section allows you as a teacher to 'edit' your class group by adding additional students.</p>
							<ul>
								<li>Select your 'class name' from the dropdown menu below</li>
								<li>Click 'Edit Now'.</li>
							</ul>


							<?php echo form_open('teachers/show_students_edit', array('class' => 'bg_classes')); ?>

								<fieldset>

									<h3>EDIT CLASS GROUP</h3>

									<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

									<div class="form-group-lg">
										<label for="classID">Select your class from</label>
										<?php
											echo classDropdown('', '', 'Classes for '. $this->session->userdata('school') .'', $this->session->userdata('school'));
										?>
									</div>

									<input type="submit" name="submit" class="btn btn-lg btn-red btn-block fa-fa" id="submit" value="&#xf040; Edit Now" />

								</fieldset>

							<?php 
							if( isset($error)) { echo $error; }

							echo form_close(); 
							?>

						</div><!-- ENDS col -->
					</div><!-- ENDS row -->


				</div><!-- ENDS well well-trans -->


			</div><!-- ENDS col -->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->