<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>FINAO NATION</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Styles -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/Fonts/barkentina/stylesheet.css" type="text/css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="<?php echo $this->cdnurl; ?>/css/default.css" rel="stylesheet">
<link href="<?php echo $this->cdnurl; ?>/css/home.css" rel="stylesheet">
<link href="<?php echo $this->cdnurl; ?>/css/responsive.css" rel="stylesheet">
<link href="<?php echo $this->cdnurl; ?>/css/coming-soon-mobile.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!------ Banner Slideshow Script ---------->
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/demo.css">
<script src="<?php echo $this->cdnurl; ?>/javascript/responsiveslides.min.js"></script>
<script>
    // You can also use "$(window).load(function() {"
    $(function () {
      // Slideshow 4
      $("#slider4").responsiveSlides({
        auto: true,
        pager: false,
        nav: false,
        speed: 800,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
      });

    });
  </script>
<!------ Banner Slideshow Script ---------->

<!-- Slider Kit styles -->
<!--<script type="text/javascript" src="javascript/jquery.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/javascript/sliderkit/lib/css/sliderkit-demos.css" media="screen, projection" />
<!-- jQuery Plugin scripts -->
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/sliderkit/lib/js/external/jquery.easing.1.3.min.js"></script>
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/sliderkit/lib/js/external/jquery.mousewheel.min.js"></script>
<!-- Slider Kit scripts -->
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/sliderkit/lib/js/sliderkit/jquery.sliderkit.1.9.2.pack.js"></script>	
<script type="text/javascript">
	$(window).load(function(){ //$(window).load() must be used instead of $(document).ready() because of Webkit compatibility				
		// Carousel > Demo #2
		$(".carousel-demo2").sliderkit({
			shownavitems:3,
			scroll:1,
			mousewheel:true,
			circular:false,
			start:2
		});
	});	
</script>
<!-- Slider Kit styles -->

<!-- Popup Box Start -->
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/fancybox-1.3.4/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/javascript/fancybox-1.3.4/jquery.fancybox.css" media="screen">

<script  type="text/javascript">
$(document).ready(function() {
$("#form-page").fancybox({
	'scrolling' : 'no',
	'titleShow' : false,
	'fixed': false
});
 
 $("#registeredpromo").fancybox({
		'scrolling'		: 'no',
 		'titleShow'		: false,
 		'hideOnOverlayClick' : false,
 		'autoScale'           : true,
 		  'fixed': false,
         'resizeOnWindowResize' : false
	});
 
  $("#registeredpromopad").fancybox({
		'scrolling'		: 'no',
 		'titleShow'		: false,
 		'hideOnOverlayClick' : false,
 		'autoScale'           : true,
 		  'fixed': false,
         'resizeOnWindowResize' : false
	});
 
 
 
  $("#getstarted").fancybox({
		'scrolling'		: 'no',
 		'titleShow'		: false,
 		'hideOnOverlayClick' : false,
 		'autoScale'           : true,
 		  'fixed': false,
         'resizeOnWindowResize' : false
	});
  
  
  
  

});
function submitreginfo(myfield,e)
	 {
		var keycode;
		if (window.event) keycode = window.event.keyCode;
		else if (e) keycode = e.which;
		else return true;
		if (keycode == 13)
		{
			$("#registerform").trigger('click');
			return false;
		}
		else
			return true;
	 
	 } 
</script>

<script  type="text/javascript">
$(document).ready(function() {
$("#form-page2").fancybox({
	'scrolling' : 'no',
	'titleShow' : false,
	'fixed': false
});


	
	$("#register").trigger('click');
	
	$('.fancybox').fancybox({
     'closeClick'  : true,
	 'scrolling'   : 'no',
	'titleShow'	   : false,
	});
	
	
	
	
	
	//global vars
	// var form = $("#customForm");
	var name = $("#ename");
	var nameInfo = $("#nameInfo");
	var email1 = $("#pemail");
	var emailInfo = $("#emailInfo");
	var pass1 = $("#pass1");
	var pass1Info = $("#pass1Info");
	var pass2 = $("#pass2");
	var pass2Info = $("#pass2Info");
	var message = $("#message");
	var phone = $("#phone");
	var phoneInfo = $("#phoneInfo");
	
	var jmail = $("#joinmail");
	var jmailInfo = $("#jmailInfo");
	
	//On blur
	name.blur(validateName);
	email1.blur(validateEmail);
	pass1.blur(validatePass1);
	pass2.blur(validatePass2);
	phone.blur(validatePhone);
	jmail.blur(validateEmail);
	//On key press
	name.keyup(validateName);
	pass1.keyup(validatePass1);
	pass2.keyup(validatePass2);
	message.keyup(validateMessage);
	phone.keyup(validatePhone);
	//On Submitting
	$('#registerform').click(function(){
		  
		 
		var isChecked = $('#remcheckbox').is(':checked');
		if(isChecked)
		{
		var remember = true;
		}
		else
		{
		var remember = false;
		}
		
		 var uname = document.getElementById("pemail").value;
 		 var pwd = document.getElementById("pass1").value;
		 var url 	= '<?php echo Yii::app()->createUrl("/site/login"); ?>';
		
		 if(validateEmail() & validatePass1() || validateName() )
			
			magelogin(uname,pwd,remember)
		else
			return false;
	});
	
			function setCookie(c_name,value,exdays)
			{
			var exdate=new Date();
			exdate.setDate(exdate.getDate() + exdays);
			var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
			document.cookie=c_name + "=" + c_value;
			}
	function magelogin(uname,pwd,remember)
			{
			
			/*jQuery(function($){
			//alert(remember);
			var url 	= '<?php echo Yii::app()->baseUrl;?>/loginmage.php'; 
			$.post(url, { uname:uname ,pwd:pwd},
			function(data)
			{
			//alert(data); 
			setCookie('SID',data,1);
			yiilogin(uname,pwd,remember);
			});
			
			});*/
			
			yiilogin(uname,pwd,remember);
			
			}
		function yiilogin(uname,pwd,remember)
		{
		
		jQuery(function($){ 
		
			//alert(remember);
		
			var url 	= '<?php echo Yii::app()->createUrl("/site/Easylogin"); ?>';
		    var type    = 'easy';
			var name    =  $('#ename').val();
			$.post(url, { email:uname ,password:pwd, remember:remember,type:type,name:name},
		
			function(data)
 			{
				
				var split = data.split('-');
				var value =  split[0];
				var conf = split[1];
				if(value == 'easy')
				{
					if(conf == 'true' )
 					{
 					var rd ='<?php echo Yii::app()->createUrl("/profile/profilelanding/edit/1/confirm/##data2/"); ?>';
 					rd = rd.replace('##data2',conf);
 					 
 					window.location=rd;			

					}else
					{
						
						var rd ='<?php echo Yii::app()->createUrl("/finao/MotivationMesg/confirm/##data2/"); ?>';
 					rd = rd.replace('##data2',conf);
 					 
 					window.location=rd;	
					}
				}
				else{
					   

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
				 else if(data == 22)
				 {
					 $('#ename').addClass('txtbox-error');
					 $('#error_msg').text('Please Enter Name');
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
		
		});
		
		}
	
	//validation functions
	function validateEmail(){
		//testing regular expression
		var a = $("#pemail").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		//if it's valid email
		if(filter.test(a)){
			email1.removeClass("txtbox-error");
			 
			emailInfo.removeClass("error");
			checkuseravailable();
			return true;
		}
		//if it's NOT valid
		else{
			email1.addClass("txtbox-error");
			/*emailInfo.html("<p style='color:red;'>Type a valid e-mail please</p>");
			emailInfo.addClass("error");*/
			return false;
		}
	}
	
	function validatePhone()
	{
		var a = $("#phone").val();
		
		//Match Cases Matches
        //9836193498 +919836193498 9745622222
		var filter = /^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1}){0,1}9[0-9](\s){0,1}(\-){0,1}(\s){0,1}[1-9]{1}[0-9]{7}$/;
		
		//if it's valid Number
		if(filter.test(a)){
			phone.removeClass("error");
			phoneInfo.text("Valid Phone Number Buddy");
			phoneInfo.removeClass("error");
			return true;
		}
		//if it's NOT valid
		else{
			phone.addClass("error");
			phoneInfo.text("Type a valid Phone please :P");
			phoneInfo.addClass("error");
			return false;
		}
	    
	}
	function validateName(){
		//if it's NOT valid
		if(name.val().length < 4){
			name.addClass("txtbox-error");
			nameInfo.text("We want names with more than 3 letters!");
			nameInfo.addClass("txtbox-error");
			return false;
		}
		//if it's valid
		else{
			name.removeClass("error");
			nameInfo.text("What's your name?");
			nameInfo.removeClass("error");
			return true;
		}
	}
	function validatePass1(){
		var a = $("#pass1");
		var b = $("#password2");

		//alert(pass1.val().length);
		if(pass1.val().length == ''){
			pass1.addClass("txtbox-error");
			/*pass1Info.html("<p style='color:red;'>Please Enter Password</p>");
			pass1Info.addClass("error");*/
			return false;
		}
		//it's NOT valid
		else if(pass1.val().length <5){
			pass1.addClass("txtbox-error");
			/*pass1Info.html("<p style='color:red;'>Ey! Remember: At least 5 characters:</p>");
			pass1Info.addClass("error");*/
			return false;
		}
		//it's valid
		else{			
			pass1.removeClass("txtbox-error");
			/*pass1Info.html("<p style='color:green;'>Perfect..!</p>");
			pass1Info.removeClass("error");*/
			//validatePass2();
			return true;
		}
	}
	function validatePass2(){
		var a = $("#password1");
		var b = $("#password2");
		//are NOT valid
		if( pass1.val() != pass2.val() ){
			pass2.addClass("error");
			pass2Info.text("Passwords doesn't match!");
			pass2Info.addClass("error");
			return false;
		}
		//are valid
		else{
			pass2.removeClass("error");
			pass2Info.text("Confirm password");
			pass2Info.removeClass("error");
			return true;
		}
	}
	function validateMessage(){
		//it's NOT valid
		if(message.val().length < 10){
			message.addClass("error");
			return false;
		}
		//it's valid
		else{			
			message.removeClass("error");
			return true;
		}
	}
	
	
	$('#joinb').click(function(){
		if(validateEmail1())
		{
			return true;
		}else
		{
			return false;
		}
		});
	
	function validateEmail1(){
		//testing regular expression
		var jemail = $("#joinemail");
		var jemailInfo = $("#jemailInfo");
		var a = $("#joinemail").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		//if it's valid email
		if(filter.test(a)){
			jemail.removeClass("txtbox-error");
			/*jemailInfo.html("<p style='color:green;'>Valid E-mail please, you will need it to Contact!</p>");*/
			jemailInfo.removeClass("error");
			return true;
		}
		//if it's NOT valid
		else{
			jemail.addClass("txtbox-error");
			/*jemailInfo.html("<p style='color:red;'>Type a valid e-mail please</p>");
			jemailInfo.addClass("error");*/
			return false;
		}
	}
	
	
	
	
	
	

});
</script>

<script  type="text/javascript">
$(document).ready(function() {
$("#form-page3").fancybox({
	'scrolling' : 'no',
	'titleShow' : false,
	'fixed': false
});

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

});
</script>
<!-- Popup Box End --> 
<?php include('analytics.php')?>

</head>

<body>
<a id="reg-link" href="#reg_form" ></a>
<div style="display:none;">    
	<div id="login_form" class="signin-popup">
    	<div class="orange font-25px padding-10pixels">Welcome to the Group</div>
        <div class="popup-finao-container">
            <div class="popup-finao-container-left"><img src="<?php echo $this->cdnurl; ?>/images/no-image.jpg" width="78" /></div>
            <div class="popup-finao-container-right">
            	<p class="font-16px" style="color:#f57b20; padding-bottom:5px;">Group Name</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been..</p>
            </div>
        </div>
        <div class="clear"></div>
        <div class="padding-10pixels"><input type="text" class="txtbox" style="width:95%;" value="Name" /></div>
        <div class="padding-10pixels"><input type="text" class="txtbox" style="width:95%;" value="Signin or Register with email address" /></div> 
        <!--<div class="padding-10pixels" style="text-align:left;"><a href="#" class="orange-link1 font-12px">Click on your email to set your password.</a></div>-->
        <div class="font-12px padding-10pixels" style="color:#343434; text-align:left; line-height:20px;">We respect your privacy. You control what information is shared. Click for our full <a href="#" class="orange-link1 font-12px">Privacy Statement</a> and <a href="#" class="orange-link1 font-12px">Terms and conditions</a></div>  
        <div class="padding-10pixels"><input type="button" class="orange-button" value="Submit" /></div>
          
        <div class="font-12px" style="color:#343434;">Or</div>
        <div class="padding-10pixels"><img src="<?php echo $this->cdnurl; ?>/images/signinwithfacebook.png" width="220" /></div> 
	</div>    	
</div>

<div style="display:none;">    
	<div id="login_form2" class="signin-popup">
    	<div class="orange font-25px padding-10pixels amarnath-font">Explore your friend’s FINAO</div>
        <div><a href="invite-facebook-friends.html"><img src="<?php echo $this->cdnurl; ?>/images/inviteFBfriends.png" width="250" /></a></div>        
	</div>    	
</div>

<div style="display:none;">    
	<div id="login_form3" class="signin-popup">
    	<div class="orange font-14px padding-10pixels" style="text-align:left;">Enter your Email Addres</div>
        <div class="padding-10pixels"><input type="text" class="txtbox" style="width:90%;" value="Email" /></div>
        <!--<div class="padding-10pixels"><input type="password" class="txtbox" style="width:90%;" value="Password" /></div>
        <div class="padding-10pixels left" style="width:100%;"><span class="left font-12px"><input type="checkbox" /> Keep me signed in</span> <span class="right"><a href="#" class="orange-link font-12px">Forgot Password?</a></span></div>
        <div class="clear"></div>
        <div class="font-12px padding-10pixels" style="color:#343434; text-align:left; line-height:20px;">We respect your privacy. You control what information is shared. Click for our full <a href="#" class="orange-link1 font-12px">Privacy Statement</a> and <a href="#" class="orange-link1 font-12px">Terms and conditions</a></div>
        <div class="padding-10pixels" style="padding-top:10px;"><input type="button" class="orange-button" value="Sign In" /></div>-->
    	<div class="popup-or-image"><img src="<?php echo $this->cdnurl; ?>/images/or-image.jpg" width="240" /></div>
    	<div class="popup-signin-facebook"><img src="<?php echo $this->cdnurl; ?>/images/signinwithfacebook.png" width="250" /></div>
	</div>    	
</div>

    
    	<div id="top-header">
        	<div id="top-header-left"><a href="/home"><img src="<?php echo $this->cdnurl; ?>/images/logo.png" ></a></div>
            <div class="navbar"><a id="registeredpromopad" href="#registeredpromocontent">LOGIN / REGISTER</a></div>
            <div id="top-header-right"> 
                <!--<a href="#" class="right"><img src="<?php echo $this->cdnurl; ?>/images/signinwithfacebook.png" width="200" /></a>
            	<span class="orange right" style="margin-top:15px; margin-right:5px;">Or</span>   -->        	
               <!-- <a id="form-page3" href="#login_form3" class="white-link font-16px right">LOGIN / REGISTER</a>-->
                <a id="registeredpromo" class="white-link font-16px right" href="#registeredpromocontent" >LOGIN / REGISTER</a>
            </div>
        </div>
        <div id="carousal-banner">
        	<div class="callbacks_container">
              <ul class="rslides" id="slider4">
                <li>
                  <img src="<?php echo $this->cdnurl; ?>/images/header.png" alt="">
                  <!--<p class="caption">This is a caption</p>-->
                </li>
                <!--<li>
                  <img src="<?php echo $this->cdnurl; ?>/images/banner2.jpg" alt="">
                </li>
                <li>
                  <img src="<?php echo $this->cdnurl; ?>/images/banner3.jpg" alt="">
                </li>-->
              </ul>
            </div>
        </div>
        <div style="clear:both"></div>
  <div id="main-wrapper">
        <div id="featured-finaos">
            <div class="featured-finaos-container">
                <div class="feat-finao-hdline">
                    <span class="left orange">Explore FINAO</span>
                    <!--<span class="right"><a id="form-page2" href="#login_form2" class="orange-link font-25px">Explore your friend’s FINAO</a></span>-->
                </div>
                <div class="featured-finaos-pad">
                
                	<div class="feat-finao-box">
                      <a href="/finao/motivationmesg/frndid/192" title="Tanner Krenz" >
                        <div class="feat-finao-image"><img src="<?php echo $this->cdnurl; ?>/images/tanner.jpg" width="100" /></div>
                        <div class="feat-finao-text">Have a positive impact on my high school</div></a>
                    </div>
                    <div class="feat-finao-box feat-finao-box-alt">
                      <a href="/finao/motivationmesg/frndid/597" title="Jeremy Taiwo" >
                        <div class="feat-finao-image"><img src="<?php echo $this->cdnurl; ?>/images/jermey.jpg" width="100" /></div>
                        <div class="feat-finao-text">I will eat healthy and discover the best foods to eat to maintain a high level of fitness.</div>
                        </a>
                    </div>
                    <div class="feat-finao-box">
                       <a href="/finao/motivationmesg/frndid/115" title="Lacey Greene" >
                        <div class="feat-finao-image"><img src="<?php echo $this->cdnurl; ?>/images/lacey.jpg" width="100" /></div>
                        <div class="feat-finao-text">Make a life long change to healthy living including improved dietary and excercise choices!</div>
                        
                        </a>
                    </div>
                    <div class="feat-finao-box feat-finao-box-alt">
                        <a href="/finao/motivationmesg/frndid/127" title="Karishma Sharma" >
                        <div class="feat-finao-image">
                        <img src="<?php echo $this->cdnurl; ?>/images/karishma.jpg" width="100" /></div>
                        <div class="feat-finao-text">I will do yoga once a week to work on my flexibility and strengthen my core.</div>
                        </a>
                    </div>
                </div>
                <div class="feat-finao-slider">
                    <div class="topics-carousal">
                        <div class="sliderkit carousel-demo2">
                            <div class="sliderkit-nav">
                                <div class="sliderkit-nav-clip">
                                    <ul>
                                        <li class="first-child">
                                            <a href="/finao/motivationmesg/frndid/192" title="Tanner Krenz" >
                                                <div class="feat-finao-box">
                                                    <div class="feat-finao-image"><img src="<?php echo $this->cdnurl; ?>/images/tanner.jpg" width="100" /></div>
                                                    <div class="feat-finao-text">Have a positive impact on my high school.</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="first-child">
                                            <a href="/finao/motivationmesg/frndid/597" title="Jeremy Taiwo" >
                                                <div class="feat-finao-box">
                                                    <div class="feat-finao-image"><img src="<?php echo $this->cdnurl; ?>/images/jermey.jpg" width="100" /></div>
                                                    <div class="feat-finao-text">I will eat healthy and discover the best foods to eat to maintain a high level of fitness.</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="first-child">
                                            <a href="/finao/motivationmesg/frndid/115" title="Lacey Greene" >
                                                <div class="feat-finao-box">
                                                    <div class="feat-finao-image"><img src="<?php echo $this->cdnurl; ?>/images/lacey.jpg" width="100" /></div>
                                                    <div class="feat-finao-text">Make a life long change to healthy living including improved dietary and excercise choices!</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="first-child">
                                            <a href="/finao/motivationmesg/frndid/127" title="Karishma Sharma" >
                                                <div class="feat-finao-box">
                                                    <div class="feat-finao-image"><img src="<?php echo $this->cdnurl; ?>/images/karishma.jpg" width="100" /></div>
                                                    <div class="feat-finao-text">I will do yoga once a week to work on my flexibility and strengthen my core.</div>
                                                </div>
                                            </a>
                                        </li> 
                                    </ul>
                                </div>
                                <div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-prev"><a href="#" title="Scroll to the left"><span>Previous</span></a></div>
                                <div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-next"><a href="#" title="Scroll to the right"><span>Next</span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="content-area">
            <div><?php echo $content; ?></div>
            <div class="content-area-left">
            	<p>Welcome to <span class="orange">FINAO</span>, the place to <span class="orange" style="font-size:27px;">create</span>, <span class="orange" style="font-size:27px;">share</span> and <span class="orange" style="font-size:27px;">celebrate</span> goals. From health to relationships, school or career, a FINAO is a goal you want to achieve... and where</p>
                <p class="right" style="padding-bottom:0;"><img src="images/tagline.png" width="300"></p>
            </div>
            <div class="content-area-right">
            	<!--<iframe id="viddler-bb13af7" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=mini&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0&amp;wmode=transparent" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>-->
            <!--<iframe id="viddler-a4723786" src="//www.viddler.com/embed/a4723786/?f=1&autoplay=0&player=full&secret=61384097&loop=0&nologo=0&hd=0" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>-->
                <iframe id="viddler-bb13af7" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=mini&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0&amp;wmode=transparent" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
            </div>
            
        </div> 
         
        <div style="clear:both;"></div>
        
    </div>
    <div id="whats-your-finao-wrapper">
    	<div class="whats-your-finao-innerwrapper">
        	<div class="whats-your-finao-tagline">WHAT'S YOUR FINAO? 
            <a href="#registeredpromocontent" id="getstarted" class="finao-get-started">GET STARTED</a>
             
            </div>
        </div>
    </div>
    <div id="promotional-area">
    	<div class="promotional-content-iphone">
        	
            <p class="promotional-content-iphone-tagline"><img src="<?php echo $this->cdnurl; ?>/images/getGear.png" class=""></p>
            <p><a href="/shop/" target="_blank" ><img src="<?php echo $this->cdnurl; ?>/images/shop.png"></a></p>
            <p class="promotional-content-iphone-tagline">
            <img src="<?php echo $this->cdnurl; ?>/images/getInspired.png"></p>
            <p><a href="http://finaospeakers.com" target="_blank" ><img src="<?php echo $this->cdnurl; ?>/images/speakers.png"></a></p>
            <p class="promotional-content-iphone-tagline">
            <a href="" title="Coming Soon">
            <img src="<?php echo $this->cdnurl; ?>/images/getMobile.png" >
            </a>
            </p>
            <p><a href="#" title="Coming Soon"><img src="<?php echo $this->cdnurl; ?>/images/mobile.png" alt="Coming Soon"></a></p>
        	
            <!--<p><a href="/shop/" ><img src="<?php echo $this->cdnurl; ?>/images/FINAO-Shop.jpg" /></a></p>
            <p><a href="#" ><img src="<?php echo $this->cdnurl; ?>/images/FINAO-Speakers.jpg" /></a></p>
            <p><a href="#"><img src="<?php echo $this->cdnurl; ?>/images/FINAO-MobileApp.jpg" /></a></p>
            
        	<a href="#"><img src="<?php echo $this->cdnurl; ?>/images/shop-img-iphone.jpg"></a>-->
        </div>
        <div class="promotional-content">
            <!--<div class="speakers-area"><a href="speakers-tiles.html" ><img src="<?php echo $this->cdnurl; ?>/images/speakers.png" /></a></div>
            <div class="mobile-app"><a href="#"><img src="<?php echo $this->cdnurl; ?>/images/mobileapp.png" /></a></div>
            <div class="do-more"><img src="<?php echo $this->cdnurl; ?>/images/do-more.png" /></div>
            <div class="shop-home"><a href="/shop/" ><img src="<?php echo $this->cdnurl; ?>/images/shop.png" /></a></div>-->
            
            <!--<div class="left shop-home"><a href="/shop/" ><img src="<?php echo $this->cdnurl; ?>/images/FINAO-Shop.jpg" width="180" /></a></div>
            <div class="left speakers-area"><a href="#" ><img src="<?php echo $this->cdnurl; ?>/images/FINAO-Speakers.jpg" width="150" /></a></div>            
            <div class="mobile-app"><a href="#"><img src="<?php echo $this->cdnurl; ?>/images/FINAO-MobileApp.jpg" width="200" /></a></div>-->
            
            <!--<div class="whats-your-finao-tagline"><img src="images/whatsYourFINAO.png"></div>-->
                
                <div class="promotional-content-taglines">
                	<div class="get-gear-note"><img src="<?php echo $this->cdnurl; ?>/images/getGear.png"></div>
                    <div class="get-inspired"><img src="<?php echo $this->cdnurl; ?>/images/getInspired.png"></div>
                    <div class="get-mobile"><a href="" title="Coming Soon"><img alt="Coming Soon" src="<?php echo $this->cdnurl; ?>/images/getMobile.png"></a></div>
                </div>
                
                <div class="promotional-content-images">
                	<div class="get-gear-image"><a href="/shop/" target="_blank" ><img src="<?php echo $this->cdnurl; ?>/images/shop.png"></a></div>
                    <div class="get-inspired-image">
                    <a href="http://finaospeakers.com" target="_blank" >
                    <img src="<?php echo $this->cdnurl; ?>/images/speakers.png">
                    </a>
                    </div>
                    <div class="get-mobile-image">
                    	<div class="view view-fifth">
                            <img src="<?php echo $this->cdnurl; ?>/images/mobile.png" />
                            <div class="mask">
                                <h2>Coming Soon</h2>
                            </div>
                        </div>                   	    
                    </div>
                </div>
        </div>
    </div>

<div id="footer">

    <div class="footer-left">

     <a href="<?php echo Yii::app()->createUrl('profile/aboutus'); ?>">About FINAO</a> |

     <!--<a href="<?php //echo Yii::app()->createUrl('profile/landing'); ?>">Explore FINAO</a> |-->
       <?php /*?> <a href="<?php echo Yii::app()->createUrl('profile/landing'); ?>">Explore FINAO</a> |<?php */?>
        <a href="<?php echo Yii::app()->createUrl('profile/finaogives'); ?>">FINAO Gives</a> |

     <a  href="<?php echo Yii::app()->createUrl('profile/faq'); ?>">FAQ</a> |

        <!--<a  href="<?php echo Yii::app()->createUrl('profile/grouppurchase'); ?>">Group Purchase</a> |-->

        <a  href="<?php echo Yii::app()->createUrl('profile/terms'); ?>">Terms of Use</a> |

  <a  href="<?php echo Yii::app()->createUrl('profile/privacy'); ?>">Privacy Policy</a> |

        <a  href="<?php echo Yii::app()->createUrl('profile/contactus'); ?>">Contact Us</a>

    </div>

    <div class="footer-right">

     <!--<span class="follow-me">Follow Us On:</span>-->

     <ul>

            <a href="https://www.facebook.com/FINAONation" target="_blank"><li class="facebook">&nbsp;</li></a>

            <a href="http://www.linkedin.com/company/2253999" target="_blank"><li class="linkedin">&nbsp;</li></a>

             <a href="http://pinterest.com/finaonation/" target="_blank"><li class="pinterest">&nbsp;</li></a>

            <a href="https://twitter.com/FINAONation" target="_blank"><li class="twitter">&nbsp;</li></a>

       </ul>

    </div>

    <div class="clear"></div>

    <div class="copyrights">&copy; 2013, JoMoWaG, LLC</div>

</div>

<div id="footer-ipad">
	<div class="footer-left">
    	<p><a href="<?php echo Yii::app()->createUrl('profile/aboutus'); ?>">About FINAO</a> | <a href="<?php echo Yii::app()->createUrl('profile/finaogives'); ?>">FINAO Gives</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('profile/faq'); ?>">FAQ</a> | <a href="<?php echo Yii::app()->createUrl('profile/terms'); ?>">Terms of use</a></p>
        <p><a  href="<?php echo Yii::app()->createUrl('profile/privacy'); ?>">Privacy Policy</a> | <a href="<?php echo Yii::app()->createUrl('profile/contactus'); ?>">Contact Us</a></p>
    </div>
    <div class="footer-right">
    	<ul>
            <a href="https://www.facebook.com/FINAONation" target="_blank"><li class="facebook">&nbsp;</li></a>
            <a href="http://www.linkedin.com/company/2253999" target="_blank"><li class="linkedin">&nbsp;</li></a>
            <a href="http://pinterest.com/finaonation/" target="_blank"><li class="pinterest">&nbsp;</li></a>
            <a href="https://twitter.com/FINAONation" target="_blank"><li class="twitter">&nbsp;</li></a>
       </ul>
    </div>
    <div class="clear"></div>
    <div class="copyrights">&copy; 2013, JoMoWaG, LLC</div>
</div>

<!--Promo Register-->
 
<div  style="display:none;">

<div id="registeredpromocontent" class="">
    
      <div id="login_form2" class="signin-popup">
<div class="orange font-16px padding-10pixels">Sign In / Register</div>
<!--<form id="customForm">-->
<div id="error_msg" style="color:#F00; margin-bottom:5px;"></div>
<div id="note_form" class="orange padding-10pixels"></div>
<div class="padding-10pixels">
<input type="text" id="pemail" name="pemail" class="txtbox"   style="width:97%;" placeholder="Email" />
<span id="emailInfo"></span>
</div>
<div class="padding-10pixels">
<input type="password" name="pass1" onKeyPress="return submitreginfo(this,event)" id="pass1" class="txtbox" placeholder="******" style="width:97%;"  />
<span id="pass1Info"></span>
</div>

       <div id="showpassword" style="display:none;">
         <div class="padding-10pixels">
           <input type="text" class="txtbox" style="width:97%;" placeholder="Name" id="ename">
        </div>

       </div>

<div class="padding-10pixels">
<span class="left font-12px">
<input id="remcheckbox" type="checkbox" /> Keep me signed in

</span> 


<span class="right">
<input type="button" id="registerform" class="orange-button" value="Sign In" />
</span>
</div>
<div class="clear"></div>
<div class="padding-10pixels">
<span class="left">

						<a  id ="forgot-link" href="#forgot_form" class="orange-link font-12px"  style="margin-right:20px;">

						Forgot Password?

						</a>

						</span>
</div>
<div class="clear"></div>

<div class="padding-10pixels" style="padding-top:10px;">
</div>

<!-- </form>-->
<div class="popup-or-image"><img src="<?php echo $this->cdnurl; ?>/images/or-image.png" width="240" /></div>
<div class="popup-signin-facebook">
<!--<img src="<?php echo $this->cdnurl; ?>/images/signinwithfacebook.png" width="250" />-->  
<?php $this->widget('FbRegister');?>
</div>


<!--<div class="orange font-16px padding-10pixels">Not a member? Join Now</div> 

<form method="post" action="<?php echo Yii::app()->createUrl('site/activationEmailSender') ?>">
<div class="padding-10pixels">
<input type="text" name="email" id="joinemail" class="txtbox left" placeholder="Email" style="width:80%;" /> 

<input type="submit" id="joinb" class="orange-button" value="Join" style="margin-top:1px;" />
</div> 
<div class="padding-10pixels"><span id="jemailInfo"></span></div>
</form>-->
<div class="font-12px padding-10pixels">We respect your privacy. You control what information is shared. Click for our full <a href="<?php echo Yii::app()->createUrl('profile/privacy'); ?>" class="orange-link font-12px">Privacy Statement</a> and <a href="<?php echo Yii::app()->createUrl('profile/terms'); ?>" class="orange-link font-12px">Terms and Conditions</a></div>

</div>

</div>

</div>
<!--Promo Register ends-->

<script type="text/javascript">
function checkuseravailable(){
 
		 var email = $("#pemail").val();
 		 var url= "<?php echo Yii::app()->createUrl('site/CheckEmail'); ?>";
     	 $.post(url, {email:email},

			function(data) { 

				 // alert(data);

				  

				var split = data.split('-');

				var value = split[0];

				var name = split[1];

				  if(value == '1')
 				  {
 					  $('#note_form').html('Welcome back <b>'+name+'</b>, please enter Password');
 					  $('#registerform').attr('value','Next'); 
 					  $('#showpassword').hide();
 					  $('#pass1').focus();
 					  $('#note2').hide();
 					  $('#privacy').hide();
 					  return true;
 				  }else if(value == "2")

				  {

					   //alert('Dont Show password');

					   $('#note_form').html('Thank you for Registering');

					   $('#showpassword').show();

					   $('#registerform').attr('value','Register');

					   $('#privacy').show();

					   $('#note2').show();

					   $('#forgot-link').hide();

					   

					   return false;

				  }

					 

			});

		 

		 

		 return false;

		

		

		}
</script>
  
</body>
</html>
