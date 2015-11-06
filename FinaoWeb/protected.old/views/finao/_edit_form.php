<?php
/* @var $this FinaoTagnoteController */
/* @var $model FinaoTagnote */
/* @var $form CActiveForm */
?>
<style>
textarea{margin:10px; padding:10px; border:1px; outline:none;}
</style>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'finao-tagnote-form',
    'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row" style="margin-right:10px;">
        <?php //echo $form->labelEx($model,'finao'); ?>
        <?php echo $form->textArea($model,'finao',array('size'=>60,'maxlength'=>200,'row'=>6,'cols'=>60)); ?>
        <?php echo $form->error($model,'finao'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->