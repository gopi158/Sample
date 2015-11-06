<?php
class GroupController extends FinaoController
{
	
	
/**
* Lists all models.
*/
	public function actionDashboard()
	{
		

		if(isset(Yii::app()->session['login']['id']))
		{
			$userid = Yii::app()->session['login']['id'];
			if(isset($_REQUEST['frndid']))
			{
				$frndid = $_REQUEST['frndid'];
				if($frndid != $userid)
				{
					$userid = $frndid;
				}
			}
		}
		else if(isset($_REQUEST['frndid']))
		{
		$frndid = $_REQUEST['frndid'];
		/*This code is added for making specific profiles public*/	
		$profiles = array(64,124,16,101,100,99,279,280,255,115,265,449,270,371,248,241,63,246,239,106,68,193,289,67,107,597,362,303,256,333);  
		 
		 
			if (in_array($frndid, $profiles)) 
			{
			$userid = $frndid;
			}
			else
			{
			$this->redirect(array('/home'));
			}
		}
		else
		{
		$this->redirect(array('/home'));
		}
		
		if(isset($_REQUEST['share']))
		{
			$share = "share";
		}
		else
		{
			$share = "no";
		}
		
		if($_REQUEST['groupid'])
		{
			$isgroup = $_REQUEST['groupid'];
		}
		else
		{
			
			$isgroup = '';
			$this->redirect(array('/home'));
			
		}
		if(isset($_REQUEST['getusertileid']) || isset($_REQUEST['tileerrormesg']))
		{
			if(isset($_REQUEST['tileerrormesg']))
				$getusertileid = $_REQUEST['tileerrormesg'];
			else if($_REQUEST['getusertileid'])
				$getusertileid = $_REQUEST['getusertileid'];
			$tileid = $getusertileid;
		}
		else
		{
			$tileid = "";
			$getusertileid = "";
		}
		if($_REQUEST['upload'])
		{
			$upload = 1;
		}
		if($_REQUEST['errormsg'])
		{
			$errormsg = $_REQUEST['errormsg'];
		}
		
		$groupinfo = Group::model()->findByPK($isgroup);
		
		
		
		$isuploadprocess = array();
		if(isset($_REQUEST["finaoid"])) 
		{
			$sourcetype  = $_REQUEST["sourcetype"];
			$finid = 0;
			$journalid =0;
			if($sourcetype == 'journal')
			{
				$finaojournal = UserFinaoJournal::model()->findByPK($_REQUEST["finaoid"]);
				if(isset($finaojournal) && !empty($finaojournal))
				{
					$finid = $finaojournal->finao_id;
				}
				$journalid = $_REQUEST["finaoid"];
			}
			else
				$finid = $_REQUEST["finaoid"];
			$finao = UserFinaoTile::model()->find(array('condition'=>'finao_id = '.$finid));
			$tileid = "";
			if(isset($finao) && count($finao) >= 1)
			{
				$tileid = $finao->tile_id;
			}
			
			$isuploadprocess = array('finao'=>$finid,//$_REQUEST['finaoid'],
									  'tile'=>$tileid,
									   'share' => $share,
									  'journalid'=>$journalid,
									  'upload'=>$_REQUEST['upload'],
									  'menuselected'=> isset($_REQUEST['menuselected']) ? $_REQUEST['menuselected']: ""	
							);
			}
			
		//$tilesslider = $this->refreshtilewidget($userid,$share,0,0,1);
		 
		 
		$Criteria = new CDbCriteria();
		$Criteria->condition = "`group_id` = ".$isgroup." and `finao_activestatus` = 1 and `updatedby` = ".$userid." and Iscompleted = 0";
		if($userid != Yii::app()->session['login']['id'] ||  $share == "share")
		{
			$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');
			
		}
		$Criteria->order = "updateddate DESC";
		$groupfinaos = UserFinao::model()->findAll($Criteria);
		 
		 
		foreach($groupfinaos as $finodet)
		{
		$finaoids .= $finodet->user_finao_id.",";
		}
		if($finaoids != "")
		{
		$finaoids = substr($finaoids,0,strlen($finaoids)-1);
		$finaouploaddetails = $this->getlatestuploaddetails($finaoids,61);
		}
		 
		$tilesslider = $this->refreshtilewidget($userid,$isgroup,$share,0,0,1);
		$members = $this->getmembersdetails($userid,$isgroup,0,0);
		$memcount= count($members,0);
		 
		$trackingyoudet = TrackingController::displayYourGroupTracking($userid,$share,"trackingyou","",$isgroup); 
		
		
		$result = GroupTracking::model()->findByAttributes(array('tracker_userid'=>Yii::app()->session['login']['id'],'tracked_groupid'=>$isgroup,'tracked_userid'=>$userid)); 
		
		 
		if(count($result)=='0')
		{
			$results='Join Group'; 
			$isgroupmem = 0;//Not a member
		}
		else 
		{
			$results='Leave Group'; 
			$isgroupmem = 1;// Member
		}
		
		//archived finaos
		$archivefinao = $this->getfinaoinfo($userid,$isgroup,"completed",$share,-1,1,0);
		// tile info 
	 	$userprofarray = $this->getUserProfile($userid,$share,$isgroup);
		$activityppl = $this->getmyheroesdata1($userid,$share); 
		//print_r($groupfinaos);exit;
		//echo $groupfinaos['user_finao_id']; 
		$result_tile_id = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$groupfinaos[0]['user_finao_id']));
		 
		/*$announcements = Announcement::model()->findByAttributes(array('uploadsourcetype'=>61,
																	   'uploadsourceid'=>$isgroup
																	   )); */
		
		$Criteria = new CDbCriteria();
		$Criteria->condition = "uploadsourcetype = 61 and createdby = ".$userid." and uploadsourceid = ".$isgroup." ";
		 
		$Criteria->order = "createddate DESC";
		$announcements = Announcement::model()->findAll($Criteria);
		
		
		$othergroups  = FinaoController::getGroupinfo($userid,$share);
		
		$this->render('index',array('userid' => $userid
		                            ,'imgcount'=> $this->GetTotalCount(0,$isgroup,$userid,'Image',0,$share)
									,'videocount'=> $this->GetTotalCount(0,$isgroup,$userid,'Video',0,$share)							,'finaocount'=> $this->getfinaoinfo($userid,$isgroup,"",'yes',-1,1,1)
									,'titlecount' => $tilesslider['totaltilecount'] 
									,'followcount'=>$this->getfollowersdetails($userid,-1,0,1)
									,'isgroup'=> $isgroup
									,'groupinfo' =>$groupinfo
									,'groupfinaos'=>$groupfinaos
									,'share' => $share
									,'upload'=>$upload
									,'memcount'=> $memcount
									,'results'=>$results
									,'share'=>$share
									,'isuploadprocess'=>$isuploadprocess
									,'finaouploaddetails'=>$finaouploaddetails
									,'getusertileid'=>$getusertileid
									,'tileid'=>$tileid
									,'trackingyoudet'=>$trackingyoudet
									,'isgroupmem'=>$isgroupmem
									,'tilesinfo'=>$userprofarray['tilesinfo']
									,'archivefinao'=>$archivefinao
									,'activityppl'=>$activityppl
									,'errormsg'=>$errormsg
									,'result_tile_id'=>$result_tile_id->tile_id
									,'announcements'=>$announcements
									,'share_value'=>$_REQUEST['share_value']
									,'othergroups'=>$othergroups['groupinfo']
									/*,'groupinfo'=>$usergroups['groupinfo']	*/								
									));
	}
	
	public function getmyheroesdata1($userid,$share)
	{
		/*$criteria = new CDbCriteria();
		$criteria->join = ' Join  fn_user_finao t1 ON t.finao_id = t1.user_finao_id ';
		$criteria->join .= ' JOIN fn_users t2 ON t.updateby = t2.userid';
		$criteria->join .= ' JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = "notificationaction"';
		$criteria->join .= ' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = "finaostatus" ';
		$criteria->join .= ' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id ';
		$criteria->order .= 't.updateddate desc';
		$criteria->group = 't.group_id, t.finao_id ,round(UNIX_TIMESTAMP(t.updateddate) / 600) desc';
		$criteria->condition = ' t.tracker_userid = '.$userid.' and t1.finao_status_Ispublic = 1 and t1.finao_activestatus = 1';
		$criteria->select = 't.*, t1.finao_msg, t4.lookup_name as finaostatus, t1.updateddate as finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id ';*/
		$sql="SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id
		FROM `fn_groupnotifications` `t`
		JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id
		JOIN fn_users t2 ON t.updateby = t2.userid
		JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id
		AND t3.lookup_type = 'notificationaction'
		JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id
		AND t4.lookup_type = 'finaostatus'
		JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id
		WHERE t.tracker_userid =".$userid."
		AND t1.finao_status_Ispublic =1
		AND t1.finao_activestatus =1
		GROUP BY t.group_id, t.finao_id, round( UNIX_TIMESTAMP( t.updateddate ) /600 ) DESC
		ORDER BY t.updateddate DESC";

		$connection=Yii::app()->db; 
		$command=$connection->createCommand($sql);
		$trackingppl = $command->queryAll();
		

		//$trackingppl = Groupnotifications::model()->findAll($criteria);
		$users = $this->getfollowersdetails($userid,-1,0,0);
		$ids = "";
		foreach($trackingppl as $tppl)
		{
			$ids .= $tppl->finao_id . ",";
		}
		$ids = substr($ids,0,strlen($ids)-1);
		$uploadinfo = ""; 
		if($ids != "") {
			$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));
			$uploadinfo = $this->getlatestuploaddetails($ids,$sourcetypeid->lookup_id);
		}
		//print_r($trackingppl);exit;
		//echo $trackingppl[0]['notification_action'];
		return array('trackingppl'=>$trackingppl,'uploadinfo'=>$uploadinfo,'users'=>$users);
	}
	
	
/*==== 
Description: Action for Getting User Group Information.
variable : 

====*/
	
	public function actionGetallGroup()
	{
		$userid = $_REQUEST['userid'];
		$share = $_REQUEST['share'];
		$pageid = $_REQUEST['pageid'];
		$Iscomplete = "";
		$noofelements = 8;

		if($userid != Yii::app()->session['login']['id'] || $share == 'share')
			$noofelements = 9;
		$finao = $this->getgroupinfo($userid,$Iscomplete,$share,$noofelements,$pageid,0);
		 
        $this->renderPartial('_allgroups',array('finaos'=>$finao['finaos']
													,'uploaddetails'=>$finao['uploaddetails']
										 	,'finaopagedetails'=>$finao['finaopagedetails']
													,'userid'=>$userid
													,'userinfo'=>$userinfo
													,'share'=>$share
													));														
													
	
	 
	}
	
	public function getgroupinfo($userid,$Iscompleted,$share,$noofelements,$pageid,$getcount)
	{
		
			if ($userid != Yii::app()->session['login']['id'] || $share == "share") {
			$conditon = "and visible = 0";
			}
			$sql = "SELECT group_id FROM `fn_user_group` WHERE `updatedby` = ".$userid." and group_activestatus = 1

union all

SELECT tracked_groupid as group_id FROM `fn_group_tracking` WHERE `tracker_userid` = ".$userid." and status = 1 ".$conditon."


";
			$connection=Yii::app()->db;  
			$command=$connection->createCommand($sql);
			$tileids = $command->queryAll();
			$gids = array();
			foreach($tileids as $newtile)
			{
				$gids[] = $newtile["group_id"];
			}
			
			//print_r($gids);exit;
			
			
		
		
		
		if($userid != Yii::app()->session['login']['id'] ||  $share == "share")
			{
			   $conditon = "and group_status_ispublic = 1";
			}
		$Criteria = new CDbCriteria();
		
		$Criteria->condition = "group_activestatus = 1 ".$conditon."";
		$Criteria->addInCondition('group_id', $gids);
		$Criteria->order = "createddate DESC";
		
		$finaos = Group::model()->findAll($Criteria);
		$finaopagedetails = $this->getpagedetails($finaos,1,$pageid,$noofelements);
		$Criteria->limit = $finaopagedetails['limittxt'];
		$Criteria->offset = $finaopagedetails['offset'];
		$finaos = Group::model()->findAll($Criteria);
		
		return  array('finaos'=>$finaos
				 ,'finaopagedetails'=>$finaopagedetails );
	}

	
	public function actioncreateGroup()
	{//echo $_POST['gtype']; exit;
	  if($_POST['group_id']!='')
	  {	//echo $_POST['gtype']; exit;
	    $editgroup = new Group;
		$editgroup = Group::model()->findByPK($_POST['group_id']);
		if(isset($_POST['gname']))
		{
			$editgroup->group_name = $_POST['gname'];
			$editgroup->group_description = $_POST['gdesc'];
			$editgroup->group_activestatus = 1;
			$editgroup->group_status_ispublic = $_POST['gtype'];
			$editgroup->upload_status = $_POST['media'];
			if($editgroup->save(false))
			{
				$groupid  = $editgroup->group_id;
				
				$images = CUploadedFile::getInstancesByName('gimage');
				foreach($images as $pic)
				{
					$fileext = $pic->extensionName;
					$fileext = strtolower($fileext);					 
					$numb = rand();
	//$filename = $_POST['userid'].'-'."groupimage-".$numb.'.'.$fileext;
					$filename = "tempbg-" .$_POST['userid']."-".$numb."-".str_replace(' ','',$_FILES["file"]["name"]);
					$newgroup->temp_profile_image = $filename;					
					if($newgroup->save(false))
					{
						$destimgpath = Yii::getPathOfAlias('webroot').'/images/uploads/groupimages/profile/'.$filename;
						$pic->saveAs($destimgpath);
						$ext = substr(strrchr($destimgpath,'.'),1);
						$ext = strtolower($ext);
						$this->createImagetofixbodysize($destimgpath,500,$ext);							
				 $this->redirect(Yii::app()->createUrl('group/dashboard',array('groupid'=>$groupid			                                                               ,'imgupload'=>1)));	
					}					
				}				
				$this->redirect(Yii::app()->createUrl('group/dashboard',array('groupid'=>$groupid)));
			}
		}
	  }
	  else
	  {
	  	if(isset($_POST['gname']))
		{			
			$newgroup = new Group;
			$newgroup->group_name = $_POST['gname'];
			$newgroup->group_description = $_POST['gdesc'];
			$newgroup->group_activestatus = 1;
			$newgroup->group_status_ispublic = $_POST['gtype'];
			$newgroup->upload_status = $_POST['media'];
			$newgroup->updatedby = $_POST['userid'];
			$newgroup->createddate = new CDbExpression('NOW()');
			if($newgroup->save(false))
			{
				$groupid  = $newgroup->group_id;
				
				$images = CUploadedFile::getInstancesByName('gimage');
				foreach($images as $pic)
				{
					$fileext = $pic->extensionName;
					$fileext = strtolower($fileext);
					 
					$numb = rand();
	//$filename = $_POST['userid'].'-'."groupimage-".$numb.'.'.$fileext;
					$filename = "tempbg-" .$_POST['userid']."-".$numb."-".str_replace(' ','',$_FILES["file"]["name"]);
					$newgroup->temp_profile_image = $filename;
					
					if($newgroup->save(false))
					{
						$destimgpath = Yii::getPathOfAlias('webroot').'/images/uploads/groupimages/profile/'.$filename;
						$pic->saveAs($destimgpath);
						$ext = substr(strrchr($destimgpath,'.'),1);
						$ext = strtolower($ext);
						$this->createImagetofixbodysize($destimgpath,500,$ext);	
						
				 $this->redirect(Yii::app()->createUrl('group/dashboard',array('groupid'=>$groupid			                                                               ,'imgupload'=>1)));	
					}
					
				}
				
				$this->redirect(Yii::app()->createUrl('group/dashboard',array('groupid'=>$groupid)));
			}
			
			
		
		}
	  }	
		
		if(isset($_POST['edit']) == 1)
		{
			$groupinfo = Group::model()->findByPK($_POST['groupid']);
		} 
		
		$this->renderPartial('_newgroup',array('userid'=> $_POST['userid']
		                                        ,'edit'=>$_POST['edit']
												,'groupinfo'=>(!empty($groupinfo))? $groupinfo:0
												));
	}
	
	public function actionGetallGroupMembers()
	{
		
		 
		//print_r($_POST);exit;
		$userid = $_POST['userid'];
		$groupid = $_POST['groupid'];
		$pageid = $_POST['pageid'];
		 
		$noofelemets = 9;
		$users = $this->getmembersdetails($userid,$groupid,0,0); 
		
		$followarray = $this->getpagedetails($users,1,$pageid,$noofelemets);
		 //print_r($followarray);exit;
		$users = $this->getmembersdetails($userid,$groupid,$followarray['limittxt'],$followarray['offset']);
			
		 
		$this->renderPartial('_allgroupmembers',array('members'=>$users
		                                              ,'followarray'=>$followarray
													  ,'userid'=>$userid
													  ,'groupid' =>$groupid));
	}
	
	public function getmembersdetails($userid,$groupid,$limit,$offset)
	{
		 
		$Criteria = new CDbCriteria();
		$Criteria->join = 'JOIN fn_user_group as t2 on t.`tracked_groupid` = t2.group_id and t2.group_activestatus =1';
        $Criteria->condition = "`tracked_userid` = ".$userid." and tracked_groupid = ".$groupid." and visible = 0";
		 
		$criteria->select='distinct t.tracker_userid';
		
		$members = GroupTracking::model()->findAll($Criteria);
		 
		 $memids = array();
		 foreach($members as $member)
		 {
			 $memids[] = $member->tracker_userid;
		 }
        
	 
		/* if(!empty($memids))
		 {*/
			 $criteria1 = new CDbCriteria();
			 $criteria1->join = 'join fn_user_profile AS t1
on t.userid = t1.user_id and t.status = 1';
			
			$criteria1->addInCondition('userid', $memids);
			$criteria1->select='t1.profile_image,t.*';
			$criteria1->order = 'createtime DESC';
			
			if($limit)
			{
			$criteria1->limit = $limit;
			$criteria1->offset = $offset;	
			}
			$meminfo = User::model()->findAll($criteria1);
		/* }*/
		 
		 
		 
		  //print_r($meminfo);exit;
		 return  $meminfo;
		 
		 	
	} 
	
// updated by ramesh script for deleting the groups
	
public function actionDeletefj()

	{	
		$userid = Yii::app()->session['login']['id'];	
		$groupid = $_POST['groupid'];
		
		// groups tabel deleting
			$groups = Group::model()->findByAttributes(array('group_id'=>$groupid));			
			//$groups = new Group;
			$groups->group_activestatus = '2';
			if($groups->save(false)){echo "success";}		
			
		$imagetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Image'));

		$videotypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Video'));
			$sourcetypeidfinao = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));	
	
			$sourcetypeidtile = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'tile'));
			$tracked_tileids=Yii::app()->session['login']['id'];
	
	
				/*$tileinfo = Tracking::model()->findAllByAttributes(array('tracked_userid'=>$tracked_tileids,'tracked_tileid'=>$tileid));	
	
				if(isset($tileinfo['0']['tracking_id']))	
				{
	
					$tileinfo = Tracking::model()->findByAttributes(array('tracking_id'=>$tileinfo['0']['tracking_id']));
	
					$tileinfo->delete();	
	
				}	*/
	
			$sourcetypeidjournal = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'journal'));
			
			$groupfinao = UserFinao::model()->findByAttributes(array('group_id'=>$groupid));			
			
			// finaos deleteing
			$type="finao";
			if($type=="finao")
	
			{
				// uploadedetails deleteing
				$delfiles = Uploaddetails::model()->findAllByAttributes(array('upload_sourceid'=>$groupfinao->user_finao_id));		
				//$delfiles1 = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$videotypeid->lookup_id,'upload_sourcetype'=>$sourcetypeidfinao->lookup_id,'upload_sourceid'=>$journalid,'uploadedby'=>$userid));	
	
				if(isset($delfiles) && !empty($delfiles))
	
				{	
					foreach($delfiles as $image)
					{	
						$image->status = 2;	
						$image->save(false);	
					}
				}
				/*if(isset($delfiles1) && !empty($delfiles1))
				{
				foreach($delfiles1 as $video)	
					{
						$video->status = 2;	
						$video->save(false);
	
					}	
				}*/
	
	
				$tiles = UserFinaoTile::model()->findAllByAttributes(array('finao_id'=>$groupfinao->user_finao_id,'createdby'=>$userid));	
	
				if(isset($tiles) && !empty($tiles))	
				{
	
					foreach($tiles as $eachtile)	
					{	
	
						$eachtile->status = '2';	
						$eachtile->save(false);	
					}
				}	
	
				// finaos deleteing
				$finaodel = UserFinao::model()->findAllByAttributes(array('user_finao_id'=>$groupfinao->user_finao_id,'updatedby'=>$userid));
				//echo $groupfinao->user_finao_id; echo $userid;	
				if(isset($finaodel) && !empty($finaodel))	
				{	
					$finaodel->finao_activestatus = '2';
					$finaodel->save(false);	
				}
	
				
				$tracked_tileids=Yii::app()->session['login']['id'];	
				$tileinfo = Tracking::model()->findAllByAttributes(array('tracked_userid'=>$tracked_tileids,'tracked_tileid'=>$tileid));
	
				if(isset($tileinfo['0']['tracking_id']))
				{	
					$tileinfo = Tracking::model()->findByAttributes(array('tracking_id'=>$tileinfo['0']['tracking_id']));	
					$tileinfo->delete();	
				}
	
				//echo "successful";
			}				
	}	
	
	// updated by ramesh
	// invite members
	
	public function actionInviteMembers()
	{
		if($_POST['membertype']=='mails')
		{//echo $_POST['groupid'];
			$getdetails = Group::model()->findByAttributes(array('group_id'=>$_POST['groupid']));
			if($getdetails)
			{
				if($getdetails->profile_image) 
				$img='http://'.$_SERVER['HTTP_HOST'].'/images/uploads/groupimages/profile/'.$getdetails->profile_image;
				else  $img='http://'.$_SERVER['HTTP_HOST'].'/images/no-image.jpg';
				
				$link='http://'.$_SERVER['HTTP_HOST'].'/easyregister?type=group&pid='.$_POST['groupid'];
				$email = $_POST["emailid"];
				$subj = "Invitation to Join Group :".$getdetails->group_name;
				$mesg='<div style="width:670px; margin:0px auto; padding:0px; background:#FFF;">
					 <div style="border:solid 2px #f47b20;"></div>
						<div style="width:650px; padding:10px; margin:0px; font-family:Geneva, Arial, Helvetica, sans-serif;">
						 <div style="color:rgb(77,77,77); font-size:13px; line-height:18px; padding-bottom:10px; margin-bottom:10px; border-bottom:dotted 1px #d6d6d6;">Hi,  I wish to invite you to the following Group</div>
						 <div style="width:100%; float:left; padding-bottom:10px;">
							 <div style="width:9%; float:left;"><img src="'.$img.'" width="50" height="50" /></div>
							 <div style="color:rgb(244, 123, 32); font-weight:bold; font-size:24px; padding-bottom:5px; width:80%; float:left; padding-top:10px;">'.$getdetails->group_name.'</div>
							</div>
						 
							<div style="color:rgb(77,77,77); font-size:13px; line-height:18px; padding-bottom:10px; margin-bottom:10px; border-bottom:dotted 1px #d6d6d6;">'.$getdetails->group_description.'</div>
							
							<div style="margin-bottom:15px; width:159px; height:19px; padding:8px 0; color:#FFF; background-color: #d84724; cursor:pointer; text-align:center; font-size:14px;
						 background: url(images/linear_bg_2.png);
						 background-repeat: repeat-x;
						 background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#d84724), to(#f27f57));
						 background: -webkit-linear-gradient(top, #f27f57, #d84724);
						 background: -moz-linear-gradient(top, #f27f57, #d84724);
						 background: -ms-linear-gradient(top, #f27f57, #d84724);
						 background: -o-linear-gradient(top, #f27f57, #d84724);  -moz-box-shadow:2px 4px 6px 0px #4d4d4d; -webkit-box-shadow:2px 4px 6px 0px #4d4d4d; box-shadow:2px 4px 6px 0px #4d4d4d;"><a href="'.$link.'">Click Here to Join Now</a>            
							</div>
							<div style="color:rgb(77,77,77); font-size:13px; line-height:18px; padding-bottom:10px;">
							 <p style="padding-bottom:5px; margin:0; color:rgb(244, 123, 32); font-size:16px;">Thanks &amp; Regards,</p>
								<p style="padding:0; margin:0;">'.Yii::app()->session['login']['username'].'.</p>
							</div>
						</div>
					</div>';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				 $headers .= "From: do-not-reply@finaonation.com";
				mail($email,$subj,$mesg,$headers);
			}
		}
	}
	
	
	public function getUserProfile($userid,$share,$groupid)

	{

		$userinfo = User::model()->findByPk($userid);
		$profileinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));
		$Criteria = new CDbCriteria();
		$Criteria->condition = "userid = '".$userid."' and finao_activestatus != 2 and IsGroup = 1 and group_id=".$groupid;
		if($userid == Yii::app()->session['login']['id'] &&  $share != "share")
		{
			$Criteria->addCondition("Iscompleted = 0","AND","IsGroup = 0", "AND");
		}

		if((isset($share) && $share=="share") || $userid != Yii::app()->session['login']['id'])
		{
			$Criteria->addCondition("finao_status_Ispublic = 1","AND");
		}		

		$Criteria->order = "updateddate DESC";
		$finaos = UserFinao::model()->findAll($Criteria);
		$latestfinao = UserFinao::model()->find(array('condition'=>'userid = '.$userid.' AND Iscompleted = 0 order by updateddate DESC'));

		if(!empty($finaos))
		{

			$Criteria = new CDbCriteria();

			$Criteria->group = 'tile_id';

			$Criteria->condition = "userid = '".$userid."'";

			$Criteria->select = "t1.tilename , t1.tile_imageurl , t1.Is_customtile, t.* ";

			if(!empty($finaos))

			{

				foreach($finaos as $finaoids):        

			    	$ids[]=$finaoids->user_finao_id;

				endforeach;

			}

			if(!empty($ids))

				$Criteria->addInCondition('finao_id', $ids);



			$Criteria->order = 'createddate DESC';

			$Criteria->join = " left join fn_tilesinfo t1 on t.tile_id = t1.tile_id and t.userid = t1.createdby ";

			$tilesinfo = UserFinaoTile::model()->findAll($Criteria);

		}

		else

		{

			$tilesinfo = "";

		}

		

		return array(

					'userid'=>$userid

					,'userinfo'=>$userinfo

					,'profileinfo'=>$profileinfo

					,'finao'=>$latestfinao

					,'tilesinfo'=>$tilesinfo

					);

	}
	
	public function actionAnnouncement()
	{
		//print_r($_POST);exit;
		$announment = new Announcement;
		$announment->uploadsourcetype = 61;
		$announment->uploadsourceid = $_POST['groupid'];
		$announment->announcement = $_POST['announcement'];
		$announment->createdby = Yii::app()->session['login']['id'];
		$announment->createddate = new CDbExpression('NOW()');
		$announment->status = 1;
		if($announment->save(false))
		{
			 $this->redirect(Yii::app()->createUrl('group/dashboard',array('groupid'=>$_POST['groupid']			                                                               )));
		} 
	}
	
	
}
