<?php
# include 'dbconnection.php';
include 'config.php';

		
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		
//header("Content-Type: application/json");
$stkCallbackResponse = file_get_contents('php://input');


#$logFile = "Mpesastkresponse.json";
#$log = fopen($logFile, "a");
#fwrite($log, $stkCallbackResponse);
#fclose($log);

$data = json_decode($stkCallbackResponse);

$MerchantRequestID = $data->Body->stkCallback->MerchantRequestID;
$CheckoutRequestID = $data->Body->stkCallback->CheckoutRequestID;
$ResultCode = $data->Body->stkCallback->ResultCode;
$ResultDesc = $data->Body->stkCallback->ResultDesc;
$Amount = $data->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$TransactionId = $data->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$UserPhoneNumber = $data->Body->stkCallback->CallbackMetadata->Item[4]->Value;
$accountRef = $data->Body->stkCallback->CallbackMetadata->Item[5]->Value;
$Transactiondate = $data->Body->stkCallback->CallbackMetadata->Item[3]->Value;





if ($ResultCode == 0) {
	$stmts = $conn->prepare("INSERT INTO mpesa_trnsactions(MerchantRequestID,transaction_date,CheckoutRequestID,ResultCode,Amount,MpesaReceiptNumber,PhoneNumber,account_number) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	$stmts->bind_param("ssssssss", $MerchantRequestID, $Transactiondate, $CheckoutRequestID, $ResultCode, $Amount, $TransactionId, $UserPhoneNumber, $accountRef);
	$res = $stmts->execute();//get result
	$stmts->close();
	echo "Successfully Saved Something good happened" ; 

		
			
			
		}




 /* 
$MerchantRequestID = '$data->Body->stkCallback->MerchantRequestID';
$CheckoutRequestID = '$data->Body->stkCallback->CheckoutRequestID';
$ResultCode = '$data->Body->stkCallback->ResultCode';
$ResultDesc = '$data->Body->stkCallback->ResultDesc';
$Amount = '$data->Body->stkCallback->CallbackMetadata->Item[0]->Value';
$TransactionId = '$data->Body->stkCallback->CallbackMetadata->Item[1]->Value';
$UserPhoneNumber = '$data->Body->stkCallback->CallbackMetadata->Item[4]->Value';

if (isset($data['Body']['stkCallback']['CallbackMetadata']['Item'])) {} else {
    echo "No valid callback data found.";
}




$accountReference = 'Bado pata';

    $callbackMetadata = $data['Body']['stkCallback']['CallbackMetadata']['Item'];

    // Extract the AccountReference
    $accountReference = null;
    foreach ($callbackMetadata as $item) {
        if ($item['Name'] == 'AccountReference') {
            $accountReference = $item['Value'];
            break;
        }
    }
*/
    // Now you can use $accountReference
   // echo "Account Reference: " . $accountReference;




/**/