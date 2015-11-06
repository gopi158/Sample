<style>
.votevideo{  padding:0 10px; float:right; cursor: pointer;}
.votevideo1{ padding:0 10px; cursor: auto; float:right;}
</style>

<script type="text/javascript">
$(document).ready(function(){

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
});
<?php }?>

<?php 
if(!empty($vconfirm) and $vconfirm == 'true'){?> 

$("#registered2").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,
		'hideOnOverlayClick' : false,
		'autoScale'           : true,
		  'fixed': false,
         'resizeOnWindowResize' : false
	});
$("#registered2").trigger('click');	
});

<?php }?>

</script>
<a id="registered1" href="#registeredcontent1" ></a>
<a id="registered2" href="#registeredcontent2" ></a>
<div  style="display:none;">

				<div id = "registeredcontent1">
                	
                    <div class="signin-popup" id="login_form3" style="text-align:center;">
    	              <span class="orange font-20px padding-10pixels">Thank you for Joining the FINAO Nation</span><br />
                     Please set your password by clicking on the confirmation mail sent to your email within next 24 Hours.   
                    </div>
               
                </div>    
</div>


<div  style="display:none;">

				<div id = "registeredcontent2">
                	
                    <div class="signin-popup" id="login_form3" style="text-align:center;">
    	              <span class="orange font-20px padding-10pixels">Thank you for Uploading Video</span><br />
                     Your Video has been uploaded and is being encoded. It will be published after the Administrator approves the Video.   
                    </div>
               
                </div>    
</div>






<div class="main-container">
<div class="finao-canvas">
<?php if($_GET['tile_name']==''){?>
	<div style="width:100%; float:left;">
                <span class="orange left font-25px padding-10pixels"><img src="<?php echo $this->cdnurl;?>/images/hbcuconnect-logo.png" width="160" /> Contest</span>
                <span class="right">
   
<input type="button" onclick="goURl('new');" class="orange-button-hbcu-big" value="Submit Your Entry" />                  <input type="button" onclick="goURl('home');" class="orange-button-hbcu-big" value="Goto My Homepage" />
              
                </span>
            </div>
	<span class="orange font-14px left padding-10pixels">Number of Entries <?php echo $tilename."(".$totalcnt.")"; ?> </span>		
<?php } else {?>			
   	<span class="my-finao-hdline orange">Search Results - <?php echo $tilename."(".$totalcnt.")"; ?> </span>
<?php }?>			
            <div class="search-results">
            <?php //print_r($userdets); 			
			if(isset($userdets))
			{
				$i=0; 
				foreach($userdets as $userinfo)
				{
					$src="";
					foreach($uploaddetails as $updet)
					{
						if($userinfo["user_finao_id"] == $updet["upload_sourceid"])
						{
							if($updet["uploadfile_name"] != "")
							{
								if(file_exists(Yii::app()->basePath."/../".$updet["uploadfile_path"]."/thumbs/".$updet["uploadfile_name"]))
									$src= $this->cdnurl.$updet["uploadfile_path"]."/thumbs/".$updet["uploadfile_name"];
								elseif(file_exists(Yii::app()->basePath."/../".$updet["uploadfile_path"]."/".$updet["uploadfile_name"]))
									$src= $this->cdnurl.$updet["uploadfile_path"]."/".$updet["uploadfile_name"]; 	
										
							}elseif($updet["video_img"] != ""){
								//if(file_exists($updet["video_img"]))
									$src= $updet["video_img"];
							}
						}
						
		
					}
					if($src == "")
					{
						if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo["profile_image"]))
							$src = $this->cdnurl."/images/uploads/profileimages/".$userinfo["profile_image"];
						else
							$src = $this->cdnurl."/images/no-image.jpg";
					}
					if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo["profile_image"]) && $userinfo["profile_image"]!='' )
							$srcs = $this->cdnurl."/images/uploads/profileimages/".$userinfo["profile_image"];
						else
							$srcs = $this->cdnurl."/images/no-image.jpg";
					$sql1 = "select * from fn_video_vote where voter_userid=".Yii::app()->session['login']['id']." and voted_userid=".$userinfo['userid']; 
				$connection=Yii::app()->db; 
		$command=$connection->createCommand($sql1);
		$votevideo = $command->queryAll(); 
		?>
<script language="javascript"> 
	$(document).ready(function() {
			$('#fancybox-media'+<?php echo $i;?>).fancybox({beforeShow : function(){
   this.title =  this.title + $(this.element).data("caption");
  },'titlePosition': 'inside','titleshow':true,'width': 620,'height': 420,type: "iframe",iframe : {preload: false}});});	
	</script>	
					
						<div class="dashboard-finao-container" <?php if($_GET['tile_name']==''){?> style="height:279px;" <?php }?>>
	                        <div class="dashboard-finao-container-left">
							<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/finaoid/'.$userinfo["user_finao_id"]); ?>" >
								<img src="<?php if($_GET['tile_name']=='') echo $srcs; else echo $src; ?>" class="border" width="66" height="66" /></a>
							</div>
	                        <div class="dashboard-finao-container-right">
								<span><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$userinfo["userid"],'finaoid'=>$userinfo["user_finao_id"])); ?>" class="orange-link font-14px"><?php echo $userinfo["fname"]." ".$userinfo["lname"] ; ?> </a></span>
	                            <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$userinfo["userid"],'finaoid'=>$userinfo["user_finao_id"])); ?>" >
								<p style="height:20px!important;"><?php 
									$finaomesg = ucfirst($userinfo["finao_msg"]);
									  $maxlen = 35;
									  if(strlen($finaomesg) > $maxlen)
									  {
									  	$offset = ($maxlen-4) - strlen($finaomesg);
									  	$finaomesg = substr($finaomesg, 0, strrpos($finaomesg, ' ', $offset)). '... ';	
									  }
	     							  echo $finaomesg;
								?>
								</p>
	                            <div class="status-button-position"><img src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst($userinfo["lookup_name"]);?>.png" width="60" /></div>
							</a>	
	                        </div>
							
							<?php if($_GET['tile_name']==''){
							  $s=explode('src=',$userinfo['video_embedurl']);$ss=explode('"',$s[1]);?>
							<input type="hidden" id="img<?php echo $userinfo['uploaddetail_id'];?>" value="<?php echo $userinfo['video_img'];?>"  />
							 <div class="video-dev-search" style="background:url('<?php echo $userinfo['video_img'];?>') center center; background-repeat:no-repeat;">							 
                        <a data-caption="<img src='<?php echo $this->cdnurl;?>/images/icon-facebook.png' width='16' height='16' onclick='facebookFunction(<?php echo $userinfo['uploaddetail_id'];?>,<?php echo $userinfo['userid'];?>);' ><?php if($votevideo){ ?><span id='vote' class='votevideo1 vote-now'>voted</span><?php } else { ?> <span id='vote' class='votevideo vote-now' onclick='myFunction(<?php echo $userinfo['userid'];?>,<?php echo $userinfo['uploaddetail_id'];?>)'>Vote Now</span> <?php }?>" title="<?php echo $userinfo['video_caption'];?>" id="fancybox-media<?php echo $i;?>"  href="<?php if($userinfo['videoid']!='') echo "//www.viddler.com/embed/".$userinfo['videoid']."/?f=1&amp;player=simple&amp;secret=".$userinfo['videoid'].""; else echo $ss[1];?>" ><span class="video-link-span3">&nbsp;</span></a>	
                    </div>
							<?php }?>
					
	                    </div>
					
			<?php $i++;	
				}		
		}
		else
			{ ?>
				<span class="font-12px padding-10pixels">No Public FINAO's </span>			
	<?php	}
			?>		                
            </div>
        </div>
</div>
<script type="text/javascript">
function goURl(page)
{
	
	 
	if(page == 'home')
	{
		//alert(page);
		var rd ='<?php echo Yii::app()->createUrl("/myhome"); ?>';
		window.location=rd;
	}else
	{
		//alert(page);
		var rd ='<?php echo Yii::app()->createUrl("finao/Videocontest"); ?>';
		window.location=rd;
	}
}
function myFunction(userid,videoid)
{
var url='<?php echo Yii::app()->createUrl("/finao/voteVideo"); ?>';
$.post(url, { voteduserid:userid, videoid:videoid,voteruserid:<?php echo Yii::app()->session['login']['id']; ?> },
		function(data){$('#vote').attr('onclick','');$('#vote').html('voted');});
 }
 
function facebookFunction(videoid,frendid){

 var url='<?php echo Yii::app()->createUrl("/finao/sharevideo"); ?>';
 var imgsrc=$('#img'+videoid).val();	
var urlpath="http://<?php echo $_SERVER['HTTP_HOST'];?>/profile/share/mediaid/"+ videoid +"/userid/<?php echo Yii::app()->session['login']['id'];?>/frendid/"+ frendid +"/vote/1"; 
 var urlpath1 = encodeURIComponent(urlpath);
var summary ='<?php echo Yii::app()->session['login']['username']?> shared a Video in finaonation.com'
window.open('http://www.facebook.com/sharer.php?s=100&p[title]='+encodeURIComponent('FINAO NATION') + '&p[summary]=' + encodeURIComponent(''+summary+'') + '&p[url]=' + encodeURIComponent(''+ urlpath +'') + '&p[images][0]=' + encodeURIComponent(''+ imgsrc +''),'facebook-share-dialog','width=626,height=436'); 

}

</script>		