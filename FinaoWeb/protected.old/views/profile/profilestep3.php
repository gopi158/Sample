<!-- AJAX Upload script doesn't have any dependencies-->
<script type="text/javascript" src="<?php echo Yii::app()->baseurl; ?>/javascript/UploadScripts/jquery.form.js"></script>
<!-- End of ajax upload script -->
<script type="text/javascript" >
$(document).ready(function(){
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
});
</script>



<!--<div class="finao-welcome-content">-->
<?php /*if($userprofile->profile_bg_image!="")
		{
			$bgsrc=Yii::app()->baseUrl."/images/uploads/backgroundimages/".$userprofile->profile_bg_image;
        }
 		else
		{
         	$bgsrc="";
        } */?>
<div id="loadingimg"><img src="<?php echo Yii::app()->baseUrl; ?>/images/loading.gif" /></div>
<!--<div id="bgimagediv" style="background-image:url(<?php echo $bgsrc;?>); height:430px; width:960px;">-->
<div id="profile-image" class="welcome-content-left">
	<div class="profile-picture">
	<div class="my-profile-img">
		<?php if($userprofile->profile_image!=""){
					$src=Yii::app()->baseUrl."/images/uploads/profileimages/".$userprofile->profile_image;
	        } else	{
	         	$src=Yii::app()->baseUrl."/images/default-photo.png";
	        }?>
		<img src="<?php echo $src;?>" height="116" width="132" id="imageid"/>
	</div>
	<div class="my-name">
		<form id="ProfileimageForm" action="<?php echo Yii::app()->createUrl('profile/changePic'); ?>" method="post" enctype="multipart/form-data">
		<!--<div style="background-image:url('<?php echo Yii::app()->request->baseUrl; ?>/images/choose-file.jpg'); width:111px; height:20px;">-->
			<input style="cursor:pointer; display:none" type="file" class="file" name="file" id="file"/>
			<a href="javascript:void(0);" onclick="js:$('#file').trigger('click');" > Change Picture</a>
		<!--</div>-->					 
		</form>
	</div>
	</div>
	
	<div id="background-image" class="change-background">
	<?php if($userprofile->profile_bg_image!=""){
				$src=Yii::app()->baseUrl."/images/uploads/backgroundimages/".$userprofile->profile_bg_image;
	        }else{
	         	$src=Yii::app()->baseUrl."/images/default-photo.png";
	        }?>
	
	<form id="BgimageForm" action="<?php echo Yii::app()->createUrl('profile/changeBgPic'); ?>" method="post" enctype="multipart/form-data">
		<!--<div style="background-image:url(<?php echo Yii::app()->request->baseUrl; ?>/images/choose-file.jpg); width:111px; height:20px;">-->
			<input style="cursor:pointer;display:none" type="file" class="file" name="file" id="bgfile"/>
			<a class="orange-link font-15px" href="javascript:void(0);" onclick="js:$('#bgfile').trigger('click');" > Change your Background</a>
		<!--</div> -->
	</form>	
	</div>
</div>

<div class="welcome-content-right">
<?php $formFinaoMesg=$this->beginWidget('CActiveForm', array(
		'id'=>'user-profile-form',
		//'action'=>Yii::app()->baseUrl.'/index.php/profile/saveImage',
		'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
							/*'clientOptions'=>array(
							'validateOnSubmit'=>true)*/
		)); ?>
	<?php echo $formFinaoMesg->hiddenField($userprofile,'user_id',array('class'=>'textbox-regfield','value'=>$userid)); ?>
	
	<div class="orange font-20px padding-8pixels">My Value Statement <span class="font-12px" style="color:#343434;">(140 chars only)</span></div>
	<p class="padding-20pixels">
         <?php echo $formFinaoMesg->textArea($userprofile,'user_profile_msg'
													,array('class'=>'finaos-area'
															,'style'=>'width:90%; height:50px;'
															,'maxlength'=>140)); ?>
	</p>
	<div class="orange font-20px padding-8pixels">My Story <span class="font-12px" style="color:#343434;">(200 words only)</span></div>
    <p class="padding-20pixels">
    	
		<?php echo $formFinaoMesg->textArea($userprofile,'mystory'
												,array('class'=>'finaos-area'
														,'style'=>'width:90%; height:120px;'
														,'maxlength'=>200)); ?>
    </p>
	
	<p class="padding-10pixels left">
    	<span class="left font-15px" style="margin-right:15px;">Location:</span>
		<?php echo $formFinaoMesg->textField($userprofile,'user_location',array('class'=>'textbox left'
																					,'style'=>'width:55%;'
																					,'maxlength'=>10)); ?>
		<br /> <span class="font-15px" style="padding-top:5px; float:left;"> <?php echo $formFinaoMesg->checkBox($userprofile,'profile_status_Ispublic',array());?> Make Profile Public?</span>
    </p>
	
	<p style="clear:left"></p>	
	<p class="center left">
		<?php echo CHtml::submitButton($userprofile ? 'Save and Proceed' : 'Save and Proceed',array('class'=>'orange-button')); ?> <?php echo CHtml::link('Skip this step',array('finao/default'),array('onclick' => 'skipdetails()'
																	,'class'=>'skip-this-step'
																	,'style'=>'margin-left:30px;'
																	)); ?>  
	<span> (You can edit your profile later from settings menu)</span>
    </p>
	
	
	
	<?php $this->endWidget(); ?>
	</div>

<!--</div>-->
<!--</div>-->

<script type="text/javascript" >
function skipdetails(){
	var url='<?php echo Yii::app()->createUrl("/profile/profilelanding"); ?>';
	var skip = "skipped";
	$.post(url,{skip:skip},
 function(data){
   //$("#rotatetabs").html(data);
   alert(data); 
   });
}
</script>