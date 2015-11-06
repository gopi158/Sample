<?php $fuser = Yii::app()->facebook->getUser();?>
<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl;?>/css/login.css" media="screen" />-->
<!-- Popup Box Start -->  
<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/javascript/fancybox-1.3.4/jquery.fancybox-1.3.4.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl;?>/javascript/fancybox-1.3.4/jquery.fancybox-1.3.4.css" media="screen" />-->
<!-- Popup Box End -->
<script  type="text/javascript">
$(document).ready(function() {
	//Start:For getting the login and registration popup when clicking on the join link in left nav	
	$("#reg-link").fancybox({
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
	});	
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
		    	$('.signin').removeClass('form-highlight');	
				$('.registration').removeClass('form-highlight');
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
	//End:For getting the login and registration popup when clicking on the login link in left nav
	//Start:For validating the registration form	
	$("#fbregbtn").click(function(){
		
		mesg="";
		flag=true;
		if($("#fbfirstname").val().length < 1  || $("#fbfirstname").val()=="First Name")
		{
			document.getElementById('fbfirstnamespan').style.display='none';
			document.getElementById('fbfirstnamespanerror').style.display='';
			flag=false;
		}
		
		if($("#fblastname").val().length < 1 || $("#fblastname").val() == "Last Name")
		{
			document.getElementById('fblastnamespan').style.display='none';
			document.getElementById('fblastnamespanerror').style.display='';
			flag=false;
		}
		if($("#fbemailid").val().length < 1 || $("#fbemailid").val() == "Email")
		{
			document.getElementById('fbemailidspan').style.display='none';
			document.getElementById('fbemailidspanerror').style.display='';
			flag=false;
		}
		if($("#password").val().length < 8 || $("#password").val() == "Password")
		{
			document.getElementById('passwordspan').style.display='none';
			document.getElementById('passwordspanerror').style.display='';
			flag=false;
		}
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
	<?php if(isset($this->Isactive)){if($this->Isactive == 'newfbreg') { ?>
	$("#log-link").trigger('click');
	<?php }} ?>
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
	$("#log-link").trigger('click');
	<?php }} ?>	
});
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
		document.getElementById(id+'spanerror').style.display='';
		document.getElementById(id).focus();
	}
	else
	{
		var text = document.getElementById(id).value;
		var alphaExp = /^[a-zA-Z]+$/;
		if(text.match(alphaExp))
		{
			document.getElementById(id+'span').style.display='block';
			document.getElementById(id).focus();
			document.getElementById(id+'spanerror').style.display='none';
		}
		else
		{
			document.getElementById(id+'span').style.display='none';
			document.getElementById(id+'spanerror').style.display='block';
			document.getElementById(id).focus();
		}
	}
}
//End:For validating the firstname,lastname
//Start:For checking whether email exists or not
function testfbEmail()
{
	var text = document.getElementById('fbemailid').value;
	if(document.getElementById('fbemailid').value=='')
	{
		document.getElementById('fbemailidspan').style.display='none';
		document.getElementById('fbemailidspanerror').style.display='';
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
								document.getElementById('fbemailidspan').style.display='none';
								document.getElementById('fbemailidspanerror').style.display='block';
								document.getElementById('fbemailidtxt').style.display='block';
								document.getElementById('fbemailid').focus();
							}
							else
							{
								document.getElementById('fbemailidspan').style.display='block';
								document.getElementById('fbemailidspanerror').style.display='none';
								document.getElementById('fbemailidtxt').style.display='none';
							}
						 });
							
			});
		}
		else
		{
			document.getElementById('fbemailidspan').style.display='none';
			document.getElementById('fbemailidspanerror').style.display='block';
			document.getElementById('fbemailidtxt').style.display='none';
			document.getElementById('fbemailid').focus();
		}
	}
}
//End:For checking whether email exists or not
//Start:For submittng the registration form
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
	var uname = document.getElementById("fbusername").value;
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
	if(pwd == 'Password'){
		pwd = '';
		flag = false;
	}
	//Ended on 14032013
	var e = document.getElementById("country_id3");
	var gender = e.options[e.selectedIndex].value;
	var dob = document.getElementById("fbdob").value;
	var zip = document.getElementById("fbzipcode").value;
	var frnds = document.getElementById("frnds").value;
	var socialid = document.getElementById("socialid").value;
	if(($("#terms").is(':checked'))==true && flag == true)
	{
	//alert(fname+''+email+''+lname+''+pwd+''+zip+''+gender);
	jQuery(function($)
	{
		
		var url='<?php echo Yii::app()->createUrl("/site/getReginfo"); ?>';
		$('#imgDiv').show();// show your loading image
		$.post(url, { fname:fname,lname:lname,uname:uname,email:email,pwd:pwd,gender:gender,dob:dob,zip:zip,frnds:frnds,socialid:socialid},
			function(data){
				if(data == "Thank you for signing up for Finao. <br> Please click on confirmation link sent to your mail to get activated.")
      			{
					$('#imgDiv').hide();
					$('#loginregbox').hide();
     				$('#thankyou').show();
					
    			}
				else if(data == "fb registration success")
				{
					$('#imgDiv').hide();
					location.href='<?php echo Yii::app()->createUrl("/profile/profilelanding"); ?>';
					//$("span.error-msg").append("<span style='color: red;'>Registration success</span>");
					
				}
				else if(data == "frnds redirect")
				{
					$('#imgDiv').hide();
					//http://biziindia.com/pv-development/index.php/site/networkConnections?displaydata=invitefriend
					window.location.href= "http://biziindia.com/finaonation/stg/index.php";
				}
				else if(data == "You are already subscribed or your account may not be activated")
				{
					$('#imgDiv').hide();
					$("span.error-msg").empty();//Added on 14032013
					$("span.error-msg").append("<span style='color: red;'>You are already subscribed or your account may not be activated</span>");
				}
				 });
				
	});
	}
	
}
//End:For submitting the registration form
//Start:For removing the error text after validation
function restoretxt(id)
{
	if(document.getElementById(id).value!='')
	{
		document.getElementById(id+'span').style.display='';
		document.getElementById(id+'spanerror').style.display='none';
		document.getElementById(id).focus();
	}
}
//End:For removing the error text after validation
//Start of userlogin details submission
function uLogin()
{
	//idTest,usertype
	mesg="";
	flag=true;
	if($("#loguname").val().length < 1 || $("#loguname").val()== 'Email')
	{
		document.getElementById('logunamespan').style.display='none';
		document.getElementById('logunamespanerror').style.display='';
		flag=false;
	}
	else
	{
		document.getElementById('logunamespan').style.display='';
		document.getElementById('logunamespanerror').style.display='none';
		flag=true;
	}
	if($("#logupwd").val().length < 1 || $("#logupwd").val()== 'Password')
	{
		document.getElementById('logupwdspan').style.display='none';
		document.getElementById('logupwdspanerror').style.display='';
		flag=false;
	}
	else
	{
		document.getElementById('logupwdspan').style.display='';
		document.getElementById('logupwdspanerror').style.display='none';
		flag=true;
	}
	if(flag!= false)
	{
		var uname = document.getElementById("loguname").value;
		var pwd = document.getElementById("logupwd").value;
		var isChecked = $('#remcheckbox').is(':checked');
		if(isChecked)
		{
			var remember = true;
		}
		else
		{
			var remember = false;
		}
		//alert(remember);
		jQuery(function($){
			//alert(remember);
			var url 	= '<?php echo Yii::app()->createUrl("/site/login"); ?>';
			$.post(url, { uname:uname ,pwd:pwd, remember:remember},
			function(data)
			{
				//alert(data);
				if(data=="not-login")
				{
					mesg = "Invalid Username/Password";
					$("#log-msg span").empty();
					$("#log-msg span").html(mesg);
					//alert("your username/password is not correct");
				}
				else if(data=="Your account is not activated")
				{
					mesg = "Your account is not activated";
					$("#log-msg span").empty();
					$("#log-msg span").html(mesg);
				}
				else if(data=="AddFinao")
				{
					//var url2 = data;
					var url1 = "<?php echo Yii::app()->createUrl('/finao/motivationmesg/newfinao/##id');?>";
					url = url.replace('##id','newfinao');
					window.location = url1;
				}
				else if(data=="MotivationMesg")
				{
					//var url2 = data;
					var url2 = "<?php echo Yii::app()->createUrl('/finao/motivationmesg');?>";
					window.location = url2;
				}
				else if(data=="MyProfile")
				{
					//var url2 = data;
					var url3 = "<?php echo Yii::app()->createUrl('/profile/profilelanding');?>";
					window.location = url3;
				}
			});
		});
	}
}
function submitclick(e)
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
		$("span.forgot-error-msg1").hide();
		$("span.forgot-error-msg3").hide();
		$("span.forgot-error-msg2").hide();
		$("span.forgot-error-msg").show();
		$("span.forgot-error-msg").empty();
		$("span.forgot-error-msg").append("<span style='color: red;'>Please Enter Your Mail Id</span>");
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
			      $("span.forgot-error-msg").hide();
				  $("span.forgot-error-msg3").hide();
			      $("span.forgot-error-msg2").show();
			      $("span.forgot-error-msg1").hide();
			      $("span.forgot-error-msg2").empty();
			      $("span.forgot-error-msg2").append("<span style='color: red;'>You Are Not Activated</span>");
			      return false;
			     }else if(data == "Succesful email"){
			      $("span.forgot-error-msg").hide();
				  $("span.forgot-error-msg3").show();
			      $("span.forgot-error-msg2").hide();
			      $("span.forgot-error-msg1").hide();
			      $("span.forgot-error-msg2").empty();
			      $("span.forgot-error-msg3").append("<span style='color: red;'>Password Is Sent To Your Mail</span>");
			     }
			    });
				
			});
	}else{
		//Added on 14032013
		$("span.forgot-error-msg3").hide();
		$("span.forgot-error-msg").hide();
		$("span.forgot-error-msg1").show();
		$("span.forgot-error-msg1").empty();
		$("span.forgot-error-msg1").append("<span style='color: red;'>Please Enter Valid Mail Id</span>");
		//Ended on 14032013
		return false;
	}
}
}
function changepwd()
{
	errormesg = "";
	flag = true;
	if($("#npswd").val().length < 1)
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
	if($("#ccpswd").val().length < 1)
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
			if($("#npswd").val().length <5)
			{
				errormesg = "Password Should be min 5 chars<br>";
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
function restoreclass(id)
{
	//alert(id);
	document.getElementById(id).className = 'textbox-reg';
}
//End of Forgot Password
function newpwd()
{
	flag = true;
	if($("#newpswd").val().length < 1)
	{
		document.getElementById('errornewpwd').style.display='';
		flag = false;
	}
	else
	{
		document.getElementById('errornewpwd').style.display='none';
		flag = true;
	}
	
	if($("#cnfrmpswd").val().length < 1)
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
		if($("#newpswd").val().length <5)
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

function clearall()
{
		document.getElementById('loguname').value = 'Username';
		document.getElementById('logupwd').value = 'Password';
		document.getElementById('fbfirstname').value = 'First Name';
		document.getElementById('fblastname').value = 'Last Name';
		document.getElementById('fbusername').value = 'User Name';
		document.getElementById('fbemailid').value = 'Email';
		document.getElementById('password').value = 'Password';
		document.getElementById('fbdob').value = 'Date Of Birth';
		document.getElementById('fbzipcode').value = 'Zip';
		document.getElementById('country_id3').value = '';
		//$("span.error-msg").hide();
		//$("span.terms-msg").hide();
		//$("span.log-msg").hide();
		//document.getElementById('logunamespan').style.display='';
		document.getElementById('msg').style.display='none';
		document.getElementById('log-msg').style.display='none';
		document.getElementById('logunamespan').style.display='';
		document.getElementById('logunamespanerror').style.display='none';
		document.getElementById('logupwdspan').style.display='';
		document.getElementById('logupwdspanerror').style.display='none';
		document.getElementById('fbfirstnamespan').style.display='';
		document.getElementById('fbfirstnamespanerror').style.display='none';
		document.getElementById('fblastnamespan').style.display='';
		document.getElementById('fblastnamespanerror').style.display='none';
		document.getElementById('fbemailidspan').style.display='';
		document.getElementById('fbemailidspanerror').style.display='none';
		document.getElementById('passwordspan').style.display='';
		document.getElementById('passwordspanerror').style.display='none';
		//$("span.logunamespanerror").hide();
		//$("span.logupwdspanerror").hide();
}
</script>
<!-- Popup Box End -->
<!-- Datepicker start -->
<!--<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/css/ui/jquery-ui.css" />
<script src="<?php echo Yii::app()->baseUrl;?>/javascript/ui/jquery-1.9.1.js"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/javascript/ui/jquery-ui.js"></script>-->
<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
<script type="text/javascript">
/*$(function() {
$( "#datepicker" ).datepicker();
});*/
/*var j = jQuery.noConflict();
j(document).ready(function(){
//j( "#fbdob" ).datepicker();
	var date = new Date();
	var currentMonth = date.getMonth();
	var currentDate = date.getDate();
	var currentYear = date.getFullYear();
	j( "#fbdob" ).datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange: "1901:2013",
	maxDate: new Date(currentYear, currentMonth, currentDate)
	});
});*/
/*function datetext(event){
	$('textbox').keypress(function(event) {
    if ((event.keyCode == 13 ) && (event.keyCode >= 48 && event.keyCode <=57) ){
        event.preventDefault();
    }
});
}*/

</script>
<!-- Datepicker end -->	
<div style="display:none;">
<div id="login_form" class="login-popupbox">
<div style="width:98%; font-weight:bold; font-size:20px; color:#f95702; margin-bottom:15px; float:left; margin-left:250px; "><img src="<?php echo Yii::app()->baseUrl;?>/images/logo-n.png" width="40" style=" float:left" /> &nbsp; <span class="left" style="padding-left:20px; padding-top:5px;">Join the FINAO&reg;Nation</span></div>
<?php if(isset($this->Isactive) && ($this->Isactive=='active')){?>
    <p class="run-text"><span style="color: red;">Congratulations.</span> Your account has been successfully activated. Please sign in to begin customizing Finao to meet your needs.</p> 
<?php }?>
<div id="imgDiv" style="display:none; position:absolute;top:50%;left:50%;"><img src="<?php echo Yii::app()->baseUrl;?>/images/status.gif"/></div>
<div id = "thankyou" style="display:none;">
<div style="text-align: center; font-weight: bold; font-size: 18px; height: 200px; padding-top: 200px; line-height: 30px;">
<h3>Thank you for signing up for Finao. <br> Please click on confirmation link sent to your mail to get activated.</h3>
</div>
</div>
<?php if(Yii::app()->user->hasFlash('fbusererror')){ ?>
<div class="flash-success">
 <?php echo Yii::app()->user->getFlash('fbusererror'); ?>
</div>
<?php } ?>
<div id ="loginregbox" class="signin-registration">
<?php if(isset($this->Isactive) && $this->Isactive == 'newfbreg'){?>
<!-- Facebook Reg -->
<?php ?>
<?php $user_profile = Yii::app()->facebook->api('/me'); ?>
<div class="registrationfb form-highlight">
<!--<h1 class="hdline-reg-fb">Welcome <?php //echo Yii::app()->session['userinfo']['fname'];?>! You are one step away from creating your personalized profile..</h1>-->
<h1 class="hdline-reg-fb">Welcome <?php echo $user_profile['first_name'];?>! You are one step away from creating your personalized profile..</h1>
<div id="msg">
<span class="terms-msg"></span>
</div>
<span class="error-msg"></span>
<?php if(isset($frnds)){?>
<input type="hidden" value="frnds" id="frnds">
<?php }else{?>
<input type="hidden" value="notfrnds" id="frnds">
<?php }?>
<!-- Register Fields -->
<div id="reg">
<!--<input type="text" onblur="if(this.value=='')this.value='First Name';" onfocus="if(this.value=='First Name')this.value='';" value="First Name" class="register"/>-->
<span id="fbfirstnamespan"><input type="text" id="fbfirstname" name="fbfirstname" onblur="if(this.value=='')this.value='First Name';" onfocus="if(this.value=='First Name')this.value='',restoretxt(this.id);"  <?php if($user_profile['first_name']){?>value="<?php echo $user_profile['first_name'];?>"<?php }else{?>value="First Name" <?php } ?> class="register"/></span>
<span id="fbfirstnamespanerror" style="display:none;"><input type="text" id="fbfirstname" name="fbfirstname" onblur="if(this.value=='')this.value='First Name';" onfocus="if(this.value=='First Name')this.value='',restoretxt(this.id);"  <?php if($user_profile['first_name']){?>value="<?php echo $user_profile['first_name'];?>"<?php }else{?>value="First Name" <?php } ?> class="register error"/></span>

<span id="fblastnamespan"><input type="text" id="fblastname" name="fblastname" onblur="if(this.value=='')this.value='Last Name';" onfocus="if(this.value=='Last Name')this.value='',restoretxt(this.id);" <?php if($user_profile['last_name']){?>value="<?php echo $user_profile['last_name'];?>"<?php }else{?>value="Last Name" <?php } ?> class="register"/></span>
<span id="fblastnamespanerror" style="display:none;"><input type="text" id="fblastname" name="fblastname" onblur="if(this.value=='')this.value='Last Name';" onfocus="if(this.value=='Last Name')this.value='',restoretxt(this.id);"  <?php if($user_profile['last_name']){?>value="<?php echo $user_profile['last_name'];?>"<?php }else{?>value="Last Name" <?php } ?> class="register error"/></span>

<input type="hidden" id="socialid" name="socialid" value="<?php echo $user_profile['id']; ?>"/>
<input type="hidden" id="fbusername" name="fbusername" value=""/>

<span id="fbemailidspan"><input type="text" id="fbemailid" name="fbemailid" onblur="if(this.value=='')this.value='Email';" onfocus="if(this.value=='Email')this.value='',restoretxt(this.id);" onChange="testfbEmail()" <?php if($user_profile['email']){?>value="<?php echo $user_profile['email'];?>"<?php }else{?>value="Email" <?php } ?> class="register"/></span>
<span id="fbemailidspanerror" style="display:none;"><input type="text" id="fbemailid" name="fbemailid" onblur="if(this.value=='')this.value='Email';" onfocus="if(this.value=='Email')this.value='',restoretxt(this.id);" onChange="testfbEmail()" <?php if($user_profile['email']){?>value="<?php echo $user_profile['email'];?>"<?php }else{?>value="Email" <?php } ?> class="register error"/></span>
<span id="fbemailidtxt" style="display: none; color:#FF0000;">Email already exists</span>

<input type="hidden" id="password" name="password" value="password"/>
<?php 
$dob = date('Y-m-d', strtotime($user_profile['birthday'])); ?>

<span id="fbdobspan"><input type="text" id="fbdob" name="fbdob" onblur="if(this.value=='')this.value='Date Of Birth';" onfocus="if(this.value=='Date Of Birth')this.value='';" onkeypress="return false;"  <?php if($user_profile['birthday']){?>value="<?php echo $user_profile['birthday']	;?>"<?php }else{?>value="Date Of Birth" <?php } ?> class="register"/></span>


<span id="fbzipcodespan"><input type="text" id="fbzipcode" name="fbzipcode" maxlength="5" onblur="if(this.value=='')this.value='Zip Code';" onfocus="if(this.value=='Zip Code')this.value='';" <?php if(isset(Yii::app()->session['userinfo']['zip'])){?>value="<?php echo Yii::app()->session['userinfo']['zip'];?>"<?php }else{?>value="Zip Code" <?php } ?> class="zipcode"/></span>

<div id="fullgender">
<div id="secondBox" >
<?php echo CHtml::dropDownList('gender', $model,$gender,array('empty' => 'Select Gender','id'=>'country_id3','class' => 'zipcode'));?>
</div>
</div>
</div>
<div style="clear:left"></div>
<!-- Blue Button -->
<div class="right" style="margin-top: 10px;margin-right: 10px;"><input  type="button" id="fbregbtn"  value="Register" class="orange-button"  onclick="fbregInput()"/></div>
<!-- Checkbox -->
<div class="checkbox">
<li>
<fieldset>
<![if !IE | (gte IE 8)]><legend id="title4" class="desc"></legend><![endif]>
<!--[if lt IE 8]><label id="title2" class="desc"></label><![endif]-->
<div>
<span>
<input type="checkbox" id="terms"/>
<label class="choice" for="Field">I have read and I agree<br/>  the Terms of Use</label>
</span>
</div>
</fieldset>
</li>
</div>
</div>
<?php }else{?>
<div class="signin">
<h1 class="hdline-reg">Already have an account</h1>
<!-- Social Buttons -->
<div class="social">
<p style="margin-bottom:4px;">Sign in using social network:</p>
<!--<div style="position: absolute; left: -120px; float: left;!important"><?php //$this->widget('application.modules.hybridauth.widgets.renderProviders'); ?></div>-->
<div >
<?php 
  $base = Yii::app()->baseUrl; 
   $serveruri = 'http://'.$_SERVER['HTTP_HOST'].''.$base.'/index.php/site/index?url=newfbreg';
  
  
  //Rathan Added this 
  $params = array(
  'scope'=>'email,user_birthday,user_location,read_friendlists,offline_access',
  //'scope'=>'email,user_birthday,user_location,read_friendlists',
  'redirect_uri' => $serveruri ,
  'display' =>'page');?>
  
<a href="<?php echo Yii::app()->facebook->getLoginUrl($params); ?>"><img src="<?php echo Yii::app()->baseUrl;?>/images/login_icons/facebook.png" /></a>

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
<span id="logupwdspan"><input type='password' id="logupwd" name='password' value='<?php echo $cookie = Yii::app()->request->cookies['login_paswrd']->value; ?>'  onfocus="if(this.value=='' || this.value == 'Password') {this.value='';this.type='password'}"  onblur="if(this.value == '') {this.type='password';this.value=this.defaultValue};" onkeypress="restoretxt(this.id);" class="login password"/></span>
<span id="logupwdspanerror" style="display: none;"><input type='password' id="logupwd" name='password' value='<?php echo $cookie = Yii::app()->request->cookies['login_paswrd']->value; ?>'  onfocus="if(this.value=='' || this.value == 'Password') {this.value='';this.type='password'}"  onblur="if(this.value == '') {this.type='password';this.value=this.defaultValue};" onkeypress="restoretxt(this.id);" class="login password error"/></span>
<?php
}else{
?>
<span id="logupwdspan"><input type='password' id="logupwd" name='password' value='Password'  onfocus="if(this.value=='' || this.value == 'Password') {this.value='';this.type='password'}"  onblur="if(this.value == '') {this.type='password';this.value=this.defaultValue}" onkeypress="restoretxt(this.id);" class="login password"/></span>
<span id="logupwdspanerror" style="display: none;"><input type='password' id="logupwd" name='password' value='Password'  onfocus="if(this.value=='' || this.value == 'Password') {this.value='';this.type='password'}"  onblur="if(this.value == '') {this.type='password';this.value=this.defaultValue}" onkeypress="restoretxt(this.id);" class="login password error"/></span>
<?php
}
?>
<input type="hidden" id="socialid" value="0"/>
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
<a  id ="forgot-link" href="#forgot_form">Forgot Password</a>
</div>
</div>
<div class="registration">
<h1 class="hdline-reg">Sign up and create your FINAO now</h1>
<div id="msg">
<span class="terms-msg"></span>
</div>
<span class="error-msg"></span>
<?php if(isset($frnds)){?>
<input type="hidden" value="frnds" id="frnds">
<?php }else{?>
<input type="hidden" value="notfrnds" id="frnds">
<?php }?>
<!-- Register Fields -->
<div id="reg">
<!--<input type="text" onblur="if(this.value=='')this.value='First Name';" onfocus="if(this.value=='First Name')this.value='';" value="First Name" class="register"/>-->
<span id="fbfirstnamespan"><input type="text" id="fbfirstname" name="fbfirstname" onblur="if(this.value=='')this.value='First Name';" onfocus="if(this.value=='First Name')this.value='',restoretxt(this.id);"  <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['fname'];?>"<?php }else{?>value="First Name" <?php } ?> class="register"/></span>
<span id="fbfirstnamespanerror" style="display:none;"><input type="text" id="fbfirstname" name="fbfirstname" onblur="if(this.value=='')this.value='First Name';" onfocus="if(this.value=='First Name')this.value='',restoretxt(this.id);"  <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['fname'];?>"<?php }else{?>value="First Name" <?php } ?> class="register error"/></span>

<span id="fblastnamespan"><input type="text" id="fblastname" name="fblastname" onblur="if(this.value=='')this.value='Last Name';" onfocus="if(this.value=='Last Name')this.value='',restoretxt(this.id);" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['lname'];?>"<?php }else{?>value="Last Name" <?php } ?> class="register"/></span>
<span id="fblastnamespanerror" style="display:none;"><input type="text" id="fblastname" name="fblastname" onblur="if(this.value=='')this.value='Last Name';" onfocus="if(this.value=='Last Name')this.value='',restoretxt(this.id);"  <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['lname'];?>"<?php }else{?>value="Last Name" <?php } ?> class="register error"/></span>

<span id="fbusernamespan"><input type="text" id="fbusername" name="fbusername" onblur="if(this.value=='')this.value='User Name';" onfocus="if(this.value=='User Name')this.value='';"  <?php if(isset(Yii::app()->session['userinfo']['uname'])){?>value="<?php echo Yii::app()->session['userinfo']['uname'];?>"<?php }else{?>value="User Name" <?php } ?> class="register"/></span>


<span id="fbemailidspan"><input type="text" id="fbemailid" name="fbemailid" onblur="if(this.value=='')this.value='Email';" onfocus="if(this.value=='Email')this.value='',restoretxt(this.id);" onChange="testfbEmail()" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['email'];?>"<?php }else{?>value="Email" <?php } ?> class="register"/></span>
<span id="fbemailidspanerror" style="display:none;"><input type="text" id="fbemailid" name="fbemailid" onblur="if(this.value=='')this.value='Email';" onfocus="if(this.value=='Email')this.value='',restoretxt(this.id);" onChange="testfbEmail()" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['email'];?>"<?php }else{?>value="Email" <?php } ?> class="register error"/></span>
<span id="fbemailidtxt" style="display: none;color:#FF0000;">Email already exists</span>
<?php if(isset(Yii::app()->session['userinfo'])){ ?>
<input type="hidden" id="password" name="password" value="password"/>
<?}else{?>
<span id="passwordspan"><input type="password" id="password" name="password" onblur="if(this.value=='')this.value='Password';" onfocus="if(this.value=='Password')this.value='',restoretxt(this.id);" value="Password" class="register"/></span>
<span id="passwordspanerror" style="display:none;"><input type="password" id="password" name="password" onblur="if(this.value=='')this.value='Password';" onfocus="if(this.value=='Password')this.value='',restoretxt(this.id);"  value="Password" class="register error"/></span>
<?php } ?>
<span id="fbdobspan"><input type="text" id="fbdob" name="fbdob" onblur="if(this.value=='')this.value='Date Of Birth';" onfocus="if(this.value=='Date Of Birth')this.value='';" onkeypress="return false;"  <?php if(isset(Yii::app()->session['userinfo']['dob'])){?>value="<?php echo Yii::app()->session['userinfo']['dob'];?>"<?php }else{?>value="Date Of Birth" <?php } ?> class="register"/></span>

<span id="fbzipcodespan"><input type="text" id="fbzipcode" name="fbzipcode" maxlength="5" onblur="if(this.value=='')this.value='Zip Code';" onfocus="if(this.value=='Zip Code')this.value='';" <?php if(isset(Yii::app()->session['userinfo']['zip'])){?>value="<?php echo Yii::app()->session['userinfo']['zip'];?>"<?php }else{?>value="Zip Code" <?php } ?> class="zipcode"/></span>

<div id="fullgender">
<div id="secondBox" >
<?php echo CHtml::dropDownList('gender', $model,$gender,array('empty' => 'Select Gender','id'=>'country_id3','class' => 'zipcode'));?>
</div>
</div>
</div>
<div style="clear:left"></div>
<!-- Blue Button -->
<div class="right" style="margin-top: 10px;margin-right: 10px;"><input  type="button" id="fbregbtn"  value="Register" class="orange-button"  onclick="fbregInput()"/></div>
<!-- Checkbox -->
<div class="checkbox">
<li>
<fieldset>
<![if !IE | (gte IE 8)]><legend id="title4" class="desc"></legend><![endif]>
<!--[if lt IE 8]><label id="title2" class="desc"></label><![endif]-->
<div>
<span>
<input type="checkbox" id="terms"/>
<label class="choice" for="Field">I have read and I agree<br/>  the Terms of Use</label>
</span>
</div>
</fieldset>
</li>
</div>
</div>
<div style="clear: left"></<div>
<?php }?>
</div>
</div>
</div>
<div style="width:auto;height:auto;overflow: hidden;position:relative; display:none;">
    <div id="forgot_form" class="forgot-password">
    	<p>Enter your Email Address to get your password:</p>
		<span class="forgot-error-msg"></span>
		<span class="forgot-error-msg1"></span>
		<span class="forgot-error-msg2"></span>
		<span class="forgot-error-msg3"></span>
       	<p style="margin-left: 83px;"><input type="text" class="textbox" id ="forgotemail"style="width:70%" /></p>
        <p><input type="button" value="Submit" class="orange-button" onclick = "forgotpswd()"/></p>
		<!--<p><a href="#changepswd_form" class="orange-button"/>changepswd</a></p>-->
    </div>
</div>
	<!--<div style="display:none;">-->
<a href="#changepswd_form" id="changepswd-link" style="display:none;">change password </a>
<?php if(isset($this->popup)){
if(($this->popup == 'forgotchngpwd')){
?>
		<div id="changepswd_form"  class="change-password">
			<p class="orange">Please Enter New Password</p>
			<p id="saved" style="display:none; padding-bottom:10px!important;" class="green-text">Your Password Saved Sucessfully</p>
			<p id="errorntmatch" style="display:none;  padding-bottom:10px!important;" class="error-message">New Password and Confirm Password Are Not Matched</p>
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
			<input type="button" id="chngpwdcancelbtn" onclick="cancelnewpwd()" value="Cancel" class="orange-button" /></div>
			</fieldset>
			
			
			
			
		</div>
<?php
}}
?>	
</div>


<!-- Super Size Slider Start -->
<div id="maximage">
    <span>
    	<img src="<?php echo Yii::app()->baseUrl; ?>/images/large/01.jpg" alt="" />
        <div class="screen-txt">
        	<h2>Lacey Greene</h2>
            <p>Anthropology Student</p>
			<p>Model</p>
			<p>FINAO Natio Member</p>
            <!--<p><a href="#" class="ask-ambassidor">Ask Melissa</a></p>-->
        </div>
    </span>
    <span>
    	<img src="<?php echo Yii::app()->baseUrl; ?>/images/large/02.jpg" alt="" />
        <div class="screen-txt">
        	<h2>Melissa Tucker</h2>
            <p>Fitnes &amp; Nutrition Expert /</p>
			<p>Portable Person Trainer</p>
			<p>FINAO Natio Member</p>
            <p><a href="#" class="ask-ambassidor">Ask Melissa</a></p>
        </div>
    </span>  
    <span>
    	<img src="<?php echo Yii::app()->baseUrl; ?>/images/large/03.jpg" alt="" />
        <div class="screen-txt">
        	<h2>Mike Smith</h2>
            <p>Motivational Speaker /</p>
			<p>Skateboarder/Homeless Advocate</p>
			<p>FINAO Natio Member</p>
            <!--<p><a href="#" class="ask-ambassidor">Ask Melissa</a></p>-->
        </div>
        <div class="caption">
        	<p>Showing strength without</p>
			<p>showing off, that's </p>
			<p>my FINAO.</p>
			<p>Mike Smith</p>
       </div>
    </span>
    <span>
    	<img src="<?php echo Yii::app()->baseUrl; ?>/images/large/04.jpg" alt="" />  
        <div class="screen-txt">
        	<h2>Tammy Sutton-Brown</h2>
            <p>WNBA All Star/2012 WNBA Champion</p>
			<p>Children's book writer</p>
			<p>FINAO Natio Member</p>
            <!--<p><a href="#" class="ask-ambassidor">Ask Melissa</a></p>-->
        </div>  
    </span>
    <span>
    	<img src="<?php echo Yii::app()->baseUrl; ?>/images/large/05.jpg" alt="" />
        <div class="screen-txt">
        	<h2>Tanner Krenz</h2>
            <p>Running Back & Student</p>
			<p>Guitarist</p>
			<p>FINAO Natio Member</p>
            <!--<p><a href="#" class="ask-ambassidor">Ask Melissa</a></p>-->
        </div>
    </span>
</div>

<div class="contentContainer">
    <div id="cycle-nav"><p class="left font-20px" style="padding-right:20px; padding-top:40px;">WHAT'S YOUR FINAO</p><ul></ul></div>
</div>

<!-- Super Size Slider End -->