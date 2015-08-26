<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Multichoice_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin/multichoice_model');
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
	// MULTI CHOICE ADMIN SECTION
	//
	/************************************************************************************************************************************************************************/
	
	/*************************************************************************************/
	// Displays the text (CK Editor) editor ready to insert a new record
	/*************************************************************************************/
	function load_editor()
	{
		$data['token'] = $this->auth->token();
		$data['title'] = get_topic_title( $this->uri->segment(3) ); // See content_helper
		
		$data['main_content'] = 'admin/content/add_multi_choice';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	} //ENDS load_editor()
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_multi_choice()
	// Adds new Multi Choice record
	/*************************************************************************************/
	public function add_multi_choice()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('topicID', 'Topic ID', 'trim|required');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('opt1', 'Option 1', 'trim|required');
		$this->form_validation->set_rules('opt2', 'Option 2', 'trim|required');
		$this->form_validation->set_rules('opt3', 'Option 3', 'trim|required');
		$this->form_validation->set_rules('opt4', 'Option 4', 'trim|required');
		$this->form_validation->set_rules('answer', 'Answer', 'trim|required');
		$this->form_validation->set_rules('reason', 'Reason', 'trim');
		$this->form_validation->set_rules('image', 'Image', 'trim');
		$this->form_validation->set_rules('on_off', 'On Off', 'trim|required');
		
		// Find out which 'opt' with be used as the $answer 
		switch ( $this->input->post('answer') ){
			case 1:
				$answer = $this->input->post('opt1');
				break;
			case 2:
				$answer = $this->input->post('opt2');
				break;
			case 3:
				$answer = $this->input->post('opt3');
				break;
			case 4:
				$answer = $this->input->post('opt4');
				break;
		}
		
		$data = array(
			'topicID' => $this->input->post('topicID'),
			'question' => $this->input->post('question'),
			'opt1' => $this->input->post('opt1'),
			'opt2' => $this->input->post('opt2'),
			'opt3' => $this->input->post('opt3'),
			'opt4' => $this->input->post('opt4'),
			'answer' => $answer,
			'reason' => $this->input->post('reason'),
			'image' => $this->input->post('image'),
			'on_off' => $this->input->post('on_off')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->multichoice_model->add_multi_choice($data);
			echo $this->update_text_message = '<div class="message_success">New Record successfully added!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_multi_choice()
	// Directs to page allowing editing of Key Notes
	/*************************************************************************************/
	public function get_multi_choice()
	{
		// Display Key Note record to be edited
		if($query = $this->multichoice_model->get_multi_choice())
		{
			$data['multi_choice'] = $query;
		}
		
		$data['title'] = get_topic_title( $this->uri->segment(4) ); // See content_helper
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/content/edit_multi_choice';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_multi_choice()
	// Updates the Multi Choice record
	/*************************************************************************************/
	public function update_multi_choice()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('opt1', 'Option 1', 'trim|required');
		$this->form_validation->set_rules('opt2', 'Option 2', 'trim|required');
		$this->form_validation->set_rules('opt3', 'Option 3', 'trim|required');
		$this->form_validation->set_rules('opt4', 'Option 4', 'trim|required');
		$this->form_validation->set_rules('answer', 'Answer', 'trim|required');
		$this->form_validation->set_rules('reason', 'Reason', 'trim');
		$this->form_validation->set_rules('image', 'Image', 'trim');
		$this->form_validation->set_rules('on_off', 'On Off', 'trim|required');
		
		// Find out which 'opt' with be used as the $answer 
		switch ( $this->input->post('answer') ){
			case 1:
				$answer = $this->input->post('opt1');
				break;
			case 2:
				$answer = $this->input->post('opt2');
				break;
			case 3:
				$answer = $this->input->post('opt3');
				break;
			case 4:
				$answer = $this->input->post('opt4');
				break;
		}
		
		$data = array(
			'id' => $this->input->post('id'),
			'question' => $this->input->post('question'),
			'opt1' => htmlentities($this->input->post('opt1')),
			'opt2' => htmlentities($this->input->post('opt2')),
			'opt3' => htmlentities($this->input->post('opt3')),
			'opt4' => htmlentities($this->input->post('opt4')),
			'answer' => htmlentities($answer),
			'reason' => $this->input->post('reason'),
			'image' => $this->input->post('image'),
			'on_off' => $this->input->post('on_off')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->multichoice_model->update_multi_choice($data);
			echo $this->update_text_message = '<div class="message_success">Record successfully updated!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_multi_choice()
	// Deletes an Multi Choice record
	/*************************************************************************************/
	public function delete_multi_choice()
	{
		$data = array();
		
		$this->multichoice_model->delete_multi_choice();
		$this->delete_message = '<div class="message_success">Item successfully deleted!</div>';
		redirect($this->session->userdata('url'));
		
	}
	
		
	

} // END Multichoice_con class