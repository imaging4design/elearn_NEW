<!-- Starts Member Login (Both Students and Teachers) -->
<div class="band-grey">
    <div class="container">
        <div class="row">
        	<div class="col-md-6 col-md-offset-3">


				<h2>Reset Password</h2>
                <div class="multiseparator vc_custom"></div>

				<?php echo form_open('main/reset_password', array('class' => 'bg_sign_up')); ?>


					<?php
						// Set and keep the temp_code
						$temp_code = ( $this->session->userdata('temp_code') ) ? $this->session->userdata('temp_code') : $this->uri->segment(3);
					?>


					<fieldset class="well well-trans">

						<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
						<input type="hidden" name="temp_code" id="temp_code" value="<?php echo $temp_code; ?>" />

						<p><small><strong>Note:</strong> If you have since remembered your password, please go <?php echo anchor('main/login', 'HERE'); ?> to login (your existing password will remain)</small></p>

						<div class="form-group-lg">
                            <label>Username (Email):</label>
						<input type="text" name="username" class="form-control" id="username" size="36" value="<?php echo set_value('username'); ?>" />
                        </div>

                        <div class="form-group-lg">
                            <label>(Change) Password:</label>
						<input type="password" name="password" class="form-control" id="password" size="36" value="<?php echo set_value('password'); ?>" />
                        </div>

                        <div class="form-group-lg">
                            <label>Confim (Change) Password:</label>
						<input type="password" name="conf_password" class="form-control" id="conf_password" size="36" value="<?php echo set_value('conf_password'); ?>" />
                        </div>

                        <br>
						<div class="containerArea">
							<input type="submit" class="btn btn-lg btn-red btn-block" id="submit" value="Reset Password" />
						</div>

					</fieldset>

					
				<?php 

				if( isset($error))
				{
					echo $error;
				}
				echo form_close(); ?>



            </div><!--ENDS col-->
        </div><!--ENDS row-->
    </div><!--ENDS container-->
</div><!-- ENDS band-white -->