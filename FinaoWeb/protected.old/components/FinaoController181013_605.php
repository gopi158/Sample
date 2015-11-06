<?php
class FinaoController extends Controller



{



	public $selheader;



	public function actionMotivationMesg()



	{



		//$this->actionRefreshwidget('hi');



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



		



		//246,239,106,68,193,289,67



		



		///371,270,449,248,241,63



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



			//$this->redirect(array('/home'));



		  







		/* Code added for retainging the finao status when images or video is uploaded */







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



									  'journalid'=>$journalid,



									  'upload'=>$_REQUEST['upload'],



									  'menuselected'=> isset($_REQUEST['menuselected']) ? $_REQUEST['menuselected']: ""	



								);



			}



		



		$user = User::model()->findByPk($userid);



		



		



	   // $sql="SELECT * FROM `finao_tagnote` WHERE `user_id` = ".$user->mageid.""; 	

		

		$sql = "SELECT * FROM `finao_tagnote` as t1

		join catalog_product_entity_varchar as t2

		on t1.`product_id` = t2.`entity_id` and t2.`attribute_id`= 86

		where t1.`user_id` = ".$user->mageid." ";

		

		$connection=Yii::app()->db2;	



		$tagnotes=$connection->createCommand($sql)->queryAll();



		



	   $pids = array();



 		foreach($tagnotes as $tag)



		{



			$pids = $tag["product_id"];



		}



		



		/*$sql2='SELECT * FROM catalog_product_entity_varchar where entity_id in '.implode(',',$pids).' and attribute_id=86';



		$connection=Yii::app()->db2;	



		$prodimg=$connection->createCommand($sql2)->queryAll();



		*/



		//print_r($prodimg);exit;



		



		



		  



		



		$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));



		$Criteria = new CDbCriteria();



		$Criteria->condition = "userid = '".$userid."' AND Iscompleted = 0 AND finao_activestatus = 1";







		if(isset($_REQUEST['frndid']))



		{



			$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');



		}



		$Criteria->order = "updateddate DESC";

		

		//ORDER BY `fn_user_finao_tile`.`tile_name` ASC



		$finaos = UserFinao::model()->findAll($Criteria);







		if(!empty($finaos))



		{



			$Criteria = new CDbCriteria();



			$Criteria->group = 'tile_id';



			$Criteria->condition = "userid = '".$userid."'";



			if(!empty($finaos))



			{



				foreach($finaos as $finaoids):        



			    	$ids[]=$finaoids->user_finao_id;



				endforeach;



			}



			if(!empty($ids))



				$Criteria->addInCondition('finao_id', $ids);



			$Criteria->order = 'updateddate DESC';



			$tilesinfo = UserFinaoTile::model()->findAll($Criteria);



		}



		else



		{



			$tilesinfo = "";



		}



		$tileslist = $tilesinfo;



		$totaltilecount = count($tilesinfo);







		$newfinao = new UserFinao;



		$newtile = new UserFinaoTile;



		$upload = new Uploaddetails;



				



		if(!isset($_REQUEST['frndid']))



		{



			if(empty($finaos))



			{



				$AddNewfinao = "addnewfinao";



			}



		}







		$prev = "";



		$next = "";



		$noofpages = "";







		if($AddNewfinao != "addnewfinao")



		{



			$tilesdetials = $this->gettilesinfo($userid,0,(isset($_REQUEST['frndid']) ? 1 : 0));



			$tilesinfo = $tilesdetials["tileinfo"];



			$prev = $tilesdetials["prev"];



			$next = $tilesdetials["next"];



			$noofpages = $tilesdetials["noofpages"];



		}







		if(isset($_REQUEST['share']))



		{



			$share = "share";



		}



		else



		{



			$share = "no";



		}







		if(isset($_REQUEST['track']) && $_REQUEST['track']=="track")



		{



			$track = "track";



		}



		else



		{



			$track = "";



		}







		if(isset($_REQUEST['search']) && $_REQUEST['search']=="search")



		{



			$search = "search";



		}



		else



		{



			$search = "";



		}



	



		/********** Getting all the tile of the user including default tiles for populating tile band *****************/



		$tiles = Lookups::model()->findAll(array('condition'=>'lookup_type = "tiles" AND lookup_status = 1 '));



		//$tilesslider = $this->refreshtilewidget($userid,$share);



		// Added on 28-06-13 to display Tiles in work space



		$tilesslider = $this->refreshtilewidget($userid,$share,0,0,1);



		// Ends here on 28-06-13	



		/************** User Profile details **********************/



		//$Userprofarray = ProfileController::getUserProfile($userid); commented on 070713-1-45-pm



		$Userprofarray = ProfileController::getUserProfile($userid,$share);



				



		/************** Latest Finao & archive  details **********************/



		$latestfinaoarray = $this->getfinaoinfo($userid,"",$share,-1,1,0);



		$archivefinao = $this->getfinaoinfo($userid,"completed",$share,-1,1,0);



		



		/************** tracking you  details **********************/



		$trackingyoudet = TrackingController::displayYourTracking($userid,$share,"trackingyou","");



		/************** Activity of the ppl following  details **********************/



		$activityppl = $this->getmyheroesdata($userid,$share);



		/***************************************/



		



		/****************** getting counts for menu ************************/



		$menucount = array('tilescount'=>$tilesslider['totaltilecount']



						   ,'imagecount'=>$tilesslider['imgcount']



						   ,'videocount'=>$tilesslider['videocount']



						   ,'finaocount'=>$this->getfinaoinfo($userid,"",$share,-1,1,1)



						   ,'followcount'=>$this->getfollowersdetails($userid,-1,0,1)



						   	);



		



		/* Added on 19-03-2013 to display the total count of images and videos*/







		$uploadtypeimage = Lookups::model()->findByAttributes(array('lookup_name'=>'Image','lookup_type'=>'uploadtype','lookup_status'=>1));







		$uploadtypevideo = Lookups::model()->findByAttributes(array('lookup_name'=>'Video','lookup_type'=>'uploadtype','lookup_status'=>1));







		/*$images = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$uploadtypeimage->lookup_id,'uploadedby'=>$userid,'status'=>1));







		$videos = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$uploadtypevideo->lookup_id,'uploadedby'=>$userid,'status'=>1));*/







		/* Added on 27-03-2013 for facebook invite friends in finaos tracking page*/







		$logeduser = User::model()->findByPk(Yii::app()->session['login']['id']);



		if(isset($_REQUEST['url']) && $_REQUEST['url']=="logedfbreg")



		{



			$userinfo = Yii::app()->facebook->api('/me');



			if(isset($_REQUEST['error_reason']) && ($_REQUEST['error_reason']=='user_denied'))



			{ 



				Yii::app()->user->setFlash('fbusererror','You are NOT LOGGED IN.You must allow basic permission access to Login from facebook');







				$this->redirect(array('/'));



			}



			$logeduser->socialnetworkid = $userinfo['id'];



			$logeduser->socialnetwork = "facebook";



			$logeduser->save(false);



			$track = "track";



			$invitefriends = "invitefriends";



		}



		else



		{



			$invitefriends = "";



		}







		/* Ends here*/



		if(isset($_REQUEST['tileimageupload']) )



		{



			$usertileid = $_REQUEST['tileimageupload'];



			$tileimage = TilesInfo::model()->findByAttributes(array('tile_id'=>$usertileid,'createdby'=>$userid));



		}



		else



		{



			$tileimage = "";



		}



		if(isset($_REQUEST['getusertileid']) || isset($_REQUEST['tileerrormesg']))



		{



			if(isset($_REQUEST['tileerrormesg']))



				$getusertileid = $_REQUEST['tileerrormesg'];



			else if($_REQUEST['getusertileid'])



				$getusertileid = $_REQUEST['getusertileid'];



			//$tileid = UserFinaoTile::model()->findByPk($getusertileid);



			$tileid = $getusertileid;



		}



		else



		{



			$tileid = "";



			$getusertileid = "";



		}



		if(isset($_REQUEST['tileerrormesg']) && isset($_REQUEST['newtile']))



		{



			if(isset($_REQUEST['tileerrormesg']))



				$gettileid = $_REQUEST['tileerrormesg'];



			$tileinfo = TilesInfo::model()->findByAttributes(array('tile_id'=>$gettileid));



			$tileinfo->delete();



			$userfinaotile = UserFinaoTile::model()->findByAttributes(array('tile_id'=>$gettileid));



			$finaoid = $userfinaotile->finao_id;



			$userfinaotile->delete();



			$finao = UserFinao::model()->findByPk($finaoid);



			$finao->delete();



			$newtileerror = "yes";



		}



		else



			$newtileerror = "";



			



		 



		



		



		 



		//print_r($tagnotes);	exit;



		$this->render('default',array('tiles'=>$tilesinfo



										,'userid'=>$userid



										,'IsMotMsg'=>1



										,'userinfo'=>(isset($userinfo) && !(empty($userinfo))) ? $userinfo : ""



										,'menucount'=>$menucount



										,'user'=>$user



										,'isuploadprocess'=>$isuploadprocess



										,'share'=>$share



										//,'track'=>$track



										,'search'=>$search



										//,'images'=>$images



										//,'videos'=>$videos



										,'model'=>$newfinao



										,'tilesnewfinao'=>$tiles



										,'newtile'=>$newtile



										/*,'upload'=>$upload*/



										,'type'=>'tilefinao'



										,'prev'=>$prev



										,'next'=>$next



										,'noofpages'=>$noofpages



										,'totaltilecount'=>$totaltilecount



										,'logeduser'=>$logeduser



										,'invitefriends'=>$invitefriends



										,'Imgupload'=>isset($_REQUEST['imgupload']) ? $_REQUEST['imgupload'] : 0



										,'Tileimageupload'=>isset($_REQUEST['tileimageupload']) ? $_REQUEST['tileimageupload'] : 0



										,'tileimage'=>$tileimage



										,'getusertileid'=>$getusertileid



										,'tileid'=>$tileid



										,'tileimageerror'=>isset($_REQUEST['tileerrormesg']) ? "Tileimageerror" : ""



										,'errormsg'=>isset($_REQUEST['errormsg']) ? $_REQUEST['errormsg'] : ""



										,'newtileerror'=>$newtileerror



										,'tileslist'=>$tileslist



										,'tilesslider'=>$tilesslider



										,'profilelatestfinao'=>$Userprofarray['finao']



										,'profiletileinfo'=>$Userprofarray['tilesinfo']



										,'latestfinaoarray'=>$latestfinaoarray



										,'archivefinao'=>$archivefinao



										,'trackingyoudet'=>$trackingyoudet



										,'activityppl'=>$activityppl



										,'userid'=>$userid



										,'tagnotes'=>$tagnotes



										));







	}







 public function actionMail(){



	



	//$userid1=Yii::app()->session['login']['id']; 



$finaoid=$_POST['finaoid'];



$frendid=$_POST['frendid'];



$userid=$_POST['userid'];



$imageid=$_POST['imageid'];



$videoid=$_POST['videoid'];



$share=1;



$to = "customerservice@finaonation.com";







/*customerservice@finaonation.com*/



$subject = "Flag Inappropriate link";



 $name = Yii::app()->db->createCommand()



    ->select('*')



    ->from('fn_users')



    ->where('userid=:id', array(':id'=>$userid))



    ->queryRow();



	



if(isset($_REQUEST['finaoid']))



{







	



$message = "Dear Admin,







 ".$name['fname']." has marked this FINAO as inappropriate.



Please check the folllowing link 



$this->cdnurl/profile/share/finaoid/".$finaoid."/userid/".$userid."/frndid/".$frendid."/shareid/".$share." 











Thanks&regards



FINAO Team";







/*$message = "<a href='$this->cdnurl/profile/share/finaoid/'".$finaoid."'/frndid/'".$frendid."'/userid/'".$userid.'>click</a>;*/



//$message=urlencode($message);



}



else if(isset($_REQUEST['imageid']))



{



$message = "Hi,







".$name['fname']." has marked this Image as inappropriate. 



Please check the folllowing link 



$this->cdnurl/profile/share/mediaimageid/".$imageid."/userid/".$userid."/frendid/".$frendid."/shareid/".$share."











Thanks&regards



FINAO Team";



}



else if(isset($_REQUEST['videoid']))



{



$message = "Hi,







".$name['fname']." has marked this Video as inappropriate. 



Please check the folllowing link 



$this->cdnurl/profile/share/mediaid/".$videoid."/userid/".$userid."/frendid/".$frendid."/shareid/".$share."











Thanks&regards



FINAO Team";



 /*?>$message = "<a href='$this->cdnurl/profile/share/videoid/'".$videoid."'/frndid/'".$fe2."'/userid/'".$fe3.'>click</a>;<?php */



}



$from = "FINAO NATION";



//$headers = "From:" . $from;



$headers .= 'From: no-reply <noreply@finaonation.com>' . "\r\n";



mail($to,$subject,$message,$headers);







	



	}







	public function gettilesinfo($userid,$pagenum = 0,$isfrd = 0)



	{



		$Criteria = new CDbCriteria();



		$Criteria->condition = "userid = '".$userid."' AND finao_activestatus != 2";



		if($userid == Yii::app()->session['login']['id'])



		{



			$Criteria->addCondition("Iscompleted = 0","AND");



		}



		if($isfrd != 0)



		{



			$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');



		}



		$Criteria->order = "updateddate DESC";



		$finaos = UserFinao::model()->findAll($Criteria);



		$prev = "";



		$next = "";



		$noofpages = "";







		if(!empty($finaos))



		{



			$Criteria = new CDbCriteria();



			$Criteria->group = 'tile_id';



			$Criteria->condition = "userid = '".$userid."'";



			$Criteria->order = 'createddate DESC';



			foreach($finaos as $finaoids):        



		    	$ids[]=$finaoids->user_finao_id;



			endforeach;



			$Criteria->addInCondition('finao_id', $ids);



			



			$tilesinfo = UserFinaoTile::model()->findAll($Criteria);



			



			$page = ($pagenum == 0) ? 1 : $pagenum ;



			



			$tilepagearray = $this->getpagedetails($tilesinfo,1,$pagenum,6);



			$prev = $tilepagearray['prev'];



			$next = $tilepagearray['next'];



			$limit = $tilepagearray['limittxt'];



			$offset = $tilepagearray['offset'];



			$noofpages = $tilepagearray['noofpage'];



			



			$Criteria->limit = $limit;



			$Criteria->offset = $offset;



			$tilesinfo = UserFinaoTile::model()->findAll($Criteria);



		}



		else



			$tilesinfo = "";







		return array( 'tileinfo'=>$tilesinfo 



					  ,'prev'=>$prev



					  ,'next'=>$next



					  ,'noofpages'=>$noofpages);



	}







	public function refreshtilewidget($userid, $share, $pageid, $getcount)



	{



		// Added on 28-06-13 added $pageid parameter to use same func for fetching next page tiles also



		$Criteria = new CDbCriteria();



		$Criteria->condition = "userid = '".$userid."' AND finao_activestatus = 1";

		if($userid != Yii::app()->session['login']['id'] ||  $share == "share")

		{

			$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');

		}

		if($userid == Yii::app()->session['login']['id'] && $share != "share")

		{

			$Criteria->addCondition("Iscompleted = 0","AND");

		}

		$Criteria->order = "updateddate DESC";

		$finaos = UserFinao::model()->findAll($Criteria);



		if(!empty($finaos))



		{



			$Criteria = new CDbCriteria();



			$Criteria->group = 't.tile_id';



			$Criteria->condition = " t.userid = '".$userid."'";



			$Criteria->order = " t.createddate DESC ";



			$Criteria->select = "t1.tilename , t1.tile_imageurl , t1.Is_customtile, t.* ";



			foreach($finaos as $finaoids):        



			    	$ids[]=$finaoids->user_finao_id;



			endforeach;







			$Criteria->addInCondition('finao_id', $ids);



			$Criteria->join = " left join fn_tilesinfo t1 on t.tile_id = t1.tile_id and t.userid = t1.createdby ";



			$tilesinfo = UserFinaoTile::model()->findAll($Criteria);



			



			$pagetiles = $this->getpagedetails($tilesinfo,1,$pageid,18);



			$limittxt = "";



			if(isset($pagetiles))



			{



				$limittxt = $pagetiles['limittxt'];	



			}



			



			$Criteria->limit = $limittxt;



			$Criteria->offset = $pagetiles['offset'];



			



			$pagetilesinfo = UserFinaoTile::model()->findAll($Criteria);



		}



		else



		{



			$tilesinfo = "";



			$pagetilesinfo = "";



		}



			







		$user = User::model()->findByPk($userid);



		



		if($getcount)



		{



			return array('totaltilecount'=>(!empty($tilesinfo)) ? count($tilesinfo) : 0



							,'imgcount'=>$this->GetTotalCount(0,$userid,'Image',0,$share)



							,'videocount'=>$this->GetTotalCount(0,$userid,'Video',0,$share)	



							);



		}



		else{



			return array('_alltiles'=>$tilesinfo



							,'userinfo'=>$user



							,'totaltilecount'=>(!empty($tilesinfo)) ? count($tilesinfo) : 0



							,'pagetilesinfo'=>$pagetilesinfo



							,'prev'=>$pagetiles['prev']



							,'next'=>$pagetiles['next']



							,'noofpages'=>$pagetiles['noofpage']



							,'widgetstyle'=>(!empty($tilesinfo)) ? 'tile' : 'notile'



							,'imgcount'=>$this->GetTotalCount(0,$userid,'Image',0,$share)



							,'videocount'=>$this->GetTotalCount(0,$userid,'Video',0,$share)



						);



	



		}



		



	}







	public function actionRefreshwidget()

	{

		$userid = isset($_POST['userid']) ? $_POST['userid'] : $userid ;

		// Added by lakshmi on 27-03-2013 modified on 28-03-2013

		$share = (isset($_POST['isshare']))? $_POST['isshare'] : $share;

		//$tilearray = $this->refreshtilewidget($userid,$share,1,0);

		/*$this->widget('tiles',array('alltiles'=>$tilearray['alltiles']

										,'userinfo'=>$tilearray['userinfo']

										,'totaltilecount'=>$tilearray['totaltilecount']

										,'widgetstyle'=>$tilearray['widgetstyle']

										,'imgcount'=>$tilearray['imgcount']

										,'videocount'=>$tilearray['videocount']

										));	*/







	}







	







	public function actionNextPrevtiles()



	{



		$userid = $_POST['userid'];



		$pageid = $_POST['pageid'];



		$share = $_POST['share'];



		$tilesdetials = $this->refreshtilewidget($userid,$share,$pageid,0);



		$tilesinfo = $tilesdetials["pagetilesinfo"];



		$prev = $tilesdetials["prev"];



		$next = $tilesdetials["next"];



		$noofpages = $tilesdetials["noofpages"];







		$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));	







		//Commented on 26-06-13 and updated



		



		$this->renderPartial('_alltiles',array(//'userinfo'=>$userinfo



														'alltiles'=>$tilesinfo



														,'prev'=>$prev



														,'next'=>$next



														,'noofpages'=>$noofpages



														,'userid'=>$userid));



	}



	







	public function actionRenderAddFinao()







	{







		$newfinao = new UserFinao;







		$newtile = new UserFinaoTile;







		$upload = new Uploaddetails;







		 







		$userid = $_POST['userid'];







		$type = $_POST['type'];







		$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));







		$tiles = Lookups::model()->findAll(array('condition'=>'lookup_type = "tiles" AND lookup_status = 1 '));







		$this->renderPartial('newfinao',array('model'=>$newfinao,'userid'=>$userid,'tiles'=>$tiles,'newtile'=>$newtile,'upload'=>$upload,'type'=>$type,'userinfo'=>$userinfo));







	}







	public function actionAddFinao()



	{



		 //print_r($_POST);exit;



		//echo $_POST['ispublic'];exit;



		



		$newfinao = new UserFinao;



		$userid = $_POST['userid'];



		



		// for badword



		$words = str_word_count($_POST['finaomesg'], 1);



		$lastWord = array_pop($words);	



		$lastSpacePosition = strrpos($_POST['finaomesg'], ' ');



		



		$textWithoutLastWord=$_POST['finaomesg'];



			



		$tiles = FnProfanityWords::model()->findAll();



		foreach($tiles as $tiles)



		{



			if(strtolower($lastWord)==strtolower($tiles->badword))



			{



				$textWithoutLastWord = substr($_POST['finaomesg'], 0, $lastSpacePosition);



				$textWithoutLastWord.=' **** ';



			}



		}



		



		



		if(isset($_POST['finaomesg']) && $_POST['finaomesg'] != "")



			$newfinao->finao_msg = $textWithoutLastWord;







		if($_POST['ispublic']=='true') $public=1;

		else $public=0;



		$newfinao->finao_status_Ispublic = $public;



		



		/*if($_POST['ispublic']=="true")



			$newfinao->finao_status_Ispublic = $_POST['ispublic'];



		else



			$newfinao->finao_status_Ispublic = $_POST['ispublic'];*/







		$newfinao->userid = $userid;







		$newfinao->createddate = new CDbExpression('NOW()');







		$newfinao->updatedby = $userid;







		$newfinao->updateddate = new CDbExpression('NOW()');







		$newfinao->finao_status = 38;







		//if($newfinao->validate())



		//{



			if($newfinao->save(false))



			{



				$finao_id  = $newfinao->user_finao_id;



				if($_POST['filename'] && $_POST['filename'] != '' )



				{



					//$filename = $_POST['filename'];



					$filename = substr(strrchr($_POST['filename'],'/'),1);



					



					$uploaddetails  = new Uploaddetails;



		            $uploaddetails->uploadfile_path = "/images/uploads/finaoimages";			



					$uploaddetails->uploadtype = 34;



					$uploaddetails->uploadfile_name = $filename;



					$uploaddetails->upload_sourcetype = 37;



					$uploaddetails->upload_sourceid = $finao_id;



					$uploaddetails->uploadedby = $userid;



					$uploaddetails->status = 1;



					$uploaddetails->updatedby = $userid; 



					$uploaddetails->updateddate = new CDbExpression('NOW()');



					$uploaddetails->caption = $_POST['caption'];



					$uploaddetails->updatedby =$userid;



					$uploaddetails->save(false);



				}



				$newtile = new UserFinaoTile;



				//$newtile->attributes = $_POST['UserFinaoTile'];



				$newtile->tile_id = $_POST['tileid'];



				$newtile->tile_name = $_POST['tilename'];



				$newtile->finao_id = $newfinao->user_finao_id;



				$tileimgurl = $this->findvalidtileimage($_POST['tilename'],$userid);



				$newtile->tile_profileImagurl = $tileimgurl;



				$newtile->userid = $userid;



				$newtile->status = 1;



				$newtile->createddate = new CDbExpression('NOW()');



				$newtile->createdby = $userid;



				$newtile->updateddate = new CDbExpression('NOW()');



				$newtile->updatedby = $userid;



				if($newtile->save(false))



				{



					$tilename = $_POST['tilename'];



					$istileinfo = TilesInfo::model()->findByAttributes(array('tilename'=>$tilename,'createdby'=>$userid));



					if(!isset($istileinfo) && empty($istileinfo))



					{



					        $tileinfo = new TilesInfo;



							$tileinfo->tile_id = $_POST['tileid'];



							$tileinfo->tilename = $_POST['tilename'];;



							$tileinfo->tile_imageurl = $tileimgurl;//$this->findvalidtileimage($_POST['tilename'],$userid);;



							$tileinfo->status = 1;



							$tileinfo->createdby = $userid;



							$tileinfo->createddate = new CDbExpression('NOW()');



							$tileinfo->updateddate = new CDbExpression('NOW()');



							$tileinfo->updatedby = $userid;



							$tileinfo->save(false);



						}



				}







				$this->addTrackingNotifications($userid,$newtile->tile_id,'Added FINAO',$newfinao->user_finao_id,0);



				//echo $newtile->tile_id.'-'.$finao_id;



				echo $newtile->tile_id;



			}



			else



			{







				echo "Something went wrong";







			}







	//	}







	//	else







	//	{







		//	echo "Please Fill Mandatory Fields";







		//}







	







	







}







	public function actionGetFinaoMessages()



	{ 



	



		







		$userid = $_REQUEST['userid'];



		



		$share = (isset($_REQUEST['share'])) ? $_REQUEST['share'] : "" ;



		//print_r($share);exit;



		$heroupdate = (isset($_REQUEST['heroupdate'])) ? $_REQUEST['heroupdate'] : "" ;



		$finaoid = (isset($_REQUEST['finaoid']) && $_REQUEST['finaoid'] != "" ) ?  $_REQUEST['finaoid'] : 0;



		//$usertileid = (isset($_REQUEST['usertileid']) && $_REQUEST['usertileid'] != "") ? $_REQUEST['usertileid'] : 0 ;



		



		$completed = "";



		$tileid = 0;



		$finaoidarray = "";



		$alltiles = $this->gettileSqlquery($userid);



		$userinfo = User::model()->findByPk($userid);



		



		$Criteria = new CDbCriteria();



		$Criteria->condition = " t.userid = '".$userid."' AND finao_activestatus = 1";



		if($share=="share" || $userid != Yii::app()->session['login']['id'])



		{



			$Criteria->addCondition("finao_status_Ispublic = 1","AND");



		}







		if(isset($_REQUEST['iscompleted']) && $_REQUEST['iscompleted']=="completed")



		{



			$completed = "completed";



		}



		elseif(isset($_REQUEST['iscompleted']) && $_REQUEST['iscompleted']=="all")



		{



			$completed = "all";



		}



		else



		{



			$completed = "";



		}







		if($userid == Yii::app()->session['login']['id'] && $share != "share")



		{



			if($completed == "")



				$Criteria->addCondition("Iscompleted = 0","AND");



			else



				$Criteria->addCondition("Iscompleted = 1","AND");	







		}







		if(isset($_REQUEST['tileid']) && $_REQUEST['tileid']!=0)



		{



			$tileid = $_REQUEST['tileid'];



			$finaoidarray = UserFinaoTile::model()->findAll(array('condition'=>'tile_id = "'.$tileid.'" AND userid = "'.$userid.'"'));



			$tileinfo = TilesInfo::model()->findAll(array('condition'=>'tile_id = "'.$tileid.'" AND createdby = "'.$userid.'"'));



			



			$Criteria->join = ' join fn_user_finao_tile t1 on t.user_finao_id = t1.finao_id and t.userid = t1.userid ';



			$Criteria->join .= ' join fn_tilesinfo t2 on t1.tile_id = t2.tile_id and t1.userid = t2.createdby ';



			$Criteria->condition .= ' and t1.tile_id = '. $tileid;



			$Criteria->condition .= ' and t1.status = 1 ';



		}



		



		/* Added on 12-03-2013 for pagination of finaos*/



		$Criteria->order = "updateddate DESC";



		$finaos = UserFinao::model()->findAll($Criteria);







		if(isset($_REQUEST['pageid']) && $_REQUEST['pageid']!= 0)



		{



			$type = $_REQUEST['type'];



			$page = $_REQUEST['pageid'];



		}



		else



		{



			$page = 1;



		}







		$finaoarray = $this->getpagedetails($finaos,1,$page,1);



		$noofpages = $finaoarray['noofpage'];



		$prev = $finaoarray['prev'];



		$next = $finaoarray['next'];



		



		//print_r($noofpages);



		



		$Criteria->limit = $finaoarray['limittxt'];//$limit;



		$Criteria->offset = $finaoarray['offset'];//$offset;



	



		$allfinaos = UserFinao::model()->findAll($Criteria);



		/* Ended on 12-03-2013 for pagination of finaos*/



		



		if(isset($finaoid) && $finaoid != 0)



		{



			$Criteria->condition .= 'and user_finao_id = "'.$finaoid.'" ';



			$finaofound = false;



			



			for($j=0, $curpag = 1; $j < $noofpages; $j++, $curpag++)



			{



				if($finaos[$j]["user_finao_id"] == $finaoid)



				{



					if($j+1 < $noofpages)



					{



						$next = $curpag + 1;



						if($j-1 == 0)



							$prev = 1;	 



						if($j-1 > 0)



							$prev = $curpag - 1;



					}



					else



					{



						$next = 1;



						$prev = $noofpages - 1;



					}	



				}



			}







		}



		$getfinaos = UserFinao::model()->findAll($Criteria);







		foreach($getfinaos as $finaoids){



			$fds[]=$finaoids->user_finao_id;



			$finaoid = $finaoids->user_finao_id;



		}        



	



		if($completed != ""){



			$Criteria = new CDbCriteria();



			$Criteria->condition = ' userid = '.$userid;



			if(isset($fds))



					$Criteria->addInCondition('finao_id', $fds);



			$finaoidarray = UserFinaoTile::model()->findAll($Criteria);



			$tileinfo = TilesInfo::model()->findAll(array('condition'=>'tile_id = "'.$finaoidarray[0]->tile_id.'" AND createdby = "'.$userid.'"'));



		}







		$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));







		$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Image'));



		



		$Criteria = new CDbCriteria();



		$Criteria->condition = "upload_sourcetype = ".$sourcetypeid->lookup_id . " and status = 1 and (`uploadfile_path` != '' or  `video_img` !='') "; 



		if(isset($fds))



			$Criteria->addInCondition('upload_sourceid', $fds);



			



			//$Criteria->condition = "";



			//$Criteria->addCondition("uploadfile_path != ''", 'AND');



			//$Criteria->addCondition("video_img != ''", 'AND');



			



		$Criteria->order = "updateddate DESC";



		



		$getimages = Uploaddetails::model()->findAll($Criteria);



						



		$uploadarray = $this->getpagedetails($getimages,1,1,1);



		$limitImg = $uploadarray["limittxt"];



		//print_r($uploadarray);



		$imgVidPrevNext = array(



							'noofpagImgVid'=>$uploadarray["noofpage"] 



							,'prevImg'=>$uploadarray["prev"] 



							,'nextImg'=>$uploadarray["next"] 



							);



						



		



		$Criteria->limit = $limitImg;







		$getimages = Uploaddetails::model()->findAll($Criteria);



		



		$getimagesdetails = array();



		$getimagesdetails = $this->getImageResizeValue($getimages);







		$finaostatus = Lookups::model()->findAll(array('condition'=>'lookup_type = "finaostatus" AND lookup_status=1'));



		



		$count = $this->GetMediaJournalCount($getfinaos[0]->user_finao_id);



		$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));



		



		$this->renderPartial('_displayfinaos',array('allfinaos'=>$getfinaos







														,'status'=>$finaostatus







														,'userid'=>$userid







														,'prev'=>$prev







														,'next'=>$next







														,'page'=>$page







														,'noofpages'=>$noofpages







														,'tileid'=>$tileid







														,'totImgCount'=>$this->GetTotalCount($tileid,$userid,'Image',0,0)







														,'totVidCount'=>$this->GetTotalCount($tileid,$userid,'Video',0,0)







														,'latestImgUrl'=>$this->Getlatestfile($tileid,$userid,'Image')







														,'latestVidUrl'=>$this->Getlatestfile($tileid,$userid,'Video')







														,'getimages'=>$getimages







														,'share'=>$share







														//,'tileinfo'=>$finaoidarray



														,'tileinfo'=>$tileinfo







														,'userinfo'=>$userinfo







														,'completed'=>$completed







														,'alltiles'=>$alltiles







														,'getimagesdetails'=>$getimagesdetails







														,'userinfo'=>$userinfo



														,'heroupdate'=>$heroupdate



														,'imgVidPrevNext'=>$imgVidPrevNext



														//,'cntjournal'=>count($journal)



														



														//,'finaoimgcnt'=>$finaoimgcnt



														



														//,'finaovidcnt'=>$finaovidcnt



														,'finaoimgcnt'=>$count['fnimgcount']



														,'cntjournal'=>$count['journalcount']



														,'finaovidcnt'=>$count['fnvidcount']



														//,'tileinfo'=>$tileinfo



														,'tileinfo_id'=>$tileinfo[0][tilesinfo_id]



													));



	



	



	



	}



	public function GetMediaJournalCount($finaoid)



	{



		$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));



		



		$Criteria = new CDbCriteria();



		$Criteria->condition = "upload_sourcetype = ".$sourcetypeid->lookup_id . " and status = 1 ";



		$Criteria->addCondition('upload_sourceid = "'.$finaoid.'"',"and");



				



		$getimages = Uploaddetails::model()->findAll($Criteria);



		$finaovidcnt = 0; $finaoimgcnt = 0;



		



		foreach($getimages as $eachdet)



		{



			if($eachdet->uploadtype == 34)// 34 is the lookupid for Images



			{



				$finaoimgcnt++;



			}



			if($eachdet->uploadtype == 35)//35 is the lookupid for Video



			{



				$finaovidcnt++;



			}



		}



		



		$Criteria = new CDbCriteria();



		$Criteria->addCondition('finao_id = "'.$finaoid.'"',"and");



		$Criteria->addCondition('journal_status = 1',"and");



		$journal = UserFinaoJournal::model()->findAll($Criteria);



		



		return array('journalcount'=>(isset($journal) && $journal != "") ? count($journal) : 0



									,'fnimgcount'=>$finaoimgcnt



									,'fnvidcount'=>$finaovidcnt);



	}







	public function GetTotalCount($tileid,$userid,$uploadtype,$finaoid,$share)







	{ 



	        if($uploadtype == "Image")



			{



				$utype = "(34,62)";



				$uploadconditon = "uploadfile_name != '' and ";



			}



			if($uploadtype == "Video")



			{



				$utype = "(35,62)";



				$uploadconditon = "(videoid != '' or video_embedurl !='') and";



			}



			



			



			if($userid != Yii::app()->session['login']['id'] or  $share == "share")



			{



			$condition = " t2.finao_status_Ispublic = 1 and";



			}



			



		$tilecount = 0;



		$wherefinao = ($finaoid != 0) ? " t2.user_finao_id = ".$finaoid : " 1=1 ";



		$wheretilefinao = ($finaoid != 0) ? " t1.finao_id = ".$finaoid : "1=1";



		$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>$uploadtype));



		$sourcetypeidfinao = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));



		$sourcetypeidtile = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'tile'));



		$sourcetypeidjournal = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'journal'));



		$whereclause = ($tileid > 0) ? " t1.tile_id = ".$tileid . " and " : "";



		$sql = "select sum(cntValue) as sumval from (







				SELECT count(distinct t.uploaddetail_id ) cntValue FROM 







				`fn_uploaddetails` t



				join fn_user_finao_tile t1 on t.upload_sourceid = t1.finao_id and upload_sourcetype = ".$sourcetypeidfinao->lookup_id."



				join fn_user_finao t2 on t1.finao_id = t2.user_finao_id and t2.finao_activestatus = 1 and t2.Iscompleted = 0



				where " .$whereclause . " 



					  uploadtype in ".$utype." and 



					  ".$condition." 



					   uploadedby = ".$userid." and ".$uploadconditon."  t1.status = 1 and t.status = 1



					  and ".$wherefinao."







				union all







				SELECT count(distinct t.uploaddetail_id) FROM 



				`fn_uploaddetails` t



				join fn_user_finao_tile t1 on t.upload_sourceid = t1.tile_id and upload_sourcetype = ".$sourcetypeidtile->lookup_id."



				where " .$whereclause . "



					  uploadtype = ".$typeid->lookup_id."



					  and uploadedby = ".$userid." and t1.status = 1 and t.status = 1



					  



					  and EXISTS (select * from fn_user_finao_tile t1 join fn_user_finao t2 on t1.finao_id = t2.user_finao_id where  ".$whereclause." t2.finao_activestatus != 2 and t2.Iscompleted = 0 and ".$wherefinao.")



					  and ".$wheretilefinao."



					  







				union all







				SELECT count(distinct t.uploaddetail_id) FROM 







				`fn_uploaddetails` t



				join fn_user_finao_journal t3 on t.upload_sourceid = t3.finao_journal_id



				join fn_user_finao_tile t1 on t3.finao_id = t1.finao_id



				join fn_user_finao t2 on t1.finao_id = t2.user_finao_id and t2.finao_activestatus != 2 and t2.Iscompleted = 0



				where " .$whereclause . "



						upload_sourcetype = ".$sourcetypeidjournal->lookup_id." 



						and uploadtype = ".$typeid->lookup_id." and



						 ".$condition."



						 uploadedby = ".$userid." and t1.status = 1 and t.status = 1



						and ". $wherefinao . "



						



				) tab







				";







		$connection=Yii::app()->db; 







		$command=$connection->createCommand($sql);







		$uploadinfo = $command->queryAll();







		//print_r($sql);		//print_r($uploadinfo);exit;







		foreach($uploadinfo as $cnt)







		{







			$tilecount = $cnt["sumval"];







		}







			







		return $tilecount;







	



	}







	







	public function Getlatestfile($tileid,$userid,$uploadtype)







	{







		$sql = $this->getUploadDetailsSQlScript($tileid,$uploadtype,$userid,' limit 0,1 ',0,0,'0');		



		



		$connection=Yii::app()->db; 







		$command=$connection->createCommand($sql);







		$uploadinfo = $command->queryAll();







		$imageurl = "";







		







		foreach($uploadinfo as $filepath)







		{







			if($uploadtype == 'Image')







				$imageurl = $this->cdnurl."/".$filepath["uploadfile_path"]."/".$filepath["uploadfile_name"];







			else if($uploadtype == 'Video')	







				$imageurl = $filepath["video_img"];







		}







			







		return $imageurl;		







	}







	







	public function actionUpdateFinao()



	{ 



 







		$userid = $_POST['userid'];



		$newtileimage = $_POST['newtileimage'];







		$finaoid = $_POST['finaoid'];







		$tileid = (isset($_POST['tileid'])) ? $_POST['tileid'] : 0;



		



		if($this->findvalidtileimage($tilename,$userid)=='')



			$src=$newtileimage;	



		else $src=$this->findvalidtileimage($tilename,$userid);







		$edit = UserFinao::model()->findByPk($finaoid);



		if(isset($_POST['statusid']))



		{



			$page = $_POST['page'];



			$statusid = $_POST['statusid'];



			$finaostatus = Lookups::model()->findAll(array('condition'=>'lookup_type = "finaostatus" AND lookup_status=1'));



			$edit->finao_status = $statusid;



		}



		if(isset($_POST['finaomesg']))	



		{



		$words = str_word_count($_POST['finaomesg'], 1);



		  $lastWord = array_pop($words); 



		  $lastSpacePosition = strrpos($_POST['finaomesg'], ' ');



		  



		  $textWithoutLastWord=$_POST['finaomesg'];



		   



		  $tiles = FnProfanityWords::model()->findAll();



		  foreach($tiles as $tiles)



		  {



		   if(strtolower($lastWord)==strtolower($tiles->badword))



		   {



		    $textWithoutLastWord = substr($_POST['finaomesg'], 0, $lastSpacePosition);



		    $textWithoutLastWord.=' **** ';



		   }



		  }   



		   



  			 $finaomesg = $textWithoutLastWord;



			$edit->finao_msg = $finaomesg;



		}



		if(isset($tileid) && $tileid != 0)



		{



			$tilename = $_POST['tilename'];



			$newtile = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));



			$newtile->tile_id = $tileid;



			$newtile->tile_name = $tilename;



			$newtile->tile_profileImagurl = $src; //strtolower($tilename);



			$newtile->updateddate = new CDbExpression('NOW()');



			$newtile->updatedby = $userid;



			$newtile->save(false);



			



			// tile info update



			$newtile = TilesInfo::model()->findByAttributes(array('tile_id'=>$tileid,'createdby'=>$userid));



			if(count($newtile)=='0')



			{



				$dates=date('Y-m-d G:i:s');



				$connection = yii::app()->db;



				$sql="insert into fn_tilesinfo set tile_id = '".$tileid."',tilename='".$tilename."',tile_imageurl='".$src."',status='1',createdby='".$userid."',createddate='".$dates."',updatedby='".$userid."'";



				$command=$connection->createCommand($sql)->execute();



			}			



		//	$tileinfo_id = $_POST['tileinfo_id'];



		//	$connection = yii::app()->db;



			//$sql="update fn_tilesinfo set tile_id = '".$tileid."',tilename='".$tilename."',tile_imageurl='".$src."' where tilesinfo_id='".$tileinfo_id."'";



			//$command=$connection->createCommand($sql)->execute();



		}



		$edit->updatedby = $userid;



		$edit->updateddate = new CDbExpression('NOW()');



		if($edit->save(false))



		{



			if(isset($_POST['finaomesg']))



			{



				$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));



				$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Updated FINAO',$finaoid,0);



			}



			else if(isset($_POST['statusid']))



			{



				$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));







				$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Changed FINAO status',$finaoid,0);



			}







			else if(isset($tileid))



			{



				$this->addTrackingNotifications($userid,$tileid,'Moved tile',$finaoid,0);



			}



			if(isset($statusid))



			{



				if($page=="singlefinao")



				{



					$this->renderPartial('_singlefinao',array('finaoinfo'=>$edit,'status'=>$finaostatus,'userid'=>$userid));



				}



				elseif($page=="allfinaos")



				{



					echo $edit->user_finao_id;



				}



			}







			elseif(isset($finaomesg))







				echo ucfirst($edit->finao_msg);







			elseif(isset($tileid) && $tileid != 0)







				echo $newtile->tile_id;







		}







		







	}







	public function actionGetAllTiles()







	{







		$userid = $_POST['userid'];



		



		$share = $_POST['share']; // Added on 26-06-13







		// Added on 26-06-13



		$frndid = ($share == "share" || $userid == Yii::app()->session['login']['id']) ? 0: 1;



		$tilesdetials = $this->gettilesinfo($userid,0,$frndid);







			$tilesinfo = $tilesdetials["tileinfo"];







			$prev = $tilesdetials["prev"];







			$next = $tilesdetials["next"];







			$noofpages = $tilesdetials["noofpages"];



		// ends here







		//$this->renderPartial('_mytiles',array('alltiles'=>$tilesinfo));



		$this->renderPartial('_alltiles',array('userid'=>$userid,'alltiles'=>$tilesinfo,'prev'=>$prev,'next'=>$next,'noofpages'=>$noofpages));







	}







	public function actionGetNewJournal()







	{







		//$finaoid = $_REQUEST['finaoid'];







		$userid = $_POST['userid'];







		$finaoid = $_POST['finaoid'];







		$finaoinfo = UserFinao::model()->findByPk($finaoid);







		$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));







		$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Image'));







		$Criteria = new CDbCriteria();







		$Criteria->condition = "upload_sourcetype = '".$sourcetypeid->lookup_id."' AND uploadtype = '".$typeid->lookup_id."' AND upload_sourceid = '".$finaoid."' ";







		







		$getimages = Uploaddetails::model()->findAll($Criteria);







		$tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid));







		$newjournal = new UserFinaoJournal;







		$finaostatus = Lookups::model()->findAll(array('condition'=>'lookup_type = "finaostatus" AND lookup_status = 1'));







		//$journalmesgs = UserFinaoJournal::model()->findAll(array('conditon'=>'finao_id = "'.$finaoid.'" AND journal_status = 1')); ,'journalinfo'=>$journalmesgs







		$this->renderPartial('_newjournal',array('finaoinfo'=>$finaoinfo,'newjournal'=>$newjournal,'status'=>$finaostatus,'userid'=>$userid,'tileid'=>$tileid,'getimages'=>$getimages));







	}







	 



	public function actionAddJournal()



	{



		 



		$journaltext = $_POST['jounrnaltxt'];



		//$startdate = $_POST['startdate'];



		$finaoid = $_POST['finaoid'];



		$userid = Yii::app()->session['login']['id'];



		//$userid = $_POST['userid'];



		$newjournal = new UserFinaoJournal;



		$newjournal->user_id = $userid;



		$newjournal->finao_id = $finaoid;



		$newjournal->finao_journal = $journaltext;



		//$newjournal->journal_startdate = $startdate;



		$newjournal->journal_startdate = new CDbExpression('NOW()');



		$newjournal->journal_status = 1;



		$newjournal->createdby = $userid;



		$newjournal->createddate = new CDbExpression('NOW()');



		$newjournal->updatedby = $userid;



		$newjournal->updateddate = new CDbExpression('NOW()');



		if($newjournal->save(false))



		{



			Yii::app()->session['journalid'] = $newjournal->finao_journal_id;



			$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));



			$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Added Journal',$finaoid,0);	



			 



		



		



		echo '<a title="upload images" onclick=" addimages('.$userid.','.$finaoid.',"journal","Image",'.Yii::app()->session['journalid'].')"><li class="finao-upload-image"></li></a>';



		



		echo '<a title="upload images" onclick=" addimages('.$userid.','.$finaoid.',"journal","Video",'.Yii::app()->session['journalid'].')"><li class="finao-upload-image"></li></a>';



		}







			







		else







			echo "Please Fill all mandatory Feilds";







	}







	public function actionAllJournals()



	{







		$finaoid = $_POST['finaoid'];







		$userid = $_POST['userid'];







		$iscompleted = $_POST['iscompleted'];







		$share = $_POST['isshare'];







		$page = $_POST['pageid'];



		$heroupdate = (isset($_POST['heroupdate'])) ? $_POST['heroupdate'] : "" ;







		$userinfo = User::model()->findByPk($userid);







		$finaoinfo = UserFinao::model()->findByPk($finaoid);



		$count = $this->GetMediaJournalCount($finaoid);



		$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));







		$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Image'));







		$Criteria = new CDbCriteria();







		$Criteria->condition = "upload_sourcetype = '".$sourcetypeid->lookup_id."' AND uploadtype = '".$typeid->lookup_id."' AND upload_sourceid = '".$finaoid."' ";







		$Criteria->order = "uploadeddate desc";







		$getimages = Uploaddetails::model()->findAll($Criteria);







		$finaostatus = Lookups::model()->findAll(array('condition'=>'lookup_type = "finaostatus" AND lookup_status = 1'));







		$tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid));







		$criteria = new CDbCriteria;







		$criteria->condition = "finao_id = '".$finaoid."' AND journal_status = 1 ";







		$criteria->addCondition("createdby = '".$userid."'", 'AND');







		if($userid!=Yii::app()->session['login']['id'])







		{







			$criteria->addCondition("journal_status  = 1", 'AND');







		}







		$criteria->order = "updateddate DESC";







		$journals = UserFinaoJournal::model()->findAll($criteria);







			







		$this->renderPartial('_newallJournals',array('journals'=>$journals,'finaoinfo'=>$finaoinfo,'status'=>$finaostatus,'userid'=>$userid,'tileid'=>$tileid,'getimages'=>$getimages,'share'=>$share,'page'=>$page,'userinfo'=>$userinfo,'completed'=>$iscompleted,'heroupdate'=>$heroupdate,'count'=>$count));







	}







	







	/*code added by Gowri */







	public function actionDeleteImages()







	{







		$fileurl = $_POST['fileurl'];







		$uploadid = $_POST['fileid'];







		$sourceid = $_POST['sourceid'];







		$userid = $_POST['userid'];







		$sourcetype = $_POST['sourcetype'];







		







		$outputdata = "";







		







		if(file_exists($fileurl))







			unlink($fileurl);







		Uploaddetails::model()->deleteByPk($uploadid);







		







		$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>$sourcetype));







		







		$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Image'));







		







		$uploadedimages = Uploaddetails::model()->findAll(array('condition'=>'upload_sourcetype = '.$sourcetypeid->lookup_id.' and upload_sourceid = '.$sourceid . ' and uploadtype = '.$typeid->lookup_id, 'order'=>'uploadeddate desc'));







			







		$this->renderPartial('_displaydetails',array('uploadedimages'=>$uploadedimages







														,'IsImag'=>1







														,'userid'=>$userid







														,'sourcetype'=>$sourcetype







													));







	}







	







	public function actionGetVediostatus()



	{



		$videoid = $_POST['videoid'];



		$uploadid = $_POST['fileid'];



		$sourceid = $_POST['sourceid'];



		$userid = $_POST['userid'];



		$vidler = Yii::app()->getComponents(false);



		$user = $vidler['vidler']['user'];



		$pass = $vidler['vidler']['pwd'];



		$api_key = $vidler['vidler']['appkey'];



		$v = new Viddler_V2($api_key);



		$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



		$sessionid = $auth['auth']['sessionid'];



		$results=$v->viddler_videos_getDetails(array('sessionid' => $sessionid,'video_id'=>$videoid));



		if($results['video']['status'] == 'ready')



		{



			$uploaddetail = Uploaddetails::model()->findByPk($uploadid);



			$uploaddetail->status = 1;



			$uploaddetail->videostatus = $results['video']['status'];



			$uploaddetail->video_img = $results['video']['thumbnail_url'];



			$uploaddetail->updatedby = $userid;



			$uploaddetail->updateddate =  new CDbExpression('NOW()');



			$uploaddetail->save(false); 



			//$id = $model->primaryKey;				



//			if(isset($results['video']['thumbnail_url']))



//			{



//				$video_img_src = $results['video']['thumbnail_url'];



//			}



//			



//			 



//			if(!empty($video_img_src))



//			{ 



//			/*Code added by LK for generating video thumbnail (02.07.2013)*/					 



//			$filename  = $id.'-'.$userid.'-'.substr(strrchr($video_img_src,'/'),1);



//			$video_img_des = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/videothumbs'.'/'.$filename;



//			$this->generatethumb($video_img_src,$video_img_des);



//			}



	$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Video'));



    $sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));



    $uploadedimages = Uploaddetails::model()->findAll(array('condition'=>'upload_sourcetype = '.$sourcetypeid->lookup_id.' and upload_sourceid = '.$sourceid .' and uploadtype = '.$typeid->lookup_id, 'order'=>'uploadeddate desc'));



			$this->renderPartial('_displaydetails',array('uploadedimages'=>$uploadedimages



														,'IsImag'=>2



														,'userid'=>$userid



													));



		}



		echo $outputdata;



	}







	







	public function actionDeleteVedio()



	{







		$videoid = $_POST['videoid'];



		$uploadid = $_POST['fileid'];



		$sourceid = $_POST['sourceid'];



		$userid = $_POST['userid'];







		$outputdata = "";







		$userid = Yii::app()->session['login']['id'];



		if($videoid != "")



		{



			$vidler = Yii::app()->getComponents(false);



			$user = $vidler['vidler']['user'];



			$pass = $vidler['vidler']['pwd'];



			$api_key = $vidler['vidler']['appkey'];



			$v = new Viddler_V2($api_key);



			$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



			$sessionid = $auth['auth']['sessionid'];



	



			$results=$v->viddler_videos_delete(array('sessionid' => $sessionid,'video_id'=>$videoid));	



			



		}



		



		Uploaddetails::model()->deleteByPk($uploadid);







		$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Video'));



		$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));







		$uploadedimages = Uploaddetails::model()->findAll(array('condition'=>'upload_sourcetype = '.$sourcetypeid->lookup_id.' and upload_sourceid = '.$sourceid .' and uploadtype = '.$typeid->lookup_id, 'order'=>'uploadeddate desc'));







		$this->renderPartial('_displaydetails',array('uploadedimages'=>$uploadedimages



														,'IsImag'=>2



														,'userid'=>$userid



													));







	}







	







		







	public function actionGetAddImages() 



	{



		//print_r($_POST);



		if(isset($_POST['Uploaddetails']))



		{



			$finaoid = $_POST['Uploaddetails']['upload_sourceid'];



		}



		else



		{



			//$finaoid = $_REQUEST['finaoid'];



			$journalmsg = $_POST['journalmessage'];



			$finaoid = $_POST['finaoid'];



			$userid = $_POST['userid'];



			//$type = $_REQUEST['type'];



			$type = $_POST['type'];



			$pageid = (isset($_POST['pageid'])) ? $_POST['pageid'] : 0;



			$journalid = 0;



			if($type == "journal")



				$journalid = $_POST['journalid'];



			/*code by Gowri */



			$upload =  $_POST['uploadtype'];



			$menuselected = $_POST['menuselected'];



			$newupload = new Uploaddetails;



			$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>$type));







			$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>$upload));







			$uploadedimages = Uploaddetails::model()->findAll(array('condition'=>'upload_sourcetype = '.$sourcetypeid->lookup_id.' and upload_sourceid = '.(($type == "journal") ? $journalid : $finaoid ) . ' and uploadtype = '.$typeid->lookup_id, 'order'=>'uploadeddate desc'));







			







			$finaoinfo = UserFinao::model()->findByPk($finaoid);



			$count = $this->GetMediaJournalCount($finaoid);



			$finaostatus = Lookups::model()->findAll(array('condition'=>'lookup_type = "finaostatus" AND lookup_status = 1'));







			$tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid));







			if($upload == 'Image')



			{



				$this->renderPartial('_newfinaoimage',array('finaoinfo'=>$finaoinfo



															 ,'status'=>$finaostatus



															 ,'newupload'=>$newupload



															 ,'sourcetypeid'=>$sourcetypeid



															 ,'typeid'=>$typeid



															 ,'userid'=>$userid



															 ,'tileid'=>$tileid



															 ,'uploadedimages'=>$uploadedimages



															 ,'journalid'=>$journalid



															 ,'sourcetype'=>$type



															 ,'page'=>$pageid 



															,'count'=>$count



															,'menuselected'=>$menuselected



															,'journalmsg'=>$journalmsg



															 ));







			}







			else







			{



				







				$vidler = Yii::app()->getComponents(false);



				$user = $vidler['vidler']['user'];



			    $pass = $vidler['vidler']['pwd'];



			    $api_key = $vidler['vidler']['appkey'];







			    $v = new Viddler_V2($api_key);



			    $auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



			    $sessionid = $auth['auth']['sessionid'];







				if($type=="journal")



				{



					$callback_url ='http://'. $_SERVER['HTTP_HOST'] .'' . $_SERVER['SCRIPT_NAME'] . '/finao/GetVideodetail/finaoid/'.$finaoid.'/journalid/'.$journalid.'/upload/Video/menuselected/'.$menuselected;



				}



				else



				{



					 $callback_url ='http://'. $_SERVER['HTTP_HOST'] .'' . $_SERVER['SCRIPT_NAME'] . '/finao/GetVideodetail/finaoid/'.$finaoid.'/upload/Video/menuselected/'.$menuselected;



				}



		   



			    $prepare_resp = $v->viddler_videos_prepareUpload(array('sessionid' => $sessionid));



				$upload_server = $prepare_resp['upload']['endpoint'];



	            $upload_token = $prepare_resp['upload']['token'];







				$typeidimages = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Image'));







				$getimages = Uploaddetails::model()->findAll(array('condition'=>'upload_sourcetype = '.$sourcetypeid->lookup_id.' and upload_sourceid = '.(($type == "journal") ? $journalid : $finaoid ) . ' and uploadtype = '.$typeidimages->lookup_id, 'order'=>'uploadeddate desc'));



				



				$this->updateviddlerstatus($sessionid,$uploadedimages,$v);



				



				$uploadedimages = Uploaddetails::model()->findAll(array('condition'=>'upload_sourcetype = '.$sourcetypeid->lookup_id.' and upload_sourceid = '.(($type == "journal") ? $journalid : $finaoid ) . ' and uploadtype = '.$typeid->lookup_id, 'order'=>'uploadeddate desc'));







				$this->renderPartial('_newfinaovideo',array('finaoinfo'=>$finaoinfo



													,'status'=>$finaostatus



													,'newupload'=>$newupload



													,'sourcetypeid'=>$sourcetypeid



													,'typeid'=>$typeid



													,'userid'=>$userid



													,'uploadedimages'=>$uploadedimages



													,'callback_url'=>$callback_url



													,'upload_server'=>$upload_server



													,'upload_token'=>$upload_token



													,'getimages'=>$getimages



													,'tileid'=>$tileid



													,'journalid'=>$journalid



													,'sourcetype'=>$type



													,'page'=>$pageid 



													,'count'=>$count



													,'journalmsg'=>$journalmsg



													



													));	







			}												 







		}







		







		







		if(isset($_POST['Uploaddetails']))



		{



			$images = CUploadedFile::getInstancesByName('image');



    		if (isset($images) && count($images) > 0)



     		{



     			foreach($images as $pic)



     			{



					$model =  new Uploaddetails;



					$model->attributes = $_POST['Uploaddetails'];



					$model->uploadeddate = new CDbExpression('NOW()');



					$model->status = 1;



					$model->updateddate = new CDbExpression('NOW()');



					if(!empty($_POST['journalmsg']))



					{



						$model->uploadtype = 62;



						$model->upload_text = $_POST['journalmsg'];







					} 



					//$model->uploadfile_name= $finaoid."-".$pic->getName();



					//$model->uploadfile_path = '/images/uploads/finaoimages';



					$filename = $finaoid."-".$pic->getName();



					$sourcetype = $_POST['Uploaddetails']['uploadsourcetype'];



					$menuselected = $_POST['Uploaddetails']["menuselected"];



                     



					if($model->save(false))



     				{



						



					$finaos = new UserFinao;	



					$finaos = UserFinao::model()->findByPk($finaoid);



					if(!empty($finaos))



					{



					$finaos->updateddate = new CDbExpression('NOW()');



					$finaos->save(false);



					}



						$pic->saveAs(Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages'.'/'.$filename);







						



						







/* Updated by LK (01.07.2013)*/











		







if(file_exists(Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages'.'/'.$filename))



{



		$model->uploadfile_name= $finaoid."-".$pic->getName();



		$model->uploadfile_path = '/images/uploads/finaoimages';



		$model->save(false);



		$source =  Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages'.'/'.$filename;



		$destination = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/thumbs/'.$filename;



		$destination2 = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/medium/'.$filename;



		



		



		/*$image = Yii::app()->getComponents(false);



		$magicianObj = new imageLib($source);



		$magicianObj -> resizeImage(120, 90, 'auto', true);



		$magicianObj -> saveImage($destination, 100);*/



		



		



		



		$ext = substr(strrchr(Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/'.$filename,'.'),1);



		$ext = strtolower($ext);



		



		$this->generatethumb($source,$destination,90,90);



		$this->generatethumb($source,$destination2,240,240);



		 



		



		



		



}



							$userid = $model->uploadedby;
							
							
							
							if($model->upload_sourcetype == 37) //for Finao hard coded
							{
								$textnotifyaction = "Uploaded Image for FINAO";
								$finaoid = $model->upload_sourceid;
							}
							else{
								$textnotifyaction = "Uploaded Image for Journal";
								$modjournal = UserFinaoJournal::model()->findByPk($model->upload_sourceid);
								$finaoid = $modjournal->finao_id;
							}	



			$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));	



			$this->addTrackingNotifications($userid,$tileiddata['tile_id'],$textnotifyaction,$finaoid,0);



							if($sourcetype == 'journal')



								$finaoid = $model->upload_sourceid;



						 	



							



$finaos = new UserFinao;



$finaos = UserFinao::model()->findByPk($finaoid);



if(!empty($finaos))



{



$finaos->updateddate = new CDbExpression('NOW()');



$finaos->save(false);



$this->redirect(Yii::app()->createUrl('finao/motivationMesg',array('menutype'=>'finao'



											   ,'finaoid'=>$finaoid



											   )));



}



      				}







                }







			}



			else



			{



				$this->redirect(array('finao/motivationMesg'));



			}



		}







		







	}







	/**/



	



	public function updateviddlerstatus($session,$uploadedimages,$v)



	{



		



		foreach($uploadedimages as $updet)



		{



			if($updet["videoid"] != "" && $updet["videostatus"] != "ready")



			{



				$results=$v->viddler_videos_getDetails(array('sessionid' => $session,'video_id'=>$updet->videoid));



				if($results['video']['status'] == 'ready')



				{



					$uploaddetail = Uploaddetails::model()->findByPk($updet["uploaddetail_id"]);



					$uploaddetail->status = 1;



					$uploaddetail->videostatus = $results['video']['status'];



					$uploaddetail->video_img = $results['video']['thumbnail_url'];



					$uploaddetail->updatedby = $userid;



					$uploaddetail->updateddate =  new CDbExpression('NOW()');



					$uploaddetail->save(false); 



				}	



	



			}



		}



		



	}



	



	public function updatefinaoviddlerstatus($session,$uploadedimages,$v)



	{



		



		foreach($uploadedimages as $updet)



		{



			 



			    $sql = "SELECT * FROM `fn_uploaddetails` WHERE  `upload_sourceid` = ".$updet."";



				$connection=Yii::app()->db; 



				$command=$connection->createCommand($sql);



				$videoarray = $command->queryAll();



				foreach($videoarray as $video)



				{



					//echo $videoid = $video["videoid"];



					



						if($video["videoid"] != "" && $video["videostatus"] != "ready")



						{



						$results=$v->viddler_videos_getDetails(array('sessionid' => $session,'video_id'=>$video["videoid"]));



						//echo $results['video']['status'];



						if($results['video']['status'] == 'ready')



						{ 



						



						



							$sql = "UPDATE `fn_uploaddetails` SET `status`= 1 ,`videostatus`= '".$results['video']['status']."' WHERE `upload_sourceid` = ".$updet." ";



							//$connection=Yii::app()->db; 



							$command=$connection->createCommand($sql);



							$videostatus = $command->queryAll();



							



							$this->refreshtilewidget(Yii::app()->session['login']['id'],0,0,0,1);



						}	



						



						}



				}



			 



			



			



		}



		



	}











	public function actionGetVideodetail()



	{  

	     //print_r($_REQUEST);exit;

		

		if(isset($_REQUEST))

		{

			$istilevideo = false;

			$userid = Yii::app()->session['login']['id'];

			

			if(isset($_REQUEST["journalid"]) && $_REQUEST["journalid"] > 0)

			{

				if(isset($_REQUEST["sourcetype"]))

				{

					if($_REQUEST["sourcetype"] == "journal")

						$finaoid = $_REQUEST["journalid"];

					else	

						$finaoid = $_REQUEST["finaoid"];		

				}

				else

					$finaoid = $_REQUEST["journalid"];

			}

			else

			{

				$finaoid = $_REQUEST["finaoid"];	

				if($finaoid == 0)

				{

					if(isset($_REQUEST["tileid"]) && $_REQUEST["tileid"] > 0)

					{	

						$finaoid = $_REQUEST["tileid"];

						$istilevideo = true;

					}

				}

			}

			

			 

			$upload = $_REQUEST["upload"];

			$menuselected = $_REQUEST["menuselected"];

			

			$videoid = "";

			$results = "";

			$videoembcode = "";

			$srctype = ""; 

		

			$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype'

												   ,'lookup_status'=>1

												   ,'lookup_name'=>$upload));

			

			$model =  new Uploaddetails;

			

			

			

			$model->upload_sourcetype = 37;//FINAO

			

			

			

			if(isset($_REQUEST["videoid"]))

			{

				$videoid = $_REQUEST["videoid"];

				$vidler = Yii::app()->getComponents(false);

				$user = $vidler['vidler']['user'];

				$pass = $vidler['vidler']['pwd'];

				$api_key = $vidler['vidler']['appkey'];

 				$callback_url = '/';

				$v = new Viddler_V2($api_key);

				$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));

				$sessionid = $auth['auth']['sessionid'];

 				$results=$v->viddler_videos_getDetails(array('sessionid' => $sessionid,'video_id'=>$videoid));

				//print_r($results);

					$description =  $results['video']['description'];
					 
					if(trim($description) == '')

					{
                         $model->uploadtype = 35;
						 
					}
					else
					{
						
						 
						$model->uploadtype = 62;
						$model->upload_text = $results['video']['description'];
					}
			}	

			else

			{

				$videoembcodeURL = $_REQUEST['emburl']; 

				$videodesc = $_REQUEST['embdescr'];	

				$srctype = $_REQUEST['sourcetype'];

				

				$yt_vid = $this->extractUTubeVidId($videoembcodeURL);

				$videoembcode = $this->generateYoutubeEmbedCode($yt_vid,530,360);

				$videoembImgUrl = "http://img.youtube.com/vi/".$yt_vid."/mqdefault.jpg";

					if(!empty($_REQUEST['journaltxt']))

					{

					  $model->uploadtype = 62;

					  $model->upload_text = $_REQUEST['journaltxt'];

					}

					else 

					{

					  $model->uploadtype = 35;

					}

				

			}

			

			$model->upload_sourceid = $finaoid;

			$model->uploadedby = $userid;

			$model->uploadeddate = new CDbExpression('NOW()');

			

			 

			$model->status = 1;

			$model->updatedby = $userid;

			$model->updateddate = new CDbExpression('NOW()');

			$model->videoid = $videoid;

			$model->videostatus = isset($results['video']['status']) ? (($results['video']['status'] == "not ready") ? "Encoding in Process" : $results['video']['status'])  : "ready";

			$model->video_img = isset($results['video']['thumbnail_url']) ? $results['video']['thumbnail_url'] : $videoembImgUrl;

			

			$model->video_caption = isset($results['video']['title']) ? $results['video']['title'] : $videodesc;

			$model->video_embedurl = $videoembcode;

			

			

		    if($model->save(false))

				{

					$finaos = new UserFinao;

					$finaos = UserFinao::model()->findByPk($finaoid);

					if(!empty($finaos))

					{

						$finaos->updateddate = new CDbExpression('NOW()');

						$finaos->save(false);

					    

					}

	 

					if($istilevideo)

					{

						$textnotifyaction = "Uploaded Video for Tile";

						$this->addTrackingNotifications($userid,$finaoid,$textnotifyaction,0,0);

					}

					else


					{

						if($model->upload_sourcetype == 37) //for Finao hard coded

						{

						$textnotifyaction = "Uploaded Video for FINAO";

						$finaoid = $model->upload_sourceid;

						    

$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));

$this->addTrackingNotifications($userid,$tileiddata['tile_id'],$textnotifyaction,$finaoid,0);

						}

		

					}

					

					if(isset($_REQUEST["videoid"]))

					{

						$this->redirect(Yii::app()->createUrl('finao/motivationMesg',array('menutype'=>'finao'

																   ,'finaoid'=>$finaoid

																   )));

					}else

					{

						echo $finaoid.'-'.$tileiddata['tile_id'];

					}

				}

		}

	}



	



	public function AddDefalutFinaoIDforTile($tileid,$tile_name,$userid)



	{



		$finaoid = 0;



		$critireia = new CDbCriteria();



		$critireia->join = ' join fn_user_finao_tile t1 on t.user_finao_id = t1.finao_id ';



		$critireia->condition = ' t1.tile_id = '.$tileid.' and t1.userid ='.$userid.' and t.Isdefault = 1';



		$tilecount =  UserFinao::model()->findAll($critireia);



		if(isset($tilecount) && $tilecount != "" && count($tilecount) >= 1)



		{



			if(isset($tilecount[0]->user_finao_id))



			{



				$finaoid = $tilecount[0]->user_finao_id;



			}



		}



		else



		{



			$newfinao = new UserFinao;



			$newfinao->finao_msg = "Favourite Videos";



			$newfinao->finao_status_Ispublic = 1;



			$newfinao->userid = $userid;



			$newfinao->createddate = new CDbExpression('NOW()');



			$newfinao->updatedby = $userid;



			$newfinao->updateddate = new CDbExpression('NOW()');



			$newfinao->finao_status = 38;



			$newfinao->Isdefault = 1;



			if($newfinao->save(false))



			{



				$finaoid = $newfinao->user_finao_id;



				



				$newtile = new UserFinaoTile;



				$newtile->tile_id = $tileid;



				$newtile->tile_name = $tile_name;



				$newtile->finao_id = $newfinao->user_finao_id;



				



				$tileimgurl = strtolower($tile_name).".png";



				if(!file_exists(Yii::app()->basePath."/../images/tiles/".$tileimgurl))



				{



					$tileimgurl = strtolower($_POST['tilename']).".jpg";



					if(!file_exists(Yii::app()->basePath."/../images/tiles/".$tileimgurl))



					{



						$tileimgurl = "";



					}



				}



				$newtile->tile_profileImagurl = $tileimgurl;



				$newtile->userid = $userid;



				$newtile->status = 1;



				$newtile->createddate = new CDbExpression('NOW()');



				$newtile->createdby = $userid;



				$newtile->updateddate = new CDbExpression('NOW()');



				$newtile->updatedby = $userid;



				$newtile->save(false);



				$this->addTrackingNotifications($userid,$newtile->tile_id,'Added FINAO',$newfinao->user_finao_id,0);



			}



		}



		return $finaoid;



	}



	



    /********* Source: http://webdeveloperswall.com/php/generate-youtube-embed-code-from-url ***********/



	public function extractUTubeVidId($url){



	    /*



	    * type1: http://www.youtube.com/watch?v=H1ImndT0fC8



	    * type2: http://www.youtube.com/watch?v=4nrxbHyJp9k&feature=related



	    * type3: http://youtu.be/H1ImndT0fC8



	    */



	    $vid_id = "";



	    $flag = false;



	    if(isset($url) && !empty($url)){



	        /*case1 and 2*/



	        $parts = explode("?", $url);



	        if(isset($parts) && !empty($parts) && is_array($parts) && count($parts)>1){



	            $params = explode("&", $parts[1]);



	            if(isset($params) && !empty($params) && is_array($params)){



	                foreach($params as $param){



	                    $kv = explode("=", $param);



	                    if(isset($kv) && !empty($kv) && is_array($kv) && count($kv)>1){



	                        if($kv[0]=='v'){



	                            $vid_id = $kv[1];



	                            $flag = true;



	                            break;



	                        }



	                    }



	                }



	            }



	        }



	        



	        /*case 3*/



	        if(!$flag){



	            $needle = "youtu.be/";



	            $pos = null;



	            $pos = strpos($url, $needle);



	            if ($pos !== false) {



	                $start = $pos + strlen($needle);



	                $vid_id = substr($url, $start, 11);



	                $flag = true;



	            }



	        }



	    }



	    return $vid_id;



	}







	public function generateYoutubeEmbedCode($vid_id, $width, $height){



	    $w = $width;



	    $h = $height;



	    $html = '<iframe id="ifrplayer" width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/'.$vid_id.'?rel=0&amp;wmode=transparent" frameborder="0" allowfullscreen></iframe>';



	    return $html;



	}



	



	public function actionUploadProgress()







	{







		$vidler = Yii::app()->getComponents(false);







		$user = $vidler['vidler']['user'];







		$pass = $vidler['vidler']['pwd'];







		$api_key = $vidler['vidler']['appkey'];







				    







		$v = new Viddler_V2($api_key);







		







		$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));







		$sessionid = $auth['auth']['sessionid'];







		







		$v->format = 'json';







		$res = $v->viddler_videos_uploadProgress(array(







		  'sessionid' =>  $sessionid,







		  'token'     =>  urldecode($_REQUEST['token'])







		));







        







		$resoutput = "";







		if(isset($res['upload_progress']))







		{







			$resoutput = "percent$$".$res["upload_progress"]["percent"]."^^"."status$$".$res["upload_progress"]["status"];







		}







		







		echo $resoutput;







		//echo $res["upload_progress"]["percent"];







		







	}







	







	public function actionAddImages()







	{







		$userid = Yii::app()->session['login']['id'];







		$finaoid = $_REQUEST['finaoid'];







		if(isset($_POST['Uploaddetails']))







		{







			$images = CUploadedFile::getInstancesByName('images');







    		if (isset($images) && count($images) > 0)







     		{







     			foreach($images as $pic)







     			{







					$model =  new Uploaddetails;







					$model->attributes = $_POST['Uploaddetails'];







					$model->uploadeddate = new CDbExpression('NOW()');







					$model->status = 1;







					$model->uploadedby = $userid;







					$model->updatedby = $userid;







					$model->updateddate = new CDbExpression('NOW()');







                    if($model->save(false))







     				{







						 $checkname = Uploaddetails::model()->findAll();







					 	//$numbers = rand(0,999999999);







						$model->uploadfile_name= $finaoid."-".$pic->getName();







						/*foreach($checkname as $filenamecheck)







						{







							if($model->uploadfile_name == $filenamecheck->uploadfile_name)







							{







								//$numbers1 = rand(0,999999999);







								//$model->uploadfile_name= $numbers1.$pic->getName();







								







							}







						}*/







						$pic->saveAs(Yii::getPathOfAlias('webroot').'images/uploads/finaoimages'.'/'.$model->uploadfile_name);







						$model->uploadfile_path = Yii::getPathOfAlias('webroot').'images/uploads/finaoimages';







						Yii::import('application.extensions.image.Image');







						$image = new Image(Yii::getPathOfAlias('webroot').'images/uploads/finaoimages'.'/'.$model->uploadfile_name);







						$image->resize(75, 75);







						$image->save(Yii::getPathOfAlias('webroot').'images/uploads/finaoimages/thumbs'.'/'.$model->uploadfile_name.'.jpg');







      					if($model->save())







						{







						 	echo "UPLOADED";







						}







      				}







                }







			}







		}







		else







		{







			echo "Please select atleast one image";







		}







	}







	public function actionUpdateFinaoPublic()







	{







		$public = $_POST['ispublic'];







		$finaoid = $_POST['finaoid'];







		$userid = $_POST['userid'];







		$type = $_POST['type'];







		$finao = UserFinao::model()->findByPk($finaoid);







		if($type=="public")







		{







			$finao->finao_status_Ispublic = $public;







		}







		elseif($type=="complete")







		{







			$finao->Iscompleted = $public;







		}







		$finao->updatedby = $userid;







		$finao->updateddate = new CDbExpression('NOW()');







		$finao->save(false);







		







		$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));







		$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Updated FINAO',$finaoid,0);







		$finaoidarray = UserFinaoTile::model()->findAllByAttributes(array('tile_id'=>$tileiddata['tile_id'],'userid'=>$userid));



		



		if(!empty($finaoidarray))



		foreach($finaoidarray as $finaoids):        



		    $id[]=$finaoids->finao_id;



		endforeach;



		if(isset($id) && !empty($id))



		{



			$Criteria = new CDbCriteria();



			$Criteria->condition = "userid = '".$userid."' AND finao_activestatus != 2 and Iscompleted = 0";



			$Criteria->addInCondition('user_finao_id', $id);



			$finaos = UserFinao::model()->findAll($Criteria);



			if(!empty($finaos))



				echo "getfinaos";



			else



				echo "coverpage";



		}



		else



			echo "coverpage";







		/*$finaos = UserFinao::model()->findAll($Criteria);



		if(isset($finaos) && !empty($finaos))



			echo "getfinaos";



		else



			echo "coverpage";*/







	//	echo "saved";







		







	}







	public function actionUpdateJournal()







	{







		$journalid = $_POST['journalid'];



		$userid = $_POST['userid'];



		$journalmesg = $_POST['journalmesg'];



		$journal = UserFinaoJournal::model()->findByPk($journalid);



		$journal->finao_journal = $journalmesg;



		$journal->updatedby = $userid;



		$journal->updateddate = new CDbExpression('NOW()');



		$journal->save(false);







		$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$journal->finao_id,'userid'=>$userid,'status'=>1));







		$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Updated Journal',$journal->finao_id,0);







		$jourmesg = ""; $maxlen = 150;



	  	$jourmesg = ucfirst($journalmesg);



	  	if(strlen($jourmesg) > $maxlen)



	  	{



		  	$offset = ($maxlen - 11) - strlen($jourmesg);



			$jourmesg = substr($jourmesg, 0, strrpos($jourmesg, ' ', $offset)) . ' ..[<a class="orange-link font-12px" onclick="js:hideshow(\'showjoumsg\',\'show\'); hideshow(\'journalmesg-'.$journal->finao_journal_id.'\',\'hide\'); " href="javascript:void(0);"> Read more </a>]';



		}	







		$output = '<p class="font-13px">';



		$output .= date("m/j/Y  \a\&#116 g:i A", strtotime('now'));



		$output .= '</p>';



		$output .= '<p class="font-14px"> ';



		$output .= ucfirst($jourmesg);



		$output .= '</p>';



		



		echo $output;



	}







	







	public function actionGetDetails()



	{ 



	



	    //print_r($_POST);exit;



		$share  = $_POST['share']; 



		$userid = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : Yii::app()->session["login"]["id"];



		$tileid = $_REQUEST['tileid'];



		$uploadtype = (isset($_REQUEST['imageorvideo'])) ? $_REQUEST['imageorvideo'] : ""; 



		// Added on 28-03-2013 for fetching particular images of finao



		$finaoid = (isset($_REQUEST['finaoid'])) ? $_REQUEST['finaoid'] :0;



		// Ended here



		$finaopageid = (isset($_REQUEST['finaopageid'])) ? $_REQUEST['finaopageid'] : 0;



		$completed = (isset($_REQUEST['iscompleted'])) ? $_REQUEST['iscompleted'] : "";



		// Added on 15-04-2013 to differentiate in which page we are displaying images



		$pagetype = (isset($_REQUEST['pagetype'])) ? $_REQUEST['pagetype'] : "";



		// Ended here



		$tileinfo = Lookups::model()->findByAttributes(array('lookup_id'=>$tileid));



		$journalid = (isset($_REQUEST['journalid'])) ? $_REQUEST['journalid'] :0;







		$heroupdate = (isset($_POST['heroupdate'])) ? $_POST['heroupdate'] : "" ;



		$sql = $this->getUploadDetailsSQlScript($tileid,$uploadtype,$userid,'',$finaoid,$journalid,$share);



		$connection=Yii::app()->db; 



		$command=$connection->createCommand($sql);



		$uploadinfo = $command->queryAll();



		



		



		if(isset($_REQUEST['pageid']))



		{



			$type = $_REQUEST['type'];



			$page = $_REQUEST['pageid'];



		}



		else



		{



			$page = 1;



		}



		 



		$noofelements = 1;



		if($pagetype == 'homethumb')



		{



			$noofelements = 21;



		}else if($pagetype == 'homevideo')



		{



			$noofelements = 21	;



		}else if($pagetype == 'populatevideos')



		{



			$noofelements = 1;



		}



			



		$nagdetUpdet = $this->getpagedetails($uploadinfo,0,$page,$noofelements);



		$limitvalue = $nagdetUpdet['limittxt'];



		$noofpages = $nagdetUpdet['noofpage'];



		$prev = $nagdetUpdet['prev'];



		$next = $nagdetUpdet['next'];



		



		$sql = $this->getUploadDetailsSQlScript($tileid,$uploadtype,$userid,$limitvalue,$finaoid,$journalid,$share);



		 



		//print_r($sql);



		$connection=Yii::app()->db; 



		$command=$connection->createCommand($sql);



		$uploadinfo = $command->queryAll();



		$uploadtypeNavigate = "";







		foreach($uploadinfo as $det)



		{



			if($det["uploadfile_name"] != "")



				$uploadtypeNavigate = "Image";



			else



				$uploadtypeNavigate = "Video";			



		}



		if($pagetype == 'homethumb')



		{  



			$this->renderPartial('_allfinaoimages',array('uploadinfo'=>$uploadinfo



														,'userid'=>$userid



														,'prev'=>$prev



														,'next'=>$next



														,'noofpages'=>$noofpages



														,'tileid'=>$tileid



														,'uploadtype'=>$uploadtype



														,'videmcode'=>$videmcode



														,'page'=>$finaopageid



														/*,'resizeWidth'=>$resizeWidth



														,'resizeHeight'=>$resizeHeight*/



														,'completed'=>$completed



														,'pagetype'=>$pagetype



														,'tileinfo'=>$tileinfo



														,'heroupdate'=>$heroupdate



														,'finaoid'=>$finaoid



														,'journalid'=>$journalid



														,'hel'=>'hello'



														));



			



		}



		else if($pagetype == 'homevideo')



		{ 



		  // echo 'u r in Home video Layout';



		   	$vidler = Yii::app()->getComponents(false);



			$user = $vidler['vidler']['user'];



		    $pass = $vidler['vidler']['pwd'];



		    $api_key = $vidler['vidler']['appkey'];



	



		    $v = new Viddler_V2($api_key);



		    $auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



		    $sessionid = $auth['auth']['sessionid'];



			$this->updateviddlerstatus($sessionid,$uploadinfo,$v);



			$uploadinfo = $command->queryAll();



		   $this->renderPartial('_allfinaovideos',array('uploadinfo'=>$uploadinfo



														,'userid'=>$userid



														,'prev'=>$prev



														,'next'=>$next



														,'noofpages'=>$noofpages



														,'tileid'=>$tileid



														,'uploadtype'=>$uploadtype



														,'videmcode'=>$videmcode



														,'page'=>$finaopageid



														/*,'resizeWidth'=>$resizeWidth



 														,'resizeHeight'=>$resizeHeight*/



														,'completed'=>$completed



														,'pagetype'=>$pagetype



														,'tileinfo'=>$tileinfo



														,'heroupdate'=>$heroupdate



														,'finaoid'=>$finaoid



														,'journalid'=>$journalid



														));	



		}else if($pagetype == 'populatevideos')



		{



			//echo $uploadinfo[0][upload_sourceid];



			//print_r($uploadinfo);



			//echo $uploadinfo[0]['upload_sourcetype'];



			if($uploadinfo[0]['upload_sourcetype']=='37')



			{



			 	$finaomsg = UserFinao::model()->findByPk($uploadinfo[0][upload_sourceid]);



				$finaomsg=$finaomsg->finao_msg;



			}



			else if($uploadinfo[0]['upload_sourcetype']=='36') 



			{



				$finaomsg = TilesInfo::model()->findByAttributes(array('tile_id'=>$uploadinfo[0][upload_sourceid]));



				$finaomsg=$finaomsg->tilename;



			}



			else 



			{



				$finaomsg = UserFinao::model()->findByPk($uploadinfo[0][upload_sourceid]);



				$finaomsg=$finaomsg->finao_msg;



			}



			$type_finao=$uploadinfo[0]['upload_sourcetype'];







		// $tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$uploadinfo[0][upload_sourceid]));



			// print_r($tileid);exit;



			$this->renderPartial('_allfinaovideos',array('uploadvideoinfo'=>$uploadinfo



														,'userid'=>$userid



														,'prev'=>$prev



														,'next'=>$next



														,'noofpages'=>$noofpages



														,'tileid'=>$tileid



														,'uploadtype'=>$uploadtype



														,'videmcode'=>$videmcode



														,'page'=>$finaopageid



														/*,'resizeWidth'=>$resizeWidth



 														,'resizeHeight'=>$resizeHeight*/



														,'completed'=>$completed



														,'pagetype'=>$pagetype



														,'tileinfo'=>$tileinfo



														,'heroupdate'=>$heroupdate



														,'finaoid'=>$finaoid



														,'journalid'=>$journalid



														,'view'=> 'populatevideogallery'



														,'finaoinfo' => $finaomsg 



														,'type_finao'=>$type_finao



														,'viewing'=>$view_finao_ids



														));	



			



		}



		else



		{



			/* code to handle Image aspect Ration */







		$resizeWidth = "";



		$resizeHeight = "";



		if($uploadtype == 'Image' || $uploadtypeNavigate == 'Image')



		{



			/* code added by Gowri on 15-Aug-2013 */



			if(!empty($uploadinfo))



			{



				$resizevaluearray = $this->getImageResizeValue($uploadinfo);



				foreach($resizevaluearray as $resimgval)



				{



					$resizeWidth = $resimgval['resizeWidth'];



					$resizeHeight = $resimgval['resizeHeight'];	



				}



			}



			



			/*if(!empty($uploadinfo))



				foreach($uploadinfo as $updetails)



				{







					$filename = Yii::app()->basePath .'/../'.$updetails["uploadfile_path"].'/'.$updetails["uploadfile_name"];				}



			else



			{



				$filename = "";



			}



			// By Default defined to Portrait 



			if($pagetype == 'finaopage') 



			{



				$targetWidth = 120;



				$targetHeight = 240;



			}



			else



			{



				$targetWidth = 380;//400;//200;



				$targetHeight = 430;//300;		



			}



			if(file_exists($filename))



			{



				list($sourceWidth,$sourceHeight) = getimagesize($filename);



				if($sourceWidth <= $targetWidth && $sourceHeight <= $targetHeight)



				{



					$resizeWidth = $sourceWidth;



					$resizeHeight = $sourceHeight;



				}



				else



					{



						if($sourceWidth > $sourceHeight) //Landscape Image condition



						{



							if($pagetype == 'finaopage')



							{



								$targetWidth = 280;



								$targetHeight = 450;



							}



							else



							{



								$targetWidth = 380;



								$targetHeight = 430;	



							}



							



						}



												



						$resizevalue = $this->getImgWidthHeight($filename,$targetWidth,$targetHeight,$sourceWidth,$sourceHeight);



						$resizeWidth = $resizevalue['resizeWidth'];



						$resizeHeight = $resizevalue['resizeHeight'];



					}







			}*/



		}



		$videmcode = "";







		if($uploadtype == 'Video' || $uploadtypeNavigate == 'Video')







		{







			$vidler = Yii::app()->getComponents(false);



			$user = $vidler['vidler']['user'];



		    $pass = $vidler['vidler']['pwd'];



		    $api_key = $vidler['vidler']['appkey'];







		    $v = new Viddler_V2($api_key);



			$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



			$i=0;



		







			foreach($uploadinfo as $eachdetails)







			{



				if(isset($eachdetails["videoid"]) && $eachdetails["videoid"] != "")



				{



					$videmcode[$i++]["embedcode"] = $v->viddler_videos_getEmbedCode(array(







								                       'sessionid' => $auth['auth']['sessionid'],







								                       'video_id' =>$eachdetails["videoid"],







								                       'embed_code_type' => 5,







								                       //'disableseek' => '1',







													   'width'=>532,







								                       'height'=>305,







													   'player_type'=>'simple',







								                      ));	



	



				}



				else



				{



					if($eachdetails["video_embedurl"] != "")



					{



						$videmcode[$i++]["embedcode"] = $eachdetails["video_embedurl"];



					}



				}



				



			}







		     







		   //print_r($videmcode);







		}







		$this->renderPartial('_displayImgVideo',array('uploadinfo'=>$uploadinfo







														,'userid'=>$userid







														,'prev'=>$prev







														,'next'=>$next







														,'noofpages'=>$noofpages







														,'tileid'=>$tileid







														,'uploadtype'=>$uploadtype







														,'videmcode'=>$videmcode







														,'page'=>$finaopageid







														,'resizeWidth'=>$resizeWidth







														,'resizeHeight'=>$resizeHeight







														,'completed'=>$completed







														,'pagetype'=>$pagetype







														,'tileinfo'=>$tileinfo



														,'heroupdate'=>$heroupdate



														,'finaoid'=>$finaoid



														,'journalid'=>$journalid



														));



		}



		



	



	}







	







	public function getImgWidthHeight($filename,$targetWidth,$targetHeight,$sourceWidth,$sourceHeight)







	{







		$resizeWidth = "";







		$resizeHeight = "";







		if(file_exists($filename))







		{







			$sourceRatio = $sourceWidth / $sourceHeight;







			$targetRatio = $targetWidth / $targetHeight;







			







			//print_r($sourceWidth);







			//print_r($sourceHeight);







			







			if ( $sourceRatio < $targetRatio ) {







    			$scale = $sourceWidth / $targetWidth;







			} else {







    		$scale = $sourceHeight / $targetHeight;







			}







			







			$resizeWidth = (int)($sourceWidth / $scale);







			$resizeHeight = (int)($sourceHeight / $scale);	







		}







		







		return array('resizeWidth'=>$resizeWidth







						,'resizeHeight'=>$resizeHeight);







	}







	







public function getUploadDetailsSQlScript($tileid,$uploadtype,$userid,$limit,$finaoid,$journalid,$share)



{ 







		if($userid != Yii::app()->session['login']['id'] ||  $share == "share" )



		{



			$condition = "and finao_status_Ispublic = 1";



		}



		  



	    



		



		/*if($uploadtype == 'Video')



		{ $videostatus ="and tab.videostatus = 'ready' and tab.status = 1";} 



*/



		$typeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>$uploadtype));



		$sourcetypeidfinao = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));



		$sourcetypeidtile = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'tile'));



		$sourcetypeidjournal = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'journal'));







		



		if($typeid->lookup_id == 34)



		{



			$utype = "(62,34)"; 



			$ucondition = "and uploadfile_name !=''";



		}



		else



		{



			$utype = "(62,35)";



			$ucondition = "and (videoid != '' or video_embedurl !='')";



		}



		$whereclause = ($tileid > 0) ? " and t1.tile_id = ".$tileid." and t1.status = 1 " : "";



		



		$sqltile = "EXISTS (SELECT *



								FROM fn_user_finao_tile t1



								JOIN fn_user_finao t2 ON t1.finao_id = t2.user_finao_id



								WHERE t2.finao_activestatus = 1



								AND t2.Iscompleted = 0 ". (($tileid > 0) ? " and t1.tile_id = ".$tileid." and t1.status = 1 " : " " ). ")";



								



		$wheretile = $whereclause. " and ".$sqltile;



		



		$whereactiveclause = "AND upload_sourceid IN ( select user_finao_id from fn_user_finao where user_finao_id = ".$finaoid." and finao_activestatus = 1)";



		



		$wherejournal = ($journalid > 0) ? "  and upload_sourceid = ".$journalid : "";







		if(isset($finaoid) && $finaoid != 0 && $journalid == 0)



		{



			$sql = "SELECT * FROM 



						fn_uploaddetails 



						WHERE ". (($typeid != '') ? ' uploadtype = '. $typeid->lookup_id : '1=1') ." 



						AND upload_sourcetype = ".$sourcetypeidfinao->lookup_id." 



						AND upload_sourceid = ".$finaoid."



						AND status = 1 	AND  (`uploadfile_path` != '' or  `video_img` !='')



						order by uploadeddate desc



				".$limit;



		}



		else



		{



			



 			$sql = "SELECT tab.* FROM (



					SELECT distinct t.* 



					FROM 



					`fn_uploaddetails` t



					join fn_user_finao_tile t1 on t.upload_sourceid = t1.finao_id and upload_sourcetype = ".$sourcetypeidfinao->lookup_id." 



					join fn_user_finao t2 on t1.finao_id = t2.user_finao_id and t2.finao_activestatus = 1 and t2.Iscompleted = 0



					



					where 1 = 1 " . $whereclause . " ".$condition." 







					union 







					SELECT distinct t.* FROM 



					`fn_uploaddetails` t



					join fn_user_finao_tile t1 on t.upload_sourceid = t1.tile_id and upload_sourcetype = ".$sourcetypeidtile->lookup_id."



					where 1 = 1 " .$wheretile . "







					union







					SELECT distinct t.* FROM 



					`fn_uploaddetails` t



					join fn_user_finao_journal t3 on t.upload_sourceid = t3.finao_journal_id and upload_sourcetype = ".$sourcetypeidjournal->lookup_id."



		



					where t3.finao_id in (select finao_id from fn_user_finao_tile t1 join fn_user_finao t2 on t1.finao_id = t2.user_finao_id where 1 = 1 ". $whereclause." ".$condition." and t2.finao_activestatus = 1 and t2.Iscompleted = 0) 







					) tab







					where ".(($typeid != "") ? "tab.uploadtype in ".$utype : " 1 = 1 ") ."







					and tab.uploadedby = ".$userid."



					



					and tab.status = 1



					



					".$videostatus."



					



					".$wherejournal." ".$ucondition."







					order by tab.uploadeddate desc







					".$limit;



					



					/*where tab.uploadedby = ".$userid."



					



					and tab.status = 1  and tab.uploadtype in ".$utype."



					



					".$videostatus."



					



					".$wherejournal." ".$ucondition."







					order by tab.uploadeddate desc







					".$limit;*/



					



					



					



				//limit 0,1;







		 }



			



		 return $sql;







	



}







	







	public function actionUpdateImgCaption()







 	{







		  $userid = $_POST['userid'];







		  $uploadid = $_POST['uploadid'];







		  $caption = $_POST['caption'];







		  $imagecaption = Uploaddetails::model()->findByPk($uploadid);







		  $imagecaption->caption = $caption;







		  $imagecaption->updatedby = $userid;







		  $imagecaption->updateddate = new CDbExpression('NOW()');







		  $imagecaption->save(false);







		  echo $imagecaption->caption;







 	}







	public function actionIsSkip()







	{







		$userid = Yii::app()->session['login']['id'];







		$newfinao = UserFinao::model()->findByAttributes(array('userid'=>$userid));







		if(isset($newfinao))







		{







			$newfinao->updatedby = $userid;







			$newfinao->updateddate = date('Y-m-d G:i:s');







		}







		else







		{







			$newfinao = new UserFinao;







			$newfinao->user_id = $userid;







			$newfinao->createdby = $userid;







			$newfinao->createddate = date('Y-m-d G:i:s');







			$newfinao->updatedby = $userid;







			$newfinao->updateddate = date('Y-m-d G:i:s');







		}







		







		$skip = $_POST['skip'];







		$newfinao->Iscompleted = $skip;







		if($newfinao->save(false)){







			echo "motivationmesg";







		}else{







			echo "not skipped";







		}







	}







	public function actionViewAllStatus()







	{







		$userid = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];







		$this->widget('ProgressBar',array('userid'=>$userid,'left'=>'left'));







	}







	public function actionNewTile()



	{



	 $userid = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];



	 $pagetype = (isset($_POST['pagetype']) && $_POST['pagetype'] != '') ? $_POST['pagetype']: "";



		



		if(isset($_POST['UserFinaoTile']))



		{



			$finaoid = 0;



			if($_POST['UserFinaoTile']['finao_id'] == 0)



			{



				$finamsg = $_POST['UserFinaoTile']['finaomessage'];	



				$finaostatu = Lookups::model()->findByAttributes(array('lookup_type'=>'finaostatus','lookup_status'=>1,'lookup_name'=>'On Track'));



				



				$newfinao = new UserFinao;



				$newfinao->userid = $userid;



				$newfinao->createddate = new CDbExpression('NOW()');



				$newfinao->updatedby = $userid;



				$newfinao->updateddate = new CDbExpression('NOW()');



				$newfinao->finao_status = $finaostatu->lookup_id;



				$newfinao->finao_msg = $finamsg;
				
				//print_r($_POST); exit;
				$newfinao->finao_status_Ispublic = $_POST['ispublic'];



				if($newfinao->save(false))



					$finaoid = $newfinao->user_finao_id;



					if($finaoid != '')



					{



						//$filename = $_POST['filename'];



					    $filename = Yii::app()->session['filename'];



						if($filename!='')



						{



							$uploaddetails  = new Uploaddetails;



							$uploaddetails->uploadfile_path = "/images/uploads/finaoimages";			



							$uploaddetails->uploadtype = 34;



							$uploaddetails->uploadfile_name = $filename;



							$uploaddetails->upload_sourcetype = 37;



							$uploaddetails->upload_sourceid = $finaoid;



							$uploaddetails->uploadedby = $userid;



							$uploaddetails->uploadeddate = new CDbExpression('NOW()'); 



							$uploaddetails->status = 1;



							$uploaddetails->updatedby = $userid; 



							$uploaddetails->updateddate = new CDbExpression('NOW()');



							$uploaddetails->caption = $_POST['caption'];



							$uploaddetails->updatedby =$userid;



							if($uploaddetails->save(false))



							{



							unset(Yii::app()->session['filename']);



							}



						}



						



 					}



					



			}



			else



				$finaoid = $_POST['UserFinaoTile']['finao_id'];



			



			$sql = "SELECT max(tile_id) FROM fn_tilesinfo";



			$connection=Yii::app()->db; 



			$command=$connection->createCommand($sql);



			$tileids = $command->queryAll();



			foreach($tileids as $newtile)



			{



				$tileid = $newtile["max(tile_id)"];



			}



			if($tileid == 0)



			{



				$sql = "SELECT max(lookup_id) FROM fn_lookups WHERE lookup_type = 'tiles' ";



				$connection=Yii::app()->db; 



				$command=$connection->createCommand($sql);



				$tileids = $command->queryAll();



				foreach($tileids as $newtile)



				{



					$tileid = $newtile["max(lookup_id)"]+1;



				}



			}



			else



			{



				$tileid = $newtile["max(tile_id)"]+1;



			}		



			$edittile = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid));



			



			if(!(isset($edittile) && !empty($edittile)))



			{



				$edittile = new UserFinaoTile;



				$edittile->userid = $userid;



				$edittile->createdby = $userid;



				$edittile->createddate = new CDbExpression('NOW()');



				$edittile->finao_id = $finaoid;



			}



			$edittile->tile_name = $_POST['UserFinaoTile']['tile_name'];



			$edittile->tile_id = $tileid;







			$images = CUploadedFile::getInstancesByName('tileimage');



    		if (isset($images) && count($images) > 0)



     		{



     			foreach($images as $pic)



     			{



					$fileext = $pic->extensionName;



					$fileext = strtolower($fileext);



					$edittile->status = 1;



					$edittile->updateddate = new CDbExpression('NOW()');



					$edittile->updatedby = $userid;



					



					//$edittile->tile_profileImagurl = $userid."-".strtolower($edittile->tile_name).".".$fileext;



					$edittile->tile_profileImagurl = $userid."-".str_replace(" ","",strtolower($edittile->tile_name)).".".$fileext;



					//print_r($edittile->attributes);exit;



					if($edittile->save(false))



     				{



						// Added on 27-06-13 to populate data in tilesinfo table



						$numb = rand();



						$tileinfo = new TilesInfo;



							$tileinfo->tile_id = $edittile->tile_id;



							$tileinfo->tilename = $_POST['UserFinaoTile']['tile_name'];;



							$tileinfo->temp_tile_imageurl = "temptile-".$userid."-".$numb."-".str_replace(" ","",strtolower($_POST['UserFinaoTile']['tile_name'])).".".$fileext;



							$tileinfo->Is_customtile = 1;



							$tileinfo->status = 1;



							$tileinfo->createdby = $userid;



							$tileinfo->createddate = new CDbExpression('NOW()');



							$tileinfo->updateddate = new CDbExpression('NOW()');



							$tileinfo->updatedby = $userid;



							$tileinfo->save(false);



						



						//$pic->saveAs(Yii::getPathOfAlias('webroot').'/images/uploads/tilesimages'.'/'.strtolower($edittile->tile_name).".jpg");



						$pic->saveAs(Yii::getPathOfAlias('webroot').'/images/tiles'.'/'."temptile-".$userid."-".$numb."-".str_replace(" ","",strtolower($tileinfo->tilename)).".".$fileext);



						if($edittile->save())



						{



							$path = Yii::app()->basePath."/../images/tiles/"."temptile-".$userid."-".$numb."-".str_replace(" ","",strtolower($tileinfo->tilename)).".".$fileext;



							if(file_exists($path))



							{



								$t_width = 80;



								$t_height = 60;



								



								$font_size = 16;



												list($sourceWidth,$sourceHeight) = getimagesize($path);



									if($sourceWidth >= 440 && $sourceHeight >= 320)



					{



						



					if($sourceWidth == 440 && $sourceHeight == 320)



					{



						if($tileinfo->tile_imageurl != "")



						{



							if(file_exists(Yii::app()->basePath."/../images/tiles/".$tileinfo->tile_imageurl))



								unlink(Yii::app()->basePath."/../images/tiles/".$tileinfo->tile_imageurl);



						} 



						$tileinfo->tile_imageurl = $filename;



						if($tileinfo->save(false))



						{



							if(file_exists(Yii::app()->basePath."/../images/tiles/".$tileinfo->temp_tile_imageurl))



								unlink(Yii::app()->basePath."/../images/tiles/".$tileinfo->temp_tile_imageurl);



							$this->redirect(Yii::app()->createUrl('finao/motivationmesg'));		



						}



					}



					else



					{



						if($sourceWidth > 440)



						{



							$ext = substr(strrchr($tileinfo->temp_tile_imageurl,'.'),1);



							$ext = strtolower($ext);



							$this->createImagetofixbodysize(Yii::app()->basePath."/../images/tiles/".$tileinfo->temp_tile_imageurl,600,$ext);	



							$this->addTrackingNotifications($userid,$tileid,'Moved tile',$finaoid,0);



						}



						$this->redirect(Yii::app()->createUrl('finao/motivationmesg',array('tileimageupload'=>$tileinfo->tile_id)));



						



					}



					}



					else



						$this->redirect(Yii::app()->createUrl('finao/motivationmesg',array('tileerrormesg'=>$tileinfo->tile_id,'newtile'=>1)));



							/*	list($w,$h) = getimagesize($path);



										



								$ratio = ($t_width/$w); 



								$nw = ceil($w * $ratio);



								$nh = ceil($h * $ratio);



								



								$nimg = imagecreatetruecolor($nw,$nh);



																



								switch($fileext)



								{



									case 'jpeg':



									case 'jpg':



												$im_src = imagecreatefromjpeg($path);



												break;



									case 'png':	



												$im_src = imagecreatefrompng($path);



												break;						



								}



								imagecopyresampled($nimg,$im_src,0,0,0,0,$nw,$nh,$w,$h);



								$color = imagecolorallocate($nimg, 255,255,255);



								$black = imagecolorallocate($im_src, 0,0,0);



								//ImageTTFText($im_src, $font_size, 0, 21, 26, $black, Yii::app()->basePath."/../Fonts/Gladifilthefte/gladifilthefte.ttf",$edittile->tile_name);



								//ImageTTFText($nimg, $font_size, 0, 20, 25, $color, Yii::app()->basePath."/../Fonts/Gladifilthefte/gladifilthefte.ttf",$edittile->tile_name);



								imagejpeg($nimg,$path,90);*/



							}



							



							



							//echo $model->uploadedby."-".$finaoid."-".$model->uploadSourcetype->lookup_name;



							//$this->addTrackingNotifications($userid,$tileid,'Moved tile',$finaoid,0);



							$this->redirect(Yii::app()->createUrl('finao/motivationMesg',array('finaoid'=>$finaoid



																						//,'upload'=>'Image'



																						)));			







						}







      				}







                }







			}







			else







			{







				$this->redirect(array('finao/motivationMesg'));







			}







		}







		else







		{







			$finaoid = (isset($_POST['finaoid']) && $_POST['finaoid']>0) ? $_POST['finaoid'] : 0;







			if($pagetype!="newtilepage")



			{



				$edittile = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid));



			}







			else







				$edittile = new UserFinaoTile;







				//print_r($edittile);







				//exit;







			$this->renderPartial('_tileform',array('newtile'=>$edittile,'userid'=>$userid,'finaoid'=>$finaoid,'pagetype'=>$pagetype));







		}







		







		







	}







	public function actionValidateTile()







	{







		$userid = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];







		$tilename = strtolower(trim($_POST['tilename']));



				



		$edittile = UserFinaoTile::model()->findAll(array('condition'=> 'tile_name like "'.$tilename.'" and userid = '.$userid.' and status = 1'));



		$stdtile = Lookups::model()->findAll(array('condition'=> 'lookup_name like "'.$tilename.'" and lookup_type = "tiles" and lookup_status = 1'));



		



		if((isset($edittile) && count($edittile)>=1) || (isset($stdtile) && count($stdtile)>=1) ) 







		{







			echo "Tile Exists";







		}







		else







		{







			echo "No Tile";







		}







		







	}







	public function actionNewFinao()



	{



		$userid = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];



		$this->widget('finao',array('type'=>'tilefinao'));



	}



	



	public function getfinaoinfo($userid,$Iscompleted,$share,$noofelements,$pageid,$getcount)



	{



		$Criteria = new CDbCriteria();



		$Criteria->condition = "t.userid = '".$userid."' AND finao_activestatus = 1 ";



		$Criteria->join = " join fn_user_finao_tile t1 on t.user_finao_id = t1.finao_id ";



		if($userid != Yii::app()->session['login']['id'] ||  $share == "share")



		{



			$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');



		}



		if($userid == Yii::app()->session['login']['id'] && $Iscompleted == "" && $share != "share")



		{



			$Criteria->addCondition("Iscompleted = 0","AND");



		}



		if(isset($Iscompleted) && $Iscompleted != "")



		{



			$Criteria->addCondition("Iscompleted = 1","AND");



		}



		$Criteria->order = "updateddate DESC";



		$finaos = UserFinao::model()->findAll($Criteria);



		$finaopagedetails = $this->getpagedetails($finaos,1,$pageid,$noofelements);



		$Criteria->limit = $finaopagedetails['limittxt'];



		$Criteria->offset = $finaopagedetails['offset'];



		$finaos = UserFinao::model()->findAll($Criteria);



		



		$uploaddetails = array();



		$finaoids = "";



		foreach($finaos as $finodet)



		{



			$finaoids .= $finodet->user_finao_id . ",";



		}



		



		if($finaoids != "")



		{



			$finaoids = substr($finaoids,0,strlen($finaoids)-1);



			$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));



			$uploaddetails = $this->getlatestuploaddetails($finaoids,$sourcetypeid->lookup_id);



		}



		



		if($getcount)



			return ((isset($finaos) && $finaos != "") ? count($finaos) :  0);



		else



			return  array('finaos'=>$finaos



						,'uploaddetails'=>$uploaddetails



						,'finaopagedetails'=>$finaopagedetails );



	}







	public function actionFinaosInfo()



	{







		$userid = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];



		$Iscompleted = (isset($_POST['completed'])) ? $_POST['completed'] : "";



		$share = (isset($_REQUEST['share'])) ? $_REQUEST['share'] : "" ;



		



		/*if(isset($_REQUEST['share']))



		{



			$share = "share";



		}



		else



		{



			$share = "no";



		}*/



		



		$finaos = $this->getfinaoinfo($userid,$Iscompleted,$share,-1,1,0);



		



		$this->renderPartial('_allfinaos',array('finaos'=>$finaos['finaos'],'userid'=>$userid,'Iscompleted'=>$Iscompleted,'share'=>$share)); 







	} 







	







	public function actionChangePic()



	{



		$id=Yii::app()->session['login']['id'];



		$name = $_FILES['file']['tmp_name'];



		



		$b=Yii::getPathOfAlias('application'); 



		$numb = rand();



		//$model= UserProfile::model()->findByAttributes(array('user_id'=>$id));



		if(isset($_POST['usertileid']))



		{



			$usertileid = $_POST['usertileid'];



			$model = TilesInfo::model()->findByAttributes(array('tile_id'=>$usertileid,'createdby'=>$id));



			$tilename = $_POST['tilename'];



			$c=str_replace('protected','images/tiles',$b);



			$filename = "temptile-" .$id."-".$numb."-".str_replace(' ','',$tilename).".jpg";



		}



		else



		{



			$model= UserProfile::model()->findByAttributes(array('user_id'=>$id));



				



			if(empty($model))



			{



				$model = new UserProfile;



				$model->createdby = $id;



				$model->createddate = date('Y-m-d G:i:s');



				$model->updatedby = $id;



				$model->updateddate = date('Y-m-d G:i:s');



			}



			else



			{



				/*if($model->profile_bg_image != "")



				{



					if(file_exists("images/uploads/backgroundimages/".$model->profile_bg_image))



						unlink("images/uploads/backgroundimages/".$model->profile_bg_image);



				}*/



				$model->updatedby = $id;



				$model->updateddate = date('Y-m-d G:i:s');



				$c=str_replace('protected','images/uploads/backgroundimages',$b);



				$filename = "tempbg-" .$id."-".$numb."-".str_replace(' ','',$_FILES["file"]["name"]);



			}



		 



		}



		/*$name = $_FILES['file']['tmp_name'];



		



		$b=Yii::getPathOfAlias('application'); 



		$numb = rand();



	    $c=str_replace('protected','images/uploads/backgroundimages',$b);



		//$model->profile_bg_image = $id."-".str_replace(' ','',$_FILES["file"]["name"]);



		



		$filename = "tempbg-" .$id."-".$numb."-".str_replace(' ','',$_FILES["file"]["name"]); */



		



		if(isset($_POST['usertileid']))



		{



			$filepath = $c."/" .$filename;



			//echo $filepath;



			//exit;



			$model->temp_tile_imageurl = $filename;



			//$model->user_id = $id;



			$model->save(false);			



			move_uploaded_file($_FILES["tileimagefile"]["tmp_name"],$filepath);



			//move_uploaded_file(str_replace(' ','',$tilename),$filepath);



		}



		else



		{



			$filepath = $c."/" .$filename;



			



			$model->temp_profile_bg_image = $filename;



			$model->user_id = $id;



			if($model->save(false))



			{



				$login = Yii::app()->session['login'];



				$login["bgImage"] = $model->profile_bg_image;



				Yii::app()->session['login'] = $login;



			}



			move_uploaded_file($_FILES["file"]["tmp_name"],$filepath);



			//print_r($model->image_name);



			//exit;



		}			



		



		chmod($filepath,0777);



				



		if(file_exists($filepath))



		{



			list($sourceWidth,$sourceHeight) = getimagesize($filepath);



			



				if(isset($_POST['usertileid']))



				{



					if($sourceWidth >= 440 && $sourceHeight >= 320)



					{



						



					if($sourceWidth == 440 && $sourceHeight == 320)



					{



						if($model->tile_imageurl != "" && $model->Is_customtile==1)



						{



							if(file_exists(Yii::app()->basePath."/../images/tiles/".$model->tile_imageurl))



								unlink(Yii::app()->basePath."/../images/tiles/".$model->tile_imageurl);



						} 



						$model->tile_imageurl = $filename;



						if($model->save(false))



						{



							if(file_exists(Yii::app()->basePath."/../images/tiles/".$model->temp_tile_imageurl))



								unlink(Yii::app()->basePath."/../images/tiles/".$model->temp_tile_imageurl);



							$this->redirect(Yii::app()->createUrl('finao/motivationmesg'));		



						}



					}



					else



					{



						if($sourceWidth > 440)



						{



							$ext = substr(strrchr($model->temp_tile_imageurl,'.'),1);



							$ext = strtolower($ext);



							$this->createImagetofixbodysize(Yii::app()->basePath."/../images/tiles/".$model->temp_tile_imageurl,600,$ext);	



						}



						



						$this->redirect(Yii::app()->createUrl('finao/motivationmesg',array('tileimageupload'=>$model->tile_id)));



						



					}



					}



					else



						$this->redirect(Yii::app()->createUrl('finao/motivationmesg',array('tileerrormesg'=>$model->tile_id)));



				}



				else



				{



					if($sourceWidth >= 980 && $sourceHeight >= 350)



			{



				if($sourceWidth == 980 && $sourceHeight == 350)



				{



					if($model->profile_bg_image != "")



					{



						if(file_exists(Yii::app()->basePath."/../images/uploads/backgroundimages/".$model->profile_bg_image))



							unlink(Yii::app()->basePath."/../images/uploads/backgroundimages/".$model->profile_bg_image);



					} 



					$model->profile_bg_image = $filename;



					if($model->save(false))



					{



						if(file_exists(Yii::app()->basePath."/../images/uploads/backgroundimages/".$model->temp_profile_bg_image))



							unlink(Yii::app()->basePath."/../images/uploads/backgroundimages/".$model->temp_profile_bg_image);



						$this->redirect(Yii::app()->createUrl('finao/motivationmesg'));		



					}



				}



				else



				{



					/** Fixing width size to body container **/



					if($sourceWidth > 1000)



					{



						$ext = substr(strrchr($model->temp_profile_bg_image,'.'),1);



						$ext = strtolower($ext);



						$this->createImagetofixbodysize(Yii::app()->basePath."/../images/uploads/backgroundimages/".$model->temp_profile_bg_image,1000,$ext);	



					}



					$this->redirect(Yii::app()->createUrl('finao/motivationmesg',array('imgupload'=>1)));



				}



				}



					else



				$this->redirect(Yii::app()->createUrl('finao/motivationmesg',array('errormsg'=>1)));



		}



		}



			



		



		



	}



	



	public static function createImagetofixbodysize($filename,$targetwidth,$fileext)
	{
		$t_width = $targetwidth;
		//$t_height = 350;
		if(file_exists($filename))
		{
			list($w,$h) = getimagesize($filename);
			$ratio = ($t_width/$w); 
			$nw = ceil($w * $ratio);
			$nh = ceil($h * $ratio);
			$nimg = imagecreatetruecolor($nw,$nh);
			$size = getimagesize($filename);
			switch ($size['mime']) {
			case "image/gif":
			break;
			case "image/jpeg":
			$im_src = imagecreatefromjpeg($filename); 
			break;
			case "image/png":
			$im_src = imagecreatefrompng($filename); 
			break;
			case "image/bmp":
			break;
			} 
			imagecopyresampled($nimg,$im_src,0,0,0,0,$nw,$nh,$w,$h);
			switch ($size['mime']) {
			case "image/gif":
			break;
			case "image/jpeg":
			imagejpeg($nimg,$filename,100);
			break;
			case "image/png":

			imagepng($nimg,$filename,9);

			break;

			case "image/bmp":

			 

			break;

			} 

			

			//imagejpeg($nimg,$filename,100);

		}



	}



	



	public static function generatethumb($src,$dest,$width,$height)
	{
		//orginal source path
		$source =  $src;
		// Set the thumbnail name
		$thumbnail = $dest;
		$thumb_width = $width;
		$thumb_height = $height;
		// Get new sizes
		list($width1, $height1) = getimagesize($source);
		//$newwidth = 90; // This can be a set value or a percentage of original size ($width)
		//$newheight = 90; // This can be a set value or a percentage of original size ($height)
		$width = $width1;
		$height = $height1;
		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;
		if ( $original_aspect >= $thumb_aspect )
		{
		// If image is wider than thumbnail (in aspect ratio sense)
		$newheight = $thumb_height;
		$newwidth = $width / ($height / $thumb_height);
		}
		else
		{
		// If the thumbnail is wider than the image
		$newwidth = $thumb_width;
		$newheight = $height / ($width / $thumb_width);
		}

		$thumb = imagecreatetruecolor($newwidth,$newheight);
		$ext = substr(strrchr($source,'.'),1);
		$ext = strtolower($ext);
		switch($ext)
		{
		case 'jpeg':
		case 'jpg':
		$source1 = imagecreatefromjpeg($source);
		break;
		case 'png':	
		$source1 = imagecreatefrompng($source);
		break;	
		case "gif":
		$source1 = imagecreatefromgif($source); 
		}
		imagecopyresampled($thumb, $source1, 0, 0, 0, 0, $newwidth, $newheight, $width1, $height1);
		imagejpeg ($thumb, $thumbnail, 100);
	}



	



	public function actionCropImage()
	{
		$t_width = 980;	// Maximum thumbnail width
		$t_height = 350;	// Maximum thumbnail height
		//$new_name = "small".$session_id.".jpg"; // Thumbnail image name
		$path = Yii::app()->basePath."/../images/uploads/backgroundimages/";
       // $path = Yii::getPathOfAlias('webroot')."/images/tiles/";
		if(isset($_GET['tileimageid']) && $_GET['tileimageid'] != 0)
		{
			$t_width = 440;
			$t_height = 320;



			//$path = Yii::getPathOfAlias('webroot')."/images/tiles/";



			$path = Yii::app()->basePath."/../images/tiles/";

			//$path = Yii::app()->basePath."/../images/uploads/backgroundimages/";



			



			 



			//echo $path;



			//exit;



		}



		if(isset($_GET['t']) and $_GET['t'] == "ajax")



			{



				extract($_GET);



				//$new_name = "small".$imagefilename.".jpg";



				//$new_name = $imagefilename; 



				$ratio = ($t_width/$w); 



				$nw = ceil($w * $ratio);



				$nh = ceil($h * $ratio);



				



					



				if(file_exists($path.$img))



				{



					$nimg = imagecreatetruecolor($nw,$nh);



					$fileext = strtolower($fileext);



				/*	switch($fileext)

					{

						case 'jpeg':

						case 'jpg':

									$im_src = imagecreatefromjpeg($path.$img);

									break;

						case 'png':	

									$im_src = imagecreatefrompng($path.$img);

									break;						

					}*/

					

					/*$handle = finfo_open(FILEINFO_MIME); 

					$mime_type = finfo_file($handle, $path.$img);

					$mime_type = mime_content_type($path.$img);*/

					

					/*	$file_info = new finfo(FILEINFO_MIME);

						$mime_type = $file_info->buffer(file_get_contents($path.$img));

								

								echo $mime_type;exit;*/

					

					/*$mime_type = mime_content_type($path.$img);

					//echo $mime_type;exit;

					switch(strtolower($mime_type)) {

					case 'image/gif':

					$im_src = imagecreatefromgif($path.$img);

					break;

					case 'image/png':

					$im_src = imagecreatefrompng($path.$img);

					break;

					case 'image/jpeg':

					$im_src = imagecreatefromjpeg($path.$img);

					break;

					}*/

					

					$size = getimagesize($path.$img);

					

					switch ($size['mime']) {

					case "image/gif":

					

					break;

					case "image/jpeg":

					$im_src = imagecreatefromjpeg($path.$img); 

					break;

					case "image/png":

					$im_src = imagecreatefrompng($path.$img); 

					break;

					case "image/bmp":

					

					break;

					} 



									



				//mysql_query("UPDATE users SET profile_image_small='$new_name' WHERE uid='$session_id'");



					imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w,$h);



					//imagejpeg($nimg,$path.$img,90);

					

					/*switch(strtolower($mime_type)) {

					case 'image/gif':

					imagegif($nimg,$path.$img,90);

					break;

					case 'image/png':

					imagepng($nimg,$path.$img,9);

					break;

					case 'image/jpeg':

					imagejpeg($nimg,$path.$img,90);

					break;

					}*/

					

					

					switch ($size['mime']) {

					case "image/gif":

					imagegif($nimg,$path.$img,90);

					break;

					case "image/jpeg":

					imagejpeg($nimg,$path.$img,90);

					break;

					case "image/png":

					imagepng($nimg,$path.$img,9);

					break;

					 

					}



					$filename = $path.$img;



					list($sourceWidth,$sourceHeight) = getimagesize($filename);



					if(isset($_GET['tileimageid']) && $_GET['tileimageid'] != 0)



					{



						if($sourceWidth > 440 && $sourceHeight > 320)		



						{



							$img = "images/tiles/".$img;



				 			$image = Yii::app()->image->load($img);



			     			$image->resize(440, 320);



							$image->save("images/tiles/".$img);	



						}



						$img_new_src = str_replace("temptile-","",$img);



						



						if(copy($path.$img,$path.$img_new_src))



						{



							$id=Yii::app()->session['login']['id'];



							$usertileid = $_GET['tileimageid'];



							$model = TilesInfo::model()->findByAttributes(array('tile_id'=>$usertileid,'createdby'=>$id));



							//$model= UserProfile::model()->findByAttributes(array('user_id'=>$id));



							if($model->tile_imageurl != "" && $model->Is_customtile==1)



							{



								if(file_exists($path.$model->tile_imageurl))



									unlink($path.$model->tile_imageurl);



							



							}



							$model->tile_imageurl = $img_new_src;



							if($model->save(false))



							{



								if(file_exists($path.$img))



									unlink($path.$img);



							}



						}



						



						echo "newfile";



						exit;



					}



					else



					{



						if($sourceWidth > 980 && $sourceHeight > 350)		



						{



							$img = "images/uploads/backgroundimages/".$img;



				 			$image = Yii::app()->image->load($img);



			     			$image->resize(980, 350);



							$image->save("images/uploads/backgroundimages/".$img);	



						}



						$img_new_src = str_replace("tempbg-","",$img);



						



						if(copy($path.$img,$path.$img_new_src))



						{



							$id=Yii::app()->session['login']['id'];



							$model= UserProfile::model()->findByAttributes(array('user_id'=>$id));



							if($model->profile_bg_image != "")



							{



								if(file_exists($path.$model->profile_bg_image))



									unlink($path.$model->profile_bg_image);



							



							}



							$model->profile_bg_image = $img_new_src;



							if($model->save(false))



							{



								if(file_exists($path.$img))



									unlink($path.$img);



							}



						}



						



						echo "newfile";



						exit;



					}



				}



				else



				{



					echo "Please try again!!";



				}



			}



	}







	







	public function actionFbfriendlist()







	{	







		$knownusers = array();







		$listData = "";$i=0;







		if(isset(Yii::app()->session['fbusers']))







		{







			foreach(Yii::app()->session['fbusers'] as $fbuserlist)







			{







				$knownusers[$i++] = $fbuserlist["id"];







			}







			







			//$knownusers = Yii::app()->session['fbusers'];	







			$model = User::model()->findAll(array('select'=>'fname,userid,lname,socialnetworkid','condition'=>"userid not in (".Yii::app()->session['login']['id'].")"));







			if(!empty($model))







			foreach($model as $email)







			{







				$getimage = UserProfile::model()->findByAttributes(array('user_id'=>$email->userid));







				if(isset($getimage->profile_image) && $getimage->profile_image!="")







				{







					if(file_exists(Yii::app()->basepath.'/../images/uploads/profileimages/'.$getimage->profile_image))







						$profileimage = $this->cdnurl.'/images/uploads/profileimages/'.$getimage->profile_image;







					else







						$profileimage = $this->cdnurl.'/images/no-image.jpg';	







				}else{







					$profileimage = $this->cdnurl.'/images/no-image.jpg';







				}







				if(in_array($email->socialnetworkid , $knownusers))







				{







					//print_r($knownusers);







					$listData .= '<div class="friend-pic"><a href="'. Yii::app()->createUrl('finao/motivationmesg/frndid/'.$email->userid).'" ><img src="'.$profileimage.'" title="'.ucfirst($email->fname)." ".ucfirst($email->lname).'" width="35" height="35" /></a></div>';







				}







			}







		}







		else 







		{







			$listData = "";







		}







		echo $listData;







	}







	







	public function addTrackingNotifications($userid,$tileid,$notifytext,$finaoid,$journalid)







	{







		







		$tracker_userid = Tracking::model()->findAll(array('condition'=> 'tracked_tileid = '.$tileid.' and tracked_userid ='. $userid,'group'=>'tracker_userid'));







		$notifyaction = Lookups::model()->findByAttributes(array('lookup_name'=>$notifytext,'lookup_type'=>'notificationaction','lookup_status'=>1));







		







		foreach($tracker_userid as $eachtracheduser)







		{







			$modeltrackNotification = new Trackingnotifications;







			$modeltrackNotification->tracker_userid = $eachtracheduser->tracker_userid;







			$modeltrackNotification->tile_id = $tileid;







			$modeltrackNotification->notification_action = $notifyaction["lookup_id"];







			$modeltrackNotification->updateby = $userid;







			$modeltrackNotification->createdby = $userid;







			$modeltrackNotification->createddate = new CDbExpression('NOW()');







			$modeltrackNotification->updateddate = new CDbExpression('NOW()');







			







			if(isset($finaoid) && $finaoid > 0)







				$modeltrackNotification->finao_id = $finaoid;







			if(isset($journalid) && $journalid > 0)	







				$modeltrackNotification->journal_id = $journalid;







			







			if($modeltrackNotification->save(false))	







				{







					//echo "saved";







				}







				







		}







	}







	public function getmyheroesdata($userid,$share)



	{



		$criteria = new CDbCriteria();



		$criteria->join = ' Join  fn_user_finao t1 ON t.finao_id = t1.user_finao_id ';



		$criteria->join .= ' JOIN fn_users t2 ON t.updateby = t2.userid';



		$criteria->join .= ' JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = "notificationaction"';



		$criteria->join .= ' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = "finaostatus" ';



		$criteria->join .= ' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id ';



		$criteria->order .= 't.updateddate desc';



		$criteria->group = ' t.tile_id, t.finao_id ,round(UNIX_TIMESTAMP(t.updateddate) / 600) desc';



		$criteria->condition = ' t.tracker_userid = '.$userid.' and t1.finao_status_Ispublic = 1 and t1.finao_activestatus = 1';



		$criteria->select = 't.*, t1.finao_msg, t4.lookup_name as finaostatus, t1.updateddate as finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id ';



		$trackingppl = Trackingnotifications::model()->findAll($criteria);



		



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



		



		



		return array('trackingppl'=>$trackingppl,'uploadinfo'=>$uploadinfo,'users'=>$users);







	}



	



	public function getlatestuploaddetails($ids,$upsourcetypeid)



	{



		$sql = "SELECT * FROM (



					SELECT * FROM `fn_uploaddetails` 



					WHERE upload_sourceid IN ( ".$ids." ) and upload_sourcetype = ".$upsourcetypeid." and status = 1 ORDER BY uploadeddate DESC



					)t1



				GROUP BY upload_sourceid";







		$connection=Yii::app()->db; 



		$command=$connection->createCommand($sql);



		$uploadinfo = $command->queryAll();



		return $uploadinfo;



	}







	public function actionGetmyheroes()



	{



		$userid = $_REQUEST['userid'];



		$share = $_POST['share'];



		$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));



		



		$myheroarray = $this->getmyheroesdata($userid,$share);



		



		$this->renderPartial('_myheroes',array('trackingppl'=>$myheroarray['trackingppl'],'uploadinfo'=>$myheroarray['uploadinfo'],'userid'=>$userid,'userinfo'=>$userinfo,'share'=>$share,'users'=>$myheroarray['users']));







	}







	public function actionNewTileFinao()







	{







		$userid = (isset($_POST['userid'])) ? $_POST['userid'] : Yii::app()->session['login']['id'];







		$finaomesg = $_POST['finaomesg'];







		$newfinao = new UserFinao;







		$newfinao->userid = $userid;







		$newfinao->createddate = new CDbExpression('NOW()');







		$newfinao->updatedby = $userid;







		$newfinao->updateddate = new CDbExpression('NOW()');







		$newfinao->finao_status = 38;







		$newfinao->finao_msg = $finaomesg;







		if($newfinao->save(false))







			echo $newfinao->user_finao_id;







		







	}



	



	public function actionDeletefj()



	{



		$userid = $_POST['userid'];



		$journalid = $_POST['journalid'];



		$tileid=$_POST['tileid'];



		$type = $_POST['type'];



		$imagetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Image'));



		$videotypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadtype','lookup_status'=>1,'lookup_name'=>'Video'));



		







		$sourcetypeidfinao = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));







		







		$sourcetypeidtile = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'tile'));







		$tracked_tileids=Yii::app()->session['login']['id'];



			$tileinfo = Tracking::model()->findAllByAttributes(array('tracked_userid'=>$tracked_tileids,'tracked_tileid'=>$tileid));



			//echo $tileinfo['0']['tracking_id']; exit;	



			if(isset($tileinfo['0']['tracking_id']))



			{



				$tileinfo = Tracking::model()->findByAttributes(array('tracking_id'=>$tileinfo['0']['tracking_id']));



				$tileinfo->delete();



			}







		$sourcetypeidjournal = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'journal'));



		if($type=="journal")



		{



			$flag = "";



			$delfiles = Uploaddetails::model()->findByAttributes(array('uploadtype'=>$imagetypeid->lookup_id,'upload_sourcetype'=>$sourcetypeidjournal->lookup_id,'upload_sourceid'=>$journalid,'uploadedby'=>$userid));



			$delfiles1 = Uploaddetails::model()->findByAttributes(array('uploadtype'=>$videotypeid->lookup_id,'upload_sourcetype'=>$sourcetypeidjournal->lookup_id,'upload_sourceid'=>$journalid,'uploadedby'=>$userid));



			



			$delid = UserFinaoJournal::model()->findByPk($journalid);



			if(isset($delid) && !empty($delid))



			{



				$delid->delete();



				//$delid->journal_status = 2;



				//$delid->save(false);



			}



				



			echo "successful";



		}



		if($type=="finao")



		{



			$delfiles = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$imagetypeid->lookup_id,'upload_sourcetype'=>$sourcetypeidfinao->lookup_id,'upload_sourceid'=>$journalid,'uploadedby'=>$userid));



			$delfiles1 = Uploaddetails::model()->findAllByAttributes(array('uploadtype'=>$videotypeid->lookup_id,'upload_sourcetype'=>$sourcetypeidfinao->lookup_id,'upload_sourceid'=>$journalid,'uploadedby'=>$userid));



			if(isset($delfiles) && !empty($delfiles))



			{



				foreach($delfiles as $image)



				{



					$image->status = 2;



					$image->save(false);



				}



				



				



			}



			if(isset($delfiles1) && !empty($delfiles1))



			{



				foreach($delfiles1 as $video)



				{



					$video->status = 2;



					$video->save(false);



				}



				



			}



			$journals = UserFinaoJournal::model()->findAllByAttributes(array('finao_id'=>$journalid,'user_id'=>$userid));



			if(isset($journals) && !empty($journals))



			{



				foreach($journals as $eachjournal)



				{



					$eachjournal->journal_status = 2;



					$eachjournal->save(false);



				}



			}



				//$journals->delete();



			$tiles = UserFinaoTile::model()->findAllByAttributes(array('finao_id'=>$journalid,'createdby'=>$userid));



			if(isset($tiles) && !empty($tiles))



			{



				foreach($tiles as $eachtile)



				{



					$eachtile->status = 2;



					$eachtile->save(false);



				}



			}



			$finaodel = UserFinao::model()->findByPk($journalid);



			if(isset($finaodel) && !empty($finaodel))



			{



				$finaodel->finao_activestatus = 2;



				$finaodel->save(false);



				



			}



			$tracked_tileids=Yii::app()->session['login']['id'];



			$tileinfo = Tracking::model()->findAllByAttributes(array('tracked_userid'=>$tracked_tileids,'tracked_tileid'=>$tileid));



			//echo $tileinfo['0']['tracking_id']; exit;	



			if(isset($tileinfo['0']['tracking_id']))



			{



				$tileinfo = Tracking::model()->findByAttributes(array('tracking_id'=>$tileinfo['0']['tracking_id']));



				$tileinfo->delete();



			}



			/*if(isset($finaodel) && !empty($finaodel))



				$finaodel->delete();*/



			echo "successful";



		}



	}



	



	public function actionGetprofiledetails()



	{



		if(!isset(Yii::app()->session['login']['id']))



		{



			$this->redirect(array('/'));



		}



		$tilename = $_REQUEST['tile_name'];



		



		$sql = "select t.userid,t.fname,t.lname, t1.user_location,t1.profile_image, t2.*



		from fn_users t 



		join fn_user_profile t1 on t.userid = t1.user_id



                join (select t.*,t2.tilename,t3.lookup_name 



                              from fn_user_finao  t 



                              join fn_user_finao_tile t1 on t.user_finao_id = t1.finao_id and t.userid = t1.userid



			      join fn_tilesinfo t2 on t1.tile_id = t2.tile_id and t1.userid = t2.createdby	



                              join fn_lookups t3 on t.finao_status = t3.lookup_id 



                              where t2.tilename like '".$tilename."'



                              and t.finao_activestatus = 1



                              and t.finao_status_Ispublic = 1



                              group by t.userid,t1.tile_id



                              order by t.updateddate desc)  



		t2 on t.userid = t2.userid



		group by  t.fname,t.lname



                order by t.fname,t.lname";



		



		$connection=Yii::app()->db; 



		$command=$connection->createCommand($sql);



		$userdet = $command->queryAll();



		



		$finaoids = "";



		for($i=0;$i<count($userdet);$i++)



		{



			$finaoids .= $userdet[$i]["user_finao_id"] . ",";



		}



		



		if($finaoids != "")



		{



			$finaoids = substr($finaoids,0,strlen($finaoids)-1);



			$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));



			$uploaddetails = $this->getlatestuploaddetails($finaoids,$sourcetypeid->lookup_id);



		}



		



		$this->render('searchresults',array('userdets'=>$userdet



											,'uploaddetails'=>$uploaddetails



											,'tilename'=>$tilename



											,'totalcnt'=>count($userdet)));



		



	}



		



	//action to show and edit mytagnotes



	public function actionEditNotes()



	{



		$notetxt = isset($_REQUEST['notestext']) ? $_REQUEST['notestext'] : "";



		$id = isset($_REQUEST['noteid']) ? $_REQUEST['noteid'] : "";



		if($id != "")



		{



			$model=FinaoTagnote::model()->findByPk($id);	



			$model->finao = $notetxt;



			if($model->save(false))



				echo $notetxt;



		}



			



	}



	



	public function actionViewJournal()



	{



		



		$finaoid = $_POST['finaoid'];



		$userid = $_POST['userid'];



		$iscompleted = $_POST['iscompleted'];



		$share = $_POST['isshare'];



		$page = isset($_POST['pageid']) ? $_POST['pageid'] : 1 ;



		$heroupdate = (isset($_POST['heroupdate'])) ? $_POST['heroupdate'] : "" ;



		$journalid = 0;



		



		$Criteria = new CDbCriteria;



		$Criteria->condition = "finao_id = '".$finaoid."' AND journal_status = 1 ";



		$Criteria->addCondition("createdby = '".$userid."'", 'AND');



		$Criteria->order = "updateddate DESC";	



		$journals = UserFinaoJournal::model()->findAll($Criteria);



		



		$noofpagjou = count($journals);



		$prejouid = 0;



		$nextjouid = 0;



		if(isset($_REQUEST['journalid']) && $_REQUEST['journalid'] != 0 && $_REQUEST['journalid'] != "")



		{



			$journalid = $_REQUEST['journalid'];



			$jourflag = true;



					



			/** --- Journal Navigation code for journal id --- **/



			



			for($j=0;$j < $noofpagjou; $j++)



			{



				if($journals[$j]["finao_journal_id"] == $journalid)



				{



					if($j+1 < $noofpagjou)



					{



						$nextjouid = $journals[$j+1]["finao_journal_id"];



						if($j-1 < 0)



							$prejouid = $journals[$noofpagjou - 1]["finao_journal_id"];



						if($j-1 >= 0)



							$prejouid = $journals[$j-1]["finao_journal_id"];		



					}



					else 



					{



						/*--- When navigation reachs to end of records, then NEXT should start from Initial stage --- */



						$nextjouid = $journals[0]["finao_journal_id"];



						$prejouid = $journals[$j-1]["finao_journal_id"];		



					}



				}



			}







		}



		else



		{



			$jourflag = true;



			//foreach($journals as $jourdet)



			for($j=0;$j < $noofpagjou; $j++)



			{



				if($jourflag)



				{



					$journalid = $journals[$j]["finao_journal_id"];



					$jourflag = false;



					if($j+1 < $noofpagjou)



					{



						$nextjouid = $journals[$j+1]["finao_journal_id"];



						if($j-1 <= 0)



							$prejouid = $journals[$noofpagjou - 1]["finao_journal_id"];



						else



							$prejouid = $journals[$j-1]["finao_journal_id"];		



					}



					



					/*if($j-1 >= 0)



					{



						$prejouid = $journals[$j-1]["finao_journal_id"];	



					}*/



				}



			}



			



			/** --- Journal Navigation code --- **/



			



			$jornavigation = $this->getpagedetails($journals,1,1,1);



			



		}



		if($prejouid == 0)



			$prejouid = $nextjouid;



		if($nextjouid == 0)



			$nextjouid = $prejouid;	



		



		$jornavigation['prev'] = $prejouid;



		$jornavigation['next'] = $nextjouid;



		$jornavigation['noofpage'] = $noofpagjou;



		$jornavigation['limittxt'] = 1;



		$jorlimi = "";	



		$jorlimi = $jornavigation['limittxt'];



			



		$Criteria->limit = $jorlimi;



		$Criteria->addCondition("finao_journal_id = ".$journalid,"and");



		$journals = UserFinaoJournal::model()->findAll($Criteria);



	



		$userinfo = User::model()->findByPk($userid);



		$finaoinfo = UserFinao::model()->findByPk($finaoid);







		$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'journal'));



		



		/** --- Image and Video Navigation code --- **/







		$Criteria = new CDbCriteria(); 



		$Criteria->condition = "upload_sourcetype = '".$sourcetypeid->lookup_id."' AND upload_sourceid = '".$journalid."' and status = 1 ";



		$Criteria->order = "uploadeddate desc";



		$getimages = Uploaddetails::model()->findAll($Criteria);



		



		$imageexists = "noimage";



		$videoexists = "novideo";



		foreach($getimages as $updet)



		{



			if($updet->uploadtype == 34)//34 is the lookupid for Image



				$imageexists = true;



			if($updet->uploadtype == 35 && $updet->status == 1)//35 is the lookupid for Video



				$videoexists = true;



		}



				



		$upldimgVidarray = $this->getpagedetails($getimages,1,1,1);



		$limittxt = "";



		if(isset($upldimgVidarray))



		{



			$limittxt = $upldimgVidarray['limittxt'];	



		}



		



		$Criteria->limit = $limittxt;



		$Criteria->offset = $upldimgVidarray['offset'];



		$getimages = Uploaddetails::model()->findAll($Criteria);



		$getimagesdetails = array();



		$getimagesdetails = $this->getImageResizeValue($getimages);



			



		$finaostatus = Lookups::model()->findAll(array('condition'=>'lookup_type = "finaostatus" AND lookup_status = 1'));



		$tileid = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid));



		$count = $this->GetMediaJournalCount($finaoid);



		$this->renderPartial('_newviewJournals'



									,array('journals'=>$journals



											,'finaoinfo'=>$finaoinfo



											,'status'=>$finaostatus



											,'userid'=>$userid



											,'tileid'=>$tileid



											,'getimages'=>$getimages



											,'share'=>$share,'page'=>$page,'userinfo'=>$userinfo



											,'completed'=>$iscompleted,'heroupdate'=>$heroupdate



											,'upldimgVidarray'=>$upldimgVidarray



											,'getimagesdetails'=>$getimagesdetails



											,'finaoid'=>$finaoid



											,'journalid'=>$journalid



											,'jornavigation'=>$jornavigation



											,'imageexists'=>$imageexists



											,'videoexists'=>$videoexists



											,'count'=>$count



											));



	



		



	}



	



	public function actionGetVideoDetails()



	{



		        



				 



				$vidler = Yii::app()->getComponents(false);



				$user = $vidler['vidler']['user'];



			    $pass = $vidler['vidler']['pwd'];



			    $api_key = $vidler['vidler']['appkey'];







			    $v = new Viddler_V2($api_key);



			    $auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



			    $sessionid = $auth['auth']['sessionid'];







				



				$callback_url ='http://'. $_SERVER['HTTP_HOST'] .'' . $_SERVER['SCRIPT_NAME'] . '/finao/GetUpdatedvideo/uploadid/'.$_POST['uploadedid'].'/upload/Video/finaoid/'.$_POST['finaoid'].'';



				 



		   



			    $prepare_resp = $v->viddler_videos_prepareUpload(array('sessionid' => $sessionid));



				$upload_server = $prepare_resp['upload']['endpoint'];



	            $upload_token = $prepare_resp['upload']['token'];







			 



				



				//$this->updateviddlerstatus($sessionid,$uploadedimages,$v);



				



				 







				$this->renderPartial('_updatefinaovideo',array( 



													/*,'uploadedimages'=>$uploadedimages*/



													 'callback_url'=>$callback_url



													,'upload_server'=>$upload_server



													,'upload_token'=>$upload_token



													,'uploadedid'=>$_POST['uploadedid']



													,'finaoid' => $_POST['finaoid'] 



													 



													  



													



													));	







			



	}



	 



	public function actionGetUpdatedvideo()



	{



		 



		if(isset($_REQUEST["videoid"]))



			{



				$uploadid = $_REQUEST['uploadid'];



				$videoid = $_REQUEST["videoid"];



				$finaoid = $_REQUEST['finaoid'];







				$vidler = Yii::app()->getComponents(false);



				$user = $vidler['vidler']['user'];



				$pass = $vidler['vidler']['pwd'];



				$api_key = $vidler['vidler']['appkey'];



	



				$callback_url = '/';



				$v = new Viddler_V2($api_key);



				$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



				$sessionid = $auth['auth']['sessionid'];



	



				$results=$v->viddler_videos_getDetails(array('sessionid' => $sessionid,'video_id'=>$videoid));



			}	



			else



			{



				



				$finaoid = $_POST['finaoid'];



				$uploadid = $_POST['uploadid'];



				$videoembcodeURL = $_REQUEST['txtVidembedUrl']; 



				$videodesc = $_REQUEST['vdurldescription'];	



				$yt_vid = $this->extractUTubeVidId($videoembcodeURL);



				$videoembcode = $this->generateYoutubeEmbedCode($yt_vid,530,360);



				$videoembImgUrl = "http://img.youtube.com/vi/".$yt_vid."/mqdefault.jpg";



				



			}







			$fid = $finaoid;



			$uploaddetailid = $uploadid;



			$upload = new Uploaddetails;



			$upload = Uploaddetails::model()->findByPk($uploaddetailid);



			if(!empty($upload))



			{



				//$upload->uploadeddate = new CDbExpression('NOW()');

				$upload->status = 1;



				$upload->updateddate = new CDbExpression('NOW()');



				$upload->videoid = $videoid;



				$upload->videostatus = isset($results['video']['status']) ? (($results['video']['status'] == "not ready") ? "Encoding in Process" : $results['video']['status'])  : "ready";



				$upload->video_img = isset($results['video']['thumbnail_url']) ? $results['video']['thumbnail_url'] : $videoembImgUrl;



				



				$upload->video_caption = isset($results['video']['title']) ? $results['video']['title'] : $videodesc;



				$upload->video_embedurl = $videoembcode;



				



				if($upload->save(false))



				{



					$finaos = new UserFinao;



					$finaos = UserFinao::model()->findByPk($fid);



					if(!empty($finaos))



					{



						$finaos->updateddate = new CDbExpression('NOW()');



						$finaos->save(false);



					  



				 



					



					if(isset($_REQUEST["videoid"]))



					{



						$this->redirect(Yii::app()->createUrl('finao/motivationMesg',array('menutype'=>'finao'



																   ,'finaoid'=>$fid



																   )));



					}else



					{



						echo $fid;



					}																	   



																							   



					}



					



					 



					



				}



			}



			



	}



	



	public function getpagedetails($getimages,$IsLimitNumber,$pageID,$noelementsperpage)



	{



		



		$totImgVid = count($getimages);



		$limitImg = $noelementsperpage;



		$noofpagImgVid = ceil($totImgVid/$limitImg) ;



		$pageImg = ($pageID != "") ? $pageID : 1 ;



		



		$offsetImg = ($pageImg-1)*$limitImg;



		



		if($pageImg == 1){



				$prevImg = $noofpagImgVid;



				$nextImg = $pageImg+1;



			}else if($pageImg == $noofpagImgVid){



				$prevImg = $pageImg-1;



				$nextImg = 1;



			}else{



				$prevImg = $pageImg-1;



				$nextImg = $pageImg+1;	



			}



		



		$lastpageImg = ceil($totImgVid/$limitImg);



    	$lpm1Img = $lastpageImg - 1;



		$limitvalueImg =  "";



		$limitvalueImg = " limit ".$offsetImg.",".$limitImg;



		



		if($IsLimitNumber)



			$limitvalueImg = $limitImg;



		



		return array(



				'prev'=>$prevImg



				,'next'=>$nextImg



				,'noofpage'=>$noofpagImgVid



				,'limittxt'=>$limitvalueImg



				,'offset'=>$offsetImg



				);



	}



	



	public function getviddlembedCode($videoid,$width,$height)



	{



		$vidler = Yii::app()->getComponents(false);



		$user = $vidler['vidler']['user'];



		$pass = $vidler['vidler']['pwd'];



		$api_key = $vidler['vidler']['appkey'];







		$v = new Viddler_V2($api_key);



		$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



		$embcode = $v->viddler_videos_getEmbedCode(array(



	                       'sessionid' => $auth['auth']['sessionid'],



	                       'video_id' =>$videoid,



	                       'embed_code_type' => 5,



						   'width'=>$width,//532,



	                       'height'=>$height,//305,



						   'player_type'=>'simple',



	                      ));



		 



		return $embcode["video"]["embed_code"];



		



	}



	



	public function getpagecount($totalcount,$limit,$page)



	{



		$totalcount = count($uploadImages);



		$noofpages = ceil($totalcount/$limit) ;



		$offset = ($page-1)*$limit;



		if($page == 1){



			$prev = $noofpages;



			$next = $page+1;



		}else if($page == $noofpages){



			$prev = $page-1;



			$next = 1;



		}else{



			$prev = $page-1;



			$next = $page+1;	



		}	



		



		$lastpage = ceil($totalcount/$limit);



    	$lpm1 = $lastpage - 1;



		return array(



					'limit'=>$limit



					,'offset'=>$offset



				); 



	}



	



	public function getImageResizeValue($getimages)



	{



		$i=0; $getimagesdetails = array();



		



		foreach($getimages as $allimages)



		{



			$filename = Yii::app()->basePath .'/../'.$allimages["uploadfile_path"].'/'.$allimages["uploadfile_name"];				



			$targetWidth = 158;//400;//200;



			$targetHeight = 240;//300; 



			if(file_exists($filename))



			{



				list($sourceWidth,$sourceHeight) = getimagesize($filename);



				if($sourceWidth <= $targetWidth && $sourceHeight <= $targetHeight)



				{



					$resizeWidth = $sourceWidth;



					$resizeHeight = $sourceHeight;



				}



				else



					{



						if($sourceWidth > $sourceHeight)



						{



							$targetWidth = 300;



							$targetHeight = 143;



						}







					$resizevalue = $this->getImgWidthHeight($filename,$targetWidth,$targetHeight,$sourceWidth,$sourceHeight);



						$resizeWidth = $resizevalue['resizeWidth'];



						$resizeHeight = $resizevalue['resizeHeight'];



					}



				$getimagesdetails[$i]["uploadfile_id"] = $allimages["uploaddetail_id"];



				$getimagesdetails[$i]["resizeWidth"] = $resizeWidth;



				$getimagesdetails[$i++]["resizeHeight"] = $resizeHeight;	



			}



		}



		return $getimagesdetails;		



	}



	



	public function findvalidtileimage($tilename,$userid)



	{



		$tileimgurl = "";



		$tilename = str_replace(" ","",$tilename);



		$tileimgarry = array(strtolower($tilename).".png"



									, strtolower($tilename).".jpg"



									, $userid ."-".strtolower($tilename).".png"



									, $userid ."-".strtolower($tilename).".jpg"



									, $userid ."-".strtolower($tilename).".jpeg" );







				



		foreach($tileimgarry as $imgurl)



		{



			if(file_exists(Yii::app()->basePath."/../images/tiles/".$imgurl))



			{



				$tileimgurl = $imgurl;



			}



		}



		return $tileimgurl;		



	}



	



	public function gettileSqlquery($userid)



	{



	



		$sql = "select distinct f.tile_id , f.tilename , f.tileimg from



(



	(select t2.tile_id,t2.tilename ,t2.tile_imageurl as tileimg



				from fn_user_finao_tile t 



				join fn_user_finao t1 on t.finao_id = t1.user_finao_id



				join fn_tilesinfo t2 on t.tile_id = t2.tile_id and t.userid = t2.createdby



				where t.userid = ".$userid." and t.status = 1 and t1.finao_activestatus != 2 



								group by tile_id,t2.tilename)



union



				(select lookup_id,lookup_name, concat(lower(lookup_name),'.jpg') as tileimg from fn_lookups 



				where lookup_type = 'tiles' and lookup_status = 1)



				



				



				) as f group by f.tile_id,f.tilename

ORDER BY `f`.`tilename` ASC";



		



		$connection=Yii::app()->db; 



		$command=$connection->createCommand($sql);



		$tiles = $command->queryAll();



		return $tiles;



	}



	



	public function actionEditTile()



	{



		$userid = $_POST['userid'];



		$usertileid = $_POST['usertileid'];



		$tilename = ($_POST['tilename']) ? $_POST['tilename'] : "" ;







		$tilenameexists = TilesInfo::model()->findByAttributes(array('tilename'=>$tilename,'createdby'=>$userid));



		if(isset($tilenameexists) && !empty($tilenameexists))



		{



			echo "Tilename exists";



			



		}



		else



		{



		$edittile = TilesInfo::model()->findByAttributes(array('tile_id'=>$usertileid,'createdby'=>$userid));



		$edittile->tilename = $tilename;



		$edittile->updatedby = $userid;



		$edittile->updateddate = new CDbExpression('NOW()');



		if($edittile->save(false))



			echo "saved";



		}



	}



	



	public function actionGetallFinao()



	{



		



		//print_r($_POST);exit;



		$userid = $_REQUEST['userid'];



		$share = $_REQUEST['share'];



		$pageid = $_REQUEST['pageid'];



		$Iscomplete = "";



		$noofelements = 8;



		



		if($userid != Yii::app()->session['login']['id'] || $share == 'share')



			$noofelements = 9;



					



		$finao = $this->getfinaoinfo($userid,$Iscomplete,$share,$noofelements,$pageid,0);



		$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));



		$this->renderPartial('_displayallfinaos',array(



													'finaos'=>$finao['finaos']



													,'uploaddetails'=>$finao['uploaddetails']



										 	,'finaopagedetails'=>$finao['finaopagedetails']



													,'userid'=>$userid



													,'userinfo'=>$userinfo



													,'share'=>$share



													));	



	}



	



	public function actionGetDetailTile()



	{



		$userid = $_REQUEST['userid'];



		$share = (isset($_POST['share'])) ? $_POST['share'] : "" ;



	



		$Criteria = new CDbCriteria();



		$Criteria->condition = "userid = '".$userid."' AND finao_activestatus = 1";



		if($userid != Yii::app()->session['login']['id'] ||  $share == "share")



		{



			$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');



		}



		if($userid == Yii::app()->session['login']['id'] && $share != "share")



		{



			$Criteria->addCondition("Iscompleted = 0","AND");



		}



		/*if($share == "share" || $userid != Yii::app()->session['login']['id'])



		{



			$Criteria->addCondition("finao_status_Ispublic = 1","AND");



			//$Criteria->addCondition("Iscompleted = 1","OR");



		}



		if($share != "share" && $userid == Yii::app()->session['login']['id'])



		{



			$Criteria->addCondition("Iscompleted = 1","AND");



		}*/



		if(isset($_REQUEST['tileid']) && $_REQUEST['tileid']!=0)



		{



			$tileid = $_REQUEST['tileid'];



			$finaoidarray = UserFinaoTile::model()->findAll(array('condition'=>'tile_id = "'.$tileid.'" AND userid = "'.$userid.'"'));



			$tileinfo = TilesInfo::model()->findByAttributes(array('tile_id'=>$tileid,'createdby'=>$userid));



			



			/*if(isset($finaoid) && $finaoid != 0)



			{



				$Criteria->condition .= 'and user_finao_id = "'.$finaoid.'" ';



			}



			else



			{*/



			foreach($finaoidarray as $finaoids):        



			    $ids[]=$finaoids->finao_id;



			endforeach;



			$Criteria->addInCondition('user_finao_id', $ids);	



			//}	



						



		//print_r($Criteria);







		}



		$Criteria->order = "updateddate DESC";



		$getfinaos = UserFinao::model()->findAll($Criteria);



		$finaoids = "";



		$uploaddetails = "";



		for($i=0;$i<count($getfinaos);$i++)



		{



			$finaoids .= $getfinaos[$i]["user_finao_id"] . ",";



		}



		



		if($finaoids != "")



		{



			$finaoids = substr($finaoids,0,strlen($finaoids)-1);



			$sourcetypeid = Lookups::model()->findByAttributes(array('lookup_type'=>'uploadsourcetype','lookup_status'=>1,'lookup_name'=>'finao'));



			$uploaddetails = $this->getlatestuploaddetails($finaoids,$sourcetypeid->lookup_id);



		}	



		$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));	



		$this->renderPartial('_detailtile',array('allfinaos'=>$getfinaos



														,'uploadinfo'=>$uploaddetails



														,'userid'=>$userid



														,'tileid'=>$tileid



														,'share'=>$share



														,'tileinfo'=>$tileinfo



														,'userinfo'=>$userinfo



													));



	











	}



	



	public function actionGetfollowingdetails()



	{



		$users = "";



		$userid = $_REQUEST["userid"];



		$pageid = $_REQUEST["pageid"];



		$noofelemets = 9;



				



		$users = $this->getfollowersdetails($userid,-1,0,0);



		$followarray = $this->getpagedetails($users,1,$pageid,$noofelemets);



		



		$users = $this->getfollowersdetails($userid,$followarray['limittxt'],$followarray['offset'],0);



		



		$this->renderPartial('_displyfollowdetails',array('users'=>$users



															,'followarray'=>$followarray



															,'userid'=>$userid



														));



		



	}



	



	public function getfollowersdetails($userid,$limit,$offset,$getcount)



	{



		$Criteria = new CDbCriteria;



		$Criteria->join = " join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1 ";



		$Criteria->join .= " join fn_user_finao t2 on t.userid = t2.userid ";



		$Criteria->join .= " join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id ";



		$Criteria->join .= " left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby ";



		$Criteria->join .= " left join fn_user_profile t5 on t.userid = t5.user_id ";



		$Criteria->group = " t.userid,t.fname,t.lname ";



		$Criteria->select = "t.fname,t.lname,t.userid, group_concat(Distinct t4.tilename ORDER BY t4.tilename SEPARATOR ', ') as gptilename, t5.profile_image as image";



		$Criteria->condition = " t1.tracker_userid = ".$userid." and t2.finao_activestatus = 1 and t2.finao_status_Ispublic = 1 and t3.status = 1 ";



		if($limit)



		{



			$Criteria->limit = $limit;



			$Criteria->offset = $offset;	



		}



			



		$users = User::model()->findAll($Criteria);



		if($getcount)



			return (isset($users) && $users != "") ? count($users) : 0;



		else



			return $users;		



	}



	



	public function actionGetmenucount()



	{



		$userid = $_REQUEST['userid'];



		$share = "";//$_REQUEST['share'];



		



		$tilesslider = $this->refreshtilewidget($userid,$share,0,0,1);



		$this->widget('TopMenu',array('userid'=>$userid,'isshare'=>$share



										,'alltiles'=>$tilesslider['totaltilecount']



										,'imgcount'=>$tilesslider['imgcount']



										,'videocount'=>$tilesslider['videocount']



										,'finaocount'=>$this->getfinaoinfo($userid,"",$share,-1,1,1)



										,'followcnt'=>$this->getfollowersdetails($userid,-1,0,1)



										));					



	}



	



	



	 



	public function actionaddNewJournal()



	{



 		//print_r($_POST);exit;



		



		$words = str_word_count($_POST['journalmsg'], 1);



		$lastWord = array_pop($words);	



		$lastSpacePosition = strrpos($_POST['journalmsg'], ' ');



		



		$textWithoutLastWord=$_POST['journalmsg'];



			



		$tiles = FnProfanityWords::model()->findAll();



		foreach($tiles as $tiles)



		{



			if(strtolower($lastWord)==strtolower($tiles->badword))



			{



				$textWithoutLastWord = substr($_POST['journalmsg'], 0, $lastSpacePosition);



				$textWithoutLastWord.=' **** ';



			}



		}	



		



		$journaltext = $textWithoutLastWord;



		



		$finaoid = $_POST['finaoid'];



		$userid = $_POST['userid'];



		



		if(!empty($journaltext))



		{



			$uploaddetails  = new Uploaddetails;



			$uploaddetails->upload_text = $journaltext;



			$uploaddetails->uploadtype = 62;



			$uploaddetails->upload_sourcetype = 37;



			$uploaddetails->upload_sourceid = $finaoid;



			$uploaddetails->uploadedby = $userid;



			$uploaddetails->status = 1;



			$uploaddetails->updatedby = $userid;



			$uploaddetails->uploadeddate = new CDbExpression('NOW()'); 



			$uploaddetails->updateddate = new CDbExpression('NOW()');



			$uploaddetails->caption = $_POST['caption'];



			$uploaddetails->updatedby =$userid;



		 



	



	 



		if($uploaddetails->save(false))



		{



			//return $finaoid; 



			$finaos = new UserFinao;



					$finaos = UserFinao::model()->findByPk($finaoid);



					if(!empty($finaos))



					{



						$finaos->updateddate = new CDbExpression('NOW()');



						$finaos->save(false);



					}



			$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));



			$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Added Journal',$finaoid,0);	



		



		  echo $_POST['finaoid'];



		  



		}else



		{



			echo "Please Fill all mandatory Feilds";



		}



		}







			







	



		/*



   	  // print_r($_POST);exit;



		$type = $_POST['uploadtype'];



		$journaltext = $_POST['journalmessage'];



		$finaoid = $_POST['finaoid'];



		$userid = Yii::app()->session['login']['id'];



		



		 similar_text($journaltext,'Enter a Journal Update or Click on Media Icons to upload Image/Video', $percent);



		//echo $percent;exit; 



		if( floor($percent) == 87)



		{



			$upload_sourcetype = 37;



		}



		else



		{



			$upload_sourcetype = 46;



			$newjournal = new UserFinaoJournal;



			$newjournal->user_id = $userid;



			$newjournal->finao_id = $finaoid;



			$newjournal->finao_journal = $journaltext;



			$newjournal->journal_startdate = new CDbExpression('NOW()');



			$newjournal->journal_status = 1;



			$newjournal->createdby = $userid;



			$newjournal->createddate = new CDbExpression('NOW()');



			$newjournal->updatedby = $userid;



			$newjournal->updateddate = new CDbExpression('NOW()');



			$newjournal->save(false);



			$journalid  = Yii::app()->db->getLastInsertId();



		}



		  if($type == 34)



		  {



			if(!empty($_FILES['journalimage']['name']))



			{



			$filename= '';



			$result = 'ERROR';



			$result_msg = '';



			$allowed_image = array ('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg','image/png');



			define('PICTURE_SIZE_ALLOWED', 2242880); // bytes



			if (isset($_FILES['journalimage']))  // file was send from browser



			{



			if ($_FILES['journalimage']['error'] == UPLOAD_ERR_OK)  // no error



			{



			if (in_array($_FILES['journalimage']['type'], $allowed_image)) {



			if(filesize($_FILES['journalimage']['tmp_name']) <= PICTURE_SIZE_ALLOWED) // bytes



			{



			$filename = Yii::app()->session['login']['id'].'-'.rand(125678,098754).'-'.$_FILES['journalimage']['name'];



			$source = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages'.'/'.$filename;



			move_uploaded_file($_FILES['journalimage']['tmp_name'], $source);



			if(file_exists($source))



			{



					$upload = new Uploaddetails;



					$upload->uploadtype = '34';



					$upload->uploadfile_name = $filename;



					$upload->uploadfile_path = '/images/uploads/finaoimages';



					$upload->upload_sourcetype = $upload_sourcetype;



					if($upload_sourcetype == 37)



					{



						$upload->upload_sourceid = $finaoid;



					}else



					{



						$upload->upload_sourceid = $journalid;



					}



					



					$upload->uploadedby = $userid;



					$upload->uploadeddate =  new CDbExpression('NOW()');



					$upload->status = 1;



					$upload->updatedby = $userid;



					$upload->save(false);



					$destination = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/thumbs'.'/'.$filename;



					$ext = substr(strrchr($source,'.'),1);



					$ext = strtolower($ext);



					if($ext == "jpg" || $ext == "jpeg")



					{



					$this->generatethumb($source,$destination);



			        }



			}



			//phpclamav clamscan for scanning viruses



			//passthru('clamscan -d /var/lib/clamav --no-summary '.$filename, $virus_msg); //scan virus



			$virus_msg = 'OK'; //assume clamav returing OK.



			if ($virus_msg != 'OK') {



			unlink($source);



			$result_msg = $filename." : ".FILE_VIRUS_AFFECTED;



			$result_msg = '<font color=red>'.$result_msg.'</font>';



			$filename = '';



			}else {



			// main action -- move uploaded file to $upload_dir



			$result = 'OK';



			}



			}else {



			$filesize = filesize($_FILES['file']['tmp_name']);// or $_FILES['file']['size']



			$filetype = $_FILES['file']['type'];



			$result_msg = PICTURE_SIZE;



			}



			}else {



			$result_msg = SELECT_IMAGE;



			}



			}



			elseif ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE)



			$result_msg = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';



			else



			$result_msg = 'Unknown error';



			}



			



			 // do not go futher



			}



$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));



$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Added Journal',$finaoid,0);	



			//$this->redirect(array('Finao/MotivationMesg', 'param1'=>'value1'));



			$this->redirect(array('/myhome'));



		



		  }else if($type == 35)



		  {



			   



			$videoembcodeURL = $_REQUEST['emburl']; 



			$videodesc = $_REQUEST['embdescr'];	



			$srctype = $_REQUEST['sourcetype'];



			



			$yt_vid = $this->extractUTubeVidId($videoembcodeURL);



			$videoembcode = $this->generateYoutubeEmbedCode($yt_vid,530,360);



			$videoembImgUrl = "http://img.youtube.com/vi/".$yt_vid."/default.jpg";



			











			$model =  new Uploaddetails;



			$model->uploadtype = 35;



            $model->upload_sourcetype = $upload_sourcetype;



			 



			



			if($upload_sourcetype == 37)



			{



			$model->upload_sourceid = $finaoid;



			}else



			{



			$model->upload_sourceid = $journalid;



			}



			



			



			$model->uploadedby = $userid;



			$model->uploadeddate = new CDbExpression('NOW()');



			$model->status = 1;



			



			$model->updatedby = $userid;



			$model->updateddate = new CDbExpression('NOW()');



			$model->videostatus = isset($results['video']['status']) ? (($results['video']['status'] == "not ready") ? "Encoding in Process" : $results['video']['status'])  : "ready";



			$model->video_img = isset($results['video']['thumbnail_url']) ? $results['video']['thumbnail_url'] : $videoembImgUrl;



			



			$model->caption = isset($results['video']['description']) ? $results['video']['description'] : $videodesc;



			$model->video_embedurl = $videoembcode;



			



			if($model->save(false))



				{



$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));



$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Uploaded Video for Journal',$finaoid,0);







$this->redirect(Yii::app()->createUrl('finao/motivationMesg',array('upload'=>'Video'



																	)));



					 



				}



			   



			   



			   



		  }else



		  { 



$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));



$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Added Journal',$finaoid,0);



		  }



		   



	*/}



	



	



	public function actionaddNewFinao()



	{



		$userid = Yii::app()->session['login']['id'];



		$user = User::model()->findByPk($userid);



		$userinfo = UserProfile::model()->findByAttributes(array('user_id'=>$userid));



		$Criteria = new CDbCriteria();



		$Criteria->condition = "userid = '".$userid."' AND Iscompleted = 0 AND finao_activestatus = 1";







		if(isset($_REQUEST['frndid']))



		{



			$Criteria->addCondition("finao_status_Ispublic = 1", 'AND');



		}



		$Criteria->order = "updateddate DESC";



		$finaos = UserFinao::model()->findAll($Criteria);







		if(!empty($finaos))



		{



			$Criteria = new CDbCriteria();



			$Criteria->group = 'tile_id';



			$Criteria->condition = "userid = '".$userid."'";



			if(!empty($finaos))



			{



				foreach($finaos as $finaoids):        



			    	$ids[]=$finaoids->user_finao_id;



				endforeach;



			}



			if(!empty($ids))



				$Criteria->addInCondition('finao_id', $ids);



			$Criteria->order = 'updateddate DESC';



			$tilesinfo = UserFinaoTile::model()->findAll($Criteria);



		}



		else



		{



			$tilesinfo = "";



		}



		$tileslist = $tilesinfo;



		$totaltilecount = count($tilesinfo);



		 



		 $tiles = Lookups::model()->findAll(array('condition'=>'lookup_type = "tiles" AND lookup_status = 1 '));



		  $this->renderPartial('_newfinaolayout',array('model'=>$model



														,'userid'=>$userid



														,'tiles'=>$tilesinfo



														,'newtile'=>$newtile



														,'upload'=>$upload



														,'type'=>$type



														,'userinfo'=>$userinfo)); 



		//$this->renderPartial('_newfinaolayout',array('newfinao'=>'new'));



		



		



	}











	/*public static function actionaddpostimages(){



		



		//print_r($_FILES);exit;



		foreach ($_FILES["images"]["error"] as $key => $error) 



		{



				if ($error == UPLOAD_ERR_OK) 



				{



				echo $name = $_FILES["images"]["name"][$key];



				move_uploaded_file( $_FILES["images"]["tmp_name"][$key], "uploads/" . $_FILES['images']['name'][$key]);



				}



		}



				//echo "<h2>Successfully Uploaded Images</h2>";



		}*/



	public static function actionfinaopreupload()



	{



		



		



		 



	/**************************************************************



	* This script is brought to you by Vasplus Programming Blog



	* Website: www.vasplus.info



	* Email: info@vasplus.info



	****************************************************************/







$upload_location = Yii::app()->basePath . '/../images/uploads/finaoimages/'; 



if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")



{



	$name = $_FILES['vasPhoto_uploads']['name']; 



	$size = $_FILES['vasPhoto_uploads']['size'];



	



	 



	//if(isset(Yii::app()->session['login']['filename']))



	//unset(Yii::app()->session['login']['filename']);



	 



	



	$allowedExtensions = array("jpg","jpeg","gif","png");  //Allowed file types



	foreach ($_FILES as $file) 



	{



	



	  if ($file['tmp_name'] > '' && strlen($name)) 



	  {



		  if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) 



		  {



			  echo '<div class="info" style="width:370px;">Sorry, you attempted to upload an invalid file format. <br>Only jpg, jpeg, gif and png image files are allowed. Thanks.</div>';



		  }



		  else 



		  {



			//  if($size<(1024*1024))



			 // {



    $actual_image_name =  Yii::app()->session['login']['id'].'-'.rand(125678,098754).'-'.$name; 



	if(isset(Yii::app()->session['filename'])){unset(Yii::app()->session['filename']);}



	Yii::app()->session['filename'] = $actual_image_name;







				  // This could be a random name such as rand(125678,098754).'.gif';



	/*$filename = substr(strrchr(Yii::app()->session['login']['id'].'-'.rand(125678,098754).'-'.$name,'/'),1);		*/		 



				  if(move_uploaded_file($_FILES['vasPhoto_uploads']['tmp_name'], $upload_location.$actual_image_name)) 



				  {



						if(file_exists(Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages'.'/'.$actual_image_name))



						{



						$source =  Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages'.'/'.$actual_image_name;



						



						$destination = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/thumbs'.'/'.$actual_image_name;



						$destination1 = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/medium'.'/'.$actual_image_name;



						$ext = substr(strrchr(Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages'.'/'.$actual_image_name,'.'),1);



						 



						FinaoController::generatethumb($source,$destination,90,90);



						FinaoController::generatethumb($source,$destination1,240,240);



						 



						



						}



//Run your SQL Query here to insert the new image file named $actual_image_name if you deem it necessary



					  echo '<div style="width:370px; padding:10px 20px; height:245px; text-align:center; border:5px solid #E2E2E2;  -moz-box-shadow: 0 0 5px #888; -webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888;"><span class="uploadeFileWrapper"><img id="filename" src="http://'.$_SERVER['HTTP_HOST'].'/images/uploads/finaoimages/'.$actual_image_name.'" width="360" height="235"></span>



					   </div>



					  ';



				  }



				  else 



				  {



					  echo "<div class='info' style='width:370px;'>Sorry, Your Image File could not be uploaded at the moment. <br>Please try again or contact the site admin if this problem persist. Thanks.</div>";



				  }



			 // }



			//  else 



			 // {



			//	  echo "<div class='info' style='width:345px;'>File exceeded 1MB max allowed file size. <br>Please upload a file at 1MB in size to proceed. Thanks.</div><br clear='all' />";



			//  }



		  }



	  }



	  else 



	  {



	  	 echo '<span class="uploadeFileWrapper"><img id="filename" src="http://'.$_SERVER['HTTP_HOST'].'/images/uploads/finaoimages/'.Yii::app()->session[filename].'" width="360" height="235"></span><br clear="all" />';



		 // echo "<div class='info' style='width:345px;'>You have just canceled your file upload process. Thanks.</div><br clear='all' />";



	  }



   }



}



	



	}



	



	// view finaos journal



	



	public function actionViewSingleFinao()



	{



		$this->renderpartial('_viewsinglefinao',array('finaoid'=>$_POST['finaoid'],'userid'=>$_POST['userid'],'share'=>$_POST['share']));				



	}



	



	// update image and video for journals



	



	public function actionUpdatedetails()



	{ //print_r($_POST);exit;



			$uploaddetail_id=$_POST['uploaddetail_id'];



			$userid=$_POST['userid'];

			

			// only caption edit

			$dates=date('Y-m-d H:i:s');



			$connection = yii::app()->db;

			if($_POST['type']=='video')
			$sql = "UPDATE  fn_uploaddetails SET video_caption='".$_POST['caption']."',updateddate='".$dates."'  WHERE uploaddetail_id=".$uploaddetail_id;
			else 
			$sql = "UPDATE  fn_uploaddetails SET caption='".$_POST['caption']."',updateddate='".$dates."'  WHERE uploaddetail_id=".$uploaddetail_id;
			$command=$connection->createCommand($sql);
			$command->execute();

			

			



			if(!empty($_FILES['journalimage']['name']))
			{



			$filename= '';



			$result = 'ERROR';



			$result_msg = '';



			$allowed_image = array ('image/gif', 'image/jpeg', 'image/jpg','image/png');



			define('PICTURE_SIZE_ALLOWED',10485760); // bytes 2242880



			if (isset($_FILES['journalimage']))  // file was send from browser



			{



			if ($_FILES['journalimage']['error'] == UPLOAD_ERR_OK)  // no error



			{



			if (in_array($_FILES['journalimage']['type'], $allowed_image)) {



			if(filesize($_FILES['journalimage']['tmp_name']) <= PICTURE_SIZE_ALLOWED) // bytes



			{



			$filename = $_POST['finaoid'].'-'.rand(125678,098754).'-'.$_FILES['journalimage']['name'];



			$source = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages'.'/'.$filename;



			move_uploaded_file($_FILES['journalimage']['tmp_name'], $source);



			if(file_exists($source))



			{



					$upload = new Uploaddetails;



					$destination = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/thumbs/'.$filename;



					$destination1 = Yii::getPathOfAlias('webroot').'/images/uploads/finaoimages/medium/'.$filename;



					$this->generatethumb($source,$destination,90,90);



					$this->generatethumb($source,$destination1,240,240);



					$dates=date('Y-m-d H:i:s');



					$connection = yii::app()->db;



					$sql = "UPDATE  fn_uploaddetails SET uploadfile_name='".$filename."',uploadfile_path='/images/uploads/finaoimages',updateddate='".$dates."'  WHERE uploaddetail_id=".$uploaddetail_id;



					$command=$connection->createCommand($sql);



					$command->execute();



					



					



			}



			//phpclamav clamscan for scanning viruses



			//passthru('clamscan -d /var/lib/clamav --no-summary '.$filename, $virus_msg); //scan virus



			$virus_msg = 'OK'; //assume clamav returing OK.



			if ($virus_msg != 'OK') {



			unlink($source);



			$result_msg = $filename." : ".FILE_VIRUS_AFFECTED;



			$result_msg = '<font color=red>'.$result_msg.'</font>';



			$filename = '';



			}else {



			// main action -- move uploaded file to $upload_dir



			$result = 'OK';



			}



			}else {



			$filesize = filesize($_FILES['file']['tmp_name']);// or $_FILES['file']['size']



			$filetype = $_FILES['file']['type'];



			$result_msg = PICTURE_SIZE;



			}



			}else {



			$result_msg = SELECT_IMAGE;



			}



			}



			elseif ($_FILES['file']['error'] == UPLOAD_ERR_INI_SIZE)



			$result_msg = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';



			else



			$result_msg = 'Unknown error';



			}



			}



			$finao = Uploaddetails::model()->findByPK($uploaddetail_id);
			$finaoid = $finao->upload_sourceid; 
			$finaos = new UserFinao;
			$finaos = UserFinao::model()->findByPk($finaoid);
			if(!empty($finaos))
			{
			$finaos->updateddate = new CDbExpression('NOW()');
			if($finaos->save(false))
			{
				//echo 'saved date';exit;
				
				$this->redirect(Yii::app()->createUrl('finao/motivationMesg',array('menutype'=>'finao'
																  ,'finaoid'=>$finaoid
																)));
			}
			
			
			/*$tileiddata = UserFinaoTile::model()->findByAttributes(array('finao_id'=>$finaoid,'userid'=>$userid,'status'=>1));
			$this->addTrackingNotifications($userid,$tileiddata['tile_id'],'Added Image To Journal',$finaoid,0);*/
			
			
			
			}



			



			



			







			



			 



			//$tempdocmodel=Uploaddetails::model()->updateByPk($Model->$_POST['journalid'],array("status"=>'ok'));    



		 // $filesmodel=UserFinaoJournal::model()->updateAll(array('user'=>"$userid",'date'=>$currenttime),"status=>'ok'");



		  



	 }



	 



	 public function actionBadWords()



	 {



	 



	 if($_POST['word'])



		{



		$tiles = FnProfanityWords::model()->findAll();



		foreach($tiles as $words)	



		{



			if( strtolower($_POST['word'])==strtolower($words->badword))



			{



				 echo 'yes';



			}



		}



	}



 



  }



 	 



	 



// delete journal



	public function actionDeletePosts()



	{



		$tileinfo = Uploaddetails::model()->findByAttributes(array('uploaddetail_id'=>$_POST['uploaddetail_id']));



		$tileinfo->delete(); 		



	} 	



	public function actionTextdetails()



	{ 



		$dates=date('Y-m-d H:i:s');



		$connection = yii::app()->db;



		// for bad wordwrap



		$words = str_word_count($_POST['text'], 1);



		$lastWord = array_pop($words);	



		$lastSpacePosition = strrpos($_POST['text'], ' ');



		



		$textWithoutLastWord=$_POST['text'];



			



		$tiles = FnProfanityWords::model()->findAll();



		foreach($tiles as $tiles)



		{



			if(strtolower($lastWord)==strtolower($tiles->badword))



			{



				$textWithoutLastWord = substr($_POST['text'], 0, $lastSpacePosition);



				$textWithoutLastWord.=' **** ';



			}



		}



		



		$sql = "UPDATE  fn_uploaddetails SET upload_text = '".$textWithoutLastWord."',updateddate='".$dates."',updateddate='".$dates."'  WHERE uploaddetail_id=".$_POST['uploadedid'];



		$command=$connection->createCommand($sql);



		$command->execute();



	} 	 



// delete journal based on type



	public function actionDeletebytype()



	{



		$info = Uploaddetails::model()->findByAttributes(array('uploaddetail_id'=>$_POST['uploadedid']));	



		if($_POST['type']=='image')



		{		



			if($_POST['source']== '62')



			{



				



				unlink(Yii::getPathOfAlias('webroot').$info['uploadfile_path'].'/'.$info['uploadfile_name']);



				unlink(Yii::getPathOfAlias('webroot').$info['uploadfile_path'].'/thumbs/'.$info['uploadfile_name']);



				//unlink($info['uploadfile_path'].'/thumbs/'.$info['uploadfile_name']);



				//unlink($info['uploadfile_path'].'/'.$info['uploadfile_name']);



				$connection = yii::app()->db;



				$sql = "UPDATE  fn_uploaddetails SET uploadfile_path = '',uploadfile_name='' WHERE uploaddetail_id=".$_POST['uploadedid'];



				$command=$connection->createCommand($sql);



				$command->execute();



			}



			else



			{



				$info->delete();



			}



		}



		else if($_POST['type']=='video')



		{



			if($_POST['source']== '62')



			{



				$connection = yii::app()->db;



				$sql = "UPDATE  fn_uploaddetails SET videoid = '',video_img='',video_embedurl=''  WHERE uploaddetail_id=".$_POST['uploadedid'];



				$command=$connection->createCommand($sql);



				$command->execute();



			}



			else



			{



				$info->delete();



			}



		}



	}	



	



	/*public function actionCheckVideoStatus()



	{



        $Criteria = new CDbCriteria();



		$Criteria->condition = "uploadedby = '".Yii::app()->session['login']['id']."'";



		$Criteria->addInCondition('uploadtype', array(35,62));



		$Criteria->order = "updateddate DESC";



		$finaos = Uploaddetails::model()->findAll($Criteria);



		



		foreach($finaos as $finaoids):        



		$ids[]=$finaoids->upload_sourceid;



		endforeach;



		 



		



		$vidler = Yii::app()->getComponents(false);



		$user = $vidler['vidler']['user'];



		$pass = $vidler['vidler']['pwd'];



		$api_key = $vidler['vidler']['appkey'];



		



		$v = new Viddler_V2($api_key);



		$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



		$sessionid = $auth['auth']['sessionid'];



		$this->updatefinaoviddlerstatus($sessionid,$ids,$v);



		 



		



	}*/



	public function actionCheckVideoStatus()



	{



		



		//print_r($_POST);



		



		/*SELECT * FROM `fn_uploaddetails` WHERE `upload_sourceid` = 1748 and `uploadedby` = 20 and `videoid` !='' and status = 1 and videostatus != 'ready'*/



		



        $ids = array();



		$Criteria = new CDbCriteria();



		$Criteria->condition = "`upload_sourceid` = ".$_POST['finaoid']." and `uploadedby` = ".$_POST['userid']." and `videoid` !='' and status = 1 and videostatus != 'ready'";



		$uploadids = Uploaddetails::model()->findAll($Criteria);



		



		foreach($uploadids as $finaoids):        



		$ids[]=$finaoids->uploaddetail_id.'-'.$finaoids->upload_sourceid;



		endforeach;



		



		



		



		foreach($ids as $updet)



		{



			//echo $updet;



			



			$datastring  = $updet;



			$item = explode(" ", $datastring);



			$item[0]; // uploadid



			$item[1]; // uploadsourceid or finaoid



			



			$updetupload = new Uploaddetails;



			$updetupload = Uploaddetails::model()->findByAttributes(array('uploaddetail_id'=>$item[0]));



			if(!empty($updetupload))



			{ 



			   if($updetupload->videostatus != 'ready')



			   {



				   //echo $updetupload->videostatus;



				   



				   



				   



					$vidler = Yii::app()->getComponents(false);



					$user = $vidler['vidler']['user'];



					$pass = $vidler['vidler']['pwd'];



					$api_key = $vidler['vidler']['appkey'];



					



					$v = new Viddler_V2($api_key);



					$auth = $v->viddler_users_auth(array('user' => $user, 'password' => $pass));



					$sessionid = $auth['auth']['sessionid'];



				   



				   $results=$v->viddler_videos_getDetails(array('sessionid' => $sessionid,'video_id'=>$updetupload->videoid));



				   



					$i =0;



					if($results['video']['status'] == 'ready')



					{ 



					   



					   //echo 'video'.$results['video']['status'];



					   $i++;



					   $updetupload->videostatus = $results['video']['status'];



					   if($updetupload->save(false))



					   {



						   echo 1;//succes



					   }



					   else



					   {



						   echo 0; //fail



					   }



					   



					   



					}



					 //echo $i.'updated';



				   



			   }



			



			



			



			}



			



		 }



		



		



		



	}



	



	public function actionEditImgVid()



	{



		if($_POST['uploadtype'] == 'Image' )



		{



		}



		else



		{



		}



		



		$this->renderPartial('_editfinaoimgvid');



	}



	



	



	



	 



}

 
?>