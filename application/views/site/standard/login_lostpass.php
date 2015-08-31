<!-- Starts Member Login (Both Students and Teachers) -->
<div class="band-grey">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <h2>Password Recovery</h2>
                <div class="multiseparator vc_custom"></div>


                <?php echo form_open('main/login_lostpass', array('class' => 'bg_lock')); ?>

                <div id="container">

                	<fieldset class="well well-trans">

                		<p>To reset your password, enter your Username (Email) below. A link will be sent to this email allowing you to reset your password.</p>
                        <p><small><strong>NOTE:</strong> If you do not receive the link, please check your <strong>'Junk' or 'Spam'</strong> folders.</small></p>


                		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

                        <div class="form-group-lg">
                            <label>Username (Email):</label>
                            <input type="text" name="username" class="form-control" id="username" size="35" value="<?php echo set_value('username'); ?>">
                        </div>

                    	<br>
                		<div class="containerArea">
                		  <input type="submit" class="btn btn-lg btn-red btn-block" id="submit" value="Send Link" />
                		</div>

                	</fieldset>

                </div><!--ENDS id container-->

                <?php 
                if( isset( $this->error ))
                {
                	echo $this->error;
                }

                echo form_close(); 
                ?>

            </div><!--ENDS col-->
        </div><!--ENDS row-->
    </div><!--ENDS container-->
</div><!-- ENDS band-white -->


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