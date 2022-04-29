<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
include_once('includes/crud.php');
include_once('includes/variables.php');
$db = new Database();
$db->connect();
// session_start();
$withdrawals_id = $_GET['id'];
$sql = "SELECT * FROM withdrawals,users WHERE withdrawals.user_id = users.id AND withdrawals.id = '$withdrawals_id'";
$db->sql($sql);
$res = $db->getResult();
if($res[0]['status'] == '0'){
    $status = 'Pending';
}
else if($res[0]['status'] == '1'){
    $status = 'Completed';
}
?>
<section class="content-header">
    <h1>View Order</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
<div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px">ID</th>
                                <td><?php echo $res[0]['id'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">User Name</th>
                                <td><?php echo $res[0]['name'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">User Mobile</th>
                                <td><?php echo $res[0]['mobile'] ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Amount</th>
                                <td><?php echo $res[0]['amount']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Status</th>
                                <td><?php echo $status; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 200px">Date</th>
                                <td><?php echo $res[0]['date_created']; ?></td>
                            </tr>

                        </table>
                    </div><!-- /.box-body -->
                    <?php
                    if($res[0]['status'] != '1'){?>
                        <div class="box-footer clearfix">
                        <a href=""><button class="btn btn-primary">Pay Now</button></a>
                    
                    </div>
                    <?php

                    }
                     ?>

                </div><!-- /.box -->
            </div>
        </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_offer_form').validate({
        rules: {
            budget_id: "required",
            

        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
    
</script>

<script>
    $('#add_offer_form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        if ($("#add_offer_form").validate().form()) {
            if(document.getElementById("wastage").value != '' || document.getElementById("pricegram").value != ''){
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    beforeSend: function() {
                        $('#submit_btn').html('Please wait..');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        $('#result').html(result);
                        $('#result').show().delay(6000).fadeOut();
                        $('#submit_btn').html('Add');
                    
                        $('#add_offer_form')[0].reset();
                        
                    }
                });

            }else{
                alert("Enter Atleast Wastage or Discount Per gram")
            }
        

            
            

        }
    
    });
</script>
<script>
    document.getElementById('valid').valueAsDate = new Date();

</script>
