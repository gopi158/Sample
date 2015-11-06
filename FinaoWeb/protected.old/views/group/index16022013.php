<?php //print_r($othergroups);exit; ?>
<!-- Scrollbar Start -->
<link href="<?php echo $this->cdnurl;?>/javascript/scrollbar/perfect-scrollbar.css" rel="stylesheet">
<script src="<?php echo $this->cdnurl;?>/javascript/scrollbar/jquery.mousewheel.js"></script>
<script src="<?php echo $this->cdnurl;?>/javascript/scrollbar/perfect-scrollbar.js"></script>
<script>
	jQuery(document).ready(function ($) {
	"use strict";
	$('#Default6').perfectScrollbar();
	});
	jQuery(document).ready(function ($) {
	"use strict";
	$('#Default5').perfectScrollbar();
	});
	/*jQuery(document).ready(function ($) {
	"use strict";
	$('#Default8').perfectScrollbar();
	});*/
	
	
</script>
<!-- Scrollbar End -->



<script type="text/javascript" src="<?php echo $this->cdnurl;?>/javascript/accordian/scriptbreaker-multiple-accordion-1.js"></script>
<script type="text/javascript" src="<?php echo $this->cdnurl;?>/javascript/jquery.multiemail.js"></script>
<style type="text/css">
    .multiemail-cont {
        padding: 3px 0 0 5px;
        cursor: text;
        position: relative;
        font-size: 12px;
        line-height: 100%;
		background:#FFF;
		min-height:20px;
		height:auto;
    }
    .multiemail-cont * {
        font-size: 100%;
        line-height: 100%;
        display: inline;
    }
    .multiemail-cont .multiemail-input {
        width: 25px;
        height: 16px;
        padding: 0;
        background-color: transparent;
        border: 0;
        display: inline-bock;
    }
    .multiemail-cont .multiemail-input:focus {outline: none;}
    .multiemail-cont .multiemail-twin {display: none; position: absolute; padding: 0;}
    .multiemail-cont .multiemail-email {
        border: solid 1px #d9d9d9  ;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
        padding: 3px 4px;
        _vertical-align: middle;
        margin: 0 3px 0 0;
        background-color: #f5f5f5 ;
        display: inline-block;
        cursor: default;
		color:#000;
		margin-bottom:3px;
    }
    .multiemail-cont .multiemail-email:hover {background-color: #d9d9d9  ;}
    .multiemail-cont .multiemail-email.selected {background-color: #d9d9d9  ; color: #000  ;}
    .multiemail-cont .multiemail-email .multiemail-close {padding-left: 5px; font-weight: bold; cursor: pointer;}
    .multiemail-cont .multiemail-placeholder {
        display: none;
        color: #999  ;
        padding: 3px 0;
    }
	
</style>
<script type="text/javascript">
	$(function() {
		$('#memail').multiEmail({
			placeholder: 'Enter Email Ids',
			fieldCss: {
				width: '225px'
			},
			max: 10
		});	
	});
</script>

<script language="JavaScript">
$(document).ready(function() {
	$(".topnav").accordion({
		accordion:false,
		speed: 500,
		closedSign: '+',
		openedSign: '-'
	});	
	
<?php if($errormsg == 1){?> 
	alert("Minimum size 260 x 260 pixels");
<?php } ?>
<?php if($errormsg == 2){?> 
	alert("Minimum size 720 x 330 pixels");
<?php } ?>
});
</script>
<?php
	$selectedfinao = "";
	$selectedtile = "";
	$upload = "";
	$jourlid = "";
	if(isset($isuploadprocess) != "")
	{
		$selectedfinao = isset($isuploadprocess["finao"]) ? $isuploadprocess["finao"] : "";
		$selectedtile = isset($isuploadprocess["tile"]) ? $isuploadprocess["tile"] : "";
		$upload = isset($isuploadprocess["upload"]) ? $isuploadprocess["upload"] : "";
		$jourlid = isset($isuploadprocess["journalid"]) ? $isuploadprocess["journalid"] : "";
		$menuselected = isset($isuploadprocess["menuselected"]) ? $isuploadprocess["menuselected"] : "";
	}
?>

<script type="text/javascript">

    var finaoid = '<?php echo $selectedfinao; ?>';
    var tileid = '<?php echo $selectedtile; ?>';
	var userid = '<?php echo $userid; ?>';
    var upload = '<?php echo $upload; ?>';
	var jourlid = '<?php echo $jourlid; ?>';
	var menuselected = '<?php echo $menuselected; ?>';
	
	//alert(tileid);
	$('document').ready(function()
	{
		if(finaoid != "" && tileid != "")
		{
			hidealldivs();
		
			if(upload != "")
			{
				if(jourlid == "" || jourlid == 0) // modified on 02-04-2013
					addimages(userid,'',finaoid,'finao',upload,0);
				else
					addimages(userid,'',finaoid,'journal',upload,jourlid);	
			}else
			{
				getfinaos(userid,tileid);
				view_single_finao(userid,finaoid);
				refreshmenucount(userid);
			}
			if(menuselected != "")
			{
				enablemenu(menuselected);
			}
			
			//refreshwidget(userid); // Added on 02-04-2013	
		}

		$("#newfinaofnacy").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,
		});
	});
	
function checkEmail(email) {
var regExp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
return regExp.test(email);
}
 var v=1;
function checkEmails(groupid){ 
    var emails = $(".multiemail-input").val();
	var emails1 = $(".sam").val();
	//alert(emails); alert(emails1);
	if(emails =='' || emails1 =='undefined')
	{//alert(emails); alert(emails1); 
		$('#sucmsg').html('Enter Email Id');$("#memail").focus();return false;
	}
	else 
	{
		if(v==1){
		$('.sam').each(function()
		{
			if(checkEmail($(this).val()))
			{
				if($('#emailid').val()==$(this).val()){$('#sucmsg').html("your Inviting your mail"); $("#memail").focus();
				return false;}
				else{
				var url='<?php echo Yii::app()->createUrl("/group/InviteMembers"); ?>';
			$.post(url, { emailid :$(this).val() ,groupid:groupid,membertype:'mails'},
			function(data){$('#sucmsg').html('Invitation Sent Successfully..');$('#reset_reset').html('<input type="text" name="mailList" style="width:96%;" id="memail"  title="Enter Mail ids seperated by space" class="txtbox">');$('#memail').multiEmail({placeholder: 'Enter Email Ids',	fieldCss: {width: '225px'},max: 10});});	
					}			
			}
			else
			{$('#sucmsg').html("invalid email: " + $(this).val()); $("#memail").focus();return false;}			
		});
		}
		v++;
	$("#memail").val('');
	}	
}
function invites(a)
{
	if(a==1) { $('#mail_invite').show();$('#facebook_invite').hide();}
	else { $('#mail_invite').hide();$('#facebook_invite').show();}
	$('#sucmsg').html('')
}
function invite_friends() {
	var fbid = document.getElementById('fbid').value;
	if(fbid!=1)
	{
		//alert(fbid);
		FB.ui({
			method: 'apprequests', message: 'wants you to join at FINAO Nation'
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
					//alert(userid + "----" + requests);
					var url = '<?php echo Yii::app()->createUrl("/site/acceptInvite"); ?>';
					//alert(userid);
	                $.post(url,{uid: userid,fbid:fbid, request_ids: requests},function(resp) {
	                });

	            } else {
	                alert('canceled');
	            }
	        });
	}
}

</script>

<?php if(!empty($_REQUEST['imgupload'])){?> 
  <link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/css/imgareaselect-default.css" />
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.imgareaselect.pack.js"></script>

<?php } ?>


<?php if(!empty($groupfinaos)){ ?>
<link href="<?php echo $this->cdnurl;?>/javascript/scrollbar/perfect-scrollbar.css" rel="stylesheet" />
<script src="<?php echo $this->cdnurl;?>/javascript/scrollbar/jquery.mousewheel.js"></script>
<script src="<?php echo $this->cdnurl;?>/javascript/scrollbar/perfect-scrollbar.js"></script>
<script>
		jQuery(document).ready(function ($) {
		"use strict";
		//if(jQuery('#Default10').length)
			jQuery('#Default10').perfectScrollbar();
		});
</script>
<?php }?>
 

<script type="text/javascript">
var IsimgUpload = "<?php echo $Imgupload; ?>";
var Tileimageupload = '<?php echo $Tileimageupload;?>';
$(document).ready(function () {
    
	
	
	
	 
	if($('img#profile_imageid').length)
	{
		$('img#profile_imageid').imgAreaSelect({
        x1: 0, y1: 0, x2: 260, y2: 260,
		//maxWidth: 980, 
		//maxHeight: 350, 
		aspectRatio: '2.8:1',
        onSelectEnd: getGroupprofileSizes
    	});	
	}
	
	if($('img#groupimageid').length)
	{
		$('img#groupimageid').imgAreaSelect({
        x1: 0, y1: 0, x2: 980, y2: 330,
		//maxWidth: 980, 
		//maxHeight: 350, 
		aspectRatio: '2.8:1',
        onSelectEnd: getGroupSizes
    	});	

	}
	 
	
	if(IsimgUpload != 0 || Tileimageupload != 0)
	{
		$("#divactualImg").hide();
	}
		

});
  
function getGroupSizes(im,obj)
	{
		
		var groupid = document.getElementById('groupid').value;
		var x_axis = obj.x1;
		var x2_axis = obj.x2;
		var y_axis = obj.y1;
		var y2_axis = obj.y2;
		var thumb_width = obj.width;
		var thumb_height = obj.height;
		var urlvalue = "<?php echo Yii::app()->createUrl('Finao/cropImage');?>";
		if(thumb_width > 0)
			{
				if(confirm("Press OK to SAVE image or CANCEL to CONTINUE EDITING!"))
					{
						fileext = ($("#group_image_name").val()).substr(($("#group_image_name").val()).lastIndexOf('.')+1);
						$.ajax({
							type:"GET",
							url: urlvalue+"?t=ajax&img="+$("#group_image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis+"&fileext="+fileext+"&groupimageid="+groupid,
							
							cache:false,
							success:function(rsponse)
								{
									
								 	if(rsponse == "Please try again!!")
									{
										alert("Please try again!!");
										return false;
									}
									
									var rd ='<?php echo Yii::app()->createUrl("/group/Dashboard/groupid/##data"); ?>';
	                    			rd = rd.replace('##data',rsponse);
									location.href = rd  ;
									
								}
						});
					}
			}
		else
			alert("Please select portion..!");
	}
	
	function getGroupprofileSizes(im,obj)
	{
		
		var groupid = document.getElementById('groupid').value;
		var x_axis = obj.x1;
		var x2_axis = obj.x2;
		var y_axis = obj.y1;
		var y2_axis = obj.y2;
		var thumb_width = obj.width;
		var thumb_height = obj.height;
		var urlvalue = "<?php echo Yii::app()->createUrl('Finao/cropImage');?>";
		if(thumb_width > 0)
			{
				if(confirm("Press OK to SAVE image or CANCEL to CONTINUE EDITING!"))
					{
						fileext = ($("#profile_image_name").val()).substr(($("#profile_image_name").val()).lastIndexOf('.')+1);
						$.ajax({
							type:"GET",
							url: urlvalue+"?t=ajax&img="+$("#profile_image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis+"&fileext="+fileext+"&profileimageid="+groupid,
							
							cache:false,
							success:function(rsponse)
								{
									
									 
								     if(rsponse == "Please try again!!")
									{
										alert("Please try again!!");
										return false;
									}
									
									var rd ='<?php echo Yii::app()->createUrl("/group/Dashboard/groupid/##data"); ?>';
	                    			rd = rd.replace('##data',rsponse);
									location.href = rd  ;
								
								}
						});
					}
			}
		else
			alert("Please select portion..!");
	}

</script>

<script type="text/javascript" >
var url = window.URL || window.webkitURL;
$(document).ready(function(){
	$('#file').bind('change', function() {
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
					$("#btnProfileimageForm").show();
					alert("After clicking OK \nPlease click on Upload button to crop your cover image!!!")
				}
				else
					document.CoverimageForm.submit();

		}	
});

var url = window.URL || window.webkitURL;
 
	$('#file_group').bind('change', function() {

   
  	
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


});



</script>

<input type="hidden" id="iscompleted" value=""/>
<input type="hidden" id="isshare" value="<?php echo $share;?>"/>
<input type="hidden" id="isheroupdate" value=""/>
<input type="hidden" id="finaoid" value=""/>
<input type="hidden" id="loggeduserid" value="<?php if($userid==Yii::app()->session['login']['id']){echo $userid;}?>"/>
<input type="hidden" id="userid" value="<?php echo $userid;?>"/>

<input type="hidden" id="statusid" value=""/>

<input type="hidden" id="selectedtile" value=""/>
<input type="hidden" id="usertileid" value=""/>
<input type="hidden" id="isfrommenu" value=""/>
<input type="hidden" id="groupid" value="<?php echo $isgroup; ?>"/>
<input type="hidden" id="ismember" value="<?php echo $isgroupmem; ?>"/> 


<?php if($_REQUEST['imgupload'] == 1){?> 

<?php  
 if(isset($groupinfo) && $groupinfo != "")
				{
					if(isset($groupinfo->temp_profile_image))
					{
						
						$coversrc=$this->cdnurl."/images/uploads/groupimages/profile/".$groupinfo->temp_profile_image;							//print_r($coversrc);	
						if(!file_exists(Yii::app()->basePath."/../images/uploads/groupimages/profile/".$groupinfo->temp_profile_image))
						{
							$coversrc= $this->cdnurl."/images/coverpage.jpg";
						}
					}
					else
						$coversrc= $this->cdnurl."/images/coverpage.jpg";
				
		        }
		 		else
				{
		         	$coversrc= $this->cdnurl."/images/coverpage.jpg";
		        }

?>

<div class="main-container">
<div id="divCoverimg" style="z-index:111; width:1000px" class="finao-canvas">
			<a class="btn-close" onclick="closefrommenu(0)" ><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>

				<span class="my-finao-hdline orange">Crop your Image</span>
				   <div class="left">
				   <ul style="padding-left:10px;">
				   <li class="font-14px padding-10pixels">Select the area of the image by holding the corner and dragging it to your desired area. </li>
				   <li class="font-14px padding-10pixels">Click on OK button to save the image or click on Cancel to change the selection.</li>
				  <!-- <li class="font-14px padding-10pixels">Click on Change Profile Picture to select new image.</li>--></ul>
				   </div>
				    <div class="right"><a href="javascript:void(0);" onclick="js:$('#file').trigger('click');" class="font-16px orange-link"> Change Picture</a></div>	
			
				<img src="<?php echo $coversrc; ?>" id="profile_imageid" />
				<input type="hidden" name="profile_image_name" id="profile_image_name" value="<?php echo $groupinfo->temp_profile_image; ?>" />
				
</div>
</div>

<?php }

if($_REQUEST['imgupload'] == 2){//exit;
  
?> 
<script type="text/javascript" >
var url = window.URL || window.webkitURL;
$(document).ready(function(){
	$('#file').bind('change', function() {
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
					$("#btnProfileimageForm").show();
					alert("After clicking OK \nPlease click on Upload button to crop your cover image!!!")
				}
				else
					document.CoverimageForm.submit();

		}	
});



});
</script>
			<?php
			
				if(isset($groupinfo) && $groupinfo != "")
				{
					if(isset($groupinfo->temp_profile_bg_image))
					{
						
						$coversrc=$this->cdnurl."/images/uploads/groupimages/coverimages/".$groupinfo->temp_profile_bg_image;							//print_r($coversrc);	
						if(!file_exists(Yii::app()->basePath."/../images/uploads/groupimages/coverimages/".$groupinfo->temp_profile_bg_image))
						{
							$coversrc= $this->cdnurl."/images/coverpage.jpg";
						}
					}
					else
						$coversrc= $this->cdnurl."/images/coverpage.jpg";
				
		        }
		 		else
				{
		         	$coversrc= $this->cdnurl."/images/coverpage.jpg";
		        }
			?>
		<div class="main-container">
		
			<div id="divCoverimg" style="z-index:111; width:1000px" class="finao-canvas">
			<a class="btn-close" onclick="closefrommenu(0)" ><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>

				<span class="my-finao-hdline orange">Crop your Image</span>
				   <div class="left">
				   <ul style="padding-left:10px;">
				   <li class="font-14px padding-10pixels">Select the area of the image by holding the corner and dragging it to your desired area. </li>
				   <li class="font-14px padding-10pixels">Click on OK button to save the image or click on Cancel to change the selection.</li>
				  <!-- <li class="font-14px padding-10pixels">Click on Change Profile Picture to select new image.</li>--></ul>
				   </div>
				    <div class="right"><a href="javascript:void(0);" onclick="js:$('#file').trigger('click');" class="font-16px orange-link"> Change Picture</a></div>	
			
				<img src="<?php echo $coversrc; ?>" id="groupimageid" />
				<input type="hidden" name="group_image_name" id="group_image_name" value="<?php echo($groupinfo->temp_profile_bg_image); ?>" />
                
				</div>
 
 </div>
<?php } ?>


                
<div class="main-container">
    	
        
        
	
	 <div id="divdisplaydata"></div> 
     <div id = "showcompletedfinaodiv-default" style="display:none"></div>
    <!--Div for showing FINAOS STARTS-->
    <div id= "finaodiv" style="display:none;">
		<div id="finaoform" class="finaoform">
			<div id="finaomesgsdisplay">
				<?php if(isset($allfinaos)){?>
					<input type="hidden" value="finaos" id="nofinaos"/>
				<?php }else{?>
					<input type="hidden" value="nofinaos" id="nofinaos"/>
				<?php }?>
			</div>
		</div>
		<!--<div id="newfinaoform" style="display:none;"></div>-->
	</div>
    <!--Div for showing FINAOS ENDS-->
    
   <?php  //if($_REQUEST['imgupload'] != 2){?>
    <div id="hidecover">
            
            <?php /*?><div class="finao-cover-new-left" style= "height:345px!important;">
               <?php if(!empty($groupinfo->profile_image)){ 
                           $src = $this->cdnurl."/images/uploads/groupimages/profile/".$groupinfo->profile_image; 
                             }
							 else
							 {
							$src = $this->cdnurl."/images/no-image.jpg";  
							 } 
				?>
                    
                     
                     
                     <?php if($userid == Yii::app()->session['login']['id'] && $share == 'no'){?> 
   <div class="user-profile-pic">
<div class="profile-pic-change" onclick="js:$('#file_group').trigger('click');">Change your profile picture</div>
		
      <a title="Minimum size 140 x 140 pixels" href="javascript:void(0);" onclick="$('#file_group').trigger('click');"> <div id="profileImg" style=" overflow:hidden;background:url('<?php echo $src;?>') center center no-repeat; height:260px;background-size: 260px 260px;
border: solid 3px #d7d7d7">
       </div> </a>
		
		
	</div>
    <form name="ProfileimageForm"  action="<?php echo Yii::app()->createUrl('finao/changePic'); ?>"  method="post" enctype="multipart/form-data">

		 
			<div style="position:absolute; top:-100px; visibility:hidden">
            <input style="cursor:pointer;" type="file" class="file" name="file" id="file_group" />
            </div>
            <input type="hidden" name="groupprofileimage" value="1" />
            <input type="hidden" name="groupid" value="<?php echo $isgroup;?>"  />
            <input type="submit" id="btnProfileimageForm1" name="btnProfileimageForm" value="Upload" class="orange-button" style="display:none"  />
		   
		 				 

		</form>
<?php }else{?> 

 <div class="user-profile-pic">
 
		  <div id="profileImg" style=" overflow:hidden;background:url('<?php echo $src;?>') center center no-repeat; height:260px;background-size: 260px 260px;
border: solid 3px #d7d7d7">
       </div>  
		
		
	</div>
<?php }?>
 <div style="clear:both"></div>
         
             <a class="orange-link font-14px" href="<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>"><div class="group-profile">Switch To My Home Page</div></a> 
             <div style="clear:both"></div>
               
            <div class="group-profile"> 
              <a href="#story" class="orange-link font-14px" id="my-story"><?php echo $groupinfo->group_name; ?>'s Story</a> 
             </div>       
            </div><?php */?>
  
            <div style="display: none;">
			<div id="story" style="width:600px;min-height:150px;max-height:600px; padding:10px; overflow: auto;">
			
			<p style="font-size:14px; line-height:22px; padding-bottom:5px;"><?php echo $groupinfo->group_description;?></p>
			</div>
			</div>          
			
            <div class="finao-cover-new">
            <div class="display-group-name">
            	<div class="group-name-left orange"><?php echo ucfirst($groupinfo->group_name); ?></div>
                <div class="group-name-right">
				<?php if($userid != Yii::app()->session['login']['id'] || $share=="share") { ?>
					 <span ><a class="white-link font-13px gropfollowing" href="javascript:void(0);" <?php if($share_value ==0){?> onclick="follow_group(<?php echo $userid;?>,<?php echo $groupinfo->group_id;?>);"<?php }?>><?php echo $results;?></a> </span>|<?php if($share_value ==0){?> <span class="followgroup" ></span> <?php }else{?> <span>Follow Group</span><?php }?>   
				  <?php } else { ?>                   
				  <span ><a href="javascript:void(0)" class="white-link font-13px" onclick="return creategroup('<?php echo $_GET['groupid'];?>','1');">Edit Group</a>  </span>| <a class="white-link font-12px" href="javascript:void(0)" onclick="return delete_group(<?php echo $_GET['groupid'];?>);"> Delete Group </a>
                   <?php }?>
                </div>
            </div>
			<?php if(!empty($groupinfo->profile_bg_image))
					$coverpage=$this->cdnurl."/images/uploads/groupimages/coverimages/".$groupinfo->profile_bg_image;
					else
					$coverpage=$this->cdnurl.'/images/coverpage.jpg';?>			
            	<img width="986" height="350" src="<?php echo $coverpage;?>">				
               <?php  if($userid==Yii::app()->session['login']['id'] && $share!="share"){ ?>
                <form enctype="multipart/form-data" method="post" action="<?php echo Yii::app()->createUrl('finao/changePic'); ?>" name="CoverimageForm">
			<input type="file" id="file" name="file" class="file" style="cursor:pointer; visibility:hidden">            
             <a href="javascript:void(0);" title="Minimum size 980 x 350 pixels" onclick="js:$('#file').trigger('click');"><div class="change-picture orange">Change cover photo</div>
            </a>
            <input type="hidden" name="groupcoverimage" value="1" />
            <input type="hidden" name="groupid" value="<?php echo $isgroup;?>"  />
            <input type="submit" style="display:none;" class="orange-button" value="Upload" name="btnProfileimageForm" id="btnProfileimageForm"> 
			</form>
            <?php } ?>
            </div>
            
    </div> 
    <?php //} ?>  	
        <div class="profile-wrapper">
            <div class="profile-content">                
               
			    <?php /*?><div class="profile-left-panel">
					
    <?php if(isset($tilesinfo) && !empty($tilesinfo)){?>
                    <div class="user-profile">



<div class="user-details font-13px padding-10pixels" style="line-height:20px;">

	<span class="orange">Tiles:</span> 

	<?php $tilenamesdis = "";

			foreach($tilesinfo as $tilenames){?>

	<?php  $tilenamesdis .= $tilenames->tilename.", ";?>

	<?php }

		echo substr($tilenamesdis,0,strlen($tilenamesdis)-2);	

		?>

</div>



       
       
        </div> 
        <?php }?>
					 
					 <?php  if($userid==Yii::app()->session['login']['id'] && $groupinfo->group_status_ispublic == 1){ ?> 
                    
                    
                    
                    
                    <div class="user-profile">
                    	<div style="width:100%;" class="orange font-18px padding-10pixels left">
                        	<span class="left">Invite Members</span>
                        </div>
                                             
						<span id="mail_invite">
						 <div class="padding-5pixels"><!--<a class="orange-link" href="#">Search People</a> |--> <a class="orange-link" href="javascript:void(0);" onclick="invites(1);">Email</a> | <a onclick="invites(2);" class="white-link" href="javascript:void(0);">Facebook</a></div>
							<input type="hidden" id="userid" value="<?php echo $userid;?>"/>
					<input type="hidden" id="fbid" value="<?php echo Yii::app()->session['login']['socialnetworkid'];?>" />
                        <div class="padding-5pixels"><input type="text" style="width:96%;" id="memail" placeholder="Enter Mail ids seperated by Commas or Semi colon" title="Enter Mail ids seperated by Commas or Semi colon" class="txtbox"></div>
                        <div class="padding-5pixels"><input type="button" value="Invite" class="orange-button" onclick="return checkEmails('<?php echo $_GET['groupid'];?>');"> <input type="button" value="Reset" class="orange-button" onclick="document.getElementById('memail').value='';"></div>
						<div id="sucmsg" style="color:#FFFFFF"></div>
						</span>
						<div id="facebook_invite" style="display:none">
						 <div class="padding-5pixels"><!--<a class="orange-link" href="#">Search People</a> |--> <a class="white-link" href="javascript:void(0);" onclick="invites(1);">Email</a> | <a onclick="invites(2);" class="orange-link" href="javascript:void(0);">Facebook</a></div>
						<a onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/inviteFBfriends.png" width="200" /></a>
					</div>
						
                    </div>	
					<?php } ?>				
					 <div class="clear"></div>
                    
				
				
                	<!--<a class="orange-link font-14px" href="<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>"><div class="group-profile">Switch To My Home Page</div></a>-->
					 <div class="clear"></div>
					
					<?php if($userid == Yii::app()->session['login']['id'] && $share != "share"){ ?>
				<div class="archives">
					<ul class="topnav">
							<li><a href="javascript:void(0);">Archived FINAOs</a>
								<ul>
									<div  id="archives">
										<?php $this->renderPartial('_allgroupfinaos',array('finaos'=>$archivefinao['finaos'],'Iscompleted'=>"completed")); ?>
									</div>
								</ul>
							</li>
					</ul>
				</div>
				<?php  }?>
                   <div class="clear"></div>
                 
                  <?php  if($userid !=Yii::app()->session['login']['id']){ ?>   
                  <div class="user-profile">
				  <div class="padding-10pixels"><img width="230" src="<?php echo $this->cdnurl; ?>/images/sponsors/group-place-holder.jpg"></div>
                  <div class="featured-video-text">Josten is committed to supporting your school's mission by encouraging underclassmen to make a commitment to graduation through our C2G program, recognize  all students through our Renaissance Program and inspire students and teachers to make a difference everyday with all our Educator Services.</div>
                  
                  <div class="padding-10pixels"><img width="230" src="<?php echo $this->cdnurl; ?>/images/sponsors/video1.jpg"></div>
                  
                  <div class="featured-video-text">Josten is committed to supporting your school's mission by encouraging underclassmen to make a commitment to graduation through our C2G program, recognize  all students through our Renaissance Program and inspire students and teachers to make a difference everyday with all our Educator Services.</div>
                  
                  <div class="padding-10pixels"><img width="230" src="<?php echo $this->cdnurl; ?>/images/sponsors/video3.jpg"></div>
                  
                  <div class="featured-video-text">Josten is committed to supporting your school's mission by encouraging underclassmen to make a commitment to graduation through our C2G program, recognize  all students through our Renaissance Program and inspire students and teachers to make a difference everyday with all our Educator Services.</div>
                  </div>
                  
                  
                  
                  
                   <?php } ?> 
				 <?php  if($userid==Yii::app()->session['login']['id']){ ?>   
                     
                  <div class="tracking-you left"> 
                 <?php	$this->renderPartial('/tracking/_yourtracking',array('findalltiles'=>$trackingyoudet['findalltiles']
								,'type'=>$trackingyoudet['type']
								,'imtracking'=>$trackingyoudet['imtracking']
								,'userid'=>$userid
								,'tileid'=>$trackingyoudet['tileid']
								,'share'=>$share
								));
				?>   
                </div>
                 <?php }?>
                </div><?php */?>
				
				<div class="profile-left-panel">
                    <div class="groups-menu">
                    	<ul>						
                        	<li class="group-home"><?php if(isset($groupinfo) && !empty($groupinfo)){?>
                        	<p class="group-name" onclick="closefrommenu('main');"  style="cursor:pointer" ><?php echo ucfirst($groupinfo->group_name); } ?> </p>
                            
                            <p class="font-12px">
							<?php if($userid != Yii::app()->session['login']['id'] || $share=="share") { ?>
     <span ><a class="orange-link font-16px gropfollowing" href="javascript:void(0);" <?php if($share_value ==0){?> onclick="follow_group(<?php echo $userid;?>,<?php echo $groupinfo->group_id;?>);"<?php }?>><?php echo $results;?></a> </span>| <?php if($share_value==0){?> <span class="followgroup" ></span> <?php }else{?> <span>Follow Group</span><?php }?>   
                  <?php } else { ?>                   
                  <span ><a href="javascript:void(0)" class="white-link font-12px" onclick="return creategroup('<?php echo $_GET['groupid'];?>','1');">Edit Group</a>  </span>| <a class="white-link font-12px" href="javascript:void(0)" onclick="return delete_group(<?php echo $_GET['groupid'];?>);"> Delete Group </a>
                  
                  
                   <?php }?>
							</p>
						
                            <?php if(!empty($finaocount)){?>
							<li class="group-finaos" onclick="return displayalldata(<?php echo $userid;?>,<?php echo $isgroup?>,1,'finaos','finaoscount');"> FINAOs <?php echo "(".$finaocount.")";?>  </li><?php }else{?>        
							<?php if($userid != Yii::app()->session['login']['id']){?>  <li class="group-finaos" >FINAOs <?php  echo "(".$finaocount.")";}else if((isset($share) && $share=="share")){?>FINAOs <?php echo "(".$finaocount.")";?></li>
							<?php } else {?>
									 <li class="group-finaos" onclick="createfinao(<?php echo  Yii::app()->session['login']['id']?>,<?=$isgroup?>);" >Create FINAO</li>		   		 
							<?php } }?>		
							
							 <?php if(!empty($imgcount)){?>
									<li onclick="return displayalldata(<?php echo $userid;?>,<?php echo $isgroup?>,1,'images','imagescount');" class="group-photos" id="imagescount">PHOTOS <?php echo "(".$imgcount.")";?> </li>
								<?php }else{?>
								<li class="group-photos">PHOTOS <?php echo "(".$imgcount.")";?></li>								
								<?php }?>

                           <?php if(!empty($videocount)){?> <li onclick="displayalldata(<?php echo $userid;?>,<?php echo $isgroup?>,1,'videos','videoscount');" class="group-videos">Videos <?php echo "(".$videocount.")";?>  </li>
						    <?php }else{?>
								<li class="group-videos">VIDEOS <?php echo "(".$videocount.")";?></li>
							<?php }?>
							
							<?php if(!empty($memcount)){?>
								<li  class="group-members" onclick="displayalldata(<?php echo $userid;?>,<?php echo $isgroup?>,1,'members','memberscount');" id="memberscount">MEMBERS <?php echo "(".$memcount.")";?> </li>
							<?php }else{?>
							<li  class="group-members" >MEMBERS <?php echo "(".$memcount.")";?></li>
							<?php }?>
                        </ul>
                    </div>
                    
                    <div class="group-story-wrapper">
                		<div class="font-16px orange padding-5pixels">Group Story</div>
                        <div style="line-height:20px;" class="font-13px padding-5pixels"><?php echo $groupinfo->group_description;?>  <a class="orange-link1 font-13px" href="#story" id="my-story">Readmore</a></div>
               	 	</div>
					
					<?php if($userid == Yii::app()->session['login']['id'] && $share != "share"){ ?>
					<?php /*?><div class="user-profile">
                    	<div style="width:100%;" class="orange font-18px padding-10pixels left">
                        	<span class="left">Invite Members</span>
                        </div>
                                             
						<span id="mail_invite">
						 <div class="padding-5pixels"><!--<a class="orange-link" href="#">Search People</a> |--> <a class="orange-link" href="javascript:void(0);" onclick="invites(1);">Email</a> | <a onclick="invites(2);" class="white-link" href="javascript:void(0);">Facebook</a></div>
							<input type="hidden" id="userid" value="<?php echo $userid;?>"/>
					<input type="hidden" id="fbid" value="<?php echo Yii::app()->session['login']['socialnetworkid'];?>" />
                        <div class="padding-5pixels"><input type="text" style="width:96%;" id="memail" placeholder="Enter Mail ids seperated by Commas or Semi colon" title="Enter Mail ids seperated by Commas or Semi colon" class="txtbox"></div>
                        <div class="padding-5pixels"><input type="button" value="Invite" class="orange-button" onclick="return checkEmails('<?php echo $_GET['groupid'];?>');"> <input type="button" value="Reset" class="orange-button" onclick="document.getElementById('memail').value='';"></div>
						<div id="sucmsg" style="color:#FFFFFF"></div>
						</span>
						
						<div id="facebook_invite" style="display:none">
						 <div class="padding-5pixels"><!--<a class="orange-link" href="#">Search People</a> |--> <a class="white-link" href="javascript:void(0);" onclick="invites(1);">Email</a> | <a onclick="invites(2);" class="orange-link" href="javascript:void(0);">Facebook</a></div>
						<a onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/inviteFBfriends.png" width="200" /></a>
					</div>
						
                    </div><?php */?>
					<div class="archives">
						<ul class="topnav">
								<li><a href="javascript:void(0);">Archived FINAOs</a>
									<ul>
										<div  id="archives">
											<?php $this->renderPartial('_allgroupfinaos',array('finaos'=>$archivefinao['finaos'],'Iscompleted'=>"completed")); ?>
										</div>
									</ul>
								</li>
						</ul>
					</div>
					<?php  }?>
					<?php if(count($othergroups) > 1){?> 
					<div class="follow-groups-container">
                        <div class="follow-groups-hdline orange">Other Groups</div>
                        <div class="contentHolder-other-groups ps-container" id="Default6">
                            <ul class="follow-group-list">
                               <?php if(!empty($othergroups)): ?> 
                                <?php foreach($othergroups as $othergroup): 
								if($othergroup->group_id == $isgroup)
								continue;
								?>
                              
                                <li>
                                   <?php  if($othergroup->updatedby ==Yii::app()->session['login']['id']){ ?>
                                     <a class="white-link" href="<?php echo Yii::app()->createUrl('group/dashboard',array('groupid'=>$othergroup->group_id)); ?>">
                                    <?php }else{?> 
									 <a class="white-link" href="<?php echo Yii::app()->createUrl('group/dashboard',array('groupid'=>$othergroup->group_id,'frndid'=>$othergroup->updatedby)); ?>">
									
									<?php } ?> 
                                    <span class="invite-friend-image">
                                    <?php 
									if($othergroup->profile_bg_image != '')
									{
										$src = $this->cdnurl.'/images/uploads/groupimages/coverimages/'.$othergroup->profile_bg_image;
									}
									else
									{
										$src = $this->cdnurl.'/images/no-image-small.jpg';
									} 
									?>
                                    
                                    <img width="40" height="40" src="<?=$src?>">
                                    </span>
                                    <span class="invite-friend-name">
                                        <span style="width:100%;" class="font-14px padding-3pixels left"><?=$othergroup->group_name?></span>
                                        <span><!--<a class="font-11px blue-link" href="#">Follow</a>--></span>
                                    </span>
                                    </a>
                                </li>
                                
                                <?php endforeach; ?>
                                <?php else : ?>
                                <li>
                                    <span>
                                    NO Other Groups
                                    </span>
                                </li>
                                <?php endif; ?>
                                
                            </ul>
                       <div class="ps-scrollbar-x" style="left: 0px; bottom: 3px; width: 0px;"></div><div class=" " style="top: 0px; right: 3px; height: 151px;"></div></div>
                    </div>
					
					<?php } ?>
                    
                    
					<?php  if($userid==Yii::app()->session['login']['id']){ ?>   
                     
                  <div class="tracking-you left"> 
                 <?php	$this->renderPartial('/tracking/_yourtracking',array('findalltiles'=>$trackingyoudet['findalltiles']
								,'type'=>$trackingyoudet['type']
								,'imtracking'=>$trackingyoudet['imtracking']
								,'userid'=>$userid
								,'tileid'=>$trackingyoudet['tileid']
								,'share'=>$share
								,'groupid'=>$isgroup
								));
				?>   
                </div>
                 <?php }?>
					
                </div>

                <div class="profile-middle-panel">
                    
                     
                    <div class="enter-your-finao" id="viewallfinaos">
                        <div class="font-16px padding-10pixels" style="float:left;">Group FINAOs</div>
                      <?php  if($userid==Yii::app()->session['login']['id'] && $share!="share"){ ?>
                       <div style="float:right;"> <input type="button" id="finaofeed"  class="orange-button bolder" onclick="createfinao(<?=$userid?>,<?=$isgroup?>)" value="Create a new FINAO"  /></div><?php }?>
                        <div class="contentHolder ps-container" id="Default10">
                            <?php 
							 $this->renderPartial('_allgroupfinaos',array('allfinaos'=>$groupfinaos,'userid'=>$userid,'uploaddetails'=>$finaouploaddetails));	
							
							?>
                          </div>
                    </div>
					
					<div id="singleviewfinao" class="enter-your-finao" style="display:none;" ></div>
                    
                      
                </div>
 
				
				<div class="profile-right-panel">
                    <div class="clear"></div>
                    <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>">
                    <div class="switch-to-home" >Switch to my Home Page</div></a>
					<?php if($groupinfo->updatedby == 255 ){?>
					<div class="friends-list">

                	<div class="orange font-14px padding-10pixels">Group Admin</div>
					
					 
						

                        <div class="feat-profile">

                         <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/255'); ?>"><img src="<?php echo $this->cdnurl;?>/images/patrickperez-featured.jpg" width="230" /></a>

                            <span class="view-profile"><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/255'); ?>" class="white-link font-14px">View Profile</a></span>

                        </div>

						
                    </div>
                    <?php }?> 
					<?php if($userid == Yii::app()->session['login']['id'] && $share != "share"){ ?>
					
					<!--Commneted Invite Friends In Production-->
					<?php /*?><div class="user-profile">
                    	<div style="width:100%;" class="orange font-18px padding-10pixels left">
                        	<span class="left">Invite Members</span><input type="hidden" id="emailid" value="<?php echo Yii::app()->session['login']['email'];?>"/>
                        </div>
                        
						<span id="mail_invite">
						 <div class="padding-5pixels"><!--<a class="orange-link" href="#">Search People</a> |--> <a class="orange-link" href="javascript:void(0);" onclick="invites(1);">Email</a> | <a onclick="invites(2);" class="white-link" href="javascript:void(0);">Facebook</a></div>
							<input type="hidden" id="userid" value="<?php echo $userid;?>"/>
					<input type="hidden" id="fbid" value="<?php echo Yii::app()->session['login']['socialnetworkid'];?>" />
                        <div class="padding-5pixels" id="reset_reset"><input type="text" name="mailList" style="width:96%;" id="memail"  title="Enter Mail ids seperated by space" class="txtbox">
						</div>
                        <div class="padding-5pixels"><input type="button" value="Invite" class="orange-button" onclick="return checkEmails('<?php echo $_GET['groupid'];?>');"> <input type="button" value="Reset" class="orange-button" onclick="resets();"></div>
						<div id="sucmsg" style="color:#FFFFFF"></div>
						</span>
						
						<div id="facebook_invite" style="display:none">
						 <div class="padding-5pixels"><!--<a class="orange-link" href="#">Search People</a> |--> <a class="white-link" href="javascript:void(0);" onclick="invites(1);">Email</a> | <a onclick="invites(2);" class="orange-link" href="javascript:void(0);">Facebook</a></div>
						<a onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/inviteFBfriends.png" width="200" /></a>
					</div>
						
                    </div><?php */?>
                    
                    <?php }?> 
                    
                        
                    <div class="group-announcements">
                    	<div class="orange font-16px padding-10pixels">Announcements</div>
                      <?php if($userid == Yii::app()->session['login']['id'] && $share != "share"){?>
                      <form action="<?php echo Yii::app()->createUrl("group/announcement");?>" method="post">	 
                        <div class="padding-10pixels">
                         
                         
                        <textarea placeholder="Enter Here" style="width:222px; height:50px; resize:none;" class="run-textarea" maxlength="400" id="announcement" name="announcement"></textarea></div>
                        <div class="padding-10pixels">
                         <input type="hidden" name="groupid" value="<?php echo $isgroup; ?>" />
                        <input type="submit" onclick="return validateannouncement()" class="orange-button" value="ADD"> 
                       <!-- <input type="button" value="Add" class="orange-button">--></div>
                       
                       </form>
                      <?php }?>  
                        <div class="contentHolder-announcements ps-container" id="Default5">
                            <ul class="follow-group-list">
                               <?php 
						   if(!empty($announcements)): 
						   $i = 0;
						   foreach($announcements as $anno)
						   { $i++;?>
                                <li>
                                    <div id="anno_show_<?php echo $i; ?>">
                                    <p class="font-11px grey">
                                    <?php 
$vv=explode(' ',$anno->createddate);
$v=explode('-',$vv[0]); $v1=explode(':',$vv[1]);
$mon = array("01"=>"January","02"=>"Febuary","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");?>
<?php echo $v['2']."th " . $mon[$v[1]]." ,  " . $v['0']."  -  ". $v1[0].":".$v1[1].'pm'; ?>
                                    
                                    </p>
                                    <p><?php echo $anno->announcement; ?></p>
                                    <!--<p><a class="orange-link" id="edit-anno-<?php echo $i; ?>" href="javascript:void(0)">Edit</a> <span class="font-11px">|</span> <a class="orange-link" href="<?php echo Yii::app()->createUrl('group/dashboard', array(
                                        'action' => 'delete',
                                        'anno_id' => $anno->anno_id
                                    )) ?>">Delete</a></p>-->
                                    </div>
                                    
                                    
                                    <div style="display:none;" id="anno_hide_<?php echo $i; ?>">
                                    <div class="padding-10pixels"><textarea style="width:205px; height:50px; resize:none;" class="run-textarea">Lakewood High School Football ahfka kjahf askdfh</textarea></div>
                                    
                                    <div class="padding-10pixels"><input type="button" value="Save" class="orange-button"> <input type="button" value="Cancel" class="orange-button"></div>
                                    </div>
                                    
                                    
                                </li>
                                <script type="text/javascript">
								  $('#edit-anno-<?php echo $i; ?>').click(function(){
															 alert('clicked');
																				   });
                                </script>
                            <?php } ?>
                            <?php else: ?>
                            <li>
                                    <p>NO Announcements</p>
                                     
                                </li>
                            <?php endif; ?>
                                
                            </ul>
                       <div class="ps-scrollbar-x" style="left: 0px; bottom: 3px; width: 0px;">
                       </div><div class="" style="top: 0px; right: 3px; height: 119px;"></div></div>
                    </div>
                    
                    <div style="clear:both;"></div>
                    <div class="user-profile" style="min-height:300px!important;">
                    
                       <?php if($userid == Yii::app()->session['login']['id'] && $share != "share"){ ?>
                        <div style="width:100%; float:left;">
                      <div class="font-14px padding-10pixels orange left">Upload Video</div>
                         <div class="right"><a href="javascript:void(0)" onclick="addadminvideo();" class="orange-link font-12px">+ Add Video</a></div>
                        </div>
                        <?php }?>
                  <div id="videoform" style="margin-top:10px;"> </div>
                         
                     
                   <div id="videoview" style="margin-top:10px;">
                   
				<?php 
				$video = Uploaddetails::model()->findByAttributes(array(
                'upload_sourcetype' => 64
                ,'upload_sourceid'=>$isgroup
				 
                )); ?>
                <div class="padding-10pixels">
				<?php if($video->video_embedurl !='')
				{
					echo $video->video_embedurl;
				}else if($video->videoid !=''){?> 
				<iframe id="viddler-<?php echo $video->videoid; ?>" src="//www.viddler.com/embed/<?php echo $video->videoid; ?>/?f=1&autoplay=0&player=mini&secret=70441634&loop=0&nologo=0&hd=0&wmode=transparent" width="230" height="160" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
				<?php }else{?> 
				<iframe id="viddler-bb13af7" src="//www.viddler.com/embed/bb13af7/?f=1&autoplay=0&player=mini&secret=70441634&loop=0&nologo=0&hd=0&wmode=transparent" width="230" height="160" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
				<?php }
                ?>  
                    </div>
                    
                    <?php if($video->upload_text !=''){?> 
				  <div class="featured-video-text"><?php echo $video->upload_text ?> </div>
                    </div>
				  
				  <?php } ?> 
                    
                    
                   
                   
                    </div>
					
                    
                     
                    
                </div>
				
				
            </div>
        </div>
    </div>
    
    

<script type="text/javascript">
function resets()
{
	$('#reset_reset').html('<input type="text" name="mailList" style="width:96%;" id="memail"  title="Enter Mail ids seperated by space" class="txtbox">');//$('#memail').val();
	$('#memail').multiEmail({
			placeholder: 'Enter Email Ids',
			fieldCss: {
				width: '225px'
			},
			max: 10
		});
}
$( document ).ready( function(){
	fbfriednslist();
	<?php if(isset($getusertileid) && $getusertileid != ""){?>
	putseltile(<?php echo $getusertileid;?>);
	getdetailtile(<?php echo $userid;?>,<?php echo $tileid;?>)
	<?php }?>
	<?php if(isset($tileimageerror) && $tileimageerror =="Tileimageerror"){?>
		putseltile(<?php echo $getusertileid;?>);
	<?php if(!isset($newtile) && $newtile != "yes"){?>
	getdetailtile(<?php echo $userid;?>,<?php echo $tileid;?>)
	<?php }?>
	alert("Minimum of 440 x 320 pixels is a must!!");
	<?php }?>
});



/*********************---- functions for embeding videos ----*************************/

function enableSavebtn()
{
	if($("#txtVidembedUrlf").val() != "Add Video URL" && $("#tileinfo").val() != "")
	{
		$("#btnemburl").show();
	}
}

function savevideoembUrl(userid,groupid,finaoid,sourcetype,journalid,txtid,txtdescid,sourcpage,errorid)
{
	var upload = "Video";
	var emburl = $("#"+txtid).val();
	var embdescr = $("#"+txtdescid).val();
	var tileid=0;
	var tilename = "";
	var ismember = document.getElementById('ismember').value;
	if(!allowonlyYoutube(txtid,errorid,sourcpage))
		return false;
	
	if(sourcpage != 'videopage' && finaoid == 0)
	{
		tileid = $("#tileinfo").val();
		tilename = $("#tileinfo option:selected").text();
	}
	var journaltxt = $('#getjournalmsg').val();
//	alert(journaltxt);return false;
	var url='<?php echo Yii::app()->createUrl("/finao/GetVideodetail"); ?>';
	$.post(url, {userid:userid, finaoid : finaoid, upload : upload , sourcetype:sourcetype, journalid: journalid , emburl: emburl, embdescr:embdescr, tileid : tileid , tilename:tilename,journaltxt:journaltxt,groupid:groupid,ismember:ismember},
		function(data){
	  		// alert(data);  
			if(data)
			{
				var split = data.split('-');
				var finaoid = split[0];
				var titleid = split[1];
				document.getElementById("youtubevideoform").reset();
				 refreshmenucount(userid);
				 getheroupdate();
				 getthatfinao(finaoid);
				 view_single_finao(userid,finaoid);
			}
		});	
}



function validYT(url) {
  //var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
  var p = /(?:http:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;
  return (url.match(p)) ? RegExp.$1 : false;
}

function allowonlyYoutube(id,errorid,sourcpage)
{
	if($("#"+id).val() != "Add Video URL" && $("#"+id).val() != "")
	{
		if(!validYT($("#"+id).val()))
		{
			if(sourcpage == 'videopage')
				$("#"+id).addClass("txtbox-caption-error").removeClass("txtbox-caption");
			else
				$("#"+id).addClass("txtbox-error").removeClass("txtbox");
				
			$("#"+errorid).html("Please enter valide youtube url only!!");	
			$("#"+id).focus();
			return false;
		}
		else
			return true;
	}
}

/*********************---- End of functions for embeding videos ----*************************/

function redirect()
{
	location.href = "<?php echo Yii::app()->createUrl('profile/Newfinao/dashboard/yes'); ?>";
}

function rfreshwindow()

{

	location.href = "<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>";

}

function savetagnotes(notestext,noteid)
{
	notestextval = $("#"+notestext).val();
	var url='<?php echo Yii::app()->createUrl("/finao/EditNotes"); ?>';
	$.post(url, { notestext : notestextval, noteid : noteid   },
		function(data){
	  		if(data)
			{
				$("#spntag-"+noteid).html(data);
				showdefaulttag(noteid);
			}
	});
}

function showdefaulttag(noteid)
{
	//alert("#edittag-"+noteid);
	$("#edittag-"+noteid).hide(); 
	$("#spntag-"+noteid).show();
}

function fbfriednslist()

{

	var userid = document.getElementById('userid').value;

	var url='<?php echo Yii::app()->createUrl("/finao/fbfriendlist"); ?>';

	$.post(url, { userid : userid },

		function(data){

	  		if(data)

			{

				$("#friends").html(data);

			}

		});

}



function userprofile()

{

	var userid = document.getElementById('userid').value;

	//alert(userid);

	var url='<?php echo Yii::app()->createUrl("/profile/userprofile"); ?>';

	$.post(url, { userid : userid },

		function(data){

	  			//alert(data);

			if(data)

			{

				$("#userprofile").html(data);

			}

		});

}

function allfinaos()

{

	var userid = document.getElementById('userid').value;
	var share = document.getElementById('isshare').value;
	var url='<?php echo Yii::app()->createUrl("/finao/finaosInfo"); ?>';

	$.post(url, { userid : userid , share : share},

		function(data){

	  			//alert(data);

			if(data)

			{

				$("#allfinaos").html(data);

			}

		});

}



function myheroes()

{

	var userid = document.getElementById('userid').value;
	var share = document.getElementById('isshare').value;
	
	var url='<?php echo Yii::app()->createUrl("/finao/getmyheroes"); ?>';

	$.post(url, { userid : userid , share : share},

		function(data){

	  			//alert(data);

			if(data)

			{
				$("#yourtracking").show();
				$("#yourtracking").html(data);

			}

		});

}



function yourtracking(type,tileid)
{
	var userid = document.getElementById('userid').value;
	var share = document.getElementById('isshare').value;
	//alert(type);
	var url='<?php echo Yii::app()->createUrl("/tracking/yourTracking"); ?>';
	$.post(url, { userid : userid ,type : type, tileid:tileid , share : share},
		function(data){
			if(data)
			{
				if(type == "trackingyou")
				{
					if(data!="")
					{
						$("#trackingyou").show();
						$("#trackingyou").html(data);	
					}
				}
				else if(type == "yourtracking")
				{
					$("#yourtracking").show();
					$("#yourtracking").html(data);
				}
			}

		});
}





function archives()

{

	var userid = document.getElementById('userid').value;

	var completed = "completed";

	var url='<?php echo Yii::app()->createUrl("/finao/finaosInfo"); ?>';

	$.post(url, { userid : userid , completed : completed},

		function(data){

	  			//alert(data);

			if(data)

			{

				$("#archives").show();

				$("#archives").html(data);

			}

		});

}

function enterfinao()

{

	var userid = document.getElementById('userid').value;

	var url='<?php echo Yii::app()->createUrl("/finao/newfinao"); ?>';

	$.post(url, { userid : userid },

		function(data){

	  			//alert(data);

			if(data)

			{

				$("#enterfinao").html(data);

			}

		});

}



function finduser(id)

{

	var tiledata = id;

	var url='<?php echo Yii::app()->createUrl("/tracking/tiletracking"); ?>';

 	$.post(url,{tiledata : tiledata},

   		function(data){

   			//alert(data);

				$("#finaoform").hide();

				$("#finaodiv").hide();

				$("#searchdiv").hide();

				$("#journaldiv").hide();

				$("#searchshowdiv").html(data);

				$("#searchshowdiv").show();

				document.getElementById('backbutton').style.display = "block";

     });

		

}



 function gettileid(id,did,inc)
{

 //var userid  = $('#loggeduserid').attr(value);
 tileid = id;

 frndid = did;
 

 var url='<?php echo Yii::app()->createUrl("/tracking/saveTracktiles"); ?>';

 	$.post(url, { tileid :  tileid , frndid : frndid,inc:inc},

   		function(data){

				$("#track"+inc).html(data);
				//refreshwidget(<?php echo Yii::app()->session['login']['id']; ?>)

		});

}

function getuntracktileid(tileid,frndid,inc)

{

 	

	var url='<?php echo Yii::app()->createUrl("/tracking/deleteTracktiles"); ?>';

 	$.post(url, { tileid :  tileid , frndid : frndid ,inc:inc},

   		function(data){

				$("#track"+inc).html(data);

		});

}

function getnewfinao(userid , type)

{

	//alert(userid);

	var url='<?php echo Yii::app()->createUrl("/finao/renderAddFinao"); ?>';

 	$.post(url, { userid :  userid , type : type},

   		function(data){

   			//alert(data);

			if(data)

			{

				hidealldivs();

				$("#addfinaobtn").hide();

				$("#motivationmesg").hide();//Added on 14032013

				$("#finaodiv").show();

				$("#finaoform").hide();


				$("#newfinaoform").show();

				$("#newfinaoform").html(data);

			}

			

     });

}

function updatefinao(finaoid,statusid,userid,page,tileid)
{
    var groupid = document.getElementById('groupid').value;
	var url='<?php echo Yii::app()->createUrl("/finao/updateFinao"); ?>';

	//alert(statusid);

 	$.post(url, { userid :  userid , finaoid : finaoid , statusid:statusid, page:page,groupid:groupid},

   		function(data){

   			 

			if(data)

			{
 

				if(page=="allfinaos")

				{

					getfinaos(userid, tileid);

				}

				else if(page=="singlefinao")

				{

					$("#alljournal-singlefinao-"+finaoid).html(data);

					$("#newjournal-singlefinao-"+finaoid).html(data);

					$("#newimage-singlefinao-"+finaoid).html(data);

				}

			}

			

     });

}

function addimages(userid,groupid,finaoid,type,uploadtype,journalid)
{
	
	var ismember = document.getElementById('ismember').value;
	var journalmessage = $('#journalmsg').val();
	$("textarea#getjournalmsg").attr("value", journalmessage);
	var menuselected = $(".active-category").attr("rel");
	// Added on 28-03-2013 for back to finaos link
	var pageid = document.getElementById('finaopageid');
	if(pageid != null)
	{
	    pageid = document.getElementById('finaopageid').value;
	}
	else
		pageid = "";
	// Ended here

	//alert(type);

	var url='<?php echo Yii::app()->createUrl("/finao/getAddImages"); ?>';
 	$.post(url, { userid :  userid , finaoid : finaoid , type:type, uploadtype:uploadtype,journalid: journalid , pageid : pageid, menuselected:menuselected,journalmessage:journalmessage,groupid:groupid,ismember:ismember},
   		function(data){
   			  //alert(data);
			if(data)
			{
				/*if(type == "finao")
					$("#journaldiv").hide();
				if(type == "journal")
					$("#journaldiv").hide();
				$("#finaoform").hide();
				$("#finaodiv").show();*/
				
				$("#hideimgvideo").hide();
				$("#imgvidupload").html(data);
				$("#imgvidupload").show();
				 
				//if(uploadtype == "Video")
					//refreshmenucount(userid) 
			}
    });

}



function deleteimag(fileurl,fileid,sourceid,userid,sourcetype)
{

	var url='<?php echo Yii::app()->createUrl("/finao/deleteImages"); ?>';
 	$.post(url, { fileurl :  fileurl , fileid : fileid , sourceid : sourceid , userid:userid , sourcetype:sourcetype},
   		function(data){
   			//alert(data);
			if(data)
			{
				if(data != "nodata")
				{
					refreshmenucount(userid);
					$("#manageImg").html(data);	
					if(sourcetype == 'journal')
					{
						if($("#nodata").length)
						{	
							if($("#uploadimgvid").length)
								$("#uploadimgvid").show();
						}	
					}
				}
			}
     });

}



function refreshvideo(videoid,fileid,sourceid,userid)

{

	var url='<?php echo Yii::app()->createUrl("/finao/getVediostatus"); ?>';

 	$.post(url, { videoid :  videoid , fileid : fileid , sourceid : sourceid , userid:userid },

   		function(data){
   			 
			if(data)
			{
				if(data != "")
				{
					$("#manageImg").html(data);
					refreshmenucount(userid);
				}
				
			}
    });

}



function deletevideo(videoid,fileid,sourceid)

{

	var url='<?php echo Yii::app()->createUrl("/finao/deleteVedio"); ?>';

 	$.post(url, { videoid :  videoid , fileid : fileid , sourceid : sourceid , userid:userid },

   		function(data){

   			//alert(data);

			if(data)

			{
				refreshmenucount(userid);
				$("#manageImg").html(data);

			}

			

     });

}



function getnewjournal(userid,finaoid)

{

	var url='<?php echo Yii::app()->createUrl("/finao/getNewJournal"); ?>';

 	$.post(url, { userid :  userid , finaoid : finaoid},

   		function(data){

   			 

			if(data)

			{

				$("#finaoform").hide();

				$("#finaodiv").hide();

				$("#journaldiv").html(data);

				$("#journaldiv").show();

				

			}

			

     });

}

function hidejournal()

{

	document.getElementById('journalentry').style.display = "none";

	 

}

 

function updatefinaopublic(finaoid,userid,type,tileid)

{

    var groupid = document.getElementById('groupid').value;
	var flag = "";

	if(type=="public")

	{


		var ispublic = document.getElementById('ispublic-'+finaoid);

		if (ispublic.checked){

	       ispublic = 1;

	    }else{

	       ispublic = 0;

	    }

		flag = "true";

	}

	else if(type=="complete")

	{

		var ispublic = document.getElementById('complete-'+finaoid);

		 

		var r=confirm("Are you sure you want to archive this FINAO? ")

		if (r==true)

		  {

		 	flag = "true";

		  }

		else

		  {

		 flag = "false";

		 document.getElementById('complete-'+finaoid).checked = false;

		  }

	       ispublic = 1;
 

	}

	if(flag=="true")

	{

		var url='<?php echo Yii::app()->createUrl("/finao/updateFinaoPublic"); ?>';

	 	$.post(url, { finaoid : finaoid, userid : userid, ispublic : ispublic, type:type,groupid:groupid},

	   		function(data){ 
			   if(data == 'getfinaos')
				 {
					 //getfinaos(userid,finaoid);
					 view_single_finao(userid,finaoid);
				 }else
				 {
					 location.href = "<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>";	
				 }
			});

	}

}


 


function cancelfinao(userid)

{

	getmessages();

}

function getmessages()

{

	//$("#finaomesg").trigger("click");

	var userid = document.getElementById('userid').value;

/*	var tile = document.getElementByClassName('details-holder show-details-active');

	var id=$(tile).attr("id");

    alert(id);*/



	var url='<?php echo Yii::app()->createUrl("/finao/getFinaoMessages"); ?>';

	$.post(url, { userid : userid},

   		function(data){

   			//alert(data);

			if(data)

			{	

				$("#finaoform").show();

				$("#finaodiv").show();

				$("#journaldiv").hide();

				$("#newfinaoform").hide();

				$("#finaomesgsdisplay").html(data);

				//$("#tilesid").html(data);

			}

			

    

     });

}

function gettiles()

{

	//alert("hiii");

	//$("#tiles").trigger("click");

	var userid = document.getElementById('userid').value;

	//alert(userid);

	var url='<?php echo Yii::app()->createUrl("/finao/getAllTiles"); ?>';

	$.post(url, { userid : userid},

   		function(data){

   			//alert(data);

			if(data)

			{

				$("#tilesid").html(data);

			}

			

    

     });

	 //$("#tiles").trigger("click");

}

function getfinaosstatus(finaoid)

{

	//$("#singlefinaoupdate").reload();

}

function getfinaos(userid, tileid)
{
 
	
	var groupid = document.getElementById('groupid').value;
	var ismember = document.getElementById('ismember').value;
	$("#selectedtile").val(tileid);
	$('#divtileslide li').removeClass();

	$("#photoslide").hide();

	$("#divshowtiles").hide();

	var completed = document.getElementById('iscompleted');

	if(completed!=null)

		completed.value = "";
	var finaomesg = document.getElementById('finaomesg');

	if(finaomesg != null)

	{

		document.getElementById('finaomesg').value = "What's Your FINAO?";

		//refreshwidget(userid);

	}

	var finao = document.getElementById('finaoid');
	if(finao != null && finao.value != "")
	{
		finaoid = finao.value;
	}	
	else
		finaoid = "";
	var share = document.getElementById('isshare').value;

	var update = document.getElementById('isheroupdate');
		if(update != null && update.value != "")
		{
			heroupdate = update.value;
			document.getElementById('isheroupdate').value = "";
		}
			
		else
			heroupdate = "";
 
	//document.writeln("userid="+ userid + "?tileid="+ tileid + "?share= "+ share + "?heroupdate="+heroupdate + "?finaoid ="+ finaoid);
	var usertileid = document.getElementById('usertileid').value;
	var url='<?php echo Yii::app()->createUrl("/finao/getFinaoMessages"); ?>';

	$.post(url, { userid : userid , tileid : tileid , share : share ,heroupdate:heroupdate , finaoid : finaoid  , usertileid : usertileid,groupid:groupid,ismember:ismember},

   		function(data){

   			 //alert(data);

			
			if(data)

			{

				getheroupdate();
				hidealldivs();
				

				$("#closefinaodiv").show();

				

				if(share != "share")

				{

					//$("#divfinaowidget").show();

				}

				else

				{

					$("#divfinaowidget").hide();

				}

				$("#addfinaobtn").show();

				$("#finaoform").show();

				$("#finaodiv").show();

				$("#newfinaoform").hide();

				getTrackStatus(userid,tileid,0);

				
                $('.fixed-image-slider').css({'height':'70'});
				$('#hidecover').hide();
	 
				//refreshmenucount(userid);
				 
				 getthatfinao(finaoid);
				$("#finaomesgsdisplay").html(data);
				 
				 

					

				videocnt = 0;

				videocnt = $("#totVidcount").val();

				$("#spncntVid").html("");

				$("#spncntVid").html((videocnt > 0) ? "("+videocnt+")" : "");

				

				imgcnt = 0;

				imgcnt = $("#totImgcount").val();

				$("#spncntImg").html("");

				$("#spncntImg").html((imgcnt > 0) ? "("+imgcnt+")" : "");

				

				 

				if(videocnt > 0)

				{

					$("#showVideos a").attr('onclick','getDetails("Video",'+userid+',0,"tilepage")');	
					$("#showVideos a").addClass('photos-videos').removeClass('no-photo-video');	
				}

				else 

				{

					$("#showVideos a").attr('onclick','return false;');	
					$("#showVideos a").addClass('no-photo-video').removeClass('photos-videos');	
					
				}

				

				if(imgcnt > 0)

				{
					$("#showImages a").attr('onclick','getDetails("Image",'+userid+',0,"tilepage")');
					$("#showImages a").addClass('photos-videos').removeClass('no-photo-video');		
				}

				else

				{

					$("#showImages a").attr('onclick','return false');	
					$("#showImages a").addClass('no-photo-video').removeClass('photos-videos');	
				}

				
 
					

				if($("#frndtileid").length)

					$("#frndtileid").val(tileid);

				if($("#userfrndid").length)

					$("#userfrndid").val(tileid);	

			 
				allfinaos();

			}

			

    

     });


	    
	  view_single_finao(userid,finaoid);

} 
/*function load_finao(finaoid)
{
	$('#load_finao_id').val(finaoid);
}*/

function  view_single_finao(userid,finaoid)
{ 
	var groupid = document.getElementById('groupid').value;
	$('#viewallfinaos').hide();$('#singleviewfinao').show();
	var ismember = document.getElementById('ismember').value;
	$('#singleviewfinao').html('Loading Finao Activities <img src="<?php echo $this->cdnurl; ?>/images/dot.gif" />');
	//else if(finaoid=='0') var finaoid=$('#next_finao').val();
	var share = document.getElementById('isshare').value;
	setTimeout(function (){var finaoid=$('#next_finao').val();	var url='<?php echo Yii::app()->createUrl("/finao/viewSingleFinao"); ?>';$.post(url, { userid : userid , finaoid :finaoid,share:share,ismember:ismember,groupid:groupid},function(data){
		
	$('#singleviewfinao').show();
	$('#singleviewfinao').html(data);});},3000);	
	
}





function changeIcon(id,uploadtype)

{

	if(uploadtype == 'Image')

	{

		$("#"+id+" img").attr('src','<?php echo $this->cdnurl; ?>/images/photos-deselect.png');

	}

	else

	{

		$("#"+id+" img").attr('src','<?php echo $this->cdnurl; ?>/images/photos-videos.png');

	}

}



function showeditfinaomesg(finaoid)
{
	document.getElementById('finaomesg-'+finaoid).style.display = "none";
	document.getElementById('editfinaomesg-'+finaoid).style.display = "block";
	$('#hideimgvideo').hide();
	$('#imgvidupload').hide();
	//document.getElementById('editfinaoicon-'+finaoid).style.display = "none";
}

function savefinaomesg(userid,finaoid)
{
	var finaomesg = document.getElementById('newmesg-'+finaoid).value;
	var url='<?php echo Yii::app()->createUrl("/finao/updateFinao"); ?>';
 	$.post(url, { userid :  userid , finaoid : finaoid , finaomesg : finaomesg},
   		function(data){
			if(data)
			{
				$('#hideimgvideo').show();
				document.getElementById('editfinaomesg-'+finaoid).style.display = "none";
				document.getElementById('finaomesg-'+finaoid).style.display = "block";
				$("#finaomesg-"+finaoid).html(data);

			}

			

     });

	 

}
<!--getthatfinao(1451);getfinaos(20,9)-->
function closefunction(fieldid,e,type,par1,par2)

{

	var keycode = e;
	/** disabling ctrl button **/
	
	if(e.which == 17)
		ctlbtn = true;
		
	if(typeof ctlbtn !== 'undefined')
	{
		if(ctlbtn && e.which == 86)
		{
			return 'false';
		}	
	}
			
	if($("#"+fieldid.id).val().length > 100 )
	{
		//txtval = $("#"+fieldid.id).val().substring(100);
		//$("#"+fieldid.id).val(txtval); 
		//$("#"+fieldid.id).focus();
		if(e.which == 8 || e.which == 46)
			return 'true';
		return 'false';
	}	
	

	
	
	if (window.event) keycode = window.event.keyCode;

	else if (e) keycode = e.which;

	else return true;

	

	if (keycode == 27 || keycode == 0)

	{

		//alert("cancel"); onkeypress is not working in chrome instead onkeydown is working

		if(type=="finao")

			closefinao(par1,par2);

		else if(type=="journal")

			closejournal(par1,par2);

		return false;

	}

	/*else if (keycode == 13 )

	{

		if(type=="finao")

			savefinaomesg(par1,par2);

		else if(type=="journal")	

			savejournalmesg(par1,par2);

		return false;

	}*/

	else

		return true;

}

function closefinao(userid,finaoid)

{

	document.getElementById('finaomesg-'+finaoid).style.display = "block";

	document.getElementById('editfinaomesg-'+finaoid).style.display = "none";
	$('#hideimgvideo').show();

	// document.getElementById('editfinaoicon-'+finaoid).style.display = "";

}

function showeditjournal(journalid)
{
	document.getElementById('journalmesg-'+journalid).style.display = "none";
	document.getElementById('editjournal-'+journalid).style.display = "block";
	document.getElementById('editicon-'+journalid).style.display = "none";
}

/*function savejournalmesg(userid,journalid)

{

	var journalmesg = document.getElementById('newjournalmesg-'+journalid).value;

	var url='<?php echo Yii::app()->createUrl("/finao/updateJournal"); ?>';

 	$.post(url, { userid :  userid , journalid : journalid , journalmesg : journalmesg},

   		function(data){

   			//alert(data);

			if(data)

			{

				document.getElementById('editjournal-'+journalid).style.display = "none";

				document.getElementById('journalmesg-'+journalid).style.display = "block";

				$("#journalmesg-"+journalid).html(data);

			}

			

     });

}

function closejournal(userid,journalid)

{

	document.getElementById('journalmesg-'+journalid).style.display = "block";

	document.getElementById('editjournal-'+journalid).style.display = "none";

}*/

function savejournalmesg(userid,journalid)

{

	if(journalid != "")

	{

		var journalmesg = document.getElementById('newjournalmesg-'+journalid).value;

		if(journalmesg != "Enter your Journal" && journalmesg.length>1)

		{

		var url='<?php echo Yii::app()->createUrl("/finao/updateJournal"); ?>';

	 	$.post(url, { userid :  userid , journalid : journalid , journalmesg : journalmesg},

	   		function(data){

	   			//alert(data);

				if(data)

				{

					if(journalid != null)
					{
						$("#journalmesg-"+journalid).html(data);
						closejournal(userid,journalid);
					}
				}
	     });

		}

		else

		{

			document.getElementById('newjournalmesg-'+journalid).className = "finao-desc-error";

		}

	}

	else

	{

		//var journalmesg = document.getElementById('journaltext').value;

		//alert("jskdfjkdsf");

		submitjournal(userid);

	}

	//document.getElementById('editicon-'+journalid).style.display = "block";

	

}

function submitjournal(id)

{

	var userid = id;

	var text = document.getElementById('journaltext').value;

	var ispublic = document.getElementById('journalstatus');

		/*if (ispublic.checked){

	       ispublic = 1;

	    }else{

	       ispublic = 0;

	    }*/

	var finaoid = document.getElementById('finao_id').value;

	if(text != "Add Journal")

		{

	//alert("hiiii");

	if(text.length >= 1)

	{

		var url='<?php echo Yii::app()->createUrl("/finao/addJournal"); ?>';

	 	$.post(url, { text : text , finaoid : finaoid, userid : userid},

	   		function(data){

	   			//alert(data);

				if(data == "saved")

				{

					/*$("#journalform").hide();

					getalljournals(finaoid,userid);*/

					closejournal(userid,"");

					getalljournals(finaoid,userid,0);

				}

				else

				{

					$("#errormesg").html(data);

				}

	    

	     });

	}else

	{

		document.getElementById('journaltext').className = "finao-desc-error";

	}

	}

	else

	{

		document.getElementById('journaltext').className = "finao-desc-error";

	}

}

function closejournal(userid,journalid)
{
	if(journalid != "")
	{
		document.getElementById('journalmesg-'+journalid).removeAttribute("style");
		document.getElementById('editjournal-'+journalid).style.display = "none";
		//document.getElementById('editicon-'+journalid).removeAttribute("style");
		document.getElementById('newjournalmesg-'+journalid).className = "finaos-area";
		var journalmesg = document.getElementById('closemesg-'+journalid).value;
		document.getElementById('newjournalmesg-'+journalid).value = journalmesg;
	}
	else
	{
		document.getElementById('hidejournal').style.display = "none";
		//document.getElementById('editicon-'+journalid).style.display = "block";
	}

}

function getallfinaos(userid)

{

	getmessages();

	/*$("#finaoform").show();

	$("#newfinaoform").show();

	$("#journaldiv").show();*/

}



function showtracking()

{

	//alert("HELLO");

	hidealldivs();

	$("#journaldiv").show();

	

	

}function showsearching()

{

	//alert("HELLO");

	hidealldivs();

        $("#searchdiv").show();

}



function showusers(id)

{

		document.getElementById('trackinguser-'+id).style.display = "block";

		document.getElementById('minusimg-'+id).style.display = "block";

		document.getElementById('plusimg-'+id).style.display = "none";

}

function hideusers(id)

{

	document.getElementById('trackinguser-'+id).style.display = "none";

	document.getElementById('plusimg-'+id).style.display = "block";

	document.getElementById('minusimg-'+id).style.display = "none";

}

function showuserss(id)

{

		document.getElementById('trackinguserr-'+id).style.display = "block";

		document.getElementById('minusimgg-'+id).style.display = "block";

		document.getElementById('plusimgg-'+id).style.display = "none";

}

function hideuserss(id)

{

	document.getElementById('trackinguserr-'+id).style.display = "none";

	document.getElementById('plusimgg-'+id).style.display = "block";

	document.getElementById('minusimgg-'+id).style.display = "none";

}

/*function getTrackStatus(userid,tileid)

{

	//alert("hiiiiiiii");

	var url='<?php echo Yii::app()->createUrl("/tracking/getTrackingStatus"); ?>';

	$.post(url, { userid : userid , tileid : tileid },

   		function(data){

   			//alert(data);

			if(data)

			{

				$("#trackingstatus").html(data);
				//$("#journaltrackingstatus").html(data);
			}

			

     });

}*/

function goback()

{

				$("#finaoform").hide();

				$("#finaodiv").hide();

				$("#searchdiv").show();

				$("#journaldiv").hide();

				$("#searchshowdiv").hide();

}

function showeditcaption(uploadid)

{

	document.getElementById('showeditcaption-'+uploadid).style.display = "none";

	document.getElementById('caption-'+uploadid).style.display = "none";

	document.getElementById('hideeditcaption-'+uploadid).style.display = "block";

	document.getElementById('divhideeditcaption-'+uploadid).style.display = "block";

}

function savecaption(userid, uploadid)

{

	var caption = document.getElementById('newcaption-'+uploadid).value;

	if(caption.length >1)

	{

		var url='<?php echo Yii::app()->createUrl("/finao/updateImgCaption"); ?>';

		$.post(url, { userid : userid , uploadid : uploadid , caption: caption},

	   		function(data){

	   			//alert(data);

				if(data)

				{

					$("#caption-"+uploadid).html(data);

					closecaption(userid, uploadid);

				}

				

	     });

	}

	else

	{

		closecaption(userid, uploadid);

	}

}

function closecaption(userid, uploadid)


{

	document.getElementById('caption-'+uploadid).style.display = "block";

	document.getElementById('showeditcaption-'+uploadid).style.display = "block";

	document.getElementById('hideeditcaption-'+uploadid).style.display = "none";

	document.getElementById('divhideeditcaption-'+uploadid).style.display = "none";

}

function showjournal()

{

	document.getElementById('hidejournal').style.display = "block";

}

function statusborder()

{

	

	var statusid = 	document.getElementById('statusid').value;

	//alert(statusid);

	if(statusid=="Ahead")

	{

		$("#statusclass").addClass("border-ahead");

	}

	else if(statusid=="On Track")

	{

		$("#statusclass").addClass("border-ontrack");

	}

	else 

	{

		//alert(statusid);

		//$("#statusclass").removeClass();

		$("#statusclass").addClass("border-behind");

	}

	 

}

</script>





<script type="text/javascript">
function clickdiv(id,tilename)
{
	var checkboxid = id.split("-");
	if($("#tileid").length)
		$("#tileid").val(checkboxid[2]);
	if($("#tilename").length)
		$("#tilename").val(tilename);
	//$("#tilename").val(checkboxid[1]);
	//alert(id + tilename);
	$("#tiledisplay .holder-active").addClass("holder smooth").removeClass("holder-active");
	$("#"+id).addClass("holder-active");		
}
function removeclass()
{
	document.getElementById('finaomesg').className = "finaos-area";
}


$(document).ready(function(){
var url='<?php echo Yii::app()->createUrl("tracking/GetGroupStatus"); ?>';
	var userid=<?php echo $userid;?>;
	var tileid=<?php echo $result_tile_id;?>;
 	$.post(url, { userid : userid, tileid:tileid},
	function(data){
		if(data)
		{   
			 $(".followgroup").html(data);
		}
	});	

/*
	$('#tileid').change(function()
	{
		var tileid = $('#tileid').children("option:selected").text();

		$("#tilename").val(tileid);

	});



	$("#finaomesg").focus(function(){

		$(this).addClass("finao-strip-txtarea");
		if(this.value == "What's Your FINAO?")
		{
			this.value = "";
		}

	});



	$("#finaomesg").blur(function(){

		if(this.value == "")
		{
			this.value = "What's Your FINAO?";

			$("#divshowtiles").hide();
			cancelnewtile();
		}
		else
		{
			$("#divshowtiles").show();
			if($("#hdnfinaomessage").length)
				$("#hdnfinaomessage").val($("#finaomesg").val());
		}

	});	



	$('#finaomesg').bind('keypress', function(e) {

		var code = (e.keyCode ? e.keyCode : e.which);

		

		if(this.value.length >= 1 && this.value != "What's Your FINAO?" && $.trim(this.value) != "")

		{

			if(code == 13)

			{

				$("#divshowtiles").show();

			}

		}

		else

		{

			$("#divshowtiles").hide();
			
		}

	});

	
	$('#finaomesg').bind('keyup', function(e) {

		var code = (e.keyCode ? e.keyCode : e.which);

		if(!(this.value.length >= 1 && this.value != "What's Your FINAO?" && $.trim(this.value) != ""))
		{

			$("#divshowtiles").hide();
		}

	});

	
	

*/});

function showtileform(finaoid,userid,pagetype)
{
	//alert(pagetype);
	$("#oldtiles").hide();
	var url='<?php echo Yii::app()->createUrl("/finao/newTile"); ?>';
		$.post(url, { userid :  userid , finaoid : finaoid ,pagetype : pagetype},
	   		function(data){
	   			//alert(data);
				if(data)
				{
					if(pagetype!="newtilepage")
					{
						$("#selecttile").hide();
						$("#newtile").show();
						$("#newtile").html(data);
					}

					else

					{

						//addnewtilefinao(userid);

						//submitfinao(userid,'addanotherfinao','tilefinao','newtilepage');

						$("#finaotiles").hide();

						$("#addanotherfinao").hide();

						$("#newusertile").show();

						$("#newusertile").html(data);

					}

					

				}

				

	     });

}

function cancelnewtile()
{
	$("#oldtiles").show();
	$("#newtile").hide();
	$("#newusertile").hide();
	$("#finaotiles").show();
	$("#selecttile").show();
	$("#createtile").show();
	$("#addanotherfinao").show();
}

function addnewtilefinao(userid)
{
	$("#createtile").hide();
	showtileform(0,userid,'newtilepage');
	if($("#hdnfinaomessage").length)
		$("#hdnfinaomessage").val($("#finaomesg").val());
	/*var finaomesg = document.getElementById('finaomesg');

	

	if(finaomesg != null && (finaomesg.value != "What's Your FINAO?" ))

	{

		//showtileform(0,userid,'newtilepage');

		var url='<?php //echo Yii::app()->createUrl("/finao/newTileFinao"); ?>';

		$.post(url, { userid : userid , finaomesg : finaomesg.value },

	   		function(data){

	   			//alert(data);

				if(data)

				{

					showtileform(data,userid,'newtilepage');

				}

				

	    

	     });

	}

	*/	

}
function deletefj(type,userid,journalid,finaoid,tileid)
{
	//alert(tileid);return false;
	if(type=="finao")
	{
		journalid = finaoid;
		msg = "Sure? All items linked to this FINAO (photos, videos, and journal entries) will be deleted."
	}
	else
	{
		msg = "Sure? All items linked to this Journal entry (photos and videos) will be deleted.";
	}	
	if(confirm(msg))
	{
		var url='<?php echo Yii::app()->createUrl("/finao/deletefj"); ?>';

			$.post(url, { userid :  userid , journalid : journalid ,type : type,tileid:tileid},

		   		function(data){

		   			//alert(data);

					if(data)

					{
						if(type=="journal")
						{
							//getalljournals(finaoid,userid,0);
							//refreshwidget(userid);
							$('#single_journal'+journalid).hide();
						}
						if(type=="finao")
						{
							//alert(data);
							location.href = "<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>";
						}
					}

					

		     });
	}
}
function closeheroupdate()
{
	//alert('hi');
	hidealldivs();
	$("#allinfo").show();
	// window.scrollTo(0,document.body.scrollHeight);
	$('html, body').animate({scrollTop:$(document).height()}, 'slow');

}

function validatesubmit(fileid,errmsg,msg,ctlid,condition)
{
	if($("#"+fileid).val() == condition)
	{
		$("#"+errmsg).html(msg);
		if(ctlid != "")
		{	
			$("#"+ctlid).removeClass("txtbox-caption");
			$("#"+ctlid).addClass("txtbox-caption-error");
		}	
		return "1";
	}
	return "0";
}

function resetfile(errormsg,ctlid)
{
	$("#"+errormsg).html("");
	if(ctlid != "")
	{
		$("#"+ctlid).removeClass("txtbox-caption-error");
		$("#"+ctlid).addClass("txtbox-caption");
	}
}

function viewjournal(journalid,finaoid,userid,completed,pageid)
{
	var update = document.getElementById('isheroupdate');
	if(update != null && update.value != "")
		heroupdate = update.value;
	else
		heroupdate = "";
	var isshare = document.getElementById('isshare').value;
	var url='<?php echo Yii::app()->createUrl("/finao/ViewJournal"); ?>';

 	$.post(url, { finaoid : finaoid, userid : userid, iscompleted : completed,isshare:isshare,pageid:pageid,heroupdate:heroupdate, journalid:journalid },
   		function(data){
			if(data)
			{
				if(iscompleted=="completed")
				{
					/*hidealldivs();
					$("#showcompletedfinaodiv-profile").show();
					$("#showcompletedfinaodiv-profile").html(data);
					$("#showcompletedfinaodiv-default").show();
					$("#showcompletedfinaodiv-default").html(data);
					$("#finaodiv").hide();
					$("#journaldiv").show();
					$("#journaldiv").hide();*/
				}
				else
				{
					hidealldivs();
					$("#finaodiv").hide();
					$("#journaldiv").show();
					$("#journaldiv").html(data);
				}
			}
    });	
}

function validateSubmitJournal(txtid)
{
	if($("#"+txtid).val() == "Enter your Journal")
	{
		$("#"+txtid).addClass("run-textarea-error").removeClass("run-textarea");
		//$("#"+txtid).addClass("left");
		return 'false';
	}
}

function hideshow(id,hideorshow)
	{
		if(hideorshow == 'hide')
			$("#"+id).hide();
		else
			$("#"+id).show();	
	}
function getalltiles(userid,share)
{
	/*var url='<?php echo Yii::app()->createUrl("/finao/getalltiles"); ?>';
	$.post(url, { userid : userid , share : share},

		function(data){

	  			//alert(data);

			if(data)

			{*/
				//hidealldivs();
				$("#menuhidediv").show();
				//$("#menuhidediv").html();

			/*}

		});*/

}
function getnextprevtiles(userid,pageid)
{
	//alert(pageid);
	var share = document.getElementById('isshare').value;
	var url='<?php echo Yii::app()->createUrl("/finao/nextPrevtiles"); ?>';
	$.post(url, { userid : userid , share : share,pageid : pageid},

		function(data){

	  			//alert(data);

			if(data)

			{
				//hidealldivs();
				//$("#allinfo").show();
				$("#divdisplaydata").html("");
				$("#divdisplaydata").html(data);
				$("#divdisplaydata").show();

			}

		});
}
function putseltile(usertileid)
{
	//document.getElementById('usertileid').value = usertileid;
	if($("#usertileid").length)
		$("#usertileid").val(usertileid);
}

function displayallfinaos(userid,pageid)
{
	alert(pageid);
	var share = $("#isshare").val(); 
	/*var url='<?php echo Yii::app()->createUrl("finao/GetallFinao"); ?>';
	$.post(url, { userid : userid , share : share,pageid : pageid},
		function(data){
			if(data)
			{
				$("#menuhidediv").hide();
				$("#divdisplaydata").html(data);
				$("#divdisplaydata").show();
			}
		});*/
}


function GetAllFinaoImages(userid,sourcetype)
{
	var url='<?php echo Yii::app()->createUrl("/finao/getallfinaoimages"); ?>';
	$.post(url, { userid : userid , sourcetype : sourcetype},
	function(data){
	//alert(data);
	if(data)
	{
			$("#divdisplaydata").html("");
			$("#divdisplaydata").html(data);
			$("#divdisplaydata").show();
	}
	});

}

function getnextprevfinaoimages(userid,pageid)
{
	//alert(pageid);
	//var share = document.getElementById('isshare').value;
	var url='<?php echo Yii::app()->createUrl("/finao/nextprevfinaoimages"); ?>';
	$.post(url, { userid : userid ,pageid : pageid},

		function(data){
			if(data)
			{
				$("#menuhidediv").show();
				$("#menuhidediv").html(data);
			}

		});
}
function getdetailtile(userid,tileid)
{
	//alert("hiii");
	var groupid = document.getElementById('groupid').value;
	var share = document.getElementById('isshare').value;
	//alert(share);
	var usertileid = document.getElementById('usertileid').value;
	var url='<?php echo Yii::app()->createUrl("/finao/getDetailTile"); ?>';
	$.post(url, { userid : userid , tileid : tileid, share : share, usertileid : usertileid,groupid:groupid},
	function(data){
	//alert(data);
	if(data)
	{
		    $('.fixed-image-slider').css({'height':'430'});
		    $('#hidecover').hide();
			$("#divdisplaydata").html("");
			$("#divdisplaydata").html(data);
			$("#divdisplaydata").show();
	}
	});
}

function videogallery(userid,groupid,pageid,imageorvideo,pagetype)
{   //alert('Clicked');
	var userid = userid; 
	var pageid = pageid; 
	var imageorvideo = imageorvideo; 
	var pagetype = pagetype;
	var share ="";
	var url='<?php echo Yii::app()->createUrl("/finao/GetDetails"); ?>';
 	$.post(url, { userid : userid , share : share, pageid : pageid , imageorvideo : imageorvideo ,pagetype:pagetype,groupid:groupid },
	function(data){
		//alert(data);
		if(data)
		{   
		 
		 $("#videocontent").html(data);
			 
		}
	});
	 
}
// delete posts
function delete_posts(uploaddetail_id)
{
	if(uploaddetail_id)
	{
		msg = "Sure? All items linked to this Journal entry (photos and videos) will be deleted.";
	}	
	if(confirm(msg))
	{
		var url='<?php echo Yii::app()->createUrl("/Finao/DeletePosts"); ?>';
		$.post(url, {uploaddetail_id: uploaddetail_id });
		$('#single_journal'+uploaddetail_id).hide();
	}
}

// view finao name on popup video
function close_finao_det(a)
{
	$('#sam'+a).hide();
}
// hide finao name on popup video
function view_finao_det(a)
{
	$('#sam'+a).show();
}
function view_change_status(fr)
{
	var url='<?php echo Yii::app()->createUrl("/Tracking/Counttiles"); ?>';
	$.post(url, { type :'0', from :fr});
	$('#countdiv').html('');
}
function change_status_block(tracker_userid,status,ids)
{
   if(status == 2)
   {
		if(confirm('Are You Sure To Block This Person'))
		{
			var url='<?php echo  Yii::app()->createUrl("/Tracking/changeStatusblock"); ?>';
			$.post(url, { status :status, tracker_userid :tracker_userid});
			$('#stat_'+ids).html('Unblock');$('#stat_'+ids).attr('onClick', "change_status_block('"+tracker_userid+"','1','"+ids+"')");
			//return false;
		}
	}
	else 
	{
		if(confirm('Are You Sure To UnBlock This Person'))
		{
			var url='<?php echo  Yii::app()->createUrl("/Tracking/changeStatusblock"); ?>';
			$.post(url, { status :status, tracker_userid :tracker_userid});
			$('#stat_'+ids).html('Block');$('#stat_'+ids).attr('onClick', "change_status_block('"+tracker_userid+"','2','"+ids+"')");
		//return false;
		}
	}	
}
// deleteing jounal
function delete_journal(finao_journal_id,finao_id)
{
	var url='<?php echo  Yii::app()->createUrl("/Finao/Deletejournal"); ?>';
	$.post(url, { finao_journal_id :finao_journal_id, finao_id :finao_id});		
}

function closefrommenu(page)
{
 
	
	//alert("Calling");
	if(page=="main")
	{
		
		//alert("main");
		$('#singleviewfinao').hide();
		$('#viewallfinaos').show();
		$('#hidecover').show();
		$('.fixed-image-slider').css({'height':'70'});
		hidealldivs();
		$("#allinfo").show();
		$("#divdisplaydata").hide();
		$('.active-category').removeClass('active-category');
	
	}
	else if(page == "finao")
	{
		hidealldivs();
		$("#allinfo").show();
		$("#divdisplaydata").hide();
	}
	else
	{ 
	  
		//alert("Hello");
		$('.finao-cover-new').show();
		$('#singleviewfinao').hide();
		$('#viewallfinaos').show();
		$('#hidecover').show();
		$('.fixed-image-slider').css({'height':'70'});
		hidealldivs();
		clickvalue = $(".active-category").attr("rel");
		$("#allinfo").show();
		if(clickvalue == 'tiles')
		{
			selectetileid = $("#usertileid").val();
			if(selectetileid != "")
				getdetailtile(userid,selectetileid);
			else
				$(".active-category").trigger("click");	
		}
		else 
		{
			$(".active-category").trigger("click");
		}
	
	}
	
}
<?php 
	if(isset($_REQUEST['share']))
		{?>
			var share = "share";
		<?php }
		else
		{?> 
			var share = "no";
		<?php }?>
	
	var url='<?php echo Yii::app()->createUrl("finao/finaosInfo"); ?>';
 	$.post(url, { userid : <?php echo $userid;?>,share:share },
	function(data){
		if(data)
		{   
			 $("#totfinaos").html(data);
		}
	});	

function refreshmenucount(userid)
{
	
	 
	selectedmenu = $(".active-category").attr("rel");
	
	var groupid = document.getElementById('groupid').value;
	/*alert(userid);
	alert(groupid);*/
	//alert(groupid);
	var url='<?php echo Yii::app()->createUrl("finao/Getgroupmenucount"); ?>';
 	$.post(url, { userid : userid ,groupid:groupid},
	function(data){
		//alert(data);
		if(data)
		{   
		 $("#menustrip").html(data);
		 enablemenu(selectedmenu);
		}
	});
	
}

function enablemenu(menuselected)
{
	$("#ultopmenu a").each(function(i){
		if($(this).attr('rel') == menuselected)
		{
			$(this).attr('class','active-category');
		}
	});	
}
</script>    

<script type="text/javascript">
function follow_group(userid,groupid)
{
	var groupid = groupid;
	if(userid!='')
	{
		var url = '<?php echo Yii::app()->createUrl("tracking/tracking");?>';
		$.post(url, { userid : userid, groupid:groupid},
		function(data){if(data){ 
		//alert(data);
		refreshmenucount(userid);
		$('.gropfollowing').html(data);
		
		}});
	}	
}
function follow_groups(userid,tileid)
{ //alert('a');
	var groupid = groupid;
	if(userid!='')
	{
		var url = '<?php echo Yii::app()->createUrl("tracking/GroupSaveTracktiles");?>';
		$.post(url, { frndid : userid, tileid:tileid},
		function(data){if(data){ 
		//alert(data);
		refreshmenucount(userid);
		$('.followgroup').html(data);		
		}});
	}	
}
function unfollow_groups(userid,tileid)
{ //alert('a');
	var groupid = groupid;
	if(userid!='')
	{
		var url = '<?php echo Yii::app()->createUrl("tracking/GroupDeleteTracktiles");?>';
		$.post(url, { frndid : userid, tileid:tileid},
		function(data){if(data){ 
		//alert(data);
		refreshmenucount(userid);
		$('.followgroup').html(data);		
		}});
	}	
}

 
function delete_group(groupid)
{
	var msg = "Sure? All items linked to this Group (Finao,photos, videos, and journal entries) will be deleted.";
	//alert(groupid); return false;
	if(confirm(msg))
	{
		var url='<?php echo Yii::app()->createUrl("/Group/deletefj"); ?>';
		$.post(url, { groupid :  groupid },
		   		function(data){if(data) location.href = "<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>";	});
	}
} 
function addadminvideo()
{
	var userid = '<?php echo $userid; ?>';
	var groupid = document.getElementById('groupid').value;
	
	var url='<?php echo Yii::app()->createUrl("/finao/Getadminvideo"); ?>';
		$.post(url, { userid:userid,groupid:groupid },
		   		function(data){
					$('#videoview').hide();
					$('#videoform').html(data); 
					});
	
} 
function validateannouncement()
{
	var announcement = document.getElementById('announcement').value;
	if(announcement == '')
	{
		$('#announcement').addClass('run-textarea-error');
		return false;
	}
	else
	{
		return true;
	}
	
}
function hidealldivs()

{

	$("#allinfo").hide();

	$("#finaoform").hide();

	$("#finaodiv").hide();

	$("#searchdiv").hide();

	$("#searchshowdiv").hide();

	$("#journaldiv").hide();

	$("#divImgVid").hide();

	$("#motivationmesg").hide();

	$("#newfinaoform").hide();

	$("#followtracking").hide();

	$("#profiletracking").hide();

	$("#profiletracking").hide();

	

	$("#showcompletedfinaodiv-profile").hide();

	$("#showcompletedfinaodiv-default").hide();

	$("#divdisplaydata").hide();

}
function displayalldata(userid,groupid,pageid,displaydata,liid)
	{
	$("#ultopmenu a").removeClass("active-category");
	$("#"+liid).closest('a').attr('class',"active-category");
	
	var share = $("#isshare").val(); 
	var url = "";	var imageorvideo = "";	var pagetype = "";
	switch(displaydata)
	{
	case 'finaos':
			url='<?php echo Yii::app()->createUrl("finao/GetallFinao"); ?>';
			break;
	case 'tiles':
			url='<?php echo Yii::app()->createUrl("finao/nextPrevtiles");?>';
			break;
	case 'images':
			imageorvideo = "Image";
			pagetype = 'homethumb';
			url='<?php echo Yii::app()->createUrl("finao/GetDetails");?>';
			break;
			
	case 'videos':
			imageorvideo = "Video";
			pagetype = 'homevideo';
			url='<?php echo Yii::app()->createUrl("finao/GetDetails");?>';
			break;
	case 'follow':
			url='<?php echo Yii::app()->createUrl("finao/Getfollowingdetails");?>';
			break;
			
	case 'groups':
			imageorvideo = "Group";
			url='<?php echo Yii::app()->createUrl("Group/GetallGroup");?>';
			break;
			
	case 'members':
			imageorvideo = "Member";
			url='<?php echo Yii::app()->createUrl("Group/GetallGroupMembers");?>';
			break;				
			
			 
	}
	
	
	$.post(url, { userid : userid ,groupid:groupid, share : share, pageid : pageid , imageorvideo : imageorvideo ,pagetype:pagetype },
	function(data){
	if(data)
	{
	 //alert(data);	
	$('#hidecover').show();
	hidealldivs();
	$("#allinfo").show();
	if(groupid != '')
	{
		 getheroupdate();
	}
	
	$("#divdisplaydata").html("");
	$("#divdisplaydata").html(data);
	$("#divdisplaydata").show();
	}
	});
	var url='<?php echo Yii::app()->createUrl("/finao/FinaosInfo"); ?>';
	$.post(url, { userid : userid , share : share},
	function(data){	if(data){$("#totfinaos").html(data);}});
	
	if(displaydata=='follow')  setTimeout(function (){$('#singleviewfinao').hide();},2000); 	
	else { if(groupid !='') $('#singleviewfinao').show(); }
	
	}
	function getTrackStatus(userid,tileid,inc)
{
	 
	var url='<?php echo Yii::app()->createUrl("/tracking/getTrackingStatus"); ?>';
	$.post(url, { userid : userid , tileid : tileid ,inc:inc},
   		function(data){
   			//alert(data);
			if(data)
			{
				$("#trackingstatus").show();
				$("#trackingstatus").html(data);
				//alert("traking");
			}

			

     });

}
function getheroupdate()
{
	var update = document.getElementById('isheroupdate');
	if(update != null)
		update.value = "heroupdate";
	$("html, body").animate({ scrollTop: 0 }, "slow");
}

 </script>