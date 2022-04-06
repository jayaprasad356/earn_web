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

if (isset($_POST['level']) && $_POST['level'] == '1'){
    if (empty($_POST['referral'])) {
        $response['success'] = false;
        $response['message'] = "Referral Code is Empty";
        print_r(json_encode($response));
        return false;
    }
    
    $referral = $db->escapeString($_POST['referral']);
    $sql = "SELECT * FROM `users` WHERE referral='$referral'";
    $db->sql($sql);
    $res = $db->getResult();
    
    $response['success'] = true;
    $response['message'] = "Level 1 User Details Retrived Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));

}
if (isset($_POST['level']) && $_POST['level'] == '2'){
    if (empty($_POST['referral'])) {
        $response['success'] = false;
        $response['message'] = "Referral Code is Empty";
        print_r(json_encode($response));
        return false;
    }
    
    $referral = $db->escapeString($_POST['referral']);
    $sql = "SELECT * FROM `users` WHERE referral=$referral";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row) {

        $referral2 =  $row['my_refer_code'];
        $sql = "SELECT * FROM `users` WHERE referral=$referral2";
        $db->sql($sql);
        $res2 = $db->getResult();
        //$rows[] = $tempRow;

    }
    
    $response['success'] = true;
    $response['message'] = "Level 2 User Details Retrived Successfully";
    $response['data'] = $res2;
    print_r(json_encode($response));



}
if (isset($_POST['level']) && $_POST['level'] == '3'){
    if (empty($_POST['referral'])) {
        $response['success'] = false;
        $response['message'] = "Referral Code is Empty";
        print_r(json_encode($response));
        return false;
    }
    
    $referral = $db->escapeString($_POST['referral']);
    $sql = "SELECT * FROM `users` WHERE referral=$referral";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row) {

        $referral2 =  $row['my_refer_code'];
        $sql = "SELECT * FROM `users` WHERE referral=$referral2";
        $db->sql($sql);
        $res2 = $db->getResult();
        foreach ($res2 as $row) {

            $referral3 =  $row['my_refer_code'];
            $sql = "SELECT * FROM `users` WHERE referral=$referral3";
            $db->sql($sql);
            $res3 = $db->getResult();
            //$rows[] = $tempRow;
    
        }
        

    }
    
    $response['success'] = true;
    $response['message'] = "Level 3 User Details Retrived Successfully";
    $response['data'] = $res3;
    print_r(json_encode($response));

}


?>