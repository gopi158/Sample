<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'group_id'); ?>
		<?php echo $form->textField($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group_name'); ?>
		<?php echo $form->textField($model,'group_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group_description'); ?>
		<?php echo $form->textField($model,'group_description',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'profile_image'); ?>
		<?php echo $form->textField($model,'profile_image',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'temp_profile_image'); ?>
		<?php echo $form->textField($model,'temp_profile_image',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'profile_bg_image'); ?>
		<?php echo $form->textField($model,'profile_bg_image',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'temp_profile_bg_image'); ?>
		<?php echo $form->textField($model,'temp_profile_bg_image',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group_status_ispublic'); ?>
		<?php echo $form->textField($model,'group_status_ispublic'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'group_activestatus'); ?>
		<?php echo $form->textField($model,'group_activestatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'upload_status'); ?>
		<?php echo $form->textField($model,'upload_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updatedby'); ?>
		<?php echo $form->textField($model,'updatedby'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createddate'); ?>
		<?php echo $form->textField($model,'createddate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updatedate'); ?>
		<?php echo $form->textField($model,'updatedate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->