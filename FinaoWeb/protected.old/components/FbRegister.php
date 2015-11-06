<?php

class FbRegister extends CWidget

{

	public $loggeduser;

	public $page;

	public function run()

	{

		if(isset($this->loggeduser))

		{

			

			if(isset($this->page) && $this->page=="default")

			{

				$base = Yii::app()->baseUrl; 

				$serveruri = 'http://'.$_SERVER['HTTP_HOST'].''.$base.'/index.php/finao/motivationmesg?url=logedfbreg';

			}

			elseif(isset($this->page) && $this->page=="profile")

			{

				$base = Yii::app()->baseUrl; 

				$serveruri = 'http://'.$_SERVER['HTTP_HOST'].''.$base.'/index.php/profile/profilelanding?url=logedfbreg';

			}

		}

		else

		{

			$base = Yii::app()->baseUrl;

			$serveruri = 'http://'.$_SERVER['HTTP_HOST'].''.$base.'/index.php/site/index?url=newfbreg';

		}

		//Rathan Added this 

		$params = array(

		'scope'=>'email,user_birthday,user_location,read_friendlists,offline_access',

		//'scope'=>'email,user_birthday,user_location,read_friendlists',

		'redirect_uri' => $serveruri ,

		'display' =>'page');

		echo '<a href="'.Yii::app()->facebook->getLoginUrl($params).'"><img src="'.Yii::app()->baseUrl.'/images/login_icons/facebook.png" /></a>';

    }

}

?>