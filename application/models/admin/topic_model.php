<?php

class Topic_model extends CI_Model {
	
	function Topic_model() 
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
	// FUNCTION NAME :: show_leader_topics()
	// ONLY shows topics that have results against them for the leaderboard
	/*************************************************************************************/
	function show_leader_topics()
	{
		$this->db->join('ad_topics', 'ad_topics.topicID = mem_results.topicID');
		$this->db->group_by('mem_results.topicID');
		$this->db->order_by('ad_topics.topic', 'ASC');
		$query = $this->db->get('mem_results');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: find_topic()
	// Finds details of a 'Specific' Topic
	/*************************************************************************************/
	function find_topic( $data )
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
	// FUNCTION NAME :: show_level()
	// Shows ALL available Topics as list
	/*************************************************************************************/
	function show_level()
	{
		$this->db->select('level_name');
		$this->db->where('id', $this->session->userdata('level_name'));
		$query = $this->db->get('ad_levels');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: show_levels()
	// Shows ALL available Topics as list
	/*************************************************************************************/
	function show_levels()
	{
		$this->db->order_by('order', 'ASC');
		$query = $this->db->get('ad_levels');
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: find_levels()
	// Finds details of a 'Specific' Topic
	/*************************************************************************************/
	function find_levels()
	{
		$this->db->select('*');
		$this->db->where('topicID', $this->uri->segment(3));
		$query = $this->db->get('ad_topics');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_topics()
	// Adds a new Topic
	/*************************************************************************************/
	function add_topics($data)
	{
		$this->db->insert('ad_topics' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: edit_topics()
	// Updates the Topic
	/*************************************************************************************/
	function edit_topics($data)
	{
		$this->db->where('topicID', $data['topicID'] /*record id*/);
		$this->db->update('ad_topics' /*tablename*/, $data);
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: admin_show_subTopics()
	// Shows ALL available Sub Topics as list
	/*************************************************************************************/
	function admin_show_subTopics()
	{
		$this->db->select('*');
		$this->db->from('ad_subTopics');
		$this->db->join('ad_topics', 'ad_topics.topicID = ad_subTopics.topicID');
		$this->db->order_by('ad_subTopics.subTopic', 'ASC');
		$query = $this->db->get();
		
		if($query->num_rows() >0) 
		{
			return $query->result();
		}
		
	}


	
	/*************************************************************************************/
	// FUNCTION NAME :: show_subTopics()
	// Shows ALL available Sub Topics as list
	/*************************************************************************************/
	function show_subTopics()
	{
		// Remember the course level the student selected via a session
		if( $this->input->post( 'level_name' ) ) {
			$this->session->set_userdata('level_name', $this->input->post( 'level_name' ));
		}

		$level_type = ( $this->session->userdata( 'level_name' ) ) ? $this->session->userdata( 'level_name' ) : 1; // Get the $_POSTed 'level_name' / type
		
		$query = $this->db->query("
			SELECT * 
			FROM ad_subTopics
			INNER JOIN ad_topics
			ON ad_topics.topicID AND  ad_subTopics.topicID = ad_topics.topicID
			JOIN ad_levels
			WHERE ad_levels.id = ".$level_type." AND find_in_set( '".$level_type."', ad_topics.level_name )
			ORDER BY ad_subTopics.subTopic
		");

		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	}

	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: find_subTopic()
	// Finds details of a 'Specific' Sub Topic
	/*************************************************************************************/
	function find_subTopic( $data )
	{
		$this->db->select('*');
		$this->db->where('subTopicID', $data);
		$query = $this->db->get('ad_subTopics');
		
		if($query->num_rows() >0) 
		{
			return $query->row();
		}
		
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: add_subTopics()
	// Adds a new Sub Topic
	/*************************************************************************************/
	function add_subTopics($data)
	{
		$this->db->insert('ad_subTopics' /*tablename*/, $data);
	}
	
	
	
	/*************************************************************************************/
	// FUNCTION NAME :: edit_subTopics()
	// Updates the Sub Topic
	/*************************************************************************************/
	function edit_subTopics($data)
	{
		$this->db->where('subTopicID', $data['subTopicID'] /*record id*/);
		$this->db->update('ad_subTopics' /*tablename*/, $data);
		
	}


	/*************************************************************************************/
	// FUNCTION NAME :: get_bestScore_menu()
	// Gets the Students best score in each topic to show on the main menn of topics
	/*************************************************************************************/
	function get_bestScore_menu()
	{

		// Remember the course level the student selected via a session
		if( $this->input->post( 'level_name' ) ) {
			$this->session->set_userdata('level_name', $this->input->post( 'level_name' ));
		}

		// This is received from the 'Home page' when they click on a topic level 'link'
		if( $this->uri->segment(2) == 'demo' ) {
			$this->session->set_userdata('level_name', $this->uri->segment(3));
		}


		// Assign $level_type based on above conditions
		if( ! $this->input->post( 'level_name' ) && ! $this->session->userdata( 'level_name' ) ) {
			$level_type = 1;
		}
		else {
			$level_type = ( $this->session->userdata( 'level_name' ) ) ? $this->session->userdata( 'level_name' ) : $this->input->post( 'level_name' );
		}
		

		// If student logged in --> use $studentID else set studentID to 00000
		$studentID = ( $this->session->userdata('studentID') ) ? $this->session->userdata('studentID') : 0; 

	
		$month = date('M'); // Get current month and append below

		$query = $this->db->query("
			SELECT ad_topics.topicID, ad_topics.topic, 
			mem_results.".$month.",
			mem_results.n_".$month."
			FROM mem_results
			RIGHT JOIN ad_topics
			ON mem_results.topicID = ad_topics.topicID AND mem_results.studentID = ".$studentID."
			JOIN ad_levels
			WHERE ad_levels.id = ".$level_type." AND find_in_set( '".$level_type."', ad_topics.level_name )
			ORDER BY ad_topics.topic
		");

		if($query->num_rows() >0) 
		{
			return $query->result();
		}

	}
	
	

} //ENDS Topic_model class