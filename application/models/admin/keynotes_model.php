<?php

class Keynotes_model extends CI_Model {
	
	function Keynotes_model() 
	{
		parent::__construct();
		//stuff here
	}
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_key_notes()
	// Get the set of Key Notes to be edited
	/*************************************************************************************/
	function get_key_notes()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('con_key_notes');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_key_notes()
	// Adds a new Key Note(s)
	/*************************************************************************************/
	function add_key_notes($data)
	{
		$this->db->insert('con_key_notes' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_key_notes()
	// Update the Key Note(s)
	/*************************************************************************************/
	function update_key_notes($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('con_key_notes' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_key_notes()
	// Deletes the Key Note(s)
	/*************************************************************************************/
	function delete_key_notes()
	{
		$this->db->where('id', $this->uri->segment(3) /*record id*/);
		$this->db->delete('con_key_notes' /*tablename*/);
	}
	
	
	
	

} //ENDS Content_model class