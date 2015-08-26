
<?php
	$class1 = ($this->uri->segment(2) =='key_notes') ? 'active' : '';
	$class2 = ( $this->uri->segment(2) =='audio_video') ? 'active' : '';
	$class3 = ( $this->uri->segment(2) =='flash_cards') ? 'active' : '';
	$class4 = ( $this->uri->segment(2) =='written_answers') ? 'active' : '';
	$class5 = ( $this->uri->segment(2) =='multi_choice') ? 'active' : '';
?>

<div class="e-tabs">
	<ul class="nav nav-tabs mode-tabs-menu">
		<li role="presentation" class="<?php echo $class1; ?>"><?php echo anchor('section/key_notes/' . $this->uri->segment(3), 'Key Notes'); ?></li>
		<li role="presentation" class="<?php echo $class2; ?>"><?php echo anchor('section/audio_video/' . $this->uri->segment(3), 'Audio Video'); ?></li>
		<li role="presentation" class="<?php echo $class3; ?>"><?php echo anchor('section/flash_cards/' . $this->uri->segment(3), 'Flash Cards'); ?></li>
		<li role="presentation" class="<?php echo $class4; ?>"><?php echo anchor('section/written_answers/' . $this->uri->segment(3), 'Written Answers'); ?></li>
		<li role="presentation" class="<?php echo $class5; ?>"><?php echo anchor('section/multi_choice/' . $this->uri->segment(3), 'Multi Choice'); ?></li>
	</ul>
</div>

<div class="band-grey-topics">

	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<h2><?php echo ( isset($topic_label)) ? $topic_label->topic : 'Sorry, no topic found'; ?></h2>
				<div class="multiseparator vc_custom"></div>

				<?php
					if( $this->session->userdata('logged_in') ==1)
					{
						echo anchor('section/index', '<i class="fa fa-angle-left"></i> Topics', array('class'=>'btn btn-sm btn-red btn-back-2 pull-right'));
					}
					else
					{
						echo anchor('section/demo', '<i class="fa fa-angle-left"></i> Topics', array('class'=>'btn btn-sm btn-red btn-back-2 pull-right'));
					}
				?>

				

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

