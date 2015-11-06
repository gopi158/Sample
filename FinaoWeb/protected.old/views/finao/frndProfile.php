<div class="finao-welcome-content" style="height:410px;">
	<input type="hidden" id="profileuserid" value="<?php echo $user->userid;?>"/>
	<div class="welcome-content-left">
      	<div class="profile-picture">
           	<div class="my-profile-img">
			<?php if($userinfo->profile_image != ""){
		$profileimage = Yii::app()->baseUrl."/images/uploads/profileimages/".$userinfo->profile_image;
		
	}else{
		$profileimage = Yii::app()->baseUrl."/images/no-image.jpg";
	} ?>
			<img src="<?php echo $profileimage;?>" width="180" height="230" /></div>
			
        </div>
		<div style="clear:left"></div>
		<div class="my-name"><a href="#"><?php echo $user->fname." ".$user->lname;?></a></div>
		<div style="clear: left;"></div>
        <div class="how-iam-doing">
           	<p class="hdline-hw-doing">How I am doing all up</p>
			<p class="bolder padding-7pixels"><span style="color:#07C1E6;" class="font-13px">On Track</span> - <span style="color:#FF791F;" class="font-13px">Ahead</span> - <span style="color:#467e14;" class="font-13px">Behind</span></p>
            
            </div>
        </div>
        <div class="welcome-content-right">
        	<div class="font-20px padding-8pixels"><span style="color:#FF791F;"><?php echo ucfirst($user->fname)."'s";?></span> FINAO</div>
            <p class="font-16px padding-20pixels"><?php echo $userinfo->user_profile_msg;?></p>
            
            <div class="font-20px padding-8pixels"><span style="color:#FF791F;"><?php echo ucfirst($user->fname)."'s";?></span> Story</div>
            <p class="font-16px padding-10pixels"><?php echo $userinfo->mystory;?></p>
        </div>
		<?php $this->widget('ProgressBar',array('userid'=>$user->userid,'frndprofile'=>'frndprofile'));?>
    </div>


<script type="text/javascript">
$( document ).ready( function(){
var userid = document.getElementById('profileuserid');
if(userid != null)
{
	refreshwidget(userid.value);
	getprofile(userid.value);
	gettracking(userid.value);
	getallstatus(userid.value);
}
});
</script>	