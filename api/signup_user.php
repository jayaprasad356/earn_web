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
$name = $db->escapeString($_POST['name']);
$mobile = $db->escapeString($_POST['mobile']);
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
    $sql = "INSERT INTO users(`name`,`mobile`,`referral`,`my_refer_code`)VALUES('$name','$mobile','$referral','$myrefercode')";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Successfully Registered";
    $response['data'] = $res;
    print_r(json_encode($response));

}




?>