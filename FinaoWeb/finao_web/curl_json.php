<?php

$data = array(
  "senderEmail" => "kunal.gala@battatech.com",
  "comment" => "Test",
);

$url_send ="http://localhost/finao_web/json_api.php";
$str_data = json_encode($data);

$ch = curl_init($url_send);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
$result = curl_exec($ch);
curl_close($ch);

echo " " . $result;
?>