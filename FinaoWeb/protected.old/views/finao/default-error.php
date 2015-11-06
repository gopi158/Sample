<link href="<?php echo $this->cdnurl;?>/javascript/scrollbar/perfect-scrollbar.css" rel="stylesheet" />
<script src="<?php echo $this->cdnurl;?>/javascript/scrollbar/jquery.mousewheel.js"></script>
<script src="<?php echo $this->cdnurl;?>/javascript/scrollbar/perfect-scrollbar.js"></script>

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
	}
?>

<script type="text/javascript">

    var finaoid = '<?php echo $selectedfinao; ?>';
    var tileid = '<?php echo $selectedtile; ?>';
	var userid = '<?php echo $userid; ?>';
    var upload = '<?php echo $upload; ?>';
	var jourlid = '<?php echo $jourlid; ?>';

	$('document').ready(function()
	{
		if(finaoid != "" && tileid != "")
		{
			hidealldivs();
		
			if(upload != "")
			{
				if(jourlid == "" || jourlid == 0) // modified on 02-04-2013
					addimages(userid,finaoid,'finao',upload,0);
				else
					addimages(userid,finaoid,'journal',upload,jourlid);	
			}else
			{
				getfinaos(userid,tileid);
			}
			
			refreshwidget(userid); // Added on 02-04-2013	
		}

		$("#newfinaofnacy").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,
		});

	});

	

</script>



<script> 

window.fbAsyncInit = function() {

	FB.init({ 

		appId:'533448090027556', // or simply set your appid hard coded

//424392384305767 this is for finao.skootweet.com
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
			method: 'apprequests', message: 'wants you to join at Finao Nation'
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
				
				/*image.onload = function() {
            		imgwidth = this.width;
					imgheight = this.height;
					
					if(!(imgwidth >= 980 && imgheight >= 350))
					{
						alert('Please upload the images of width greater than 980px and height greater than 350px!');
						return false;
					}
					else
					{
						$("#CoverimageForm").submit();
					}	
					//alert('Width:'+this.width +' Height:'+ this.height+' '+ Math.round(chosen.size/1024)+'KB');
        		};
				image.onerror = function() {
            		alert('Not a valid file type: '+ chosen.type);
        		};
        		image.src = url.createObjectURL(chosen);*/
				
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					$("#btnProfileimageForm").show();
					alert("After clicking OK \nPlease click on Upload button to crop your cover image!!!")
				}
				else
					document.CoverimageForm.submit();

		}	
});
$('#tilefile').bind('change', function() {
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
					$("#btnTileimageForm").show();
					alert("After clicking OK \nPlease click on Upload button to crop your cover image!!!")
				}
				else
					document.TileimageForm.submit();

		}	
});
});
</script>

<?php if ($Imgupload != 0) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/css/imgareaselect-default.css" />
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.imgareaselect.pack.js"></script>
<?php } ?>
<script type="text/javascript">
function getSizes(im,obj)
	{
		
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
						fileext = ($("#image_name").val()).substr(($("#image_name").val()).lastIndexOf('.')+1);
						
						$.ajax({
							type:"GET",
							url: urlvalue+"?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis+"&fileext="+fileext,
							cache:false,
							success:function(rsponse)
								{
								 	if(rsponse == "Please try again!!")
									{
										alert("Please try again!!");
										return false;
									}
									location.href = "<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>";
									/*$("#divimag").hide();
									$("#divform").show();
								    $("#profileImg").attr("src",imgurl+$("#image_name").val());*/
								}
						});
					}
			}
		else
			alert("Please select portion..!");
	}
var IsimgUpload = "<?php echo $Imgupload; ?>";

$(document).ready(function () {
    
	if($('img#imageid').length)
	{
		$('img#imageid').imgAreaSelect({
        x1: 0, y1: 0, x2: 980, y2: 350,
		//maxWidth: 980, 
		//maxHeight: 350, 
		aspectRatio: '2.8:1',
        onSelectEnd: getSizes
    	});	
	}
	
	if(IsimgUpload != 0)
	{
		$("#divactualImg").hide();
	}
		

});
</script>


<!-- /*********************** Accordian for Fav, Archive tabs **************************/ -->

<script type="text/javascript" src="<?php echo $this->cdnurl;?>/javascript/accordian/scriptbreaker-multiple-accordion-1.js"></script>

<script  language="JavaScript">

$(document).ready(function() {
	$(".topnav").accordion({
		accordion:false,
		speed: 500,
		closedSign: '+',
		openedSign: '-'
	});
});

</script>

<!-- /*********************** **************************/ -->

<div class="main-container">
	<!-- Start of Tiles widget -->
	<div id="tileswidget" style="width:100%;float:left;">
		<div class="fixed-image-slider" id="tiles-strip">
		<?php /*$this->widget('tiles',array('alltiles'=>$tilesslider['alltiles']
										,'userinfo'=>$tilesslider['userinfo']
										,'totaltilecount'=>$tilesslider['totaltilecount']
										,'widgetstyle'=>$tilesslider['widgetstyle']
										,'imgcount'=>$tilesslider['imgcount']
										,'videocount'=>$tilesslider['videocount']
										));*/
		$this->widget('TopMenu',array('userid'=>$userid,'isshare'=>$share
										,'alltiles'=>$tilesslider['totaltilecount']
										,'imgcount'=>$tilesslider['imgcount']
										,'videocount'=>$tilesslider['videocount']));
		?>
		
		<div id="menuhidediv" style="display:none;">
			<?php $this->renderPartial('_alltiles',array('alltiles'=>$tilesslider['pagetilesinfo'],'userid'=>$userid,'prev'=>$tilesslider['prev'],'next'=>$tilesslider['next'],'noofpages'=>$tilesslider['noofpages']));?>
		</div>
		</div>
	</div>

	<!-- End of Tiles widget -->
	<input type="hidden" id="iscompleted" value=""/>

	<input type="hidden" id="isshare" value="<?php echo $share;?>"/>
	<input type="hidden" id="isheroupdate" value=""/>
	<input type="hidden" id="finaoid" value=""/>
	<input type="hidden" id="loggeduserid" value="<?php if($userid==Yii::app()->session['login']['id']){echo $userid;}?>"/>
	<input type="hidden" id="userid" value="<?php echo $userid;?>"/>

	<input type="hidden" id="statusid" value=""/>

	<input type="hidden" id="selectedtile" value=""/>
	
	<div class="welcome-container" style="display:none;">

        	<span class="left" style="dsiplay:none;">
				 <span class="welcome-message" style="display:none;">you are signed in as </span>
			</span>

			<?php if(isset(Yii::app()->session['login']['profImage']) && Yii::app()->session['login']['profImage']!="" ){
				$src = $this->cdnurl."/images/uploads/profileimages/".Yii::app()->session['login']['profImage'];
			 }else{
			 	$src = $this->cdnurl."/images/no-image.jpg";
			  }?>

			  <?php if(Yii::app()->session['login']['id'] == $userid && $share != "share") { ?>

            <span class="left welcome-back"> <!-- <img src="<?php //echo $src;?>" width="50" height="50" class="left" />--> <!--Welcome back,--> <?php /*echo ucfirst(Yii::app()->session['login']['username'])."!";*/?></span>

			<?php }else{

			$userfinding = User::model()->findByPk($userid); ?>

			<span class="left welcome-back"> <!-- <img src="<?php //echo $src;?>" width="50" height="50" class="left" />--> <?php /*echo ucfirst($userfinding->fname)."'s Profile";*/?></span>

			<?php } ?>

        </div>

		

		<div id="allinfo">
		<?php
			
			$coversrc = "";
			if(isset($userinfo) && $userinfo != "")
			{
				if(isset($userinfo->profile_bg_image))
				{
					$coversrc= $this->cdnurl."/images/uploads/backgroundimages/".$userinfo->profile_bg_image;	
					if(!file_exists(Yii::app()->basePath."/../images/uploads/backgroundimages/".$userinfo->profile_bg_image))
					{
						$coversrc = $this->cdnurl."/images/coverpage.jpg";
					}
				}
				else
					$coversrc = $this->cdnurl."/images/coverpage.jpg";
			
	        }
	 		else
			{
	         	$coversrc = $this->cdnurl."/images/coverpage.jpg";
	        }
			
			
		?>

	<?php if ($Imgupload != 0) { ?>
		
			<?php
			
				if(isset($userinfo) && $userinfo != "")
				{
					if(isset($userinfo->temp_profile_bg_image))
					{
						
						$coversrc=$this->cdnurl."/images/uploads/backgroundimages/".$userinfo->temp_profile_bg_image;							//print_r($coversrc);	
						if(!file_exists(Yii::app()->basePath."/../images/uploads/backgroundimages/".$userinfo->temp_profile_bg_image))
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
		
		
			<div id="divCoverimg" style="z-index:111; width:1000px" class="finao-canvas">
			
				<span class="my-finao-hdline orange">Crop your Image</span>
				   <div class="left">
				   <ul style="padding-left:10px;">
				   <li class="font-14px padding-10pixels">Select the area of the image by holding the corner and dragging it to your desired area. </li>
				   <li class="font-14px padding-10pixels">Click on OK button to save the image or click on Cancel to change the selection.</li>
				  <!-- <li class="font-14px padding-10pixels">Click on Change Profile Picture to select new image.</li>--></ul>
				   </div>
				   <!-- <div class="right"><a href="javascript:void(0);" onclick="js:$('#file').trigger('click');" class="font-16px orange-link"> Change Picture</a></div>	-->
			
				<img src="<?php echo $coversrc; ?>" id="imageid" />
				<input type="hidden" name="image_name" id="image_name" value="<?php echo($userinfo->temp_profile_bg_image); ?>" />
				</div>
				<!--<div class="right"><a class="change-picture" onclick="js:$('#file').trigger('click');" href="javascript:void(0);"> Change Picture</a></div>-->
			<?php }  ?>

		

        <div class="finao-cover-photo" id="divactualImg">

            <img src="<?php echo $coversrc; ?>" width="986" height="350" />
			
			<form name="CoverimageForm" action="<?php echo Yii::app()->createUrl('finao/changePic'); ?>" method="post" enctype="multipart/form-data">

			<input style="cursor:pointer; visibility:hidden" type="file" class="file" name="file" id="file" />

			<?php if(($userid == Yii::app()->session['login']['id'])) { ?>

			<div style="position:absolute; right:0; bottom:10px;">

			<a class="change-picture" onclick="js:$('#file').trigger('click');" title="Minimum size 980 x 350 pixels" href="javascript:void(0);"> Change Picture</a><input type="submit" id="btnProfileimageForm" name="btnProfileimageForm" value="Upload" class="orange-button" style="display:none;" />
			</div>

			<?php } ?>

			</form>

        </div>

		<div class="clear-left"></div>
		
		<?php if($errormsg == "Imgerror") {?>
			<script type="text/javascript">alert("Minimum of 980 x 350 pixels is a must!!")</script>
		<!--<span class="red"></span>-->
		<?php } ?>
		
		</div>
	
	<div id="divImgVid" class="finao-welcome-content" style="display:none;" >

	</div>

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
		<div id="newfinaoform" style="display:none;"></div>
	</div>
	<div id="journaldiv" style="display:none;">
	</div>

		   <div id = "searchshowdiv" style="display:none">
			   </div>

			   <div id = "showcompletedfinaodiv-default" style="display:none">
			   </div>

		<!------------------ SEARCH DIV FOR TRACKING AND TRACKERS END ---------------- -->



	<!-- New layout -->

	<div class="profile-wrapper">

		<div class="profile-content">

	    	<div class="profile-left-panel">

	        	<div class="user-profile" id="userprofile">

	            	<?php $this->renderPartial('/profile/_userprofile',array('userid'=>$userid
													,'userinfo'=>$user
													,'profileinfo'=>$userinfo
													,'finao'=>$profilelatestfinao
													,'tilesinfo'=>$profiletileinfo )); ?>

	            </div>
				
				 
				 
				<?php if($userid == Yii::app()->session['login']['id'] && $share != "share"){ ?>
				<div class="archives">
                        <ul class="topnav">
                            <li><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/'.$userid.'/share/1');?>">Switch to My Public View</a></li>
                        </ul>
                </div>
				 <div class="archives">
                        <ul class="topnav">
                            <li><a href="javascript:void(0)">Add your favorite videos</a>
                                <ul>
                                	<div id="defaultFavVideo" style="padding:5px;">
                                     	<li>
											<p class="padding-5pixels"><font id="errormsgf" style="color:red"></font></p>
                                        	<p class="padding-5pixels"> <input type="text" name="txtVidembedUrlf" id="txtVidembedUrlf" class="txtbox" value="Add Video URL" onclick="if(value == 'Add Video URL') value = ''; if($('#txtVidembedUrlf').hasClass('txtbox-error')) $('#txtVidembedUrlf').addClass('txtbox').removeClass('txtbox-error'); $('#errormsgf').html('');" onblur="if(this.value == ''){ this.value='Add Video URL'; }else { enableSavebtn(); allowonlyYoutube(this.id,'errormsgf','dashboard'); }  " style="width:96%;"/>
								</p>
                                            <p class="padding-5pixels"><input type="text" name="vdurldescriptionf" id="vdurldescriptionf" value="Add Caption" onclick="if(value == 'Add Caption') value = ''; " onblur="if(this.value == '') { this.value='Add Caption'; } " class="txtbox" style="width:96%" maxlength="25" /></p>
                                            
											<?php //print_r(CHtml::listData($tiles,'tile_id','tile_name')); 
												if(isset($tileslist) && $tileslist != "")	{
											?>
											<p class="padding-5pixels"><!--<select class="dropdown" style="width:100%;"><option></option></select>--> <?php echo CHtml::dropDownList('tileinfo','',CHtml::listData($tileslist,'tile_id','tile_name'),array('prompt'=>'Select Your Tile','class'=>'dropdown','onchange'=>'enableSavebtn();')); ?> </p>
											<?php }else { ?>
											<p class="padding-5pixels"><select class="dropdown" style="width:100%;"><option>No Tile Available</option></select ></p>
											<?php } ?>
                                            <p class="padding-5pixels"><input type="button" id="btnemburl" name="btnemburl" class="orange-button" value="Save" style="cursor:pointer;display:none"  onclick="if($('#txtVidembedUrlf').val() != 'Add Video URL' && $('#tileinfo').val() != '' ){ savevideoembUrl(0,'Video',0,'txtVidembedUrlf','vdurldescriptionf','dashboard','errormsgf'); }else{ return false; }" /> <!--<input type="button" class="orange-button" value="Cancel" />--></p>
                                        </li>
                                    </div> 
									<div id="defaultMsgFavVideo" style="padding:10px 5px;display:none">
										<li>
											<font > Your favorite video is added succesfully!!
											</font>
										</li>
									</div>
                                </ul>
                            </li>
                        </ul>
                    </div>
		
				       	
				<div class="archives">
					<ul class="topnav">
							<li><a href="javascript:void(0);">Archived FINAOs</a>
								<ul>
									<div  id="archives">
										<?php $this->renderPartial('_allfinaos',array('finaos'=>$archivefinao,'Iscompleted'=>"completed")); ?>
									</div>
								</ul>
							</li>
					</ul>
				</div>
				<?php }else{?>
				<div class="archives">
                        <ul class="topnav">
                            <li><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg');?>">Switch to My Homepage</a></li>
                        </ul>
                </div>
				<?php }?>
				<div class="clear-left"></div>
				
	            <?php if($userid == Yii::app()->session['login']['id'] && $share != "share"){ ?>
				
				<div class="friends-list"  <?php if(!isset(Yii::app()->session['knownusers'])){?> style="height:50px;" <?php }?>>
						<input type="hidden" id="fbid" value="<?php echo Yii::app()->session['login']['socialnetworkid'];?>" />

					<?php
                    if(!isset(Yii::app()->session['knownusers']))
     				{?> 
						<a onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/inviteFBfriends.png" width="200" /></a>	 	
	 				<?php } 
					
					else{?>
						<div class="font-14px orange left" style="width:100%; padding-bottom:10px;"><span class="left"><?php if($userid!= Yii::app()->session['login']['id'])echo ucfirst($user->fname)."'s";?> Friends In FINAO</span> <a class="right" onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/invite-friends.png" width="100" /></a></div>
						
					<?php } ?> 
                    
					<div id="Default2" class="contentHolder2 ps-container">

					<div id="friends" class="friends-list-wrapper">

								

					</div>

					</div>

	            </div>
				<div class="tracking-you" id="trackingyou" >
				<?php	$this->renderPartial('/tracking/_yourtracking',array('findalltiles'=>$trackingyoudet['findalltiles']
								,'type'=>$trackingyoudet['type']
								,'imtracking'=>$trackingyoudet['imtracking']
								,'userid'=>$userid
								,'tileid'=>$trackingyoudet['tileid']
								,'share'=>$share
								));
				?>
	            </div>
				<?php } ?>	
	            <div class="stats" style="display:none">

	            	<div class="font-16px">Stats</div>

	            </div>

	        </div>

			

	        <div class="profile-middle-panel">
				<?php if($userid== Yii::app()->session['login']['id'] && $share != "share"){?>
	        	<?php if(!empty($tiles) && $tiles != "") {?>				
				<div class="enter-your-finao" id="divfinaowidget" >
				<?php $this->widget('finao',array('type'=>'tilefinao'
										,'Isprofile'=>($share == "share") ? "1" : "0" )); ?>
		         </div>
				 <?php }else
				 { ?>
				 <div class="enter-your-finao">
					<!-- commented on 17-04-2013 -->
				 	<div class="font-14px padding-10pixels orange"><a class="orange" href="#"  onclick="redirect()">Enter a FINAO </a></div><!-- divnewfinaofnacy id="newfinaofnacy"-->
				 	<div style="display:none;">
					 <div id="divnewfinaofnacy" class="login-popupbox" style="width:987px">
					  <?php	$this->renderPartial('newfinao',array('model'=>$model
														,'userid'=>$userid
														,'tiles'=>$tilesnewfinao
														,'newtile'=>$newtile
														,'upload'=>$upload
														,'type'=>$type
														,'userinfo'=>$userinfo)); 
					  ?>	

					</div>

					</div>

				</div>

				<?php } ?>

				<?php }?>

	            <div class="finaos-display" id="allfinaos">

	            	<?php $this->renderPartial('_allfinaos',array('finaos'=>$latestfinaoarray,'Iscompleted'=>"")); ?>

	            </div>
				<script type="text/javascript">
				var notification = setInterval(
				function (){
				myheroes()

				}, 100000); // refresh every 10000 milliseconds



				</script>
	            <div class="finaos-display" id="yourtracking">

	            	<!--<div class="font-16px">Activity of people I am following </div>-->
				<?php	$this->renderPartial('_myheroes',array('trackingppl'=>$activityppl['trackingppl']
																,'uploadinfo'=>$activityppl['uploadinfo']
																,'userid'=>$userid,'userinfo'=>$userinfo
																,'share'=>$share,'users'=>$activityppl['users'])); ?>

	            </div>

	        </div>

	        <div class="profile-right-panel">

				<?php if($userid== Yii::app()->session['login']['id'] && $share != "share"){?>

				
				<div class="clear-left"></div>
				
				 <?php if($user->tags): ?>
			       <div class="tagnotes">
					<ul class="topnav">
					    <li><a href="#">My Tag Notes</a>
						<ul>
						  <!-- array('/finao/editNotes','id'=>$tag->finao_id) -->
							<?php foreach($user->tags as $tag): 
									 echo "  <li style='border-bottom:solid 1px #464646;'>"; ?>
									<a id="spntag-<?php echo $tag->finao_id; ?>" onclick="$('#spntag-<?php echo $tag->finao_id; ?>').hide();$('#edittag-<?php echo $tag->finao_id ?> ').show();" class="double-click" href="javascript:void(0)">
										<!--<img src="" />-->
										<span  class="image-text"><?php echo $tag->finao; ?></span> </a>
										<span id="edittag-<?php echo $tag->finao_id; ?>" style="display:none; float:none!important; position:relative; left:30px;">
											<p style="padding-bottom:10px;"><input type="text" class="txtbox" style="width:180px;" id="edittxt-<?php echo $tag->finao_id; ?>" value="<?php echo $tag->finao; ?>" /></p> 
			<p><input type="button" onclick="savetagnotes('edittxt-<?php echo $tag->finao_id; ?>','<?php echo $tag->finao_id; ?>');" class="orange-button" value="Save" />
			<input type="button" onclick="js:showdefaulttag(<?php echo $tag->finao_id; ?>);" class="orange-button" value="Cancel" /></p>
										</span>						
										
										
										
							<?php								
								  echo "</li>";
						
							      endforeach; ?>
						</ul>
					    </li>
					</ul>
				    </div>
				    <?php endif; ?>
				
                <div class="clear-left"></div>
               
                
				

				<?php } else {?>
					<!--<div class="archives">
                        <ul class="topnav">
                            <li><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg');?>">Switch to My Homepage</a></li>
                        </ul>
                </div>-->
				<?php }?>

				<?php if($userid== Yii::app()->session['login']['id'] && $share != "share"){?>
<!--
	            <div class="friends-list"  <?php if(!isset(Yii::app()->session['knownusers'])){?> style="height:50px;" <?php }?>>
						<input type="hidden" id="fbid" value="<?php echo Yii::app()->session['login']['socialnetworkid'];?>" />

					<?php
                    if(!isset(Yii::app()->session['knownusers']))
     				{?> 
						<a onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/inviteFBfriends.png" width="200" /></a>	 	
	 				<?php } 
					
					else{?>
						<div class="font-14px orange left" style="width:100%; padding-bottom:10px;"><span class="left"><?php if($userid!= Yii::app()->session['login']['id'])echo ucfirst($user->fname)."'s";?> Friends In FINAO</span> <a class="right" onclick="invite_friends()" id="default-invitefriends" href="javascript:void(0);"><img src="<?php echo $this->cdnurl;?>/images/invite-friends.png" width="100" /></a></div>
						
					<?php } ?> 
                    
					<div id="Default2" class="contentHolder2 ps-container">

					<div id="friends" class="friends-list-wrapper">

								

					</div>

					</div>

	            </div>-->

	            <div class="shop">
					<a href="<?php echo $this->cdnurl; ?>/newshop.php">
	            	<img src="<?php echo $this->cdnurl; ?>/images/dashboard/shop.jpg" /></a> 

	            </div>

				<?php }else{?>
				<div class="friends-list">
                	<div class="orange font-14px padding-10pixels">Featured Profiles</div>
						<?php if($userid != 115 ){?>
                    	<div class="feat-profile">
                        	<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/115'); ?>"><img src="<?php echo $this->cdnurl;?>/images/dashboard/01.jpg" width="230" /></a>
                            	<span class="view-profile">
								<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/115'); ?>" class="white-link font-14px">View Profile</a>
								</span>
                        </div>
						<?php }?>
						<?php if($userid != 101 ){?>
                        <div class="feat-profile">
                         <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/101'); ?>"><img src="<?php echo $this->cdnurl;?>/images/dashboard/02.jpg" width="230" /></a>
                            <span class="view-profile"><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/101'); ?>" class="white-link font-14px">View Profile</a></span>
                        </div>
						<?php }?>
						<?php if($userid != 100 ){?>
                        <div class="feat-profile">
                         <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/100'); ?>"><img src="<?php echo $this->cdnurl;?>/images/dashboard/03.jpg" width="230" /></a>
                            <span class="view-profile"><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/100'); ?>" class="white-link font-14px">View Profile</a></span>
                        </div>
						<?php }?>
                        <!--<div class="feat-profile">
                         <img src="images/dashboard/04.jpg" width="230" />
                            <span class="view-profile"><a href="#" class="orange-link font-14px">View Profile</a></span>
                        </div>-->
                    </div> 
                    <!--<div class="shop">
                        <img src="<?php echo $this->cdnurl; ?>/images/dashboard/shop1.jpg" />
                    </div>-->
				<?php }?>

	        </div>

		</div>

	</div>

	<!-- End of new layout-->

</div>



<script type="text/javascript">

$( document ).ready( function(){
	/*$(document).bind("contextmenu",function(e){
    return false;
	});*/
	fbfriednslist();	
});



/*********************---- functions for embeding videos ----*************************/

function enableSavebtn()
{
	if($("#txtVidembedUrlf").val() != "Add Video URL" && $("#tileinfo").val() != "")
	{
		$("#btnemburl").show();
	}
}

function savevideoembUrl(finaoid,sourcetype,journalid,txtid,txtdescid,sourcpage,errorid)
{
	var upload = "Video";
	var emburl = $("#"+txtid).val();
	var embdescr = $("#"+txtdescid).val();
	var tileid=0;
	var tilename = "";
	
	if(!allowonlyYoutube(txtid,errorid,sourcpage))
		return false;
	
	if(sourcpage != 'videopage' && finaoid == 0)
	{
		tileid = $("#tileinfo").val();
		tilename = $("#tileinfo option:selected").text();
	}
		
	var url='<?php echo Yii::app()->createUrl("/finao/GetVideodetail"); ?>';
	$.post(url, { finaoid : finaoid, upload : upload , sourcetype:sourcetype, journalid: journalid , emburl: emburl, embdescr:embdescr, tileid : tileid , tilename:tilename },
		function(data){
	  		if(data)
			{
				if(sourcpage == 'videopage')
				{
					$("#manageImg").html("");
					$("#manageImg").html(data);	
				}
				else
				{
					$("#defaultFavVideo").hide();
					$("#defaultMsgFavVideo").show();
					setTimeout(function(){
						refreshwidget(<?php echo $userid; ?>);
						$("#"+txtid).val("Add Video URL");
						$("#"+txtdescid).val("Add Caption");
						$("#tileinfo").val("");
				        $("#defaultMsgFavVideo").hide();
						$("#defaultFavVideo").show();
				    }, 5000);
				}
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



 function gettileid(id,did)

{

 tileid = id;

 frndid = did;

 var url='<?php echo Yii::app()->createUrl("/tracking/saveTracktiles"); ?>';

 	$.post(url, { tileid :  tileid , frndid : frndid},

   		function(data){

				$("#track").html(data);

		});

}

function getuntracktileid(tileid,frndid)

{

 	

	var url='<?php echo Yii::app()->createUrl("/tracking/deleteTracktiles"); ?>';

 	$.post(url, { tileid :  tileid , frndid : frndid},

   		function(data){

				$("#tracking").html(data);

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

	var url='<?php echo Yii::app()->createUrl("/finao/updateFinao"); ?>';

	//alert(statusid);

 	$.post(url, { userid :  userid , finaoid : finaoid , statusid:statusid, page:page},

   		function(data){

   			//alert(data);

			if(data)

			{

				//getmessages();

				//$("#singlefinaoupdate-"+page+"-"+finaoid).html(data);

				//alert($("#finaoform").html(data));

				//$("#finaoimage").html(data);

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

function addimages(userid,finaoid,type,uploadtype,journalid)

{

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

 	$.post(url, { userid :  userid , finaoid : finaoid , type:type, uploadtype:uploadtype,journalid: journalid , pageid : pageid},

   		function(data){

   			//alert(data);

			if(data)

			{

				if(type == "finao")

					$("#journaldiv").hide();

				if(type == "journal")

					$("#journaldiv").hide();

				$("#finaoform").hide();

				$("#finaodiv").show();

				$("#newfinaoform").html(data);

				$("#newfinaoform").show();

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

   			//alert(data);

			if(data)

			{

				if(data != "")

					$("#manageImg").html(data);

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

				$("#manageImg").html(data);

			}

			

     });

}



function getnewjournal(userid,finaoid)

{

	var url='<?php echo Yii::app()->createUrl("/finao/getNewJournal"); ?>';

 	$.post(url, { userid :  userid , finaoid : finaoid},

   		function(data){

   			//alert(data);

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

	//$("#journalentry").hide();

}

/*function getalljournals(id,userid)

{

	//alert(id);

	//alert(userid);

	//$("#getalljournals-"+id).trigger("click");

	var url='<?php echo Yii::app()->createUrl("/finao/allJournals"); ?>';

 	$.post(url, { finaoid : id, userid : userid},

   		function(data){

   			//alert(data);

			if(data)

			{

				$("#finaodiv").hide();

				$("#journaldiv").show();

				$("#journaldiv").html(data);

				

			}

			

     });

}*/

function updatefinaopublic(finaoid,userid,type,tileid)

{

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

		/*if (ispublic.checked){*/

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

	    /*}else{

	       ispublic = 0;

	    }*/

	}

	if(flag=="true")

	{

		var url='<?php echo Yii::app()->createUrl("/finao/updateFinaoPublic"); ?>';

	 	$.post(url, { finaoid : finaoid, userid : userid, ispublic : ispublic, type:type},

	   		function(data){

	   			//alert(data);

				if(data)

				{
					if(data=="getfinaos")
					{
						getfinaos(userid,tileid);
					}
					else if(data=="coverpage")
					{
						hidealldivs();
						$("#allinfo").show();
						refreshwidget(userid);
					}
				}

				

	     });

	}

}



function submitfinao(userid,redirecttype,type)

{

	var finaomesg = document.getElementById('finaomesg').value;

	var tileid = document.getElementById('tileid').value;

	var tilename = document.getElementById('tilename').value;

	var ispublic = document.getElementById("ispublic").checked;

	

	if(tileid > 0 && tilename == "" )

		tileid = "";

	//alert(ispublic);

	if(finaomesg.length > 1 && tileid.length >= 1)

	{

		//alert(tileid.length)

		var url='<?php echo Yii::app()->createUrl("/finao/addFinao"); ?>';

		$.post(url, { userid : userid , tileid : tileid , finaomesg : finaomesg , tilename : tilename , ispublic : ispublic},
	   		function(data){
				if(data)
				{
					getheroupdate();
					if(type == "firstfinao")
					{
						var url = "<?php echo Yii::app()->createUrl('/finao/motivationmesg');?>";
   						window.location = url;
					}
					if(redirecttype=="addanotherfinao")
					{
						getfinaos(userid,data);
						refreshwidget(userid);
					}
					else if(redirecttype=="savefinaomedia")
					{
						//addimages(userid,data,'finao','Image');
						getfinaos(userid,tileid);
					}
					else if(redirecttype=="savefinaojournal")
						getnewjournal(userid,data);
				}

				

	    

	     });

	}

	else

	{

		//$("#mesg").html("Please enter mandatory fields");

		if(finaomesg.length < 1)

		{

			document.getElementById('finaomesg').className = "finaos-area-error";

		}

		if(tilename.length < 1)

		{

			document.getElementById('finaotiles').className = "tiles-div-error";

		}

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

	/*if($("#tileid"+tileid).length)
		$("#tileid"+tileid).addClass("selected");*/
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

	var url='<?php echo Yii::app()->createUrl("/finao/getFinaoMessages"); ?>';

	$.post(url, { userid : userid , tileid : tileid , share : share ,heroupdate:heroupdate , finaoid : finaoid},

   		function(data){

   			//alert(data);

			if(data)

			{

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

				getTrackStatus(userid,tileid);

				

				$("#finaomesgsdisplay").html(data);
				
				//$("#allinfo").html(data);			

					/* code add by Gowri */

					

				videocnt = 0;

				videocnt = $("#totVidcount").val();

				$("#spncntVid").html("");

				$("#spncntVid").html((videocnt > 0) ? "("+videocnt+")" : "");

				

				imgcnt = 0;

				imgcnt = $("#totImgcount").val();

				$("#spncntImg").html("");

				$("#spncntImg").html((imgcnt > 0) ? "("+imgcnt+")" : "");

				

				//$("#sampleimg").attr('src',$("#totImgurl").val());

				//$("#samplevid").attr('src',$("#totVidurl").val());

				

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

				

				//alert($("#totImgurl").val());

				//alert($("#totVidurl").val());

				/*if($("#totVidurl").val() == "")

					$("#samplevid").attr('src',"");

				if($("#totImgurl").val() == "")	

					$("#sampleimg").attr('src',"");*/

					

				if($("#frndtileid").length)

					$("#frndtileid").val(tileid);

				if($("#userfrndid").length)

					$("#userfrndid").val(tileid);	

				//document.getElementById('frndtileid').value = tileid;

				//document.getElementById('userfrndid').value = userid;

				

				//$("#tilesid").html(data);

				allfinaos();

			}

			

    

     });

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

	//document.getElementById('editfinaoicon-'+finaoid).style.display = "none";

}

function savefinaomesg(userid,finaoid)

{

	var finaomesg = document.getElementById('newmesg-'+finaoid).value;

	var url='<?php echo Yii::app()->createUrl("/finao/updateFinao"); ?>';

 	$.post(url, { userid :  userid , finaoid : finaoid , finaomesg : finaomesg},

   		function(data){

   			//alert(data);

			if(data)

			{

				//document.getElementById('editfinaoicon-'+finaoid).style.display = "";

				document.getElementById('editfinaomesg-'+finaoid).style.display = "none";

				document.getElementById('finaomesg-'+finaoid).style.display = "block";

				

				$("#finaomesg-"+finaoid).html(data);

			}

			

     });

	 

}

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



function clickdiv(id)

{

	var checkboxid = id.split("-");

	if($("#tileid").length)

		$("#tileid").val(checkboxid[2]);

		

	if($("#tilename").length)

		$("#tilename").val(checkboxid[1]);

	

	$("#tiledisplay .holder-active").addClass("holder smooth").removeClass("holder-active");

	$("#"+id).addClass("holder-active");		

}

function removeclass()

{

	document.getElementById('finaomesg').className = "finaos-area";

}



$(document).ready(function(){



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

	
	

});

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

		var url='<?php echo Yii::app()->createUrl("/finao/newTileFinao"); ?>';

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
function deletefj(type,userid,journalid,finaoid)
{
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

			$.post(url, { userid :  userid , journalid : journalid ,type : type},

		   		function(data){

		   			//alert(data);

					if(data)

					{
						if(type=="journal")
						{
							getalljournals(finaoid,userid,0);
							refreshwidget(userid);
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
	alert(pageid);
	var share = document.getElementById('isshare').value;
	var url='<?php echo Yii::app()->createUrl("/finao/nextPrevtiles"); ?>';
	$.post(url, { userid : userid , share : share,pageid : pageid},

		function(data){

	  			//alert(data);

			if(data)

			{
				$("#menuhidediv").show();
				$("#menuhidediv").html(data);

			}

		});
}
</script>