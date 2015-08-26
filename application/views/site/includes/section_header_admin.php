<?php
// Don't display on the home page ...
if( $this->uri->segment(1) != 'index' && $this->uri->segment(1) != ''):
?>

<div class="info_bar">

	<?php
	// Used to show 'current' tab in use
	$c1 = array('view_month', 'show_class_students', 'view_student', 'refresh_class_students', 'results_by_topic');
	$c2 = array('view_month_print', 'results_PDF', 'show_class_students_print', 'view_student_print');
	$c3 = array('show_students_edit', 'group_students', 'show_students', 'class_message_form');

	$class1 = FALSE; // Initiate var
	$class2 = FALSE; // Initiate var
	$class3 = FALSE; // Initiate var

	if( in_array($this->uri->segment(2), $c1))
	{
		$class1 = 'one';
	}

	if( in_array($this->uri->segment(2), $c2))
	{
		$class2 = 'two';
	}
	

	if( in_array($this->uri->segment(2), $c3))
	{
		$class3 = 'three';
	}
	
		//Display view 'Progress' and 'Edit Options' buttons for registered uers only!
		echo '<ul id="subNav">';
			echo '<li id="screen">' . anchor('teachers/view_month', ' ', array('class' => $class1)) . '</li>';
			echo '<li id="print">' . anchor('teachers/view_month_print', ' ', array('class' => $class2)) . '</li>';
			echo '<li id="show_options">' . anchor('teachers/show_students_edit', ' ', array('class' => $class3)) . '</li>';
		echo '</ul>';
	?>


	<?php
		// Set up short names for session vars that were created at login
		$schoolID = $this->session->userdata('schoolID');
		$school = $this->session->userdata('school');


	?>

	<h6 style="margin-top:7px;">Logged in: <span class="bold">TEACHER ADMIN</span> from <span class="bold"><?php echo strtoupper( $school ); ?></span></h6>


</div>

<?php endif; ?>