<?php

$link = mysql_connect('localhost', 'fnspeak_wpdb', 'glQJQAkGvUox');

if (!$link) {

    die('Could not connect: ' . mysql_error());

}

mysql_select_db('fnspeak_wpdb',$link); 

?>



<?php 

$str = "SELECT * FROM `fs_booking` WHERE `email` = '".$_POST['email']."' AND `event_date` = '".$_POST['Date']."'";

$res = mysql_query($str);

$count =  mysql_num_rows($res);

//echo $count;

if($count > 0 )

{?>

<?php echo '<p style="color:red;">Event Booked ...Please select some other date</p>'; ?>

<?php }else{ ?>





<?php

$query = "INSERT INTO `fs_booking`( `email`, `name`, `phone`, `event`, `event_date`, `school`, `attendance`, `additional`) VALUES ( '".$_POST['email']."','".$_POST['name']."','".$_POST['phone']."','".$_POST['event']."','".$_POST['Date']."','".$_POST['school']."','".$_POST['attendance']."','".$_POST['additional']."')";

$insert = mysql_query($query);

if($insert)

{

	// multiple recipients

$to  = 'info@finaospeakers.com'; // note the comma
//$to  = 'swapna.a@wincito.com';
// subject

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

   <p>	The User '.$_POST['name'].' has requested to book '.$_POST['speaker'].' as a speaker.</p>

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

$headers .= 'Cc: leadership@finaonation.com' . "\r\n";

$headers .= 'Bcc:dev@wincito.com' . "\r\n";

//$headers .= 'Cc: Wallace@finaonation.com,chris@finaospeakers.com,Scott@finaonation.com' . "\r\n";

//$headers .= 'Bcc:siri502.alla@gmail.com' . "\r\n";

//$headers .= 'Cc: Chris@finaonation.com' . "\r\n";

//$headers .= 'Cc: Scott@finaonation.com' . "\r\n";

//$headers .= 'Cc:  Wallace@finaonation.com' . "\r\n";

// Mail it to user like confirmation

$mail = mail($to, $subject, $message, $headers);



if($mail)

{

	$subject = 'Booking Enquiry for '.$_POST['speaker'].'';

	// To send HTML mail, the Content-type header must be set

$headers1  = 'MIME-Version: 1.0' . "\r\n";

$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


$headers1 .= 'From: Finao Spekaers <info@finaospeakers.com>' . "\r\n";
//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
$headers1 .= 'Bcc: dev@wincito.com' . "\r\n";
/*
	$headers .= 'Cc: leadership@finaonation.com' . "\r\n";

$headers .= 'Bcc:siri502.alla@gmail.com' . "\r\n";

	$headers1 .= 'From:marketing@finaospeakers.com' . "\r\n";
	$headers .= 'Bcc: dev@wincito.com' . "\r\n";

	$headers1 .= 'Cc: dev@wincito.com' . "\r\n";*/

	echo '<span style="color:green;">"Thank you for your interest in booking "'.$_POST['speaker'].'". We will have someone reach out to your shortly."</span>';

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

   <p>	Thank you for booking '.$_POST['speaker'].' as speaker .We will get back to you Shortly.</p>

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



?>



 

<?php } ?>

 