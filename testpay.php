<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<script>
    $.ajax({
        url: 'https://payout-api.cashfree.com/payout/v1/directTransfer',
        type: 'post',
        data: {
            amt: '50',
        }, 
        success: function (data) {
            var data = JSON.parse(data);
            alert("Amount Paid Successfully");
            if(data.status == 'success'){
                alert("Amount Paid Successfully");
                location.reload(true);

            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alert("Failed ");
        }
    });
</script>