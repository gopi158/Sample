
<div class="tiles-container"> 
            	<div class="tile-container-navigation">
                <?php if($followarray['noofpage'] > 1) {   ?>
					<a onclick="displayalldata(<?php echo $userid; ?>,<?php echo $followarray['prev'];?>,'follow')" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>									
                    <a onclick="displayalldata(<?php echo $userid; ?>,<?php echo $followarray['next'];?>,'follow')" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;</a>
				<?php } ?>	
                </div>
                
                <div class="detailed-container">
				<p style="height:30px;">&nbsp;</p> 
                		<?php foreach($users as $eachuser){

						$src="";
											
						if($src == "")
						{
							if(file_exists(Yii::app()->basePath."/../images/uploads/profileimages/".$eachuser->image) and $eachuser->image!='')
								$src = $this->cdnurl."/images/uploads/profileimages/".$eachuser->image;
							else
								$src = $this->cdnurl."/images/no-image.jpg";
						}
						
						?>
						<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$eachuser->userid)); ?>">
						<div class="follow-tab">
	                    	<div class="follow-tab-left"><img src="<?php echo $src; ?>" width="70" height="70" /></div>
	                        <div class="follow-tab-right">
	                        	<p class="orange font-16px"><?php echo ucfirst($eachuser->fname)." ".ucfirst($eachuser->lname);  ?></p>
	                            <p class="person-tiles"><strong>Tiles:&nbsp;</strong><?php echo $eachuser->gptilename; ?></p>
	                        </div>
	                    </div>
						</a>
						<?php }?>
                   
                </div>
            
           </div>