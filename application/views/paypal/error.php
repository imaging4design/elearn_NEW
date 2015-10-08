<div class="band-grey">
	<div class="container">
		<div class="row">

			<div class="col-md-12">

				<h2>Message from eLearn Economics</h2>
				<div class="multiseparator vc_custom"></div>

				<?php

					if( $this->session->flashdata('error') )
					{
						echo '<p>' . $this->session->flashdata('error') . '</p>';
					}
					
					// KEEP THIS THOUGH
					if( $this->session->flashdata('success') )
					{
						echo '<p>' . $this->session->flashdata('success') . '</p>';
					}

				?>

			</div><!-- ENDS col -->

		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-grey-->