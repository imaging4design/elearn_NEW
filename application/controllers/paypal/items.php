<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Items extends CI_Controller {

 
function items() 
{
	parent::__construct();
	$this->load->model( 'paypal/items_model', 'Item' );
	$this->load->model('admin/subscribers_model');
	$this->load->model('site/section_model');
	$data['site_name'] = $this->config->item( 'site_name' );
	$this->load->vars( $data );
}
		
		
		
function message()
{
	$data['token'] = $this->auth->token();
	$data['page_title'] = 'Message';
	
	$data['main_content'] = 'paypal/register_Paypal';
	$this->load->view('site/includes/template', $data);
}



function error()
{
	$data['main_content'] = 'paypal/error';
	$this->load->view('site/includes/template', $data);
}

		
		
function index()
{
	$data['page_title'] = 'Subscriptions';
	$data['items'] = $this->Item->get_all();
	
	$data['main_content'] = 'paypal/list';
	$this->load->view('site/includes/template', $data);
}
		
		
		
function details() // ROUTE: item/{name}/{id}
{ 
	$id = $this->uri->segment( 3 );
	$item = $this->Item->get( $id );
	 
	if ( ! $item ) 
	{
		$this->session->set_flashdata( 'error', 'Item not found.' );
		//redirect( 'paypal/items' );
		redirect( 'paypal/error' );
	}
	 
	$data['page_title'] = $item->name;
	$data['item'] = $item;
	 
	$data['main_content'] = 'paypal/details';
	$this->load->view('site/includes/template', $data);
}
		
		
		
function purchase() // ROUTE: purchase/{name}/{id}
{ 
	$item_id = $this->uri->segment( 3 );
	$item = $this->Item->get( $item_id );
 
	if ( ! $item ) {
		$this->session->set_flashdata( 'error', 'Item not found.' );
		//redirect( 'paypal/items' );
		redirect( 'paypal/error' );
	}
	
	
	// Validate form here
	$this->form_validation->set_rules( 'terms', 'Terms and Conditions', 'required' );
	$this->form_validation->set_rules( 'email', 'Email', 'required|valid_email|max_length[127]' );

	// Create session var for email that the user originally enters (this will be their membership email - not their PayPal email)
	$this->session->set_userdata('member_email', $this->input->post( 'email' ));
			
		// If form validates .. do this ...
		if ( $this->form_validation->run() ) {

			$email = $this->input->post( 'email' );
		 
			$key = md5( $item_id . time() . $email . rand() );
			$this->Item->setup_payment( $item->id, $email, $key );
		 
			$this->load->library( 'Paypal_Lib' );
			$this->paypal_lib->add_field( 'business', $this->config->item( 'paypal_email' ));
			$this->paypal_lib->add_field( 'return', site_url( 'paypal/paypal/success' ) );
			$this->paypal_lib->add_field( 'cancel_return', site_url( 'paypal/paypal/cancel' ) );
			$this->paypal_lib->add_field( 'notify_url', site_url( 'paypal/paypal/ipn' ) ); // <-- IPN url
		 
			$this->paypal_lib->add_field( 'item_name', $item->name );
			$this->paypal_lib->add_field( 'item_number', '1' );
			$this->paypal_lib->add_field( 'amount', $item->price );
		 
			$this->paypal_lib->add_field( 'custom', $key );
		 
			redirect( $this->paypal_lib->paypal_get_request_link() );
		}
		
		
 
	$data['page_title'] = 'Purchase &ldquo;' . $item->name . '&rdquo;';
	$data['item'] = $item;
 
	$data['main_content'] = 'paypal/purchase';
	$this->load->view('site/includes/template', $data);
}




/*********************************************************************************************************************************************************************/
/*********************************************************************************************************************************************************************/

// THIS IS THE SECTION WHERE SCHOOLS ARE DIRECTED TO A FORM TO ORDER A SCHOOL SUBSCRIPTION!
// THIS IS THE SECTION WHERE SCHOOLS ARE DIRECTED TO A FORM TO ORDER A SCHOOL SUBSCRIPTION!
// THIS IS THE SECTION WHERE SCHOOLS ARE DIRECTED TO A FORM TO ORDER A SCHOOL SUBSCRIPTION!

/*********************************************************************************************************************************************************************/
/*********************************************************************************************************************************************************************/


/*************************************************************************************/
// FUNCTION NAME :: school_order()
// Directs schools to a form so they can register their school (i.e., make a school order)
/*************************************************************************************/
public function school_order()
{
	$this->form_validation->set_rules('token', 'Token', 'trim|required');
	//$this->form_validation->set_rules('schoolID', 'Select School', 'trim|required');
	if( ! $this->input->post('other_school'))
	{
		$this->form_validation->set_rules('schoolID', 'Select School', 'trim|required');
		$school = $this->input->post('schoolID');
	}
	if($this->input->post('schoolID') == 335 or ! $this->input->post('schoolID'))
	{
		$this->form_validation->set_rules('other_school', 'Select School / Other School', 'trim|required');
		$school = $this->input->post('other_school');
	}

	$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
	$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
	$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
	$this->form_validation->set_rules('phone', 'Phone', 'trim|required');

	$this->form_validation->set_rules('genPassword', 'Generic Password', 'trim|required|min_length[6]');
	$this->form_validation->set_rules('teachPassword', 'Teacher Password', 'trim|required|min_length[6]');
	$this->form_validation->set_rules('order_num', 'Order Number', 'trim');

	$this->form_validation->set_rules('school_licence', 'School Licence', 'trim');
	$this->form_validation->set_rules('num_students', 'Number of Students', 'trim|required');
	$this->form_validation->set_rules('conf_order', 'Confirm Order', 'trim|required');

	

	// Convert POSTed school name into human friendly format
	if($this->input->post('schoolID'))
	{
		$get_school_name = school_label(); // converts the posted schoolID value
		$school_label = $get_school_name->school;
	}
	else
	{
		$school_label = $this->input->post('other_school');
	}
	

	$data = array(
		//'schoolID' => $school,
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'email' => $this->input->post('email'),
		'phone' => $this->input->post('phone'),
		'genPassword' => $this->input->post('genPassword'),
		'teachPassword' => $this->input->post('teachPassword'),
		'order_num' => $this->input->post('order_num'),
		'school_licence' => $this->input->post('school_licence'),
		'num_students' => $this->input->post('num_students')
	);

	// If form validates -> add new record to database and initiate success or failure message
	if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token')) 
	{
		
		/**********************************************************************************************************/
		// EMAIL ORDER CONFIRMATION TO ADMIN !!!
		/**********************************************************************************************************/

		//load email library
		$this->email->set_newline("\r\n");

		//assign values to vars
		//$email = 'gavin@imaging4design.co.nz';
		$email = 'info@elearneconomics.com';
		$message = 'Hello Admin,<br /><br />';
		$message .= '<strong>' . $school_label . ' - has placed an order for a School Subscription.</strong><br /><br />';
		$message .= '<strong>DETAILS:</strong><br />';
		$message .= 'Contact: ' . $data['first_name'] . ' ' . $data['last_name'] . '<br />';
		$message .= 'Email: ' . $data['email'] . '<br />';
		$message .= 'Phone: ' . $data['phone'] . '<br /><br />';
		$message .= 'Order Number: <strong>' . $data['order_num'] . '</strong><br /><br />';
		$message .= 'Generic Password: <strong>' . $data['genPassword'] . '</strong><br />';
		$message .= 'Teacher Access Password: <strong>' . $data['teachPassword'] . '</strong><br /><br />';

		$message .= 'School Licence: <strong>' . $data['school_licence'] . '</strong><br />';
		$message .= 'Number of Students: <strong>' . $data['num_students'] . '</strong><br /><br />';

		$message .= 'Please click this link to process the order: ' . base_url() . 'admin/login_con/<br /><br />';
		$message .= 'Kind regards,<br />';
		$message .= $data['first_name'] . ' ' . $data['last_name'].',<br />';
		$message .= $school_label;

		//set to, from, subject, message
		$this->email->to($email, 'eLearn Economics');
		$this->email->from('info@elearneconomics.com');
		$this->email->subject('eLearn Economics - School Order');
		$this->email->message($message);

		//send the email!!
		$this->email->send();

		//display any problems to screen
		//echo $this->email->print_debugger();



		/**********************************************************************************************************/
		// EMAIL ORDER TO SUBSCRIBER !!!
		/**********************************************************************************************************/

		//load email library
		$this->email->set_newline("\r\n");

		//assign values to vars
		$email = $data['email']; // Goes to the School

		$message = 'Hello ' . $data['first_name'] . ',<br /><br />';
		$message .= '<strong>Thank you for your subscription order for ' . $school_label . '. Please check the following details are correct. If not please contact Elearn Economics on (09) 410 9653</strong><br /><br />';
		$message .= '<strong>DETAILS:</strong><br />';
		$message .= 'Contact: ' . $data['first_name'] . ' ' . $data['last_name'] . '<br />';
		$message .= 'Email: ' . $data['email'] . '<br />';
		$message .= 'Phone: ' . $data['phone'] . '<br /><br />';
		$message .= 'Order Number: <strong>' . $data['order_num'] . '</strong><br /><br />';
		$message .= 'Generic Password: <strong>' . $data['genPassword'] . '</strong><br />';
		$message .= 'Teacher Access Password: <strong>' . $data['teachPassword'] . '</strong><br /><br />';

		$message .= 'School Licence: <strong>' . $data['school_licence'] . '</strong> (Note: 15 indivdual subscriptions included as standard)<br />';
		$message .= 'Number of Students: <strong>' . $data['num_students'] . '</strong><br /><br />';

		$message .= 'Kind regards,<br />';
		$message .= 'Elearn Economics';

		//set to, from, subject, message
		$this->email->to($email, 'eLearn Economics');
		$this->email->from('info@elearneconomics.com');
		$this->email->subject('eLearn Economics - School Order');
		$this->email->message($message);

		//send the email!!
		$this->email->send();

		//display any problems to screen
		//echo $this->email->print_debugger();

		/**********************************************************************************************************/
		// ENDS Email
		/**********************************************************************************************************/

		$data['token'] = $this->auth->token();
		$data['error'] = '<div class="message_success">Thank you. Your School Order Subscription has been successfully placed.</div>';

        	$data['main_content'] = 'paypal/school_order';
		$this->load->view('site/includes/template', $data);
		
	}
	else
	{
		$data['token'] = $this->auth->token();
		$data['error'] = validation_errors('<div class="message_error">* ', '</div>');

        	$data['main_content'] = 'paypal/school_order';
		$this->load->view('site/includes/template', $data);
	}


}
		
		
		
/*function download() // ROUTE: download/{purchase_key}
{ 
	$key = $this->uri->segment( 2 );
	$purchase = $this->Item->get_purchase_by_key( $key );
 
	// Check purchase was fulfilled
	if ( ! $purchase ) {
		$error = $this->session->set_flashdata( 'error', 'Download key not valid.' );
		//redirect( 'paypal/items' );
		redirect( 'paypal/message' );
	}
	if ( $purchase->active == 0 ) {
		$this->session->set_flashdata( 'error', 'Download not active.' );
		//redirect( 'paypal/items' );
		redirect( 'paypal/message' );
	}
	
	// Check download limit
	$download_limit = $this->config->item( 'download_limit' );
	if ( $download_limit['enable'] ) {
		$downloads = $this->Item->get_purchase_downloads( $purchase->id, $download_limit['downloads'] );
		$count = 0;
		$time_limit = time() - (86400 * $download_limit['days']);
		foreach ( $downloads as $download ) {
			if ( $download->download_at >= $time_limit )
				$count++; // download within past x days
			else
				break; // later than x days, so can stop foreach
		}
	 
		// If over download limit, error
		if ( $count >= $download_limit['downloads'] ) { // can only download x times within y days
			$this->session->set_flashdata( 'error', 'You can only download a file ' . $download_limit['downloads'] . ' times in a ' . $download_limit['days'] . ' day period. Please try again later.' );
			//redirect( 'paypal/items' );
			redirect( 'paypal/message' );
		}
	}
 
	// Get item and initiate download if exists
	$item = $this->Item->get( $purchase->item_id );
 
	$file_name = $item->file_name;
	$file_data = read_file( 'files/' . $file_name );
 
	if ( ! $file_data ) { // file not found on server
		$this->session->set_flashdata( 'error', 'The requested file was not found. Please contact us to resolve this.' );
		//redirect( 'paypal/items' );
		redirect( 'paypal/message' );
	}
 
 	$this->Item->log_download( $item->id, $purchase->id, $this->input->ip_address(), $this->input->user_agent() );
	force_download( $file_name, $file_data );
}*/
		
		
		
 
} // ENDS class Items