<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_con extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/login_model');
	}
		
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: index()
	// USES index.php (template)
	/*************************************************************************************/
	public function index()
	{
		$data['token'] = $this->auth->token();
		
		$data['main_content'] = 'admin/index';
		$this->load->view('admin/includes/template', $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: validate_login()
	// Validates login details
	/*************************************************************************************/
	function validate_login()
	{		
		$query = $this->login_model->validate_login();

		if($query && $this->input->post('token') == $this->session->userdata('token')) //If the admin's credentials validated...
		{
			
			$admin_level = $query;

			$data = array(
				'username' => $this->input->post('ad_username'),
				'admin' => true,
				'is_logged_in' => true,
				'level' => $admin_level->level
			);

			
			// Unset the failed attempt session var
			$this->session->unset_userdata('login_attempt');
			
			$this->session->set_userdata($data);
			redirect('topic_con/index');
		}
		else 
		{
			// Incorrect username or password
			$this->session->set_userdata('login_attempt', 'fail');
			$this->index();
		}
		
	} //ENDS validate_login()
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: logout()
	// Logs admin OUT and returns them to the home page
	/*************************************************************************************/
	function logout()
	{
		$this->session->sess_destroy();
		redirect('');
		
	} //ENDS logout()
	
	
		
	

} // END Login_con class