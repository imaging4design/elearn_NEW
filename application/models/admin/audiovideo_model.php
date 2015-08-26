<?php

class Audiovideo_model extends CI_Model {
	
	function Audiovideo_model() 
	{
		parent::__construct();
		//stuff here
	}
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: get_audio_video()
	// Get the Audio Video file to be edited
	/*************************************************************************************/
	function get_audio_video()
	{
		$this->db->select('*');
		$this->db->where('id', $this->uri->segment(3));
		$query = $this->db->get('con_audio_video');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_audio_video()
	// Adds a new Audio Video
	/*************************************************************************************/
	function add_audio_video($data)
	{
		$this->db->insert('con_audio_video' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: update_audio_video()
	// Updates the Audio Video record
	/*************************************************************************************/
	function update_audio_video($data)
	{
		$this->db->where('id', $data['id'] /*record id*/);
		$this->db->update('con_audio_video' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: delete_audio_video()
	// Deletes the Audio Video
	/*************************************************************************************/
	function delete_audio_video()
	{
		$this->db->where('id', $this->uri->segment(3) /*record id*/);
		$this->db->delete('con_audio_video' /*tablename*/);
	}
	
	
	

} //ENDS Audiovideo_model class