<h1 class="gridHeader strong">Multi Choice</h1>

<div class="gridPadding textPadLeft">
	
  <?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'],'&lsaquo;&lsaquo; Back', array('class' => 'butSmall butRight'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  
  <?php echo form_open('multichoice_con/add_multi_choice'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="topicID" id="topicID" value="<?php echo $this->uri->segment(3); ?>" />
      
      
      <fieldset>
      <legend>QUESTION:</legend>
      <textarea name="question" id="question" rows="4" style="width:98%;"><?php echo set_value('question'); ?></textarea>
      </fieldset>
      
      <fieldset>
      <legend>ANSWER OPTIONS:</legend>
      a)<input name="answer" id="answer" type="radio" value="1" checked="checked" />
      <input type="text" name="opt1" id="opt1" style="width:90%;" value="<?php echo set_value('opt1'); ?>" /><br />
      
      b)<input name="answer" id="answer" type="radio" value="2" />
      <input type="text" name="opt2" id="opt2" style="width:90%;" value="<?php echo set_value('opt2'); ?>" /><br />
      
      c)<input name="answer" id="answer" type="radio" value="3" />
      <input type="text" name="opt3" id="opt3" style="width:90%;" value="<?php echo set_value('opt3'); ?>" /><br />
      
      d)<input name="answer" id="answer" type="radio" value="4" />
      <input type="text" name="opt4" id="opt4" style="width:90%;" value="<?php echo set_value('opt4'); ?>" />
      </fieldset>
      
      <fieldset>
      <legend>ADDITIONAL OPTIONS:</legend>
      <label for"reason"><strong>Reason:</strong></label>
      <textarea name="reason" id="reason" rows="4" style="width:98%;"><?php echo set_value('reason'); ?></textarea>
      
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
	var opt1 = $('#opt1').val();
	var opt2 = $('#opt2').val();
	var opt3 = $('#opt3').val();
	var opt4 = $('#opt4').val();
	var answer = $('input:radio[name=answer]:checked').val();
	var reason = $('#reason').val();
	var image = $('#image').val();
	var on_off = document.getElementById('on_off').checked;
	
	
	$.ajax({
		url: '<?php echo base_url() . 'multichoice_con/add_multi_choice'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&topicID=' + topicID
		+ '&question=' + escape(question)
		+ '&opt1=' + escape(opt1)
		+ '&opt2=' + escape(opt2)
		+ '&opt3=' + escape(opt3)
		+ '&opt4=' + escape(opt4)
		+ '&answer=' + answer
		+ '&reason=' + escape(reason)
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