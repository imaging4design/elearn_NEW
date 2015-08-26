<h1 class="gridHeader">Member Login - Lost Password</h1>

<div class="gridPadding textPadding">

<?php echo form_open('main/login_lostpass', array('class' => 'bg_lock')); ?>

<div id="container">

	<fieldset>
	<legend>LOST PASSWORD RECOVERY</legend>

	<span class="marginBot">
		If you have forgotten your password, enter your Username (Email) below.<br />
		A link will then be sent to this email enabling you to reset your password.<br /><br />
		<span class="textOrange bold">NOTE: </span>If you do not receive a link, be sure to check your <strong>'Junk'</strong> or <strong>'Spam'</strong> folders.</span>

		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

		<label>Username (Email):</label>
		<input type="text" name="username" id="username" size="35" value="<?php echo set_value('username'); ?>">

		<div class="containerArea">
		<input type="submit" id="submit" value="Send Link" />
		</div>

	</fieldset>

</div>

<?php 
if( isset( $this->error ))
{
	echo $this->error;
}

echo form_close(); 
?>

</div>


<!--JQUERY AJAX UPDATE SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#container').append('<img src="<?php echo base_url() . '/images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

    var token = $('#token').val();
    var username = $('#username').val();    
    
    $.ajax({
        url: '<?php echo base_url() . 'main/login_lostpass'; ?>',
        type: 'POST',
        data: 'token=' + token
        + '&username=' + username,
        
        success:    function(result) {
                
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