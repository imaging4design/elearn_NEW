<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscription_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('admin/subscription_model');
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
	// SUBSCRIPTION ADMIN SECTION
	//
	/************************************************************************************************************************************************************************/
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_subscriptions()
	// Gets subscriptions
	/*************************************************************************************/
	public function get_subscriptions()
	{
		if($query = $this->subscription_model->get_subscriptions())
		{
			$data['subscriptions'] = $query;
		}
		
		$data['main_content'] = 'admin/subscriptions/view_subscriptions';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
		
	/*************************************************************************************/
	// FUNCTION NAME :: get_subscription()
	// Directs to page allowing editing of Subscriptions
	/*************************************************************************************/
	public function get_subscription()
	{
		// Display Subscription record to be edited
		if($query = $this->subscription_model->get_subscription())
		{
			$data['subscription'] = $query;
		}
		
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/subscriptions/edit_subscriptions';
		$this->load->view('admin/ckedit');
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_subscription()
	// Updates the Audio Video record
	/*************************************************************************************/
	public function update_subscription()
	{
		// Perform form validation
		$this->form_validation->set_rules('token', 'token', 'trim|required');
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('name', 'Subscription Name', 'trim|required');
		$this->form_validation->set_rules('special_offer', 'Special Offer', 'trim|required');
		$this->form_validation->set_rules('price', 'Subscription Price', 'trim|required');
		$this->form_validation->set_rules('bodyContent', 'Description', 'trim|required');
		
		$data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'special_offer' => $this->input->post('special_offer'),
			'price' => $this->input->post('price'),
			'description' => $this->input->post('bodyContent')
		);
		
		// If form validates -> add new record to database and initiate success or failure message
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
		{
			$this->subscription_model->update_subscription($data);
			echo $this->update_text_message = '<div class="message_success">Subscription successfully updated!</div>';
		} 
		else 
		{
			echo validation_errors('<div class="message_error">* ', '</div>');
		}
		
	}
	
		
	

} // END Subscription_con class