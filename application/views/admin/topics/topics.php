<h1 class="gridHeader">Topics</h1>

<div class="gridPadding textPadBoth">

<?php 
	echo anchor('topic_con/add_topics', 'Add Topic', array('class' => 'butSmall butRight'));
?>

<h1 class="greyArrow"><strong>Edit a Topic</strong></h1>
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
					
					$segments = array( 'topic_con/edit_topics/' . $row->topicID);
		
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
  



	<div class="horzLine"></div>
	<h1 class="greyArrow"><strong>Edit a Sub Topic</strong></h1>
  <p>Click on the topic you wish to edit</p>

  <?php
	$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$letters = str_split($alphabet);
	$set_letter = FALSE;
	
	// Display full list of topics in alphabetical order with letter (A, B, C) as heading
	if( isset($subTopics) )
	{
	
		$results = count($subTopics);
		$per_column = ceil($results/4);
		
		$i = 0;
		echo '<table cellspacing="0" cellpadding="0" border="0" width="100%" >';
		echo '<tr valign="top">';
		echo '<td width=25%>';
		
		/*************************************************************************/
		// Loop through each topic alphbetically
		/*************************************************************************/
		foreach($subTopics as $row) {
		
			 if($i == $per_column)
			 {
					echo '</td><td width=25%>';
					$i = 0;
			 }
			 
					/*************************************************************************/
					// Break topics up by each letter of alphabet - Use letter (A, B, C ..) as label
					/*************************************************************************/
					foreach($letters as $letter):
					
					$segments = array( 'topic_con/edit_subTopics/' . $row->subTopicID . '/' . $row->topicID );
		
						if( substr($row->subTopic, 0, 1) == $letter )
						{
							// Only show new alpha letter at the start of each alpha category
							$alpha_header = ( $set_letter != $letter ) ? $letter : ''; 
							// Display alpha letter (i.e., A, B, C ...)
							echo '<h4 class="strong textOrange" style="margin:0;">' . $alpha_header . '</h4>';
							// Display Topic Name
							//echo '<h5>' . anchor('admin/admin_con/edit_subTopics/' . url_title($row->subTopic) . '/' . $row->subTopicID, $row->subTopic, array('class' => 'non')) . '</h5>';
							echo '<h6>' . anchor($segments, $row->subTopic, array('class' => 'non')) . '</h6>';
							
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