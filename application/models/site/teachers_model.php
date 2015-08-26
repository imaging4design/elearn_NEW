<?php

class Teachers_model extends CI_Model {
	
	function Main_model() 
	{
		parent::__construct();
		
	}


	/*************************************************************************************************************************************************************************/
	// SECTION BELOW IS FOR TEACHER ADMIN WHEN THEY ARE SETTING CLASS MESSAGES (SPECIFIC TO EACH CLASS)
	/*************************************************************************************************************************************************************************/

	/*************************************************************************************/
	// NAME :: class_message()
	// This displays the message created by the teacher for his/her students
	// Displays when a student logs in - giving them instructions on what to do for their studies
	/*************************************************************************************/
	function class_message()
	{
		$studentID = $this->session->userdata('studentID');

		$this->db->select('first_name, class_name, message');
		$this->db->where('mem_students.studentID', $studentID);
		$this->db->join('mem_students', 'mem_students.classID = mem_classes.id', 'left');
		$query = $this->db->get('mem_classes');

		if($query->num_rows() >0)
		{
			return $query->row();
		}
	}


	/*************************************************************************************/
	// NAME :: update_class_message()
	// This updates the class message in the database
	/*************************************************************************************/
	function update_class_message($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('mem_classes' /*tablename*/, $data);
	}


	/*************************************************************************************/
	// NAME :: class_message()
	// This displays the message created by the teacher for his/her students
	// Displays when a student logs in - giving them instructions on what to do for their studies
	/*************************************************************************************/
	function get_class_message()
	{
		$this->db->select('*');
		$this->db->where('mem_classes.id', $this->session->userdata('classID') );
		$query = $this->db->get('mem_classes');

		if($query->num_rows() >0)
		{
			return $query->row();
		}
	}


	/*************************************************************************************/
	// NAME :: get_class_name()
	// Gets the 'Class Name / Teacher name' to display on printed reports
	/*************************************************************************************/
	function get_class_name($data)
	{
		$this->db->select('*');
		$this->db->where('mem_classes.id', $data);
		$query = $this->db->get('mem_classes');

		if($query->num_rows() >0)
		{
			return $query->row();
		}
	}





	/*************************************************************************************************************************************************************************/
	// SECTION BELOW IS FOR RETRIEVING AND DISPLAYING RESULTS FOR THE TEACHER
	/*************************************************************************************************************************************************************************/


	/*************************************************************************************/
	// NAME :: show_class_students()
	// Show ALL students from current school (i.e., Rosmini College) and selected class (i.e., Mr Jones)
	/*************************************************************************************/
	function show_class_students()
	{
		$this->db->select('*');
		$this->db->where('mem_students.schoolID', $this->session->userdata('schoolID'));
		$this->db->where('mem_students.classID', $this->session->userdata('classID'));
		$this->db->join('mem_results', 'mem_results.studentID = mem_students.studentID', 'left');
		$this->db->group_by('mem_students.studentID');
		$this->db->order_by('last_name', 'ASC');
		$query = $this->db->get('mem_students');

		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}


	/*************************************************************************************/
	// NAME :: single_student_details()
	// Returns details about a single student. Useful for displayng their name etc
	/*************************************************************************************/
	function single_student_details()
	{
		$this->db->select('*');
		$this->db->where('studentID', $this->uri->segment(3));
		$query = $this->db->get('mem_students');

		if($query->num_rows() >0)
		{
			return $query->row();
		}
	}


	/*************************************************************************************/
	// NAME :: remember_teacher()
	// This remembers the teachers name - required for the 'Class' drop down menu
	/*************************************************************************************/
	function remember_teacher()
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
		$this->db->where('n_'.$this->input->post('month') . ' !=', 0); // Only get results if num tests greater than 0!
		$this->db->where('mem_students.classID', $this->session->userdata('classID'));

		$this->db->join('mem_students', 'mem_students.studentID = mem_results.studentID');
		$this->db->order_by($this->input->post('month'), 'DESC'); // Order by month score DESC
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

		$this->db->where('mem_results.studentID', $this->uri->segment(3));
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
	// NAME :: results_by_topic()
	// Displays ALL results for a single selected topic - for 12 months
	/*************************************************************************************/
	function results_by_topic()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(test_date, '%d %b %Y') AS test_date", FALSE);
		$this->db->where('mem_results.topicID', $this->input->post('topic'));
		$this->db->where('mem_results.studentID', $this->uri->segment(3));
		$query = $this->db->get('mem_results');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}









	/*************************************************************************************************************************************************************************/
	// SECTION BELOW IS FOR TEACHER ADMIN WHEN THEY ARRANGE STUDENTS INTO CLASS GROUPS
	/*************************************************************************************************************************************************************************/


	/*************************************************************************************/
	// NAME :: classDropdown()
	// Creates drop down menu for all classes with a selected school
	/*************************************************************************************/
	function classDropdown()
	{
		$this->db->select('*');
		$this->db->where('schoolID', $this->session->userdata('schoolID'));
		$this->db->order_by('class_name', 'ASC');
		$query = $this->db->get('mem_classes');

		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}


	/*************************************************************************************/
	// NAME :: create_class()
	// Creates a new class group for a school
	/*************************************************************************************/
	function create_class($data)
	{
		$this->db->insert('mem_classes' /*tablename*/, $data);
		// Collect the new insertID as a session var!
		$this->session->set_userdata('class_id', $this->db->insert_id());
	}


	/*************************************************************************************/
	// NAME :: rename_class()
	// Renames an existing class
	/*************************************************************************************/
	function rename_class($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('mem_classes' /*tablename*/, $data);
	}


	/*************************************************************************************/
	// NAME :: group_students()
	// Puts selected students into a class group
	/*************************************************************************************/
	function group_students($data)
	{
		$this->db->where('studentID', $data['studentID'] /*record id*/);
		$this->db->update('mem_students' /*tablename*/, $data);
		
	}


	/*************************************************************************************/
	// NAME :: show_students()
	// Get ALL students from current school (i.e., Rosmini College) to display on Group Students page
	// Also determines if they have any results against their name for the current month
	/*************************************************************************************/
	function show_students()
	{
		$this->db->select('*');
		$this->db->where('schoolID', $this->session->userdata('schoolID'));
		$this->db->order_by('last_name', 'ASC');
		$query = $this->db->get('mem_students');

		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}


	
	
	

} //ENDS Teachers_model class