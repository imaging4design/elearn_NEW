<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			
			<?php

				/********************************************************************************************************/
				// DISPLAY MAIN CONTENT (AUDIO / VIDEO)
				/********************************************************************************************************/

				// Set full path to video files
				$path = base_url() . 'video/'; 

				if( isset($audio_video))
				{
					foreach($audio_video as $row):

						$video = $row->fileName;

						//echo $row->fileName;

			?>

				<!-- Start EasyHtml5Video.com BODY section -->
				<div data-video="isvideo" id="checkVideo" class="center video">

					<video controls="controls"  poster="<?php echo $path; ?><?php echo $video; ?>/<?php echo $video; ?>.jpg" width="900" height="480"  onclick="if(/Android/.test(navigator.userAgent))this.play();">

						<source src="<?php echo $path; ?><?php echo $video; ?>/<?php echo $video; ?>.mp4" type="video/mp4" />
						<source src="<?php echo $path; ?><?php echo $video; ?>/<?php echo $video; ?>.webm" type="video/webm" />
						<source src="<?php echo $path; ?><?php echo $video; ?>/<?php echo $video; ?>.ogv" type="video/ogg" />

						<object type="application/x-shockwave-flash" data="<?php echo $path; ?><?php echo $video; ?>/flashfox.swf" width="900" height="480" style="position:relative;">
						<param name="movie" value="<?php echo $path; ?><?php echo $video; ?>/flashfox.swf" />
						<param name="allowFullScreen" value="true" />
						<param name="flashVars" value="autoplay=true&amp;controls=true&amp;loop=true&amp;src=<?php echo $video; ?>.mp4" />
						 <embed src="<?php echo $path; ?><?php echo $video; ?>/flashfox.swf" width="900" height="480" style="position:relative;"  flashVars="autoplay=true&amp;controls=true&amp;loop=true&amp;poster=<?php echo $path; ?><?php echo $video; ?>/<?php echo $video; ?>.jpg&amp;src=<?php echo $video; ?>.mp4"	allowFullScreen="true" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_en" />
						<img alt="<?php echo $video; ?>" src="<?php echo $path; ?><?php echo $video; ?>/<?php echo $video; ?>.jpg" style="position:absolute;left:0;" width="900" height="480" title="Video playback is not supported by your browser" />
						</object>

					</video>

				</div>

				<!-- <script src="<?php //echo $video; ?>/html5ext.js" type="text/javascript"></script> -->
				<!-- End EasyHtml5Video.com BODY section -->


			<?php
				endforeach;
				
				}
				else
				{
					$image = array(
						'src' => $this->css_path_url . 'main/misc/blue_monster.jpg',
						'alt' => 'eLearn Economics',
						'width' => '300',
						'height' => '300',
						'style' => 'margin:0 auto;'
					);

					echo '<div align="center">';
						echo '<h3><span class="bold">Sorry,</span> there is no Audio / Video resource available for this topic at present.</h3>';
						echo img($image);
					echo '</div>';
				}
			?>

			<a style="display:none" href="http://easyhtml5video.com">html5 video chrome by EasyHtml5Video.com v1.5.1m</a>


		</div><!--ENDS col-->
	</div><!--ENDS row-->
</div><!--ENDS container-->

