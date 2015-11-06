<script type="text/javascript" src="<?php echo $this->cdnurl;?>/javascript/paging.js"></script>

<?php
if(isset($finaos) && !empty($finaos))
{if($Iscompleted == ""){?>	
	<script>
		jQuery(document).ready(function ($) {
		"use strict";
		if($('#Default').length)
			$('#Default').perfectScrollbar();
		});
	</script>
<?php $userfinding1 = User::model()->findByPk($userid); ?>  	
<div id="totfinaos">
	
    <div class="enter-your-finao" id="singleviewfinao">
		
        <div style="width:100%; float:left;">
        	<div class="font-16px padding-10pixels left" id="Activity">
			<?php if($userid==Yii::app()->session['login']['id'] && isset($share) && $share!="share") echo 'My FINAOs'; else echo ucfirst($userfinding1->fname)."'s       FINAOs";?>
		</div>
            <div class="right">
            
		<?php if($userid==Yii::app()->session['login']['id'] && isset($share) && $share!="share"){ ?> 
        <input type="button" id="finaofeed"  class="orange-button bolder" onclick="createfinao()" value="Create a new FINAO"  />
        <?php }?>
            
            </div>
        </div>
        
		<div class="contentHolder ps-container" id="Default">
			<div class="finao-display-container">
	<?php  
	$Criteria = new CDbCriteria();
	if($userid==Yii::app()->session['login']['id'] && isset($share) && $share!="share")
		$Criteria->condition = "userid = '".$userid."' and Iscompleted!=1 and finao_activestatus=1 and IsGroup = 0";
	//else if($userid==Yii::app()->session['login']['id'])
	//	$Criteria->condition = "userid = '".$userid."' and Iscompleted!=1 and finao_activestatus = 1";	
	else 
		$Criteria->condition = "userid = '".$userid."' and Iscompleted!=1 and finao_activestatus = 1 and finao_status_Ispublic=1 and IsGroup = 0";	
	$Criteria->order = "updateddate desc";
	$totfinaos = UserFinao::model()->findAll($Criteria);
	$i=0;
	foreach($totfinaos as $finaoalll)
	{  
		
		$i++;
	
	$finaotile = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoalll->user_finao_id));
	//echo $finaotile->tile_id;
	//echo $userid;
	?>
    <script language="javascript">
	$(document).ready(function() {
			$("#fancyboximg"+<?php echo $i;?>).fancybox({});
			$("#fancyboximgs"+<?php echo $finaoalll->user_finao_id;?>).fancybox({});
			$('#fancybox-media'+<?php echo $finaoalll->user_finao_id;?>).fancybox({'titlePosition': 'inside','titleshow':true,'width': 620,'height': 420,type: "iframe",iframe : {preload: false}});});		

	
	function getTrackStatus1(userid,tileid,inc)
	{
	//alert("hiiiiiiii");
	var url='<?php echo Yii::app()->createUrl("/tracking/getTrackingStatus"); ?>';
	$.post(url, { userid : userid , tileid : tileid,inc :inc },
	function(data){
		//alert(data);
		if(data)
		{
			$("#trackingstatus-"+<?php echo $i;?>).show();
			$("#trackingstatus-"+<?php echo $i;?>).html(data);
			//alert("traking");
		}
	
		
	
	});
	
	}
	
	<?php if($userid!=Yii::app()->session['login']['id']){?> 
		getTrackStatus1(<?php echo $userid ?>,<?php if($finaotile->tile_id) echo $finaotile->tile_id; else echo 1;?>,<?php echo $i;?>);
	<?php } ?>
	
	
	/*function gettilestatus()
	{
		alert("Hello");
	}*/
	//gettilestatus();
    
    </script>	
     <?php
 	//if($finaoalll->Iscompleted!='1'){
 	$res = time()-strtotime($finaoalll->updateddate);
 	$days = floor($res / (60 * 60 * 24));
 	$hours = floor($res / 3600);
    $journl_pro = Uploaddetails::model()->findByAttributes(array('upload_sourceid'=>$finaoalll->user_finao_id),array('order'=>'updateddate desc'));

	if($journl_pro->status=='0' && $journl_pro->videostatus=='Encoding in Process')

	$journl_pro = Uploaddetails::model()->findByAttributes(array('upload_sourceid'=>$finaoalll->user_finao_id,'status'=>1),array('order'=>'updateddate desc'));?>

	

	<?php $tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoalll->user_finao_id)); 

	  $userimage = UserProfile::model()->findByAttributes(array('user_id'=>$userid)); 

	  

		// posts count

		$sql = "SELECT COUNT(*) FROM fn_uploaddetails where uploadedby='".$userid."' and upload_sourceid='".$finaoalll->user_finao_id."'";$numClients = Yii::app()->db->createCommand($sql)->queryScalar();

		

		// images count

		$sql_img="SELECT COUNT(*) FROM fn_uploaddetails where uploadedby='".$userid."' and uploadtype IN('34','62') and upload_sourceid='".$finaoalll->user_finao_id."' and uploadfile_name!=''"; $num_images= Yii::app()->db->createCommand($sql_img)->queryScalar();

	

		// videos count	

		$sql_vid="SELECT COUNT(*) FROM fn_uploaddetails where uploadedby='".$userid."' and uploadtype IN('35','62') and upload_sourceid='".$finaoalll->user_finao_id."' and video_img!=''"; $num_vide= Yii::app()->db->createCommand($sql_vid)->queryScalar();?>	

	

	<?php  if($userid != Yii::app()->session['login']['id'] ||  $share == "share")

    {  
		if($finaoalll->finao_status_Ispublic ='1')

		{?> 

			<div class="finao-desc-media">

				<div class="finao-strip-bar"></div>

				<div style="padding:0; width:430px;" >

					
					
					<div class="finao-image-video">

						<div class="">

					<?php if($journl_pro["uploadfile_name"] == "" and $journl_pro->video_img==''){?>

		<?php if(file_exists($this->cdnurl.'/images/uploads/profileimages/thumbs/'.$userimage->profile_image)){echo $path ='thumbs/';}else{echo $path = '';}?>

                       <?php if(file_exists(Yii::app()->basepath.'/../images/uploads/profileimages/thumbs/'.$userimage->profile_image))

					{

						 $path = 'thumbs/';

					}else

					{

						echo $path = '';

					}

					if($userimage->profile_image!='')
						{
							$Criteria = new CDbCriteria();							
							$Criteria->condition = "upload_sourceid = '".$finaoalll->user_finao_id."' and  (uploadfile_name!= '' or video_img!='') ";
							$Criteria->order = "updateddate desc";
							$prevfinaos = Uploaddetails::model()->findAll($Criteria);
							//echo $finaoalll->user_finao_id.$prevfinaos[0]['video_img'].$prevfinaos[0]['uploadfile_name']; 
							//echo 'gfg fg fg '.$prevfinaos[0]['video_img'];
							if($prevfinaos[0]['uploadfile_name']!='' or $prevfinaos[0]['video_img']!='')
							{
								if($prevfinaos[0]['uploadfile_name']!='')
								{
									
									             if(file_exists(Yii::app()->basePath."/../".$prevfinaos[0]["uploadfile_path"]."/thumbs/".$prevfinaos[0]["uploadfile_name"])){ $path = "/thumbs/";}else{$path = "/";}  
									
									$img_src=$this->cdnurl.$prevfinaos[0]['uploadfile_path'].$path.$prevfinaos[0]['uploadfile_name'];
								}			
								else { $img_src=$prevfinaos[0]['video_img'];	 }
							}
							else
							{ 	
							  $img_src=$this->cdnurl.'/images/uploads/profileimages/'.$path.$userimage->profile_image;
							 }
						}
					else 
						{
						$img_src=Yii::app()->baseUrl."/images/no-image-small.jpg";	
						}	
					 ?>

                    <div style="overflow:hidden;background:url('<?php echo $img_src;?>') center center; width:90px; height:90px;" class="gallery-thumb-new smooth thumb-container-square">

                 

                    </div>

					<?php }?>

						

						<?php if(file_exists(Yii::app()->basePath."/../".$journl_pro["uploadfile_path"].'/'.$journl_pro["uploadfile_name"]) && $journl_pro["uploadfile_name"] != "" && $journl_pro->video_img=='') {?>	

						<div>

						 <a id="fancyboximgs<?php echo $finaoalll->user_finao_id;?>" rel="gallery1" href="<?php echo $journl_pro['uploadfile_path'].'/'.$journl_pro['uploadfile_name'];?>" title="<?php echo $journl_pro["caption"];?>">

                         
  <?php if(file_exists(Yii::app()->basePath."/../".$journl_pro["uploadfile_path"]."/thumbs/".$journl_pro["uploadfile_name"])){ $path = "/thumbs/";}else{$path = "/";} ?> 
                         <div style=" overflow:hidden;background:url('<?php echo $this->cdnurl.$journl_pro['uploadfile_path'].$path.$journl_pro['uploadfile_name'];?>') center center; width:90px; height:90px;" class="gallery-thumb-new smooth thumb-container-square">       

        </div>

                         

                         </a></div>											

						<?php }?>

						

					 <?php if($journl_pro->videoid=='' and $journl_pro->video_embedurl!='' ){?> 

					 <?php $s=explode('src=',$journl_pro->video_embedurl);$ss=explode('"',$s[1]);?>	

							<div style="overflow:hidden;background:url('<?php echo $journl_pro->video_img;?>') center center; width:90px; height:90px;" class="gallery-thumb-new smooth thumb-container-square" >

								<a id="fancybox-media<?php echo $finaoalll->user_finao_id;?>"  href="<?php echo $ss[1];?>" class="video-a-link" title="Click Here To Play Video"><span class="video-link-span">&nbsp;</span></a>	

							</div>

					<?php }else if($journl_pro->video_img!='') {?>		

						
					<?php if($journl_pro->videostatus != 'ready')
                    { 
                    $vidimg = Yii::app()->baseUrl."/images/video-encoding.jpg";
                    $vidsrc = '#';
                    }else
                    {
                    $vidimg = $journl_pro->video_img;
                    $vidsrc = "//www.viddler.com/embed/".$journl_pro->videoid."/?f=1&amp;player=simple&amp;secret=".$journl_pro->videoid."";
                    } 
                    ?>
                        
                        	 <div style="overflow:hidden;background:url('<?php echo $vidimg;?>') center center; width:90px; height:90px; background-size:90px 90px;" class="gallery-thumb-new smooth thumb-container-square" >

								<a id="fancybox-media<?php echo $finaoalll->user_finao_id;?>"   href="<?php echo $vidsrc; ?>" class="video-a-link" title="Click Here To Play Video">
                <?php if($journl_pro->videostatus === 'ready') {?> 
                            <span class="video-link-span">&nbsp;</span>
                            
                          <?php }?>   
                            </a>	

							</div>

						<?php }?>
						</div>  
					</div>
                    
					<div class="finao-activity-text">

						<div class="finao-text"><a href="javascript:void(0);" onClick="getheroupdate();getthatfinao(<?php echo $finaoalll->user_finao_id;?>);getfinaos(<?php echo $userid;?>,<?php echo $tileid->tile_id;?>)"><?php echo substr($finaoalll->finao_msg,0,150);?></a></div>
                        
                        
                        

					  <?php if(!empty($journl_pro->upload_text)){?>  
                      <div class="finao-activity">
                      <span class="orange">Recent Activity:</span> 
					  <?php echo $journl_pro->upload_text;?>
                      </div>
					  <?php }?>
                      
                                              
                      

					</div>
                    

				</div>

 <?php  
	$Criteria = new CDbCriteria();
	$Criteria->condition = "uploadtype = '".$userid."' AND upload_sourceid = ".$finaoalll->user_finao_id."";
	$journals = Uploaddetails::model()->findAll($Criteria); 
  ?>

		<div class="finao-status-bar">

		 <div class="left">

        	<span><?php echo $numClients;?></span> Posts: <span><?php echo $num_images;?></span> Photos: <span><?php echo $num_vide;?></span> Video  <?php /*?>: <span><?php if($days=='0') echo $hours.' Hours active'; else echo $days.'days active';?></span><?php */?>

   		 </div> 

		 <div class="right">
        
        <div class="left">
			<?php /*$this->widget('Notes',array('widgettype'=>'note','i'=>$i,'sourceid'=>$finaoalll->user_finao_id,'userid'=>$userid,'uname'=>$userfinding1->fname,'sourcetype'=>37));*/?>
         </div>

		 <div style="float:left;">
        
        <?php if($userid != Yii::app()->session['login']['id']){?> 
		<div id="trackingstatus-<?php echo $i;?>">
         </div>
		  
			<script type="text/javascript">
			$("#notepopup-"+<?php echo $i;?>).click(function(){
					$("#overlay_form"+<?php echo $i;?>).fadeIn(1000);
			});
			
			$("#close"+<?php echo $i;?>).click(function(){
				$("#overlay_form"+<?php echo $i;?>).fadeOut(500);
			});
			</script>
		
		<?php }?> 
         
         
         </div>
			
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
        </div>
		<?php 

		} 

    }else{?> 

		<div class="finao-desc-media">

				<div class="finao-strip-bar"></div>

				<div style="padding:0; width:430px;" class="htmltext<?php echo $i;?>">

					<div class="finao-image-video">

						<div class="">

					<?php if($journl_pro["uploadfile_name"] == "" and $journl_pro->video_img==''){?>

							 

                                <?php if(file_exists(Yii::app()->basepath.'/../images/uploads/profileimages/thumbs/'.$userimage->profile_image))

					{

						 $path = 'thumbs/';

					}else

					{

						echo $path = '';

					}

					if($userimage->profile_image!='')
					{
						
						$Criteria = new CDbCriteria();							
						$Criteria->condition = "upload_sourceid = '".$finaoalll->user_finao_id."' and (uploadfile_name!= '' or video_img!='') ";
						$Criteria->order = "updateddate desc";
						$prevfinaos = Uploaddetails::model()->findAll($Criteria);
						if($prevfinaos[0]['uploadfile_name']!='' or $prevfinaos[0]['video_img']!='')
						{
							if($prevfinaos[0]['uploadfile_name']!='')
							{
								
								
								  if(file_exists(Yii::app()->basePath."/../".$prevfinaos[0]["uploadfile_path"]."/thumbs/".$prevfinaos[0]["uploadfile_name"])){ $path = "/thumbs/";}else{$path = "/";}  
									
								
								$img_src=$this->cdnurl.$prevfinaos[0]['uploadfile_path'].$path.$prevfinaos[0]['uploadfile_name'];
							}			
							else { $img_src=$prevfinaos[0]['video_img'];	 }
						}
						else
						{ 	
						  $img_src=$this->cdnurl.'/images/uploads/profileimages/'.$path.$userimage->profile_image;
						 }
						//$img_src=$this->cdnurl.'/images/uploads/profileimages/'.$path.$userimage->profile_image;
					}
					else 
					{	
						$img_src=Yii::app()->baseUrl."/images/no-image-small.jpg";	
					}
					 ?>

                    <div style="overflow:hidden;background:url('<?php echo $img_src;?>') center center; width:90px; height:90px;" class="gallery-thumb-new smooth thumb-container-square">

                    <!--<img width="120" height="90" style=""  src="" />-->

                    </div>

                             

                             

					<?php }?>

						

						<?php if(file_exists(Yii::app()->basePath."/../".$journl_pro["uploadfile_path"]."/".$journl_pro["uploadfile_name"]) && $journl_pro["uploadfile_name"] != ""  && $journl_pro->video_img=='') {?>	

						<div>

						 <a id="fancyboximgs<?php echo $finaoalll->user_finao_id;?>" rel="gallery1" href="<?php echo $journl_pro['uploadfile_path'].'/'.$journl_pro['uploadfile_name'];?>" title="<?php echo $journl_pro->caption; ?>">
                         
                         <?php if(file_exists(Yii::app()->basePath."/../".$journl_pro["uploadfile_path"]."/thumbs/".$journl_pro["uploadfile_name"])){ $path = "/thumbs/";}else{$path = "/";} ?>

                               <div style=" overflow:hidden;background:url('<?php echo $this->cdnurl.$journl_pro['uploadfile_path'].$path.$journl_pro['uploadfile_name'];?>') center center; width:90px; height:90px;" class="gallery-thumb-new smooth thumb-container-square">       

     					   </div>

                        </a></div>											

						<?php }?>

						

					 <?php if($journl_pro->videoid=='' and $journl_pro->video_embedurl!='' ){?> 

					<?php $s=explode('src=',$journl_pro->video_embedurl);$ss=explode('"',$s[1]);?>	

							
       <?php if($journl_pro->videostatus != 'ready')
	          { 
	           $vidimg = Yii::app()->baseUrl."/images/video-encoding.jpg";
			  }else
			  {
			   $vidimg = $journl_pro->video_img;
			  } 
	   ?>
                            <div style=" background: url('<?php echo $vidimg;?>') no-repeat scroll center center transparent;cursor: pointer;float: left;height: 90px;position: relative;width:90px; background-size:90px 90px;" class="gallery-thumb-new smooth thumb-container-square" >

								<a id="fancybox-media<?php echo $finaoalll->user_finao_id;?>"  href="<?php echo $ss[1];?>" class="video-a-link" title="<?php echo $journl_pro->caption; ?>">
                                
                                <?php if($journl_pro->videostatus === 'ready'){?> 
                                <span class="video-link-span">&nbsp;</span>
                                <?php }?> 
                                </a>	

							</div>

					<?php }else if($journl_pro->video_img!='') {?>	
                    
		<?php if($journl_pro->videostatus != 'ready')
        { 
        $vidimg = Yii::app()->baseUrl."/images/video-encoding.jpg";
		$vidsrc = '#';
        }else
        {
        $vidimg = $journl_pro->video_img;
		$vidsrc = "//www.viddler.com/embed/".$journl_pro->videoid."/?f=1&amp;player=simple&amp;secret=".$journl_pro->videoid."";
        } 
        ?>	

							 <div style="overflow:hidden;background:url('<?php echo $vidimg;?>') center center; width:90px; height:90px; background-size:90px 90px;" class="gallery-thumb-new smooth thumb-container-square">

								<a id="fancybox-media<?php echo $finaoalll->user_finao_id;?>"   href="<?php echo $vidsrc; ?>" class="video-a-link" title="<?php echo $journl_pro->caption; ?>">
                                
                                <?php if($journl_pro->videostatus  === 'ready'){?> 
                                <span class="video-link-span">&nbsp;</span>
                                <?php }?>
                                </a>	

							</div>

						<?php }?>	

							

						</div>   

					</div>

					<div class="finao-activity-text">
 
						<div class="finao-text"><a href="javascript:void(0);" onClick="getheroupdate();<?php if(Yii::app()->session['login']['id']){?>getvideostatus(<?php echo $finaoalll->user_finao_id;?>);<?php } ?>getthatfinao(<?php echo $finaoalll->user_finao_id;?>);getfinaos(<?php echo $userid;?>,<?php echo $tileid->tile_id;?>)">  <?php echo substr($finaoalll->finao_msg,0,150);?></a></div>
                        
                        

					  <?php if(!empty($journl_pro->upload_text)){?>  
                      <div class="finao-activity">
                      <span class="orange">Recent Activity:</span> 
					  <?php echo $journl_pro->upload_text;?></div><?php }?>
                      
                      
                     

					</div>

				</div>

<?php  

$Criteria = new CDbCriteria();

$Criteria->condition = "uploadtype = '".$userid."' AND upload_sourceid = ".$finaoalll->user_finao_id."";

$journals = Uploaddetails::model()->findAll($Criteria); 

?>



	<div class="finao-status-bar">

    <div class="left">

        <span><?php echo $numClients;?></span> Posts: <span><?php echo $num_images;?></span> Photos: <span><?php echo $num_vide;?></span> Video <?php /*?>: <span><?php if($days=='0') echo $hours.' Hours active'; else echo $days.'days active';?></span><?php */?>

    </div> 	

	

    <div class="right">
    
<?php /*$this->widget('Notes',array('widgettype'=>'rendernotes','i'=>$i,'sourceid'=>$finaoalll->user_finao_id,'userid'=>$userid,'uname'=>$userfinding1->fname,'sourcetype'=>37));*/?>	
     <?php if($finaoalll->Iscompleted !=1 ){?>

            <img src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst($finaoalll->finaoStatus->lookup_name);?>.png" width="60" />

        <?php }else{?>

        <img src="<?php echo $this->cdnurl;?>/images/dashboard/Dashboard<?php echo ucfirst("completed");?>.png" width="60" />

        <?php }?>

    </div>

</div> 

</div>

	<?php }?>

	

	<?php  } //} ?>

				

				

	</div>

			

		

	</div>

			

	</div>

</div>



<?php }

	

	if($Iscompleted != ""){?>



	<script>



	jQuery(document).ready(function ($) {



	"use strict";



	if($('#Default1').length)

		$('#Default1').perfectScrollbar();



	});



</script>


 



<?php if($Iscompleted=='completed') {?>

<div id="Default1"  class="contentHolder" style="overflow:auto; height:200px;"> <!-- -->



<?php if(count($finaos >= 1)) { foreach($finaos as $eachfinao){?>



<li style="border-bottom:solid 1px #464646;">



	<a style="line-height:18px; padding-left:5px!important;" onclick="getheroupdate();showCompletedFInaos(<?php echo $eachfinao->userid;?>,<?php echo $eachfinao->user_finao_id;?>)" href="javascript:void(0)">



		<p style="color:#999a9b;"><?php echo "Completed On : ".date("j  M,  g:i a", strtotime($eachfinao->updateddate)); ?></p>



		<p><?php echo ucfirst($eachfinao->finao_msg); ?></p>



	</a>



</li>



<?php }



}



else



echo '<span class="orange font-14px left" style="padding-left:5px; padding-top:5px; padding-bottom:5px;">NO Archived FINAOs</span>';?>



</div>



<?php }?>


 





<?php }



}



?>

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
	$('#note_contents'+a).html($('.htmltext'+a).html());$('.htm').html($('.htmltext'+a).html());
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
	<span class="font-18px" style="margin-bottom:10px;">Tell  <span class="orange"><?php echo ucfirst($userfinding1->fname);?></span></span>
 	 <div id="note_content" style="font-size:24px; font-style:normal; color:#343434; margin-bottom:10px;"></div>	 
	 	<input type="button" value="Send" class="orange-button bolder" onclick="insert_note();" />
        <input type="button" class="orange-button bolder" value="Cancel" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" />
		<input type="hidden" readonly="readonly" value="" id="source_type" /><input type="hidden" readonly="readonly" value="" id="contentid" />
		<input type="hidden" readonly="readonly" value="" id="sourceid_note" /><input type="hidden" readonly="readonly" value="" id="userid_note" />
        
</div>
	
<div id="fade" class="black_overlay"></div>