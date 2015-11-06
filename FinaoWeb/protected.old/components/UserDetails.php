<?php



class UserDetails extends CWidget

{

	public $myaddress;

	public $myprofile;

	public $editprof;

	public $page;
	public $userid;
	

	public function run()

	{
		if(isset($this->userid))
		{
			if($this->userid==Yii::app()->session['login']['id'])
			{
				$userid = Yii::app()->session['login']['id'];
			}

			else
			{
				$userid = $this->userid;
			}
		}
		else
		{
			$userid = Yii::app()->session['login']['id'];
		}
		
		//echo $userid;

		if(isset($_POST["User"]))

		{

			$editprof = new User;

			$rnd = rand(0,9999);

			$editprof->attributes = $_POST['User'];

			$uploadedFile=CUploadedFile::getInstance($editprof,'image');

            $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name

            if($uploadedFile->saveAs(Yii::app()->basePath.'/../images/uploads/parentimages/'.$fileName))

			{

				$editprof = User::model()->findByPK($userid);

				$editprof->profile_image = $fileName;

				$editprof->updatedby = $userid;

				$editprof->updatedate = new CDbExpression('NOW()');

				$editprof->save(false);	

				if($this->page == 'myprofile'){

					$this->myprofile[0]->profile_image = $fileName;

				}else{

					$this->myprofile->profile_image = $fileName;

				}

			}

						

		}

		//print_r($this->myprofile);

		

		$this->render('_userprofile',array('myprofile'=>$this->myprofile

											,'editprof'=>$this->editprof

											,'myaddress'=>$this->myaddress

											,'page'=>$this->page
											,'userid'=>$userid

											));

		

	}

}



?>