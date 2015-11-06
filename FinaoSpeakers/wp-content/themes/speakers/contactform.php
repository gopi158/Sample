<?php 

	if($name != "" && $email!= "" && $phone != "" && $comment != ""){



	//$to = "siri502.alla@gmail.com";
$to = "info@finaospeakers.com";


			$subject = "Contact Request";

			

			$message = '<html>

<head>

  <title>Contact Request Form</title>

  <style>

   p {font-size: 1em !important;font-family: Arial !important;}

    </style>

</head>

<body>

    

	<div width="570px">

	<p>Hi Finao Speakers Team,</p>

   <p>	We recieved contact request form the following person:</p>

 

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

    <td bgcolor="#FFFFFF">Comment</td>

    <td bgcolor="#FFFFFF">'.$_POST['comment'].'</td>

  </tr>



  </table>

  
  <p>Thanks,</br>

    Finao Speakers Team.

  </p>


</div>

</body>

</html>';



			//$message = "Name : $name \n Email : $email\n Phone : $phone\n Quantity : $group\n Comment : $comment";



			$from = $email;



			//$headers = "From:" . $from;

	// Always set content-type when sending HTML email

			$headers = "MIME-Version: 1.0" . "\r\n";

			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

			$headers .= "From: Finaospeakers <do-notreply@finaonation.com>";



			//$message = "Name : $name \n Email : $email\n Phone : $phone\n Comment : $comment";



			//$from = $email;



			//$headers = "From:" . $from;



			mail($to,$subject,$message,$headers);



			echo "success";



		



		}



	?>