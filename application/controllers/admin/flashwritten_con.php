<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flashwritten_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin/flashwritten_model');
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: is_logged_in()
	// Checks to see if admin is already logged in
	// If not - send them to the login page again
	/*************************************************************************************/
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');	
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			redirect('admin/login_con', 'refresh');
		}
		
	}
		
	
	
	/************************************************************************************************************************************************************************/
	//
	// FLASH WRITTEN ADMIN SECTION
	//
	/************************************************************************************************************************************************************************/
	
	/*************************************************************************************/
	// Displays the text (CK Editor) editor ready to insert a new record
	/*************************************************************************************/
	function load_editor()
	{
		$data['token'] = $this->auth->token();
		$data['title'] = get_topic_title( $this->uri->segment(3) ); // See content_helper
		
		$data['main_content'] = 'admin/content/add_flash_written';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	} //ENDS load_editor()
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_flash_written()
	// Adds new Flash Written record
	/*************************************************************************************/
	public function add_flash_written()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('topicID', 'Topic ID', 'trim|required');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('answer', 'Answer', 'trim|required');
		$this->form_validation->set_rules('image', 'Image', 'trim');
		$this->form_validation->set_rules('on_off', 'On Off', 'trim|required');
		
		$data = array(
			'topicID' => $this->input->post('topicID'),
			'question' => $this->input->post('question'),
			'answer' => $this->input->post('answer'),
			'image' => $this->input->post('image'),
			'on_off' => $this->input->post('on_off')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->flashwritten_model->add_flash_written($data);
			echo $this->update_text_message = '<div class="message_success">New Record successfully added!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_flashwritten()
	// Directs to page allowing editing of Key Notes
	/*************************************************************************************/
	public function get_flash_written()
	{
		// Display Key Note record to be edited
		if($query = $this->flashwritten_model->get_flash_written())
		{
			$data['flash_written'] = $query;
		}

		$data['title'] = get_topic_title( $this->uri->segment(4) ); // See content_helper
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/content/edit_flash_written';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_flash_written()
	// Updates the Flash Written record
	/*************************************************************************************/
	public function update_flash_written()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('answer', 'Answer', 'trim|required');
		$this->form_validation->set_rules('image', 'Image', 'trim');
		$this->form_validation->set_rules('on_off', 'On Off', 'trim|required');
		
		$data = array(
			'id' => $this->input->post('id'),
			'question' => $this->input->post('question'),
			'answer' => $this->input->post('answer'),
			'image' => $this->input->post('image'),
			'on_off' => $this->input->post('on_off')
		);

		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->flashwritten_model->update_flash_written($data);
			echo $this->update_text_message = '<div class="message_success">Record successfully updated!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_flash_written()
	// Deletes an Flash Written record
	/*************************************************************************************/
	public function delete_flash_written()
	{
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		
		if($this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->flashwritten_model->delete_flash_written();
			$this->delete_message = '<div class="message_success">Item successfully deleted!</div>';
		}
		redirect($this->session->userdata('url'));
		
	}
	
		
	

} // END Flashwritten_con class