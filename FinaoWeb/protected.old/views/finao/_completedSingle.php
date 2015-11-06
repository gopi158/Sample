	<?php
	if($eachfinao->finaoStatus->lookup_name=="Behind")
	{
		$divclass = "journal-slider-green";
	}elseif($eachfinao->finaoStatus->lookup_name=="On Track")
	{
		$divclass = "journal-slider-blue";
	}else
	{
		$divclass = "journal-slider-orange";
	}
?>
	<div class="single-finao">
	<div class="single-finao-left center">
	<?php $getimagesrc = Yii::app()->baseUrl."/images/logo-n.png";
		if(isset($getimages))
			foreach($getimages as $allimages)
			{
				if($allimages["upload_sourceid"] == $eachfinao->user_finao_id)
				{
					$getimagesrc = Yii::app()->baseUrl."/images/uploads/finaoimages/".$allimages['uploadfile_name'];
				}
			}
	?>
	<div class="profile-picture">
	<img width="170" style="margin-right:10px;" class="left" src="<?php echo $getimagesrc ; ?>" /></div>
	<p class="font-14px"><?php echo $allimages["caption"]; ?></p>
	</div>
	 <div class="single-finao-right">
	 	<div class="myfinao-hdline">
			<div class="font-20px padding-8pixels bolder left">MY FINAO</div>
			<div class="right orange font-16px bolder"><?php echo $tileid->tile_name;?></div>
		</div>
		<p class="my-finao-msg padding-10pixels" id="finaomesg-<?php echo $eachfinao->user_finao_id;?>">
			<?php echo $eachfinao->finao_msg;?>
		</p>
		
			
			<p class="center" style="margin-top:20px;">
				
					<a id="getjournal-<?php echo $eachfinao->user_finao_id;?>" onclick="getalljournals(<?php echo $eachfinao->user_finao_id;?>,<?php echo $userid;?>,'completed')" class="journal-entry">Journal Log</a>
				</p>
                <div style="clear:both;"></div>
				<?php $tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$eachfinao->user_finao_id,'userid'=>$eachfinao->userid));
				?>
				<!--<img src="<?php //echo Yii::app()->baseUrl;?>/images/tiles/<?php //echo strtolower($tileid->tile_name);?>.png" width="45"/>-->
				<div class="track-buttons">
				<span class="left">
					<ul class="tracking left">
						<?php
							     if($eachfinao->finaoStatus->lookup_name=="Behind"){
							       $class="behind-btn behind-active"; 
							     }elseif($eachfinao->finaoStatus->lookup_name=="Ahead"){
							        $class="ahead-btn ahead-active" ;
							     }elseif($eachfinao->finaoStatus->lookup_name=="On Track"){
							       $class="ontrack-btn ontrack-active";
							     }?>
						
						 <?php if(isset($eachfinao->finao_status)){	?>
								<a href="javascript:void(0)"><li class="<?php echo $class;?>"></li></a>
							<?php
							   }
							?>
					</ul>
				</span>
				</div>
				
    </div>
	</div>