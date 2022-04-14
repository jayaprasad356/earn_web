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
if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "user_id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['amount'])) {
    $response['success'] = false;
    $response['message'] = "Amount is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['type'])) {
    $response['success'] = false;
    $response['message'] = "Type is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$amount = $db->escapeString($_POST['amount']);
$type = $db->escapeString($_POST['type']);

$sql = "SELECT * FROM users WHERE id = '" . $user_id . "'";
$db->sql($sql);
$res = $db->getResult();
$recharge = $res[0]['balance'];
$recharge = $recharge + $amount;
$num = $db->numRows($res);
if ($num == 1) {
    $sql = "INSERT INTO recharges (`user_id`,`amount`,`payment_type`,`status`) VALUES ('$user_id','$amount','$type','1')";
    $db->sql($sql);
    $res = $db->getResult();
    
    $sql = "UPDATE users SET `balance`= $recharge WHERE `id`=" . $user_id;
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Amount Recharged Successfully";


}
else{
    $response['success'] = false;
    $response['message'] = "User Not Found";

}

print_r(json_encode($response));
   
    
   


?>
