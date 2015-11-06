
<div class="finao-canvas">

        	<div id="closefinaodiv" >
			<?php 
			if(isset($heroupdate) && $heroupdate != "")
			{
				$url = "";
			}
			else if($userid==Yii::app()->session['login']['id'] && $share!="share" && $completed != "completed"){
				$url = Yii::app()->createUrl('finao/motivationmesg');
			 }else{
			 	$url = Yii::app()->createUrl('finao/motivationmesg/frndid/'.$userid);
			 }?>
			 
			<a class="btn-close" <?php if($url != ""){?> href="<?php echo $url; ?>" <?php }else{?> onclick="closeheroupdate()" <?php }?>><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>

			</div>
			
        	<div class="finao-canvas-left">

            	<div class="journal-log">
					<div class="font-16px padding-5pixels orange left">
						Journal Log
					</div>
					
					<div class="right" style="margin-top:5px;">
						<a onclick="getalljournals(<?php echo $finaoid; ?>,<?php echo $userid; ?>,<?php echo $completed; ?>,1)" class="journal-link" href="javascript:void(0)">
						<?php if($userid==Yii::app()->session['login']['id'] && $share!="share"){?>
							<span>Enter New Journal</span> |
						<?php }else{?>
						<?php //echo ucfirst($userinfo->fname)."'s FINAO"?>
							<span>Summary View</span> |
						<?php }?>
						</a>
						
						<?php if(count($journals) >= 1) {?>
							<span><a class="journal-link journal-link-active" onclick="viewjournal(0,<?php echo $finaoinfo->user_finao_id; ?>,<?php echo $userid; ?>,<?php echo $completed; ?>,1);" href="javascript:void(0);" >Journal View</a></span> 
						<?php }else { ?> 
							<span>Journal View</span> 
						<?php } ?>
					</div>
				</div>
				
                <div class="clear-left"></div>
                
				<div class="finao-display-area">
				<div class="fixed-imagea-area">
					
					<div id="divhideshowJournal" class="journal-view-area">
						
                        <?php $this->renderPartial('_journal',array('jornavigation'=>$jornavigation 
																	,'journals'=>$journals
																	,'journalid'=>$journalid
																	,'finaoid'=>$finaoid
																	,'userid'=>$userid
																	,'completed'=>$completed
																	,'imageexists'=>$imageexists
																	,'videoexists'=>$videoexists)); ?>
					</div>
					
					<div class="journal-hide-show">
						<a  href="javascript:void(0)">
								<img src="<?php echo $this->cdnurl; ?>/images/journal-icons/journal-hide.png" title="Hide Journal" onclick="hideshowJournal(this);" />
							</a>
					</div>
					
			        <div class="finao-image-area">
		
						<?php $getimagesrc = $this->cdnurl."/images/logo-n.png";
			
								$imageflag = "false";
								$resizeWidth = $resizeHeight = 0;
								$Isvideo = 0;
								$videocode = "";	
								//print_r($getimages);
							if(isset($getimages) && !empty($getimages))
								foreach($getimages as $allimages)
								{
									//if($allimages["upload_sourceid"] == $eachfinao->user_finao_id)
									//{
										if($allimages['uploadfile_name'] != "")
										{
											$imageflag = "true";
											$Isvideo = 0;
											$getimagesrc = $this->cdnurl."/images/uploads/finaoimages/".$allimages['uploadfile_name'];
											if(isset($getimagesdetails) && count($getimagesdetails) >=1)
											{
												foreach($getimagesdetails as $imgvalues)
												{
													if($imgvalues["uploadfile_id"] == $allimages["uploaddetail_id"])
													{
														$resizeWidth = $imgvalues["resizeWidth"];
														$resizeHeight = $imgvalues["resizeHeight"];
													}
												}
											}	
										}
										else
										{
											$getimagesrc = "";
											
											if($allimages["videoid"] != "")
											{
												
												$Isvideo = 1;
												//532, 305
												$videocode = FinaoController::getviddlembedCode($allimages["videoid"],560,360);
											}
											elseif($allimages["video_embedurl"] != "")
											{
												$Isvideo = 1;
												$videocode = $allimages["video_embedurl"];
											}
										}
									//}
								}
			
							
							if($resizeWidth != 0 && $resizeHeight != 0)
								$style = 'width="'.$resizeWidth.'" height="'.$resizeHeight.'"';
							else
								$style = "";		
						?>
						
						<?php
								$noofpagImgVid = 0;
								$prevImg = 0;
								$nextImg = 0;
								
								if(isset($upldimgVidarray) && $upldimgVidarray != "")
								{
									$noofpagImgVid = $upldimgVidarray['noofpage'];
									$prevImg = $upldimgVidarray['prev'];
									$nextImg = $upldimgVidarray['next'];
								}
								
							?>
						
						<div id="finaoimagesjournal">
								
						<div class="slider-navigation">
			
							<?php if($noofpagImgVid>1){
							
							if($prevImg <= $noofpagImgVid)
							
							{?>
							
								<a onclick="getprevImgVid(<?php echo $prevImg;?>,<?php echo $userid;?>,'prev',<?php echo $tileid->tile_id;?>,'','finaopage',<?php echo $finaoid; ?>,<?php echo $journalid; ?>)" class="slider-navigation-left" href="javascript:void(0)">&nbsp;</a>
							
							<?php 
							
							}?>
											
							<?php if($nextImg<=$noofpagImgVid){?>
											
								<a onclick="getprevImgVid(<?php echo $nextImg;?>,<?php echo $userid;?>,'next',<?php echo $tileid->tile_id;?>,'','finaopage',<?php echo $finaoid; ?>,<?php echo $journalid; ?>)" class="slider-navigation-right" href="javascript:void(0)">&nbsp;
									
								</a>
							
							
							
							<?php }?>
											
							
							<?php  }?>
							
							</div>
						
						<?php if(isset($getimages) && !empty($getimages)) { ?>
						<?php 	
								if($Isvideo == 1){ 
									echo $videocode;		
								}else { ?>
									<img src="<?php echo $getimagesrc ; ?>" <?php echo $style ; ?> />			
						<?php	} ?>													
						<?php } else {?>
								<img src="<?php echo $this->cdnurl."/images/logo-n.png" ; ?>" />
						<?php } ?>
			
			           
					     
					   <div class="image-caption">
			
						<?php if(isset($getimages) && !empty($getimages)) echo $allimages["caption"]; ?>
			
						</div>
			
						</div>
			
			       	</div>
					
				</div>
			
			</div>
			</div>
			
            <div class="finao-canvas-right">

				

				<?php if(!($userid == Yii::app()->session['login']['id'])) { ?>

						<input type="hidden" id="frndtileid" value=""/>

						<input type="hidden" value="" id="userfrndid"/>

						<div id="trackingstatus" style="float:right;">

						</div>

						<div class="clear-right"></div>

					<?php } ?>

			

			

            	<?php $this->renderPartial('_newsinglefinao',array('finaoinfo'=>$finaoinfo

																	,'status'=>$status,'userid'=>$userid

																	,'getimages'=>$getimages,'share'=>$share

																	,'tileid'=>$tileid,'completed'=>$completed

																	,'page'=>$page

																	,'hidebtn'=>'journal'
																	,'heroupdate'=>$heroupdate
																	,'count'=>$count
																	)); ?>

            </div>

</div>

<script type="text/javascript">
	function hideshowJournal(imgelement)
	{
		src = $(imgelement).attr('src').toLowerCase();
		showsrc = "<?php echo $this->cdnurl; ?>/images/journal-icons/journal-show.png";
		hidesrc = "<?php echo $this->cdnurl; ?>/images/journal-icons/journal-hide.png";
		
		if(src.indexOf("hide") >= 0)
		{
			$(imgelement).attr("src",showsrc);
			$(imgelement).attr("title","Show Journal");
			$("#divhideshowJournal").hide();
		}
		if(src.indexOf("show") >= 0)
		{
			$(imgelement).attr("src",hidesrc);
			$(imgelement).attr("title","Hide Journal");
			$("#divhideshowJournal").show();
		}
	}
</script>