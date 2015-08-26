<h1 class="gridHeader strong">Subscribers</h1>

<div class="gridPadding textPadLeft">

    <?php 
        echo anchor('subscribers_con/select_access_codes', 'Review Codes', array('class' => 'butSmall butRight'));
        echo anchor('subscribers_con/school_admin_form', 'School Admin', array('class' => 'butSmall butBack'));
        echo anchor('subscribers_con/school_form', 'Edit School List', array('class' => 'butSmall butBack'));
        echo anchor('subscribers_con/get_school_details', 'Search Schools', array('class' => 'butSmall butBack'));
        echo anchor('subscribers_con/get_student_details', 'Search Students', array('class' => 'butSmall butBack'));
    ?>
    
    <h1 class="greyArrow textOrange"><strong>Create Codes</strong></h1>
    <p>Complete the fields to create access codes</p>
  
    <?php echo form_open('subscribers_con/'); ?>

        <div id="container">
        
        <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
        
        <fieldset>
        <legend>CREATE ACCESS CODES</legend>
        
            <?php echo mem_schools_dropdown('', '', 'Select School'); ?>

            <label for"batch"><strong>Batch (Teacher/Class) Name:</strong></label>
            <input type="text" name="batch" id="batch" style="width:40%;" value="<?php echo set_value('batch'); ?>" />

            <label for"quantity"><strong>Number of Codes:</strong></label>
            <input type="text" name="quantity" id="quantity" style="width:10%;" value="<?php echo set_value('quantity'); ?>" />
          
        </fieldset>
        
        <fieldset>
        <legend>EMAIL CODES TO:</legend>

            <input type="text" name="email" id="email" style="width:50%;" value="<?php echo set_value('email'); ?>" />

        </fieldset>
        
        <div class="containerArea">
            <input type="submit" id="submit" value="Create Codes" class="butSmall" />
        </div>
        
        </div>
    
    <?php echo form_close(); ?>
  
  
</div>



<!--JQUERY AJAX UPDATE SCRIPT-->
<script type="text/javascript">

$(function() {

$('#submit').click(function() {
$('#container').append('<img src="<?php echo base_url() . '/images/loading.gif' ?>" alt="Currently Loading" id="loading" />');

    var token = $('#token').val();
    var schoolID = $('#schoolID').val();
    var batch = $('#batch').val();
    var quantity = $('#quantity').val();
    var email = $('#email').val();
    
    
    $.ajax({
        url: '<?php echo base_url() . 'subscribers_con/add_access_codes'; ?>',
        type: 'POST',
        data: 'token=' + token
        + '&schoolID=' + schoolID
        + '&batch=' + batch
        + '&quantity=' + quantity
        + '&email=' + email,
        
        success:    function(result) {
                
                                $('#response').remove();
                                $('.containerArea').append('<span id="response">' + result + '</span>');
                                $('#loading').fadeOut(500, function() {
                                    $(this).remove();
                                });
                                
                        }
                });
        
        return false;
        
    });
    
    });
</script>