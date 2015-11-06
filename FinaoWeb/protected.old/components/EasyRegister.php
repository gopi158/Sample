<?php
class EasyRegister extends CWidget
{
	 
	public $type;
	public $pid;
   
	public function run()
	{
		
		
		switch($this->type)
		{
			case 'group': 
			             $resultinfo = Group::model()->findByAttributes(array('group_id'=>$this->pid));
			             break;
			
			case 'tile': 
			             $resulttileinfo = Lookups::model()->findByAttributes(array('lookup_id'=>$this->pid));
			             break;	
						 
			case 'video': 
			             $resultgroupinfo = '';
			             break;			 		 
						 
		}  
		
		$this->render('_easyregister',array('type'=>$this->type
		                                    ,'pid'=>$this->pid
											,'resultinfo'=>$resultinfo
											,'resulttileinfo'=>$resulttileinfo
											 ));
    }
}
?>