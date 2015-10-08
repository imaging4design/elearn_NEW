<?php

class General_model extends CI_Model {
	
	function General_model() 
	{
		parent::__construct();
		//stuff here
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: show_faqs()
	// Displays the FAQs
	/*************************************************************************************/
	function show_faqs()
	{
		$this->db->select('*');
		$this->db->order_by('order', 'ASC');
		$query = $this->db->get('ad_faqs');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	
	/*************************************************************************************/
	// FUNCTION NAME :: get_faqs()
	// Get the set of FAQs to be edited
	/*************************************************************************************/
	function get_faqs()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('ad_faqs');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_faqs()
	// Adds a new FAQ
	/*************************************************************************************/
	function add_faqs($data)
	{
		$this->db->insert('ad_faqs' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_faqs()
	// Update the FAQ
	/*************************************************************************************/
	function update_faqs($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('ad_faqs' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_faqs()
	// Deletes the FAQ
	/*************************************************************************************/
	function delete_faqs()
	{
		$this->db->where('id', $this->uri->segment(3) /*record id*/);
		$this->db->delete('ad_faqs' /*tablename*/);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: view_latest_news()
	// Retrieves ALL of the Latest News
	/*************************************************************************************/
	function view_latest_news()
	{
		$this->db->select('*');
		$this->db->select("DATE_FORMAT(created_at, '%d %b %Y') AS created_at", FALSE);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('ad_latest_news');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: add_news()
	// Adds a new Latest News Article
	/*************************************************************************************/
	function add_news($data)
	{
		$this->db->insert('ad_latest_news' /*tablename*/, $data);
	}



	/*************************************************************************************/
	// FUNCTION NAME :: get_news()
	// Get the set of Latest News to be edited
	/*************************************************************************************/
	function get_news()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('ad_latest_news');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: update_news()
	// Update the Latest News Article
	/*************************************************************************************/
	function update_news($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('ad_latest_news' /*tablename*/, $data);
		
	}



	/*************************************************************************************/
	// FUNCTION NAME :: delete_news()
	// Deletes the Latest News Article
	/*************************************************************************************/
	function delete_news()
	{
		$this->db->where('id', $this->uri->segment(3) /*record id*/);
		$this->db->delete('ad_latest_news' /*tablename*/);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: clean_out()
	// Deletes ALL Students and their Results by 'Hemisphere' (i.e., Northern or Southern)
	/*************************************************************************************/
	function clean_out($data)
	{
		$query = $this->db->query("
			DELETE mem_students, mem_results
			FROM mem_students
			INNER JOIN mem_results
				ON mem_results.studentID = mem_students.studentID
			WHERE mem_students.season = ".$data['season']."
		");

		$this->db->where('season', $data['season'] /*record id*/);
		$this->db->delete('mem_students' /*tablename*/);
	}


	

} //ENDS Subscribers_model class