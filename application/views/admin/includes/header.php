<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8" />
  <title>eLearn Economics | ADMINISTRATOR</title>
  
  <!--CSS STYLE SHEETS-->
  <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'><!--FONTS CSS-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/reset.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/960.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/styles_admin.css" type="text/css" />
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/><!--JQUERY UI CSS-->
  
  <!--JS IMPORTS-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script><!--JQUERY 1.7 MAIN PACK JS-->
  <!--IMPORT JQUERY UI-->
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript" ></script><!--JQUERY UI LIB-->
  
</head>
<body>

<div id="wrap"><!--start wrap-->


<!--START HEADER SECTION-->

<div id=headContainer class="container_12"><!--start headContainer-->

  <div class="grid_6">
		<?php
    // Display eLearn logo - page top left
    $logo = array(
      'src' => $this->css_path_url . 'admin/BGs/logo_head.png',
      'alt' => 'eLearn Economics',
      'width' => '459',
      'height' => '80',
      'style' => 'float:left;'
    );
    
    echo anchor('admin/topic_con', img($logo));
    ?>
  </div> 
  
  <div class="grid_6" style="padding-top:23px;">
  
	<?php
	// Display head nav links ONLY if admin is logged in
	if( $this->session->userdata('is_logged_in')) 
	{
		echo anchor('admin/login_con/logout', 'Log Out', array('class' => 'butSmall butBack')) . ' ' . anchor('admin/topic_con/', 'Main Menu', array('class' => 'butSmall butBack'));
	}
	
	?>
  
  </div>
  
</div><!--end headContainer-->

<!--END HEADER SECTION-->


  

<!--START MAIN BODY SECTION-->

<div id="bodyContainer" class="container_12"><!--start bodyContainer-->
	
  <div id="body" class="grid_12"><!--start body-->
  