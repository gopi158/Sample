   

<style>
img.bg {
	/* Set rules to fill background */
	min-height: 100%; min-width: 1024px; z-index:-1;
			
	/* Set up proportionate scaling */
	width: 100%; height: auto;
			
	/* Set up positioning */
	position:fixed; top: 0; left: 0;}
		
	@media screen and (max-width: 1024px){
		img.bg {left: 50%; margin-left: -512px; }
	}
</style>
<a id="registered1" href="#registeredcontent1" ></a>

<div  style="display:none;">

				<div id = "registeredcontent1">
                	
                    <div class="signin-popup" id="login_form3" style="text-align:center;">
    	              <span class="orange font-20px padding-10pixels">Thank you for Joining the FINAO Nation</span><br />
                     Please set your password by clicking on the confirmation mail sent to your email within next 24 Hours.   
                    </div>
               
                </div>    
</div>

<div style="display:none;">    
	<div class="hbcu-create-popup" id="login_form">
    	<div class="create-story-hdline orange">Create Your Story</div>
        <div class="create-story-content">
        	<div class="create-story-content-left">
            	<p>Write it, film it, and upload it.</p>
                <p style="font-size:13px;">(recommended 15 to 60 seconds),</p>
                <p>write your story, include photos.</p>
                <p>Whatever you want to use to tell your <span class="orange">FINAO</span> story.</p>
            	<p class="bolder">You can upload video, <?php echo $this->cdnurl; ?>/images, or text to tell us about your <span class="orange">FINAO.</span></p>
            </div>
            <div class="create-story-content-right">
            	<iframe width="250" height="156" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=mini&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0&amp;wmode=transparent" id="viddler-bb13af7"></iframe>
            </div>
        </div>
	</div>    	
</div>

<div style="display:none;">    
	<div class="signin-popup" id="login_form3">
    	<div style="text-align:left;" class="orange font-14px padding-10pixels">Enter your Email Addres</div>
        <div class="padding-10pixels"><input type="text" class="txtbox" style="width:90%;" value="Email" /></div>
        <!--<div class="padding-10pixels"><input type="password" class="txtbox" style="width:90%;" value="Password" /></div>
        <div class="padding-10pixels left" style="width:100%;"><span class="left font-12px"><input type="checkbox" /> Keep me signed in</span> <span class="right"><a href="#" class="orange-link font-12px">Forgot Password?</a></span></div>
        <div class="clear"></div>
        <div class="font-12px padding-10pixels" style="color:#343434; text-align:left; line-height:20px;">We respect your privacy. You control what information is shared. Click for our full <a href="#" class="orange-link1 font-12px">Privacy Statement</a> and <a href="#" class="orange-link1 font-12px">Terms and conditions</a></div>
        <div class="padding-10pixels" style="padding-top:10px;"><input type="button" class="orange-button" value="Sign In" /></div>-->
    	<div class="popup-or-image"><img src="<?php echo $this->cdnurl; ?>/images/or-image.jpg" width="380" /></div>
    	<div class="popup-signin-facebook"><img src="<?php echo $this->cdnurl; ?>/images/signinwithfacebook.png" width="250" /></div>
	</div>    	
</div>
 
<div class="hbcu-pages-wrapper">
    <div id="hbcu-middle-container">
        <div id="hbcu-promo-container">
            <div class="hbcu-splash-banner">
            	<img width="1000" src="<?php echo $this->cdnurl; ?>/images/header-banner.jpg">
                
                <div class="hbch-home-buttons-enter">
                   <a href="<?php echo Yii::app()->createUrl('finao/Learnmore');?>">
                    <img class="hbcu-enter-btn"  width="190" src="<?php echo $this->cdnurl; ?>/images/enterContest1.png">
                    </a>
                     
                </div>
            </div>
        </div>
    </div>
</div>
 
<script type="text/javascript">

<?php 
 if(!empty($confirm) and $confirm == 'true'){?> 
$("#registered1").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,
		'hideOnOverlayClick' : false,
		'autoScale'           : true,
		  'fixed': false,
         'resizeOnWindowResize' : false
	});
	
$("#registered1").trigger('click');	
 
<?php }?>


function fireClick()
{
  //alert("Hello");
 <?php $type = 'video'; ?>
 $("#registered_video").trigger('click');
  
 
}

function goURl(page)
{
	
	 
	if(page == 'home')
	{
		//alert(page);
		var rd ='<?php echo Yii::app()->createUrl("/myhome"); ?>';
		window.location=rd;
	}else if(page == 'search')
	{
		var rd ='<?php echo Yii::app()->createUrl("/finao/Getcontestdetails/tile/HBCU+connect"); ?>';
	                    			 
									 
									window.location=rd;
	}
	else
	{
		//alert(page);
		var rd ='<?php echo Yii::app()->createUrl("finao/Videocontest"); ?>';
		window.location=rd;
	}
}






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

</script>

<?php   $this->widget('EasyRegister',array('type'=> $type,'pid'=>'65')); ?>



<a href="#changepswd_form" id="changepswd-link" style="display:none;">change password </a>




<?php  if(isset($this->popup)){



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
					

 

