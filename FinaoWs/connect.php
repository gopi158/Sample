<?php
error_reporting(1);
$soap_url='http://finaonation.com/shop/api/soap/?wsdl';
$soapusername='apiintegrator';
$soappassword='ap11ntegrator';

$link = mysql_connect('localhost', 'root', '');
if (!$link){
	die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db('finaonationqa', $link);
if (!$db_selected) 
{
	die ('ERROR::'.mysql_error());
}
?>