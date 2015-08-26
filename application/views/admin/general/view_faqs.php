<h1 class="gridHeader strong">FAQs</h1>

<div class="gridPadding textPadBoth">

	<?php
	// Back button
	echo anchor('general_con/load_editor/', 'Add New &rsaquo;&rsaquo;', array('class' => 'butSmall butRight'));
	?>
	
	<h1 class="greyArrow textOrange"><strong>Manage FAQs</strong></h1>
  <p>Click edit button to modify each FAQ</p>

	<?php
	// Display all FAQs from database in a definition list
	if( isset($faqs) )
	{
		echo '<dl>';
		
		foreach($faqs as $row):
		
			echo '<dt class="admin"><strong>' . $row->order . ' ) ' . $row->question . '</strong></dt>';
			echo '<dd>' . $row->answer . anchor('general_con/get_faqs/' . $row->id, 'Edit &rsaquo;&rsaquo;', array('class' => 'butSmall butLeft')) . '</dd>';
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