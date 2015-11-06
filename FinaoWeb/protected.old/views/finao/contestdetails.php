 <link href="<?php echo $this->cdnurl;?>/css/hbcu.css" rel="stylesheet" />
 <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/Fonts/barkentina/stylesheet.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/Fonts/oswald/stylesheet.css" type="text/css" media="screen" />


<a id="registered1" href="#registeredcontent1" ></a>

<div  style="display:none;">

				<div id = "registeredcontent1">
                	
                    <div class="signin-popup" id="login_form3" style="text-align:center;">
    	              <span class="orange font-20px padding-10pixels">Thank you for Joining the FINAO Nation</span><br />
                     Please set your password by clicking on the confirmation mail sent to your email within next 24 Hours.   
                    </div>
               
                </div>     
</div>

<div  style="display:none;">
 
 <div id ="registeredcontent3">
                	
                 <div id="login_form2" class="signin-popup">
     <div class="orange font-16px padding-10pixels" id="note">Please Fill in the Following</div>
     
      
        
        <div id="log-msgerror" style="color:#F00; margin-bottom:5px;"></div>
       
       <div id="error_msg" style="color:red; padding:5px;"></div>
       
      <form id="student" onsubmit="return validateForm()" action="<?php echo Yii::app()->createUrl('finao/Contestuserdetails'); ?>" method="post">
        <div class="padding-10pixels">
        College:<input type="text" id="college" name="college" class="txtbox require" style="width:97%;" placeholder="Enter College Name" />
        <span id="collegeInfo" style="color:#F00;"></span>
        </div>
         
        <div class="padding-10pixels">
        Graduation Year:<input type="text" id="graduate" name="graduate" class="txtbox require" style="width:97%;" placeholder="Enter Graduation Year" />
        <span id="graduateInfo" style="color:#F00;"></span>
        </div> 
        
        <div class="padding-10pixels">
        Major:<input type="text" id="major" name="major" class="txtbox require" style="width:97%;" placeholder="Enter Major" />
        <span id="majorInfo" style="color:#F00;"></span>
        </div>
        
        <div class="padding-10pixels">
        <span class="left font-12px">
        </span> 
        <span class="right">
        <input type="submit" id="vregister" name="submit" class="orange-button" value="Next" />
        </span>
        </div>
        
        </form>
        
        
         <div class="padding-10pixels">
       
        </div>
        <div class="clear"></div>
        <div class="padding-10pixels" style="padding-top:10px;">
        </div>
        
        <!-- </form>-->
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
    	<div class="popup-or-image"><img src="<?php echo $this->cdnurl; ?>/images/or-image.jpg" width="380" /></div>
    	<div class="popup-signin-facebook"><img src="<?php echo $this->cdnurl; ?>/images/signinwithfacebook.png" width="250" /></div>
	</div>    	
</div>
	


<div class="hbcu-pages-wrapper">
    <div id="hbcu-middle-container">
    	<div class="hbcu-promo-second-banner"><img width="1000" border="0" usemap="#Map" src="<?php echo $this->cdnurl; ?>/images/contestHeader.png">
<map id="Map" name="Map">
  <area href="<?php echo Yii::app()->createUrl('finao/hbcupromo'); ?>" coords="704,41,938,267" shape="rect" style=" outline:none !important;
   border: none !important;">
</map></div>
<div id="hbcu-promo-container-text">
          <div class="hbcu-inner-content">
          	
            	<div class="orange font-25px padding-5pixels oswald-font">Are you ready to show the world what you've got? </div>
                <div class="hbcu-promo-run-text-black">Win a fully paid summer internship at FINAO<sup>&reg;</sup>. You'll have a chance to influence an innovative new company, develop new skills, and make connections.</div>
                <div class="hbcu-promo-run-text-black">If FINAO isn't on your career path, we'll pay you for an internship at another HBCU affiliated company.</div>
                <div class="hbcu-promo-run-text-black">How do you win?  We want to hear your Failure Is Not An Option story. Submit a short video that inspires.</div>
                
                <div class="orange font-25px padding-5pixels oswald-font">Innovator. Creator. Intern.</div>
                <div class="hbcu-promo-run-text-black">The FINAO Career Catapult is a once-in-a-lifetime internship where you will learn and grow from hands-on experience at an innovative company in Seattle. </div>
                <div class="hbcu-promo-run-text-black">Part tech company, part apparel brand, FINAO is an entirely new type of social experience that connects the digital world to the real world. Our mission is simple: to make it fun and cool to lead a goal-oriented life. </div>
                
          		
                <div class="orange font-25px padding-15pixels oswald-font">The Contest</div>
                
                <div class="orange font-18px padding-5pixels">DATES</div>
                <div class="hbcu-promo-run-text-black">We are accepting video submissions for The Career Catapult Internship Contest between December 18, 2013 and March 31, 2014.</div>
                <div class="hbcu-promo-run-text-black">The FINAO internship will begin June 2 and end August 8, 2014.</div>
                
                <div class="orange font-18px padding-5pixels">STEP 1: ENTER</div>
                <div class="hbcu-promo-run-text-black">At finaonation.com/careercatapult-hbcu.</div>
                
                <div class="orange font-18px padding-5pixels">STEP 2:  CREATE</div>
                <div class="hbcu-promo-run-text-black">Record a 15 to 60 second video about your career FINAO (i.e. "I will work for a leading tech company,") why you should win, and what this internship will mean to your career. You can include pics or music &ndash; this is the time to be creative.</div>
                
                <div class="orange font-18px padding-5pixels">STEP 3: APPLY</div>
                <div class="hbcu-promo-run-text-black">Upload your video here and get your friends to vote for you by sharing your FINAO video through Facebook.</div>
                
                <div class="orange font-18px padding-5pixels">WHAT HAPPENS NEXT: </div>
                <div class="hbcu-promo-run-text-black">One winner will be selected each week and entered to our final judging pool. All non-winning entries will carry over to the next week. You can enter multiple times but you'll only win one internship (out of three available).</div>
                
                <div class="orange font-18px padding-5pixels">ELIGIBILITY  &amp;  RULES</div>
                <div class="hbcu-promo-run-text-black">The FINAO Career Catapult is open to any student at an HBCU affiliated college who has completed one year of study. Masters and PhD candidates can apply.</div>
                
                <div>
				<?php if(!empty(Yii::app()->session['login']['id'])){?> 	
					<?php if(empty($uservideodetails)){?> 
					<a id="registered3" href="#registeredcontent3" >
                    <img width="330" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png">
                    </a>
					<?php }else{?> 
					 <a id="registered1" href="javascript:void(0)" onclick="goURl('search');" ><img width="220" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png"></a>
					<?php } ?>
                   
				  	<?php }else{?>
					<a id="registered1" href="javascript:void(0)" onclick="fireClick();" ><img width="220" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png"></a>
					<?php }?>
				
      </div>
        </div>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function(){
						   
		$('#college').blur(validateSchool);
		$('#graduate').blur(validateGraduate);
		$('#major').blur(validateMajor);
		
		$('#college').keyup(validateSchool);
		$('#graduate').keyup(validateGraduate);
		$('#major').keyup(validateMajor);				   
						   
						   
		$("#registered3").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,
		'hideOnOverlayClick' : false,
		'autoScale'           : true,
		'fixed': false,
		'resizeOnWindowResize' : false
		});	
		
		
		
		

						   
});
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

function validateSchool(){
		
		college = $('#college');
        collegeInfo = $('#collegeInfo');		 
		if(college.val().length < 4){
			college.addClass("txtbox-error");
			college.attr("placeholder", "Enter College Name");
			collegeInfo.text("College Name minimum of 3 letters!");
			//nameInfo.addClass("txtbox-error");
			return false;
		}
		//if it's valid
		else{
			college.removeClass("txtbox-error");
			collegeInfo.text("");
			//nameInfo.removeClass("txtbox-error");
			return true;
		}
	}
   
	function validateMajor(){
		
		major = $('#major');
		majorInfo = $('#majorInfo');
		 
		if(major.val().length < 4){
			major.addClass("txtbox-error");
			major.attr("placeholder", "Enter Major");
			majorInfo.text("Enter Major");
			//nameInfo.addClass("txtbox-error");
			return false;
		}
		//if it's valid
		else{
			major.removeClass("txtbox-error");
			majorInfo.text("");
			//nameInfo.removeClass("txtbox-error");
			return true;
		}
	}
	
	function validateGraduate(){
		//testing regular expression
		graduate = $('#graduate');
		graduateInfo = $('#graduateInfo');
		var a = $('#graduate').val();
		var filter = /^-{0,1}\d*\.{0,1}\d+$/;
		//if it's valid email
		if(filter.test(a)){
			graduate.removeClass("txtbox-error");
			graduateInfo.text("");
			//emailInfo.text("Valid E-mail please, you will need it to log in!");
			//emailInfo.removeClass("txtbox-error");
			
			
			return true;
		}
		//if it's NOT valid
		else{
			graduate.addClass("txtbox-error");
			graduateInfo.text("Please Enter Number");
			graduate.attr("placeholder", "Enter Graduation Year");
			 
			return false;
		}
	}
	
 	 
function validateForm()
{
	if(validateGraduate() & validateSchool() & validateMajor())
	{
	return true;
	}
	else
	{
	return false;
	}
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
		var rd ='<?php echo Yii::app()->createUrl("/finao/videocontest"); ?>';
	                    			 
									 
									window.location=rd;
	}
	else
	{
		//alert(page);
		var rd ='<?php echo Yii::app()->createUrl("finao/Videocontest"); ?>';
		window.location=rd;
	}
}
function fireClick()
{
  //alert("Hello");
 <?php $type = 'video'; ?>
 $("#registered_video").trigger('click');
  
 
}

</script>
 

<?php   $this->widget('EasyRegister',array('type'=>'video','pid'=>'65')); ?>