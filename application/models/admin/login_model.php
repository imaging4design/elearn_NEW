<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model 
{
	
	function __construct()
	{
		parent::__construct();
		// Stuff here ....
	}
	
	
	/*************************************************************************************/
	// NAME :: validate_login()
	// FUNCTION :: validates the admin login user credentials
	/*************************************************************************************/
	function validate_login()
	{
		$this->db->where('username', $this->input->post('ad_username'));
		$this->db->where('password', md5($this->input->post('ad_password')));
		$query = $this->db->get('ad_admin');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	} //ENDS validate_login()
	
	
	

} //ENDS Login_model class