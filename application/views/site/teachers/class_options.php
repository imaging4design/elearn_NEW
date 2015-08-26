<h1 class="gridHeader_grey">Create &amp; Edit Class Groups 444</h1>

<div class="grid_6 alpha gridPadding textPadding">

	<h3 class="bold">Creating Class Groups</h3>
	<p class="bold">This section allows you as a teacher to move your students into class groups to make it easier to monitor their progress.</p>
	<ol>
		<li>Create a new class by entering your (teacher) name or class name</li>
		<li>Click 'Create Now'</li>
	</ol>

<?php echo form_open('teachers/create_class', array('class' => 'bg_classes')); ?>

	<fieldset>
	<legend class="grey">CREATE A NEW CLASS GROUP</legend>

		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

		<label>Enter a Class Name (e.g. Mr Jones or Class 4JR):</label>
		<input type="text" name="class_name" id="class_name" size="35" value="<?php echo set_value('class_name'); ?>"><br>

		<input type="submit" name="submit" id="submit" value="Create Now" class="butSmall" />

	</fieldset>

<?php 
if( isset($message)) { echo $message; }

echo form_close(); 
?>

</div>



<div class="grid_6 omega gridPadding textPadding">

	<h3 class="bold">Editing Class Groups</h3>
	<p class="bold">This section allows you as a teacher to 'edit' your class group by adding additional students.</p>
	<ol>
		<li>Select your 'class name' from the dropdown menu below</li>
		<li>Click 'Edit Now'.</li>
	</ol>


<?php echo form_open('teachers/show_students_edit', array('class' => 'bg_classes')); ?>

	<fieldset>
	<legend class="grey">EDIT CLASS GROUP</legend>

		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

		<label>Select your Class</label>
		<?php
			echo classDropdown('', '', 'Classes for '. $this->session->userdata('school') .'', $this->session->userdata('school'));
		?>

		<label></label>
		<input type="submit" name="submit" id="submit" value="Edit Now" class="butSmall" />

	</fieldset>

<?php 
if( isset($error)) { echo $error; }

echo form_close(); 
?>

</div>