<?php
	// Set up var names to display who is the current 'logged in' user
	// Show them in in a nice styled band at the top of the page
	$first_name = $this->session->userdata('first_name');
	$last_name = $this->session->userdata('last_name');
	$school = $this->session->userdata('school');
?>

<!-- Shows the current logged in user :: their full name ans school -->
<!-- Let's make this a nice CSS display - maybe a coloured band! -->

	<div class="container">
		<div class="row">
			<div class="col-sm-12">



				<?php
					// Show 'Back to Topics' animated button - only if user is on topic content pages (i.e., Key Notes, Audio/Video, Flash Cards, Writtem Answers, Multi-Choice)
					// $sections = array('key_notes', 'audio_video', 'flash_cards', 'written_answers', 'multi_choice', 'leaders_school');

					// if( in_array( $this->uri->segment(2), $sections ) ) {
					// 	//echo '<div class="btn-back" id="btn-back">BACK TO TOPICS</div>';
					// 	echo '<br><h4 class="center">Welcome ' . ucwords(strtolower( $first_name )) . '</h4>';
					// }
				?>
				
				

				<!-- Single button -->
				<!-- <div>
					<p class="pull-left"><strong>Welcome </strong></p>&nbsp;
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-red dropdown-toggle btn-settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php //echo ucwords(strtolower( $first_name )); ?> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><?php //echo anchor('section/edit_options', 'My Settings'); ?></li>
							<li><?php //echo anchor('results/view_progress', 'My Progress'); ?></li>
							<li><?php //echo anchor('results/leaders_school', 'Leader Board'); ?></li>
							<li><?php //echo anchor('site/news', 'Latest News'); ?></li>
						</ul>
					</div>
				</div> -->
				

			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->



