<div class="band-topic-sections">
	<div class="container">
		<div class="row">

			<div class="col-sm-12 col-full">


				<h2>Select your course level topics</h2>
				<div class="multiseparator vc_custom"></div>
				<p>Select a course level from below that best suits your study requirements</p>


				<div class="row">
					<div class="col-md-4">

						<!-- START FORM to choose the topics of a specific course level -->
						<?php echo form_open('section/index'); ?>

							<fieldset>

								<?php
									// Dropdown menu to show only 'USER' defined topics
									// See admin_helper - show_levels()
									echo show_levels_dropdown('', '', 'Select Course Level');
								?>

							</fieldset>
						

						<?php
							// Display error message
							if( isset($error)) { echo $error; }
							
							echo form_close();
						?>

						<?php
						// Display the 'Level' name
						if( isset($level)) 
						{
							$ext = ($level->level_name != 'All Topics') ? 'Topics' : '';
							echo '<h2 class="bold">' . $level->level_name . ' ' . $ext . '</h2>';
						}
						?>

					</div><!-- ENDS col -->
				</div><!-- ENDS row -->

				<?php
					// Displays the class message instructing students what to study
					//This is created by the teacher and displays for each student in that teachers class
					// if( isset( $class_message->message ) && ! empty( $class_message->message ) )
					// {
					// 	echo '<div id="class_message">';
					// 		echo '<h3>Hello ' . $class_message->first_name . ',</h3>';
					// 		echo '<p>' . nl2br($class_message->message) . '</p>';
					// 	echo '</div>';

					// 	echo anchor('#', 'Hide Instructions', array('class'=>'btn btn-md btn-red class_message_toggle'));
					// }
				?>

			</div><!--ENDS col-->



		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->



<a id="topic-title"></a><!-- Anchor for jQuery scrollTo() -->



<?php if( isset($topics) ) { // DO NOT display unless $topics exists! ?>

	<div class="band-grey">
		<div class="container">

			<div class="row">
				<div class="col-sm-12">

					<h2>Course Topics</h2>
					<div class=	"multiseparator vc_custom"></div>
					<p>Click <i class="fa fa-search"></i> for leaderboard results</p>

				</div><!-- ENDS col -->
			</div><!-- ENDS row -->



				<?php
						
					/*************************************************************************/
					// Loop through each topic alphbetically
					/*************************************************************************/
					// FULL LIST OF TOPICS ...
					// Display full list of topics in alphabetical order with letter (A, B, C) as heading

					$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$letters = str_split($alphabet);
					$set_letter = FALSE;

					$results = count($topics);
					$per_column = ceil($results/3);
					
					$i = 0;
					$score = NULL;


					echo '<div class="row topics-list">';
					echo '<div class="col-sm-4">';


					foreach($topics as $row) {
					
						 if($i == $per_column)
						 {
							echo '</div><div class="col-sm-4">';
							$i = 0;
						 }

						 $month = date('M'); // Get current month and append below
				
						$score = $row->$month*2;
						 
								/*************************************************************************/
								// Break topics up by each letter of alphabet - Use letter (A, B, C ..) as label
								/*************************************************************************/
								foreach($letters as $letter):
				
								$segments = array( 'topic_con/edit_topics/' . $row->topicID);
					
									if( substr($row->topic, 0, 1) == $letter )
									{
										// Only show new alpha letter at the start of each alpha category
										$alpha_header = ( $set_letter != $letter ) ? $letter  . '<div class="multiseparator vc_custom"></div>' : ''; 
										// Display alpha letter (i.e., A, B, C ...)
										echo '<h4 class="text-redLight"><strong>' . $alpha_header . '</strong></h4>';

										// Display Topic Name
										echo '<p>' .anchor('results/leaders_school/' . $row->topicID,  ' <i class="fa fa-search"></i> ') . ' ' . anchor( 'section/key_notes/' . $row->topicID, $row->topic) . ' ' . $score . '%</p>';

										// Save alpha letter as var to test against looped through version above
										$set_letter = $letter; 
									}
									
								endforeach;
								
								/*************************************************************************/
						 
						 $i++;
						 
					}
					
					echo '</div>';
					echo '</div>';
					
				?>

		</div><!-- ENDS container -->
	</div><!--ENDS full-band -->

<?php } ?>






<?php if( isset($subTopics) ) { // DO NOT display unless $subTopics exists! ?>
	<div class="band-white">
		<div class="container">

			<div class="row">
				<div class="col-sm-12">

					<h2>Glossary of Terms</h2>
					<div class="multiseparator vc_custom"></div>
					<p>Each Glossary Term relates to a parent topic above.</p>

				</div><!-- ENDS col -->
			</div><!-- ENDS row -->




			
					<?php
						// Display full list of topics in alphabetical order with letter (A, B, C) as heading
						// FULL LIST OF SUB-TOPICS ...
						$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$letters = str_split($alphabet);
						$set_letter = FALSE;

						$results = count($subTopics);
						$per_column = ceil($results/4);
						
						$i = 0;

						/*************************************************************************/
						// Loop through each topic alphbetically
						/*************************************************************************/

						echo '<div class="row topics-list">';
						echo '<div class="col-sm-3">';

						foreach($subTopics as $row) {
						
							if($i == $per_column)
							{
								echo '</div><div class="col-sm-3">';
								$i = 0;
							}

									/*************************************************************************/
									// Break topics up by each letter of alphabet - Use letter (A, B, C ..) as label
									/*************************************************************************/
									foreach($letters as $letter):
									
									$segments = array( 'topic_con/edit_subTopics/' . $row->subTopicID . '/' . $row->topicID );
						
										if( substr($row->subTopic, 0, 1) == $letter )
										{
											// Only show new alpha letter at the start of each alpha category
											$alpha_header = ( $set_letter != $letter ) ? $letter . '<div class=	"multiseparator vc_custom"></div>' : ''; 
											// Display alpha letter (i.e., A, B, C ...)
											echo '<h5 class="text-redLight"><strong>' . $alpha_header . '</strong></h5>';
											// Display Topic Name - links back to the parent topic (Key Notes)

											echo '<p><small>' . anchor( 'section/key_notes/' . $row->topicID, $row->subTopic ) . '</small></p>';
											
											// Save alpha letter as var to test against looped through version above
											$set_letter = $letter; 
										}
										
									endforeach;
									
									/*************************************************************************/
							 
							 $i++;
							 
						}

						echo '</div>';
						echo '</div>';

					?>

					

		</div><!--ENDS container-->
	</div><!-- ENDS band-white -->

<?php } ?>
			


			

<script>
/*******************************************/
/* SHOW / HIDE Study Guide
/*******************************************/
(function(){

	// SHOW / HIDE Class message box
	$("a.class_message_toggle").click(function(e) {
		e.preventDefault();
		var txt = $("#class_message").is(':visible') ? 'Show Instructions' : 'Hide Instructions';
		$("a.class_message_toggle").text(txt);
		$("#class_message").fadeToggle(600);
	});

	//Auto submit the 'Choose Topics Level' dropdown form
	$("#level_name").on('change', function () {
		this.form.submit();
	});
	
					
})();

</script>