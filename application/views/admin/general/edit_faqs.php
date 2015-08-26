<h1 class="gridHeader strong">FAQs</h1>

<div class="gridPadding textPadLeft">

<?php
	// Back button
	echo anchor('general_con/show_faqs', '&lsaquo;&lsaquo; Back', array('class' => 'butSmall butRight'));
?>

<h1 class="greyArrow textOrange"><strong>Manage FAQs</strong></h1>

<?php echo form_open('general_con/update_faqs'); ?>

	<div id="container">

	<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
	<input type="hidden" name="faqID" id="faqID" value="<?php echo $faqs->id; ?>" />

	<fieldset>
	<legend>ADD NEW FAQ</legend>

	<label for"question"><strong>Question:</strong></label>
	<textarea name="question" id="question" rows="4" style="width:98%;"><?php echo $faqs->question; ?></textarea>

	<label for"bodyContent"><strong>Answer:</strong></label>
	<textarea name="bodyContent" id="bodyContent" class="content"><?php echo $faqs->answer; ?></textarea>
	<!--DISPLAY THE CKEDITOR-->
	<?php echo form_ckeditor(array('id'=>'bodyContent')); ?>

	<label for"order"><strong>Order:</strong></label>
	<input type="text" name="order" id="order" size="3" value="<?php echo $faqs->order; ?>" />

	</fieldset>

	<div class="containerArea" style="margin-top:10px;">
	<input type="submit" id="submit" value="Update Content" class="butSmall" />
	</div>

	</div>

<?php echo form_close(); ?>


<?php echo form_open('general_con/delete_faqs/' . $faqs->id); ?>

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
	var faqID = $('#faqID').val();
	var question = $('#question').val();
	var bodyContent = $('#bodyContent').val();
	var order = $('#order').val();
	
	
	$.ajax({
		url: '<?php echo base_url() . 'general_con/update_faqs'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&faqID=' + faqID
		+ '&question=' + question
		+ '&bodyContent=' + escape(bodyContent)
		+ '&order=' + order,
		
		success: function(result) {
				
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