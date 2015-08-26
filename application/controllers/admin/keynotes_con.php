<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keynotes_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin/keynotes_model');
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
	// KEY NOTES ADMIN SECTION
	//
	/************************************************************************************************************************************************************************/
	
	/*************************************************************************************/
	// Displays the text (CK Editor) editor ready to insert a new article
	/*************************************************************************************/
	function load_editor()
	{
		$data['token'] = $this->auth->token();
		$data['title'] = get_topic_title( $this->uri->segment(3) ); // See content_helper
		
		$data['main_content'] = 'admin/content/add_key_notes';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	} //ENDS load_editor()
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_key_notes()
	// Adds new Key Note(s)
	/*************************************************************************************/
	public function add_key_notes()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('topicID', 'Topic ID', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Body', 'trim|required');
		$this->form_validation->set_rules('on_off', 'On Off', 'trim|required');
		
		$data = array(
			'topicID' => $this->input->post('topicID'),
			'content' => $this->input->post('bodyContent'),
			'on_off' => $this->input->post('on_off')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->keynotes_model->add_key_notes($data);
			echo $this->update_text_message = '<div class="message_success">New Record successfully added!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_key_notes()
	// Directs to page allowing editing of Key Notes
	/*************************************************************************************/
	public function get_key_notes()
	{
		// Display Key Note record to be edited
		if($query = $this->keynotes_model->get_key_notes())
		{
			$data['key_notes'] = $query;
		}
		
		$data['title'] = get_topic_title( $this->uri->segment(4) ); // See content_helper
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/content/edit_key_notes';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_key_notes()
	// Updates the Key Note(s)
	/*************************************************************************************/
	public function update_key_notes()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Body', 'trim|required');
		$this->form_validation->set_rules('on_off', 'On Off', 'trim|required');
		
		$data = array(
			'id' => $this->input->post('id'),
			'content' => $this->input->post('bodyContent'),
			'on_off' => $this->input->post('on_off')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->keynotes_model->update_key_notes($data);
			echo $this->update_text_message = '<div class="message_success">Record successfully updated!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_key_notes()
	// Deletes an Key Notes record
	/*************************************************************************************/
	public function delete_key_notes()
	{
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		
		if($this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->keynotes_model->delete_key_notes();
			$this->delete_message = '<div class="message_success">Item successfully deleted!</div>';
		}
		redirect($this->session->userdata('url'));
		
	}
	
	
		
	

} // END Keynotes_con class