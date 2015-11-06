<?php $userimage = UserProfile::model()->findByAttributes(array('user_id'=>$userid)); 
 //echo $userimage->profile_image;
?>
<?php if($Iscompleted=='completed') {?>

<div id="Default1"  class="contentHolder" style="overflow:auto; height:200px;"> 
<?php if(count($finaos) >= 1) 
   { 
	foreach($finaos as $eachfinao){?>
	<li style="border-bottom:solid 1px #464646;">
		<a style="line-height:18px; padding-left:5px!important;" onclick="getheroupdate();showCompletedFInaos(<?php echo $eachfinao->userid;?>,<?php echo $eachfinao->user_finao_id;?>)" href="javascript:void(0)">
			<p style="color:#999a9b;"><?php echo "Completed On : ".date("j  M,  g:i a", strtotime($eachfinao->updateddate)); ?></p>
			<p><?php echo ucfirst($eachfinao->finao_msg); ?></p>
		</a>
	</li>
	<?php } }
	
else {
echo '<span class="orange font-14px left" style="padding-left:5px; padding-top:15px; padding-bottom:5px;">NO Archived FINAOs</span>'; }?>
</div>
<?php }  else {?>


<?php if(isset($allfinaos) and !empty($allfinaos)){?>

  
<div class="finao-display-container">
                          
                             <?php   foreach($allfinaos as $finaoalll){ 
							 
							 $journl_pro = Uploaddetails::model()->findByAttributes(array('upload_sourceid'=>$finaoalll->user_finao_id),array('order'=>'updateddate desc'));
							 
							 if($journl_pro->status=='0' && $journl_pro->videostatus=='Encoding in Process')

	$journl_pro = Uploaddetails::model()->findByAttributes(array('upload_sourceid'=>$finaoalll->user_finao_id,'status'=>1),array('order'=>'updateddate desc')); 

							 ?> 
                             
<?php 
			
			   

            $i++;

            $src="";

            foreach($uploaddetails as $updet)
            {
				
                if($finaoalll->user_finao_id == $updet["upload_sourceid"])
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
			( select max(uploadeddate) from fn_uploaddetails where upload_sourceid = ".$finaoalll->user_finao_id." ) 
			and upload_sourceid = ".$finaoalll->user_finao_id."
			order by uploadeddate desc limit 1";
			$connection=Yii::app()->db; 
			$command=$connection->createCommand($sql);
			$tileids = $command->queryAll();
			foreach($tileids as $newtile)
			{
				$src = $newtile["video_img"];
				
				if($finaoalll->user_finao_id == $newtile["upload_sourceid"])
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
					$video = 'true';
					}else
					{
					$src = $newtile["video_img"];
					$video = 'true';
					$vidsrc = "//www.viddler.com/embed/".$newtile["videoid"]."/?f=1&amp;player=simple&amp;secret=".$newtile["videoid"]."";
					} 
					
					 

				}
				

             }
			}
			
			
			 
			
			
			
			
			}
            

if($src == "" )
			{
				if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userimage["profile_image"])  and $userimage["profile_image"]!='')
					
					$src = $this->cdnurl."/images/uploads/profileimages/".$userimage["profile_image"];
					
					else
					
					$src = $this->cdnurl."/images/no-image.jpg";
					
			}
?>
							   
                               
                                <div class="finao-desc-media">

				<div class="finao-strip-bar"></div>

				<div style="padding:0; width:430px;">

					<?php //echo $video; ?>
					
					<div class="finao-image-video">

						<div style="overflow:hidden;background:url('<?php echo $src;?>') center center; width:90px; height:90px; background-size:90px 90px;" class="gallery-thumb-new smooth thumb-container-square">
</div>                
                        
					
                    </div>
                    
                    
                    
                    
					<div class="finao-activity-text">
<?php $tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoalll->user_finao_id));

 ?>
						<div class="finao-text"><a href="javascript:void(0);" onClick="getthatfinao(<?php echo $finaoalll->user_finao_id;?>);getfinaos(<?php echo $userid;?>,<?php echo $tileid->tile_id;?>)"><?php echo $finaoalll->finao_msg;?></a></div>
                        
                        
                        

					  <?php if(!empty($journl_pro->upload_text)){?>  
                      <div class="finao-activity">
                      <span class="orange">Recent Activity:</span> 
					  <?php //echo $journl_pro->upload_text;
					  
					  
					  if(strlen($journl_pro->upload_text)>200)
					  {
							$words = explode(" ",$journl_pro->upload_text);
							$content = implode(" ",array_splice($words,0,30));
							echo $content;?>
						  .........
					<?php   }else{ echo $journl_pro->upload_text; }
					  
					  ?>
                      </div>
					  <?php }?>
                      
                                              
                      

					</div>
                    

				</div>

 <?php  
	$Criteria = new CDbCriteria();
	$Criteria->condition = "uploadtype = '".$userid."' AND upload_sourceid = ".$finaoalll->user_finao_id."";
	$journals = Uploaddetails::model()->findAll($Criteria); 
	
	// posts count
		$sql = "SELECT COUNT(*) FROM fn_uploaddetails where uploadedby='".$userid."' and upload_sourceid='".$finaoalll->user_finao_id."'";$numClients = Yii::app()->db->createCommand($sql)->queryScalar();		

		// images count
		$sql_img="SELECT COUNT(*) FROM fn_uploaddetails where uploadedby='".$userid."' and uploadtype IN('34','62') and upload_sourceid='".$finaoalll->user_finao_id."' and uploadfile_name!=''"; $num_images= Yii::app()->db->createCommand($sql_img)->queryScalar();	

		// videos count	
		$sql_vid="SELECT COUNT(*) FROM fn_uploaddetails where uploadedby='".$userid."' and uploadtype IN('35','62') and upload_sourceid='".$finaoalll->user_finao_id."' and video_img!=''"; $num_vide= Yii::app()->db->createCommand($sql_vid)->queryScalar(); ?> 

		<div class="finao-status-bar">

		 <div class="left">

        	<span><?php echo $numClients;?></span> Posts: <span><?php echo $num_images;?></span> Photos: <span><?php echo $num_vide;?></span> Video  <?php /*?>: <span><?php if($days=='0') echo $hours.' Hours active'; else echo $days.'days active';?></span><?php */?>

   		 </div> 

		<div class="right">

		 <div style="float:left;">
        
        <?php if($userid != Yii::app()->session['login']['id']){?> 
		<div id="trackingstatus-<?php echo $i;?>">
                        
                       <!--<input style=" background: none repeat scroll 0 0 #F57B20;
    color: #FFFFFF;
    cursor: pointer;
    font-size: 9px;
    padding: 4px 14px; margin-right:5px;
    text-align: center;
    transition: all 0.5s ease 0s;" type="button" onClick="gettileid()" value = "Follow FINAO">-->
                       
         </div>
		
		<?php } ?>
         
         
         </div>
		 
		 <div style="float:right; margin-left:5px;">
         <?php if($finaoalll->Iscompleted !=1 ){?>

				<img src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst($finaoalll->finaoStatus->lookup_name);?>.png" width="60" />

			<?php }else{?>

			<img src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst("completed");?>.png" width="60" />

			<?php }?>
         </div>
		 
		 

		</div>

	</div> 

	</div>
							 <?php } ?> 
                                
     
                                
                            </div>
 <?php }else{?> 
<div style="text-align: center;margin-top: 28px;font-size: 16px;color: #a8a8a8;border: solid 1px #565656;padding: 20px 0;">
No Active FINAO'S FOR THIS GROUP...
</div>
<?php } } ?>
<script type="text/javascript">

function getthatfinao(finaoid)
{
	var finao = document.getElementById('finaoid');
	if(finao != null)
		finao.value = finaoid;
}

function deselectfinao()
{
	if($("#finaoid").length)
		$("#finaoid").val("");
}

</script>
                            