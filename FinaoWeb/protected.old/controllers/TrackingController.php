<?php

class TrackingController extends Controller

{

	public function actionTiletracking()

	{

	/*

		$userid = Yii::app()->session['login']['id'];

		echo = $userid*/

		$tiledata = $_REQUEST["tiledata"];

		//$userrelatedtotiles = UserFinaoTile::model()->findAllByAttributes(array('tile_id'=>$tiledata));

		$Criteria = new CDbCriteria();

   		$Criteria->group = 'userid';

   		$Criteria->condition = "tile_id = '".$tiledata."'";

		$tileattributes  = Lookups::model()->findByAttributes(array('lookup_id'=>$tiledata));

		$tilename = $tileattributes->lookup_name;

		$userrelatedtotiles = UserFinaoTile::model()->findAll($Criteria);

		if(empty($userrelatedtotiles))

		{

			echo "<div class='search-sort padding-15pixels'>

					<div class='orange font-20px left'>Results For ".$tilename."</div>

						</div><div id = 'backbutton' style='float:right'><a id='addfinao' class='orange-button' onclick='goback()' >Back</a></div>

							<br />No Users Found Under This Tile";

			exit;

		}

		$this->renderPartial('showrelateduser',array('userrelatedtotiles'=>$userrelatedtotiles,'tilename'=>$tilename));

	}

	public function actionFindUser()

	{

	/*

		$userid = Yii::app()->session['login']['id'];

		echo = $userid*/

		$displaytiles = Lookups::model()->findAllByAttributes(array('lookup_type'=>'tiles'));

		$this->renderPartial('showtileuser',array('displaytiles'=>$displaytiles));

	}

	public function actionTracktiles()

	{

		

		$findalltiles = Lookups::model()->findAllByAttributes(array('lookup_type'=>'tiles'));

		$this->renderPartial('tracktiles',array('findalltiles'=>$findalltiles));

	}

	public function actionSaveTracktiles()

	{

		$tileid = $_REQUEST['tileid']; 	

		$frndid = $_REQUEST['frndid'];	  	 

		$tileform = new Tracking;

		$tileform->tracker_userid = Yii::app()->session['login']['id']; 

		$tileform->tracked_userid = $frndid;

		$tileform->tracked_tileid = $tileid;

		$tileform->createddate = new CDbExpression('NOW()');

		$tileform->status = 1; //0

		
		$inc = $_REQUEST['inc'];
		$class = "unfollow-finao";
		if(empty($inc))
		{
			$inc = 0;
			$class = "orange-button";
		} 
		
		
		if(empty($tileform->tracker_userid))
		{
			
			 echo "<div id = 'trackid-'".$frndid." > <input class='".$class."' type='button' value='Please Login To Follow FINAO'></div>";
		}
		else 
		{
			if($tileform->save())
	
			{
				 
				
				echo "<input type='button' value='Unfollow' onclick='getuntracktileid(".$tileid.",".$frndid.",".$inc.")' class='".$class."'>
				";
				 
			}
		}

		

	}

	

	public function actionDeleteTracktiles()

	{

		$tileid = $_REQUEST['tileid']; 	
		$frndid = $_REQUEST['frndid'];
		$inc = $_REQUEST['inc'];
		$class = "follow-finao";
		if(empty($inc))
		{
			$inc = 0;
			$class = "orange-button";
		} 
		$userid = Yii::app()->session['login']['id'];
		
		$tileform1 = Tracking::model()->findByAttributes(array('tracker_userid'=>$userid , 'tracked_tileid'=>$tileid ,'tracked_userid'=>$frndid));
		//old code
		//$tileform1 = Tracking::model()->findByAttributes(array('tracker_userid'=>$userid , 'tracked_tileid'=>$tileid ,'status'=>1,'tracked_userid'=>$frndid));
		//print_r($tileform1);
		if($tileform1->delete())
		{//Commented by varma on 22032013

			echo " <input class='".$class."' type='button' onClick='gettileid(".$tileid.",".$frndid.",".$inc.")' value='Follow FINAO' />";

		}

		

	}

	public function actionAcceptTracktiles()

	{
		   $tileid = $_POST['tileid']; 	
		    $tracker = $_POST['tracker']; 
		$userid = Yii::app()->session['login']['id'];

		$tileaccept = Tracking::model()->findByAttributes(array('tracker_userid'=>$tracker ,                                                                 'tracked_tileid'=>$tileid ,                                                                 'tracked_userid'=>$userid));
		$tileaccept->status = 1;

		if($tileaccept->save(false))

		{

			echo "Accepted";

		}

	}

	public function actionRejectTracktiles()

	{

	

		$tileid = $_POST['tileid']; 	

		$tracker = $_POST['tracker'];	 

		$userid = Yii::app()->session['login']['id'];

		$tileaccept = Tracking::model()->findByAttributes(array('tracker_userid'=>$tracker , 'tracked_tileid'=>$tileid , 'tracked_userid'=>$userid));

		$tileaccept->status = 2;

		if($tileaccept->save())

		{

			echo "Rejected";

		}

	}

	public function actionGetTrackingStatus()

	{

		

		$userid = $_POST['userid'];

		$tileid = $_POST['tileid'];
		
		$inc = $_POST['inc'];
		$class= "unfollow-finao";
		if(empty($inc))
		{
			$inc = 0;
			$class= "orange-button";
		}

		$trackeruserid = Yii::app()->session['login']['id'];

		$trackstatus = Tracking::model()->findByAttributes(array('tracked_tileid'=>$tileid,'tracked_userid'=>$userid,'tracker_userid'=>$trackeruserid));

		

		if(isset($trackstatus))

		{

			if($trackstatus->status == 1)

			{

				
				echo '<div id = "track'.$inc.'"><input class="'.$class.'" type="button" onClick ="getuntracktileid('.$tileid.','.$userid.','.$inc.')" value = "Unfollow" ></div>';

			}
			elseif($trackstatus->status == 2)
			{
				echo '<div id = "track'.$inc.'"><input class="'.$class.'" type="button" value = "Unfollow" ></div>';
			}
			else

			{

				echo '<input class="orange-button" type="button" value="Request Pending">';

			}

		}

		else

		{
            
			if(!empty($inc))
			{
			 
			$class= "follow-finao";
			}
			
			echo '<div id = "track'.$inc.'"><input class="'.$class.'" type="button" onClick="gettileid('.$tileid.','.$userid.','.$inc.')" value = "Follow FINAO"></div>';

		}

	}

	public function actionCounttiles()

	{

	if($_REQUEST['type']=='0')
	{
		$connection = yii::app()->db;
		$sql="update fn_tracking set view_status = 1 where tracked_userid='".$_REQUEST['from']."'";
		$command=$connection->createCommand($sql)->execute();
		$sql1="update fn_notes set view_status = 1 where tracked_userid='".$_REQUEST['from']."'";
		$command=$connection->createCommand($sql1)->execute();
	}
	else 
	{
		$userid = $_POST['userid'];

		$tileform2 = Tracking::model()->findAllByAttributes(array('tracked_userid'=>$userid ,'status'=>0)); 

		$notificationcount = count($tileform2);

		if($notificationcount-1 > 0)

		echo($notificationcount-1);
	}
		

	}

	public function actionNotifications()
	{

		$userid = Yii::app()->session['login']['id'];
		
		// old code
		
		/*$criteria = new CDbCriteria();
		$criteria->join = " join fn_user_finao_tile t1 on t.tracked_tileid = t1.tile_id and t.tracker_userid = t1.userid ";
		$criteria->join .= " join fn_user_finao t2 on t1.finao_id = t2.user_finao_id  and finao_activestatus = 1 and finao_status_Ispublic = 1 and Iscompleted = 0 ";
		$criteria->group = " t1.tile_id, t1.tile_name,t1.userid";
		$criteria->condition = " t.tracked_userid = ".$userid." and t.status = 0";
		$criteria->select = "t.*, t1.tile_name";
		//print_r($criteria);exit;
		$tileform2 = Tracking::model()->findAll($criteria);
		$this->renderPartial('notifications',array('tiles'=>$tileform2,'userid'=>$userid));*/

		//old code end 
		$Criteria = new CDbCriteria();

		$Criteria->condition = "tracked_userid = '".$userid."' AND status = '1' and view_status='0'";

		$Criteria->order = "tracking_id desc";

		$tileforms = Tracking::model()->findAll($Criteria);
		
		//$notes = Notess::model()->findByAttributes(array('tracker_userid'=>$userid,'view_status'=>0));
		
		$notes = new CDbCriteria();

		$notes->condition = "tracked_userid = '".$userid."' and view_status='0'";

		$notes->order = "note_id desc";

		$notes = Notess::model()->findAll($notes);		
		
		
		
		//$tileforms= Tracking::model()->findAllByAttributes(array('tracked_userid'=>$userid ,'status'=>1)); 
		//echo $tileforms[0]['tracking_id'];exit;
		$this->renderPartial('notifications',array('tiles'=>$tileforms,'userid'=>$userid,'notes'=>$notes));
      // print_r($tileform2);exit;
		//$this->renderPartial('notifications',array('tiles'=>$tileform2,'userid'=>$userid));
	}

	public function actionViewTracking()

	{

		$userid = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];

		$imtracking = Tracking::model()->findAllByAttributes(array('tracker_userid'=>$userid,'status'=>1));

		$trackingme = Tracking::model()->findAllByAttributes(array('tracked_userid'=>$userid,'status'=>1));

		$imtracking =  (!empty($imtracking)) ? count($imtracking) : 0;

		$trackingme = (!empty($trackingme)) ? count($trackingme) : 0;

		echo "<p>I'm Tracking : <span class='bolder'>".$imtracking."</span></p>

                        <p>Tracking Me : <span class='bolder'>".$trackingme."</span></p>

                        <p>Total Hits: <span class='bolder'>0</span></p>";

	}

	
	/*public function displayYourTracking($userid,$share,$type,$tileid)
	{
		$tiletxt = isset($tileid) ? (($tileid != "") ? 'and tracked_tileid = '.$tileid : "")  : "" ;
		
		//echo $type;exit;
		if($type == "yourtracking")
			$imtracking = Tracking::model()->findAllByAttributes(array('tracker_userid'=>$userid,'status'=>1));
		elseif($type == "trackingyou")

		{
		//$imtracking = Tracking::model()->findAll(array('condition'=>'tracked_userid = '.$userid .' and status=1 or status=2'.$tiletxt,'select'=>tracker_userid,'group'=>tracker_userid,'distinct'=>true));	
			$imtracking = Tracking::model()->findAll(array('condition'=>'tracked_userid = '.$userid .' and status=1 or status=2'.$tiletxt));		
			//$imtracking = Tracking::model()->findAll(array('condition'=>'tracked_userid = '.$userid .' and status=1 or status=2'.$tiletxt));
			
			$criteria = new CDbCriteria();
			$criteria->join = ' join fn_user_finao t1 ON t.finao_id = t1.user_finao_id';
			$criteria->join .= ' join fn_tracking t2 on t.tile_id = t2.tracked_tileid';
			$criteria->condition = ' t1.finao_status_Ispublic =1 and t2.tracked_userid = '.$userid;
			$criteria->group = ' t.tile_id,t.tile_name'; 
			$findalltiles = UserFinaoTile::model()->findAll($criteria);												
		}

		return array('findalltiles'=>$findalltiles
								,'type'=>$type
								,'imtracking'=>$imtracking
								,'userid'=>$userid
								,'tileid'=>$tileid 
								,'share'=>$share
								);

	}*/
	
	public function displayYourTracking($userid,$share,$type,$tileid)
	{
		$tiletxt = isset($tileid) ? (($tileid != "") ? 'and tracked_tileid = '.$tileid : "")  : "" ;
		
		if($type == "yourtracking")
			$imtracking = Tracking::model()->findAllByAttributes(array('tracker_userid'=>$userid,'status'=>1));
		elseif($type == "trackingyou")
		{
			// old code
			//$imtracking = Tracking::model()->findAll(array('condition'=>'tracked_userid = '.$userid .' and status=1 '.$tiletxt,'select'=>'distinct tracker_userid'));
			$imtracking = Tracking::model()->findAll(array('condition'=>'tracked_userid = '.$userid .' and status!=0 '.$tiletxt,'select'=>'distinct tracker_userid'));

			$criteria = new CDbCriteria();
			$criteria->join = ' join fn_user_finao t1 ON t.finao_id = t1.user_finao_id';
			$criteria->join .= ' join fn_tracking t2 on t.tile_id = t2.tracked_tileid';
			$criteria->condition = ' t1.finao_status_Ispublic =1 and t2.tracked_userid = '.$userid;
			$criteria->group = ' t.tile_id,t.tile_name'; 
			$findalltiles = UserFinaoTile::model()->findAll($criteria);												
		}

		return array('findalltiles'=>$findalltiles
								,'type'=>$type
								,'imtracking'=>$imtracking
								,'userid'=>$userid
								,'tileid'=>$tileid 
								,'share'=>$share
								);

	}

	public function actionYourTracking()
	{
		$userid = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];
		$share = $_POST['share'];
		$type = $_POST['type'];
		/*$tileid = isset($_POST['tileid']) ? (($_POST['tileid'] != "") ? 'and tracked_tileid = '.$_POST['tileid'] : "")  : "" ;*/
		//echo $_POST['tileid'];exit;
		$trackingarray = $this->displayYourTracking($userid,$share,$type,$_POST['tileid']);
		
		$this->renderPartial('_yourtracking',array('findalltiles'=>$trackingarray['findalltiles']
								,'type'=>$trackingarray['type']
								,'imtracking'=>$trackingarray['imtracking']
								,'userid'=>$userid
								,'tileid'=>$_POST['tileid']
								,'share'=>$share
								));
	}
	
	//block un block code
	
	public function actionChangeStatusblock()
	{
		$connection = yii::app()->db;
		$sql="update fn_tracking set status = '".$_POST['status']."' where tracker_userid='".$_POST['tracker_userid']."' and tracked_userid=".Yii::app()->session['login']['id'];
		echo $sql;//exit;
		$command=$connection->createCommand($sql)->execute();		
	}
	
	
	public function displayYourGroupTracking($userid,$share,$type,$tileid,$groupid)
	{
		$tiletxt = isset($tileid) ? (($tileid != "") ? 'and tracked_tileid = '.$tileid : "")  : "" ;
		
		if($type == "yourtracking")
			$imtracking = Tracking::model()->findAllByAttributes(array('tracker_userid'=>$userid,'status'=>1));
		elseif($type == "trackingyou")
		{
			// old code
			//$imtracking = Tracking::model()->findAll(array('condition'=>'tracked_userid = '.$userid .' and status=1 '.$tiletxt,'select'=>'distinct tracker_userid'));
			$imtracking = Tracking::model()->findAll(array('condition'=>'tracked_userid = '.$userid .' and status!=0 '.$tiletxt,'select'=>'distinct tracker_userid'));

			$criteria = new CDbCriteria();
			$criteria->join = ' join fn_user_finao t1 ON t.finao_id = t1.user_finao_id and t1.group_id='.$groupid.'';
			$criteria->join .= ' join fn_tracking t2 on t.tile_id = t2.tracked_tileid';
			$criteria->condition = ' t1.finao_status_Ispublic =1 and t2.tracked_userid = '.$userid;
			$criteria->group = ' t.tile_id,t.tile_name'; 
			$findalltiles = UserFinaoTile::model()->findAll($criteria);												
		}

		return array('findalltiles'=>$findalltiles
								,'type'=>$type
								,'imtracking'=>$imtracking
								,'userid'=>$userid
								,'tileid'=>$tileid 
								,'share'=>$share
								);

	}
	
	
	public function actionGetGroupStatus()
	{
		$userid = $_POST['userid'];
		$tileid = $_POST['tileid'];		
		$inc = $_POST['inc'];
		if(empty($inc))
		{
			$inc = 0;
			$class= "orange-button";
		}
		$trackeruserid = Yii::app()->session['login']['id'];
		$trackstatus = Tracking::model()->findByAttributes(array('tracked_tileid'=>$tileid,'tracked_userid'=>$userid,'tracker_userid'=>$trackeruserid));	
		if(isset($trackstatus))
		{
			if($trackstatus->status == 1)
			{				
				echo '<a onclick="unfollow_groups('.$userid.','.$tileid.')" class="white-link font-12px"  href="javascript:void(0)" >Unfollow Group</a>';
			}
			else
			{
				echo '<a class="white-link font-12px" href="javascript:void(0)" >Unfollow</a>';
			}
		}
		else
		{            
			echo '<a class="white-link font-12px" href="javascript:void(0)" onclick="follow_groups('.$userid.','.$tileid.')" >Follow Group</a>';
		}
	}
	 // follow and unfollow code  for group controller
 public function actionTracking()
 {
 	//print_r($_POST);exit;
	$tracked_userid=$_POST['userid'];
	$tracked_groupid=$_POST['groupid'];
	$tracker_userid=Yii::app()->session['login']['id'];
	$result = GroupTracking::model()->findByAttributes(array('tracker_userid'=>$tracker_userid,'tracked_groupid'=>$tracked_groupid,'tracked_userid'=>$tracked_userid));
	
	if(count($result) =='0')
	{
		$connection = yii::app()->db;
		$sql="insert into  fn_group_tracking set tracker_userid = '".$tracker_userid."',tracked_groupid='".$tracked_groupid."',tracked_userid='".$tracked_userid."',createddate='".date('y-m-d')."',status='1'";
		//print_r($sql);exit;
		$command=$connection->createCommand($sql)->execute();
		echo "UnJoin Group";
	}
	else 
	{
	   $connection = yii::app()->db;
		$sql="delete from fn_group_tracking where tracker_userid = '".$tracker_userid."' and tracked_groupid='".$tracked_groupid."' and tracked_userid='".$tracked_userid."'";
		
		//print_r($sql);exit;
		$command=$connection->createCommand($sql)->execute();
		echo "Join Group";
	}
	
 } 
 // group model
	public function actionGroupSaveTracktiles()

	{
		$tileid = $_REQUEST['tileid']; 	

		$frndid = $_REQUEST['frndid'];	  	 

		$tileform = new Tracking;

		$tileform->tracker_userid = Yii::app()->session['login']['id']; 

		$tileform->tracked_userid = $frndid;

		$tileform->tracked_tileid = $tileid;
		
		$tileform->tracked_type = 61;

		$tileform->createddate = new CDbExpression('NOW()');

		$tileform->status = 1; //0
		$userid = Yii::app()->session['login']['id'];
		
		$inc = $_REQUEST['inc'];
		$class = "unfollow-finao";
		if(empty($inc))
		{
			$inc = 0;
			$class = "orange-button";
		} 	
		
		if(empty($tileform->tracker_userid))
		{			
			 echo "<div id = 'trackid-'".$frndid." > <input class='".$class."' type='button' value='Please Login To Follow FINAO'></div>";
		}
		else 
		{
			if($tileform->save())
	
			{				
				echo '<a onclick="unfollow_groups('.$userid.','.$tileid.')" class="white-link font-12px"   href="javascript:void(0)" >Unfollow Group</a>';			 
			}
		}
	}
	public function actionGroupDeleteTracktiles()

	{
		$tileid = $_REQUEST['tileid']; 	
		$frndid = $_REQUEST['frndid'];
		$inc = $_REQUEST['inc'];
		$class = "follow-finao";
		if(empty($inc))
		{
			$inc = 0;
			$class = "orange-button";
		} 
		$userid = Yii::app()->session['login']['id'];
		
		$tileform1 = Tracking::model()->findByAttributes(array('tracker_userid'=>$userid , 'tracked_tileid'=>$tileid ,'tracked_userid'=>$frndid));
		if($tileform1->delete())
		{
			echo '<a href="javascript:void(0)" onclick="follow_groups('.$userid.','.$tileid.')" class="white-link font-12px"  >Follow Group</a>';
		}
	}	
	

}

