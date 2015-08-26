<?php

class Studentspdf_model extends CI_Model {
	
	function Main_model() 
	{
		parent::__construct();
		
	}


	/*************************************************************************************************************************************************************************/
	// SECTION BELOW IS FOR RETRIEVING AND DISPLAYING RESULTS FOR THE TEACHER
	/*************************************************************************************************************************************************************************/

	/*************************************************************************************/
	// FUNCTION NAME :: getclass_results()
	// Get results for SINGLE student -> send to results_PDF()
	/*************************************************************************************/
	function getstudent_results()
	{
		$this->db->select('*');
		$this->db->where('mem_students.studentID', $this->input->post('studentID'));
		$this->db->join('mem_results', 'mem_results.studentID = mem_students.studentID');
		//$this->db->join('mem_classes', 'mem_classes.id = mem_students.classID');
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

	
	

} //ENDS Studentspdf_model class