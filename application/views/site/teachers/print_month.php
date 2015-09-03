<div class="band-grey">
	<div class="container results">
		<div class="row">
			<div class="col-lg-12 col-full">


				<h2>Print reports for class: <span class="non_bold"><?php echo get_class_name( $this->session->userdata('classID') ); ?></span></h2>
				<div class="multiseparator vc_custom"></div>


				<div class="well well-trans">
					

					<?php
					/*
					|-----------------------------------------------------------------------------------------------------------------
					| THIS IS THE MASTER 'SET YOU CLASS' DROP DOWN MENU
					| WHY? So the teacher doesn't have to constantly keep selecting their class in the teacher admin section!
					|-----------------------------------------------------------------------------------------------------------------
					*/
					echo form_open('teachers/set_class');
					?>

					<div class="row">
						<div class="col-md-6">

							<fieldset>

								<h3>SELECT YOUR CLASS</h3>

								<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
								<input type="hidden" name="current_URL" id="current_URL" value="<?php echo $this->uri->segment(2); ?>" />

								<?php
								// Set $class to current session -> classID
								$current_class = get_class_name( $this->session->userdata('classID'));

								// Display class list dropdown menu (with current selected class)
								echo '<div class="form-group-lg">';
									echo classDropdown($this->session->userdata('classID'), $this->session->userdata('classID'), $current_class, $this->session->userdata('school') ); 
								echo '</div>';
								?>

							</fieldset>

						<?php echo form_close(); ?>



						<?php

						/*
						|-----------------------------------------------------------------------------------------------------------------
						| Hide everything else on page until they select a class (therefore creating a session 'classID' )
						|-----------------------------------------------------------------------------------------------------------------
						*/
						$hide_me = ( ! $this->session->userdata('classID') ) ? 'display:none;' : '';

						?>

						</div><!-- ENDS col -->
					</div><!-- ENDS row -->




					<div class="row">
						<div class="col-md-6" style="<?php echo $hide_me; ?>">

							<?php
							/************************************************************************************************************/
							// This form will retrieve ALL results for a single topic/month for an entire class group
							/************************************************************************************************************/
							echo form_open('teachers_pdf/results_PDF', array('class' => 'bg_printer')); // THIS PRINTS A PDF!!
							?>

								<fieldset>

									<h3>CLASS REPORT</h3>

									<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

									<p>Full summary of all students (for <?php echo date('Y') ?>)</p>
									<input type="submit" name="submit" class="btn btn-md btn-red" id="submit" value="Download Report" />

								</fieldset>


							<?php 
							if( isset($error))
							{
								echo $error;
							}
							echo form_close();
							?>

						</div><!-- ENDS col -->


						<div class="col-md-6" style="<?php echo $hide_me; ?>">

							<?php
							/************************************************************************************************************/
							// This form will first display a full list of students in a single class group
							// Then each student can be clicked to view their entire results for the current month
							/************************************************************************************************************/
							echo form_open('teachers/show_class_students_print', array('class' => 'bg_printer'));

							
							// Set the default label / value for the Class dropdown menu
							// i.e. Remember the Teacher/Class name so we don't have to reselect!
							// Used in classDropdown($value, $selected, $label) below
							if( isset($class) && $this->session->userdata('classID'))
							{
								$value = $this->session->userdata('classID');
								$selected = $this->session->userdata('classID');
								$label = $class->class_name;
							}
							else
							{
								$value = '';
								$selected = ''; 
								$label = 'Classes for '. $this->session->userdata('school');
							}
							/****************************************************************************/

							?>

							<fieldset>

								<h3>STUDENT REPORTS</h3>

								<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

								<p>Individual student reports (for <?php echo date('Y') ?>)</p>
								<input type="submit" name="submit" class="btn btn-md btn-red" id="submit" value="View Students" />

							</fieldset>


							<?php
							if( isset($error2))
							{
								echo $error2;
							}
								
							echo form_close(); 

							?>

						</div><!-- ENDS col -->
					</div><!-- ENDS row -->


				</div><!-- ENDS well well-trans -->

			</div><!-- ENDS col -->

		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->


<script type="text/javascript">
	
// Submit form when onChange radion button #flash_opt
(function(){
	
	// Submit form when onChange 'drop down'
	(function(){
		$("#classID").on('change', function () {
			this.form.submit();
		});
	})();


	$("#order").on('change', function () {
		this.form.submit();
	});

	$(".month").on('change', function () {
		this.form.submit();
	});

})();


</script>