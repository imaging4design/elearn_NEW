<h1 class="gridHeader strong">Edit Content</h1>

<div class="gridPadding textPadBoth">

	<?php
	// Format Title / Heading
	$title = humanize( $this->uri->segment(3) );
	
	$kn = array(
		'src' => $this->css_path_url . 'admin/icons/16/attibutes.png',
		'alt' => 'Key Notes',
		'style' => 'text-align:center;'
	);
	
	$av = array(
		'src' => $this->css_path_url . 'admin/icons/16/showreel.png',
		'alt' => 'Audio Video',
		'class' => 'post_images',
	);
	
	$fw = array(
		'src' => $this->css_path_url . 'admin/icons/16/brainstorming.png',
		'alt' => 'Flash Written',
		'class' => 'post_images',
	);
	
	$mc = array(
		'src' => $this->css_path_url . 'admin/icons/16/credit-card.png',
		'alt' => 'Multi Choice',
		'class' => 'post_images',
	);
	
	$format = array('class' => 'butSmall butRight');
	
	// Change modes
	echo anchor('content_con/index/multi_choice', img($mc) .' Multi Choice', $format);
	echo anchor('content_con/index/flash_written', img($fw) .' Flash / Written', $format);
	echo anchor('content_con/index/audio_video', img($av) .' Audio / Video', $format);
	echo anchor('content_con/index/key_notes', img($kn) .' Key Notes', $format);
	?>
  
  <h1 class="greyArrow textOrange"><strong><?php echo $title; ?></strong></h1>
  <p>Click on the topic you wish to edit</p>

  <?php
	$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$letters = str_split($alphabet);
	$set_letter = FALSE;
	
	// Display full list of topics in alphabetical order with letter (A, B, C) as heading
	if( isset($topics) )
	{
	
		$results = count($topics);
		$per_column = ceil($results/3);
		
		$i = 0;
		echo '<table cellspacing="0" cellpadding="0" border="0" width="100%" >';
		echo '<tr valign="top">';
		echo '<td width=33%>';
		
		/*************************************************************************/
		// Loop through each topic alphbetically
		/*************************************************************************/
		foreach($topics as $row) {
		
			 if($i == $per_column)
			 {
					echo '</td><td width=33%>';
					$i = 0;
			 }
			 
					/*************************************************************************/
					// Break topics up by each letter of alphabet - Use letter (A, B, C ..) as label
					/*************************************************************************/
					foreach($letters as $letter):
					
					$segments = array( 'content_con/get_records/' . $this->uri->segment(3) . '/' . $row->topicID . '/' . url_title($row->topic) );
		
						if( substr($row->topic, 0, 1) == $letter )
						{
							// Only show new alpha letter at the start of each alpha category
							$alpha_header = ( $set_letter != $letter ) ? $letter : ''; 
							// Display alpha letter (i.e., A, B, C ...)
							echo '<h4 class="strong textOrange" style="margin:0;">' . $alpha_header . '</h4>';
							// Display Topic Name
							echo '<h5 class="strong">' . anchor( $segments, $row->topic, array('class' => 'non strong') ) . '</h5>';
							echo '<div class="underLine"></div>';
							// Save alpha letter as var to test against looped through version above
							$set_letter = $letter; 
						}
						
					endforeach;
					
					/*************************************************************************/
			 
			 $i++;
			 
		}
		
		echo '</td>';
		echo '</tr>';
		echo '</table>';
	
	}
	
?>

</div>