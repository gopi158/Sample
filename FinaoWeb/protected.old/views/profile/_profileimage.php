<script type="text/javascript">
/*$(document).ready(function()
{
$('#photoimg').live('change', function()
{
$("#preview").html('');
//$("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
alert("beforeaction");
$("#imageform").ajaxForm(
{
target: '#preview'
}).submit();
});
});*/
</script>
<!--<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo Yii::app()->createUrl("/profile/saveBgImage");?>'>
Upload image <input type="file" name="photoimg" id="photoimg" />
</form>-->

<div id='preview'>
</div>
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