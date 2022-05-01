<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql_query = "SELECT id, name FROM category ORDER BY id ASC";
$db->sql($sql_query);

$res = $db->getResult();
$sql_query = "SELECT value FROM settings WHERE variable = 'Currency'";
$pincode_ids_exc = "";
$db->sql($sql_query);

$res_cur = $db->getResult();
if (isset($_POST['btnUpdate'])) {
        $error = array();
        $account_number = (isset($_POST['account_number'])) ? $db->escapeString($fn->xss_clean($_POST['account_number'])) : "";
        $ifsc_code = (isset($_POST['ifsc_code'])) ? $db->escapeString($fn->xss_clean($_POST['ifsc_code'])) : "";
        $bank_name = (isset($_POST['bank_name'])) ? $db->escapeString($fn->xss_clean($_POST['bank_name'])) : "";
        $name = (isset($_POST['name'])) ? $db->escapeString($fn->xss_clean($_POST['name'])) : "";
        $upi_id = (isset($_POST['upi_id'])) ? $db->escapeString($fn->xss_clean($_POST['upi_id'])) : "";
        $minimum_setting = (isset($_POST['minimum_setting'])) ? $db->escapeString($fn->xss_clean($_POST['minimum_setting'])) : "";
        $recharge_setting = (isset($_POST['recharge_setting'])) ? $db->escapeString($fn->xss_clean($_POST['recharge_setting'])) : "";
        $service_link = (isset($_POST['service_link'])) ? $db->escapeString($fn->xss_clean($_POST['service_link'])) : "";
        
    
       
        
      
            $sql = "UPDATE earn_settings SET account_number='$account_number',ifsc_code='$ifsc_code',bank_name='$bank_name',name='$name',upi_id='$upi_id',minimum_setting='$minimum_setting',recharge_setting='$recharge_setting',service_link='$service_link' WHERE title='earn_settings'";
            $db->sql($sql);
            $earnsettings_result = $db->getResult();
            if (!empty($earnsettings_result)) {
                $earnsettings_result = 0;
            } else {
                $earnsettings_result = 1;
            }
            if ($earnsettings_result == 1) {
                $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Earn Details Updated Successfully</span>
                                                
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }

}

$sql = "SELECT * FROM earn_settings WHERE title= 'earn_settings'";
$db->sql($sql);
$res = $db->getResult();
foreach ($res as $row)
    $data = $row;
?>
<section class="content-header">
    <h1>Update Details</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Update Details</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='updatedetails_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Account Number</label> <?php echo isset($error['account_number']) ? $error['account_number'] : ''; ?>
                                    <input type="text" class="form-control" name="account_number" value="<?php echo $data['account_number']?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">IFSC Code</label> <?php echo isset($error['ifsc_code']) ? $error['ifsc_code'] : ''; ?>
                                    <input type="text" class="form-control" name="ifsc_code" value="<?php echo $data['ifsc_code']?>" >
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Account Holder Name</label> <?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" value="<?php echo $data['name']?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Bank Name</label> <?php echo isset($error['bank_name']) ? $error['bank_name'] : ''; ?>
                                    <input type="text" class="form-control" name="bank_name" value="<?php echo $data['bank_name']?>">
                                </div>
                            </div>

                        </div>


                        <hr>
                        
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">UPI id</label> <?php echo isset($error['upi_id']) ? $error['upi_id'] : ''; ?>
                                    <input type="text" class="form-control" name="upi_id" value="<?php echo $data['upi_id']?>">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Withdraw minimum setting</label> <?php echo isset($error['minimum_setting']) ? $error['minimum_setting'] : ''; ?>
                                    <input type="text" class="form-control" name="minimum_setting" value="<?php echo $data['minimum_setting']?>">
                                </div>
                               

                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group">
                               <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Minimum Recharge Setting</label> <?php echo isset($error['recharge_setting']) ? $error['recharge_setting'] : ''; ?>
                                    <input type="text" class="form-control" name="recharge_setting">
                                </div>
                                <div class='col-md-4'>
                                    <label for="exampleInputEmail1">Customer Service Link</label> <?php echo isset($error['service_link']) ? $error['service_link'] : ''; ?>
                                    <input type="text" class="form-control" name="service_link" >
                                </div>

                            </div>
                        </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Update" name="btnUpdate" />&nbsp;
                        <!--<div  id="res"></div>-->
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>