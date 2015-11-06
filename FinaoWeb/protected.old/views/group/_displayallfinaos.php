<?php //echo $groupid; ?>
<div class="<?php if($groupid) echo 'tiles-container-group'; else echo 'tiles-container';?>">
        <div class="tile-container-navigation">
        <?php if($finaopagedetails['noofpage'] > 1) {   ?>
        <a onclick="displayalldata(<?php echo $userid; ?>,'<?php echo $groupid ?>',<?php echo $finaopagedetails['prev'];?>,'finaos')" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>									

        <a onclick="displayalldata(<?php echo $userid; ?>,'<?php echo $groupid ?>',<?php echo $finaopagedetails['next'];?>,'finaos')" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;</a>
        <?php } ?>
        </div>


        <div class="detailed-container">
        <p style="height:30px;">&nbsp;</p>
            <?php if(!($userid != Yii::app()->session['login']['id']) && isset($share) && $share!="share") { ?>
            <div class="create-finao-container" onclick="<?php if($groupid) {?>createfinao('<?php echo Yii::app()->session['login']['id'] ?>','<?php echo $groupid; ?>');<?php }else {?> createfinao();<?php }?>">
               <span class="create-finao-hdline"> Create a new FINAO</span>
            </div>
            <?php } ?>

            

            <?php $i = 0 ;foreach($finaos as $eachfinao){

            $i++;

            $src="";

            foreach($uploaddetails as $updet)
            {
				
                if($eachfinao->user_finao_id == $updet["upload_sourceid"])
                {
					if($updet["uploadfile_name"] != "")
					{
					if(file_exists(Yii::app()->basePath."/../".$updet["uploadfile_path"]."/thumbs/".$updet["uploadfile_name"]))
					{
					$src= $this->cdnurl.$updet["uploadfile_path"]."/thumbs/".$updet["uploadfile_name"];
					}else
					{
					$src= $this->cdnurl.$updet["uploadfile_path"]."/".$updet["uploadfile_name"];
					}
				}
				else if($updet["video_img"] != "")
				{
					//if(file_exists($updet["video_img"]))
					 
						//$src= $newtile["video_img"];
						
					if($updet["videostatus"] != 'ready')
					{ 
					$src = Yii::app()->baseUrl."/images/video-encoding.jpg";
					$vidsrc = '0';
					}else
					{
					$src = $updet["video_img"];
					$vidsrc = "//www.viddler.com/embed/".$updet["videoid"]."/?f=1&amp;player=simple&amp;secret=".$updet["videoid"]."";
					} 
					
					 

				}

             }
			 
			 
			

            
			}
			
			if($src == "")
			{
				
				$sql = "select * from fn_uploaddetails 
			where uploadeddate < 
			( select max(uploadeddate) from fn_uploaddetails where upload_sourceid = ".$eachfinao->user_finao_id." ) 
			and upload_sourceid = ".$eachfinao->user_finao_id."
			order by uploadeddate desc limit 1";
			$connection=Yii::app()->db; 
			$command=$connection->createCommand($sql);
			$tileids = $command->queryAll();
			foreach($tileids as $newtile)
			{
				$src = $newtile["video_img"];
				
				if($eachfinao->user_finao_id == $newtile["upload_sourceid"])
                {
					if($newtile["uploadfile_name"] != "")
					{
					if(file_exists(Yii::app()->basePath."/../".$newtile["uploadfile_path"]."/thumbs/".$newtile["uploadfile_name"]))
					{
					$src= $this->cdnurl.$newtile["uploadfile_path"]."/thumbs/".$newtile["uploadfile_name"];
					}else
					{
					$src= $this->cdnurl.$newtile["uploadfile_path"]."/".$newtile["uploadfile_name"];
					}
				}
				else if($newtile["video_img"] != "")
				{
					if($newtile["videostatus"] != 'ready')
					{ 
					$src = Yii::app()->baseUrl."/images/video-encoding.jpg";
					$vidsrc = 0;
					}else
					{
					$src = $newtile["video_img"];
					$vidsrc = "//www.viddler.com/embed/".$newtile["videoid"]."/?f=1&amp;player=simple&amp;secret=".$newtile["videoid"]."";
					} 
					
					 

				}
				

             }
			}
			
			
			 
			
			
			
			
			}
            ?>

            

            <?php $tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$eachfinao->user_finao_id));?>

             

             <div class="dashboard-finao-container" onclick="js:$('#isfrommenu').html('tilepage');getthatfinao(<?php echo $eachfinao->user_finao_id;?>);<?php if(Yii::app()->session['login']['id'] == $userid){?>getvideostatus(<?php echo $eachfinao->user_finao_id;?>);<?php } ?>getfinaos(<?php echo $tileid->userid;?>,<?php echo $tileid->tile_id;?>);"> 
<?php 
                
               if($src == "")
{ 
		/*$sql = "select * from fn_uploaddetails 
		where uploadeddate < 
		( select max(uploadeddate) from fn_uploaddetails) 
		and upload_sourceid = ".$eachfinao->user_finao_id."
		order by uploadeddate desc";
		$connection=Yii::app()->db; 
		$command=$connection->createCommand($sql);
		$tileids = $command->queryAll();
		foreach($tileids as $newtile)
		{
		$src = $newtile["video_img"];
		
		if(!empty($src))
		{
			$src = $newtile["video_img"];
		}
		else
		{
			if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo["profile_image"])  and $userinfo["profile_image"]!='')
			
			$src = $this->cdnurl."/images/uploads/profileimages/".$userinfo["profile_image"];
			
			else
			
			$src = $this->cdnurl."/images/no-image.jpg";
		}
		
		}*/
}?>

                <div class="dashboard-finao-container-left">
                <?php if($src == '')
				{
				 
					if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo["profile_image"])  and $userinfo["profile_image"]!='')
					
					$src = $this->cdnurl."/images/uploads/profileimages/".$userinfo["profile_image"];
					
					else
					
					$src = $this->cdnurl."/images/no-image.jpg";
				 
				} ?>
                
                <img src="<?php echo $src; ?>" width="66" height="66" />
                </div>

                <div class="dashboard-finao-container-right">

                    <!--<p><span class="display-time"><?php //echo date("j  M,  g:i a", strtotime($eachfinao->updateddate));?></span></p>-->

                    <p>

                    <?php $finaomesg = ucfirst($eachfinao->finao_msg);

                          $maxlen = 70;

                          if(strlen($finaomesg) > $maxlen)

                          {

                            $offset = ($maxlen-4) - strlen($finaomesg);

                            $finaomesg = substr($finaomesg, 0, strrpos($finaomesg, ' ', $offset)). '... ';	

                          }

                          echo $finaomesg;

                    ?>

                    </p>

                    <div class="status-button-position">

                    <?php if($eachfinao->Iscompleted !=1 ){?>

                        <img src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst($eachfinao->finaoStatus->lookup_name);?>.png" width="60" />

                    <?php }else{?>

                    <img src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst("completed");?>.png" width="60" />

                    <?php }?>

                    </div>

                </div>

            </div>

        

            <?php }?>

        

        </div>

</div>

 <script type="text/javascript">



 </script>          