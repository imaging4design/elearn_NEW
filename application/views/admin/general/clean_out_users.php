<h1 class="gridHeader strong">Database Maintenance</h1>

<div class="gridPadding textPadLeft">
	
	<h1 class="greyArrow textOrange"><strong>Clean Out Users</strong></h1>


	
	<?php echo form_open('general_con/clean_out'); ?>

		<div id="container">
		
			<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
			
			<fieldset>
			<legend>DELETE ALL STUDENTS / RESULTS FROM</legend>
				
				<label for"question">
					<input type="radio" name="season" value="1" <?php echo set_radio('season', '1'); ?> /> <strong>Northern Hemisphere</strong>
				</label>

				<label for"bodyContent">
					<input type="radio" name="season" value="0" <?php echo set_radio('season', '0'); ?> /> <strong>Southern Hemisphere</strong>
				</label>
			
			</fieldset>

			<?php
			// Display message
			if( isset($this->delete_message)) 
			{
				echo $this->delete_message;
			}
			?>
			
			<div class="containerArea" style="margin-top:10px;">
				<input type="button" id="submit_del" value="Delete this item?" class="butSmall" />
    				<input type="submit" id="delete" value="Yes Delete!" class="butSmall" />
			</div>
		
		</div>
		
	<?php echo form_close(); ?>
	
</div>


<script>

(function(){
					
	$('#delete').hide(); /*Hide the actual Delete button*/
	
	$('#submit_del').on('click', function(){
		$('#delete').toggle();
	})


})();

</script>