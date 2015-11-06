<?php
class TopHeader extends CWidget
{
	public $userid;
	public $userinfo;
	public $alltiles;
	public $imgcount;
	public $videocount;
	//public $finaos;
	public function run()
	{
		$this->userinfo = User::model()->findByPk($this->userid);
		$Criteria = new CDbCriteria();
		$Criteria->condition = "userid = '".$this->userid."' AND Iscompleted = 0";
		if($this->userid != Yii::app()->session['login']['id'])
		{
			$Criteria->condition = "AND finao_status_Ispublic = 0";
		}
		$finaos = UserFinao::model()->findAll($Criteria);
		if(!empty($finaos))
		{
			foreach($finaos as $finaoids):        
		    	$ids[]=$finaoids->user_finao_id;
			endforeach;
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
		$uploadtypeimage = Lookups::model()->findByAttributes(array('lookup_name'=>'Image','lookup_type'=>'uploadtype','lookup_status'=>1));
		//$uploadsourcetypeimage = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_name'=>'finao','lookup_status'=>1));
		$uploadtypevideo = Lookups::model()->findByAttributes(array('lookup_name'=>'Video','lookup_type'=>'uploadtype','lookup_status'=>1));
		//$uploadsourcetypevideo = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_name'=>'finao','lookup_status'=>1));
		$images = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$uploadtypeimage->lookup_id,'uploadedby'=>$this->userid,'status'=>1));
		$videos = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$uploadtypevideo->lookup_id,'uploadedby'=>$this->userid,'status'=>1));
		$this->imgcount = count($images);
		$this->videocount = count($videos);
		
		$this->render('_topheader',array('tilescount'=>count($this->alltiles)

										,'userinfo'=>$this->userinfo

										,'finaocount'=>count($finaos)

										,'imgcount'=>$this->imgcount

										,'videocount'=>$this->videocount

										));
	}
}







?>