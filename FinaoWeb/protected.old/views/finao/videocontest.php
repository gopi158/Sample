<div class="main-container">
<div class="finao-canvas">


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
	  		//alert("Ready....");
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

		//alert(progressBarWidth);
		
		var num = Math.ceil(progressBarWidth); 
		//alert(num);
		if (num % 2 == 0) 
		{
		   
		   $('#video-alert').show();
		}else
		{
			 $('#video-alert').hide();
		}
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
	  		//alert("Submitted");
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
		$('.video_val').val('');
		return false;
    }
}
function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}
function validation()
{
	if($('#getjournalmsg').val() =='')
	{
		$('#getjournalmsg').css('border','red 1px solid'); return false;
	}
	else 
	{
		$('#getjournalmsg').css('border','none'); 
	}
	if($('#file').val() =='')
	{
		$('#file').css('border','red 1px solid'); return false;
	}
	else
	{
		$('#file').css('border','none'); 
		
		sbclick();
	}
}
</script> 

<span class="orange left font-25px padding-10pixels" style="width:100%;"><a href="/careercatapult-hbcu"><img width="80" src="<?php echo $this->cdnurl; ?>/images/careerCatapult.png" class="left"> <span class="left" style="padding-top:20px;"></a> Video Contest</span></span>
<div class="update-finao-box" id="hideimgvideo" style="width: 960px; border:none;">
                	<div class="update-finao-area" style="height:100px;">
                    	
                    </div>
                    
                   
                    <div class="uploaded-media" style="padding-left:0; background:none; width:100%;">
    


<div class="">

 

	<div class="">
		 

        <div class="clear-left"></div>

		<div id="uploadimgvid">

		<script type="text/javascript">

			$('#file').live('change', function(){ $("#hdnimgchange").val(this.value); });

		</script>
		
		 <div style="height:10px;"></div>
		
		
        <div id="rightjournal">
 
			
            <form method="post" action="<?php echo $upload_server; ?>" enctype="multipart/form-data" >

			<input type="hidden" name="uploadtoken" value="<?php echo $upload_token; ?>" />

			<input type="hidden" name="callback" value="<?php echo $callback_url; ?>" />					   

			<div class="padding-10pixels left">
			<span id="errormsgv" style="color:red"></span>	
			<span style=" position:absolute; top:0px;left:0px; ">
			<textarea class="run-textarea"   style="width:944px; height:90px; resize:none;" name="description" id="getjournalmsg" placeholder="What's Your FINAO"><?php if(!empty($journalmsg)){ echo $journalmsg;} ?></textarea></span>
            <div style="width:100%; float:left; padding-bottom:10px;"><input type="file" id="file" name="file" class="upload-btn video_val"  onchange="readURLs(this.value);" onfocus="resetfile('errormsgv','')" style="width:190px;" /></div>

			<div style="width:100%; float:left; padding-bottom:10px;">
            <input type="text" name="title" id="description" value="" placeholder="Enter Caption" maxlength="20" onclick="if(placeholder == 'Enter Caption') placeholder = ''" onblur="if(!placeholder) placeholder='Enter Caption'" class="txtbox left" style="width:944px;" />
            </div>				  

			<input type="hidden" id="hdnimgchange" value="test" />

				
				<input type="submit" value="Upload Video" id="sb" name="sb" class="orange-button" onclick="return  validation();"/>
                
            <!--    <a href="<?php echo Yii::app()->request->urlReferrer;?>" class="orange-button">Cancel</a>-->
                
                <input type="button" onclick="goURl('search');" value="Cancel" class="orange-button" />

			</div>		

			<div class="clear-left"></div>

			<div id="progressbar" style="display:none;"><div></div></div>	

			

			</form>

			</div>
			
			
			 

		</div>
			 

	</div>	
 	

</div>


<script type="text/javascript">

function hidedivs(hideid,showid)
{
	$("#"+hideid).hide();
	$("#"+showid).show();
	$("#errormsg").html("");
	$("#errormsgv").html("");
}

function goURl(page)
{
	
	 
	if(page == 'home')
	{
		//alert(page);
		var rd ='<?php echo Yii::app()->createUrl("/myhome"); ?>';
		window.location=rd;
	}else if(page == 'search')
	{
		var rd ='<?php echo Yii::app()->createUrl("finao/Viewvideohdcu"); ?>';
	                    			 
									 
									window.location=rd;
	}
	else
	{
		//alert(page);
		var rd ='<?php echo Yii::app()->createUrl("finao/Videocontest"); ?>';
		window.location=rd;
	}
}

</script>

                    </div>
                     
                </div>
 
</div>
</div>                