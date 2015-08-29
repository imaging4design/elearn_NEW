<div class="band-white">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<div id="owl-example" class="owl-carousel">
					
					
					<?php
						/********************************************************************************************************/
						// DISPLAY MAIN CONTENT (FLASH CARDS)
						/********************************************************************************************************/

						if( isset($flash_cards)) {

							//Initialise '$flash_opt' (i.e., single or double slides) - default id double slide - answers and questions 
							$flash_opt = ( $this->session->userdata('flash_opt') ) ? $this->session->userdata('flash_opt') : 'combine';
							
							$count = 1; //Start $count var (used to display question numbers)
							
							foreach($flash_cards as $row): //Iterate through each question

								$image = array(
									'src' => base_url() . 'images/images/' . $row->image,
									'alt' => 'eLearn Economics',
									'width' => '440px',
									'height' => '293',
									'style' => 'float:right; margin:0 0 20px 20px;',
									'class' => 'img-responsive'
								);

								//Only show image if there is one (otherwise leaves an empty box in some browsers)!
								$display_image = ( $row->image !='' ) ? img($image) : '';

									//if($flash_opt == 'combine')
									{
										//Display BOTH Question AND Answer on the same slide - (refer student config for flash_opt)
										echo '<div class="owl-carousel-cont">';
											echo '<h2><span class="quest-num">Q'.$count.'</span> ' . $display_image . '</h2>';
											echo '<h3>QUESTION:</h3>';
											echo '<p>' . $row->question . '</p>';
											echo '<h3>ANSWER:</h3>';
											echo '<p>' . $row->answer . '</p>';

											if($count == 10) {
												echo anchor('section/flash_cards/1', 'Shuffle', array('class'=>'btn btn-md btn-red'));
											}

										echo '</div>';
									}
									// else
									// {
									// 	//Display Question and Answer on SEPARATE slides - (refer student config for flash_opt)
									// 	echo	'<h2 class="title">Q'.$count.'</h2>';
									// 	echo 	'<h3>' . $display_image . '<span class="textOrange bold">QUESTION: </span><br />'.$row->question.'</h3><br />';
									// 	echo	'<h2 class="title">A'.$count.'</h2>';
									// 	echo 	'<h3>' . $display_image . '<span class="textOrange bold">ANSWER: </span><br />'.$row->answer.'</h3><br />';
										

									

									// }
								
								$count++;

							endforeach;
						
						} else {

							//Initialise Var if no Flash Questions present !important to prevent error message
							$flash_opt = 'combine';
						}

					?>
					

				</div><!-- ENDS owl-example -->


				<!-- OPTIONS :: to include the answer and question together or separate them on different slides -->
				<?php echo form_open('section/flash_cards/' . $this->uri->segment(3), array('class' => 'section_form', 'id' => 'section_form')); ?>

					<div class="radio">
						<label>
							<input type="radio" name="flash_opt" class="flash_opt" id="optionsRadios1" value="combine" <?php if( $flash_opt == 'combine' ) { echo 'checked = \"checked\"'; } ?> />
							Answers on same slide
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="flash_opt" class="flash_opt" id="optionsRadios2" value="separate" <?php if( $flash_opt == 'separate' ) { echo 'checked = \"checked\"'; } ?> />
							Answers on following slide
						</label>
					</div>
					
					<!-- <input type="submit" id="submit_But" class="btn btn-sm btn-red" value="Change" /> -->

				<?php echo form_close(); ?>


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

