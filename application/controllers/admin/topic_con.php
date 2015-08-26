<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topic_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
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
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: index()
	// Directs user to the admin login page
	/*************************************************************************************/
	public function index()
	{
		$data['main_content'] = 'admin/admin_menu';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: show_topics()
	// Shows ALL available Topics AND Sub Topics as 3 or 4 column list
	/*************************************************************************************/
	public function show_topics()
	{
		$data = array();
		$data['topics'] = admin_show_topics(); // See admin_helper
		$data['subTopics'] = admin_show_subTopics(); // See admin_helper
		
		$data['main_content'] = 'admin/topics/topics';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_topics()
	// Allows admin to ADD a new Topic
	/*************************************************************************************/
	public function add_topics()
	{
		// Form Validation ...
		$this->form_validation->set_rules('topic_name', 'Topic Name', 'trim|required|is_unique[ad_topics.topic]');
		$this->form_validation->set_rules('level_name[]', 'Topic Level', 'trim|required');

		//Initialise $data
		$data = array();

		// If form validates -> add new record to database
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) {

			$data = array(
				'topic' => $this->input->post('topic_name'),
				'level_name' => implode(',', $this->input->post('level_name')) //implode array as comma deliminated list
			);
			
			$this->topic_model->add_topics($data);
			$data['token'] = $this->auth->token();
			$data['error'] = $this->insert_text_message = '<div class="message_success">Topic successfully inserted!</div>';
			
			$data['main_content'] = 'admin/topics/add_topics';
			$this->load->view('admin/includes/template', $data);
		}
		else
		{
			$data['token'] = $this->auth->token();
			$data['error'] = validation_errors('<div class="message_error">* ', '</div>');
		
			$data['main_content'] = 'admin/topics/add_topics';
			$this->load->view('admin/includes/template', $data);
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: edit_topics()
	// Allows admin to EDIT a Topic
	/*************************************************************************************/
	public function edit_topics()
	{
		// Form Validation ...
		$this->form_validation->set_rules('topicID', 'Topic ID', 'trim|required');
		$this->form_validation->set_rules('topic', 'Topic Name', 'trim|required');
		$this->form_validation->set_rules('level_name[]', 'Topic Level', 'trim|required');
		
		//Initialise $data
		$data = array();
	
		// If form validates -> add new record to database
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) {

			$data = array(
				'topicID' => $this->input->post('topicID'),
				'topic' => $this->input->post('topic'),
				'level_name' => implode(',', $this->input->post('level_name')) //implode array as comma deliminated list
			);
			
			$this->topic_model->edit_topics($data);
			$data['token'] = $this->auth->token();
			$data['error'] = $this->insert_text_message = '<div class="message_success">Topic successfully updated!</div>';
			
			// Dynamically find the Topic info and supply to edit_topics.php
			$data['find_topic'] = find_topic( $this->uri->segment(3) ); // See admin_helper
			
			$data['main_content'] = 'admin/topics/edit_topics';
			$this->load->view('admin/includes/template', $data);
		}
		else
		{
			$data['token'] = $this->auth->token();
			$data['error'] = validation_errors('<div class="message_error">* ', '</div>');
			
			// Dynamically find the Topic info and supply to edit_topics.php
			$data['find_topic'] = find_topic( $this->uri->segment(3) ); // See admin_helper
			
			$data['main_content'] = 'admin/topics/edit_topics';
			$this->load->view('admin/includes/template', $data);
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_subTopics()
	// Allows admin to ADD a new Sub Topic
	/*************************************************************************************/
	public function add_subTopics()
	{
		// Form Validation ...
		$this->form_validation->set_rules('topic', 'Parent Topic', 'trim|required');
		$this->form_validation->set_rules('subTopic', 'Sub Topic Name', 'trim|required');
		
		$data = array(
			'topicID' => $this->input->post('topic'),
			'subTopic' => $this->input->post('subTopic')
		);
	
		// If form validates -> add new record to database
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) {
			
			$this->topic_model->add_subTopics($data);
			$data = array();
			$data['token'] = $this->auth->token();
			$data['error_sub'] = $this->insert_text_message = '<div class="message_success">Sub-Topic successfully inserted!</div>';
			
			$data['main_content'] = 'admin/topics/add_topics';
			$this->load->view('admin/includes/template', $data);
		}
		else
		{
			$data = array();
			$data['token'] = $this->auth->token();
			$data['error_sub'] = validation_errors('<div class="message_error">* ', '</div>');
		
			$data['main_content'] = 'admin/topics/add_topics';
			$this->load->view('admin/includes/template', $data);
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: edit_subTopics()
	// Allows admin to EDIT a Topic
	/*************************************************************************************/
	public function edit_subTopics()
	{
		// Form Validation ...
		$this->form_validation->set_rules('topic', 'Parent Topic', 'trim|required');
		$this->form_validation->set_rules('subTopicID', 'Sub Topic ID', 'trim|required');
		$this->form_validation->set_rules('subTopic', 'Sub Topic Name', 'trim|required');
		
		$data = array(
			'topicID' => $this->input->post('topic'),
			'subTopicID' => $this->input->post('subTopicID'),
			'subTopic' => $this->input->post('subTopic')
		);
		
		// If form validates -> add new record to database
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) {
			
			$this->topic_model->edit_subTopics($data);
			$data = array();
			$data['token'] = $this->auth->token();
			$data['error_sub'] = $this->insert_text_message = '<div class="message_success">Topic successfully updated!</div>';
			
			// Dynamically find the Topic and Sub Topic info and supply to edit_subTopics.php
			$data['find_topic'] = find_topic( $this->input->post('topic') ); // See admin_helper
			$data['find_subTopic'] = find_subTopic( $this->uri->segment(3) ); // See admin_helper
			
			$data['main_content'] = 'admin/topics/edit_subTopics';
			$this->load->view('admin/includes/template', $data);
		}
		else
		{
			$data = array();
			$data['token'] = $this->auth->token();
			$data['error_sub'] = validation_errors('<div class="message_error">* ', '</div>');
			
			// Dynamically find the Topic and Sub Topic info and supply to edit_subTopics.php
			$data['find_topic'] = find_topic( $this->uri->segment(4) ); // See admin_helper
			$data['find_subTopic'] = find_subTopic( $this->uri->segment(3) ); // See admin_helper
			
			$data['main_content'] = 'admin/topics/edit_subTopics';
			$this->load->view('admin/includes/template', $data);
		}
		
	}
	
	
		
	

} // END Topic_con class