<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscribers_con extends CI_Controller
{   
    
function __construct()
{
	parent::__construct();
	$this->is_logged_in();
	$this->load->model('admin/subscribers_model');
}

    
    
/*************************************************************************************/
// FUNCTION NAME :: is_logged_in()
// Checks to see if admin is already logged in
// If not - send them to the login page again
/*************************************************************************************/
function is_logged_in()
{
	$is_logged_in = $this->session->userdata('is_logged_in');
	$master = $this->session->userdata('level');

	if( ! isset($is_logged_in) || $is_logged_in != true || $master == 0 )
	{
		//Log out user if NOT 'master' admin
		redirect('admin/login_con/logout');
	}
	
}
    
    
    
/************************************************************************************************************************************************************************/
//
// SUBSCRIBERS ADMIN SECTION
//
/************************************************************************************************************************************************************************/  

/*************************************************************************************/
// FUNCTION get_auto_students()
// Used to operate the 'auto complete' drop down student menu
/*************************************************************************************/
public function get_auto_students()
{
	// If query returns TRUE
	if($query = $this->subscribers_model->get_auto_students())
	{
		// Initiate $nameLast array()
		$nameLast = array();

		// Loop through results and create an array
		foreach($query as $row)

		// Pushes the passed variables onto the end of array ($nameLast)
		array_push($nameLast, strtoupper($row->last_name) . ', ' . ucwords($row->first_name) . ' (' . $row->school . ') ' . $row->studentID );

		// Return data (json_encode)
		echo json_encode($nameLast);
	}
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: get_student_details()
// Displays the Students personal details
/*************************************************************************************/
public function get_student_details()
{
	$this->form_validation->set_rules('token', 'Token', 'trim|required');
	$this->form_validation->set_rules('studentID', 'Search Student', 'trim|required');

	// Get only the 4 digit studentID number
	$studentID = substr($this->input->post('studentID'), -4);

	$data = array(
		'studentID' => $studentID
	);

	// If form validates -> add new record to database and initiate success or failure message
	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		if($query = $this->subscribers_model->get_student_details($data))
		{
			$data['student'] = $query;
		}

		$data['token'] = $this->auth->token();

		$data['main_content'] = 'admin/subscribers/search_students';
		$this->load->view('admin/includes/template', $data);
	} 
	else 
	{
		$this->error_student = validation_errors('<div class="message_error">* ', '</div>');

		$data['token'] = $this->auth->token();

		$data['main_content'] = 'admin/subscribers/search_students';
		$this->load->view('admin/includes/template', $data);
	}

}



/*************************************************************************************/
// FUNCTION NAME :: get_northern_students()
// Displays Students registered for the Northern Hemisphere Season
/*************************************************************************************/
public function get_northern_students()
{
	$this->form_validation->set_rules('token', 'Token', 'trim|required');
	$this->form_validation->set_rules('season', 'Season', 'trim|required');

	// Get value for 'Northern Hemisphere' students
	$season = $this->input->post('season');

	$data = array(
		'season' => $season
	);


	// If form validates -> add new record to database and initiate success or failure message
	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		
		if($query = $this->subscribers_model->get_northern_students($data))
		{
			$data['show_season'] = $query;
		}

		$data['token'] = $this->auth->token();

		$data['main_content'] = 'admin/subscribers/search_students';
		$this->load->view('admin/includes/template', $data);
	} 
	else 
	{
		$this->error_season = validation_errors('<div class="message_error">* ', '</div>');

		$data['token'] = $this->auth->token();

		$data['main_content'] = 'admin/subscribers/search_students';
		$this->load->view('admin/includes/template', $data);
	}

}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: get_school_details()
// Displays the Schools details
/*************************************************************************************/
public function get_school_details()
{
	$this->form_validation->set_rules('token', 'Token', 'trim|required');
	$this->form_validation->set_rules('schoolID', 'Search School', 'trim|required');

	$data = array(
		'schoolID' => $this->input->post('schoolID')
	);

	// If form validates -> add new record to database and initiate success or failure message
	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		if($query = $this->subscribers_model->get_school_details($data))
		{
			$data['school'] = $query;
		}

		if($query = $this->subscribers_model->get_student_from_school($data))
		{
			$data['schoolStudents'] = $query;
		}

		$data['token'] = $this->auth->token();

		$data['main_content'] = 'admin/subscribers/search_schools';
		$this->load->view('admin/includes/template', $data);

	} 
	else 
	{
		$this->error_school = validation_errors('<div class="message_error">* ', '</div>');

		$data['token'] = $this->auth->token();

		$data['main_content'] = 'admin/subscribers/search_schools';
		$this->load->view('admin/includes/template', $data);
	}

}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: school_form()
// Displays form to add a School
/*************************************************************************************/
public function school_form()
{
	$data['token'] = $this->auth->token();
	$data['main_content'] = 'admin/subscribers/add_school';
	$this->load->view('admin/includes/template', $data);
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: school_admin_form()
// Displays form to add a new school administrator
/*************************************************************************************/
public function school_admin_form()
{
	$data['token'] = $this->auth->token();
	$data['main_content'] = 'admin/subscribers/add_school_admin';
	$this->load->view('admin/includes/template', $data);
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: add_school_admin()
// Adds a new School to database
/*************************************************************************************/
public function add_school_admin()
{
	$this->form_validation->set_rules('token', 'Token', 'trim|required');
	$this->form_validation->set_rules('schoolID', 'School Name', 'trim|required|is_unique[mem_schools.schoolID]|max_length[45]');
	$this->form_validation->set_rules('name_first', 'First Name', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('name_last', 'Last Name', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email');
	$this->form_validation->set_rules('phone', 'Phone', 'trim');

	$this->form_validation->set_rules('admin_user', 'Teacher Username', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('admin_pass', 'Teacher Password', 'trim|required|min_length[6]');

	$this->form_validation->set_rules('student_user', 'Student Username', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('student_pass', 'Student Password', 'trim|required|min_length[6]');

	$data = array(
		'schoolID' => $this->input->post('schoolID'),
		'name_first' => $this->input->post('name_first'),
		'name_last' => $this->input->post('name_last'),
		'email' => $this->input->post('email'),
		'phone' => $this->input->post('phone'),
		'admin_user' => $this->input->post('admin_user'),
		'admin_pass' => md5( $this->input->post('admin_pass') ),
		'student_user' => $this->input->post('student_user'),
		'student_pass' => md5( $this->input->post('student_pass') ),
		'created_at' => date('Y-m-d')
	);

	// Set up unencrypted passwords so they can be email and understood - before md5()
	$password = array(
		'admin_pass' => $this->input->post('admin_pass'),
		'student_pass' => $this->input->post('student_pass')
	);

	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		$this->subscribers_model->add_school_admin($data);
		echo '<div class="message_success">New Record successfully added!</div>';


		/**********************************************************************************************************/
		// Email notification to School Admin User
		/**********************************************************************************************************/

		//load email library
		$this->email->set_newline("\r\n");

		//assign values to vars
		$fullName = $data['name_first'] . ' ' . $data['name_last'];
		$email = $data['email'];

		// Send to the school and a copy to eLearn admin
		$email = $data['email'];

		$enquiry = 'Notification from eLearn Economics - School details:<br><br>';
		$enquiry = 'Please click here to go to the teacher login page: '.base_url().'main/login_teach<br>';
		$enquiry = 'Please note this is for teachers to view results of students whom have individual access, guest users will not be tracked<br>';
		$enquiry = 'Please click here to go to the student login page. Please note students and teachers wishing to view the student site log in as School Guest Members on the right hand side: '.base_url().'main/login<br><br>';

		$enquiry .= '<strong>Teacher Login (Username): </strong>' . $data['admin_user'] . '<br>';
		$enquiry .= '<strong>Teacher Login (Password): </strong>' . $password['admin_pass'] . '<br><br>';
		$enquiry .= '<strong>Student Login (Username): </strong>' . $data['student_user'] . '<br>';
		$enquiry .= '<strong>Student Login (Password): </strong>' . $password['student_pass'] . '<br><br>';

		$enquiry .= 'Please ensure you have read and agree to the sites terms and conditions. <br>The above Logins are for the use of students and teachers at the individual school.<br>The school department is responsible for protecting the privacy of the Teacher Login Password<br><br>';
		$enquiry .= 'Rennie Resources Ltd<br>';
		$enquiry .= 'Ph (09) 410 9653<br>';
		$enquiry .= 'Email: '. mailto('info@elearneconomics.com', 'info@elearneconomics.com') .'<br>';
		$enquiry .= 'Website: '. anchor(base_url(), 'www.elearneconomics.com') . ' | ' . anchor('http://www.rennieresources.co.nz', 'www.rennieresources.co.nz');

		//set to, from, subject, message
		$this->email->to($email, 'eLearn Economics');
		$this->email->cc('info@elearneconomics.com');
		$this->email->from('info@elearneconomics.com');
		$this->email->subject('eLearn Economics - School Admin Details');
		$this->email->message($enquiry);

		//send the email!!
		$this->email->send();

		//display any problems to screen
		//echo $this->email->print_debugger();

		/**********************************************************************************************************/
		// ENDS
		/**********************************************************************************************************/
	} 
	else 
	{
		echo validation_errors('<div class="message_error">* ', '</div>');
	}
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: add_school()
// Adds a new School to database
/*************************************************************************************/
public function add_school()
{
	$this->form_validation->set_rules('school', 'School Name', 'trim|required|is_unique[ad_schools.school]|max_length[45]');

	$data = array(
		'school' => $this->input->post('school')
	);

	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		$this->subscribers_model->add_school($data);

		$data['token'] = $this->auth->token();
		$data['message'] = '<div class="message_success">New Record successfully added!</div>';

		$data['main_content'] = 'admin/subscribers/add_school';
		$this->load->view('admin/includes/template', $data);
	} 
	else 
	{
		$data['token'] = $this->auth->token();
		$data['message'] = validation_errors('<div class="message_error">* ', '</div>');

		$data['main_content'] = 'admin/subscribers/add_school';
		$this->load->view('admin/includes/template', $data);
	}
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: update_school()
// Edits a School name
/*************************************************************************************/
public function update_school()
{
	$this->form_validation->set_rules('schoolID', 'Select School', 'trim|required');
	$this->form_validation->set_rules('newSchoolName', 'New School Name', 'trim|required|max_length[45]');

	$data = array(
		'id' => $this->input->post('schoolID'),
		'school' => $this->input->post('newSchoolName')
	);

	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		$this->subscribers_model->update_school($data);
		echo '<div class="message_success">Record successfully updated!</div>';
	} 
	else 
	{
		echo validation_errors('<div class="message_error">* ', '</div>');
	}
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: access_code_form()
// Displays the form to add new Access Codes
/*************************************************************************************/
public function access_code_form()
{
	$data['token'] = $this->auth->token();

	$data['main_content'] = 'admin/subscribers/add_access_codes';
	$this->load->view('admin/includes/template', $data);

}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: select_access_codes()
// Displays the Access Codes
/*************************************************************************************/
public function select_access_codes()
{
	$data['token'] = $this->auth->token();

	$data['main_content'] = 'admin/subscribers/review_codes';
	$this->load->view('admin/includes/template', $data);

}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: view_access_codes()
// Displays the Access Codes for the selected school
/*************************************************************************************/
public function view_access_codes()
{
	$data['token'] = $this->auth->token();

	// Display list of Access Codes from selected school
	if($query = $this->subscribers_model->view_access_codes())
	{
		$data['codes'] = $query;
	}

	$data['main_content'] = 'admin/subscribers/review_codes';
	$this->load->view('admin/includes/template', $data);
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: add_access_codes()
// Adds a new batch of Access Codes
/*************************************************************************************/
public function add_access_codes()
{
	$this->form_validation->set_rules('schoolID', 'Select School', 'trim|required');
	$this->form_validation->set_rules('batch', 'Batch Name', 'trim|required');
	$this->form_validation->set_rules('quantity', 'Number of Codes', 'trim|required|is_natural_no_zero');
	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

	$data = array(
	'schoolID' => $this->input->post('schoolID'),
	'batch' => $this->input->post('batch'),
	'created_at' => date('Y-m-d')
	);


	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{

		// Initiate var $email_codes
		$email_codes = FALSE;

		// Insert $count x number of codes
		$count = $this->input->post('quantity');

		for($i=1; $i<=$count; $i++):

		// Create random Access Code during each loop! (8 digits)
		$data['access_code'] = substr(md5(uniqid(mt_rand(), true)), 0, 8);
		$email_codes .= $data['access_code'] . '<br>';

		$this->subscribers_model->add_access_codes($data);

		endfor;

		echo '<div class="message_success">Codes successfully created!</div>';


		/**********************************************************************************************************/
		// Email notification to School Admin User (only if checkbox ticked)
		/**********************************************************************************************************/
		if( $this->input->post('email') )
		{
			//load email library
			$this->email->set_newline("\r\n");

			//assign values to vars
			$fullName = $data['batch'];
			$email = $this->input->post('email');

			$enquiry = '<strong>ACCESS CODES for ' . $data['batch'] . ':</strong><br><br>';
			$enquiry .= 'Please print out the access code(s) below.<br>';
			$enquiry .= 'Visit ' . anchor(base_url(), 'www.elearneconomics.com') . ' and go to FAQs at top of page<br>';
			$enquiry .= 'Go to the question:<br>';
			$enquiry .= 'How do I log in using an access code?<br>';
			$enquiry .= 'Click on the question to see a dropdown answer with full instructions on how to activate an access code. (Instructions may be printed if required).<br><br>';
			
			$enquiry .= 'Visit ' . base_url() . 'add_member_codes to register your access code and become a member.<br><br>';
			$enquiry .= '<strong>ACCESS CODES:</strong><br>';
			$enquiry .= $email_codes . '<br><br>';

			$enquiry .= 'eLearn Resources<br>';
			$enquiry .= 'Ph (09) 410 9653<br>';
			$enquiry .= 'Email: '. mailto('info@elearneconomics.com', 'info@elearneconomics.com') .'<br>';
			//$enquiry .= 'Email: '. mailto('info@imaging4design.co.nz', 'info@imaging4design.co.nz') .'<br>';
			$enquiry .= 'Website: '. anchor(base_url(), 'www.elearneconomics.com') . ' | ' . anchor('http://www.rennieresources.co.nz', 'www.rennieresources.co.nz');

			//set to, from, subject, message
			$this->email->to($email, 'eLearn Economics');
			$this->email->cc('info@elearneconomics.com');
			$this->email->from('info@elearneconomics.com');
			$this->email->subject('eLearn Economics - Student Access Codes');
			$this->email->message($enquiry);

			//send the email!!
			$this->email->send();

			//display any problems to screen
			//echo $this->email->print_debugger();
		}

		/**********************************************************************************************************/
		// ENDS
		/**********************************************************************************************************/
	} 
	else 
	{
		echo validation_errors('<div class="message_error">* ', '</div>');
	}

}



/*************************************************************************************/
// FUNCTION NAME :: delete_access_codes()
// Deletes unused Access Codes
/*************************************************************************************/
function delete_access_codes()
{
	//Loop through codeID rows (id's) and assign them to var $id
	foreach($this->input->post('deleteCode') as $id):

		$data = array(
			'codeID' => $id                         
		);

		$this->subscribers_model->delete_access_codes($data);

		$this->message = '<div class="message_success">Codes successfully deleted</div>';

	endforeach;

	$this->select_access_codes();
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: edit_school()
// Populates form field to edit school admin details
/*************************************************************************************/
public function edit_school()
{
	$data['token'] = $this->auth->token();

	// Display list of Access Codes from selected school
	if($query = $this->subscribers_model->edit_school())
	{
		$data['school'] = $query;
	}

	$data['main_content'] = 'admin/subscribers/edit_school';
	$this->load->view('admin/includes/template', $data);
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: update_school_admin()
// Updates school admin details to the database
/*************************************************************************************/
public function update_school_admin()
{
	$this->form_validation->set_rules('token', 'Token', 'trim|required');
	$this->form_validation->set_rules('schoolUserID', 'School User ID', 'trim|required');
	$this->form_validation->set_rules('name_first', 'First Name', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('name_last', 'Last Name', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email');
	$this->form_validation->set_rules('phone', 'Phone', 'trim');
	$this->form_validation->set_rules('admin_user', 'Teacher Username', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('admin_pass', 'Teacher Password', 'trim|min_length[6]');
	$this->form_validation->set_rules('hid_admin_pass', 'Current Teacher Password', 'trim|min_length[6]');
	$this->form_validation->set_rules('student_user', 'Student Username', 'trim|required|max_length[50]');
	$this->form_validation->set_rules('student_pass', 'Student Password', 'trim|min_length[6]');
	$this->form_validation->set_rules('hid_student_pass', 'Current Student Password', 'trim|min_length[6]');
	$this->form_validation->set_rules('block_user', 'Block User', 'trim');
	$this->form_validation->set_rules('notification', 'School Notification Email', 'trim');


	// Only update passwords if new value entered. Otherwise leave them as is.
	// The new password will come via $this->input->post('admin_pass') or $this->input->post('student_pass')
	// The existing password will come via $this->input->post('hid_admin_pass') or $this->input->post('hid_student_pass')

	$admin_pass = ($this->input->post('admin_pass') == NULL) ? $this->input->post('hid_admin_pass') : md5($this->input->post('admin_pass'));
	$student_pass = ($this->input->post('student_pass') == NULL) ? $this->input->post('hid_student_pass') : md5($this->input->post('student_pass'));


	$data = array(
		'id' => $this->input->post('schoolUserID'),
		'name_first' => $this->input->post('name_first'),
		'name_last' => $this->input->post('name_last'),
		'email' => $this->input->post('email'),
		'phone' => $this->input->post('phone'),
		'admin_user' => $this->input->post('admin_user'),
		'admin_pass' => $admin_pass,
		'student_user' => $this->input->post('student_user'),
		'student_pass' => $student_pass,
		'block_user' => $this->input->post('block_user')
	);

	// Set up unencrypted passwords so they can be email and understood - before md5()
	$password = array(
		'admin_pass' => $this->input->post('admin_pass'),
		'student_pass' => $this->input->post('student_pass')
	);


	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		$this->subscribers_model->update_school_admin($data);
		echo '<div class="message_success">Record successfully updated!</div>';


		/**********************************************************************************************************/
		// Email notification to School Admin User (only if checkbox ticked)
		/**********************************************************************************************************/
		if($this->input->post('notification') == 'true')
		{
			//load email library
			$this->email->set_newline("\r\n");

			//assign values to vars
			$fullName = $data['name_first'] . ' ' . $data['name_last'];

			$email = $data['email'];

			$enquiry = 'Notification from eLearn Economics - School details:<br><br>';
			$enquiry = 'Please click here to go to the teacher login page: '.base_url().'main/login_teach<br>';
			$enquiry = 'Please note this is for teachers to view results of students whom have individual access, guest users will not be tracked<br>';
			$enquiry = 'Please click here to go to the student login page. Please note students and teachers wishing to view the student site log in as School Guest Members on the right hand side: '.base_url().'main/login<br><br>';
			$enquiry .= '<strong>Teacher Login Username: </strong>' . $data['admin_user'] . '<br>';
			$enquiry .= '<strong>Teacher Login Password: </strong>' . $password['admin_pass'] . '<br><br>';
			$enquiry .= '<strong>Student Login Username: </strong>' . $data['student_user'] . '<br>';
			$enquiry .= '<strong>Student Login Password: </strong>' . $password['student_pass'] . '<br>';

			//set to, from, subject, message
			$this->email->to($email, 'eLearn Economics');
			$this->email->cc('info@elearneconomics.com');
			$this->email->from('info@elearneconomics.com');
			$this->email->subject('eLearn Economics - School Admin Details');
			$this->email->message($enquiry);

			//send the email!!
			$this->email->send();

			//display any problems to screen
			//echo $this->email->print_debugger();
		}

		/**********************************************************************************************************/
		// ENDS
		/**********************************************************************************************************/


	} 
	else 
	{
		echo validation_errors('<div class="message_error">* ', '</div>');
	}

}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: view_access_codes()
// Populates form field to edit student details
/*************************************************************************************/
public function edit_student()
{
	$data['token'] = $this->auth->token();

	// Display list of Access Codes from selected school
	if($query = $this->subscribers_model->edit_student())
	{
		$data['student'] = $query;
	}

	$data['main_content'] = 'admin/subscribers/edit_student';
	$this->load->view('admin/includes/template', $data);
}
    
    
    
/*************************************************************************************/
// FUNCTION NAME :: update_student()
// Updates student details to the database
/*************************************************************************************/
public function update_student()
{
	$this->form_validation->set_rules('token', 'Token', 'trim|required');
	$this->form_validation->set_rules('studentID', 'Student ID', 'trim|required');
	$this->form_validation->set_rules('schoolID', 'School', 'trim|required');
	$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
	$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
	$this->form_validation->set_rules('blockUser', 'Block User', 'trim');
	$this->form_validation->set_rules('notes', 'Notes', 'trim');

	$data = array(
		'studentID' => $this->input->post('studentID'),
		'schoolID' => $this->input->post('schoolID'),
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'email' => $this->input->post('email'),
		'blockUser' => $this->input->post('blockUser'),
		'notes' => $this->input->post('notes')
	);

	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		$this->subscribers_model->update_student($data);
		echo '<div class="message_success">Record successfully updated!</div>';
	} 
	else 
	{
		echo validation_errors('<div class="message_error">* ', '</div>');
	}
}
    
        

} // END Subscribers_con class