<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teachers extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('site/teachers_model');
		$this->load->model('site/teachersPDF_model');
		$this->load->model('site/section_model');
		$this->load->model('site/results_model');
		$data['site_name'] = $this->config->item( 'site_name' );
		$this->load->vars( $data );
		$this->logged_in_admin();
	}


	/*************************************************************************************/
	// FUNCTION NAME :: logged_in_admin()
	// Checks to see if student user is currently logged in
	// If not - send them to the login page again
	/*************************************************************************************/
	function logged_in_admin()
	{
		$logged_in_admin = $this->session->userdata('logged_in_admin');	
		if( ! isset( $logged_in_admin ) || $logged_in_admin != true )
		{
			redirect('main/login_admin', 'refresh');
		}
	}



	/*************************************************************************************/
	// FUNCTION NAME :: set_class()
	// When a teacher selects a 'class' this will create a session
	// WHY? So the teacher doesn't have to repeatedly select a class for each of the admin reporting / editing functions!
	/*************************************************************************************/
	function set_class()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('classID', 'Class Name', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
		{
			// Create array of data we need for the new 'session' var
			$data = array(
				'classID' => $this->input->post('classID'),
				'url_name' => $this->input->post('current_URL')
			);

			// Create new 'session' var
			$this->session->set_userdata($data);
		}

		//redirect('/login/form/', 'refresh');
		//redirect('teachers/view_month', 'refresh' );
		redirect('teachers/' . $this->session->userdata('url_name') );
		
	}









	/*************************************************************************************************************************************************************************/

	// SECTION BELOW IS FOR RETRIEVING AND DISPLAYING RESULTS FOR THE TEACHER

	/*************************************************************************************************************************************************************************/
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: view_month()
	// Displays the Teacher Start page to view results by month
	// This will display ALL results for a single class / single topic / single month
	/*************************************************************************************/
	public function view_month()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		//$this->form_validation->set_rules('classID', 'Class Name', 'trim|required');
		$this->form_validation->set_rules('topic', 'Topic', 'trim|required');
		$this->form_validation->set_rules('month', 'Month', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
		{
			// This will display ALL results for a single class / single topic / selected month
			if($query = $this->teachers_model->class_topic_results())
			{
				$data['results'] = $query;
				$data['topic'] = topic_label(); // To display the Current Topic Name / Label
			}
			else
			{
				// If no results - display as error message
				$data['error'] = '<div class="message_error">NO RESULTS FOUND!</div>';
			}

		}
		else
		{
			$data['error'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/teachers/screen_month';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: view_student()
	// Displays the Teacher Start page to view results by student
	// This will display ALL results for a single class / single topic / single month
	/*************************************************************************************/
	public function view_student()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('month', 'Month', 'trim|required');
		$this->form_validation->set_rules('order', 'Order', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
		{
			// NEED $this->form_validation->run() for the sticky form values to work
			$data['topic'] = topic_label(); // To display the Current Topic Name / Label

		}

		// Displays ALL the results for a single student in ALL topics for current month
		if($query = $this->teachers_model->single_student_results())
		{
			$data['single_student'] = $query;
		}
		else
		{
			// If no results - display as error message
			$data['error'] = '<div class="message_error">NO RESULTS FOUND FOR THIS PERIOD!</div>';
		}

		// Returns details about a single student. Useful for displayng their name etc
		if($query = $this->teachers_model->single_student_details())
		{
			$data['student_details'] = $query;
		}

		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/teachers/screen_student';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: show_class_students()
	// Show FULL student name list from selected school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
	/*************************************************************************************/
	public function show_class_students()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
		{
			// Show FULL student name list from selected school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
			if($query = $this->teachers_model->show_class_students())
			{
				$data['students'] = $query;
			}

			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/teachers/screen_student';
			$this->load->view('site/includes/template', $data);
			
		}
		else
		{
			$data['error2'] = validation_errors('<div class="message_error">* ', '</div>');

			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/teachers/screen_month';
			$this->load->view('site/includes/template', $data);
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: results_by_topic()
	// Displays ALL results for a single selected topic - for 12 months
	/*************************************************************************************/
	function results_by_topic()
	{
		$data = array();

		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('topic', 'Topic', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$data['topic'] = topic_label(); // To display the Current Topic Name / Label

			// Get results for a selected topic
			if($query = $this->teachers_model->results_by_topic())
			{
				$data['topic_results'] = $query;
			}
			else
			{
				// If no results - display as error message
				$data['error2'] = '<div class="message_error">NO RESULTS FOUND FOR THIS TOPIC!</div>';
			}

			// Returns details about a single student. Useful for displayng their name etc
			if($query = $this->teachers_model->single_student_details())
			{
				$data['student_details'] = $query;
			}
		} 
		else
		{
			$data['topic_error'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/teachers/screen_student';
		$this->load->view('site/includes/template', $data);
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: refresh_class_students()
	// Refreshes FULL student name list from selected school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
	// This allows us to continually switch between different student names
	/*************************************************************************************/
	public function refresh_class_students()
	{
		// Show FULL student name list from selected school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
		if($query = $this->teachers_model->show_class_students())
		{
			$data['students'] = $query;
		}

		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/teachers/screen_student';
		$this->load->view('site/includes/template', $data);
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: refresh_class_students_print()
	// Refreshes FULL student name list from selected school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
	// This allows us to continually switch between different student names
	/*************************************************************************************/
	public function refresh_class_students_print()
	{
		// Show FULL student name list from selected school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
		if($query = $this->teachers_model->show_class_students())
		{
			$data['students'] = $query;
		}

		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/teachers/print_student';
		$this->load->view('site/includes/template', $data);
		
	}














	/*************************************************************************************************************************************************************************/
	// SECTION BELOW IS FOR TEACHER ADMIN PDF PRINT FUNCTIONS
	// SECTION BELOW IS FOR TEACHER ADMIN PDF PRINT FUNCTIONS
	// SECTION BELOW IS FOR TEACHER ADMIN PDF PRINT FUNCTIONS
	/*************************************************************************************************************************************************************************/


	/*************************************************************************************/
	// FUNCTION NAME :: view_month_print()
	// Displays the Teacher Start page to view results by month
	// This will display ALL results for a single class / single topic / single month
	/*************************************************************************************/
	public function view_month_print()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('classID', 'Class Name', 'trim|required');
		$this->form_validation->set_rules('topic', 'Topic', 'trim|required');
		$this->form_validation->set_rules('month', 'Month', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
		{
			// This will display ALL results for a single class / single topic / selected month
			if($query = $this->teachers_model->class_topic_results())
			{
				$data['results'] = $query;
				$data['topic'] = topic_label(); // To display the Current Topic Name / Label
			}
			else
			{
				// If no results - display as error message
				$data['error'] = '<div class="message_error">NO RESULTS FOUND!</div>';
			}

		}
		else
		{
			$data['error'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/teachers/print_month';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: view_student_print()
	// Displays the Teacher Start page to view results by student
	// This will display ALL results for a single class / single topic / single month
	/*************************************************************************************/
	public function view_student_print()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('month', 'Month', 'trim|required');
		$this->form_validation->set_rules('order', 'Order', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
		{
			// NEED $this->form_validation->run() for the sticky form values to work
			$data['topic'] = topic_label(); // To display the Current Topic Name / Label

		}

		// Displays ALL the results for a single student in ALL topics for current month
		if($query = $this->teachers_model->single_student_results())
		{
			$data['single_student'] = $query;
		}
		else
		{
			// If no results - display as error message
			$data['error'] = '<div class="message_error">NO RESULTS FOUND!</div>';
		}

		// Returns details about a single student. Useful for displayng their name etc
		if($query = $this->teachers_model->single_student_details())
		{
			$data['student_details'] = $query;
		}

		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'site/teachers/print_student';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: show_class_students_print()
	// Show FULL student name list from selected school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
	/*************************************************************************************/
	public function show_class_students_print()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
		{
			// Show FULL student name list from selected school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
			if($query = $this->teachers_model->show_class_students())
			{
				$data['students'] = $query;
			}

			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/teachers/print_student';
			$this->load->view('site/includes/template', $data);
			
		}
		else
		{
			$data['error2'] = validation_errors('<div class="message_error">* ', '</div>');

			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/teachers/print_month';
			$this->load->view('site/includes/template', $data);
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: results_by_topic_print()
	// Displays ALL results for a single selected topic - for 12 months
	/*************************************************************************************/
	function results_by_topic_print()
	{
		$data = array();

		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('topic', 'Topic', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$data['topic'] = topic_label(); // To display the Current Topic Name / Label

			// Get results for a selected topic
			if($query = $this->teachers_model->results_by_topic())
			{
				$data['topic_results'] = $query;
			}

			// Returns details about a single student. Useful for displayng their name etc
			if($query = $this->teachers_model->single_student_details())
			{
				$data['student_details'] = $query;
			}
		} 
		else
		{
			$data['topic_error'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/teachers/print_student';
		$this->load->view('site/includes/template', $data);
		
	}

















	/*************************************************************************************************************************************************************************/

	// SECTION BELOW IS FOR TEACHER ADMIN WHEN THEY ARRANGE STUDENTS INTO CLASS GROUPS

	/*************************************************************************************************************************************************************************/


	/*************************************************************************************/
	// FUNCTION NAME :: show_students()
	// Displays the full list of students within the current school to they can be selected and placed into class groups.
	/*************************************************************************************/
	public function show_students()
	{
		// Get ALL students from current school (i.e., Rosmini College)
		if($query = $this->teachers_model->show_students())
		{
			$data['students'] = $query;
		}

		$data['token'] = $this->auth->token();

		$data['main_content'] = 'site/teachers/group_students';
		$this->load->view('site/includes/template', $data);
	}


	/*************************************************************************************/
	// FUNCTION NAME :: show_students_edit()
	// Displays the full list of students within the current school to they can be selected for editing class groups.
	/*************************************************************************************/
	public function show_students_edit()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('classID', 'Select Class', 'trim|required');

		$this->session->set_userdata('class_id', $this->input->post('classID'));

		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			// Get ALL students from current school (i.e., Rosmini College)
			if($query = $this->teachers_model->show_students())
			{
				$data['students'] = $query;
			}

			$data['token'] = $this->auth->token();

			$data['main_content'] = 'site/teachers/group_students';
			$this->load->view('site/includes/template', $data);
		}
		else
		{
			$data['error'] = validation_errors('<div class="message_error">* ', '</div>');

			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/teachers/class_options';
			$this->load->view('site/includes/template', $data);
		}

	}


	/*************************************************************************************/
	// FUNCTION NAME :: create_class()
	// Creates a new class group for a school
	/*************************************************************************************/
	public function create_class()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('class_name', 'Create Class', 'trim|required|is_unique[mem_classes.class_name]');

		$data = array(
			'schoolID' => $this->session->userdata('schoolID'),
			'class_name' => $this->input->post('class_name')
		);

		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->teachers_model->create_class($data);
			$data['message'] = $this->update_text_message = '<div class="message_success">New class successfully created!</div>';

			// Create session var for 'Class Name'
			$this->session->set_userdata('class_name', $data['class_name']);
			redirect('teachers/show_students');
		} 
		else 
		{
			$data['message'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/teachers/class_options';
		$this->load->view('site/includes/template', $data);
	}


	/*************************************************************************************/
	// FUNCTION NAME :: rename_class()
	// Renames an existing class
	/*************************************************************************************/
	public function rename_class()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('classID', 'Select Class', 'trim|required');
		$this->form_validation->set_rules('newclass_name', 'Rename Class', 'trim|required|is_unique[mem_classes.class_name]');

		$data = array(
			'id' => $this->input->post('classID'),
			'class_name' => $this->input->post('newclass_name')
		);

		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->teachers_model->rename_class($data);
			$data['message'] = $this->update_text_message = '<div class="message_success">Class successfully renamed!</div>';

			// Create session var for 'Class Name'
			$this->session->set_userdata('class_name', $data['class_name']);
			redirect('teachers/show_students');
		} 
		else 
		{
			$data['message'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/teachers/group_students';
		$this->load->view('site/includes/template', $data);
	}


	/*************************************************************************************/
	// FUNCTION NAME :: group_students()
	// Moves students into a selected class group
	/*************************************************************************************/
	public function group_students()
	{
		if($this->input->post('studentID'))
		{
			//Loop through codeID rows (id's) and assign them to var $id
			foreach($this->input->post('studentID') as $studentID):

				$data = array(
					'studentID' => $studentID,
					'classID' => $this->session->userdata('class_id')
				);

				$this->teachers_model->group_students($data);

			endforeach;

			$data['error'] = '<div class="message_success">Students successfully moved!</div>';
			
			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/teachers/class_options';
			$this->load->view('site/includes/template', $data);
		}
		else
		{
			$data['error'] = '<div class="message_error">No students were selected!</div>';

			$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/teachers/class_options';
			$this->load->view('site/includes/template', $data);
		}

	}




	/*************************************************************************************************************************************************************************/

	// SECTION BELOW IS FOR TEACHER ADMIN WHEN THEY ARE SETTING CLASS MESSAGES (SPECIFIC TO EACH CLASS)

	/*************************************************************************************************************************************************************************/


	/*************************************************************************************/
	// FUNCTION NAME :: set_class_message()
	// Teacher stes a class message to be displayed when students of his/her class log in
	/*************************************************************************************/
	public function class_message_form()
	{
		// Get the current message to this class
		if($query = $this->teachers_model->get_class_message())
		{
			$data['class_message'] = $query;
		}

		$data['token'] = $this->auth->token();

		$data['main_content'] = 'site/teachers/set_message';
		$this->load->view('site/includes/template', $data);
	}


	
	/*************************************************************************************/
	// FUNCTION NAME :: update_class_message()
	// Updates the current class message for this class
	/*************************************************************************************/
	public function update_class_message()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('class_message', 'Message', 'trim');
		
		$data = array(
			'id' => $this->session->userdata('classID'),
			'message' => $this->input->post('class_message')
		);
		
		// If form validates -> add new (message) record to database and/or initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			if( $this->teachers_model->update_class_message($data) );
			$data['message'] = '<div class="message_success">Class message successfully set!</div>';
		} 
		else 
		{
			$data['message'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		// Get the current message to this class
		if( $query = $this->teachers_model->get_class_message() )
		{
			$data['class_message'] = $query;
		}

		// Send them back to the message form page
		$data['token'] = $this->auth->token();

		$data['main_content'] = 'site/teachers/set_message';
		$this->load->view('site/includes/template', $data);
		
	}
	
		

} // END Teachers class