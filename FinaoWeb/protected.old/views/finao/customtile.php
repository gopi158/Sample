<script>
		jQuery(document).ready(function ($) {
		"use strict";
		if($('#Defaultss').length)
			$('#Defaultss').perfectScrollbar();
			$('.hbcucou').html('|<span class="orange">   Displaying Search Results for: <?php echo $userdets[0]['tilename'];?></span>');
		});
	</script>



<div class="<?php if($groupid) echo 'tiles-container-group'; else echo 'tiles-container';?>" id="Defaultss">
        <div class="tile-container-navigation">
        <?php if($finaopagedetails['noofpage'] > 1) {   ?>
        <a onclick="displayalldata(<?php echo $userid; ?>,'<?php echo $groupid ?>',<?php echo $finaopagedetails['prev'];?>,'finaos')" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>									

        <a onclick="displayalldata(<?php echo $userid; ?>,'<?php echo $groupid ?>',<?php echo $finaopagedetails['next'];?>,'finaos')" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;</a>
        <?php } ?>
        </div>


        <div class="detailed-container" style="width: 906px;height: 330px;padding: 0 30px;overflow-y: scroll;">
        <p style="height:30px;">&nbsp;</p>
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
					
						<div class="dashboard-finao-container" <?php if($_POST['tile_name']==''){?> style="height:279px;" <?php }?>>
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
							
							<?php if($_POST['tile_name']==''){
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

 <script type="text/javascript">



 </script>          