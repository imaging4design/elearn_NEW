<h1 class="gridHeader strong">Key Notes</h1>

<div class="gridPadding textPadBoth keyNotes">

<?php
	// Back button
	echo anchor('keynotes_con/load_editor/' . $this->uri->segment(4), 'Add New &rsaquo;&rsaquo;', array('class' => 'butSmall butRight'));
	echo anchor('content_con/index/key_notes', '&lsaquo;&lsaquo; Back', array('class' => 'butSmall butBack'));
?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
	<p>Click edit button to modify each set of Key Notes</p>
 
<?php
	if( isset($records) )
	{
		foreach( $records as $row ):

			if( $row->on_off == 'false')
			{
				$on_off = '<p class="bold textRed">(Off)</p>';
			}
			else
			{
				$on_off = FALSE;
			}
		
			echo $row->content . ' ' . $on_off;
			echo anchor('keynotes_con/get_key_notes/' . $row->id . '/' . $this->uri->segment(4), 'Edit &rsaquo;&rsaquo;', array('class' => 'butSmall butLeft'));
			echo '<div class="horzLine"></div>';
			
		endforeach;
	}
?>

</div>

<!--JAVASCRIPT - USED TO ALTERNATE THE COLOUR OF TABLE ROWS ABOVE-->
<script>
	$('tr:even').css('background', '#FAFAFA');
</script>