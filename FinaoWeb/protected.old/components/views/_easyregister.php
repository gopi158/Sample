
<input type="hidden" id="utype" name="utype" value="uploader"  />
<input type="hidden" name="type" id="type" value="<?php echo $type;?>" />

<input type="hidden" id="groupid" value="<?php echo $pid ?>" />

<input type="hidden" id="tileid" value="<?php echo $pid ?>"  /> 

<script type="text/javascript">

$(document).ready(function(){
//alert("krishna");
//alert(<?php echo $type;?>);
 

 <?php if( $type  == 'tile')

        {  

            $t = $type;

			$init = 't';

		  

		}else if( $type == 'group')

		{

			$t = $type;

			$init = 'g';

			

		}else if($type == 'video')

		{

			$t = $type;

			$init = 'v';

		}

?>

var name = $("#<?php echo $init; ?>name");

var nameInfo = $("#<?php echo $init; ?>nameInfo");

var email = $("#<?php echo $init; ?>email");

var emailInfo = $("#<?php echo $init; ?>emailInfo");

var pass1 = $("#<?php echo $init; ?>pass1");

var pass1Info = $("#<?php echo $init; ?>pass1Info");

var pass2 = $("#<?php echo $init; ?>pass2");

var pass2Info = $("#<?php echo $init; ?>pass2Info");



$("#forgot-link").fancybox({
 		'scrolling'		: 'no',
 		'titleShow'		: false,
 		'onClosed'		: function() {
 		    	 $("span.forgot-error-msg").empty();
 				 $("#btnsubforgot").show();
 			}
 	});
 
$("#registered_<?php echo $t ?>").fancybox({
 		'scrolling'		: 'no',
 		'titleShow'		: false,
 		'hideOnOverlayClick' : false,
 		'autoScale'           : true,
 		  'fixed': false,
         'resizeOnWindowResize' : false
 	});
 
<?php if($type == 'video')
 {?> 
 	//$("#registered_<?php echo $t; ?>").trigger('click');
 <?php }?>

<?php if($type == 'group')

{?> 

	$("#registered_<?php echo $t; ?>").trigger('click');

<?php }?>
 

//var message = "";
//On blur
 	name.blur(validateName);
 	email.blur(validateEmail);
 	email.blur(checkuseravailable);
 	pass1.blur(validatePass1);
 	pass2.blur(validatePass2);
 	//On key press
 	name.keyup(validateName);
 	pass1.keyup(validatePass1);
 	pass2.keyup(validatePass2);
 	//message.keyup(validateMessage);
     $('#<?php echo $init; ?>register').click(function()
    {

		if(validateEmail() & validatePass1())

		{

			//alert("sucess");

			

			var name = $('#<?php echo $init; ?>name').val();

			var mobile = '';

			var email = $('#<?php echo $init; ?>email').val();

			var tilename = $('#<?php echo $init; ?>tilename').val();

			var password = $('#<?php echo $init; ?>pass1').val(); 

			 //alert(email);

			var finaomsg = $('#finaomsg').val(); 

			var type = $('#type').val();

			var utype = $('#utype').val();

			var url= "<?php echo Yii::app()->createUrl('site/Easylogin'); ?>";

	$.post(url, {type:type,name:name,email:email,mobile:mobile,finaomsg:finaomsg,tilename:tilename,password:password,utype:utype},

			function(data) {

				 //alert(data); 

				 

				 var split = data.split('-');

				 var value =  split[0];

				 var conf = split[1];

				  var utype =  split[2];

				  var vote = split[3]

				 //alert(value);

				 if(value == 'video')

				 {

					 

					

					if(conf != '' )

					{

						 

					var rd ='<?php echo Yii::app()->createUrl("/finao/Viewvideohdcu/confirm/##data2/vote/##data1/utype/##data0"); ?>';

					rd = rd.replace('##data2',conf);

					rd = rd.replace('##data0',utype);

					if(vote == 'true'){vote = vote;}else{vote = 'false';}

		            rd = rd.replace('##data1',vote);

 						 

						window.location=rd;			

					} 

					 

					 

				 

				 }

				 else

				 {

					 if(data == 0)

				 {

					 $('#error_msg').text('Invalid Username/Password');

					 //alert("Enter fields");

				 }else if(data == 1)

				 {

					  $('#error_msg').text('You are already subscribed or your account may not be activated');

				 }

				 else if (data == 3)

				 {

					   $('#error_msg').text('Welcome back, please enter password');

				 }

				 else

				 { 

						var split = data.split('-');

						var value = split[0];

						

						if(value == 2 )

						{

							conf = 'false'; 

							var titlename = split[1];

						}else

						{

							 conf = 'true';

							 var titlename = split[2]; 

						}

						var rd ='<?php echo Yii::app()->createUrl("/finao/Getprofiledetails/tile_name/##data1/confirm/##data2"); ?>';

	                    			rd = rd.replace('##data1',titlename);

									rd = rd.replace('##data2',conf);

									window.location=rd;

				}

				 } 

				  

					 

			});

			

		}else

		{

			//alert("Fails");

		}



	});

 

});





//validation functions

	function validateEmail(){

		//testing regular expression

		

		var email = $("#<?php echo $init; ?>email");

		var a = $("#<?php echo $init; ?>email").val();

		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

		//if it's valid email

		if(filter.test(a)){

			email.removeClass("txtbox-error");

			//emailInfo.text("Valid E-mail please, you will need it to log in!");

			//emailInfo.removeClass("txtbox-error");

			return true;

		}

		//if it's NOT valid

		else{

			email.addClass("txtbox-error");

			email.attr("placeholder", "Type a valid e-mail");

			//emailInfo.text("Stop cowboy! Type a valid e-mail please :P");

			//emailInfo.addClass("txtbox-error");

			return false;

		}

	}

	function validateName(){

		//if it's NOT valid
        name = $("#<?php echo $init; ?>name");
		if(name.val().length < 4){

			name.addClass("txtbox-error");

			name.attr("placeholder", "Name min of 3 Characters");

			//nameInfo.text("We want names with more than 3 letters!");

			//nameInfo.addClass("txtbox-error");

			return false;

		}

		//if it's valid

		else{

			name.removeClass("txtbox-error");

			//nameInfo.text("What's your name?");

			//nameInfo.removeClass("txtbox-error");

			return true;

		}

	}

	 

	function validateMessage(){

		//it's NOT valid

		if(message.val().length < 6){

			message.addClass("multi-line-text-error");

			message.attr("placeholder", "FINAO Min of 6 Characters");

			return false;

		}

		//it's valid

		else{			

			message.removeClass("multi-line-text-error");

			return true;

		}

	}

	

	function validatePass1(){

		var a = $("#<?php echo $init; ?>pass1");

		var b = $("#<?php echo $init; ?>pass2");

        var pass1 = $("#<?php echo $init; ?>pass1");

		//it's NOT valid

		if(pass1.val().length <5){

			pass1.addClass("txtbox-error");

			pass1.attr("placeholder", "Password min of 5 Characters");

			//pass1Info.text("Ey! Remember: At least 5 characters: letters, numbers and '_'");

			//pass1Info.addClass("error");

			return false;

		}

		//it's valid

		else{			

			pass1.removeClass("txtbox-error");

			//pass1Info.text("At least 5 characters: letters, numbers and '_'");

			//pass1Info.removeClass("error");

			//validatePass2();

			return true;

		}

	}

	function validatePass2(){

		var a = $("#<?php echo $init; ?>pass1");

		var b = $("#<?php echo $init; ?>pass2");

		//are NOT valid

		if( a != b  ){

			pass2.addClass("txtbox-error");

			//pass2Info.text("Passwords doesn't match!");

			//pass2Info.addClass("error");

			return false;

		}

		//are valid

		else{

			pass2.removeClass("txtbox-error");

			//pass2Info.text("Confirm password");

			//pass2Info.removeClass("error");

			return true;

		}

	}

	

	function checkuseravailable(){

		

		 var email = $("#<?php echo $init; ?>email").val();

		 var url= "<?php echo Yii::app()->createUrl('site/CheckEmail'); ?>";

	$.post(url, {email:email},

			function(data) { 

				  //alert(data);

				  

				var split = data.split('-');

				var value = split[0];

				var name = split[1];

				  if(value == '1')

				  {

					  //alert('Show password');

					  $('#note<?php echo $init; ?>').html('Welcome back <b>'+name+'</b>, please enter Password');

					  $('#<?php echo $init; ?>register').attr('value','Next'); 

					  $('#showpassword<?php echo $init; ?>').hide();

					  $('#pass1').focus();

					  $('#note2<?php echo $init; ?>').hide();

					  $('#privacy').hide();

					  

					  return true;

				  }else if(value == "2")

				  {

					   //alert('Dont Show password');

					   $('#note<?php echo $init; ?>').html('Thank you for Registering');

					   $('#showpassword<?php echo $init; ?>').show();

					   $('#<?php echo $init; ?>register').attr('value','Register');

					   $('#privacy').show();

					   $('#note2<?php echo $init; ?>').show();

					   $('#forgot-link').hide();

					   

					   return false;

				  }

					 

			});

		 

		 

		 return false;

		

		

		}



function change_va(event)

	{

		var url = '<?php echo Yii::app()->createUrl("finao/badWords"); ?>';

		if(event.keyCode == 32) 

		{

			var valu=$('#finaomsg').val();

			//alert(valu);

			var mySplitResult = valu.split(" ");

			//alert(mySplitResult[mySplitResult.length-1]); 

			var lastWord =  mySplitResult[mySplitResult.length-2];

	//		alert(valu.length);

	//		alert(valu.length-lastWord.length);

			

			$.post(url, { word : lastWord}, function (data){if(data=='yes'){

				if(valu.length-lastWord.length<=1){$('#finaomsg').val('');}

				else {// alert('f'); //var ss=valu.slice(0,lastword.length);

				$('#finaomsg').val($('#finaomsg').val().slice(0,valu.length-lastWord.length-2)); }

				$('#error_msg').html('Bad word');

			}});

			$('#error_msg').html('');	   

		}	

	}

	



function forgotpswd(a)

{ 

  

	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

	var forgotemail = document.getElementById('forgotemail').value;



	if(forgotemail == '')

	{

		$("span.forgot-error-msg").empty();

		$("span.forgot-error-msg").html("<span style='color: red;'>Please Enter Your Mail Id</span>");

        return false;

	}else{

	if(reg.test(forgotemail) == true){

		jQuery(function($){

				var url='/site/forgotpwd';

				$.post(url, { forgotemail:forgotemail,hbcu:a},

				function(data)

			    {

			     if(data == "You Are not activated")

			     {

			      $("span.forgot-error-msg").empty();

			      $("span.forgot-error-msg").html("<span style='color: red;'>You Are Not Activated</span>");

			      return false;

			     }else if(data == "Succesful email"){

			      $("span.forgot-error-msg").empty();

			      $("span.forgot-error-msg").html("<span style='color: red;'>A link to change your password has been sent to your email</span>");

				  $("#btnsubforgot").hide();

			     }

				 else{

		$("span.forgot-error-msg").html("<span style='color: red;'>Please Enter Valid Mail Id</span>");

		return false;

	}

			    });

			});

	}else{

		$("span.forgot-error-msg").empty();

		$("span.forgot-error-msg").html("<span style='color: red;'>Please Enter Valid Mail Id</span>");

		return false;

	}

}



}



	

	

</script>

 

 

<a id="registered_<?php echo $t ?>" href="#registeredcontent<?php echo $t ?>" ></a>

 



<!--Tile Register-->



<!--<div  style="display:none;">



				<div id = "registeredcontenttile">

                	

                    <div class="signin-popup" id="login_form3" style="text-align:center;">

    	<div class="orange font-20px padding-10pixels">What's Your FINAO? <?php echo $resulttileinfo->lookup_name; ?>fsfs</div>

        

        <span id="error_msg" style="color:red; text-align:left; float:left; width:100%; padding-bottom:10px;"></span>

         

         <div class="popup-finao-container">

            <div class="popup-finao-container-left">

            <?php 

			$src1 =   Yii::app()->baseUrl."/images/tiles/academics.jpg"; 

			if($resulttileinfo->lookup_name != '')

			      {

					$src1 =   Yii::app()->baseUrl."/images/tiles/academics.jpg"; 

				  }else

				  {

					  $src1 =   Yii::app()->baseUrl."/images/no-image.jpg"; 

				  }

			?>

            <img width="78" src="<?php echo $src1;?>">

            

            </div>

            <div class="popup-finao-container-right">

                <p><textarea class="multi-line-text" id="finaomsg" placeholder="Enter your FINAO" style="width:290px; height:68px;" maxlength="140" onkeyup="change_va(event)"></textarea></p>

            </div>

        </div>

        

        	<div class="clear"></div>

        

        <div class="padding-10pixels"><input placeholder="Name" id="name" type="text" style="width:95%;" class="txtbox"></div>

        <div class="padding-10pixels"><input placeholder="Email" id="uemail"  type="text" style="width:95%;" class="txtbox"></div> 

         

        <div style="display:none;" id="showpassword" class="padding-10pixels">

        <input placeholder="********" id="password" type="password" style="width:95%;" class="txtbox"></div>

               

        

        <div class="font-12px padding-10pixels" style="color:#343434; text-align:left; line-height:20px;">We respect your privacy. You control what information is shared. Click for our full <a  target="_blank" href="<?php echo Yii::app()->createUrl('profile/privacy'); ?>" class="orange-link1 font-12px">Privacy Statement</a> and <a target="_blank" href="<?php echo Yii::app()->createUrl('profile/terms'); ?>" class="orange-link1 font-12px">Terms and conditions</a></div> 

               

        <div style="padding-top:10px;" class="padding-10pixels">

        <input type="hidden" id="tilename" value="<?php echo $_REQUEST['tile']; ?>" />

        <input type="button" id="easysubmit" value="Submit" class="orange-button">

        </div>        

	</div>

                    

                    

                    



				</div>



				</div>--> 

                

<!--Group Register-->

   



<!--Video Register-->

<div style="width:auto;height:auto;overflow: hidden;position:relative; display:none;">







    <div id="forgot_form" class="forgot-password">







    	<p>Enter your Email Address to get your password:</p>







		<span class="forgot-error-msg"></span>







		<!--<span class="forgot-error-msg1"></span>







		<span class="forgot-error-msg2"></span>







		<span class="forgot-error-msg3"></span>-->







       	<p style="margin-left: 83px;"><input type="text" class="textbox" id ="forgotemail"style="width:70%" onfocus="$('span.forgot-error-msg').empty();" onkeypress="return forgotsubmit(this,event);"/></p>







        <p><input type="button" value="Submit" id="btnsubforgot" class="orange-button" onclick = "forgotpswd('<?php echo $hbcu;?>')"/></p>







		<!--<p><a href="#changepswd_form" class="orange-button"/>changepswd</a></p>-->







    </div>







</div>

<div  style="display:none;">



				<div id="registeredcontentvideo">



<div id="login_form2" class="signin-popup">

     <div class="orange font-16px padding-10pixels" id="notev">Welcome to FINAO Nation</div>

     

     <div id="note2v" style="color:#343434; text-align:left; line-height:20px;" class="font-12px padding-10pixels">

          We are asking you to Sign In / Register so this contest can remain a protected environment. Your information will be used for access to finaonation.com and will not be shared with any third party.

          </div>

        <!--<form id="customForm">-->

        <div id="log-msgerror" style="color:#F00; margin-bottom:5px;"></div>

       

       <div id="error_msg" style="color:red; padding:5px;"></div>

        <div class="padding-10pixels">

        <input type="text" id="vemail" name="vemail" class="txtbox" style="width:97%;" placeholder="Sign-in or Register with email address" />

        <span id="emailInfo"></span>

        </div>

        <div class="padding-10pixels">

        <input type="password" name="vpass1" onkeypress="return submit1(this,event);" id="vpass1" class="txtbox" placeholder="Password" style="width:97%;"  />

        <span id="pass1Info"></span>

        </div>

        <div id="showpasswordv" style="display:none;">

         

        <div class="padding-10pixels">

       <input type="text" class="txtbox" style="width:97%;" placeholder="Name" id="vname">

       </div>

       </div>

       <div id="privacy" style="display:none;"> 

        <div style="color:#343434; text-align:left; line-height:20px;" class="font-12px padding-10pixels">We respect your privacy. You control what information is shared. Click for our full <a class="orange-link1 font-12px" href="/site/privacy" target="_blank">Privacy Statement</a> and <a class="orange-link1 font-12px" href="/site/terms" target="_blank">Terms and conditions</a></div>

        

          

       </div>

        <div class="padding-10pixels">

        <span class="left font-12px">

       <!-- <input id="remcheckbox" type="checkbox" /> Keep me signed in--></span> 

        <span class="right">

        <input type="button" id="vregister" class="orange-button" value="Next" />

        </span>

		<a style="margin-right:20px;" class="orange-link font-12px" href="#forgot_form" id="forgot-link">Forgot Password?</a>

        </div>

        

        

         <div class="padding-10pixels">

       

        </div>

        <div class="clear"></div>

        <div class="padding-10pixels" style="padding-top:10px;">

        </div>

        

        <!-- </form>-->

 </div> 

 

 </div>

 

 </div>            

<script type="text/javascript">

function submit1(myfield,e)

	{

		var keycode;

		if (window.event) keycode = window.event.keyCode;

		else if (e) keycode = e.which;

		else return true;

		if (keycode == 13)

		{

		  $("#vregister").trigger('click');

		  return false;

		}

		else

		  return true;

		

	}

	

</script>

