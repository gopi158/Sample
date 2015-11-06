<?php



class finao extends CWidget

{

	public $type;
	public $Isprofile;
	public $isgroup;

	

	public function run()

	{

		$newfinao = new UserFinao;

		$newtile = new UserFinaoTile;

		$upload = new Uploaddetails;

		

		$userid = Yii::app()->session['login']['id'];

				

		//$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));

		//$tiles = Lookups::model()->findAll(array('condition'=>'lookup_type = "tiles" AND lookup_status = 1 '));
		
		/*$sql = "select lookup_id,lookup_name, concat(lower(lookup_name),'.png') as tileimg from fn_lookups where lookup_type = 'tiles' and lookup_status = 1
				union
				select tile_id,tile_name, tile_profileimagurl from fn_user_finao_tile t join fn_user_finao t1 on t.finao_id = t1.user_finao_id where t.userid = ".$userid." and t.status = 1 and t1.finao_activestatus != 2 
				group by tile_id,tile_name";
		
		$connection=Yii::app()->db; 

		$command=$connection->createCommand($sql);

		$tiles = $command->queryAll();*/
		
		
		$tiles = FinaoController::gettileSqlquery($userid);
				

		$this->render('_finao',array('model'=>$newfinao

									 	,'userid'=>$userid

									 	,'tiles'=>$tiles

										,'newtile'=>$newtile

										,'upload'=>$upload

										,'type'=>$this->type
										,'isgroup'=>$this->isgroup

										//,'userinfo'=>$userinfo

										,'Isprofile'=>$this->Isprofile));

    }

}



?>