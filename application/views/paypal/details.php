<div class="band-grey">
	<div class="container">
		<div class="row">

			<div class="col-md-9 col-full">
				
				<h2>Subscription Details</h2>
				<div class="multiseparator vc_custom"></div>


				<h2 class="text-capitalize"><?php echo $item->name . ' <span class="label label-default">$' . $item->price . '</span>'; ?></h2>
				<p class="text-redLight"><?php echo $item->special_offer; ?></p>
				<p><?php echo $item->description; ?></p>

				<?php $segments = array( 'purchase', url_title( $item->name, 'dash', true ), $item->id ); ?>

				<span>
					<br>
					<?php echo anchor( $segments, 'BUY NOW', array('class'=>'btn btn-lg btn-red')); ?>
				</span>

			</div><!--ENDS col-->


			<div class="col-md-3 sidebar">

				<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>

			</div><!--ENDS col-->

		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-grey-->








