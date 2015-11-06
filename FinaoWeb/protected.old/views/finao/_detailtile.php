
<div class="tile-finao-container">
                	<div class="tile-big">
                		<div class="holder smooth" style="margin-right:16px!important; margin-left:0;">
                           
						    <a href="javascript:void(0)">
							<?php if(file_exists(Yii::app()->basePath."/../images/tiles/".str_replace(" ","",$tileinfo->tile_imageurl)) && $tileinfo->tile_imageurl != "")
					{ ?> 
						<img src="<?php echo $this->cdnurl;?>/images/tiles/<?php echo str_replace(" ","",$tileinfo->tile_imageurl);?>" width="440" height="320"/>
						
				<?php	}else{?> 
							<img src="<?php echo $this->cdnurl;?>/images/upload-tileimg-big.png" width="440" height="320"/>
							<?php }?>
							</a>
                            <!--<span class="tile-image-caption-big" id="tilename"><?php echo $tileinfo->tilename;?></span>-->
                            <span class="tile-image-caption-big" <?php if($tileinfo->Is_customtile !=1){?>style="background:none;" <?php }?> id="tilename">
							<span class="tile-big-text-position">
							<?php echo $tileinfo->tilename;?>
                            </span>
                            </span>
							<div id="edittilename" style="display:none;" class="tile-image-caption-big">
							<input type="text" class="txtbox left" style="width:300px; margin-left:10px;" id="tiletext" maxlength="16"  value="<?php echo $tileinfo->tilename;?>" />
							<img src="<?php echo $this->cdnurl;?>/images/checkWhite.png" id="savetile" onclick="savetilename(<?php echo $userid;?>,<?php echo $tileinfo->tile_id; ?>)" width="16" height="16" class="left" style="margin-top:5px; margin-right:5px;" title="Save" />
							<img src="<?php echo $this->cdnurl;?>/images/deleteXwhite.png" id="closetile" onclick="js:$('#edittilename').hide();$('#tilename').show();$('#tiletext').removeClass('txtbox-error').addClass('txtbox left');$('#tiletext').val('<?php echo $tileinfo->tilename;?>')" width="16" height="16" class="left"  style="margin-top:5px; margin-right:5px;" title="Close" />
							
							</div>
							<input id="tileupload" type="button" name="button" value="Upload" style="display:none; position:absolute; right:30px; top:2px; z-index:222;" class="orange-button"  />
                             <span class="edit-tile-options" id="settingsmenu" <?php if($userid!=Yii::app()->session['login']['id'] || $share=="share"){?> style="display:none;" <?php }?>>
								<a href="javascript:void(0)" title="Edit Tile" ><img src="<?php echo Yii::app()->baseUrl;?>/images/icon-edit-small.png" width="18" /></a>
								 <div class="tile-settings" style="display:none;" id="tilemenu">
								 <?php if($tileinfo->Is_customtile == 1){?>
				                    <a href="javascript:void(0);" class="white-link font-11px" onclick="changetilename(<?php echo $userid;?>,<?php echo $tileinfo->tile_id;?>)">Rename Tile</a>
								<?php }?>
				                 	<a href="javascript:void(0);" class="white-link font-11px" onclick="js:$('#tileimagefile').trigger('click');">Change Tile Image</a>
									
									<div id="changeimage" style="display:none;">
				                 	
									<form name="TileimageForm" action="<?php echo Yii::app()->createUrl('finao/changePic'); ?>" method="post" enctype="multipart/form-data" id="TileimageForm">
									<input style="cursor:pointer; visibility:hidden" type="file" class="file" name="tileimagefile" id="tileimagefile" />
									<input type="hidden" id="usertileid" name="usertileid" value="<?php echo $tileinfo->tile_id;?>"/>
									<input type="hidden" id="tilename" name="tilename" value="<?php echo $tileinfo->tilename;?>"/>
									
									<input type="submit" id="btnTileimageForm" name="btnTileimageForm" value="Upload" class="orange-button" style="display:none;"/>
									</form>
									</div>
								 	
				                 </div>
							</span>
                        </div>    
                    </div>
                    <div class="finao-detail">
					<?php $i=0; foreach($allfinaos as $eachfinao){ $i++;?>
                    	<div class="finao-container-detail" onclick="js:$('#isfrommenu').html('tilepage');getprevfinao(<?php echo $i;?>,<?php echo $userid;?>,'prev',<?php echo $tileid;?>,'<?php echo $groupid; ?>');">
                            <div class="finao-container-detail-left">
							<?php $src = ""; foreach($uploadinfo as $updet)
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
												
									}elseif($updet["video_img"] != ""){
										//if(file_exists($updet["video_img"]))
											$src= $updet["video_img"];
									}
								}
							}
							
							if($src == "")
							{
								/*if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo["profile_image"]) and $userinfo["profile_image"]!='')
								$src = $this->cdnurl."/images/uploads/profileimages/".$userinfo["profile_image"];
							else
								$src = $this->cdnurl."/images/no-image.jpg";
								//$src = $this->cdnurl."/images/uploads/profileimages/".Yii::app()->session['login']['profImage'];*/
								
								$sql = "select * from fn_uploaddetails 
			where uploadeddate < 
			( select max(uploadeddate) from fn_uploaddetails where upload_sourceid = ".$eachfinao->user_finao_id.") 
			and upload_sourceid = ".$eachfinao->user_finao_id."
			order by uploadeddate desc";
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
					//if(file_exists($updet["video_img"]))
					 
						//$src= $newtile["video_img"];
						
					if($newtile["videostatus"] != 'ready')
					{ 
					$src = Yii::app()->baseUrl."/images/video-encoding.jpg";
					$vidsrc = '#';
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
                            
                            <?php 
                
	if($src == "")
	{ 
	if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$userinfo["profile_image"])  and $userinfo["profile_image"]!='')
	
	$src = $this->cdnurl."/images/uploads/profileimages/".$userinfo["profile_image"];
	
	else
	
	$src = $this->cdnurl."/images/no-image.jpg";
	}
	?>
							<img src="<?php echo $src;?>" width="86" height="86" />
							</div>
							<div class="finao-container-detail-right" onclick="js:$('#isfrommenu').html('tilepage');getprevfinao(<?php echo $i;?>,<?php echo $userid;?>,'prev',<?php echo $tileid;?>,'<?php echo $groupid; ?>');">
							<p > <?php 
	     							  echo $eachfinao->finao_msg;
								?></p>
							<div class="status-button-position">
								<?php if($eachfinao->Iscompleted !=1)
									$src = $this->cdnurl."/images/dashboard/Dashboard".ucfirst($eachfinao->finaoStatus->lookup_name).".png";
									else
									$src = $this->cdnurl."/images/dashboard/Dashboard".ucfirst('completed').".png";
								?>
								
								<img src="<?php echo $src;?>" width="60" />
								</div>
							</div>
						
                      
                    </div>
					<?php }?>
                </div>

<script type="text/javascript">
$(document).ready(function(){
$('#tileimagefile').bind('change', function() {
	//alert('hi');
	filetype = this.files[0].type; 
  	var ext = filetype.split('/').pop().toLowerCase();
	if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
		  alert('Invalid extension!');
		}
		else{
				var chosen = this.files[0];
				var image = new Image();
				imgwidth = "";
				imgheight = "";
							
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					$("#btnTileimageForm").show();
					$('#tileupload').show();
					alert("After clicking OK \nPlease click on Upload button to crop your cover image!!!")
				}
				else
				{
					//$("#TileimageForm").submit();
					//alert('else');
					$("#btnTileimageForm").trigger("click");
				}
					//document.TileimageForm.submit();

		}	
});
});


	$("#settingsmenu").mouseover(function(){
	$('#tilemenu').show();
	});
$("#settingsmenu").mouseout(function(){
	$('#tilemenu').hide();
	});

function changetilename(userid,usertileid)
{
	$("#edittilename").show();
	$("#tiletext").focus();
	$("#tilename").hide();
	$("#tiletext").addClass('txtbox left');
}
function submittile(myfield,e,userid,usertileid)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	{
		//$("#Login").trigger('click');
		savetilename(userid,usertileid);
   		return false;
	}
	else if(keycode == 27)
	{
		$("#edittilename").hide();
		$("#tilename").show();
		return false;
	}
	else
	   	return true;
}


$('#tileupload').click(function(){
								$("#TileimageForm").submit();
								});

function savetilename(userid,usertileid)
{
	var tilename = document.getElementById('tiletext').value;
	var url='<?php echo Yii::app()->createUrl("/finao/EditTile"); ?>';
	$.post(url, { userid : userid , usertileid : usertileid ,tilename : tilename},

		function(data){

	  			//alert(data);

			if(data=="saved")

			{
				$("#tilename").html(tilename);
				$("#edittilename").hide();
				$("#tilename").show();

			}
			else if(data=="Tilename exists")
			{
				//$("#tiletext").css({"color" : "red"  });
				$('#tiletext').removeClass('txtbox').addClass('txtbox-error');
			}
			
		});	
}
</script>