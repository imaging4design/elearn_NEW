<div class="gridPadding textPadLeft">

	<?php

	// Work out what access level this admin user is before displaying all editing menu options
	// Id admin does NOT have 'master' access only display TOPICS and CONTENT editing buttons

	// Initiate $access var
	$access = FALSE;

	if( $this->session->userdata('level') == 1 )
	{	
		$access = 'master';
	}
	
	?>


	<h1 class="greyArrow textOrange"><strong>Admin Menu</strong></h1>
	<p>Select the section you wish to edit:</p>
	<p>
		<?php
			echo '<span class="adminBut" id="topics">' . img($this->css_path_url . 'admin/icons/32/order-162.png') . '<br />Topics</span>';
			echo '<span class="adminBut" id="content">' . img($this->css_path_url . 'admin/icons/32/pen.png') . '<br />Content</span>';
			if( $access == 'master') { echo '<span class="adminBut" id="subscriptions">' . img($this->css_path_url . 'admin/icons/32/payment-card.png') . '<br />Subscriptions</span>'; }
			if( $access == 'master') { echo '<span class="adminBut" id="subscribers">' . img($this->css_path_url . 'admin/icons/32/customers.png') . '<br />Subscribers</span>'; }
			if( $access == 'master') { echo '<span class="adminBut" id="setup">' . img($this->css_path_url . 'admin/icons/32/config.png') . '<br />General</span>'; }
			echo anchor('admin/login_con/logout', img($this->css_path_url . 'admin/icons/32/logout.png') . '<br />Log Out', array('class' => 'adminBut'));
		?>
	</p>


	  
	<!-- DISPLAY TOPICS EDITING OPTIONS -->
	<div class="topics hide" style="display:none;">
	<h3 class="greyArrow textOrange"><strong>Manage Topics</strong></h3>
	<p>Add new topics or edit the names of existing topics.</p>
	<p>
		<?php
			echo anchor('topic_con/add_topics', img($this->css_path_url . 'admin/icons/32/plus.png') . '<br />Add Topic', array('class' => 'adminBut'));
			echo anchor('topic_con/show_topics', img($this->css_path_url . 'admin/icons/32/pencil.png') . '<br />Edit Topic', array('class' => 'adminBut'));
		?>
	</p>
	</div>

	  
	  
	<!-- DISPLAY CONTENT EDITING OPTIONS -->
	<div class="content hide" style="display:none;">
	<h3 class="greyArrow textOrange"><strong>Manage Content</strong></h3>
	<p>Add or edit content within the following sections.</p>
	<p>
		<?php
			echo anchor('content_con/index/key_notes', img($this->css_path_url . 'admin/icons/32/attibutes.png') . '<br />Key Notes', array('class' => 'adminBut'));
			echo anchor('content_con/index/audio_video', img($this->css_path_url . 'admin/icons/32/showreel.png') . '<br />Audio / Video', array('class' => 'adminBut'));
			echo anchor('content_con/index/flash_written', img($this->css_path_url . 'admin/icons/32/brainstorming.png') . '<br />Flash / Written', array('class' => 'adminBut'));
			echo anchor('content_con/index/multi_choice', img($this->css_path_url . 'admin/icons/32/credit-card.png') . '<br />Multi Choice', array('class' => 'adminBut'));
		?>
	</p>
	</div>
	  
	 

	<!-- DISPLAY SUBSCRIPTION OPTIONS -->
	<div class="subscriptions hide" style="display:none;">
	<h3 class="greyArrow textOrange"><strong>Manage Subscriptions</strong></h3>
	<p>Edit the description or price of a subscription option below.</p>
	<p>
		<?php
			echo anchor('subscription_con/get_subscriptions', img($this->css_path_url . 'admin/icons/32/paypal.png') . '<br />Edit Subscriptions', array('class' => 'adminBut'));
		?>
	</p>
	</div>

	  
	  
	<!-- DISPLAY SUBSCRIBER OPTIONS -->
	<div class="subscribers hide" style="display:none;">
	<h3 class="greyArrow textOrange"><strong>Manage Subscribers</strong></h3>
	<p>Search for subscribers by student or school below.</p>
	<p>
		<?php
			echo anchor('subscribers_con/get_student_details', img($this->css_path_url . 'admin/icons/32/user.png') . '<br />Search Students', array('class' => 'adminBut'));
			echo anchor('subscribers_con/get_school_details', img($this->css_path_url . 'admin/icons/32/freelance.png') . '<br />Search Schools', array('class' => 'adminBut'));
			echo anchor('subscribers_con/school_admin_form', img($this->css_path_url . 'admin/icons/32/settings.png') . '<br />Regsiter School', array('class' => 'adminBut'));
			echo anchor('subscribers_con/school_form', img($this->css_path_url . 'admin/icons/32/pen.png') . '<br />Edit School List', array('class' => 'adminBut'));
			echo anchor('subscribers_con/access_code_form', img($this->css_path_url . 'admin/icons/32/administrative-docs.png') . '<br />Create Access Codes', array('class' => 'adminBut'));
			echo anchor('subscribers_con/select_access_codes', img($this->css_path_url . 'admin/icons/32/zoom.png') . '<br />View Access Codes', array('class' => 'adminBut'));
		?>
	</p>
	</div>
	 

	  
	<!-- DISPLAY SCHOOL CONFIG OPTIONS -->
	<div class="setup hide" style="display:none;">
	<h3 class="greyArrow textOrange"><strong>General Options</strong></h3>
	<p>Manage FAQs and Latest News sections.</p>
	<p>
		<?php
			echo anchor('general_con/show_faqs', img($this->css_path_url . 'admin/icons/32/freelance.png') . '<br />FAQs', array('class' => 'adminBut'));
			echo anchor('general_con/view_latest_news', img($this->css_path_url . 'admin/icons/32/future-projects.png') . '<br />Lastest News', array('class' => 'adminBut'));
			echo anchor('general_con/clean_out_users', img($this->css_path_url . 'admin/icons/32/process.png') . '<br />Clean Out Users', array('class' => 'adminBut'));
		?>
	</p>
	</div>
 


</div>

<script>
/*******************************************/
/* SHOW / HIDE Menu Sub Items
/*******************************************/
(function(){
	
	$('span').on('click', function(){
												
			/* Get the 'id' of the link that was clicked on */
			var id = $(this).attr('id'); 
			
			/* Slide down the revelant div with corresponding 'id' */
			/* Hide all other divs */
			$('.' + id).slideDown(200).siblings('.hide').hide(200);			
			
	})	
					
})();
</script>