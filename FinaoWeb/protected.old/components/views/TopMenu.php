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
	public $groupcnt;
	public $isgroup;
	public $groupinfo;
	
	public function run()
	{
		$this->userinfo = User::model()->findByPk($this->userid);
		
		if(!empty($this->isgroup))
		{
		$this->groupinfo = Group::model()->findByAttributes(array('group_id'=>$this->isgroup));
		}
		
		$this->render('_topmenu',array('tilescount'=>$this->alltiles
										,'userinfo'=>$this->userinfo
										,'finaocount'=>$this->finaocount 
										,'imgcount'=>$this->imgcount
										,'videocount'=>$this->videocount
										,'isshare'=>$this->isshare
										,'followcnt'=>$this->followcnt
										,'userid'  => $this->userid
										,'groupcnt'=>$this->groupcnt
										,'isgroup' =>$this->isgroup
										,'groupinfo'=>$this->groupinfo
										));
	}
}







?>