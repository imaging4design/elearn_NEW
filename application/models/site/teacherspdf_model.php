<?php

class Teacherspdf_model extends CI_Model {
	
	function Main_model() 
	{
		parent::__construct();
		
	}


	/*************************************************************************************************************************************************************************/
	// SECTION BELOW IS FOR RETRIEVING AND DISPLAYING RESULTS FOR THE TEACHER
	/*************************************************************************************************************************************************************************/

	/*************************************************************************************/
	// FUNCTION NAME :: getStudentsInClass()
	// Get ALL students in selected class
	/*************************************************************************************/
	function getclass_results()
	{
		//$this->db->select('*');
		$this->db->select(
			'mem_students.studentID,
			Jan,
			Feb,
			Mar,
			Apr,
			May,
			Jun,
			Jul,
			Aug,
			Sep,
			Oct,
			Nov,
			Dec,
			first_name,
			last_name,
			mem_results.topicID,
			topic,
			test_date,
			n_Jan,
			n_Feb,
			n_Mar,
			n_Apr,
			n_May,
			n_Jun,
			n_Jul,
			n_Aug,
			n_Sep,
			n_Oct,
			n_Nov,
			n_Dec'

		);
		$this->db->where('mem_classes.id', $this->session->userdata('classID'));
		$this->db->join('mem_results', 'mem_results.studentID = mem_students.studentID');
		$this->db->join('mem_classes', 'mem_classes.id = mem_students.classID');
		$this->db->join('ad_topics', 'ad_topics.topicID = mem_results.topicID');

		$this->db->order_by('last_name', 'ASC');
		$this->db->order_by('mem_results.studentID', 'ASC', 'topic', 'ASC');
		$this->db->order_by('topic', 'ASC');

		$query = $this->db->get('mem_students');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}



	function getstudent_results()
	{
		//$this->db->select('*');
		$this->db->select(
			'mem_students.studentID,
			Jan,
			Feb,
			Mar,
			Apr,
			May,
			Jun,
			Jul,
			Aug,
			Sep,
			Oct,
			Nov,
			Dec,
			first_name,
			last_name,
			mem_results.topicID,
			topic,
			test_date,
			n_Jan,
			n_Feb,
			n_Mar,
			n_Apr,
			n_May,
			n_Jun,
			n_Jul,
			n_Aug,
			n_Sep,
			n_Oct,
			n_Nov,
			n_Dec'
		);
		$this->db->where('mem_students.studentID', $this->uri->segment(3));
		$this->db->join('mem_results', 'mem_results.studentID = mem_students.studentID');
		$this->db->join('mem_classes', 'mem_classes.id = mem_students.classID');
		$this->db->join('ad_topics', 'ad_topics.topicID = mem_results.topicID');

		$this->db->order_by('last_name', 'ASC');
		$this->db->order_by('topic', 'ASC');

		$query = $this->db->get('mem_students');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}









	/*************************************************************************************/
	// FUNCTION NAME :: show_topics()
	// Shows ALL available Topics as list
	/*************************************************************************************/
	function show_topics()
	{
		$this->db->order_by('topic', 'ASC');
		$query = $this->db->get('ad_topics');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: get_class_name()
	// Gets the 'Class Name / Teacher name' to display on printed reports
	/*************************************************************************************/
	function get_class_name()
	{
		$this->db->select('*');
		$this->db->where('mem_classes.id', $this->session->userdata('classID'));
		$query = $this->db->get('mem_classes');

		if($query->num_rows() >0)
		{
			return $query->row();
		}
	}


	/*************************************************************************************/
	// NAME :: class_topic_results()
	// Displays results for ALL student in a class for a selected topic
	/*************************************************************************************/
	function class_topic_results()
	{
		$this->db->select(
			'mem_students.studentID,
			Jan,
			Feb,
			Mar,
			Apr,
			May,
			Jun,
			Jul,
			Aug,
			Sep,
			Oct,
			Nov,
			Dec,
			email,
			first_name,
			last_name,
			topicID,
			test_date,
			n_Jan,
			n_Feb,
			n_Mar,
			n_Apr,
			n_May,
			n_Jun,
			n_Jul,
			n_Aug,
			n_Sep,
			n_Oct,
			n_Nov,
			n_Dec'
			);
		$this->db->where('mem_results.topicID', $this->input->post('topic'));
		$this->db->where('mem_students.classID', $this->input->post('classID'));

		$this->db->join('mem_students', 'mem_students.studentID = mem_results.studentID');

		$this->db->order_by('mem_students.last_name', 'ASC'); // Order by month score DESC
		$query = $this->db->get('mem_results');

		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}


	/*************************************************************************************/
	// NAME :: single_student_results()
	// Displays results for a SINGLE student - shows ALL topics for month
	/*************************************************************************************/
	function single_student_results()
	{
		$month = ($this->input->post('month')) ? $this->input->post('month') : date('M');
		$n_month = ($this->input->post('month')) ? 'n_'.$this->input->post('month') : 'n_'.date('M');
		$studentID = ($this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('studentID');

		// Work out how to order the results
		if($this->input->post('order') == 3) 
		{
			$order = "mem_results.$n_month DESC";
		}
		elseif($this->input->post('order') == 2)
		{
			$order = "mem_results.$month DESC";
		}
		else
		{
			$order = "ad_topics.topic ASC";
		}

		$this->db->select('*');
		$this->db->select("DATE_FORMAT(test_date, '%d %b %Y') AS test_date", FALSE);

		$this->db->where('mem_results.studentID', $studentID);
		$this->db->where($n_month . ' !=', 0); // Only get results if num tests greater than 0!

		$this->db->join('mem_students', 'mem_students.studentID = mem_results.studentID');
		$this->db->join('ad_topics', 'ad_topics.topicID = mem_results.topicID');

		$this->db->order_by($order);
		$query = $this->db->get('mem_results');

		if($query->num_rows() >0)
		{
			return $query->result();
		}

	}


	/*************************************************************************************/
	// NAME :: student_name()
	// Gets the student name to display
	/*************************************************************************************/
	function student_name()
	{
		$studentID = ($this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('studentID');

		$this->db->select('*');
		$this->db->where('studentID', $studentID);
		$query = $this->db->get('mem_students');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// NAME :: student_topic_results()
	// Displays ALL results for ALL topics for ALL months for selected student 
	/*************************************************************************************/
	function student_topic_results()
	{
		$this->db->select('*');

		$this->db->where('mem_students.studentID', $this->input->post('studentID'));
		$this->db->where('mem_students.classID', $this->session->userdata('classID'));

		$this->db->join('mem_students', 'mem_students.studentID = mem_results.studentID');
		$this->db->join('ad_topics', 'ad_topics.topicID = mem_results.topicID');

		$this->db->order_by('topic', 'ASC');

		$query = $this->db->get('mem_results');

		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}


	/*************************************************************************************/
	// NAME :: class_full_results()
	// Displays ALL results for ALL topics for ALL months for ALL students 
	/*************************************************************************************/
	function class_full_results()
	{
		$this->db->select('*');

		$this->db->where('mem_students.classID', $this->input->post('classID'));

		$this->db->join('mem_students', 'mem_students.studentID = mem_results.studentID');
		$this->db->join('ad_topics', 'ad_topics.topicID = mem_results.topicID');

		$this->db->order_by('topic', 'ASC');

		$query = $this->db->get('mem_results');

		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}


	/*************************************************************************************/
	// NAME :: get_class()
	// Gets the 'Class Name / Teacher name' to display on printed reports
	/*************************************************************************************/
	function get_class()
	{
		$this->db->select('*');
		$this->db->where('mem_students.classID', $this->input->post('classID'));
		$this->db->join('mem_results', 'mem_results.studentID = mem_students.studentID');
		$this->db->group_by('mem_students.studentID');
		$this->db->order_by('mem_students.last_name', 'ASC');
		$query = $this->db->get('mem_students');

		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}


} //ENDS Teachers_model class