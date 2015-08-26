<h1 class="gridHeader strong">Audio Video</h1>

<div class="gridPadding textPadBoth">

<?php
	// Back button
	echo anchor('audiovideo_con/load_editor/' . $this->uri->segment(4), 'Add New &rsaquo;&rsaquo;', array('class' => 'butSmall butRight'));
	echo anchor('content_con/index/audio_video', '&lsaquo;&lsaquo; Back', array('class' => 'butSmall butBack'));
?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  	<p>Click edit button to modify each Audio Video file</p>
 
<?php
	$count = 1;
	
	if( isset($records) )
	{
		foreach( $records as $row ):

			if( $row->on_off == 'false')
			{
				$on_off = '<span class="bold textRed">(Off)</span>';
			}
			else
			{
				$on_off = FALSE;
			}
		
			echo '<h5><strong>' . $count . ') ' . $row->fileName . ' ' . $on_off . '</strong></h5>';
			echo anchor('audiovideo_con/get_audio_video/' . $row->id . '/' . $this->uri->segment(4), 'Edit &rsaquo;&rsaquo;', array('class' => 'butSmall butLeft'));
			echo '<h5>&nbsp;</h5>';
			
			$count++;
			
		endforeach;
	}
?>

</div>