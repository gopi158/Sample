 
<style>
a.tagnotes-anchor:hover{background:#FFF!important; color:#343434!important; min-height:40px;}
</style>

<link href="<?php echo $this->cdnurl;?>/javascript/scrollbar/perfect-scrollbar.css" rel="stylesheet" />
<script src="<?php echo $this->cdnurl;?>/javascript/scrollbar/jquery.mousewheel.js"></script>
<script src="<?php echo $this->cdnurl;?>/javascript/scrollbar/perfect-scrollbar.js"></script>
 <script>
/*$(document).ready(function() {
	$(".topnav").accordion({
		accordion:false,
		speed: 500,
		closedSign: '+',
		openedSign: '-'
	});
});*/


$(function($) {
    $('.double-click').click(function() {
        return false;
    }).dblclick(function() {
        window.location = this.href;
        return false;
    });
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
</script>


<script src="http://connect.facebook.net/en_US/all.js"></script>
<script> 

window.fbAsyncInit = function() {

	FB.init({ 

	appId:'424392384305767', // or simply set your appid hard coded

//424392384305767 this is for finao.skootweet.com
		cookie:true, 

		status : true,

		xfbml:true

	});



};

FB.api('/me', function(response) {

 // alert('Your name is ' + response.name);

});

// https://developers.facebook.com/docs/reference/dialogs/requests/

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

<?php if ($Imgupload != 0 || $Tileimageupload != 0) {  ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/css/imgareaselect-default.css" />
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.imgareaselect.pack.js"></script>
<?php } ?>
<script type="text/javascript">
var IsimgUpload = "<?php echo $Imgupload; ?>";
var Tileimageupload = '<?php echo $Tileimageupload;?>';
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
	if($('img#tileimageid').length)
	{
		$('img#tileimageid').imgAreaSelect({
        x1: 0, y1: 0, x2: 440, y2: 320,
		//maxWidth: 980, 
		//maxHeight: 350, 
		aspectRatio: '11:8',
        onSelectEnd: getTileSizes
    	});	
	}
	if(IsimgUpload != 0 || Tileimageupload != 0)
	{
		$("#divactualImg").hide();
	}
		

});

function getTileSizes(im,obj)
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
						
						fileext = ($("#tileimage_name").val()).substr(($("#tileimage_name").val()).lastIndexOf('.')+1);
						//alert(fileext);
						$.ajax({
							type:"GET",
							
								url: urlvalue+"?t=ajax&img="+$("#tileimage_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis+"&fileext="+fileext+"&tileimageid="+Tileimageupload,
							
							
							cache:false,
							success:function(rsponse)
								{
									//alert(rsponse);
								 	if(rsponse == "Please try again!!")
									{
										alert("Please try again!!");
										return false;
									}
							<?php if($groupid != ''){?> 
							var rd ='<?php echo Yii::app()->createUrl("/group/dashboard/groupid/".$groupid."/getusertileid/##data"); ?>';
							<?php }else{?> 
							var rd ='<?php echo Yii::app()->createUrl("/finao/motivationmesg/getusertileid/##data"); ?>';
							
							<?php }?>		
									
	                    			rd = rd.replace('##data',Tileimageupload);
									window.location=rd;
									 
								}
						});
					}
			}
		else
			alert("Please select portion..!");
}
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
									//alert(rsponse);
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
		<div id="menustrip">
		<?php
		$this->widget('TopMenu',array('userid'=>$userid
		                                ,'isshare'=>$share
										,'alltiles'=>$menucount['tilescount']
										,'imgcount'=>$menucount['imagecount']
										,'videocount'=>$menucount['videocount']
										,'finaocount'=>$menucount['finaocount']
										,'followcnt'=>$menucount['followcount']
										,'groupcnt' =>$groupcount
										));
		?>
		</div>
		 
		 
        <div id="divdisplaydata">
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
	<input type="hidden" id="usertileid" value=""/>
	<input type="hidden" id="isfrommenu" value=""/>
    <input type="hidden" name="groupid" id="groupid" value=""  />
    <input type="hidden" name="ismember" id="ismember" value=""  />

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

	<?php if ($Imgupload != 0 ) { ?>
		
			
			
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
			<a class="btn-close" onclick="closefrommenu(0)" ><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>

				<span class="my-finao-hdline orange">Crop your Image</span>
				   <div class="left">
				   <ul style="padding-left:10px;">
				   <li class="font-14px padding-10pixels">Select the area of the image by holding the corner and dragging it to your desired area. </li>
				   <li class="font-14px padding-10pixels">Click on OK button to save the image or click on Cancel to change the selection.</li>
				  <!-- <li class="font-14px padding-10pixels">Click on Change Profile Picture to select new image.</li>--></ul>
				   </div>
				    <div class="right"><a href="javascript:void(0);" onclick="js:$('#file').trigger('click');" class="font-16px orange-link"> Change Picture</a></div>	
			
				<img src="<?php echo $coversrc; ?>" id="imageid" />
				<input type="hidden" name="image_name" id="image_name" value="<?php echo($userinfo->temp_profile_bg_image); ?>" />
				</div>
                
	<?php }elseif($Tileimageupload != 0)
			{
				//echo "hiiiiii";
				if(isset($tileimage) && $tileimage->temp_tile_imageurl != "")
				{
					$tileimagesrc = $this->cdnurl."/images/tiles/".$tileimage->temp_tile_imageurl;
					if(file_exists(Yii::app()->basePath."/../images/tiles/".$tileimage->temp_tile_imageurl))
					{ ?>
				<div id="tileimagecrop" style="z-index:111; width:1000px" class="finao-canvas">
<a class="btn-close" onclick="closefrommenu(0)" ><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>
			
				<span class="my-finao-hdline orange">Crop your Image</span>
				   <div class="left">
				   <ul style="padding-left:10px;">
				   <li class="font-14px padding-10pixels">Select the area of the image by holding the corner and dragging it to your desired area. </li>
				   <li class="font-14px padding-10pixels">Click on OK button to save the image or click on Cancel to change the selection.</li>
				  <!-- <li class="font-14px padding-10pixels">Click on Change Profile Picture to select new image.</li>--></ul>
				   </div>
				   <!-- <div class="right"><a href="javascript:void(0);" onclick="js:$('#file').trigger('click');" class="font-16px orange-link"> Change Picture</a></div>	-->
			
				<img src="<?php echo $tileimagesrc; ?>" id="tileimageid" />
				<input type="hidden" name="tileimage_name" id="tileimage_name" value="<?php echo($tileimage->temp_tile_imageurl); ?>" />
				</div>
						
			<?php }
				}
			}
			?>


        <div class="finao-cover-photo" id="divactualImg">

            <img src="<?php echo $coversrc; ?>" width="986" height="350" />
			
			<form name="CoverimageForm" action="<?php echo Yii::app()->createUrl('finao/changePic'); ?>" method="post" enctype="multipart/form-data">

			<input style="cursor:pointer; visibility:hidden" type="file" class="file" name="file" id="file" />

			<?php if(($userid == Yii::app()->session['login']['id'])) { ?>

			<!--<div style="position:absolute; right:0; bottom:10px;">

			<a class="change-picture" onclick="js:$('#file').trigger('click');" title="Minimum size 980 x 350 pixels" href="javascript:void(0);"> Change Picture</a><input type="submit" id="btnProfileimageForm" name="btnProfileimageForm" value="Upload" class="orange-button" style="display:none;" />
			</div>-->
            
             <a onclick="js:$('#file').trigger('click');" title="Minimum size 980 x 350 pixels" href="javascript:void(0);"><div class="change-picture orange"><?php if(isset($userinfo->temp_profile_bg_image)) echo 'Change cover photo'; else echo 'Upload a cover photo';?></div>
            </a>
            <input type="submit" id="btnProfileimageForm" name="btnProfileimageForm" value="Upload" class="orange-button" style="display:none;" /> 

			<?php } ?>

			</form>

        </div>

		<div class="clear-left"></div>
		
		<?php if($errormsg == "1") {?>
			<script type="text/javascript">alert("Minimum of 980 x 350 pixels is a must!!")</script>
		<!--<span class="red"></span>-->
		<?php } ?>
        
        <?php if($errormsg == "2") {?>
			<script type="text/javascript">alert("Minimum of 140 x 140 pixels is a must!!")</script>
		<!--<span class="red"></span>-->
		<?php } ?>
		
		</div>
		
<?php if($_GET['create']=='finao'){?><script type="text/javascript">createfinao(<?php echo $userid ?>,'0');</script><?php }?>		
		
	
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
		<!--<div id="newfinaoform" style="display:none;"></div>-->
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
													,'tilesinfo'=>$profiletileinfo
													,'share' => $share )); ?>

	            </div>
				
				<?php if($userid == Yii::app()->session['login']['id']){ if(!empty($trackgroups)){?> 
				<!--<div class="define-team-profile">
                    	<div class="box left"><div class="orange font-14px padding-10pixels tour_9">Following Groups</div></div>
                        <div class="font-12px padding-5pixels groups">
                        	
                        <?php  foreach($trackgroups as $eachitem){?> 
						    <div class="grooup-name">
                            	<div class="group-left">
                               <?php 
							   $grpimg =  "".$this->cdnurl."/images/icon-group.png";
							   if($eachitem->profile_image != '')
							   {
								   $grpimg = "".$this->cdnurl."/images/uploads/groupimages/profile/".$eachitem->profile_image."";
							   }?>
                               
                                <img width="16" height="16" src="<?php echo $grpimg; ?>">
                                </div>
                                <div class="group-right">
                                	<a href="<?php echo Yii::app()->createUrl("Group/Dashboard",array('groupid'=>$eachitem->group_id,'frndid'=>$eachitem->updatedby)); ?>" style="color:#fff;"><span class="left"><?=substr($eachitem->group_name,0,18)?></span></a>
                                        <span class="right">
                                        
                                         
									  <input type="checkbox" id="visible" onclick="visible(<?php echo $eachitem->group_id?>);" <?php if($eachitem->visible == 1) {?> checked="checked" <?php }?>  name="visible"  />
									  
                                        </span>
                                        <span class="right"> 
                                      
                                        <img style="margin-right:25px;" src="<?php echo $this->cdnurl;?>/images/icon-admin.png"> 
                                        	<?php /*?><dl class="dropdown" id="sample">
                                                <dt>
                                                <a href="<?php echo Yii::app()->createUrl("Group/Dashboard",array('groupid'=>$eachitem->group_id,'action'=>'edit')); ?>">
                                                <span>
                                                <img width="12" height="12" src="<?php echo $this->cdnurl;?>/images/icon-edit.png">
                                                </span>
                                                </a></dt>
                                                <dd>
                                                    <ul>
                                                        <li><a href="#"><input type="checkbox"> Make Public</a></li>
                                                        <li><a href="#">Leave Group</a></li>
                                                    </ul>
                                                </dd>
                                            </dl><?php */?>
                                       </span>
                                </div>
                            </div>
						<?php  } ?>    
                            
                        
                        
                        </div>
                    </div>-->
				<?php } } ?>
                
                 
                    
                    <div class="clear-left"></div>
				 
				<?php if($userid == Yii::app()->session['login']['id'] && $share != "share"){ ?>
                
                
				<div class="archives">
                        <ul class="topnav">
                            <li><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/'.$userid.'/share/1');?>">Switch to My Public View</a></li>
                        </ul>
                </div>
				<?php if(isset($latestfinaoarray['finaos']) && !empty($latestfinaoarray['finaos'])){?>
				 
		
				       	
				<div class="archives">
					<ul class="topnav">
							<li><a href="javascript:void(0);">Archived FINAOs</a>
								<ul>
									<div  id="archives">
										<?php $this->renderPartial('_allfinaos',array('finaos'=>$archivefinao['finaos'],'Iscompleted'=>"completed")); ?>
									</div>
								</ul>
							</li>
					</ul>
				</div>
				<?php }?>
				<?php }else if(empty(Yii::app()->session['login']['id'])){?>
				<div class="archives">
                        <ul class="topnav">
                            <li><a href="<?php echo Yii::app()->createUrl('site/index');?>">Switch to My Homepage</a></li>
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
				
				<?php if(isset($latestfinaoarray['finaos']) && !empty($latestfinaoarray['finaos'])){
				if(isset($_REQUEST['share']))
				{
					$share = "share";
				}
				else
				{
					$share = "no";
				}			
				 $this->renderPartial('_allfinaos',array('finaos'=>$latestfinaoarray['finaos'],'latestuploads' =>$latestfinaoarray['uploaddetails'], 'Iscompleted'=>"",'userid'=>$userid,'share'=>$share)); ?>

	           <!-- </div>-->
				<?php }else {?>
				
        <div id="totfinaos">
        <div class="enter-your-finao" id="singleviewfinao">
        <div>
   
      <div class="font-16px padding-10pixels left" id="Activity">
   
      <?php if($userid==Yii::app()->session['login']['id'] && isset($share) && $share!="share") echo 'No FINAOs'; else echo "No FINAOs";?>
   
     </div>
      <div class="right">
   
      
   
     <?php if($userid==Yii::app()->session['login']['id'] && isset($share) && $share!="share"){ ?> 
   
     <input type="button" id="finaofeed"  class="orange-button bolder" onclick="createfinao(<?php echo $userid ?>,'0')" value="Create a new FINAO"  />
   
     <?php }?>
   
      
   
      </div>
   
     </div>
    </div>
   </div>
   
                  <?php }?>
	
				<script type="text/javascript">
				var notification = setInterval(
				function (){
				myheroes()

				}, 100000); // refresh every 10000 milliseconds
				</script>
	
				<div class="clear"></div>
	            <div class="finaos-display" id="yourtracking">

	            	<!--<div class="font-16px">Activity of people I am following </div>-->
				<?php	$this->renderPartial('_myheroes',array('trackingppl'=>$activityppl['trackingppl']
																,'uploadinfo'=>$activityppl['uploadinfo']
																,'userid'=>$userid,'userinfo'=>$userinfo
																,'share'=>$share,'users'=>$activityppl['users'])); ?>

	            </div>

	        </div>

	        <div class="profile-right-panel">
                 
				<?php if($userid== Yii::app()->session['login']['id']){?>
				
               
                        <!-- <div class="friends-list"><div class="box left"><div style="width:230px;" class="orange font-14px padding-5pixels tour_14">Create Group</div></div>
                        <p class="padding-5pixels">Groups pages offer an organization, team with a similar interest to create a page where the leader (Admin) can share information, media and offer support and encouragement, make goals, or motivate team members through group FINAOs.</p>
                        <p class="padding-5pixels center">
                       <!-- <input onclick="creategroup();" type="button" value="Create Group" class="orange-button">-->
                      <!--   <a class="orange-button" onclick="creategroup(0,0);" href="#divdisplaydata">Create Group</a>
                        </p></div>-->
						 <div class="switch-to-home" id="create_grou" onclick="creategroup(0,0);">Create Group</div>
                    
                    
				
                <div class="clear-left"></div>
				
				 <?php if(!empty($tagnotes)){ ?> 
			       <div class="tagnotes" >
                   
					<ul class="topnav">
					    <li><a href="#">My Tag Notes</a>
						<ul>
						  <!-- array('/finao/editNotes','id'=>$tag->finao_id) -->
							<div  style="overflow-y:auto; overflow-x:hidden; height:200px; width:250px; float:left; margin-bottom:10px; background:#323232;">
							<?php foreach($tagnotes as $tag): 
									
									
									//echo $tag["value"].'<br/>';
									
							$filname = $tag["value"];
							$pieces = explode("/", $filname);
							//echo $pieces[0]; // piece1
							$imgsrc =  'http://'.$_SERVER['HTTP_HOST'].'/shop/media/catalog/product/'.$pieces[1].'/'.$pieces[2].'/'.$pieces[3]; 
									
									//echo $tag["finao"];
								 echo "  <li style='border-bottom:solid 1px #464646; width:240px; padding:5px; float:left;'>"; ?>
                                     
                                    
                                    
                                    <div style="float:left; width:40px;">
                                   
                                   
                                   <img width="40" height="40" src="<?php echo $imgsrc ?>" />
                                   
                                   
                                
                                    </div>
                                    
                                    <div style=" position:relative;width:185px; padding-left:5px; float:left;">
                                    <a class="tagnotes-anchor double-click" style="padding:0px; color:#999a9b;" id="spntag-<?php echo $tag["finao_id"]; ?>" onclick="$('#spntag-<?php echo $tag["finao_id"]; ?>').hide();$('#edittag-<?php echo $tag["finao_id"];?> ').show();"  href="javascript:void(0)">
										<!--<img src="" />-->
										<span  class="image-text" style="width:133px; padding-left:0px; padding-top:0; word-wrap:break-word; line-height:14px;">
										<?php echo $tag["finao"]; ?>
                                        </span> 
                                        <span>
                                        <img  src="<?php echo $this->cdnurl; ?>/images/icon-edit.png" title="Edit" style="position:absolute; right:5px; top:5px;" />
                                        </span>
                                        </a>
										<span id="edittag-<?php echo $tag["finao_id"]; ?>" style="display:none; float:left;">
            <p style="padding-bottom:10px;">
            <input type="text" class="txtbox" style="width:170px; " id="edittxt-<?php echo $tag["finao_id"]; ?>" value="<?php echo $tag["finao"]; ?>" />
            <!--<textarea style="width:170px;" class="txtbox" id="edittxt-<?php echo $tag["finao_id"]; ?>">
            <?php echo $tag["finao"]; ?>
            </textarea> -->
            </p> 
			<p><input type="button" onclick="savetagnotes('edittxt-<?php echo $tag["finao_id"]; ?>','<?php echo $tag["finao_id"]; ?>');" class="orange-button" value="Save" />
			<input type="button" onclick="js:showdefaulttag(<?php echo $tag["finao_id"]; ?>);" class="orange-button" value="Cancel" /></p>
										</span>	
                                    </div> 
                                    
                                    <?php /*?><li style="width:250px; float:left">
                                      <a href="#" style="width:240px; padding-left:10px; float:left; color:#999a9b;">
                      <span class="left" style="width:50px; margin-right:0px;">
                      <!--<img src="<?php echo $this->cdnurl; ?>/images/profile-pic.jpg" width="45" class="left" />-->
                      <img width="40" height="40" src="<?php echo $imgsrc ?>" class="left" />
                                         
                                          </span>
                                            <span class="left" style="width:140px; margin-right:0px; position:relative; word-wrap:break-word;">
                                             <?php echo $tag["finao"]; ?>
                                                <img  src="<?php echo $this->cdnurl; ?>/images/icon-edit.png" title="Edit" style="position:absolute; right:0; bottom:0;" />
                                                
                                                
                                            </span>
                                        </a>
                                     </li><?php */?>
														
										
										
										
							<?php								
								 echo "</li>";
						
							      endforeach; ?>
                                  </div>
						</ul>
					    </li>
					</ul>
				    </div>
				    <?php } ?>
				
                <div class="clear-left"></div>
               
                
				

				<?php } else {?>
					<!--<div class="archives">
                        <ul class="topnav">
                            <li><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg');?>">Switch to My Homepage</a></li>
                        </ul>
                </div>-->
				<?php }?>

				<?php if($userid== Yii::app()->session['login']['id']){?>
                 <div class="shop">
               
                <div class="orange font-14px padding-10pixels">Featured Profiles</div>
                <?php $rand=rand(1,2);?>
              <?php  if($rand == 1){?> 
			  
						<?php if($userid != 100 ){?>
                        
                        <div class="feat-profile">
                        
                        <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/100'); ?>"><img src="<?php echo $this->cdnurl;?>/images/dashboard/03.jpg" width="230" /></a>
                        
                        <span class="view-profile"><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/100'); ?>" class="white-link font-14px">View Profile</a></span>
                        
                        </div>
                        
                        <?php }?>
			  
			  <?php }else{?> 
			  
						<?php if($userid != 101 ){?>
                        
                        <div class="feat-profile">
                        
                        <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/101'); ?>"><img src="<?php echo $this->cdnurl;?>/images/dashboard/02.jpg" width="230" /></a>
                        
                        <span class="view-profile"><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/101'); ?>" class="white-link font-14px">View Profile</a></span>
                        
                        </div>
                        
                        <?php }?>
			  
			  <?php }?>
               
               </div>

	            <div class="shop">
					
                    <?php if(isset($_COOKIE['SID'])){ $url = "/shop/index.php/?SID=".trim($_COOKIE['SID']).""; }else{$url = "http://".$_SERVER['SERVER_NAME']."/shop";}?>
                    
                   <a href="<?php echo $url;?>">
					<?php $string = substr(str_shuffle("mf"), 0, 1); //$short=rand(1,7);$long=rand(1,10);
					if($string=='m')
						{
							$short=rand(1,3);
							$long=rand(1,6);?>	
						<img src="<?php echo $this->cdnurl; ?>/images/dashboard/b<?php echo $short;?>.png" style="margin-bottom:6px;" />
						<img src="<?php echo $this->cdnurl; ?>/images/dashboard/tg<?php echo $long;?>.png" />
						<?php } else {
						$short=rand(1,4);
							$long=rand(1,4);?>	
						<img src="<?php echo $this->cdnurl; ?>/images/dashboard/g<?php echo $short;?>.png" style="margin-bottom:6px;" />
						<img src="<?php echo $this->cdnurl; ?>/images/dashboard/tm<?php echo $long;?>.png" />
						
						<?php }?>

					
					
	            	<?php /*?><img src="<?php echo $this->cdnurl; ?>/images/dashboard/Shop_Short_<?php echo $short;?>.png" />
					<img src="<?php echo $this->cdnurl; ?>/images/dashboard/Shop_Tall_<?php echo $long;?>.png" /><?php */?>
					</a> 

	            </div>

				<?php }else{?>
				<div class="friends-list">

                	<div class="orange font-14px padding-10pixels">Featured Profiles</div>
					
					
					
<?php /*?>
						<?php if($userid != 115 ){?>

                    	<div class="feat-profile">

                        	<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/115'); ?>"><img src="<?php echo $this->cdnurl;?>/images/dashboard/01.jpg" width="230" /></a>

                            	<span class="view-profile">

								<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/115'); ?>" class="white-link font-14px">View Profile</a>

								</span>

                        </div>

						<?php }?><?php */?>
						

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

						

                        

                       <?php /*?> <?php if($userid != 265 ){?>

                        <div class="feat-profile">

                         <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/265'); ?>"><img src="<?php echo $this->cdnurl;?>/images/dashboard/05.jpg" width="230" /></a>

                            <span class="view-profile"><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/265'); ?>" class="white-link font-14px">View Profile</a></span>

                        </div>

                        <?php }?><?php */?>

                        <!--<div class="feat-profile">

                         <img src="images/dashboard/04.jpg" width="230" />

                            <span class="view-profile"><a href="#" class="orange-link font-14px">View Profile</a></span>

                        </div>-->

                    </div> 
					
					 <?php if(isset($_COOKIE['SID'])){ $url = "/shop/index.php/?SID=".trim($_COOKIE['SID']).""; }else{$url = "http://".$_SERVER['SERVER_NAME']."/shop";}?>

                    
					
                  <a href="<?php echo $url;?>">
                  	<div class="shop">

						<?php $long=rand(1,10);?>

	            	<img src="<?php echo $this->cdnurl; ?>/images/dashboard/Shop_Tall_<?php echo $long;?>.png" />				
                    </div>

					</a>

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
	<?php if(isset($_GET['tile'])){?>
	putseltile(<?php echo $getusertileid;?>);
	getdetailcustomtile(<?php echo $userid;?>,<?php echo $_GET['tile'];?>);
	<?php }?>
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
	
	if(!allowonlyYoutube(txtid,errorid,sourcpage))
		return false;
	
	if(sourcpage != 'videopage' && finaoid == 0)
	{
		tileid = $("#tileinfo").val();
		tilename = $("#tileinfo option:selected").text();
	}
	var journaltxt = $('#getjournalmsg').val();
	//alert(journaltxt);
	var url='<?php echo Yii::app()->createUrl("/finao/GetVideodetail"); ?>';
	$.post(url, {userid:userid, finaoid : finaoid, upload : upload , sourcetype:sourcetype, journalid: journalid , emburl: emburl, embdescr:embdescr, tileid : tileid , tilename:tilename,journaltxt:journaltxt},
		function(data){
	  		 //alert(data);
			if(data)
			{
				var split = data.split('-');
				var finaoid = split[0];
				var titleid = split[1];
				
				refreshmenucount(userid);
				document.getElementById("youtubevideoform").reset();
				 getheroupdate();
				 getthatfinao(finaoid);
				 //getfinaos(userid,tileid);
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

	var url='<?php echo Yii::app()->createUrl("/finao/updateFinao"); ?>';

	//alert(statusid);

 	$.post(url, { userid :  userid , finaoid : finaoid , statusid:statusid, page:page},

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
	var journalmessage = $('#journalmsg').val();
	 //alert(journalmessage);
	//$('#getjournalmsg').html(journalmessage);
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
 	$.post(url, { userid :  userid , finaoid : finaoid , type:type, uploadtype:uploadtype,journalid: journalid , pageid : pageid, menuselected:menuselected,journalmessage:journalmessage },
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
				 
				if(uploadtype == "Video")
					refreshmenucount(userid) 
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
    var groupid = '';
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

	 	$.post(url, { finaoid : finaoid, userid : userid, ispublic : ispublic, type:type},

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

	var groupid = '';
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

	$.post(url, { userid : userid , tileid : tileid , share : share ,heroupdate:heroupdate , finaoid : finaoid  , usertileid : usertileid,groupid:groupid},

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
				getTrackStatus(userid,tileid,0);
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
	$('#singleviewfinao').html('Loading Finao Activities <img src="<?php echo $this->cdnurl; ?>/images/dot.gif" />');
	//else if(finaoid=='0') var finaoid=$('#next_finao').val();
	var share = document.getElementById('isshare').value;
	setTimeout(function (){var finaoid=$('#next_finao').val();	var url='<?php echo Yii::app()->createUrl("/finao/viewSingleFinao"); ?>';$.post(url, { userid : userid , finaoid :finaoid,share:share},function(data){$('#singleviewfinao').html(data);});},3000);	
	
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
	var share = document.getElementById('isshare').value;
	//alert(share);
	var usertileid = document.getElementById('usertileid').value;
	var url='<?php echo Yii::app()->createUrl("/finao/getDetailTile"); ?>';
	$.post(url, { userid : userid , tileid : tileid, share : share, usertileid : usertileid},
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
// custom tile display 66 hbcu
function getdetailcustomtile(userid,tileid)
{
	var url='<?php echo Yii::app()->createUrl("/finao/Getprofiledetails"); ?>';
	$.post(url, { userid : userid ,tileid : tileid, tile_name : 'HBCU connect', render:1},
	function(data){
	if(data)
	{
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
	if(page=="main")
	{
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
	$('.hbcucou').html('');$('#create_grou').show();
	
}

function refreshmenucount(userid)
{
	selectedmenu = $(".active-category").attr("rel");
	
	//alert(userid);
	var url='<?php echo Yii::app()->createUrl("finao/Getmenucount"); ?>';
 	$.post(url, { userid : userid },
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
function visible(groupid,inc)
{
  var visible = $('#visiblehide'+inc).attr('checked') ? 1 : 0;
  
  alert(visible);
  var url='<?php echo Yii::app()->createUrl("finao/hidegroup"); ?>';
   $.post(url, { groupid:groupid,visible:visible },
		function(data){
	  		if(data)
			{
				 alert(data);
			}
	});	 
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

