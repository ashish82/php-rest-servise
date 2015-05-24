<?php
$host="http://localhost/rest-servises/api/api.php?rquest=insertBooks";
$headers = array(
		'Content-Type:application/json',
		'Authorization: Basic '. base64_encode("ashish:ashish") // <---
);
 $payloadName="{\"title\": \"Three Musketeers\",\"author\": \"Alexander Dumas\",\"summary\": \"Three Musketeers\"}";
$process = curl_init($host);
curl_setopt($process, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($process, CURLOPT_POSTFIELDS, $payloadName);
curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
curl_setopt($process, CURLOPT_HTTPHEADER,$headers);
curl_setopt($process, CURLOPT_TIMEOUT, 30);
$response=curl_exec($process);
if(!$response){
	die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
}else{
	echo $response;
}
curl_close($process);



?>