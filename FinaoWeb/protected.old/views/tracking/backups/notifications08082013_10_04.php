   <script>
	jQuery(document).ready(function ($) {
	"use strict";
	if($('#Default8').length)
		$('#Default8').perfectScrollbar();
	});
</script> 
    
    <span class="notifications">

	<div class="messages">

	 <ul id="menu">

                    <li>

					<a href="#">

					<img src="<?php echo Yii::app()->baseUrl;?>/images/notifications.png" width="35"  /> 

					<span class="latest-notifications">

					<div id = "countdiv" style="font-size: 12px;" class="orange"><?php if(count($tiles) > 0) echo count($tiles);?></div>

					</span>

					</a><!-- Begin Home Item -->

                    

                             <div class="dropdown_2columns align_right"><!-- Begin 2 columns container -->

                    		

									 <?php if(empty($tiles)){ ?>

									 	

										 No Notifications

										

									<?php }else{		?>	
							<div id="Default8" class="contentHolder2">

                            	<div class="col_2">

                                

								<?php foreach($tiles as $message){?>

								<div class="notif-message">

								<?php //$tilename = Lookups::model()->findByAttributes(array('lookup_id'=>$message->tracked_tileid));

										//echo $tilename->lookup_name;

										$username = User::model()->findByAttributes(array('userid'=>$message->tracker_userid));

										$userprofile = UserProfile::model()->findByAttributes(array('user_id'=>$message->tracker_userid));

				if(isset($userprofile) && !empty($userprofile))

				{

					$src = Yii::app()->baseUrl.'/images/uploads/profileimages/'.$userprofile->profile_image;

				}

				else

				{

					$src = Yii::app()->baseUrl.'/images/no-image.png';

				}

										?>						<?php /*if(isset($username) && !empty($username->profile_image))

										{*/ ?>

									<div class="notif-msg-left">

                                    <img src="<?php echo $src;?>" width="30" />

                                    </div>

									<?php	/*}else{?>

                                	<div class="notif-msg-left">

                                    <img src="<?php echo Yii::app()->baseUrl;?>/images/no-image.jpg" width="30" />

                                    </div>

									<?php }*/ ?>

                                    <div class="notif-msg-right">

									

										<?php 

										

										echo ucfirst($username->lname)." wants to follow your tile :".$message->tile_name;?>

										<input type ="hidden" id="tileid" value ="<?php echo $message->tracked_tileid; ?> ">

										<input type ="hidden" id="tracker" value ="<?php echo $message->tracker_userid; ?> ">

										<div>

										<a id="accept-<?php echo $message->tracked_tileid;?>-<?php echo $message->tracker_userid; ?>" onclick="accepttile(<?php echo $message->tracked_tileid;?>,<?php echo $message->tracker_userid; ?>),checknotificationcount( <?php echo $userid ; ?>)">Accept</a> | <a id = "reject-<?php echo $message->tracked_tileid;?>-<?php echo $message->tracker_userid; ?>" onclick="rejecttile(<?php echo $message->tracked_tileid;?>,<?php echo $message->tracker_userid; ?>),checknotificationcount( <?php echo $userid ; ?>)">Reject</a></div>

									</div>

                               </div>

								<?php

									}

								?>

                            </div>
                            
                            </div>

							<?php } ?>

                        </div>

                    

                    </li>

                </ul>

				</div>

				</span>