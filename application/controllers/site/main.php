<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/subscribers_model');
		$this->load->model('site/results_model');
		$this->load->model('paypal/items_model', 'Item');
		$data['site_name'] = $this->config->item( 'site_name' );
		$this->load->vars( $data );
	}
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: index()
	// Displays the home page
	/*************************************************************************************/
	public function index()
	{
		// Fetch Latest News Artciles from database
		if($query = $this->main_model->news())
		{
			$data['news'] = $query;
		}

			
		// Display the total No. of tests completed by students to date
		if($query = $this->results_model->stats())
		{
			$data['stats'] = $query;
		}

		$jan = 'Jan';
		$feb = 'Feb';
		$mar = 'Mar';
		$apr = 'Apr';
		$may = 'May';
		$jun = 'Jun';
		$jul = 'Jul';
		$aug = 'Aug';
		$sep = 'Sep';
		$oct = 'Oct';
		$nov = 'Nov';
		$dec = 'Dec';


		$scores = array(
			$jan => 'n_Jan',
			$feb => 'n_Feb',
			$mar => 'n_Mar',
			$apr => 'n_Apr',
			$may => 'n_May',
			$jun => 'n_Jun',
			$jul => 'n_Jul',
			$aug => 'n_Aug',
			$sep => 'n_Sep',
			$oct => 'n_Oct',
			$nov => 'n_Nov',
			$dec => 'n_Dec'
		);


		$total = 0;
		$key = 0;

		// Loop through each month ...
		foreach ($scores as $key => $value) {

			if( isset( $data['stats'] )) {
				// Loop through each results for month
				foreach ($data['stats'] as $row) {
					$key = $row->$value + $key;
				}
			}

			$total = $key + $total;
			
		}

		//echo $total;
		$data['total'] = $total;

		// Get total number of registered users on site (direct method)
		// $data['num_users'] = $this->db->count_all('mem_students');

		$data['main_content'] = 'site/index';
		$this->load->view('site/includes/template', $data);
		
	}





	/*************************************************************************************/
	// FUNCTION NAME :: news()
	// Displays the Latest News page - intro snippets text only
	/*************************************************************************************/
	public function news()
	{
		// Fetch FAQs from database
		if($query = $this->main_model->all_news())
		{
			$data['news'] = $query;
		}
		
		$data['main_content'] = 'site/standard/news';
		$this->load->view('site/includes/template', $data);
		
	}

	/*************************************************************************************/
	// FUNCTION NAME :: news_full()
	// Displays the FULL news story
	/*************************************************************************************/
	public function news_full()
	{
		// Fetch FAQs from database
		if($query = $this->main_model->news_full())
		{
			$data['news_full'] = $query;
		}
		
		$data['main_content'] = 'site/standard/news_full';
		$this->load->view('site/includes/template', $data);
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: aboutUs()
	// Displays the About Us page
	/*************************************************************************************/
	public function aboutUs()
	{
		$data['main_content'] = 'site/standard/aboutUs';
		$this->load->view('site/includes/template', $data);
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: faqs()
	// Displays the FAQs page
	/*************************************************************************************/
	public function faqs()
	{
		// Fetch FAQs from database
		if($query = $this->main_model->faqs())
		{
			$data['faqs'] = $query;
		}
		
		$data['main_content'] = 'site/standard/faqs';
		$this->load->view('site/includes/template', $data);
		
	}
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: contact()
	// Displays the Contact Us page
	/*************************************************************************************/
	public function contact()
	{
		$data['main_content'] = 'site/standard/contact';
		$this->load->view('site/includes/template', $data);
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: contact()
	// Displays the Contact Us page
	/*************************************************************************************/
	public function terms()
	{
		$data['main_content'] = 'site/standard/terms';
		$this->load->view('site/includes/template', $data);
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: login()
	// Displays the Student Login Page with form
	/*************************************************************************************/
	public function login()
	{
		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/standard/login_student';
		$this->load->view('site/includes/template', $data);

		// Unset the failed login message so it doesn't remain
		$this->session->unset_userdata('login_attempt');
		$this->session->unset_userdata('login_attempt2');
	}


	/*************************************************************************************/
	// FUNCTION NAME :: login_admin()
	// Displays the Teacher Login Page with form
	/*************************************************************************************/
	public function login_admin()
	{
		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/standard/login_teach';
		$this->load->view('site/includes/template', $data);
	}


	/*************************************************************************************/
	// FUNCTION NAME :: login_member_student()
	// Validates the (MEMBER) Student Login
	/*************************************************************************************/
	public function login_member_student()
	{
		$query = $this->main_model->login_member_student();
		
		if($query && $this->input->post('token') == $this->session->userdata('token')) //If the users credentials validated...
		{

			$data = array(
				'member_type' => 'paid_member',
				'logged_in' => TRUE,
				'studentID' => $query->studentID,
				'first_name' => $query->first_name,
				'last_name' => $query->last_name,
				'schoolID' => $query->schoolID,
				'school' => $query->school,
				'courseID' => $query->courseID
			);
			
			// Set sussessful login details as session vars
			$this->session->set_userdata($data);
			//redirect('section/index', 'refresh'); //MAYBE AN ISSUE WITH THE REDIRECT FUCTION!!!!!!
			//redirect('section/index', 'location', 307);
			//redirect('section/index', 'location', 301);

			$data = array();
			$data['topics'] = show_topics(); // See admin_helper
			$data['subTopics'] = show_subTopics(); // See admin_helper
			$data['class_message'] = class_message(); // See section_helper (displays a custom teacher message to students)


			//$data['token'] = $this->auth->token();
			$data['main_content'] = 'site/sections/menu';
			$this->load->view('site/includes/template', $data);

		}
		else 
		{
			// Set error message via session var
			$this->session->set_userdata('login_attempt', 'fail');
			$this->login();
		}
	}


	/*************************************************************************************/
	// FUNCTION NAME :: login_guest_student()
	// Validates the (GUEST) Student Login
	/*************************************************************************************/
	public function login_guest_student()
	{
		$query = $this->main_model->login_guest_student();
		
		if($query && $this->input->post('token') == $this->session->userdata('token')) //If the users credentials validated...
		{
			$data = array(
				'member_type' => 'guest_member',
				'logged_in' => TRUE,
				'first_name' => 'guest',
				'last_name' => 'user',
				'schoolID' => $query->schoolID,
				'school' => $query->school
			);
			
			// Set sussessful login details as session vars
			$this->session->set_userdata($data);
			redirect('section/index');
		}
		else 
		{
			// Set error message via session var
			$this->session->set_userdata('login_attempt2', 'fail');
			$this->login();
		}
	}



	/*************************************************************************************/
	// FUNCTION NAME :: login_teach()
	// Displays the Teacher Login page
	/*************************************************************************************/
	public function login_teach()
	{
		$query = $this->main_model->login_teacher();

		if($query && $this->input->post('token') == $this->session->userdata('token')) //If the users credentials validated...
		{
			$data = array(
				'member_type' => 'teach admin',
				'logged_in_admin' => TRUE,
				'schoolID' => $query->schoolID,
				'school' => $query->school
			);
			
			// Set sussessful login details as session vars
			$this->session->set_userdata($data);
			// Unset the failed login message so it doesn't remain
			$this->session->unset_userdata('login_teach');

			redirect('teachers/view_month');
		}
		else 
		{
			// Set error message via session var
			$this->session->set_userdata('login_teach', 'fail');
			$this->login_admin();
		}
	}


	/*************************************************************************************/
	// FUNCTION NAME :: login_lostpass_form()
	// Displays the page for students to request new password if lost
	/*************************************************************************************/
	public function login_lostpass_form()
	{
		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/standard/login_lostpass';
		$this->load->view('site/includes/template', $data);
	}


	/*************************************************************************************/
	// FUNCTION NAME :: login_lostpass()
	// Processes the lost password form request and sends email
	/*************************************************************************************/
	public function login_lostpass()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('username', 'Username (Email)', 'trim|valid_email|required');

		$data = array(
			'username' => $this->input->post('username'),
		);

		// Create a random string to be emailed to user as part of security confirmation
		$random = array(
			'email' => $this->input->post('username'),
			'temp_code' => random_string('sha1')
		);

		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			// !!! Create a temp random string in database to be compared with when they return from email link
			$this->main_model->add_random_string($random);



			if($query = $this->main_model->vaildate_username())
			{

				/**********************************************************************************************************/
				// Email Reset Password Link to Student User
				/**********************************************************************************************************/

				//load email library
				$this->email->set_newline("\r\n");

				//assign values to vars
				$email = $data['username'];
				$message = '<strong>Dear eLearn Subscriber,</strong><br /><br />';
				$message .= '<strong>You have received this email because you requested a password reset for eLearn Economics.</strong><br /><br />';
				$message .= 'Please click this link to reset your password: ' . base_url() . 'main/reset_password/'.$random['temp_code'].'<br /><br />';
				$message .= '<strong>NOTE:</strong> If you have since remembered your password, please ignore this link - your existing password will remain in use.<br /><br />';
				$message .= 'Kind regards,<br />';
				$message .= 'eLearn Economics Support';

				//set to, from, subject, message
				$this->email->to($email, 'eLearn Economics');
				$this->email->from('info@elearneconomics.com');
				$this->email->subject('eLearn Economics - Password Reset');
				$this->email->message($message);

				//send the email!!
				$this->email->send();

				//display any problems to screen
				//echo $this->email->print_debugger();

				/**********************************************************************************************************/
				// ENDS Email
				/**********************************************************************************************************/

				echo '<div class="message_success">Thank you. A password reset link has been emailed to: ' . $data['username'] . '</div>';
			}
			else
			{
				echo '<div class="message_error">Sorry, we have no records matching that Username (Email)</div>';
			}
		}
		else
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
	}



	/*************************************************************************************/
	// FUNCTION NAME :: reset_password()
	// Sends user to a page from email link to change their password
	/*************************************************************************************/
	public function reset_password()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('temp_code', 'Confirmation error, please check your email link', 'trim|required');
		$this->form_validation->set_rules('username', 'Username (Email) required', 'trim|valid_email|required');
		$this->form_validation->set_rules('password', 'Password  required', 'trim|min_length[6]|required');
		$this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|matches[password]|required');

		$this->form_validation->set_message('required', '%s');  
		

		//Remember temp_code in $this->uri->segment(3)!
		if( $this->uri->segment(3) )
		{
			$this->session->set_userdata('temp_code', $this->uri->segment(3));
		}

		$data = array(
			'email' => $this->input->post('username'),
			'temp_code' => $this->session->userdata('temp_code'),
		);

		// If form validates ->
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			// Check to see if the 'temp_code' field matches the user email!
			if($query = $this->main_model->find_temp_code_match($data))
			{
				$data = array(
					'studentID' => $query->studentID,
					'temp_code' => '',
					'password' => md5($this->input->post('password'))
				);

				// If matches and all ok .. update user password and show link to login page
				$this->main_model->update_options($data);

				//Unset $this->session->userdata('temp_code')
				$this->session->unset_userdata('temp_code');
				// Display success message
				$data['error'] = '<div class="message_success">Your password has been successfully reset!</div>';
			}
			else
			{
				//$this->session->unset_userdata('temp_code');
				// Display error message if temp_code is NOT valid
				$data['error'] = '<div class="message_error">There has been a problem, please try again!</div>';
			}
			
		}
		else
		{
			//$this->form_validation->set_message('temp_code', 'Invalid %s');
			$data['error'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/standard/login_changepass';
		$this->load->view('site/includes/template', $data);

	}


	/*************************************************************************************/
	// FUNCTION NAME :: logout()
	// Logs any user OUT and returns them to the home page
	/*************************************************************************************/
	function logout()
	{
		$this->session->sess_destroy();
		redirect('');
	} 
		
	

} // END Main class