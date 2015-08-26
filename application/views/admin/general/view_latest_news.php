
<h1 class="gridHeader strong">Latest News</h1>

<div class="gridPadding textPadBoth">

<?php
	// Back button
	echo anchor('general_con/load_news_editor/', 'Add New &rsaquo;&rsaquo;', array('class' => 'butSmall butRight'));
?>

	<h1 class="greyArrow textOrange"><strong>Latest News</strong></h1>
	<p>Click edit button to modify Latest News</p>

	<?php
	// Display all FAQs from database in a definition list
	if( isset($latest_news) )
	{
		echo '<dl>';

		foreach($latest_news as $row):

			echo '<dt class="admin"><strong>' . $row->title . ' | Date: ' . $row->created_at . '</strong></dt>';
			echo '<dd>' . $row->content . anchor('general_con/get_news/' . $row->id, 'Edit &rsaquo;&rsaquo;', array('class' => 'butSmall butLeft')) . '</dd>';
			echo '<div class="underLine" style="margin:5px 30px; 0 30px;"></div>';

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