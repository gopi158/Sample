 

<div class="<?php if($groupid) echo 'tiles-container-group'; else echo 'tiles-container';?>">
               
                
                <div class="tile-container-navigation">
                <?php if($followarray['noofpage'] > 1) {   ?>
					<a onclick="displayalldata(<?php echo $userid; ?>,<?php echo $groupid; ?>,<?php echo $followarray['prev'];?>,'members')" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>									
                    <a onclick="displayalldata(<?php echo $userid; ?>,<?php echo $groupid; ?>,<?php echo $followarray['next'];?>,'members')" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;</a>
				<?php } ?>	
                </div>
                
                <div class="detailed-container">
                	 
                    <div class="clear-right"></div>
                  <?php foreach($members as $member){?>
                    <div class="dashboard-group-container">
                    	<a href="" class="close-group">
                        <img src="<?php echo $this->cdnurl;?>/images/close.png" width="30" />
                        </a>
                        
          <?php $userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$member->userid));?>
                        <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$member->userid)); ?>">
                        <div class="dashboard-group-container-left">
                        
<?php 
if($userinfo->user_id == $member->userid )
{
		if($userinfo->profile_image !='')
		{
			if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo->profile_image) and $userinfo->profile_image!='')
			$src = $this->cdnurl."/images/uploads/profileimages/".$userinfo->profile_image;
			else
			$src = $this->cdnurl."/images/no-image.jpg";
		}
}

?> 
                        
                        <img src="<?php echo $src;?>" width="66" height="66" />
                        </div>
                        
                        <div class="dashboard-group-container-right"> 
                        	<span class="group-name orange font-15px"><?=$member->fname.'&nbsp;'.$member->lname?></span>
                            <p><?php echo substr($userinfo->mystory, 0,40); ?><span class="orange">...More</span></p>
                            <div class="media-buttons">
                            <!--<input type="button" class="orange-button-small" value="Media" /> <input type="button" class="orange-button-small" value="Home" />-->
                            </div>
                        </div>
                        </a>
                    </div>
                   <?php  }?>                 
                </div>
            </div>