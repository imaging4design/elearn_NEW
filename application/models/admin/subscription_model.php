<?php

class Subscription_model extends CI_Model {
	
	function Subscription_model() 
	{
		parent::__construct();
		//stuff here
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_subscriptions()
	// Gets ALL subscriptions
	/*************************************************************************************/
	function get_subscriptions()
	{
		$this->db->select('*');
		$query = $this->db->get('pp_items');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_subscription()
	// Get SPECIFIC subscription for editing
	/*************************************************************************************/
	function get_subscription()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('pp_items');
		
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
		$this->db->insert('pp_items' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_subscription()
	// Updates the Subscription record
	/*************************************************************************************/
	function update_subscription($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('pp_items' /*tablename*/, $data);
		
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