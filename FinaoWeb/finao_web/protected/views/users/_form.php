<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uname'); ?>
		<?php echo $form->textField($model,'uname',array('size'=>55,'maxlength'=>55)); ?>
		<?php echo $form->error($model,'uname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'secondary_email'); ?>
		<?php echo $form->textField($model,'secondary_email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'secondary_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activkey'); ?>
		<?php echo $form->textField($model,'activkey',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'activkey'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastvisit'); ?>
		<?php echo $form->textField($model,'lastvisit'); ?>
		<?php echo $form->error($model,'lastvisit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'superuser'); ?>
		<?php echo $form->textField($model,'superuser'); ?>
		<?php echo $form->error($model,'superuser'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile_image'); ?>
		<?php echo $form->textField($model,'profile_image',array('size'=>60,'maxlength'=>750)); ?>
		<?php echo $form->error($model,'profile_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fname'); ?>
		<?php echo $form->textField($model,'fname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'fname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lname'); ?>
		<?php echo $form->textField($model,'lname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'lname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->textField($model,'gender'); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dob'); ?>
		<?php echo $form->textField($model,'dob'); ?>
		<?php echo $form->error($model,'dob'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'age'); ?>
		<?php echo $form->textField($model,'age',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mageid'); ?>
		<?php echo $form->textField($model,'mageid'); ?>
		<?php echo $form->error($model,'mageid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'socialnetwork'); ?>
		<?php echo $form->textField($model,'socialnetwork',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'socialnetwork'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'socialnetworkid'); ?>
		<?php echo $form->textField($model,'socialnetworkid',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'socialnetworkid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usertypeid'); ?>
		<?php echo $form->textField($model,'usertypeid'); ?>
		<?php echo $form->error($model,'usertypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'zipcode'); ?>
		<?php echo $form->textField($model,'zipcode'); ?>
		<?php echo $form->error($model,'zipcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'createtime'); ?>
		<?php echo $form->textField($model,'createtime'); ?>
		<?php echo $form->error($model,'createtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'createdby'); ?>
		<?php echo $form->textField($model,'createdby'); ?>
		<?php echo $form->error($model,'createdby'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updatedby'); ?>
		<?php echo $form->textField($model,'updatedby'); ?>
		<?php echo $form->error($model,'updatedby'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updatedate'); ?>
		<?php echo $form->textField($model,'updatedate'); ?>
		<?php echo $form->error($model,'updatedate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'trackid'); ?>
		<?php echo $form->textField($model,'trackid'); ?>
		<?php echo $form->error($model,'trackid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->