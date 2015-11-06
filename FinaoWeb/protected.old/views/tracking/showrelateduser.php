<div class="search-sort padding-15pixels">
<div class="orange font-20px left">Results For <?php echo $tilename; ?></div>
<div class="search-results">
<?php $userid = Yii::app()->session['login']['id']; ?>
<?php
foreach($userrelatedtotiles as $relatetiles){?>

	<?php 
	$finduser = User::model()->findByAttributes(array('userid'=>$relatetiles->userid));
	$image = UserProfile::model()->findByAttributes(array('user_id'=>$relatetiles->userid));
	if($image->profile_image != ""){
		$profileimage = Yii::app()->baseUrl."/images/uploads/profileimages/".$image->profile_image;
		
	}else{
		$profileimage = Yii::app()->baseUrl."/images/no-image.jpg";
	}
	 if($finduser->userid != Yii::app()->session['login']['id']){
	if(!empty($finduser)){
	$checktracktilestatus = Tracking::model()->findAllByAttributes(array('tracked_tileid'=>$relatetiles->tile_id,'tracked_userid'=>$finduser->userid,'status'=>0,'tracker_userid'=>$userid));
	$checktracktile = Tracking::model()->findAllByAttributes(array('tracked_tileid'=>$relatetiles->tile_id,'tracked_userid'=>$finduser->userid,'status'=>1,'tracker_userid'=>$userid));
	$counttrackers = count($checktracktile);?>
	<input type="hidden" id="tileid" value="<?php echo $relatetiles->tile_id;?>"/>
	    
		<div class="results-tab">
		<div class="profile-pic-img">
		<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/'.$finduser->userid); ?>">
			<img width="100" src="<?php echo $profileimage; ?>">
		</a>
		</div>
		<div class="person-name">
			<p class="padding-10pixels">
		<a class="orange-link font-16px" href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/'.$finduser->userid); ?>"><?php echo $finduser->fname;?></a>
		</p>
		<p class="font-13px"><?php echo $finduser->location;?></p>
		</div>
		<?php if($counttrackers > 0)
		{?>
			<div class="tracks font-14px"><?php echo $counttrackers; ?> Trackers</div>
		<?php }else{ ?>
 			<div class="tracks font-14px">No Trackers</div>
		
		<?php }?>
		<div class="track">
		<?php if(!empty($checktracktilestatus)){?>
		<input class="orange-button" type="button" value="Request Pending">
		<?php }else{
		if(!empty($checktracktile))
			{?>
				<input type ="hidden" id="tileid" value ="<?php echo $relatetiles->tile_id; ?> " />
				<input type ="hidden" id="frndid" value ="<?php echo $finduser->userid; ?> " />
				<div id = "untrackid-<?php echo $finduser->userid;?>"><input class="orange-button" type="button" onClick = "getuntracktileid(<?php echo $finduser->userid;?>,<?php echo $relatetiles->tile_id; ?>)" value="UnTrack"/></div><br />
			<?php }else{  ?>
				<div id = "trackid-<?php echo $finduser->userid;?>"><input class="orange-button" type="button" onClick = "trackusertilesall(<?php echo $finduser->userid;?>,<?php echo $relatetiles->tile_id; ?>)" value="Track"/></div><br />
			<?php } }?>
			
	<?php }
	else {
		echo "No Users Found Under This Tile";
	}?>
		</div>
		</div>
		
	<?php }
}
?>
</div>
<script type="text/javascript">
function trackusertilesall(id,tileid)
{
	//var tileid = document.getElementById('tileid').value;
	var tileid = tileid;
	var frndid = id;
	var url='<?php echo Yii::app()->createUrl("/tracking/saveTracktiles"); ?>';
 	$.post(url, { tileid :  tileid , frndid : frndid},
   		function(data){
				$("#trackid-"+id).html(data);
		});

}
function getuntracktileid(id,tileid)
{
 	//var tileid = document.getElementById('tileid').value;
	var tileid = tileid;
	var frndid = id;
	var url='<?php echo Yii::app()->createUrl("/tracking/deleteTracktiles"); ?>';
 	$.post(url, { tileid :  tileid , frndid : frndid},
   		function(data){
				$("#untrackid-"+frndid).html(data);
		});
}
</script>
