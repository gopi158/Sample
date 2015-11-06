<?php

class tiles extends CWidget

{

	public $alltiles;

    public $userinfo;

	public $totaltilecount;

	public $widgetstyle;

	public $imgcount;

	public $videocount;

	public $homepage;

	public function run()

	{

		/*$userid = Yii::app()->session['login']['id'];

		//$userid = Yii::app()->session['login']['id'];

		$criteria=new CDbCriteria;

        $criteria->distinct = true;

		$criteria->condition = "userid = '".$userid."'";

		$alltiles = UserFinaoTile::model()->findAll($criteria);*/

		if(isset($this->homepage))

		{

			$userid = Yii::app()->session['login']['id'];

			$this->userinfo = User::model()->findByPk($userid);

			$widstyle = 'notile';

			$Criteria = new CDbCriteria();

			$Criteria->condition = "userid = '".$userid."' AND Iscompleted = 0";

			$finaos = UserFinao::model()->findAll($Criteria);

			if(!empty($finaos))

			{

				$Criteria = new CDbCriteria();

				$Criteria->group = 'tile_id';

				$Criteria->condition = "userid = '".$userid."'";

				/*if(isset($_REQUEST['frndid']))

				{*/

					if(!empty($finaos))

					{

						foreach($finaos as $finaoids):        

					    	$ids[]=$finaoids->user_finao_id;

						endforeach;

					}

					if(!empty($ids))

						$Criteria->addInCondition('finao_id', $ids);

				/*}*/

				$Criteria->order = 'createddate DESC';

				$this->alltiles = UserFinaoTile::model()->findAll($Criteria);

			}

			else

			{

				$this->alltiles = "";

			}

			$uploadtypeimage = Lookups::model()->findByAttributes(array('lookup_name'=>'Image','lookup_type'=>'uploadtype','lookup_status'=>1));

		//$uploadsourcetypeimage = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_name'=>'finao','lookup_status'=>1));

		$uploadtypevideo = Lookups::model()->findByAttributes(array('lookup_name'=>'Video','lookup_type'=>'uploadtype','lookup_status'=>1));

		//$uploadsourcetypevideo = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_name'=>'finao','lookup_status'=>1));

		$images = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$uploadtypeimage->lookup_id,'uploadedby'=>$userid,'status'=>1));

		$videos = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$uploadtypevideo->lookup_id,'uploadedby'=>$userid,'status'=>1));

			$this->imgcount = count($images);

			$this->videocount = count($videos);

			$this->totaltilecount = count($this->alltiles);

		}

			

			

		if($this->widgetstyle == 'tile')
		{
						
			$this->render('_tile',array('alltiles'=>$this->alltiles

										,'userinfo'=>$this->userinfo

										,'totaltilecount'=>$this->totaltilecount

										,'imgcount'=>$this->imgcount

										,'videocount'=>$this->videocount

										));
		}

			

		else 

										

			$this->render('_tilenotumb',array('alltiles'=>$this->alltiles

										,'userinfo'=>$this->userinfo

										,'totaltilecount'=>$this->totaltilecount

										,'imgcount'=>$this->imgcount

										,'videocount'=>$this->videocount

										));

	}



}







?>