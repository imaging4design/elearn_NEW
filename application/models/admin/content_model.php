<?php

class Content_model extends CI_Model {
	
	function Content_model() 
	{
		parent::__construct();
		//stuff here
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
	// FUNCTION NAME :: get_topic_title()
	// Gets the 'Topic Name' to display as title on pages where selected
	/*************************************************************************************/
	function get_topic_title($data)
	{
		$this->db->select('*');
		$this->db->where('topicID', $data);
		$query = $this->db->get('ad_topics');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_records()
	// Gets ALL records for category (i.e., Key Notes, Flash, Multi-Choice etc)
	/*************************************************************************************/
	function get_records($data)
	{
		$this->db->select('*');
		$this->db->from( $data['table'] );
		$this->db->where('topicID', $data['id']);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}
	
	
	
	

} //ENDS Content_model class