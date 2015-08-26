<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audiovideo_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin/audiovideo_model');
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
	// AUDIO VIDEO ADMIN SECTION
	//
	/************************************************************************************************************************************************************************/
	
	/*************************************************************************************/
	// Displays the text (CK Editor) editor ready to insert a new record
	/*************************************************************************************/
	function load_editor()
	{
		$data['token'] = $this->auth->token();
		$data['title'] = get_topic_title( $this->uri->segment(3) ); // See content_helper
		
		$data['main_content'] = 'admin/content/add_audio_video';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	} //ENDS load_editor()
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_audio_video()
	// Adds new Audio Video record
	/*************************************************************************************/
	public function add_audio_video()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('topicID', 'Topic ID', 'trim|required');
		$this->form_validation->set_rules('fileName', 'Video File', 'trim|required');
		$this->form_validation->set_rules('on_off', 'On Off', 'trim|required');
		
		$data = array(
			'topicID' => $this->input->post('topicID'),
			'fileName' => $this->input->post('fileName'),
			'on_off' => $this->input->post('on_off')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->audiovideo_model->add_audio_video($data);
			echo $this->update_text_message = '<div class="message_success">New Record successfully added!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_audio_video()
	// Directs to page allowing editing of Audio Video
	/*************************************************************************************/
	public function get_audio_video()
	{
		// Display Key Note record to be edited
		if($query = $this->audiovideo_model->get_audio_video())
		{
			$data['audio_video'] = $query;
		}
		
		$data['title'] = get_topic_title( $this->uri->segment(4) ); // See content_helper
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/content/edit_audio_video';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_audio_video()
	// Updates the Audio Video record
	/*************************************************************************************/
	public function update_audio_video()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('fileName', 'Video File', 'trim|required');
		$this->form_validation->set_rules('on_off', 'On Off', 'trim|required');
		
		$data = array(
			'id' => $this->input->post('id'),
			'fileName' => $this->input->post('fileName'),
			'on_off' => $this->input->post('on_off')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->audiovideo_model->update_audio_video($data);
			echo $this->update_text_message = '<div class="message_success">Record successfully updated!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_audio_video()
	// Deletes an Audio Video record
	/*************************************************************************************/
	public function delete_audio_video()
	{
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		
		if($this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->audiovideo_model->delete_audio_video();
			$this->delete_message = '<div class="message_success">Item successfully deleted!</div>';
		}
		redirect($this->session->userdata('url'));
		
	}
	
		
	

} // END Audiovideo_con class