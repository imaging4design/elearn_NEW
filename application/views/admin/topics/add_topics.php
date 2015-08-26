<h1 class="gridHeader strong">Topics</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('topic_con/show_topics', 'Edit Topic', array('class' => 'butSmall butRight'));
		echo anchor('topic_con/add_topics', 'Add Topic', array('class' => 'butSmall butRight'));
	?>

	<h1 class="greyArrow textOrange"><strong>Create New Topics</strong></h1>
	<p>Add or edit topics below</p>
	
	<?php echo form_open('topic_con/add_topics'); ?>
	
	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
	
	<fieldset>
	<legend>ADD NEW TOPIC</legend>
		<label for"topic_name"><strong>Topic Name:</strong></label>
		<input name="topic_name" type="text" id="topic_name" size="60" value="<?php echo set_value('topic_name'); ?>" />

		<?php
		// Display 'Topic Level' checkboxes
		// i.e., NCEA Level 1, NCEA Level 2 .. etc 
		// See admin_helper - show_levels()
		echo show_levels()
		?>

		<button id="Togglebutton" class="butSmall">Check All</button>
		
	</fieldset>
	
	<div class="containerArea" style="margin-top:10px;">
		<input type="submit" id="submit" value="Add Topic" class="butSmall" />
	</div>
	
	
	<?php
	// Display error message
	if( isset($error))
	{ 
		echo $error; 
	}
	
	echo form_close();
	?>
	
	
	<?php echo form_open('topic_con/add_subTopics'); ?>
	
	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
	
	<fieldset>
		<legend>ADD NEW SUB TOPIC</legend>
		<label for"topic"><strong>Select a Parent Topic:</strong></label>
		<?php echo dropDownTopics('', '', 'List of Topics'); // See admin_helper ?>
		
		<label for"subTopic"><strong>Sub-Topic Name:</strong></label>
		<input name="subTopic" type="text" id="subTopic" size="60" value="<?php echo set_value('subTopic'); ?>" />
	</fieldset>
	
	<div class="containerArea" style="margin-top:10px;">
		<input type="submit" id="submit" value="Add Sub-Topic" class="butSmall" />
	</div>
	
	
	<?php
	// Display error message
	if( isset($error_sub))
	{ 
		echo $error_sub; 
	}
	
	echo form_close();
	?>

</div>

<script>
// Toggles checkboxes on/off
$(document).ready(function() {
	$('#Togglebutton').click(function(e) {
		e.preventDefault();
		$('.checkBoxes').each(function() {
		$(this).attr('checked',!$(this).attr('checked'));
		});
	});
});
</script>