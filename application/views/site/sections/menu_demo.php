<div class="container">
	<div class="row">
		<div class="col-sm-9 col-full">
			
			<h2>Take the FREE Tour ...</h2>
			<div class="multiseparator vc_custom"></div>

			<p>Hello and welcome to the demo area of our site. </p>
			<p>Click on one of the bolded topics which will take you through to the key notes of that topic. You can also view audio videos, flash cards and the written answers section by clicking the various tabs on the toolbar. This will give you an insight into the site as a student. An individual licence allows you to track your progress and see reports. For more information on the depth of the site, see the downloadable brochure on the home page.</p><br>
			<p>We are happy to answer any questions. <?php echo safe_mailto('info@elearneconomics.com', 'Please click Here to Contact Us'); ?></p>

		</div><!--ENDS col-->

		<div class="col-sm-3 sidebar">

			<h5><strong>SELECT TOPICS</strong></h5>
			<div class="multiseparator vc_custom"></div>



			<!-- START FORM to choose the topics of a specific course level -->
			<?php echo form_open('section/demo'); ?>

				<fieldset>

					<?php
						// Dropdown menu to show only 'USER' defined topics
						// See admin_helper - show_levels()
						echo show_levels_dropdown('', '', 'Select Course Level');
					?>

				</fieldset>

			<br>
			<p>Choose the course level best suited to your study requirement form the drop-down above:</p>

			<?php
				// Display error message
				if( isset($error)) { echo $error; }
				
				echo form_close();
			?>

		</div><!--ENDS col-->
	</div><!--ENDS row-->
</div><!--ENDS container-->



<?php if( isset($topics) ) { // DO NOT display unless $topics exists! ?>

	<div class="full-band">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">

					
						<h2>Main Topics - Select any <span class="text-redLight">(demo)</span> topic for a free sample</h2>
						<div class=	"multiseparator vc_custom"></div>


				</div><!-- ENDS col -->
			</div><!-- ENDS row -->




			<div class="row topics-list">
				<div class="col-sm-4">

					<?php
							
						/*************************************************************************/
						// Loop through each topic alphbetically
						/*************************************************************************/
						// FULL LIST OF TOPICS ...
						// Display full list of topics in alphabetical order with letter (A, B, C) as heading


						$leaders_icon = array(
							'src' => $this->css_path_url . 'main/icons/set01/16/search.png',
							'alt' => 'Leader Board',
							'width' => '16',
							'height' => '16',
							'style' => 'margin:0 3px 0 0;'
						);

						$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$letters = str_split($alphabet);
						$set_letter = FALSE;

						$results = count($topics);
						$per_column = ceil($results/3);
						
						$i = 0;


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

									/*
									|-----------------------------------------------------------------------------------------------------------------
									| THESE ARE THE DEMO TOPIC ID's
									|-----------------------------------------------------------------------------------------------------------------
									*/
									$demo_topics = array('1', '8', '16');

									if( in_array($row->topicID, $demo_topics)) 
									{
										$segments = '<p>' . anchor( 'section/key_notes/' . $row->topicID, $row->topic ) . ' <span class="text-redLight">(demo)</span></p>';
									}
									else
									{
										$segments = '<p>' .  $row->topic . '</p>';
									}
									
						
										if( substr($row->topic, 0, 1) == $letter )
										{
											// Only show new alpha letter at the start of each alpha category
											$alpha_header = ( $set_letter != $letter ) ? $letter . '<div class=	"multiseparator vc_custom"></div>' : ''; 
											// Display alpha letter (i.e., A, B, C ...)
											echo '<h4 class="text-redLight"><strong>' . $alpha_header . '</strong></h4>';
											//echo '<div class=	"multiseparator vc_custom"></div>';

											// Display Topic Name
											echo $segments;

											// Save alpha letter as var to test against looped through version above
											$set_letter = $letter; 
										}
										
									endforeach;
									
									/*************************************************************************/
							 
							 $i++;
							 
						}
						
						echo '</row>';
						
					?>

				</div><!-- ENDS col -->
			</div><!-- ENDS row -->
		</div><!-- ENDS container -->
	</div><!--ENDS full-band -->
<?php } ?>






<?php if( isset($subTopics) ) { // DO NOT display unless $subTopics exists! ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<h2>Glossary of Terms</h2>
				<div class="multiseparator vc_custom"></div>
				<p>Each Glossary Term relates to a parent topic above.</p>

			</div><!-- ENDS col -->
		</div><!-- ENDS row -->




		<div class="row topics-list">
			<div class="col-sm-3">

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
										echo '<p><small>' . $row->subTopic . '</small></p>';
										
										// Save alpha letter as var to test against looped through version above
										$set_letter = $letter; 
									}
									
								endforeach;
								
								/*************************************************************************/
						 
						 $i++;
						 
					}

					echo '</row>';

				?>

				
			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
<?php } ?>



<script>
/*******************************************/
/* SHOW / HIDE Study Guide
/*******************************************/
(function(){
	
	//Auto submit the 'Choose Topics Level' dropdown form
	$("#level_name").on('change', function () {
		this.form.submit();
	});
					
})();

</script>


