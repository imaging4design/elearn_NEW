<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/***********************************************************************************************************************************
|
|	TOPIC HELPER FUNCTIONS
|
/***********************************************************************************************************************************/


/********************************************************************/
// FUNCTION show_price()
// This enables us to dynamically display the price of the subscriptions
/********************************************************************/
function show_prices($id)
{
	$CI = &get_instance();
	$CI->load->model('paypal/items_model');
	$var = $CI->items_model->show_prices($id);
	
	//return the data $query
	if($query = $var) 
	{
		echo '<h2>' . $query->name . '</h2>';
		echo '<p><strong>$' . $query->price . '</strong> (incl GST) for the current school year.<br .>';
		echo $query->special_offer . '</p>';
	}
	
}


/********************************************************************/
// FUNCTION topic_label()
// This enables us to display the current Topic name! => converted from the topicID in the URI
/********************************************************************/
function topic_label()
{
	$CI = &get_instance();
	//$CI->load->model('topic_model');
	$var = $CI->section_model->topic_label();
	
	//return the data $query
	if($query = $var) 
	{
		return $query;
	}
	
}


/********************************************************************/
// FUNCTION school_label()
// This enables us to display the current School name! => converted from the schoolID
/********************************************************************/
function school_label()
{
	$CI = &get_instance();
	//$CI->load->model('topic_model');
	$var = $CI->section_model->school_label();
	
	//return the data $query
	if($query = $var) 
	{
		return $query;
	}
	
}


/********************************************************************/
// FUNCTION classDropdown()
// Creates drop down menu for all classes with a selected school
/********************************************************************/
function classDropdown($value='', $selected='', $label='', $default='')
{
	$CI = &get_instance();
	//$CI->load->model('subscribers_model');
	$var = $CI->teachers_model->classDropdown();
	
	$data = array();
	//gets the list of topics to display in left column
	if($query = $var)
	{
		$data = $query;
	}

	echo '<select name="classID" id="classID">';
	
		if($value)
		{
			echo '<option value="'.$value.'"'.set_select('classID', $selected).'>'.$label.'</option>';
		}
		else
		{
			echo '<option value="" selected="selected">'.$default.'</option>';
		}
		
		foreach($data as $row):
			echo '<option value="'.$row->id.'"'.set_select('classID', $row->id).'>'.$row->class_name.'</option>';
		endforeach;	
		
	echo '</select>';
	
}


/********************************************************************/
// FUNCTION monthDropdown()
// Creates drop down menu for the months of the year
/********************************************************************/
function monthDropdown($value='', $selected='', $label='')
{
	$month=array(
		'Jan'=>'January',
		'Feb'=>'February',
		'Mar'=>'March',
		'Apr'=>'April',
		'May'=>'May',
		'Jun'=>'June',
		'Jul'=>'July',
		'Aug'=>'August',
		'Sep'=>'September',
		'Oct'=>'October',
		'Nov'=>'November',
		'Dec'=>'December'
	);

	echo '<select name="month" id="month" class="month form-control">';
			
		if($value)
		{
			echo '<option value="'.$value.'"'.set_select('month', $selected).'>'.$label.'</option>';
		}
		else
		{
			echo '<option value="" selected="selected">'.$label.'</option>';
		}
		
		foreach($month as $key => $value):
			echo '<option value="'.$key.'"'.set_select('month', $key).'>'.$value.'</option>';
		endforeach;


		
	echo '</select>';

}


/********************************************************************/
// FUNCTION monthDropdown()
// Creates drop down menu for the months of the year
/********************************************************************/
function orderDropdown($value='', $selected='', $label='')
{
	$order_options=array(
		'1'=>'Topic Name',
		'2'=>'Best Results',
		'3'=>'Number of Tests'
	);

	echo '<select name="order" id="order" class="order form-control">';
			
		if($value)
		{
			echo '<option value="'.$value.'"'.set_select('order', $selected).'>'.$label.'</option>';
		}
		else
		{
			echo '<option value="" selected="selected">'.$label.'</option>';
		}
		
		foreach($order_options as $key => $value):
			echo '<option value="'.$key.'"'.set_select('order', $key).'>'.$value.'</option>';
		endforeach;


		
	echo '</select>';

}


/********************************************************************/
// FUNCTION NAME :: topicsWithResults()
// Shows ALL Topics that a student has results against - Ignores empty topics with no results
// Used in the show student results area so a huge list of irrelevant topics don't appear
/********************************************************************/
function topicsWithResultsStudents($value='', $selected='', $label='')
{
	$CI = &get_instance();
	//$CI->load->model('topic_model');
	$var = $CI->results_model->topicsWithResultsStudents();
	
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


/********************************************************************/
// FUNCTION NAME :: resultColourCodes()
// Work out colour coded div progress bar for results
// This affects both teachers and students results pages
/********************************************************************/
function resultColourCodes($average_score_percent = NULL)
{

	if( $average_score_percent <= 35)
	{
		$div_colour = 'poor';
	}
	elseif( $average_score_percent > 35 && $average_score_percent <= 70)
	{
		$div_colour = 'good';
	}
	elseif( $average_score_percent > 70 && $average_score_percent <= 84)
	{
		$div_colour = 'satisfactory';
	}
	else
	{
		$div_colour = 'excellent';
	}

	return $div_colour;

}


/********************************************************************/
// FUNCTION class_message()
// This displays the message created by the teacher for their students
// Shows when a student login in - giving them instruction what to do for their studies
/********************************************************************/
function class_message()
{
	$CI = &get_instance();
	$CI->load->model('site/teachers_model');
	$var = $CI->teachers_model->class_message();
	
	//return the data $query
	if($query = $var) 
	{
		return $query;
	}
	
}


/********************************************************************/
// FUNCTION get_class_name()
// NAME :: get_class_name()
// Converts the 'classID' into the actual 'Class Name'
/********************************************************************/
function get_class_name($data)
{
	$CI = &get_instance();
	$CI->load->model('site/teachers_model');
	$var = $CI->teachers_model->get_class_name($data);
	
	//return the class_name
	if($query = $var) 
	{
		return $query->class_name;
	}
	
}



/********************************************************************/
// FUNCTION get_bestScore_menu()
// NAME :: get_bestScore_menu()
// Gets the Students best score in each topic to show on the main menn of topics
/********************************************************************/
function get_bestScore_menu($student)
{
	$CI = &get_instance();
	$CI->load->model('site/results_model');
	$var = $CI->results_model->get_bestScore_menu($student);

	//return the data $query
	// if($query = $var) 
	// {
	// 	return $query->Jan;
	// }
	//$p = NULL;
	//return the data $query
	if($query = $var) 
	{
		// $full = array($query->Jan, $query->Feb, $query->Mar);
		// foreach($full as $n)
		// {
		// 	$p .= $n;
		// }
		return $query;
		//return $p;
	}
	
}
