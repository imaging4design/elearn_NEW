<h1 class="gridHeader">Message from eLearn Economics:</h1>

<div class="gridPadding textPadding">

<?php

	if( $this->session->flashdata('error') )
	{
		echo '<h4>' . $this->session->flashdata('error') . '</h4>';
	}
	
	// KEEP THIS THOUGH
	if( $this->session->flashdata('success') )
	{
		echo '<h4>' . $this->session->flashdata('success') . '</h4>';
	}

?>

</div>