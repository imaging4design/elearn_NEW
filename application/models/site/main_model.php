<?php

class Main_model extends CI_Model {
	
	function Main_model() 
	{
		parent::__construct();
		
	}


	/*************************************************************************************/
	// NAME :: news()
	// FUNCTION :: gets the Latest News Article to display on home page
	/*************************************************************************************/
	function news()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('ad_latest_news');
		
		if($query->num_rows() >0)
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: all_news()
	// FUNCTION :: gets ALL Latest News Articles to display on news page (As intro snippets only)
	/*************************************************************************************/
	function all_news()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(30);
		$query = $this->db->get('ad_latest_news');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}

	/*************************************************************************************/
	// NAME :: news_full()
	// FUNCTION :: gets the FULL 'single' news article to display
	/*************************************************************************************/
	function news_full()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('ad_latest_news');

		if($query->num_rows() == 1) 
		{
			return $query->row();
		}
		
	}
	
	
	/*************************************************************************************/
	// NAME :: faqs()
	// FUNCTION :: gets ALL FAQs to display
	/*************************************************************************************/
	function faqs()
	{
		$this->db->order_by('order', 'ASC');
		$query = $this->db->get('ad_faqs');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// NAME :: login_member_student()
	// FUNCTION :: Logs (MEMBER) student in
	/*************************************************************************************/
	function login_member_student()
	{
		$this->db->where('email', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$this->db->where('blockUser', 'false');
		$this->db->join('ad_schools', 'ad_schools.id = mem_students.schoolID');
		$query = $this->db->get('mem_students');
		
		if($query->num_rows() == 1) 
		{
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// NAME :: login_guest_student()
	// FUNCTION :: Logs (GUEST) student in
	/*************************************************************************************/
	function login_guest_student()
	{
		$this->db->where('student_user', $this->input->post('student_user'));
		$this->db->where('student_pass', md5($this->input->post('student_pass')));
		$this->db->where('block_user', 'false');
		$this->db->join('ad_schools', 'ad_schools.id = mem_schools.schoolID');
		$query = $this->db->get('mem_schools');
		
		if($query->num_rows == 1)
		{
			//return true;
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// NAME :: login_teacher()
	// FUNCTION :: Logs (ADMIN) teacher in
	/*************************************************************************************/
	function login_teacher()
	{
		$this->db->where('admin_user', $this->input->post('admin_user'));
		$this->db->where('admin_pass', md5($this->input->post('admin_pass')));
		$this->db->join('ad_schools', 'ad_schools.id = mem_schools.schoolID');
		$query = $this->db->get('mem_schools');
		
		if($query->num_rows == 1)
		{
			//return true;
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// NAME :: vaildate_username()
	// Used for lost password reset function - checks to see if the user (email) actaully exists!
	/*************************************************************************************/
	function vaildate_username()
	{
		$this->db->where('email', $this->input->post('username'));
		$query = $this->db->get('mem_students');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}


	/*************************************************************************************/
	// NAME :: edit_options()
	// Gets the student details from database to populate the 'Edit Options' page form
	/*************************************************************************************/
	function edit_options()
	{
		$this->db->select('*');
		$this->db->where('studentID', $this->session->userdata('studentID'));
		$this->db->join('ad_courses', 'ad_courses.id = mem_students.courseID');
		$this->db->join('ad_schools', 'ad_schools.id = mem_students.schoolID');
		$query = $this->db->get('mem_students');
		
		if($query->num_rows >0)
		{
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: add_random_string()
	// Adds a random string to mem_students so this can e sent back via email link when they reset their password
	/*************************************************************************************/
	function add_random_string($random)
	{
		$this->db->where('email', $random['email'] /*record id*/);
		$this->db->update('mem_students' /*tablename*/, $random);
	}


	/*************************************************************************************/
	// NAME :: find_temp_code_match()
	// Works out if the user trying to reset their password is legitimate by comparuing temp_code value with email
	/*************************************************************************************/
	function find_temp_code_match($data)
	{
		$this->db->select('*');
		$this->db->where('email', $data['email']);
		$this->db->where('temp_code', $data['temp_code']);
		$query = $this->db->get('mem_students');
		
		if($query->num_rows >0)
		{
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// NAME :: update_options()
	// Updates the student details to the database
	/*************************************************************************************/
	function update_options($data)
	{
		$this->db->where('studentID', $data['studentID'] /*record id*/);
		$this->db->update('mem_students' /*tablename*/, $data);
	}
	
	
	

} //ENDS Main_model class