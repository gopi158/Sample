<style>
.votevideo{  padding-right:10px; float:right; cursor: pointer;}
.votevideo1{ padding-right:10px; cursor: auto; float:right;}
</style><?php // echo $_SERVER['HTTP_HOST']; die(); ?><?php function resize_values($image){
$source =  $image;
#for the purpose of this example, we'll set this here
#to make this function more powerful, i'd pass these 
#to the function on the fly
$thumb_width = 440;
$thumb_height = 320;
// list($width1, $height1) = getimagesize($source);
list($width1,$height1) = getimagesize($image);
#get the size of the image you're resizing.
// $origHeight = imagesy($image);
// $origWidth = imagesx($image);
$width = $width1;
$height = $height1;

$original_aspect = $width / $height;
$thumb_aspect = $thumb_width / $thumb_height;
				if ( $original_aspect >= $thumb_aspect )
				{
				// If image is wider than thumbnail (in aspect ratio sense)
				$newheight = $thumb_height;
				$newwidth = $width / ($height / $thumb_height);
				$retval = array($newwidth, $newheight);
				}
				else
				{
				// If the thumbnail is wider than the image
				$newwidth = $thumb_width;
				$newheight = $height / ($width / $thumb_width);
				$retval = array($newwidth, $newheight);
				}
return $retval;
} 


?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/slick/jquery.slick.2.1.js"></script>-->
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.css?v=2.1.5" media="screen" /> 
<script type="text/javascript">

			$(document).ready(function($){
			
			$(".fancybox-share").fancybox({
			
			
			});
			
			});

</script>
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/styles.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/home.css" type="text/css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<div class="header-home">
            <div class="logo-area"><a href="<?php echo $this->cdnurl; ?>/home"><img title="FINAO NATION" src="<?php echo $this->cdnurl; ?>/images/logo2.png" width="220" height="73"></a></div>
                  <div class="search-area">
             <span class="settings">
            	<div class="messages">
                    <ul id="menu">
                        <li><!--<a class="drop" href="#"><img width="50" src="<?php //echo $this->cdnurl; ?>/images/home/settings.png"></a>--><!-- Begin Home Item -->
                        
                            <div class="dropdown_2columns align_right"><!-- Begin 2 columns container -->
                        
                                <div class="col_2">
                                    <!--<a class="menu-link" href="#">Edit your Profile</a>-->
                                </div>
                        
                                <!--<div class="col_2">
                                    <a href="#" class="menu-link">Change Background Image</a>     
                                </div>-->
                                
                                <div style="padding-bottom:0;" class="col_2">
                                   <!-- <a class="menu-link" href="index.html">Sign Out</a>    --> 
                                </div>
                              
                            </div><!-- End 2 columns container -->
                        
                        </li>
                    </ul>
                </div>
            </span>
              <span class="notifications">
            	<div class="messages">
                    <ul id="menu">
                        <!--<li><a class="drop" href="#"><img width="30" src="images/notification.png"></a><!-- Begin Home Item -->
                        
                        <!--     <div class="dropdown_2columns align_right">Begin 2 columns container 
                        
                                No Notifications
                              
                            </div><!-- End 2 columns container 
                        
                        </li>-->
                    </ul>
                </div>
            </span>
            <span class="welcome-pic"><a href="dashboard.html"><!--<img width="24" height="24" class="image-border" src="images/profile-pic.jpg">--></a></span>
             <span style="margin-right:180px;" class="right"><!--<input type="text" value="Search.." class="search">--></span>
            <!--<span class="right"><a href="#"><img src="images/profile-pic.jpg" width="50" class="image-border" /></a></span>-->
        </div>
    </div>

<div class="main-container" id="main-container">


<div class="share-container">
      <div class="font-20px padding-20pixels left" style="width:100%;">
							<span class="left"><a href="http://finaonation.com/finao/motivationmesg/frndid/<?php echo $_REQUEST['userid']?>">
							<img src="<?php if($view == 'displayvideo'){echo $this->cdnurl;?>/images/uploads/profileimages/<?php echo $displayvideo2['profile_image']; }else if($view == 'displayfinao'){ echo $this->cdnurl;?>/images/uploads/profileimages/<?php echo $finaosuserprofile['profile_image']; }else if($view == 'displayimage'){ echo $this->cdnurl;?>/images/uploads/profileimages/<?php echo $displayimage1['profile_image']; }?>" width="50" height="50" style="border:solid 3px #d7d7d7;" />
							</a>
							</span> 
							<span style="margin-left:10px; margin-top:10px;" class="left"><a class="orange-link font-20px" href="http://finaonation.com/finao/motivationmesg/frndid/<?php echo $_REQUEST['userid']?>">
							
							<?php if($view == 'displayvideo'){echo ucfirst($displayvideo1['fname']);}
							else if($view == 'displayfinao'){ echo ucfirst($finaoprofilenames['fname']);}
							else if($view == 'displayimage'){ echo ucfirst($displayimage2['fname']);}?> </a><?php if($shareid==1)echo "Marked"; else echo "Shared"; ?>
							<?php if($view == 'displayvideo'){
							if($shareid==1)
							echo  " Video as inapropriate";
							else if(isset($_REQUEST['frendid']))
							{
							if($_REQUEST['frendid']==$_REQUEST['userid'])
							echo " a Video";
							else{
							echo " ".ucfirst($getfrenddtls['fname'])."'s"." Video";
							}
							//echo " ".ucfirst($getfrenddtls['fname'])."'s"." Video";
							}
							else
							echo " a Video"; }
							else if($view == 'displayfinao'){ 
							if($shareid==1)
							echo  " FINAO as inapropriate";
							else if(isset($_REQUEST['frendid']))
							echo " ".ucfirst($getfrenddtls['fname'])."'s"." FINAO";
							else echo " a FINAO";}
							else if($view == 'displayimage'){  
							if($shareid==1)
							echo  " Image as inapropriate";
							else if(isset($_REQUEST['frendid']))
							echo " ".ucfirst($getfrenddtls['fname'])."'s"." Image";
							else  echo " an Image";}?></span>
							<span  style="margin-top:10px;" class="right">
							<a href="#contentid" class="fancybox-share orange-link font-20px" >	<?php if($view == 'displayvideo'){echo ucfirst($displayvideo1['fname']);}
							else if($view == 'displayfinao'){ echo ucfirst($finaoprofilenames['fname']);}
							else if($view == 'displayimage'){ echo ucfirst($displayimage2['fname']);}?>'s Story </a>	</span>
							<div style=" display:none;">
			<div id="contentid" style=" width: 600px; min-height: 150px; max-height: 600px; padding: 10px; overflow: auto;">
					
										<p class="orange font-16px padding-10pixels">	
										<?php if($view == 'displayvideo'){echo ucfirst($displayvideo1['fname']);}
										else if($view == 'displayfinao'){ echo ucfirst($finaoprofilenames['fname']);}
										else if($view == 'displayimage'){ echo ucfirst($displayimage2['fname']);}?>'s Story</p>
										<p style="font-size:14px; line-height:22px; padding-bottom:5px;">
										<?php if($view == 'displayvideo'){echo $displayvideo2['mystory'];}
										else if($view == 'displayfinao'){echo $finaosuserprofile['mystory'];}
										else if($view == 'displayimage'){echo $displayimage1['mystory'];}?></p>
		</div>			
		</div>
</div> <?php if($view == 'displayvideo'){ ?>
<div class="share-image-area" style="margin-bottom: 60px;"><?php 
if(!empty( $displayvideo['videoid'])){?>
<iframe width="478" height="360" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" src="//www.viddler.com/embed/<?php echo $displayvideo['videoid']?>/?f=1&amp;player=simple&amp;secret=<?php echo $displayvideo['videoid']?>" id="viddler-<?=$eachImgVid['videoid']?>"></iframe>

<?php }
else echo  $displayvideo['video_embedurl'];?>


<?php if($displayvideo['video_caption']==""){ //if(isset($_REQUEST['vote'])){?>

 <!--<span id="vote" class="votevideo" onclick="myFunction(<?php //echo $_REQUEST['userid'];?>,<?php echo $_REQUEST['mediaid'];?>)">vote</span>-->
<?php //}
}else{?>

<div class="image-caption1" style="bottom: -39px; background:#000;"><?php if($view == 'displayvideo'){
											echo $displayvideo['video_caption'];}?>
											<?php //if(isset($_REQUEST['vote'])){?>
			<!--	<span id="vote" class="votevideo" onclick="myFunction(<?php //echo $_REQUEST['userid'];?>,<?php echo $_REQUEST['mediaid'];?>)">vote</span>-->
											
											<?php //} ?>
</div>
<?php }?>

<?php } else {
			if($view == 'displayfinao') {
			
			
			$imagesrc1=$this->cdnurl."/images/uploads/finaoimages/".$uploaddetails['uploadfile_name'];
			//$filename= "http://dev-v2.skootweet.com/images/uploads/finaoimages/".$uploaddetails['uploadfile_name'];
			$filename = Yii::app()->basePath .'/../'.$uploaddetails["uploadfile_path"].'/'.$uploaddetails["uploadfile_name"];
			//$filename= "http://dev-v2.skootweet.com/images/uploads/finaoimages/".$uploaddetails['uploadfile_name'];
			//echo $filename;die();
			if($uploaddetails['uploadfile_name']!=NULL){$value = resize_values($filename);}
			
			else if($uploaddetails["uploadfile_name"]==""){
						if(isset($_REQUEST['frendid'])){ 	
						$imagesrc1=$this->cdnurl."/images/uploads/profileimages/".$frendinfo['profile_image'];}
						else { $imagesrc1=$this->cdnurl."/images/uploads/profileimages/".$finaosuserprofile['profile_image']; }
			
			}
			else if($frendinfo['profile_image']=="" || $finaosuserprofile['profile_image']==""){
			
				$imagesrc1=Yii::app()->baseUrl."/images/no-image.jpg";	
			}
			
			
}
			else if($view == 'displayimage') {
			//print_r($displayimage);die();
			$filename = Yii::app()->basePath .'/../'.$displayimage["uploadfile_path"].'/'.$displayimage["uploadfile_name"];
			//$filename="http://dev-v2.skootweet.com/images/uploads/finaoimages/".$displayimage['uploadfile_name'];
			$imagesrc1= $this->cdnurl."/images/uploads/finaoimages/".$displayimage['uploadfile_name'];
			$value = resize_values($filename);
}

?>
<div class="share-image-area" style="background: url('<?php echo $imagesrc1; ?>') center center no-repeat #000; width:<?php echo $value['0'];?>px; height:<?php echo $value['1'];?>px;" >
         <!--   <div class="share-image-area"><img src="<?php //echo $getimagesrc1; ?>" />--> 
									<div class="image-caption1"><?php if($view == 'displayfinao'){  $check=  $uploaddetails['caption']; 
											if ($check == 'Add Caption') {} 
											else { echo $uploaddetails['caption'];}}                                    
											else if($view == 'displayimage'){$check=  $displayimage['caption'];if ($check == 'Add Caption') {} else {echo $displayimage['caption'];}}?></div><?php }?>
            </div>
            <div class="finao-message padding-10pixels font-20px left" style="line-height:36px;"><?php if($view == 'displayvideo'){echo $finaovideoprofile['finao_msg'];}
				                                                   else if($view == 'displayfinao'){ echo $finaoprofile['finao_msg'];}
																   else if($view == 'displayimage'){ echo $finaoimageprofile['finao_msg'];}?></div>
        </div>
</div>
<div id="footer">
     <div class="footer-left">

    	<a href="<?php echo Yii::app()->createUrl('profile/aboutus'); ?>">About FINAO</a> |

    	<!--<a href="<?php echo Yii::app()->createUrl('profile/landing'); ?>">Explore FINAO</a> |-->

       <?php /*?> <a href="<?php echo Yii::app()->createUrl('profile/finaogives'); ?>">FINAO Gives</a> |<?php */?>

    	<a  href="<?php echo Yii::app()->createUrl('profile/faq'); ?>">FAQ</a> |

        <a  href="<?php echo Yii::app()->createUrl('profile/grouppurchase'); ?>">Group Purchase</a> |

        <a  href="<?php echo Yii::app()->createUrl('profile/terms'); ?>">Terms of Use</a> |
		 <a  href="<?php echo Yii::app()->createUrl('profile/privacy'); ?>">Privacy Policy</a> |
        <a  href="<?php echo Yii::app()->createUrl('profile/contactus'); ?>">Contact Us</a>

    </div>
    <div class="footer-right">
    	<!--<span class="follow-me">Follow Us On:</span>-->
    	<ul>
            <a target="_blank" href="https://www.facebook.com/FINAONation"><li class="facebook">&nbsp;</li></a>
            <a target="_blank" href="http://www.linkedin.com/company/2253999"><li class="linkedin">&nbsp;</li></a>
            <a target="_blank" href="http://pinterest.com/finaonation/"><li class="pinterest">&nbsp;</li></a>
            <a target="_blank" href="https://twitter.com/FINAONation"><li class="twitter">&nbsp;</li></a>
       </ul>
    </div>
    <div class="clear"></div>
    <div class="copyrights">&copy; Copyright 2013. All Rights Reserved. FINAO</div>
</div>
<script type="text/javascript">
function myFunction(userid,videoid)
{
var url='<?php echo Yii::app()->createUrl("/finao/voteVideo"); ?>';
$.post(url, { voteduserid:userid, videoid:videoid,voteruserid:<?php echo Yii::app()->session['login']['id']; ?> },
		function(data){$('#vote').attr('onclick','');$('#vote').html('voted');$('#vote').attr('class','votevideo1'); });
}
 </script>
