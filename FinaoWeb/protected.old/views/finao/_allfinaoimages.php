 <style>.hidden { display:  none; }</style>
 <script type="text/javascript">
$(".fancybox1")
    .attr('rel', 'gallery')
    .fancybox({
        beforeLoad: function() {
            var el, id = $(this.element).data('title-id');

            if (id) {
                el = $('#' + id);
            
                if (el.length) {
                    this.title = el.html();
                }
            }
        }
    });
	

function mailFunction(a,b,c){
var url='<?php echo Yii::app()->createUrl("/finao/mail"); ?>';
$.post(url, { imageid : a, frendid :b,userid:c});
alert('You have marked this Image as inappropriate. A mail has been sent to the Admin successfully.')
}
</script>
<div class="<?php if($groupid) echo 'tiles-container-group'; else echo 'tiles-container';?>">
<div class="tile-container-navigation">
<?php if($noofpages>1){?>
		<?php 
        if($prev<=$noofpages)
        {?>  <!-- getprevImgVid(<?php echo $prev;?>,<?php echo $userid;?>,'prev','','<?php echo $uploadtype;?>','<?php echo $pagetype;?>')   getprevImgVid(<?php echo $next;?>,<?php echo $userid;?>,'next','','<?php echo $uploadtype;?>','<?php echo $pagetype;?>')-->
        <a  onclick="displayalldata(<?php echo $userid;?>,'<?php echo $groupid; ?>',<?php echo $prev;?>,'images');" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>
        <?php } ?>
        
		<?php if($next<=$noofpages){?>
        <a onclick="displayalldata(<?php echo $userid;?>,'<?php echo $groupid; ?>',<?php echo $next;?>,'images');" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;
        </a>
        <?php } ?> 
  <?php }?>

</div>
            
<div class="detailed-container">
<?php foreach($uploadinfo as $eachImgVid){
$tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$eachImgVid['upload_sourceid']));
		if($eachImgVid["upload_sourcetype"]=='37')
			{
			 	$finaomsg = UserFinao::model()->findByPk($eachImgVid['upload_sourceid']);
				$finaomsg=$finaomsg->finao_msg;
			}
			else if($eachImgVid["upload_sourcetype"]=='36') 
			{
				$finaomsg = TilesInfo::model()->findByAttributes(array('tile_id'=>$eachImgVid['upload_sourceid']));
				$finaomsg=$finaomsg->tilename; 
			}
			else  
			{
				$finaomsg = UserFinaoJournal::model()->findByAttributes(array('finao_id'=>$eachImgVid['upload_sourceid'],'user_id'=>$_REQUEST['userid']));
				$finaomsg=$finaomsg->finao_journal;
				//print_r($uploadinfo[0][upload_sourceid]);exit;
			}
	
 if($uploadtype == 'Image')
 { 	
     if(file_exists(Yii::app()->basePath."/../".$eachImgVid["uploadfile_path"]."/thumbs/".$eachImgVid["uploadfile_name"]) && $eachImgVid["uploadfile_name"] != "") 
	 { 
	   $path = "/thumbs/"; 
	   ?>
      
	 <a class="fancybox1 black-link font-14px" rel="gallery1" data-title-id="title-<?php echo $eachImgVid['uploaddetail_id'];?>" href="<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"];?>" title="<?php //echo $eachImgVid["caption"]; ?>">
        <div class="gallery-thumb smooth thumb-container-square" style=" overflow:hidden;background:url('<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"].$path.$eachImgVid["uploadfile_name"];?>') center center; width:90px; height:90px;"  >       
        </div> 
	</a>
		<div id="title-<?php echo $eachImgVid['uploaddetail_id'];?>" class="hidden">
			<b style=" margin-left:10px;"><?php 
			$check= $eachImgVid["caption"]; 
	if ($check == 'Add Caption') {

} else {
     echo $eachImgVid["caption"]; 
}
		
			
			
			?></b> 
	
	 
	 
			<!--<div style="width:100px; float:left">&nbsp;</div>-->
	<?php /*?><a class="view_finaos<?php echo $eachImgVid['uploaddetail_id'];?> right font-13px orange-link"  style=" margin-right:10px; margin-top:3px; "href="javascript:void(0);" onclick="view_finao_det('<?php echo $eachImgVid['uploaddetail_id'];?>');">View <?php if($eachImgVid["upload_sourcetype"]=='37') echo 'FINAO'; else if($eachImgVid["upload_sourcetype"]=='36') echo 'Tile';else echo 'Journal'; ?> </a><?php */?>

<?php 	 if($userid!=Yii::app()->session['login']['id']) {
		             $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);
					 
					 
					  if(file_exists(Yii::app()->basePath."/../".$eachImgVid["uploadfile_path"]."/medium/".$eachImgVid["uploadfile_name"]))
								{
									$imgsrcenc =  $this->cdnurl.$eachImgVid["uploadfile_path"]."/medium/".$eachImgVid["uploadfile_name"];
									}
									else
									{
									
						 $imgsrcenc =  $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"];
									}
					 
	               // $imgsrcenc =  $this->cdnurl.$eachImgVid["uploadfile_path"]."/medium/".$eachImgVid["uploadfile_name"];
	                 $imgsrcenc =  urlencode($imgsrcenc);
 $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/share/mediaimageid/".$eachImgVid['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']."/frendid/".$userid;
 $urlpath1 = urlencode($urlpath);
	 
	                $summary = Yii::app()->session['login']['username'].'+shared+an+Image+in+finaonation.com'; 
	 ?>
			<span class="sharing-container right" style=" margin-right:10px; margin-top:2px;">
	<span id="infomail"></span>  
   <img src="<?php echo $this->cdnurl;?>/images/icon-flag.png" width="18" height="18" alt="FLAG" onclick="mailFunction('<?php echo $eachImgVid['uploaddetail_id'];?>','<?php echo $userid;?>','<?php echo Yii::app()->session['login']['id'];?>');" style="cursor:pointer;" />
   <b>Flag inappropriate |</b><span style=" clear:both;"></span>
   <span class="bolder" style="margin-right:3px;">SHARE</span>	
		<a href="<?php echo $urlpath1; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION	&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 'facebook-share-dialog','width=626,height=436');return false;">
		<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="16" height="16" />
		</a>		
		<!-- facebook sharing ends -->
		
		<!-- Twitter sharing starts -->				
		<a href="https://twitter.com/share?url=http%3A%2F%2Ffinaonationb.com%2Fprofile%2Fshare%2Fmediaimageid%2F<?php echo $eachImgVid['uploaddetail_id'];?>%2Fuserid%2F<?php echo Yii::app()->session['login']['id']; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/myhome/finao/<?php echo $eachImgVid['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="16" height="16" /></a>
		<!-- Twitter sharing ends -->
	</span>
	</span><?php }else{?>
	<span class="sharing-container right" style=" margin-right:10px; margin-top:2px;">
<span class="left bolder" style="margin-right:3px;">SHARE</span>
	 <?php $fnmsg = str_replace(' ', '+',$eachfinao->finao_msg);
  if(file_exists(Yii::app()->basePath."/../".$eachImgVid["uploadfile_path"]."/medium/".$eachImgVid["uploadfile_name"]))
								{
									$imgsrcenc =  $this->cdnurl.$eachImgVid["uploadfile_path"]."/medium/".$eachImgVid["uploadfile_name"];
									}
									else
									{
									
						 $imgsrcenc =  $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"];
									}
	 $imgsrcenc =  urlencode($imgsrcenc);
	 $urlpath="http://".$_SERVER['HTTP_HOST']."/profile/share/mediaimageid/".$eachImgVid['uploaddetail_id']."/userid/".Yii::app()->session['login']['id']; 
 $urlpath1 = urlencode($urlpath);
	 
	 $summary = Yii::app()->session['login']['username'].'+shared+an+Image+in+finaonation.com';?>
		<a href="<?php echo $urlpath1; ?>" onclick="window.open('https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=FINAO+NATION	&amp;p[url]=<?php echo $urlpath1; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[images][0]=<?php echo $imgsrcenc; ?>', 'facebook-share-dialog','width=626,height=436');return false;">
		<img src="<?php echo $this->cdnurl;?>/images/icon-facebook.png" width="16" height="16"/>
		  </a>		
		  <!--  facebook sharing ends -->
		
		<!-- Twitter sharing starts -->				
		<a href="https://twitter.com/share?url=http%3A%2F%2Ffinaonationb.com%2Fprofile%2Fshare%2Fmediaimageid%2F<?php echo $eachImgVid['uploaddetail_id'];?>%2Fuserid%2F<?php echo Yii::app()->session['login']['id']; ?>" class="twitter-share-button" data-url="<?php echo $this->cdnurl;?>/myhome/finao/<?php echo $eachImgVid['uploaddetail_id'];?>/userid/<?php echo Yii::app()->session['login']['id']; ?>" target="_blank"><img src="<?php echo $this->cdnurl;?>/images/icon-twitter.png" width="16" height="16" /></a>
		
		<!-- Twitter sharing ends --><?php }?>
					
		<span style="display:none; cursor:pointer; color:#343434; text-align:right; width:100%;" class="right padding-10pixels font-14px sam<?php echo $eachImgVid['uploaddetail_id'];?>" <?php if($eachImgVid["upload_sourcetype"]=='37') {?> onclick="getfinaos(<?php echo $tileid->userid;?>,<?php echo $tileid->tile_id;?>);" <?php } else if($eachImgVid["upload_sourcetype"]=='36'){}else {?> onclick="viewjournal(0,<?php echo $finao_id; ?>,<?php echo $tileid->userid;?>,'completed',<?php echo $page;?>);" <?php }?> > <?php echo $finaomsg; ?> </span>
		
				
	</div>
       
	 <?php }else{ $path = "/";?>
     
       <a class="fancybox" rel="gallery1" href="<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"];?>" title="<?php echo $eachImgVid["caption"]; ?>">
        <div class="gallery-thumb smooth thumb-container-square"    >
        <img src="<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"].$path.$eachImgVid["uploadfile_name"];?>"  width="90" height="90"/>         
        </div> 
        </a>
	 <?php } ?>			

<?php }?>
<?php } ?>
</div>
                
</div>

            
       

            