<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Paypal extends CI_Controller {


function Paypal() 
{
	parent::__construct();
	$this->load->model('paypal/items_model', 'Item');
	$this->load->model('admin/subscribers_model');
	$this->load->library('Paypal_Lib');
	$data['site_name'] = $this->config->item('site_name');
	$this->load->vars($data);

	//$this->output->enable_profiler(TRUE);
}
	
 
function index() 
{
	redirect( 'paypal/items' );
}

 
function success() 
{
	// Create session vars to present back to the 'Success Message' page upon return from PayPal
	$check_key = array(
		'first_name' => $_POST['first_name'],
		'last_name' => $_POST['last_name'],
		'payer_email' => $_POST['payer_email'],
		'txn_id' => $_POST['txn_id'],
		'key_code' => NULL
	);

	// Create session vars 
	$this->session->set_userdata($check_key);

	// Create 'Success Message' itself
	$this->session->set_flashdata( 'success', '<strong>Thank you.</strong> Your payment has been processed. Complete your registration now, or via the registration email link you will receive soon.' );
	//redirect( 'paypal/items' );
	redirect( 'paypal/add_member' );
}
	
 
function cancel()
{
	$this->session->set_flashdata( 'success', '<strong>Your Payment was cancelled!</strong>' );
	//redirect( 'paypal/items' );
	redirect( 'paypal/error' );
}
	
	
function ipn() 
{
	if($this->paypal_lib->validate_ipn()) 
	{
	// Data returned from PayPal	
	$item_name 	= $this->paypal_lib->ipn_data['item_name'];
	$price 			= $this->paypal_lib->ipn_data['mc_gross'];
	$currency 		= $this->paypal_lib->ipn_data['mc_currency'];
	$payer_email 	= $this->paypal_lib->ipn_data['payer_email'];
	$txn_id 		= $this->paypal_lib->ipn_data['txn_id'];
	$key 			= $this->paypal_lib->ipn_data['transaction_subject'];

	$this->Item->confirm_payment( $key, $payer_email, $txn_id );
	$purchase 		= $this->Item->get_purchase_by_key( $key );
	$item 			= $this->Item->get( $purchase->item_id );


	
	// Send download link to customer
	$to = $purchase->email;
	$from = $this->config->item( 'no_reply_email' );
	$name = $this->config->item( 'site_name' );
	$subject = $item->name . ' Download';
	 
	$segments = array( 'item', url_title( $item->name, 'dash', true ), $item->id );
	$message = '<p>Thanks for purchasing ' . anchor( $segments, $item->name ) . ' from ' . anchor( '', $name ) . '. If you have NOT completed your registration please click the link below.</p>';
	$message .= '<p>' . anchor( 'paypal/add_member/' . $key) . '</p>';
	 
	$this->email->from( $from, $name );
	$this->email->to( $to );
	$this->email->subject( $subject );
	$this->email->message( $message );
	$this->email->send();
	$this->email->clear();
	
	
	// Send confirmation of purchase to admin
	$message = '<p><strong>New Purchase:</strong></p><ul>';
	$message .= '<li><strong>Item:</strong> ' . anchor( $segments, $item->name ) . '</li>';
	$message .= '<li><strong>Price:</strong> $' . $item->price . '</li>';
	$message .= '<li><strong>Email:</strong> ' . $purchase->email . '</li><li></li>';
	$message .= '<li><strong>PayPal Email:</strong> ' . $payer_email . '</li>';
	$message .= '<li><strong>PayPal TXN ID:</strong> ' . $txn_id . '</li></ul>';
	$this->email->from( $from, $name );
	$this->email->to( $this->config->item( 'admin_email' ) );
	$this->email->subject( 'A purchase has been made' );
	$this->email->message( $message );
	$this->email->send();
	$this->email->clear();
	
	}
	
	
} // ends ipn()



/*********************************************************************************************************************************************************************/
/*********************************************************************************************************************************************************************/

// THIS IS THE SECTION WHERE THE SUBSCRIBER IS ADDED TO THE DATABASE!
// THIS IS THE SECTION WHERE THE SUBSCRIBER IS ADDED TO THE DATABASE!
// THIS IS THE SECTION WHERE THE SUBSCRIBER IS ADDED TO THE DATABASE!

/*********************************************************************************************************************************************************************/
/*********************************************************************************************************************************************************************/


function add_member() 
{
	// Validate form here
	$this->form_validation->set_rules( 'token', 'Token', 'trim|required' );
	$this->form_validation->set_rules( 'txn_id', 'Transaction ID', 'trim' );
	$this->form_validation->set_rules( 'first_name', 'First Name', 'trim|required|alpha' );
	$this->form_validation->set_rules( 'last_name', 'Last Name', 'trim|required|alpha' );
	$this->form_validation->set_rules( 'email', 'Email (Username)', 'trim|required|valid_email|is_unique[mem_students.email]' );
	$this->form_validation->set_rules( 'password', 'Password', 'trim|required|min_length[6]' );
	$this->form_validation->set_rules( 'conf_password', 'Confirm Password', 'trim|required|matches[password]' );
	$this->form_validation->set_rules( 'schoolID', 'School', 'trim|required' );
	$this->form_validation->set_rules( 'subscribe', 'Subscribe', 'trim|required' );
	//$this->form_validation->set_rules( 'courseID', 'Course', 'trim|required' );

	
	// Work out which $check_key variable to check against
	// 'key_code' for those visting via their email link
	// 'txn_id' for those coming directly back from PayPal
	$check_key = ( $this->uri->segment(3) ) ? $this->uri->segment(3) : $this->session->userdata('txn_id');

	
	$data = array(
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'email' => $this->input->post('email'),
		'password' => md5($this->input->post('password')),
		'schoolID' => $this->input->post('schoolID'),
		//'courseID' => $this->input->post('courseID'),
		'subscribe' => $this->input->post('subscribe'),
		'created_at' => date('Y-m-d'),
		'pay_method' => 1
		);

	$update = array(
		'email' => $this->input->post('email'),
		'redeemed' => 'true'
	);

	// If form validates -> add new record to database and initiate success or failure message
        	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
        	{
		// Before entering new a subscriber into database - check to see if a legitimate 'key_code' OR PayPal 'txn_id' exists for this user
        		// This function will see if the current (PayPal) txn_id session matches an entry in the database
        		// or whether the $this->uri->segment(3) URL from the link emailed to the subscriber matches an entry in the database
        		if( $this->subscribers_model->check_key($check_key) )
        		{
        			$this->subscribers_model->add_member($data); // add member to the mem_students table
        			$this->subscribers_model->update_purchases($update); // update the pp_purchases table redeemed field from 'false' to 'true' so no more members can be added to this 'key_code' / 'txn_id'
        			$this->session->sess_destroy();

				redirect('main/login');
        		}
        		
        	}
        	else
        	{
		$data['token'] = $this->auth->token();
		$data['error'] = $this->error_school = validation_errors('<div class="message_error">* ', '</div>');

		// Check to see if the prospective member has a valid 'Key Code' or 'PayPal txn_id' against their email
		if($query = $this->subscribers_model->check_key($check_key))
		{
			$data['email'] = $query;
		}
		else
		{
			//$this->session->sess_destroy();
			
			// If 'key_code' or 'txn_id' has beed used - send user to error page
			$this->session->set_flashdata( 'error', '<strong>This subscription has already been activated.</strong> Please contact support for further assistance.' );
			redirect( 'paypal/error' );
		}

		$data['main_content'] = 'paypal/register_Paypal';
		$this->load->view('site/includes/template', $data);
        	}

}






function add_member_codes() 
{
	// Validate form here
	$this->form_validation->set_rules( 'token', 'Token', 'trim|required' );
	$this->form_validation->set_rules( 'access_code', 'Student Access Code', 'trim|required' );
	$this->form_validation->set_rules( 'first_name', 'First Name', 'trim|required' );
	$this->form_validation->set_rules( 'last_name', 'Last Name', 'trim|required' );
	$this->form_validation->set_rules( 'email', 'Email (Username)', 'trim|required|valid_email|is_unique[mem_students.email]' );
	$this->form_validation->set_rules( 'password', 'Password', 'trim|required|min_length[6]' );
	$this->form_validation->set_rules( 'conf_password', 'Confirm Password', 'trim|required|matches[password]' );
	$this->form_validation->set_rules( 'schoolID', 'School', 'trim|required' );
	$this->form_validation->set_rules( 'subscribe', 'Subscribe', 'trim|required' );
	//$this->form_validation->set_rules( 'courseID', 'Course', 'trim|required' );

	$data_code = array(
		'access_code' => $this->input->post('access_code')
	);

	$data = array(
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'email' => $this->input->post('email'),
		'password' => md5($this->input->post('password')),
		'schoolID' => $this->input->post('schoolID'),
		'subscribe' => $this->input->post('subscribe'),
		// 'courseID' => $this->input->post('courseID'),
		'created_at' => date('Y-m-d'),
		'pay_method' => 0
		);


	// If form validates -> add new record to database and initiate success or failure message
        	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
        	{
		
			if( $this->subscribers_model->check_codes($data_code) )
        		{
        			
        			$query = $this->subscribers_model->check_codes($data_code);
        			$code_status = $query;

        			$this->subscribers_model->add_member($data); // add member to the mem_students table
        			$this->subscribers_model->update_code_status($code_status); // update the mem_codes table - change status to 'Used'
        			$this->session->set_userdata('code_message', '<div class="textGreen">Thank you. You have successfully registered with your access code. Login below as a Full Member using the email and password that you subscribed with.</div>');

				redirect( 'main/login' );
        		}
        		else
        		{
        			$data['token'] = $this->auth->token();
        			$data['code_error'] = '<div class="message_error">Your Access Code is not valid. Please try again</div>';
				$data['error'] = $this->error_school = validation_errors('<div class="message_error">* ', '</div>');
	        		$data['main_content'] = 'paypal/register_codes';
				$this->load->view('site/includes/template', $data);
        		}
        	}
        	else
        	{
        		$data['token'] = $this->auth->token();
			$data['error'] = $this->error_school = validation_errors('<div class="message_error">* ', '</div>');
        		$data['main_content'] = 'paypal/register_codes';
			$this->load->view('site/includes/template', $data);
        	}

}


} // ENDS class Paypal