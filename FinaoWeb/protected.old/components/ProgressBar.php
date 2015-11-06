<?php



class ProgressBar extends CWidget

{

	public $userid;

	public $frndprofile;

	public $tileid;

	public $left;

	public $finao;
	public $share;
	
	public $groupid;

	public function run()

	{

		$user = UserProfile::model()->findByAttributes(array('user_id'=>$this->userid));

		$ontrackid = Lookups::model()->findByAttributes(array('lookup_type'=>'finaostatus','lookup_name'=>'On Track'));

		$aheadid = Lookups::model()->findByAttributes(array('lookup_type'=>'finaostatus','lookup_name'=>'Ahead'));

		$behindid = Lookups::model()->findByAttributes(array('lookup_type'=>'finaostatus','lookup_name'=>'Behind'));

		if(isset($this->tileid))

		{

			$finaos = UserFinaoTile::model()->findAllByAttributes(array('tile_id'=>$this->tileid,'userid'=>$this->userid));

			foreach($finaos as $finaoids):        

			    $ids[]=$finaoids->finao_id;

			endforeach;

		}
						
		if(isset($this->groupid) && $this->groupid != "")
		{
		   $condition = "and IsGroup = 1 and group_id = ".$this->groupid."";
		 
		
		}
		else
		{
		   $condition = "and IsGroup = 0 ";
		}
			
			$Criteria = new CDbCriteria();
			$Criteria->condition = "userid = '".$this->userid."' and finao_activestatus = 1 and IsCompleted = 0 ".$condition."";
			if(isset($ids) && !empty($ids))
			{
				$Criteria->addInCondition('user_finao_id', $ids);
			}
			if(Yii::app()->session['login']['id'] != $this->userid || ($this->share == "share"))
			{
				$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');
			}

			$Criteria->order = "updateddate DESC";
			$Criteria->addCondition("finao_status = '".$ontrackid->lookup_id."'", 'AND');
			$ontrack = UserFinao::model()->findAll($Criteria);

			

			$Criteria = new CDbCriteria();

			$Criteria->condition = "userid = '".$this->userid."' and finao_activestatus != 2 and IsCompleted = 0";

			if(isset($ids) && !empty($ids))
			{
				$Criteria->addInCondition('user_finao_id', $ids);
			}
			
			if(Yii::app()->session['login']['id'] != $this->userid || ($this->share == "share"))
			{
				$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');
			}

			$Criteria->order = "updateddate DESC";

			$Criteria->addCondition("finao_status = '".$aheadid->lookup_id."'", 'AND');

			$ahead = UserFinao::model()->findAll($Criteria);

			

			$Criteria = new CDbCriteria();

			$Criteria->condition = "userid = '".$this->userid."' and finao_activestatus != 2 and IsCompleted = 0";

			if(isset($ids) && !empty($ids))

			{

				$Criteria->addInCondition('user_finao_id', $ids);

			}
			if(Yii::app()->session['login']['id'] != $this->userid || ($this->share == "share"))
			{
				$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');
			}

			$Criteria->order = "updateddate DESC";

			$Criteria->addCondition("finao_status = '".$behindid->lookup_id."'", 'AND');

			$behind = UserFinao::model()->findAll($Criteria);
			
			$Criteria = new CDbCriteria();

			$Criteria->condition = "userid = '".$this->userid."' and finao_activestatus != 2 and IsCompleted = 1";

			if(isset($ids) && !empty($ids))

			{

				$Criteria->addInCondition('user_finao_id', $ids);

			}

			$Criteria->order = "updateddate DESC";

			$completed = UserFinao::model()->findAll($Criteria);
			

		

		/*$ontrack = UserFinao::model()->findAll(array('condition'=>'userid = "'.$this->userid.'" AND finao_status = 38'));

		$ahead = UserFinao::model()->findAll(array('condition'=>'userid = "'.$this->userid.'" AND finao_status = 39'));

		$behind = UserFinao::model()->findAll(array('condition'=>'userid = "'.$this->userid.'" AND finao_status = 40'));*/

		if(isset($this->frndprofile))

		{

			$frndprofile = "mainpage";

		}

		else

		{

			$frndprofile = "no";

		}

		if(isset($this->left))

			$leftlayout = "leftlayout";

		else

			$leftlayout = "";

		if(isset($this->finao))

			$finaopage = "finao";

		else

			$finaopage = "";

		$this->render('_progressBar',array('user'=>$user,'ontrack'=>$ontrack,'ahead'=>$ahead,'behind'=>$behind,'frndprofile'=>$frndprofile,'leftlayout'=>$leftlayout,'finaopage'=>$finaopage,'completed'=>$completed));

    }

}



?>