<div class="main-container">
<div class="finao-canvas">
        	<span style="width:100%; font-size:18px; padding-bottom:10px;" class="orange left">			Search Results - <font style="font-size:25px;">
			<?php echo $tilename."&nbsp;(".$totalcnt.")"; ?> </font>
            </span>
            <div class="search-results">
            <?php
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
					    if($userinfo["profile_image"] != '')
						{
							if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo["profile_image"]))
							$src = $this->cdnurl."/images/uploads/profileimages/".$userinfo["profile_image"];
						}
						else
						{
							$src = $this->cdnurl."/images/no-image.jpg";
						}
							
					} ?>
				
					
						<div class="dashboard-finao-container">
	                        <div class="dashboard-finao-container-left">
							<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/finaoid/'.$userinfo["user_finao_id"]); ?>" >
								<img src="<?php echo $src; ?>" class="border" width="66" height="66" /></a>
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
	                    </div>
					
			<?php	
				}		
		}
		else
			{ ?>
				<span class="font-12px padding-10pixels">No Public FINAO's </span>			
	<?php	}
			?>		                
            </div>
        </div>
</div>