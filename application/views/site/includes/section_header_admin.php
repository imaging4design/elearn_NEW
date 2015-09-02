<?php
	// Don't display on the home page ...
	if( $this->uri->segment(1) != 'index' && $this->uri->segment(1) != ''):


	// Used to show 'current' tab in use
	$c1 = array('view_month', 'show_class_students', 'view_student', 'refresh_class_students', 'results_by_topic');
	$c2 = array('view_month_print', 'results_PDF', 'show_class_students_print', 'view_student_print');
	$c3 = array('show_students_edit', 'group_students', 'show_students', 'class_message_form');

	$class1 = FALSE; // Initiate var
	$class2 = FALSE; // Initiate var
	$class3 = FALSE; // Initiate var

	$class1 = ( in_array($this->uri->segment(2), $c1)) ? 'active' : '';
	$class2 = ( in_array($this->uri->segment(2), $c2)) ? 'active' : '';
	$class3 = ( in_array($this->uri->segment(2), $c3)) ? 'active' : '';


	// Set up short names for session vars that were created at login
	$schoolID = $this->session->userdata('schoolID');
	$school = $this->session->userdata('school');


?>


<div class="e-tabs">
	<ul class="nav nav-tabs mode-tabs-menu">
		<li class="<?php echo $class1; ?>" id ="screen"><?php echo anchor('teachers/view_month/', '<i class="fa fa-desktop"></i> Screen Reports'); ?></li>
		<li class="<?php echo $class2; ?>" id ="print"><?php echo anchor('teachers/view_month_print/', '<i class="fa fa-print"></i> Print Reports'); ?></li>
		<li class="<?php echo $class3; ?>" id ="show_options"><?php echo anchor('teachers/show_students_edit/', '<i class="fa fa-user"></i> Edit Classes'); ?></li>
	</ul>
</div>

	

<div class="band-topic-sections">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<h2>Welcome, <?php echo strtoupper( $school ); ?></h2>
				<div class="multiseparator vc_custom"></div>

			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-topic-sections-->

<?php endif; ?>