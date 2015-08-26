<div class="container">
	<div class="row">
		<div class="col-sm-9 col-full">
			
			<h2>Subscription Options</h2>
			<div class="multiseparator vc_custom"></div>

			<?php

				echo '<p>HAVE YOU BEEN GIVEN A SCHOOL ACCESS CODE?<br /> If you have, please ' . anchor('add_member_codes', 'CLICK HERE') . ' to subscribe through your school.</p>';
				echo '<br/>';

				if ( ! $items )
				{
					echo '<p>No items found.</p>';
				}
				else
				{
					
				  foreach ( $items as $item ):
					
					$segments = array( 'purchase', url_title( $item->name, 'dash', true ), $item->id );
					
					echo '<h2 class="text-capitalize">' . $item->name . ' <span class="label label-default">$' . $item->price . '</span> <small>(incl GST)</small></h2>';
					echo '<div class="multiseparator vc_custom"></div>';
					echo '<p class="text-red">' . $item->special_offer . '</p>';
					echo '<p>' . $item->description . '</p><br />';
					
					if( $item->subType == 0) 
					{
						// (i.e., a 'student subscription' - send to PayPal)
						echo anchor( $segments, 'PURCHASE NOW', array('class'=>'btn btn-lg btn-green')) . '<br/> <br/>';
					}
					else
					{
						// (i.e., a 'school subscription' - send to manual order page)
						echo anchor( 'items/school_order', 'ORDER NOW', array('class'=>'btn btn-lg btn-green')) . '<br/> <br/>';
					}
					
						
				  endforeach;
				 
				}
			?>


		</div><!--ENDS col-->


		<div class="col-sm-3 sidebar">

			<?php include('application/views/site/includes/sidebar.php'); // Pulls in side bar ?>

		</div><!--ENDS col-->


		</div><!--ENDS col-->
	</div><!--ENDS row-->
</div><!--ENDS container-->



