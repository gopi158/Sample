<?php
class TopMenu extends CWidget
{
	public $userid;
	public $userinfo;
	public $isshare;
	public $alltiles;
	public $imgcount;
	public $videocount;
	public $finaocount;
	public $followcnt;
	
	public function run()
	{
		$this->userinfo = User::model()->findByPk($this->userid);
		
		$this->render('_topmenu',array('tilescount'=>$this->alltiles
										,'userinfo'=>$this->userinfo
										,'finaocount'=>$this->finaocount 
										,'imgcount'=>$this->imgcount
										,'videocount'=>$this->videocount
										,'isshare'=>$this->isshare
										,'followcnt'=>$this->followcnt
										));
	}
}







?>