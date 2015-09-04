<div class="band-grey">
	<div class="container results">
		<div class="row">
			<div class="col-lg-12 col-full">


				<h2>Edit Class name</h2>
				<div class="multiseparator vc_custom"></div>


				<div class="well well-trans">


					<h3>Rename your Class:</h3>
					<p>Select the class you wish to rename from dropdown menu</p>


					<?php echo form_open('teachers/rename_class'); ?>

						<fieldset>

							<div class="row">
								<div class="col-md-6">
							
									<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

									<div class="form-group-lg">
										<label for="classID">Your class</label>
										<?php echo classDropdown('', '', 'Classes for '. $this->session->userdata('school') .''); ?>
									</div>

								</div><!-- ENDS col -->
								<div class="col-md-6">

									<div class="form-group-lg">
										<label for="newclass_name">Enter new class name</label>
										<input type="text" name="newclass_name" class="form-control" id="newclass_name" size="35" value="<?php echo set_value('newclass_name'); ?>" placeholder="Class Name" required>
									</div>

									<input type="submit" name="submit" class="btn btn-lg btn-red fa-fa" id="submit" value="&#xf00c; Update" />

								</div><!-- ENDS col -->
							</div><!-- ENDS row -->

						</fieldset>

					<?php 
					if( isset( $message ))
					{
						echo $message;
					}

					echo form_close(); 

					?>


				</div><!-- ENDS well well-trans -->


			</div><!-- ENDS col -->
		</div><!-- ENDS row -->


		<h2>Manage Students</h2>
		<div class="multiseparator vc_custom"></div>



		<div class="well well-trans">

			<div class="row">
				<div class="col-lg-12 col-full">

					<h3>Add/Move students into your class</h3>
					<p>This task only needs to be performed once to arrange students into your class group.</p>

					<ul>
						<li>Tick the box next to each of YOUR students</li>
						<li>Click <strong>'Move Students'</strong> button at the bottom of the page.</li>
					</ul>

					<p><strong>NOTE:</strong> Students <em>'greyed out'</em> have already been allocated into a class group.<br /> However, if a student has been allocated by mistake, you can still tick/select that student for your class.</p>
					
					<br>
					
				</div><!-- ENDS col -->
			</div><!-- ENDS row -->


				
			<?php echo form_open('teachers/group_students'); ?>

			<?php
				$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$letters = str_split($alphabet);
				$set_letter = FALSE;
				
				// Display full list of topics in alphabetical order with letter (A, B, C) as heading
				if( isset($students) )
				{
					$results = count($students);
					$per_column = ceil($results/3);
					
					$i = 0;


				echo '<div class="row topics-list">';
				echo '<div class="col-sm-4">';
					
					/*************************************************************************/
					// Loop through each topic alphbetically
					/*************************************************************************/
					foreach($students as $row) {
					
					
						if($i == $per_column)
						{
							echo '</div><div class="col-sm-4">';
							$i = 0;
						} 
						 
							/*************************************************************************/
							// Break students up by each letter of alphabet - Use letter (A, B, C ..) as label
							/*************************************************************************/
							foreach($letters as $letter):
							
								// Convert last name to uppercase (otherwise the $alphabet array() being uppercase will miss the lowercase names)
								$name = strtoupper($row->last_name);
				
								if( substr($name, 0, 1) == $letter )
								{
									// Only show new alpha letter at the start of each alpha category
									$alpha_header = ( $set_letter != $letter ) ? $letter . '<div class=	"multiseparator vc_custom"></div>' : '';

									$class = ($row->classID == 0) ? ' ' : 'text-greyLight';

									// Display alpha letter (i.e., A, B, C ...)
									echo '<h4 class="text-redLight"><strong>' . $alpha_header . '</strong></h4>';
									// Display Student Name
									echo '<h5><input type="checkbox" name="studentID[]" id="studentID[]"  value=" ' . $row->studentID . ' " /><span class="'.$class.'"> ' . strtoupper($row->last_name) . ', ' . ucwords($row->first_name).'</span></h5>';

									// Save alpha letter as var to test against looped through version above
									$set_letter = $letter; 
								}
								
							endforeach;
							
							/*************************************************************************/
						 
						 $i++;
						 
					}
					
					echo '</div>';
					echo '</div>';
				
				}
				
			?>

			<br />
			<input type="submit" name="submit" class="btn btn-lg btn-red fa-fa" id="submit" value="Move Students &#xf061;" />

			<?php echo form_close(); ?>

			


		</div><!-- ENDS well well-trans -->

			
	</div><!--ENDS container-->
</div><!--ENDS band-white-->