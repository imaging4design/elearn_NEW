<div class="band-white">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-full">
				
				<h2>Frequently Asked Questions</h2>
				<div class="multiseparator vc_custom"></div>


				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

					<?php
						// Display all FAQs from database in a definition list
						if( isset($faqs) )
						{
							
							$counter = 0;

							foreach($faqs as $row):

								// returns ...
								// $row->question
								// $row->answer

								// $in = ($counter === 0) ? 'in' : ''; // Uncomment this to have first FAQ 'open'
								$in = null;

								echo '<div class="panel panel-default">';
									echo '<div class="panel-heading" role="tab" id="item-'.$counter.'">';
										echo '<p class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-'.$counter.'" aria-expanded="true" aria-controls="collapse-'.$counter.'"><span class="text-redLight"><i class="fa fa-plus"></i></span> &nbsp;' . $row->question . '</a></p>';
									echo '</div>';
									echo '<div id="collapse-'.$counter.'" class="panel-collapse collapse '.$in.'" role="tabpanel" aria-labelledby="item-'.$counter.'">';
										echo '<div class="panel-body"><p>' . $row->answer . '</p></div>';
									echo '</div>';
								echo '</div>';

								$counter++;

							endforeach;
						}

					?>

				</div><!-- ENDS panel-group -->




			</div><!--ENDS col-->

			<div class="col-md-3 sidebar">

				<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>

			</div><!--ENDS col-->


		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!-- ENDS band-white -->
