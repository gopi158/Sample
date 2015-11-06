<!-- Added on 29-01-2013 to include common header in network page -->
<?php $this->beginContent('//layouts/networkHeader'); ?>
		<?php $this->endContent(); ?>
<!-- Ends here -->
<style type="text/css">

div.flash-error, div.flash-notice, div.flash-success
{
	padding:.8em;
	margin-bottom:1em;
	border:2px solid #ddd;
}

div.flash-error
{
	background:#FBE3E4;
	color:#8a1f11;
	border-color:#FBC2C4;
}

div.flash-notice
{
	background:#FFF6BF;
	color:#514721;
	border-color:#FFD324;
}

div.flash-success
{
	background:#E6EFC2;
	color:#264409;
	border-color:#C6D880;
}

div.flash-error a
{
	color:#8a1f11;
}

div.flash-notice a
{
	color:#514721;
}

div.flash-success a
{
	color:#264409;
}
div.form .errorMessage
{
	color: red;
	font-size: 0.9em;
}

div.form .errorSummary p
{
	margin: 0;
	padding: 5px;
}

div.form .errorSummary ul
{
	margin: 0;
	padding: 0 0 0 20px;
}

</style>
<?php
$this->breadcrumbs=array(
	ucfirst($this->module->id)=>array('inbox'),
	ucfirst($this->getAction()->getId())
);

$this->renderpartial('_menu');
?>
<div class="mailbox-compose ui-helper-clearfix">

<?php

$this->renderPartial('_flash');


$form=$this->beginWidget('CActiveForm', array(
'id'=>'message-form',
'enableAjaxValidation'=>false,
'htmlOptions'=>array('autocomplete'=>$this->createUrl('ajax/auto')),
));
?>
	<div class="form message-create">	

		<div class="mailbox-input-row">
			<div style="float:left">
				<?php echo CHtml::activeLabelEx($conv,'to'); ?>
			</div>
			<div style="margin-left:80px">
				<?php
					if(isset($_REQUEST['email'])){
						$val= base64_decode($_REQUEST['email']);
					}
					
				?>
				<!--Start:Changed by varma on 14122012 -->
				<?php echo $form->textField($conv,'to',array('style'=>'width:100%;','id'=>'message-to','class'=>'mailbox-input', 'edit'=>$this->module->editToField? '1' : null, 'value'=>!empty($val)? $val : null )); ?>
				<!-- End:Changed by varma on 14122012-->
				<?php echo $form->error($conv,'to'); ?>
			</div>
		</div>
		<div class="mailbox-input-row">
			<div style="float:left">
				<?php echo CHtml::activeLabelEx($conv,'subject',array('class'=>'mailbox-label')); ?>
			</div>
			<div class="mailbox-compose-inputwrap" style="margin-left:80px;">
				<?php echo $form->textField($conv,'subject',array('class'=>'mailbox-input','style'=>'width:100%;','placeholder'=>$this->module->defaultSubject)); ?>
				<?php echo $form->error($conv,'subject'); ?>
			</div>
		</div>
		<div class="mailbox-textarea-wrap">
		<?php echo $form->textArea($msg,'text',array('cols'=>50,'rows'=>7, 'style'=>'width:100%;','placeholder'=>'Enter message here...')); ?>
		<?php echo $form->error($msg,'text'); ?>
		</div>
		<div>
		<button class="btn btn-large message-btn-reply">Send Message</button>
		</div>
	</div>
<?php $this->endWidget(); 
//'class'=>'mailbox-message-input',
?><!-- form --> 

</div>
<!-- mailbox -->