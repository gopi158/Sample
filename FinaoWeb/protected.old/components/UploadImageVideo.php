<?php

class UploadImageVideo extends CWidget
{
	public $uploadTargetpage;
	//public $finaoid;
	//public $type;
	//public $upload;
	//public $curPagenum;
	
	public function run()
	{
		
		if($this->uploadTargetpage == "Image")
		{
			$newupload = new Uploaddetails;
			//$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>$this->type));
			//$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>$this->uploadTargetpage));
			//$uploadedimages = Uploaddetails::model()->findAll(array('condition'=>'upload_sourcetype = '.$sourcetypeid->lookup_id.' and upload_sourceid = '.$this->finaoid . ' and uploadtype = '.$typeid->lookup_id, 'order'=>'uploadeddate desc'));
		
			//$finaoinfo = UserFinao::model()->findByPk($this->finaoid);
			//$finaostatus = Lookups::model()->findAll(array('condition'=>'lookup_type = "finaostatus" AND lookup_status = 1'));
			$this->render('_imageupload',array('newupload'=>$newupload
												//,'sourcetypeid'=>$sourcetypeid
												//,'typeid'=>$typeid
												//,'userid'=>$userid
											));	
		}
				
		
    }
}

?>