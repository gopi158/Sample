<?php

class ProgressBar extends CWidget
{
	public $userid;
	public $frndprofile;
	public function run()
	{
		$user = UserProfile::model()->findByAttributes(array('user_id'=>$this->userid));
		$finaostatus = Lookups::model()->findAll(array('condition'=>'lookup_type = "finaostatus" AND lookup_status=1'));
		$ontrack = UserFinao::model()->findAll(array('condition'=>'userid = "'.$this->userid.'" AND finao_status = 38'));
		$ahead = UserFinao::model()->findAll(array('condition'=>'userid = "'.$this->userid.'" AND finao_status = 39'));
		$behind = UserFinao::model()->findAll(array('condition'=>'userid = "'.$this->userid.'" AND finao_status = 40'));
		if(isset($this->frndprofile))
		{
			$frndprofile = "mainpage";
		}
		else
		{
			$frndprofile = "no";
		}
		$this->render('_progressBar',array('user'=>$user,'ontrack'=>$ontrack,'ahead'=>$ahead,'behind'=>$behind,'frndprofile'=>$frndprofile));
    }
}

?>