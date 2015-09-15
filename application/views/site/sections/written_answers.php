<div class="band-white">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">


				<?php
				
					// Display users answers and model answers
					if( isset($result))
					{
						echo '<h2>Answers</h2>';
						echo '<div class="multiseparator vc_custom"></div>';
						echo $result;

						// Restart new test of current topic (large screens)
						echo anchor('section/written_answers/'. $this->uri->segment(3), 'Another Test?', array('class'=>'btn btn-lg btn-red hidden-xs'));
						// (mobile screens)
						echo anchor('section/written_answers/'. $this->uri->segment(3), 'Another Test?', array('class'=>'btn btn-lg btn-red btn-block visible-xs'));

					}

				?>

				

				<!--ADD START OF FORM IN HERE - REMEMBR CSS!!!!-->
				<?php

				echo form_open('section/written_answers/' . $this->uri->segment(3), array('class' => 'section_form', 'id' => 'section_form'));

					echo '<div id="owl-example" class="owl-carousel">';

						if( isset($written_answers))
						{
							$count = 1; //Start $count var (used to display question numbers)
							
							foreach($written_answers as $row): //Iterate through each question

							$image = array(
								'src' => base_url() . 'images/images/' . $row->image,
								'alt' => 'eLearn Economics',
								'width' => '440',
								'height' => '293',
								'style' => 'float:right; margin:0 0 20px 20px;',
								'class' => 'img-responsive'
							);

							//Only show image if there is one (otherwise leaves an empty box in some browsers)!
							$display_image = ( $row->image !='' ) ? img($image) : '';

								echo '<div class="owl-carousel-cont">';
									echo '<h2><span class="quest-num">Q'.$count.'</span> ' . $display_image . '</h2>';
									echo '<h3>QUESTION:</h3>';
									echo '<p>' . $row->question . '</p>';

									echo '<input type="hidden" name="question[]" id="question[]" value=" ' . $row->question . ' " />'; //Hidden field containing Question
									//echo '<input type="hidden" name="mod_answer[]" id="mod_answer[]" value=" ' . $this->encrypt->encode( $row->answer ) . ' " />'; //Hidden field containing Model Answer
									echo '<textarea name="mod_answer[]" id="mod_answer[]" style="display:none;">' . $this->encrypt->encode( $row->answer ) . '</textarea>'; //Input field containing User Answer
									echo '<input type="hidden" name="image[]" id="image[]" value="'.$row->image.'" />';
									echo '<textarea rows="6" name="answer[]" class="form-control" id="answer[]" ></textarea>'; //Input field containing User Answer
								
									if($count == 5) {
										echo '<input name="submit" type="submit" class="btn btn-md btn-red" id="submit_but" value="Submit and Review" />';
									}

								echo '</div>';

							$count++;

							endforeach;
						}

					echo '</div>';

				echo form_close();

				?>


			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->


<script>

    $(document).ready(function() {
     
      $("#owl-example").owlCarousel({
     
		navigation : true, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		autoHeight: true,
		responsiveRefreshRate: 50,
		paginationNumbers: false

      });
     
    });

</script>

