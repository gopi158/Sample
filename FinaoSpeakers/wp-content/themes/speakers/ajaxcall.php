<?php
//echo $_POST['encrypted'];die();


$link = mysql_connect('localhost', 'fnspeak_wpdb', 'glQJQAkGvUox');



if (!$link) {



    die('Could not connect: ' . mysql_error());



}



mysql_select_db('fnspeak_wpdb',$link); 



?>







<?php 



/*$str = "SELECT * FROM `fs_booking` WHERE `email` = '".$_POST['email']."' AND `event_date` = '".$_POST['Date']."'";



$res = mysql_query($str);



$count =  mysql_num_rows($res);



//echo $count;



if($count > 0 )



{*/?>



<?php //echo '<p style="color:red;">Event Booked ...Please select some other date</p>'; ?>



<?php //}else{ ?>



<?php
if($_POST['encrypted']=="123")
{
//echo "hi";die();
$query = "INSERT INTO `fs_booking`( `email`, `name`, `phone`, `event`, `event_date`, `school`, `attendance`, `additional`) VALUES ( '".$_POST['email']."','".$_POST['name']."','".$_POST['phone']."','".$_POST['event']."','".$_POST['Date']."','".$_POST['school']."','".$_POST['attendance']."','".$_POST['additional']."')";



$insert = mysql_query($query);



if($insert)



{



	// multiple recipients



$to  = 'info@finaospeakers.com'; 



$subject = 'Booking Enquiry for '.$_POST['speaker'].'';







// message



$message = '



<html>



<head>



  <title>Booking Form</title>



  <style>



   p {font-size: 1em !important;font-family: Arial !important;}



    </style>



</head>



<body>



    



	<div width="570px">



	<p>Dear Admin,</p>



   <p>	The User '.$_POST['name'].' wants to enquire about '.$_POST['speaker'].' as a speaker.</p>



   <p>The details submitted by the user are as below :</p>



  <table width="550" border="0" cellpadding="5" cellspacing="1" bgcolor="#6e6e6e">



	



  <tr>



    <td bgcolor="#FFFFFF">Email</td>



    <td bgcolor="#FFFFFF">'.$_POST['email'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Name</td>



    <td bgcolor="#FFFFFF">'.$_POST['name'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Phone</td>



    <td bgcolor="#FFFFFF">'.$_POST['phone'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Event Name</td>



    <td bgcolor="#FFFFFF">'.$_POST['event'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Event Date</td>



    <td bgcolor="#FFFFFF">'.$_POST['Date'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Location</td>



    <td bgcolor="#FFFFFF">'.$_POST['location'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">School/College/University</td>



    <td bgcolor="#FFFFFF">'.$_POST['school'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Estimated Attendance</td>



    <td bgcolor="#FFFFFF">'.$_POST['attendance'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Additional Notes</td>



    <td bgcolor="#FFFFFF">'.$_POST['additional'].'</td>



  </tr>



  </table>



  



    



  <p>Thanks,</br>



    Finao Speakers Team.



  </p>



 



  











</div>



</body>



</html>



';







// To send HTML mail, the Content-type header must be set



$headers  = 'MIME-Version: 1.0' . "\r\n";



$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";







// Additional headers



/*$headers .= 'To: Admin<nagesh@wincito.com>' . "\r\n";*/



$headers .= 'From: info@finaospeakers.com' . "\r\n";







$headers .= 'Bcc:dev@wincito.com, nagesh@wincito.com, chris@finaospeakers.com' . "\r\n";





$mail = mail($to, $subject, $message, $headers);







if($mail)



{



	$subject = 'Booking Enquiry for '.$_POST['speaker'].'';



	// To send HTML mail, the Content-type header must be set



$headers1  = 'MIME-Version: 1.0' . "\r\n";



$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";





$headers1 .= 'From: Finao Speakers <info@finaospeakers.com>' . "\r\n";



$headers1 .= 'Bcc: dev@wincito.com' . "\r\n";

//$headers1 .= 'Bcc: siri502.alla@gmail.com' . "\r\n";



	echo '<span style="color:green;">"Thanks for your enquiry. We will have someone reach out to you shortly."</span>';



	$message1 = '



<html>



<head>



  <title>Booking Form</title>



  <style>



   p {font-size: 1em !important;font-family: Arial !important;}



    </style>



</head>



<body>



    



	<div width="570px">



	<p>Dear '.$_POST['name'].',</p>



   <p>	Thanks for your enquiry about '.$_POST['speaker'].' .We will get back to you Shortly.</p>



    <p>The details submitted by you are as below :</p>



  <table width="550" border="0" cellpadding="5" cellspacing="1" bgcolor="#6e6e6e">



	



  <tr>



    <td bgcolor="#FFFFFF">Email</td>



    <td bgcolor="#FFFFFF">'.$_POST['email'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Name</td>



    <td bgcolor="#FFFFFF">'.$_POST['name'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Phone</td>



    <td bgcolor="#FFFFFF">'.$_POST['phone'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Event Name</td>



    <td bgcolor="#FFFFFF">'.$_POST['event'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Event Date</td>



    <td bgcolor="#FFFFFF">'.$_POST['Date'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Location</td>



    <td bgcolor="#FFFFFF">'.$_POST['location'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">School/College/University</td>



    <td bgcolor="#FFFFFF">'.$_POST['school'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Estimated Attendance</td>



    <td bgcolor="#FFFFFF">'.$_POST['attendance'].'</td>



  </tr>



  <tr>



    <td bgcolor="#FFFFFF">Additional Notes</td>



    <td bgcolor="#FFFFFF">'.$_POST['additional'].'</td>



  </tr>



  </table>



  



    



  <p>Thanks,</br>



    Finao Speakers Team.



  </p>



 





</div>



</body>



</html>



';







	mail($_POST['email'], $subject,$message1, $headers1);



}




}


}







?>







 







 