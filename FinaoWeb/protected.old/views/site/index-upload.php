<?php $this->pageTitle=Yii::app()->name; ?>




<div >
 
<?php /*
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'service-form',
    'enableAjaxValidation'=>false,
    'method'=>'post',
    //'type'=>'horizontal',
    'htmlOptions'=>array(
        //'enctype'=>'multipart/form-data'
    )
)); */ ?>



<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
 
    <fieldset style="height:100px; position:absolute">
        <legend>
            <p class="note">Fields with <span class="required">*</span> are required.</p>
        </legend>
		<?php // if($numofrows > 0) { ?>
 		<span style="display:none"><b>Num of rows effected: <?php // echo $numofrows; ?></b></span>
		<?php // } ?>
        <?php //echo $form->errorSummary($model, 'Opps!!!', null, array('class'=>'alert alert-error span12')); ?>
 
        <div  >   
			
       <div >
        <?php //echo $form->labelEx($model,'file'); ?>
        <?php echo CHtml::activefileField($model,'file'); ?>
        <?php //echo $form->error($model,'file'); ?>
          </div>
		
		<div >
        <?php //echo $form->labelEx($model,'file'); ?>
        <?php echo CHtml::activetextField($model,'keyword'); ?>
        <?php //echo $form->error($model,'file'); ?>
          </div> 
		  
		<div >
        <?php //echo $form->labelEx($model,'file'); ?>
        <?php echo CHtml::activetextField($model,'title'); ?>
        <?php //echo $form->error($model,'file'); ?>
          </div>  
 			
		
		<div >
        <?php //echo $form->labelEx($model,'file'); ?>
        <?php echo CHtml::activetextField($model,'description'); ?>
        <?php //echo $form->error($model,'file'); ?>
          </div>  
			
        </div>
 
       <div >
		<?php echo CHtml::submitButton('Submit',array("class"=>"")); ?>
	</div>
 
    </fieldset>
 
<?php //$this->endWidget(); ?>

 <?php echo CHtml::endForm(); ?>
 
</div><!-- form -->