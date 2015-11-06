<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'group_name'); ?>
		<?php echo $form->textField($model,'group_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'group_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_description'); ?>
		<?php echo $form->textField($model,'group_description',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'group_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile_image'); ?>
		<?php echo $form->textField($model,'profile_image',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'profile_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temp_profile_image'); ?>
		<?php echo $form->textField($model,'temp_profile_image',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'temp_profile_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile_bg_image'); ?>
		<?php echo $form->textField($model,'profile_bg_image',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'profile_bg_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temp_profile_bg_image'); ?>
		<?php echo $form->textField($model,'temp_profile_bg_image',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'temp_profile_bg_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_status_ispublic'); ?>
		<?php echo $form->textField($model,'group_status_ispublic'); ?>
		<?php echo $form->error($model,'group_status_ispublic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_activestatus'); ?>
		<?php echo $form->textField($model,'group_activestatus'); ?>
		<?php echo $form->error($model,'group_activestatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'upload_status'); ?>
		<?php echo $form->textField($model,'upload_status'); ?>
		<?php echo $form->error($model,'upload_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updatedby'); ?>
		<?php echo $form->textField($model,'updatedby'); ?>
		<?php echo $form->error($model,'updatedby'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'createddate'); ?>
		<?php echo $form->textField($model,'createddate'); ?>
		<?php echo $form->error($model,'createddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updatedate'); ?>
		<?php echo $form->textField($model,'updatedate'); ?>
		<?php echo $form->error($model,'updatedate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->