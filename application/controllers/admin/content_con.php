<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content_con extends CI_Controller
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
	// Shows ALL available Topics AND Sub Topics as 3 or 4 column list
	/*************************************************************************************/
	public function index()
	{
		$data = array();
		$data['topics'] = admin_show_topics(); // See admin_helper
		$data['subTopics'] = admin_show_subTopics(); // See admin_helper
		
		$data['main_content'] = 'admin/topics/topics_select';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_records()
	// Gets ALL records for each category / section and send the data to the appropriate page
	// EXAMPLE: Get ALL Key Notes data from database with id of (?) and populate key_notes.php
	/*************************************************************************************/
	public function get_records()
	{
		$data = array(
			'table' => 'con_' . $this->uri->segment(3),
			'id' => $this->uri->segment(4)
		);
		
		// Remember the current URL so we can return to it if admin 'Deletes' a record
		$this->session->set_userdata('url', current_url());
		
		$data['title'] = get_topic_title( $this->uri->segment(4) ); // See content_helper
		$data['records'] = get_records( $data ); // See content_helper
		
		$data['main_content'] = 'admin/content/view_' . $this->uri->segment(3);
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
		
	

} // END Content_con class