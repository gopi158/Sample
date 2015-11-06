<?php
$requestBody = file_get_contents('php://input');
$requestBody = json_decode($requestBody);
print_r($requestBody);
?>