
<!--<div id="fb-root"></div> -->
<script> 
window.fbAsyncInit = function() {
	FB.init({ 
		appId:'240563026070641', // or simply set your appid hard coded
		cookie:true, 
		status : true,
		xfbml:true
	});

};
FB.api('/me', function(response) {
  alert('Your name is ' + response.name);
});
// https://developers.facebook.com/docs/reference/dialogs/requests/
function invite_friends() {
	var fbid = document.getElementById('fbid').value;
	if(fbid!=1)
	{
		//alert("hiii");
		FB.ui({
			method: 'apprequests', message: 'wants you to join at Parent Valet'
			
		},
	        function (response) {
	            if (response.request && response.to) {
	                var request_ids = [];
	                for(i=0; i<response.to.length; i++) {
	                    var temp = response.request + '_' + response.to[i];
	                    request_ids.push(temp);
	                }
	                var requests = request_ids.join(',');
					var userid = document.getElementById('userid').value;
					var fbid = document.getElementById('fbid').value;
					var url = '<?php echo Yii::app()->createUrl("/site/acceptInvite"); ?>';
					//alert(userid);
	                $.post(url,{uid: userid,fbid:fbid, request_ids: requests},function(resp) {
						//alert(resp);
	                    // callback after storing the requests
	                });
	            } else {
	                alert('canceled');
	            }
	        });
	}
	
}
</script>

<input type="hidden" id="userid" value="<?php echo $userid;?>"/>
<input type="hidden" id="fbid" value="<?php echo $fbid;?>"/>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<?php if(!isset($networkpage)){?>
<!-- Added on 29-01-2013 to include common header in network page -->
<?php $this->beginContent('//layouts/networkHeader'); ?>
		<?php $this->endContent(); ?>
<!-- Ends here -->
<?php }?>
<div id="invitefriends" style="min-height:500px; margin-top:3px!important;">
        		<div class="invite-fb-headline">Involve Your Network In Supporting Your Child’s Learning Needs</div>
                <!--<div class="run-text"></div>-->
                <div class="run-text">Establish an intimate network that supports your child’s learning by selecting friends and family from your Facebook community.</div>
				<?php if($fbid!=1){?>
				<p class="btn-fb-friends"><a href="#" onclick="invite_friends()"><img src="<?php echo Yii::app()->baseUrl;?>/images/facebook-icon.png" /></a>
				<?php $this->widget('application.modules.hybridauth.widgets.renderProviders',array('invitefrnd'=>'all'));?>
				</p>
				<?php }else{?>
				<?php $this->widget('application.modules.hybridauth.widgets.renderProviders',array('invitefrnd'=>'all'));?>
				<?php $this->widget('application.modules.hybridauth.widgets.renderProviders',array('invitefrnd'=>'facebook'));?>
				<?php }?>
                <!--<p class="right"><a href="#" class="blue-link">Skip to Education Plan</a></p>-->
				
<?php if(isset($known) && $known == "endofpage"){?>
	<div class="search-contacts">
    	<p class="run-text font-13px">
			Thanks for searching your Gmail contacts. Come back anytime to find connections.
		</p>
    </div>
<?php }?>
</div>

<script type="text/javascript">
 $(document).ready(function() {
  document.getElementById('anyemail').value = '';
 });
function validateemail()
{
	var email = document.getElementById('logedemail').value;
	if($("#anyemail").val().length < 1)
	{
		alert("Please Enter any email");
		return 'false';
	}
	else
	{
		email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if(!email_regex.test($("#anyemail").val()))
		{	
			document.getElementById('anyemail').className = 'validation-no';
			alert("Incorrect Format of email");
			return 'false';
		}
		else
		{
			if(email == $("#anyemail").val())
			{
				alert("You cannot invite");
				return 'false';
			}
			else
				return 'true';
				
		}
	}
	//return 'false';
}
</script>