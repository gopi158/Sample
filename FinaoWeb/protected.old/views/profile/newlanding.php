<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>
<script  type="text/javascript">

$(document).ready(function() {
	$("#video-link").fancybox({
				'scrolling'		: 'no',
				'titleShow'		: false,
				
			});
	$("#image-link").fancybox({
				'scrolling'		: 'no',
				'titleShow'		: false,
				onStart: function(){
					//alert('hi');
					//showfeatureImgVid('Image','');
				}
			});		
	});	
	
</script>

<div class="main-container" >
<div id="divdisplaydata" style="height:450px; display:none">
<div style="top:0px;display:none" class="tiles-container">
                <!--<div class="create-finao-wrapper">
                	<div class="create-finao-wrapper-left">
                    	<div class="font-18px orange padding-10pixels">Upload FINAO Image</div>
                        <div><input type="file" style="width:180px;" class="left"> <input type="text" style="width:140px;" value="Enter Caption" class="txtbox left"> <input type="button" class="orange-button" value="Upload"></div>
                    </div>
                	<div class="create-finao-wrapper-right">
                    	<div class="transperant-layer"></div>
                    	<div class="padding-5pixels"><textarea style="width:506px; resize:none; height:60px;" class="finaos-area">Enter FINAO</textarea></div>
                        <div class="font-18px orange bolder padding-5pixels">Select Tile</div>
                        <div class="finao-tile-container">
                        	<div class="create-tile">
                                Create<br> New Tile                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/basketball.jpg"></a>
                                <span class="tile-image-caption font-12px">Baseball</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/causes.jpg"></a>
                                <span class="tile-image-caption font-12px">Causes</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/careers.jpg"></a>
                                <span class="tile-image-caption font-12px">Careers</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/basketball.jpg"></a>
                                <span class="tile-image-caption font-12px">Baseball</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/causes.jpg"></a>
                                <span class="tile-image-caption font-12px">Causes</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/careers.jpg"></a>
                                <span class="tile-image-caption font-12px">Careers</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/basketball.jpg"></a>
                                <span class="tile-image-caption font-12px">Baseball</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/causes.jpg"></a>
                                <span class="tile-image-caption font-12px">Causes</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/careers.jpg"></a>
                                <span class="tile-image-caption font-12px">Careers</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/basketball.jpg"></a>
                                <span class="tile-image-caption font-12px">Baseball</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/causes.jpg"></a>
                                <span class="tile-image-caption font-12px">Causes</span>                            </div>
                            <div class="tile-holder smooth">
                                <a href="#"><img width="96" height="70" src="images/tiles/careers.jpg"></a>
                                <span class="tile-image-caption font-12px">Careers</span>                            </div>
                        </div>
                        <div>
                        	<span class="left font-14px"><input type="checkbox"> Make Public?</span>
                            <span class="right">
                            	<a class="grey-square" href="#">Create FINAO</a>
                                <a class="grey-square" href="#">Cancel</a>                            </span>                        </div>
                    </div>
              </div>-->
            </div>
</div>
<div style="clear:both"></div>
		
    	<div class="finao-canvas">
        	<div class="step-details">

            	<span class="my-finao-hdline orange padding-5pixels" style="font-family: 'Amaranth', sans-serif;">Welcome <?php echo ucfirst($user->fname);?></span>

            </div>

             <div class="clear-left"></div>

            <div class="welcome-run-text"><span style="font-family:'Open Sans', sans-serif; font-weight:bold;">FINAO<font>&reg;</font></span> empowers you to share aspirations that align with your passions and capabilities, not those expected of you by society. We call these statements of commitment &quot;<span style="font-family:'Open Sans', sans-serif; font-weight:bold;">FINAO<font>&reg;</font></span>s&quot; (fin-nay-o), which stand for <br />&quot;<span class="orange">F</span>AILURE <span class="orange">I</span>S <span class="orange">N</span>OT <span class="orange">A</span>N <span class="orange">O</span>PTION.&quot; </div>
            <div class="welcome-run-text">We know everyone operates differently, so there are many unique and engaging ways for you to live your <span style="font-family:'Open Sans', sans-serif; font-weight:bold;">FINAO<font>&reg;</font></span>. These include sharing pictures or video through an online community of supporters, a mobile phone app, and our innovative FlipWear<font>&reg;</font> line of casual apparel where you can wear your <span style="font-family:'Open Sans', sans-serif; font-weight:bold;">FINAO<font>&reg;</font></span> and reveal it if you wish.</div>

            <!--<div class="center padding-10pixels"><img src="images/dashboard/addfinao.jpg" /></div>-->

            <div class="caption-bar" style="font-family: 'Amaranth', sans-serif;">Creating a FINAO<font>&reg;</font> just takes  a minute. Your legacy lasts forever.</div>

			  <div class="center">
			 <?php /*?> <a href="<?php echo Yii::app()->createUrl('profile/Newfinao'); ?>" class="btn-next-step">Create a FINAO</a> <a href="<?php echo Yii::app()->createUrl('finao/MotivationMesg'); ?>" class="btn-next-step">My Home Page</a><?php */?>
			<!-- <a href="javascript:void(0)" onclick="createfinao();" class="btn-next-step">-->
			  <a href="<?php echo Yii::app()->createUrl('finao/motivationMesg',array('create'=>'finao')); ?>" class="btn-next-step">Create a FINAO</a> <a href="<?php echo Yii::app()->createUrl('finao/MotivationMesg'); ?>" class="btn-next-step">My Home Page</a>
			  
			  </div>

            <div class="font-15px orange padding-10pixels">Featured </div>

            <div class="profile-pics">

            	<div class="profile-pics-left">

                	<p><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/115'); ?>"><img src="<?php echo $this->cdnurl; ?>/images/dashboard/01.jpg" width="140" class="left image-border" style="margin-right:10px;" /></a> <span>Define who you are to yourself and the world around you.<br /> <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/115'); ?>" class="orange-link font-12px right" style="margin-right:10px;">View Profile</a></span></p>

                </div>

                <div class="profile-pics-right">

                	<p><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/100'); ?>"><img src="<?php echo $this->cdnurl; ?>/images/dashboard/03.jpg" width="140" class="left image-border" style="margin-right:10px;" /></a> <span>Where your words and actions speak volumes together.<br /> <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/100'); ?>" class="orange-link font-12px right" style="margin-right:10px;">View Profile</a></span></p>

                </div>

                <div class="profile-pics-left">

                	<p><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/101'); ?>"><img src="<?php echo $this->cdnurl; ?>/images/dashboard/02.jpg" width="140" class="left image-border" style="margin-right:10px;" /></a> <span>Show your strengths without showing off.<br /> <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/101'); ?>" class="orange-link font-12px right" style="margin-right:10px;">View Profile</a></span></p>

                </div>
                
                <div class="profile-pics-right">

                	<p><a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/265'); ?>"><img src="<?php echo $this->cdnurl; ?>/images/dashboard/05.jpg" width="140" class="left image-border" style="margin-right:10px;" /></a> <span>The people, who are crazy enough to think they can change the world, are the ones who do.<br /> <a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/265'); ?>" class="orange-link font-12px right" style="margin-right:10px;">View Profile</a></span></p>

                </div>

            </div>

            

            <!--<div class="caption-bar">and choose what you want to share when you want to share it.</div>-->

            <div class="slide2-bottom-tabs">

            	<div class="slide2-bottom-left">
					<div ><a class="orange-link font-16px left padding-5pixels" onclick="clickvideo();" href="javascript:void(0)"> Browse more Featured Videos</a></div>
					<div class="clear"></div>
                	<a id="video-link" <?php if(isset($uploadVideo) && ($uploadVideo != "") && count($uploadVideo) >= 1 ){ ?> href="#browseVideo" <?php }else{ ?> href="javascript:void(0)" <?php } ?> >
						<!--<img src="<?php echo $this->cdnurl; ?>/images/dashboard/slide2_image1.jpg" width="308" />-->
						<?php if(isset($videoembedurl) && $videoembedurl) 
									echo $videoembedurl;	?>	
					</a>

                    

                </div>

                <!--<div class="slide2-bottom-middle">

                	<a href="#">
						<img src="<?php echo $this->cdnurl; ?>/images/dashboard/slide2_image2.jpg" width="308" />
					</a>

                    <div class="slide2-bottom-caption">find people</div>

                </div>-->

                <div class="slide2-bottom-right" >
					<div ><a class="orange-link font-16px left padding-5pixels" onclick="clickimage();" href="javascript:void(0)">Browse more Featured Images</a></div>
					<div class="clear"></div>
                	<div  style="height:330px;overflow:hidden">
					<a id="image-link" <?php if(isset($uploadImages) && ($uploadImages != "") && count($uploadImages) >= 1 ){  ?>   href="#browseImg" <?php }else{ ?> href="javascript:void(0)" <?php } ?> >
					<?php $imgcaption = ""; 							
						if(isset($uploadImages) && ($uploadImages != "") && count($uploadImages) >= 1 ) 
						{
						
						foreach($uploadImages as $upldimg)
						{
							$filename = $upldimg->uploadfile_path."/".$upldimg->uploadfile_name;
							
							if(file_exists(Yii::app()->basePath."/../".$filename))
							{
							?>
							   <img src="<?php echo Yii::app()->baseUrl.$filename; ?>" width="410" />
					<?php	}
							else
							{ ?>
								<img src="<?php echo $this->cdnurl; ?>/images/dashboard/browseimages.jpg" width="410" />
				<?php		}	
							
						}
					}
					else
					{  ?>
						<img src="<?php echo $this->cdnurl; ?>/images/dashboard/browseimages.jpg" width="308" />
			<?php	}
					?>	
					</a>

                    </div>

                </div>

            </div>

            

          <?php /*?>  <div class="center"><a href="<?php echo Yii::app()->createUrl('profile/Newfinao'); ?>" class="btn-next-step">Create a FINAO</a> <a href="<?php echo Yii::app()->createUrl('finao/MotivationMesg'); ?>" class="btn-next-step">My Home Page</a></div><?php */?>

            

            <!--<div>

            	<span class="left">

                	<p><img src="images/dashboard/finaoSnapshot.png" width="540" /></p>

                    <p><img src="images/dashboard/video.jpg" width="525" /></p>

                </span>

                <span class="right"><img src="images/dashboard/slide2_img4.jpg" width="400" height="590" /></span>

            </div>-->

            

        </div>

    </div>
	
	<div style="display:none;">
		<div id="browseVideo" class="browse-popupbox">
			<div id="divbrowseVideo">
				<?php /*if(isset($videoembedurl) && $videoembedurl) 
									echo $videoembedurl;*/	
					 $this->renderPartial('_browserImagVideo',array('videoembedurl'=>$videoembedurl
													,'uploadtype'=>'Video'
													,'upPageNav'=>$upviddet
													,'caption'=>$vidcaption
													,'targetdiv'=>'divbrowseVideo'
													,'userinfo'=>$userimg
													));				
									?>	
									
			</div>
		</div>
	</div>
	
	<div style="display:none;">
		<div id="browseImg" class="browse-popupbox">
			<div id="divbrowseImg">
				
				<?php if(isset($uploadImages) && ($uploadImages != "") && count($uploadImages) >= 1 ) 
					{
						foreach($uploadImages as $upldimg)
						{
							$filename = $upldimg->uploadfile_path."/".$upldimg->uploadfile_name;
							
							if(file_exists(Yii::app()->basePath."/../".$filename)){ 
								$videoembedurl = Yii::app()->baseUrl.$filename;
							}
							else{ 
								$videoembedurl = Yii::app()->baseUrl."/images/dashboard/browseimages.jpg"; 
							}
							$imgcaption = $upldimg->caption;	
						}
					}
					else{ 
						$videoembedurl = Yii::app()->baseUrl."/images/dashboard/browseimages.jpg";
						
					}
				
				
					$this->renderPartial('_browserImagVideo',array('videoembedurl'=>$videoembedurl
													,'uploadtype'=>'Image'
													,'upPageNav'=>$upimgdet
													,'caption'=>$imgcaption
													,'targetdiv'=>'divbrowseImg'
													,'userinfo'=>$uservid
													));		?>		
				
			</div>
		</div>
	</div>
	
<script type="text/javascript">
	
	/** --- fun to intial light window -- **/
	function showfeatureImgVid(imgvid,pageid)
	{
		imgvid = imgvid;
		pagid = 1;
		if(pageid != '')
			pagid = pageid;
		
		var url='<?php echo Yii::app()->createUrl("/profile/BrowseVideoImage"); ?>';
		
		$.post(url, { imgvid :  imgvid , pageid : pagid },
	   		function(data){
				if(data != "")
				{
					$("divbrowseImgVideo1").html("");
					$("divbrowseImgVideo1").html(data);	
					/*if(imgvid == 'Video'){
						triggerclick();//$("#video-link").trigger('click');
					}*/
					/*if(imgvid == 'Image'){
						triggerImgclick();
					}*/
				}
	     });
	}
	
		
	function shownextpreImgVid(pageid,imgvid,targetdivid)
	{
		var url='<?php echo Yii::app()->createUrl("/profile/BrowseVideoImage"); ?>';
		
		$.post(url, { imgvid :  imgvid , pageid : pageid, targetdiv: targetdivid },
	   		function(data){
				if(data != "")
				{
					$("#"+targetdivid).html("");
					$("#"+targetdivid).html(data);	
				}
	     });
	}
	
	function clickvideo()
	{
		$("#video-link").trigger('click');
	}
	
	function clickimage()
	{
		$("#image-link").trigger('click');
	}
</script>	
 <script type="text/javascript">
 function createfinao()
 {      var userid=""; var url ="";
		var userid =  <?php echo  Yii::app()->session['login']['id']?>;
		if(userid!='')
		{
			var url = '<?php echo Yii::app()->createUrl("finao/addNewFinao");?>';
			$.post(url, { userid : userid},
			function(data){
			if(data)
			{   
				hidealldivs();
				$("#allinfo").show();
				$("#divdisplaydata").html("");
				$("#divdisplaydata").html(data);
				$("#divdisplaydata").show();
				$('.finao-canvas').hide();
				$('#cancel_explore').attr('onClick','close_explore()');
			}
			});
		}
		else 
		{
			alert('Please Login');
		}	
 }
 
function close_explore()
{
	$('.finao-canvas').show();$("#divdisplaydata").hide();
} 
 </script>      
 
 
            
<script type="text/javascript">

$(document).ready(function(){
	$('#finaomesg').blur(function()
	{
		 
		var msg  = $(this).val()
		if(msg != "" && msg == "What's Your FINAO?"  )
		{
			
		}
	});
	
	});
</script>  

<script type="text/javascript">

$( document ).ready( function(){
	
	
	/**************************************************************
	* This script is brought to you by Vasplus Programming Blog
	* Website: www.vasplus.info
	* Email: info@vasplus.info
	****************************************************************/

	$('#vasPhoto_uploads').live('change', function() 
	{
	$('#noimage').hide();
	$("#vasPLUS_Programming_Blog_Form").vPB({
	url: '<?php echo Yii::app()->createUrl("/finao/finaopreupload"); ?>',
	beforeSubmit: function() 
	{
	 
	$("#vasPhoto_uploads_Status").show();
	$("#vasPhoto_uploads_Status").html('');
	$("#vasPhoto_uploads_Status").html('<div style="width:370px; height:135px; padding:120px 20px 10px 20px; text-align:center; border:5px solid #E2E2E2;  -moz-box-shadow: 0 0 5px #888; -webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888;"><img src="<?php  echo Yii::app()->baseUrl; ?>/images/bx_loader.gif" align="absmiddle" alt="Upload...." title="Upload...."/></div>');
	},
	success: function(response) 
	{
	 
	$("#vasPhoto_uploads_Status").hide().fadeIn('slow').html(response);
	}
	}).submit();
	});
	/**************************************************************
	* This script Ends
	****************************************************************/
	
	/*$(document).bind("contextmenu",function(e){
    return false;
	});*/
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
 

function submitfinao(userid,redirecttype,type)
{
	var finaomesg = document.getElementById('finaomesg').value;
	if(finaomesg == '')
	{
		$('#finaomesg').css({'border':'2px solid #F00'});
		$('#finaomesg').attr('value','Enter your FINAO and select Tile to proceed') 
		return false;
	}
	var tileid = document.getElementById('tileid').value;
	var tilename = document.getElementById('tilename').value;
	var ispublic = document.getElementById("ispublic").checked;
	var filename =   $('#filename').attr('src');
	var caption  = document.getElementById('caption').value; 
	//var filename = sourcefilename.split("/");
	
 
	if(tileid > 0 && tilename == "" )
		tileid = "";
	//alert(ispublic);
	if(finaomesg.length > 1 && tileid.length >= 1)
	{
		 
		var url='<?php echo Yii::app()->createUrl("/finao/addFinao"); ?>';
		$.post(url, { userid : userid , tileid : tileid , finaomesg : finaomesg , tilename : tilename , ispublic : ispublic,filename:filename,caption:caption},
	   		function(data){
				if(data)
				{
				 
					refreshmenucount(userid);
					getfinaos(userid,data);
					view_single_finao(userid,finaoid);
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
	 $(".holder-active").addClass("holder smooth").removeClass("holder-active");
	$("#"+id).addClass("holder-active");		
}
function removeclass()
{
	document.getElementById('finaomesg').className = "finaos-area";
}



$(document).ready(function(){ });

function showtileform(finaoid,userid,pagetype)
{
	//alert(pagetype);
	var finaomesg = document.getElementById('finaomesg').value;
	if(finaomesg == '')
	{
		$('#finaomesg').css({'border':'2px solid #F00'});
		$('#finaomesg').attr('value','Enter your FINAO to activate Tiles') 
		$("#addanotherfinao").show();
		return false;
	}
	
	$("#oldtiles").hide();
    var filename =   $('#filename').attr('src');
	/*alert(finaoid);
	alert(filename);*/
	//$('#filenamesrc').attr('value',filename);
	//var caption  = document.getElementById('caption').value; 
	var url='<?php echo Yii::app()->createUrl("/finao/newTile"); ?>';
		$.post(url, { userid :  userid , finaoid : finaoid ,pagetype : pagetype ,filename:filename},
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
	$('.grey-square').hide();
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
							//refreshwidget(userid);
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
function putseltile(usertileid)
{
	//document.getElementById('usertileid').value = usertileid;
	if($("#usertileid").length)
		$("#usertileid").val(usertileid);
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
  
function closefrommenu(page)
{
	if(page=="main")
	{
		hidealldivs();
		$("#allinfo").show();
		$("#divdisplaydata").hide();
	}
	else
	{
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
 
function refreshmenucount(userid)
{
	selectedmenu = $(".active-category").attr("rel");
	
	
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

$(".fixed-imagea-area").click(function () {
$('#vasPhoto_uploads').trigger('click');

});
</script>        