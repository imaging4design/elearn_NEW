<h1 class="gridHeader strong">Key Notes</h1>

<div class="gridPadding textPadLeft">
	
  <?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'],'&lsaquo;&lsaquo; Back', array('class' => 'butSmall', 'style' => 'margin-right:30px; float:right;'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  
  <?php echo form_open('keynotes_con/add_key_notes'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="topicID" id="topicID" value="<?php echo $this->uri->segment(3); ?>" />
      
      <label for"bodyContent"><strong>Body Content:</strong></label>
      <textarea name="bodyContent" id="bodyContent" class="content"><?php echo set_value('bodyContent'); ?></textarea>
      <!--DISPLAY THE CKEDITOR-->
      <?php echo form_ckeditor(array('id'=>'bodyContent')); ?>
      
      <label for"on_off"><strong>On / Off:</strong></label>
      <input type="radio" name="on_off" id="on_off" value="true" <?php echo set_radio('on_off', 'true'); ?> /> On
      <input type="radio" name="on_off" id="on_off" value="false" <?php echo set_radio('on_off', 'false', TRUE); ?> /> Off
      
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

	
	<!--This will force all CKEDITOR instances in the form to update their respective fields-->
	for ( instance in CKEDITOR.instances )
							CKEDITOR.instances[instance].updateElement();

	<!--UPDATES THE CKEDITOR TEXTBOX (iFrame) WHEN PASTED INTO / NEEDS THIS TO PASS ITS VALUE ASYNCHRONOUSLY-->
	CKEDITOR.instances["bodyContent"].document.on('keydown', function(event)
	{
			CKEDITOR.tools.setTimeout( function()
			{ 
					$("#bodyContent").val(CKEDITOR.instances.bodyContent.getData()); 
			}, 0);
	});
	
	CKEDITOR.instances["bodyContent"].document.on('paste', function(event)
	{
			CKEDITOR.tools.setTimeout( function()
			{ 
					$("#bodyContent").val(CKEDITOR.instances.bodyContent.getData()); 
			}, 0);
	});
	
	
	
	var token = $('#token').val();
	var topicID = $('#topicID').val();
	var bodyContent = $('#bodyContent').val();
	var on_off = document.getElementById('on_off').checked;
	
	
	$.ajax({
		url: '<?php echo base_url() . 'keynotes_con/add_key_notes'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&topicID=' + topicID
		+ '&bodyContent=' + escape(bodyContent)
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