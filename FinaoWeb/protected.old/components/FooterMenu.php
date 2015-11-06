<?php
class FooterMenu extends CWidget
{
	 
	public $pagetype;
	public function run()
	{
		$this->render('_footermenu',array('pagetype'=>$this->pagetype));
	}
}







?>