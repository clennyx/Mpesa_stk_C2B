<?php
//$accessToken = 'AccessToken'; // Use the access token generated above
include 'accessToken.php';
$shortcode = '174379'; // Your M-Pesa short code
$passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'; // Your M-Pesa passkey
$timestamp = date('YmdHis');
$password = base64_encode($shortcode . $passkey . $timestamp);

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $access_token
));

$curl_post_data = array(
    'BusinessShortCode' => $shortcode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => '1',
    'PartyA' => '254724412549', // The phone number sending the money
    'PartyB' => $shortcode,
    'PhoneNumber' => '254724412549', // The phone number sending the money
    'CallBackURL' => 'https://iestepas.com/callback',
    'AccountReference' => 'LiveTest123',
    'TransactionDesc' => 'Payment for testing'
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$response = curl_exec($curl);
echo $response;

curl_close($curl);
?>
