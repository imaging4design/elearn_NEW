<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

			<?php

				/********************************************************************************************************/
				// DISPLAY MAIN CONTENT (KEY NOTES)
				/********************************************************************************************************/

				echo '<div class="key-notes">'; // So we can target content only for styling
				
				if( isset($key_notes))
				{
					foreach($key_notes as $row):

						echo $row->content;
						
					endforeach;
				}

				echo '</div>';
			
			?>

		</div><!--ENDS col-->
	</div><!--ENDS row-->
</div><!--ENDS container-->
