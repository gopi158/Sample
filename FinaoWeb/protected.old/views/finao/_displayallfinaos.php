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

             

             <div class="dashboard-finao-container"> 
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

                    <p onclick="js:$('#isfrommenu').html('tilepage');getthatfinao(<?php echo $eachfinao->user_finao_id;?>);<?php if(Yii::app()->session['login']['id'] == $userid){?>getvideostatus(<?php echo $eachfinao->user_finao_id;?>);<?php } ?>getfinaos(<?php echo $tileid->userid;?>,<?php echo $tileid->tile_id;?>);">

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
					<?php if($userid==Yii::app()->session['login']['id'] && $finaos->Iscompleted!=1 && isset($share) && $share!="share"){	
				/* $this->widget('Notes',array('widgettype'=>'rendernotes','i'=>$i,'sourceid'=>$eachfinao->user_finao_id,'userid'=>$userid,'uname'=>$userfinding1->fname,'sourcetype'=>37));*/
				 					
				 }else {
					 /*$this->widget('Notes',array('widgettype'=>'note','i'=>$i,'sourceid'=>$eachfinao->user_finao_id,'userid'=>$userid,'uname'=>$uname->fname,'sourcetype'=>37));*/?>
					<script type="text/javascript">
						$("#notepopup-"+<?php echo $i;?>).click(function(){
								$("#overlay_form"+<?php echo $i;?>).fadeIn(1000);
						});
						
						$("#close"+<?php echo $i;?>).click(function(){
							$("#overlay_form"+<?php echo $i;?>).fadeOut(500);
						});
					</script>					
						
					<?php }?>	

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
function insert_note()
{	
	var sourcetype=$('#source_type').val();
	var sourceid=$('#sourceid_note').val();
	var userid=$('#userid_note').val();
	var contentid=$('#contentid').val();	
	if(userid!='' && sourceid!='')
	{
		var url = '<?php echo Yii::app()->createUrl("/Finao/notes"); ?>';
		$.post(url,{userid: userid,sourceid:sourceid,sourcetype:sourcetype,contentid:contentid},function(data) {document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';});
	}
}
function popups(a,sourceid,userid,sourcetype,content,contentid)
{
	//var c=['cool finao','You inspire me','Rock on','I dig your finao','Nice job','Way to go','Keep going','proud of you','Fist bump'];
	$('#note_content').html(content);$('#sourceid_note').val(sourceid);$('#userid_note').val(userid);$('#source_type').val(sourcetype);$('#contentid').val(contentid);
	document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';
}	
function view_notes(a)
{
	//alert($('.htmltext'+a).html()); return false;
	var c=['cool finao','You inspire me','Rock on','I dig your finao','Nice job','Way to go','Keep going','proud of you','Fist bump'];$('#note_contents'+a).html($('.htmltext'+a).html());$('.htm').html($('.htmltext'+a).html());
	document.getElementById('light'+a).style.display='block';document.getElementById('fade').style.display='block';
}			

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


<div id="light" class="white_content2"> <!--<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></a>-->
	<span class="font-18px" style="margin-bottom:10px;">Tell  <span class="orange"><?php echo ucfirst($uname->fname);?></span></span>
 	 <div id="note_content" style="font-size:24px; font-style:normal; color:#343434; margin-bottom:10px;"></div>	 
	 	<input type="button" value="Send" class="orange-button bolder" onclick="insert_note();" />
        <input type="button" class="orange-button bolder" value="Cancel" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" />
		<input type="hidden" readonly="readonly" value="" id="source_type" /><input type="hidden" readonly="readonly" value="" id="contentid" />
		<input type="hidden" readonly="readonly" value="" id="sourceid_note" /><input type="hidden" readonly="readonly" value="" id="userid_note" />
        
</div>
	
