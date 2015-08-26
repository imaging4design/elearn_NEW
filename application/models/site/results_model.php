<?php

class Results_model extends CI_Model {
	
	function Main_model() 
	{
		parent::__construct();
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: topicsWithResults()
	// Shows ALL Topics that a student has results against - Ignores empty topics with no results
	// Used in the show student results area so a huge list of irrelevant topics don't appear
	/*************************************************************************************/
	function topicsWithResultsStudents()
	{
		$this->db->where('mem_results.studentID', $this->session->userdata('studentID'));
		$this->db->or_where('mem_results.studentID', $this->uri->segment(3));
		$this->db->join('mem_results', 'mem_results.topicID = ad_topics.topicID');
		$this->db->group_by('ad_topics.topicID'); //NEWLEY ADDED 20/03/2014
		$this->db->order_by('ad_topics.topic', 'ASC');
		$query = $this->db->get('ad_topics');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: results_by_topic()
	// Displays ALL results for a single selected topic - for 12 months
	/*************************************************************************************/
	function results_by_topic()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(test_date, '%d %b %Y') AS test_date", FALSE);
		$this->db->where('mem_results.topicID', $this->input->post('topic'));
		$this->db->where('mem_results.studentID', $this->session->userdata('studentID'));
		$query = $this->db->get('mem_results');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// NAME :: results_by_month()
	// Displays ALL results for topics studied by selected month
	/*************************************************************************************/
	function results_by_month()
	{
		//$month = date('M');
		//$n_month = 'n_'.date('M');

		$month = $this->input->post('month');
		$n_month = 'n_'.$this->input->post('month');

		// Word out how to order the results
		if($this->input->post('order') == 1) 
		{
			$order = "ad_topics.topic ASC";
		}
		elseif($this->input->post('order') == 2)
		{
			$order = "mem_results.$month DESC";
		}
		else
		{
			$order = "mem_results.$n_month DESC";
		}

		$this->db->select('*');
		$this->db->select("DATE_FORMAT(test_date, '%d %b %Y') AS test_date", FALSE);
		$this->db->where('mem_results.studentID', $this->session->userdata('studentID'));
		$this->db->join('ad_topics', 'ad_topics.topicID = mem_results.topicID');
		$this->db->order_by($order);
		$query = $this->db->get('mem_results');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
		
	}


	/*************************************************************************************/
	// NAME :: leaders_school()
	// Displays leading topic results for students school
	/*************************************************************************************/
	function leaders_school( $month )
	{
		// Get topicID / month from either POST value or uri->segment(3) ------------------------/
		$topic = ( $this->input->post('topic') ) ? $this->input->post('topic') : $this->uri->segment(3);
		//-------------------------------------------------------------------------------/

		$this->db->select('*');
		$this->db->select("DATE_FORMAT(test_date, '%d %b %Y') AS test_date", FALSE);

		$this->db->where('mem_results.topicID', $topic);
		$this->db->where('mem_results.n_'.$month . ' >=', 5);  // Must have completed at least 5 tests!
		//$this->db->where('mem_results.'.$month . ' !=', 0);  // Must have a score greater than 0

		$this->db->where('mem_students.schoolID', $this->session->userdata('schoolID'));
		$this->db->where('mem_students.leaderboard', 1);

		$this->db->join('mem_students', 'mem_students.studentID = mem_results.studentID');
		$this->db->join('ad_schools', 'ad_schools.id = mem_students.schoolID');

		$this->db->order_by($month, 'DESC');
		$this->db->order_by('n_'.$month, 'DESC');

		$this->db->order_by('test_date', 'ASC');
		$this->db->limit(50);
		
		$query = $this->db->get('mem_results');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: leaders_national()
	// Displays leading topic results for national schools
	/*************************************************************************************/
	function leaders_national( $month )
	{
		// Get topicID / month from either POST value or uri->segment(3) ------------------------/
		$topic = ( $this->input->post('topic') ) ? $this->input->post('topic') : $this->uri->segment(3);
		//-------------------------------------------------------------------------------/
		
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(test_date, '%d %b %Y') AS test_date", FALSE);

		$this->db->where('mem_results.topicID', $topic);
		$this->db->where('mem_results.n_'.$month . ' >=', 5);  // Must have completed at least 5 tests!
		//$this->db->where('mem_results.'.$month . ' !=', 0);  // Must have a score greater than 0

		$this->db->where('mem_students.leaderboard', 1);

		$this->db->join('mem_students', 'mem_students.studentID = mem_results.studentID');
		$this->db->join('ad_schools', 'ad_schools.id = mem_students.schoolID');

		$this->db->order_by($month, 'DESC');
		$this->db->order_by('n_'.$month, 'DESC');

		$this->db->order_by('test_date', 'ASC');
		$this->db->limit(50);
		
		$query = $this->db->get('mem_results');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}





	/*************************************************************************************/
	// FUNCTION NAME :: stats()
	// Displays No. of students subscribed and the No. of tests they have completed
	// Needed for home page stats
	/*************************************************************************************/

	// Loop through all results i.e., all months and count number of tests ..
	function stats()
	{
		$this->db->select('n_Jan, n_Feb, n_Mar, n_Apr, n_May, n_Jun, n_Jul, n_Aug, n_Sep, n_Oct, n_Nov, n_Dec');
		$query = $this->db->get('mem_results');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}



	
	

} //ENDS Results_model class