<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

	/***********************************************************************************************************************************
	|
	|	TOPIC HELPER FUNCTIONS
	|
	/***********************************************************************************************************************************/
 	

 	/********************************************************************/
	// FUNCTION admin_show_topics()
	// Shows ALL available Topics as list
	/********************************************************************/
	function admin_show_topics()
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->show_topics();
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}


	/********************************************************************/
	// FUNCTION show_topics()
	// Shows ALL available Topics as list
	/********************************************************************/
	function show_topics()
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		//$var = $CI->topic_model->show_topics();
		$var = $CI->topic_model->get_bestScore_menu();
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}



	/********************************************************************/
	// FUNCTION admin_show_subTopics()
	// Shows ALL available Sub Topics as list
	/********************************************************************/
	function admin_show_subTopics()
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->admin_show_subTopics();
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}



	/********************************************************************/
	// FUNCTION show_subTopics()
	// Shows ALL available Sub Topics as list
	/********************************************************************/
	function show_subTopics()
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->show_subTopics();
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}


	
	/********************************************************************/
	// FUNCTION find_topic()
	// Finds details of a 'Specific' Topic
	/********************************************************************/
	function find_topic( $data )
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->find_topic( $data );
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}
	
	
	
	/********************************************************************/
	// FUNCTION find_subTopic()
	// Finds details of a 'Specific' Sub Topic
	/********************************************************************/
	function find_subTopic( $data )
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->find_subTopic( $data );
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}


	/********************************************************************/
	// FUNCTION show_level()
	// Displays the title of the 'Selected' level from the drop down menu
	/********************************************************************/
	function show_level()
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->show_level();
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}


	/********************************************************************/
	// FUNCTION show_levels()
	// Finds ALL available levels (i.e.,   NCEA Level 1, NCEA Level 2 etc ...)
	/********************************************************************/
	function show_levels()
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->show_levels();

		if($query = $var)
		{
			$data = $query;
		}

		echo '<label for"level_name"><strong>Topic Level:</strong></label>';

		foreach ($data as $row) {
			echo '<label>';
				echo '<input type="checkbox" name="level_name[]" value=" ' . $row->id . ' " '. set_checkbox('level_name[]', $row->id) .' class="checkBoxes" />' . $row->level_name;
			echo '</label>';
		}
		echo '<br />';	

	}


	/********************************************************************/
	// FUNCTION show_levels_dropdown()
	// Finds ALL available levels (i.e.,   NCEA Level 1, NCEA Level 2 etc ...)
	/********************************************************************/
	function show_levels_dropdown($value='', $selected='', $label='')
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->show_levels();

		if($query = $var)
		{
			$data = $query;
		}

		echo '<select name="level_name" id="level_name" class="form-control">';
		
			if($value)
			{
				echo '<option value="'.$value.'"'.set_select('level_name', $selected).'>'.$label.'</option>';
			}
			else
			{
				echo '<option value="" selected="selected">'.$label.'</option>';
			}
			
			foreach($data as $row):
				echo '<option value="'.$row->id.'"'.set_select('level_name', $row->id).'>'.$row->level_name.'</option>';
			endforeach;	
			
		echo '</select>';

	}


	/********************************************************************/
	// FUNCTION find_levels()
	// Finds ALL available levels (i.e.,   NCEA Level 1, NCEA Level 2 etc ...) AND;
	// Makes activate the 'checkboxes' of the previous 'saved' state
	/********************************************************************/
	function find_levels()
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');

		$var = $CI->topic_model->show_levels();
		if($query = $var)
		{
			$data = $query;
		}

		$var2 = $CI->topic_model->find_levels();
		if($query = $var2) 
		{
			$data_cbox = $query; // i.e.,  1,2,6 etc
		}


		$check_me = explode(',', $data_cbox->level_name);

		echo '<label for"level_name"><strong>Topic Level:</strong></label>';
		foreach ($data as $row) {

			// Work out if check box should be checked
			$checked = ( in_array( $row->id, $check_me ) ) ? 'checked' : '';

			echo '<label>';
				echo '<input type="checkbox" name="level_name[]" value=" ' . $row->id . ' " '.$checked.' class="checkBoxes" />' . $row->level_name;				
			echo '</label>';
		}
		echo '<br />';	

	}
	
	
	
	/********************************************************************/
	// FUNCTION dropDownTopics()
	// Creates drop down menu for ALL 'Topics'
	/********************************************************************/
	function dropDownTopics($value='', $selected='', $label='')
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->show_topics();
		
		$data = array();
		//gets the list of topics to display in left column
		if($query = $var)
		{
			$data = $query;
		}
		
		echo '<select name="topic" id="topic">';
		
			if($value)
			{
				echo '<option value="'.$value.'"'.set_select('topic', $selected).'>'.$label.'</option>';
			}
			else
			{
				echo '<option value="" selected="selected">'.$label.'</option>';
			}
			
			foreach($data as $row):
				echo '<option value="'.$row->topicID.'"'.set_select('topic', $row->topicID).'>'.$row->topic.'</option>';
			endforeach;	
			
		echo '</select>';
		
	}



	/********************************************************************/
	// FUNCTION dropDownLeaderboardTopics()
	// Creates drop down menu for 'Topics' on the Leaderboard
	// ONLY shows topics that have results against them!
	/********************************************************************/
	function dropDownLeaderboardTopics($value='', $selected='', $label='')
	{
		$CI = &get_instance();
		//$CI->load->model('topic_model');
		$var = $CI->topic_model->show_leader_topics();
		
		$data = array();
		//gets the list of topics to display in left column
		if($query = $var)
		{
			$data = $query;
		}
		
		echo '<select name="topic" id="topic" class="form-control">';
		
			if($value)
			{
				echo '<option value="'.$value.'"'.set_select('topic', $selected).'>'.$label.'</option>';
			}
			else
			{
				echo '<option value="" selected="selected">'.$label.'</option>';
			}
			
			foreach($data as $row):
				echo '<option value="'.$row->topicID.'"'.set_select('topic', $row->topicID).'>'.$row->topic.'</option>';
			endforeach;	
			
		echo '</select>';
		
	}
	
	
	
	/***********************************************************************************************************************************
	|
	|	CONTENT HELPER FUNCTIONS
	|
	/***********************************************************************************************************************************/
	
	/********************************************************************/
	// FUNCTION get_topic_title()
	// Gets the 'Topic Name' to display as title on pages where selected
	/********************************************************************/
	function get_topic_title($data)
	{
		$CI = &get_instance();
		//$CI->load->model('content_model');
		$var = $CI->content_model->get_topic_title($data);
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}
	
	
	
	/********************************************************************/
	// FUNCTION get_records()
	// Gets ALL records for category (i.e., Key Notes, Flash, Multi-Choice etc)
	/********************************************************************/
	function get_records($data)
	{
		$CI = &get_instance();
		//$CI->load->model('content_model');
		$var = $CI->content_model->get_records($data);
		
		//return the data $query
		if($query = $var) 
		{
			return $query;
		}
		
	}
	
	
	
	/***********************************************************************************************************************************
	|
	|	MEMBER HELPER FUNCTIONS
	|
	/***********************************************************************************************************************************/
	
	/********************************************************************/
	// FUNCTION schools_dropdown()
	// Gets the 'Schools' and puts them into a dropdown menu
	/********************************************************************/
	function schools_dropdown($value='', $selected='', $label='')
	{
		$CI = &get_instance();
		//$CI->load->model('subscribers_model');
		$var = $CI->subscribers_model->schools_dropdown();
		
		$data = array();
		//gets the list of topics to display in left column
		if($query = $var)
		{
			$data = $query;
		}
		
		echo '<select name="schoolID" id="schoolID">';
		
			if($value)
			{
				echo '<option value="'.$value.'"'.set_select('schoolID', $selected).'>'.$label.'</option>';
			}
			else
			{
				echo '<option value="" selected="selected">'.$label.'</option>';
			}
			
			foreach($data as $row):
				echo '<option value="'.$row->id.'"'.set_select('schoolID', $row->id).'>'.$row->school.'</option>';
			endforeach;	
			
		echo '</select>';
		
	}
	
	
	
	/********************************************************************/
	// FUNCTION mem_schools_dropdown()
	// Gets the member 'Schools' only and puts them into a dropdown menu
	/********************************************************************/
	function mem_schools_dropdown($value='', $selected='', $label='')
	{
		$CI = &get_instance();
		//$CI->load->model('subscribers_model');
		$var = $CI->subscribers_model->mem_schools_dropdown();
		
		$data = array();
		//gets the list of topics to display in left column
		if($query = $var)
		{
			$data = $query;
		}
		
		echo '<select name="schoolID" id="schoolID">';
		
			if($value)
			{
				echo '<option value="'.$value.'"'.set_select('schoolID', $selected).'>'.$label.'</option>';
			}
			else
			{
				echo '<option value="" selected="selected">'.$label.'</option>';
			}
			
			foreach($data as $row):
				echo '<option value="'.$row->id.'"'.set_select('schoolID', $row->id).'>'.$row->school.'</option>';
			endforeach;	
			
		echo '</select>';
		
	}
	
	
	
	/********************************************************************/
	// FUNCTION codes_schools_dropdown()
	// Gets all Codes grouped by School
	/********************************************************************/
	function codes_schools_dropdown($value='', $selected='', $label='')
	{
		$CI = &get_instance();
		//$CI->load->model('subscribers_model');
		$var = $CI->subscribers_model->codes_schools_dropdown();
		
		$data = array();
		//gets the list of topics to display in left column
		if($query = $var)
		{
			$data = $query;
		}
		
		echo '<select name="schoolID" id="schoolID">';
		
			if($value)
			{
				echo '<option value="'.$value.'"'.set_select('schoolID', $selected).'>'.$label.'</option>';
			}
			else
			{
				echo '<option value="" selected="selected">'.$label.'</option>';
			}
			
			foreach($data as $row):
				echo '<option value="'.$row->id.'"'.set_select('schoolID', $row->id).'>'.$row->school.'</option>';
			endforeach;	
			
		echo '</select>';
		
	}



	/********************************************************************/
	// FUNCTION courses_dropdown()
	// Gets all Courses available for students
	/********************************************************************/
	function courses_dropdown($value='', $selected='', $label='')
	{
		$CI = &get_instance();
		//$CI->load->model('subscribers_model');
		$var = $CI->subscribers_model->courses_dropdown();
		
		$data = array();
		//gets the list of topics to display in left column
		if($query = $var)
		{
			$data = $query;
		}
		
		echo '<select name="courseID" id="courseID">';
		
			if($value)
			{
				echo '<option value="'.$value.'"'.set_select('courseID', $selected).'>'.$label.'</option>';
			}
			else
			{
				echo '<option value="" selected="selected">'.$label.'</option>';
			}
			
			foreach($data as $row):
				echo '<option value="'.$row->id.'"'.set_select('courseID', $row->id).'>'.$row->course.'</option>';
			endforeach;	
			
		echo '</select>';
		
	}