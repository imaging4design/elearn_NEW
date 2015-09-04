<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Section extends CI_Controller
{	
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('site/section_model');
		$this->load->model('admin/subscribers_model');
		$data['site_name'] = $this->config->item( 'site_name' );
		$this->load->vars( $data );
		//$this->logged_in();

		//Get the topicID so we can use it for the 
		if($this->uri->segment(2) == 'key_notes' && $this->uri->segment(3))
		{
			$this->session->set_userdata('topicID', $this->uri->segment(3));
		}

		/*************************************************************************************************************************************/
		// DEMO SECTION ........ DEMO SECTION ........ DEMO SECTION ........ DEMO SECTION ........ DEMO SECTION ........ DEMO SECTION ........    
		// This allows the DEMO mode to run without students having to login
		// DEMO topics must be the $demo array();
		/**************************************************************************************************************************************/
		$demo_topics = array('1', '8', '16');

		if( ! in_array( $this->uri->segment(3), $demo_topics ) and $this->uri->segment(2) != 'demo')
		{
			$this->logged_in();
		}
		/**************************************************************************/



	}



	/*************************************************************************************/
	// FUNCTION NAME :: logged_in()
	// Checks to see if student user is currently logged in
	// If not - send them to the login page again
	/*************************************************************************************/
	function logged_in()
	{
		$logged_in = $this->session->userdata('logged_in');	
		if( ! isset( $logged_in ) || $logged_in != true )
		{
			redirect('main/login', 'refresh');
		}
		
	}

	
	
	/*************************************************************************************/
	// FUNCTION NAME :: index()
	// Displays the home page
	/*************************************************************************************/
	public function index()
	{
		$data = array();
		$data['topics'] = show_topics(); // See admin_helper
		$data['subTopics'] = show_subTopics(); // See admin_helper
		$data['class_message'] = class_message(); // See section_helper (displays a custom teacher message to students)
	
		$data['main_content'] = 'site/sections/menu';
		$this->load->view('site/includes/template', $data);
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: demo()
	// Displays the home page
	/*************************************************************************************/
	public function demo()
	{
		$data = array();
		$data['topics'] = show_topics(); // See admin_helper
		$data['subTopics'] = show_subTopics(); // See admin_helper

		$data['main_content'] = 'site/sections/menu_demo';
		$this->load->view('site/includes/template', $data);
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: key_notes()
	// Displays the Key Notes page
	/*************************************************************************************/
	public function key_notes()
	{
		$data = array();
		$data['topic_label'] = topic_label(); // See section_helper

		//Get Key Notes from Database
		if($query = $this->section_model->key_notes())
		{
			$data['key_notes'] = $query;
		}

		//Get ALL related Sub Topics to display
		if($query = $this->section_model->get_related_topics())
		{
			$data['sub_topics'] = $query;
		}

			// See if video exists - if not, disable menu button
			if($query = $this->section_model->audio_video())
			{
				$this->session->unset_userdata('no_video');
			}
			else
			{
				$this->session->set_userdata('no_video', true);
			}

		$data['main_content'] = 'site/sections/key_notes';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: audio_video()
	// Displays the Audio Video page
	/*************************************************************************************/
	public function audio_video()
	{
		$data = array();
		$data['topic_label'] = topic_label(); // See section_helper

		//Get Key Notes from Database
		if($query = $this->section_model->audio_video())
		{
			$data['audio_video'] = $query;
		}

		//Get ALL related Sub Topics to display
		if($query = $this->section_model->get_related_topics())
		{
			$data['sub_topics'] = $query;
		}

		$data['main_content'] = 'site/sections/audio_video';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: flash_cards()
	// Displays the Flash Cards page
	/*************************************************************************************/
	public function flash_cards()
	{
		if($this->input->post('flash_opt'))
		{
			$this->session->set_userdata('flash_opt', $this->input->post('flash_opt'));
		}

		$data = array();
		$data['topic_label'] = topic_label(); // See section_helper

		//Get Key Notes from Database
		if($query = $this->section_model->flash_cards())
		{
			$data['flash_cards'] = $query;
		}

		//Get ALL related Sub Topics to display
		if($query = $this->section_model->get_related_topics())
		{
			$data['sub_topics'] = $query;
		}

		$data['main_content'] = 'site/sections/flash_cards';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: written_answers()
	// Displays the Written Answers page
	/*************************************************************************************/
	public function written_answers()
	{
		$data = array();
		$data['topic_label'] = topic_label(); // See section_helper
		
		// If user submits answers ... run function
		//Loop through codeID rows (id's) and assign them to var $id
		if($this->input->post('submit') == 'Submit and Review')
		{
			//Initiate var
			$data['result'] = FALSE;
			$q_number = 1;

			for ($i = 0, $count = count( $this->input->post('question') ); $i < $count; $i++)
			{

				$q_num = $i+1;

				// SET UP THE IMAGE PROPERTIES
				$image = array(
					'src' => base_url() . 'images/images/' . $_POST['image'][$i],
					'alt' => 'eLearn Economics',
					'width' => '440',
					'height' => '293',
					'style' => 'margin:0 20px 20px 0;',
					'class' => 'img-responsive'
				);

				//Only show image if there is one (otherwise leaves an empty box in some browsers)!
				$display_image = ( $_POST['image'][$i] !='' ) ? img($image) : '';


				if($_POST['answer'][$i] =='')
				{
					$data['result'] .= '<div class="no_answer">';
					$data['result'] .= $display_image;
					$data['result'] .= '<p><strong>QUESTION ' . $q_num . '</strong>. ' . $_POST['question'][$i] . '</p>';
					$data['result'] .= '<p><strong class="text-muted">You said: </strong>' . $_POST['answer'][$i] . '</p>';
					$data['result'] .= '<hr class="hr-written">';
					$data['result'] .= '</div>';
				}
				else
				{
					$data['result'] .= '<div class="correct">';
					$data['result'] .= $display_image;
					$data['result'] .= '<p><strong>QUESTION ' . $q_num . '</strong>. ' . $_POST['question'][$i] . '</p>';
					$data['result'] .= '<p><strong class="text-muted">You said: </strong>' . $_POST['answer'][$i] . '</p>';
					$data['result'] .= '<p><strong class="text-muted">eLearn: </strong><em>' . $this->encrypt->decode( $_POST['mod_answer'][$i] ) . '</em></p>';
					$data['result'] .= '<hr class="hr-written">';
					$data['result'] .= '</div>';
				}
			}
		}
		else
		{
			//Get Key Notes from Database
			if($query = $this->section_model->written_answers())
			{
				$data['written_answers'] = $query;
			}

			//Get ALL related Sub Topics to display
			if($query = $this->section_model->get_related_topics())
			{
				$data['sub_topics'] = $query;
			}

		}

		$data['main_content'] = 'site/sections/written_answers';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: add_multi_score()
	// Loads the user score results to the database (add_mem_results)
	/*************************************************************************************/
	public function add_multi_score($new_score) // $new_score received from function multi_choice()
	{
		$month = date('M');		// Work out the current $month (i.e. Jan, Feb, Mar ...)
		$n_month = 'n_'.date('M');	// Work out the current $n_month (i.e. n_Jan, n_Feb, n_Mar ...)

		// Create data array of user info (studentID, topicID, month)
		$data = array(
			'studentID' => $this->session->userdata('studentID'),
			'topicID' => $this->session->userdata('topicID')
		);

		// Does the student have an existing score for this topicID? (check mem_results_data to see if data exists)
		// If YES .. update the table with this:
		if($query = $this->section_model->get_score_info($data))
		{
			// Each new month -> reset the last_score array to 0,0,0,0,0
			if( $query->$n_month == 0) 
			{
			 	$this->section_model->reset_month_array();
			}


			$data = array(
				'studentID' => $this->session->userdata('studentID'),
				'topicID' => $this->session->userdata('topicID'),
				$month => $new_score
			);

			// Update the update_mem_results_data($data) table
			$this->section_model->update_mem_results($data);

		}
		// If NO .. insert new data to the table with this:
		else
		{
			// Create data array of user info (studentID, topicID, month)
			$data = array(
				'studentID' => $this->session->userdata('studentID'),
				'topicID' => $this->session->userdata('topicID'),
				'test_date' => date('Y-m-d'),
				'last_score' => '0,0,0,0,' . $new_score,
				$n_month => 1,
				$month => $new_score
			);

			// Insert new data to add_mem_results($data) table
			// BUT NOT if the student is a guest student !!!!
			if( $this->session->userdata('member_type') != 'guest_member')
			{
				$this->section_model->add_mem_results($data);
			}
		}

	}



	/*************************************************************************************/
	// FUNCTION NAME :: multi_choice()
	// Displays the Multi Choice page
	/*************************************************************************************/
	public function multi_choice()
	{
		$data = array();
		$data['topic_label'] = topic_label(); // See section_helper

		// If user submits answers ... run function
		//Loop through codeID rows (id's) and assign them to var $id
		if($this->input->post('submit') == 'Submit and Review' && $this->input->post('token') == $this->session->userdata('token'))
		{

			//Initiate var(s)
			$data['result'] = FALSE;
			$posted_answer = FALSE;
			$data['score'] = 0;

			for ($i = 0, $count = count( $this->input->post('question') ); $i < $count; $i++)
			{

				$qID = $_POST['id'][$i]; // Find the id ($qID) of each question
				$q_number = $i+1; // This is for question numbering (nothing to do with functionality)!!!!
				

				if( isset($_POST["q$qID"])) // If the user has submitted and answer
				{
					
					// SET UP THE IMAGE PROPERTIES
					$image = array(
						'src' => base_url() . 'images/images/' . $_POST['image'][$i],
						'alt' => 'eLearn Economics',
						'width' => '200px',
						'height' => '133',
						'style' => 'margin: 10px 0 10px 30px;',
						'class' => 'img-responsive'
					);

					//Only show image if there is one (otherwise leaves an empty box in some browsers)!
					$display_image = ( $_POST['image'][$i] !='' ) ? img($image) : '';



					$data['token'] = $this->auth->token(); // !!!!  IMPORTANT !!!! - This required to stop reloading of page adding another score!

					$posted_answer = $_POST["q$qID"]; // This is the user $_POST answer (from the radio but)
					$actual_answer = $_POST['answer'][$i]; // This is the corerct answer

					$actual_answer = $this->encrypt->decode( $_POST['answer'][$i] ); // Decode the answer  

					if($posted_answer == $actual_answer) // If the user has selected the CORRECT answer
					{
						$data['score'] = $data['score'] +1; // Add 1 to the total score

						$data['result']  .= '<div class="correct bg_correct">';
						$data['result']  .= '<h4 class="bold">' . $q_number . '. ' . $_POST['question'][$i] . '</h4>';
						$data['result']  .= '<h4><span class="textGreen bold">You: </span>' . $posted_answer . '</h4>';

						if($this->input->post('show_answers')) // Only show correct answers and reasons if user checks 'show_reasons' checkbox
						{
							$data['result']  .= '<h4><span class="textGreen bold">eLearn: </span>' . $this->encrypt->decode( $_POST['answer'][$i] ) . '</h4>';
							$data['result']  .= '<h4><span class="textGreen bold">Reason: </span><em>' . $this->encrypt->decode(  $_POST['reason'][$i] ) . '</em></h4>';
						}

						$data['result']  .= $display_image; // SHOWS IMAGE
						$data['result']  .=  '</div>';
					}
					else // If the user has selected the INCORRECT answer
					{
						$data['result']  .= '<div class="incorrect bg_incorrect">';
						$data['result']  .= '<h4 class="bold">' . $q_number . '. ' . $_POST['question'][$i] . '</h4>';
						$data['result']  .= '<h4><span class="textRed bold">You: </span>' . $posted_answer . '</h4>';

						if($this->input->post('show_answers')) // Only show correct answers and reasons if user checks 'show_reasons' checkbox
						{
							$data['result']  .= '<h4><span class="textRed bold">eLearn: </span>' . $this->encrypt->decode( $_POST['answer'][$i] ) . '</h4>';
							$data['result']  .= '<h4><span class="textRed bold">Reason: </span><em>' . $this->encrypt->decode(  $_POST['reason'][$i] ) . '</em></h4>';
						}

						$data['result']  .= $display_image; // SHOWS IMAGE
						$data['result']  .=  '</div>';
					}

				}
				else // If the user has NOT submitted and answer
				{
					$data['result']  .= '<div class="no_answer">';
					$data['result']  .= '<h4 class="bold">' . $q_number . '. ' . $_POST['question'][$i] . '</h4>';
					$data['result']  .= '<h4><span class="textGrey bold">You: </span>No answer provided</h4>';

					if($this->input->post('show_answers')) // Only show correct answers and reasons if user checks 'show_reasons' checkbox
					{
						$data['result']  .= '<h4><span class="textGrey bold">eLearn: </span><em>' . $this->encrypt->decode(  $_POST['answer'][$i] ) . '</em></h4>';
						$data['result']  .= '<h4><span class="textGrey bold">Reason: </span><em>' . $this->encrypt->decode(  $_POST['reason'][$i] ) . '</em></h4>';
					}

					$data['result']  .= $display_image; // SHOWS IMAGE
					$data['result']  .=  '</div>';
				}

			}

			//Get score to carry through to next function
			$new_score = $data['score'];



			/**************************************************************************/
			// !!!!! - IMPORTANT - !!!!!
			// Only add score if user is logged in
			// Don't add score if in DEMO mode!!!!
			/**************************************************************************/
			$logged_in = $this->session->userdata('logged_in');	
			if( isset( $logged_in ) && $logged_in == true )
			{
				$this->add_multi_score($new_score);
			}



		}
		else
		{
			//Get Multi Choice from Database
			if($query = $this->section_model->multi_choice())
			{
				$data['token'] = $this->auth->token();
				$data['multi_choice'] = $query;
			}

			//Get ALL related Sub Topics to display
			if($query = $this->section_model->get_related_topics())
			{
				$data['sub_topics'] = $query;
			}
		
		}

		$data['main_content'] = 'site/sections/multi_choice';
		$this->load->view('site/includes/template', $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: edit_options()
	// Allows Students to edit their own details and add options
	/*************************************************************************************/
	public function edit_options()
	{
		$this->form_validation->set_rules('token', 'Token', 'trim|required');
		$this->form_validation->set_rules('studentID', 'StudentID', 'trim|required');
		$this->form_validation->set_rules('leaderboard', 'Leaderboard', 'trim|required');


		$data = array(
			'studentID' =>$this->input->post('studentID'),
			'leaderboard' => $this->input->post('leaderboard')
		);
		

		// If form validates -> update student user details
		if($this->form_validation->run() == TRUE && $this->input->post('token') == $this->session->userdata('token'))
		{
			$this->main_model->update_options($data);
			$data['error'] = '<div class="text-green">Thank you. Your details have been updated.</div>';
		}
		else
		{
			$data['error'] = validation_errors('<div class="text-red">* ', '</div>');
		}

		//Get student details from database
		if($query = $this->main_model->edit_options())
		{
			$data['details'] = $query;
		}

		$data['token'] = $this->auth->token();
		$data['main_content'] = 'site/standard/edit_options';
		$this->load->view('site/includes/template', $data);
	}
	
	
	
	

} // END Section class