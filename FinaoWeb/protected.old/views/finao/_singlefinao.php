<?php if($finaoinfo->finaoStatus->lookup_name=="Behind")
			{
				$divclass = "journal-slider-green";
			}elseif($finaoinfo->finaoStatus->lookup_name=="On Track")
			{
				$divclass = "journal-slider-blue";
			}else
			{
				$divclass = "journal-slider-orange";
			} ?>
<div class="<?php echo $divclass;?>">
<?php $getimagesrc = Yii::app()->baseUrl."/images/logo-n.png";
		if(isset($getimages))
			if($getimages[0]["uploadfile_name"] != "")
				$getimagesrc = Yii::app()->baseUrl."/images/uploads/finaoimages/".$getimages[0]["uploadfile_name"];
			else
				$getimagesrc = Yii::app()->baseUrl."/images/logo-n.png";	
	?>

<p><?php //if(isset($getimages) && $getimages[0]["uploadfile_name"]!=""){?>
	<img width="170" style="margin-right:10px;" class="left" src="<?php echo $getimagesrc; ?>" />
	<?php //}else{ ?>
	<!--<img width="170" style="margin-right:10px;" class="left" src="<?php echo Yii::app()->baseUrl;?>/images/logo-n.png" />-->
	<?php //}?></p>
	
		<?php
		if($userid==Yii::app()->session['login']['id'])
		{  echo $share ; if(isset($share) && $share!="share"){?>
			<!--<a onclick="showeditfinaomesg(<?php echo $finaoinfo->user_finao_id;?>)"  href="javascript:void(0)">
				Edit
			</a>-->
		<?php }}?>
	
	 	<p style="min-height: 190px;padding-bottom: 10px;" id="finaomesg-<?php echo $finaoinfo->user_finao_id;?>">
			<?php echo $finaoinfo->finao_msg;?>
		</p>
		
		<p class="finao-def-msg" id="editfinaomesg-<?php echo $finaoinfo->user_finao_id;?>" style="display:none;min-height: 190px;padding-bottom: 10px;">
			<input type="text" maxlength="140" value="<?php echo $finaoinfo->finao_msg;?>" id="newmesg-<?php echo $finaoinfo->user_finao_id;?>" class="textbox" style="width:70%;"/>
			<a  id="savefinao-<?php echo $finaoinfo->user_finao_id;?>" href="javascript:void(0)"   onclick="savefinaomesg(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>)" >save</a>
			<a id="closefinao-<?php echo $finaoinfo->user_finao_id;?>" href="javascript:void(0)" onclick="closefinao(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>)">close</a>
		</p>
	
	<?php //echo $userid;
	if($userid==Yii::app()->session['login']['id'])
	{ if(isset($share) && $share!="share"){?>
		<p>
				<a href="javascript:void(0);" class="left" onclick="addimages(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>,'finao','Image')">
				<?php  $srcphoto = Yii::app()->baseUrl."/images/photos.png";
				       $srcVideo = Yii::app()->baseUrl."/images/videos.png";
						if(isset($IsImage))
						{
							if($IsImage == 1)
							{
								$srcphoto = Yii::app()->baseUrl."/images/photos-deselect.png";
				       			$srcVideo = Yii::app()->baseUrl."/images/videos.png";
							}
							else
							{
								$srcphoto = Yii::app()->baseUrl."/images/photos.png";
				       			$srcVideo = Yii::app()->baseUrl."/images/videos-deselect.png";
							}	
						}
				?>
				<img src="<?php echo $srcphoto; ?>" />
				</a>
				<a href="javascript:void(0)" class="right" onclick="addimages(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>,'finao','Video');">
				<img src="<?php echo $srcVideo; ?>" />
				</a>
			</p>
		<p class="center" style="margin-top:20px;">
				<?php
					echo "<a id='getjournal-".$finaoinfo->user_finao_id."' onclick='getalljournals(".$finaoinfo->user_finao_id.",".$userid.",0)' class='journal-entry'>Journal Entry</a>";?>
		</p>
		
		<div style="clear:both;"></div>	
		<p>	
		<div style="margin:10px 0;" id="singlefinaoupdate-singlefinao-<?php echo $finaoinfo->user_finao_id;?>">
		<ul>
		
		<?php foreach($status as $finaostatus)
		{?>
			
			<li <?php if($finaoinfo->finao_status==$finaostatus->lookup_id){?>class="active-finao" <?php }else{?> class="finao-status" <?php }?>>
				
				
			<a href="javascript:void(0)" onclick="updatefinao(<?php echo $finaoinfo->user_finao_id;?>,<?php echo $finaostatus->lookup_id;?>,<?php echo $userid;?>,'singlefinao')" ><?php echo $finaostatus->lookup_name;?></a>
			</li>
		<?php }?>
		
		</ul>
		</div>
		</p>
		 <p><span class="left"><input type="checkbox" id="ispublic-<?php echo $finaoinfo->user_finao_id;?>" onclick="updatefinaopublic(<?php echo $finaoinfo->user_finao_id;?>,<?php echo $userid;?>,'public',<?php echo $tileid;?>)" <?php if($finaoinfo->finao_status_Ispublic == 1) { echo 'checked=checked'; } ?>/> Make Public</span>  <span class="right"><input type="checkbox" id="complete-<?php echo $finaoinfo->user_finao_id;?>" onclick="updatefinaopublic(<?php echo $finaoinfo->user_finao_id;?>,<?php echo $userid;?>,'complete',<?php echo $tileid;?>)" <?php if($finaoinfo->Iscompleted == 1) { echo 'checked=checked'; } ?>/> Mark Complete</span></p>
	<?php } }
	elseif($share=="share" || $userid != Yii::app()->session['login']['id'])
	{?>
		<p>
			<a href="javascript:void(0);" class="left" >
			<img src="<?php echo Yii::app()->baseUrl;?>/images/photos.png" />
			</a>
			<a href="javascript:void(0)" class="right">
			<img src="<?php echo Yii::app()->baseUrl;?>/images/videos.png" />
			</a>
		</p>
		<p class="center" style="margin-top:20px;">
				<?php
					echo "<a id='getjournal-".$eachfinao->user_finao_id."' onclick='getalljournals(".$eachfinao->user_finao_id.",".$userid.",0)' class='journal-entry'>Journal Log</a>";?>
				</p>
	 	<?php if($eachfinao->finao_status)
				{echo '<p class="center"><a href="javascript:void(0)" class="active-finao-status">'.$eachfinao->finaoStatus->lookup_name.'</a></p>';}
	}
	
?>
</div>