<h1 class="gridHeader strong">Audio Video</h1>

<div class="gridPadding textPadLeft">
	
  <?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'],'&lsaquo;&lsaquo; Back', array('class' => 'butSmall butRight'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  
  <?php echo form_open('audiovideo_con/add_audio_video'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="topicID" id="topicID" value="<?php echo $this->uri->segment(3); ?>" />
      
      <fieldset>
      <legend>ADD NEW AUDIO / VIDEO DETAILS</legend>
        <label for"fileName"><strong>Video File:</strong></label>
        <input type="text" name="fileName" id="fileName" style="width:40%;" value="<?php echo set_value('fileName'); ?>" />
        
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
	var fileName = $('#fileName').val();
	var on_off = document.getElementById('on_off').checked;
	
	
	$.ajax({
		url: '<?php echo base_url() . 'audiovideo_con/add_audio_video'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&topicID=' + topicID
		+ '&fileName=' + fileName
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