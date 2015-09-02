<div class="band-grey">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-full">
				
				<h2>Subscription Options</h2>
				<div class="multiseparator vc_custom"></div>


				<p><strong>HAVE YOU BEEN GIVEN A SCHOOL ACCESS CODE?</strong><br /> If you have, please <?php echo anchor('add_member_codes', 'CLICK HERE'); ?> to subscribe through your school.</p><br>

				<?php

					if( isset( $items ) ) {

						$count = count($items);

						for($i = 0; $i < $count; $i++) {
							$id[$i] = $items[$i]->id;
							$name[$i] = $items[$i]->name;
							$price[$i] =  $items[$i]->price;
							$description[$i] =  $items[$i]->description;
							$special_offer[$i] =  $items[$i]->special_offer;
						}

					}

				?>


				<div class="row">
					<div class="col-sm-6">
						<div class="subs-container-light">
							<h2><?php echo $name[0]; ?></h2>
							<div class="multiseparator vc_custom"></div>
							<h3>$<?php echo $price[0]; ?></h3>
							<p><strong><?php echo $special_offer[0]; ?></strong></p>
							<p><small><?php echo $description[0]; ?></small></p>
							<br>

							<?php $segments = array( 'purchase', url_title( $name[0], 'dash', true ), $id[0] ); ?>
							<?php echo anchor( $segments, 'PURCHASE NOW', array('class'=>'btn btn-lg btn-red')) ?>

						</div>
					</div>

					<div class="col-sm-6">
						<div class="subs-container-dark">
							<h2><?php echo $name[1]; ?></h2>
							<div class="multiseparator vc_custom"></div>
							<h3>$<?php echo $price[1]; ?></h3>
							<p><strong><?php echo $special_offer[1]; ?></strong></p>
							<p><small><?php echo $description[1]; ?></small></p>
							<br>

							<?php echo anchor( 'items/school_order', 'ORDER NOW', array('class'=>'btn btn-lg btn-red')) ?>

						</div>
					</div>
				</div>



			</div><!--ENDS col-->


			<div class="col-md-3 sidebar">

				<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>

			</div><!--ENDS col-->


			</div><!--ENDS col-->
		</div><!--ENDS row-->
	</div><!--ENDS container-->
</div><!--ENDS band-grey-->

