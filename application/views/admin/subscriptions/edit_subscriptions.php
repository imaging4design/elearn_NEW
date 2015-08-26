<h1 class="gridHeader strong">Subscriptions</h1>

<div class="gridPadding textPadLeft">

	<?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'],'&lsaquo;&lsaquo; Back', array('class' => 'butSmall butRight'));
	?>
	

	<h1 class="greyArrow textOrange"><strong>Edit Subscriptions</strong></h1>
  
  <?php echo form_open('subscription_con/update_subscription'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="id" id="id" value="<?php echo $subscription->id; ?>" />
      
      <fieldset>
      <legend>SUBSCRIPTION DETAILS</legend>
        <label for"name"><strong>Subscription Name:</strong></label>
        <input type="text" name="name" id="name" style="width:95%;" value="<?php echo $subscription->name; ?>" />

        <label for"special_offer"><strong>Special Offer:</strong></label>
        <input type="text" name="special_offer" id="special_offer" style="width:95%;" value="<?php echo $subscription->special_offer; ?>" />
        
        <label for"price"><strong>Subscription Price:</strong></label>
        <input type="text" name="price" id="price" style="width:20%;" value="<?php echo $subscription->price; ?>" />
      </fieldset>
        
      <label for"bodyContent"><strong>Description:</strong></label>
      <textarea name="bodyContent" id="bodyContent" class="content"><?php echo $subscription->description; ?></textarea>
      <!--DISPLAY THE CKEDITOR-->
      <?php echo form_ckeditor(array('id'=>'bodyContent')); ?>
      
      
      <div class="containerArea" style="margin-top:10px;">
        <input type="submit" id="submit" value="Update Subscription" class="butSmall" />
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
	var id = $('#id').val();
	var name = $('#name').val();
	var special_offer = $('#special_offer').val();
	var price = $('#price').val();
	var bodyContent = $('#bodyContent').val();
	
	
	$.ajax({
		url: '<?php echo base_url() . 'subscription_con/update_subscription'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&id=' + id
		+ '&name=' + name
		+ '&special_offer=' + special_offer
		+ '&price=' + price
		+ '&bodyContent=' + escape(bodyContent),
		
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