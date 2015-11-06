 <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl;?>/css/login.css" media="screen" />
 
<!-- Popup Box Start -->  



<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/javascript/fancybox-1.3.4/jquery.fancybox-1.3.4.js"></script>



<!-- --------------------------------------- DATE PICKER ---------------------------- -->



<script src="<?php echo Yii::app()->baseUrl;?>/javascript/datepicker.min.js">{"describedby":"fd-dp-aria-describedby"}</script>



<!--<link href="<?php //echo Yii::app()->baseUrl;?>/css/datepicker.css" rel="stylesheet" type="text/css" />-->



<!-- ------------------------------------ DATE PICKER END ---------------------------- -->





<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl;?>/javascript/fancybox-1.3.4/jquery.fancybox-1.3.4.css" media="screen" />



<!-- Popup Box End -->



<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />





<!--<script src="http://code.jquery.com/jquery-1.8.3.js"></script>-->



<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script> 



<script  type="text/javascript">



$(document).ready(function() {



	 

	

	$('#registerclose').click(function(){

	$.fancybox.close();

	$('#loguname').focus();

	});   

	

	<?php if(isset($_REQUEST['userstatus']) &&$_REQUEST['userstatus'] == 2){ ?>
	//alert("Register User");

	$("#registered").trigger('click');

	<?php }?>
	
	<?php if(isset($type) && $type==="promo"){ ?>
	 //alert("Register User");
	$("#registeredpromo").trigger('click');
	<?php }?>

	

	<?php if(isset($_REQUEST['userstatus']) && $_REQUEST['userstatus'] == 1){?> 

	 //alert("Joined Not Registered");

	 $("#joined").trigger('click');

	<?php }?>	

	

	//Start:For getting the login and registration popup when clicking on the join link in left nav	



	//$('#fbdob').glDatePicker();



	/*$("#reg-link").fancybox({



		'scrolling'		: 'no',



		'titleShow'		: false,



		'onComplete'		: function(){



			$('.signin').removeClass('form-highlight');	



			$('.registration').toggleClass('form-highlight');	



		},	



		'onClosed'		: function() {



		    	$('.registration').removeClass('form-highlight');



				clearall();



		}



	});	*/



	//End:For getting the login and registration popup when clicking on the join link in left nav	



	//Start:For getting the login and registration popup when clicking on the login link in left nav	



	$("#log-link").fancybox({



		'scrolling'		: 'no',



		'titleShow'		: false,



		'onComplete'		: function(){



			$('.registration').removeClass('form-highlight');		



			$('.signin').toggleClass('form-highlight');	



		},



		'onClosed'		: function() {



		    $('.signin').removeClass('form-highlight');



			clearall();



		}



	});



	$("#forgot-link").fancybox({



		'scrolling'		: 'no',



		'titleShow'		: false,



		'onClosed'		: function() {



		    	 $("span.forgot-error-msg").empty();

				 $("#btnsubforgot").show();

			}



			



	});	



	$("#changepswd-link").fancybox({



		'scrolling'		: 'no',



		'titleShow'		: false,



		'onClosed'		: function() {



		    	$('.signin').removeClass('form-highlight');	



				$('.registration').removeClass('form-highlight');



			}



			



	});	



	$("#thankyou-link").fancybox({



		'scrolling'		: 'no',



		'titleShow'		: false,



		'onClosed'		: function() {



		    	$('.signin').removeClass('form-highlight');	



				$('.registration').removeClass('form-highlight');



			}



			



	});

	

	$("#thankyou-unverify").fancybox({



		'scrolling'		: 'no',



		'titleShow'		: false,



		'onClosed'		: function() {



		    	$('.signin').removeClass('form-highlight');	



				$('.registration').removeClass('form-highlight');



			}



			



	});		

	



	$("#termlogin").fancybox({



			'scrolling'		: 'no',



			'titleShow'		: false,



			'onClosed'		:function(){



			//document.location.reload(true);	



		}



		});	



	//End:For getting the login and registration popup when clicking on the login link in left nav



	//Start:For validating the registration form	



	$("#fbregbtn").click(function(){



		



		mesg="";



		flag=true;



		if($("#fbfirstname").val().length < 1  || $("#fbfirstname").val()=="First Name")



		{



			//document.getElementById('fbfirstnamespan').style.display='none';



			//document.getElementById('fbfirstnamespanerror').style.display='';



			document.getElementById('fbfirstname').className='register error';



			flag=false;



		}



		



		if($("#fblastname").val().length < 1 || $("#fblastname").val() == "Last Name")



		{



			//document.getElementById('fblastnamespan').style.display='none';



			//document.getElementById('fblastnamespanerror').style.display='';



			document.getElementById('fblastname').className='register error';



			flag=false;



		}



		if($("#fbemailid").val().length < 1 || $("#fbemailid").val() == "Email")



		{



			//document.getElementById('fbemailidspan').style.display='none';



			//document.getElementById('fbemailidspanerror').style.display='';



			document.getElementById('fbemailid').className='register error';



			flag=false;



		}



		/*if($("#upassword").val().length < 6 || $("#upassword").val() == "Password")



		{



			//document.getElementById('passwordspan').style.display='none';



			//document.getElementById('passwordspanerror').style.display='';

			document.getElementById('password').className='register error';

			document.getElementById('upassword').className='register error';

			//document.getElementById('password').style.display='none';

			//document.getElementById('upassword').className='register error';

			flag=false;



		}

		if($("#upassword").val().length >= 6 && $("#upassword").val() != "Password")



		{

			document.getElementById('upassword').className='register';

			//document.getElementById('password').style.display='block';

		}

		if($("#password").val().length >= 6 && $("#password").val() != "Password")



		{

			document.getElementById('password').className='register';

			//document.getElementById('password').style.display='block';

		}*/





		if(($("#terms").is(':checked'))==false)



		{



			mesg = "Please check terms and conditions";



			flag=false;



		}



		if(flag == false)



		{



			document.getElementById('msg').style.display='';



			$("#msg span").html(mesg);



			return false;



		}



	});



	//End:For validating the registration form	



	//Start:For showing login screen after activiation of email



	<?php if(isset($this->Isactive)){if($this->Isactive == 'active') { ?>



		$("#log-link").trigger('click');



	<?php }} ?>



	//End:For showing login screen after activiation of email



	//Start:: facebook register page



	//alert('<?php echo $this->Isactive; ?>');



	<?php if(isset($this->Isactive)){if($this->Isactive == 'newfbreg' || $this->Isactive == 'newreg')  { ?>



	$("#reg-link").trigger('click');



	<?php }} ?>

	

	<?php if(isset($joinnow) && $joinnow == 1){ ?>



	$("#thankyou-link").trigger('click');



	<?php } ?>

	

	<?php if(isset($joinnow) && $joinnow == "already_subscribed_but_unverified"){ ?>

    

	$("#thankyou-unverify").trigger('click');

	<? }?>

	

		<?php /*?><a id="registered" href="#registered" ></a> 

		<a id="joined" href="#joined" ></a> <?php */?>

	

	

	//End:: facebook register page



	//Start:: facebook register page



	<?php if(isset($this->popup)){if($this->popup == 'forgotchngpwd') { ?>



	$("#changepswd-link").trigger('click');



	<?php }} ?>



	//End:: facebook register page



	$("#sign-link").click(function(){



		$('#fbfirstname').focus();



	});



	<?php if(isset($this->Isactive)){if($this->Isactive == 'fberror') { ?>



	$("#reg-link").trigger('click');



	<?php }} ?>	



});







//Start:For checking whether email exists or not



function testfbEmail()



{



	var text = document.getElementById('fbemailid').value;



	if(document.getElementById('fbemailid').value=='')



	{



		document.getElementById('fbemailid').className = "register error";



		//document.getElementById('fbemailidspan').style.display='none';



		//document.getElementById('fbemailidspanerror').style.display='';



	}



	else



	{



		var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;



		if(text.match(emailExp))



		{



			jQuery(function($)



			{



				var url='<?php echo Yii::app()->createUrl("/site/validEmail"); ?>';



					$.post(url, { email:text},



						function(data){



							//alert(data);



							if(data == "Already Activated")



							{



								//document.getElementById('fbemailidspan').style.display='none';



								//document.getElementById('fbemailidspanerror').style.display='block';



								document.getElementById('fbemailid').className = "register error";



								document.getElementById('fbemailidtxt').style.display='block';



								document.getElementById('fbemailid').focus();



							}



							else



							{



								//document.getElementById('fbemailidspan').style.display='block';



								//document.getElementById('fbemailidspanerror').style.display='none';



								document.getElementById('fbemailid').className = "register";



								document.getElementById('fbemailidtxt').style.display='none';



							}



						 });



							



			});



		}



		else



		{



			//document.getElementById('fbemailidspan').style.display='none';



			//document.getElementById('fbemailidspanerror').style.display='block';



			document.getElementById('fbemailid').className = "register error";



			document.getElementById('fbemailidtxt').style.display='none';



			document.getElementById('fbemailid').focus();



		}



	}



}



//End:For checking whether email exists or not



//Start:For submittng the registration form
function isNumberKey(evt)
 {
	var charCode = (evt.which) ? evt.which : event.keyCode
	//alert(charCode);
	if(charCode == 8) return true;
	if (charCode < 48 || charCode > 57 )
		return false;
}

function fbregInput()

{

	//Changed on 14032013

	var flag = true;

	var fname = document.getElementById("fbfirstname").value;

	if(fname == 'First Name'){

		fname = '';

		flag = false;

	}

 	var lname = document.getElementById("fblastname").value;

 	if(lname == 'Last Name'){

 		lname = '';

 		flag = false;

 	}



	//var uname = document.getElementById("fbusername").value;



	/*if(uname == 'User Name'){



		uname = '';



		flag = false;



	}*/



	var email = document.getElementById("fbemailid").value;

 	if(email == 'Email'){

 		email = '';



		flag = false;



	}



	var pwd = document.getElementById("password").value;
var socialid = document.getElementById("socialid").value;
//alert(socialid);
if(socialid=='0'){ 
//alert(socialid);
	if(pwd == 'Password' || pwd.length < 6){



		pwd = '';

		document.getElementById('password').className='register error';
		document.getElementById('upassword').className='register error';

		flag = false;



	}
	
	
	var cpwd = document.getElementById("cpassword").value;



	if(cpwd == 'Confirm Password' || cpwd.length < 6){



		cpwd = '';
		
		document.getElementById('cpassword').className='register error';

		flag = false;

	}
	
	if(pwd != cpwd){



		pwd = '';
		
		cpwd='';
		document.getElementById('cpassword').className='register error';
		document.getElementById('password').className='register error';
		
		$('#cpwd').css('color','red');
		//document.getElementById('upassword').className='register error';
		
		$('.error-msg').html('<span style="color:red">Password and Confirm Password should match</span>');

		flag = false;

	} 
	if(document.getElementById("password").value == document.getElementById("cpassword").value){
		//document.getElementById('cpassword').className='register error';
		//document.getElementById('password').className='register error';	
		document.getElementById('password').className='register';	document.getElementById('cpassword').className='register';
	//	$('#cpwd').css('color','red');
		$('.error-msg').html('');
		//flag = false;
	} 
	
}//alert(document.getElementById("date_mon").value);
	if(document.getElementById("date_dat").value=='0000' || document.getElementById("date_mon").value=='00' || document.getElementById("date_year").value=='00')
	 {
	 	 $('.dropdown').css('border','1px red solid'); 
		 $('#dob-error-msgs').html('Please Select Your Date Of Birth');
		  flag = false;
	}

	else { $('.dropdown').css('border',''); $('#dob-error-msgs').html('');}




	//Ended on 14032013



	var e = document.getElementById("country_id3");



	var gender = e.options[e.selectedIndex].value;

	

	



	//var dob = document.getElementById("date_dat").value;

	var dob = document.getElementById("date_dat").value +'-'+document.getElementById("date_mon").value +'-'+ document.getElementById("date_year").value;

	

	//alert(dob);return false;



	var zip = document.getElementById("fbzipcode").value;



	var frnds = document.getElementById("frnds").value;



	



	if(($("#terms").is(':checked'))==true && flag == true)



	{



	//alert(fname+''+email+''+lname+''+pwd+''+zip+''+gender);



	jQuery(function($)



	{



		



		var url='<?php echo Yii::app()->createUrl("/site/getReginfo"); ?>';



		//$('#regimgDiv').show();// show your loading image



		$.post(url, { fname:fname,lname:lname,email:email,pwd:pwd,gender:gender,dob:dob,zip:zip,frnds:frnds,socialid:socialid},



			function(data){



				//if(data == "Thank you for signing up for Finao. <br> Please click on confirmation link sent to your mail to get activated.")

				if(data == "reg success")

      			{

					

					//$('#registersuccess').show()

					//$('#regbox').hide();

					//setTimeout("$('#registersuccess').show()",5000);

					//$('#regimgDiv').hide();

					location.href = '<?php echo Yii::app()->createUrl("profile/profilelanding/"); ?>';
					//location.href = '<?php //echo Yii::app()->createUrl("Profile/landing"); ?>';

    			}

				else if(data == "fb registration success")

				{

					$('#regimgDiv').hide();
					location.href = '<?php echo Yii::app()->createUrl("profile/profilelanding/"); ?>';
					//location.href='<?php //echo Yii::app()->createUrl("/profile/landing"); ?>';

				}

				else if(data == "frnds redirect")

				{

					$('#regimgDiv').hide();

					window.location.href= '<?php echo Yii::app()->createUrl("site/index"); ?>';

				}

				else if(data == "You are already subscribed or your account may not be activated")

				{

					$('#regimgDiv').hide();

					$("span.error-msg").empty();//Added on 14032013



					$("span.error-msg").append("<span style='color: red;'>You are already subscribed or your account may not be activated</span>");



				}



				 });



				



	});



	}



	



}



//End:For submitting the registration form



//Start:For validating the firstname,lastname



function validatetxt(winEvent,id)



{



	var key;



	// event passed as param in Firefox, not IE where it's defined as window.event



	if(!winEvent)



	{



		winEvent = window.event;



		key = winEvent.keyCode;



	}



	else



	{ // ff key == 8 ||--- for backspaces



		key = winEvent.which;



	}



	if(key == 9 || key == 46 || (key >= 37 && key <= 40) || (key >= 48 && key <= 57))



	{



		return false;



		document.getElementById(id).className='register error';



		document.getElementById(id).focus();



	}



	else



	{



		var text = document.getElementById(id).value;



		var alphaExp = /^[a-zA-Z]+$/;



		if(text.match(alphaExp))



		{



			document.getElementById(id).className='register';



			document.getElementById(id).focus();



			//document.getElementById(id+'spanerror').style.display='none';



		}



		else



		{



			document.getElementById(id).className='register error';



			//document.getElementById(id+'spanerror').style.display='block';



			document.getElementById(id).focus();



		}



	}



}



//End:For validating the firstname,lastname



//Start:For removing the error text after validation



function restoretxt(id)



{



	document.getElementById(id).className='register';



	/*if(document.getElementById(id).value!='')



	{



		//document.getElementById(id+'span').style.display='';



		//document.getElementById(id+'spanerror').style.display='none';



		document.getElementById(id).className='register';



		document.getElementById(id).focus();



	}*/



}



//End:For removing the error text after validation



//Start of userlogin details submission



function submit1(myfield,e)



		{



			



			var keycode;



			if (window.event) keycode = window.event.keyCode;



			else if (e) keycode = e.which;



			else return true;



			if (keycode == 13)



			{



				



				$("#Login").trigger('click');



			   		return false;



			}



			else



			   	return true;



		}



 





//End of userlogin details submission



//Start of Forgot Password



function forgotpswd()



{



	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;



	var forgotemail = document.getElementById('forgotemail').value;



	



	if(forgotemail == '')



	{



		//Added on 14032013



		$("span.forgot-error-msg").empty();



		$("span.forgot-error-msg").html("<span style='color: red;'>Please Enter Your Mail Id</span>");



        return false;



		//Ended on 14032013



	}else{



	if(reg.test(forgotemail) == true){



		jQuery(function($){



				var url='<?php echo Yii::app()->createUrl("/site/forgotpwd"); ?>';



				$.post(url, { forgotemail:forgotemail},



				function(data)



			    {



			     if(data == "You Are not activated")



			     {



			      $("span.forgot-error-msg").empty();



			      $("span.forgot-error-msg").html("<span style='color: red;'>You Are Not Activated</span>");



			      return false;



			     }else if(data == "Succesful email"){



			     /* $("span.forgot-error-msg").hide();



				  $("span.forgot-error-msg3").show();



			      $("span.forgot-error-msg2").hide();



			      $("span.forgot-error-msg1").hide();*/



			      $("span.forgot-error-msg").empty();



			      $("span.forgot-error-msg").html("<span style='color: red;'>Password Is Sent To Your Mail</span>");

				  $("#btnsubforgot").hide();



			     }

				 else{



		//Added on 14032013



	/*	$("span.forgot-error-msg3").hide();



		$("span.forgot-error-msg").hide();



		$("span.forgot-error-msg1").show();*/



		$("span.forgot-error-msg").empty();



		$("span.forgot-error-msg").html("<span style='color: red;'>Please Enter Valid Mail Id</span>");



		//Ended on 14032013



		return false;



	}



			    });



				



			});



	}else{



		//Added on 14032013



	/*	$("span.forgot-error-msg3").hide();



		$("span.forgot-error-msg").hide();



		$("span.forgot-error-msg1").show();*/



		$("span.forgot-error-msg").empty();



		$("span.forgot-error-msg").html("<span style='color: red;'>Please Enter Valid Mail Id</span>");



		//Ended on 14032013



		return false;



	}



}



}



function changepwd()



{



	errormesg = "";



	flag = true;



	if($("#npswd").val().length < 6)



	{



		document.getElementById('errornpwd').style.display='';



		document.getElementById('npswd').className = 'validation-no';



		flag = false;



	}



	else



	{



		document.getElementById('errornpwd').style.display='none';



		document.getElementById('npswd').className = 'textbox-reg';



		



	}



	if($("#ccpswd").val().length < 6)



	{



		document.getElementById('errorccpswd').style.display='';



		document.getElementById('ccpswd').className = 'validation-no';



		flag = false;



	}



	else



	{



		document.getElementById('errorccpswd').style.display='none';



		document.getElementById('ccpswd').className = 'textbox-reg';



		



	}



	if($('#validcpwd').css('display') == 'block')



	{



		flag = false;



	}



	else



	{



		if($('#errorcpwd').css('display') == 'none' && $('#errornpwd').css('display') == 'none' && $('#errorccpswd').css('display') == 'none' && $('#validcpwd').css('display') == 'none')



		{



			if($("#npswd").val().length <6)



			{



				errormesg = "Password Should be min 6 chars<br>";



				flag = false;



			}



			else



			{



				if($("#npswd").val() == $("#ccpswd").val())



				{



					errormesg = "";



					



				}



				else



				{



					errormesg = "New Password and Current Password are not matched.";



					flag = false;



					



				}



			}



			



		}



	}



	



	if(flag == false)



	{



		$("#msg p").html(errormesg);



		return false;



	}



	/*else



	{



		errormesg = "";



		flag = true;



	}*/



	if(flag == true)



	{



		var npswd = document.getElementById('npswd').value;



		//var cnfrmpswd = document.getElementById('cnfrmpswd').value;



		jQuery(function($)



		{



			var url='<?php echo Yii::app()->createUrl("/site/changePassword"); ?>';



			$.post(url, { npswd:npswd},



				function(data){



						if(data == "changed succesfully")



						{



							document.getElementById('changed').style.display = '';



							//document.getElementById('cpswd').value = '';



							document.getElementById('npswd').value = '';



							document.getElementById('ccpswd').value = '';



							$("#msg p").html('');



						}



						else



						{



							alert("something wrong. Try again later");



						}



				 });



				



		});



		



	



	}



}



function submitchngpswd(myfield,e)



{



	var keycode;



	if (window.event) keycode = window.event.keyCode;



	else if (e) keycode = e.which;



	else return true;



	if (keycode == 13)



	{



		$("#chngpwdbtn").trigger('click');



   		return false;



	}



	else



	   	return true;



}



function submitnewpswd(myfield,e)



{



	var keycode;



	if (window.event) keycode = window.event.keyCode;



	else if (e) keycode = e.which;



	else return true;



	if (keycode == 13)



	{



		$("#forgotchngpwdbtn").trigger('click');



   		return false;



	}



	else



	   	return true;



}



/*function restoreclass(id)



{



	//alert(id);



	document.getElementById(id).className = 'textbox-reg';



}*/



//End of Forgot Password



function newpwd()



{



	flag = true;



	if($("#newpswd").val().length < 6)



	{



		document.getElementById('errornewpwd').style.display='';



		flag = false;



	}



	else



	{



		document.getElementById('errornewpwd').style.display='none';



		flag = true;



	}



	



	if($("#cnfrmpswd").val().length < 6)



	{



		document.getElementById('errorcnfrmpswd').style.display='';



		flag = false;



	}



	else



	{



		document.getElementById('errorcnfrmpswd').style.display='none';



		flag = true;



	}



	if($('#errornewpwd').css('display') == 'none' && $('#errorcnfrmpswd').css('display') == 'none')



	{



		if($("#newpswd").val().length <6)



		{



			document.getElementById('errorminfive').style.display='';



			flag = false;



		}



		else



		{



			if($("#newpswd").val() == $("#cnfrmpswd").val())



			{



				document.getElementById('errorntmatch').style.display='none';



				flag = true;



			}



			else



			{



				document.getElementById('errorntmatch').style.display='';



				document.getElementById('errorminfive').style.display='none';



				flag = false;



				



			}



		}



		



	}



	if(flag != false)



	{



		var newpswd = document.getElementById('newpswd').value;



		var cnfrmpswd = document.getElementById('cnfrmpswd').value;



		jQuery(function($)



		{



			var url='<?php echo Yii::app()->createUrl("/site/newPswd"); ?>';



			$.post(url, { newpswd:newpswd, cnfrmpswd:cnfrmpswd},



				function(data){



						if(data == "Saved Successfully")



						{



							document.getElementById('newpswd').value = '';



							document.getElementById('cnfrmpswd').value = '';



							document.getElementById('saved').style.display = '';

							document.getElementById('close').style.display = 'none';

							document.getElementById('pleasetext').style.display = 'none';

							document.getElementById('loginbutton').style.display = '';

							

                         

						}



						else



						{



							alert("something wrong. Try again later");



						}



				 });



				



		});



		



	



	}



}



function submitnewpswd(myfield,e)



{



	var keycode;



	if (window.event) keycode = window.event.keyCode;



	else if (e) keycode = e.which;



	else return true;



	if (keycode == 13)



	{



		$("#forgotchngpwdbtn").trigger('click');



   		return false;



	}



	else



	   	return true;



}

function forgotsubmit(myfield,e)



{



	var keycode;



	if (window.event) keycode = window.event.keyCode;



	else if (e) keycode = e.which;



	else return true;



	if (keycode == 13)



	{



		$("#btnsubforgot").trigger('click');



   		return false;



	}



	else



	   	return true;

	

}

function isDate(input, msg) {



  // dd-mmm-yyyy format



  /*obj = field;



  date = obj.value;



 // alert(msg);



  if(date.length==0) {



  	document.getElementById('dob-error-msg').style.display='none';



    return true; // Ignore null value



  }



  if(date.length == 10) { 



    date = "0"+date; // Add a leading zero



  } 



  if (date.length!= 11) {



  document.getElementById('dob-error-msg').style.display='';



    return false;



  } 



  day = date.substring(0, 2);



  month = date.substring(3, 6).toUpperCase();



  year = date.substring(7, 11);



  if( isNaN(day) || (day < 0) || isNaN(year) || (year < 1)) {



    document.getElementById('dob-error-msg').style.display='';



    return false;



  } 







  // Ensure valid month and set maximum days for that month...



  if( (month == "JAN") || (month == "MAR") || (month == "MAY") || 



      (month == "JUL") || (month == "AUG") || (month == "OCT") || 



      (month == "DEC") ) { monthdays = 31 }



  else if( (month == "APR") || (month == "JUN") || (month == "SEP") ||



           (month == "NOV") ) { monthdays = 30 }



  else if(month == "FEB") { 



    monthdays = ((year % 4) == 0) ? 29 : 28; 



  }



  else {



     document.getElementById('dob-error-msg').style.display='';;



    return false;



  }



  if(day > monthdays) {



     document.getElementById('dob-error-msg').style.display='';



    return false;



  }



  document.getElementById('dob-error-msg').style.display='none';



  return true;*/



  



	if(input.value == ""){



		document.getElementById('fbdob').className = "register";



		document.getElementById('dob-error-msg').style.display='none';



		var returnval=false



		return returnval



		exit;



	}



    var validformat=/^\d{2}\-\d{2}\-\d{4}$/ //Basic check for format validity



	var returnval=false



	if (!validformat.test(input.value)){



	document.getElementById('dob-error-msg').style.display='block';



	document.getElementById('fbdob').className = "register error";



	}



	else{ //Detailed check for valid date ranges



	var monthfield=input.value.split("-")[0]



	var dayfield=input.value.split("-")[1]



	var yearfield=input.value.split("-")[2]



	var dayobj = new Date(yearfield, monthfield-1, dayfield)



	var today = dayobj;



	//alert("first");



	if(monthfield > 12 || dayfield >31)



	{



		document.getElementById('dob-error-msg').style.display='block';



		document.getElementById('fbdob').className = "register error";



		exit;



	}



	//alert("date");



	var hi = $.datepicker.formatDate('dd-MM-yy',today);



	//var hi = dojo.date.locale.format(today, {selector:"date", datePattern:"d-M-Y" });



	document.getElementById('fbdob').value = hi;



	if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))



	document.getElementById('dob-error-msg').style.display='';



	//document.getElementById('fbdob').className = "register error";



	else



	returnval=true



	document.getElementById('fbdob').className = "register";



	document.getElementById('dob-error-msg').style.display='none';



	}



	if (returnval==false) input.select()



	



	return returnval



	



}



function clearall()



{



		document.getElementById('loguname').value = 'Email';



		document.getElementById('logupwd').value = 'Password';



		document.getElementById('fbfirstname').value = 'First Name';



		document.getElementById('fblastname').value = 'Last Name';



		/*document.getElementById('fbusername').value = 'User Name';*/



		document.getElementById('fbemailid').value = 'Email';



		document.getElementById('password').value = 'Password';

		document.getElementById('upassword').value = 'Password';

		

		document.getElementById('password').style.display = 'none';

		document.getElementById('upassword').style.display = '';

		

		//document.getElementById('fbdob').value = 'DOB: MM-DD-YYYY';



		document.getElementById('fbzipcode').value = 'Zip Code';



		document.getElementById('country_id3').value = '';



		



		document.getElementById('fbfirstname').className = 'register';



		document.getElementById('fblastname').className = 'register';



		



		document.getElementById('fbemailid').className = 'register';



		document.getElementById('password').className = 'register';

		document.getElementById('upassword').className = 'register';



		document.getElementById('msg').style.display='none';



		document.getElementById('log-msg').style.display='none';



		document.getElementById('dob-error-msg').style.display='none';



		document.getElementById('logunamespan').style.display='';



		



		document.getElementById('logupwdspan').style.display='';



		



		document.getElementById('fbfirstnamespan').style.display='';



		



		document.getElementById('fblastnamespan').style.display='';



		



		document.getElementById('fbemailidspan').style.display='';



		



		document.getElementById('passwordspan').style.display='';



		



}



</script>







<div style="display:none;">



<div id="login_form" class="login-popupbox">



<div style="width:98%; font-weight:bold; font-size:20px; color:#f95702; margin-bottom:15px; float:left; margin-left:250px; "><img src="<?php echo Yii::app()->baseUrl;?>/images/logo-n.png" width="40" style=" float:left" /> &nbsp; <span class="left" style="padding-left:20px; padding-top:5px;">Login FINAO&reg;Nation</span></div>



<?php if(isset($this->Isactive) && ($this->Isactive=='active')){?>



    <p class="run-text"><span style="color: red;">Congratulations.</span> Your account has been successfully activated. Please sign in to begin customizing FINAO to meet your needs.</p> 



<?php }?>



<div id="imgDiv" style="display:none; position:absolute;top:50%;left:50%;"><img src="<?php echo Yii::app()->baseUrl;?>/images/status.gif"/></div>











<div id ="loginregbox" class="signin-registration">







<div class="signin">



<h1 class="hdline-reg">Already have an account</h1>



<!-- Social Buttons -->



<div class="social">



<p style="margin-bottom:4px;">Sign in using social network:</p>







<div >







<?php $this->widget('FbRegister');?>



</div>







</div>







<!-- Login Fields -->



<div id="login">Sign in using your registered account:<br/>



<div id="log-msg">



<span style="color:#FF0000;"></span>



</div>



<?php if(isset(Yii::app()->request->cookies['login_usernme']->value))



{ 



?>



<span id="logunamespan"><input type="text" id="loguname" onblur="if(this.value=='')this.value='Email'" onfocus="if(this.value=='Email')this.value='';" onkeypress="restoretxt(this.id);" value="<?php echo $cookie = Yii::app()->request->cookies['login_usernme']->value; ?>" class="login user"/></span>



<span id="logunamespanerror" style="display: none;"><input type="text" id="loguname" onblur="if(this.value=='')this.value='Email';" onfocus="if(this.value=='Email')this.value='';" onkeypress="restoretxt(this.id);" value="<?php echo $cookie = Yii::app()->request->cookies['login_usernme']->value; ?>" class="login user error"/></span>



<?php



}else{



?>



<span id="logunamespan"><input type="text" id="loguname" onblur="if(this.value=='')this.value='Email';" onfocus="if(this.value=='Email')this.value='';" value="Email" class="login user"/></span>



<span id="logunamespanerror" style="display: none;"><input type="text" id="loguname" onblur="if(this.value=='')this.value='Email';" onfocus="if(this.value=='Email')this.value='';" onkeypress="restoretxt(this.id);" value="Email" class="login user error"/></span>



<?php	



}



?>



<?php if(isset(Yii::app()->request->cookies['login_paswrd']->value))



{ 



?>



<span id="logupwdspan"><input type='password' id="logupwd" name='password' value='<?php echo $cookie = Yii::app()->request->cookies['login_paswrd']->value; ?>'  onfocus="if(this.value=='' || this.value == 'Password') {this.value='';this.type='password'}"  onblur="if(this.value == '') {this.type='password';this.value=this.defaultValue};" onkeypress="return submit1(this,event);restoretxt(this.id);" class="login password"/></span>



<span id="logupwdspanerror" style="display: none;"><input type='password'  id="logupwd" name='password' value='<?php echo $cookie = Yii::app()->request->cookies['login_paswrd']->value; ?>'  onfocus="if(this.value=='' || this.value == 'Password') {this.value='';this.type='password'}"  onblur="if(this.value == '') {this.type='password';this.value=this.defaultValue};" onkeypress="return submit1(this,event);restoretxt(this.id);" class="login password error"/></span>



<?php



}else{



?>



<span id="logupwdspan"><input type='password' id="logupwd" name='password' value='Password'  onfocus="if(this.value=='' || this.value == 'Password') {this.value='';this.type='password'}"  onblur="if(this.value == '') {this.type='password';this.value=this.defaultValue}" onkeypress="return submit1(this,event);restoretxt(this.id);" class="login password"/></span>



<span id="logupwdspanerror" style="display: none;"><input type='password' id="logupwd" name='password' value='Password'  onfocus="if(this.value=='' || this.value == 'Password') {this.value='';this.type='password'}"  onblur="if(this.value == '') {this.type='password';this.value=this.defaultValue}" onkeypress="return submit1(this,event);restoretxt(this.id);" class="login password error"/></span>



<?php



}



?>







</div>







<!-- Green Button -->



<div class="right" style="margin-top:10px;"><input  type="button" id="Login" name="Login" value="Sign In" class="orange-button" onclick="uLogin()"/></div>







<!-- Checkbox -->



<div class="checkbox">



<li>



<fieldset>



<![if !IE | (gte IE 8)]><legend id="title2" class="desc"></legend><![endif]>



<!--[if lt IE 8]><label id="title2" class="desc"></label><![endif]-->



<div>



<span>



<!--<input type="checkbox" id="Field" name="Field" class="field checkbox" value="First Choice" tabindex="4" onchange="handleInput(this);" />-->



<input type="checkbox" id="remcheckbox"/>



<label class="choice" for="Field">Keep me signed in</label>



</span>



</div>



</fieldset>



</li>



</div>



<!-- Text Under Box -->



<div id="bottom_text">


<!--
<a  id ="forgot-link" href="#forgot_form">Forgot Password</a>-->



</div>



</div>







<div style="clear: right"></<div>



<div style="float:left; font-size:13px; line-height:26px; margin-left:10px; width:360px;">



	<p class="run-text padding-8pixels orange font-15px">Some of the things you can do with FINAO... </p>



	<p class="orange font-15px">Create & manage</p>



	<p class="run-text padding-8pixels">Create a FINAO to set your personal goals. Then track your progress with video, photo and more. </p>



	<p class="orange font-15px">Search & track</p>



	<p class="run-text padding-8pixels">Need some inspiration? Search for other FINAO members and follow their progress. </p>



	<p class="orange font-15px">Share your FINAOs it you want to.</p>



	<p class="run-text padding-8pixels">Share your FINAO goals and progress with others, it’s easy to do online or with our mobile app.</p>



	<p class="orange font-15px">Ready to rock your FINAO? Check out our gear. </p>



	<p class="run-text padding-8pixels">You know what matters most to you, and you’re not afraid to show it. Customize your FINAO FlipWear® to show the world you mean it.</p>







</div>



</div>



</div>



</div>

 

<div style="width:auto;height:auto;overflow: hidden;position:relative; display:none;">



    <div id="forgot_form" class="forgot-password">



    	<p>Enter your Email Address to get your password:</p>



		<span class="forgot-error-msg"></span>



		<!--<span class="forgot-error-msg1"></span>



		<span class="forgot-error-msg2"></span>



		<span class="forgot-error-msg3"></span>-->



       	<p style="margin-left: 83px;"><input type="text" class="textbox" id ="forgotemail"style="width:70%" onfocus="$('span.forgot-error-msg').empty();" onkeypress="return forgotsubmit(this,event);"/></p>



        <p><input type="button" value="Submit" id="btnsubforgot" class="orange-button" onclick = "forgotpswd()"/></p>



		<!--<p><a href="#changepswd_form" class="orange-button"/>changepswd</a></p>-->



    </div>



</div>



	<!--<div style="display:none;">-->



<a href="#changepswd_form" id="changepswd-link" style="display:none;">change password </a>



<?php if(isset($this->popup)){



if(($this->popup == 'forgotchngpwd')){



?>



		<div id="changepswd_form"  class="change-password">



			<p class="orange" id="pleasetext">Please Enter New Password</p>



			<p id="saved" style="display:none; padding-bottom:10px!important;" class="green-text" align="center">Your Password Saved Sucessfully</p>

		    <p align="center"> <a href="/" align="center" id="loginbutton" style="display:none;font-size: 15px;"/>

			<?php /*<a href="<?php echo Yii::app()->baseUrl;?>/home" align="center" id="loginbutton" style="display:none;font-size: 15px;"/>*/?>

			Login now</a></p>



			<p id="errorntmatch" style="display:none;  padding-bottom:10px!important;" class="error-message">New Password and Confirm Password Are Not Matched</p>



		<div id="close">	

		

		<fieldset>



				<label>New password:</label>



				<div><input  type="password" class="textbox" id="newpswd" value="" style="width:70%" /></div>	



			</fieldset>



			<fieldset id="errornewpwd" style="display:none;">



				<label>&nbsp;</label>



				<div><p  class="error-message">Please Enter New Password</p></div>		



			</fieldset>



			<fieldset>



			<label>Confirm password:</label>



			<div><input  type="password" class="textbox" id="cnfrmpswd" onKeyPress="return submitnewpswd(this,event)" value="" style="width:70%"/></div>



			</fieldset>

			



			<fieldset id="errorcnfrmpswd" style="display:none;">



			<label>&nbsp;</label>



			<div><p class="error-message">Please Enter Confirm Password</p></div>



			</fieldset>



			<fieldset>



			<label>&nbsp;</label>



			<div><input type="button" id="forgotchngpwdbtn" onclick="newpwd()" value="Submit" class="orange-button" align="center"/>



			<input type="button" id="chngpwdcancelbtn" onclick="cancelnewpwd()" value="Cancel" class="orange-button" />		</div>



			</fieldset>



			

</div>

			



			



			



		</div>



<?php



}}



?>	



</div>



</div>



<div style="display:none;">



<div id="reg_form" class="login-popupbox">



<div style="width:98%; font-weight:bold; font-size:20px; color:#f95702; margin-bottom:15px; float:left; margin-left:250px; ">



	<img src="<?php echo Yii::app()->baseUrl;?>/images/finao-logo.png" width="40" style=" float:left" /> &nbsp; <span class="left" style="padding-left:20px; padding-top:10px;">

	Welcome to FINAO Nation</span>

	<!--Join the FINAO<sup>&reg;</sup> Nation</span>-->



</div>



<div id="regimgDiv" style="display:none; position:absolute;top:50%;left:50%;">



 	<img src="<?php echo Yii::app()->baseUrl;?>/images/newprogress.gif"/>



</div>



<div id = "regthankyou" style="display:none;">



<div style="text-align: center; font-weight: bold; font-size: 18px; height: 200px; padding-top: 200px; line-height: 30px;">



<h3>Thank you for signing up for FINAO. <br> Please click on confirmation link sent to your mail to get activated.</h3>



</div>



</div>

<div id="registersuccess" style="display:none;">

	<p class="run-text" style="color: red;text-align: center; font-weight: bold; font-size: 18px; height: 200px; padding-top: 200px; line-height: 30px;"><span style="text-align:center;">Congratulations.</span><br> Your account has been successfully registered. Please sign in to begin customizing FINAO to meet your needs.</p>

	</div>

<div id="regbox" class="signin-registration">



	<div  <?php if(isset($this->Isactive) && $this->Isactive == 'newfbreg'){?> class="registrationfb form-highlight" <?php }else{?> class="registration" <?php }?>>



	<?php if(Yii::app()->user->hasFlash('fbusererror')){ ?>



		<div class="flash-success">



 		<?php echo Yii::app()->user->getFlash('fbusererror'); ?>



		</div>



	<?php } ?>



	<?php if(isset($this->Isactive) && $this->Isactive == 'newfbreg'){?>



		<?php $user_profile = Yii::app()->facebook->api('/me'); ?>



		<h1 class="hdline-reg-fb">



		Welcome <?php echo $user_profile['first_name'];?>! You are one step away from creating your personalized profile..



		</h1>



	<?php }else{?>



	<h1 class="hdline-reg">Create your profile now <!--<sup>&reg;</sup>--></h1>



	<?php //$this->widget('FbRegister');?>



	<?php }?>



	<div id="msg">



		



		<!--<span id="dob-error-msg" class="terms-msg"></span>-->
		<span id="dob-error-msgs" class="terms-msg">

			<span class="red">* Mandatory Fields</span>

			<!--Please enter the date in MM-DD-YYYY format-->



		</span>

		



	</div>

	

	<span class="error-msg"></span>



	<?php if(isset($frnds)){?>



	<input type="hidden" value="frnds" id="frnds">



	<?php }else{?>



	<input type="hidden" value="notfrnds" id="frnds">   



	<?php }?>

		



	<div id="reg">



	<span id="fbfirstnamespan" style="width:100%; float:left;">

	<span class="left">

		<input type="text" id="fbfirstname"  name="fbfirstname" onblur="if(this.value=='')this.value='First Name';" onfocus="if(this.value=='First Name')this.value='',restoretxt(this.id);" onkeypress="validatetxt(event,this.id);" <?php if(isset($user_profile['first_name'])){?> value="<?php echo $user_profile['first_name'];?>" <?php }else{?> value="First Name" <?php } ?>class="register"/></span><span class="red left" style="padding-top:20px; padding-left:5px;">*</span>



	</span>


	<div class="clear"></div>
	



	<span id="fblastnamespan" style="width:100%; float:left;">

<span class="left">

		<input type="text" id="fblastname"  name="fblastname" onblur="if(this.value=='')this.value='Last Name';" onfocus="if(this.value=='Last Name')this.value='',restoretxt(this.id);" onkeypress="validatetxt(event,this.id);" <?php if(isset($user_profile['last_name'])){?> value="<?php echo $user_profile['last_name'];?>" <?php }else{?> value="Last Name" <?php }?> class="register"/></span><span class="red left" style="padding-top:20px; padding-left:5px;">*</span>



	</span>

	<div class="clear"></div>

	



	<span id="fbemailidspan">



		<input type="text"  id="fbemailid" name="fbemailid" onblur="if(this.value=='')this.value='Email';" onfocus="if(this.value=='Email')this.value='',restoretxt(this.id);" onChange="testfbEmail()" <?php if(isset($user_profile['email'])){?> value="<?php echo $user_profile['email'];?>" <?php }else{ if(isset($email) & $email != "") {?> value = <?php echo $email; ?> <?php }else{ ?> value="Email" <?php } }?> class="register" <?php if(isset($email) & $email != "") { ?> disabled="disabled" <?php } ?>/>



	</span>



	<span id="fbemailidtxt" style="display: none;color:#FF0000;">Email already exists</span>



	<?php if(isset($this->Isactive) && $this->Isactive == 'newfbreg'){?>



	<input type="hidden" id="password" name="password" value="password"/>



	<?php }else{?>



	<span id="passwordspan" style="width:100%; float:left;">

		
     <style type="text/css">::-webkit-input-placeholder { color: #8E8D8D;
}
:-moz-placeholder { /* Firefox 18- */
   color: #8E8D8D;  
}
::-moz-placeholder {  /* Firefox 19+ */
   color: #8E8D8D;  
}</style>
	<span class="left">	

		<input type="text" id="upassword" name="password" onblur="if(this.value=='')this.value='Password';" onfocus="changeUpwd();restoretxt(this.id);" value="Password" class="register"/>		

		<input type="password" id="password" name="password" onblur="if(this.value==''){restoreUpwd();this.value='Password';}" onfocus="if(this.value=='Password')this.value='',restoretxt(this.id);" value="Password" class="register" style="display:none;"/></span><span class="red left" style="padding-top:20px; padding-left:5px;">*</span>
		
		<div class="clear"></div>
<span class="left">	
			<input type="password" id="cpassword" name="cpassword"  placeholder="Confirm Password"  onfocus="restoretxt(this.id);"  class="register" /></span><span class="red left" style="padding-top:20px; padding-left:5px;">*</span>
			<div class="clear"></div>
			
			
			
			<!--<input type="password" id="cpassword" name="cpassword"  placeholder="Confirm Password" onfocus="restoretxt(this.id);if(this.value == 'Confirm Password') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'Confirm Password'; }" class="register" />-->


	</span>



	<?php } ?>

<div class="clear"></div>

	



	<span id="fbdobspan">



	<?php /*?><input type="text" id="fbdob" name="fbdob" onblur="if(this.value=='')this.value='DOB: MM-DD-YYYY';" onfocus="if(this.value=='DOB: MM-DD-YYYY')this.value='';" onChange="return isDate(this,'please enter the date in DOB: MM-DD-YYYY format');" <?php if(isset($user_profile['dob'])){?> value="<?php echo $user_profile['dob'];?>" <?php }else{?>value="DOB: MM-DD-YYYY" <?php } ?> class="txtbox left" style="margin: 13px 0 -3px;padding: 7px 8px;width:250px;" /><?php */

	

	if($user_profile['birthday']){$ss=explode('/',$user_profile['birthday']); ?>
	
	<div style="margin-top:10px;">	<span style="color:#8E8D8D">D O B :  </span>

		<select id="date_year" class="dropdown" style="width:100px;" onchange="year_change('<?php echo $s[1];?>','<?php echo $s[0];?>',this.value);">

		<?php $s=explode('-',date('d-m-Y')); $prev_year=$s[2]-101;$curnt_year=$s[2]-13;
		 for($i=$curnt_year;$i>$prev_year;$i--){?>

			<option value="<?php echo $i;?>" <?php if($i==$ss['2']) echo 'selected="selected"';?>><?php echo $i;?></option>

		<?php }?>

		</select>
		<?php $det_mnth=array('','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');?>

		<span id="date_sel"><select id="date_mon" class="dropdown"  onchange="day_change('<?php echo $s['2'];?>',this.value);">

			<?php for($i=01;$i<=12;$i++){?>

			<option value="<?php echo $i;?>" <?php if($i==$ss['0']) echo 'selected="selected"';?>><?php echo $det_mnth[$i];?></option>

				<?php }?>

		</select></span>
		
		<span id="date_sel_date">

		<?php $num = cal_days_in_month(CAL_GREGORIAN, $ss[0], $ss[2]);?>

		<select id="date_dat"  class="dropdown" >

		<?php for($i=01;$i<=$num;$i++){?>

			<option value="<?php echo $i;?>"<?php if($i==$ss['1']) echo 'selected="selected"';?> ><?php echo $i;?></option>

				<?php }?>

		</select></span>

		<span class="red">*</span>

		</div>	

		

	  <?php }

	else{ $s=explode('-',date('d-m-Y')); $prev_year=$s[2]-101;$curnt_year=$s[2]-13;?> 

	<div style="margin-top:10px;">	<span style="color:#8E8D8D">D O B :  </span>

		<select id="date_year" class="dropdown" style="width:100px;" onchange="year_change('<?php echo $s[0];?>','<?php echo $s[1];?>',this.value);"><option value="0000">Year</option>

			<?php for($i=$curnt_year;$i>$prev_year;$i--){?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php }?>

		</select>

		

		<span id="date_sel"><select id="date_mon" class="dropdown"><option value="00">Month</option></select></span>

				<?php /*?><?php for($i=1;$i<=$s[1];$i++){?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php }?><?php */?>

	

		<span id="date_sel_date"><select id="date_dat" class="dropdown"><option value="00">Date</option></select></span>

		<?php /*?><select id="date_dat">

			<?php for($i=1;$i<$s[0];$i++){?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php }?>

		</select><?php */?>

	<span class="red">*</span></div>

	<?php }?>

	</span>

	

	

	<script>	

	//  date month generating

	

	function year_change(day,mnth,year)

	{

		//$('#date_sel').html();

		 var newdata = new Date();

		 var highdate = new Date(newdata.getFullYear(),newdata.getMonth()+1,newdata.getDate());

		 var highdatevalue = highdate.getFullYear();

		 var month=highdate.getMonth();

		 var date=highdate.getDate();

		if($('#date_mon').val()=='' || $('#date_mon').val()=='0')  var select_month='0'; else  var select_month=$('#date_mon').val(); 

		if(year!=0)

		{		

			$('#date_sel').html('<select id="date_mon" class="dropdown" onchange="day_change('+year+',this.value);"><option value="00">Month</option></select>');

			if(highdatevalue>=year)

			 {

				var t='';

				var det_mnth=['','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

				if(highdatevalue!=year){for(var i=1; i<=12; i++)  t+='<option value='+i+' >'+det_mnth[i]+'</option>'; }

				else { for(var i=1; i<=month; i++) t+='<option value='+i+' >'+det_mnth[i]+'</option>';}

				$('#date_mon').append(t);//alert(select_month);

				$('#date_mon').children('option:eq('+select_month+')').attr('selected', 'selected');				

			 }

			 day_change(year,select_month);

			// $('#date_sel_date').html('<select class="dropdown" id="date_dat" ><option value="0">Day</option></select>');

		}

		else

		{

			$('#date_sel').html('<select id="date_mon" class="dropdown"><option value="00">Month</option></select>');

			$('#date_sel_date').html('<select class="dropdown" id="date_dat" ><option value="00">Date</option></select>');

		}	 

		getAge();

	}

	

	function day_change(year,month)

	{

		var d = new Date(year, month, 0);

		 var newdatas = new Date();

		 var highdates = new Date(newdata.getFullYear(),newdata.getMonth()+1,newdata.getDate());

		 var highdatevalues= highdates.getFullYear();

		 var months=highdates.getMonth();

		  var dates=highdates.getDate();

		   if($('#date_dat').val()=='' || $('#date_dat').val()=='0')  var select_date='0'; else  var select_date=$('#date_dat').val()-1; 

		// alert(d.getDate());

		if(month!=0)

		{

			 $('#date_sel_date').html('<select class="dropdown" id="date_dat"  onchange="getAge();"></select>');

			 var t='';

			 if((highdatevalues==year) && (months==month)){for(var i=1; i<dates; i++) t+='<option value='+i+'>'+i+'</option>';}

			 else {for(var i=1; i<=d.getDate(); i++) t+='<option value='+i+'>'+i+'</option>'; }

				$('#date_dat').append(t);

				$('#date_dat').children('option:eq('+select_date+')').attr('selected', 'selected');				

		}

		else

		{

			 $('#date_sel_date').html('<select class="dropdown" id="date_dat" ><option value="00">Date</option></select>');

		}

		getAge();		

	}

	

function getAge()

{

	var birthDay=$('#date_dat').val();

    var birthMonth=$('#date_mon').val();

    var birthYear=$('#date_year').val();	

	 var todayDate = new Date();

	 var todayYear = todayDate.getFullYear();

	  var todayMonth = todayDate.getMonth();

	  var todayDay = todayDate.getDate();

	  var age = todayYear - birthYear;	

	  if (todayMonth < birthMonth - 1)

	  {

		age--;

	  }	

	  if (birthMonth - 1 == todayMonth && todayDay < birthDay)

	  {

		age--;

	  }	

	

/*   var birth = new Date(date+'/'+month+'/'+year);var check = new Date();

	var milliDay = 1000 * 60 * 60 * 24; // a day in milliseconds;	

	var ageInDays = (check - birth) / milliDay;	

	var ageInYears =  Math.floor(ageInDays / 365 );

//	alert(ageInYears);*/



	if(age<13) { $('.dropdown').css('border','1px red solid'); $('#dob-error-msgs').html('Sorry, Your Age Is Less than 13'); $('#fbregbtn').attr('disabled','disabled');  return false;}

	else { $('.dropdown').css('border',''); $('#dob-error-msgs').html('');$('#fbregbtn').removeAttr('disabled'); }

}



		 

	 var newdata = new Date();

	 var highdate = new Date(newdata.getFullYear(),newdata.getMonth()+1,newdata.getDate());

	    

	 var highdatevalue = highdate.getFullYear() + "" ; 

	     highdatevalue += (highdate.getMonth() <= 9) ? "0"+highdate.getMonth() : highdate.getMonth() +"" ;

		 highdatevalue +=  highdate.getDate();	

		 

		// Create the first datepicker

		datePickerController.createDatePicker({ 

		    // Associate the text input (with an id of "demo-1") with a DD/MM/YYYY date

		    // format

		    formElements:{"fbdob":"%m-%d-%Y"},

			statusFormat:"%l, %d%S %F %Y",

			rangeHigh: highdatevalue

		    }); 

    </script>

	<!--<span style="padding-top: 22px; float: left; margin-left: 12px;"><input type="checkbox" /> Make Public</span>-->

	<span class="clear-left"></span>

	<span id="fbzipcodespan">



		<input type="text" id="fbzipcode" name="fbzipcode" onkeypress="return isNumberKey(event);" maxlength="5" onblur="if(this.value=='')this.value='Zip Code';" onfocus="if(this.value=='Zip Code')this.value='';" <?php if(isset($user_profile['zip'])){?> value="<?php echo $user_profile['zip'];?>"<?php }else{?>value="Zip Code" <?php } ?> class="zipcode"/>



	</span>







	<?php if(isset($this->Isactive) && $this->Isactive == 'newfbreg'){?>



		<input type="hidden" id="socialid" value="<?php echo $user_profile['id']; ?>"/>



	<?php }else{?>



		<input type="hidden" id="socialid" value="0"/>



	<?php }?>







	<div id="fullgender">



		<div id="secondBox" >



		<?php echo CHtml::dropDownList('gender', $model,$gender,array('empty' => 'Select Gender','id'=>'country_id3','class' => 'zipcode'));?>



		</div>



	</div>



	</div>



	<div style="clear:left"></div>

 <div style="margin-top:5px;"> <span style="color:#343434;font-size:14px;padding-right:10px;float:left;">Follow Us on Facebook :  </span>
    <div class="fb-follow" data-href="http://www.facebook.com/FINAONation" data-width="450" data-layout="button_count" data-show-faces="true"></div> 
     </div>

<!-- Blue Button -->



	<div class="right" style="margin-top: 10px;margin-right: 10px;">



		<input  type="button" id="fbregbtn"  value="Get Started" class="orange-button" onclick="fbregInput()"/>



	</div>



<!-- Checkbox -->



	<div class="checkbox">



		<li>



		<fieldset>



		<!--<![if !IE | (gte IE 8)]><legend id="title4" class="desc"></legend><![endif]>-->



<!--[if lt IE 8]><label id="title2" class="desc"></label><![endif]-->



		<div>



		<span>



		<input type="checkbox" id="terms"/>



		<label class="choice" for="Field">I have read and I agree<br/>  the <a href="<?php echo Yii::app()->createUrl('profile/terms'); ?>" target="_blank" class = "orange-link font-12px">Terms of Use</a></label>



		</span>



		</div>



		</fieldset>



		</li>



	</div>







</div>







	<div style="clear:right;">



	<div style="float:left; font-size:13px; line-height:26px; margin-left:10px; width:360px;">



		<p class="run-text padding-8pixels orange font-15px">Some of the things you can do with FINAO... </p>



		<p class="orange font-15px">Create & manage</p>



		<p class="run-text padding-8pixels">Create a FINAO to set your personal goals. Then track your progress with video, photo and more. </p>



		<p class="orange font-15px">Search & track</p>



		<p class="run-text padding-8pixels">Need some inspiration? Search for other FINAO members and follow their progress. </p>



		<p class="orange font-15px">Share your FINAOs if you want to</p>



		<p class="run-text padding-8pixels">Share your FINAO goals and progress with others, it’s easy to do online or with our mobile app.</p>



		<p class="orange font-15px">Wear it </p>



		<p class="run-text padding-8pixels">Ready to rock your FINAO? Check our customized gear.</p>







	</div>







	</div>



</div>



</div>



<div style="display:none;">

<div id="ter_form" class="login-popupbox">

	<?php //$this->renderPartial('//profile/terms'); ?>

</div>

</div>



<a id="log-link" href="#act_form" class="orange-link font-12px" style="margin-right:20px;">&nbsp;</a>



<div style="display:none;">



<div id="act_form" class="login-popupbox">







<div id="actmsg">



	<div style="text-align: center; font-weight: bold; font-size: 18px; padding:20px 0; line-height: 30px;">



		<h3>Congratulations!! Your account has been activated please login to proceed.</h3>



	</div>



</div>



	



</div>



</div>



















</div>



<!-- This section is for Splash Screen -->



<!--<section id="jSplash">



	<section class="selected">



		<h2 style="padding-bottom:25px;">FINAO NATION</h2>



		<p><img src="<?php echo Yii::app()->baseUrl;?>/images/finao-caption.png" width="500" /></p>



	</section>



</section>-->



<!-- End of Splash Screen -->







