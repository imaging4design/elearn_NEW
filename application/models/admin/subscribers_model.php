<?php

class Subscribers_model extends CI_Model {
	
	function Subscribers_model() 
	{
		parent::__construct();
		//stuff here
	}



	/*********************************************************************************************************************************************************************/
	// THIS IS THE SECTION WHERE THE SUBSCRIBER IS ADDED TO THE DATABASE!
	/*********************************************************************************************************************************************************************/

	/********************************************************************/
	// FUNCTION check_key($check_key)
	// Checks to see if a VALID key_code exists against the new member - before they can be added
	/********************************************************************/
	function check_key($check_key)
	{
		$query = $this->db->query("
			SELECT * 
			FROM pp_purchases
			WHERE redeemed = 'false' AND (key_code = '" . $check_key . "'  OR paypal_txn_id = '" . $check_key . "' )
		");

		if($query->num_rows() >0) 
		{
			return $query->row();
		}

	}



	/********************************************************************/
	// FUNCTION check_codes($data)
	// Checks to see if a VALID 'Access Code' exists - before they can be added
	/********************************************************************/
	function check_codes($data_code)
	{
		$this->db->select('codeID');
		$this->db->where('access_code', $data_code['access_code']); // Does the code match one in the database?
		$this->db->where('status', 0); // Has it been prviously used?
		$query = $this->db->get('mem_codes');

		if($query->num_rows() >0) 
		{
			$row = $query->row();
			return $row->codeID;
		}

	}



	/*************************************************************************************/
	// FUNCTION NAME :: update_code_status($data_code)
	// Deletes the Access Code the new member student has just used to register with
	/*************************************************************************************/
	function update_code_status($code_status)
	{
		$update_status = array(
			'status' => 1
			);

		$this->db->where('codeID', $code_status /*record id*/);
		$this->db->update('mem_codes' /*tablename*/, $update_status);
	}



	/********************************************************************/
	// FUNCTION add_member($data)
	// Adds a new student member to the database - after successful payment from PayPal
	/********************************************************************/
	function add_member($data)
	{
		$this->db->insert('mem_students' /*tablename*/, $data);
	}



	/********************************************************************/
	// FUNCTION update_purchase()
	// Update the pp_purchases table redeemed field from 'false' to 'true' so no more members can be added to this 'key_code' / 'txn_id'
	/********************************************************************/
	function update_purchases($update)
	{
		$this->db->where('email', $update['email'] /*record id*/);
		$this->db->update('pp_purchases' /*tablename*/, $update);
	}



	/*********************************************************************************************************************************************************************/
	// (ENDS) THIS IS THE SECTION WHERE THE SUBSCRIBER IS ADDED TO THE DATABASE!
	/*********************************************************************************************************************************************************************/




	
	
	
	/********************************************************************/
	// FUNCTION get_auto_students()
	// Retrieves ALL student names for 'auto-populate' jQuery drop down
	/********************************************************************/
	function get_auto_students()
	{
		// Search term 'athletes' from jQuery
		$students = $this->input->post('students');
		
		// Search from table called clients
		$this->db->select('*');
		$this->db->like('last_name', $students, 'after');
		
		$this->db->join('ad_schools', 'ad_schools.id = mem_students.schoolID');
		
		$this->db->order_by('last_name', 'ASC');
		$this->db->order_by('first_name', 'ASC');
		$query = $this->db->get('mem_students');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
	
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_student_details()
	// Displays the Students personal details
	/*************************************************************************************/
	function get_student_details($data)
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->where('studentID', $data['studentID']);
		$this->db->join('ad_schools', 'ad_schools.id = mem_students.schoolID');
		$this->db->join('ad_courses', 'ad_courses.id = mem_students.courseID');
		$query = $this->db->get('mem_students');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: get_student_from_school()
	// Displays ALL students from teh selected school - via their schoolID
	/*************************************************************************************/
	function get_student_from_school($data)
	{
		$this->db->select('*');
		$this->db->where('schoolID', $data['schoolID']);
		$this->db->order_by('last_name', 'ASC');
		$query = $this->db->get('mem_students');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_school_details()
	// Displays the School details
	/*************************************************************************************/
	function get_school_details($data)
	{
		$this->db->select('*');
		$this->db->select("mem_schools.id AS schoolAdminID", FALSE); // need this otherwise both tables have 'id' fields! (they clash)
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->where('ad_schools.id', $data['schoolID']);
		$this->db->join('ad_schools', 'ad_schools.id = mem_schools.schoolID');
		$query = $this->db->get('mem_schools');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: schools_dropdown()
	// Gets the 'Schools' and puts them into a dropdown menu
	/*************************************************************************************/
	function schools_dropdown()
	{
		$this->db->select('*');
		$this->db->order_by('school', 'ASC');
		$query = $this->db->get('ad_schools');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: mem_schools_dropdown()
	// Gets the member 'Schools' only and puts them into a dropdown menu
	/*************************************************************************************/
	function mem_schools_dropdown()
	{
		$this->db->select('*');
		$this->db->order_by('ad_schools.school', 'ASC');
		$this->db->join('ad_schools', 'ad_schools.id = mem_schools.schoolID');
		$this->db->group_by('ad_schools.id');
		$query = $this->db->get('mem_schools');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: codes_schools_dropdown()
	// Gets all Codes grouped by School
	/*************************************************************************************/
	function codes_schools_dropdown()
	{
		$this->db->select('*');
		$this->db->order_by('ad_schools.school', 'ASC');
		$this->db->join('ad_schools', 'ad_schools.id = mem_codes.schoolID');
		$this->db->group_by('ad_schools.id');
		$query = $this->db->get('mem_codes');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: courses_dropdown()
	// Gets all Courses available for students
	/*************************************************************************************/
	function courses_dropdown()
	{
		$this->db->select('*');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('ad_courses');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_school()
	// Adds a new School
	/*************************************************************************************/
	function add_school($data)
	{
		$this->db->insert('ad_schools' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_school_admin()
	// Adds a new School Admin
	/*************************************************************************************/
	function add_school_admin($data)
	{
		$this->db->insert('mem_schools' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_school()
	// Updates the School
	/*************************************************************************************/
	function update_school($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('ad_schools' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: edit_school()
	// Populates form field to edit school admin details
	/*************************************************************************************/
	function edit_school()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('mem_schools');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_school_admin()
	// Updates the School Admin details
	/*************************************************************************************/
	function update_school_admin($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('mem_schools' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: edit_student()
	// Displays the populated form to edit a student
	/*************************************************************************************/
	function edit_student()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->where('studentID', $this->uri->segment(3));
		$this->db->join('ad_schools', 'ad_schools.id = mem_students.schoolID');
		$query = $this->db->get('mem_students');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_student()
	// Updates the Students details
	/*************************************************************************************/
	function update_student($data)
	{
		$this->db->where('studentID', $data['studentID'] /*record id*/);
		$this->db->update('mem_students' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_access_codes()
	// Adds a batch of Access Codes
	/*************************************************************************************/
	function add_access_codes($data)
	{
		$this->db->insert('mem_codes' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: view_access_codes()
	// Displays the Access Codes for the selected school
	/*************************************************************************************/
	function view_access_codes()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->where('schoolID', $this->input->post('schoolID'));
		$this->db->order_by('codeID', 'DESC');
		$this->db->order_by('batch', 'ASC');
		$this->db->join('ad_schools', 'ad_schools.id = mem_codes.schoolID');
		$query = $this->db->get('mem_codes');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_access_codes()
	// Deletes unused Access Codes
	/*************************************************************************************/
	function delete_access_codes($data)
	{
		$this->db->where('codeID', $data['codeID'] /*record id*/);
		$this->db->delete('mem_codes' /*tablename*/);
	}
	
	
	

} //ENDS Subscribers_model class