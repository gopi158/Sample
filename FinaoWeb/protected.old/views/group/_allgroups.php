 
 
<div class="tiles-container">
                <div class="tile-container-navigation">
                    
		 <?php if($finaopagedetails['noofpage'] > 1) {   ?>
        <a onclick="displayalldata(<?php echo $userid; ?>,'',<?php echo $finaopagedetails['prev'];?>,'groups')" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>									

        <a onclick="displayalldata(<?php echo $userid; ?>,'',<?php echo $finaopagedetails['next'];?>,'groups')" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;</a>
        <?php } ?>
                </div>
                <p style="height:30px;">&nbsp;</p>
                <div class="detailed-container">
                    <div class="clear-right"></div>
	<?php if(!($userid != Yii::app()->session['login']['id']) && isset($share) && $share!="share") { ?>
    <div class="create-finao-container" onclick="creategroup();">
    <span class="create-finao-hdline"> Create a new GROUP</span>
    </div>
    <?php } ?>

                    
					<?php $i= 0; foreach($finaos as $group){$i++;
						
						$visible = GroupTracking::model()->findByAttributes(array('tracked_groupid'=>$group->group_id,'tracker_userid'=>Yii::app()->session['login']['id']));
                     ?>   
						
						
                   
                    <?php /*?><div class="dashboard-group-container">
                    	<a class="close-group" href="javascript:void(0);">
                        <img width="30" src="<?php echo $this->cdnurl;?>/images/close.png"></a>
                        
                        <?php if($userid != Yii::app()->session['login']['id'] ||  $share == "share"){
							$url = array('groupid'=>$group->group_id,'frndid'=>$userid);
							}
							else
							{
							$url = array('groupid'=>$group->group_id);
							} ?>
                        <a href="<?php echo Yii::app()->createUrl("group/Dashboard",$url); ?>">
                        <div class="dashboard-group-container-left">
                         
					<?php if(!empty($group->profile_image)){?> 
                    
                    
                    <img  width="66" height="66" style="border:solid 3px #d7d7d7;" src="<?php echo $this->cdnurl;?>/images/uploads/groupimages/profile/<?php echo $group->profile_image;?>">
                    
                    <?php }else{?> 
                   <img  width="66" height="66"  style="border:solid 3px #d7d7d7;" src="<?php echo $this->cdnurl;?>/images/no-image.jpg">
                    <?php } ?>
                        </div>
                        </a>
                        <a href="<?php echo Yii::app()->createUrl("group/Dashboard",$url); ?>">
                        <div class="dashboard-group-container-right">
                        	<span class="group-name orange font-15px"><?php echo $group->group_name ?></span>
                            <p><?php echo substr($group->group_description, 0,30);?>..</p>
                            <div class="media-buttons">
                          
                            <?php if($group->upload_status == 1){?> 
						   <input type="button" value="Media" class="orange-button-small"> 
							<?php }  ?>
                            
                           <!-- <input type="button" value="Home" class="orange-button-small">-->
                            </div>
                        </div>
                        </a>
                    </div><?php */?>
                    
                     <?php if($userid != Yii::app()->session['login']['id'] ||  $share == "share" || $group->updatedby != Yii::app()->session['login']['id']){
					 if($share == "share") $share_value=1; else $share_value=0;
							$url = array('groupid'=>$group->group_id,'frndid'=>$group->updatedby,'share'=>$share,'share_value'=>$share_value);
							}
							else
							{
							$url = array('groupid'=>$group->group_id);
							} ?>
                    
                    <div class="dashboard-group-container">
                    	<!--<a class="close-group" href="#"><img width="30" src="<?php //echo $this->cdnurl;?>/images/close.png"></a>-->
                         <a href="<?php echo Yii::app()->createUrl("group/Dashboard",$url); ?>">
                        <div class="dashboard-group-container-left">
                        <?php if(!empty($group->profile_bg_image)){?>                     
                    <img  width="66" height="66" style="border:solid 3px #d7d7d7;" src="<?php echo $this->cdnurl;?>/images/uploads/groupimages/coverimages/<?php echo $group->profile_bg_image;?>">                    
                    <?php }else{?> 
                   <img  width="66" height="66"  style="border:solid 3px #d7d7d7;" src="<?php echo $this->cdnurl;?>/images/no-image.jpg">
                    <?php } ?> 
                        </div>
                        </a>
                        
                        <div class="dashboard-group-container-right">
                       <a href="<?php echo Yii::app()->createUrl("group/Dashboard",$url); ?>">

                            <span class="group-name orange font-15px">
							<?php echo substr($group->group_name, 0,20);?>
                            </span>
                            <p><?php echo substr($group->group_description, 0,30);?>..</p>
                            </a> 
                           
                            <p>
                             
                            <?php if($group->updatedby == Yii::app()->session['login']['id'] ){?>                           <span class="left">
                             <img class="admin-group" src="<?php echo $this->cdnurl;?>/images/icon-admin.png"></span>
							<?php }else{ //echo $visible->visible;?> 
							<?php if($userid == Yii::app()->session['login']['id']){?> 
							<span class="right">
                            <input id="visiblehide<?php echo $i; ?>" <?php if($visible->visible == 1){?> checked="checked" <?php }   ?> onclick="visible(<?php echo $group->group_id?>,'<?php echo $i; ?>');" type="checkbox"> Hide
                            </span>
							<?php } ?> 
                            
							<?php } ?>
                           </p>
                        </div>  
                                             
                    </div>
				  
					<?php } ?>
                    
                    
                    
                </div>
</div>
<script type="text/javascript">
/*function visible(groupid)
{
  var visible = $('#visible').attr('checked') ? 1 : 0;
  
  var url='<?php echo Yii::app()->createUrl("finao/hidegroup"); ?>';
   $.post(url, { groupid:groupid,visible:visible },
		function(data){
	  		if(data)
			{
				 alert(data);
			}
	});	 
}*/
</script>