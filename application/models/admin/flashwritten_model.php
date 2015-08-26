<?php

class Flashwritten_model extends CI_Model {
	
	function Flashwritten_model() 
	{
		parent::__construct();
		//stuff here
	}
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_flash_written()
	// Get the Flash Written Question to be edited
	/*************************************************************************************/
	function get_flash_written()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('con_flash_written');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_flash_written()
	// Adds a new Flash Written
	/*************************************************************************************/
	function add_flash_written($data)
	{
		$this->db->insert('con_flash_written' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_flash_written()
	// Updates the Flash Written record
	/*************************************************************************************/
	function update_flash_written($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('con_flash_written' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_flash_written()
	// Deletes the Flash Written
	/*************************************************************************************/
	function delete_flash_written()
	{
		$this->db->where('id', $this->uri->segment(3) /*record id*/);
		$this->db->delete('con_flash_written' /*tablename*/);
	}
	
	
	

} //ENDS Content_model class