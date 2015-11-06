<script type="text/javascript">
function changeImageClick(id,type)
{
	//alert(id);
	//$("#childFileupload_"+id).show();
	if(type==0)
	{
		$('#image-'+id).trigger('click');
	}
	else if(type==1)
	{
		$('#backgroundimage-'+id).trigger('click');
	}
	//alert(type);
}
function ImageUpload(id,type)
{
	var url="<?php echo Yii::app()->createUrl('profile/saveBgImage');?>";
	
	if(type==0)
	{
		var typeofimage = "profile-image";
		var ext = $('#image-'+id).val().split('.').pop().toLowerCase();
	}
	else if(type==1)
	{
		var typeofimage = "bg-image";
		var ext = $('#backgroundimage-'+id).val().split('.').pop().toLowerCase();
	}
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
	    //$("#profileFileupload").hide();
		alert('Invalid extension!');
	}
	else{
		if(type==0)
		{
			/*$("#user-image-form").ajaxForm(
			{
			target: '#preview'
			
			}).submit();*/
			$("#user-image-form").submit();
			/*alert(url);
			var userprofileimage = $('#image-'+id).val();
			alert(userprofileimage);
			$.post(url, {image:userprofileimage,userid:id,type:typeofimage},
				function(data){ 
   									if(data.length>0){
   											alert(data);
   											
   										}
 								});*/
		}
		else if(type==1)
		{
			//$("#user-background-image").submit();
		
		}
		}
}
</script>
<div class="middle-content">
<div >
<div id='preview'>
</div>
<div>
<?php //echo $this->renderPartial('_profileimage',array('userprofile'=>$userprofile,'userid'=>$userid));?>
<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-image-form',
		'action'=>Yii::app()->baseUrl.'/index.php/profile/saveImage',
		'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
							/*'clientOptions'=>array(
							'validateOnSubmit'=>true)*/
		)); ?>
<?php if($userprofile->profile_image!="")
		{
			$src=Yii::app()->baseUrl."/images/uploads/profileimages/".$userprofile->profile_image;
        }
 		else
		{
         	$src=Yii::app()->baseUrl."/images/default-photo.png";
        }?>
        <div class="child-photo"><img src="<?php echo $src; ?>" class="border" height="130" width="130"/>
        <div>
		<a href="#" class="orange-link" style="padding-left:30px;" id="atagImageOld" onclick="js: changeImageClick('<?php echo $userid;?>',0); return false;" >Upload Photo</a>
		<div id="childFileupload_<?php echo $userid;?>" style="display:none">
		<?php echo CHtml::activeFileField($userprofile, 'userprofileimage', array("id"=>"image-$userid"
																				,'size'=>'10'
																				,"onchange"=>"js: ImageUpload($userid,0)"																
																					)); ?>
		<?php echo $form->hiddenField($userprofile,'user_id',array('class'=>'textbox-regfield','value'=>$userid)); ?>										<?php	echo $form->error($userprofile, 'userprofileimage'); ?>
																							
									</div> 
																
							</div>
						</div>
	<?php $this->endWidget(); ?>
	</div>
	<?php $formFinaoMesg=$this->beginWidget('CActiveForm', array(
		'id'=>'user-profile-form',
		//'action'=>Yii::app()->baseUrl.'/index.php/profile/saveImage',
		'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
							/*'clientOptions'=>array(
							'validateOnSubmit'=>true)*/
		)); ?>
	<div style="padding-left:150px;">
	<fieldset>
      	<label>FINAO:</label>
    	    <div>
			<?php echo $formFinaoMesg->textArea($userprofile,'user_profile_msg',array('class'=>'textbox-regfield','maxlength'=>140)); ?>
			</div>
    </fieldset>
	<fieldset>
        <label>LOCATION:</label>
		<?php echo $formFinaoMesg->textField($userprofile,'user_location',array('class'=>'textbox-regfield','maxlength'=>10)); ?>
	</fieldset>
	<fieldset>
	<label>Is Public:</label>
	<p><?php echo $formFinaoMesg->checkBox($userprofile,'profile_status_Ispublic',array());?></p>
	</fieldset>
	<?php echo CHtml::submitButton($userprofile ? 'Save' : 'Save'); ?>
	<?php $this->endWidget(); ?>
	<?php $formbgimage=$this->beginWidget('CActiveForm', array(
		'id'=>'user-background-image',
		'action'=>Yii::app()->baseUrl.'/index.php/profile/saveImage',
		'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
							/*'clientOptions'=>array(
							'validateOnSubmit'=>true)*/
		)); ?>
<?php if($userprofile->profile_bg_image!="")
		{
			$src=Yii::app()->baseUrl."/images/uploads/backgroundimages/".$userprofile->profile_bg_image;
        }
 		else
		{
         	$src=Yii::app()->baseUrl."/images/default-photo.png";
        }?>
        <div class="child-photo"><img src="<?php echo $src; ?>" class="border" height="130" width="130"/>
        <div>
		<a href="#" class="orange-link" style="padding-left:30px;" id="bgimage" onclick="js: changeImageClick('<?php echo $userid;?>',1); return false;" >Upload Photo</a>
		<div id="bgimage-<?php echo $userid;?>" style="display:none">
		<?php echo CHtml::activeFileField($userprofile, 'bgimage', array("id"=>"backgroundimage-$userid"
																				,'size'=>'10'
																				,"onchange"=>"js: ImageUpload($userid,1)"																
																					)); ?>
		<?php echo $formbgimage->hiddenField($userprofile,'user_id',array('class'=>'textbox-regfield','value'=>$userid)); ?>										<?php	echo $formbgimage->error($userprofile, 'bgimage'); ?>
																							
									</div> 
																
							</div>
						</div>
	<?php /*$this->endWidget(); */?>
	
	</div>
<?php $this->endWidget(); ?>
</div>
</div>