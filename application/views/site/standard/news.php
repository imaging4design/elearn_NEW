<div class="band-white">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-full">
				
				<h2>Latest News</h2>
				<div class="multiseparator vc_custom"></div>

				<?php
					if( isset($news))
					{
						foreach($news as $row):

							echo '<h4>' . $row->title . '</h4>';
							echo '<h6 class="created">Created on: ' . $row->created_at . '</h6>';
							echo word_limiter($row->content, 40) . '<br /> <br />';
							echo anchor('site/news_full/' . $row->id, 'READ MORE <i class="fa fa-arrow-right"></i> ', array('class'=>'btn btn-sm btn-red'));

						endforeach;
					}
				?>

			</div><!--ENDS col-->

			<div class="col-md-3 sidebar">

				<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>
				
			</div><!--ENDS col-->


		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-white-->