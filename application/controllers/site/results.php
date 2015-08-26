<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Results extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('site/results_model');
		$this->load->model('site/section_model');
		$data['site_name'] = $this->config->item( 'site_name' );
		$this->load->vars( $data );
		$this->logged_in();
	}



	/*************************************************************************************/
	// FUNCTION NAME :: logged_in()
	// Checks to see if student user is currently logged in
	// If not - send them to the login page again
	/*************************************************************************************/
	function logged_in()
	{
		$logged_in_admin = $this->session->userdata('logged_in_admin');	// Teacher is logged in
		$logged_in = $this->session->userdata('logged_in');	 // Student is logged in
		// if( ! isset( $logged_in ) || $logged_in != true )
		if( ! isset( $logged_in ) || $logged_in != true and ! isset( $logged_in_admin ) || $logged_in_admin != true ) // Either a teacher or student is NOT logged in
		{
			redirect('main/login', 'refresh');
		}
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: index()
	// xxxxxxx
	/*************************************************************************************/
	function view_progress()
	{
		$data = array();
		$data['token'] = $this->auth->token();
		$data['topic'] = topic_label();

		$data['main_content'] = 'site/results/results_student';
		$this->load->view('site/includes/template', $data);
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
			$data['token'] = $this->auth->token();

			// Get results for a selected topic
			if($query = $this->results_model->results_by_topic())
			{
				$data['results'] = $query;
			}
		} 
		else
		{
			$data['token'] = $this->auth->token();
			$data['topic_error'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['topic'] = topic_label();
		$data['main_content'] = 'site/results/results_student';
		$this->load->view('site/includes/template', $data);
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: results_by_month()
	// Displays ALL results for topics studied by selected month
	/*************************************************************************************/
	function results_by_month()
	{
		$data = array();

		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('month', 'Month', 'trim|required');
		$this->form_validation->set_rules('order', 'Order By', 'trim|required');

		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$data['token'] = $this->auth->token();

			// Get results for a selected topic
			if( $query = $this->results_model->results_by_month() )
			{
				$data['months'] = $query;
			}
		} 
		else
		{
			$data['token'] = $this->auth->token();
			$data['month_error'] = validation_errors('<div class="message_error">* ', '</div>');
		}

		$data['topic'] = topic_label();
		$data['main_content'] = 'site/results/results_student';
		$this->load->view('site/includes/template', $data);
		
	}


	/*******************************************************************************************************************************************************************/
	// Functions for the OVERALL Leaderboards - both School and National Level
	/*******************************************************************************************************************************************************************/
	/*************************************************************************************/
	// FUNCTION NAME :: leaders_school()
	// Displays leading topic results for students school
	/*************************************************************************************/
	function leaders_school()
	{
		
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('topic', 'Select Topic', 'trim|required');

		if( ($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) or $this->uri->segment(3))
		{
			
			// Create month arrays => NOTE reverse order, as we want to show results from oldest to newest
			$month = array('Dec', 'Nov', 'Oct', 'Sep', 'Aug', 'Jul', 'Jun', 'May', 'Apr', 'Mar', 'Feb', 'Jan');
			$n_month = array('n_Dec', 'n_Nov', 'n_Oct', 'n_Sep', 'n_Aug', 'n_Jul', 'n_Jun', 'n_May', 'n_Apr', 'n_Mar', 'n_Feb', 'n_Jan');

			
			// Loop through and query the database for each $month[$i]
			for ($i = 0, $num = count($month); $i < $num; $i++):

				// Get results for a selected topic
				if($query = $this->results_model->leaders_school( $month[$i] ))
				{
					// Store results in a using [$i]
					$data['results_school'][$i] = $query;
				}

			endfor;


			// Loop through and query the database for each $month[$i]
			for ($i = 0, $num = count($month); $i < $num; $i++):

				// Get results for a selected topic
				if($query = $this->results_model->leaders_national( $month[$i] ))
				{
					// Store results in a using [$i]
					$data['results_national'][$i] = $query;
				}

			endfor;


			// Get results for a selected topic
			// if($query = $this->results_model->leaders_national())
			// {
			// 	$data['results_national'] = $query;
			// }

			$data['topic'] = topic_label();
			$data['school_name'] = school_label();
		}
		else
		{
			$data['topic_error'] = validation_errors('<div class="message_error">* ', '</div>');
		}
		


		$data['token'] = $this->auth->token();

		$data['topic'] = topic_label();
		$data['main_content'] = 'site/results/results_leaders';
		$this->load->view('site/includes/template', $data);
	}
	
	

	
	

} // END Results class