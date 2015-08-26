<h1 class="gridHeader strong">Multi Choice</h1>

<div class="gridPadding textPadBoth">
	
  <?php
	// Back button
	echo anchor('multichoice_con/load_editor/' . $this->uri->segment(4), 'Add New &rsaquo;&rsaquo;', array('class' => 'butSmall butRight'));
	echo anchor('content_con/index/multi_choice', '&lsaquo;&lsaquo; Back', array('class' => 'butSmall butBack'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  	<p>Click edit button to modify each Multi Choice Question</p>

	<?php
	$count = 1;
	
	// Set up image icon to indicate an image exists with the question
	$image_icon = array(
		'src' => $this->css_path_url . 'admin/icons/16/illustration.png',
		'style' => 'float:right;'
	);
	
	
	// Display all FAQs from database in a definition list
	if( isset($records) )
	{
		echo '<dl>';
		
		foreach($records as $row):

			if( $row->on_off == 'false')
			{
				$on_off = '<span class="bold textRed"> - (Off)</span>';
			}
			else
			{
				$on_off = FALSE;
			}
			
			// Display image only if it exists!
			if( $row->image )
			{
				$image = array(
					'src' => 'images/images/' . $row->image,
					'width' => 400,
					'height' => 267,
					'alt' => $row->image,
					'class' => 'image'
				);
				
				// If image exists - create vars for image and image icon
				$show_image = img($image);
				$show_icon = img($image_icon);
			}
			else
			{
				// Don't display image and image icon
				$show_image = FALSE;
				$show_icon = FALSE;
			}
			
			$opt1 = ($row->opt1 == $row->answer) ? '<strong>'.$row->opt1.'</strong>' : $row->opt1;
			$opt2 = ($row->opt2 == $row->answer) ? '<strong>'.$row->opt2.'</strong>' : $row->opt2;
			$opt3 = ($row->opt3 == $row->answer) ? '<strong>'.$row->opt3.'</strong>' : $row->opt3;
			$opt4 = ($row->opt4 == $row->answer) ? '<strong>'.$row->opt4.'</strong>' : $row->opt4;
			
			$options = 'a) ' . $opt1 . '<br />b) ' . $opt2 . '<br />c) ' . $opt3 . '<br />d) ' . $opt4;
			$reason = '<span class="reason"><em>'.$row->reason.'</em></span>';
			$edit = anchor('multichoice_con/get_multi_choice/' . $row->id . '/' . $this->uri->segment(4), 'Edit &rsaquo;&rsaquo;', array('class' => 'butSmall'));
		
			echo '<dt class="admin">' . $show_icon . '<strong>' . $count . ') ' . $row->question . ' ' . $on_off . '</strong></dt>';
			echo '<dd class="admin">' . $options . ' ' . $reason . ' ' . $show_image . ' ' . $edit . '</dd>';
			echo '<div class="underLine" style="margin:5px 30px; 0 30px;"></div>';
			
			$count++;
			
		endforeach;
		
		echo '</dl>';
	}
	?>
	
	
</div>


<script>
/*******************************************/
/* SHOW / HIDE FAQ Question and answers
/*******************************************/
(function(){
	
	$('dd').filter(':nth-child(n+4)').hide(); 	/* Hide all but the first FAQ answer */
	$('dt:first-child').addClass('textOrange');	/* Highlight the first question orange */ 
	
	$('dl').on('click', 'dt', function(){
																		 
		$('dt').removeClass('textOrange');	/* Remove orange highlight from previous question */											 
																								 
		$(this).addClass('textOrange')			/* Add orange highligh to new selected question */
				.next()
					.slideDown(200)
					.siblings('dd')
						.slideUp(200);
	})
	
					
})();
</script>