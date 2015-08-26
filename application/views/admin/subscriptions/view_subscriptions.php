<h1 class="gridHeader strong">Subscriptions</h1>

<div class="gridPadding textPadBoth">
	

	<h1 class="greyArrow textOrange"><strong>Subscriptions</strong></h1>
  <p>Click edit button to modify each Subscription option</p>

	<?php
	// Display all FAQs from database in a definition list
	if( isset($subscriptions) )
	{
		
		foreach( $subscriptions as $row ):
		
			echo '<h1 class="strong">' . $row->name . ' <span class="strong textOrange">$' . $row->price . '</span></h1>';
			echo '<p>' . $row->description . '</p>';
			echo '<p>' . anchor('subscription_con/get_subscription/' . $row->id, 'Edit &rsaquo;&rsaquo;', array('class' => 'butSmall')) .'</p>';
			echo '<div class="horzLine"></div>';
		
		endforeach;
		
	}
	?>
	
	
</div>