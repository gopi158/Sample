<div>
<table >
<td >
<?php $findalltiles = Lookups::model()->findAllByAttributes(array('lookup_type'=>'tiles'));?>
<?php $userid = Yii::app()->session['login']['id'];?>
<h3>Tracking</h3>
<?php foreach ($findalltiles as $tiledisplay){ ?>
<?php 
$getcount = Tracking::model()->findAllByAttributes(array('tracked_tileid'=>$tiledisplay->lookup_id,'tracker_userid'=>$userid,'status'=>1));
if(count($getcount) > 0){?>
	<br></br><div><a ><div id = "plusimg-<?php echo $tiledisplay->lookup_id;?>"><img src = "<?php echo Yii::app()->baseUrl;?>/images/plus.gif" onClick="showusers(<?php echo $tiledisplay->lookup_id;?>)"></img></div><div id = "minusimg-<?php echo $tiledisplay->lookup_id;?>" style="display:none"><img src = "<?php echo Yii::app()->baseUrl;?>/images/minus.gif" onClick="hideusers(<?php echo $tiledisplay->lookup_id;?>)"></img></div></a></div><?php echo $tiledisplay->lookup_name .'('.count($getcount).')'; ?>; 
	<?php }
foreach($getcount as $getusers){
	$users = User::model()->findByAttributes(array('userid'=>$getusers->tracked_userid));?>
	
	<div id = "trackinguser-<?php echo $tiledisplay->lookup_id;?>" style="display:none"><?php echo '<br />'.$users->fname;?></div>
<?php } ?>
<?php } ?>
</td>
<td style="padding-left:650px">
<h3>Trackers</h3>
<?php foreach ($findalltiles as $tiledisplay){ 
$gettrackercount = Tracking::model()->findAllByAttributes(array('tracked_tileid'=>$tiledisplay->lookup_id,'tracked_userid'=>$userid,'status'=>1)); ?>
<?php 
if(count($gettrackercount) > 0){?>
	<br></br><div><a ><div id = "plusimgg-<?php echo $tiledisplay->lookup_id;?>"><img src = "<?php echo Yii::app()->baseUrl;?>/images/plus.gif" onClick="showuserss(<?php echo $tiledisplay->lookup_id;?>)"></img></div><div id = "minusimgg-<?php echo $tiledisplay->lookup_id;?>" style="display:none"><img src = "<?php echo Yii::app()->baseUrl;?>/images/minus.gif" onClick="hideuserss(<?php echo $tiledisplay->lookup_id;?>)"></img></div></a></div><?php echo $tiledisplay->lookup_name .'('.count($gettrackercount).')'; ?>; 
<?php } ?>
<?php foreach($gettrackercount as $getusers){
	$users = User::model()->findByAttributes(array('userid'=>$getusers->tracker_userid)); ?>
	
	<div id = "trackinguserr-<?php echo $tiledisplay->lookup_id;?>" style="display:none"><?php echo '<br />'.$users->fname;?></div>
<?php } ?>
<?php } ?>
</td>
</table>
</div>
<script type="text/javascript">
function showusers(id)
{
		document.getElementById('trackinguser-'+id).style.display = "block";
		document.getElementById('minusimg-'+id).style.display = "block";
		document.getElementById('plusimg-'+id).style.display = "none";
}
function hideusers(id)
{
	document.getElementById('trackinguser-'+id).style.display = "none";
	document.getElementById('plusimg-'+id).style.display = "block";
	document.getElementById('minusimg-'+id).style.display = "none";
}
function showuserss(id)
{
		document.getElementById('trackinguserr-'+id).style.display = "block";
		document.getElementById('minusimgg-'+id).style.display = "block";
		document.getElementById('plusimgg-'+id).style.display = "none";
}
function hideuserss(id)
{
	document.getElementById('trackinguserr-'+id).style.display = "none";
	document.getElementById('plusimgg-'+id).style.display = "block";
	document.getElementById('minusimgg-'+id).style.display = "none";
}
</script>