<h1 class="gridHeader strong">Flash Written</h1>

<div class="gridPadding textPadLeft">
	
  <?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'],'&lsaquo;&lsaquo; Back', array('class' => 'butSmall butRight'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  
  <?php echo form_open('flashwritten_con/add_flash_written'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="topicID" id="topicID" value="<?php echo $this->uri->segment(3); ?>" />
      
      <fieldset>
      <legend>QUESTION</legend>
        <textarea name="question" id="question" rows="4" style="width:98%;"><?php echo set_value('question'); ?></textarea>
      </fieldset>
      
      <fieldset>
      <legend>ANSWER</legend>
        <textarea name="answer" id="answer" rows="4" style="width:98%;"><?php echo set_value('answer'); ?></textarea>
      </fieldset>
      
      <fieldset>
      <legend>ADDITIONAL OPTIONS</legend>
        <label for"image"><strong>Image:</strong></label>
        <input type="text" name="image" id="image" style="width:20%;" value="<?php echo set_value('image'); ?>" />
      
        <label for"on_off"><strong>On / Off:</strong></label>
        <input type="radio" name="on_off" id="on_off" value="true" <?php echo set_radio('on_off', 'true'); ?> /> On
        <input type="radio" name="on_off" id="on_off" value="false" <?php echo set_radio('on_off', 'false', TRUE); ?> /> Off
       </fieldset>
      
      
      <div class="containerArea" style="margin-top:10px;">
        <input type="submit" id="submit" value="Add Content" class="butSmall" />
      </div>
    
    </div>
    
  <?php echo form_close(); ?>
  
</div>



<!--JQUERY AJAX UPDATE SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#container').append('<img src="<?php echo base_url() . '/images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

	var token = $('#token').val();
	var topicID = $('#topicID').val();
	var question = $('#question').val();
	var answer = $('#answer').val();
	var image = $('#image').val();
	var on_off = document.getElementById('on_off').checked;
	
	
	$.ajax({
		url: '<?php echo base_url() . 'flashwritten_con/add_flash_written'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&topicID=' + topicID
		+ '&question=' + escape(question)
		+ '&answer=' + escape(answer)
		+ '&image=' + image
		+ '&on_off=' + on_off,
		
		success: 	function(result) {
				
								$('#response').remove();
								$('.containerArea').append('<span id="response">' + result + '</span>');
								$('#loading').fadeOut(500, function() {
									$(this).remove();
								});
								
						}
				});
		
		return false;
		
	});
	
	});
</script>