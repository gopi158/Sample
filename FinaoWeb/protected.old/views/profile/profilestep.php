<?php // $edit;exit; ?>
<!-- AJAX Upload script doesn't have any dependencies-->

<!--<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/UploadScripts/jquery.form.js"></script>

-->

<!-- End of ajax upload script -->

<!-- --------------------------------------- DATE PICKER ---------------------------- -->

<script src="<?php echo $this->cdnurl;?>/javascript/datepicker.min.js">{"describedby":"fd-dp-aria-describedby"}</script>

<link href="<?php echo $this->cdnurl;?>/css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/css/responsive.css" type="text/css" media="screen">

<!-- --------------------------------------- DATE PICKER END ---------------------------- -->

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
				
				//alert(this.files)
				var chosen = this.files[0];
				var image = new Image();
				imgwidth = "";
				imgheight = "";
				
				 
				
				if(navigator.appName == 'Microsoft Internet Explorer')
				{
					$("#btnProfileimageForm").show();
					alert("After clicking OK \nPlease click on Upload button to crop your profile image!!!")
					//$("#uploadimag").trigger('click');
				}
				else
					document.ProfileimageForm.submit();
		}	


	});

	/*if(navigator.appName == 'Microsoft Internet Explorer')
	{
		$("#btnProfileimageForm").show();
	}*/


});

function checkwidth()
{
	if(imgwidtharea)
	alert('WIdth is '+ imgwidtharea);
}

/*$(document).ready(function(){
	$("#loadingimg").hide();
	
	$("#file").change(function(){
		
		$("#ProfileimageForm").ajaxForm(function(data){
		
		$("#profile-image").html(data);
  
		}).submit();
	});
	$("#bgfile").change(function(){
		$("#loadingimg").show();
		
		$("#BgimageForm").ajaxForm(function(data){
			setTimeout(function(){ $("#loadingimg").hide(); }, 100);
			$("#bgimagediv").css({'background-image':'url('+data+')'});
  		}).submit();
		
	});
});*/
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



<script type="text/javascript" >

function chkalphanum(){

  var location = $('#UserProfile_user_location').val();

  letters =/^[a-zA-Z0-9]+$/; 

  if(!letters.test(location)){   

     $('#location-msg').show();

  }else{

     $('#location-msg').hide();

  }

}

</script>

<?php if(isset($Imgupload) && $Imgupload != 0) { ?>

<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/css/imgareaselect-default.css" />

<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/crop/jquery.imgareaselect.pack.js"></script>

<?php } ?>

<script type="text/javascript">
// Get Image Crop size.
function getSizes(im,obj)
	{
		
		var x_axis = obj.x1;
		var x2_axis = obj.x2;
		var y_axis = obj.y1;
		var y2_axis = obj.y2;
		var thumb_width = obj.width;
		var thumb_height = obj.height;
		
		var urlvalue = "<?php echo Yii::app()->createUrl('Profile/cropImage');?>";
		var imgurl = '<?php echo "Yii::app()-baseurl"."/images/uploads/profileimages/"; ?>';
		
		if(thumb_width != thumb_height)
		{
			alert("Width and Height of the selected portion must be equal");
			return false;
		}
		
		if(thumb_width > 0)
			{
				if(confirm("Press OK to SAVE image or CANCEL to CONTINUE EDITING!"))
					{
						fileext = ($("#image_name").val()).substr(($("#image_name").val()).lastIndexOf('.')+1);
						$.ajax({
							type:"GET",
							//url:"ajax_image.php?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis,
							url: urlvalue+"?t=ajax&img="+$("#image_name").val()+"&w="+thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis+"&fileext="+fileext,
							cache:false,
							success:function(rsponse)
								{
									<?php if($edit=="1"){?>
									location.href = "<?php echo Yii::app()->createUrl('profile/profilelanding/edit/1'); ?>";
									<?php }else if($edit=="2"){?>
								 	location.href = "<?php echo Yii::app()->createUrl('Finao/MotivationMesg'); ?>";  
									<?php }else{?> 
									
									location.href = "<?php echo Yii::app()->createUrl('profile/profilelanding'); ?>";
									<?php }?>
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
	
function getsizeSave()
{
	
}

var IsimgUpload = "<?php echo $Imgupload; ?>";

$(document).ready(function () {
							
							
	//var screen = $(window);
	//alert(screen.width);
 	if (screen.width < 1024) {
	$("#divimag").hide();
	}
	else 
	{
 	$("#divimag").show();
	
	if($('img#imageid').length)
	{
		$('img#imageid').imgAreaSelect({
        x1: 10, y1: 10, x2: 250, y2: 250,
		/*maxWidth: 420, 
		maxHeight: 420, */
		aspectRatio: '1:1',
        onSelectEnd: getSizes
    	});	
	}
	}						
    
	
	
	if(IsimgUpload != 0)
	{
		$("#divform").hide();
	}

});

$(document).ready(function() {
    $("#zpcode").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
		
});


</script>


<script  type="text/javascript">

/*$(document).ready(function() {

	$("#uploadimag").fancybox({

		'scrolling'		: 'no',
		'titleShow'		: false,
		//parent.$.fancybox.close();
	});	
});*/


// validation code

function validation()
{
  if($('#fname').val()=='Enter First Name' || $('#fname').val()=='')
  {
  	$('#fname').css('border','1px red solid'); return false;
  }
  else 
  {
  	$('#fname').css('border','1px green solid');
  }
  if($('#lname').val()=='Enter Last Name' || $('#lname').val()=='')
  {
  	$('#lname').css('border','1px red solid');return false;
  }
  else 
  {
  	$('#lname').css('border','1px green solid');
  }
}

</script>

<!--<div class="finao-welcome-content">-->

<?php if(isset($userprofile) && $userprofile->profile_bg_image!="")

		{

			$bgsrc=$this->cdnurl."/images/uploads/backgroundimages/".$userprofile->profile_bg_image;

        }

 		else

		{

         	$bgsrc="";

        }?>

<!--<div id="loadingimg"><img src="<?php //echo $this->cdnurl; ?>/images/loading.gif" /></div>-->

<!--<div id="bgimagediv" style="background-image:url(<?php echo $bgsrc;?>); height:430px; width:960px;">-->



		<?php $style = "";
					if($userprofile->profile_image!=""){
					$filename = Yii::app()->basePath."/../images/uploads/profileimages/".$userprofile->profile_image;
					if(file_exists($filename))
					{
						list($sourceWidth,$sourceHeight) = getimagesize($filename);
						if($sourceWidth <= 140 && $sourceHeight <= 140)
							$src=$this->cdnurl."/images/uploads/profileimages/".$userprofile->profile_image;
						else
						{
							$src=$this->cdnurl."/images/uploads/profileimages/".$userprofile->profile_image;
							$style = "width:140px;height:140px";
						}	
					}
					else
						$src=$this->cdnurl."/images/no-image.jpg";			
			        } else	{
			         	$src=$this->cdnurl."/images/no-image.jpg";
			   }?>



<?php if ($Imgupload != 0) { ?>
	
		<?php if($userprofile->temp_profile_image != ""){
				if(file_exists(Yii::app()->basePath."/../images/uploads/temp_profileimages/".$userprofile->temp_profile_image)){
					$src=$this->cdnurl."/images/uploads/temp_profileimages/".$userprofile->temp_profile_image;	
				}
				else	
					$src = $this->cdnurl."/images/no-image.jpg";					
				
	    } else	{
	     	$src=$this->cdnurl."/images/no-image.jpg";
	    }?>
		
	<!-- Crop Page Start-->
<div class="main-container" >
<div id="divimag" >

   <div class="finao-canvas">
   <a class="btn-close" onclick="cropredirect();" ><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>
   <span style="width:100%; float:left;">
   	<span class="my-finao-hdline orange">Crop your Image</span>
    <span class="right">
    
    <a title="Minimum size 140 x 140 pixels" href="javascript:void(0);" onclick="js:$('#file').trigger('click');" class="font-16px orange-link"> Change Profile Picture</a> 
    </span>
   </span>
   <div class="left" style="width:100%;"> 
   <ul style="padding-left:10px;">
   <li class="font-14px padding-10pixels">Select the area of the image by holding the corner and dragging it to your desired area. </li>
   <li class="font-14px padding-10pixels">Click on OK button to save the image or click on Cancel to change the selection.</li>
   <li class="font-14px padding-10pixels">Click on Change Profile Picture to select new image.</li></ul>
   </div>
    
	<img src="<?php echo $src;?>" id="imageid" />
	<input type="hidden" name="image_name" id="image_name" value="<?php echo($userprofile->temp_profile_image)?>" />	
	
	
	<!--<div id="crop_save_div" style="display:none">
	<input type="button" class="orange-button" name="crop_save" value="Save" onclick="Javascript:getsizeSave();"/>
	</div>-->
	</div>
</div>
</div>
<?php }  ?>
<!-- Crop Page End-->

<?php $user = User::model()->findByPk(Yii::app()->session['login']['id']); ?>

<div id="middle-wrapper">
    	<div id="middle-content-area">
        	<div id="middle-container">
    			<div class="user-profile-wrapper">
                    <div class="step-details">
                        <span class="orange font-25px">Welcome <?php echo $user['fname']; ?></span>
                    </div>
                    <div class="clear-left"></div>
                    <div class="welcome-run-text">Do you want to introduce yourself to the FINAO Nation?</div>
                    
                    <div class="step2-content-ipad">
                    	<div class="user-profile-pic">
							 <img width="224" height="224" style="border: solid 3px #d7d7d7;" src="<?php echo $src;?>">
                           <div class="profile-pic-change" onclick="js:$('#file').trigger('click');"><?php if($userprofile->profile_image != "") echo 'Change your profile picture'; else echo 'Click to add your profile picture';?></div>
                        </div>
                        <div class="step2-content-right">
                            <fieldset>
                                <label>First Name: <span class="orange font-10px">(Public)</span></label>
                                <div><input class="txtbox" type="text" id="fname" name="fname" onblur="if(this.value=='')this.value='Enter First Name';" onfocus="if(this.value=='Enter First Name')this.value='';" onChange="$('#hdnfname').val(this.value);" value="<?php if($user->fname!='') echo $user->fname; ?>" /></span></div>
                            </fieldset>
                            <fieldset>
                                <label>Last Name: <span class="orange font-10px">(Public)</span></label>
                                <div><input class="txtbox" type="text" id="lname" name="lname" onblur="if(this.value=='')this.value='Enter Last Name';" onfocus="if(this.value=='Enter Last Name')this.value='';" onChange="$('#hdnlname').val(this.value);" value="<?php echo $user->lname; ?>" /></span></div>
                            </fieldset>
							<?php /*$formFinaoMesg=$this->beginWidget('CActiveForm', array(

						'id'=>'user-profile-form',
				
						//'action'=>$this->cdnurl.'/index.php/profile/saveImage',
				
						'enableClientValidation'=>true,
				
						'enableAjaxValidation'=>false,
				
						'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
				
											/*'clientOptions'=>array(
				
											'validateOnSubmit'=>true)*/
				
						//));*/ ?>
				
					<?php 
				
					//$finduserage = $user;//User::model()->findByPk(Yii::app()->session['login']['id']);
				
					$age = floor( (strtotime(date('Y-m-d')) - strtotime($user->dob)) / 31556926); ?>
                            <fieldset>
                                <label>DOB: <span class="orange font-10px">(Private)</span></label>
                                <div>
                                    <?php 
		if($user->dob){$s=explode('-',$user->dob); ?>
		<select name="date_year" style="width:90px; margin-right:5px;width:90px; margin-right:5px;" class="dropdown date_year" onchange="year_change('<?php echo $s[2];?>','<?php echo $s[1];?>',this.value);"><option value="0">Year</option>		
		<?php $ss=explode('-',date('d-m-Y')); $prev_year=$ss[2]-101;$curnt_year=$ss[2]-13;
		 for($i=$curnt_year;$i>$prev_year;$i--){?>
			<option value="<?php echo $i;?>" <?php if($i==$s['0']) echo 'selected="selected"';?>><?php echo $i;?></option>
		<?php }?>
		</select>
		
		<span class="date_sel">
		<?php  if(date('Y')==$s[0]) $da=date('m');  else $da=12;?>
		<?php $det_mnth=array('','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');?>
		<select class="date_mon dropdown" name="date_mon" style="width:90px; margin-right:5px;" onchange="day_change('<?php echo $s['0'];?>',this.value);">		
			<?php if($s['1']!='00'){ for($i=1;$i<=$da;$i++){?>
			<option value="<?php echo $i;?>" <?php if($i==$s['1']) echo 'selected="selected"';?>><?php echo $det_mnth[$i];?></option>
				<?php } }else {?><option value="0">Month</option>  <?php }?>
		</select></span>
		<span class="date_sel_date">
		<?php if(($s[1]!='00') and ($s[0]!='0000')) $num = cal_days_in_month(CAL_GREGORIAN, $s[1], $s[0]); else $num='0'?>
		<select class="dropdown date_dat" name="date_dat" style="width:90px; margin-right:5px;">
		<?php if($num!='0'){ for($i=1;$i<=$num;$i++){?>
			<option value="<?php echo $i;?>"<?php if($i==$s['2']) echo 'selected="selected"';?> ><?php echo $i;?></option>
				<?php }} else{?><option value="0">Day</option> <?php }?>
		</select></span>
			
	  <?php } ?>
		<span id="dob-error-msgs"></span>
                                </div>
                            </fieldset>
                            <fieldset>
                                <label>ZIP Code: <span class="orange font-10px">(Private)</span></label>
                                <div><input class="txtbox left" type="text" id="zpcode" name="zpcode" onblur="if(this.value=='')this.value='Enter Zipcode';$('#hdnzpcode').val(this.value);" onfocus="if(this.value=='Enter Zipcode')this.value='';" maxlength="5" onkeypress=""  value="<?php echo ($user->zipcode != "0") ? $user->zipcode : "Enter Zipcode"; ?>" /></div>
                            </fieldset>
                            <div style="margin-right:10px;" class="welcome-run-text orange left">Tell us about yourself...</div><span class="orange font-10px left public-text">(Public)</span>
                            <div class="padding-10pixels">
							
							<textarea style="resize:none; height:100px;" class="add-story"></textarea></div>
                            <div class="center">
                                <a class="orange-square" href="#">Save</a> <a class="orange-square" href="#">Cancel</a>
                            </div>
                        </div>
                    </div>  
					
					<div class="my-name">

		<form name="ProfileimageForm"   <?php  if(isset($edit) && $edit== 1){?> action="<?php echo Yii::app()->createUrl('profile/changePic/edit/1'); ?>" <?php }else{?> action="<?php echo Yii::app()->createUrl('profile/changePic'); ?>" <?php }?> method="post" enctype="multipart/form-data">

		 
			<div style="position:absolute; top:-100px; visibility:hidden">
            <input style="cursor:pointer;" type="file" class="file" name="file" id="file" />
            </div>
            <input type="submit" id="btnProfileimageForm" name="btnProfileimageForm" value="Upload" class="orange-button" style="display:none"  />
		</form>
	</div>
					<div class="step2-content">
					 <div class="step2-content-left">
                    	<div class="user-profile-pic">
                            <img width="224" height="224" style="border: solid 3px #d7d7d7;" src="<?php echo $src;?>">
                           <div class="profile-pic-change" onclick="js:$('#file').trigger('click');"><?php if($userprofile->profile_image != "") echo 'Change your profile picture'; else echo 'Click to add your profile picture';?></div>

                        </div>
					  </div>	
                        <div class="step2-content-right">
                            <fieldset>
                                <label>First Name: <span class="orange font-10px">(Public)</span></label>
                                <div><input class="txtbox" style="width:300px;" type="text" id="fname" name="fname" onblur="if(this.value=='')this.value='Enter First Name';" onfocus="if(this.value=='Enter First Name')this.value='';" onChange="$('#hdnfname').val(this.value);" value="<?php if($user->fname!='') echo $user->fname; ?>" /></span></div>
                            </fieldset>
                            <fieldset>
                                <label>Last Name: <span class="orange font-10px">(Public)</span></label>
                                <div><input class="txtbox" style="width:300px;" type="text" id="lname" name="lname" onblur="if(this.value=='')this.value='Enter Last Name';" onfocus="if(this.value=='Enter Last Name')this.value='';" onChange="$('#hdnlname').val(this.value);" value="<?php echo $user->lname; ?>" /></span></div>
                            </fieldset>
							<?php $formFinaoMesg=$this->beginWidget('CActiveForm', array(

						'id'=>'user-profile-form',
				
						//'action'=>$this->cdnurl.'/index.php/profile/saveImage',
				
						'enableClientValidation'=>true,
				
						'enableAjaxValidation'=>false,
				
						'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
				
											'clientOptions'=>array(
				
											'validateOnSubmit'=>true)
				
						)); ?>
				
					<?php 
				
					//$finduserage = $user;//User::model()->findByPk(Yii::app()->session['login']['id']);
				
					$age = floor( (strtotime(date('Y-m-d')) - strtotime($user->dob)) / 31556926); ?>
                            <fieldset>
                                <label>DOB: <span class="orange font-10px">(Private)</span></label>
								<div>
									<?php 
									if($user->dob){$s=explode('-',$user->dob); ?>
									<select name="date_year" style="width:90px; margin-right:5px;" class="dropdown date_year" onchange="year_change('<?php echo $s[2];?>','<?php echo $s[1];?>',this.value);"><option value="0">Year</option>		
									<?php $ss=explode('-',date('d-m-Y')); $prev_year=$ss[2]-101;$curnt_year=$ss[2]-13;
									 for($i=$curnt_year;$i>$prev_year;$i--){?>
										<option value="<?php echo $i;?>" <?php if($i==$s['0']) echo 'selected="selected"';?>><?php echo $i;?></option>
									<?php }?>
									</select>
									
									<span class="date_sel">
									<?php  if(date('Y')==$s[0]) $da=date('m');  else $da=12;?>
									<?php $det_mnth=array('','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');?>
										<select name="date_mon" style="width:113px; margin-right:5px;" class="dropdown date_mon"  onchange="day_change('<?php echo $s['0'];?>',this.value);">		
										<?php if($s['1']!='00'){ for($i=1;$i<=$da;$i++){?>
										<option value="<?php echo $i;?>" <?php if($i==$s['1']) echo 'selected="selected"';?>><?php echo $det_mnth[$i];?></option>
											<?php } }else {?><option value="0">Month</option>  <?php }?>
									</select>
									</span>
									<span class="date_sel_date">
									<?php if(($s[1]!='00') and ($s[0]!='0000')) $num = cal_days_in_month(CAL_GREGORIAN, $s[1], $s[0]); else $num='0'?>
										<select name="date_dat" style="width:90px; margin-right:5px;" class="dropdown date_dat" >
									<?php if($num!='0'){ for($i=1;$i<=$num;$i++){?>
										<option value="<?php echo $i;?>"<?php if($i==$s['2']) echo 'selected="selected"';?> ><?php echo $i;?></option>
											<?php }} else{?><option value="0">Day</option> <?php }?>
									</select>
									</span>			
								  <?php } ?>
								
		<span id="dob-error-msgs"></span>
                                </div>
                            </fieldset>
                            <fieldset>
                                <label>ZIP Code: <span class="orange font-10px">(Private)</span></label>
                                <div><input class="txtbox left" style="width:300px;" type="text" id="zpcode" name="zpcode" onblur="if(this.value=='')this.value='Enter Zipcode';$('#hdnzpcode').val(this.value);" onfocus="if(this.value=='Enter Zipcode')this.value='';" maxlength="5" onkeypress=""  value="<?php echo ($user->zipcode != "0") ? $user->zipcode : "Enter Zipcode"; ?>" /></div>
                            </fieldset>
							
							 <div style="margin-right:10px;" class="welcome-run-text orange left">Tell us about yourself...</div><span class="orange font-10px left public-text">(Public)</span>
                            <div class="padding-10pixels"><?php echo $formFinaoMesg->textArea($userprofile,'mystory'

												,array('class'=>'add-story'

														,'style'=>'width:96%; resize:none; height:100px;'

														)); ?></div>
                            
                            <div class="center">
                            <input type="hidden" name="tileid" value="<?php echo $tileid; ?>"  />
                               <?php if(isset($edit) && $edit== 1){?>	

	<?php echo CHtml::submitButton($userprofile ? 'Save' : 'Save',array('class'=>'orange-square','onclick'=>'return validation();')); ?> 

<!-- <input type="button" name="cancel" class="btn-next-step" value="Cancel"  />-->
<a href="<?php echo Yii::app()->createUrl('/finao/MotivationMesg');?>"><input  class="orange-square"   type="button" value="Cancel" /></a>
	<?php }else{?>
   <?php  $value =''; if($tileid == 77){  $value = 'tile';}else{?> 
   <input type="button" id="skip" onclick="navigate('<?php echo $value; ?>');"  class="orange-square" value="Skip" />
   
   <?php } ?>
	

	<?php echo CHtml::submitButton($userprofile ? 'Save & Proceed' : 'Save & Proceed',array('class'=>'orange-square')); ?> 
 	<?php }?>
    
                            </div>
                            <div style="height:30px;"></div>
                             
                        </div>
                    </div>	
                </div>
                
            </div>
			
			<div class="step2-content-right">


	
		
	<?php echo $formFinaoMesg->hiddenField($userprofile,'user_id',array('class'=>'textbox-regfield','value'=>$userid)); ?>
	<?php echo $formFinaoMesg->hiddenField($userprofile,'dob',array('value'=>$user->dob,'id'=>'hdndob')); ?>
	<?php echo $formFinaoMesg->hiddenField($userprofile,'fname',array('value'=>$user->fname,'id'=>'hdnfname')); ?>
	<?php echo $formFinaoMesg->hiddenField($userprofile,'lname',array('value'=>$user->lname,'id'=>'hdnlname')); ?>
	<?php echo $formFinaoMesg->hiddenField($userprofile,'zpcode',array('value'=>$user->zipcode,'id'=>'hdnzpcode')); ?>
	
	

	<?php $this->endWidget(); ?>
	
	

	</div>

	<div class="clear-left"></div>
	
	<?php if($errormsg == "Imgerror") {?>
	<script type="text/javascript">alert("Minimum size 140 x 140 pixels")</script>
	<!--<span class="red">Please upload the images of width and height greater than 140px!</span>-->
	<?php } ?>
	</div>
        </div>
    </div>



<script type="text/javascript">

function navigate(value)

{
    if(value == 'tile')
	{
		var url = "<?php echo Yii::app()->createUrl('group/Dashboard?groupid=5&frndid=255&share=no&share_value=0');?>";
		
	}else
	{
		var url = "<?php echo Yii::app()->createUrl('/profile/landing');?>";
	}
	

   	window.location = url;

}

function isDate1(input, msg) {


	if(input.value == ""){

		document.getElementById('editdob').className = "register";

		//document.getElementById('dob-error-msg').style.display='none';

		var returnval=false

		return returnval

		exit;

	}

    var validformat=/^\d{2}\-\d{2}\-\d{4}$/ //Basic check for format validity

	var returnval=false

	if (!validformat.test(input.value)){

	//document.getElementById('dob-error-msg').style.display='block';

	document.getElementById('editdob').className = "register error";

	}

	else{ //Detailed check for valid date ranges

	var monthfield=input.value.split("-")[0]

	var dayfield=input.value.split("-")[1]

	var yearfield=input.value.split("-")[2]

	var dayobj = new Date(yearfield, monthfield-1, dayfield)

	var today = dayobj;

	//alert("first");

	if(monthfield > 12 || dayfield >31)

	{

		//document.getElementById('dob-error-msg').style.display='block';

		document.getElementById('editdob').className = "register error";

		exit;

	}

	//alert("date");

	var hi = $.datepicker.formatDate('dd-MM-yy',today);

	//var hi = dojo.date.locale.format(today, {selector:"date", datePattern:"d-M-Y" });

	document.getElementById('editdob').value = hi;

	if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))

	document.getElementById('dob-error-msg').style.display='';

	//document.getElementById('fbdob').className = "register error";

	else

	returnval=true

	document.getElementById('editdob').className = "register";

	//document.getElementById('dob-error-msg').style.display='none';

	}

	if (returnval==false) input.select()

	

	return returnval

	

}

</script>
<script>
	//  date month generating
	
		function year_change(day,mnth,year)
	{
		//$('#date_sel').html();
		 var newdata = new Date();
		 var highdate = new Date(newdata.getFullYear(),newdata.getMonth()+1,newdata.getDate());
		 var highdatevalue = highdate.getFullYear();
		 var month=highdate.getMonth();
		 var date=highdate.getDate();
		if($('.date_mon').val()=='' || $('.date_mon').val()=='0')  var select_month='0'; else  var select_month=$('.date_mon').val(); 
		if(year!=0)
		{		
			$('.date_sel').html('<select class="dropdown date_mon" name="date_mon" style="width:90px; margin-right:5px;"  onchange="day_change('+year+',this.value);"><option value="0">Month</option></select>');
			if(highdatevalue>=year)
			 {
				var t='';
				var det_mnth=['','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
				if(highdatevalue!=year){for(var i=1; i<=12; i++)  t+='<option value='+i+' >'+det_mnth[i]+'</option>'; }
				else { for(var i=1; i<=month; i++) t+='<option value='+i+' >'+det_mnth[i]+'</option>';}
				$('.date_mon').append(t);//alert(select_month);
				$('.date_mon').children('option:eq('+select_month+')').attr('selected', 'selected');				
			 }
			 day_change(year,select_month);
			// $('#date_sel_date').html('<select class="dropdown" class="date_dat" ><option value="0">Day</option></select>');
		}
		else
		{
			$('.date_sel').html('<select class="dropdown date_mon" name="date_mon" style="width:90px; margin-right:5px;" class="dropdown"><option value="0">Month</option></select>');
			$('.date_sel_date').html('<select style="width:90px; margin-right:5px;" name="date_dat" class="dropdown date_dat" ><option value="0">Date</option></select>');
		}	 
		getAge();
	}
	
	function day_change(year,month)
	{
		var d = new Date(year, month, 0);
		 var newdatas = new Date();
		 var highdates = new Date(newdata.getFullYear(),newdata.getMonth()+1,newdata.getDate());
		 var highdatevalues= highdates.getFullYear();
		 var months=highdates.getMonth();
		  var dates=highdates.getDate();
		   if($('.date_dat').val()=='' || $('.date_dat').val()=='0')  var select_date='0'; else  var select_date=$('.date_dat').val()-1; 
		// alert(d.getDate());
		if(month!=0)
		{
			 $('.date_sel_date').html('<select style="width:90px; margin-right:5px;" class="dropdown date_dat" name="date_dat"  onchange="getAge();"></select>');
			 var t='';
			 if((highdatevalues==year) && (months==month)){for(var i=1; i<dates; i++) t+='<option value='+i+'>'+i+'</option>';}
			 else {for(var i=1; i<=d.getDate(); i++) t+='<option value='+i+'>'+i+'</option>'; }
				$('.date_dat').append(t);
				$('.date_dat').children('option:eq('+select_date+')').attr('selected', 'selected');				
		}
		else
		{
			 $('.date_sel_date').html('<select style="width:90px; margin-right:5px;" class="date_dat dropdown" name="date_dat" ><option value="0">Date</option></select>');
		}
		getAge();		
	}
	
function getAge()
{
	var birthDay=$('#date_dat').val();
    var birthMonth=$('#date_mon').val();
    var birthYear=$('#date_year').val();	
	 var todayDate = new Date();
	 var todayYear = todayDate.getFullYear();
	  var todayMonth = todayDate.getMonth();
	  var todayDay = todayDate.getDate();
	  var age = todayYear - birthYear;
	
	  if (todayMonth < birthMonth - 1)
	  {
		age--;
	  }
	
	  if (birthMonth - 1 == todayMonth && todayDay < birthDay)
	  {
		age--;
	  }
	/*var date=$('#date_dat').val();
    var month=$('#date_mon').val();
    var year=$('#date_year').val();
	
   var birth = new Date(date+'/'+month+'/'+year);var check = new Date();
 //  alert(birth); alert(check);
	var milliDay = 1000 * 60 * 60 * 24; // a day in milliseconds;	
	var ageInDays = (check - birth) / milliDay;	
	var ageInYears =  Math.floor(ageInDays / 365 );
	//alert(ageInYears);*/
	
	if(age<13) { $('.dropdown').css('border','1px red solid'); $('#dob-error-msgs').html('Sorry, Your Age Is Less than 13'); return false;}
	else { $('.dropdown').css('border',''); $('#dob-error-msgs').html('');}
}

	
	 
	 var newdata = new Date();
	 var highdate = new Date(newdata.getFullYear(),newdata.getMonth()+1,newdata.getDate());
	    
	 var highdatevalue = highdate.getFullYear() + "" ; 
	     highdatevalue += (highdate.getMonth() <= 9) ? "0"+highdate.getMonth() : highdate.getMonth() +"" ;
		 highdatevalue +=  highdate.getDate();	
		 
 		//alert(highdatevalue); 
		// Create the first datepicker
		datePickerController.createDatePicker({ 
		    // Associate the text input (with an id of "demo-1") with a DD/MM/YYYY date
		    // format
		    formElements:{"fbdob":"%d-%M-%Y"},
			statusFormat:"%l, %d%S %F %Y",
			 rangeHigh: highdatevalue
		    }); 
    </script>