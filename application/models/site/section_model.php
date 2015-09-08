<?php

class Section_model extends CI_Model {
	
	function Main_model() 
	{
		parent::__construct();
		
	}


	/*************************************************************************************/
	// NAME :: topic_label()
	// This enables us to display the current Topic name! => converted from the topicID
	/*************************************************************************************/
	function topic_label()
	{
		if( $this->input->post('topic') )
		{
			$topic = $this->input->post('topic');
		}
		else
		{
			$topic = $this->uri->segment(3);
		}

		$this->db->select('*');
		$this->db->where('topicID', $topic);
		//$this->db->where('topicID', $this->uri->segment(3));
		//$this->db->or_where('topicID', $this->input->post('topic'));
		$query = $this->db->get('ad_topics');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// NAME :: school_label()
	// This enables us to display the current School name! => converted from the schoolID
	/*************************************************************************************/
	function school_label()
	{
		// Get value of schoolID from either SESSION var or POST!
		$schoolID = ($this->session->userdata('schoolID')) ? $this->session->userdata('schoolID') : $this->input->post('schoolID');

		$this->db->select('*');
		$this->db->where('id', $schoolID);
		$query = $this->db->get('ad_schools');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// NAME :: key_notes()
	// Gets all Key Notes from database => based on topicID
	/*************************************************************************************/
	function key_notes()
	{
		$this->db->select('*');
		$this->db->where('topicID', $this->uri->segment(3));
		$this->db->where('on_off', 'true');
		$query = $this->db->get('con_key_notes');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: audio_video()
	// Gets all Audio Video from database => based on topicID
	/*************************************************************************************/
	function audio_video()
	{
		$this->db->select('*');
		$this->db->where('topicID', $this->uri->segment(3));
		$this->db->where('on_off', 'true');
		$query = $this->db->get('con_audio_video');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: flash_cards()
	// Gets all Flash Cards from database => based on topicID
	/*************************************************************************************/
	function flash_cards()
	{
		$this->db->select('*');
		$this->db->where('topicID', $this->uri->segment(3));
		$this->db->where('on_off', 'true');
		$this->db->order_by('id', 'random');
		$this->db->limit(7);
		$query = $this->db->get('con_flash_written');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: written_answers()
	// Gets all Written Answers from database => based on topicID
	/*************************************************************************************/
	function written_answers()
	{
		$this->db->select('*');
		$this->db->where('topicID', $this->uri->segment(3));
		$this->db->where('on_off', 'true');
		$this->db->order_by('id', 'random');
		$this->db->limit(5);
		$query = $this->db->get('con_flash_written');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: multi_choice()
	// Gets all Multi Choice from database => based on topicID
	/*************************************************************************************/
	function multi_choice()
	{
		$this->db->select('*');
		$this->db->where('topicID', $this->uri->segment(3));
		$this->db->where('on_off', 'true');
		$this->db->order_by('id', 'random');
		$this->db->limit(10);
		$query = $this->db->get('con_multi_choice');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: get_related_topics()
	// Gets all Sub-Topics related to the main topic to display in each section
	/*************************************************************************************/
	function get_related_topics()
	{
		$this->db->select('*');
		$this->db->where('topicID', $this->uri->segment(3));
		$this->db->order_by('subTopic', 'ASC');
		$query = $this->db->get('ad_subTopics');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: get_score_info($data)
	// Get the number of tests completed for this topic for this month!
	// Gets the last known score for this topic for this month
	/*************************************************************************************/
	function get_score_info($data)
	{
		$n_month = 'n_'.date('M');

		$this->db->select('*');
		$this->db->where('studentID', $data['studentID']);
		$this->db->where('topicID', $data['topicID']);
		$query = $this->db->get('mem_results');

		if($query->num_rows() >0)
		{
			return $query->row();
		}
	}


	/*************************************************************************************/
	// NAME :: add_mem_results($data)
	// Adds / Updates test 'results' for each topic studied for each student
	/*************************************************************************************/
	function add_mem_results($data)
	{
		$this->db->insert('mem_results' /*tablename*/, $data);
	}


	/*************************************************************************************/
	// NAME :: reset_month_array($data)
	// Each new month - reset the score of 5 array items to (0,0,0,0,0) so last months scores don't affect this month
	/*************************************************************************************/
	function reset_month_array()
	{
		$data = array('last_score' => '0,0,0,0,0');

		$this->db->where('studentID', $this->session->userdata['studentID'] /*record id*/);
		$this->db->where('topicID', $this->session->userdata['topicID'] /*record id*/);
		$this->db->update('mem_results' /*tablename*/, $data);
	}


	/*************************************************************************************/
	// NAME :: mem_results_data($data)
	// Updates data to the mem_results table
	/*************************************************************************************/
	function update_mem_results($data)
	{
		$month = date('M'); 		// Work out the current $month (i.e. Jan, Feb, Mar etc ...)
		$n_month = 'n_'.date('M');	// Work out the current $n_month (i.e. n_Jan, n_Feb, n_Mar etc ...)
		$new_results = FALSE; 	// Initiate this var so we don't get an error
		$total = FALSE; 			// Initiate this var so we don't get an error

		// Find out if the student has existing results for this topicID and this 'current' month
		$this->db->select('*');
		$this->db->where('studentID', $data['studentID']);
		$this->db->where('topicID', $data['topicID']);
		//$this->db->where($month . ' IS NOT NULL', NULL, TRUE);  // Means the month col is NOT empty!
		$query = $this->db->get('mem_results');


		if($query->num_rows() >0)
		{
			$row = $query->row(); // Convert returned data into useable format (i.e. month = $row->$month)

			$explodedResults = explode(",", $row->last_score); // Separate each result with ',' (comma)

			$results = $explodedResults;
			array_shift( $results ); // Drop the first element off the array
			array_push( $results, $data[$month] ); // Add new element to the end of the array (in this case the new score)

			foreach($results as $value):
				$new_results .= $value . ','; 	// Create a new comma separated array of the result
				$total = $total + $value; 		// Add up all the scores and create a var for it to feed into the $month
			endforeach;


			$new_results = reduce_multiples( $new_results, ", ", TRUE ); // Get rid of the trailing ',' (comma - don't need it)
			$new_test_num = $row->$n_month + 1;

			$data = array(
				'studentID' => $this->session->userdata('studentID'),
				'topicID' => $this->session->userdata('topicID'),
				'test_date' => date('Y-m-d'),
				'last_score' => $new_results, // Assign the new result array to the applicable month
				$n_month => $new_test_num,
				$month => $total
			);

			// Finally - update the table with the new adjusted data!
			$this->db->where('studentID', $data['studentID'] /*record id*/);
			$this->db->where('topicID', $data['topicID'] /*record id*/);
			$this->db->update('mem_results' /*tablename*/, $data);
		}

	}
	
	

} //ENDS Section_model class