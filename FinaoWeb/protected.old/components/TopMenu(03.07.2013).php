<?php
class TopMenu extends CWidget
{
	public $userid;
	public $userinfo;
	public $isshare;
	public $alltiles;
	public $imgcount;
	public $videocount;
	//public $finaos;
	public function run()
	{
		$this->userinfo = User::model()->findByPk($this->userid);
		$Criteria = new CDbCriteria();
		$Criteria->condition = "userid = '".$this->userid."' AND Iscompleted = 0";
		if($this->userid != Yii::app()->session['login']['id'] || $this->isshare == "share")
		{
			$Criteria->addCondition("finao_status_Ispublic = 0","AND");
		}
		$finaos = UserFinao::model()->findAll($Criteria);
		if(!empty($finaos))
		{
			foreach($finaos as $finaoids):        
		    	$ids[]=$finaoids->user_finao_id;
			endforeach;
			//print_r($ids);
			//exit;
			$Criteria = new CDbCriteria();
			$Criteria->group = 'tile_id';
			$Criteria->condition = "userid = '".$this->userid."'";
			if(!empty($ids))
				$Criteria->addInCondition('finao_id', $ids);
			$Criteria->order = 'createddate DESC';
			$this->alltiles = UserFinaoTile::model()->findAll($Criteria);
		}
		else
			$this->alltiles = "";
		//print_r($this->alltiles."hiiii");
		//exit;
		$uploadtypeimage = Lookups::model()->findByAttributes(array('lookup_name'=>'Image','lookup_type'=>'uploadtype','lookup_status'=>1));
		//$uploadsourcetypeimage = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_name'=>'finao','lookup_status'=>1));
		$uploadtypevideo = Lookups::model()->findByAttributes(array('lookup_name'=>'Video','lookup_type'=>'uploadtype','lookup_status'=>1));
		//$uploadsourcetypevideo = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_name'=>'finao','lookup_status'=>1));
		$images = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$uploadtypeimage->lookup_id,'uploadedby'=>$this->userid,'status'=>1));
		$videos = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$uploadtypevideo->lookup_id,'uploadedby'=>$this->userid,'status'=>1));
		//$this->imgcount = count($images);
		//$this->videocount = count($videos);
		
		$this->render('_topmenu',array('tilescount'=>$this->alltiles

										,'userinfo'=>$this->userinfo

										,'finaocount'=>count($finaos)

										,'imgcount'=>$this->imgcount

										,'videocount'=>$this->videocount
										,'isshare'=>$this->isshare

										));
	}
}







?>