	<?php
		// Set up social media icons for footer
		$facebook = array(
			'src' => $this->css_path_url . 'main/misc/icon_facebook.png',
			'alt' => 'facebook',
			'width' => '40',
			'height' => '40',
			'style' => 'text-align:center;'
		);

		$linkedIn = array(
			'src' => $this->css_path_url . 'main/misc/icon_linkedIn.png',
			'alt' => 'linkedIn',
			'width' => '40',
			'height' => '40',
			'style' => 'text-align:center;'
		);
	?>



	<footer class="footer" id="footer">
		<div class="container">

			<div class="row">

				<div class="col-sm-3">
					<h3>DOWNLOADS</h3>
					<?php echo anchor(base_url() . 'userfiles/file/elearn_siteGuide.pdf', '<i class="fa fa-cloud-download"></i> SITE GUIDE', array('class' => 'btn btn-md btn-red')); ?>
				</div>

				<div class="col-sm-3 social-media">
					<h3>CONTACT US</h3>
					<p>
						Ph (09) 410 9653 <br>
						Email: <a href="mailto: info@elearneconomics.com">info@elearneconomics.com</a>
					</p>
				</div>

				<div class="col-sm-3 social-media">
					<!-- Facebook Link -->
					<h3>SOCIAL MEDIA</h3>
					<a href="https://www.facebook.com/elearneconomics" target="_blank"><span class="icon-med"><i class="fa fa-facebook-official"></i></span></a>
					&nbsp;
					<!-- LinkedIN Link -->
					<a href="https://www.linkedin.com/company/elearn-resources-ltd?trk=biz-companies-cym" target="_blank"><span class="icon-med"><i class="fa fa-linkedin-square"></i></span></a>
				</div><!-- ENDS col -->

				<div class="col-sm-3">
					<h3>TERMS &amp; CONDITIONS</h3>
					<?php echo anchor('site/terms', '<i class="fa fa-search"></i> AVAILABLE HERE', array('class'=>'btn btn-md btn-red')); ?>
				</div><!-- ENDS col -->

				<div class="col-sm-6">
					<!-- Copyright Info -->
					<?php $copyright = ( date('Y') > 2012 ) ? '2012&ndash;' . date( 'Y' ) : '2012'; ?>
				</div>

			</div><!--ENDS row-->

		</div><!--ENDS container-->
	</footer><!-- ENDS footer -->


	<div class="container">
		<div class="row">
			<div class="col-sm-12 center">

				<!-- Link to Developer site -->
				<p><small>&copy;Copyright <?php echo anchor( '', $site_name ) . ' ' . $copyright; ?>. <br / class="visible-xs"> Website By: <?php echo anchor('http://www.lovegrovedesign.co.nz', 'Lovegrove Design'); ?></small></p>
			
			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->




	<?php
		// Show 'Back to Topics' animated button - only if user is on topic content pages (i.e., Key Notes, Audio/Video, Flash Cards, Writtem Answers, Multi-Choice)
		$sections_one = array('key_notes', 'audio_video', 'flash_cards', 'written_answers', 'multi_choice', 'leaders_school');

		if( in_array( $this->uri->segment(2), $sections_one ) ) {
			echo anchor('section/index', '<i class="fa fa-angle-left"></i>', array('id'=>'btn-back', 'class'=>'btn-back visible-md visible-lg'));
		}

		// Show 'Top of Page' animated button - only if user is on topic content pages (i.e., Home, Topics)
		// $sections_two = array('', 'index', 'aboutUs', 'news_full');

		if( ! in_array( $this->uri->segment(2), $sections_one ) ) {
			echo '<div class="btn-top visible-md visible-lg" id="btn-top"><i class="fa fa-angle-up"></i></div>';
		}
	?>



	<!-- Bootstrap js -->
	<script src="<?php echo base_url(); ?>js/bootstrap.js" type="text/javascript"></script><!-- Bootstrap JS -->
	<script src="<?php echo base_url(); ?>js/main.js" type="text/javascript"></script><!-- Main JS -->



	<?php 
	// Disable and hide 'Audo/Video' section nav button
	if( $this->session->userdata('no_video') ) { ?>
		<script>
			(function() {
				var disableBut = $('li#videoBlock');
				disableBut.hide();
			})();
		</script>
	<?php } ?>


</body>
</html>