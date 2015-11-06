<?php  if(!empty($profileinfo))
	   {
	   		if($profileinfo->profile_image != "")
			{
				$src = Yii::app()->baseUrl.'/images/uploads/profileimages/'.$profileinfo->profile_image;

			}

			else

			{

				$src = Yii::app()->baseUrl.'/images/no-image.jpg';

			}

	   }

	   else

	   	$src = Yii::app()->baseUrl.'/images/no-image.jpg';

		?>

<?php if($userid == Yii::app()->session['login']['id'] && $share == 'no'){?> 
   <div class="user-profile-pic">
<div class="profile-pic-change" onclick="js:$('#file_dash').trigger('click');">Change your profile picture</div>
		
      <a title="Minimum size 140 x 140 pixels" href="javascript:void(0);" onclick="$('#file_dash').trigger('click');"> <div id="profileImg" style=" overflow:hidden;background:url('<?php echo $src;?>') center center no-repeat; height:224px;background-size: 224px 224px;
border: solid 3px #d7d7d7">
       </div> </a>
		 
		
	</div>
    <form name="ProfileimageForm"  action="<?php echo Yii::app()->createUrl('profile/changePic/edit/2'); ?>"  method="post" enctype="multipart/form-data">

		 
			<div style="position:absolute; top:-100px; visibility:hidden">
            <input style="cursor:pointer;" type="file" class="file" name="file" id="file_dash" />
            </div>
            <input type="submit" id="btnProfileimageForm1" name="btnProfileimageForm" value="Upload" class="orange-button" style="display:none"  />
		    <input type="hidden" name="dashboard" value="1"  />	 
		 				 

		</form>
<?php }else{?> 


 <div class="user-profile-pic">

<img src="<?php echo $src;?>" width="224" height="224" />



</div>

<?php }?>



<div class="font-18px padding-10pixels"><?php echo ucfirst($userinfo->fname)." ".ucfirst($userinfo->lname);?></div>

<!--<div class="user-details font-14px"><span class="orange">Age:</span> 31</div>-->

<?php if($userinfo->location != ""){?>

<div class="user-details font-14px">

	<span class="orange">Location:</span>

	<?php echo $userinfo->location;?>

</div>

<?php }?>



<?php if(isset($tilesinfo) && !empty($tilesinfo)){?>

<div class="user-details font-13px padding-10pixels" style="line-height:20px;">

	<span class="orange">Tiles:</span> 

	<?php $tilenamesdis = "";

			foreach($tilesinfo as $tilenames){?>

	<?php  $tilenamesdis .= $tilenames->tilename.", ";?>

	<?php }

		echo substr($tilenamesdis,0,strlen($tilenamesdis)-2);	

		?>

</div>

<?php }?>


<?php if(!($userid != Yii::app()->session['login']['id'])) { ?>
<div  <?php if(!isset(Yii::app()->session['knownusers'])){?> style="height:50px; margin-top:20px;" <?php }?>>
						<input type="hidden" id="fbid" value="<?php echo Yii::app()->session['login']['socialnetworkid'];?>" />

					<?php
                    if(!isset(Yii::app()->session['knownusers']))
     				{?> 
						<a onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/inviteFBfriends.png" width="200" /></a>	 	
	 				<?php } 
					
					else{?>
						<div class="font-14px orange" style="width:100%; padding-bottom:10px;"><span class=""><?php if($userid!= Yii::app()->session['login']['id'])echo ucfirst($user->fname)."'s";?> Friends In FINAO</span> <a class="right" onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/invite-friends.png" width="100" /></a></div>
						
					<?php } ?>  
                    
					<!--<div id="Default2" class="contentHolder2 ps-container">

					<div id="friends" class="friends-list-wrapper">

								

					</div>

					</div>-->

	            </div>
                
<?php } ?>                

<?php // old code //if($userid != Yii::app()->session['login']['id'] && $profileinfo->mystory != ""){
if($profileinfo->mystory != ""){?>
<a id="my-story" class="orange-link font-14px" href="#story"><?php echo ucfirst($userinfo->fname)." ".ucfirst($userinfo->lname)."'s Story";?></a>
<?php }?>

<?php //if(isset($finao) && !empty($finao)){?>

<!--<div class="user-details font-14px" style="display:none;">

<span class="orange">My Recent FINAO:</span>

</div>-->

<!--<p><?php //echo ucfirst($finao->finao_msg);?></p>

 <p class="right display-time"><?php //echo $this->getPassedTime($finao->updateddate);?></p>-->

<?php //}?>

<div style="display: none;">
<div id="story" style="width:600px;min-height:150px;max-height:600px; padding:10px; overflow: auto;">
<p class="orange font-16px padding-10pixels"><?php echo ucfirst($userinfo->fname)." ".ucfirst($userinfo->lname)."'s Story";?></p>
<p style="font-size:14px; line-height:22px; padding-bottom:5px;"><?php echo $profileinfo->mystory;?></p>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
$("#my-story").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,
		
		
	});
});


var url = window.URL || window.webkitURL;
 
	$('#file_dash').bind('change', function() {

   
  	
	filetype = this.files[0].type; 
	
  	var ext = filetype.split('/').pop().toLowerCase();
	if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
		  alert('Invalid extension!');
		}
		else{
				
				//alert(this.files)
				var chosen = this.files[0];
				var image = new Image();
				imgwidth = "";
				imgheight = "";
				
				 
				
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					$("#btnProfileimageForm1").show(); 
					alert("After clicking OK \nPlease click on Upload button to crop your profile image!!!")
					//$("#uploadimag").trigger('click');
				}
				else
					document.ProfileimageForm.submit();
		}	


	});
	
	
	function changepic(id)
	{
	var ext = $('#'+id).val().split('.').pop().toLowerCase();
	if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
	  alert('Invalid extension!');
	}
	else{
		if(id=="file")
		{
			$("#ProfileimageForm").submit();
		}
		else if	(id=="bgfile")
		{
			$("#BgimageForm").submit();
		}
		}
	}

	 


 
</script>