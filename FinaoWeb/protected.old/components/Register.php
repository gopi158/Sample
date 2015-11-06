<?php

class Register extends CWidget
{
	public $selheader;
	public function run()
	{
		$this->selheader = "register";
		$model = new User;
		$gender = Lookups::model()->findAllByAttributes(array('lookup_type'=>'UIValues-Gender'));
		$gender2 = CHtml::listData($gender, 'lookup_id', 'lookup_name');	
    	$this->render('_regform',array('gender'=>$gender2,'model'=>$model));
    }
}

?>