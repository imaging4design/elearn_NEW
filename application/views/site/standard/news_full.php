<div class="container">
	<div class="row">
		<div class="col-sm-9 col-full">
			
			<h2>eLearn Economics Latest</h2>
			<div class="multiseparator vc_custom"></div>


			<?php
				if( isset($news_full))
				{
					echo '<h4>' . $news_full->title . '</h4>';
					echo '<h6 class="created">Created on: ' . $news_full->created_at . '</h6>';
					echo $news_full->content;
					echo anchor('site/news', '<i class="fa fa-arrow-left"></i> BACK TO NEWS', array('class'=>'btn btn-sm btn-red'));

				}

			?>

		</div><!--ENDS col-->

		<div class="col-sm-3 sidebar">

			<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>

		</div><!--ENDS col-->
	</div><!--ENDS row-->
</div><!--ENDS container-->