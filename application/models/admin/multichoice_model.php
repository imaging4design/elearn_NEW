<?php

class Multichoice_model extends CI_Model {
	
	function Multichoice_model() 
	{
		parent::__construct();
		//stuff here
	}
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_multi_choice()
	// Get the Multi Coice Question to be edited
	/*************************************************************************************/
	function get_multi_choice()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('con_multi_choice');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_multi_choice()
	// Adds a new Multi Choice
	/*************************************************************************************/
	function add_multi_choice($data)
	{
		$this->db->insert('con_multi_choice' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_multi_choice()
	// Updates the Multi Choice record
	/*************************************************************************************/
	function update_multi_choice($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('con_multi_choice' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_multi_choice()
	// Deletes the Multi Choice
	/*************************************************************************************/
	function delete_multi_choice()
	{
		$this->db->where('id', $this->uri->segment(3) /*record id*/);
		$this->db->delete('con_multi_choice' /*tablename*/);
	}
	
	
	

} //ENDS Multichoice_model class