<!-- Accordian code start -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/javascript/accordian/jquery.toggleElements.pack.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('div.toggler-1').toggleElements( );
});
</script>
<!-- Accordian code end -->
<script> 
window.fbAsyncInit = function() {
	FB.init({ 
		appId:'160095650812067', // or simply set your appid hard coded
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
						alert(resp);
	                    // callback after storing the requests
	                });
	            } else {
	                alert('canceled');
	            }
	        });
	}
	
}
</script>
<script type="text/javascript">

function getFilterDetails(lookupid,targetSource)
{
	var url= "<?php echo Yii::app()->createUrl('site/getFilterDetails'); ?>";
	switch(targetSource)
	{
		case 'interests':
		
			$.post(url, {interestid:lookupid,targetSource:targetSource},
			function(data) { 
					//alert(data);
					$("#connectionsMiddle").html(data);
					var frstUsrid = $("#firstConUserId").val();
					$("#rightframe").html("");
					displaySelectedData(frstUsrid);
			});
		
			break;
		case 'tags':
		
			$.post(url, {interestid:lookupid,targetSource:targetSource},
			function(data) { 
					//alert(data);
					$("#connectionsMiddle").html(data);
					var frstUsrid = $("#firstConUserId").val();
					//alert(frstUsrid);
					$("#rightframe").html("");
					displaySelectedData(frstUsrid);
			});
		
			break;
	}
	
	
}

function displaySelectedData(userid)
{
	/*Remove class to all the files and adding default class */
	$("div[id^='div']").removeClass("friend-details friend-details-active");
	$("div[id^='div']").addClass("friend-details");
	$("#div"+userid).addClass("friend-details friend-details-active");
	
	var url= "<?php echo Yii::app()->createUrl('site/getConnectionDetails'); ?>";
	$.post(url, {id:userid},
		function(data) { //alert(data);
					$("#rightframe").html(data);
					
			});			
}

/*
function changeImageClick()
{
	$("#profileFileupload").show();
	$('input[type=file]').trigger('click');
}

function editdata(disctr,editctr,Isedit)
{
	if(Isedit)
	{
		$("#"+disctr).hide();
		$("#"+editctr).show();	
	}
	else
	{
		$("#"+disctr).show();
		$("#"+editctr).hide();	
	}
	
	
}

function uploadDetails(trgaction,userid)
{
	var url= "<?php echo Yii::app()->createUrl('site/uploadDetail'); ?>";
	switch(trgaction)
	{
		case 'changeImage':
				var ext = $('#profileFile').val().split('.').pop().toLowerCase();
				if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
				    $("#profileFileupload").hide();
					alert('invalid extension!');
				}
				else
					$("#upload-form").submit();
				
				break;
		case 'changeName':
				var fname = $.trim($("#editfName").val());
				var lname = $.trim($("#editlName").val());
				if(fname != "" || lname != "")
				{
					$.post(url, {id:userid,uploadoption:trgaction,fname:fname,lname:lname},
					function(data) { 
							if(data == "success")
							{
								$("#displayName").html(fname + " " + lname);
								editdata('disName','editName',false);
							}
					});
				}
				break;
		case 'changeDescription':
				
				var description = $.trim($("#editdescription").val());
				if(description != "")
				{
					$.post(url, {id:userid,uploadoption:trgaction,description:description},
					function(data) { 
							if(data == "success")
							{
								$("#disdescription").html(description);
								//$("#editdescription").html(description);
								editdata('disdesc','editdesc',false);
								$('#aeditdesc').hide(); 
								$('#adisdesc').show(); 
							}
					});
				}
				break;
		case 'changeInterest':
		
				var selectInt = $("#dpselectInt").val()
				
				var countArray = new Array();
				countArray.push($("#dpselectInt").val());
				
				if(countArray != "")
				{
					$.post(url, {id:userid,uploadoption:trgaction,selectInt:selectInt},
					function(data) { 
					});
				}
				break;								
	}
	
}*/

</script>

	<!--<h1 class="page-headline">Empower Your Network 
            	<a href="#" class="addspeech" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."><img src="<?php echo Yii::app()->baseUrl; ?>/images/icon-help.png" />
                   
               </a>
            </h1>
            <div class="run-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>-->
            <div class="network">
			
                <div class="tabs">
             <!-- Added on 29-01-2013 to include common header in network page -->
				<?php $this->beginContent('//layouts/networkHeader'); ?>
						<?php $this->endContent(); ?>
				<!-- Ends here -->
                    
				<?php if($displaydata == 'connections') { 
							if($totalConnections > 0) {
														
						?>	
                    <div id="connections">
                        <div class="connections-left">
                        	<div class="tab-headline">Connections</div>
                            <div class="all-connections">
                            	<a href="#" onclick="js: getFilterDetails(0,'interests'); return false;" > All Connections (<?php echo $totalConnections; ?>)</a><br />
								
                            </div>
							<input type="hidden" id="userid" value="<?php echo $userid;?>"/>
								<input type="hidden" id="fbid" value="<?php echo $fbid;?>"/>
							<script src="http://connect.facebook.net/en_US/all.js"></script>	
					<?php if($fbid!=1){?>	
				<p style="padding-top:35px">Click Here To Invite Your FB Friends</p><a onclick="invite_friends()"><img src="<?php echo Yii::app()->baseUrl;?>/images/facebook-icon.png" /></a>
				<?php //$this->widget('application.modules.hybridauth.widgets.renderProviders',array('invitefrnd'=>'facebook'));?>
				</p>
				<?php }else{?>
				<?php //$this->widget('application.modules.hybridauth.widgets.renderProviders',array('invitefrnd'=>'all'));?>
				<?php //$this->widget('application.modules.hybridauth.widgets.renderProviders',array('invitefrnd'=>'facebook'));?>
				<?php }?>
                        </div>
						<div class="connections-middle">
						<div class="tab-headline" >All<!-- Select <a href="#" class="dark-blue-link">All</a> <a href="#" class="dark-blue-link">None</a> --></div>
						<div class="connections-order" id="connectionsMiddle">
						
							<?php $this->renderPartial('_networkmiddlepage',array('userDet'=>$userDet,
																				  'usertiles'=>$usertiles																									)); ?>
                        
						</div>
						</div>
                        <div class="connections-right" >
							<div class="tab-headline">&nbsp;</div>
							<div style="overflow-y:scroll; overflow-x:hidden; height:370px;" id="rightframe">
							<?php $this->renderPartial('_networkDetail',array('firstConnection'=>$firstConnection,
																				 'usertiles'=>$usertiles,
																				 'displaytiles'=>$displaytiles	
																		)); ?>
							</div>											
						</div>
                    </div>
                    <?php } else { ?>
					   <div id="connections">
					  <div class="connections-left">
                        	<!--<div class="tab-headline">Filter Connections</div>-->
                            <div class="all-connections">
                            	<a href="#" > All Connections (0)</a>
							</div>
							<div class="no-invitees orange-font15">You have no Connections</div>
                     </div>
						<div class="connections-middle">
						<!--<div class="tab-headline" >All</div>-->
						<div>
					
                            </div>
					  </div>
					 <!-- <div class="connections-right" >
							<div class="tab-headline">&nbsp;</div>
																		
						</div>-->
						</div>
					<?php  }?>
					<?php } ?>
					<?php if($displaydata == 'mailbox') { ?>    
                
						<?php 
						
						$this->redirect(array('mailbox/message/inbox')); 
						?>
					
					<?php } ?>
                </div>
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