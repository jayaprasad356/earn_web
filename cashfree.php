<?php
/*
Below is an integration flow on how to use Cashfree's payouts.
Please go through the payout docs here: https://dev.cashfree.com/payouts

The following script contains the following functionalities :
    1.getToken() -> to get auth token to be used in all following calls.
    2.getBeneficiary() -> to get beneficiary details/check if a beneficiary exists
    3.createBeneficiaryEntity() -> to create beneficiaries
    4.requestTransfer() -> to create a payout transfer
    5.getTransferStatus() -> to get payout transfer status.


All the data used by the script can be found in the below assosciative arrays. This includes the clientId, clientSecret, Beneficiary object, Transaction Object.
You can change keep changing the values in the config file and running the script.
Please enter your clientId and clientSecret, along with the appropriate enviornment, beneficiary details and request details
*/

#default parameters
$clientId = 'CF217067CAAUJMQF3KT4N5J3K7QG';
$clientSecret = 'b4045cac1efcb090a39c093cd4ddb6639206e458';
$env = 'prod';

#config objs
$baseUrls = array(
    'prod' => 'https://payout-api.cashfree.com',
    'test' => 'https://payout-gamma.cashfree.com',
);
$urls = array(
    'auth' => '/payout/v1/authorize',
    'getBene' => '/payout/v1/getBeneficiary/',
    'addBene' => '/payout/v1/addBeneficiary',
    'requestTransfer' => '/payout/v1/requestTransfer',
    'getTransferStatus' => '/payout/v1/getTransferStatus?transferId=',
    'directTransfer' => '/payout/v1/directTransfer'
);
$beneficiary = array(
    'beneId' => 'Prasad123',
    'name' => 'jhon doe',
    'email' => 'johndoe@cashfree.com',
    'phone' => '+919876543210',
    'vpa' => '9442071531@ybl',
    'address1' => '23,east street',
);
$transfer = array(
    'beneId' => 'Prasad123',
    'amount' => '1.00',
    'transferId' => 'D2039',
);
$dtransfer = array (
    'amount' => '3.00',
    'transferId' => 'JUNOB2018142',
    'transferMode' => 'upi',
    'remarks' => 'test',
    'beneDetails' => 
    array (
      'vpa' => '9442071531@ybl',
      'name' => 'Ranjiths',
      'email' => 'ranjiths@cashfree.com',
      'phone' => '9999999999',
      'address1' => 'any_dummy_value',
    ),
);

$header = array(
    'X-Client-Id: '.$clientId,
    'X-Client-Secret: '.$clientSecret, 
    'Content-Type: application/json',
);

$baseurl = $baseUrls[$env];


function create_header($token){
    global $header;
    $headers = $header;
    if(!is_null($token)){
        array_push($headers, 'Authorization: Bearer '.$token);
    }
    return $headers;
}

function post_helper($action, $data, $token){
    global $baseurl, $urls;
    $finalUrl = $baseurl.$urls[$action];
    $headers = create_header($token);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $finalUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
    if(!is_null($data)) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
    
    $r = curl_exec($ch);
    
    if(curl_errno($ch)){
        print('error in posting');
        print(curl_error($ch));
        die();
    }
    curl_close($ch);
    $rObj = json_decode($r, true);    
    // if($rObj['status'] != 'SUCCESS' || $rObj['subCode'] != '200') throw new Exception('incorrect response: '. $rObj['subCode']);
    return $rObj;
}

function get_helper($finalUrl, $token){
    $headers = create_header($token);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $finalUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
    
    $r = curl_exec($ch);
    
    if(curl_errno($ch)){
        print('error in posting');
        print(curl_error($ch));
        die();
    }
    curl_close($ch);

    $rObj = json_decode($r, true);    
    if($rObj['status'] != 'SUCCESS' || $rObj['subCode'] != '200') throw new Exception('incorrect response: '.$rObj['message']);
    return $rObj;
}

#get auth token
function getToken(){
    try{
       $response = post_helper('auth', null, null);
       return $response['data']['token'];
    }
    catch(Exception $ex){
        error_log('error in getting token');
        error_log($ex->getMessage());
        die();
    }

}

#get beneficiary details
function getBeneficiary($token){
    try{
        global $baseurl, $urls, $beneficiary;
        $beneId = $beneficiary['beneId'];
        $finalUrl = $baseurl.$urls['getBene'].$beneId;
        $response = get_helper($finalUrl, $token);
    
        return true;
    }
    catch(Exception $ex){
        $msg = $ex->getMessage();
        if(strstr($msg, 'Beneficiary does not exist')) return false;
        error_log('error in getting beneficiary details');
        error_log($msg);
        die();
    }    
}

#add beneficiary
function addBeneficiary($token){
    try{
        global $beneficiary;
        $response = post_helper('addBene', $beneficiary, $token);
        error_log('beneficiary created');
    }
    catch(Exception $ex){
        $msg = $ex->getMessage();
        error_log('error in creating beneficiary');
        error_log($msg);
        die();
    }    
}

#request transfer
function directTransfer($token){
    try{
        global $dtransfer;
        $response = post_helper('directTransfer', $dtransfer, $token);
        echo json_encode($response);
        // print_r($response);
        
        error_log('transfer requested successfully');
    }
    catch(Exception $ex){
        $msg = $ex->getMessage();
        echo $msg;
        error_log('error in requesting transfer');
        error_log($msg);
        die();
    }
}
function requestTransfer($token){
    try{
        global $transfer;
        $response = post_helper('requestTransfer', $transfer, $token);
        
        error_log('transfer requested successfully');
    }
    catch(Exception $ex){
        $msg = $ex->getMessage();
        echo $msg;
        error_log('error in requesting transfer');
        error_log($msg);
        die();
    }
}

#get transfer status
function getTransferStatus($token){
    try{
        global $baseurl, $urls, $transfer;
        $transferId = $transfer['transferId'];
        $finalUrl = $baseurl.$urls['getTransferStatus'].$transferId;
        $response = get_helper($finalUrl, $token);
        print_r ($response);
        error_log(json_encode($response));
    }
    catch(Exception $ex){
        $msg = $ex->getMessage();
        echo $msg;
        error_log('error in getting transfer status');
        error_log($msg);
        die();
    }
}
$token = getToken();
directTransfer($token);
#main execution
// if(!getBeneficiary($token)) addBeneficiary($token);
// requestTransfer($token);
// getTransferStatus($token);
?> 