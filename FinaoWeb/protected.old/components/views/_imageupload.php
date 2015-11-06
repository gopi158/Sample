<script type="text/javascript">
	function imgclick()
	{
		$("#widgetimage").trigger('click');
	}
</script>
<div>
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'upload-form',
	'enableClientValidation'=>true,
	//'multiple'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<div style="display:none;">
<?php $this->widget('CMultiFileUpload', array(
                'name' => 'widgetimage',
                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                'duplicate' => 'Duplicate file!', // useful, i think
                'denied' => 'Invalid file type', // useful, i think
    			'remove' => Yii::t('ui', '<div><img  title="Delete" style="float:right;padding-right:5px;padding-left:5px;" src="' . Yii::app()->request->baseUrl . '/images/delete.png" /></div>'),
                       )); 
?></div>
<div>
	<img src="<?php echo Yii::app()->baseUrl;?>/images/photos.png" onclick="js:imgclick();" />
</div>
<?php
	//echo $form->textField($newupload,'caption',array('value'=>'Add Caption')) 
?>					   
<?php 
//echo $form->hiddenField($newupload,'uploadtype',array('value'=>$typeid->lookup_id)); 
 ?>
<?php // echo $form->hiddenField($newupload,'upload_sourcetype',array('value'=>$sourcetypeid->lookup_id));?>
 <?php 
 // echo $form->hiddenField($newupload,'upload_sourceid',array('value'=>$finaoinfo->user_finao_id)); 
 ?>
<?php 
// echo $form->hiddenField($newupload,'uploadedby',array('value'=>$finaoinfo->userid)); 
 ?>
 <?php 
// echo $form->hiddenField($newupload,'updatedby',array('value'=>$finaoinfo->userid)); 
 ?>
		<?php // echo CHtml::submitButton('Upload',array('id'=>'newfinaoimage')); ?>
	
<?php $this->endWidget(); ?>
</div>

