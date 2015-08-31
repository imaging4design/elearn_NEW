<!-- Starts Member Login (Both Students and Teachers) -->
<div class="band-grey">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

            	<h2>Teacher Administration</h2>
            	<p><small><strong>NOTE:</strong> Please keep your teacher admin login details secure.</small></p>
                <div class="multiseparator vc_custom"></div>


					<?php echo form_open('main/login_teach'); ?>

					<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

					<fieldset class="well well-trans">

					

						<div class="form-group-lg">
                            <label>Username:</label>
						<input type="text" name="admin_user" class="form-control" id="admin_user" size="30" value="<?php echo set_value('admin_user'); ?>">
                        </div>

                        <div class="form-group-lg">
                            <label>Password:</label>
						<input type="password" name="admin_pass" class="form-control" id="admin_pass" size="30" value="<?php echo set_value('admin_pass'); ?>">
                        </div>
                        <br>
						<input type="submit" name="submit" class="btn btn-lg btn-red btn-block" id="submit" value="LOGIN" />

					</fieldset>

					<?php
					// Display success / error message
					if( $this->input->post('submit') && $this->session->userdata('login_teach') == 'fail' )
					{
						echo '<div class="message_error">Incorrect login details - please try again</div>';
					}

					echo form_close(); 
					?>

					<?php echo form_close(); ?>

  
            </div><!--ENDS col-->
        </div><!--ENDS row-->
    </div><!--ENDS container-->
</div><!-- ENDS band-white -->