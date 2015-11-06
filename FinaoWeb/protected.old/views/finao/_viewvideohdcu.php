 
  
<style>
.vote-now {
/*background: url(../images/vote-bg.png) left top repeat-x;*/
background-color:#f57b20;
height: 19px;
padding: 0 10px;
font-size: 12px;
color: #FFF;
}
.voted-now {
background-color:#E5E5E5;
/*background: url(../images/voted-bg.png) left top repeat-x; */
height: 19px;
padding: 0 10px;
font-size: 12px;
color: #343434;
cursor:default!important
}

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
 
<script type="text/javascript">
 
jQuery(function ($) {
     
	
	/*$('a.clickTip').aToolTip({
	clickIt: true,
	tipContent: '<?php echo $week[0]["finao_msg"]; ?>'
	});*/
	
	
	
	$('#college').blur(validateSchool);
	$('#graduate').blur(validateGraduate);
	$('#major').blur(validateMajor);
	
	$('#college').keyup(validateSchool);
	$('#graduate').keyup(validateGraduate);
	$('#major').keyup(validateMajor);

	$("#registered1").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,
		'hideOnOverlayClick' : false,
		'autoScale'           : true,
		  'fixed': false,
         'resizeOnWindowResize' : false,
		 <?php if($utype == 'uploader'){?> 
		 'afterClose': function() { $("#registered3").trigger('click'); },
		 <?php } ?>
		
		'closeClick': true

	});	
	
	
	
	$("#registered2").fancybox({
			'scrolling'		: 'no',
			'titleShow'		: false,
			'hideOnOverlayClick' : false,
			'autoScale'           : true,
			  'fixed': false,
			 'resizeOnWindowResize' : false
		});
		
	$("#registered3").fancybox({
			'scrolling'		: 'no',
			'titleShow'		: false,
			'hideOnOverlayClick' : false,
			'autoScale'           : true,
			  'fixed': false,
			 'resizeOnWindowResize' : false
		});	
	
	$("#registered4").fancybox({
			'scrolling'		: 'no',
			'titleShow'		: false,
			'hideOnOverlayClick' : false,
			'autoScale'           : true,
			/*'afterClose': function() { $("#registered1").trigger('click'); },*/
			  'fixed': false,
			 'resizeOnWindowResize' : false
		});	
	
 
<?php 
if(!empty($confirm) and $confirm == 'true'){?> 
 
	//alert('new user');
	$("#registered1").trigger('click');	
<?php }?>

<?php 
if(!empty($vote) and $vote == 'true'){?> 
 
	//alert('Vote');
	$("#registered4").trigger('click');	
<?php }?>
 


 

<?php 
if(!empty($vconfirm) and $vconfirm == 'true'){?> 
$("#registered2").trigger('click');	
<?php }?>
});
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
 	 
	 	
 

</script>
<a id="registered1" href="#registeredcontent1" ></a>
<a id="registered2" href="#registeredcontent2" ></a>
<a id="registered4" href="#registeredcontent4" ></a>


<div  style="display:none;">

				<div id ="registeredcontent1">
                	
                    <div class="signin-popup" id="login_form3" style="text-align:center;">
    	              <span class="orange font-20px padding-10pixels">Thank you for Joining</span><br />
                     You can Explore the videos posted by other users and upload your own video.   
                    </div>
               
                </div>    
</div>




<div  style="display:none;">

				<div id = "registeredcontent2">
                	
                    <div class="signin-popup" id="login_form3" style="text-align:center;">
    	              <span class="orange font-20px padding-10pixels">Thank you for Uploading Video</span><br />
                     Your Video is being encoded. It will be published after the Administrator approves the Video.   
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

<div  style="display:none;">

				<div id ="registeredcontent4">
                	
                    <div class="signin-popup" id="login_form3" style="text-align:center;">
    	              <span class="orange font-20px padding-10pixels">Thank you for Votting</span><br />
                     You can Explore the videos posted by other users and upload your own video.   
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
        <div id="hbcu-promo-container">
          <div class="hbcu-inner-pages">
          	   <div class="hbcu-inner-left">
               		<div class="hbcu-home-nav">
                    	<div class="hbcu-home-nav-left">
               				<a href="<?php echo Yii::app()->createUrl('finao/hbcupromo'); ?>"><img width="120" class="left" src="<?php echo $this->cdnurl; ?>/images/careerCatapult.png"></a> 
                        </div>
                        <div class="hbcu-nav-right">
                        	<p class="hbcu-page-hdline">Video Entries</p>
                        	<p class="hbcu-top-run-text">Help us decide who should be our summer intern. View and vote for videos below or join the competition and submit your own video. You could win a paid internship and a summer in Seattle.</p>
							
							<p class="upload-video-btn-ipad"><a id="registered3" href="#registeredcontent3" class="upload-video-btn-ipad"><img src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png" width="180" /></a></p>
                        </div>
                    </div>
				<?php 	if($week[0]["finao_msg"] !=''){?> 
                
                
		 
                <div class="previous-entries-hdline oswald-font recent-entries-ipad">Recent Entries</div>
                    <div class="video-of-the-week-box">
                    	<div class="video-of-week-left">
                        	<div class="video-of-the-week" id="current_id">
							<iframe  src="<?php echo "//www.viddler.com/embed/".$week[0]['videoid']."/?f=1&amp;player=simple&amp;secret=".$week[0]['videoid'];?>" width="320" height="240"></iframe>
<?php /*?>							<img src="<?php echo $week[0]['video_img'];?>" /><?php */?> 
    						 </div>                      
	 						<div class="video-of-week-finao" id="current_msg">
							
							 <?php //echo strlen($week[0]["finao_msg"]);
                            
                            if(strlen($week[0]["finao_msg"]) > 100)
                            {
                            
							 
							$content .=substr($week[0]["finao_msg"], 0, 80); 
							$content .= '...';  
							  
							  ?>
                           
                            <?php   }else{    $content = $week[0]["finao_msg"]; }
                            
                            ?>
							<?php echo $content;
							 ?>
                            
                            </div>
                          <div style="cursor:pointer; float:right" id="voteview">
                         
                         <?php 
						 $sql1 = "select * from fn_video_vote where voter_userid=".Yii::app()->session['login']['id']." and voted_userid=".$week[0]['userid']; 
				$connection=Yii::app()->db; 
				$command=$connection->createCommand($sql1);
				$votevideo = $command->queryAll();
						 ?>
                         
                         <?php if($votevideo){ ?><span id='vote' class='votevideo1 voted-now'>Voted</span><?php } else { ?> <span id='votes<?php echo $week[0]['uploaddetail_id'];?>' class='votevideo vote-now' onclick='myFunction(<?php echo $week[0]['userid'];?>,<?php echo $week[0]['uploaddetail_id'];?>,1)'>Vote Now</span> <?php }?>
						</div> 
						<?php 
						 $fnmsg = str_replace(' ', '+',$week[0]["finao_msg"]);
						 if($userinfo['video_img']==NULL) $imgsrcenc =  $this->cdnurl.$week[0]["uploadfile_path"]."/".$week[0]["uploadfile_name"];
						 else $imgsrcenc =  $week[0]['video_img'];
						 
						   $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/ShareVote/mediaid/".$week[0]['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']."/frndid/".$week[0]['updatedby'];  
						 $urlpath1 = urlencode($urlpath);
						 $imgsrcenc = urlencode($imgsrcenc);
						 $summary = Yii::app()->session['login']['username'].'+shared+a+Video+from+FINAO+CAREER+CATAPULT';?>
						<span class="sharing-container" style="background:none; border:0;">
							<span class="left bolder" style="margin-right:3px; margin-top:2px;">Share</span>
							<span id="fb"><a style="margin-right:5px;" href="<?php echo $urlpath1; ?>" 
							 onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 'facebook-share-dialog', 
							'width=626,height=436');return false;"><img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="20" height="20" /></a></span><span id="twtr"><a href="https://twitter.com/share?url=<?php echo $urlpath1; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/profile/sharevote/mediaid/<?php  echo  $week[0]['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="20" height="20" /></a></span>
						</span> 
                        </div>
						
                        <div id="Defaults" class="hbcu-contentHolder">
                        	<div class="video-of-week-right">
							<?php $j=0;
							 foreach($week as $userinfo)
							{$j++;
								$src="//www.viddler.com/embed/".$userinfo['videoid']."/?f=1&amp;player=simple&amp;secret=".$userinfo['videoid'].""; 
				$sql1 = "select * from fn_video_vote where voter_userid=".Yii::app()->session['login']['id']." and voted_userid=".$userinfo['userid']; 
				$connection=Yii::app()->db; 
				$command=$connection->createCommand($sql1);
				$votevideo = $command->queryAll(); ?>
                
                 
                
                <?php //echo strlen($userinfo["finao_msg"]);
                            
                            if(strlen($userinfo["finao_msg"]) > 80)
                            {
                              $content = substr($userinfo["finao_msg"], 0, 80);?>
                           
                            <?php   }else{    $content = $userinfo["finao_msg"]; }
                            
                            ?>
                
								<input type="hidden" id="url<?php echo $j;?>" value="<?php echo $src;?>" />
								<input type="hidden" id="msg<?php echo $j;?>" value="<?php if(strlen($userinfo["finao_msg"])>80){ echo $content."...";}else{echo $content;}?>" />
                                
                                <div class="video-of-week-small">
                                    <div class="video-of-week-small-left"><img onclick="voteview('<?php echo $userinfo['userid'];?>','<?php echo $userinfo['uploaddetail_id'];?>','<?php echo $j;?>');play_video(<?php echo $j;?>)" src="<?php echo $userinfo['video_img'];?>" width="100" height="80" /></div>
                                    <div class="video-of-week-small-right">
                                    	<div class="video-week-small-finao" onclick="voteview('<?php echo $userinfo['userid'];?>','<?php echo $userinfo['uploaddetail_id'];?>','<?php echo $j;?>');play_video(<?php echo $j;?>)">										
										
										
										<?php echo $content;if(strlen($userinfo["finao_msg"])>100){echo '...';}?>
                                        </div>
                                        <div style="padding-bottom: 5px;">by <span class="orange"><a target="_blank" href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$userinfo["userid"],'finaoid'=>$userinfo["user_finao_id"])); ?>" class="orange-link font-12px"><?php echo $userinfo["fname"]." ".$userinfo["lname"] ; ?> </a></span>
										
						<?php  $fnmsg = str_replace(' ', '+',$week[0]["finao_msg"]);
						 if($userinfo['video_img']==NULL) $imgsrcenc =  $this->cdnurl.$userinfo["uploadfile_path"]."/".$userinfo["uploadfile_name"];
						 else $imgsrcenc =  $week[0]['video_img'];
						 
						   $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/ShareVote/mediaid/".$userinfo['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']."/frndid/".$userinfo['updatedby'];  
						 $urlpath1 = urlencode($urlpath);
						 $imgsrcenc = urlencode($imgsrcenc);
						 $summary = Yii::app()->session['login']['username'].'+shared+a+Video+from+FINAO+CAREER+CATAPULT';?>
						<span style="display:none" id="fb<?php echo $j;?>">	
							<a style="margin-right:5px;"  href="<?php echo $urlpath1; ?>" 
							 onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 'facebook-share-dialog', 
							'width=626,height=436');return false;"><img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="20" height="20" /></a></span><span id="twtr<?php echo $j;?>" style="display:none"><a href="https://twitter.com/share?url=<?php echo $urlpath1; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/profile/sharevote/mediaid/<?php  echo  $userinfo['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="20" height="20" /></a>
						</span></div>
									
                                    </div>
                                </div>
							<?php }?>	
										
                            </div>
                        </div>
                    </div>
				
				<?php }?>
                    
               </div>
			   
               <div class="hbcu-inner-right">
               		<div class="upload-video-btn">
					
					 <?php if(!empty(Yii::app()->session['login']['id'])){?> 	
					<?php if(empty($uservideodetails)){?> 
					<a id="registered3" href="#registeredcontent3" >
                      
                    <img width="330" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png">
                    </a>
					<?Php }else{?> 
					<a id="registered" href="javascript:void(0)" onclick="goURl('search');" ><img width="330" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png"></a>
					<?php } ?>
					<?php }else{?>
					<!--<a id="registered" href="javascript:void(0)" onclick="fireClick();" ><img width="330" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png"></a>-->
                    
                    
					<?php }?>
					
					</div>
                    
                    <div class="upload-video-btn">
                    <a href="<?php echo Yii::app()->createUrl('finao/contestdetails');?>" >
                    <img width="330" src="<?php echo $this->cdnurl; ?>/images/contestDetails.png"></a>
                    </div>
                    <div class="winners-of-the-week">
					
					  <!--  <iframe id="viddler-bb13af7" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=simple&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0" width="307" height="193" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>-->
					
	<span class="font-20px padding-10pixels left oswald-font">Invitation from FINAO</span>
	<div class="clear"></div>
	<div class="winners-week-video-box">
		<div class="winners-week-video">
		 <iframe id="viddler-d3dd9cd5" src="//www.viddler.com/embed/d3dd9cd5/?f=1&amp;autoplay=0&amp;player=simple&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0" width="150" height="100" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe></div>
		<div class="winners-week-finao">
			<span class="left"><b>Wallace Greene</b>,<br/> FINAO,<br/> Founder and CEO.</span>			
		</div>
	</div>  
	
	<span class="font-20px padding-10pixels left oswald-font">Invitation from HBCU CONNECT</span>
	<div class="clear"></div>
	<div class="winners-week-video-box">
		<div class="winners-week-video">
		 <img src="<?php echo $this->cdnurl; ?>/images/William-R -Moss-III.jpg" width="150" height="100" />		
		<!-- <iframe id="viddler-bb13af7" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=simple&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0" width="150" height="100" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>--> 
		</div>
		<div class="winners-week-finao">
			<span class="left"><b>Will Moss</b>, <br/>HBCU Connect,<br/> Founder and CEO.</span>
		</div>
	</div>                   
                        
                    </div>
					
					<?php /*?><div class="winners-of-the-week">
                    	<span class="font-25px padding-10pixels left oswald-font">Winners last week</span>
                        <div class="clear"></div>
					<?php foreach($winner as $userinfo)
							{ 
						 $src="//www.viddler.com/embed/".$userinfo['videoid']."/?f=1&amp;player=simple&amp;secret=".$userinfo['videoid']; 	?>
                        
						<div class="winners-week-video-box">
                        	<div class="winners-week-video"><iframe src="<?php echo $src;?>" width="150" height="100" ></iframe></div>
                            <div class="winners-week-finao">
                            	<span class="left"><?php echo substr(ucfirst($userinfo['finao_msg']),0,40);?></span>
                                <span class="font-12px">by <span class="orange"><?php echo $userinfo["fname"]." ".$userinfo["lname"] ; ?></span></span>
                            </div>
                        </div>
						
					<?php }?>	
                    </div><?php */?>
               </div>
			   
			   <?php if(count($userdets) > 0){?> 
               <div class="previous-entries-wrapper">
                	<div class="previous-entries-hdline oswald-font">Previous Entries</div>
					<span id="loads"> 
			<?php $j=0;
			 foreach($userdets as $userinfo)
				{ $j++;
					if($userinfo['videoid']=='') { $s=explode('src=',$userinfo['video_embedurl']);$ss=explode('"',$s[1]); $src=$ss[1];} else { $src="//www.viddler.com/embed/".$userinfo['videoid']."/?f=1&amp;player=simple&amp;secret=".$userinfo['videoid'].""; }
					$sql1 = "select * from fn_video_vote where voter_userid=".Yii::app()->session['login']['id']." and voted_userid=".$userinfo['userid']; 
				$connection=Yii::app()->db; 
				$command=$connection->createCommand($sql1);
				$votevideo = $command->queryAll();
				$msg_id=$userinfo['uploaddetail_id']; ?>
					
                    <script type="text/javascript">
	jQuery(function ($) {
					/*		   
							    var showChar = 90;
	var ellipsestext = "...";
	var moretext = "more";
	var lesstext = "less";
	$('.moreview1<?php echo $j; ?>').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);

			var html = c + '<span class="moreelipses">'+ellipsestext+'</span>&nbsp;<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="orange-link1 orange-link<?php echo $j; ?> font-12px">'+moretext+'</a></span>';

			$(this).html(html);
		}

	});

	$(".orange-link<?php echo $j; ?>").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
							   
					*/	
					
					$('a.clickTip<?php echo $j; ?>').aToolTip({
					clickIt: true,
					tipContent: '<?php echo $userinfo["finao_msg"]; ?>'
					});
							   });				
   
                    </script>
                    
                    <div class="hbcu-video-big">
                    	<div class="hbcu-big-video-top"><iframe src="<?php echo $src;?>" width="310" height="210" ></iframe></div>
                        <div class="hbcu-big-video-bottom">
                        	<div class="hbcu-big-video-finao">
                            
                             <?php //echo strlen($week[0]["finao_msg"]);
                            
                            if(strlen($userinfo["finao_msg"]) > 100)
                            {
                            
							 
							$content1 =substr($userinfo["finao_msg"], 0, 80).'&nbsp;<a href="#" class="clickTip'.$j.' exampleTip orange-link1 font-13px" >more</a>'; 
							  
							  
							  ?>
                           
                            <?php   }else{    $content1 = $userinfo["finao_msg"]; }
                            
                            ?>
							<?php echo $content1;
							 ?>
							<?php //echo substr(ucfirst($userinfo["finao_msg"]),0,40);?>
                            <?php /*?><div class="comment moreview moreview1<?php echo $j;?>">
                            <?php  echo $userinfo["finao_msg"]; ?>
                            </div><?php */?>
                            </div>							
                            <div class="font-12px;" style="padding-bottom: 5px;">by <span class="orange"><a target="_blank" href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$userinfo["userid"],'finaoid'=>$userinfo["user_finao_id"])); ?>" class="orange-link font-12px"><?php echo $userinfo["fname"]." ".$userinfo["lname"] ; ?> </a></span></div>
							
							<div style="float:right"><?php if($votevideo){ ?><span id='vote' class='votevideo1 voted-now'>voted</span><?php } else { ?> <span id='votes<?php echo $userinfo['uploaddetail_id'];?>' class='votevideo vote-now' onclick='myFunctions(<?php echo $userinfo['userid'];?>,<?php echo $userinfo['uploaddetail_id'];?>,<?php echo $j;?>)'>Vote Now</span> <?php }?></div>
						<?php 
						 $fnmsg = str_replace(' ', '+',$userinfo["finao_msg"]);
						 if($userinfo['video_img']==NULL) $imgsrcenc =  $this->cdnurl.$userinfo["uploadfile_path"]."/".$userinfo["uploadfile_name"]; 
						 else $imgsrcenc =  $userinfo['video_img'];
						 
						  $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/ShareVote/mediaid/".$userinfo['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']."/frndid/".$userinfo['updatedby']; 
						 $urlpath1 = urlencode($urlpath);
						 $imgsrcenc = urlencode($imgsrcenc);
						 $summary = Yii::app()->session['login']['username'].'+shared+a+Video+from+FINAO+CAREER+CATAPULT';?>
						<span class="sharing-container" style="background:none; border:0;">
							<span class="left bolder" style="margin-right:3px; margin-top:2px;">Share</span>
							<a style="margin-right:5px;" href="<?php echo $urlpath1; ?>" 
							 onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 'facebook-share-dialog', 
							'width=626,height=436');return false;"><img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="20" height="20" /></a><a href="https://twitter.com/share?url=<?php echo $urlpath1; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/profile/sharevote/mediaid/<?php  echo  $userinfo['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="20" height="20" /></a>
						</span>
	
							
                        </div>
                    </div>
				<?php }?>
				<div class="clear"></div>
				
               <!--commented by LK --> 
                 <?php /*?> <div id="more<?php echo $msg_id; ?>" class="morebox"></div>
			   <div class="center" id="remove<?php echo $msg_id; ?>"><a href="javascript:void(0)" class="more" id="<?php echo $msg_id; ?>"><img class="show-more-btn" src="<?php echo $this->cdnurl;?>/images/btn-showmore.jpg"></a>
			   </span>
               </div><?php */?>
			  
			   
          </div>  
               <?php } ?>          
        </div>
    </div>
</div>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>

<script type="text/javascript">
$(function() {
$('.more').live("click",function() 
{
	var ID = $(this).attr("id");
	if(ID)
	{
		$("#more"+ID).html('<img src="<?php echo $this->cdnurl; ?>/images/moreajax.gif" />');
		$.ajax({
		type: "POST",
		url: "<?php echo Yii::app()->createUrl("/finao/ajaxmore"); ?>",
		data: "lastmsg="+ ID, 
		cache: false,
		success: function(html){
		$("#loads").append(html);
		$("#more"+ID).remove();
		$("#remove"+ID).remove();
	}
	});
	}
	else
	{
		$("#remove"+ID).remove();
	}
	return false;
	});
});

</script>

<!-- Scrollbar Start -->
<link href="<?php echo $this->cdnurl; ?>/javascript/scrollbar/perfect-scrollbar.css" rel="stylesheet">
<script src="<?php echo $this->cdnurl; ?>/javascript/scrollbar/jquery.mousewheel.js"></script>
<script src="<?php echo $this->cdnurl; ?>/javascript/scrollbar/perfect-scrollbar.js"></script>


 <script>
	jQuery(document).ready(function ($) {
	"use strict";
	$('#Defaults').perfectScrollbar();
	});
</script>

<script type="text/javascript">


function goURl(page)
{
	if(page == 'home')
	{
		var rd ='<?php echo Yii::app()->createUrl("/myhome"); ?>';
		window.location=rd;
	}else if(page == 'search')
	{
		var rd ='<?php echo Yii::app()->createUrl("/finao/videocontest"); ?>';
	    window.location=rd;                			 
	}
	else
	{
		var rd ='<?php echo Yii::app()->createUrl("finao/Videocontest"); ?>';
		window.location=rd;
	}
}
function voteview(userid,videoid,inc)
{
	
	 var url='<?php echo Yii::app()->createUrl("/finao/Checkvideovote"); ?>';
	$.post(url, { voteduserid:userid, videoid:videoid,voteruserid:<?php echo Yii::app()->session['login']['id']; ?>, inc:inc},
		function(data)
		{ 
		     $('#voteview').html(data);
		});
	
	  
}
function play_video(a)
{
	//alert(a);
	$('#fb').html($('#fb'+a).html());$('#twtr').html($('#twtr'+a).html());
	$('#current_id').html('<iframe  src="'+$('#url'+a).val()+'" width="320" height="240"></iframe>');
	$('#current_msg').html($('#msg'+a).val());
}
function myFunction(userid,videoid,a)
{ 
	var url='<?php echo Yii::app()->createUrl("/finao/voteVideo"); ?>';
	$.post(url, { voteduserid:userid, videoid:videoid,voteruserid:<?php echo Yii::app()->session['login']['id']; ?> },
		function(data){$('#votes'+videoid).attr('onclick','');$('#votes'+videoid).html('Voted');$("#votes"+videoid).toggleClass('vote-now voted-now');});
}
function myFunctions(userid,videoid,a)
{
	var url='<?php echo Yii::app()->createUrl("/finao/voteVideo"); ?>';
	$.post(url, { voteduserid:userid, videoid:videoid,voteruserid:<?php echo Yii::app()->session['login']['id']; ?> },
		function(data){$('#votes'+videoid).attr('onclick','');$('#votes'+videoid).html('Voted'); $("#votes"+videoid).toggleClass('vote-now voted-now');});
 }
</script>