<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/crud.php');
$db = new Database();
$db->connect();

if (empty($_POST['name'])) {
    $response['success'] = false;
    $response['message'] = "Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['mobile'])) {
    $response['success'] = false;
    $response['message'] = "Mobilenumber is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['upi'])) {
    $response['success'] = false;
    $response['message'] = "Upi is Empty";
    print_r(json_encode($response));
    return false;
}
$name = $db->escapeString($_POST['name']);
$mobile = $db->escapeString($_POST['mobile']);
$upi = $db->escapeString($_POST['upi']);
$referral = (isset($_POST['referral']) && $_POST['referral'] != "") ? $db->escapeString($_POST['referral']) : "";
$sql = "SELECT * FROM users WHERE mobile ='$mobile'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 1){
    $response['success'] = false;
    $response['message'] = "Mobile Number Already Registered";
    print_r(json_encode($response));
}
else{
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $myrefercode  = "";
    for ($i = 0; $i < 10; $i++) {
        $myrefercode .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    //$referral = (isset($res[0]['referral']) && $res[0]['referral'] != "") ? $db->escapeString($res[0]['referral']) : "";
    $level1_referral_id = "0";
    $level2_referral_id = "0";
    $level3_referral_id = "0";
    if($referral != ''){
        $sql = "SELECT * FROM `users` WHERE my_refer_code='$referral'";
        $db->sql($sql);
        $res = $db->getResult();
        $level1_referral_id = (isset($res[0]['id']) && $res[0]['id'] != "") ? $db->escapeString($res[0]['id']) : "0";
        $referral2 = (isset($res[0]['referral']) && $res[0]['referral'] != "") ? $db->escapeString($res[0]['referral']) : "";

    }
    if($level1_referral_id != '0'){
        $sql = "SELECT * FROM `users` WHERE my_refer_code='$referral2'";
        $db->sql($sql);
        $res = $db->getResult();
        $level2_referral_id = (isset($res[0]['id']) && $res[0]['id'] != "") ? $db->escapeString($res[0]['id']) : "0";
        $referral3 = (isset($res[0]['referral']) && $res[0]['referral'] != "") ? $db->escapeString($res[0]['referral']) : "";

    }
    if($level2_referral_id != '0'){
        $sql = "SELECT * FROM `users` WHERE my_refer_code='$referral3'";
        $db->sql($sql);
        $res = $db->getResult();
        $level3_referral_id = (isset($res[0]['id']) && $res[0]['id'] != "") ? $db->escapeString($res[0]['id']) : "0";

    }



    $sql = "INSERT INTO users(`name`,`mobile`,`upi`,`referral`,`my_refer_code`,`level1_referral_id`,`level2_referral_id`,`level3_referral_id`)VALUES('$name','$mobile','$upi','$referral','$myrefercode',$level1_referral_id,$level2_referral_id,$level3_referral_id)";
    $db->sql($sql);
    $res = $db->getResult();
    $sql = "SELECT * FROM users WHERE mobile ='$mobile'";
    $db->sql($sql);
    $res = $db->getResult();

    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['name'] = $row['name'];
        $temp['mobile'] = $row['mobile'];
        $temp['referral'] = $row['referral'];
        $temp['upi'] = $row['upi'];
        $temp['my_refer_code'] = $row['my_refer_code'];
        $balance = $row['balance'];
        if($balance == NULL){
            $balance = 0;

        }
        $temp['balance'] = $balance;

        $earn = $row['earn'];
        if($earn == NULL){
            $earn = 0;

        }
        $temp['earn'] = $earn;
        $temp['level1_referral_id'] = $row['level1_referral_id'];
        $temp['level2_referral_id'] = $row['level2_referral_id'];
        $temp['level3_referral_id'] = $row['level3_referral_id'];
        $rows[] = $temp;
    }
    $response['success'] = true;
    $response['message'] = "Successfully Registered";
    $response['data'] = $rows;
    print_r(json_encode($response));

}




?>