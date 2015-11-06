<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->userid,
);

$this->menu=array(
	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->userid)),
	array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->userid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>View Users #<?php echo $model->userid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'userid',
		'password',
		'username',
		'email',
		'secondary_email',
		'activkey',
		'lastvisit',
		'superuser',
		'profile_image',
		'fname',
		'lname',
		'gender',
		'location',
		'description',
		'dob',
		'age',
		'mageid',
		'socialnetwork',
		'socialnetworkid',
		'usertypeid',
		'status',
		'zipcode',
		'createtime',
		'createdby',
		'updatedby',
		'updatedate',
		'trackid',
	),
)); ?>
