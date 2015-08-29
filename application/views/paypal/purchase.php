<div class="container">
	<div class="row">

		<div class="col-sm-9 col-full">
			
			<h2>You have selected:</h2>
			<div class="multiseparator vc_custom"></div>

			<?php 
				$segments = array( 'item', url_title( $item->name, 'dash', true ), $item->id );
				echo '<h3>' . $item->name . ' <span class="text-redLight">$' . $item->price . '</span></h3>';
				echo '<p>(Subscription period - as per terms and conditions).</p>';
			?>

			<br>

			<h2 class="text-capitalize">Instructions</h2>
			<div class="multiseparator vc_custom"></div>
			<p>To purchase the <?php echo anchor( $segments, $item->name, array('class' => 'bold')); ?> subscription:</p>

			<ol>
				<li>Enter your (valid) email address below and click through to pay with PayPal. </li>
				<li>Tick the checkbox below agreeing to the terms and conditions.</li>
				<li>Upon confirmation of your payment, you will receive an email with a link to complete your registration.</li>
			</ol>

			<p><strong>IMPORTANT:</strong> The email address you enter below will be your <strong>login USERNAME</strong> for eLearnEconomics. <br />When you get to PayPal, you can use whatever email you prefer for the PayPal processing form.</p>




			<?php
				$url_title = url_title( $item->name, 'dash', true );
				echo form_open( 'purchase/' . $url_title . '/' . $item->id, array('class' => 'bg_credit_card'));
			?>

			<br>
			
			<div class="well well-sm">

				<h2>Purchase via PayPal</h2>
				<div class="multiseparator vc_custom"></div>

				<fieldset>

					

					<div class="form-group-lg">
						<label for="username"><strong>Email Address:</strong> <small>(This will be your 'login USERNAME' and where your confirmation details will be sent):</small></label>
						<input type="email" name="email" id="email" class="form-control" placeholder="example@something.co.nz" /><br />
					</div>


					
					<div class="checkbox">
						<label for="terms">
						<input type="checkbox" name="terms" id="terms" value="1" class="checkbox" /> I agree to the <?php echo anchor( 'site/terms', '<strong>terms and conditions.</strong>', array('target' => '_blank') ); ?><br />
						</label>
					</div>
					<input type="submit" value="Pay $<?php echo $item->price; ?> via PayPal" class="btn btn-lg btn-green" />	

				</fieldset>

				<?php echo validation_errors( '<div class="message_error">* ', '</div>' ); ?>

				<?php echo form_close(); ?>

			</div><!-- ENDS well -->

		</div><!--ENDS col-->


		<div class="col-sm-3 sidebar">

			<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>

		</div><!--ENDS col-->

	</div><!--ENDS row-->
</div><!--ENDS container-->


