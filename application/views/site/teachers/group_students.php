<h1 class="gridHeader_grey">Arrange Students into Class Groups</h1>

<div class="gridPadding textPadding">

<h3 class="bold">Renaming a Class:</h3>
<p class="bold">SELECT THE CLASS YOU WISH TO RENAME (FROM DROP DOWN MENU) AND ENTER THE NEW NAME IN THE BOX.</p>

<?php echo form_open('teachers/rename_class'); ?>

	<fieldset>
	<legend class="grey">EDIT CLASS NAME(S)</legend>

	<div style="width:50%; float:left;">
		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

		<label>Select your Class</label>
		<?php echo classDropdown('', '', 'Classes for '. $this->session->userdata('school') .''); ?>
	</div>

	<div style="width:50%; float:left;">
		<label>Rename Class to:</label>
		<input type="text" name="newclass_name" id="newclass_name" size="35" value="<?php echo set_value('newclass_name'); ?>"><br />

		<input type="submit" name="submit" id="submit" value="Update" class="butSmall" />
	</div>

	</fieldset>

<?php 
if( isset( $message ))
{
	echo $message;
}

echo form_close(); 

?>



<h3 class="bold">Grouping Students into Classes:</h3>
<p class="bold">THIS TASK ONLY NEEDS TO BE PERFORMED ONCE TO ARRANGE STUDENTS INTO YOUR CLASS GROUP.</p>
<ul>
	<li>1. Tick the box next to each of YOUR students</li>
	<li>2. Click <span class="bold">'Move Students'</span> button at the bottom of the page.</li>
</ul>
<p><span class="textOrange bold">NOTE:</span> Students 'greyed out' have already been allocated into a class group.<br /> However, if a student has been allocated by mistake, you can still tick/select that student for your class.</p>


<?php echo form_open('teachers/group_students'); ?>

<?php
	$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$letters = str_split($alphabet);
	$set_letter = FALSE;
	
	// Display full list of topics in alphabetical order with letter (A, B, C) as heading
	if( isset($students) )
	{
		$results = count($students);
		$per_column = ceil($results/3);
		
		$i = 0;
		echo '<table cellspacing="0" cellpadding="0" border="0" width="100%" >';
		echo '<tr valign="top">';
		echo '<td width=33%>';
		
		/*************************************************************************/
		// Loop through each topic alphbetically
		/*************************************************************************/
		foreach($students as $row) {
		
		
			if($i == $per_column)
			{
				echo '</td><td width=33%>';
				$i = 0;
			}
			 
				/*************************************************************************/
				// Break students up by each letter of alphabet - Use letter (A, B, C ..) as label
				/*************************************************************************/
				foreach($letters as $letter):
				
					// Convert last name to uppercase (otherwise the $alphabet array() being uppercase will miss the lowercase names)
					$name = strtoupper($row->last_name);
	
					if( substr($name, 0, 1) == $letter )
					{
						// Only show new alpha letter at the start of each alpha category
						$alpha_header = ( $set_letter != $letter ) ? $letter : ''; 

						$class = ($row->classID == 0) ? 'bold' : 'textLightGrey bold';

						// Display alpha letter (i.e., A, B, C ...)
						echo '<h4 class="textOrange bold" style="margin:0;">' . $alpha_header . '</h4>';
						// Display Student Name
						echo '<h5><input type="checkbox" name="studentID[]" id="studentID[]"  value=" ' . $row->studentID . ' " /><span class="'.$class.'">' . strtoupper($row->last_name) . ', ' . ucwords($row->first_name).'</span></h5>';
						echo '<div class="underLine"></div>';

						// Save alpha letter as var to test against looped through version above
						$set_letter = $letter; 
					}
					
				endforeach;
				
				/*************************************************************************/
			 
			 $i++;
			 
		}
		
		echo '</td>';
		echo '</tr>';
		echo '</table>';
	
	}
	
?>

<div align="center">

	<input type="submit" name="submit" id="submit" value="Move Students" class="butSmall" />
	
</div>

<?php echo form_close(); ?>

</div>