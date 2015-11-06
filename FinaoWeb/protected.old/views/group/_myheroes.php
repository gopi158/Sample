<script>
	jQuery(document).ready(function ($) {
	"use strict";
	if($('#Default7').length)
		$('#Default7').perfectScrollbar();
	});
</script>

<?php 
$userfinding1 = User::model()->findByPk($userid); ?>   

<?php if(Yii::app()->session['login']['id'] == $userid && $share != "share") { ?>

<div class="font-14px padding-10pixels orange" style="width:220px;float:left;">Activity of people I am following </div>

<?php }else{ ?>

<div class="font-16px padding-10pixels" >Activity of people <?php echo ucfirst($userfinding1->fname); ?> is following </div>

<?php } ?>

<div class="right show-links" style="display:block;"><a href="javascript:void(0)" class="orange-link" id="show" onclick="showheroes('show')">&darr; People <?php if(Yii::app()->session['login']['id'] == $userid && $share != "share"){?>I am <?php }else{?> <?php echo ucfirst($userfinding1->fname)." is"; ?><?php }?> following</a><a href="javascript:void(0)" class="orange-link" id="hide" onclick="showheroes('hide')" style="display:none;">&uarr; People <?php if(Yii::app()->session['login']['id'] == $userid && $share != "share"){?>I am <?php }else{?> <?php echo ucfirst($userfinding1->fname)." is "; ?><?php }?> following</a></div>

<div class="clear"></div>
		<div id="myheroes" style="display:none;">
		<?php if(isset($users) && !empty($users)){?>
		<?php foreach($users as $eachuser){ 
		$profileimg = "";
		$user = UserProfile::model()->findByAttributes(array('user_id'=>$eachuser->userid));
		if(isset($user) && isset($user->profile_image))
			$profileimg = $this->cdnurl."/images/uploads/profileimages/".$user->profile_image;
		else
			$profileimg = $this->cdnurl."/images/no-image-small.jpg";
			?>
			<div class="friend-pic"><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/'.$eachuser->userid);?>"><img src="<?php echo $profileimg; ?>" width="35" height="35" title="<?php echo ucfirst($eachuser->fname)." ".ucfirst($eachuser->lname); ?>" /></a></div>
		<?php }?>
		<?php }?>
		</div>
<?php

if(isset($trackingppl) && !empty($trackingppl))

{ ?>

	<div class="right show-links" style="display:none;"><a href="#" class="orange-link">Sort By Tile</a> |<a href="#" class="orange-link">Show All</a></div>

      <div class="clear-right padding-10pixels"></div>
		
      <div id="Default7" class="contentHolder">

	  		<div class="finaos-display-area">
			

			<?php foreach($trackingppl as $tppl) {

				$profileimg = "";

				$filename = "";
				
				$user = UserProfile::model()->findByAttributes(array('user_id'=>$tppl->createdby->userid));
				
				if(isset($user) && isset($user->profile_image))
					$profileimg = $this->cdnurl."/images/uploads/profileimages/".$user->profile_image;
				else
					$profileimg = $this->cdnurl."/images/no-image-small.jpg";

					$imgsrc = $profileimg;

					foreach($uploadinfo as $updet)
					{
						if($tppl->finao_id == $updet["upload_sourceid"])
						{
							$filename = Yii::app()->basePath .'/../'.$updet["uploadfile_path"].'/thumbs/'.$updet["uploadfile_name"];
							if($updet["uploadfile_name"] != "")
							{
								if(file_exists($filename))
								{
									$imgsrc = $this->cdnurl.''.$updet["uploadfile_path"].'/thumbs/'.$updet["uploadfile_name"];	
								}
								else{
									$filename = Yii::app()->basePath .'/../'.$updet["uploadfile_path"].'/'.$updet["uploadfile_name"];
									if(file_exists($filename))
										$imgsrc = $this->cdnurl.''.$updet["uploadfile_path"].'/'.$updet["uploadfile_name"];
									else	
										$imgsrc = $this->cdnurl."/images/no-image-small.jpg";	
								}
							}
							else
							{
								if($updet["video_img"] != "")
									$imgsrc = $updet["video_img"];
								else
									$imgsrc = $this->cdnurl."/images/no-image-small.jpg"; 	
							}
						}
					}
				if(isset($user) && isset($user->profile_image)) 
					$profileimg = $this->cdnurl."/images/uploads/profileimages/".$user->profile_image;
				else
					$profileimg = $this->cdnurl."/images/no-image-small.jpg";	
					
				?>

			    <div class="finao-desc-media">
				<?php $tileid = UserFinaoTile::model()->findByAttributes(array('tile_id'=>$tppl->tile_id,'finao_id'=>$tppl->finao_id));?>
                                	<div class="finao-content-caption"><?php echo $tppl->finao_msg; ?></div>
                                	<div class="finao-hero-content">
                                    
                                     <div style="overflow:hidden;background:url('<?php echo $imgsrc; ?>') center center; width:90px; height:90px;" class="gallery-thumb smooth thumb-container-square">
                 
                    </div>
                                    <a class="black-link font-13px" <?php if (stripos($tppl->lookup_name, "added finao") !== false || stripos($tppl->lookup_name, "updated finao") !== false || stripos($tppl->lookup_name, "changed finao status") !== false){?> onclick="getheroupdate();getthatfinao(<?php echo $tppl->finao_id;?>);getfinaos(<?php echo $tppl->createdby;?>,<?php echo $tppl->tile_id;?>);" <?php }elseif(stripos($tppl->lookup_name, "added journal") !== false){?> onclick="getheroupdate();getthatfinao(<?php echo $tppl->finao_id;?>);getfinaos(<?php echo $tppl->createdby;?>,<?php echo $tppl->tile_id;?>); "  <?php }elseif(stripos($tppl->lookup_name, "uploaded image") !== false || stripos($tppl->lookup_name, "uploaded video") !== false){?> onclick="getheroupdate();getthatfinao(<?php echo $tppl->finao_id;?>);getfinaos(<?php echo $tppl->createdby;?>,<?php echo $tppl->tile_id;?>);" <?php }?> href="#finaomesgsdisplay"><?php echo ucfirst($tppl->fname)." ".ucfirst($tppl->lname);?>&nbsp;<?php echo $tppl->lookup_name." for the tile ".$tileid->tile_name;?></a></div> 
                                        <div class="finao-status-bar">
                                        <div class="left">
                                            <span><?php echo "Updated on".date("j  M,  g:i a", strtotime($tppl->updateddate));?></span>
                                        </div>
                                        <div class="right">
                                            <img width="60" src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst($tppl->finaostatus);?>.png">
                                        </div>
                                    </div>                                
                                </div>

			

			<?php } ?>

				

			

			</div>				

	 </div>	

<?php }else{

	echo "NO FINAOs Available";

}

?>
<script type="text/javascript">
function getupdate(tileid,finaoid,journalid,action,userid)
{
	var update = document.getElementById('isheroupdate');
	if(update != null)
		update.value = "heroupdate";
	if (action.indexof("added journal") !== -1)
	{
		getalljournals(finaoid,userid,0,0,'heroupdate');
	}
	else if(action.indexof("uploaded image for finao") !== -1)
	{
		getDetails('Image',userid,0,'tilepage');
	}
	else
	{
		getfinaos(userid,tileid);
	}
}
function getheroupdate()
{
	var update = document.getElementById('isheroupdate');
	if(update != null)
		update.value = "heroupdate";
	$("html, body").animate({ scrollTop: 0 }, "slow");
}
function showheroes(id)
{
	if(id=="show")
	{
		$("#hide").show();
		$("#show").hide();
		//$("#myheroes").show();
		$("#myheroes").fadeIn("slow");
	}
	else if(id=="hide")
	{
		$("#hide").hide();
		$("#show").show();
		//$("#myheroes").hide();
		$("#myheroes").fadeOut("slow");
	}
}
</script>
