   <script>
	jQuery(document).ready(function ($) {
	"use strict";
	if($('#Default8').length)
		$('#Default8').perfectScrollbar();
	});
</script> 
    <?php //$lastbackup = Tracking::model()->findByAttributes(array('tracker_userid' => $userid,'status'=>1));
	

	//echo $userid; exit;
	?>		
				
<span class="notifications">

<div class="messages"> 

 <ul id="menu">

     <li>
		<a href="javascript:void(0)" onclick="view_change_status('<?php echo $userid;?>');" >

					<img src="<?php echo Yii::app()->baseUrl;?>/images/notifications.png" width="35"  /> 

					<span class="latest-notifications">
				<?php $counts= Tracking::model()->findAllByAttributes(array('tracked_userid'=>$userid ,'status'=>1,'view_status'=>0)); ?>	

					<div id = "countdiv" style="font-size: 12px;" class="orange"><?php if(count($counts) > 0) echo count($counts);?></div>

					</span>

					</a><!-- Begin Home Item -->

                    

                             <div class ="dropdown_2columns align_right"><!-- Begin 2 columns container -->

                    		

									 <?php // if(empty($tiles)){ echo "No Notifications";
									 //}else{		?>	
							<div id="Default8" class="contentHolder3">

                            	<div class="col_2">

                                <?php //echo  print_r($tiles);exit; ?>
 
								

								<div class="notif-message">


								<?php
								if(count($tiles))
								{
								 foreach($tiles as $message){ //$tilename = Lookups::model()->findByAttributes(array('lookup_id'=>$message->tracked_tileid));

										//echo $tilename->lookup_name;

		$username = User::model()->findByAttributes(array('userid'=>$message['tracker_userid']));
		$userprofile = UserFinaoTile::model()->findByAttributes(array('tile_id'=>$message['tracked_tileid']));

				
                            ?>
										<!--<div class="notif-msg-left">
						
												<img src="<?php// echo $src;?>" width="30" />
						
											</div>-->
		                              <div class="notif-message">
									 
											<?php echo ucfirst($username->fname)." is   following your tile:&nbsp;" .$userprofile->tile_name;?>
									   </div>

				<?php } }else {?>
				
				<div class="notif-message">
									 
											<?php echo "Sorry! No notifications";?>
									   </div>

				
				
				
				<?php }?>

			</div>
			
			</div>

		</div>

                    </div>

                    </li>

                </ul>

				</div>

</span>				