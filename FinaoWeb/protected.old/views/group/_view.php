<?php
/* @var $this GroupController */
/* @var $data Group */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->group_id), array('view', 'id'=>$data->group_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_name')); ?>:</b>
	<?php echo CHtml::encode($data->group_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_description')); ?>:</b>
	<?php echo CHtml::encode($data->group_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profile_image')); ?>:</b>
	<?php echo CHtml::encode($data->profile_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temp_profile_image')); ?>:</b>
	<?php echo CHtml::encode($data->temp_profile_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profile_bg_image')); ?>:</b>
	<?php echo CHtml::encode($data->profile_bg_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temp_profile_bg_image')); ?>:</b>
	<?php echo CHtml::encode($data->temp_profile_bg_image); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('group_status_ispublic')); ?>:</b>
	<?php echo CHtml::encode($data->group_status_ispublic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_activestatus')); ?>:</b>
	<?php echo CHtml::encode($data->group_activestatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upload_status')); ?>:</b>
	<?php echo CHtml::encode($data->upload_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatedby')); ?>:</b>
	<?php echo CHtml::encode($data->updatedby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createddate')); ?>:</b>
	<?php echo CHtml::encode($data->createddate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatedate')); ?>:</b>
	<?php echo CHtml::encode($data->updatedate); ?>
	<br />

	*/ ?>

</div>