<div class="band-white">
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
</div><!--ENDS band-white-->


<!-- BLOCK non paid users from downloading PDF resources in Key Notes -->
<?php if( ! $this->session->userdata('studentID')) { ?>
		
	<script>
		$('a.pdf').removeAttr("href").html('PDFs are available to fully subscribed members only.');
	</script>

<?php } ?>