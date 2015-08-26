<h1 class="gridHeader_grey">Set a Class Message for: <span class="non_bold"><?php echo get_class_name( $this->session->userdata('classID') ); ?></span></h1>

<div class="grid_12 alpha gridPadding textPadding">

	<h3 class="bold">Setting Class Messages</h3>
	<p class="bold">This section allows you as a teacher to set instructions for your class. When students from your class log in, they are presented with this message.</p>
	<ol>
		<li>Select the class group you wish to set a message for.</li>
		<li>Click 'Create Message'.</li>
	</ol>

<?php echo form_open('teachers/update_class_message', array('class' => 'bg_classes')); ?>

	<fieldset>
	<legend class="grey">YOUR CLASS MESSAGE</legend>

		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

		<label>Enter the message you would like to present to your students when they login: (leave blank for no message)</label>
		<textarea cols="80" rows="10" name="class_message" id="class_message"><?php echo $class_message->message; ?></textarea>

		<label></label>
		<input type="submit" name="submit" id="submit" value="Submit" class="butSmall" />

	</fieldset>

<?php 
if( isset( $message ) ) 
{ 
	echo $message;
}

echo form_close(); 
?>

</div>