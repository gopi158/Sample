<?php $j=0;
	 foreach($userdets as $userinfo)
		{ $j++;
			if($userinfo['videoid']=='') { $s=explode('src=',$userinfo['video_embedurl']);$ss=explode('"',$s[1]); $src=$ss[1];} else { $src="//www.viddler.com/embed/".$userinfo['videoid']."/?f=1&amp;player=simple&amp;secret=".$userinfo['videoid'].""; }
			$sql1 = "select * from fn_video_vote where voter_userid=".Yii::app()->session['login']['id']." and voted_userid=".$userinfo['userid']; 
		$connection=Yii::app()->db; 
		$command=$connection->createCommand($sql1);
		$votevideo = $command->queryAll(); ?>	
			<div class="hbcu-video-big">
				<div class="hbcu-big-video-top"><iframe src="<?php echo $src;?>" width="310" height="210" ></iframe></div>
				<div class="hbcu-big-video-bottom">
					<div class="hbcu-big-video-finao">
					<?php echo substr(ucfirst($userinfo["finao_msg"]),0,40);?>
                    
                    </div>							
					<div class="font-12px"  style="padding-bottom: 5px;">by <span class="orange"><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$userinfo["userid"],'finaoid'=>$userinfo["user_finao_id"])); ?>" class="orange-link font-12px"><?php echo $userinfo["fname"]." ".$userinfo["lname"] ; ?> </a></span></div>
					<div style="float:right"><?php if($votevideo){ ?><span id='vote' class='votevideo1 voted-now'>voted</span><?php } else { ?> <span id='votes<?php echo $userinfo['uploaddetail_id'];?>' class='votevideo vote-now' onclick='myFunctions(<?php echo $userinfo['userid'];?>,<?php echo $userinfo['uploaddetail_id'];?>,<?php echo $j;?>)'>Vote Now</span> <?php }?></div>
				</div>
			</div>
		<?php }?><div class="clear"></div>
		 <div id="more<?php echo $msg_id; ?>" class="morebox"></div>
			   <div class="center" id="remove<?php echo $msg_id; ?>"><a href="javascript:void(0)" class="more" id="<?php echo $msg_id; ?>"><img class="show-more-btn" src="<?php echo $this->cdnurl;?>/images/btn-showmore.jpg"></a>	
					