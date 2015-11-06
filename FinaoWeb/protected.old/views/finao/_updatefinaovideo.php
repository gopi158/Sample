 
<style>
	#progressbar {
		background: #292929;
		border: 1px solid #111;	
		border-radius: 5px;	
		overflow: hidden;
		box-shadow: 0 0 5px #333;	
	}
		#progressbar div {
		background-color: #1a82f7;
		background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0099FF), to(#1a82f7));
		background: -webkit-linear-gradient(top, #0099FF, #1a82f7);
		background: -moz-linear-gradient(top, #0099FF, #1a82f7);
		background: -ms-linear-gradient(top, #0099FF, #1a82f7);
		background: -o-linear-gradient(top, #0099FF, #1a82f7);
	}

</style>

<script type="text/javascript">
      var endpoint  = '<?=$upload_server?>';
      var token     = '<?=$upload_token?>';
      var timer = -1;
      var progress = 0;
	  function getprogressval()
	  {
	  		urlinfo = "<?php echo Yii::app()->createUrl('finao/uploadProgress'); ?>" + "/token/" +token ; 
			$.ajax({
	          url: urlinfo,
			  type: "POST",
	          success: function(res)
	           {
			  		var inputdata = res;
					var inputres;
					if(res.indexOf('^^'))
					{
						inputdata = res.split('^^');
						$.each(inputdata, function(key, value)
						{
							if(value.indexOf('$$'))
							{
						

								inputres = value.split('$$');

								if(inputres[0] == "percent")

								{	progress = inputres[1];	}

								if(inputres[0] == "status")

									status = inputres[1];

							}

						});  

					}

				 progressBar(progress,"#progressbar")	

			   }

			});  	

	  }

	  

	  function progressBar(percent, $element) {

		var progressBarWidth = percent * $("#progressbar").width() / 100;

		$("#progressbar").find('div').animate({ width: progressBarWidth }, 500).html(percent + "%&nbsp;");

	 	}
	  function aClick()
	  {
			//$('input[type=file]').trigger('click');
	  }
	  function fileonChange()
	  {
	  		//$("#sb").trigger('click');
	  }	
      /**
      Fire off an event to call the checkProgress() method every second when
      the user submits the form for upload.
      **/
	  function sbclick()
	  {
	  		if($("#hdnimgchange").val() != "")
			{
				$("#progressbar").show();	
			    timer = setInterval(function()
	        	{
		        	 //Progress less than 100, call again
		        	 //Otherwise clear the interval
		        	 if (progress < 100) {
		        	   getprogressval(); //checkProgress();
		        	 }
	        	}, 3000); 
			}
			else
				return false;
	  }
 //hide add image inserting
 function close_type(a)
 {
 	$('#imgvid'+a).hide();	
 }
function readURLs(filename)
{
	var ext = getExtension(filename);
    switch (ext.toLowerCase())
	{
		case 'pdf':
		case 'doc':
		case 'rar':
		case 'zip':
		case 'xlsx':
		case 'docx':
		case 'ai':
		case 'jpg':
		case 'gif':
		case 'bmp':
		case 'png':
		case 'xml':
		case 'php':
		case 'txt':
		case 'docs':		
		alert('invalid File Format');
		$('.video_vals').val('');
		return false;
    }
}
function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}	        

    </script> 
 
                	 
                    
                     
                    <div class="uploaded-media"  style=" margin-top:5px;">
                    	 <!--newfinaovideo.php-->



<?php

	$style = '';
	if($sourcetype == 'journal')
	{
		if(isset($uploadedimages) && count($uploadedimages) >= 1)
			$style = 'style="width:100%;display:none;"'	;
	}

?>




<div class="">

<?php /*?><div id="closefinaodiv" >

		<a class="btn-close" href="<?php echo Yii::app()->createUrl('finao/motivationmesg'); ?>"><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>

	</div><?php */?>

	<div class="">
		<!--<div class="journal-log">&nbsp;</div>-->
    	<!--<div class="my-finao-hdline orange">My FINAO</div>-->

        <div class="clear-left"></div>

		<div id="uploadimgvid"  <?php if($style != "") { echo $style; } ?>>

		<script type="text/javascript">

			$('#file').live('change', function(){ $("#hdnimgchange").val(this.value); });

		</script>
		
		<table cellspacing="0" cellpadding="5" width="100%">
		<tr>
		<td width="2%">
			<input type="radio" name="rduploadvideo" value="videoupload" checked="checked" onclick="js:hidedivs('video_embcode','rightjournal')" />
		</td><td class="orange font-14px" width="28%">	
			Upload <?php echo ucfirst($sourcetype); ?> Video
		</td><td width="2%">
			<input type="radio" name="rduploadvideo" value="videoembedurl" onclick="js:hidedivs('rightjournal','video_embcode')"/>  </td><td class="orange font-14x" width="68%">
			Paste Youtube URL to embed video for <?php echo ucfirst($sourcetype); ?>
		</td>	
		</tr>	
		</table>
		
		<div id="rightjournal">

			<form method="post" action="<?php echo $upload_server; ?>" enctype="multipart/form-data" >

			<input type="hidden" name="uploadtoken" value="<?php echo $upload_token; ?>" />

			<input type="hidden" name="callback" value="<?php echo $callback_url; ?>" />					   

			<div class="padding-10pixels left">
			<span id="errormsgv" style="color:red"></span>	
			 
            <input type="file" id="file" name="file" class="upload-btn video_vals"  onchange="readURLs(this.value);"  onfocus="resetfile('errormsgv','')" />	
			</div>			    

				<div class="padding-10pixels left">
				<input type="text" name="title" id="description" value="Add Caption" onclick="if(value == 'Add Caption') value = ''" onblur="if(!value) value='Add Caption'" class="txtbox left" style="width:170px" maxlength="60" />					  

			<input type="hidden" id="hdnimgchange" value="" />

				
				<input type="submit" value="Upload" id="sb" style="margin-right:3px" name="sb" class="orange-button left" style="cursor:pointer;" onclick="if($('#hdnimgchange').val() != '' ){sbclick();}else { if(validatesubmit('hdnimgchange','errormsgv','Please select a file to Upload','','') == '1') {return false;}} "/>
				
			<span class="left" style=""><input type="button" value="Cancel" style="float:left" class="orange-button" onclick="close_type(<?php echo $_POST['uploadedid'];?>);" /></span>

			</div>		

			<div class="clear-left"></div>

			<div id="progressbar" style="display:none;"><div></div></div>	

			

			</form>

			</div>
			
			
			<div id="video_embcode" class="upload-image" style="display:none; padding-top:0; padding-bottom:0; padding-left:0;">
				
			<form method="post" action="" id="youtubevideoform" enctype="multipart/form-data" >

			<div class="padding-10pixels left">
				<span id="errormsg" style="color:red"></span>	
				
                
                <input type="text" name="txtVidembedUrl" id="txtVidembedUrl" class="txtbox-caption" style="width:150px" value="Add Video URL" onclick="if(value == 'Add Video URL') value = ''; if($('#txtVidembedUrl').hasClass('txtbox-caption-error')) $('#txtVidembedUrl').addClass('txtbox-caption').removeClass('txtbox-caption-error'); $('#errormsg').html('');" onblur="if(this.value == ''){ this.value='Add Video URL'; }else { allowonlyYoutube(this.id,'errormsg','videopage'); }  " />
				
				<input type="text" name="vdurldescription" id="vdurldescription" value="Add Caption" onclick="if(value == 'Add Caption') value = ''; " onblur="if(this.value == '') { this.value='Add Caption'; } " class="txtbox-caption" style="width:150px" maxlength="60" />	
				</div>				   
<div class="padding-10pixels left">
				<input type="button" value="Save" style="margin-right:3px;" id="sburl" name="sburl" class="orange-button left" style="cursor:pointer;" onclick="if($('#txtVidembedUrl').val() != 'Add Video URL' ){ savevideoembUrlactivity(<?php echo $uploadedid ?>,<?php echo $finaoid ?>); }else{ if(validatesubmit('txtVidembedUrl','errormsg','Please enter an url to Save','txtVidembedUrl','Add Video URL') == '1') {return false;} };"/>
	
			<input type="button" onclick="close_type(<?php echo $_POST['uploadedid'];?>);" value="Cancel" class="orange-button" />
             <!--<a onclick="$('#hideimgvideo').show();$('#imgvidupload').hide();" value="cancel" class="orange-square font-16px" href="javascript:void(0);">Cancel</a>-->
                
            </div>		

			<div class="clear-left"></div>

			</form>
			
			
			</div>

		</div>
			<?php /*?><div id="manageImg"> 

	

       <?php $this->renderPartial('_displaydetails',array('uploadedimages'=>$uploadedimages

														,'IsImag'=>2

														,'userid'=>$userid

														//,'sourcetype'=>$sourcetype

													));

		?>

			</div><?php */?>

	</div>	

	<?php /*?><div class="finao-canvas-right">

		<?php if(!($userid == Yii::app()->session['login']['id'])) { ?>

			<input type="hidden" id="frndtileid" value=""/>

			<input type="hidden" value="" id="userfrndid"/>

			<div id="trackingstatus" style="float:right;">

			</div>

			<div class="clear-right"></div>

		<?php } ?>

		<?php $this->renderPartial('_newsinglefinao',array('finaoinfo'=>$finaoinfo

																	,'status'=>$status,'userid'=>$userid

																	,'getimages'=>$uploadedimages,'share'=>$share

																	,'tileid'=>$tileid,'completed'=>$completed

																	,'page'=>$page

																	,'hidebtn'=>'video'
																	,'count'=>$count
																	)); ?>

	</div><?php */?>	

		

</div>


<script type="text/javascript">

function hidedivs(hideid,showid)
{
	$("#"+hideid).hide();
	$("#"+showid).show();
	$("#errormsg").html("");
	$("#errormsgv").html("");
}

</script>

                    </div>
                    <!--<span style="position:absolute; right:5px; bottom:70px;"><a href="#" class="orange-square font-16px">Update</a></span>-->
         