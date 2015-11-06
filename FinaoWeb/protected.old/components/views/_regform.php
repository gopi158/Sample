<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl;?>/css/form-style.css" />
<script src="<?php echo Yii::app()->baseUrl;?>/javascript/formbox/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl;?>/javascript/formbox/ChunkFive_400.font.js" type="text/javascript"></script>
<script type="text/javascript">
	Cufon.replace('h1',{ textShadow: '1px 1px #fff'});
	Cufon.replace('h2',{ textShadow: '1px 1px #fff'});
	Cufon.replace('h3',{ textShadow: '1px 1px #000'});
	Cufon.replace('.back');
</script>
<!--<script  type="text/javascript">
$(document).ready(function() {
$("#privacy_page").fancybox({
	'scrolling'		: 'no',
	'titleShow'		: false,
	'onClosed'		: function() {
		
	}
});
$("#terms_page").fancybox({
	'scrolling'		: 'no',
	'titleShow'		: false,
	'onClosed'		: function() {
		
	}
});
});
</script>-->
<script type="text/javascript" >
$(document).ready(function(){
	$("#fbregbtn").click(function(){
		mesg="";
		flag=true;
		if($("#fbfirstname").val() == '')
		{
			document.getElementById('errorfbfirstname').style.display='';
			flag=false;
		}
		if($("#fblastname").val() == '')
		{
			document.getElementById('errorfblastname').style.display='';
			flag=false;
		}
		if($("#fbemailid").val().length < 1)
		{
			document.getElementById('errorfbemailid').style.display='';
			flag=false;
		}
		if($("#password").val().length < 1)
		{
			document.getElementById('errorpassword').style.display='';
			flag=false;
		}
		if(($("#terms").is(':checked'))==false)
		{
			mesg = "Please check terms and conditions";
			flag=false;
		}
		if(flag == false)
		{
			$("#msg span").html(mesg);
			return false;
		}
	});
});
function restoretxt(id)
{
	if(document.getElementById(id).value=='')
	{
		document.getElementById('error'+id).style.display='none';
		document.getElementById('crct'+id).style.display='none';
	}
}
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
		document.getElementById('crct'+id).style.display='none';
		document.getElementById('error'+id).style.display='';
	}
	else
	{
		var text = document.getElementById(id).value;
		var alphaExp = /^[a-zA-Z]+$/;
		if(text.match(alphaExp))
		{
			document.getElementById('crct'+id).style.display='block';
			document.getElementById('error'+id).style.display='none';
		}
		else
		{
			document.getElementById('error'+id).style.display='block';
		 	document.getElementById('crct'+id).style.display='none';
		}
	}
}
function testfbEmail()
{
	var text = document.getElementById('fbemailid').value;
	if(document.getElementById('fbemailid').value=='')
	{
	    document.getElementById('erroremail').style.display='none';
		document.getElementById('crctemail').style.display='none';
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
								document.getElementById('emailexist').style.display='block';
								document.getElementById('crctfbemailid').style.display='none';
								document.getElementById('errorfbemailid').style.display='none';
							}
							else
							{
								//document.getElementById('fbemailid').className = '';
								document.getElementById('emailexist').style.display='none';
								document.getElementById('crctfbemailid').style.display='block';
								document.getElementById('errorfbemailid').style.display='none';
							}
						 });
							
			});
		}
		else
		{
			document.getElementById('errorfbemailid').style.display='block';
			document.getElementById('crctfbemailid').style.display='none';
		}
	}
}
function fbregInput()
{
	var fname = document.getElementById("fbfirstname").value;
	var lname = document.getElementById("fblastname").value;
	var uname = document.getElementById("fbusername").value;
	var email = document.getElementById("fbemailid").value;
	var pwd = document.getElementById("password").value;
	var e = document.getElementById("country_id3");
	var gender = e.options[e.selectedIndex].value;
	var dob = document.getElementById("fbdob").value;
	var socialid = document.getElementById('socialnetworkid').value;
	var social = document.getElementById('social').value;
	var zip = document.getElementById("fbzipcode").value;
	var frnds = document.getElementById("frnds").value;
	
	//alert("hiiii");
	
	if(($("#terms").is(':checked'))==true)
	{
	//alert(fname+''+email+''+lname+''+pwd+''+zip+''+gender);
	jQuery(function($)
	{
		
		var url='<?php echo Yii::app()->createUrl("/site/getReginfo"); ?>';
		
		$.post(url, { fname:fname,lname:lname,uname:uname,email:email,pwd:pwd,gender:gender,dob:dob,socialid : socialid, social:social,zip:zip,frnds:frnds},
			function(data){
				alert(data);
				if(data == "fb registration success")
				{
					//alert("You Are Reg")
					//http://biziindia.com/pv-development/index.php/servicearea/index
					window.location.href= "http://biziindia.com/finao/index.php";
				}
				else if(data == "frnds redirect")
				{
					//http://biziindia.com/pv-development/index.php/site/networkConnections?displaydata=invitefriend
					window.location.href= "http://biziindia.com/finao/index.php";
				}
				else if(data == "Not an invited user")
				{
					alert("Sorry You Are Not an Invited User");
					//http://biziindia.com/pv-development/index.php
					window.location.href= "http://biziindia.com/finao/index.php";
				}
				else if(data == "You are already subscribed or your account may not be activated")
				{
					alert("You are already subscribed with this email id");
					//http://biziindia.com/pv-development/index.php/educationalPlan/educationalPlans
					window.location.href= "http://biziindia.com/finao/index.php";
				}
				 });
				
	});
	}
	
}
		 	
function submitenter2(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	{
		$("#fbregbtn").trigger('click');
   		return false;
	}
	else
	   	return true;
}
</script>
<div align="center" style="margin-bottom:-4px;"><img src="<?php echo Yii::app()->baseUrl;?>/images/form-top-logo.png" width="170" height="109" alt="FINAO" /></div>
<div id="form_wrapper" class="form_wrapper">
<!-- Start of Registration -->
<form class="register">
<h3>Register</h3>
<div class="column">
<div>
<label>First Name:</label>
<input type="text" name="fbfirstname" id="fbfirstname" title="Enter Your First Name" onBlur="restoretxt(this.id)" onkeypress="validatetxt(event,this.id)" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['fname'];?>"<?php }else{?> value=""<?php }?>/>
<div id="crctfbfirstname" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
</div>
<div id="errorfbfirstname" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
</div>
<span class="error">This is an error</span>
</div>
<div>
<label>Last Name:</label>
<input name="fblastname" id="fblastname" type="text" title="Last Name" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['lname'];?>"<?php }else{?> value=""<?php }?> onBlur="restoretxt(this.id)" onkeypress="validatetxt(event,this.id)"/>
<div id="crctfblastname" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
</div>
<div id="errorfblastname" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
</div>
<span class="error">This is an error</span>
</div>
<div>
<label>Username:</label>
<input name="fbusername" id="fbusername" type="text" title="Last Name" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['uname'];?>"<?php }else{?> value=""<?php }?> onBlur="restoretxt(this.id)" onkeypress="validatetxt(event,this.id)"/>
<div id="crctfbusername" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
</div>
<div id="errorfbusername" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
</div>
<span class="error">This is an error</span>
</div>

<div>
<label>Gender:</label>
<div id="fullgender">
<div id="secondBox" >
<?php echo CHtml::dropDownList('gender', $model, 
  $gender,
  array('empty' => 'Gender','id'=>'country_id3'));?>

 </div>
</div>
<span class="error">This is an error</span>
</div>
</div>
<div class="column">
<div>
<label>Email:</label>
<input name="fbemailid" id="fbemailid" type="text" onChange="testfbEmail()" onBlur="restoretxt(this.id)" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['email'];?>"<?php }else{?> value="" <?php }?>  title="Enter your Email" />
<div id="crctfbemailid" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
</div>
<div id="errorfbemailid" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
</div>
<div id="emailexist" style="display:none">
<p class="error">Email Address Already Exist</p> 	
</div>
</div>
<div>
<label>Password:</label>
<input class="textbox-regfield" type="password" name="password" id="password" onBlur="restoretxt(this.id)" value="" title="Password" />
<div id="errorpassword" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
</div>
<span class="error">This is an error</span>
</div>
<div>
<label>Date of Birth:</label>
<input name="fbdob" id="fbdob" type="text" onBlur="testfbEmail()" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['dob'];?>"<?php }else{?> value="" <?php }?>  title="Enter your DOB" />
<div id="crctfbdob" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
</div>
<div id="errorfbdob" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
</div>
<span class="error">This is an error</span>
</div>
<div>
<label>Zip Code:</label>
<input type="text" id="fbzipcode" maxlength="5" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php echo Yii::app()->session['userinfo']['zip'] ;?>"<?php }else{?> value="" <?php }?>/>
<div id="crctfbzipcode" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
</div>
<div id="errofbzipcode" style="display:none">
<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
</div>
<span class="error">This is an error</span>
</div>
</div>
<div class="bottom">
<div class="terms">
<input type="checkbox" />
<span> I agree to FINAO Nation <a href="#" class="policy">Privacy Policy</a> and <a href="#" class="policy">Terms & Conditions</a></span>
</div>
<input type="button" value="Register" id="fbregbtn" onclick="fbregInput()" />
<a href="#" rel="login" class="linkform">You have an account already? Log in here</a>
<div class="clear"></div>
</div>
<?php if(isset(Yii::app()->session['userinfo'])){?>
	<input type="hidden" id="socialnetworkid" value="<?php echo Yii::app()->session['userinfo']['SocialNetworkID'];?>"/>
	<input type="hidden" id="social" value="<?php echo Yii::app()->session['userinfo']['SocialNetwork'];?>"/>
<?php }else{?>
	<input type="hidden" id="socialnetworkid" value=""/>
	<input type="hidden" id="social" value=""/>
<?php }?>
<?php if(isset($frnds)){?>
	<input type="hidden" value="frnds" id="frnds">
<?php }else{?>
	<input type="hidden" value="notfrnds" id="frnds">
<?php }?>
</form>
<!--End of Registration-->
<!--Start of Login -->
<form class="login active">
<h3>Sign in</h3>
<label class="fb-text">You can also login with your social account</label>
<div class="fb-div">
<a class="fb-btn"> 
<span style="position:relative; left:0; top:10px;"><img src="images/fb-icon.png" alt="" width="14" height="27" /> </span><span> Facebook</span>	
</a>
</div>
<div>
<label>Username:</label>
<input type="text" />
<span class="error">This is an error</span>
</div>
<div>
<label>Password: <a href="#" rel="forgot_password" class="forgot linkform">Forgot your password?</a></label>
<input type="password" />
<span class="error">This is an error</span>
</div>
<div class="bottom">
<div class="remember"><input type="checkbox" /><span>Keep me logged in</span></div>
<input type="button" value="Login"></input>
<a href="#" rel="register" class="linkform">You don't have an account yet? Register here</a>
<div class="clear"></div>
</div>
</form>
<!--End of Login-->
<!--Start of Forgot Password-->
<form class="forgot_password">
<h3>Forgot Password</h3>
<div>
<label>Username or Email:</label>
<input type="text" />
<span class="error">This is an error</span>
</div>
<div class="bottom">
<input type="button" value="Send reminder"></input>
<a href="#" rel="login" class="linkform">Suddenly remebered? Log in here</a>
<a href="#" rel="register" class="linkform">You don't have an account? Register here</a>
<div class="clear"></div>
</div>
</form>
<!--End of Forgot Password -->
</div>
<div class="clear"></div>
<!-- The JavaScript -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
	//the form wrapper (includes all forms)
	var $form_wrapper	= $('#form_wrapper'),
	//the current form is the one with class active
	$currentForm	= $form_wrapper.children('form.active'),
	//the change form links
	$linkform		= $form_wrapper.find('.linkform');
	//get width and height of each form and store them for later						
	$form_wrapper.children('form').each(function(i){
	var $theForm	= $(this);
	//solve the inline display none problem when using fadeIn fadeOut
	if(!$theForm.hasClass('active'))
		$theForm.hide();
		$theForm.data({
		width	: $theForm.width(),
		height	: $theForm.height()
	});
	});
	//set width and height of wrapper (same of current form)
	setWrapperWidth();
	/*
	clicking a link (change form event) in the form
	makes the current form hide.
	The wrapper animates its width and height to the 
	width and height of the new current form.
	After the animation, the new form is shown
	*/
	$linkform.bind('click',function(e){
	var $link	= $(this);
	var target	= $link.attr('rel');
	$currentForm.fadeOut(400,function(){
	//remove class active from current form
	$currentForm.removeClass('active');
	//new current form
	$currentForm= $form_wrapper.children('form.'+target);
	//animate the wrapper
	$form_wrapper.stop()
				 .animate({
					width	: $currentForm.data('width') + 'px',
					height	: $currentForm.data('height') + 'px'
				 },500,function(){
					//new form gets class active
					$currentForm.addClass('active');
					//show the new form
					$currentForm.fadeIn(400);
				 });
	});
	e.preventDefault();
	});
	function setWrapperWidth(){
		$form_wrapper.css({
			width	: $currentForm.data('width') + 'px',
			height	: $currentForm.data('height') + 'px'
		});
	}
	/*
	for the demo we disabled the submit buttons
	if you submit the form, you need to check the 
	which form was submited, and give the class active 
	to the form you want to show
	*/
	$form_wrapper.find('input[type="submit"]')
		 .click(function(e){
			e.preventDefault();
		 });	
});
</script>				