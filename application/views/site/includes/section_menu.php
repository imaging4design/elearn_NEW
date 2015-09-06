<?php $topics = show_topics(); // Get list of current topics to display in 'Off-Canvas' ?>

<!-- This is the 'Off-Canvas' slide in list of topics -->
<div class="topics-off-canvas-btn visible-md visible-lg" id="topics-off-canvas-btn"><i class="fa fa-bars"></i></div>

<div class="topics-off-canvas">
	<div class="topics-off-canvas-content">

		<h2><span class="text-redLight">Topic List</span></h2>

		<ul class="canvas-topics">
			
			<?php 
			foreach ($topics as $row): 
				echo anchor( 'section/key_notes/' . $row->topicID, '<li>' . $row->topic . '</li>');
			endforeach;
			?>

		</ul>

		<a href="../section/index"><button class="btn btn-md btn-red">All Topics</button></a>

	</div><!-- ENDS topics-off-canvas-content -->
</div><!-- ENDS topics-off-canvas -->


<?php

	//$test = $this->output->cache(30);

?>


<?php
	$class1 = ($this->uri->segment(2) =='key_notes') ? 'active' : '';
	$class2 = ( $this->uri->segment(2) =='audio_video') ? 'active' : '';
	$class3 = ( $this->uri->segment(2) =='flash_cards') ? 'active' : '';
	$class4 = ( $this->uri->segment(2) =='written_answers') ? 'active' : '';
	$class5 = ( $this->uri->segment(2) =='multi_choice') ? 'active' : '';
?>

<div class="e-tabs">
	<ul class="nav nav-tabs mode-tabs-menu">
		<li role="presentation" class="<?php echo $class1; ?>"><?php echo anchor('section/key_notes/' . $this->uri->segment(3), '<i class="fa fa-file-text"></i> KEY NOTES'); ?></li>
		<li role="presentation" class="<?php echo $class2; ?>" id="videoBlock"><?php echo anchor('section/audio_video/' . $this->uri->segment(3), '<i class="fa fa-rss"></i> AUDIO/VIDEO'); ?></li>
		<li role="presentation" class="<?php echo $class3; ?>"><?php echo anchor('section/flash_cards/' . $this->uri->segment(3), '<i class="fa fa-clone"></i> FLASH CARDS'); ?></li>
		<li role="presentation" class="<?php echo $class4; ?>"><?php echo anchor('section/written_answers/' . $this->uri->segment(3), '<i class="fa fa-pencil"></i> WRITTEN ANSWERS'); ?></li>
		<li role="presentation" class="<?php echo $class5; ?>"><?php echo anchor('section/multi_choice/' . $this->uri->segment(3), '<i class="fa fa-th-list"></i> MULTI-CHOICE'); ?></li>
	</ul>
</div>

<div class="band-topic-sections">

	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<h2><?php echo ( isset($topic_label)) ? $topic_label->topic : 'Sorry, no topic found'; ?></h2>
				<div class="multiseparator vc_custom"></div>

				

				

				<?php
					/********************************************************************************************************/
					// DISPLAY RELATED TOPICS
					/********************************************************************************************************/
					if( isset($sub_topics))
					{
						$subTopic = NULL;

						echo '<h3>Terms/Ideas:</h3>';
						echo '<p>';

						foreach($sub_topics as $row):

							$subTopic .= $row->subTopic . " | ";

							///$string=",Fred, Bill,, Joe, Jimmy,";
							//$string=reduce_multiples($string, ", ", TRUE); //results in "Fred, Bill, Joe, Jimmy" 

						endforeach;

						echo reduce_multiples($subTopic, " | ", TRUE); // Remove last pipe |
						echo '</p>';

						echo '<div></div>';
					}


				?>


			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->

</div><!--ENDS band-grey-topics-->

