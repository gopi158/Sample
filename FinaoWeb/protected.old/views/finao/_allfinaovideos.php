<?php //echo ; ?>
<script type="text/javascript">
function mailFunction(videoid,frendid,userid){
	var url='<?php echo Yii::app()->createUrl("/finao/mail"); ?>';
	$.post(url, { videoid : videoid, frendid :frendid,userid:userid});
  alert('You have marked this Video as inappropriate. A mail has been sent to the Admin successfully.');
  return false;
}
</script>
<?php 
if($view == 'populatevideogallery')
{  ?>
	  
	<!--onclick="videogallery(<?=$eachImgVid['uploadedby']?>,1,'Video','populatevideos')
    displayalldata(<?php echo $userid;?>,<?php echo $prev;?>,'videos');
    -->	 
<?php if($noofpages>1){
	 
if($prev<=$noofpages)
{?>   
<a  onclick="videogallery(<?php echo $userid;?>,'<?php echo $groupid; ?>',<?php echo $prev;?>,'Video','populatevideos');" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>
<?php 
} ?>
<?php if($next<=$noofpages){?>
<!-- <a  class="slider-navigation-right" href="javascript:void(0)">&nbsp;
</a>-->

<a onclick="videogallery(<?php echo $userid;?>,'<?php echo $groupid; ?>',<?php echo $next;?>,'Video','populatevideos');" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;
	</a>
<?php } }?>

<?php foreach($uploadvideoinfo as $eachImgVid){ ?>
  
    <div class="">
    <?php if(!empty( $eachImgVid['videoid'])){?> 
	<iframe width="530" height="360" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" src="//www.viddler.com/embed/<?=$eachImgVid['videoid']?>/?f=1&amp;player=simple&amp;secret=<?=$eachImgVid['videoid']?>" id="viddler-<?=$eachImgVid['videoid']?>"></iframe>
    
    
    
	<?php }else{ ?> 
	<?php echo  $eachImgVid['video_embedurl'];?>
	<?php } ?>
	 
    </div>

<div id="caption" class="video-caption-share">
 <span class="video-caption-popup">
 
 <?php 
			//$check=$eachImgVid['video_caption']; 
	/*if ($check == 'Add Caption') {

} else {*/
     echo $eachImgVid['video_caption']; 
/*}*/
			?>
 
 
 
 </span>
 <?php 

//REPLACE SPACES OF URL DATA WITH + IN ALL PLACES
//DATA FOR SHARING ON FACEBOOK

 $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);
  if($eachImgVid['video_img']==NULL)
								{
									$imgsrcenc =  $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"];
									}
									else
									{
									
						 $imgsrcenc =  $eachImgVid['video_img'];
									}
// $imgsrcenc=$eachImgVid['video_img']; 
 $imgsrcenc = urlencode($imgsrcenc);
 $summary = Yii::app()->session['login']['username'].'+shared+a+Video+in+finaonation.com';
 $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/share/mediaid/".$eachImgVid['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']."/frendid/".$userid; 
 $urlpath1 = urlencode($urlpath);
?>


<?php 	 if($userid!=Yii::app()->session['login']['id']) { ?>
<span class="sharing-container right">
<span ><img src="<?php echo $this->cdnurl;?>/images/icon-flag.png" width="18" height="18" style="cursor:pointer;" id="flag" alt="FLAG" onclick="mailFunction('<?php echo $eachImgVid['uploaddetail_id'];?>','<?php echo $userid;?>','<?php echo Yii::app()->session['login']['id'];?>');""/>
<b>Flag inappropriate |</b></span>
<span class="bolder" style="margin-right:3px;">SHARE</span>

<a href="<?php echo $urlpath1; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION	&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 
      'facebook-share-dialog', 
      'width=626,height=436'); 
    return false;">
<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="16" height="16" />
</a>
<a href="<?php echo $urlpath1; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/profile/share/mediaid/<?php  echo  $eachImgVid['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="16" height="16" /></a>
<span id="infomail"></span> 
</span>

<?php } else{?> <?php 

//REPLACE SPACES OF URL DATA WITH + IN ALL PLACES
//DATA FOR SHARING ON FACEBOOK

 $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);
 //$imgsrcenc=$eachImgVid['video_img']; 
 if($eachImgVid['video_img']==NULL)
								{
									$imgsrcenc =  $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"];
									}
									else
									{
									
						 $imgsrcenc =  $eachImgVid['video_img'];
									}
  $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/share/mediaid/".$eachImgVid['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']; 
 $urlpath1 = urlencode($urlpath);
 $imgsrcenc = urlencode($imgsrcenc);
 $summary = Yii::app()->session['login']['username'].'+shared+a+Video+in+finaonation.com';
 
?>
<span class="sharing-container right">
<span class="left bolder" style="margin-right:3px;">SHARE</span>
<a href="<?php echo $urlpath1; ?>" 
 onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 
      'facebook-share-dialog', 
      'width=626,height=436'); 
    return false;">
<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="16" height="16" />
</a>
<a href="https://twitter.com/share?url=<?php echo $urlpath1; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/profile/share/mediaid/<?php  echo  $eachImgVid['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="16" height="16" /></a>
<?php }?>
 
 </span>
 
</div>

<?php } ?>
         
	</div> 
	
<?php }
else
{?>
	<?php //print_r($uploadinfo) ;exit; ?>

  <div class="<?php if($groupid) echo 'tiles-container-group'; else echo 'tiles-container';?>">
            
            	<div class="tile-container-navigation">
                    
					
	<?php if($noofpages>1){
    if($prev<=$noofpages)
    {?>  <!-- getprevImgVid(<?php echo $prev;?>,<?php echo $userid;?>,'prev','','<?php echo $uploadtype;?>','<?php echo $pagetype;?>')   getprevImgVid(<?php echo $next;?>,<?php echo $userid;?>,'next','','<?php echo $uploadtype;?>','<?php echo $pagetype;?>')-->
    <a  onclick="displayalldata(<?php echo $userid;?>,'',<?php echo $prev;?>,'videos');" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>
    <?php 
    } ?>
    <?php if($next<=$noofpages){?>
   <!-- <a  class="slider-navigation-right" href="javascript:void(0)">&nbsp;
    </a>-->
    
    <a onclick="displayalldata(<?php echo $userid;?>,'',<?php echo $next;?>,'videos');" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;
					</a>
    <?php } }?>
					
					
					
				 
                </div>
            
            	<div class="detailed-container">
                	
                    
<?php $i =0; foreach($uploadinfo as $eachImgVid){$i++; ?>
 <?php
if($uploadtype == 'Video')
{  ?>
    
     <?php //if(file_exists($thumb)) {?>
     <?php if($eachImgVid["videostatus"] != 'ready')
        { 
        $vidimg = Yii::app()->baseUrl."/images/video-encoding.jpg";
        }else
        {
        $vidimg = $eachImgVid["video_img"];
        } 
        ?>	
     		
<a class="fancybox123" rel="" href="#inline1" onclick="videogallery(<?=$eachImgVid['uploadedby']?>,'<?php echo $groupid; ?>',<?=$i;?>,'Video','populatevideos');" title="<?php //echo $eachImgVid["caption"]  ?>">
                    <div class="gallery-thumb smooth thumb-container-square">
                        <img src="<?php echo $vidimg; ?>" width="90" height="90"    />                </div> </a>
                        
    <?php //}?>
<?php }?>

<?php } ?>
</div>
                
            </div>
            
            
          
            
          
            
<?php } ?>