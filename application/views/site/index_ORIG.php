<?php
/********************************************************************************************/
// DISPLAYS THE IMAGE FADER BANNER AT TOP OF PAGE. Images received from $image_array()
/********************************************************************************************/
$image_array = array(
	'slider_00.png',
	'slider_01.png',
	'slider_02.png',
	'slider_03.png',
	'slider_04.png',
	'slider_05.png',
	'slider_06.png',
	'slider_07.png',
	'slider_08.png'
);

echo '<div class="slider">';

	foreach($image_array as $row):
		echo '<div><img src="'.base_url() . 'js/slider/large/' . $row . '" alt="The Events Group" /></div>';
	endforeach;

echo '</div>';

?>

<div id="news" class="grid_12 alpha textPadding gridPadding" style="background:#F2F2F2; display:none;">

	<?php
		if( isset($news))
		{
			foreach($news as $row):

				echo '<h1 class="bold">' . $row->title . '</h1>';
				echo '<h5 class="bold textOrange">News Release: ' . $row->created_at . '</h5>';
				echo $row->content;

			endforeach;

			echo '<p>' . anchor('#', 'HIDE', array('id' => 'hideNews')) . ' | ' . anchor('main/news', 'SEE MORE NEWS') . '</p>';
		}
	?>

</div>

<!--FEATURE INTRODUCTION-->


<div class="grid_12 gridPadding textPadding" style="text-align:center;">
	<span class="genericBut genOrange"><?php echo anchor('section/demo', 'TRY FREE DEMO'); ?></span>
	<h4 class="marginTop">Take the free demo tour of eLearn Economics to sample the content and features available. <br> Full members have unlimited access, with the addition of leader boards and progress charts. </h4>
</div>



<!--SUBSCRIPTION PRICES-->
<div class="grid_6 alpha gridPadding textPadding" align="center">
	<?php echo show_prices(0); ?> <!-- see section_helper.php -->
	<span class="genericBut genGreen"><?php echo anchor('paypal/items', 'SUBSCRIBE'); ?></span>
</div>

<div class="grid_6 omega gridPadding textPadding" align="center">

	<?php echo show_prices(1); ?> <!-- see section_helper.php -->
	<span class="genericBut genGreen"><?php echo anchor('paypal/items', 'SUBSCRIBE'); ?></span>

</div>





<!--TESTIMONIALS Auto Scroll-->
<h2 align="center" class="bold" style="margin:10px 0 -10px 0;">What teachers and students are saying about eLearnEconomics ...</h2>
<div class="grid_12">

	<div id="scroller">
		<div class="grid_4">
			<div class="scrollerDiv">
				<blockquote>The electronic flash cards are helpful, showing Q&amp;A in quick succession, getting a lot of info across in a short amount of time. You only need to go on for about 10 minutes at a time.<br /><strong>Todd Year 11</strong></blockquote>
			</div>
		</div>
		<div class="grid_4">
			<div class="scrollerDiv">
				<blockquote>I am a Year 11 homeschool student using your site to give me a good base for the economics course I was doing earlier, which I found far too difficult. I am finding the notes, revision help and tests great, I'm beginning to understand a lot of the concepts now.<br /><strong>Thanks, Brianna</strong></blockquote>
			</div>
		</div>
		<div class="grid_4">
			<div class="scrollerDiv">
				<blockquote>The multi choice questions are very useful as they break down the standards and quickly show me what parts I need to study more.<br /><strong>Nicole Year 12</strong></blockquote>
			</div>
		</div>
		<div class="grid_4">
			<div class="scrollerDiv">
				<blockquote>What a brilliant site for both the gifted, independent student and the reluctant, struggling pupil. The element of competition gave the site an extra spark and the range of topics covered gives all learners the chance to reinforce and revise at their own pace. Excellent and irrefutable evidence for parents too. <br /><strong>Aimee Reynolds Curriculum Leader Economics Tunbridge Wells Girls' Grammar School</strong></blockquote>
			</div>
		</div>
		<div class="grid_4">
			<div class="scrollerDiv">
				<blockquote>The on-line tests have helped my ESOL students learn the terms and concepts and now they are able to use them with success in written answers.<br /><strong>Vanessa - Assistant HOD Commerce, Economics Curriculum Manager</strong></blockquote>
			</div>
		</div>

	</div><!-- ENDS grid_12 -->
	
</div>



<script>

(function(){

	$("#showNews").on('click', function (e) {
		e.preventDefault();
		$("#news").slideDown(300);
	});

	$("#hideNews").on('click', function (e) {
		e.preventDefault();
		$("#news").slideUp(300);
	});
})();

</script>