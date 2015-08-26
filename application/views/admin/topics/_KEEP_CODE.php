<h1 class="gridHeader">Topics List</h1>

<div class="gridPadding textPadding">

  <?php
	$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$letters = str_split($alphabet);
	$set_letter = FALSE;
	
	// Display full list of topics in alphabetical order with letter (A, B, C) as heading
	if( isset($topics) )
	{
		foreach($topics as $row):
		
			foreach($letters as $letter):
			
				if( substr($row->topic, 0, 1) == $letter )
				{
					// Only show new alpha letter at the start of each alpha category
					$alpha_header = ($set_letter != $letter) ? $letter : ''; 
					// Display alpha letter (i.e., A, B, C ...)
					echo '<p style="margin:0;"><strong>' . $alpha_header . '</strong></p>'; 
					// Display Topic Name
					echo '<h5>' . $row->topic . '</h5>'; 
					// Save alpha letter as var to test against looped through version above
					$set_letter = $letter; 
				}
				
			endforeach;
			
		endforeach;
	}
	
	?>
  

</div>