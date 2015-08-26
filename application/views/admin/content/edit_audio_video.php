<h1 class="gridHeader strong">Audio Video</h1>

<div class="gridPadding textPadLeft">
	
  <?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'], '&lsaquo;&lsaquo; Back', array('class' => 'butSmall butRight'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  
  <?php echo form_open('audiovideo_con/update_audio_video'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="id" id="id" value="<?php echo $audio_video->id; ?>" />
      
      <fieldset>
      <legend>EDIT AUDIO / VIDEO DETAILS</legend>
        <label for"fileName"><strong>Image:</strong></label>
        <input type="text" name="fileName" id="fileName" style="width:40%;" value="<?php echo $audio_video->fileName; ?>" />
        
        <label for"on_off"><strong>On / Off:</strong></label>
        <input type="radio" name="on_off" id="on_off" value="true" <?php if($audio_video->on_off == 'true') { echo 'checked = \"checked\"'; } ?> /> On
        <input type="radio" name="on_off" id="on_off" value="false" <?php if($audio_video->on_off == 'false') { echo 'checked = \"checked\"'; } ?> /> Off
      </fieldset>
      
      <input type="submit" id="submit" value="Update Content" class="butSmall" />
      
      <div class="containerArea" style="margin-top:10px;"></div>
    
    </div>
    
  <?php echo form_close(); ?>
  
  
  
  <?php echo form_open('audiovideo_con/delete_audio_video/' . $audio_video->id); ?>

    <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
  
    <input type="button" id="submit_del" value="Delete this item?" class="butSmall" />
    <input type="submit" id="delete" value="Yes Delete!" class="butSmall" />
    
  <?php echo form_close(); ?>
  

</div>



<!--JQUERY AJAX UPDATE SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#container').append('<img src="<?php echo base_url() . '/images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
	
	
	var token = $('#token').val();
	var id = $('#id').val();
	var fileName = $('#fileName').val();
	var on_off = document.getElementById('on_off').checked;
	
	
	$.ajax({
		url: '<?php echo base_url() . 'audiovideo_con/update_audio_video'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&id=' + id
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

<script>

(function(){
					
	$('#delete').hide(); /*Hide the actual Delete button*/
	
	$('#submit_del').on('click', function(){
		$('#delete').toggle();
	})


})();

</script>