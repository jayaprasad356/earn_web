<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earn App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<?php
include_once('./includes/crud.php');
$db = new Database;
$db->connect();

if (isset($_POST['btnSubmit'])) {
    $name = $db->escapeString($_POST['name']);
    $mobile = $db->escapeString($_POST['mobile']);
    $referral = $db->escapeString($_POST['referral']);
    $error = array();
    if (empty($name)) {
        $error['failed'] = "<span class='btn btn-danger'>Please Enter Name</span>";

    }
    if (!empty($name)) {
        $sql = "INSERT INTO users(`name`,`mobile`,`referral`)VALUES('$name','$mobile','$referral')";
        $db->sql($sql);
        
    }
    if (empty($mobile)) {
        $error['failed'] = "<span class='btn btn-danger'>Please Enter Mobilenumber</span>";

    }
    if (!empty($mobile)) {
        $sql = "INSERT INTO users (`name`,`mobilenumber`,`referral`)VALUES('$name','$mobile','$referral')";
        $db->sql($sql);
        
    }
    if (empty($referral)) {
        $error['failed'] = "<span class='btn btn-danger'>Please Enter your referral</span>";

    }
    if (!empty($referral)) {
        $sql = "INSERT INTO users(`name`,`mobilenumber`,`referral`)VALUES('$name','$mobile','$referral')";
        $db->sql($sql);
    }
    $error['failed'] = "<span class='btn btn-success'>Registered Successfully</span>";
   
    

}
?>
<body>
<form method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="name">Name</label>
    <input  name="name" type="text" class="form-control" id=""  placeholder="name">
    
  </div>
  <div class="form-group">
        <label for="mobile">Mobile Number</label>
            <input name="mobile" type="text" class="form-control" id=""  placeholder="Mobile Number">
  </div>
  <div class="form-group ">
        <label for="referral">Referral Code</label>
            <input name="referral" type="text" class="form-control" id=""  placeholder="Code">
  </div>
  <button type="submit" name="btnSubmit" class="btn btn-primary">Sign Up</button>

  <p class="text-danger"><?php echo isset($error['failed']) ? $error['failed'] : ''; ?></p>
</form>
    
    
</body>
</html>