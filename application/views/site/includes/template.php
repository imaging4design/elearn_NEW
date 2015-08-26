<?php
$this->css_path_url = base_url().'css/css_images/'; //CSS image path

/************************************************************/
//START IMPORTING WEBSITE SECTIONS
/************************************************************/
$this->load->view('site/includes/header'); //Header and meta info

// Display View Progress / Edit Options header (if student logged in)
if( $this->session->userdata('logged_in') ==1)
{
	$this->load->view('site/includes/section_header');
}

// Display admin header (if teacher logged in)
if( $this->session->userdata('logged_in_admin') ==1)
{
	$this->load->view('site/includes/section_header_admin');
}

//Insert the 'Sections' menu only in the following pages
$section_menu = array(
	'key_notes', 
	'audio_video', 
	'flash_cards', 
	'written_answers', 
	'multi_choice',
	);

	if(in_array($this->uri->segment(2), $section_menu) )
	{
		$this->load->view('site/includes/section_menu');
	}

$this->load->view($main_content); //Main content

$this->load->view('site/includes/footer'); //Footer info

?>