<?php
class Notes extends CWidget
{
	public $userid;
	public $sourcetype;
	public $sourceid;
	public $widgettype; 
	public $i; 
	public $uname;
	public $note;
	public function run()
	{  
		if($sourcetype=='') $sourcetype=37;
		 $connection = yii::app()->db;
		 $tracked_userid = Yii::app()->session['login']['id'];	 
	 	$Criteria = new CDbCriteria();
        $Criteria->condition = "upload_sourceid = '".$this->sourceid."' AND tracked_userid ='".$tracked_userid."'and upload_sourcetype='".$this->sourcetype."' and view_status=0 and block_status=0";
        $Criteria->order = "note_id DESC";
        $note = Notess::model()->findAll($Criteria);
		
		 foreach ($note as $notes):
                $ids[] = $notes->tracker_userid;
         endforeach;
		
		$Criteria->join = 'join fn_users as t1	on t1.userid = t.tracker_userid ';
		$Criteria->join .= 'join fn_contentnote as t2 on t2.id = t.contentnote_id ';		
		$Criteria->addInCondition('t.tracker_userid', $ids);
		//$Criteria->group = 't.tracker_userid';
		$Criteria->select = "t.*,t1.fname,t2.name";
		$note = Notess::model()->findAll($Criteria);
		
		$content_note = Contentnote::model()->findAll();
		
		//echo $content_note->contentnote_id;
		//print_r($content_note);
		/*SELECT t.*,t1.fname FROM `fn_notes` as t
		join fn_users as t1 
		on t1.userid  = t.tracker_userid
		WHERE t.`tracker_userid` in (616,115)
		group by t.`tracker_userid`*/
		//echo count($note); 	
		$this->render('_note',array('type'=>$this->widgettype,'i'=>$this->i,'sourceid'=>$this->sourceid,'userid'=>$this->userid,'uname'=>$this->uname,'sourcetype'=>$this->sourcetype,'notek'=>$note,'result'=>$content_note));
	}
}

?>