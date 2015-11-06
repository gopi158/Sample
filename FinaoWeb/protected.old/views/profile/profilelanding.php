<?php //echo $tileid;exit; ?>
<div>

	<div>

		<input type="hidden" id="userid" value="<?php echo $userid; //echo Yii::app()->session['login']['id'];?>"/>

		<div id= "finaodiv">

		<?php $this->renderPartial('profilestep',array('userprofile'=>$userprofile,'tileid'=>$tileid,'userid'=>$userid,'Imgupload'=>$Imgupload,'edit'=>$edit,'logeduser'=>$logeduser,'errormsg'=>((isset($errormsg) && $errormsg == 1) ? "Imgerror" : "")));?>

		</div>

		<div id="showcompletedfinaodiv-profile" style="display:none;"></div>

		<div id = "searchshowdiv" style="display:none"></div>

			<!------------------ SEARCH DIV FOR TRACKING AND TRACKERS END ---------------- -->

				<div id = "searchdiv" style="display:none">



			<div class="orange font-18px padding-10pixels">Search By People</div>

					<div style="width: 960px;">

					<?php $this->widget('NetworkSearch');  ?>

					</div>

					<div class="orange font-18px padding-10pixels" style=" margin-top:50px;">Search By Tiles</div>

					<div style="width:940px; height:278px; overflow-y:scroll; overflow-x:hidden;">

					

					<?php $alltiles = Lookups::model()->findAllByAttributes(array('lookup_type' => 'tiles','lookup_status'=>1));?>

					<table width="100%" cellpadding="3" cellspacing="10">

						<?php $j = 0;?>

						<?php foreach($alltiles as $i => $tileshow ){

							if($j==0){

						?>

						<tr>

							<?php

								}

							?>

		              		<td>

			                  	<a href="#">

			                  	<div class="holder" id="div-<?php echo $tileshow->lookup_name;?>-<?php echo $tileshow->lookup_id;?>" onclick="finduser(<?php echo $tileshow->lookup_id; ?>)">

							  	<img src="<?php echo Yii::app()->baseUrl;?>/images/tiles/<?php echo strtolower($tileshow->lookup_name);?>.png" width="75px;" />

			                    <div class="go-left text-position"><?php echo $tileshow->lookup_name;?></div>

							  	</div>

			             		</a>

		              		</td>

						<?php

							$j=$j+1;

							if($j > 5){

							$j=0;	

						?>

						</tr>

						<?php

										}	

							} 

						?>

		       		</table>

					

			

			

					</div>	

			

			

			   </div>

			   <div id = "showcompletedfinaodiv-default" style="display:none">

			   

			   </div>

		<!------------------ SEARCH DIV FOR TRACKING AND TRACKERS END ---------------- -->

		<!------------------ JOURNAL DIV FOR TRACKING AND TRACKERS START ---------------- -->

				

				<div class="tracking" id="followtracking" style="display:none;">

				<?php $findalltiles = Lookups::model()->findAllByAttributes(array('lookup_type'=>'tiles'));?>

<?php //$userid = Yii::app()->session['login']['id'];?>

					



				

				<div class="padding-10pixels">

				

					<input type="hidden" id="userid" value="<?php echo Yii::app()->session['login']['id'];?>"/>

								<input type="hidden" id="fbid" value="<?php echo Yii::app()->session['login']['socialnetworkid'];?>"/>

							<script src="http://connect.facebook.net/en_US/all.js"></script>

				<?php if($logeduser->socialnetworkid!=0){?>	

				<div class="orange font-20px padding-10pixels bolder">Invite Friends From Facebook</div><a onclick="invite_friends()" id="default-invitefriends"><img src="<?php echo Yii::app()->baseUrl;?>/images/invite-fb-friends.png" /></a>

				<?php //$this->widget('application.modules.hybridauth.widgets.renderProviders',array('invitefrnd'=>'facebook'));?>

				</p>

				<?php }else{ ?>

				<?php $this->widget('FbRegister',array('loggeduser'=>1,'page'=>'default'));?>

				<?php }?>

				</div>

				<div class="following-followers">

				<div class="following">

					<div class="orange font-16px padding-10pixels">Tracking - You are following</div>

					<div style="height:300px; width:97%; overflow:auto; float:left;">

					

				<?php foreach ($findalltiles as $tiledisplay){ ?>

				<?php 

				$getcount = Tracking::model()->findAllByAttributes(array('tracked_tileid'=>$tiledisplay->lookup_id,'tracker_userid'=>Yii::app()->session['login']['id'],'status'=>1));

				if(count($getcount) > 0){?>

					<div><a style="color:#838383; font-size: 14px; font-weight:bold;" >

							    <div id = "plusimg-<?php echo $tiledisplay->lookup_id;?>" onclick="showhideuserstracking(<?php echo $tiledisplay->lookup_id;?>,this.id,'tracking')"  style="display:none;">

									<img src = "<?php echo Yii::app()->baseUrl;?>/images/plus.gif" style="float:left;"/>

									<span style="float:left; padding-left:5px;"><?php echo $tiledisplay->lookup_name .'('.count($getcount).')'; ?></span>

								</div>

								<div id = "minusimg-<?php echo $tiledisplay->lookup_id;?>"  onclick="showhideuserstracking(<?php echo $tiledisplay->lookup_id;?>,this.id,'tracking')">

									<img src = "<?php echo Yii::app()->baseUrl;?>/images/minus.gif"/>

									<span style="padding-left:5px;"><?php echo $tiledisplay->lookup_name .'('.count($getcount).')'; ?></span>

								</div>

								 

						</a></div>

					<?php }?>

					<div style="clear:both;"></div>

					<div id = "tracking-<?php echo $tiledisplay->lookup_id;?>" > 

					

				<?php foreach($getcount as $getusers){

					$users = User::model()->findByAttributes(array('userid'=>$getusers->tracked_userid));

					$userimage = UserProfile::model()->findByAttributes(array('user_id'=>$getusers->tracked_userid)); ?>

					<div style=" color:#343434; font-size:13px; float:left; margin-left:21px;">

					<a href = "<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/'.$users->userid); ?>" >

					<span>

					<?php if(isset($userimage->profile_image)) { ?>

					<img width="50" height="50" src="<?php echo Yii::app()->baseUrl;?>/images/uploads/profileimages/<?php echo $userimage->profile_image;?>" title="<?php echo ucfirst($users->fname)." ".ucfirst($users->lname);?>">

					<?php }else{ ?>

						<img width="50" height="50" src="<?php echo Yii::app()->baseUrl;?>/images/no-image.jpg" title="<?php echo ucfirst($users->fname)." ".ucfirst($users->lname);?>">

					<?php } ?>

					</span>

					

					</a>

					</div>

				<?php } ?>

					</div>

					<div style="clear:left;"></div>

				<?php } ?>

</div>

		</div>

				<div class="followers">

				

				<div class="orange font-16px padding-10pixels">Trackers - Those who are following you</div>

				<div style="height:300px; width:97%; overflow:auto; float:left;">

					

					

				<?php foreach ($findalltiles as $tiledisplay){ 

$gettrackercount = Tracking::model()->findAllByAttributes(array('tracked_tileid'=>$tiledisplay->lookup_id,'tracked_userid'=>Yii::app()->session['login']['id'],'status'=>1)); 

?>



				<?php 

				if(count($gettrackercount) > 0){?>

					<div>

							<a style="color:#838383; font-size: 14px; font-weight:bold;" >

							<div id ="plusimgg-<?php echo $tiledisplay->lookup_id;?>" onclick="showhideusers(<?php echo $tiledisplay->lookup_id;?>,this.id,'tracker')" style="display:none;">

							<img src = "<?php echo Yii::app()->baseUrl;?>/images/plus.gif"  />

							<span>

							<?php echo $tiledisplay->lookup_name .'('.count($gettrackercount).')'; ?>

							</span>

							</div>

							<div  id = "minusimgg-<?php echo $tiledisplay->lookup_id;?>"  onclick="showhideusers(<?php echo $tiledisplay->lookup_id;?>,this.id,'tracker')">

							<img src = "<?php echo Yii::app()->baseUrl;?>/images/minus.gif"  />

							<span><?php echo $tiledisplay->lookup_name .'('.count($gettrackercount).')'; ?></span>

							</div>

							</a>

						</div>

					<div style="clear:both;"></div>

					<div id="tracker-<?php echo $tiledisplay->lookup_id;?>">

					<?php foreach($gettrackercount as $getusers){

					$users = User::model()->findByAttributes(array('userid'=>$getusers->tracker_userid)); 

					$userimage = UserProfile::model()->findByAttributes(array('user_id'=>$getusers->tracker_userid)); 

					?>

					

					<div style=" color:#343434; font-size:13px; float:left;  margin-left:17px;">

					<a href = "<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/'.$users->userid); ?>" >

					<?php echo $users->profile_image ; ?>

					<span>

					<?php if(isset($userimage->profile_image)) { ?>

					<img width="50" height="50" src="<?php echo Yii::app()->baseUrl;?>/images/uploads/profileimages/<?php echo $userimage->profile_image;?>" title="<?php echo ucfirst($users->fname)." ".ucfirst($users->lname);?>" />

					<?php }else{ ?>

						<img width="50" height="50" src="<?php echo Yii::app()->baseUrl;?>/images/no-image.jpg" title="<?php echo ucfirst($users->fname)." ".ucfirst($users->lname);?>" />

					<?php } ?>

					</span>

					</a>

					</div>

					

					<?php } ?>

					</div>

					<div style="clear:left;"></div>

				<?php } ?>

				

				<?php } ?>

				</div>

				</div>

				</div>

				</div>

				

				<!------------------ JOURNAL DIV FOR TRACKING AND TRACKERS END ---------------- -->   

	</div>

</div>

<script type="text/javascript">

$('document').ready(function()

{

	<?php if(isset($invitefriends) && $invitefriends =="invitefriends"){?>

		showtracking();

		$("#profile-invitefriends").trigger("click");

	<?php }?>	

});

</script>