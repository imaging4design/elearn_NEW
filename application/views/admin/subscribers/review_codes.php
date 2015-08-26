<h1 class="gridHeader strong">Review Codes</h1>

<div class="gridPadding textPadLeft">

	<?php 
		echo anchor('subscribers_con/access_code_form', 'Create Codes', array('class' => 'butSmall butRight'));
		echo anchor('subscribers_con/school_admin_form', 'School Admin', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/school_form', 'Edit School List', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_school_details', 'Search Schools', array('class' => 'butSmall butBack'));
		echo anchor('subscribers_con/get_student_details', 'Search Students', array('class' => 'butSmall butBack'));
	?>
	
	<h1 class="greyArrow textOrange"><strong>Review Codes</strong></h1>
  <p>Select a school to view their active access codes</p>
  
  <?php echo form_open('subscribers_con/view_access_codes'); ?>

    <div id="container">
    
    <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
    
    <fieldset>
    <legend>REVIEW ACCESS CODES</legend>
    
      <?php echo codes_schools_dropdown('', '', 'Select School'); ?>
      <input type="submit" id="submit" value="View Codes" class="butSmall" />
      
    </fieldset>
    
    <div class="containerArea"></div>
    
    </div>
    
  <?php 
	// Display success message if codes deleted
	if( isset($this->message))
	{
		echo $this->message;
	}
		
	echo form_close(); 
	?>
  
  
  
  
  <?php
	/**************************************************************************/
	// Display list of access codes for school
	/**************************************************************************/
	if( isset($codes))
	{

	echo form_open('subscribers_con/delete_access_codes');
		
		echo '<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="25%" class="strong">Batch Name:</td>
				<td width="25%" class="strong">Access Code:</td>
				<td width="25%" class="strong">Created:</td>
				<td width="25%" class="strong">Used/Unused</td>
				<td width="25%" class="strong">Delete:</td>
			</tr>';
		
		$count = 1;
		$used = 0;

		foreach( $codes as $row ):

			// Format 'Status'
			$status = ($row->status == 1) ? '<span class="textOrange bold">USED</span>' : '';
		
			echo '<tr>
				<td width="25%">' . $count . '. ' . $row->batch . '</td>
				<td width="25%">' . $row->access_code . '</td>
				<td width="25%">' . $row->created_at . '</td>
				<td width="25%">' . $status . '</td>
				<td width="25%" align="left"><input type="checkbox" name="deleteCode[]" id="deleteCode[]" value="'.$row->codeID.'" /></td>
			</tr>';
		
		$count++;
		if($status) {
			$used++;
		}

		endforeach;
		
		echo '</table><br />';
		
		echo '<input type="submit" id="submit" value="Delete Codes" class="butSmall" />';
		
	echo form_close();	

	echo '<h4><span class="strong">Total Codes: ' . count($codes) . '</span> | Used: ' . $used . ' | Unused: ' . (count($codes) - $used) . '</h4>';
	
	}
	
	?>
  
  
</div>

<!--JAVASCRIPT - USED TO ALTERNATE THE COLOUR OF TABLE ROWS ABOVE-->
<script>
	$('tr:odd').css('background', '#EBEBEB');
</script>