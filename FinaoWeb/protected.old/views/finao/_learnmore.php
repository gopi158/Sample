 
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
            	<iframe  frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=mini&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0&amp;wmode=transparent" id="viddler-bb13af7"></iframe>
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
          	   
               <div class="hbcu-inner-right">			   
               		
                    <div class="upload-video-btn">
                    <a href="<?php echo Yii::app()->createUrl('finao/contestdetails');?>" >
                    <img width="330" src="<?php echo $this->cdnurl; ?>/images/contestDetails.png"></a>
                    </div>
                    
                    
                    <div class="upload-video-btn">
				  <?php if(!empty(Yii::app()->session['login']['id'])){?> 	
					<a id="uploader" href="javascript:void(0)" onclick="goURl('search');"><img width="330" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png"></a>
				  	<?php }else{?>
					<a id="uploader" href="javascript:void(0)" onclick="setUser(this.id);fireClick();" ><img width="330" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png"></a>
					<?php }?>					
					</div>					
					 <div class="upload-video-btn">
                     <?php if(empty(Yii::app()->session['login']['id'])){?> 
                     
                    
                    <a href="javascript:void(0)" id="voter" onclick="setUser(this.id);fireClick();" >
                    <img width="330" src="<?php echo $this->cdnurl; ?>/images/viewVideos.png"></a>
                    </a>
                    
                    <?php }else{?> 
                    
                    <a href="<?php echo Yii::app()->createUrl('finao/Viewvideohdcu'); ?>" class="entercontest-btn">
                    <img width="300" src="<?php echo $this->cdnurl; ?>/images/viewVideos.png">
                    </a>
                    
                    <?php }?>
                    </div>
                    
                   
                    
                    
					 
                     <div class="winners-of-the-week">
                     <iframe id="viddler-bb13af7" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=simple&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0" width="307" height="193" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                     <div style="padding: 5px 0;">
                      <a href="/shop" target="_blank">
                      <img src="<?php echo $this->cdnurl; ?>/images/video1.jpg" width="300" height=""  />
                      </a>
                     
                     </div>
                     
                      <?php /*?><div style="padding: 5px 0;">
                        <a href="/shopnew" target="_blank">
                      <img src="<?php echo $this->cdnurl; ?>/images/video2.jpg" width="300" height=""  />
                      </a>
                     </div><?php */?>
                     </div>
                     
                    
                     
                    <?php /*?><div class="winners-of-the-week">
                    	<span class="font-25px padding-10pixels left oswald-font">Winners last week</span>
                        <div class="clear"></div>
							<?php foreach($winner as $userinfo)
							{ 
								if($userinfo['videoid']=='') { $s=explode('src=',$userinfo['video_embedurl']);$ss=explode('"',$s[1]); $src=$ss[1];} else { $src="//www.viddler.com/embed/".$userinfo['videoid']."/?f=1&amp;player=simple&amp;secret=".$userinfo['videoid'].""; }	?>
                        <div class="winners-week-video-box">
                        	<div class="winners-week-video"><iframe src="<?php echo $src;?>" ></iframe></div>
                            <div class="winners-week-finao">
                            	<span class="left"><?php echo substr(ucfirst($userinfo['finao_msg']),0,40);?></span>
                                <span class="font-12px">by <span class="orange"><?php echo $userinfo["fname"]." ".$userinfo["lname"] ; ?></span></span>
                            </div> 
                        </div>
						
					<?php }?>	
                        
                    </div><?php */?>
               </div>
                
               <div class="hbcu-inner-left">
               		
					<div class="hbcu-home-nav">
                    	<div class="hbcu-home-nav-left">
               				<a href="<?php echo Yii::app()->createUrl('finao/hbcupromo'); ?>"><img width="120" class="left" src="<?php echo $this->cdnurl; ?>/images/careerCatapult.png"></a> 
                        </div>
                        <div class="hbcu-nav-right">
                        	<p class="hbcu-page-hdline">Ready to launch</p>
                        	<p class="hbcu-top-run-text">Win the internship from FINAO and you could spend your summer in Seattle, getting hands-on experience and real-world knowledge.</p>
							<p class="upload-video-btn-ipad">
							
					<a href="<?php echo Yii::app()->createUrl('finao/contestdetails');?>"><img src="<?php echo $this->cdnurl; ?>/images/contestDetails.png" width="180" /></a>
                    		
							<?php if(!empty(Yii::app()->session['login']['id'])){?> 	
					<a id="registere" href="javascript:void(0)" onclick="goURl('search');"><img width="330" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png"></a>
				  	<?php }else{?>
					<a id="registere" href="javascript:void(0)" onclick="fireClick();" ><img width="330" src="<?php echo $this->cdnurl; ?>/images/uploadVideo.png"></a>
					<?php }?> 
                    
                     <?php if(empty(Yii::app()->session['login']['id'])){?> 
                     
                    
                    <a href="javascript:void(0)" id="voter" onclick="setUser(this.id);fireClick();" >
                    <img width="330" src="<?php echo $this->cdnurl; ?>/images/viewVideos.png"></a>
                    </a>
                    
                    <?php }else{?> 
                    
                    <a href="<?php echo Yii::app()->createUrl('finao/Viewvideohdcu'); ?>" class="entercontest-btn">
                    <img width="300" src="<?php echo $this->cdnurl; ?>/images/viewVideos.png">
                    </a>
                    
                    <?php }?>
                    
                    </p>	
						</div>
                    </div>
					 
                    
                    <div class="hbcu-sample-videos" style="background:#FFF">
                    <div style="width:100%; float:left;">
                    
                     <p class="hbcu-page-hdline">An invitation from HBCU CONNECT and FINAO</p>
                   
                    </div>
                    <div class="hbcu-sample-video-box left">
                    <div class="hbcu-sample-videobox-left">
                    <span class="hbcu-samp-video">
                   <!-- <img src="images/hbcu/video-bg.jpg" width="175" height="125" />-->
                    <iframe id="viddler-d3dd9cd5" src="//www.viddler.com/embed/d3dd9cd5/?f=1&amp;autoplay=0&amp;player=simple&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0" width="175" height="125" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                    </span>
                    <span>by <span class="orange">Wallace Greene</span></span>
                    </div>
                    <div class="hbcu-sample-videobox-right">
                    <span class="hbcu-sample-finao"><b>Wallace Greene</b>, <br/>FINAO,<br/> Founder and CEO.</span>
                    </div>
                    </div>
                    <div class="hbcu-sample-video-box right">
                    <div class="hbcu-sample-videobox-left">
                    <span class="hbcu-samp-video">
					 <img src="<?php echo $this->cdnurl; ?>/images/william1.jpg" width="175" height="125" />
                    <!-- <iframe id="viddler-bb13af7" src="//www.viddler.com/embed/bb13af7/?f=1&amp;autoplay=0&amp;player=simple&amp;secret=70441634&amp;loop=0&amp;nologo=0&amp;hd=0" width="175" height="125" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>-->
                    
                    </span>
                    <span>by <span class="orange">Will Moss</span></span>
                    </div>
                    <div class="hbcu-sample-videobox-right">
                    <span class="hbcu-sample-finao"><b>Will Moss</b>,<br/> HBCU Connect,<br/> Founder and CEO. </span>
                    </div>
                    </div>
                   
                    <!--<a id="form-page" href="#login_form" class="orange-link font-13px right">View more</a>-->
                    </div>
                    <?php if(!empty($userdets)){?> 
					<div class="hbcu-sample-videos">
                    <div style="width:100%; float:left;">
                    <p class="hbcu-page-hdline left">Video Sneak Peak</p>
                    </div>
                     
                     <?php $i=1; foreach($userdets as $userinfo)
				{
					if($userinfo['videoid']=='') { $s=explode('src=',$userinfo['video_embedurl']);$ss=explode('"',$s[1]); $src=$ss[1];} else { $src="//www.viddler.com/embed/".$userinfo['videoid']."/?f=1&amp;player=simple&amp;secret=".$userinfo['videoid'].""; }?>
                    
                    
                    

<script type="text/javascript">
	$(function(){ 
					
		$('a.clickTip<?php echo $i; ?>').aToolTip({
			clickIt: true,
			tipContent: '<?php echo $userinfo["finao_msg"]; ?>'
		});
	});
	
	
</script>							
                  
                    	<div class="hbcu-sample-video-box <?php if($i%2==0)echo 'right'; else echo 'left';?>">
                        	<div class="hbcu-sample-videobox-left">
                            	<span class="hbcu-samp-video">
									<iframe src="<?php echo $src;?>" ></iframe>
								</span>
                                <span>by <span class="orange"><a target="_blank" href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$userinfo["userid"],'finaoid'=>$userinfo["user_finao_id"])); ?>" class="orange-link font-12px"><?php echo $userinfo["fname"]." ".$userinfo["lname"] ; ?> </a></span></span>
                            </div>
                            <div class="hbcu-sample-videobox-right">
                            	<span class="hbcu-sample-finao">
								
								
							<?php //echo strlen($userinfo["finao_msg"]);
                            
                            if(strlen($userinfo["finao_msg"]) > 100)
                            {
                               echo substr($userinfo["finao_msg"], 0, 80).'&nbsp;<a href="#" class="clickTip'.$i.' exampleTip orange-link1 font-13px" >more</a>';   
							}
							else
							{ 
							echo $userinfo["finao_msg"]; 
							}
                            
                            ?>
								
								<?php //echo ucfirst($userinfo["finao_msg"]);?>
                                
                                </span>
                                
                            </div>
                           <!--<span>
                            <span onclick="fireClick();" id='votes<?php echo $userinfo['uploaddetail_id'];?>' class='votevideo vote-now' >Vote Now</span>
                            </span>-->
                        </div>
				
				<?php $i++; }?>
                
                      <?php if(!empty(Yii::app()->session['login']['id'])){?> 	
					 
                    
                    <input onclick="goURl('search');"  type="button" class="orange-button right" value="View more & Vote" />
				  	<?php }else{?>
					 
                    <input onclick="fireClick();" type="button" class="orange-button right" value="View more & Vote" />
					<?php }?>   
                      
                    </div>
					<?php } ?>
                    
                    
                    

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

function setUser(value)
{
	//alert(value);
	$('#utype').attr('value',value);
}
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
		var rd ='<?php echo Yii::app()->createUrl("/finao/Viewvideohdcu"); ?>';
	                    			 
									 
									window.location=rd;
	}
	else
	{
		//alert(page);
		var rd ='<?php echo Yii::app()->createUrl("finao/Viewvideohdcu"); ?>';
		window.location=rd;
	}
}

</script>

<?php   $this->widget('EasyRegister',array('type'=> $type,'pid'=>'65')); ?>
