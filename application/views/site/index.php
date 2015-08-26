<!-- Starts Carousel -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
	
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>

	<div class="carousel-inner" role="listbox">

		<div class="item active">
			<img class="first-slide center-block" src="<?php echo base_url() . 'images/banner_01.jpg'; ?>">
			<div class="container">
				<div class="carousel-caption pull-left">
					<h1 class="giant-text-rev">eLearn Economics</h1>
					<h2>Full Key Notes on ALL Topics</h2>
					<p>The site covers a wide range of courses and individuals have the ability to customise their course or do extension work</p>
					<p><a class="btn btn-lg btn-red" href="#" role="button">SUBSCRIBE TODAY</a></p>
				</div>
			</div>
		</div>
		<div class="item">
			<img class="second-slide center-block" src="<?php echo base_url() . 'images/banner_02.jpg'; ?>">
			<div class="container">
				<div class="carousel-caption pull-left">
					<h1 class="giant-text-rev">eLearn Economics</h1>
					<h2>Audio and Video Presentations</h2>
					<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
					<p><a class="btn btn-lg btn-red" href="#" role="button">Learn more</a></p>
				</div>
			</div>
		</div>
		
	</div><!-- ENDS carousel-inner -->

	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>

</div><!-- ENDS carousel -->




<!-- Main Home Page Content -->
<div class="container">


	<?php 
		$total = ( isset( $total ) ) ? $total : '';
		$num_users = ( isset( $num_users ) ) ? $num_users : '';
	?>

	<!-- Starts total tests completed counter -->
	<div class="row">
		<div class="col-sm-12 center">

			<div><strong><span class="count"><?php echo $total; ?></span></strong></div>
			<h4>online tests completed!</h4>

		</div><!-- ENDS col -->

	</div><!--ENDS row-->

	<br>


	<!-- Intro text -->
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">

			<div class="center">

				<h1>Want to learn Economics?</h1>
				<h4>
					Are you studying or teaching Macroeconomics, Microeconomics, Advanced Placement, IB&nbsp;Economics, Cambridge Economics or another Economics Course? 
				</h4>

				<p>
					 Help is at hand, elearnEconomics assists individuals studying Economics. This site covers a wide range of courses and individuals have the ability to customise their course or do extension work. It's simple, easy to use and very cost effective.
				</p>
				
			</div>

		</div><!-- ENDS col -->
	</div><!--ENDS row-->


<br><hr>

	<!-- Features and benefits (4 x boxes) -->
	<div class="row no-gutters">

		<div class="col-lg-12">

			<h2 class="center"><strong>Features &amp; Content</strong></h2>

			<div class="module-parent">

				
			
				<div class="col-md-3 modules green">
					<div class="module-head">
						<div class="icon-med text-green"><i class="fa fa-check-square-o"></i></div>
						<h4 class="text-green">Ticks all the boxes</h4>
					</div>
					<ul>
						<li>Quality economic content available 24/7</li>
						<li>Comprehensive range of material and activities</li>
						<li>Caters for different learning styles</li>
						<li>Q&amp;A's to build economic literacy</li>
						<li>Printable worksheets with answers</li>
						<li>Track and monitor progress for improved results</li>
						<li>Affordable</li>
					</ul>
				</div>

				<div class="col-md-3 modules red">
					<div class="module-head">
						<div class="icon-med text-red"><i class="fa fa-book"></i></div>
						<h4 class="text-red">Course material</h4>
					</div>
					<ul>
						<li>International Baccalaureate Economics (SL and HL)</li>
						<li>Cambridge AS and A Level Economics</li>
						<li>Cambridge IGCSE Economics</li>
						<li>Advanced Placement Microeconomics</li>
						<li>Advanced Placement Macroeconomics</li>
						<li>NCEA Economics</li>
					</ul>
				</div>
			
				<div class="col-md-3 modules yellow">
					<div class="module-head">
						<div class="icon-med text-yellow"><i class="fa fa-desktop"></i></div>
						<h4 class="text-yellow">Content formats</h4>
					</div>
					<ul>
						<li><strong>KEY NOTES</strong> - comprehensive explinations detailing each topic in depth </li>
						<li><strong>AUDIO/VIDEO</strong> - professionally animated and narrated video clips</li>
						<li><strong>FLASH CARDS</strong> - question and answer concept prompts</li>
						<li><strong>WRITTEN QUESTIONS</strong> - designed to enforce the learning process</li>
						<li><strong>MULTI-CHOICE</strong> - test your knowledge with tracked results</li>
					</ul>
				</div>

				<div class="col-md-3 modules blue">
					<div class="module-head">
						<div class="icon-med text-blue"><i class="fa fa-list"></i></div>
						<h4 class="text-blue">View the topics</h4>
					</div>
					<ul>
						<?php echo anchor(base_url() . 'section/demo/1', '<li>All Topics</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/3', '<li>AS</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/5', '<li>IB (SL)</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/7', '<li>AP Micro</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/10', '<li>NCEA Level 1</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/2', '<li>IGCSE</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/4', '<li>A2</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/6', '<li>IB (HL)</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/8', '<li>AP Macro</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/11', '<li>NCEA Level 2</li>'); ?>
						<?php echo anchor(base_url() . 'section/demo/12', '<li>NCEA Level 3</li>'); ?>
					</ul>
				</div>
			</div><!-- ENDS module parent -->

		</div><!-- ENDS col -->
			
	</div><!--ENDS row-->


	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 center">

			<h2><strong>A Great Learning Tool</strong></h2>
			<p>
				eLearnEconomics is a great learning tool and a comprehensive revision system, offering multiple ways of understanding the key concepts of economics through flash cards, key notes, audio/visual clips, written answers and multiple choice tests. It enables you to learn at your pace and in your own time. For more information, download the 'Site Guide' below.
			</p>
			<br>

			<?php echo anchor(base_url() . 'userfiles/file/elearn_siteGuide.pdf', '<i class="fa fa-cloud-download"></i> DOWNLOAD SITE GUIDE', array('class' => 'btn btn-lg btn-red')); ?>
			
		</div><!--ENDS col-->
	</div><!--ENDS row-->


</div><!--ENDS container-->




<!-- Starts Blog Section -->
<div class="container">
	<div class="row">
		<div class="col-sm-12">

			<?php
				// if( isset($news))
				// {
				// 	foreach($news as $row):

				// 		echo '<h1 class="bold">' . $row->title . '</h1>';
				// 		echo '<h5 class="bold textOrange">News Release: ' . $row->created_at . '</h5>';
				// 		echo $row->content;

				// 	endforeach;

				// 	echo '<p>' . anchor('#', 'HIDE', array('id' => 'hideNews')) . ' | ' . anchor('main/news', 'SEE MORE NEWS') . '</p>';
				// }
			?>
			
		</div><!--ENDS col-->
	</div><!--ENDS row-->
</div><!--ENDS container-->




<!-- Starts FREE Tour Section -->
<div class="band-grey mar60">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 center">

				<div class="icon-super text-green"><i class="fa fa-rocket"></i></div>

				<h2><strong>Take a Test Drive</strong></h2>
				
				<p>
					Take the <strong>FREE DEMO</strong> tour of eLearn Economics to sample the content and features available. Full members have unlimited access, with the addition of leader boards, progress charts and printable PDF worksheets with answers.
				</p>
				<br>

				<?php echo anchor('section/demo', 'TRY THE DEMO <i class="fa fa-arrow-right"></i>', array('class'=>'btn btn-lg btn-green')); ?>

			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS full-band-->






<!-- Starts Subscription Prices -->

<div class="container">
	<div class="row">

		<div class="col-sm-6">
			<div class="center">

				<div class="icon-sub-super text-red"><i class="fa fa-user"></i></div>
				<?php echo show_prices(0); ?> <!-- see section_helper.php -->
				<br>
				<?php echo anchor('paypal/items', '<i class="fa fa-credit-card"></i> SIGN UP NOW', array('class'=>'btn btn-lg btn-red')); ?>

			</div>
		</div><!--ENDS col-->

		<div class="col-sm-6">
			<div class="center">

				<div class="icon-sub-super text-blue"><i class="fa fa-users"></i></div>
				<?php echo show_prices(1); ?> <!-- see section_helper.php -->
				<br>
				<?php echo anchor('paypal/items', '<i class="fa fa-credit-card"></i> SIGN UP NOW', array('class'=>'btn btn-lg btn-blue')); ?>
				
			</div>
		</div><!--ENDS col-->

	</div><!--ENDS row-->
</div><!--ENDS container-->




<!-- Starts Testimonials -->
<div class="band-grey mar60">
	<div class="container">

		<div class="row">
			<div class="col-sm-12 center">
				<h2><strong>What our users are saying ...</strong></h2><br>
			</div>
		</div>

		<div class="row">
			
			<div class="col-sm-3">
				<p>The electronic flash cards are helpful, showing Q&amp;A in quick succession, getting a lot of info across in a short amount of time. You only need to go on for about 10 minutes at a time.<br /><br /><strong><em>Todd Year 11 </em></strong></p>
				<div class="multiseparator vc_custom"></div>
			</div><!--ENDS col-->

			<div class="col-sm-3">
				<p>I am a Year 11 homeschool student using your site to give me a good base for the economics course I was doing earlier, which I found far too difficult. I am finding the notes, revision help and tests great, I'm beginning to understand a lot of the concepts now.<br /><br /><strong><em>Thanks, Brianna</em></strong></p>
				<div class="multiseparator vc_custom"></div>
			</div><!--ENDS col-->

			<div class="col-sm-3">
				<p>What a brilliant site for both the gifted, independent student and the reluctant, struggling pupil. The element of competition gave the site an extra spark and the range of topics covered gives all learners the chance to reinforce and revise at their own pace. Excellent and irrefutable evidence for parents too. <br /><br /><strong><em>Aimee Reynolds Curriculum Leader Economics Tunbridge Wells Girls' Grammar School</em></strong></p>
				<div class="multiseparator vc_custom"></div>
			</div><!--ENDS col-->
			
			<div class="col-sm-3">
				<p>The on-line tests have helped my ESOL students learn the terms and concepts and now they are able to use them with success in written answers.<br /><br /><strong><em>Vanessa - Assistant HOD Commerce, Economics Curriculum Manager</em></strong></p>
				<div class="multiseparator vc_custom"></div>
			</div><!--ENDS col-->

		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS full-band-->



