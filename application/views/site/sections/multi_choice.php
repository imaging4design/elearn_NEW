<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">


			<?php

			//Display users answers and model answers
			if( isset($result))
			{
				// Display score in text output
				echo '<h3 class="bold" align="center">ANSWERS: You scored ' . $score . ' out of 10</h3>';

				// Display score in graphic output
				echo '<div class="guage guage_grey">';
				echo '<div class="guage guage_green" style="width:'.$score.'0%;"></div>';
				echo '</div>';
				
				// Display actual list of results as $results array
				echo $result;

				// Restart new test of current topic
				echo '<div class="genericBut genOrange center"><a href="'. $this->uri->segment(3) .'">Restart Test</button></a></div>';
			}

			?>




				
			<!--ADD START OF FORM IN HERE - REMEMBR CSS!!!!-->
			<?php
			echo form_open('section/multi_choice/' . $this->uri->segment(3), array('class' => 'section_form', 'id' => 'section_form'));
				
				// IMPORTANT - Needed to stop page reloads adding additional scores!!!!
				echo '<input type="hidden" name="token" id="token" value="'.$token.'" />';

				echo '<div id="owl-example" class="owl-carousel">';

					if( isset($multi_choice))
					{
						//Start $count var (used to display question numbers)
						$count = 1; 
						
						foreach($multi_choice as $row): //Iterate through each question

							$image = array(
								'src' => base_url() . 'images/images/' . $row->image,
								'alt' => 'eLearn Economics',
								'width' => '440',
								'height' => '293',
								'style' => 'float:right; margin:0 0 20px 20px;',
								'class' => 'img-responsive'
							);


							$id = $row->id;

							$opt1 = $row->opt1; 
							$opt2 = $row->opt2; 
							$opt3 = $row->opt3; 
							$opt4 = $row->opt4; 

							$answer = $row->answer; 
							$picture = $row->image; 



							//Only show image if there is one (otherwise leaves an empty box in some browsers)!
							$display_image = ( $row->image !='' ) ? img($image) : '';

								//Display BOTH Question AND Answer on the same slide - (refer student config for flash_opt)
								echo '<div class="owl-carousel-cont">';

									echo '<h2><span class="quest-num">Q'.$count.'</span> ' . $display_image . '</h2>';
									echo '<h3>QUESTION: <span class="log"></span></h3>';
									echo '<p>' . $row->question . '</p>';

								

									//Hidden field containing the CORRECT ANSWER
									echo '<input type="hidden" name="id[]" id="id[]" value="'.$row->id.'" />'; 
									echo '<input type="hidden" name="question[]" id="question[]" value="'.$row->question.'" />'; 
									echo '<input type="hidden" name="answer[]" id="answer[]" value="'. $this->encrypt->encode( $row->answer ) .'" />'; // Encrypt the answer so can't be seen in the source code
									echo '<input type="hidden" name="reason[]" id="reason[]" value="'. $this->encrypt->encode( $row->reason ) .'" />';  // Encrypt the reason so can't be seen in the source code
									echo '<input type="hidden" name="image[]" id="image[]" value="'.$row->image.'" />'; 


									//Create a shuffle($array) of $opt's
									// Why? So each time test is taken answers are presented in a random order
									$options = array($opt1, $opt2, $opt3, $opt4);
									shuffle($options);

									// Display each option
									foreach ($options as $option)
									{
										echo '<div class="radio">';
										echo '<label>';
										echo '<input type="radio" name="q'.$row->id.'" class="radio_class owl-next" id="q' . $row->id . '" value="' . $option . '">';
										echo $option;
										echo '</label>';
										echo '</div>';
									}


									if($count == 10) {

										echo '<input name="submit" type="submit" class="btn btn-md btn-red" id="submit_but" value="Submit and Review" /><br />';
										
										echo '<div class="checkbox">';
										echo '<label id="options">';
										echo '<input type="checkbox" name="show_answers" id="show_answers" value="1" checked="checked">';
										echo ' Show Correct Answers and Reasons?';
										echo '</label>';
										echo '</div>';

										echo '<br /><br />';

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


<script>

(function(){

	$('#submit_but').hide(); 	// Hide submit button unless ALL 10 questions have been answered
	$('#options').hide(); 		// Hide options checkbox unless ALL 10 questions have been answered


	//Clear ALL form values & submit buttons / options (on submit) to avoid back button being used to alter answers
	$('#submit_but').click(function() {

		setTimeout(function() {
			$('#section_form')[0].reset();
			$('.log').empty();
			$('#submit_but').hide();
			$('#options').hide(); 
		}, 100); //wait one second to run function

	});


	function countChecked() 
	{
		var n = $("input:radio[class*='radio_class']:checked").length;


		if(n > 0) // Display feedback to user when an answer has been selected
		{
			$('.log').empty();
			$("<span class='message_accepted'>( " + n + " answered )</span>").appendTo('.log').hide().fadeIn(1000);
		}



		if( n == 10 ) // Display submit answers / options when ALL 10 answers been selected
		{
			//$("#coda-nav-right-1").html('Test Complete - submit your answers');
			$('#submit_but').delay(200).fadeIn(400);
			$('#options').delay(200).fadeIn(400);
		}

		//console.log('clicked ' + n + ' time(s)');

	}


	//Run above countChecked() function
	$(":radio").click(countChecked);


})();

</script>

