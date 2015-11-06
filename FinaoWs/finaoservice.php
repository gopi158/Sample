<?php
$contype="dev";
$globalpath="../../preprod/";
include_once("resizeclass.php");
include_once("connect.php");
include_once("errorconstants.php");
include_once("functions.php");
global $authuserid;

if(!empty($_SERVER['PHP_AUTH_USER'])){
	$username = $_SERVER['PHP_AUTH_USER'];	
	$password = $_SERVER['PHP_AUTH_PW'];
	echo $authuserid = validateLogin($username, $password);
	exit;
}else{
	if (!function_exists('http_response_code')){
		getStatusCode(401);
		exit;
	}
}

function generateResponse($issuccess, $message=NULL, $data=NULL){
	$json = array();
	$json['IsSuccess'] = $issuccess;
	
	if($message!=NULL)
		$json['message'] = $message;
	
	if($data!=NULL)
		$json['item'] = $data;
	
	return $json;
}

function validateLogin($username, $password){
	$password = md5($password);
	$query = mysql_query("select userid from fn_users where email='$username' and password='$password' and status=1");
	if(mysql_num_rows($query)>0){
		$obj = mysql_fetch_object($query);
		return $obj->userid;
	}else{
		$response = generateResponse(FALSE, INVALID_USERNAME_PWD);
		echo json_encode($response);
		getStatusCode(401);
	}
}

function getStatusCode($newcode = NULL)
{
	static $code = 200;
	if($newcode !== NULL)
	{
		header('X-PHP-Response-Code: '.$newcode, true, $newcode);
		if(!headers_sent())
			$code = $newcode;
	}       
	return $code;
}

$method = $_REQUEST['json'];
switch($method){
	case "finaorecentposts":
		finaorecentposts($authuserid);
		break;
		
	case "login":
		login();
		break;	
		
}

function finaorecentposts($uid){
	$data = array();
	$query = mysql_query("select user_finao_id from fn_user_finao where userid=$uid AND finao_activestatus=1 AND Iscompleted=0 order by user_finao_id DESC");
	if(mysql_num_rows($query)>0){
		$sno = 0;
		while($obj = mysql_fetch_object($query)){
			//echo "select uploaddetail_id, uploadtype, upload_text from fn_uploaddetails where upload_sourcetype=37 AND upload_sourceid=$obj->user_finao_id order by uploaddetail_id DESC";
			//echo "\n";
			$qry = mysql_fetch_object(mysql_query("select uploaddetail_id, uploadtype, upload_text from fn_uploaddetails where upload_sourcetype=37 AND upload_sourceid=$obj->user_finao_id order by uploaddetail_id DESC"));
			if($qry->uploadtype!=''){
				if($qry->uploadtype==62){
					$data[$sno]['message'] = $qry->upload_text;
					$data[$sno]['image_name'] = "";
					$data[$sno]['caption'] = "";
				}else if($qry->uploadtype==34){
					$imgdata = mysql_fetch_object(mysql_query("select uploadfile_name, caption from fn_images where upload_id=$qry->uploaddetail_id order by image_id DESC limit 1"));
					$data[$sno]['message'] = "";
					$data[$sno]['image_name'] = $imgdata->uploadfile_name;
					$data[$sno]['caption'] = $imgdata->caption;
				}else if($qry->uploadtype==35){
					$viddata = mysql_fetch_object(mysql_query("select uploadfile_name, caption from fn_videos where upload_id=$qry->uploaddetail_id order by image_id DESC"));
					$data[$sno]['message'] = "";
					$data[$sno]['image_name'] = $viddata->uploadfile_name;
					$data[$sno]['caption'] = $viddata->caption;
				}
				$data[$sno]['uploaddetail_id'] = $qry->uploaddetail_id;
				$sno++;
			}
		}
		$response = generateResponse(TRUE, NULL, $data);
		echo json_encode($response);
	}else{
		// show error
	}
}

function login(){
	echo "In login";
	exit;
}
exit;

if($_REQUEST['json']=='updateexplorefinao')
{
	 $tile_id=$_REQUEST['tile_id'];
     $sqlUpdate="update fn_user_finao_tile set explore_finao=1 where tile_id=".$tile_id;
     mysql_query($sqlUpdate);
}
if($_REQUEST['json']=='explorefinao')
{
	set_time_limit(0);
	$uploadnamearray=array();
include 'phpviddler.php';
$v            = new Viddler_V2('1mn4s66e3c44f11rx1xd');
$auth         = $v->viddler_users_auth(array('user'=>'nageshvenkata','password'=>'V1d30Pl@y3r'));
$session_id   = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;

 $json =array();
	//$sqlSelect="SELECT fup.user_id, fup.profile_image,uploadfile_name as tile_image,uploadfile_path,fu.uname, tile_id, tile_name, count( finao_id ) cnt_max FROM fn_user_finao_tile t JOIN fn_user_finao t1 JOIN fn_user_profile fup JOIN fn_uploaddetails fd JOIN fn_users fu ON fup.user_id = t1.userid AND fu.userid = t1.userid AND t.finao_id = t1.user_finao_id AND fd.upload_sourceid = t1.userid WHERE t.explore_finao =1 GROUP BY tile_id, tile_name ORDER BY cnt_max DESC";
$userid=$_REQUEST['userid'];
$sqlSelect="SELECT t. * ,usr.*, t1.finao_msg, fup.profile_image,fud.uploadfile_name, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id JOIN fn_user_profile fup ON fup.user_id = t2.userid JOIN fn_uploaddetails fud ON fud.`uploadedby`=t2.userid JOIN fn_users usr on usr.userid=fup.user_id WHERE t1.finao_status_Ispublic =1";
if($userid!="")
{
$sqlSelect.=" AND t.tracker_userid =".$userid;
}

$sqlSelect.="  AND t3.lookup_name!='Image' AND t3.lookup_name!='Video' AND t1.finao_activestatus =1 GROUP BY t.tile_id, t.finao_id,round( UNIX_TIMESTAMP( t.updateddate ) /600 ) DESC ORDER BY t.updateddate DESC limit 0,30";
 
       $sqlSelectRes=mysql_query($sqlSelect);
		if(mysql_num_rows($sqlSelectRes)>0)
		{
			while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
				{        
					$sqlSelectDet['password']="";					
					$uploadnamearray[]=$sqlSelectDet['uploadfile_name'];						
				//	$rows['all'][] = $sqlSelectDet;  
				
				}
		}
	//	$rows['all'] = "";  
//		$sqlSelectImage="select * from fn_uploaddetails t  join fn_user_finao t1 on t.upload_sourceid = t1.user_finao_id join fn_lookups t2 on t.upload_sourcetype = t2.lookup_id and t2.lookup_type = 'uploadsourcetype' and t2.lookup_name = 'finao' join fn_user_finao_tile t3 on t1.user_finao_id = t3.finao_id join fn_lookups t4 on t.uploadtype = t4.lookup_id and t4.lookup_type = 'uploadtype' and t4.lookup_name = 'Image' where t3.explore_finao = 1 order by t.uploadeddate desc ";

 $sqlSelectImage="SELECT t.*,fup.user_profile_id,fup.user_profile_msg,fup.user_location,fup.profile_image,fup.profile_bg_image,fup.profile_status_Ispublic,fup.mystory,fup.IsCompleted,fup.explore_finao,usr.userid,usr.uname,usr.email,usr.fname,usr.lname,fu.finao_msg FROM fn_uploaddetails t JOIN fn_lookups t1 JOIN fn_user_profile fup ON t.uploadtype = t1.lookup_id JOIN fn_users usr on usr.userid=fup.user_id LEFT JOIN fn_user_finao fu on fu.user_finao_id=t.upload_sourceid WHERE lookup_name = 'Image' AND t.explore_finao =1 AND fup.user_id = t.`uploadedby`  AND upload_sourcetype=37";

		$sqlSelectImageRes=mysql_query($sqlSelectImage);

		if(mysql_num_rows($sqlSelectImageRes)>0)
		{
			while($sqlSelectImageDet=mysql_fetch_assoc($sqlSelectImageRes))
				{        
					    /*****************Total Count*******************/
					 $totalfollowers=0;
				 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '".$sqlSelectImageDet['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
				 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
                 $totalfollowers=mysql_num_rows($sqlMyTrackingsRes);

                 $totaltiles=0;
				 $sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$sqlSelectImageDet['userid']."' AND Iscompleted =0 AND finao_activestatus !=2 AND finao_status_Ispublic =1 GROUP BY tile_id";
				 //
				 $sqlTilesCountRes=mysql_query($sqlTilesCount);
				 $totaltiles=mysql_num_rows($sqlTilesCountRes);
                 
				 $totalfinaos=0;
				 $sqlFianosCount="SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid ='".$sqlSelectImageDet['userid']."' AND f.finao_activestatus =1 AND Iscompleted =0 and finao_status_Ispublic = 1";
				 $sqlSelectCountRes=mysql_query($sqlFianosCount);
				 if(mysql_num_rows($sqlSelectCountRes)>0)
				 {
					while($sqlSelectCountDet=mysql_fetch_array($sqlSelectCountRes))
					 {
						$totalfinaos=$sqlSelectCountDet['totalfinaos'];
					 }
				 }
				  $totalfollowings=0;

				 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '".$sqlSelectImageDet['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
				 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
				 $totalfollowings=mysql_num_rows($sqlMyTrackingsRes);

				 if($totaltiles=="")
                    $totaltiles=0;
			     if($totalfinaos=="")
                    $totalfinaos=0;
				 if($totalfollowers=="")
                    $totalfollowers=0;
				 if($totalfollowings=="")
                    $totalfollowings=0;
				$sqlSelectImageDet['totalfinaos']=$totalfinaos;
				$sqlSelectImageDet['totaltiles']=$totaltiles;
				$sqlSelectImageDet['totalfollowers']=$totalfollowers;
				$sqlSelectImageDet['totalfollowings']=$totalfollowings;
                
					$sqlSelectImageDet['password']="";
					if($sqlSelectImageDet['upload_sourcetype']==37)
                    $sqlSelectImageDet['finao_id']=$sqlSelectImageDet['upload_sourceid'];
					if (!in_array($sqlSelectImageDet['uploadfile_name'], $uploadnamearray)) {
					$rows['image'][] = $sqlSelectImageDet;  
				}
					
				}
		}

//$sqlSelectVideo="select * from fn_uploaddetails t  join fn_user_finao t1 on t.upload_sourceid = t1.user_finao_id join fn_lookups t2 on t.upload_sourcetype = t2.lookup_id and t2.lookup_type = 'uploadsourcetype' and t2.lookup_name = 'finao' join fn_user_finao_tile t3 on t1.user_finao_id = t3.finao_id join fn_lookups t4 on t.uploadtype = t4.lookup_id and t4.lookup_type = 'uploadtype' and t4.lookup_name = 'Video' where t3.explore_finao = 1 order by t.uploadeddate desc";
 $sqlSelectVideo="SELECT t.*,fup.user_profile_id,fup.user_profile_msg,fup.user_location,fup.profile_image,fup.profile_bg_image,fup.profile_status_Ispublic,fup.mystory,fup.IsCompleted,fup.explore_finao,usr.userid,usr.uname,usr.email,usr.fname,usr.lname,fu.finao_msg FROM fn_uploaddetails t JOIN fn_lookups t1 JOIN fn_user_profile fup ON t.uploadtype = t1.lookup_id JOIN fn_users usr on usr.userid=fup.user_id LEFT JOIN fn_user_finao fu on fu.user_finao_id=t.upload_sourceid WHERE lookup_name = 'Video' AND t.explore_finao =1 AND fup.user_id = t.`uploadedby` AND upload_sourcetype=37";

		$sqlSelectVideoRes=mysql_query($sqlSelectVideo);
		if(mysql_num_rows($sqlSelectVideoRes)>0)
		{
			while($sqlSelectVideoDet=mysql_fetch_assoc($sqlSelectVideoRes))
				{       
				        /*****************Total Count*******************/
					 $totalfollowers=0;
				 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '".$sqlSelectVideoDet['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
				 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
                 $totalfollowers=mysql_num_rows($sqlMyTrackingsRes);

                 $totaltiles=0;
				 $sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$sqlSelectVideoDet['userid']."' AND Iscompleted =0 AND finao_activestatus !=2 AND finao_status_Ispublic =1 GROUP BY tile_id";
				 $sqlTilesCountRes=mysql_query($sqlTilesCount);
				 $totaltiles=mysql_num_rows($sqlTilesCountRes);
                 
				 $totalfinaos=0;
				 $sqlFianosCount="SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid ='".$sqlSelectVideoDet['userid']."' AND f.finao_activestatus =1 AND Iscompleted =0 and finao_status_Ispublic = 1";
				 $sqlSelectCountRes=mysql_query($sqlFianosCount);
				 if(mysql_num_rows($sqlSelectCountRes)>0)
				 {
					while($sqlSelectCountDet=mysql_fetch_array($sqlSelectCountRes))
					 {
						$totalfinaos=$sqlSelectCountDet['totalfinaos'];
					 }
				 }
				  $totalfollowings=0;

				 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '".$sqlSelectVideoDet['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
				 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
				 $totalfollowings=mysql_num_rows($sqlMyTrackingsRes);

				 if($totaltiles=="")
                    $totaltiles=0;
			     if($totalfinaos=="")
                    $totalfinaos=0;
				 if($totalfollowers=="")
                    $totalfollowers=0;
				 if($totalfollowings=="")
                    $totalfollowings=0;
				$sqlSelectVideoDet['totalfinaos']=$totalfinaos;
				$sqlSelectVideoDet['totaltiles']=$totaltiles;
				$sqlSelectVideoDet['totalfollowers']=$totalfollowers;
				$sqlSelectVideoDet['totalfollowings']=$totalfollowings;
                
					/************************************/
					if($sqlSelectVideoDet['upload_sourcetype']==37)
                    $sqlSelectVideoDet['finao_id']=$sqlSelectVideoDet['upload_sourceid'];
					$sqlSelectVideoDet['password']="";
				if(!empty($sqlSelectVideoDet['videoid']))
					{
						$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=".$session_id."&key=1mn4s66e3c44f11rx1xd&video_id=".$sqlSelectVideoDet['videoid']);

						$video=json_decode($videosource,true);
						$sqlSelectVideoDet['videofrom']="";
						foreach($video['video']['files'] as $k=>$v)
                                                {  
                                                   if($v['html5_video_source']!="")
                      	                           $sqlSelectVideoDet['videosource']=$v['html5_video_source'];
                                                }		
                        $rows['video'][] = (unstrip_array($sqlSelectVideoDet));
					}
					else
					{					         
 					  $str=str_replace("/default.jpg","",$sqlSelectVideoDet['video_img']);
 					  $str=str_replace("http://img.youtube.com/vi/","",$str);
					  $sqlSelectVideoDet['video_embedurl']="";
					  $sqlSelectVideoDet['videofrom']="youtube";		
					  $sqlSelectVideoDet['videosource']="http://www.youtube.com/embed/".$str;
					  $rows['video'][] = (unstrip_array($sqlSelectVideoDet));
					}					
					//$rows['video'][] = $sqlSelectVideoDet;  
					
				}
		}

		$json = array();
		$json['res'] = $rows;
		
		echo json_encode($json);
}
elseif($_REQUEST['json']=='finao_details')
{
	include 'phpviddler.php';
	$v            = new Viddler_V2('1mn4s66e3c44f11rx1xd');
	$auth         = $v->viddler_users_auth(array('user'=>'nageshvenkata','password'=>'V1d30Pl@y3r'));
	$session_id   = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;
    $json =array();	
   
    $userid=$_REQUEST['userid'];
    $finaoid=$_REQUEST['finaoid'];
	echo $sqlSelect="SELECT * FROM ( (SELECT fu. * , t.finao_msg AS message FROM fn_uploaddetails fu LEFT JOIN fn_user_finao t ON fu.upload_sourceid = t.user_finao_id WHERE fu.updatedby =".$userid." AND upload_sourcetype =37 AND t.user_finao_id =".$finaoid." ORDER BY fu.`uploaddetail_id` DESC ) )a ORDER BY a.updateddate DESC";
	exit;
	$sqlSelectRes=mysql_query($sqlSelect);
		if(mysql_num_rows($sqlSelectRes)>0)
		{
			while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
				{       $videosource=""; 
					$id=$sqlSelectDet['upload_sourceid'];
					$upload_sourcetype=$sqlSelectDet['upload_sourcetype'];
					$uploadtype=$sqlSelectDet['uploadtype'];
					$temp=array();
					if($sqlSelectDet['uploadtype']=='34' && $sqlSelectDet['upload_sourcetype']==37)
					{
									$sqlSelectDet['imagename']=$sqlSelectDet['uploadfile_name'];
									$sqlSelectDet['imagepath']=$sqlSelectDet['uploadfile_path'];
									$sqlSelectDet['type']='finaoimage';
					}
                                        else if($sqlSelectDet['uploadtype']=='62' && $sqlSelectDet['upload_sourcetype']==37)
					{
									if($sqlSelectDet['uploadfile_name']!="")
									{
										$sqlSelectDet['imagename']=$sqlSelectDet['uploadfile_name'];
										$sqlSelectDet['imagepath']=$sqlSelectDet['uploadfile_path'];
										$sqlSelectDet['type']='finaoimage';
									}
									else if($sqlSelectDet['videoid']!="")
									{
										$uploadfile_name=$sqlSelectDet['uploadfile_name'];
									$videoid=$sqlSelectDet['videoid'];
									$videostatus=$sqlSelectDet['videostatus'];
									$video_img=$sqlSelectDet['video_img'];                                                                        
									$sqlSelectDet['type']='finaovideo';
									if(!empty($videoid))
									{
									$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=".$session_id."&key=1mn4s66e3c44f11rx1xd&video_id=".$videoid);
									$video=json_decode($videosource,true);
									$videofrom="";
									foreach($video['video']['files'] as $k=>$v)
									{  

								//		$v=unstrip_array($v);
									   if($v['html5_video_source']!="")
										$videosource=stripslashes($v['html5_video_source']);
									}

									}
									else
									{
                                      if($video_img!="")
                                      {					         
				 					  $str=str_replace("/default.jpg","",$video_img);
									  $str=str_replace("/mqdefault.jpg","",$str);
									  $str=str_replace("http://img.youtube.com/vi/","",$str);
									  $video_embedurl="";
									  $sqlSelectDet['video_embedurl']="";
									  $videofrom="youtube";		
									  if($str!="")
									  $str="http://www.youtube.com/embed/".$str;
                                      }
									  $videosource=stripslashes($str);
									}					
									}
									else
									{
										$str="";
						 	            $str=" and upload_sourceid='".$finaoid."'";
										$sqlSelectUploadLatest="select * from fn_uploaddetails where (uploadtype='34' or uploadtype='35') and Lower(upload_sourcetype)='37' ".$str." order by uploaddetail_id desc limit 0,1 ";
										$sqlSelectUploadLatestRes=mysql_query($sqlSelectUploadLatest);
										if(mysql_num_rows($sqlSelectUploadLatestRes)>0)
										{		
										 while($sqlSelectUploadLatestRes=mysql_fetch_assoc($sqlSelectUploadLatestRes))
										 {        
												$sqlSelectDet['imagename'] = "".$sqlSelectUploadLatestRes['uploadfile_name'];
												$sqlSelectDet['uploadfile_name'] = "".$sqlSelectUploadLatestRes['uploadfile_name'];
												$sqlSelectDet['imagepath'] = $sqlSelectUploadLatestRes['uploadfile_path'];
										 }
										}

										$sqlSelectDet['type']='finaotext';
									}
					}
					else if($sqlSelectDet['uploadtype']=='35'  && $sqlSelectDet['upload_sourcetype']==37)
					{						
									$uploadfile_name=$sqlSelectDet['uploadfile_name'];
									$videoid=$sqlSelectDet['videoid'];
									$videostatus=$sqlSelectDet['videostatus'];
									$video_img=$sqlSelectDet['video_img'];                                                                        
									$sqlSelectDet['type']='finaovideo';
									if(!empty($videoid))
									{
									$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=".$session_id."&key=1mn4s66e3c44f11rx1xd&video_id=".$videoid);
									$video=json_decode($videosource,true);
									$videofrom="";
									foreach($video['video']['files'] as $k=>$v)
									{  

								//		$v=unstrip_array($v);
									   if($v['html5_video_source']!="")
										$videosource=stripslashes($v['html5_video_source']);
									}

									}
									else
									{
                                      if($video_img!="")
                                      {					         
				 					  $str=str_replace("/default.jpg","",$video_img);
									    $str=str_replace("/mqdefault.jpg","",$str);
									  $str=str_replace("http://img.youtube.com/vi/","",$str);
									  $video_embedurl="";
									  $sqlSelectDet['video_embedurl']="";
									  $videofrom="youtube";		
									  if($str!="")
									  $str="http://www.youtube.com/embed/".$str;
                                      }
									  $videosource=stripslashes($str);
									}					

					}					
					else if($sqlSelectDet['uploadtype']=='34'  && $sqlSelectDet['upload_sourcetype']==46)
						{
									$sqlSelectDet['imagename']=$sqlSelectDet['uploadfile_name'];
									$sqlSelectDet['imagepath']=$sqlSelectDet['uploadfile_path'];
									$sqlSelectDet['type']='journalimage';										
						}
					else if($sqlSelectDet['uploadtype']=='35'  && $sqlSelectDet['upload_sourcetype']==46)
						{						
									$uploadfile_name=$sqlSelectDet['uploadfile_name'];
									$videoid=$sqlSelectDet['videoid'];
									$videostatus=$sqlSelectDet['videostatus'];
									$video_img=$sqlSelectDet['video_img'];
          					        $sqlSelectDet['type']='journalvideo';
									if(!empty($videoid))
									{
									$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=".$session_id."&key=1mn4s66e3c44f11rx1xd&video_id=".$videoid);
									$video=json_decode($videosource,true);
									$videofrom="";
									foreach($video['video']['files'] as $k=>$v)
									{  
										//$v=unstrip_array($v);
									   if($v['html5_video_source']!="")
										$videosource=stripslashes($v['html5_video_source']);
									}

									}
									else
									{
					                                  if($video_img!="")
                                                                          {
				 					  $str=str_replace("/default.jpg","",$video_img);
									  $str=str_replace("http://img.youtube.com/vi/","",$str);
									  $video_embedurl="";
                                                                          $sqlSelectDet['video_embedurl']="";
									  $videofrom="youtube";		
									  if($str!="")
									  $str="http://www.youtube.com/embed/".$str;
                                                                          }
									  $videosource=stripslashes($str);
									}					
						}
				
					$sqlSelectDet['videofrom']=$videofrom;
					$sqlSelectDet['videosource']=stripslashes($videosource);
				 	$sqlSelectDet['tile_name']=$tile_name;

 				        $rows[] = (unstrip_array($sqlSelectDet));

					$json = array();
					$json["res"] = $rows;
		}

}else
			{
			        $json = array();
					$json["res"] ="";
			}
			
			echo "<pre>";
			print_r($json);
			exit;
echo json_encode($json);
}
else if($_REQUEST['json']=='List')
{
 $json =array();
	$sqlSelect="select * from fn_lookups where lookup_type='tiles' and lookup_status=1";
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{
		
      while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
		 {
        
				$rows[] = $sqlSelectDet;         
		 }
		 	$json = array();
 	$json['res'] = $rows;
	}
	else
	{
	   $json['res']="";
	}
        
 	echo json_encode($json);
}
else if($_REQUEST['json']=='searchtiles')
{
	$json =array();
	$search=$_REQUEST['search'];
//		$sqlSelect="SELECT t.tile_id,t.userid,t.tile_name,t1.finao_activestatus,t1.finao_msg,t.tile_profileImagurl,t1.* FROM fn_user_finao_tile t JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id AND t1.finao_status_Ispublic =1 AND t.status =1 AND t1.finao_activestatus !=2 AND t.tile_name LIKE '%".$search."%' GROUP BY t.tile_name, t.userid";

$sqlSelect="SELECT t.tile_id, t.userid, fo.tilename, t.`finao_id` , t1.finao_activestatus, fo.status, t1.finao_msg, t.tile_profileImagurl, t1. * FROM fn_user_finao_tile t JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_tilesinfo fo ON fo.tile_id = t.tile_id AND t1.finao_status_Ispublic =1 AND t.status =1 AND t1.finao_activestatus !=2 AND fo.tilename LIKE '%".$search."%' GROUP BY fo.tilename, t.userid";
		$sqlSelectRes=mysql_query($sqlSelect);
		if(mysql_num_rows($sqlSelectRes)>0)
		{
			while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
				{            
					$sqlSelectProfile="SELECT `fname` , `lname` , fu.profile_image FROM fn_users u LEFT JOIN fn_user_profile fu ON fu.user_id = u.userid WHERE fu.user_id ='".$sqlSelectDet['userid']."'";
				    $sqlSelectProfileRes=mysql_query($sqlSelectProfile);
					 if(mysql_num_rows($sqlSelectProfileRes))
					 {
						while($sqlSelectProfileDet=mysql_fetch_array($sqlSelectProfileRes))
						 {
							$profile_image=$sqlSelectProfileDet['profile_image'];
                                                        $fname=$sqlSelectProfileDet['fname'];
							$lname=$sqlSelectProfileDet['lname'];
						 }
					 }
					 $sqlSelectDet['profile_image']=$profile_image;
                                         $sqlSelectDet['fname']=$fname;
                                         $sqlSelectDet['lname']=$lname;   
					  $rows[] = $sqlSelectDet;
				}
		}
		else
		{
		   $json['res']="";
		}
		$json['res'] = $rows;   
 		echo json_encode($json);
}
elseif($_REQUEST['json']=='SendInvites')
{
 $json =array();
require_once('class.phpmailer.php');
$to=$_REQUEST['to'];
$subject='Welcome to Finaonation';
$message="Hi, Welcome to finaonation.com";
$headers = 'From: admin@finaoation.com' . "\r\n" .
'Reply-To: admin@finaoation.org' . "\r\n" .
'X-Mailer: PHP/' . phpversion();   
$headers .= 'Cc: '.$cc . "\r\n";
$headers .= 'Bcc: '.$bcc . "\r\n";
$headers .= "Reply-To: Finaonation <admin@finaonation.com>\r\n"; 
$headers .= "Return-Path:finaonation <admin@finaonation.com>\r\n"; 
$headers .= "From: finaonation <admin@finaonation.com>\r\n"; 
$headers .= "Organization: finaonation\r\n"; 
$headers .= "Content-Type: text/plain\r\n"; 
$headers .= 'X-Mailer: PHP/' . phpversion();
$to = strtolower(trim($to));
//$headers .= 'Cc: '.$cc . "\r\n";
//$headers .= 'Bcc: '.$bcc . "\r\n";
$message =trim($message);   
$subject=trim($subject);     
$list=explode(",",$to);
if(count($list)>0)
	{
foreach($list as $k=>$v)
	{
			$mail             = new PHPMailer(); // defaults to using php "mail()"
			$body             = $message;
			$body             = eregi_replace("[\]",'',$body);
			$mail->AddReplyTo("admin@finaonation.com","Administrator");
			$mail->SetFrom('admin@finaonation.com', 'Administrator');
			$mail->AddReplyTo("admin@finaonation.com","Administrator");
			$mail->AddAddress($v, $name);
			$mail->Subject    = $subject;
			//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->MsgHTML($body);
			$json = array();
			if(!$mail->Send()) {
			$json['res']="Mail Failed";

			} else {
			$json['res']="Mail Sent Successfully";
			}
	}
	}
echo json_encode($json);
	

}
elseif($_REQUEST['json']=='homelist')
{
include 'phpviddler.php';
$v            = new Viddler_V2('1mn4s66e3c44f11rx1xd');
$auth         = $v->viddler_users_auth(array('user'=>'nageshvenkata','password'=>'V1d30Pl@y3r'));
$session_id   = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;

 $json =array();
 $json['home']="";
	$sqlSelect="SELECT fu.updateddate, fu.uploadfile_name, uname, lookup_name, upload_sourceid FROM fn_uploaddetails fu JOIN fn_users fur RIGHT JOIN fn_lookups fl ON fu.updatedby = fur.userid AND fu.upload_sourcetype = fl.lookup_id WHERE (lookup_name = 'tile' OR lookup_name = 'finao' OR lookup_name = 'journal' )ORDER BY fu.updateddate DESC LIMIT 0,30";
$userid=$_REQUEST['userid'];
$sqlSelect="SELECT t.*, t1 . *, t6.profile_image,t6.mystory, t4.lookup_name as finaostatus, t1.updateddate as finaoupdateddate,DATE_FORMAT(t1.updateddate,'%d %b %y') as fupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name FROM `fn_trackingnotifications` `t` Join fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 JOIN fn_user_profile t6 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id WHERE t.tracker_userid = ".$userid." AND t6.`user_id` = t2.userid
 and t1.finao_status_Ispublic = 1 and t1.finao_activestatus = 1 GROUP BY t.tile_id, t.finao_id ,round(UNIX_TIMESTAMP(t.updateddate) / 600) desc ORDER BY t.updateddate desc";
	$sqlSelectRes=mysql_query($sqlSelect);
		if(mysql_num_rows($sqlSelectRes)>0)
		{
			while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
				{        
					$id=$sqlSelectDet['upload_sourceid'];
					$tile_name=$sqlSelectDet['tile_name'];
					$lookup_name=$sqlSelectDet['lookup_name'];
					if($lookup_name=='finao')
					{
						$sqlgetFiano="select tile_id,tile_name from fn_user_finao_tile where finao_id=".$id;					

						$sqlgetFianoRes=mysql_query($sqlgetFiano);						
						if(mysql_num_rows($sqlgetFianoRes)>0)
						{		
							while($sqlgetFianoDet=mysql_fetch_assoc($sqlgetFianoRes))
								{
   									$tile_name=$sqlgetFianoDet['tile_name'];
								}
						}

					}
					else if($lookup_name=='journal')
					{
						$sqlgetJournalInfo="select finao_id from fn_user_finao_journal where finao_journal_id=".$id;
						$sqlgetJournalInfoRes=mysql_query($sqlgetJournalInfo);						
						if(mysql_num_rows($sqlgetJournalInfoRes)>0)
						{		
							while($sqlgetJournalInfoDet=mysql_fetch_assoc($sqlgetJournalInfoRes))
								{									
									$sqlgetFiano="select tile_id,tile_name from fn_user_finao_tile where finao_id=".$sqlgetJournalInfoDet['finao_id'];
									$sqlgetFianoRes=mysql_query($sqlgetFiano);						
									if(mysql_num_rows($sqlgetFianoRes)>0)
									{		
										while($sqlgetFianoDet=mysql_fetch_assoc($sqlgetFianoRes))
											{
												$tile_name=$sqlgetFianoDet['tile_name'];
											}
									}
								}

						}
					}
					
					else if($sqlSelectDet['finao_id']!="")
					{
						
						$sqlgetFiano2="SELECT uploadfile_name, videoid, videostatus, video_img, video_embedurl FROM fn_user_finao f JOIN fn_uploaddetails fu ON f.user_finao_id = fu.upload_sourceid WHERE user_finao_id =".$sqlSelectDet['finao_id'];
						$uploadfile_name="";
						$videoid="";
						$videostatus="";
						$video_img="";
						$sqlgetFianoRes2=mysql_query($sqlgetFiano2);						
						if(mysql_num_rows($sqlgetFianoRes2)>0)
						{		
							while($sqlgetFianoDet2=mysql_fetch_assoc($sqlgetFianoRes2))
								{
									$uploadfile_name=$sqlgetFianoDet2['uploadfile_name'];
									$videoid=$sqlgetFianoDet2['videoid'];
									$videostatus=$sqlgetFianoDet2['videostatus'];
									$video_img=$sqlgetFianoDet2['video_img'];

									if(!empty($videoid))
									{
									$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=".$session_id."&key=1mn4s66e3c44f11rx1xd&video_id=".$videoid);
									

									$video=json_decode($videosource,true);


									$videofrom="";
						                        foreach($video['video']['files'] as $k=>$v)
                                                                        {  
																			$v=unstrip_array($v);
                                                                           if($v['html5_video_source']!="")
                      	                                                    $videosource=stripslashes($v['html5_video_source']);
																		}

									}
									else
									{					         
				 					  $str=str_replace("/default.jpg","",$video_img);
									  $str=str_replace("http://img.youtube.com/vi/","",$str);
									  $video_embedurl="";
									  $videofrom="youtube";		
									  if($str!="")
									  $str="http://www.youtube.com/embed/".$str;
									  $videosource=$str;
									}					
									
								}
						}
					}
					$sqlSelectDet['videofrom']=$videofrom;
					$sqlSelectDet['uploadfile_name']=$uploadfile_name;					
					$sqlSelectDet['videosource']=stripslashes($videosource);
					$sqlSelectDet['tile_name']=$tile_name;
					
					$totalfollowers=0;
					
					 $totalfollowers=fngetTotalFollowers($sqlSelectDet['userid']);
					 
					 $totaltiles=0;
//					 $totaltiles=fngetTotalTiles($sqlSelectDet['userid'],"");
					 $totaltiles=0;
					 $sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =".$sqlSelectDet['userid']." AND finao_activestatus !=2 ";		
					 $sqlTilesCount.=" and `finao_status_Ispublic` =1";	
					 $sqlTilesCount.=" GROUP BY tile_id ";
					 $sqlTilesCountRes=mysql_query($sqlTilesCount);
	                 $totaltiles=mysql_num_rows($sqlTilesCountRes);    
					 $totalfinaos=0;
					 //$totalfinaos=fngetTotalFinaos($sqlSelectDet['userid'],"");
					 $sqlFianosCount="";	
					 $sqlFianosCount="SELECT user_tileid FROM  fn_user_finao_tile ft JOIN fn_user_finao f WHERE ft.finao_id = f.user_finao_id AND ft.userid =  '".$sqlSelectDet['userid']."' AND f.finao_activestatus =1 AND finao_status_Ispublic =1";
					//echo $sqlFianosCount;


					$sqlSelectFinaoCountRes=mysql_query($sqlFianosCount);

					$totalfinaos=mysql_num_rows($sqlSelectFinaoCountRes);

					 $totalfollowings=0;
					 $totalfollowings=fngetTotalFollowings($sqlSelectDet['userid']);

					 if($totaltiles=="")
						$totaltiles=0;
					 if($totalfinaos=="")
						$totalfinaos=0;
					 if($totalfollowers=="")
						$totalfollowers=0;
					 if($totalfollowings=="")
						$totalfollowings=0;
					$sqlSelectDet['totalfinaos']=$totalfinaos;
					$sqlSelectDet['totaltiles']=$totaltiles;
					$sqlSelectDet['totalfollowers']=$totalfollowers;
					$sqlSelectDet['totalfollowings']=$totalfollowings;
					$rows[] = $sqlSelectDet;  
					
					$json['home'] = $rows;
		}

}
echo "<pre>";
print_r($json);
exit;

echo json_encode($json);
}
else if($_REQUEST['json']=='changepassword')
{
         $json = array();
	$user_id=$_REQUEST['user_id'];
	$oldpassword=$_REQUEST['oldpassword'];
	$newpassword=$_REQUEST['newpassword'];
	$confirmpassword=$_REQUEST['confirmpassword'];
	$sqlSelect="select userid,mageid from fn_users where userid='".mysql_real_escape_string($user_id)."' and password='".mysql_real_escape_string(md5($oldpassword))."'";
//echo $sqlSelect;
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{
		$sqlSelectDet=mysql_fetch_array($sqlSelectRes);
		if($newpassword==$confirmpassword)
		{
			$sqlquery="update fn_users set password='".mysql_real_escape_string($newpassword)."' where email='".mysql_real_escape_string($email)."'";
			mysql_query($sqlquery);
			
		    
	        $proxy = new SoapClient($soap_url); // TODO : change url
			$sessionId = $proxy->login($soapusername, $soappassword);				
			$result = $client->call($sessionId, 'customer.update', array('customerId' => $sqlSelectDet['mageid'], 'customerData' => array('password' => $newpassword)));

			$json['res']="Password Updated Successfully";
		}
		else
		{
			$json['res']="Confirmation Password Failed";
		}
	}
	else
	{
		   $json['res']="User password does not match";
	}
	echo json_encode($json);
}
else if($_REQUEST['json']=='user_details')
{
    $json =array();
	$userid=$_GET['user_id'];
	$sqlSelect="select * from fn_users where status=1 and userid = '".$userid."'";
	$sqlSelectRes=mysql_query($sqlSelect);
	$count=mysql_num_rows($sqlSelectRes);
	if($count>0)
	{		
			while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
				{            
					$sqlSelectProfile="select profile_image,mystory from fn_user_profile where user_id='".$sqlSelectDet['userid']."'";
				    $sqlSelectProfileRes=mysql_query($sqlSelectProfile);
					 if(mysql_num_rows($sqlSelectProfileRes)>0)
					 {
						while($sqlSelectProfileDet=mysql_fetch_array($sqlSelectProfileRes))
						 {
							$profile_image=$sqlSelectProfileDet['profile_image'];
                            $mystory=$sqlSelectProfileDet['mystory'];
						 }
					 }             
					 $totalfollowers=0;
					 $totalfollowers=fngetTotalFollowers($sqlSelectDet['userid']);
					 $totaltiles=0;
					 $totaltiles=fngetTotalTiles($sqlSelectDet['userid'],"");
					 $totalfinaos=0;
					 $totalfinaos=fngetTotalFinaos($sqlSelectDet['userid'],"");
					 $totalfollowings=0;
					 $totalfollowings=fngetTotalFollowings($sqlSelectDet['userid']);

					 if($totaltiles=="")
						$totaltiles=0;
					 if($totalfinaos=="")
						$totalfinaos=0;
					 if($totalfollowers=="")
						$totalfollowers=0;
					 if($totalfollowings=="")
						$totalfollowings=0;
					$sqlSelectDet['totalfinaos']=$totalfinaos;
					$sqlSelectDet['totaltiles']=$totaltiles;
					$sqlSelectDet['totalfollowers']=$totalfollowers;
					$sqlSelectDet['totalfollowings']=$totalfollowings;
					$sqlSelectDet['profile_image']=$profile_image;
					$sqlSelectDet['mystory']=$mystory;  
					$rows[] = $sqlSelectDet;
				}		
				$json = array();
                //$rows['totalrows']=mysql_num_rows($sqlSelectRes);
				$json['res'] = $rows;
		}
		else
		{
		   $json['res']="";
		}
	
 	echo json_encode($json);
}
else if($_REQUEST['json']=='searchusers')
{
    $json =array();
	$tile_name=strtolower(trim($_REQUEST['tile_name']));
	$username=strtolower(trim($_REQUEST['username']));	
	if($username!="")
	$sqlSelect="select * from fn_users where status=1 and email like '%".$username."%' or fname like '%".$username."%' or lname like '%".$username."%' or uname like '%".$username."%'";
	$userarr=explode(" ",$username);
	if(count($userarr))
	{
		$sqlSelect.=" OR concat(fname,' ',lname) like '%".$username."%'";	
	}

	
	$sqlSelectRes=mysql_query($sqlSelect);
	$count1=mysql_num_rows($sqlSelectRes);
	if($tile_name=="")	
	$tile_name=$username;	
//	$sqlSelect1="SELECT t.userid, t . * , t1.user_location, t1.profile_image, t2 . * FROM fn_users t JOIN fn_user_profile t1 ON t.userid = t1.user_id JOIN ( SELECT t . * , t2.tilename, t3.lookup_name FROM fn_user_finao t JOIN fn_user_finao_tile t1 ON t.user_finao_id = t1.finao_id AND t.userid = t1.userid JOIN fn_tilesinfo t2 ON t1.tile_id = t2.tile_id AND t1.userid = t2.createdby JOIN fn_lookups t3 ON t.finao_status = t3.lookup_id WHERE t2.tilename LIKE '%".$tile_name."%' AND t.finao_activestatus =1 AND t.finao_status_Ispublic =1 GROUP BY t.userid, t1.tile_id ORDER BY t.updateddate DESC )t2 ON t.userid = t2.userid where t.status=1 GROUP BY t.fname, t.lname ORDER BY t.fname, t.lname ";
$sqlSelect1="SELECT t.userid as user_id,t.userid as uid,t. * , t1.user_location, t1.profile_image, t2. * FROM fn_users t LEFT JOIN fn_user_profile t1 ON t.userid = t1.user_id LEFT JOIN ( SELECT t.userid,t.user_finao_id,t.finao_msg,t.finao_status_Ispublic,t.finao_activestatus,t.createddate,t.updatedby,t.updateddate,t.finao_status,t.Iscompleted,t.Isdefault , t2.tilename, t3.lookup_name FROM fn_user_finao t JOIN fn_user_finao_tile t1 ON t.user_finao_id = t1.finao_id AND t.userid = t1.userid JOIN fn_tilesinfo t2 ON t1.tile_id = t2.tile_id AND t1.userid = t2.createdby JOIN fn_lookups t3 ON t.finao_status = t3.lookup_id AND t.finao_activestatus =1 AND t.finao_status_Ispublic =1 GROUP BY t.userid, t1.tile_id ORDER BY t.updateddate DESC )t2 ON t.userid = t2.userid WHERE t.status =1 AND ( t2.tilename LIKE  '%".$tile_name."%' OR t.email LIKE  '%".$username."%' OR t.fname LIKE  '%".$username."%' OR t.lname LIKE  '%".$username."%' OR t.uname LIKE  '%".$username."%'";

if(count($userarr))
	{
		$sqlSelect1.=" OR concat(fname,' ',lname) like '%".$username."%'";	
	}

$sqlSelect1.=" ) GROUP BY uid ORDER BY t.fname, t.lname";
//OR CONCAT( t.fname,  ' ', t.lname ) LIKE  '%".$username."%') 
//echo $sqlSelect1;

	$sqlSelectRes1=mysql_query($sqlSelect1);
	$count2=mysql_num_rows($sqlSelectRes1);
	if($count1>0 || $count2>0)
		{		
			if($count1>0 && $count2>0)
			$sqlSelectRes=$sqlSelectRes1;
			if($count1<=0 && $count2>0)
			$sqlSelectRes=$sqlSelectRes1;
			while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
				{ 
				    if($sqlSelectDet["userid"]=="")
					$sqlSelectDet["userid"]=$sqlSelectDet['user_id'];
 				    $profile_image="";
                    $mystory="";
					$sqlSelectProfile="select profile_image,mystory from fn_user_profile where user_id='".$sqlSelectDet['uid']."'";
					//echo $sqlSelectProfile;
				    $sqlSelectProfileRes=mysql_query($sqlSelectProfile);
					 if(mysql_num_rows($sqlSelectProfileRes)>0)
					 {
						while($sqlSelectProfileDet=mysql_fetch_array($sqlSelectProfileRes))
						 {
							$profile_image=$sqlSelectProfileDet['profile_image'];
                                                        $mystory=$sqlSelectProfileDet['mystory'];

						 }
					 }            
 					 $totalfollowers=0;
					 $totalfollowers=fngetTotalFollowers($sqlSelectDet['userid']);
					 $totaltiles=0;
					// $totaltiles=fngetTotalTiles($sqlSelectDet['userid'],"search");

					 $SqlSelectTilesCount="SELECT user_tileid FROM  `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =  '".$sqlSelectDet['userid']."' AND finao_activestatus !=2 AND  `finao_status_Ispublic` =1 GROUP BY tile_id";
					 $SqlSelectTilesCountRes=mysql_query($SqlSelectTilesCount);
					 $totaltiles=mysql_num_rows($SqlSelectTilesCountRes);

					 $totalfinaos=0;
					 $totalfinaos=fngetTotalFinaos($sqlSelectDet['userid'],"search");
					 $totalfollowings=0;
					 $totalfollowings=fngetTotalFollowings($sqlSelectDet['userid']);
					 if($totaltiles=="")
						$totaltiles=0;
					 if($totalfinaos=="")
						$totalfinaos=0;
					 if($totalfollowers=="")
						$totalfollowers=0;
					 if($totalfollowings=="")
						$totalfollowings=0;
					$sqlSelectDet['totalfinaos']=$totalfinaos;
					$sqlSelectDet['totaltiles']=$totaltiles;
					$sqlSelectDet['totalfollowers']=$totalfollowers;
					$sqlSelectDet['totalfollowings']=$totalfollowings;
					$sqlSelectDet['profile_image']=$profile_image;
					$sqlSelectDet['mystory']=$mystory;     
				$counter=0;
if($username!="")
{
$sqlSelectProfile="SELECT t.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id WHERE t.tracker_userid =".$sqlSelectDet['userid']." AND t1.finao_status_Ispublic =1 AND t1.finao_activestatus =1 GROUP BY t.tile_id DESC ORDER BY t.updateddate DESC";
$sqlSelectProfile="SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
FROM `fn_trackingnotifications` `t`
JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id
JOIN fn_users t2 ON t.updateby = t2.userid
JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id
AND t3.lookup_type = 'notificationaction'
JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id
AND t4.lookup_type = 'finaostatus'
JOIN fn_user_finao_tile t5 
LEFT JOIN fn_uploaddetails fd
ON t1.user_finao_id = t5.finao_id 
WHERE t.tracker_userid =".$sqlSelectDet['userid']."
AND fd.`upload_sourceid` = t5.`finao_id`
AND t1.finao_status_Ispublic =1
AND t1.finao_activestatus =1
GROUP BY t.tile_id,finao_id DESC
ORDER BY t.updateddate DESC";

}
else
$sqlSelectProfile="SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
FROM `fn_trackingnotifications` `t`
JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id
JOIN fn_users t2 ON t.updateby = t2.userid
JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id
AND t3.lookup_type = 'notificationaction'
JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id
AND t4.lookup_type = 'finaostatus'
JOIN fn_user_finao_tile t5 
LEFT JOIN fn_uploaddetails fd
ON t1.user_finao_id = t5.finao_id 
WHERE t.tracker_userid =".$sqlSelectDet['userid']."
AND t.tile_id =".$sqlSelectDet['tile_id']."
AND fd.`upload_sourceid` = t5.`finao_id`
AND t1.finao_status_Ispublic =1
AND t1.finao_activestatus =1
GROUP BY t.tile_id,finao_id DESC
ORDER BY t.updateddate DESC";
//echo $sqlSelectProfile;
$counter=0;
//$sqlSelectProfileRes=mysql_query($sqlSelectProfile);
//$counter=mysql_num_rows($sqlSelectProfileRes);
//  $sqlSelectDet['totalfinaos']=$counter;
                                         $rows[] = $sqlSelectDet;
				}		
				 $json = array();
                                //$rows['totalrows']=mysql_num_rows($sqlSelectRes);
				$json['res'] = $rows;
                                
		}
		else
		{
		   $json['res']="";
		}
	
 	echo json_encode($json);
}
else if($_REQUEST['json']=='searchusers_new')
{
 $json =array();
	$tile_name=$_REQUEST['tile_name'];
	$username=$_REQUEST['username'];	
	if($username!="")
	$sqlSelect="select * from fn_users where email like '%".$username."%' or fname like '%".$username."%' or lname like '%".$username."%' or uname like '%".$username."%'";
	else	
	
	$sqlSelect="SELECT t.userid, t . * , t1.user_location, t1.profile_image, t2 . * FROM fn_users t JOIN fn_user_profile t1 ON t.userid = t1.user_id JOIN ( SELECT t . * , t2.tilename, t3.lookup_name FROM fn_user_finao t JOIN fn_user_finao_tile t1 ON t.user_finao_id = t1.finao_id AND t.userid = t1.userid JOIN fn_tilesinfo t2 ON t1.tile_id = t2.tile_id AND t1.userid = t2.createdby JOIN fn_lookups t3 ON t.finao_status = t3.lookup_id WHERE t2.tilename LIKE '%".$tile_name."%' AND t.finao_activestatus =1 AND t.finao_status_Ispublic =1 GROUP BY t.userid, t1.tile_id ORDER BY t.updateddate DESC )t2 ON t.userid = t2.userid GROUP BY t.fname, t.lname ORDER BY t.fname, t.lname ";

		$sqlSelectRes=mysql_query($sqlSelect);
		if(mysql_num_rows($sqlSelectRes)>0)
		{		

			while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
				{        
					         
					$sqlSelectProfile="select profile_image,mystory from fn_user_profile where user_id='".$sqlSelectDet['userid']."'";
				    $sqlSelectProfileRes=mysql_query($sqlSelectProfile);
					 if(mysql_num_rows($sqlSelectProfileRes)>0)
					 {
						while($sqlSelectProfileDet=mysql_fetch_array($sqlSelectProfileRes))
						 {
							$profile_image=$sqlSelectProfileDet['profile_image'];
                                                        $mystory=$sqlSelectProfileDet['mystory'];

						 }
					 }
                      
                                        
 				 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '".$sqlSelectDet['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
				 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
                 $totalfollowers=mysql_num_rows($sqlMyTrackingsRes);

                 $totaltiles=0;
				 $sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$sqlSelectDet['userid']."' AND Iscompleted =0 AND finao_activestatus !=2 AND finao_status_Ispublic =1 GROUP BY tile_id";
				 $sqlTilesCountRes=mysql_query($sqlTilesCount);
				 $totaltiles=mysql_num_rows($sqlTilesCountRes);
                 
				 $totalfinaos=0;
				 $sqlFianosCount="SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid ='".$sqlSelectDet['userid']."' AND f.finao_activestatus =1 AND Iscompleted =0 and finao_status_Ispublic = 1";
				 $sqlSelectCountRes=mysql_query($sqlFianosCount);
				 if(mysql_num_rows($sqlSelectCountRes)>0)
				 {
					while($sqlSelectCountDet=mysql_fetch_array($sqlSelectCountRes))
					 {
						$totalfinaos=$sqlSelectCountDet['totalfinaos'];
					 }
				 }
				  $totalfollowings=0;

				 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '".$sqlSelectDet['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
				 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
				 $totalfollowings=mysql_num_rows($sqlMyTrackingsRes);
				 if($totaltiles=="")
                    $totaltiles=0;
			     if($totalfinaos=="")
                    $totalfinaos=0;
				 if($totalfollowers=="")
                    $totalfollowers=0;
				 if($totalfollowings=="")
                    $totalfollowings=0;
				$sqlSelectDet['totalfinaos']=$totalfinaos;
				$sqlSelectDet['totaltiles']=$totaltiles;
				$sqlSelectDet['totalfollowers']=$totalfollowers;
				$sqlSelectDet['totalfollowings']=$totalfollowings;
				$sqlSelectDet['profile_image']=$profile_image;
				$sqlSelectDet['mystory']=$mystory;     
				$counter=0;
if($username!="")
{
$sqlSelectProfile="SELECT t.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id WHERE t.tracker_userid =".$sqlSelectDet['userid']." AND t1.finao_status_Ispublic =1 AND t1.finao_activestatus =1 GROUP BY t.tile_id DESC ORDER BY t.updateddate DESC";
$sqlSelectProfile="SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
FROM `fn_trackingnotifications` `t`
JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id
JOIN fn_users t2 ON t.updateby = t2.userid
JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id
AND t3.lookup_type = 'notificationaction'
JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id
AND t4.lookup_type = 'finaostatus'
JOIN fn_user_finao_tile t5 
LEFT JOIN fn_uploaddetails fd
ON t1.user_finao_id = t5.finao_id 
WHERE t.tracker_userid =".$sqlSelectDet['userid']."
AND fd.`upload_sourceid` = t5.`finao_id`
AND t1.finao_status_Ispublic =1
AND t1.finao_activestatus =1
GROUP BY t.tile_id,finao_id DESC
ORDER BY t.updateddate DESC";

}
else
$sqlSelectProfile="SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
FROM `fn_trackingnotifications` `t`
JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id
JOIN fn_users t2 ON t.updateby = t2.userid
JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id
AND t3.lookup_type = 'notificationaction'
JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id
AND t4.lookup_type = 'finaostatus'
JOIN fn_user_finao_tile t5 
LEFT JOIN fn_uploaddetails fd
ON t1.user_finao_id = t5.finao_id 
WHERE t.tracker_userid =".$sqlSelectDet['userid']."
AND t.tile_id =".$sqlSelectDet['tile_id']."
AND fd.`upload_sourceid` = t5.`finao_id`
AND t1.finao_status_Ispublic =1
AND t1.finao_activestatus =1
GROUP BY t.tile_id,finao_id DESC
ORDER BY t.updateddate DESC";

$counter=0;
$sqlSelectProfileRes=mysql_query($sqlSelectProfile);
$counter=mysql_num_rows($sqlSelectProfileRes);
//  $sqlSelectDet['totalfinaos']=$counter;
                                         $rows[] = $sqlSelectDet;
				}		
				 $json = array();
                                //$rows['totalrows']=mysql_num_rows($sqlSelectRes);
				$json['res'] = $rows;
                                
		}
		else
		{
		   $json['res']="";
		}
	
 	echo json_encode($json);
}
elseif($_REQUEST['json']=='forgotpassword')
{
 $json =array();
	$email=$_REQUEST['email'];
	require_once('class.phpmailer.php');
	$sqlSelect="select * from fn_users  where email='".$email."'";
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{
			
			$sqlSelectDet=mysql_fetch_array($sqlSelectRes);
			$fname=$sqlSelectDet['fname'];
			$lname=$sqlSelectDet['lname'];
			$name = $fname." ".$lname;
			$to=$email;
			//$headers = 'From: no-reply@bizindia.com' . "\r\n" .'Reply-To: no-reply@bizindia.org' . "\r\n" .'X-Mailer: PHP/' . phpversion();
			$headers .= "Reply-To: Fiano <admin@finaonation.com>\r\n"; 
$headers .= "Return-Path:Fiano <admin@finaonation.com>\r\n"; 
$headers .= "From: Fiano <admin@finaonation.com>\r\n"; 
$headers .= "Organization: finaonation\r\n"; 
$headers .= "Content-Type: text/plain\r\n"; 
$headers .= 'X-Mailer: PHP/' . phpversion();
		    $to = strtolower(trim($to));
			//$headers .= 'Cc: '.$cc . "\r\n";
			//$headers .= 'Bcc: '.$bcc . "\r\n";
			$subject="Fiano : Forgot Password Link";
			$message="Hi ".$name."\r\n Please Click on this following link to reset your passoword ";
			$activekey=md5(rand_string(10));
			$message.="http://finaonation.com/index.php/site/changepswdpopup?activkey=".$activekey."&email=".$email;	
		  
			$sqlUpdate="update fn_users set activkey='".$activekey."' where email='".$email."'";
			mysql_query($sqlUpdate);

			$message =trim($message);   
		    $subject=trim($subject);     
			$mail             = new PHPMailer(); // defaults to using php "mail()"
			$body             = $message;
			$body             = eregi_replace("[\]",'',$body);

			$mail->AddReplyTo("admin@bizindia.com","Administrator");

			$mail->SetFrom('admin@bizindia.com', 'Administrator');

			$mail->AddReplyTo("admin@bizindia.com","Administrator");


			$mail->AddAddress($to, $name);

			$mail->Subject    = $subject;

			//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

			$mail->MsgHTML($body);


			if(!$mail->Send()) {
			$json['res'] = "Message delivery failed";
			} else {
			$json['res'] = "Mail has sent successfully";
			}

	}
	else
	{
	   $json['res']="No email exists";
	}
 	echo json_encode($json);
}
else if($_REQUEST['json']=='register')
{

$json = array();
	$email=$_REQUEST['email'];
	$password=$_REQUEST['password'];
	$user_id=$_REQUEST['user_id'];
	$secondary_email=$_REQUEST['secondary_email'];
	$fname=$_REQUEST['fname'];
	$lname=$_REQUEST['lname'];
	$gender=$_REQUEST['gender'];
	$location=$_REQUEST['location'];
	$dob=$_REQUEST['dob'];
	$age=$_REQUEST['age'];
	$socialnetwork=$_REQUEST['socialnetwork'];
	$socialnetworkid=$_REQUEST['socialnetworkid'];
	$usertypeid=$_REQUEST['usertypeid'];
	$status=$_REQUEST['status'];
	$zipcode=$_REQUEST['zipcode'];

    $usertypeid="64";
	
	if($socialnetwork!="FACEBOOK")
	$socialnetwork="NULL";

	if($socialnetworkid=="")
	$socialnetworkid="0";

	$sqlSelect="select * from fn_users where UPPER(email)='".strtoupper($email)."'";

	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)<=0)
	{		

				$proxy = new SoapClient($soap_url); // TODO : change url
				
				$sessionId = $proxy->login($soapusername, $soappassword);				

				//$mageid = $proxy->customerCustomerCreate($sessionId, array('email' => $email, 'firstname' => $fname, 'lastname' => $lname, 'password' => $password,'store_id'=>'1','website_id'=>'1','group_id'=>1));
                $mageid = $proxy->call($sessionId, 'customer.create', array(array('email' => $email, 'firstname' => $fname, 'lastname' => $lname, 'password' => $password, 'website_id' => 1, 'store_id' => 1, 'group_id' => 1)));
//echo $mageid;
//exit;
				$sqlInsert ="insert into fn_users(password,uname,email,secondary_email,fname,lname,gender,location,dob,age,socialnetwork,socialnetworkid, 	usertypeid,status,zipcode,createtime,createdby,updatedby,updatedate,activkey,mageid)values('".md5($password)."','".$uname."','".$email."','".$secondary_email."','".$fname."','".$lname."','".$gender."','".$location."','".$dob."','".$age."','".$socialnetwork."','".$socialnetworkid."', 	'".$usertypeid."','".$status."','".$zipcode."',NOW(),'".$user_id."','".$user_id."',NOW(),'','".$mageid."')";
				
				mysql_query($sqlInsert);
				$insert_id=mysql_insert_id();
				$ch = curl_init("http://www.aweber.com/scripts/addlead.pl");				
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HEADER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER,array('Expect:'));               
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_NOBODY, FALSE);
				curl_setopt($ch, CURLOPT_POSTFIELDS,  "from=".$email."&name=".$email."&meta_web_form_id=848580469&meta_split_id=&unit=friendlies&redirect=http://www.aweber.com/form/thankyou_vo.html&meta_redirect_onlist=&meta_adtracking=&meta_message=1&meta_required=from&meta_forward_vars=0?");
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
				$result = @curl_exec($ch);
				
				$json = array();
		 		$json['res'] = $insert_id;
	}
	else
	{
	   $json['res']="Email Already Registered";
	}
 	echo json_encode($json);
}
else if($_REQUEST['json']=='journaldetails')
{
 $json =array();
		$user_id=$_REQUEST['user_id'];
		$sqlSelectJournal="select * from fn_user_finao_journal where finao_id='".$_REQUEST['finao_id']."' order by finao_journal_id desc";							
		$sqlSelectJournalRes=mysql_query($sqlSelectJournal);
		if(mysql_num_rows($sqlSelectJournalRes)>0)
		{		
			while($sqlSelectJournalDet=mysql_fetch_assoc($sqlSelectJournalRes))
			{        
				$rows2[] = $sqlSelectJournalDet;         
				//$rows2['json_journalimage']=stripslashes(getImageOrVideodetails('Image','journal',$sqlSelectJournalDet['finao_journal_id'],$user_id));
				//$rows2['json_journalvideo']=stripslashes(getImageOrVideodetails('Video','journal',$sqlSelectJournalDet['finao_journal_id'],$user_id));
			}		
			 $json = array();
			$json['res'] = $rows2;
		}
		else
		{
		   $json['res']="";
		}
 	echo json_encode($json);
						
}
elseif($_REQUEST['json']=='userlogon')
{
 $json =array();
	$flag=0;
	
    if($_REQUEST['email']!="" && $_REQUEST['socialnetworid']=="")
	{
	   $sqlSelect="select * from fn_users where email='".$_REQUEST['email']."' and password='".md5($_REQUEST['pwd'])."'";
	   $sqlSelectRes=mysql_query($sqlSelect);
	   if(mysql_num_rows($sqlSelectRes)<=0)
		{
			$sqlSelect="select * from fn_users where socialnetworkid='".($_REQUEST['pwd'])."'";
		}   
	   $flag=1;
	} 
	else 
	{
	   if($_REQUEST['socialnetworid']!="")
	   {           	   
	           
	           $sqlSelect="select * from fn_users where email='".$_REQUEST['email']."'";  
			   $flag=1;
	   }
	   else
	   {
	      $flag=0;		 
	   }
	}
	//echo $sqlSelect;
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0  && $flag==1)
	{		
      while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
		 {        
				
				if($_REQUEST['socialnetworid']!="")
		         {
		           $sqlUpdate="update fn_users set socialnetwork='facebook',socialnetworkid=".$_REQUEST['socialnetworid']." where userid='".$sqlSelectDet['userid']."'";
				   mysql_query($sqlUpdate);
				 }
				 $sqlSelectProfile="select profile_image,profile_bg_image,mystory  from fn_user_profile where user_id='".$sqlSelectDet['userid']."'";
				 $sqlSelectProfileRes=mysql_query($sqlSelectProfile);
				 if(mysql_num_rows($sqlSelectProfileRes))
				 {
					while($sqlSelectProfileDet=mysql_fetch_array($sqlSelectProfileRes))
					 {
						$profile_image=$sqlSelectProfileDet['profile_image'];
                                                $profile_bg_image=$sqlSelectProfileDet['profile_bg_image'];
                                                $mystory=$sqlSelectProfileDet['mystory'];
					 }
				 }
                                 $totalnotifications=0;
                                 $totalfinaos=0;
				  $sqlFianosCount="SELECT user_tileid FROM  `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id`  WHERE ft.userid =  '".$sqlSelectDet['userid']."' AND STATUS =1  AND finao_activestatus =1 AND  `Iscompleted` =0 ";
				 $sqlSelectCountRes=mysql_query($sqlFianosCount);
				 if(mysql_num_rows($sqlSelectCountRes))
				 {
					while($sqlSelectCountDet=mysql_fetch_array($sqlSelectCountRes))
					 {
						$totalfinaos=mysql_num_rows($sqlSelectCountRes);
					 }
				 }
                 $totaltiles=0;
				 $sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$sqlSelectDet['userid']."' AND Iscompleted =0 AND STATUS =1 AND finao_activestatus =1 GROUP BY tile_id";
				 $sqlTilesCountRes=mysql_query($sqlTilesCount);
				 $totaltiles=mysql_num_rows($sqlTilesCountRes);
				 
				 $sqlNotificationsCount="SELECT count(*) as totalnotifications FROM `fn_tracking` `t` JOIN fn_user_finao_tile t1 ON t.tracked_tileid = t1.tile_id AND t.tracker_userid = t1.userid JOIN fn_user_finao t2 ON t1.finao_id = t2.user_finao_id LEFT JOIN fn_tilesinfo fo ON fo.tile_id = t1.user_tileid AND finao_activestatus !=2 AND finao_status_Ispublic =1 WHERE t.tracked_userid ='".$sqlSelectDet['userid']."' AND t.status =0 GROUP BY t1.tile_id, fo.tilename";

				 $sqlNotificationsCountRes=mysql_query($sqlNotificationsCount);
				 if(mysql_num_rows($sqlNotificationsCountRes))
				 {
					//while($sqlNotificationsCountDet=mysql_fetch_array($sqlNotificationsCountRes))
					 {
						$totalnotifications=mysql_num_rows($sqlNotificationsCountRes);
					 }
				 }
           				 $totalfollowings=0;
				 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '".$sqlSelectDet['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
				 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
				 $totalfollowings=mysql_num_rows($sqlMyTrackingsRes);
				 

				 $totalfollowers=0;
				 
 				 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '".$sqlSelectDet['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
				 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
				 $totalfollowers=mysql_num_rows($sqlMyTrackingsRes);
				 
				 if($totalnotifications=="")
					 $totalnotifications=0;
				  if($totalfinaos=="")
					 $totalfinaos=0;
				   if($totalfollowers=="")
					 $totalfollowers=0;
				    if($totalfollowings=="")
					 $totalfollowings=0;
					
				    if($totaltiles=="")
					 $totaltiles=0;

				 $sqlSelectDet['totalnotifications']=$totalnotifications;
				 $sqlSelectDet['totalfinaos']=$totalfinaos;
                                 $sqlSelectDet['totalfollowers']=$totalfollowers;
				 $sqlSelectDet['totalfollowings']=$totalfollowings;
                                 $sqlSelectDet['totaltiles']=$totaltiles;
				 $sqlSelectDet['profile_image']=$profile_image;
                                 $sqlSelectDet['profile_bg_image']=$profile_bg_image;
                                  $sqlSelectDet['mystory']=$mystory;
				 $rows[] = $sqlSelectDet;      

		 }

		 	$json = array();
			
	 	$json['res'] = $rows;
	}
	else
	{
	   $json['res']="No User Exists";
	}
 	echo json_encode($json);
}
else if($_REQUEST['json']=='listfinos_old')
{
 $json =array();
		$str="";
        $actual_user_id=$_REQUEST['actual_user_id'];    
	if(!empty($_REQUEST['tile_id']))
	{
		$str=" and tile_id='".$_REQUEST['tile_id']."'";
	}
	$sqlSelectFinos="SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id ".$str." and ft.userid 	='".$_REQUEST['user_id']."'";
	if($_REQUEST['ispublic']!="")
	$sqlSelectFinos.="and f.finao_status_Ispublic=1";
		$sqlSelectFinos.=" and finao_activestatus!=2 order by user_tileid DESC";
         // echo $sqlSelectFinos;
	$sqlSelectFinosRes=mysql_query($sqlSelectFinos);
	if(mysql_num_rows($sqlSelectFinosRes)>0)
	{		
      while($sqlSelectFinosDet=mysql_fetch_assoc($sqlSelectFinosRes))
		 {      
                        $sqlSelectFinosDet['isfollow'] = "0";
			if($actual_user_id!="")
			 {
			    $sqlSelectTrack="select status as isfollow from fn_tracking where tracker_userid=".$actual_user_id." and tracked_userid=".$_REQUEST['user_id'];
				$sqlSelectTrackRes=mysql_query($sqlSelectTrack);
				if(mysql_num_rows($sqlSelectTrackRes)>0)
				{		
				  while($sqlSelectTrackDet=mysql_fetch_assoc($sqlSelectTrackRes))
					 {        
						$sqlSelectFinosDet['isfollow'] = $sqlSelectTrackDet['isfollow'];	
					 }
				}
			 }
		  	$sqlSelectFinosDet['finao_image'] = "";
			$sqlSelectFinosDet['uploadfile_path'] = "";
                    $str="";
 	            $str=" and upload_sourceid='".$sqlSelectFinosDet['finao_id']."'";
		    $sqlSelectUpload="select * from fn_uploaddetails where uploadtype='34' and Lower(upload_sourcetype)='37' ".$str;
               	    $sqlSelectUploadRes=mysql_query($sqlSelectUpload);
				if(mysql_num_rows($sqlSelectUploadRes)>0)
				{		
				  while($sqlSelectUploadDet=mysql_fetch_assoc($sqlSelectUploadRes))
					 {        
							$sqlSelectFinosDet['finao_image'] = "".$sqlSelectUploadDet['uploadfile_name'];
							$sqlSelectFinosDet['uploadfile_path'] = $sqlSelectUploadDet['uploadfile_path'];

					 }
				 }
				
				$rows[] = $sqlSelectFinosDet;        			
		 }
		 $json = array();
		$json['res'] = $rows;	
	}
	else
	{
	   $json['res']="";
	}
 	echo json_encode($json);
}
else if($_POST['json']=='listfinos')
{
 $json =array();
		$str="";
        $actual_user_id=$_POST['actual_user_id'];    
	if(!empty($_POST['tile_id']))
	{
		$str=" and tile_id='".$_REQUEST['tile_id']."'";
	}
	$sqlSelectFinos="SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f ON ft.`finao_id`=f.user_finao_id ".$str." and ft.userid 	='".$_REQUEST['user_id']."'";
	if($_POST['ispublic']!="")
	$sqlSelectFinos.=" and f.finao_status_Ispublic=1";
	if($_POST['actual_user_id']=="" && $_POST['ispublic']=="")
	$sqlSelectFinos.=" and Iscompleted =0";
		$sqlSelectFinos.=" and finao_activestatus=1 order by user_tileid DESC";

    // echo $sqlSelectFinos;
	$sqlSelectFinosRes=mysql_query($sqlSelectFinos);
	if(mysql_num_rows($sqlSelectFinosRes)>0)
	{		
      while($sqlSelectFinosDet=mysql_fetch_assoc($sqlSelectFinosRes))
		 {      
                        $sqlSelectFinosDet['isfollow'] = "0";
			if($actual_user_id!="")
			 {
			    
			    $sqlSelectTrack="select status as isfollow from fn_tracking where tracker_userid=".$actual_user_id." and tracked_userid=".$_REQUEST['user_id']." and tracked_tileid=".$sqlSelectFinosDet['tile_id'];
                            
				$sqlSelectTrackRes=mysql_query($sqlSelectTrack);
				if(mysql_num_rows($sqlSelectTrackRes)>0)
				{		
				  while($sqlSelectTrackDet=mysql_fetch_assoc($sqlSelectTrackRes))
					 {        
						$sqlSelectFinosDet['isfollow'] = $sqlSelectTrackDet['isfollow'];	
					 }
				}
			 }
		  	$sqlSelectFinosDet['finao_image'] = "";
			$sqlSelectFinosDet['uploadfile_path'] = "";
			$sqlSelectFinosDet['upload_text'] = ""; 
                    $str="";
 	            $str=" and upload_sourceid='".$sqlSelectFinosDet['finao_id']."'";
		    $sqlSelectUpload="select * from fn_uploaddetails where (uploadtype='34' or uploadtype='35' or uploadtype='62') and Lower(upload_sourcetype)='37' ".$str;
//			echo $sqlSelectUpload;
               	    $sqlSelectUploadRes=mysql_query($sqlSelectUpload);
				if(mysql_num_rows($sqlSelectUploadRes)>0)
				{		
				  while($sqlSelectUploadDet=mysql_fetch_assoc($sqlSelectUploadRes))
					 {        
							$sqlSelectFinosDet['finao_image'] = "".$sqlSelectUploadDet['uploadfile_name'];
							$sqlSelectFinosDet['uploadfile_path'] = $sqlSelectUploadDet['uploadfile_path'];
							$sqlSelectFinosDet['caption'] = $sqlSelectUploadDet['caption'];
							$sqlSelectFinosDet['video_caption'] = $sqlSelectUploadDet['video_caption'];
							$sqlSelectFinosDet['videoid'] = $sqlSelectUploadDet['videoid'];
							$sqlSelectFinosDet['videostatus'] = $sqlSelectUploadDet['videostatus'];
							$sqlSelectFinosDet['video_img'] = $sqlSelectUploadDet['video_img'];
							$sqlSelectFinosDet['video_embedurl'] = $sqlSelectUploadDet['video_embedurl'];

							//$sqlSelectFinosDet['upload_text'] = $sqlSelectUploadDet['upload_text'];// old code
							if($sqlSelectUploadDet['upload_text']=='null' or $sqlSelectUploadDet['upload_text']=='') $result=""; else $result=$sqlSelectUploadDet['upload_text'];
							$sqlSelectFinosDet['upload_text'] = $result; 
							$sqlSelectFinosDet['caption'] = $sqlSelectUploadDet['caption'];
						    if($sqlSelectUploadDet['uploadfile_name']=="")
						    {

								$sqlSelectUploadLatest="select * from fn_uploaddetails where (uploadtype='34' or uploadtype='35') and Lower(upload_sourcetype)='37' ".$str." order by uploaddetail_id desc limit 0,1 ";
								$sqlSelectUploadLatestRes=mysql_query($sqlSelectUploadLatest);
								if(mysql_num_rows($sqlSelectUploadLatestRes)>0)
								{		
							     while($sqlSelectUploadLatestRes=mysql_fetch_assoc($sqlSelectUploadLatestRes))
								 {        
										$sqlSelectFinosDet['finao_image'] = "".$sqlSelectUploadLatestRes['uploadfile_name'];
										$sqlSelectFinosDet['uploadfile_path'] = $sqlSelectUploadLatestRes['uploadfile_path'];
								 }
								}
							}
 
							

					 }
				 }
				$sqlSelectFinosDet['iscompleted']=$sqlSelectFinosDet['Iscompleted'];
				$rows[] = $sqlSelectFinosDet;        			
		 }
		 $json = array();
		$json['res'] = $rows;	
	}
	else
	{
	   $json['res']="";
	}
 	echo json_encode($json);
}
else if($_REQUEST['json']=='finaosdetails')
{	
 $json =array();
	//$type=$_REQUEST['type'];//Image/Video	
	$srctype='finao';//finao
	$srcid=$_REQUEST['finao_id'];
	$user_id=$_REQUEST['user_id'];
	
//	$json_finaoimage=getImageOrVideodetails('Image',$srctype,$srcid,$user_id);
//	$json_finaovideo=getImageOrVideodetails('Video',$srctype,$srcid,$user_id);
	
	$sqlSelectFinos="select * from fn_user_finao where user_finao_id='".$_REQUEST['finao_id']."'";
	$sqlSelectFinosRes=mysql_query($sqlSelectFinos);
	if(mysql_num_rows($sqlSelectFinosRes)>0)
	{		
      while($sqlSelectFinosDet=mysql_fetch_assoc($sqlSelectFinosRes))
		 {        
				$rows[] = $sqlSelectFinosDet;         
						/**Get finas details
							$sqlSelectJournal="select * from fn_user_finao_journal where finao_id='".$sqlSelectFinosDet['user_finao_id']."'";
							
							$sqlSelectJournalRes=mysql_query($sqlSelectJournal);
							if(mysql_num_rows($sqlSelectJournalRes)>0)
							{		
								while($sqlSelectJournalDet=mysql_fetch_assoc($sqlSelectJournalRes))
								{        
									$rows2[] = $sqlSelectJournalDet;         
									$rows2['json_journalimage']=stripslashes(getImageOrVideodetails('Image','journal',$sqlSelectJournalDet['finao_journal_id'],$user_id));
								    $rows2['json_journalvideo']=stripslashes(getImageOrVideodetails('Video','journal',$sqlSelectJournalDet['finao_journal_id'],$user_id));
								}								
							}
						Get finas details*/
		 }

			//	$rows['json_finaoimage']=stripslashes(json_encode($json_finaoimage));
			//	$rows['json_finaovideo']=stripslashes(json_encode($json_finaovideo));
			//	$rows["json_journaldata"]=stripslashes(json_encode($rows2));
				$json = array();
				$json['res'] = $rows;
	}
	else
	{
	   $json['res']="";
	}
 	$json1=json_encode($json);
	echo stripslashes($json1);
}
else if($_REQUEST['json']=='userdata')
{
 $json =array();
	$sqlSelectUser="select userid,uname,email,secondary_email,activkey,lastvisit,superuser,profile_image,fname,lname,gender,location,description,dob,age,socialnetwork,socialnetworkid,usertypeid,status,zipcode,createtime,createdby,updatedby,updatedate from fn_users where userid='".$_REQUEST['user_id']."'";
	$sqlSelectUserRes=mysql_query($sqlSelectUser);
	if(mysql_num_rows($sqlSelectUserRes)>0)
	{
		
      while($sqlSelectUserDet=mysql_fetch_assoc($sqlSelectUserRes))
		 {
        
				$rows[] = $sqlSelectUserDet;         
		 }
		 $json = array();
 	$json['res'] = $rows;
	}
	else
	{
	   $json['res']="";
	}

	
 	echo json_encode($json);
}
else if($_REQUEST['json']=='listjournals')
{
 $json =array();
	$sqlSelectJournal="select * from fn_user_finao_journal where finao_id='".$_REQUEST['finao_id']."'";
	$sqlSelectJournalRes=mysql_query($sqlSelectJournal);
	if(mysql_num_rows($sqlSelectJournalRes)>0)
	{		
      while($sqlSelectJournalDet=mysql_fetch_assoc($sqlSelectJournalRes))
		 {        
				$rows[] = $sqlSelectJournalDet;         
		 }
		 $json = array();
		$json['res'] = $rows;
	}
	else
	{
	   $json['res']="";
	}
 	echo json_encode($json);
}
else if($_REQUEST['json']=='userprofiledata')
{
 $json =array();
	$sqlSelectProfile="select * from fn_user_profile where user_id='".$_REQUEST['user_id']."'";
	$sqlSelectProfileRes=mysql_query($sqlSelectProfile);
	if(mysql_num_rows($sqlSelectProfileRes)>0)
	{
		
      while($sqlSelectProfileDet=mysql_fetch_assoc($sqlSelectProfileRes))
		 {
        
				$rows[] = $sqlSelectProfileDet;         
		 }
		 $json = array();
 	$json['res'] = $rows;
	}
	else
	{
	   $json['res']="";
	}

	
 	echo json_encode($json);
}
elseif($_REQUEST['json']=='usertiles')
{
 $json =array();
	/*$sqlSelectUserTiles="select * from fn_user_finao_tile";
	if($_REQUEST['user_id']!="")
	$sqlSelectUserTiles.=" where userid='".$_REQUEST['user_id']."'";
	$sqlSelectUserTiles.=" group by tile_id";*/
$ispublic=$_REQUEST['ispublic'];
$iscomplete=$_REQUEST['iscomplete'];

if($_REQUEST['user_id']=="")
{
	$sqlSelectUserTiles="SELECT t.user_tileid, t.tile_id, t.tile_name AS tilename, t.tile_name, t.userid, t.finao_id, t1.tile_imageurl AS tile_image, t.status, t.createddate, t.createdby, t.updateddate, t.updatedby, t.explore_finao, t1.tile_imageurl AS uploadfile_name FROM fn_user_finao_tile t LEFT JOIN fn_tilesinfo t1 ON t.tile_id = t1.tile_id AND t.userid = t1.createdby JOIN fn_lookups fl JOIN fn_uploaddetails fd ON fl.lookup_id = t.tile_id WHERE lookup_type =  'tiles' AND fd.upload_sourceid = t.userid AND t1.tile_imageurl!='' finao_id IN ( SELECT user_finao_id FROM fn_user_finao where user_finao_id<>0 ";
	if($_REQUEST['user_id']!="")
	$sqlSelectUserTiles.=" and userid='".$_REQUEST['user_id']."'";
	$sqlSelectUserTiles.=" AND finao_activestatus =1";
	if($iscomplete=="0" && isset($iscomplete))
	$sqlSelectUserTiles.=" AND Iscompleted =0";
	if($ispublic=="1")
	$sqlSelectUserTiles.=" AND finao_status_Ispublic = 1 ";
	$sqlSelectUserTiles.=" ORDER BY updateddate DESC ) GROUP BY t.tile_id ";

	
	if($_REQUEST['custom_user_id']!='')
	{

	$sqlSelectUserTiles="select * from ((SELECT t.user_tileid, t.tile_id, t.tile_name AS tilename, t.tile_name, t.userid, t.finao_id, t1.tile_imageurl AS tile_image, t.status, t.createddate, t.createdby, t.updateddate, t.updatedby, t.explore_finao, t1.tile_imageurl AS uploadfile_name FROM fn_user_finao_tile t LEFT JOIN fn_tilesinfo t1 ON t.tile_id = t1.tile_id AND t.userid = t1.createdby AND t1.tile_imageurl!='' WHERE finao_id IN ( SELECT user_finao_id FROM fn_user_finao where user_finao_id<>0 ";
	$sqlSelectUserTiles.=" AND finao_activestatus =1";
	if($iscomplete=="0" && isset($iscomplete))
	$sqlSelectUserTiles.=" AND Iscompleted =0 ";
	if($_REQUEST['custom_user_id']!="")
	$sqlSelectUserTiles.=" and userid='".$_REQUEST['custom_user_id']."'";
	if($ispublic=="1")
	$sqlSelectUserTiles.=" AND finao_status_Ispublic = 1 ";		
	$sqlSelectUserTiles.=" ORDER BY updateddate DESC ) GROUP BY t.tile_id ) UNION (SELECT t.user_tileid, t.tile_id, t.tile_name AS tilename, t.tile_name, t.userid, t.finao_id, t1.tile_imageurl AS tile_image, t.status, t.createddate, t.createdby, t.updateddate, t.updatedby, t.explore_finao, t1.tile_imageurl AS uploadfile_name FROM fn_user_finao_tile t LEFT JOIN fn_tilesinfo t1 ON t.tile_id = t1.tile_id AND t.userid = t1.createdby JOIN fn_lookups fl JOIN fn_uploaddetails fd ON fl.lookup_id = t.tile_id WHERE lookup_type = 'tiles' AND fd.upload_sourceid = t.userid AND finao_id IN ( SELECT user_finao_id FROM fn_user_finao where user_finao_id<>0 AND finao_activestatus =1 ";
	if($iscomplete=="0" && isset($iscomplete))
	$sqlSelectUserTiles.=" AND Iscompleted =0 ";
	if($ispublic=="1")
	$sqlSelectUserTiles.=" AND finao_status_Ispublic = 1 ";

	$sqlSelectUserTiles.=" ORDER BY updateddate DESC ) GROUP BY t.tile_id)) a GROUP BY tile_name ";

	/*$sqlSelectUserTiles="select * from ( (SELECT t.user_tileid, t.tile_id, t.tile_name AS tilename, t.tile_name, t.userid, t.finao_id, t1.tile_imageurl AS tile_image, t.status, t.createddate, t.createdby, t.updateddate, t.updatedby, t.explore_finao, t1.tile_imageurl AS uploadfile_name FROM fn_user_finao_tile t LEFT JOIN fn_tilesinfo t1 ON t.tile_id = t1.tile_id AND t.userid = t1.createdby JOIN fn_lookups fl JOIN fn_uploaddetails fd ON fl.lookup_id = t.tile_id WHERE lookup_type = 'tiles' AND fd.upload_sourceid = t.userid AND finao_id IN ( SELECT user_finao_id FROM fn_user_finao where user_finao_id<>0 AND finao_activestatus =1 ";
	if($iscomplete=="0" && isset($iscomplete))
	$sqlSelectUserTiles.=" AND Iscompleted =0 ";
	if($ispublic=="1")
	$sqlSelectUserTiles.=" AND finao_status_Ispublic = 1 ";

	$sqlSelectUserTiles.=" ORDER BY updateddate DESC ) GROUP BY t.tile_id)	UNION	(SELECT t.user_tileid, t.tile_id, t.tile_name AS tilename, t.tile_name, t.userid, t.finao_id, t1.tile_imageurl AS tile_image, t.status, t.createddate, t.createdby, t.updateddate, t.updatedby, t.explore_finao, t1.tile_imageurl AS uploadfile_name FROM fn_user_finao_tile t LEFT JOIN fn_tilesinfo t1 ON t.tile_id = t1.tile_id AND t.userid = t1.createdby WHERE finao_id IN ( SELECT user_finao_id FROM fn_user_finao where user_finao_id<>0 ";
	$sqlSelectUserTiles.=" AND finao_activestatus =1";
	if($iscomplete=="0" && isset($iscomplete))
	$sqlSelectUserTiles.=" AND Iscompleted =0 ";
	if($_REQUEST['custom_user_id']!="")
	$sqlSelectUserTiles.=" and userid='".$_REQUEST['custom_user_id']."'";
	if($ispublic=="1")
	$sqlSelectUserTiles.=" AND finao_status_Ispublic = 1 ";		
	$sqlSelectUserTiles.=" ORDER BY updateddate DESC ) GROUP BY t.tile_id )	) a GROUP BY tile_name ";
*/

	//	echo $sqlSelectUserTiles;
	}
}
else
{

$sqlSelectUserTiles="SELECT t.user_tileid, t.tile_id, t.tile_name AS tilename, t.tile_name, t.userid, t.finao_id, t1.tile_imageurl AS tile_image, t.status, t.createddate, t.createdby, t.updateddate, t.updatedby, t.explore_finao, t1.tile_imageurl AS uploadfile_name FROM fn_user_finao_tile t LEFT JOIN fn_tilesinfo t1 ON t.tile_id = t1.tile_id AND t.userid = t1.createdby WHERE finao_id IN ( SELECT user_finao_id FROM fn_user_finao where user_finao_id<>0 ";
if($_REQUEST['user_id']!="")
$sqlSelectUserTiles.=" and userid='".$_REQUEST['user_id']."'";
$sqlSelectUserTiles.=" AND finao_activestatus =1";
if($iscomplete=="0" && isset($iscomplete))
$sqlSelectUserTiles.=" AND Iscompleted =0";
if($ispublic=="1")
$sqlSelectUserTiles.=" AND finao_status_Ispublic = 1 ";
$sqlSelectUserTiles.=" ORDER BY updateddate DESC ) GROUP BY t.tile_id ";
}
	


//echo $sqlSelectUserTiles;

	$sqlSelectUserTilesRes=mysql_query($sqlSelectUserTiles);
	if(mysql_num_rows($sqlSelectUserTilesRes)>0)
	{
		
      while($sqlSelectUserTilesDet=mysql_fetch_assoc($sqlSelectUserTilesRes))
		 {
                $sqlSelectUserTilesDet['uploadfile_path']='/images/uploads/tiles';
				//$sqlSelectUserTilesDet['tile_image']="";
			    $img = "http://cdn.finaonation.com/images/tiles/".$sqlSelectUserTilesDet['tile_image'];
				$exists=getimagesize($img) ? "Yes" : "No";
//				echo "http://cdn.finaonation.com/images/tiles/".$sqlSelectUserTilesDet['tile_image'];
//				echo $exists;
				if($exists=='No')
				{
					$sqlSelectUserTilesImage="SELECT t1.tile_imageurl AS tile_image FROM fn_user_finao_tile t LEFT JOIN fn_tilesinfo t1 ON t.tile_id = t1.tile_id AND t.userid = t1.createdby JOIN fn_lookups fl JOIN fn_uploaddetails fd ON fl.lookup_id = t.tile_id WHERE lookup_type = 'tiles' AND fd.upload_sourceid = t.userid AND finao_id IN ( SELECT user_finao_id FROM fn_user_finao where user_finao_id<>0 AND finao_activestatus =1 ";
					if($iscomplete=="0" && isset($iscomplete))
					$sqlSelectUserTilesImage.=" AND Iscompleted =0 ";
					if($ispublic=="1")
					$sqlSelectUserTilesImage.=" AND finao_status_Ispublic = 1 ";
					$sqlSelectUserTilesImage.=" AND t.tile_id = ".$sqlSelectUserTilesDet['tile_id'];
					$sqlSelectUserTilesImage.=" ORDER BY updateddate DESC ) GROUP BY t.tile_id ";
					//echo $sqlSelectUserTilesImage;
					$sqlSelectUserTilesImageRes=mysql_query($sqlSelectUserTilesImage);
					if(mysql_num_rows($sqlSelectUserTilesImageRes)>0)
					{
						$sqlSelectUserTilesImageDet=mysql_fetch_array($sqlSelectUserTilesImageRes);
						$sqlSelectUserTilesDet['tile_image']=$sqlSelectUserTilesImageDet['tile_image'];
					}
				}
				

				$rows[] = $sqlSelectUserTilesDet;         
		 }
		 
	$json = array();
 	$json['res'] = $rows;
	}
	else
	{
	   $json['res']="";
	}

 	echo json_encode($json);
  
}
elseif($_REQUEST['json']=='usertiles_new')
{
 $json =array();
	/*$sqlSelectUserTiles="select * from fn_user_finao_tile";
	if($_REQUEST['user_id']!="")
	$sqlSelectUserTiles.=" where userid='".$_REQUEST['user_id']."'";
	$sqlSelectUserTiles.=" group by tile_id";*/
$ispublic=$_REQUEST['ispublic'];
if($_REQUEST['user_id']=="")
{
	$sqlSelectUserTiles="select fu.user_tileid,fu.tile_id,fu.tile_name,fu.userid,fu.finao_id,fu.tile_profileImagurl as tile_image,fu.status,fu.createddate,fu.createdby,fu.updateddate,fu.updatedby,fu.explore_finao,fd.uploadfile_name,fd.uploadfile_path from fn_user_finao_tile fu RIGHT JOIN fn_user_finao f ON fu.finao_id = f.user_finao_id join fn_lookups fl JOIN fn_uploaddetails fd on fl.lookup_id=fu.tile_id where lookup_type='tiles' AND fd.upload_sourceid = fu.userid AND `lookup_name` = fu.tile_name AND finao_activestatus =1 and iscompleted=0";	
	if($ispublic=="1")
	{
		$sqlSelectUserTiles.=" and finao_status_Ispublic = 1";
	}
	//JOIN fn_uploaddetails fd AND fd.uploadedby  = t1.userid
	$sqlSelectUserTiles.=" group by fu.tile_name";
}
else
{
	$sqlSelectUserTiles="select fu.user_tileid,fu.tile_id,fu.tile_name,fu.userid,fu.finao_id,fu.tile_profileImagurl as tile_image,fu.status,fu.createddate,fu.createdby,fu.updateddate,fu.updatedby,fu.explore_finao,fd.uploadfile_name,fd.uploadfile_path FROM `fn_user_finao_tile` fu RIGHT JOIN fn_user_finao f ON fu.finao_id = f.user_finao_id LEFT JOIN fn_uploaddetails fd ON fd.`upload_sourceid` = fu.`finao_id`  ";
	if($_REQUEST['user_id']!="")
	$sqlSelectUserTiles.=" where fu.userid='".$_REQUEST['user_id']."'";
        $sqlSelectUserTiles.=" AND finao_activestatus =1 ";
		if($ispublic=="1")
		{
			$sqlSelectUserTiles.=" and finao_status_Ispublic = 1";
		}
	$sqlSelectUserTiles.=" group by tile_id";
}
	$sqlSelectUserTiles.=" ORDER BY fu.user_tileid DESC";

//echo $sqlSelectUserTiles;

	$sqlSelectUserTilesRes=mysql_query($sqlSelectUserTiles);
	if(mysql_num_rows($sqlSelectUserTilesRes)>0)
	{
		
      while($sqlSelectUserTilesDet=mysql_fetch_assoc($sqlSelectUserTilesRes))
		 {
        
				$rows[] = $sqlSelectUserTilesDet;         
		 }
		 
	$json = array();
 	$json['res'] = $rows;
	}
	else
	{
	   $json['res']="";
	}

 	echo json_encode($json);
  
}
elseif($_REQUEST['json']=='usertiles_old')
{
 $json =array();
	/*$sqlSelectUserTiles="select * from fn_user_finao_tile";
	if($_REQUEST['user_id']!="")
	$sqlSelectUserTiles.=" where userid='".$_REQUEST['user_id']."'";
	$sqlSelectUserTiles.=" group by tile_id";*/
$ispublic=$_REQUEST['ispublic'];
if($_REQUEST['user_id']=="")
{
	$sqlSelectUserTiles="select fu.user_tileid,fu.tile_id,fu.tile_name,fu.userid,fu.finao_id,fu.tile_profileImagurl as tile_image,fu.status,fu.createddate,fu.createdby,fu.updateddate,fu.updatedby,fu.explore_finao,fd.uploadfile_name,fd.uploadfile_path from fn_user_finao_tile fu RIGHT JOIN fn_user_finao f ON fu.finao_id = f.user_finao_id join fn_lookups fl JOIN fn_uploaddetails fd on fl.lookup_id=fu.tile_id where lookup_type='tiles' AND fd.upload_sourceid = fu.userid AND `lookup_name` = fu.tile_name AND finao_activestatus =1 and iscompleted=0   and fu.tile_profileImagurl like '%png'";	
	if($ispublic=="1")
	{
		$sqlSelectUserTiles.=" and finao_status_Ispublic = 1";
	}
	
	//JOIN fn_uploaddetails fd AND fd.uploadedby  = t1.userid
	$sqlSelectUserTiles.=" group by fu.tile_name";
	$sqlSelectUserTiles.=" ORDER BY fu.user_tileid DESC";
}
else
{
	$sqlSelectUserTiles="select ut.user_tileid,ut.tile_id,ut.tile_name,ut.userid,ut.finao_id,fo.tile_imageurl as  tile_image,ut.status,ut.createddate,ut.createdby,ut.updateddate,ut.updatedby,ut.explore_finao from fn_user_finao_tile ut left join fn_tilesinfo fo on ut.tile_id=fo.tile_id where finao_id in (select user_finao_id from fn_user_finao where finao_activestatus!=2 ";
if($_REQUEST['user_id']!="")
$sqlSelectUserTiles.=" and userid='".$_REQUEST['user_id']."'";
if($ispublic=="1")
{
	$sqlSelectUserTiles.=" and finao_status_Ispublic = 1 ";
}
else
	{
		$sqlSelectUserTiles.=" and Iscompleted = 0";
	}
$sqlSelectUserTiles.=" order by updateddate DESC)";
if($_REQUEST['user_id']!="")
$sqlSelectUserTiles.=" and userid='".$_REQUEST['user_id']."'";
$sqlSelectUserTiles.=" group by tile_id order by createddate DESC";
}
	


//echo $sqlSelectUserTiles;

	$sqlSelectUserTilesRes=mysql_query($sqlSelectUserTiles);
	if(mysql_num_rows($sqlSelectUserTilesRes)>0)
	{
		
      while($sqlSelectUserTilesDet=mysql_fetch_assoc($sqlSelectUserTilesRes))
		 {
        
				$rows[] = $sqlSelectUserTilesDet;         
		 }
		 
	$json = array();
 	$json['res'] = $rows;
	}
	else
	{
	   $json['res']="";
	}

 	echo json_encode($json);
  
}
elseif($_REQUEST['json']=='movefinao')
{
	$finao_id=$_REQUEST['finao_id'];
	$user_id=$_REQUEST['user_id'];
	$srctile_id=$_REQUEST['srctile_id'];
	$targettile_id=$_REQUEST['targettile_id'];
	$sqlUpdateQuery="update fn_user_finao_tile set tile_id=".$targettile_id." where tile_id=".$srctile_id." and userid=".$user_id." and finao_id=".$finao_id;
//echo $sqlUpdateQuery;
	mysql_query($sqlUpdateQuery);
	$json = array();
	$json['res'] = 'ok';
	echo json_encode($json);
}
elseif($_REQUEST['json']=='deletefinao')
{
	$id=$_REQUEST['id'];
	$user_id=$_REQUEST['user_id'];

	$sqlDelteQuery="update fn_user_finao set finao_activestatus=2 where user_finao_id=".$id;
	mysql_query($sqlDelteQuery);

	
	$sqlDelteUserTileQuery="update fn_user_finao_tile set status=2 where finao_id=".$id." and userid=".$user_id;
	mysql_query($sqlDelteUserTileQuery);

	 
	$sqlDeleteFianoDetails="update fn_uploaddetails set status=2 where upload_sourcetype=37 and upload_sourceid=".$id." and uploadedby=".$user_id;
	mysql_query($sqlDeleteFianoDetails);
	$json = array();
	$json['res'] = 'ok';
	echo json_encode($json);

}
else if($_REQUEST['json']=='getfinaoimageorvideo')
{
 $json =array();
	$type=$_REQUEST['type'];//Image/Video	
	$srctype=$_REQUEST['srctype'];//tile/finao/journal
	$srcid=$_REQUEST['srcid'];
	$user_id=$_REQUEST['user_id'];

	$sqlSelect="select * from fn_lookups where lookup_type='uploadtype' and Lower(lookup_name)='".strtolower($type)."'";
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{		
      while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
		 {
			$lookup_id=$sqlSelectDet['lookup_id'];
		 }
	}
	$sqlSelectSrctype="select * from fn_lookups where lookup_type='uploadsourcetype' and Lower(lookup_name)='".strtolower($srctype)."'";

	$sqlSelectSrctypeRes=mysql_query($sqlSelectSrctype);
	if(mysql_num_rows($sqlSelectSrctypeRes)>0)
	{		
      while($sqlSelectSrctypeDet=mysql_fetch_assoc($sqlSelectSrctypeRes))
		 {
			$srclookup_id=$sqlSelectSrctypeDet['lookup_id'];
		 }
	}
	$str="";
	if($srcid!="")
	$str=" and upload_sourceid='".$srcid."'";

	$sqlSelectUpload="select * from fn_uploaddetails where uploadtype='".$lookup_id."' and Lower(upload_sourcetype)='".strtolower($srclookup_id)."' ".$str." and uploadedby='".$user_id."'";
	$sqlSelectUploadRes=mysql_query($sqlSelectUpload);
	if(mysql_num_rows($sqlSelectUploadRes)>0)
	{		
      while($sqlSelectUploadDet=mysql_fetch_assoc($sqlSelectUploadRes))
		 {        
				$rows[] = $sqlSelectUploadDet;         
		 }
		 
	$json = array();
 	$json['res'] = $rows;

	 }
	 else
	{
		 $json['res']="";
	}
		echo json_encode($json);
	}
else if($_REQUEST['json']=='createfiano_live')
{
		$json =array();
		$json_test='{ "user_id":1 ,"finao_msg":"tester","tile_id":1,"tile_name":"tester test","finao_status_inpublic":1,"updatedby":1,"finao_status":1,"iscompleted":1,"tile_id":1,"tile_name":"test"}';
	
		//$json_data=json_decode($_POST['json_data'],true);
		

		$userid=mysql_real_escape_string($_REQUEST['user_id']);
		$finao_msg=mysql_real_escape_string($_REQUEST['finao_msg']);
		$tile_id=mysql_real_escape_string($_REQUEST['tile_id']);
		$atile_id=mysql_real_escape_string($_REQUEST['tile_id']);
		$tile_name=mysql_real_escape_string($_REQUEST['tile_name']);
		$finao_status_ispublic=mysql_real_escape_string($_REQUEST['finao_status_ispublic']);
		$updatedby=mysql_real_escape_string($_REQUEST['user_id']);
		$finao_status=mysql_real_escape_string($_REQUEST['finao_status']);
		if($finao_status!="")
		$finao_status=1;
		$iscompleted=mysql_real_escape_string($_REQUEST['iscompleted']);                
		$tile_create=0;
                if($tile_id!="")
                {
                  $tile_create=1;
                }
                if($tile_id=="")  
                {
		$sqlSelect="select * from fn_lookups where lookup_type='tiles' and lookup_name='".$tile_name."'";
		$sqlSelectRes=mysql_query($sqlSelect);
		if(mysql_num_rows($sqlSelectRes)<=0)				
                {
		
			$sqlSelectTile="select * from fn_tilesinfo from tilename='".$tile_name."'";
                    $sqlSelectTileRes=mysql_query($sqlSelectTile);
					if(mysql_num_rows($sqlSelectTileRes)<=0)				
					{
						$tile_create=1;		
					}
		}
                }
		if($tile_create==1)
	        {
		if($tile_id=="")
		{
			$selectTile_id="select max(tile_id) as tilecount from fn_user_finao_tile";
			$selectTile_idRes=mysql_query($selectTile_id);
			$selectTile_idDet=mysql_fetch_array($selectTile_idRes);
			$tile_id=($selectTile_idDet['tilecount'])+1;
		}
		$sqlInsert="insert into fn_user_finao (userid,finao_msg,finao_status_ispublic,updatedby,finao_status,iscompleted,createddate,updateddate)values('".$userid."','".$finao_msg."','".$finao_status_ispublic."','".$updatedby."','".$finao_status."','".$iscompleted."',NOW(),NOW())";
		mysql_query($sqlInsert);
		$finao_id=mysql_insert_id();	
		/*if($atile_id!="")
		{
			$sqlSelectTileData="select tile_profileImagurl,tile_name from  fn_user_finao_tile where tile_id=".$atile_id;
			$sqlSelectResTileData=mysql_query($sqlSelectTileData);
			if(mysql_num_rows($sqlSelectResTileData))
			{
				while($sqlSelectDetTileData=mysql_fetch_array($sqlSelectResTileData))
				{
					$tile_profileImagurl=$sqlSelectDetTileData['tile_profileImagurl'];	
                    $tile_name=$sqlSelectDetTileData['tile_name'];			
                    @move_uploaded_file($target_path.$tile_profileImagurl, $target_path.$tile_profileImagurl);
					$tile_image=$tile_id."-".$tile_profileImagurl;
				}
			}
            else
		    {
		           $tile_image=$tile_id."-".$_FILES['tile_image']['name'];
		    }
			$tile_id=$atile_id;
		}
		else
		{
		   $tile_image=$tile_id."-".$_FILES['tile_image']['name'];
		}*/
		$target_path = $globalpath."images/tiles/";
		$upload_path = "images/tiles/";
		if($_FILES['tile_image']['name']!="")
		{
			
			$target_path = $target_path . basename($_FILES['tile_image']['name']); 
			@move_uploaded_file($_FILES['tile_image']['tmp_name'], $target_path);

			$uploadfile_name=basename($_FILES['tile_image']['name']);
		}

		if($tile_id=="")
                {
			$sqlInsertFianoTable="insert into fn_user_finao_tile(tile_id,tile_name,userid,finao_id,tile_profileImagurl,status,createddate,createdby,updateddate,updatedby)values('".$tile_id."','".$tile_name."','".$userid."','".$finao_id."','".$_FILES['tile_image']['name']."','1',NOW(),'".$userid."',NOW(),'".$userid."')";
			mysql_query($sqlInsertFianoTable);
		        $sqlInsertTileInfo="insert into fn_tilesinfo(tile_id,tilename,tile_imageurl,status,createddate,createdby,updateddate,updatedby)values('".$tile_id."','".$tile_name."','".$_FILES['tile_image']['name']."','".$status."',NOW(),'".$userid."',NOW(),'".$userid."')";
			mysql_query($sqlInsertTileInfo);
                }

//		$tile_id=mysql_insert_id();	

//		$sqlUpdate="update fn_lookups set lookup_name='".$tile_id."' where lookup_type='newtile'";
//		mysql_query($sqlUpdate);
		//if($atile_id!="")
		{
				$upload_type="34";
                $target_path = $globalpath."images/uploads/finaoimages";	
                $upload_path = "/images/uploads/finaoimages";		
				if($_FILES['image']['name']!="")
				{
					$upload_type="34";		
					$target_path = $target_path .$finao_id."-". basename($_FILES['image']['name']); 

					@move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
					$uploadfile_name=$_FILES['image']['name'];
				}
				if($_FILES['video']['name']!="")
				{
					$upload_type="35";	
					$target_path = $target_path .$finao_id."-". basename($_FILES['video']['name']); 
					@move_uploaded_file($_FILES['video']['tmp_name'], $target_path);
					$uploadfile_name=$_FILES['video']['name'];
				}
				$id=$tile_id;
				$user_id=$_REQUEST['user_id'];
				$caption=$_REQUEST['caption'];
				$videoid=$_REQUEST['videoid'];
				$videostatus=$_REQUEST['videostatus'];
				$video_img=$_REQUEST['video_img'];
				$type='tile';
				if($type=='tile')
				{
					$upload_sourcetype=36;
				}
				$sqlInsert="insert into fn_uploaddetails(uploadtype,uploadfile_name,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img)values('".$upload_type."','".$finao_id."-".basename($_FILES['image']['name'])."','".$upload_path."','".$upload_sourcetype."','".$finao_id."','".$user_id."',NOW(),'1','".$user_id."',NOW(),'".$caption."','".$videoid."','".$videostatus."','".$video_img."')";
				mysql_query($sqlInsert);
		 }		
		$json = array();
		$json['finao_id']=$finao_id;
		}
		else
		{
			$json = array();
			$json['res']="Cannot Create Duplicate Tile";
		}
 		echo json_encode($json);
}
else if($_REQUEST['json']=='createfiano')
{
        $json =array();
		$json_test='{ "user_id":1 ,"finao_msg":"tester","tile_id":1,"tile_name":"tester test","finao_status_inpublic":1,"updatedby":1,"finao_status":1,"iscompleted":1,"tile_id":1,"tile_name":"test"}';
	
		//$json_data=json_decode($_POST['json_data'],true);
		
		$caption=mysql_real_escape_string(trim($_REQUEST['caption']));
		$userid=mysql_real_escape_string($_REQUEST['user_id']);
		$finao_msg=mysql_real_escape_string($_REQUEST['finao_msg']);
		$tile_id=mysql_real_escape_string($_REQUEST['tile_id']);
		$atile_id=mysql_real_escape_string($_REQUEST['tile_id']);
		$tile_name=mysql_real_escape_string($_REQUEST['tile_name']);
		$finao_status_ispublic=mysql_real_escape_string($_REQUEST['finao_status_ispublic']);
		$updatedby=mysql_real_escape_string($_REQUEST['user_id']);
		$finao_status=mysql_real_escape_string($_REQUEST['finao_status']);
		//if($finao_status=="")
		$finao_status=38;
		$iscompleted=mysql_real_escape_string($_REQUEST['iscompleted']);                
		if($tile_id=="")
		{
			$selectTile_id="select max(tile_id) as tilecount from fn_user_finao_tile";
			$selectTile_idRes=mysql_query($selectTile_id);
			$selectTile_idDet=mysql_fetch_array($selectTile_idRes);
			$tile_id=($selectTile_idDet['tilecount'])+1;
		}
		$sqlInsert="insert into fn_user_finao (userid,finao_msg,finao_status_ispublic,updatedby,finao_status,iscompleted,createddate,updateddate)values('".$userid."','".$finao_msg."','".$finao_status_ispublic."','".$updatedby."','".$finao_status."','".$iscompleted."',NOW(),NOW())";
		mysql_query($sqlInsert);
		$error_log="one";
		$finao_id=mysql_insert_id();	
		
		if($atile_id!="")
		{
			$target_path = $globalpath."images/tiles/";
			$sqlSelectTileData="select tile_profileImagurl,tile_name from  fn_user_finao_tile where tile_id=".$atile_id." and tile_profileImagurl<>''";
			$sqlSelectResTileData=mysql_query($sqlSelectTileData);
			if(mysql_num_rows($sqlSelectResTileData)>0)
			{
				while($sqlSelectDetTileData=mysql_fetch_array($sqlSelectResTileData))
				{
					$tile_profileImagurl=$sqlSelectDetTileData['tile_profileImagurl'];	
                    //$tile_name=$sqlSelectDetTileData['tile_name'];			
                    @move_uploaded_file($target_path.$tile_profileImagurl, $target_path.$tile_profileImagurl);
					$tile_image=$tile_profileImagurl;
				}
			}
            else
		    {
		           $tile_image=$tile_id."-".$_FILES['tile_image']['name'];
		    }
			
		}
		else
		{
		   $tile_image=$tile_id."-".$_FILES['tile_image']['name'];
		}
		$target_path = $globalpath."images/tiles/";
                $target_thumb = $globalpath."images/tiles/thumbs/";
		$upload_path = "images/tiles/";
		if($_FILES['tile_image']['name']!="")
		{
			
			$target_path = $target_path . basename($_FILES['tile_image']['name']); 
                        $target_thumb = $target_thumb . basename($_FILES['tile_image']['name']);
			@move_uploaded_file($_FILES['tile_image']['tmp_name'], $target_path);                        
			$uploadfile_name=basename($_FILES['tile_image']['name']);                        
			$resize = new ResizeImage($target_path);
			$resize->resizeTo(200, 200,'default');
			$resize->saveImage($target_thumb); 
		}

		//if($atile_id=="")
        {
			$sqlInsertFianoTable="insert into fn_user_finao_tile(tile_id,tile_name,userid,finao_id,tile_profileImagurl,status,createddate,createdby,updateddate,updatedby)values('".$tile_id."','".$tile_name."','".$userid."','".$finao_id."','".$tile_image."','1',NOW(),'".$userid."',NOW(),'".$userid."')";
			mysql_query($sqlInsertFianoTable);
			$error_log.="two";
			$sqlSelect="select tilesinfo_id from fn_tilesinfo where tile_id=".$atile_id." and createdby=".$userid." and tilename like '%".$tile_name."%'";
		    $sqlSelectRes=mysql_query($sqlSelect);
			 if(mysql_num_rows($sqlSelectRes)<=0)
      
					
					{
						$error_log.="three";
						$sqlInsertTileInfo="insert into fn_tilesinfo(tile_id,tilename,tile_imageurl,status,createddate,createdby,updateddate,updatedby)values('".$tile_id."','".$tile_name."','".$tile_image."','1',NOW(),'".$userid."',NOW(),'".$userid."')";
						mysql_query($sqlInsertTileInfo);
					}
        }
				$upload_type="34";
                $target_path = $globalpath."images/uploads/finaoimages/";	
                $target_thumb = $globalpath."images/uploads/finaoimages/thumbs/";      
				$target_medium = $globalpath."images/uploads/finaoimages/medium/";
                $upload_path = "/images/uploads/finaoimages";		


                
				if($_FILES['image']['name']!="")
				{
					$upload_type="34";		
					$target_path = $target_path .$finao_id."-". basename($_FILES['image']['name']); 
                    $target_thumb = $target_thumb .$finao_id."-". basename($_FILES['image']['name']); 
					$target_medium = $target_medium .$finao_id."-". basename($_FILES['image']['name']); 
					@copy($_FILES['image']['tmp_name'], $target_path);
					$uploadfile_name=$_FILES['image']['name'];
					$fname=$finao_id."-".basename($_FILES['image']['name']);
				}
				if($_FILES['video']['name']!="")
				{
					$upload_type="35";	
					$target_path = $target_path .$finao_id."-". basename($_FILES['video']['name']); 
					@move_uploaded_file($_FILES['video']['tmp_name'], $target_path);
					$uploadfile_name=$_FILES['video']['name'];
					$video_caption="";
					$video_caption=$caption;
					$caption="";
				}
				$id=$tile_id;
				$user_id=$_REQUEST['user_id'];
				
				$videoid=$_REQUEST['videoid'];
				$videostatus=$_REQUEST['videostatus'];
				$video_img=$_REQUEST['video_img'];
				//$type='tile';
				if($type=='tile')
				{
					$upload_sourcetype=36;
				}
				else
				{
                  $upload_sourcetype=37;
				}
				if($fname=="")
					$upload_path="";
				$sqlInsert="insert into fn_uploaddetails(uploadtype,uploadfile_name,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img,video_caption)values('".$upload_type."','".$fname."','".$upload_path."','".$upload_sourcetype."','".$finao_id."','".$user_id."',NOW(),'1','".$userid."',NOW(),'".addslashes($caption)."','".$videoid."','".$videostatus."','".$video_img."','".$video_caption."')";
				//mysql_query($sqlInsert) or die("Unable to execute query");
				$error_log.="four";

				if($_FILES['image']['name']!="")
				{
					 $resize = new ResizeImage($target_path);
					$resize->resizeTo(100, 100,'default');
					$resize->saveImage($target_thumb); 
						$resize_m = new ResizeImage($target_path);
					$resize_m->resizeTo(400, 400,'default');
					$resize_m->saveImage($target_medium); 

			    }
				
		 $error_log.="five";
        $json = array();
		$json['finao_id']=$finao_id;
 		echo json_encode($json);
}
else if($_REQUEST['json']=='addjournal')
{
//		$json_data=json_decode($_REQUEST['jsondata'],true);
	
	    $finao_id=mysql_real_escape_string($_REQUEST['finao_id']);
$finao_journal=mysql_real_escape_string($_REQUEST['finao_journal']);
$journal_status=mysql_real_escape_string($_REQUEST['journal_status']);
$user_id=mysql_real_escape_string($_REQUEST['user_id']);
$status_value=mysql_real_escape_string($_REQUEST['status_value']);
$createdby=mysql_real_escape_string($_REQUEST['user_id']);
$updatedby=mysql_real_escape_string($_REQUEST['user_id']);

		$sqlInsert="insert into fn_user_finao_journal(finao_id,finao_journal,journal_status,journal_startdate,user_id,status_value,createdby,createddate,updatedby,updateddate)values('".$finao_id."','".$finao_journal."','".$journal_status."',NOW(),'".$user_id."','".$status_value."','".$createdby."',NOW(),'".$updatedby."',NOW())";
		mysql_query($sqlInsert);
$json = array();
		$json['res']=mysql_insert_id();	
 		echo json_encode($json);
}
else if($_REQUEST['json']=='addNotification')
{
	$tracker_userid=$_REQUEST['tracker_userid'];
	$user_id=$_REQUEST['user_id'];
	$tile_id=$_REQUEST['tile_id'];
	$finao_id=$_REQUEST['finao_id'];
	$journal_id=$_REQUEST['journal_id'];
	$notification_action=$_REQUEST['notification_action'];
	$updatedby=$user_id;
	$createdby=$user_id;

	$sqlInsert="insert into fn_trackingnotifications(tracker_userid,tile_id,finao_id,journal_id,notification_action,updateby,updateddate,createdby,createddate)values()";
	mysql_query($sqlInsert) or die("Insert Query Failed");



}
else if($_REQUEST['json']=='addTracker')
{
 $json =array();
	$tracker_userid=$_REQUEST['tracker_userid'];
	$tracked_userid=$_REQUEST['tracked_userid'];
	$tracked_tileid=$_REQUEST['tracked_tileid'];
	$status=$_REQUEST['status'];		
	$sqlSelect="select tracking_id from fn_tracking where tracker_userid=".$tracked_userid." and tracked_userid=".$tracker_userid." and tracked_tileid=".$tracked_tileid;
	$sqlSelectRes=mysql_query($sqlSelect);	
	if(mysql_num_rows($sqlSelectRes)>0)
	{
	   while($sqlSelectDet=mysql_fetch_array($sqlSelectRes))
	   {
		$id=$sqlSelectDet['tracking_id'];	
		$sqlUpdate="delete from fn_tracking where tracker_userid='".$tracked_userid."' and tracked_userid='".$tracker_userid."' and tracker_userid='".$tracked_userid."'" ;
		mysql_query($sqlUpdate) or die("Delete Query Failed");
	   }	
	}
	else
	{
		$status=1;
		$sqlQuery="insert into fn_tracking(tracker_userid,tracked_userid,tracked_tileid,status)values('".$tracked_userid."','".$tracker_userid."','".$tracked_tileid."','".$status."')";
		mysql_query($sqlQuery) or die("Insert Query Failed");
		$id=mysql_insert_id();
	}
	$json['res']=$id;	
	echo json_encode($json);
}
else if($_REQUEST['json']=='updateTracker')
{
 $json =array();
	$tracker_userid=$_REQUEST['tracker_userid'];
	$tracked_userid=$_REQUEST['tracked_userid'];
	$tracked_tileid=$_REQUEST['tracked_tileid'];
        $tracking_id=$_REQUEST['tracking_id'];
	$status=$_REQUEST['status'];
		
	//$sqlUpdate="update fn_tracking set status='".$status."' where tracker_userid='".$tracker_userid."' and tracked_userid='".$tracked_userid."' and tracked_tileid=".$tracked_tileid;
$sqlUpdate="update fn_tracking set status='".$status."' where tracking_id='".$tracking_id."'";

	mysql_query($sqlUpdate) or die("Insert Query Failed");

        $json = array();
	$json['res']="updated";	
	echo json_encode($json);
}
else if($_REQUEST['json']=='addTrackerInfo')
{
 $json =array();
	$tracker_userid=$_REQUEST['tracker_userid'];
	$tracked_userid=$_REQUEST['tracked_userid'];
	$tracked_tileid=$_REQUEST['tracked_tileid'];
	$notification_action=$_REQUEST['notification_action'];	
	$tile_id=$_REQUEST['tile_id'];
	$finao_id=$_REQUEST['finao_id'];
	$journal_id=$_REQUEST['journal_id'];

	$sqlInsert="insert into fn_trackingnotifications(tracker_userid,tile_id,finao_id,journal_id,notification_action,updateby,updateddate,createdby,createddate)values('".$tracker_userid."','".$tile_id."','".$finao_id."','".$journal_id."','".$notification_action."','".$tracked_userid."',NOW(),'".$tracked_userid."',NOW())";
	mysql_query($sqlInsert) or die("Insert Query Failed");
        $json = array();
	$json['res']=mysql_insert_id();	
	echo json_encode($json);
}
else if($_REQUEST['json']=='IamTrackings')
{
 $json =array();
	$tracker_userid=$_REQUEST['tracker_userid'];
	$sqlSelect="select select ft.trackingnotification_id,ft.tracker_userid,ft.tile_id,ft.finao_id,ft.journal_id,fu.uname,fp.profile_image,tile_name from fn_trackingnotifications ft join fn_users fu  join  fn_user_profile fp join fn_user_finao_tile ftl on ft.tile_id=ftl.tile_id and fu.userid=fp.user_id and ft.tracker_userid = fu.userid from fn_trackingnotifications where updateby=".$tracker_userid;
if($_REQUEST['finao_id']!="")
	$sqlSelect.=" and ft.finao_id=".$_REQUEST['finao_id'];
$sqlSelect.=" GROUP BY finao_id";
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{		
     while($sqlSelectUploadDet=mysql_fetch_assoc($sqlSelectRes))
		 {        				
				$rows[] = $sqlSelectUploadDet;         
		 }
	}
	$json = array();
	$json['res']=$rows;
	echo json_encode($json);
}
else if($_REQUEST['json']=='followers')
{
     $json = array();

	 $sqlMyTrackings="select t.fname,t.lname,t.userid, t5.mystory, group_concat(Distinct t4.tilename ORDER BY t4.tilename SEPARATOR ', ') as gptilename, t5.profile_image as image,t1.tracker_userid,t4.tile_id,t1.tracker_userid,t1.tracked_userid,t1.status,t2.finao_msg from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '".$_REQUEST['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
	 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
					 $totalfollowers=mysql_num_rows($sqlMyTrackingsRes);
	 if($totalfollowers>0)
	 {
	   while($sqlMyTrackingsDet=mysql_fetch_assoc($sqlMyTrackingsRes))
	   {
		   $userid=$sqlMyTrackingsDet['userid'];
			$totalfollowers=0;
			$sqlMyTrackingsDet['totalfollowers']=fngetTotalFollowers($userid);
			$totaltiles=0;
			$sqlMyTrackingsDet['totaltiles']=fngetTotalTiles($userid,"search");

			$totaltiles=0;
	$sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =".$userid." AND finao_activestatus !=2 ";	
	
	$sqlTilesCount.=" and `finao_status_Ispublic` =1";	
	$sqlTilesCount.=" GROUP BY tile_id ";
	

	$sqlTilesCountRes=mysql_query($sqlTilesCount);
	$totaltiles=mysql_num_rows($sqlTilesCountRes);    
    $sqlMyTrackingsDet['totaltiles']=$totaltiles;
			$totalfinaos=0;
			$sqlMyTrackingsDet['totalfinaos']=fngetTotalFinaos($userid,"");
			$totalfollowings=0;
			$sqlMyTrackingsDet['totalfollowings']=fngetTotalFollowings($userid);
		   $rows[] = $sqlMyTrackingsDet;         
	   }
	  }
	  $json['res'] = $rows;
	  echo json_encode($json);
}
else if($_REQUEST['json']=='followings')
{
    $json = array();
	 $rows = "";
	 $sqlMyTrackings="select t.fname,t.lname,t.userid, t5.mystory, group_concat(Distinct t4.tilename ORDER BY t4.tilename SEPARATOR ', ') as gptilename, t5.profile_image as image,t1.tracker_userid,t4.tile_id,t1.tracker_userid,t1.tracked_userid,t1.status,t2.finao_msg from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '".$_REQUEST['userid']."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
	 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
	 $totalfollowers=mysql_num_rows($sqlMyTrackingsRes);
	 if($totalfollowers>0)
	 {
	   while($sqlMyTrackingsDet=mysql_fetch_assoc($sqlMyTrackingsRes))
	   {
		$userid=$sqlMyTrackingsDet['userid'];
		$totalfollowers=0;
		$sqlMyTrackingsDet['totalfollowers']=fngetTotalFollowers($userid);
		$totaltiles=0;
		$sqlMyTrackingsDet['totaltiles']=fngetTotalTiles($userid,"search");
		$totaltiles=0;
	$sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =".$userid." AND finao_activestatus !=2 ";	
	
	$sqlTilesCount.=" and `finao_status_Ispublic` =1";	
	$sqlTilesCount.=" GROUP BY tile_id ";
	

	$sqlTilesCountRes=mysql_query($sqlTilesCount);
	$totaltiles=mysql_num_rows($sqlTilesCountRes);    
    $sqlMyTrackingsDet['totaltiles']=$totaltiles;
		$totalfinaos=0;
		$sqlMyTrackingsDet['totalfinaos']=fngetTotalFinaos($userid,"followings");
		$totalfollowings=0;
		$sqlMyTrackingsDet['totalfollowings']=fngetTotalFollowings($userid);
		$rows[] = $sqlMyTrackingsDet;         
	   }
	  }
	  $json['res'] = $rows;
	  echo json_encode($json);
}
else if($_REQUEST['json']=='MyTrackings')
{
 $json =array();
	$tracker_userid=$_REQUEST['tracker_userid'];
	
		$sqlSelect="SELECT t.*, t1.tile_name FROM `fn_tracking` `t`  join fn_user_finao_tile t1 on t.tracked_tileid = t1.tile_id and t.tracker_userid = t1.userid  join fn_user_finao t2 on t1.finao_id = t2.user_finao_id  and finao_activestatus != 2 and finao_status_Ispublic = 1 WHERE  t.tracked_userid = ".$tracker_userid." and t.status = 0 GROUP BY  t1.tile_id, t1.tile_name";
//$sqlSelect.=" AND ft.status=0 GROUP BY tracking_id";
	if($_REQUEST['finao_id']!="")
	$sqlSelect.=" and t.finao_id=".$_REQUEST['finao_id'];

	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{		
     while($sqlSelectUploadDet=mysql_fetch_assoc($sqlSelectRes))
		 {        		
$sqlSelectUploadDet['profile_image']="";
$sqlSelectUploadDet['uname']="";
				$sqlSelectProf="select concat(fname,' ',lname) as uname,fu.profile_image from fn_user_profile fu right join fn_users f on fu.user_id=f.userid where f.userid=".$sqlSelectUploadDet['tracker_userid'];
         	                $sqlSelectProfRes=mysql_query($sqlSelectProf);
				if(mysql_num_rows($sqlSelectProfRes)>0)
				{		
				     while($sqlSelectProfDet=mysql_fetch_assoc($sqlSelectProfRes))
					 {        				
						$sqlSelectUploadDet['profile_image']=$sqlSelectProfDet['profile_image'];
						$sqlSelectUploadDet['uname']=$sqlSelectProfDet['uname'];
					 }
				}		
				$rows[] = $sqlSelectUploadDet;         
		 }
	}
	$json = array();
	$json['res']=$rows;
	echo json_encode($json);
}
else if($_REQUEST['json']=='IamTracking')
{
 $json =array();
	$updateby=$_REQUEST['updateby'];
	
	$sqlSelect="select * from fn_trackingnotifications where updateby=".$updateby;
	if($_REQUEST['finao_id']!="")
	$sqlSelect.=" and finao_id=".$_REQUEST['finao_id'];
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{		
     while($sqlSelectUploadDet=mysql_fetch_assoc($sqlSelectRes))
		 {        				
				$rows[] = $sqlSelectUploadDet;         
		 }
	}
        $json = array();
	$json['res']=$rows;
	echo json_encode($json);
}
else if($_REQUEST['json']=='ListTrackerUsingFiano')
{
 $json =array();
	$tracker_userid=$_REQUEST['tracker_userid'];
	$notification_action=$_REQUEST['notification_action'];
	$tile_id=$_REQUEST['tile_id'];
	$finao_id=$_REQUEST['finao_id'];
	$status=$_REQUEST['status'];
        $sqlSelect="select * from fn_trackingnotifications where trackingnotification_id<>''";
	if($finao_id!="")
	$sqlSelect.="and finao_id=".$finao_id;
        if($tile_id!="")
	$sqlSelect.="and tile_id=".$tile_id;
	$sqlSelectRes=mysql_query($sqlSelect);
	while($det=mysql_fetch_assoc($sqlSelectRes))
	{
		$json['res'][]=$det;	
	}
	echo json_encode($json);
}
else if($_REQUEST['json']=='modifyjournal')
{
 $json =array();
//		$json_data=json_decode($_REQUEST['jsondata'],true);
	
	    $finao_journal_id=mysql_real_escape_string($_REQUEST['finao_journal_id']);
		$finao_journal=mysql_real_escape_string($_REQUEST['finao_journal']);
		$journal_status=mysql_real_escape_string($_REQUEST['journal_status']);
		$user_id=mysql_real_escape_string($_REQUEST['user_id']);
		$status_value=mysql_real_escape_string($_REQUEST['status_value']);		
		$updatedby=mysql_real_escape_string($_REQUEST['user_id']);

		$sqlInsert="update fn_user_finao_journal set finao_journal='".$finao_journal."',journal_status='".$journal_status."',status_value='".$status_value."',updatedby='".$user_id."',updateddate=NOW() where finao_journal_id='".$finao_journal_id."'";


		mysql_query($sqlInsert);
		$json['res']="ok";	
 		echo json_encode($json);
}
else if($_REQUEST['json']=='modifyfiano')
{

 $json =array();
		$finao_id=mysql_real_escape_string($_REQUEST['finao_id']);
		$userid=mysql_real_escape_string($_REQUEST['user_id']);
		$finao_msg=mysql_real_escape_string($_REQUEST['finao_msg']);
		$finao_status_ispublic=mysql_real_escape_string($_REQUEST['finao_status_ispublic']);
		$updatedby=mysql_real_escape_string($_REQUEST['updatedby']);
		$finao_status=mysql_real_escape_string($_REQUEST['finao_status']);
		if($finao_status==1)
		$finao_status=38;
		$iscompleted=mysql_real_escape_string($_REQUEST['iscompleted']);
		$sqlUpdate="update fn_user_finao set finao_status_ispublic='".$finao_status_ispublic."',updateddate=NOW(),updatedby='".$updatedby."',finao_status='".$finao_status."',iscompleted='".$iscompleted."' where user_finao_id='".$finao_id."'";
        //echo $sqlUpdate;
		mysql_query($sqlUpdate) or die("Update Query Failed");
		$json['res']="OK";	
 		echo json_encode($json);
}
else if($_REQUEST['json']=='changefinao')
{
		$json =array();
		$finao_id=mysql_real_escape_string($_REQUEST['finao_id']);
		$user_id=mysql_real_escape_string($_REQUEST['user_id']);
		$finao_msg=mysql_real_escape_string($_REQUEST['finao_msg']);

		$sqlUpdate="update fn_user_finao set finao_msg='".$finao_msg."' where user_finao_id='".$finao_id."'";
		mysql_query($sqlUpdate) or die("Update Query Failed");

		$upload_type="34";
		$target_path = $globalpath."images/uploads/finaoimages";	
		$target_thumb = $globalpath."images/uploads/finaoimages/thumbs";      
		$upload_path = "/images/uploads/finaoimages";				
		//if($_FILES['image']['name']!="")
		{
			$upload_type="34";		
			$target_path = $target_path .$finao_id."-". basename($_FILES['image']['name']); 
			$target_thumb = $target_thumb .$finao_id."-". basename($_FILES['image']['name']); 
			@move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
			$uploadfile_name=$_FILES['image']['name'];
			$resize = new ResizeImage($target_path);
			$resize->resizeTo(100, 100,'default');
			$resize->saveImage($target_thumb); 
			$sqlUpdate="update fn_uploaddetails set uploadfile_name='".$finao_id."-".basename($_FILES['image']['name'])."',updatedby='".$user_id."',updateddate=NOW() where upload_sourceid=".$finao_id." and uploadedby=".$user_id." and (uploadtype=34 or uploadtype=62) and upload_sourcetype=37";
			mysql_query($sqlUpdate) or die("Update Query Failed");
		}
		$json['res']="OK".$sqlUpdate;	
 		echo json_encode($json);
}
else if($_REQUEST['json']=='editprofile')
{
$json=array();

$user_profile_msg=$_REQUEST['user_profile_msg'];
$user_location=$_REQUEST['user_location'];
$profile_image=$_REQUEST['profile_image'];
$profile_bg_image=$_REQUEST['profile_bg_image'];
$profile_status_Ispublic=$_REQUEST['profile_status_Ispublic'];
$updatedby=$_REQUEST['updatedby'];
$mystory=$_REQUEST['mystory'];
$iscompleted=$_REQUEST['Iscompleted'];
$user_id=$_REQUEST['user_id'];


$target_path = @"../../finaonation/images/uploads/profileimages/";
$target_thumb = @"../../finaonation/images/uploads/profileimages/thumbs/";
$upload_path = "images/uploads/profileimages/";
if($_FILES['profile_image']['name']!="")
{
    $target_path = $target_path . basename($_FILES['profile_image']['name']); 
    $target_thumb = $target_thumb . basename($_FILES['profile_image']['name']);
    @move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path);
    $profile_image=$_FILES['profile_image']['name'];
	
	$resize = new ResizeImage($target_path);
	$resize->resizeTo(200, 200,'default');
	$resize->saveImage($target_path); 

	$resize1 = new ResizeImage($target_path);
	$resize1->resizeTo(120, 90,'default');
	$resize1->saveImage($target_thumb); 
}
if($_FILES['profile_bg_image']['name']!="")
{
$target_path = $target_path . basename($_FILES['profile_bg_image']['name']); 
@move_uploaded_file($_FILES['profile_bg_image']['tmp_name'], $target_path);
$profile_bg_image=$_FILES['profile_bg_image']['name'];
}
$selectUpdateProfile="select * from fn_user_profile where user_id='".$_REQUEST['user_id']."'";
$selectUpdateProfileRes=mysql_query($selectUpdateProfile);
if(mysql_num_rows($selectUpdateProfileRes)>0)
	{

$sqlUpdateProfile="update fn_user_profile set user_location='".$user_location."' ";
if($_FILES['profile_image']['name']!="")
{
	$sqlUpdateProfile.=",profile_image='".$profile_image."'";
}
$sqlUpdateProfile.=",updatedby='".$updatedby."',updateddate=NOW(),mystory='".$mystory."' where user_id='".$_REQUEST['user_id']."'";
mysql_query($sqlUpdateProfile);
	}
	else
	{
$sqlInsertProfile="insert into fn_user_profile(user_id,createdby,updatedby,user_profile_msg,user_location,profile_image,profile_bg_image,profile_status_Ispublic,updateddate,mystory,IsCompleted)values('".$_REQUEST['user_id']."','".$_REQUEST['user_id']."','".$_REQUEST['user_id']."','".$user_profile_msg."','".$user_location."','".$profile_image."','".$profile_bg_image."','".$profile_status_Ispublic."',NOW(),'".$mystory."','".$iscompleted."')";

mysql_query($sqlInsertProfile);
	}
//echo $sqlUpdateProfile;
	$email=$_REQUEST['email'];
	$user_id=$_REQUEST['user_id'];
	$secondary_email=$_REQUEST['secondary_email'];
	$fname=$_REQUEST['fname'];
	$lname=$_REQUEST['lname'];
	$gender=$_REQUEST['gender'];
	$location=$_REQUEST['location'];
	$dob=$_REQUEST['dob'];
	$age=$_REQUEST['age'];
	$socialnetwork=$_REQUEST['socialnetwork'];
	$socialnetworkid=$_REQUEST['socialnetworkid'];
	$usertypeid=$_REQUEST['usertypeid'];
	$status=$_REQUEST['status'];
	$zipcode=$_REQUEST['zipcode'];
	$uname=$_REQUEST['uname'];
	$json['res']="OK";
	$sqlSelect="select * from fn_users where email='".$email."'";
	
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{		
        
			$sqlUpdateUserdata="update fn_users set uname='".$uname."',";
			//if($email!="")
			//$sqlUpdateUserdata.=",email='".$email."',";			
			$sqlUpdateUserdata.="fname='".$fname."',lname='".$lname."',location='".$location."',updatedby='".$updatedby."',updatedate=NOW() where userid='".$user_id."'";		
//echo $sqlUpdateUserdata;
			mysql_query($sqlUpdateUserdata);
		
	}
	else
	{
		$json['res']="Email has already been in use";
	}

	

 	echo json_encode($json);
}
elseif($_REQUEST['json']=='uploadvideoorimage_old')
{
  $json =array();
	$target_path = $globalpath."images/uploads/finaoimages";	
        $upload_path = "images/uploads/finaoimages";

	if($_FILES['image']['name']!="")
	{
		$upload_type="34";		
		$target_path = $target_path .$id."-". basename($_FILES['image']['name']); 
		@move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
		$uploadfile_name=basename($_FILES['image']['name']);
	}
	if($_FILES['video']['name']!="")
	{
		$upload_type="35";	
		$target_path = $target_path .$id."-". basename($_FILES['video']['name']); 
		@move_uploaded_file($_FILES['video']['tmp_name'], $target_path);
	
	

set_time_limit(0);
	include 'phpviddler.php';
	$v            = new Viddler_V2('1mn4s66e3c44f11rx1xd');
	$auth         = $v->viddler_users_auth(array('user'=>'nageshvenkata','password'=>'V1d30Pl@y3r'));
	$session_id   = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;
	$response = $v->viddler_videos_prepareUpload(array('sessionid' => $session_id));
	$endpoint = (isset($response['upload']['endpoint'])) ? $response['upload']['endpoint'] : NULL;
	$token    = (isset($response['upload']['token'])) ? $response['upload']['token'] : NULL;
	$query          =   array(
	  'uploadtoken' =>  $token,
	  'title'       =>  'Video from iphone App',
	  'description' =>  'Video from iphone App',
	  'tags'        =>  'testing,upload',
	  'file'        =>  '@../../finaonation/images/uploads/finaoimages/'.$id."-". basename($_FILES['video']['name'])
	);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $endpoint);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_NOBODY, FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 0);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
	$response     = curl_exec($ch);
	$info         = curl_getinfo($ch);
	$header_size  = $info['header_size'];
	$header       = substr($response, 0, $header_size);
	$video        = unserialize(substr($response, $header_size));
      
	curl_close($ch);
 
        @unlink('../../finaonation/images/uploads/finaoimages/'.$_FILES['video']['name']);
	

         
	$videoid=$video['video']['id'];
	$videostatus=$_REQUEST['videostatus'];
	$video_img=$video['video']['thumbnail_url'];
	}
	$id=$_REQUEST['id'];
	$user_id=$_REQUEST['user_id'];
	$caption=$_REQUEST['caption'];
	$type=$_REQUEST['type'];
	if($type=='fiano')
	{
		$upload_sourcetype=37;
	}
	else if($type=='journal')
	{
		$upload_sourcetype=46;
	}	
	else if($type=='tile')
	{
		$upload_sourcetype=36;
	}
	
	if($_FILES['video']['name']!="")
	{
	
		$target_path = ""; 
	}
	$sqlInsert="insert into fn_uploaddetails(uploadtype,uploadfile_name,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img)values('".$upload_type."','".$uploadfile_name."','".$upload_path."','".$upload_sourcetype."','".$id."','".$user_id."',NOW(),'1','".$user_id."',NOW(),'".$caption."','".$videoid."','".$videostatus."','".$video_img."')";
	mysql_query($sqlInsert);
}
elseif($_REQUEST['json']=='uploadvideoorimage')
{
    $json =array();
    $upload_text=mysql_real_escape_string($_REQUEST['upload_text']);
	 $id=$_REQUEST['id'];
    $target_path = $globalpath."images/uploads/finaoimages/";
    $target_thumb = $globalpath."images/uploads/finaoimages/thumbs/";
	$target_medium = $globalpath."images/uploads/finaoimages/medium/";
    $upload_path = "/images/uploads/finaoimages";
	$caption=mysql_real_escape_string($_REQUEST['caption']);
	if($_FILES['image']['name']!="")
	{
		$upload_type="34";		
		$target_path = $target_path .$id."-". basename($_FILES['image']['name']); 
		$target_thumb = $target_thumb .$id."-". basename($_FILES['image']['name']); 
		$target_medium= $target_medium .$id."-". basename($_FILES['image']['name']); 
		@move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
		$uploadfile_name=$id."-".basename($_FILES['image']['name']);
		
		$resize = new ResizeImage($target_path);
		$resize->resizeTo(100, 100,'default');
		$resize->saveImage($target_thumb); 			

		$resize_m = new ResizeImage($target_path);
		$resize_m->resizeTo(240, 240,'default');
		$resize_m->saveImage($target_medium); 
	}
	if($_FILES['video']['name']!="")
	{
		$upload_type="35";	
		$target_path = $target_path .$id."-". basename($_FILES['video']['name']); 
		@move_uploaded_file($_FILES['video']['tmp_name'], $target_path);
		set_time_limit(0);
		include 'phpviddler.php';
		$v            = new Viddler_V2('1mn4s66e3c44f11rx1xd');
		$auth         = $v->viddler_users_auth(array('user'=>'nageshvenkata','password'=>'V1d30Pl@y3r'));
		$session_id   = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;
		$response = $v->viddler_videos_prepareUpload(array('sessionid' => $session_id));
		$endpoint = (isset($response['upload']['endpoint'])) ? $response['upload']['endpoint'] : NULL;
		$token    = (isset($response['upload']['token'])) ? $response['upload']['token'] : NULL;
		$query          =   array(
								'uploadtoken' =>  $token,
								'title'       =>  'Video from iphone App',
								'description' =>  'Video from iphone App',
								'tags'        =>  'testing,upload',
							    'file'        =>  '@../../finaonation/images/uploads/finaoimages/'.$id."-". basename($_FILES['video']['name'])
		);	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		$response     = curl_exec($ch);
		$info         = curl_getinfo($ch);
		$header_size  = $info['header_size'];
		$header       = substr($response, 0, $header_size);
		$video        = unserialize(substr($response, $header_size));      
		curl_close($ch);
        @unlink('../../finaonation/images/uploads/finaoimages/'.$id."-".$_FILES['video']['name']);
		$videoid=$video['video']['id'];
		$videostatus=$_REQUEST['videostatus'];
		$video_img=$video['video']['thumbnail_url'];
		
		$video_caption="";
		$video_caption=$caption;
		$caption="";
	}
	$id=$_REQUEST['id'];
	$user_id=$_REQUEST['user_id'];
	
	$type=$_REQUEST['type'];
        if(trim($upload_text)!="")
	{
		$upload_type="62";
	}
	if($type=='fiano')
	{
		$upload_sourcetype=37;
	}
	else if($type=='journal')
	{
		//$upload_sourcetype=46;
	}	
	else if($type=='tile')
	{
		$upload_sourcetype=36;
	}
	if($_FILES['video']['name']!="")
	{
	
		$target_path = ""; 
	}
	if($_FILES['video']['name']=="" && $_FILES['image']['name']=="" && $upload_text!="")
	{
	
		$upload_path = ""; 
	}
			if($user_id=="")
	        {
				if($id!="" && $type=='fiano')
				{
					$sqlSelect="SELECT userid FROM  `fn_user_finao` where user_finao_id=".$id;
					$sqlSelectRes=mysql_query($sqlSelect);
					if(mysql_num_rows($sqlSelectRes)>0)
					{
						$sqlSelectDet=mysql_fetch_array($sqlSelectRes);
						$user_id=$sqlSelectDet['userid'];
					}
				}
			}
	$sqlInsert="insert into fn_uploaddetails(uploadtype,uploadfile_name,upload_text,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img,video_caption)values('".$upload_type."','".$uploadfile_name."','".addslashes($upload_text)."','".$upload_path."','".$upload_sourcetype."','".$id."','".$user_id."',NOW(),'1','".$user_id."',NOW(),'".trim($caption)."','".$videoid."','".$videostatus."','".$video_img."','".$video_caption."')";
	mysql_query($sqlInsert);
	if($type=='fiano')
	{
		if($id!="")
		{
			$sqlUpdate="update fn_user_finao set updateddate=NOW(),updatedby=".$user_id." where user_finao_id=".$id;
			mysql_query($sqlUpdate);
		}
	}
}

elseif($_REQUEST['json']=='getimageorvideo')
{
    $json =array();
	$type=$_REQUEST['type'];//Image/Video	
	$srctype=$_REQUEST['srctype'];//tile/finao/journal
	$srcid=$_REQUEST['srcid'];
	$user_id=$_REQUEST['user_id'];
	set_time_limit(0);
    include 'phpviddler.php';
    $v            = new Viddler_V2('1mn4s66e3c44f11rx1xd');
    $auth         = $v->viddler_users_auth(array('user'=>'nageshvenkata','password'=>'V1d30Pl@y3r'));
    $session_id   = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;
	$sqlSelect="select * from fn_lookups where lookup_type='uploadtype' and Lower(lookup_name)='".strtolower($type)."'";
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{		
      while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
		 {
			$lookup_id=$sqlSelectDet['lookup_id'];
		 }
	}
	$sqlSelectSrctype="select * from fn_lookups where lookup_type='uploadsourcetype' and Lower(lookup_name)='".strtolower($srctype)."'";
	$sqlSelectSrctypeRes=mysql_query($sqlSelectSrctype);
	if(mysql_num_rows($sqlSelectSrctypeRes)>0)
	{		
      while($sqlSelectSrctypeDet=mysql_fetch_assoc($sqlSelectSrctypeRes))
		 {
			$srclookup_id=$sqlSelectSrctypeDet['lookup_id'];
		 }
	}
        if($type=='Image')
        {
			$sqlSelectUpload="select * from fn_uploaddetails where  upload_sourcetype='".strtolower($srclookup_id)."' and (uploadtype='34'  or uploadtype='62') ";
			if($srcid!="")
			$sqlSelectUpload.=" and upload_sourceid='".$srcid."'";	
			$sqlSelectUpload.=" and uploadedby='".$user_id."'  order by uploaddetail_id DESC";
        }
		else
		{
			$sqlSelectUpload="select * from fn_uploaddetails where  upload_sourcetype='".strtolower($srclookup_id)."' and (uploadtype='35' or uploadtype='62')";
			if($srcid!="")
			$sqlSelectUpload.=" and upload_sourceid='".$srcid."'";
			$sqlSelectUpload.=" and uploadedby='".$user_id."'  order by uploaddetail_id DESC";
		}

		$sqlSelectVideoRes=mysql_query($sqlSelectUpload);
		if(mysql_num_rows($sqlSelectVideoRes)>0)
		{		
		while($sqlSelectVideoDet=mysql_fetch_assoc($sqlSelectVideoRes))
				{       

				if(!empty($sqlSelectVideoDet['videoid']))
					{

						//$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=".$session_id."&key=1mn4s66e3c44f11rx1xd&video_id=".$sqlSelectVideoDet['videoid']);
                         $videosource =curl_file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=".$session_id."&key=1mn4s66e3c44f11rx1xd&video_id=".$sqlSelectVideoDet['videoid']);

						
						$video=json_decode(unserialize($videosource),true);
						$sqlSelectVideoDet['videofrom']="";
					
						foreach($video['video']['files'] as $k=>$v)
                                                {  

                                                   if($v['html5_video_source']!="")
                      	                           $sqlSelectVideoDet['videosource']=$v['html5_video_source'];
                                                }
                        $rows[] = (unstrip_array($sqlSelectVideoDet));
					}
					else
					{			

 					  $str=str_replace("/default.jpg","",$sqlSelectVideoDet['video_img']);
 					  $str=str_replace("http://img.youtube.com/vi/","",$str);
					  $sqlSelectVideoDet['video_embedurl']="";
					  $sqlSelectVideoDet['videofrom']="youtube";		
					  if($str!="")
					  $str="http://www.youtube.com/embed/".$str;
					  $sqlSelectVideoDet['videosource']=$str;
					  $rows[] = (unstrip_array($sqlSelectVideoDet));
					}					
					
				}
	}
       $json =array();
	$json['res']=$rows;

 	echo json_encode($json);
}
else if($_REQUEST['json']=='getuser_finaocounts')
{	
	$userid=$_REQUEST['userid'];
	$actual_user_id=$_REQUEST['actual_user_id'];

	$totalfollowers=0;
	$rows['totalfollowers']=fngetTotalFollowers($userid);
	$totaltiles=0;
	$rows['totaltiles']=fngetTotalTiles_counts($userid,$actual_user_id);

	$totaltiles=0;
				 $sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$userid."' AND Iscompleted =0 AND finao_activestatus !=2  GROUP BY tile_id";
				 //
				 $sqlTilesCountRes=mysql_query($sqlTilesCount);
				 $rows['totaltiles']=mysql_num_rows($sqlTilesCountRes);
				 $rows['totaltiles']=fngetTotalTiles_counts($userid,$actual_user_id);
	$totalfinaos=0;
	$rows['totalfinaos']=fngetTotalFinaos($userid,$actual_user_id);
	$totalfollowings=0;
	$rows['totalfollowings']=fngetTotalFollowings($userid);
    $json =array();
	$json['res']=$rows;
 	echo json_encode($json);
}else if($_REQUEST['json']=='homepage_user'){
	$userid = $_REQUEST['userid'];
	$data = getHomePageDetailsByUser($userid);
	echo $data;
}else if($_REQUEST['json']=='finao_list'){
	$myid = $_REQUEST['userid'];
	$type = $_REQUEST['type'];
	$otherid = 0;
	if($type == 1)
		$otherid = $_REQUEST['otherid'];
	
	$data = getFinaoList($type, $myid, $otherid);
	
	echo $data;
}else if($_REQUEST['json']=='finaodetails'){
	$userid = $_REQUEST['userid'];
	$finaoid = $_REQUEST['finaoid'];
	$data = getFinaoDetails($userid, $finaoid);
	echo $data;
}else if($_REQUEST['json']=='uploadimagesfinao'){
	$userid = $_POST['userid'];
	$finaoid = $_POST['finaoid'];
	$type = $_POST['type'];	// finao or tile
	$uploadtext = $_POST['upload_text'];
	
	if($type==1){
		$sourcetype = 37;
	}else{
		$sourcetype = 36;
	}
	
	$captions = json_decode($_POST['captiondata']);
	if($_FILES['video']['name']!=''){
		$uploadtype = 35;
	}else if($_FILES['image1']['name']!=''){
		$uploadtype = 34;
	}

	if(empty($_FILES) && !empty($uploadtext)){
		$uploadtype = 62;
		uploaddata($uploadtype, $sourcetype, $finaoid, $userid, $uploadtext);
	}else if(!empty($_FILES) && !empty($uploadtext)){
		uploaddata($uploadtype, $sourcetype, $finaoid, $userid, $uploadtext, $_FILES, $captions);
	}else if(!empty($_FILES) && empty($uploadtext)){
		uploaddata($uploadtype, $sourcetype, $finaoid, $userid, NULL, $_FILES, $captions);
	}
	
	print_r($captions);
	print_r($_FILES);
	echo "success";
}else if($_REQUEST['json']=='changefinaostatus')
{
	$json =array();
	$type = mysql_real_escape_string($_POST['type']);	// 1=public/private status, 2=finaostatus, 3=completedstatus
	$userid=mysql_real_escape_string($_POST['userid']);
	$finao_id=mysql_real_escape_string($_POST['finaoid']);
	
	// getting data
	//$finaoquery = mysql_query("select userid from fn_user_finao where ");
	if($type==1){
		$finao_status_ispublic=mysql_real_escape_string($_POST['status']);
		$query="update fn_user_finao set finao_status_ispublic='".$finao_status_ispublic."', updateddate=NOW() where user_finao_id='".$finao_id."' AND userid=$userid limit 1";
	}else if($type==2){
		$finaostatus=mysql_real_escape_string($_POST['status']);
		if($finaostatus==1)
			$query="update fn_user_finao set finao_status='".$finaostatus."', Iscompleted=1, updateddate=NOW() where user_finao_id='".$finao_id."' AND userid=$userid limit 1";	
		else	
			$query="update fn_user_finao set finao_status='".$finaostatus."', updateddate=NOW() where user_finao_id='".$finao_id."' AND userid=$userid limit 1";	
	}
	
	// updating query
	if(mysql_query($query)>0){
		$json['status']="success";
	}else{
		$json['status']="fail";
	}
	echo json_encode($json);
}else if($_REQUEST['json']=='registration'){
	$json = array();
	$type=$_POST['type'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
    
	$target_path = $globalpath."images/uploads/profileimages/";
	
	// 1-normal registration, 2-facebook registration
    if($type==1){
		$sqlSelect=mysql_query("select userid from fn_users where email='".$email."' limit 1");
		if(mysql_num_rows($sqlSelect)==0){
			//$proxy = new SoapClient($soap_url); // TODO : change url
            //$sessionId = $proxy->login($soapusername, $soappassword);				
            //$mageid = $proxy->call($sessionId, 'customer.create', array(array('email' => $email, 'firstname' => $fname, 'lastname' => $lname, 'password' => $password, 'website_id' => 1, 'store_id' => 1, 'group_id' => 1)));
            $mageid = 77777;
			$sqlInsert = "insert into fn_users(password,email,fname,lname,usertypeid,status,createtime,mageid) 
            				values ('".$password."','".$email."','".$fname."','".$lname."',64,1,NOW(),'".$mageid."')";
            
            mysql_query($sqlInsert);
            $insert_id=mysql_insert_id();
			
			if(!empty($_FILES['profilepic']['name'])){
				$uploadfile_name = $insert_id."-".$_FILES['profilepic']['name'];
				$tmpname = $_FILES['profilepic']['tmp_name'];	
				$target_main = $target_path.$uploadfile_name ; 
				
				move_uploaded_file($tmpname,$target_main);
				// updating user profile			
				$sqlProfileImage = "insert into fn_user_profile (user_id, profile_image, createdby, createddate, updatedby, updateddate, temp_profile_image) values ($insert_id, '$uploadfile_name', $insert_id, NOW(), $insert_id, NOW(), '$uploadfile_name')";
				mysql_query($sqlProfileImage);
			}else{
				$sqlProfileImage = "insert into fn_user_profile (user_id, createdby, createddate, updatedby, updateddate) values ($insert_id, $insert_id, NOW(), $insert_id, NOW())";
				mysql_query($sqlProfileImage);
			}
				
            $ch = curl_init("http://www.aweber.com/scripts/addlead.pl");				
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Expect:'));               
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, FALSE);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  "from=".$email."&name=".$email."&meta_web_form_id=848580469&meta_split_id=&unit=friendlies&redirect=http://www.aweber.com/form/thankyou_vo.html&meta_redirect_onlist=&meta_adtracking=&meta_message=1&meta_required=from&meta_forward_vars=0?");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            $result = @curl_exec($ch);
            
            $json = array();
			$json['status'] = "success";
            $json['res'] = $insert_id;
        }else{
			$obj = mysql_fetch_object($sqlSelect);
			$json['status'] = "User already registered";
            $json['res'] = $obj->userid;
		}
    }else{
    	$gender=$_POST['gender'];
        $fid = $_POST['facebookid'];
		$sqlSelect=mysql_query("select userid, socialnetworkid from fn_users where email='".$email."' limit 1");
        if(mysql_num_rows($sqlSelect)>0){
        	$obj = mysql_fetch_object($sqlSelect);
            if($obj->socialnetworkid==NULL){
            	// map the facebookid and return userid
                $sqlUpdate = "update fn_users set socialnetwork='facebook', socialnetworkid='$fid' where userid='$obj->userid' limit 1";
            	mysql_query($sqlUpdate);
            }
			$json['status'] = "User already registered";
            $json['res'] = $obj->userid;
        }else{
        	//$proxy = new SoapClient($soap_url); // TODO : change url
            //$sessionId = $proxy->login($soapusername, $soappassword);				
            //$mageid = $proxy->call($sessionId, 'customer.create', array(array('email' => $email, 'firstname' => $fname, 'lastname' => $lname, 'password' => $password, 'website_id' => 1, 'store_id' => 1, 'group_id' => 1)));
            $mageid = 77777;
			$genval = 2;
			if($gender=='male')
				$genval = 4;
					
			$sqlInsert = "insert into fn_users(email,fname,lname,gender,usertypeid,status,createtime,mageid, socialnetwork, socialnetworkid) 
            				values ('".$email."','".$fname."','".$lname."','".$genval."',64,1,NOW(),'".$mageid."','facebook','$fid')";
			mysql_query($sqlInsert);
            $insert_id=mysql_insert_id();
            
			$sqlProfileImage = "insert into fn_user_profile (user_id, createdby, createddate, updatedby, updateddate) values ($insert_id, $insert_id, NOW(), $insert_id, NOW())";
			mysql_query($sqlProfileImage);
				
			$ch = curl_init("http://www.aweber.com/scripts/addlead.pl");				
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Expect:'));               
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, FALSE);
            curl_setopt($ch, CURLOPT_POSTFIELDS,  "from=".$email."&name=".$email."&meta_web_form_id=848580469&meta_split_id=&unit=friendlies&redirect=http://www.aweber.com/form/thankyou_vo.html&meta_redirect_onlist=&meta_adtracking=&meta_message=1&meta_required=from&meta_forward_vars=0?");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            $result = @curl_exec($ch);
            
            $json = array();
			$json['status'] = "success";
            $json['res'] = $insert_id;
        }
    }
    
 	echo json_encode($json);
}else if($_REQUEST['json']=='login'){
	echo $_SERVER['PHP_AUTH_USER'];
	echo $_SERVER['PHP_AUTH_PW'];
	//echo json_encode($json);
}

function getImageOrVideodetails($type,$srctype,$srcid,$user_id)
{
/*	$type=$_REQUEST['type'];//Image/Video	
	$srctype=$_REQUEST['srctype'];//tile/finao/journal
	$srcid=$_REQUEST['srcid'];
	$user_id=$_REQUEST['user_id'];
	*/

	$sqlSelect="select * from fn_lookups where lookup_type='uploadtype' and Lower(lookup_name)='".strtolower($type)."'";
	$sqlSelectRes=mysql_query($sqlSelect);
	if(mysql_num_rows($sqlSelectRes)>0)
	{		
      while($sqlSelectDet=mysql_fetch_assoc($sqlSelectRes))
		 {
			$lookup_id=$sqlSelectDet['lookup_id'];
		 }
	}
	$sqlSelectSrctype="select * from fn_lookups where lookup_type='uploadsourcetype' and Lower(lookup_name)='".strtolower($srctype)."'";
	$sqlSelectSrctypeRes=mysql_query($sqlSelectSrctype);
	if(mysql_num_rows($sqlSelectSrctypeRes)>0)
	{		
      while($sqlSelectSrctypeDet=mysql_fetch_assoc($sqlSelectSrctypeRes))
		 {
			$srclookup_id=$sqlSelectSrctypeDet['lookup_id'];
		 }
	}

	$sqlSelectUpload="select * from fn_uploaddetails where uploadtype='".$lookup_id."' and upload_sourcetype='".strtolower($srclookup_id)."' and upload_sourceid='".$srcid."' and uploadedby='".$user_id."'";

	$sqlSelectUploadRes=mysql_query($sqlSelectUpload);
	if(mysql_num_rows($sqlSelectUploadRes)>0)
	{		
     while($sqlSelectUploadDet=mysql_fetch_assoc($sqlSelectUploadRes))
		 {        				
				$rows[] = unstrip_array($sqlSelectUploadDet);         
		 }
	}

	
	 return $rows;
}
function stripslashes_deep($value)
{
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);

    return $value;
}
function unstrip_array($array){
	foreach($array as &$val){
		if(is_array($val)){
			$val = unstrip_array($val);
		}else{
			$val = stripslashes($val);
		}
	}
return $array;
}
mysql_close();
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
function curl_file_get_contents($url)
{
 $curl = curl_init();
 $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
 
 curl_setopt($curl,CURLOPT_URL,$url); //The URL to fetch. This can also be set when initializing a session with curl_init().
 curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
 curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5); //The number of seconds to wait while trying to connect.	
 
 curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
 curl_setopt($curl, CURLOPT_FAILONERROR, TRUE); //To fail silently if the HTTP code returned is greater than or equal to 400.
 curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
 curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
 curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.	
 
 $contents = curl_exec($curl);
 curl_close($curl);
 return $contents;
}

function fngetTotalFollowings($userid)
{
	 $totalfollowings=0;
	 $sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '".$userid."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
	 $sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
	 $totalfollowings=mysql_num_rows($sqlMyTrackingsRes);
	 return $totalfollowings;
}
function fngetTotalFinaos($userid,$actual_user_id)
{
	$totalfinaos=0;
	$sqlFianosCount="SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid ='".$userid."' AND f.finao_activestatus =1 and finao_status_Ispublic = 1";
	$sqlFinaosCount="SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid ='".$userid."' AND f.finao_activestatus =1";
	if($actual_user_id=="")
	$sqlFinaosCount.=" and Iscompleted =0";	
	if($actual_user_id!="")
	$sqlFinaosCount.=" and `finao_status_Ispublic` =1";	
	 
	if($actual_user_id=="search")
	$sqlFinaosCount.=" and `finao_status_Ispublic` =1 ";	
	
	$sqlSelectCountRes=mysql_query($sqlFinaosCount);

//	echo $sqlFinaosCount;

	$totalfinaos=mysql_num_rows($sqlSelectCountRes);
	return $totalfinaos;
}
function fngetTotalTiles($userid,$actual_user_id)
{
	$totaltiles=0;
	$sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$userid."' AND finao_activestatus !=2 ";
	if($actual_user_id!="")
	$sqlTilesCount.=" and Iscompleted =0 ";	
	if($actual_user_id!="")
	$actual_user_id.=" and `finao_status_Ispublic` =1";
	if($actual_user_id=="search")
	$sqlTilesCount.=" and `finao_status_Ispublic` =1 ";	
	$sqlTilesCount.=" GROUP BY tile_id ";

	$sqlTilesCountRes=mysql_query($sqlTilesCount);
	$totaltiles=mysql_num_rows($sqlTilesCountRes);    
	return $totaltiles;
}
function fngetTotalTiles_counts($userid,$actual_user_id)
{
	$totaltiles=0;
	$sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$userid."' AND finao_activestatus !=2 ";
	//if($actual_user_id!="")
	$sqlTilesCount.=" and Iscompleted =0 ";	
	if($actual_user_id!="")
	$sqlTilesCount.=" and `finao_status_Ispublic` =1";	
	$sqlTilesCount.=" GROUP BY tile_id ";
	

	$sqlTilesCountRes=mysql_query($sqlTilesCount);
	$totaltiles=mysql_num_rows($sqlTilesCountRes);    
	return $totaltiles;
}
function fngetTotalFollowers($userid)
{
	$sqlMyTrackings="select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '".$userid."' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
	$sqlMyTrackingsRes=mysql_query($sqlMyTrackings);
	$totalfollowers=mysql_num_rows($sqlMyTrackingsRes);
	return $totalfollowers;
}
function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}
	return $str;
}
?>