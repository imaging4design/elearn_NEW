<h1 class="gridHeader strong">Topics</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('topic_con/add_topics', 'Add Topic', array('class' => 'butSmall butRight'));
	?>

	<h1 class="greyArrow textOrange"><strong>Edit Topic</strong></h1>
	<p>Edit Topic name details below</p>
	
	<?php echo form_open('topic_con/edit_topics/' . $this->uri->segment(3)); ?>
	
	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
	<input type="hidden" name="topicID" id="topicID" value="<?php echo $find_topic->topicID; ?>" />
	
	<fieldset>
	<legend>CHANGE TOPIC NAME</legend>
		<label for"topic"><strong>Topic Name:</strong></label>
		<input name="topic" type="text" id="topic" size="40" value="<?php echo $find_topic->topic; ?>" />

		<?php 
			// Display 'Topic Level' checkboxes
			// i.e., NCEA Level 1, NCEA Level 2 .. etc 
			// Shows checkboxes either checked or unchecked - depending on their saved state
			// See admin_helper - show_levels()
			echo find_levels();
		?>

		<button id="Togglebutton" class="butSmall" style="margin-bottom:15px;">Check All</button>
		
		<label for"super"><strong>Super Topic:</strong></label>
		<input type="radio" name="super" id="super" value="true" <?php if($find_topic->super == 'true') { echo 'checked = \"checked\"'; } ?> /> Yes
		<input type="radio" name="super" id="super" value="false" <?php if($find_topic->super == 'false') { echo 'checked = \"checked\"'; } ?> /> No
	</fieldset>
	
	<div class="containerArea" style="margin-top:10px;">
		<input type="submit" id="submit" value="Update Topic" class="butSmall" />
	</div>
			
	
	<?php
	// Display error message
	if( isset($error))
	{ 
		echo $error; 
	}
	
	echo form_close();
	?>
		

</div>

<script>
//Toggle check boxes on/off
$(document).ready(function() {
	$(function () {
		$('#Togglebutton').toggle(
			function() {
				$('.checkBoxes').prop('checked', true);
			},
			function() {
				$('.checkBoxes').prop('checked', false);
			}
		);
	});
});
</script>