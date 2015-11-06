<script  type="text/javascript">
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
</script>
<script type="text/javascript" >
 $(document).ready(function(){
	
 $("#fbregbtn").click(function(){
	
		mesg="";
	    flag=true;
	
		if($("#fbemailid").val().length < 1)
		{
			document.getElementById('erroremail').style.display='';
			//mesg += "Please give an email<br>";
			flag=false;
		}
		/*if($("#fbzipcode").val().length < 1)
		{
			document.getElementById('errorzip').style.display='';
			//mesg += "Please enter Zip Code";
			flag=false;
		}*/
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
function restorefbFname()
{
	if(document.getElementById('fbfirstname').value=='')
	{
		document.getElementById('errorfname').style.display='none';
		document.getElementById('crctfname').style.display='none';
	}
}
function testingfbfname(winEvent)
{
	//alert("hiiii");
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
	if(
		key == 9 ||
		key == 46 ||
		(key >= 37 && key <= 40) ||
		(key >= 48 && key <= 57)
	  )
	{
		document.getElementById('crctfname').style.display='none';
		document.getElementById('errorfname').style.display='';
	}
	else
	{
		var text = document.getElementById('fbfirstname').value;
		var alphaExp = /^[a-zA-Z]+$/;
		if(text.match(alphaExp) && text.length>=3)
		{
			document.getElementById('crctfname').style.display='block';
			document.getElementById('errorfname').style.display='none';
		}
		else
		{
			document.getElementById('errorfname').style.display='block';
		 	document.getElementById('crctfname').style.display='none';
		}
	}
}
function restorefbLname()
{
	if(document.getElementById('fblastname').value=='')
	{
		document.getElementById('errorlname').style.display='none';
		document.getElementById('crctlname').style.display='none';
	}
}
function testinglname(winEvent)
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
	if(
		key == 9 ||
		key == 46 ||
		(key >= 37 && key <= 40) ||
		(key >= 48 && key <= 57)
	   )
	{
		document.getElementById('crctlname').style.display='none';
		document.getElementById('errorlname').style.display='';
	}
	else
	{
		var text = document.getElementById('fblastname').value;
		var alphaExp = /^[a-zA-Z]+$/;
		if(text.match(alphaExp))
		{
			document.getElementById('crctlname').style.display='block';
			document.getElementById('errorlname').style.display='none';
		}
		else
		{
			document.getElementById('errorlname').style.display='block';
		 	document.getElementById('crctlname').style.display='none';
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
											//document.getElementById('fbemailid').className = 'validation-no';
											document.getElementById('emailexist').style.display='block';
											document.getElementById('crctemail').style.display='none';
											document.getElementById('erroremail').style.display='none';
										}
										else
										{
											//document.getElementById('fbemailid').className = '';
											document.getElementById('emailexist').style.display='none';
											document.getElementById('crctemail').style.display='block';
											document.getElementById('erroremail').style.display='none';
										}
									 });
										
						});
		}
		else
		{
			document.getElementById('erroremail').style.display='block';
			document.getElementById('crctemail').style.display='none';
		}
	}
}
function fbregInput()
{
	//alert("hiiii");
	var fname = document.getElementById("fbfirstname").value;
	var email = document.getElementById("fbemailid").value;
	var lname = document.getElementById("fblastname").value;
	var pwd = document.getElementById("password").value;
	var zip = document.getElementById("fbzipcode").value;
	var frnds = document.getElementById("frnds").value;
	var e = document.getElementById("country_id3");
	var gender = e.options[e.selectedIndex].value;
	if(($("#terms").is(':checked'))==true)
	{
		//alert(fname+''+email+''+lname+''+pwd+''+zip+''+gender);
	jQuery(function($)
	{
		
		var url='<?php echo Yii::app()->createUrl("/site/getReginfo"); ?>';
		
		$.post(url, { fname:fname ,email:email,lname:lname,pwd:pwd,zip:zip,gender:gender,frnds:frnds},
			function(data){
				//alert(data);
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

<div style="display:none;">
<div id="privacy" class="login-popupbox">
<p class="run-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
</div>
</div>
<div style="display:none;">
<div id="termscnds" class="login-popupbox">
<p class="run-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
</div>
</div>
<!-- Added on 10-1-13 to redirect the page to home page when click on cancel in fb login page-->
<?php if(isset(Yii::app()->session['userinfo'])){
//['email']||isset(Yii::app()->session['userinfo']['fname'])
//print_r(Yii::app()->session['userinfo']);
?>
<div class="middle-content">
	<div class="facebook-form">
       	<h1 class="page-headline">START HERE</h1>
    		<div class="facebook-fields">
            	<div class="fb-fields-left">
				<?php 
				if(isset(Yii::app()->session['changepic'])){?>
				<img src="<?php echo Yii::app()->session['changepic']['photourl'];?>" />
				<?php }elseif(isset(Yii::app()->session['userinfo'])){?>
				<img src="<?php echo Yii::app()->session['userinfo']['photourl'];?>"/>
				<?php }else{?>
				<img src="<?php echo Yii::app()->baseUrl;?>/images/default-photo.png" class="border" />
				<?php }?>
				</div>
                    <div class="fb-fields-right contact_form">
						<div id="msg">
						<span style="color:red"></span>
						</div>
						<?php if(isset($frnds)){?>
						<input type="hidden" value="frnds" id="frnds">
						<?php }else{?>
						<input type="hidden" value="notfrnds" id="frnds">
						<?php }?>
                    	<fieldset>
                        	<label>First Name:</label>
                            <div>
							<input type="text" name="fbfirstname" id="fbfirstname" title="Enter Your First Name" onBlur="restorefbFname()" onkeypress="testingfbfname(event)" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php print_r(Yii::app()->session['userinfo']['fname']) ;?>"<?php }else{?> value=""<?php }?>/>
							</div>
							<div id="crctfname" style="display:none">
								<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
							</div>
							<div id="errorfname" style="display:none">
							<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
							</div>
                        </fieldset>
                        <fieldset>
                        	<label>Last Name:</label>
                            <div>
							<input name="fblastname" id="fblastname" type="text" title="Last Name" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php print_r(Yii::app()->session['userinfo']['lname']) ;?>"<?php }else{?> value=""<?php }?> onkeypress="testinglname(event)" onBlur="restorefbLname()"/>
							</div>
							<div id="crctlname" style="display:none">
							<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
							</div>
							<div id="errorlname" style="display:none">
							<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
							</div>
                        </fieldset>
                        <fieldset>
                        	<label>Email:</label>
                            <div>
							<input name="fbemailid" id="fbemailid" type="text" onBlur="testfbEmail()" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php print_r(Yii::app()->session['userinfo']['email']) ;?>"<?php }else{?> value="" <?php }?>  title="Enter your Email" />
							</div>
							<div id="crctemail" style="display:none">
							<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
							</div>
							<div id="erroremail" style="display:none">
							<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
							</div>
							<div id="emailexist" style="display:none">
							<p class="error-message">Email Address Already Exist</p> 	
							</div>
                        </fieldset>
						<input type="hidden" id="password" value="password" />
                        <fieldset>
                        	<label>Gender:</label>
							<div id="fullgender">
							<div id="secondBox" >
							<?php echo CHtml::dropDownList('gender', $model, 
				              $gender,
				              array('empty' => 'Gender','id'=>'country_id3'));?>
				           
					         </div>
							</div>
                        </fieldset>
                        <fieldset>
                        	<label>Location:</label>
                            <div><input type="textarea" id="fblocation" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php print_r(Yii::app()->session['userinfo']['country'].''.Yii::app()->session['userinfo']['region'].''.Yii::app()->session['userinfo']['city']) ;?>"<?php }else{?> value="" <?php }?>/></div>
                        </fieldset>
                        <fieldset>
                        	<label>Age:</label>
                            <div><input type="text" id="fbage" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php print_r(Yii::app()->session['userinfo']['age']) ;?>"<?php }else{?> value="" <?php }?>/></div>
                        </fieldset>
                        <fieldset>
                        	<label>ZIP Code:</label>
                            <div><input type="text" id="fbzipcode" maxlength="5" <?php if(isset(Yii::app()->session['userinfo'])){?>value="<?php print_r(Yii::app()->session['userinfo']['zip']) ;?>"<?php }else{?> value="" <?php }?>/></div>
							<div id="crctzip" style="display:none">
							<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-yes.png" class="validation-padding" />
							</div>
							<div id="errorzip" style="display:none">
							<img src="<?php echo Yii::app()->baseUrl;?>/images/validation-no.png" class="validation-padding" />
							</div>
                        </fieldset>
                        <fieldset>
                        	<label>&nbsp;</label>
                            <div><input type="checkbox" class="checkbox" id="terms"/> <span class="agreed-padding">I agree to ParentValet <a href="#privacy" id="privacy_page" class="orange-link">Privacy Policy</a> and <a id="terms_page" href="#termscnds" class="orange-link">Terms &amp; Conditions</a></span></div>
                        </fieldset>
                    </div>
                    <div class="btn-padding"><input type="button" value="CREATE ACCOUNT" class="blue-button" id="fbregbtn" onclick="fbregInput()"/></div>
                	<!--<div class="contact_form">
                    	First Name: <input type="text"  /> <img src="images/validation-yes.png" />
                    </div>-->
                </div>
            </div>
        </div>
<?php } else {
$this->redirect(array('/'));
}
?>