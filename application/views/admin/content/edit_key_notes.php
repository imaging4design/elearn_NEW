<h1 class="gridHeader strong">Key Notes</h1>

<div class="gridPadding textPadLeft">
	
  <?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'],'&lsaquo;&lsaquo; Back', array('class' => 'butSmall', 'style' => 'margin-right:30px; float:right;'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  
  <?php echo form_open('keynotes_con/update_key_notes'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="id" id="id" value="<?php echo $key_notes->id; ?>" />
      
      <label for"bodyContent"><strong>Body Content:</strong></label>
      <textarea name="bodyContent" id="bodyContent" class="content"><?php echo $key_notes->content; ?></textarea>
      <!--DISPLAY THE CKEDITOR-->
      <?php echo form_ckeditor(array('id'=>'bodyContent')); ?>
      
      <label for"on_off"><strong>On / Off:</strong></label>
      <input type="radio" name="on_off" id="on_off" value="true" <?php if($key_notes->on_off == 'true') { echo 'checked = \"checked\"'; } ?> /> On
        <input type="radio" name="on_off" id="on_off" value="false" <?php if($key_notes->on_off == 'false') { echo 'checked = \"checked\"'; } ?> /> Off
      
      <div class="containerArea" style="margin-top:10px;">
        <input type="submit" id="submit" value="Update Content" class="butSmall" />
      </div>
    
    </div>
    
  <?php echo form_close(); ?>
  
  
  <?php echo form_open('keynotes_con/delete_key_notes/' . $key_notes->id); ?>

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
	var id = $('#id').val();
	var bodyContent = $('#bodyContent').val();
	var on_off = document.getElementById('on_off').checked;
	
	
	$.ajax({
		url: '<?php echo base_url() . 'keynotes_con/update_key_notes'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&id=' + id
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

<script>

(function(){
					
	$('#delete').hide(); /*Hide the actual Delete button*/
	
	$('#submit_del').on('click', function(){
		$('#delete').toggle();
	})


})();

</script>