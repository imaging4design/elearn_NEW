<h1 class="gridHeader strong">Flash Written</h1>

<div class="gridPadding textPadLeft">
	
  <?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'], '&lsaquo;&lsaquo; Back', array('class' => 'butSmall butRight'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  
  <?php echo form_open('flashwritten_con/update_flash_written'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="id" id="id" value="<?php echo $flash_written->id; ?>" />
      
      <fieldset>
      <legend>QUESTION</legend>
        <textarea name="question" id="question" rows="4" style="width:98%;"><?php echo $flash_written->question; ?></textarea>
      </fieldset>
      
      <fieldset>
      <legend>ANSWER</legend>
        <textarea name="answer" id="answer" rows="4" style="width:98%;"><?php echo $flash_written->answer; ?></textarea>
      </fieldset>
      
      <fieldset>
      <legend>ADDITIONAL OPTIONS</legend>
        <label for"image"><strong>Image:</strong></label>
        <input type="text" name="image" id="image" style="width:20%;" value="<?php echo $flash_written->image; ?>" />
        
        <label for"on_off"><strong>On / Off:</strong></label>
        <input type="radio" name="on_off" id="on_off" value="true" <?php if($flash_written->on_off == 'true') { echo 'checked = \"checked\"'; } ?> /> On
        <input type="radio" name="on_off" id="on_off" value="false" <?php if($flash_written->on_off == 'false') { echo 'checked = \"checked\"'; } ?> /> Off
      </fieldset>
      
      <?php
			if( $flash_written->image )
			{
				$image = array(
					'src' => 'images/images/' . $flash_written->image,
					'width' => 400,
					'height' => 267,
					'alt' => $flash_written->image,
					'class' => 'image',
					'id' => 'test'
				);
				
			echo img($image);
			
			}
			?>
      
      <div class="containerArea" style="margin-top:10px;">
        <input type="submit" id="submit" value="Update Content" class="butSmall" />
      </div>
    
    </div>
    
  <?php echo form_close(); ?>
  
  
  
  <?php echo form_open('flashwritten_con/delete_flash_written/' . $flash_written->id); ?>

    <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
  
    <input type="button" id="submit_del" value="Delete this item?" class="butSmall" />
    <input type="submit" id="delete" value="Yes Delete!" class="butSmall" style="display:inline-block;" />
    
  <?php echo form_close(); ?>
  
  

</div>



<!--JQUERY AJAX UPDATE SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#container').append('<img src="<?php echo base_url() . '/images/loading.gif' ?>" alt="Currently Loading" id="loading" />');
	
	
	var token = $('#token').val();
	var id = $('#id').val();
	var question = $('#question').val();
	var answer = $('#answer').val();
	var image = $('#image').val();
	var on_off = document.getElementById('on_off').checked;
	
	$.ajax({
		url: '<?php echo base_url() . 'flashwritten_con/update_flash_written'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&id=' + id
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

<script>

(function(){
					
	$('#delete').hide(); /*Hide the actual Delete button*/
	
	$('#submit_del').on('click', function(){
		$('#delete').toggle();
	})


})();

</script>