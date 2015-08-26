<h1 class="gridHeader strong">Sub Topics</h1>

<div class="gridPadding textPadLeft">

	<?php 
    echo anchor('topic_con/add_topics', 'Add Topic', array('class' => 'butSmall butRight'));
  ?>

  <h1 class="greyArrow textOrange"><strong>Edit Sub Topic</strong></h1>
  <p>Edit Sub Topic name details below</p>
  
  <?php echo form_open('topic_con/edit_subTopics/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)); ?>
  
  <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
  <input type="hidden" name="subTopicID" id="subTopicID" value="<?php echo $find_subTopic->subTopicID; ?>" />
  
  <fieldset>
  <legend>CHANGE SUB TOPIC NAME</legend>
    <!--Find the Parent Topic to dynamically populate the 'topic' dropdown - from find_topic( $data ) // admin_helper-->
    <label for"topic"><strong>Parent Topic:</strong></label>
    <?php echo dropDownTopics($find_topic->topicID, $find_topic->topicID, $find_topic->topic); // See topic_helper ?>
    
    <!--Find the Sub Topic to dynamically populate the 'subTopic' field - from find_subTopic( $data ) // admin_helper-->
    <label for"subTopic"><strong>Sub-Topic Name:</strong></label>
    <input name="subTopic" type="text" id="subTopic" size="40" value="<?php echo $find_subTopic->subTopic; ?>" />
  </fieldset>
  
  <div class="containerArea" style="margin-top:10px;">
    <input type="submit" id="submit" value="Update Sub Topic" class="butSmall" />
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