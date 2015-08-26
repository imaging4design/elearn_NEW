<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin/general_model');
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
	// FUNCTION show_faqs()
	// Displays a list of all the FAQs
	/*************************************************************************************/
	public function show_faqs()
	{
		// Remember the current URL so we can return to it if admin 'Deletes' a record
		$this->session->set_userdata('url', current_url());
		
		// Display FAQs to be edited
		if($query = $this->general_model->show_faqs())
		{
			$data['faqs'] = $query;
		}
		
		$data['main_content'] = 'admin/general/view_faqs';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION load_editor()
	// Loads the editor to add a new FAQ
	/*************************************************************************************/
	function load_editor()
	{
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/general/add_faqs';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	} //ENDS load_editor()
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_faqs()
	// Adds new FAQ
	/*************************************************************************************/
	public function add_faqs()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Answer', 'trim|required');
		
		$data = array(
			'question' => $this->input->post('question'),
			'answer' => $this->input->post('bodyContent')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->general_model->add_faqs($data);
			echo $this->update_text_message = '<div class="message_success">New Record successfully added!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_faqs()
	// Directs to page allowing editing of FAQs
	/*************************************************************************************/
	public function get_faqs()
	{
		// Display Key Note record to be edited
		if($query = $this->general_model->get_faqs())
		{
			$data['faqs'] = $query;
		}
		
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/general/edit_faqs';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_faqs()
	// Updates the FAQs
	/*************************************************************************************/
	public function update_faqs()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('faqID', 'FAQ ID', 'trim|required');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Answer', 'trim|required');
		$this->form_validation->set_rules('order', 'Order', 'trim|required');
		
		$data = array(
			'id' => $this->input->post('faqID'),
			'question' => $this->input->post('question'),
			'answer' => $this->input->post('bodyContent'),
			'order' => $this->input->post('order')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->general_model->update_faqs($data);
			echo $this->update_text_message = '<div class="message_success">Record successfully updated!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_faqs()
	// Deletes an FAQ record
	/*************************************************************************************/
	public function delete_faqs()
	{
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		
		if($this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->general_model->delete_faqs();
			$this->delete_message = '<div class="message_success">Item successfully deleted!</div>';
		}
		redirect($this->session->userdata('url'));
		
	}



	/*************************************************************************************/
	// FUNCTION view_latest_news()
	// Displays a list of all the Latest News
	/*************************************************************************************/
	public function view_latest_news()
	{
		// Remember the current URL so we can return to it if admin 'Deletes' a record
		$this->session->set_userdata('url', current_url());
		
		// Display FAQs to be edited
		if($query = $this->general_model->view_latest_news())
		{
			$data['latest_news'] = $query;
		}

		//echo $this->session->userdata('url');
		
		$data['main_content'] = 'admin/general/view_latest_news';
		$this->load->view('admin/includes/template', $data);
		
	}



	/*************************************************************************************/
	// FUNCTION load_news_editor()
	// Loads the editor to add a new Latest News article
	/*************************************************************************************/
	function load_news_editor()
	{
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/general/add_news';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: add_news()
	// Adds new Latest News article
	/*************************************************************************************/
	public function add_news()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Body Content', 'trim|required');
		
		$data = array(
			'title' => $this->input->post('title'),
			'content' => $this->input->post('bodyContent'),
			'created_at' => date('Y-m-d')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->general_model->add_news($data);
			echo $this->update_text_message = '<div class="message_success">New Record successfully added!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: get_news()
	// Directs to page allowing editing of Latest News
	/*************************************************************************************/
	public function get_news()
	{
		// Display Key Note record to be edited
		if($query = $this->general_model->get_news())
		{
			$data['news'] = $query;
		}
		
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/general/edit_news';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: update_news()
	// Updates the Latest News Article
	/*************************************************************************************/
	public function update_news()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('newsID', 'News ID', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Content', 'trim|required');
		
		$data = array(
			'id' => $this->input->post('newsID'),
			'title' => $this->input->post('title'),
			'content' => $this->input->post('bodyContent'),
			'created_at' => date('Y-m-d')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->general_model->update_news($data);
			echo $this->update_text_message = '<div class="message_success">Record successfully updated!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: delete_news()
	// Deletes a Latest News Article record
	/*************************************************************************************/
	public function delete_news()
	{
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		
		if($this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->general_model->delete_news();
			$this->delete_message = '<div class="message_success">Item successfully deleted!</div>';
		}
		redirect($this->session->userdata('url'));
		
	}
	
	
	

} // END General_con class