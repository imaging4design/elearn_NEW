<h1 class="gridHeader strong">Multi Choice</h1>

<div class="gridPadding textPadLeft">
	
  <?php
	// Back button
	echo anchor($_SERVER['HTTP_REFERER'],'&lsaquo;&lsaquo; Back', array('class' => 'butSmall butRight'));
	?>

	<h1 class="greyArrow textOrange"><strong><?php echo $title->topic; ?></strong></h1>
  
  <?php echo form_open('multichoice_con/update_multi_choice'); ?>

    <div id="container">
    
      <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
      <input type="hidden" name="id" id="id" value="<?php echo $multi_choice->id; ?>" />
      
      <fieldset>
      <legend>QUESTION:</legend>
      <textarea name="question" id="question" rows="4" style="width:98%;"><?php echo $multi_choice->question; ?></textarea>
      </fieldset>
      
      <fieldset>
      <legend>ANSWER OPTIONS:</legend>
      a)<input name="answer" id="answer" type="radio" value="1" <?php if( $multi_choice->opt1 === $multi_choice->answer) { echo 'checked="checked"'; } ?> />
      <input type="text" name="opt1" id="opt1" style="width:90%;" value="<?php echo $multi_choice->opt1; ?>" /><br />
      
      b)<input name="answer" id="answer" type="radio" value="2" <?php if( $multi_choice->opt2 === $multi_choice->answer) { echo 'checked="checked"'; } ?> />
      <input type="text" name="opt2" id="opt2" style="width:90%;" value="<?php echo $multi_choice->opt2; ?>" /><br />
      
      c)<input name="answer" id="answer" type="radio" value="3" <?php if( $multi_choice->opt3 === $multi_choice->answer) { echo 'checked="checked"'; } ?> />
      <input type="text" name="opt3" id="opt3" style="width:90%;" value="<?php echo $multi_choice->opt3; ?>" /><br />
      
      d)<input name="answer" id="answer" type="radio" value="4" <?php if( $multi_choice->opt4 === $multi_choice->answer) { echo 'checked="checked"'; } ?> />
      <input type="text" name="opt4" id="opt4" style="width:90%;" value="<?php echo $multi_choice->opt4; ?>" />
      </fieldset>
      
      <fieldset>
      <legend>ADDITIONAL OPTIONS:</legend>
      <label for"reason"><strong>Reason:</strong></label>
      <textarea name="reason" id="reason" rows="4" style="width:98%;"><?php echo $multi_choice->reason; ?></textarea>
      
      <label for"image"><strong>Image:</strong></label>
      <input type="text" name="image" id="image" style="width:20%;" value="<?php echo $multi_choice->image; ?>" />
      
      <label for"on_off"><strong>On / Off:</strong></label>
      <input type="radio" name="on_off" id="on_off" value="true" <?php if($multi_choice->on_off == 'true') { echo 'checked = \"checked\"'; } ?> /> On
      <input type="radio" name="on_off" id="on_off" value="false" <?php if($multi_choice->on_off == 'false') { echo 'checked = \"checked\"'; } ?> /> Off
      </fieldset>
      
      <?php
			if( $multi_choice->image )
			{
				$image = array(
					'src' => 'images/images/' . $multi_choice->image,
					'width' => 400,
					'height' => 267,
					'alt' => $multi_choice->image,
					'class' => 'image'
				);
				
			echo img($image);
			
			}
			?>
      
      <div class="containerArea" style="margin-top:10px;">
        <input type="submit" id="submit" value="Update Content" class="butSmall" />
      </div>
    
    </div>
    
  <?php echo form_close(); ?>
  
  
  
  <?php echo form_open('multichoice_con/delete_multi_choice/' . $multi_choice->id); ?>

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
	var opt1 = $('#opt1').val();
	var opt2 = $('#opt2').val();
	var opt3 = $('#opt3').val();
	var opt4 = $('#opt4').val();
	var answer = $('input:radio[name=answer]:checked').val();
	var reason = $('#reason').val();
	var image = $('#image').val();
	var on_off = document.getElementById('on_off').checked;
	
	
	$.ajax({
		url: '<?php echo base_url() . 'multichoice_con/update_multi_choice'; ?>',
		type: 'POST',
		data: 'token=' + token
		+ '&id=' + id
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
								
								/*RELOAD PAGE*/
								/* location.reload(); */
								
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