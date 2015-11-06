<?php
$globalpath = "../../webservice/";
require_once('vendor/autoload.php');
require_once('class.phpmailer.php');
require_once('ImageManipulator.php');
define ("BASE_URL" , "finaonationb.com/site/finao_web/");

use OpenCloud\Rackspace;
use OpenCloud\ObjectStore\Resource\DataObject;

function generateResponse($issuccess, $message = NULL, $data = NULL)
{
	$json              = array();
	$json['IsSuccess'] = $issuccess;

	if ($message != NULL)
		$json['message'] = $message;

	if ($data != NULL)
		$json['item'] = $data;

	return $json;
}

function time_elapsed_string($ptime)
{

	$etime = time() - strtotime($ptime);

	if ($etime < 1)
	{
		return '0 seconds';
	}

	$a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
			30 * 24 * 60 * 60       =>  'month',
			24 * 60 * 60            =>  'day',
			60 * 60                 =>  'hour',
			60                      =>  'minute',
			1                       =>  'second'
	);

	foreach ($a as $secs => $str)
	{
		$d = $etime / $secs;
		if ($d >= 1)
		{
			$r = round($d);
			return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
		}
	}
}
function validateLogin($username, $password)
{
	$password = md5($password);
	//$query=mysql_query("call validatelogin('$username','$password')");
	$query = mysql_query("select userid from fn_users where email='$username' and password='$password' and status=1");

	if(mysql_num_rows($query) > 0) {
		$obj = mysql_fetch_object($query);
		mysql_free_result();
		return $obj->userid;

	} else {
		$response = generateResponse(FALSE, INVALID_USERNAME_PWD);
		echo json_encode($response);
		getStatusCode(401);
		exit;
	}
}

function getStatusCode($newcode = NULL)
{
	static $code = 200;
	if ($newcode !== NULL) {
		header('X-PHP-Response-Code: ' . $newcode, true, $newcode);
		if (!headers_sent())
			$code = $newcode;
	}
	return $code;
}

function updateexplorefinao($tile_id)
{
	$sqlUpdate = "update fn_user_finao_tile set explore_finao=1 where tile_id=" . $tile_id;
	mysql_query($sqlUpdate);
}
//--------------- 2
function explorefinao($userid, $session_id)
{
	set_time_limit(0);
	$uploadnamearray = array();
	$json            = array();
	$sqlSelect       = "SELECT t. * ,usr.*, t1.finao_msg, fup.profile_image,fud.uploadfile_name, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id JOIN fn_user_profile fup ON fup.user_id = t2.userid JOIN fn_uploaddetails fud ON fud.`uploadedby`=t2.userid JOIN fn_users usr on usr.userid=fup.user_id WHERE t1.finao_status_Ispublic =1";
	if ($userid != "") {
		$sqlSelect .= " AND t.tracker_userid =" . $userid;
	}
	$sqlSelect .= "  AND t3.lookup_name!='Image' AND t3.lookup_name!='Video' AND t1.finao_activestatus =1 GROUP BY t.tile_id, 		                   t.finao_id,round( UNIX_TIMESTAMP( t.updateddate ) /600 ) DESC ORDER BY t.updateddate DESC limit 0,30";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$sqlSelectDet['password'] = "";
			$uploadnamearray[]        = $sqlSelectDet['uploadfile_name'];
		}
	}
	$sqlSelectImage = "SELECT t.*,fup.user_profile_id,fup.user_profile_msg,fup.user_location,fup.profile_image,fup.profile_bg_image,
	fup.profile_status_Ispublic,fup.mystory,fup.IsCompleted,fup.explore_finao,usr.userid,usr.uname,usr.email,usr.fname,usr.lname,fu.finao_msg FROM fn_uploaddetails t JOIN fn_lookups t1 JOIN fn_user_profile fup ON t.uploadtype = t1.lookup_id JOIN fn_users usr on usr.userid=fup.user_id LEFT JOIN fn_user_finao fu on fu.user_finao_id=t.upload_sourceid WHERE lookup_name = 'Image' AND t.explore_finao =1 AND fup.user_id = t.`uploadedby`  AND upload_sourcetype=37";

	$sqlSelectImageRes = mysql_query($sqlSelectImage);

	if (mysql_num_rows($sqlSelectImageRes) > 0) {
		while ($sqlSelectImageDet = mysql_fetch_assoc($sqlSelectImageRes)) {
			/*****************Total Count*******************/
			$totalfollowers    = 0;
			$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '" . $sqlSelectImageDet['userid'] . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
			$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
			$totalfollowers    = mysql_num_rows($sqlMyTrackingsRes);

			$totaltiles       = 0;
			$sqlTilesCount    = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='" . $sqlSelectImageDet['userid'] . "' AND Iscompleted =0 AND finao_activestatus !=2 AND finao_status_Ispublic =1 GROUP BY tile_id";
			//
			$sqlTilesCountRes = mysql_query($sqlTilesCount);
			$totaltiles       = mysql_num_rows($sqlTilesCountRes);

			$totalfinaos       = 0;
			$sqlFianosCount    = "SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid ='" . $sqlSelectImageDet['userid'] . "' AND f.finao_activestatus =1 AND Iscompleted =0 and finao_status_Ispublic = 1";
			$sqlSelectCountRes = mysql_query($sqlFianosCount);
			if (mysql_num_rows($sqlSelectCountRes) > 0) {
				while ($sqlSelectCountDet = mysql_fetch_array($sqlSelectCountRes)) {
					$totalfinaos = $sqlSelectCountDet['totalfinaos'];
				}
			}
			$totalfollowings = 0;

			$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '" . $sqlSelectImageDet['userid'] . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
			$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
			$totalfollowings   = mysql_num_rows($sqlMyTrackingsRes);

			if ($totaltiles == "")
				$totaltiles = 0;
			if ($totalfinaos == "")
				$totalfinaos = 0;
			if ($totalfollowers == "")
				$totalfollowers = 0;
			if ($totalfollowings == "")
				$totalfollowings = 0;
			$sqlSelectImageDet['totalfinaos']     = $totalfinaos;
			$sqlSelectImageDet['totaltiles']      = $totaltiles;
			$sqlSelectImageDet['totalfollowers']  = $totalfollowers;
			$sqlSelectImageDet['totalfollowings'] = $totalfollowings;

			$sqlSelectImageDet['password'] = "";
			if ($sqlSelectImageDet['upload_sourcetype'] == 37)
				$sqlSelectImageDet['finao_id'] = $sqlSelectImageDet['upload_sourceid'];
			if (!in_array($sqlSelectImageDet['uploadfile_name'], $uploadnamearray)) {
				$rows['image'][] = $sqlSelectImageDet;
			}

		}
	}
	$sqlSelectVideo = "SELECT t.*,fup.user_profile_id,fup.user_profile_msg,fup.user_location,fup.profile_image,fup.profile_bg_image,fup.profile_status_Ispublic,fup.mystory,fup.IsCompleted,fup.explore_finao,usr.userid,usr.uname,usr.email,usr.fname,usr.lname,fu.finao_msg FROM fn_uploaddetails t JOIN fn_lookups t1 JOIN fn_user_profile fup ON t.uploadtype = t1.lookup_id JOIN fn_users usr on usr.userid=fup.user_id LEFT JOIN fn_user_finao fu on fu.user_finao_id=t.upload_sourceid WHERE lookup_name = 'Video' AND t.explore_finao =1 AND fup.user_id = t.`uploadedby` AND upload_sourcetype=37";

	$sqlSelectVideoRes = mysql_query($sqlSelectVideo);
	if (mysql_num_rows($sqlSelectVideoRes) > 0) {
		while ($sqlSelectVideoDet = mysql_fetch_assoc($sqlSelectVideoRes)) {
			/*****************Total Count*******************/
			$totalfollowers    = 0;
			$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '" . $sqlSelectVideoDet['userid'] . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
			$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
			$totalfollowers    = mysql_num_rows($sqlMyTrackingsRes);

			$totaltiles       = 0;
			$sqlTilesCount    = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='" . $sqlSelectVideoDet['userid'] . "' AND Iscompleted =0 AND finao_activestatus !=2 AND finao_status_Ispublic =1 GROUP BY tile_id";
			$sqlTilesCountRes = mysql_query($sqlTilesCount);
			$totaltiles       = mysql_num_rows($sqlTilesCountRes);

			$totalfinaos       = 0;
			$sqlFianosCount    = "SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid ='" . $sqlSelectVideoDet['userid'] . "' AND f.finao_activestatus =1 AND Iscompleted =0 and finao_status_Ispublic = 1";
			$sqlSelectCountRes = mysql_query($sqlFianosCount);
			if (mysql_num_rows($sqlSelectCountRes) > 0) {
				while ($sqlSelectCountDet = mysql_fetch_array($sqlSelectCountRes)) {
					$totalfinaos = $sqlSelectCountDet['totalfinaos'];
				}
			}
			$totalfollowings = 0;

			$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '" . $sqlSelectVideoDet['userid'] . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
			$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
			$totalfollowings   = mysql_num_rows($sqlMyTrackingsRes);

			if ($totaltiles == "")
				$totaltiles = 0;
			if ($totalfinaos == "")
				$totalfinaos = 0;
			if ($totalfollowers == "")
				$totalfollowers = 0;
			if ($totalfollowings == "")
				$totalfollowings = 0;
			$sqlSelectVideoDet['totalfinaos']     = $totalfinaos;
			$sqlSelectVideoDet['totaltiles']      = $totaltiles;
			$sqlSelectVideoDet['totalfollowers']  = $totalfollowers;
			$sqlSelectVideoDet['totalfollowings'] = $totalfollowings;

			/************************************/
			if ($sqlSelectVideoDet['upload_sourcetype'] == 37)
				$sqlSelectVideoDet['finao_id'] = $sqlSelectVideoDet['upload_sourceid'];
			$sqlSelectVideoDet['password'] = "";
			if (!empty($sqlSelectVideoDet['videoid'])) {
				$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=" . $session_id . "&key=1mn4s66e3c44f11rx1xd&video_id=" . $sqlSelectVideoDet['videoid']);

				$video                          = json_decode($videosource, true);
				$sqlSelectVideoDet['videofrom'] = "";
				foreach ($video['video']['files'] as $k => $v) {
					if ($v['html5_video_source'] != "")
						$sqlSelectVideoDet['videosource'] = $v['html5_video_source'];
				}
				$rows['video'][] = (unstrip_array($sqlSelectVideoDet));
			} else {
				$str                                 = str_replace("/default.jpg", "", $sqlSelectVideoDet['video_img']);
				$str                                 = str_replace("http://img.youtube.com/vi/", "", $str);
				$sqlSelectVideoDet['video_embedurl'] = "";
				$sqlSelectVideoDet['videofrom']      = "youtube";
				$sqlSelectVideoDet['videosource']    = "http://www.youtube.com/embed/" . $str;
				$rows['video'][]                     = (unstrip_array($sqlSelectVideoDet));
			}
			//$rows['video'][] = $sqlSelectVideoDet;

		}
	}

	$json        = array();
	$json['res'] = $rows;

	echo json_encode($json);

}
//--------------- 3
function finao_details($userid, $finaoid, $session_id)
{

	$json      = array();
	$sqlSelect = "SELECT * FROM ( (SELECT fu. * , t.finao_msg AS message FROM fn_uploaddetails fu LEFT JOIN fn_user_finao t ON fu.upload_sourceid = t.user_finao_id WHERE fu.updatedby =" . $userid . " AND upload_sourcetype =37 AND t.user_finao_id =" . $finaoid . " ORDER BY fu.`uploaddetail_id` DESC ) )a ORDER BY a.updateddate DESC";

	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$videosource       = "";
			$id                = $sqlSelectDet['upload_sourceid'];
			$upload_sourcetype = $sqlSelectDet['upload_sourcetype'];
			$uploadtype        = $sqlSelectDet['uploadtype'];
			$temp              = array();
			if ($sqlSelectDet['uploadtype'] == '34' && $sqlSelectDet['upload_sourcetype'] == 37) {
				$sqlSelectDet['imagename'] = $sqlSelectDet['uploadfile_name'];
				$sqlSelectDet['imagepath'] = $sqlSelectDet['uploadfile_path'];
				$sqlSelectDet['type']      = 'finaoimage';
			} else if ($sqlSelectDet['uploadtype'] == '62' && $sqlSelectDet['upload_sourcetype'] == 37) {
				if ($sqlSelectDet['uploadfile_name'] != "") {
					$sqlSelectDet['imagename'] = $sqlSelectDet['uploadfile_name'];
					$sqlSelectDet['imagepath'] = $sqlSelectDet['uploadfile_path'];
					$sqlSelectDet['type']      = 'finaoimage';
				} else if ($sqlSelectDet['videoid'] != "") {
					$uploadfile_name      = $sqlSelectDet['uploadfile_name'];
					$videoid              = $sqlSelectDet['videoid'];
					$videostatus          = $sqlSelectDet['videostatus'];
					$video_img            = $sqlSelectDet['video_img'];
					$sqlSelectDet['type'] = 'finaovideo';
					if (!empty($videoid)) {
						$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=" . $session_id . "&key=1mn4s66e3c44f11rx1xd&video_id=" . $videoid);
						$video       = json_decode($videosource, true);
						$videofrom   = "";
						foreach ($video['video']['files'] as $k => $v) {

							//		$v=unstrip_array($v);
							if ($v['html5_video_source'] != "")
								$videosource = stripslashes($v['html5_video_source']);
						}

					} else {
						if ($video_img != "") {
							$str                            = str_replace("/default.jpg", "", $video_img);
							$str                            = str_replace("/mqdefault.jpg", "", $str);
							$str                            = str_replace("http://img.youtube.com/vi/", "", $str);
							$video_embedurl                 = "";
							$sqlSelectDet['video_embedurl'] = "";
							$videofrom                      = "youtube";
							if ($str != "")
								$str = "http://www.youtube.com/embed/" . $str;
						}
						$videosource = stripslashes($str);
					}
				} else {
					$str                      = "";
					$str                      = " and upload_sourceid='" . $finaoid . "'";
					$sqlSelectUploadLatest    = "select * from fn_uploaddetails where (uploadtype='34' or uploadtype='35') and Lower(upload_sourcetype)='37' " . $str . " order by uploaddetail_id desc limit 0,1 ";
					$sqlSelectUploadLatestRes = mysql_query($sqlSelectUploadLatest);
					if (mysql_num_rows($sqlSelectUploadLatestRes) > 0) {
						while ($sqlSelectUploadLatestRes = mysql_fetch_assoc($sqlSelectUploadLatestRes)) {
							$sqlSelectDet['imagename']       = "" . $sqlSelectUploadLatestRes['uploadfile_name'];
							$sqlSelectDet['uploadfile_name'] = "" . $sqlSelectUploadLatestRes['uploadfile_name'];
							$sqlSelectDet['imagepath']       = $sqlSelectUploadLatestRes['uploadfile_path'];
						}
					}

					$sqlSelectDet['type'] = 'finaotext';
				}
			} else if ($sqlSelectDet['uploadtype'] == '35' && $sqlSelectDet['upload_sourcetype'] == 37) {
				$uploadfile_name      = $sqlSelectDet['uploadfile_name'];
				$videoid              = $sqlSelectDet['videoid'];
				$videostatus          = $sqlSelectDet['videostatus'];
				$video_img            = $sqlSelectDet['video_img'];
				$sqlSelectDet['type'] = 'finaovideo';
				if (!empty($videoid)) {
					$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=" . $session_id . "&key=1mn4s66e3c44f11rx1xd&video_id=" . $videoid);
					$video       = json_decode($videosource, true);
					$videofrom   = "";
					foreach ($video['video']['files'] as $k => $v) {

						//		$v=unstrip_array($v);
						if ($v['html5_video_source'] != "")
							$videosource = stripslashes($v['html5_video_source']);
					}

				} else {
					if ($video_img != "") {
						$str                            = str_replace("/default.jpg", "", $video_img);
						$str                            = str_replace("/mqdefault.jpg", "", $str);
						$str                            = str_replace("http://img.youtube.com/vi/", "", $str);
						$video_embedurl                 = "";
						$sqlSelectDet['video_embedurl'] = "";
						$videofrom                      = "youtube";
						if ($str != "")
							$str = "http://www.youtube.com/embed/" . $str;
					}
					$videosource = stripslashes($str);
				}

			} else if ($sqlSelectDet['uploadtype'] == '34' && $sqlSelectDet['upload_sourcetype'] == 46) {
				$sqlSelectDet['imagename'] = $sqlSelectDet['uploadfile_name'];
				$sqlSelectDet['imagepath'] = $sqlSelectDet['uploadfile_path'];
				$sqlSelectDet['type']      = 'journalimage';
			} else if ($sqlSelectDet['uploadtype'] == '35' && $sqlSelectDet['upload_sourcetype'] == 46) {
				$uploadfile_name      = $sqlSelectDet['uploadfile_name'];
				$videoid              = $sqlSelectDet['videoid'];
				$videostatus          = $sqlSelectDet['videostatus'];
				$video_img            = $sqlSelectDet['video_img'];
				$sqlSelectDet['type'] = 'journalvideo';
				if (!empty($videoid)) {
					$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=" . $session_id . "&key=1mn4s66e3c44f11rx1xd&video_id=" . $videoid);
					$video       = json_decode($videosource, true);
					$videofrom   = "";
					foreach ($video['video']['files'] as $k => $v) {
						//$v=unstrip_array($v);
						if ($v['html5_video_source'] != "")
							$videosource = stripslashes($v['html5_video_source']);
					}

				} else {
					if ($video_img != "") {
						$str                            = str_replace("/default.jpg", "", $video_img);
						$str                            = str_replace("http://img.youtube.com/vi/", "", $str);
						$video_embedurl                 = "";
						$sqlSelectDet['video_embedurl'] = "";
						$videofrom                      = "youtube";
						if ($str != "")
							$str = "http://www.youtube.com/embed/" . $str;
					}
					$videosource = stripslashes($str);
				}
			}

			$sqlSelectDet['videofrom']   = $videofrom;
			$sqlSelectDet['videosource'] = stripslashes($videosource);
			$sqlSelectDet['tile_name']   = $tile_name;

			$rows[] = (unstrip_array($sqlSelectDet));

			$json        = array();
			$json["res"] = $rows;
		}

	} else {
		$json        = array();
		$json["res"] = "";
	}

	echo "<pre>";
	print_r($json);
	exit;
	echo json_encode($json);
}
//--------------- 4
function List_finao()
{
	$json         = array();
	$sqlSelect    = "select * from fn_lookups where lookup_type='tiles' and lookup_status=1";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$rows[] = $sqlSelectDet;
		}
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}
	echo json_encode($json);
}
//--------------- 5
function searchtiles($search)
{

	$json      = array();
	$sqlSelect = "SELECT t.tile_id, t.userid, fo.tilename, t.`finao_id` , t1.finao_activestatus, fo.status, t1.finao_msg, t.tile_profileImagurl, t1. * FROM fn_user_finao_tile t JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_tilesinfo fo ON fo.tile_id = t.tile_id AND t1.finao_status_Ispublic =1 AND t.status =1 AND t1.finao_activestatus !=2 AND fo.tilename LIKE '%" . $search . "%' GROUP BY fo.tilename, t.userid";

	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$sqlSelectProfile    = "SELECT `fname` , `lname` , fu.profile_image FROM fn_users u LEFT JOIN fn_user_profile fu ON fu.user_id = u.userid WHERE fu.user_id ='" . $sqlSelectDet['userid'] . "'";
			$sqlSelectProfileRes = mysql_query($sqlSelectProfile);
			if (mysql_num_rows($sqlSelectProfileRes)) {
				while ($sqlSelectProfileDet = mysql_fetch_array($sqlSelectProfileRes)) {
					$profile_image = $sqlSelectProfileDet['profile_image'];
					$fname         = $sqlSelectProfileDet['fname'];
					$lname         = $sqlSelectProfileDet['lname'];
				}
			}
			$sqlSelectDet['profile_image'] = $profile_image;
			$sqlSelectDet['fname']         = $fname;
			$sqlSelectDet['lname']         = $lname;
			$rows[]                        = $sqlSelectDet;
		}
	} else {
		$json['res'] = "";
	}
	$json['res'] = $rows;
	echo json_encode($json);
}
//--------------- 6
function activateacccount($activkey)
{

	$sqlSelectRes='';
	if($activkey!='')
	{

		$sqlSelect="select * from fn_users  where activkey='".$activkey."'";
		$sqlSelectRes=mysql_query($sqlSelect);
	}
	$json =array();
	if(mysql_num_rows($sqlSelectRes)>0)
	{
		$sqlUpdate="update fn_users set status=1 where activkey='".$activkey."'";
		mysql_query($sqlUpdate);

		$json = generateResponse(TRUE, 'success', "Succesfully Activated your account");
	}

	else {
		$json = generateResponse(FALSE,'Activation Key expired');


	}

	echo json_encode($json);

}
function SendInvites($to)
{

	$json    = array();
	$subject = 'Welcome to Finaonation';
	$message = "Hi, Welcome to finaonation.com";
	$headers = 'From: admin@finaoation.com' . "\r\n" . 'Reply-To: admin@finaoation.org' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	$headers .= 'Cc: ' . $cc . "\r\n";
	$headers .= 'Bcc: ' . $bcc . "\r\n";
	$headers .= "Reply-To: Finaonation <admin@finaonation.com>\r\n";
	$headers .= "Return-Path:finaonation <admin@finaonation.com>\r\n";
	$headers .= "From: finaonation <admin@finaonation.com>\r\n";
	$headers .= "Organization: finaonation\r\n";
	$headers .= "Content-Type: text/plain\r\n";
	$headers .= 'X-Mailer: PHP/' . phpversion();
	//$headers .= 'Cc: '.$cc . "\r\n";
	//$headers .= 'Bcc: '.$bcc . "\r\n";
	$message = trim($message);
	$subject = trim($subject);
	$list    = explode(",", $to);
	if (count($list) > 0) {
		foreach ($list as $k => $v) {
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$body = $message;
			$body = eregi_replace("[\]", '', $body);
			$mail->AddReplyTo("admin@finaonation.com", "Administrator");
			$mail->SetFrom('admin@finaonation.com', 'Administrator');
			$mail->AddReplyTo("admin@finaonation.com", "Administrator");
			$mail->AddAddress($v, $name);
			$mail->Subject = $subject;
			//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			$mail->MsgHTML($body);
			$json = array();
			if (!$mail->Send()) {
				$json['res'] = "Mail Failed";
			} else {
				$json['res'] = "Mail Sent Successfully";
			}
		}
	}
	echo json_encode($json);
}
//--------------- 7
function homelist($userid, $session_id)
{
	$json         = array();
	$json['home'] = "";

	$sqlSelect    = "SELECT fu.updateddate, fu.uploadfile_name, uname, lookup_name, upload_sourceid FROM fn_uploaddetails fu JOIN fn_users fur RIGHT JOIN fn_lookups fl ON fu.updatedby = fur.userid AND fu.upload_sourcetype = fl.lookup_id WHERE (lookup_name = 'tile' OR lookup_name = 'finao' OR lookup_name = 'journal' )ORDER BY fu.updateddate DESC LIMIT 0,30";
	$sqlSelect    = "SELECT t.*, t1 . *, t6.profile_image,t6.mystory, t4.lookup_name as finaostatus, t1.updateddate as finaoupdateddate,DATE_FORMAT(t1.updateddate,'%d %b %y') as fupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name FROM `fn_trackingnotifications` `t` Join fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 JOIN fn_user_profile t6 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id WHERE t.tracker_userid = " . $userid . " AND t6.`user_id` = t2.useridand t1.finao_status_Ispublic = 1 and t1.finao_activestatus = 1 GROUP BY t.tile_id, t.finao_id ,round(UNIX_TIMESTAMP(t.updateddate) / 600) desc ORDER BY t.updateddate desc";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$id          = $sqlSelectDet['upload_sourceid'];
			$tile_name   = $sqlSelectDet['tile_name'];
			$lookup_name = $sqlSelectDet['lookup_name'];
			if ($lookup_name == 'finao') {
				$sqlgetFiano = "select tile_id,tile_name from fn_user_finao_tile where finao_id=" . $id;

				$sqlgetFianoRes = mysql_query($sqlgetFiano);
				if (mysql_num_rows($sqlgetFianoRes) > 0) {
					while ($sqlgetFianoDet = mysql_fetch_assoc($sqlgetFianoRes)) {
						$tile_name = $sqlgetFianoDet['tile_name'];
					}
				}

			} else if ($lookup_name == 'journal') {
				$sqlgetJournalInfo    = "select finao_id from fn_user_finao_journal where finao_journal_id=" . $id;
				$sqlgetJournalInfoRes = mysql_query($sqlgetJournalInfo);
				if (mysql_num_rows($sqlgetJournalInfoRes) > 0) {
					while ($sqlgetJournalInfoDet = mysql_fetch_assoc($sqlgetJournalInfoRes)) {
						$sqlgetFiano    = "select tile_id,tile_name from fn_user_finao_tile where finao_id=" . $sqlgetJournalInfoDet['finao_id'];
						$sqlgetFianoRes = mysql_query($sqlgetFiano);
						if (mysql_num_rows($sqlgetFianoRes) > 0) {
							while ($sqlgetFianoDet = mysql_fetch_assoc($sqlgetFianoRes)) {
								$tile_name = $sqlgetFianoDet['tile_name'];
							}
						}
					}

				}
			}

			else if ($sqlSelectDet['finao_id'] != "") {

				$sqlgetFiano2    = "SELECT uploadfile_name, videoid, videostatus, video_img, video_embedurl FROM fn_user_finao f JOIN fn_uploaddetails fu ON f.user_finao_id = fu.upload_sourceid WHERE user_finao_id =" . $sqlSelectDet['finao_id'];
				$uploadfile_name = "";
				$videoid         = "";
				$videostatus     = "";
				$video_img       = "";
				$sqlgetFianoRes2 = mysql_query($sqlgetFiano2);
				if (mysql_num_rows($sqlgetFianoRes2) > 0) {
					while ($sqlgetFianoDet2 = mysql_fetch_assoc($sqlgetFianoRes2)) {
						$uploadfile_name = $sqlgetFianoDet2['uploadfile_name'];
						$videoid         = $sqlgetFianoDet2['videoid'];
						$videostatus     = $sqlgetFianoDet2['videostatus'];
						$video_img       = $sqlgetFianoDet2['video_img'];

						if (!empty($videoid)) {
							$videosource = file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=" . $session_id . "&key=1mn4s66e3c44f11rx1xd&video_id=" . $videoid);


							$video = json_decode($videosource, true);


							$videofrom = "";
							foreach ($video['video']['files'] as $k => $v) {
								$v = unstrip_array($v);
								if ($v['html5_video_source'] != "")
									$videosource = stripslashes($v['html5_video_source']);
							}

						} else {
							$str            = str_replace("/default.jpg", "", $video_img);
							$str            = str_replace("http://img.youtube.com/vi/", "", $str);
							$video_embedurl = "";
							$videofrom      = "youtube";
							if ($str != "")
								$str = "http://www.youtube.com/embed/" . $str;
							$videosource = $str;
						}

					}
				}
			}
			$sqlSelectDet['videofrom']       = $videofrom;
			$sqlSelectDet['uploadfile_name'] = $uploadfile_name;
			$sqlSelectDet['videosource']     = stripslashes($videosource);
			$sqlSelectDet['tile_name']       = $tile_name;

			$totalfollowers = 0;

			$totalfollowers = fngetTotalFollowers($sqlSelectDet['userid']);

			$totaltiles    = 0;
			//					 $totaltiles=fngetTotalTiles($sqlSelectDet['userid'],"");
			$totaltiles    = 0;
			$sqlTilesCount = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =" . $sqlSelectDet['userid'] . " AND finao_activestatus !=2 ";
			$sqlTilesCount .= " and `finao_status_Ispublic` =1";
			$sqlTilesCount .= " GROUP BY tile_id ";
			$sqlTilesCountRes = mysql_query($sqlTilesCount);
			$totaltiles       = mysql_num_rows($sqlTilesCountRes);
			$totalfinaos      = 0;
			//$totalfinaos=fngetTotalFinaos($sqlSelectDet['userid'],"");
			$sqlFianosCount   = "";
			$sqlFianosCount   = "SELECT user_tileid FROM  fn_user_finao_tile ft JOIN fn_user_finao f WHERE ft.finao_id = f.user_finao_id AND ft.userid =  '" . $sqlSelectDet['userid'] . "' AND f.finao_activestatus =1 AND finao_status_Ispublic =1";
			//echo $sqlFianosCount;


			$sqlSelectFinaoCountRes = mysql_query($sqlFianosCount);

			$totalfinaos = mysql_num_rows($sqlSelectFinaoCountRes);

			$totalfollowings = 0;
			$totalfollowings = fngetTotalFollowings($sqlSelectDet['userid']);

			if ($totaltiles == "")
				$totaltiles = 0;
			if ($totalfinaos == "")
				$totalfinaos = 0;
			if ($totalfollowers == "")
				$totalfollowers = 0;
			if ($totalfollowings == "")
				$totalfollowings = 0;
			$sqlSelectDet['totalfinaos']     = $totalfinaos;
			$sqlSelectDet['totaltiles']      = $totaltiles;
			$sqlSelectDet['totalfollowers']  = $totalfollowers;
			$sqlSelectDet['totalfollowings'] = $totalfollowings;
			$rows[]                          = $sqlSelectDet;

			$json['home'] = $rows;
		}

	}
	echo "<pre>";
	print_r($json);
	exit;

	echo json_encode($json);
}
//--------------- 8
function changepassword($userid, $oldpassword, $newpassword, $confirmpassword, $email)
{
	$json         = array();
	$sqlSelect    = "select userid,mageid from fn_users where userid='" . $user_id . "' and password='" . $oldpassword . "'";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		$sqlSelectDet = mysql_fetch_array($sqlSelectRes);
		if ($newpassword == $confirmpassword) {
			$sqlquery = "update fn_users set password='" . $newpassword . "' where email='" . $email . "'";
			mysql_query($sqlquery);

			$proxy       = new SoapClient($soap_url); // TODO : change url
			$sessionId   = $proxy->login($soapusername, $soappassword);
			$result      = $client->call($sessionId, 'customer.update', array(
					'customerId' => $sqlSelectDet['mageid'],
					'customerData' => array(
							'password' => $newpassword
					)
			));
			$json['res'] = "Password Updated Successfully";
		} else {
			$json['res'] = "Confirmation Password Failed";
		}
	} else {
		$json['res'] = "User password does not match";
	}
	echo json_encode($json);
}
//--------------- 9
function user_details($userid)
{

	$json         = array();
	$sqlSelect    = "select * from fn_users where status=1 and userid = '" . $userid . "'";
	$query=" SELECT  COUNT(inspire.inspiringpostid) totalinspire
	FROM    inspiringpost inspire
	INNER JOIN fn_uploaddetails upload ON inspire.userpostid = upload.uploadedby
	WHERE   upload.uploadedby ='" . $userid . "'";
	$queryres=mysql_query($query);
	$querydet=mysql_fetch_assoc($queryres);
	$sqlSelectRes = mysql_query($sqlSelect);
	$count        = mysql_num_rows($sqlSelectRes);
	if ($count > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$sqlSelectProfile    = "select profile_image,mystory,profile_bg_image from fn_user_profile where user_id='" . $sqlSelectDet['userid'] . "'";
			$sqlSelectProfileRes = mysql_query($sqlSelectProfile);
			if (mysql_num_rows($sqlSelectProfileRes) > 0) {
				while ($sqlSelectProfileDet = mysql_fetch_array($sqlSelectProfileRes)) {
					$profile_image = $sqlSelectProfileDet['profile_image'];
					$banner_image=$sqlSelectProfileDet['profile_bg_image'];
					$mystory       = $sqlSelectProfileDet['mystory'];
				}
			}
			$totalfollowers  = 0;
			$totalfollowers  = fngetTotalFollowers($sqlSelectDet['userid']);
			$totaltiles      = 0;
			$totaltiles      = fngetTotalTiles($sqlSelectDet['userid'], "");
			$totalfinaos     = 0;
			$totalfinaos     = fngetTotalFinaos($sqlSelectDet['userid'], "");
			$totalfollowings = 0;
			$totalfollowings = fngetTotalFollowings($sqlSelectDet['userid']);

			if ($totaltiles == "")
				$totaltiles = 0;
			if ($totalfinaos == "")
				$totalfinaos = 0;
			if ($totalfollowers == "")
				$totalfollowers = 0;
			if ($totalfollowings == "")
				$totalfollowings = 0;

			$sqlSelectDet['totalinspired']     =  $querydet['totalinspire'];
			$sqlSelectDet['totalfinaos']     = $totalfinaos;
			$sqlSelectDet['totaltiles']      = $totaltiles;
			$sqlSelectDet['totalfollowers']  = $totalfollowers;
			$sqlSelectDet['totalfollowings'] = $totalfollowings;
			$sqlSelectDet['profile_image']   = $profile_image;
			$sqlSelectDet['mystory']         = $mystory;
			$sqlSelectDet['banner_image']=  $banner_image;
			$rows[]                          = $sqlSelectDet;
		}
		$json        = array();
		//$rows['totalrows']=mysql_num_rows($sqlSelectRes);
		$response=generateResponse(true,'success',$rows);

	} else {
		$response=generateResponse(false,'no data');
	}

	echo json_encode($response);
}

//--------------- 10
function searchusers($username, $tile_name)
{

	$json = array();
	if ($username != "")
		$sqlSelect = "select * from fn_users where status=1 and email like '%" . $username . "%' or fname like '%" . $username . "%' or lname like '%" . $username . "%' or uname like '%" . $username . "%'";
	$userarr = explode(" ", $username);
	if (count($userarr)) {
		$sqlSelect .= " OR concat(fname,' ',lname) like '%" . $username . "%'";
	}
	$sqlSelectRes = mysql_query($sqlSelect);
	$count1       = mysql_num_rows($sqlSelectRes);
	if ($tile_name == "")
		$tile_name = $username;
	$sqlSelect1 = "SELECT t.userid as user_id,t.userid as uid,t. * , t1.user_location, t1.profile_image, t2. * FROM fn_users t LEFT JOIN fn_user_profile t1 ON t.userid = t1.user_id LEFT JOIN ( SELECT t.userid,t.user_finao_id,t.finao_msg,t.finao_status_Ispublic,t.finao_activestatus,t.createddate,t.updatedby,t.updateddate,t.finao_status,t.Iscompleted,t.Isdefault , t2.tilename, t3.lookup_name FROM fn_user_finao t JOIN fn_user_finao_tile t1 ON t.user_finao_id = t1.finao_id AND t.userid = t1.userid JOIN fn_tilesinfo t2 ON t1.tile_id = t2.tile_id AND t1.userid = t2.createdby JOIN fn_lookups t3 ON t.finao_status = t3.lookup_id AND t.finao_activestatus =1 AND t.finao_status_Ispublic =1 GROUP BY t.userid, t1.tile_id ORDER BY t.updateddate DESC )t2 ON t.userid = t2.userid WHERE t.status =1 AND ( t2.tilename LIKE  '%" . $tile_name . "%' OR t.email LIKE  '%" . $username . "%' OR t.fname LIKE  '%" . $username . "%' OR t.lname LIKE  '%" . $username . "%' OR t.uname LIKE  '%" . $username . "%'";

	if (count($userarr)) {
		$sqlSelect1 .= " OR concat(fname,' ',lname) like '%" . $username . "%'";
	}

	$sqlSelect1 .= " ) GROUP BY uid ORDER BY t.fname, t.lname";
	//OR CONCAT( t.fname,  ' ', t.lname ) LIKE  '%".$username."%')
	//echo $sqlSelect1;

	$sqlSelectRes1 = mysql_query($sqlSelect1);
	$count2        = mysql_num_rows($sqlSelectRes1);
	if ($count1 > 0 || $count2 > 0) {
		if ($count1 > 0 && $count2 > 0)
			$sqlSelectRes = $sqlSelectRes1;
		if ($count1 <= 0 && $count2 > 0)
			$sqlSelectRes = $sqlSelectRes1;
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			if ($sqlSelectDet["userid"] == "")
				$sqlSelectDet["userid"] = $sqlSelectDet['user_id'];
			$profile_image       = "";
			$mystory             = "";
			$sqlSelectProfile    = "select profile_image,mystory from fn_user_profile where user_id='" . $sqlSelectDet['uid'] . "'";
			//echo $sqlSelectProfile;
			$sqlSelectProfileRes = mysql_query($sqlSelectProfile);
			if (mysql_num_rows($sqlSelectProfileRes) > 0) {
				while ($sqlSelectProfileDet = mysql_fetch_array($sqlSelectProfileRes)) {
					$profile_image = $sqlSelectProfileDet['profile_image'];
					$mystory       = $sqlSelectProfileDet['mystory'];

				}
			}
			$totalfollowers = 0;
			$totalfollowers = fngetTotalFollowers($sqlSelectDet['userid']);
			$totaltiles     = 0;
			// $totaltiles=fngetTotalTiles($sqlSelectDet['userid'],"search");

			$SqlSelectTilesCount    = "SELECT user_tileid FROM  `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =  '" . $sqlSelectDet['userid'] . "' AND finao_activestatus !=2 AND  `finao_status_Ispublic` =1 GROUP BY tile_id";
			$SqlSelectTilesCountRes = mysql_query($SqlSelectTilesCount);
			$totaltiles             = mysql_num_rows($SqlSelectTilesCountRes);

			$totalfinaos     = 0;
			$totalfinaos     = fngetTotalFinaos($sqlSelectDet['userid'], "search");
			$totalfollowings = 0;
			$totalfollowings = fngetTotalFollowings($sqlSelectDet['userid']);
			if ($totaltiles == "")
				$totaltiles = 0;
			if ($totalfinaos == "")
				$totalfinaos = 0;
			if ($totalfollowers == "")
				$totalfollowers = 0;
			if ($totalfollowings == "")
				$totalfollowings = 0;
			$sqlSelectDet['totalfinaos']     = $totalfinaos;
			$sqlSelectDet['totaltiles']      = $totaltiles;
			$sqlSelectDet['totalfollowers']  = $totalfollowers;
			$sqlSelectDet['totalfollowings'] = $totalfollowings;
			$sqlSelectDet['profile_image']   = $profile_image;
			$sqlSelectDet['mystory']         = $mystory;
			$counter                         = 0;
			if ($username != "") {
				$sqlSelectProfile = "SELECT t.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id WHERE t.tracker_userid =" . $sqlSelectDet['userid'] . " AND t1.finao_status_Ispublic =1 AND t1.finao_activestatus =1 GROUP BY t.tile_id DESC ORDER BY t.updateddate DESC";
				$sqlSelectProfile = "SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
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
				WHERE t.tracker_userid =" . $sqlSelectDet['userid'] . "
				AND fd.`upload_sourceid` = t5.`finao_id`
				AND t1.finao_status_Ispublic =1
				AND t1.finao_activestatus =1
				GROUP BY t.tile_id,finao_id DESC
				ORDER BY t.updateddate DESC";

			} else
				$sqlSelectProfile = "SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
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
				WHERE t.tracker_userid =" . $sqlSelectDet['userid'] . "
				AND t.tile_id =" . $sqlSelectDet['tile_id'] . "
				AND fd.`upload_sourceid` = t5.`finao_id`
				AND t1.finao_status_Ispublic =1
				AND t1.finao_activestatus =1
				GROUP BY t.tile_id,finao_id DESC
				ORDER BY t.updateddate DESC";
			//echo $sqlSelectProfile;
			$counter = 0;
			$rows[]  = $sqlSelectDet;
		}

		//$rows['totalrows']=mysql_num_rows($sqlSelectRes);
		$json['res'] = $rows;

	} else {
		$json['res'] = "";
	}

	echo json_encode($json);

}
//--------------- 11
function searchusers_new($username, $tile_name)
{

	$json = array();
	if ($username != "")
		$sqlSelect = "select * from fn_users where email like '%" . $username . "%' or fname like '%" . $username . "%' or lname like '%" . $username . "%' or uname like '%" . $username . "%'";
	else
		$sqlSelect = "SELECT t.userid, t . * , t1.user_location, t1.profile_image, t2 . * FROM fn_users t JOIN fn_user_profile t1 ON t.userid = t1.user_id JOIN ( SELECT t . * , t2.tilename, t3.lookup_name FROM fn_user_finao t JOIN fn_user_finao_tile t1 ON t.user_finao_id = t1.finao_id AND t.userid = t1.userid JOIN fn_tilesinfo t2 ON t1.tile_id = t2.tile_id AND t1.userid = t2.createdby JOIN fn_lookups t3 ON t.finao_status = t3.lookup_id WHERE t2.tilename LIKE '%" . $tile_name . "%' AND t.finao_activestatus =1 AND t.finao_status_Ispublic =1 GROUP BY t.userid, t1.tile_id ORDER BY t.updateddate DESC )t2 ON t.userid = t2.userid GROUP BY t.fname, t.lname ORDER BY t.fname, t.lname ";

	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {

		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {

			$sqlSelectProfile    = "select profile_image,mystory from fn_user_profile where user_id='" . $sqlSelectDet['userid'] . "'";
			$sqlSelectProfileRes = mysql_query($sqlSelectProfile);
			if (mysql_num_rows($sqlSelectProfileRes) > 0) {
				while ($sqlSelectProfileDet = mysql_fetch_array($sqlSelectProfileRes)) {
					$profile_image = $sqlSelectProfileDet['profile_image'];
					$mystory       = $sqlSelectProfileDet['mystory'];

				}
			}


			$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '" . $sqlSelectDet['userid'] . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
			$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
			$totalfollowers    = mysql_num_rows($sqlMyTrackingsRes);

			$totaltiles       = 0;
			$sqlTilesCount    = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='" . $sqlSelectDet['userid'] . "' AND Iscompleted =0 AND finao_activestatus !=2 AND finao_status_Ispublic =1 GROUP BY tile_id";
			$sqlTilesCountRes = mysql_query($sqlTilesCount);
			$totaltiles       = mysql_num_rows($sqlTilesCountRes);

			$totalfinaos       = 0;
			$sqlFianosCount    = "SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid ='" . $sqlSelectDet['userid'] . "' AND f.finao_activestatus =1 AND Iscompleted =0 and finao_status_Ispublic = 1";
			$sqlSelectCountRes = mysql_query($sqlFianosCount);
			if (mysql_num_rows($sqlSelectCountRes) > 0) {
				while ($sqlSelectCountDet = mysql_fetch_array($sqlSelectCountRes)) {
					$totalfinaos = $sqlSelectCountDet['totalfinaos'];
				}
			}
			$totalfollowings = 0;

			$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '" . $sqlSelectDet['userid'] . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
			$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
			$totalfollowings   = mysql_num_rows($sqlMyTrackingsRes);
			if ($totaltiles == "")
				$totaltiles = 0;
			if ($totalfinaos == "")
				$totalfinaos = 0;
			if ($totalfollowers == "")
				$totalfollowers = 0;
			if ($totalfollowings == "")
				$totalfollowings = 0;
			$sqlSelectDet['totalfinaos']     = $totalfinaos;
			$sqlSelectDet['totaltiles']      = $totaltiles;
			$sqlSelectDet['totalfollowers']  = $totalfollowers;
			$sqlSelectDet['totalfollowings'] = $totalfollowings;
			$sqlSelectDet['profile_image']   = $profile_image;
			$sqlSelectDet['mystory']         = $mystory;
			$counter                         = 0;
			if ($username != "") {
				$sqlSelectProfile = "SELECT t.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id WHERE t.tracker_userid =" . $sqlSelectDet['userid'] . " AND t1.finao_status_Ispublic =1 AND t1.finao_activestatus =1 GROUP BY t.tile_id DESC ORDER BY t.updateddate DESC";
				$sqlSelectProfile = "SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
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
				WHERE t.tracker_userid =" . $sqlSelectDet['userid'] . "
				AND fd.`upload_sourceid` = t5.`finao_id`
				AND t1.finao_status_Ispublic =1
				AND t1.finao_activestatus =1
				GROUP BY t.tile_id,finao_id DESC
				ORDER BY t.updateddate DESC";

			} else
				$sqlSelectProfile = "SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
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
				WHERE t.tracker_userid =" . $sqlSelectDet['userid'] . "
				AND t.tile_id =" . $sqlSelectDet['tile_id'] . "
				AND fd.`upload_sourceid` = t5.`finao_id`
				AND t1.finao_status_Ispublic =1
				AND t1.finao_activestatus =1
				GROUP BY t.tile_id,finao_id DESC
				ORDER BY t.updateddate DESC";

			$counter             = 0;
			$sqlSelectProfileRes = mysql_query($sqlSelectProfile);
			$counter             = mysql_num_rows($sqlSelectProfileRes);
			//  $sqlSelectDet['totalfinaos']=$counter;
			$rows[]              = $sqlSelectDet;
		}
		$json        = array();
		//$rows['totalrows']=mysql_num_rows($sqlSelectRes);
		$json['res'] = $rows;

	} else {
		$json['res'] = "";
	}

	echo json_encode($json);
}
//--------------- 12
function resetpassword($newpassword,$activkey)
{
	$sqlSelectRes='';
	if($activkey!='')
	{

		$sqlSelect="select * from fn_users  where activkey='".$activkey."'";
		$sqlSelectRes=mysql_query($sqlSelect);

		$json =array();
		if(mysql_num_rows($sqlSelectRes)>0)
		{
			$sqlUpdate="update fn_users set password='".$newpassword."' where activkey='".$activkey."'";
			mysql_query($sqlUpdate);
			$json['res']="Succesfully updated password";
		}
		else {
			$json['res']="Activation Key Expired";
		}
	}
	else {
		$json['res']="Activation Key Expired";
	}

	echo json_encode($json);

}

function forgotpassword($email)
{

	$json         = array();
	$sqlSelect    = "select * from fn_users  where email='" . $email . "'";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {

		$sqlSelectDet = mysql_fetch_array($sqlSelectRes);
		$fname        = $sqlSelectDet['fname'];
		$lname        = $sqlSelectDet['lname'];
		$name         = $fname . " " . $lname;
		$to           = $email;
		//$headers = 'From: no-reply@bizindia.com' . "\r\n" .'Reply-To: no-reply@bizindia.org' . "\r\n" .'X-Mailer: PHP/' . phpversion();
		$headers .= "Reply-To: Fiano <admin@finaonation.com>\r\n";
		$headers .= "Return-Path:Fiano <admin@finaonation.com>\r\n";
		$headers .= "From: Fiano <admin@finaonation.com>\r\n";
		$headers .= "Organization: finaonation\r\n";
		$headers .= "Content-Type: text/plain\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();
		$to        = strtolower(trim($to));
		//$headers .= 'Cc: '.$cc . "\r\n";
		//$headers .= 'Bcc: '.$bcc . "\r\n";
		$subject   = "Fiano : Forgot Password Link";
		$message   = "Hi " . $name . "\r\n Please Click on this following link to reset your passoword ";
		$activekey = md5(rand_string(10));
		//	$message.="http://" . BASE_URL . "index.php/resetpassword&activkey=".$activekey."&email=".$email;
		$message.="<a href='http://" . BASE_URL . "index.php?r=site/resetpassword&activkey=". $activekey ."&email=". $email ."'> Click Here to change password</a>";

		$sqlUpdate = "update fn_users set activkey='" . $activekey . "' where email='" . $email . "'";
		mysql_query($sqlUpdate);

		$message = trim($message);
		$subject = trim($subject);
		$mail    = new PHPMailer(); // defaults to using php "mail()"
		$body    = $message;
		$body    = eregi_replace("[\]", '', $body);

		$mail->AddReplyTo("admin@finaonation.com", "Administrator");

		$mail->SetFrom('admin@finaonation.com', 'Administrator');

		$mail->AddReplyTo("admin@finaonation.com", "Administrator");


		$mail->AddAddress($to, $name);

		$mail->Subject = $subject;

		//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

		$mail->MsgHTML($body);


		if (!$mail->Send()) {
			$json['res'] = "Message delivery failed";
		} else {
			$json['res'] = "Mail has sent successfully";
		}

	} else {
		$json['res'] = "No email exists";
	}
	echo json_encode($json);

}
//--------------- 13
function register($email, $password, $user_id, $secondary_email, $fname, $lname, $gender, $location, $dob, $age, $socialnetwork, $socialnetworkid, $usertypeid, $status, $zipcode)
{


	$json       = array();
	$usertypeid = "64";

	if ($socialnetwork != "FACEBOOK")
		$socialnetwork = "NULL";

	if ($socialnetworkid == "")
		$socialnetworkid = "0";

	$sqlSelect = "select * from fn_users where UPPER(email)='" . strtoupper($email) . "'";

	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) <= 0) {
		$proxy     = new SoapClient($soap_url); // TODO : change url
		$sessionId = $proxy->login($soapusername, $soappassword);
		$mageid    = $proxy->call($sessionId, 'customer.create', array(
				array(
						'email' => $email,
						'firstname' => $fname,
						'lastname' => $lname,
						'password' => $password,
						'website_id' => 1,
						'store_id' => 1,
						'group_id' => 1
				)
		));

		$sqlInsert = "insert into fn_users(password,uname,email,secondary_email,fname,lname,gender,location,dob,age,socialnetwork,socialnetworkid, 	usertypeid,status,zipcode,createtime,createdby,updatedby,updatedate,activkey,mageid)values('" . md5($password) . "','" . $uname . "','" . $email . "','" . $secondary_email . "','" . $fname . "','" . $lname . "','" . $gender . "','" . $location . "','" . $dob . "','" . $age . "','" . $socialnetwork . "','" . $socialnetworkid . "', 	'" . $usertypeid . "','" . $status . "','" . $zipcode . "',NOW(),'" . $user_id . "','" . $user_id . "',NOW(),'','" . $mageid . "')";

		mysql_query($sqlInsert);
		$insert_id = mysql_insert_id();

		$ch = curl_init("http://www.aweber.com/scripts/addlead.pl");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Expect:'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "from=" . $email . "&name=" . $email . "&meta_web_form_id=848580469&meta_split_id=&unit=friendlies&redirect=http://www.aweber.com/form/thankyou_vo.html&meta_redirect_onlist=&meta_adtracking=&meta_message=1&meta_required=from&meta_forward_vars=0?");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		$result = @curl_exec($ch);

		$json        = array();
		$json['res'] = $insert_id;
	} else {
		$json['res'] = "Email Already Registered";
	}
	echo json_encode($json);

}
//--------------- 14
function journaldetails($finaoid)
{
	$json                = array();
	$sqlSelectJournal    = "select * from fn_user_finao_journal where finao_id='" . $finaoid . "' order by finao_journal_id desc";
	$sqlSelectJournalRes = mysql_query($sqlSelectJournal);
	if (mysql_num_rows($sqlSelectJournalRes) > 0) {
		while ($sqlSelectJournalDet = mysql_fetch_assoc($sqlSelectJournalRes)) {
			$rows2[] = $sqlSelectJournalDet;
		}
		$json        = array();
		$json['res'] = $rows2;
	} else {
		$json['res'] = "";
	}
	echo json_encode($json);
}
//--------------- 15
function userlogon($email, $password, $socialnetworkid)
{
	$json = array();
	$flag = 0;
	if ($email != "" && $socialnetworkid == "") {
		$sqlSelect    = "select * from fn_users where email='" . $email . "' and password='" . $password . "'";
		$sqlSelectRes = mysql_query($sqlSelect);
		if (mysql_num_rows($sqlSelectRes) <= 0) {
			$sqlSelect = "select * from fn_users where socialnetworkid='" . $password . "'";
		}
		$flag = 1;
	} else {
		if ($socialnetworkid != "") {

			$sqlSelect = "select * from fn_users where email='" . $email . "'";
			$flag      = 1;
		} else {
			$flag = 0;
		}
	}
	//echo $sqlSelect;
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0 && $flag == 1) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {

			if ($socialnetworkid != "") {
				$sqlUpdate = "update fn_users set socialnetwork='facebook',socialnetworkid=" . $socialnetworkid . " where userid='" . $sqlSelectDet['userid'] . "'";
				mysql_query($sqlUpdate);
			}
			$sqlSelectProfile    = "select profile_image,profile_bg_image,mystory  from fn_user_profile where user_id='" . $sqlSelectDet['userid'] . "'";
			$sqlSelectProfileRes = mysql_query($sqlSelectProfile);
			if (mysql_num_rows($sqlSelectProfileRes)) {
				while ($sqlSelectProfileDet = mysql_fetch_array($sqlSelectProfileRes)) {
					$profile_image    = $sqlSelectProfileDet['profile_image'];
					$profile_bg_image = $sqlSelectProfileDet['profile_bg_image'];
					$mystory          = $sqlSelectProfileDet['mystory'];
				}
			}
			$totalnotifications = 0;
			$totalfinaos        = 0;
			$sqlFianosCount     = "SELECT user_tileid FROM  `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id`  WHERE ft.userid =  '" . $sqlSelectDet['userid'] . "' AND STATUS =1  AND finao_activestatus =1 AND  `Iscompleted` =0 ";
			$sqlSelectCountRes  = mysql_query($sqlFianosCount);
			if (mysql_num_rows($sqlSelectCountRes)) {
				while ($sqlSelectCountDet = mysql_fetch_array($sqlSelectCountRes)) {
					$totalfinaos = mysql_num_rows($sqlSelectCountRes);
				}
			}
			$totaltiles       = 0;
			$sqlTilesCount    = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='" . $sqlSelectDet['userid'] . "' AND Iscompleted =0 AND STATUS =1 AND finao_activestatus =1 GROUP BY tile_id";
			$sqlTilesCountRes = mysql_query($sqlTilesCount);
			$totaltiles       = mysql_num_rows($sqlTilesCountRes);

			$sqlNotificationsCount = "SELECT count(*) as totalnotifications FROM `fn_tracking` `t` JOIN fn_user_finao_tile t1 ON t.tracked_tileid = t1.tile_id AND t.tracker_userid = t1.userid JOIN fn_user_finao t2 ON t1.finao_id = t2.user_finao_id LEFT JOIN fn_tilesinfo fo ON fo.tile_id = t1.user_tileid AND finao_activestatus !=2 AND finao_status_Ispublic =1 WHERE t.tracked_userid ='" . $sqlSelectDet['userid'] . "' AND t.status =0 GROUP BY t1.tile_id, fo.tilename";

			$sqlNotificationsCountRes = mysql_query($sqlNotificationsCount);
			if (mysql_num_rows($sqlNotificationsCountRes)) {
				//while($sqlNotificationsCountDet=mysql_fetch_array($sqlNotificationsCountRes))
				{
					$totalnotifications = mysql_num_rows($sqlNotificationsCountRes);
				}
			}
			$totalfollowings   = 0;
			$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '" . $sqlSelectDet['userid'] . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
			$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
			$totalfollowings   = mysql_num_rows($sqlMyTrackingsRes);


			$totalfollowers = 0;

			$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '" . $sqlSelectDet['userid'] . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
			$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
			$totalfollowers    = mysql_num_rows($sqlMyTrackingsRes);

			if ($totalnotifications == "")
				$totalnotifications = 0;
			if ($totalfinaos == "")
				$totalfinaos = 0;
			if ($totalfollowers == "")
				$totalfollowers = 0;
			if ($totalfollowings == "")
				$totalfollowings = 0;

			if ($totaltiles == "")
				$totaltiles = 0;

			$sqlSelectDet['totalnotifications'] = $totalnotifications;
			$sqlSelectDet['totalfinaos']        = $totalfinaos;
			$sqlSelectDet['totalfollowers']     = $totalfollowers;
			$sqlSelectDet['totalfollowings']    = $totalfollowings;
			$sqlSelectDet['totaltiles']         = $totaltiles;
			$sqlSelectDet['profile_image']      = $profile_image;
			$sqlSelectDet['profile_bg_image']   = $profile_bg_image;
			$sqlSelectDet['mystory']            = $mystory;
			$rows[]                             = $sqlSelectDet;

		}

		$json = array();

		$json['res'] = $rows;
	}
}
	//--------------- 16
function listfinos_old($actual_user_id, $tile_id, $user_id, $ispublic)
{

	$json = array();
	$str  = "";

	if (!empty($tile_id)) {
		$str = " and tile_id='" . $tile_id . "'";
	}
	$sqlSelectFinos = "SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id " . $str . " and ft.userid 	='" . $user_id . "'";
	if ($ispublic != "")
		$sqlSelectFinos .= "and f.finao_status_Ispublic=1";
	$sqlSelectFinos .= " and finao_activestatus!=2 order by user_tileid DESC";
	// echo $sqlSelectFinos;
	$sqlSelectFinosRes = mysql_query($sqlSelectFinos);
	if (mysql_num_rows($sqlSelectFinosRes) > 0) {
		while ($sqlSelectFinosDet = mysql_fetch_assoc($sqlSelectFinosRes)) {
			$sqlSelectFinosDet['isfollow'] = "0";
			if ($actual_user_id != "") {
				$sqlSelectTrack    = "select status as isfollow from fn_tracking where tracker_userid=" . $actual_user_id . " and tracked_userid=" . $user_id;
				$sqlSelectTrackRes = mysql_query($sqlSelectTrack);
				if (mysql_num_rows($sqlSelectTrackRes) > 0) {
					while ($sqlSelectTrackDet = mysql_fetch_assoc($sqlSelectTrackRes)) {
						$sqlSelectFinosDet['isfollow'] = $sqlSelectTrackDet['isfollow'];
					}
				}
			}
			$sqlSelectFinosDet['finao_image']     = "";
			$sqlSelectFinosDet['uploadfile_path'] = "";
			$str                                  = "";
			$str                                  = " and upload_sourceid='" . $sqlSelectFinosDet['finao_id'] . "'";
			$sqlSelectUpload                      = "select * from fn_uploaddetails where uploadtype='34' and Lower(upload_sourcetype)='37' " . $str;
			$sqlSelectUploadRes                   = mysql_query($sqlSelectUpload);
			if (mysql_num_rows($sqlSelectUploadRes) > 0) {
				while ($sqlSelectUploadDet = mysql_fetch_assoc($sqlSelectUploadRes)) {
					$sqlSelectFinosDet['finao_image']     = "" . $sqlSelectUploadDet['uploadfile_name'];
					$sqlSelectFinosDet['uploadfile_path'] = $sqlSelectUploadDet['uploadfile_path'];

				}
			}

			$rows[] = $sqlSelectFinosDet;
		}
		$json        = array();
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}
	echo json_encode($json);

}
//--------------- 17
function listfinos($actual_user_id, $tile_id, $user_id, $ispublic)
{

	$json = array();
	$str  = "";


	if (!empty($tile_id)) {
		$str = " and tile_id='" . $tile_id . "'";
	}
	$sqlSelectFinos = "SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f ON ft.`finao_id`=f.user_finao_id " . $str . " and ft.userid 	='" . $user_id . "'";

	if ($ispublic != "")
		$sqlSelectFinos .= " and f.finao_status_Ispublic=1";
	if ($actual_user_id == "" && $ispublic == "")
		$sqlSelectFinos .= " and Iscompleted =0";
	$sqlSelectFinos .= " and finao_activestatus=1 order by user_tileid DESC";

	// echo $sqlSelectFinos;
	$sqlSelectFinosRes = mysql_query($sqlSelectFinos);
	if (mysql_num_rows($sqlSelectFinosRes) > 0) {
		while ($sqlSelectFinosDet = mysql_fetch_assoc($sqlSelectFinosRes)) {
			$sqlSelectFinosDet['isfollow'] = "0";
			if ($actual_user_id != "") {

				$sqlSelectTrack = "select status as isfollow from fn_tracking where tracker_userid=" . $actual_user_id . " and tracked_userid=" . $user_id . " and tracked_tileid=" . $sqlSelectFinosDet['tile_id'];

				$sqlSelectTrackRes = mysql_query($sqlSelectTrack);
				if (mysql_num_rows($sqlSelectTrackRes) > 0) {
					while ($sqlSelectTrackDet = mysql_fetch_assoc($sqlSelectTrackRes)) {
						$sqlSelectFinosDet['isfollow'] = $sqlSelectTrackDet['isfollow'];
					}
				}
			}
			$sqlSelectFinosDet['finao_image']     = "";
			$sqlSelectFinosDet['uploadfile_path'] = "";
			$sqlSelectFinosDet['upload_text']     = "";
			$str                                  = "";
			$str                                  = " and upload_sourceid='" . $sqlSelectFinosDet['finao_id'] . "'";
			$sqlSelectUpload                      = "select * from fn_uploaddetails where (uploadtype='34' or uploadtype='35' or uploadtype='62') and Lower(upload_sourcetype)='37' " . $str;
			//			echo $sqlSelectUpload;
			$sqlSelectUploadRes                   = mysql_query($sqlSelectUpload);
			if (mysql_num_rows($sqlSelectUploadRes) > 0) {
				while ($sqlSelectUploadDet = mysql_fetch_assoc($sqlSelectUploadRes)) {
					$sqlSelectFinosDet['finao_image']     = "" . $sqlSelectUploadDet['uploadfile_name'];
					$sqlSelectFinosDet['uploadfile_path'] = $sqlSelectUploadDet['uploadfile_path'];
					$sqlSelectFinosDet['caption']         = $sqlSelectUploadDet['caption'];
					$sqlSelectFinosDet['video_caption']   = $sqlSelectUploadDet['video_caption'];
					$sqlSelectFinosDet['videoid']         = $sqlSelectUploadDet['videoid'];
					$sqlSelectFinosDet['videostatus']     = $sqlSelectUploadDet['videostatus'];
					$sqlSelectFinosDet['video_img']       = $sqlSelectUploadDet['video_img'];
					$sqlSelectFinosDet['video_embedurl']  = $sqlSelectUploadDet['video_embedurl'];

					//$sqlSelectFinosDet['upload_text'] = $sqlSelectUploadDet['upload_text'];// old code
					if ($sqlSelectUploadDet['upload_text'] == 'null' or $sqlSelectUploadDet['upload_text'] == '')
						$result = "";
					else
						$result = $sqlSelectUploadDet['upload_text'];
					$sqlSelectFinosDet['upload_text'] = $result;
					$sqlSelectFinosDet['caption']     = $sqlSelectUploadDet['caption'];
					if ($sqlSelectUploadDet['uploadfile_name'] == "") {

						$sqlSelectUploadLatest    = "select * from fn_uploaddetails where (uploadtype='34' or uploadtype='35') and Lower(upload_sourcetype)='37' " . $str . " order by uploaddetail_id desc limit 0,1 ";
						$sqlSelectUploadLatestRes = mysql_query($sqlSelectUploadLatest);
						if (mysql_num_rows($sqlSelectUploadLatestRes) > 0) {
							while ($sqlSelectUploadLatestRes = mysql_fetch_assoc($sqlSelectUploadLatestRes)) {
								$sqlSelectFinosDet['finao_image']     = "" . $sqlSelectUploadLatestRes['uploadfile_name'];
								$sqlSelectFinosDet['uploadfile_path'] = $sqlSelectUploadLatestRes['uploadfile_path'];
							}
						}
					}



				}
			}
			$sqlSelectFinosDet['iscompleted'] = $sqlSelectFinosDet['Iscompleted'];
			$rows[]                           = $sqlSelectFinosDet;
		}
		$json        = array();
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}
	echo json_encode($json);

}
//--------------- 18
function finaosdetails($finao_id)
{
	$json              = array();
	$sqlSelectFinos    = "select * from fn_user_finao where user_finao_id='" . $finao_id . "'";
	$sqlSelectFinosRes = mysql_query($sqlSelectFinos);
	if (mysql_num_rows($sqlSelectFinosRes) > 0) {
		while ($sqlSelectFinosDet = mysql_fetch_assoc($sqlSelectFinosRes)) {
			$rows[] = $sqlSelectFinosDet;

		}
		$json        = array();
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}
	$json1 = json_encode($json);
	echo stripslashes($json1);
}
//--------------- 19
function userdata($user_id)
{
	$json             = array();
	$sqlSelectUser    = "select userid,uname,email,secondary_email,activkey,lastvisit,superuser,profile_image,fname,lname,gender,location,description,dob,age,socialnetwork,socialnetworkid,usertypeid,status,zipcode,createtime,createdby,updatedby,updatedate from fn_users where userid='" . $user_id . "'";
	$sqlSelectUserRes = mysql_query($sqlSelectUser);
	if (mysql_num_rows($sqlSelectUserRes) > 0) {
		while ($sqlSelectUserDet = mysql_fetch_assoc($sqlSelectUserRes)) {
			$rows[] = $sqlSelectUserDet;
		}
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}
	echo json_encode($json);
}
//--------------- 20
function listjournals($finao_id)
{
	$json                = array();
	$sqlSelectJournal    = "select * from fn_user_finao_journal where finao_id='" . $finao_id . "'";
	$sqlSelectJournalRes = mysql_query($sqlSelectJournal);
	if (mysql_num_rows($sqlSelectJournalRes) > 0) {
		while ($sqlSelectJournalDet = mysql_fetch_assoc($sqlSelectJournalRes)) {
			$rows[] = $sqlSelectJournalDet;
		}
		$json        = array();
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}
	echo json_encode($json);
}

//--------------- 21
function userprofiledata($user_id)
{
	$json                = array();
	$sqlSelectProfile    = "select * from fn_user_profile where user_id='" . $user_id . "'";
	$sqlSelectProfileRes = mysql_query($sqlSelectProfile);
	if (mysql_num_rows($sqlSelectProfileRes) > 0) {

		while ($sqlSelectProfileDet = mysql_fetch_assoc($sqlSelectProfileRes)) {

			$rows[] = $sqlSelectProfileDet;
		}
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}


	echo json_encode($json);
}

function whotofollow($userid){
	if($userid > 0){
		$query = "call whotofollow('$userid')";
		$result = mysql_query($query);
	
		if($result){
			if(mysql_num_rows($result) > 0){
				while($obj = mysql_fetch_object($result)){
					$data['userid'] = $obj->userid;
					$data['username'] = $obj->username;
					$data['image'] = $obj->image;
					$data['totaltiles'] = $obj->tiles;
					$data['totalfinaos'] = $obj->finaos;
					$data['totalinspired'] = $obj->inspired;
					$rows[] = $data;
				}
				$response = generateResponse(TRUE,'success', $rows);
			}
			else{
				$response = generateResponse(TRUE, NO_RESULT);
			}
		}
		else{
			$response = generateResponse(FALSE,  NO_RESULT);
		}
	}
	else{
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}

	echo json_encode($response);
}
function updateprofiledetails($userid, $name, $email, $password, $profile_image, $profile_banner_image, $mystory){
	if($userid > 0){
		$arr = split(" ", $name);
		$len = sizeof($arr);
		$fname = $arr[0];
		$flag = 1;
		$lname = "";

		while($flag != $len){
			$lname = $lname." ".$arr[$flag];
			$flag++;
		}
		$lname = trim($lname);

		$sqlupdate = "call settings_updateuserdetails('$userid','$fname','$password', '$profile_image','$profile_banner_image', '$mystory', '$lname')";
		$result = mysql_query($sqlupdate) ;
		if($result){
			$json = Array();
			$json['userid'] = $userid;
			$response = generateResponse(TRUE, 'success', $json );
		}
		else{
			$response = generateResponse(FALSE,  getErrorMessage(mysql_errno()));
		}
	}
	else{
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);
}

function updateprofile($userid, $name, $email, $password, $mystory){

	$basePath = $globalpath.'images/uploads/profileimages/';
	// cloud info
	$username = "finaonation"; // username
	$key = "e211284f93dd42da001243442a5bd25d"; // api key
	if($userid > 0)
	{
		//Rackspace client
		$client = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
				'username' => $username,
				'apiKey'   => $key
		));

		//Authenticate client
		$client->authenticate();
		$service = $client->objectStoreService('cloudFiles');
		$container = $service->getContainer('userimages');

		//Figure out the user first name and last name based on the $name variable
		$arr = split(" ", $name);
		$len = sizeof($arr);
		$fname = $arr[0]; //Regardless, the first array is the first name
		$flag = 1;
		$lname = "";

		while($flag != $len){  //Build the last name by joining up whatever remains
			$lname = $lname." ".$arr[$flag];
			$flag++;
		}
		$lname = trim($lname);

		//OK, now to start working with images, lets decide what we want to name them
		$target_profile_pic_name  = uniqid()."_profile_regular.jpg";
		$target_profile_pic_thumb = uniqid()."_profile_thumb.jpg";
		$target_banner_pic_name = uniqid()."_profile_banner.jpg";

		//We must have got some dimensions to crop the images, lets get that set
		$profile_image_crop_x = $_POST['x'];
		$profile_image_crop_y = $_POST['y'];
		$profile_image_crop_w = $_POST['w'];
		$profile_image_crop_h = $_POST['h'];

		if ($_FILES['profile_image']['tmp_name'] != "") {
			$imageProcessor = new ImageManipulator($_FILES['profile_image']['tmp_name']);
			if($profile_image_crop_w > 1 && $profile_image_crop_h > 1)
			{
				$croppedImage = $imageProcessor.crop($profile_image_crop_x, $profile_image_crop_y, $profile_image_crop_x + $profile_image_crop_w, $profile_image_crop_y + $profile_image_crop_h);
			}
				
			$imageProcessor->save($basePath.$target_profile_pic_name);
				
			//Read back the file so that we can now upload it to Rackspace CDN.
				
			//Common Meta
			$meta = array(
					'Author' => $name,
					'Origin' => 'FINAO Web'
			);
			$metaHeaders = DataObject::stockHeaders($meta);
				
			$data = fopen($basePath.$target_profile_pic_name, 'r+');
			$container->uploadObject($target_profile_pic_name, $data, $metaHeaders);
				
			$targ_w = 150;
			$targ_h = 150;
			$jpeg_quality = 90;
			$profile_thumb_image = $imageProcessor->resample($targ_w, $targ_h);
			$imageProcessor->save($basePath.$target_profile_pic_thumb);
				
			$data = fopen($basePath.$target_profile_pic_thumb, 'r+');
			$container->uploadObject($target_profile_pic_thumb, $data, $metaHeaders);
		}

		if ($_FILES['profile_bg_image']['tmp_name'] != "") {
			@move_uploaded_file($_FILES['profile_bg_image']['tmp_name'],
					'images/uploads/profileimages/'.$target_banner_pic_name);
			//Common Meta
			$meta = array(
					'Author' => $name,
					'Origin' => 'FINAO Web'
			);
			$metaHeaders = DataObject::stockHeaders($meta);
			$data = fopen($basePath.$target_banner_pic_name, 'r+');
			$container->uploadObject($target_banner_pic_name, $data, $metaHeaders);
		}

		$sqlupdate = "call settings_updateuserdetails('$userid','$fname','$password', '$target_profile_pic_thumb','$target_banner_pic_name', '$mystory', '$lname')";

		$result = mysql_query($sqlupdate) ;

		if($result){

			$json = Array();

			$json['userid'] = $userid;

			$response = generateResponse(TRUE, 'success', $json );

		}

		else{

			$response = generateResponse(FALSE,  getErrorMessage(mysql_errno()));

		}


	}

	else{

		$response = generateResponse(FALSE, UNUTHORISED_USER);

	}

	echo json_encode($response);

}
function resize_image_crop($image, $width, $height)
{

	$w = @imagesx($image); //current width

	$h = @imagesy($image); //current height
	if ((!$w) || (!$h)) {
		$GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false;
	}
	if (($w == $width) && ($h == $height)) {
		return $image;
	}  //no resizing needed
	$ratio = $width / $w;       //try max width first...
	$new_w = $width;
	$new_h = $h * $ratio;
	if ($new_h < $height) {  //if that created an image smaller than what we wanted, try the other way
		$ratio = $height / $h;
		$new_h = $height;
		$new_w = $w * $ratio;
	}
	$image2 = imagecreatetruecolor ($new_w, $new_h);
	imagecopyresampled($image2,$image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
	if (($new_h != $height) || ($new_w != $width)) {    //check to see if cropping needs to happen
		$image3 = imagecreatetruecolor ($width, $height);
		if ($new_h > $height) { //crop vertically
			$extra = $new_h - $height;
			$x = 0; //source x
			$y = round($extra / 2); //source y
			imagecopyresampled($image3,$image2, 0, 0, $x, $y, $width, $height, $width, $height);
		} else {
			$extra = $new_w - $width;
			$x = round($extra / 2); //source x
			$y = 0; //source y
			imagecopyresampled($image3,$image2, 0, 0, $x, $y, $width, $height, $width, $height);
		}
		imagedestroy($image2);
		return $image3;
	} else {
		return $image2;
	}
}
//--------------- 22

//--------------- 23
function usertiles_new($ispublic, $user_id)
{
	$json = array();
	if ($user_id == "") {
		$sqlSelectUserTiles = "select fu.user_tileid,fu.tile_id,fu.tile_name,fu.userid,fu.finao_id,fu.tile_profileImagurl as tile_image,fu.status,fu.createddate,fu.createdby,fu.updateddate,fu.updatedby,fu.explore_finao,fd.uploadfile_name,fd.uploadfile_path from fn_user_finao_tile fu RIGHT JOIN fn_user_finao f ON fu.finao_id = f.user_finao_id join fn_lookups fl JOIN fn_uploaddetails fd on fl.lookup_id=fu.tile_id where lookup_type='tiles' AND fd.upload_sourceid = fu.userid AND `lookup_name` = fu.tile_name AND finao_activestatus =1 and iscompleted=0";
		if ($ispublic == "1") {
			$sqlSelectUserTiles .= " and finao_status_Ispublic = 1";
		}
		//JOIN fn_uploaddetails fd AND fd.uploadedby  = t1.userid
		$sqlSelectUserTiles .= " group by fu.tile_name";
	} else {
		$sqlSelectUserTiles = "select fu.user_tileid,fu.tile_id,fu.tile_name,fu.userid,fu.finao_id,fu.tile_profileImagurl as tile_image,fu.status,fu.createddate,fu.createdby,fu.updateddate,fu.updatedby,fu.explore_finao,fd.uploadfile_name,fd.uploadfile_path FROM `fn_user_finao_tile` fu RIGHT JOIN fn_user_finao f ON fu.finao_id = f.user_finao_id LEFT JOIN fn_uploaddetails fd ON fd.`upload_sourceid` = fu.`finao_id`  ";
		if ($user_id != "")
			$sqlSelectUserTiles .= " where fu.userid='" . $user_id . "'";
		$sqlSelectUserTiles .= " AND finao_activestatus =1 ";
		if ($ispublic == "1") {
			$sqlSelectUserTiles .= " and finao_status_Ispublic = 1";
		}
		$sqlSelectUserTiles .= " group by tile_id";
	}
	$sqlSelectUserTiles .= " ORDER BY fu.user_tileid DESC";

	$sqlSelectUserTilesRes = mysql_query($sqlSelectUserTiles);
	if (mysql_num_rows($sqlSelectUserTilesRes) > 0) {

		while ($sqlSelectUserTilesDet = mysql_fetch_assoc($sqlSelectUserTilesRes)) {

			$rows[] = $sqlSelectUserTilesDet;
		}

		$json        = array();
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}

	echo json_encode($json);


}
//--------------- 24
function usertiles_old($ispublic, $user_id)
{
	$json = array();
	if ($user_id == "") {
		$sqlSelectUserTiles = "select fu.user_tileid,fu.tile_id,fu.tile_name,fu.userid,fu.finao_id,fu.tile_profileImagurl as tile_image,fu.status,fu.createddate,fu.createdby,fu.updateddate,fu.updatedby,fu.explore_finao,fd.uploadfile_name,fd.uploadfile_path from fn_user_finao_tile fu RIGHT JOIN fn_user_finao f ON fu.finao_id = f.user_finao_id join fn_lookups fl JOIN fn_uploaddetails fd on fl.lookup_id=fu.tile_id where lookup_type='tiles' AND fd.upload_sourceid = fu.userid AND `lookup_name` = fu.tile_name AND finao_activestatus =1 and iscompleted=0   and fu.tile_profileImagurl like '%png'";
		if ($ispublic == "1") {
			$sqlSelectUserTiles .= " and finao_status_Ispublic = 1";
		}
		$sqlSelectUserTiles .= " group by fu.tile_name";
		$sqlSelectUserTiles .= " ORDER BY fu.user_tileid DESC";
	} else {
		$sqlSelectUserTiles = "select ut.user_tileid,ut.tile_id,ut.tile_name,ut.userid,ut.finao_id,fo.tile_imageurl as  tile_image,ut.status,ut.createddate,ut.createdby,ut.updateddate,ut.updatedby,ut.explore_finao from fn_user_finao_tile ut left join fn_tilesinfo fo on ut.tile_id=fo.tile_id where finao_id in (select user_finao_id from fn_user_finao where finao_activestatus!=2 ";
		if ($user_id != "")
			$sqlSelectUserTiles .= " and userid='" . $user_id . "'";
		if ($ispublic == "1") {
			$sqlSelectUserTiles .= " and finao_status_Ispublic = 1 ";
		} else {
			$sqlSelectUserTiles .= " and Iscompleted = 0";
		}
		$sqlSelectUserTiles .= " order by updateddate DESC)";
		if ($user_id != "")
			$sqlSelectUserTiles .= " and userid='" . $user_id . "'";
		$sqlSelectUserTiles .= " group by tile_id order by createddate DESC";
	}

	$sqlSelectUserTilesRes = mysql_query($sqlSelectUserTiles);
	if (mysql_num_rows($sqlSelectUserTilesRes) > 0) {
		while ($sqlSelectUserTilesDet = mysql_fetch_assoc($sqlSelectUserTilesRes)) {
			$rows[] = $sqlSelectUserTilesDet;
		}
		$json        = array();
		$json['res'] = $rows;
	} else {
		$json['res'] = "";
	}

	echo json_encode($json);
}
//--------------- 25
function movefinao($finao_id, $user_id, $srctile_id, $targettile_id)
{
	$sqlUpdateQuery = "update fn_user_finao_tile set tile_id=" . $targettile_id . " where tile_id=" . $srctile_id . " and userid=" . $user_id . " and finao_id=" . $finao_id;
	mysql_query($sqlUpdateQuery);
	$json        = array();
	$json['res'] = 'ok';
	echo json_encode($json);
}
//--------------- 26
function deletefinao($id, $user_id)
{
	$sqlDelteQuery = "update fn_user_finao set finao_activestatus=2 where user_finao_id=" . $id;
	mysql_query($sqlDelteQuery);
	$sqlDelteUserTileQuery = "update fn_user_finao_tile set status=2 where finao_id=" . $id . " and userid=" . $user_id;
	mysql_query($sqlDelteUserTileQuery);
	$sqlDeleteFianoDetails = "update fn_uploaddetails set status=2 where upload_sourcetype=37 and upload_sourceid=" . $id . " and uploadedby=" . $user_id;
	mysql_query($sqlDeleteFianoDetails);
	$json        = array();
	$json['res'] = 'ok';
	echo json_encode($json);
}
//--------------- 27
function getfinaoimageorvideo($type, $srctype, $srcid, $user_id)
{
	$json         = array();
	$sqlSelect    = "select * from fn_lookups where lookup_type='uploadtype' and Lower(lookup_name)='" . strtolower($type) . "'";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$lookup_id = $sqlSelectDet['lookup_id'];
		}
	}
	$sqlSelectSrctype = "select * from fn_lookups where lookup_type='uploadsourcetype' and Lower(lookup_name)='" . strtolower($srctype) . "'";

	$sqlSelectSrctypeRes = mysql_query($sqlSelectSrctype);
	if (mysql_num_rows($sqlSelectSrctypeRes) > 0) {
		while ($sqlSelectSrctypeDet = mysql_fetch_assoc($sqlSelectSrctypeRes)) {
			$srclookup_id = $sqlSelectSrctypeDet['lookup_id'];
		}
	}
	$str = "";
	if ($srcid != "")
		$str = " and upload_sourceid='" . $srcid . "'";

	$sqlSelectUpload    = "select * from fn_uploaddetails where uploadtype='" . $lookup_id . "' and Lower(upload_sourcetype)='" . strtolower($srclookup_id) . "' " . $str . " and uploadedby='" . $user_id . "'";
	$sqlSelectUploadRes = mysql_query($sqlSelectUpload);
	if (mysql_num_rows($sqlSelectUploadRes) > 0) {
		while ($sqlSelectUploadDet = mysql_fetch_assoc($sqlSelectUploadRes)) {
			$rows[] = $sqlSelectUploadDet;
		}

		$json        = array();
		$json['res'] = $rows;

	} else {
		$json['res'] = "";
	}
	echo json_encode($json);
}
//--------------- 28
function createfiano_live($userid, $finao_msg, $tile_id, $tile_name, $finao_status_ispublic, $updatedby, $finao_status, $iscompleted, $caption, $videoid, $videostatus, $video_img)
{

	$json      = array();
	$json_test = '{ "user_id":1 ,"finao_msg":"tester","tile_id":1,"tile_name":"tester test","finao_status_inpublic":1,"updatedby":1,"finao_status":1,"iscompleted":1,"tile_id":1,"tile_name":"test"}';
	if ($finao_status != "")
		$finao_status = 1;
	$tile_create = 0;
	if ($tile_id != "") {
		$tile_create = 1;
	}
	if ($tile_id == "") {
		$sqlSelect    = "select * from fn_lookups where lookup_type='tiles' and lookup_name='" . $tile_name . "'";
		$sqlSelectRes = mysql_query($sqlSelect);
		if (mysql_num_rows($sqlSelectRes) <= 0) {

			$sqlSelectTile    = "select * from fn_tilesinfo from tilename='" . $tile_name . "'";
			$sqlSelectTileRes = mysql_query($sqlSelectTile);
			if (mysql_num_rows($sqlSelectTileRes) <= 0) {
				$tile_create = 1;
			}
		}
	}
	if ($tile_create == 1) {
		if ($tile_id == "") {
			$selectTile_id    = "select max(tile_id) as tilecount from fn_user_finao_tile";
			$selectTile_idRes = mysql_query($selectTile_id);
			$selectTile_idDet = mysql_fetch_array($selectTile_idRes);
			$tile_id          = ($selectTile_idDet['tilecount']) + 1;
		}
		$sqlInsert = "insert into fn_user_finao (userid,finao_msg,finao_status_ispublic,updatedby,finao_status,iscompleted,createddate,updateddate)values('" . $userid . "','" . $finao_msg . "','" . $finao_status_ispublic . "','" . $updatedby . "','" . $finao_status . "','" . $iscompleted . "',NOW(),NOW())";
		mysql_query($sqlInsert);
		$finao_id    = mysql_insert_id();
		$target_path = $globalpath . "images/tiles/";
		$upload_path = "images/tiles/";
		if ($_FILES['tile_image']['name'] != "") {

			$target_path = $target_path . basename($_FILES['tile_image']['name']);
			@move_uploaded_file($_FILES['tile_image']['tmp_name'], $target_path);

			$uploadfile_name = basename($_FILES['tile_image']['name']);
		}

		if ($tile_id == "") {
			$sqlInsertFianoTable = "insert into fn_user_finao_tile(tile_id,tile_name,userid,finao_id,tile_profileImagurl,status,createddate,createdby,updateddate,updatedby)values('" . $tile_id . "','" . $tile_name . "','" . $userid . "','" . $finao_id . "','" . $_FILES['tile_image']['name'] . "','1',NOW(),'" . $userid . "',NOW(),'" . $userid . "')";
			mysql_query($sqlInsertFianoTable);
			$sqlInsertTileInfo = "insert into fn_tilesinfo(tile_id,tilename,tile_imageurl,status,createddate,createdby,updateddate,updatedby)values('" . $tile_id . "','" . $tile_name . "','" . $_FILES['tile_image']['name'] . "','" . $status . "',NOW(),'" . $userid . "',NOW(),'" . $userid . "')";
			mysql_query($sqlInsertTileInfo);
		} {
			$upload_type = "34";
			$target_path = $globalpath . "images/uploads/finaoimages";
			$upload_path = "/images/uploads/finaoimages";
			if ($_FILES['image']['name'] != "") {
				$upload_type = "34";
				$target_path = $target_path . $finao_id . "-" . basename($_FILES['image']['name']);

				@move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
				$uploadfile_name = $_FILES['image']['name'];
			}
			if ($_FILES['video']['name'] != "") {
				$upload_type = "35";
				$target_path = $target_path . $finao_id . "-" . basename($_FILES['video']['name']);
				@move_uploaded_file($_FILES['video']['tmp_name'], $target_path);
				$uploadfile_name = $_FILES['video']['name'];
			}
			$id   = $tile_id;
			$type = 'tile';
			if ($type == 'tile') {
				$upload_sourcetype = 36;
			}
			$sqlInsert = "insert into fn_uploaddetails(uploadtype,uploadfile_name,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img)values('" . $upload_type . "','" . $finao_id . "-" . basename($_FILES['image']['name']) . "','" . $upload_path . "','" . $upload_sourcetype . "','" . $finao_id . "','" . $userid . "',NOW(),'1','" . $userid . "',NOW(),'" . $caption . "','" . $videoid . "','" . $videostatus . "','" . $video_img . "')";
			mysql_query($sqlInsert);
		}
		$json             = array();
		$json['finao_id'] = $finao_id;
	} else {
		$json        = array();
		$json['res'] = "Cannot Create Duplicate Tile";
	}
	echo json_encode($json);
}
//--------------- 29
function createfiano($caption, $finao_msg, $tile_id, $atile_id, $tile_name, $userid, $finao_status_ispublic, $updatedby, $finao_status, $videoid, $videostatus, $video_img, $iscompleted)
{
	$json         = array();
	$json_test    = '{ "user_id":1 ,"finao_msg":"tester","tile_id":1,"tile_name":"tester test","finao_status_inpublic":1,"updatedby":1,"finao_status":1,"iscompleted":1,"tile_id":1,"tile_name":"test"}';
	$finao_status = 38;
	if ($tile_id == "") {
		$selectTile_id    = "select max(tile_id) as tilecount from fn_user_finao_tile";
		$selectTile_idRes = mysql_query($selectTile_id);
		$selectTile_idDet = mysql_fetch_array($selectTile_idRes);
		$tile_id          = ($selectTile_idDet['tilecount']) + 1;
	}
	$sqlInsert = "insert into fn_user_finao (userid,finao_msg,finao_status_ispublic,updatedby,finao_status,iscompleted,createddate,updateddate)values('" . $userid . "','" . $finao_msg . "','" . $finao_status_ispublic . "','" . $updatedby . "','" . $finao_status . "','" . $iscompleted . "',NOW(),NOW())";
	mysql_query($sqlInsert);
	$error_log = "one";
	$finao_id  = mysql_insert_id();
	if ($atile_id != "") {
		$target_path          = $globalpath . "images/tiles/";
		$sqlSelectTileData    = "select tile_profileImagurl,tile_name from  fn_user_finao_tile where tile_id=" . $atile_id . " and tile_profileImagurl<>''";
		$sqlSelectResTileData = mysql_query($sqlSelectTileData);
		if (mysql_num_rows($sqlSelectResTileData) > 0) {
			while ($sqlSelectDetTileData = mysql_fetch_array($sqlSelectResTileData)) {
				$tile_profileImagurl = $sqlSelectDetTileData['tile_profileImagurl'];
				//$tile_name=$sqlSelectDetTileData['tile_name'];
				@move_uploaded_file($target_path . $tile_profileImagurl, $target_path . $tile_profileImagurl);
				$tile_image = $tile_profileImagurl;
			}
		} else {
			$tile_image = $tile_id . "-" . $_FILES['tile_image']['name'];
		}

	} else {
		$tile_image = $tile_id . "-" . $_FILES['tile_image']['name'];
	}
	$target_path  = $globalpath . "images/tiles/";
	$target_thumb = $globalpath . "images/tiles/thumbs/";
	$upload_path  = "images/tiles/";
	if ($_FILES['tile_image']['name'] != "") {

		$target_path  = $target_path . basename($_FILES['tile_image']['name']);
		$target_thumb = $target_thumb . basename($_FILES['tile_image']['name']);
		@move_uploaded_file($_FILES['tile_image']['tmp_name'], $target_path);
		$uploadfile_name = basename($_FILES['tile_image']['name']);
		$resize          = new ResizeImage($target_path);
		$resize->resizeTo(200, 200, 'default');
		$resize->saveImage($target_thumb);
	}
	{
		$sqlInsertFianoTable = "insert into fn_user_finao_tile(tile_id,tile_name,userid,finao_id,tile_profileImagurl,status,createddate,createdby,updateddate,updatedby)values('" . $tile_id . "','" . $tile_name . "','" . $userid . "','" . $finao_id . "','" . $tile_image . "','1',NOW(),'" . $userid . "',NOW(),'" . $userid . "')";
		mysql_query($sqlInsertFianoTable);
		$error_log .= "two";
	
	
	}
	$upload_type   = "34";
	$target_path   = $globalpath . "images/uploads/finaoimages/";
	$target_thumb  = $globalpath . "images/uploads/finaoimages/thumbs/";
	$target_medium = $globalpath . "images/uploads/finaoimages/medium/";
	$upload_path   = "/images/uploads/finaoimages";
	if ($_FILES['image']['name'] != "") {
		$upload_type   = "34";
		$target_path   = $target_path . $finao_id . "-" . basename($_FILES['image']['name']);
		$target_thumb  = $target_thumb . $finao_id . "-" . basename($_FILES['image']['name']);
		$target_medium = $target_medium . $finao_id . "-" . basename($_FILES['image']['name']);
		@copy($_FILES['image']['tmp_name'], $target_path);
		$uploadfile_name = $_FILES['image']['name'];
		$fname           = $finao_id . "-" . basename($_FILES['image']['name']);
	}
	if ($_FILES['video']['name'] != "") {
		$upload_type = "35";
		$target_path = $target_path . $finao_id . "-" . basename($_FILES['video']['name']);
		@move_uploaded_file($_FILES['video']['tmp_name'], $target_path);
		$uploadfile_name = $_FILES['video']['name'];
		$video_caption   = "";
		$video_caption   = $caption;
		$caption         = "";
	}
	$id = $tile_id;
	//$type='tile';
	if ($type == 'tile') {
		$upload_sourcetype = 36;
	} else {
		$upload_sourcetype = 37;
	}
	if ($fname == "")
		$upload_path = "";
	$sqlInsert = "insert into fn_uploaddetails(uploadtype,uploadfile_name,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img,video_caption)values('" . $upload_type . "','" . $fname . "','" . $upload_path . "','" . $upload_sourcetype . "','" . $finao_id . "','" . $userid . "',NOW(),'1','" . $userid . "',NOW(),'" . addslashes($caption) . "','" . $videoid . "','" . $videostatus . "','" . $video_img . "','" . $video_caption . "')";
	//mysql_query($sqlInsert) or die("Unable to execute query");
	$error_log .= "four";

	if ($_FILES['image']['name'] != "") {
		$resize = new ResizeImage($target_path);
		$resize->resizeTo(100, 100, 'default');
		$resize->saveImage($target_thumb);
		$resize_m = new ResizeImage($target_path);
		$resize_m->resizeTo(400, 400, 'default');
		$resize_m->saveImage($target_medium);

	}
	$error_log .= "five";
	$json             = array();
	$json['finao_id'] = $finao_id;
	echo json_encode($json);
}
//--------------- 30
function addjournal($finao_id, $finao_journal, $journal_status, $user_id, $status_value, $createdby, $updatedby)
{
	$sqlInsert = "insert into fn_user_finao_journal(finao_id,finao_journal,journal_status,journal_startdate,user_id,status_value,createdby,createddate,updatedby,updateddate)values('" . $finao_id . "','" . $finao_journal . "','" . $journal_status . "',NOW(),'" . $user_id . "','" . $status_value . "','" . $createdby . "',NOW(),'" . $updatedby . "',NOW())";
	mysql_query($sqlInsert);
	$json        = array();
	$json['res'] = mysql_insert_id();
	echo json_encode($json);
}
//--------------- 31
function addNotification($tracker_userid, $user_id, $tile_id, $finao_id, $journal_id, $notification_action, $updatedby, $createdby)
{
	$sqlInsert = "insert into fn_trackingnotifications(tracker_userid,tile_id,finao_id,journal_id,notification_action,updateby,updateddate,createdby,createddate)values()";
	mysql_query($sqlInsert) or die("Insert Query Failed");
}
//--------------- 32
function addTracker($tracker_userid, $tracked_userid, $tracked_tileid, $status)
{
	$json         = array();
	$sqlSelect    = "select tracking_id from fn_tracking where tracker_userid=" . $tracked_userid . " and tracked_userid=" . $tracker_userid . " and tracked_tileid=" . $tracked_tileid;
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_array($sqlSelectRes)) {
			$id        = $sqlSelectDet['tracking_id'];
			$sqlUpdate = "delete from fn_tracking where tracker_userid='" . $tracked_userid . "' and tracked_userid='" . $tracker_userid . "' and tracker_userid='" . $tracked_userid . "'";
			mysql_query($sqlUpdate) or die("Delete Query Failed");
		}
	} else {
		$status   = 1;
		$sqlQuery = "insert into fn_tracking(tracker_userid,tracked_userid,tracked_tileid,status)values('" . $tracked_userid . "','" . $tracker_userid . "','" . $tracked_tileid . "','" . $status . "')";
		mysql_query($sqlQuery) or die("Insert Query Failed");
		$id = mysql_insert_id();
	}
	$json['res'] = $id;
	echo json_encode($json);
}
//--------------- 33
function updateTracker($tracker_userid, $tracked_userid, $tracked_tileid, $tracking_id, $status)
{
	$json      = array();
	$sqlUpdate = "update fn_tracking set status='" . $status . "' where tracking_id='" . $tracking_id . "'";
	mysql_query($sqlUpdate) or die("Insert Query Failed");
	$json['res'] = "updated";
	echo json_encode($json);
}
//--------------- 34
function addTrackerInfo($tracker_userid, $tracked_userid, $tracked_tileid, $notification_action, $tile_id, $finao_id, $journal_id)
{
	$json      = array();
	$sqlInsert = "insert into fn_trackingnotifications(tracker_userid,tile_id, finao_id,journal_id, notification_action,     updateby,updateddate,createdby,createddate)values('" . $tracker_userid . "','" . $tile_id . "','" . $finao_id . "','" . $journal_id . "','" . $notification_action . "','" . $tracked_userid . "',NOW(),'" . $tracked_userid . "',NOW())";
	mysql_query($sqlInsert) or die("Insert Query Failed");
	$json['res'] = mysql_insert_id();
	echo json_encode($json);
}
//--------------- 35
function IamTrackings($tracker_userid, $finao_id)
{
	$json      = array();
	$sqlSelect = "select select ft.trackingnotification_id,ft.tracker_userid,ft.tile_id,ft.finao_id,ft.journal_id,fu.uname,fp.profile_image,tile_name from fn_trackingnotifications ft join fn_users fu  join  fn_user_profile fp join fn_user_finao_tile ftl on ft.tile_id=ftl.tile_id and fu.userid=fp.user_id and ft.tracker_userid = fu.userid from fn_trackingnotifications where updateby=" . $tracker_userid;
	if ($_REQUEST['finao_id'] != "")
		$sqlSelect .= " and ft.finao_id=" . $finao_id;
	$sqlSelect .= " GROUP BY finao_id";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectUploadDet = mysql_fetch_assoc($sqlSelectRes)) {
			$rows[] = $sqlSelectUploadDet;
		}
	}
	$json['res'] = $rows;
	echo json_encode($json);
}
//--------------- 36
function followers($user_id)
{
	$row=array();
	$sql=mysql_query("call follower('$user_id')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['fname']=$obj->fname;
			$row['lname']=$obj->lname;
			$row['userid']=$obj->userid;
			$row['mystory']=$obj->mystory;
			$row['gptilename']=$obj->name;
			$row['image']=$obj->profile_img;
			$row['tracker_userid']=$obj->tracker_id	;
			$row['tile_id']=$obj->tileid;
			$row['tracked_userid']=$obj->trackedid;
			$row['finao_msg']=$obj->finaomsg;
			$row['totalfollowers']=$obj->follower;
			$row['totaltiles']=$obj->totaltile;
			$row['totalfinaos']=$obj->totalfinao;
			$row['totalfollowings']=$obj->following;
			$row['totalinspired']=$obj->inspired;
			$row['status']=$obj->status;



			$data[] = $row;
		}
		$json['res'] = $data;
	}
	else{
		$json['res'] = 'No followers';
	}

	echo	json_encode($json);


}

//---------------37
function followings($user_id)
{
	$json              = array();
	$rows              = "";
	$sqlMyTrackings    = "select t.fname,t.lname,t.userid, t5.mystory, group_concat(Distinct t4.tilename ORDER BY t4.tilename SEPARATOR ', ') as gptilename, t5.profile_image as image,t1.tracker_userid,t4.tile_id,t1.tracker_userid,t1.tracked_userid,t1.status,t2.finao_msg from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '" . $user_id . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
	$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
	$totalfollowers    = mysql_num_rows($sqlMyTrackingsRes);
	if ($totalfollowers > 0) {
		while ($sqlMyTrackingsDet = mysql_fetch_assoc($sqlMyTrackingsRes)) {
			$userid                              = $sqlMyTrackingsDet['userid'];
			$totalfollowers                      = 0;
			$sqlMyTrackingsDet['totalfollowers'] = fngetTotalFollowers($userid);
			$totaltiles                          = 0;
			$sqlMyTrackingsDet['totaltiles']     = fngetTotalTiles($userid, "search");
			$totaltiles                          = 0;
			$sqlTilesCount                       = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =" . $userid . " AND finao_activestatus !=2 ";

			$sqlTilesCount .= " and `finao_status_Ispublic` =1";
			$sqlTilesCount .= " GROUP BY tile_id ";
			$sqlTilesCountRes                     = mysql_query($sqlTilesCount);
			$totaltiles                           = mysql_num_rows($sqlTilesCountRes);
			$sqlMyTrackingsDet['totaltiles']      = $totaltiles;
			$totalfinaos                          = 0;
			$sqlMyTrackingsDet['totalfinaos']     = fngetTotalFinaos($userid, "followings");
			$totalfollowings                      = 0;
			$sqlMyTrackingsDet['totalfollowings'] = fngetTotalFollowings($userid);
			$rows[]                               = $sqlMyTrackingsDet;
		}
	}
	$json['res'] = $rows;
	echo json_encode($json);
}
//--------------- 38
function MyTrackings($tracker_userid, $finao_id)
{
	$json      = array();
	$sqlSelect = "SELECT t.*, t1.tile_name FROM `fn_tracking` `t`  join fn_user_finao_tile t1 on t.tracked_tileid = t1.tile_id and t.tracker_userid = t1.userid  join fn_user_finao t2 on t1.finao_id = t2.user_finao_id  and finao_activestatus != 2 and finao_status_Ispublic = 1 WHERE  t.tracked_userid = " . $tracker_userid . " and t.status = 0 GROUP BY  t1.tile_id, t1.tile_name";
	//$sqlSelect.=" AND ft.status=0 GROUP BY tracking_id";
	if ($_REQUEST['finao_id'] != "")
		$sqlSelect .= " and t.finao_id=" . $finao_id;

	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectUploadDet = mysql_fetch_assoc($sqlSelectRes)) {
			$sqlSelectUploadDet['profile_image'] = "";
			$sqlSelectUploadDet['uname']         = "";
			$sqlSelectProf                       = "select concat(fname,' ',lname) as uname,fu.profile_image from fn_user_profile fu right join fn_users f on fu.user_id=f.userid where f.userid=" . $sqlSelectUploadDet['tracker_userid'];
			$sqlSelectProfRes                    = mysql_query($sqlSelectProf);
			if (mysql_num_rows($sqlSelectProfRes) > 0) {
				while ($sqlSelectProfDet = mysql_fetch_assoc($sqlSelectProfRes)) {
					$sqlSelectUploadDet['profile_image'] = $sqlSelectProfDet['profile_image'];
					$sqlSelectUploadDet['uname']         = $sqlSelectProfDet['uname'];
				}
			}
			$rows[] = $sqlSelectUploadDet;
		}
	}
	$json['res'] = $rows;
	echo json_encode($json);
}
//--------------- 39
function IamTracking($updateby, $finao_id)
{
	$json      = array();
	$sqlSelect = "select * from fn_trackingnotifications where updateby=" . $updateby;
	if ($finao_id != "")
		$sqlSelect .= " and finao_id=" . $finao_id;
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectUploadDet = mysql_fetch_assoc($sqlSelectRes)) {
			$rows[] = $sqlSelectUploadDet;
		}
	}
	$json        = array();
	$json['res'] = $rows;
	echo json_encode($json);
}
//--------------- 40
function ListTrackerUsingFiano($tracker_userid, $notification_action, $tile_id, $finao_id, $status)
{
	$json      = array();
	$sqlSelect = "select * from fn_trackingnotifications where trackingnotification_id<>''";
	if ($finao_id != "")
		$sqlSelect .= "and finao_id=" . $finao_id;
	if ($tile_id != "")
		$sqlSelect .= "and tile_id=" . $tile_id;
	$sqlSelectRes = mysql_query($sqlSelect);
	while ($det = mysql_fetch_assoc($sqlSelectRes)) {
		$json['res'][] = $det;
	}
	echo json_encode($json);
}
//--------------- 41
function modifyjournal($finao_journal_id, $finao_journal, $journal_status, $user_id, $status_value, $updatedby)
{
	$json      = array();
	$sqlInsert = "update fn_user_finao_journal set finao_journal='" . $finao_journal . "',journal_status='" . $journal_status . "',status_value='" . $status_value . "',updatedby='" . $user_id . "',updateddate=NOW() where finao_journal_id='" . $finao_journal_id . "'";
	mysql_query($sqlInsert);
	$json['res'] = "ok";
	echo json_encode($json);
}
//--------------- 42
function modifyfiano($finao_id, $userid, $finao_msg, $finao_status_ispublic, $updatedby, $finao_status, $iscompleted)
{
	$json = array();
	if ($finao_status == 1)
		$finao_status = 38;
	$sqlUpdate = "update fn_user_finao set finao_status_ispublic='" . $finao_status_ispublic . "',updateddate=NOW(),updatedby='" . $updatedby . "',finao_status='" . $finao_status . "',iscompleted='" . $iscompleted . "' where user_finao_id='" . $finao_id . "'";
	mysql_query($sqlUpdate) or die("Update Query Failed");
	$json['res'] = "OK";
	echo json_encode($json);
}
//--------------- 43
function changefinao($finao_id, $user_id, $finao_msg)
{
	$json      = array();
	$sqlUpdate = "update fn_user_finao set finao_msg='" . $finao_msg . "' where user_finao_id='" . $finao_id . "'";
	mysql_query($sqlUpdate) or die("Update Query Failed");

	$upload_type  = "34";
	$target_path  = $globalpath . "images/uploads/finaoimages";
	$target_thumb = $globalpath . "images/uploads/finaoimages/thumbs";
	$upload_path  = "/images/uploads/finaoimages"; {
		$upload_type  = "34";
		$target_path  = $target_path . $finao_id . "-" . basename($_FILES['image']['name']);
		$target_thumb = $target_thumb . $finao_id . "-" . basename($_FILES['image']['name']);
		@move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
		$uploadfile_name = $_FILES['image']['name'];
		$resize          = new ResizeImage($target_path);
		$resize->resizeTo(100, 100, 'default');
		$resize->saveImage($target_thumb);
		$sqlUpdate = "update fn_uploaddetails set uploadfile_name='" . $finao_id . "-" . basename($_FILES['image']['name']) . "',updatedby='" . $user_id . "',updateddate=NOW() where upload_sourceid=" . $finao_id . " and uploadedby=" . $user_id . " and (uploadtype=34 or uploadtype=62) and upload_sourcetype=37";
		mysql_query($sqlUpdate) or die("Update Query Failed");
	}
	$json['res'] = "OK" . $sqlUpdate;
	echo json_encode($json);
}
//--------------- 44
function editprofile($user_profile_msg, $user_location, $profile_image, $profile_bg_image, $profile_status_Ispublic, $updatedby, $mystory, $iscompleted, $user_id, $email, $secondary_email, $fname, $lname, $gender, $location, $dob, $age, $socialnetwork, $socialnetworkid, $usertypeid, $status, $zipcode, $uname)
{

	$json         = array();
	$target_path  = @"../../finaonation/images/uploads/profileimages/";
	$target_thumb = @"../../finaonation/images/uploads/profileimages/thumbs/";
	$upload_path  = "images/uploads/profileimages/";
	if ($_FILES['profile_image']['name'] != "") {
		$target_path  = $target_path . basename($_FILES['profile_image']['name']);
		$target_thumb = $target_thumb . basename($_FILES['profile_image']['name']);
		@move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path);
		$profile_image = $_FILES['profile_image']['name'];

		$resize = new ResizeImage($target_path);
		$resize->resizeTo(200, 200, 'default');
		$resize->saveImage($target_path);

		$resize1 = new ResizeImage($target_path);
		$resize1->resizeTo(120, 90, 'default');
		$resize1->saveImage($target_thumb);
	}
	if ($_FILES['profile_bg_image']['name'] != "") {
		$target_path = $target_path . basename($_FILES['profile_bg_image']['name']);
		@move_uploaded_file($_FILES['profile_bg_image']['tmp_name'], $target_path);
		$profile_bg_image = $_FILES['profile_bg_image']['name'];
	}
	$selectUpdateProfile    = "select * from fn_user_profile where user_id='" . $user_id . "'";
	$selectUpdateProfileRes = mysql_query($selectUpdateProfile);
	if (mysql_num_rows($selectUpdateProfileRes) > 0) {
		$sqlUpdateProfile = "update fn_user_profile set user_location='" . $user_location . "' ";
		if ($_FILES['profile_image']['name'] != "") {
			$sqlUpdateProfile .= ",profile_image='" . $profile_image . "'";
		}
		$sqlUpdateProfile .= ",updatedby='" . $updatedby . "',updateddate=NOW(),mystory='" . $mystory . "' where user_id='" . $user_id . "'";
		mysql_query($sqlUpdateProfile);
	} else {
		$sqlInsertProfile = "insert into fn_user_profile(user_id,createdby,updatedby,user_profile_msg,user_location,profile_image,profile_bg_image,profile_status_Ispublic,updateddate,mystory,IsCompleted)values('" . $user_id . "','" . $user_id . "','" . $user_id . "','" . $user_profile_msg . "','" . $user_location . "','" . $profile_image . "','" . $profile_bg_image . "','" . $profile_status_Ispublic . "',NOW(),'" . $mystory . "','" . $iscompleted . "')";

		mysql_query($sqlInsertProfile);
	}
	$json['res']  = "OK";
	$sqlSelect    = "select * from fn_users where email='" . $email . "'";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		$sqlUpdateUserdata = "update fn_users set uname='" . $uname . "',";
		$sqlUpdateUserdata .= "fname='" . $fname . "',lname='" . $lname . "',location='" . $location . "',updatedby='" . $updatedby . "',updatedate=NOW() where userid='" . $user_id . "'";
		mysql_query($sqlUpdateUserdata);

	} else {
		$json['res'] = "Email has already been in use";
	}
	echo json_encode($json);
}

//--------------- 45
function uploadvideoorimage_old($response, $videostatus, $id, $user_id, $caption, $type)
{

	$json        = array();
	$target_path = $globalpath . "images/uploads/finaoimages";
	$upload_path = "images/uploads/finaoimages";

	if ($_FILES['image']['name'] != "") {
		$upload_type = "34";
		$target_path = $target_path . $id . "-" . basename($_FILES['image']['name']);
		@move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
		$uploadfile_name = basename($_FILES['image']['name']);
	}
	if ($_FILES['video']['name'] != "") {
		$upload_type = "35";
		$target_path = $target_path . $id . "-" . basename($_FILES['video']['name']);
		@move_uploaded_file($_FILES['video']['tmp_name'], $target_path);
		set_time_limit(0);
		$endpoint = (isset($response['upload']['endpoint'])) ? $response['upload']['endpoint'] : NULL;
		$token    = (isset($response['upload']['token'])) ? $response['upload']['token'] : NULL;
		$query    = array(
				'uploadtoken' => $token,
				'title' => 'Video from iphone App',
				'description' => 'Video from iphone App',
				'tags' => 'testing,upload',
				'file' => '@../../finaonation/images/uploads/finaoimages/' . $id . "-" . basename($_FILES['video']['name'])
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
		$response    = curl_exec($ch);
		$info        = curl_getinfo($ch);
		$header_size = $info['header_size'];
		$header      = substr($response, 0, $header_size);
		$video       = unserialize(substr($response, $header_size));
		curl_close($ch);
		@unlink('../../finaonation/images/uploads/finaoimages/' . $_FILES['video']['name']);
		$videoid   = $video['video']['id'];
		$video_img = $video['video']['thumbnail_url'];
	}

	if ($type == 'fiano') {
		$upload_sourcetype = 37;
	} else if ($type == 'journal') {
		$upload_sourcetype = 46;
	} else if ($type == 'tile') {
		$upload_sourcetype = 36;
	}

	if ($_FILES['video']['name'] != "") {

		$target_path = "";
	}
	$sqlInsert = "insert into fn_uploaddetails(uploadtype,uploadfile_name,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img)values('" . $upload_type . "','" . $uploadfile_name . "','" . $upload_path . "','" . $upload_sourcetype . "','" . $id . "','" . $user_id . "',NOW(),'1','" . $user_id . "',NOW(),'" . $caption . "','" . $videoid . "','" . $videostatus . "','" . $video_img . "')";
	mysql_query($sqlInsert);
}
//--------------- 46
function uploadvideoorimage($userid, $session_id)
{

	$json          = array();
	$target_path   = $globalpath . "images/uploads/finaoimages/";
	$target_thumb  = $globalpath . "images/uploads/finaoimages/thumbs/";
	$target_medium = $globalpath . "images/uploads/finaoimages/medium/";
	$upload_path   = "/images/uploads/finaoimages";

	if ($_FILES['image']['name'] != "") {
		$upload_type   = "34";
		$target_path   = $target_path . $id . "-" . basename($_FILES['image']['name']);
		$target_thumb  = $target_thumb . $id . "-" . basename($_FILES['image']['name']);
		$target_medium = $target_medium . $id . "-" . basename($_FILES['image']['name']);
		@move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
		$uploadfile_name = $id . "-" . basename($_FILES['image']['name']);

		$resize = new ResizeImage($target_path);
		$resize->resizeTo(100, 100, 'default');
		$resize->saveImage($target_thumb);

		$resize_m = new ResizeImage($target_path);
		$resize_m->resizeTo(240, 240, 'default');
		$resize_m->saveImage($target_medium);
	}
	if ($_FILES['video']['name'] != "") {
		$upload_type = "35";
		$target_path = $target_path . $id . "-" . basename($_FILES['video']['name']);
		@move_uploaded_file($_FILES['video']['tmp_name'], $target_path);
		set_time_limit(0);
		$endpoint = (isset($response['upload']['endpoint'])) ? $response['upload']['endpoint'] : NULL;
		$token    = (isset($response['upload']['token'])) ? $response['upload']['token'] : NULL;
		$query    = array(
				'uploadtoken' => $token,
				'title' => 'Video from iphone App',
				'description' => 'Video from iphone App',
				'tags' => 'testing,upload',
				'file' => '@../../finaonation/images/uploads/finaoimages/' . $id . "-" . basename($_FILES['video']['name'])
		);
		$ch       = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		$response    = curl_exec($ch);
		$info        = curl_getinfo($ch);
		$header_size = $info['header_size'];
		$header      = substr($response, 0, $header_size);
		$video       = unserialize(substr($response, $header_size));
		curl_close($ch);
		@unlink('../../finaonation/images/uploads/finaoimages/' . $id . "-" . $_FILES['video']['name']);
		$videoid   = $video['video']['id'];
		$video_img = $video['video']['thumbnail_url'];

		$video_caption = "";
		$video_caption = $caption;
		$caption       = "";
	}
	if ($upload_text != "") {
		$upload_type = "62";
	}
	if ($type == 'fiano') {
		$upload_sourcetype = 37;
	} else if ($type == 'journal') {
		//$upload_sourcetype=46;
	} else if ($type == 'tile') {
		$upload_sourcetype = 36;
	}
	if ($_FILES['video']['name'] != "") {

		$target_path = "";
	}
	if ($_FILES['video']['name'] == "" && $_FILES['image']['name'] == "" && $upload_text != "") {

		$upload_path = "";
	}
	if ($user_id == "") {
		if ($id != "" && $type == 'fiano') {
			$sqlSelect    = "SELECT userid FROM  `fn_user_finao` where user_finao_id=" . $id;
			$sqlSelectRes = mysql_query($sqlSelect);
			if (mysql_num_rows($sqlSelectRes) > 0) {
				$sqlSelectDet = mysql_fetch_array($sqlSelectRes);
				$user_id      = $sqlSelectDet['userid'];
			}
		}
	}
	$sqlInsert = "insert into fn_uploaddetails(uploadtype,uploadfile_name,upload_text,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img,video_caption)values('" . $upload_type . "','" . $uploadfile_name . "','" . $upload_text . "','" . $upload_path . "','" . $upload_sourcetype . "','" . $id . "','" . $user_id . "',NOW(),'1','" . $user_id . "',NOW(),'" . $caption . "','" . $videoid . "','" . $videostatus . "','" . $video_img . "','" . $video_caption . "')";
	mysql_query($sqlInsert);
	if ($type == 'fiano') {
		if ($id != "") {
			$sqlUpdate = "update fn_user_finao set updateddate=NOW(),updatedby=" . $user_id . " where user_finao_id=" . $id;
			mysql_query($sqlUpdate);
		}
	}
}
//--------------- 47
function getimageorvideo($session_id, $type, $srctype, $srcid, $user_id)
{
	$json = array();
	set_time_limit(0);
	$sqlSelect    = "select * from fn_lookups where lookup_type='uploadtype' and Lower(lookup_name)='" . $type . "'";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$lookup_id = $sqlSelectDet['lookup_id'];
		}
	}
	$sqlSelectSrctype    = "select * from fn_lookups where lookup_type='uploadsourcetype' and Lower(lookup_name)='" . $srctype . "'";
	$sqlSelectSrctypeRes = mysql_query($sqlSelectSrctype);
	if (mysql_num_rows($sqlSelectSrctypeRes) > 0) {
		while ($sqlSelectSrctypeDet = mysql_fetch_assoc($sqlSelectSrctypeRes)) {
			$srclookup_id = strtolower($sqlSelectSrctypeDet['lookup_id']);
		}
	}
	if ($type == 'Image') {
		$sqlSelectUpload = "select * from fn_uploaddetails where  upload_sourcetype='" . $srclookup_id . "' and (uploadtype='34'  or uploadtype='62') ";
		if ($srcid != "")
			$sqlSelectUpload .= " and upload_sourceid='" . $srcid . "'";
		$sqlSelectUpload .= " and uploadedby='" . $user_id . "'  order by uploaddetail_id DESC";
	} else {
		$sqlSelectUpload = "select * from fn_uploaddetails where  upload_sourcetype='" . $srclookup_id . "' and (uploadtype='35' or uploadtype='62')";
		if ($srcid != "")
			$sqlSelectUpload .= " and upload_sourceid='" . $srcid . "'";
		$sqlSelectUpload .= " and uploadedby='" . $user_id . "'  order by uploaddetail_id DESC";
	}
	$sqlSelectVideoRes = mysql_query($sqlSelectUpload);
	if (mysql_num_rows($sqlSelectVideoRes) > 0) {
		while ($sqlSelectVideoDet = mysql_fetch_assoc($sqlSelectVideoRes)) {

			if (!empty($sqlSelectVideoDet['videoid'])) {
				$videosource = curl_file_get_contents("http://api.viddler.com/api/v2/viddler.videos.getDetails.json?sessionid=" . $session_id . "&key=1mn4s66e3c44f11rx1xd&video_id=" . $sqlSelectVideoDet['videoid']);

				$video                          = json_decode(unserialize($videosource), true);
				$sqlSelectVideoDet['videofrom'] = "";

				foreach ($video['video']['files'] as $k => $v) {

					if ($v['html5_video_source'] != "")
						$sqlSelectVideoDet['videosource'] = $v['html5_video_source'];
				}
				$rows[] = (unstrip_array($sqlSelectVideoDet));
			} else {
				$str                                 = str_replace("/default.jpg", "", $sqlSelectVideoDet['video_img']);
				$str                                 = str_replace("http://img.youtube.com/vi/", "", $str);
				$sqlSelectVideoDet['video_embedurl'] = "";
				$sqlSelectVideoDet['videofrom']      = "youtube";
				if ($str != "")
					$str = "http://www.youtube.com/embed/" . $str;
				$sqlSelectVideoDet['videosource'] = $str;
				$rows[]                           = (unstrip_array($sqlSelectVideoDet));
			}

		}
	}
	$json        = array();
	$json['res'] = $rows;
	echo json_encode($json);
}
//--------------- 48
function getuser_finaocounts($userid, $actual_user_id)
{
	$totalfollowers         = 0;
	$rows['totalfollowers'] = fngetTotalFollowers($userid);
	$totaltiles             = 0;
	$rows['totaltiles']     = fngetTotalTiles_counts($userid, $actual_user_id);

	$totaltiles              = 0;
	$sqlTilesCount           = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='" . $userid . "' AND Iscompleted =0 AND finao_activestatus !=2  GROUP BY tile_id";
	$sqlTilesCountRes        = mysql_query($sqlTilesCount);
	$rows['totaltiles']      = mysql_num_rows($sqlTilesCountRes);
	$rows['totaltiles']      = fngetTotalTiles_counts($userid, $actual_user_id);
	$totalfinaos             = 0;
	$rows['totalfinaos']     = fngetTotalFinaos($userid, $actual_user_id);
	$totalfollowings         = 0;
	$rows['totalfollowings'] = fngetTotalFollowings($userid);
	$json                    = array();
	$json['res']             = $rows;
	echo json_encode($json);
}


function markinappropriatepost($userid, $userpostid){
	$json = array();
	if($userid > 0 )
	{
		if($userpostid > 0){
			$result = mysql_query("call markinappropriatepost('$userpostid', '$userid')");
			if($result){

				$inappropriatepostid = mysql_fetch_object($result)->inappropriatepostid;
				$json['inappropriatepostid']=$inappropriatepostid;
				$response = generateResponse(TRUE, 'success', $json );
			}
			else{
				$response = generateResponse(FALSE, "Not able to mark inappropriate");
			}
		}
		else{
			$response = generateResponse(FALSE, WRONG_DATA);
		}
	}
	else{
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);
}
function profiledetails($user_id){
	$json = array();

	if($user_id > 0){
		$result = mysql_query("call settings_getuserdetails( '$user_id ') ");
		if($result){
			$logobj = mysql_fetch_object($result);

			$data['userid'] = $user_id;
			$data['name'] = $logobj->uname;
			$data['email'] = $logobj->email;
			$data['fname'] = $logobj->fname;
			$data['lname'] = $logobj->lname;
			$data['profile_image'] = $logobj->profile_image;
			$data['profile_banner_image'] = $logobj->profile_bg_image;
			$data['mystory'] = $logobj->mystory;
			$data['tagnote'] = $logobj->user_profile_msg;

			$response = generateResponse(TRUE, 'success', $data );

		}
		else{
			$response = generateResponse(FALSE, getErrorMessage(mysql_errno()));

		}
	}
	else{
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);
}


function searchdata($search){

	$json =array();
	if($search != null || $search != ''){
		$query="call search_user('$search')";
		$sqlsearch = mysql_query($query);
		if($sqlsearch)
		{
			if(mysql_num_rows($sqlsearch)>0){
				while($sqlSearchData=mysql_fetch_array($sqlsearch)){
					$data['resultid'] = $sqlSearchData['resultid'];
					$data['resulttype'] = $sqlSearchData['resulttype'];
					$data['name'] = $sqlSearchData['name'] ;
					$data['image'] = $sqlSearchData['image'];
					$data['totalfinaos']=$sqlSearchData['totalfinaos'];
					$data['totaltiles']=$sqlSearchData['totaltiles'];
					$data['totalfollowings']=$sqlSearchData['totalfollowings'];
					$data['totalfollowers']=$sqlSearchData['totalfollowers'];
					$data['mystory']=$sqlSearchData['mystory'];

					$rows[] = $data;
				}
				$response = generateResponse(TRUE, "success",$rows);
			}
			else{
				$response = generateResponse(TRUE, NO_RESULT);
			}
		}
		else{
			$response = generateResponse(FALSE, WRONG_DATA);
		}
	}
	else{
		$response = generateResponse(FALSE, WRONG_DATA);
	}
	echo json_encode($response);
}


function getinspiredfrompost($userid, $userpostid){
	$json = array();
	if($userid > 0 )
	{
		if( $userpostid > 0){
			$result = mysql_query("call inspiringpost('$userpostid', '$userid')");
			if($result){
				$inspiringpostid = mysql_fetch_object($result)->inspiringpostid;
				$json['inspiringpostid']=$inspiringpostid;
				$response = generateResponse(TRUE,'success');
			}
			else{
				$response = generateResponse(FALSE, getErrorMessage(mysql_errno()));
					
			}
		}
		else{
			$response = generateResponse(FALSE,WRONG_DATA);
		}
	}
	else{
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}

	echo json_encode($response);
}
function unfollowuser($userid, $followeduserid, $tileid)
{

}

function deletepost($userid, $finao_id, $userpostid){
	$json = array();
	if($userid > 0)
	{
		if( $finao_id > 0 && $userpostid > 0){
			$sqldelete = mysql_query("call deletepost('$finao_id', '$userpostid', '$userid')");
			if($sqldelete){
				$result = mysql_fetch_object($sqldelete);

				$response = generateResponse(TRUE, 'success');
			}
			else{
				$response = generateResponse(FALSE, 'post not deleted ');
			}
		}
		else{
			$response = generateResponse(FALSE, WRONG_DATA);
		}
	}
	else	{
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);
}

function followuser($userid, $followeduserid, $tileid){

	$json = array();
	if($userid > 0)
	{
		if(  ($followeduserid > 0 || $tileid > 0)){
			$result = mysql_query("call followuser('$userid', '$followeduserid', '$tileid')");

			if($result){
				$userfollowerid = mysql_fetch_object($result)->userfollowerid;
				$json['userfollowerid']=$userfollowerid;
				$response = generateResponse(TRUE, 'success', $json);
			}
			else{
				$response = generateResponse(FALSE,'Already following this tile');
			}
		}
		else{
			$response = generateResponse(FALSE, DATA, WRONG_DATA);
		}
	}
	else {
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);
}

function createpost($finao_id,$postmsg,$user_id){
	if($user_id > 0 )
	{
		$uploadfile_name="";
		$uploadtype=62;
		$uploadsource=37;
		$uploadpath= $globalpath."images/uploads/postimages/";
		if (!empty($_FILES['postimage']['name'])) {
			$uploadtype=34;
			 $uploadfile_name = $finao_id . "-" . $_FILES['postimage']['name'];
			$tmpname         = $_FILES['postimage']['tmp_name'];
			$target_main     =  $uploadpath . $uploadfile_name;
			move_uploaded_file($tmpname, $target_main);
		}
		if( $finao_id > 0){

			$insertquery = mysql_query("call createpost('$finao_id','$uploadtype', '$user_id','$postmsg','$uploadpath' ,'  $uploadsource','$uploadfile_name')");
			$insert_id=mysql_insert_id();
		
			$response = generateResponse(True, 'succefully created post'.$insert_id);
		}
	}
	else {
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);
}

function  getusertiles($userid,$ispublic,$iscompletedstatus)
{

	$data = Array();
	if($userid > 0){
		$result = mysql_query("call getuserstile('$userid','$iscompletedstatus','$ispublic')");

		if($result){
			while($obj = mysql_fetch_object($result)){


				$data['user_tileid']=$obj->user_tileid;
				$data['tile_id'] = $obj->tile_id;
				$data['tilename'] = $obj->tile_name;
				$data['tile_imageurl'] = $obj->tile_profileImagurl;

				$data['status']=$obj->status;
				$data['createddate']=$obj->createddate;
				$data['createdby']=$obj->createdby;
				$data['updateddate']=$obj->updateddate;
				$data['updatedby']=$obj->updatedby;
				$data['finao_message']=$obj->finao_msg;
				$data['finao_id']=$obj->user_finao_id	;
				$data['explore_finao']=$obj->explore_finao;




				$rows[] = $data;
			}
			$response = generateResponse(TRUE,'success', $rows);
		}
		else{
			$response = generateResponse(FALSE, 'No tiles');
		}
	}
	else{
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);
}
function getinterestedvisitors($fromdate, $todate){
	$json =array();
	$sqlquery = "call getinterestedvisitors('$fromdate', '$todate')";
	$result = mysql_query($sqlquery);
	if($result){
		if(mysql_num_rows($result) > 0){
			while($logobj = mysql_fetch_object($result)){
				$data['email'] = $logobj->email;
				$data['phone_number'] = $logobj->phone_num;
				$data['ip address'] = $logobj->ip;
				$data['date'] = $logobj->date;
				$rows[] = $data;
			}
			$response = generateNewResponse(TRUE, $rows, NULL, 'NONE', NONE, "success");
		}
		else{
			$response = generateNewResponse(TRUE, NULL, NULL, 'NONE', NONE, NO_RESULT);
		}
	}
	else{
		$response = generateNewResponse(FALSE, NULL, NULL, 'SQL', mysql_errno(), getErrorMessage(mysql_errno()));

	}
	echo json_encode($response);
}
function  sendemail($fname,$lname,$email)
{

	$name = $fname." ".$lname;
	$to=$email;
	//$headers = 'From: no-reply@bizindia.com' . "\r\n" .'Reply-To: no-reply@bizindia.org' . "\r\n" .'X-Mailer: PHP/' . phpversion();
	$headers .= "Reply-To: Finao <admin@finaonation.com>\r\n";
	$headers .= "Return-Path:Finao <admin@finaonation.com>\r\n";
	$headers .= "From: Finao <admin@finaonation.com>\r\n";
	$headers .= "Organization: finaonation\r\n";
	$headers .= "Content-Type: text/plain\r\n";
	$headers .= 'X-Mailer: PHP/' . phpversion();
	$to = strtolower(trim($to));
	//$headers .= 'Cc: '.$cc . "\r\n";
	//$headers .= 'Bcc: '.$bcc . "\r\n";
	$subject="Finao : Registration Link";
	//$message.="http://finaonationb.com/site/finao_web/index.php?r=site/activkey=".$activekey."&email=".$email;

	$activekey=md5(rand_string(10));
	$message.="<a href='http://" . BASE_URL . "index.php?r=site/activation&activationkey=". $activekey ."&email=". $email ."'> Click Here </a>";	$sqlUpdate="update fn_users set activkey='".$activekey."' where email='".$email."'";
	mysql_query($sqlUpdate);

	$message =trim($message);
	$subject=trim($subject);
	$mail             = new PHPMailer(); // defaults to using php "mail()"
	$body             = $message;
	$body             = eregi_replace("[\]",'',$body);

	$mail->AddReplyTo("admin@finaonation.com","Administrator");

	$mail->SetFrom('admin@finaonation.com', 'Administrator');

	$mail->AddReplyTo("admin@finaonation.com","Administrator");


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

function registration($type, $email, $password, $fname, $lname, $facebookid)
{
	$json    = array();
	// 1-normal registration, 2-facebook registration
	try {
	$mystory = "";
	if ($type == 1) {
		$sqlSelect = mysql_query("select userid from fn_users where email='" . $email . "' limit 1");
		if (mysql_num_rows($sqlSelect) == 0) {
	
				$proxy = new SoapClient(host); // TODO : change url
				$sessionId = $proxy->login(username, password);
				$store = 1;
				$website = 1;
				$newCustomer = array(
						'exceptions' => true,
						'firstname'       => $fname,
						'lastname'        => $lname,
						'email'           => $email,
						'password_hash'   => $password,
						'store_id'        => $store,
						'website_id'      => $website
				);

				$mageid = $proxy->call($sessionId, 'customer.create', array($newCustomer));
		
			$sqlInsert = "insert into fn_users(password,email,fname,lname,usertypeid,status,createtime,mageid)
			values ('" . $password . "','" . $email . "','" . $fname . "','" . $lname . "',64,0,NOW(),'" . $mageid . "')";
			mysql_query($sqlInsert);
			$insert_id = mysql_insert_id();

			if (!empty($_FILES['profilepic']['name'])) {
				$uploadfile_name = $insert_id . "-" . $_FILES['profilepic']['name'];
				$tmpname         = $_FILES['profilepic']['tmp_name'];
				$target_main     = PROFILE_IMG_PATH . $uploadfile_name;
				move_uploaded_file($tmpname, $target_main);
				// updating user profile
				$sqlProfileImage = "insert into fn_user_profile (user_id, profile_image, createdby, createddate, updatedby, updateddate, temp_profile_image) values ($insert_id, '$uploadfile_name', $insert_id, NOW(), $insert_id, NOW(), '$uploadfile_name')";
				mysql_query($sqlProfileImage);
			} else {
				$sqlProfileImage = "insert into fn_user_profile (user_id, createdby, createddate, updatedby, updateddate) values ($insert_id, $insert_id, NOW(), $insert_id, NOW())";
				mysql_query($sqlProfileImage);
			}

			sendemail($fname, $lname, $email);

			$json            = array();
			$data['userid']  = $insert_id;
			$data['fname']   = $fname;
			$data['lname']   = $lname;
			$data['mystory'] = $mystory;
			if (!empty($_FILES['profilepic']['name'])) {
				$data['profile_bg_image'] = $uploadfile_name;
				$data['profile_image']    = $uploadfile_name;
			} else {
				$data['profile_bg_image'] = "";
				$data['profile_image']    = "";
			}

			$response = generateResponse(TRUE, USER_REGISTERED, $data);
			echo json_encode($response);
		} else {
			getStatusCode(409);
			$response = generateResponse(FALSE, USER_ALREADY_REGISTERED);
			echo json_encode($response);
		}
	} else {
		$sqlSelect = mysql_query("select userid, socialnetworkid from fn_users where email='" . $email . "' limit 1");
		if (mysql_num_rows($sqlSelect) > 0) {
			$obj = mysql_fetch_object($sqlSelect);
			if ($obj->socialnetworkid == NULL) {
				// map the facebookid and return userid
				$sqlUpdate = "update fn_users set socialnetwork='facebook', socialnetworkid='$facebookid' where userid='$obj->userid' limit 1";
				mysql_query($sqlUpdate);
				$respmessage = ACCOUNTS_MAPPED;
			} else {
				$respmessage = USER_LOGGED_IN;
			}

			$query = "select a.fname, a.lname, b.mystory, b.profile_bg_image, b.profile_image from fn_users as a, fn_user_profile as b where a.userid=b.user_id AND a.userid=$obj->userid limit 1";
			$exe   = mysql_query($query);



			$userobj         = mysql_fetch_object($exe);
			$data['userid']  = $obj->userid;
			$data['fname']   = $userobj->fname;
			$data['lname']   = $userobj->lname;
			$data['mystory'] = "";
			if (!empty($userobj->mystory))
				$data['mystory'] = $userobj->mystory;


			if (!empty($userobj->profile_bg_image))
				$data['profile_bg_image'] = $userobj->profile_bg_image;
			else
				$data['profile_bg_image'] = "";

			if (!empty($userobj->profile_image))
				$data['profile_image'] = $userobj->profile_image;
			else
				$data['profile_image'] = "";

			$response = generateResponse(TRUE, $respmessage, $data);
			echo json_encode($response);
		} else {
			$proxy     = new SoapClient(host); // TODO : change url
			$sessionId = $proxy->login($soapusername, $soappassword);
			$mageid    = $proxy->call($sessionId, 'customer.create', array(
					array(
							'email' => $email,
							'firstname' => $fname,
							'lastname' => $lname,
							'password' => $password,
							'website_id' => 1,
							'store_id' => 1,
							'group_id' => 1
					)
			));
			$sqlInsert = "insert into fn_users(email,fname,lname,usertypeid,status,createtime,mageid, socialnetwork, socialnetworkid) values ('" . $email . "','" . $fname . "','" . $lname . "',64,1,NOW(),'" . $mageid . "','facebook','$facebookid')";
			mysql_query($sqlInsert);
			$insert_id       = mysql_insert_id();
			$sqlProfileImage = "insert into fn_user_profile (user_id, createdby, createddate, updatedby, updateddate) values ($insert_id, $insert_id, NOW(), $insert_id, NOW())";
			mysql_query($sqlProfileImage);

			$ch = curl_init("http://www.aweber.com/scripts/addlead.pl");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Expect:'
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_NOBODY, FALSE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "from=" . $email . "&name=" . $email . "&meta_web_form_id=848580469&meta_split_id=&unit=friendlies&redirect=http://www.aweber.com/form/thankyou_vo.html&meta_redirect_onlist=&meta_adtracking=&meta_message=1&meta_required=from&meta_forward_vars=0?");
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
			$result = @curl_exec($ch);

			$data['userid']           = $insert_id;
			$data['fname']            = $fname;
			$data['lname']            = $lname;
			$data['mystory']          = "";
			$data['profile_bg_image'] = "";
			$data['profile_image']    = "";

			$response = generateResponse(TRUE, FINAO_FACEBOOK_USER_CREATED, $data);
			echo json_encode($response);
		}
	}
	} catch ( SoapFault $e ) {
		
		$response = generateResponse(FALSE, REGISTER_ERROR);
		echo json_encode($response);
	}
}

function login($uid, $username, $password)
{

	$json     = array();
	$flag     = 0;
	$logquery = mysql_query("select userid from fn_users where email='$username' and password='$password' and status=1 limit 1");

	if(!empty($uid))
	{
		if (mysql_num_rows($logquery) > 0) {
			$logobj = mysql_fetch_object($logquery);

			if ($uid == $logobj->userid) {
				// getting count for a user
				$query          = "select a.fname, a.lname, b.mystory, b.profile_bg_image, b.profile_image from fn_users as a, fn_user_profile as b where a.userid=b.user_id AND a.userid=$uid limit 1";
				$exe            = mysql_query($query);
				$obj            = mysql_fetch_object($exe);
				$data['userid'] = $uid;
				$data['fname']  = $obj->fname;
				$data['lname']  = $obj->lname;

				//$data['mystory'] = "";
				//if(!empty($data['mystory']))
				$data['mystory'] = $obj->mystory;

				//$data['profile_bg_image'] = "";
				//if(!empty($data['profile_bg_image']))
				$data['profile_bg_image'] = $obj->profile_bg_image;

				//$data['profile_image'] = "";
				//if(!empty($data['profile_image']))
				$data['profile_image'] = $obj->profile_image;

				$response = generateResponse(TRUE, USER_LOGGED_IN, $data);
				echo json_encode($response);
					

			}
		} else {	getStatusCode(401);
		$response = generateResponse(FALSE, UNUTHORISED_USER);
		echo json_encode($response);

		}
	}
	else {	getStatusCode(401);
	$response = generateResponse(FALSE, UNUTHORISED_USER);
	echo json_encode($response);

	}
}

function finaorecentposts($uid)
{
	if($uid>0)
	{
		include 'phpviddler.php';
		$v          = new Viddler_V2('145i86zgnzi1h1xln0ly');
		$auth       = $v->viddler_users_auth(array(
				'user' => ' finaonation',
				'password' => 'Finao123'
		));
		$session_id = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;

		$data  = array();
		$query = mysql_query("select user_finao_id,finao_status from fn_user_finao where userid=$uid AND finao_activestatus=1 AND Iscompleted=0 order by user_finao_id DESC");
		$query1=" SELECT  COUNT(inspire.inspiringpostid) totalinspire	FROM    inspiringpost inspire 	INNER JOIN fn_uploaddetails upload ON inspire.userpostid = upload.uploadedby WHERE   upload.uploadedby ='" . $uid . "'";
		$queryres=mysql_query($query1);
		$querydet=mysql_fetch_assoc($queryres);

			

		if (mysql_num_rows($query) > 0) {
			while ($obj = mysql_fetch_object($query)) {
				$data['videoimg'] = "";
				$data['videourl'] = "";
				$data['finao_status']=$obj->finao_status;
				$data['totalinspired']= $querydet['totalinsipre'];
				$data['finao_id']=$obj->user_finao_id;
				$sqlquery="select * from fn_uploaddetails where uploaddetail_id='$qry->uploaddetail_id'";
				$sqlRes=mysql_query($sq);

				$querymsg=mysql_query("select finao_msg from fn_user_finao where user_finao_id='" . $data['finao_id'] . "'");
				$querymsgRes=mysql_fetch_assoc($querymsg);


				$qry= mysql_fetch_object(mysql_query("select uploaddetail_id,status, uploadtype, upload_text, uploadeddate from fn_uploaddetails where upload_sourcetype=37 AND upload_sourceid=$obj->user_finao_id order by uploaddetail_id DESC"));
				$upload_id        = $qry->uploaddetail_id;
				if ($qry->uploadtype != '') {
					if ($qry->uploadtype == 62) {
						$videoid             = 0;
						$data['updateddate'] = date("d M y", strtotime($qry->uploadeddate));
					} else if ($qry->uploadtype == 34) {
						$videoid = 1;
						$query1  = mysql_query("select uploadfile_name, uploadeddate,status from fn_uploaddetails where uploaddetail_id='$qry->uploaddetail_id'");
						$imgno   = 0;
						$imgarr  = array();
						if (mysql_num_rows($query1) > 0) {
							while ($obj1 = mysql_fetch_object($query1)) {
								$imgarr[$imgno]['image_url'] = $obj1->uploadfile_name;
								$data['updateddate']         = time_elapsed_string($obj1->uploadeddate);
								$imgno++;
							}
						} else {
							$imgarr = array();
						}
					} else if ($qry->uploadtype == 35) {
						$query1   = mysql_query("select videoid, caption, video_img, video_embedurl, uploadeddate from fn_uploaddetails where uploaddetail_id='$qry->uploaddetail_id'");
						$obj1     = mysql_fetch_object($query1);
						$videoid  = 2;
						$videourl = "";
						$videoimg = "";
						if (!empty($obj1->videoid)) {
							$results  = $v->viddler_videos_getDetails(array(
									'sessionid' => $session_id,
									'video_id' => $obj1->videoid
							));
							$videourl = $results['video']['files'][1]['html5_video_source'];

							if (!empty($obj1->video_img))
								$videoimg = $obj1->video_img;
							$caption = $obj1->caption;
						} else if (!empty($obj1->video_embedurl)) {
							$videocode = str_replace("/default.jpg", "", $obj1->video_img);
							$videocode = str_replace("http://img.youtube.com/vi/", "", $videocode);
							$videourl  = "http://www.youtube.com/embed/" . $videocode;
							if (!empty($obj1->video_img))
								$videoimg = $obj1->video_img;
						}

						$data['type']        = $videoid;
						$data['videoimg']    = $videoimg;
						$data['videourl']    = $videourl;
						$data['updateddate'] = date("d M y", strtotime($obj1->uploadeddate));
					}

					if (!empty($qry->upload_text)) {
						$data['upload_text'] = $qry->upload_text;
					} else {
						$data['upload_text'] = "";
					}
					$data['finao_msg']= $querymsgRes['finao_msg'];
					$data['type']            = $videoid;
					$data['image_urls']      = $imgarr;
					$data['uploaddetail_id'] = $upload_id;
					$data['status'] = $qry->status;
					$data['uploadtype']=$qry->uploadtype;
					$rows[$upload_id]        = $data;
				}
			}
			krsort($rows);
			$rows     = array_values($rows);
			$response = generateResponse(TRUE, NULL, $rows);
			echo json_encode($response);
		} else {

			$response = generateResponse(False, 'No recent posts');
			echo json_encode($response);
		}
	}
	else {
		getStatusCode(401);
		$response = generateResponse(False, 'Unauthorised user');
		echo json_encode($response);
	}
}



// 	Home Page Webservice
// 	Developer - Sathish Ravepati
// 	Dated - 26-12-2013
//	version - 1.5v

function homepage_user($userid){
	if(!empty($userid)){
		include 'phpviddler.php';

		$v          = new Viddler_V2('145i86zgnzi1h1xln0ly');
		$auth       = $v->viddler_users_auth(array(
				'user' => ' finaonation',
				'password' => 'Finao123'
		));
		$session_id = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;

		$data = array();
		$query = "SELECT notification.trackingnotification_id,
		notification.tile_id,
		notification.finao_id,
		notification.notification_action,
		notification.updateby,
		finao.updateddate,
		finao.finao_msg,
		finao.finao_status,
		lookup.lookup_name,
		profile.profile_image,
		profile.mystory,
		usr.fname,
		usr.lname,
		upload.uploaddetail_id,
		upload.uploadtype,
		upload.upload_text,
		upload.updateddate
		FROM `fn_trackingnotifications` AS notification
		INNER JOIN fn_user_finao AS finao ON finao.user_finao_id=notification.finao_id
		INNER JOIN fn_lookups AS lookup ON lookup.lookup_id= notification.notification_action
		INNER JOIN fn_user_profile AS profile
		INNER JOIN fn_users AS usr ON usr.userid= profile.user_id AND usr.userid= notification.updateby
		INNER JOIN fn_uploaddetails AS upload ON upload.upload_sourceid= notification.finao_id
		LEFT OUTER JOIN inappropriatepost inapp ON inapp.userpostid = upload.uploaddetail_id
		WHERE notification.tracker_userid = '$userid' AND
		notification.notification_action IN ('51','52','53','54','55','56') AND
		inapp.userpostid IS NULL
		GROUP BY notification.finao_id
		ORDER BY notification.updateddate DESC  LIMIT 0 , 30";

		$exe = mysql_query($query);
		if(mysql_num_rows($exe)>0)
		{
			while($obj = mysql_fetch_object($exe)){
				$videoimg="";
				$videourl="";
				$videoid = 0;
				if($obj->uploadtype=='34' || $obj->uploadtype=='62'){
					if($obj->uploadtype=='34'){
						$videoid = 1;
					}
					$query1 = mysql_query("select uploadfile_name, uploadfile_path, caption, updateddate from fn_uploaddetails where uploaddetail_id='$obj->uploaddetail_id'");
					$sno = 0;
					if(mysql_num_rows($query1)>0){
						while($obj1=mysql_fetch_object($query1)){
							$imgarr[$sno]['image_url'] = $obj1->uploadfile_name;
							if(!empty($obj1->caption)){
								$imgarr[$sno]['image_caption'] = $obj1->caption;
							}else{
								$imgarr[$sno]['image_caption'] = "";
							}
							$sno++;
						}
					}else{
						$imgarr = array();
					}
				}else if($obj->uploadtype=='35' || $obj->uploadtype=='62'){
					if($obj->uploadtype=='35'){
						$videoid = 2;
					}

					$query1 = mysql_query("select videoid, caption, video_img, video_embedurl from fn_uploaddetails where uploaddetail_id='$obj->uploaddetail_id'");
					$obj1=mysql_fetch_object($query1);
					if(empty($obj1->videoid) && empty($obj1->video_embedurl)){
						$videoid = 0;
						$videourl = "";
						$videoimg = "";
						if(!empty($obj1->caption)){
							$caption = $obj1->caption;
						}
					}

					$videoimg = "";
					if(!empty($obj1->videoid)){
						$results      = $v->viddler_videos_getDetails(array(
								'sessionid' => $session_id,
								'video_id' => $obj1->videoid
						));
						$videourl = $results['video']['files'][1]['html5_video_source'];

						if(!empty($obj1->video_img))
							$videoimg = $obj1->video_img;
						$caption = $obj1->caption;
					}else if(!empty($obj1->video_embedurl)){
						$videocode=str_replace("/default.jpg","",$obj1->video_img);
						$videocode=str_replace("http://img.youtube.com/vi/","",$videocode);
						$videourl="http://www.youtube.com/embed/".$videocode;
						if(!empty($obj1->video_img))
							$videoimg = $obj1->video_img;

						$caption = $obj1->caption;
					}
				}

				$data['tile_id'] = $obj->tile_id;
				$data['finao_id'] = $obj->finao_id;
				$data['notification_status'] = $obj->lookup_name;
				$data['updateby'] = $obj->updateby;
				$data['finao_msg'] = $obj->finao_msg;
				$data['finao_status'] = $obj->finao_status;
				$data['profile_image'] = $obj->profile_image;
				$data['profilename'] = $obj->fname." ".$obj->lname;
				$data['story'] = $obj->mystory;
				$data['uploaddetail_id'] = $obj->uploaddetail_id;
				$data['type'] = $videoid;
				$data['videoimg'] = $videoimg;
				$data['videourl'] = $videourl;
				if($caption!=NULL)
					$data['caption'] = $caption;
				else
					$data['caption'] = "";
				$data['image_urls'] = $imgarr;
				if(!empty($obj->upload_text)){
					$data['upload_text'] = $obj->upload_text;
				}else{
					$data['upload_text'] = "";
				}
				$data['updateddate'] = date("d M y",strtotime($obj->uploadeddate));

				// getting count for a user
				$totalfollowers=0;
				$totalfollowers=fngetTotalFollowers($obj->updateby);
				$totaltiles=0;
				$sqlTilesCount="SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =".$obj->updateby." AND finao_activestatus !=2 ";
				$sqlTilesCount.=" and `finao_status_Ispublic`=1";
				$sqlTilesCount.=" GROUP BY tile_id ";
				$sqlTilesCountRes=mysql_query($sqlTilesCount);
				$totaltiles=mysql_num_rows($sqlTilesCountRes);

				$totalfinaos=0;
				$sqlFianosCount="SELECT user_tileid FROM  fn_user_finao_tile ft JOIN fn_user_finao f WHERE ft.finao_id = f.user_finao_id AND ft.userid =  '".$obj->updateby."' AND f.finao_activestatus =1 AND finao_status_Ispublic =1";
				$sqlSelectFinaoCountRes=mysql_query($sqlFianosCount);
				$totalfinaos=mysql_num_rows($sqlSelectFinaoCountRes);

				$totalfollowings=0;
				$totalfollowings=fngetTotalFollowings($obj->updateby);

				if($totaltiles=="")
					$totaltiles=0;
				if($totalfinaos=="")
					$totalfinaos=0;
				if($totalfollowers=="")
					$totalfollowers=0;
				if($totalfollowings=="")
					$totalfollowings=0;

				$data['totalfinaos']=$totalfinaos;
				$data['totaltiles']=$totaltiles;
				$data['totalfollowers']=$totalfollowers;
				$data['totalfollowings']=$totalfollowings;

				$rows[] = $data;
			}
			$response = generateResponse(TRUE, NULL, $rows);
		}
		else{
			$response = generateResponse(TRUE, NULL, 'Currently there are no posts');
		}
		echo json_encode($response);
	}else{
		getStatusCode(401);
		$response = generateResponse(FALSE, UNUTHORISED_USER);
		echo json_encode($response);
	}
}


// 	Finao List Webservice
// 	Developer - Sathish Ravepati
// 	Dated - 26-12-2013
//	version - 1.3v
function finao_list($myid, $type, $otherid)
{
	if (!empty($myid)) {
		$data  = array();
		$query = "SELECT a.user_finao_id, a.finao_msg, a.finao_status, a.Iscompleted, a.finao_status_Ispublic, b.tile_id
		FROM fn_user_finao as a, fn_user_finao_tile as b
		WHERE a.finao_activestatus = 1 AND b.finao_id=a.user_finao_id ";

		if ($type == 0) {
			$query .= " AND a.userid=$myid AND a.Iscompleted=0";
		} else {
			$query .= " AND a.userid=$otherid AND a.finao_status_Ispublic=1";
		}
		$query .= " ORDER BY a.updateddate DESC LIMIT 0 , 30";

		$exe = mysql_query($query);
		while ($obj = mysql_fetch_object($exe)) {
			$data['finao_id']    = $obj->user_finao_id;
			$data['finao_msg'] = $obj->finao_msg;
			$data['tile_id']     = $obj->tile_id;
			if ($obj->Iscompleted == 1 && $type == 1) {
				$data['finao_status'] = 1;
			} else {
				$data['finao_status'] = $obj->finao_status;
			}

			if ($type == 0) {
				$data['tracking_status'] = $obj->finao_status_Ispublic;
			} else {
				$followqry = mysql_query("select status from fn_tracking where tracker_userid=" . $myid . " and tracked_userid=" . $otherid . " and tracked_tileid=" . $obj->tile_id);
				if (mysql_num_rows($followqry) > 0) {
					$data['tracking_status'] = 1;
				} else {
					$data['tracking_status'] = 0;
				}
			}
			$rows[] = $data;
		}
		$response = generateResponse(TRUE, NULL, $rows);
		echo json_encode($response);
	} else {
		getStatusCode(401);
		$response = generateResponse(FALSE, UNUTHORISED_USER);
		echo json_encode($response);
	}
}

// 	Finao Details Webservice
// 	Developer - Sathish Ravepati
// 	Dated - 29-12-2013
//	version - 1.1v
function finaodetails( $finaoid)
{
	if (!empty($finaoid)) {
		include 'phpviddler.php';
		$v          = new Viddler_V2('145i86zgnzi1h1xln0ly');
		$auth       = $v->viddler_users_auth(array(
				'user' => ' finaonation',
				'password' => 'Finao123'
		));
		$session_id = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;

		$data  = array();
		$query = "SELECT b.finao_msg, b.finao_status, b.finao_status_Ispublic, f.uploaddetail_id, f.upload_text, f.uploadtype, f.uploadeddate
		FROM fn_user_finao as b, fn_uploaddetails as f
		WHERE b.user_finao_id=f.upload_sourceid and f.upload_sourcetype=37 and f.upload_sourceid=$finaoid
		ORDER BY f.updateddate DESC
		LIMIT 0 , 30";
		$exe   = mysql_query($query);
		while ($obj = mysql_fetch_object($exe)) {
			$videoid = 0;
			$caption = "";
			$imgarr  = array();

			if ($obj->uploadtype == '34' || $obj->uploadtype == '62') {
				$videoimg = "";
				$videourl = "";
				if ($obj->uploadtype == '34') {
					$videoid = 1;
				}
				$query1 = mysql_query("select uploadfile_name, uploadfile_path, caption, updateddate from fn_images where upload_id='$obj->uploaddetail_id'");
				$sno    = 0;
				if (mysql_num_rows($query1) > 0) {
					while ($obj1 = mysql_fetch_object($query1)) {
						$imgarr[$sno]['image_url'] = $obj1->uploadfile_name;
						if (!empty($obj1->caption)) {
							$imgarr[$sno]['image_caption'] = $obj1->caption;
						} else {
							$imgarr[$sno]['image_caption'] = "";
						}
						$sno++;
					}
				} else {
					$imgarr = array();
				}
			} else if ($obj->uploadtype == '35' || $obj->uploadtype == '62') {
				$videoimg = "";
				$videourl = "";
				if ($obj->uploadtype == '35') {
					$videoid = 2;
				}

				$query1 = mysql_query("select videoid, caption, video_img, video_embedurl from fn_videos where upload_id='$obj->uploaddetail_id'");
				$obj1   = mysql_fetch_object($query1);
				if (empty($obj1->videoid) && empty($obj1->video_embedurl)) {
					$videoid  = 0;
					$videourl = "";
					$videoimg = "";
					if (!empty($obj1->caption)) {
						$caption = $obj1->caption;
					}
				}

				$videoimg = "";
				if (!empty($obj1->videoid)) {
					$results  = $v->viddler_videos_getDetails(array(
							'sessionid' => $session_id,
							'video_id' => $obj1->videoid
					));
					$videourl = $results['video']['files'][1]['html5_video_source'];

					if (!empty($obj1->video_img))
						$videoimg = $obj1->video_img;
					$caption = $obj1->caption;
				} else if (!empty($obj1->video_embedurl)) {
					$videocode = str_replace("/default.jpg", "", $obj1->video_img);
					$videocode = str_replace("http://img.youtube.com/vi/", "", $videocode);
					$videourl  = "http://www.youtube.com/embed/" . $videocode;
					if (!empty($obj1->video_img))
						$videoimg = $obj1->video_img;

					$caption = $obj1->caption;
				}
			}
			$data['uploaded_id'] = $obj->uploaddetail_id;
			$data['type']        = $videoid;
			$data['videoimg']    = $videoimg;
			$data['videourl']    = $videourl;
			$data['caption']     = $caption;
			$data['image_urls']  = $imgarr;
			if (!empty($obj->upload_text)) {
				$data['upload_text'] = $obj->upload_text;
			} else {
				$data['upload_text'] = "";
			}
			$data['updateddate'] = date("d M y", strtotime($obj->uploadeddate));

			$rows[] = $data;
		}
			
		$response = generateResponse(TRUE, 'success', $rows);
		echo json_encode($response);
	} else {
		getStatusCode(401);
		$response = generateResponse(FALSE, UNUTHORISED_USER);
		echo json_encode($response);
	}
}

function uploadimagesfinao($userid, $finaoid, $type, $uploadtext, $captions)
{
	$_FILES['image1']['name'];
	if (!empty($userid)) {
		if ($type == 1) {
			$sourcetype = 37;
		} else {
			$sourcetype = 36;
		} 
		if ($_FILES['video']['name'] != '') {
			$uploadtype = 35;
		} else if ($_FILES['image1']['name'] != '') {
			$uploadtype = 34;
		}
		if (empty($_FILES) && !empty($uploadtext)) {
			$uploadtype = 62;
			uploaddata($uploadtype, $sourcetype, $finaoid, $userid, $uploadtext);
		} else if (!empty($_FILES) && !empty($uploadtext)) {
			uploaddata($uploadtype, $sourcetype, $finaoid, $userid, $uploadtext, $_FILES, $captions);
		} else if (!empty($_FILES) && empty($uploadtext)) {
			uploaddata($uploadtype, $sourcetype, $finaoid, $userid, NULL, $_FILES, $captions);
		}
		$response = generateResponse(TRUE, FINAO_DATA_UPLOAD);
		echo json_encode($response);
	} else {
		getStatusCode(401);
		$response = generateResponse(FALSE, UNUTHORISED_USER);
		echo json_encode($response);
	}

}


function changefinaostatus($userid,$type,$finao_id,$finao_status_ispublic,$finaostatus){
	$json = Array();
	if($userid > 0)
	{
		if($finao_id > 0){
			$sqlupdate = "call changefinaostatus('$userid', '$finao_id', '$finaostatus', '$type', '$finao_status_ispublic')";
			$result = mysql_query($sqlupdate);
			if($result){
				$finaoid = mysql_fetch_object($result)->finaoid;
				$json['finaoid']=$finaoid;
				$response = generateResponse(TRUE,'success' ,$json);
			}
			else{
				$response = generateResponse(FALSE, 'Error in data');

			}
		}
		else{
			$response = generateResponse(FALSE, WRONG_DATA);
		}
	}
	else
	{
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);
}



// 	Multiple Image upload for Finao/Tile Webservice
// 	Developer - Sathish Ravipati
// 	Dated - 06-01-2014
//	version - 1.1v
function uploaddata($type, $sourcetype, $finaoid, $userid, $uploadtext, $data, $captiondata)
{
	$target_path   = $globalpath . "images/uploads/finaoimages/";
	$target_thumb  = $globalpath . "images/uploads/finaoimages/thumb/";
	$target_medium = $globalpath . "images/uploads/finaoimages/medium/";
	$upload_path   = "/images/uploads/finaoimages";

	$query = "insert into fn_uploaddetails (`uploadtype`,`upload_text`,`upload_sourcetype`, `upload_sourceid`, `uploadedby`, `uploadeddate`, `status`) values ('$type','$uploadtext','$sourcetype','$finaoid','$userid',now(),1)";
	mysql_query($query);
	$uploadid = mysql_insert_id();
	if (!empty($data)) {
		if ($data['image1']['name'] != '') {
			$sno = 0;
			foreach ($data as $key => $val) {
				$name            = $val['name'];
				$uploadfile_name = $finaoid . "-" . $name;
				$tmpname         = $val['tmp_name'];
				$target_main     = $target_path . $uploadfile_name;

				$target_thumb  = $target_thumb . $uploadfile_name;
				$target_medium = $target_medium . $uploadfile_name;
				@move_uploaded_file($tmpname, $target_main);

				$resize = new ResizeImage($target_main);
				$resize->resizeTo(100, 100, 'default');
				$resize->saveImage($target_thumb);

				$resize_m = new ResizeImage($target_main);
				$resize_m->resizeTo(240, 240, 'default');
				$resize_m->saveImage($target_medium);
				$query = "insert into fn_images (`upload_id`,`uploadfile_name`,`uploadfile_path`, `caption`, `uploadedby`, `uploadeddate`, `status`) values ('$uploadid','$uploadfile_name','$upload_path','$captiondata[$sno]','$userid',now(),1)";
				mysql_query($query);
				$sno++;
			}
		} else {
			$target_path = $target_path . $finaoid . "-" . basename($data['video']['name']);
			@move_uploaded_file($data['video']['tmp_name'], $target_path);
			set_time_limit(0);
			include 'phpviddler.php';
			$v          = new Viddler_V2('145i86zgnzi1h1xln0ly');
			$auth       = $v->viddler_users_auth(array(
					'user' => ' finaonation',
					'password' => 'Finao123'
			));
			$session_id = (isset($auth['auth']['sessionid'])) ? $auth['auth']['sessionid'] : NULL;
			$response   = $v->viddler_videos_prepareUpload(array(
					'sessionid' => $session_id
			));
			$endpoint   = (isset($response['upload']['endpoint'])) ? $response['upload']['endpoint'] : NULL;
			$token      = (isset($response['upload']['token'])) ? $response['upload']['token'] : NULL;
			$query      = array(
					'uploadtoken' => $token,
					'title' => 'Video from iphone App',
					'description' => 'Video from iphone App',
					'tags' => 'testing,upload',
					'file' => '@../../preprod/images/uploads/finaoimages/' . $finaoid . "-" . basename($data['video']['name'])
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
			$response    = curl_exec($ch);
			$info        = curl_getinfo($ch);
			$header_size = $info['header_size'];
			$header      = substr($response, 0, $header_size);
			$video       = unserialize(substr($response, $header_size));
			curl_close($ch);
			@unlink('../../preprod/images/uploads/finaoimages/' . $finaoid . "-" . basename($data['video']['name']));
			$videoid = $video['video']['id'];
			$results = $v->viddler_videos_getDetails(array(
					'sessionid' => $session_id,
					'video_id' => $videoid
			));

			$videostatus = $results['video']['status'];
			$video_img   = $results['video']['thumbnail_url'];
			$query       = "insert into fn_videos (`upload_id`,`videoid`,`videostatus`, `video_img`, `caption`, `uploadedby`, `uploadeddate`, `status`) values ('$uploadid','$videoid','$videostatus','$video_img','$captiondata[0]','$userid',now(),1)";
			mysql_query($query);
		}
	}

	// updating the current date time in fn_user_finao
	$sqlUpdate = "update fn_user_finao set updateddate=NOW(),updatedby=" . $userid . " where user_finao_id=" . $finaoid;
	mysql_query($sqlUpdate);
	// end of fn_user_finao update
}



function getdefaulttiles(){
	$row=array();
	$sql=mysql_query("call gettiles()");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['tile_id']=$obj->tile_id;
			$row['tile_name']=$obj->tilename;
			$row['tile_imageurl']=$obj->tile_imageurl;
			$row['status']=$obj->status;
			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false);
	}

	echo	json_encode($response);
}
function getNotifications($userid){
	$json = array();
	$sqlgetnotification = "call getnotifications('$userid')";
	$notificationresult = mysql_query($sqlgetnotification);
	if(mysql_num_rows($notificationresult)>0)
	{
		while($sqlnotificationdata=mysql_fetch_array($notificationresult)){
			$data['userid'] = $sqlnotificationdata['userid'];
			$data['profile_image'] = $sqlnotificationdata['profile_image'];
			$data['action'] = $sqlnotificationdata['action'] ;
			$data['createddate']=$sqlnotificationdata['createddate'];
			$rows[] = $data;
		}

		$response=generateResponse(true,'success',$rows);


	}
	else
	{

		$response=generateResponse(false,"Currently there are no notifications available");
	}
	echo json_encode($response);
}

function getinspired($authuserid){
	$row=array();
	$sql=mysql_query("call inspired('$authuserid')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['user_id']=$obj->userid;
			$row['inspireuserid']=$obj->inspireuserid;
			$row['upload_text']=$obj->upload_text;
			$row['finao_id']=$obj->finaoid;
			$row['finao_msg']=$obj->finaomsg;
			$row['name']=$obj->name;
			$row['image_urls']=$obj->upload_img;
			$row['videourl']=$obj->video_url;
			$row['tile_image']=$obj->imgurl;
			$row['uploaddetail_id']=$obj->uploadid;
			$row['finao_status']=$obj->finao_status;
			$row['status']=$obj->status;
			$row['totalinspired']=$obj->totalinspired;
			$row['updateddate']=$obj->updatedate;
			$row['video_img']=$obj->video_img;
			if($row['image_urls']==null&&$obj->video_url==null)
			{
				$type=0;
			}
			else if($row['image_urls']!=null){
				$type=1;
			}
			else{
				$type=2;
			}
			$row['type']=$type;
			$row['profileimg']=$obj->profileimg;
			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false,"No Inspired Post ");
	}

	echo	json_encode($response);

}

function gettagnotes($authid)
{
	$client = new SoapClient(host);
	$sessionId = $client->login(username, password);
	$customerId = '';

	$query = mysql_query("select mageid from fn_users where userid='".$authid."' limit 1");

	if(mysql_num_rows($query)>0)
	{
		$obj = mysql_fetch_object($query);

		$customerId= $obj->mageid;

		$requestData = array(
				'customer_id' =>$customerId
		);



		$tagnoteData = $client->call($sessionId, 'finao.all', array($requestData));

		echo $json=json_encode($tagnoteData);

	}
	else
	{	getStatusCode(401);
	$response = generateResponse(FALSE, UNUTHORISED_USER);
	echo json_encode($response);

	}

}
function  mytiles($authid)
{
	$row=array();
	$sql=mysql_query("call mytiles('$authuserid')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['tile_id']=$obj->ttid;
			$row['status']=$obj->status;
			$row['tile_name']=$obj->name;
			$row['tile_image']=$obj->imageurl;

			$row['finao_image']=$obj->uploadpath;
			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false,"No Tiles ");
	}

	echo	json_encode($response);
}


function homepage_public($id)
{
	$row=array();
	$sql=mysql_query("call homepage_public('$id')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['tile_id']=$obj->tile_id;
			$row['finao_id']=$obj->finao_id;
			$row['status']=$obj->status;
			$row['updatedby']=$obj->updatedby;
			$row['finao_msg']=$obj->finao_msg;
			$row['finao_activestatus']=$obj->finao_activestatus;
			$row['tile_profileImagurl']=$obj->tile_profileImagurl;
			$row['updateddate']=$obj->updateddate;
			$row['caption']=$obj->caption;
			$row['videoid']=$obj->videoid;
			$row['video_embedurl']=$obj->video_embedurl;
			$row['uploadtype']=$obj->uploadtype;
			$row['uploaddetail_id']=$obj->uploaddetail_id;

			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false,"No  Post ");
	}

	echo	json_encode($response);


}
function    userpublic_detail($id){
	$row=array();
	$sql=mysql_query("call userpublic_detail('$id')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['user_id']=$obj->id;
			$row['profile_img']=$obj->profile_img;
			$row['banner_img']=$obj->banner_img;
			$row['name']=$obj->name;
			$row['mystory']=$obj->mystory;
			$row['totalfinao']=$obj->totalfinao;
			$row['totaltile']=$obj->totaltile;
			$row['following']=$obj->following;
			$row['follower']=$obj->follower;
			$row['inspired']=$obj->inspired;


			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false,"No  Post ");
	}

	echo	json_encode($response);


}

function getunusedtiles($authuserid){
	$row=array();
	$sql=mysql_query("call unusedtile('$authuserid')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['tile_id']=$obj->tile_id;
			$row['tilename']=$obj->tilename;
			$row['tile_imageurl']=$obj->tile_imageurl;
			$row['status']=$obj->status;
			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false);
	}

	echo	json_encode($response);


}
function  finao_public($cust_id, $tileid){

	$row=array();
	$sql=mysql_query("call public_finao('$cust_id','$tileid')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['tile_id']=$obj->tile_id;
			$row['tilename']=$obj->tile_name;
			$row['tile_imageurl']=$obj->tile_profileImagurl;
			$row['uploadtype']=$obj->uploadtype	;
			$row['upload_sourcetype']=$obj->upload_sourcetype;
			$row['finao_msg']=$obj->finao_msg;
			$row['userid']=$obj->userid;
			$row['finao_id']=$obj->finao_id;
			$row['finao_status']=$obj->finao_status;
			$row['finao_status_ispublic']=$obj->	finao_status_ispublic;
			$row['finao_image']=$obj->uploadfile_path;
			$row['createddate']=$obj->createddate;

			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false,"no finao");
	}

	echo	json_encode($response);



}

function public_posts($finaoid){
	$row=array();
	$sql=mysql_query("call public_post('$finaoid')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['userid']=$obj->userid;
			$row['user_finao_id']=$obj->user_finao_id;
			$row['uploadtype']=$obj->uploadtype;
			$row['upload_text']=$obj->upload_text;
			$row['uploadfile_name']=$obj->uploadfile_name;
			$row['uploadfile_path']=$obj->uploadfile_path;
				


			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false,"no posts");
	}

	echo	json_encode($response);


}
function getowntiles($authuserid){
	$row=array();
	$sql=mysql_query("call userowntile('$authuserid')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['tile_id']=$obj->tile_id;
			$row['tile_name']=$obj->tilename;
			$row['tile_imageurl']=$obj->tile_imageurl;
			$row['status']=$obj->	status;
				



			$data[] = $row;
		}
		$response=generateResponse(true,'success',$data);
	}
	else{
		$response=generateResponse(false,"no tiles");
	}

	echo	json_encode($response);


}


function   sorttiles($tileid,$userid){
	$row=array();
	$sql=mysql_query("call usermatchingtile('$tileid','$userid')");

	if(mysql_num_rows($sql) > 0) {

		while($obj = mysql_fetch_object($sql))
		{
			$row['fname']=$obj->fname;
			$row['lname']=$obj->lname;
			$row['userid']=$obj->userid;
			$row['mystory']=$obj->mystory;
			$row['gptilename']=$obj->gptilname;
			$row['image']=$obj->image;
			$row['tracker_userid']=$obj->tracker_id	;
			$row['tile_id']=$obj->usertileid;
			$row['tracked_userid']=$obj->tracked_id;
			$row['finao_msg']=$obj->finaomsg;
			$row['totalfollowers']=$obj->totalfollowers;
			$row['totaltiles']=$obj->totaltiles;
			$row['totalfinaos']=$obj->totalfinaos;
			$row['totalfollowings']=$obj->totalfollowings;
			$row['totalinspired']=$obj->totalinspire;
			$row['status']=$obj->status;



			$data[] = $row;
		}
		$json['res'] = $data;
	}
	else{
		$json['res'] = 'No followers';
	}

	echo	json_encode($json);

}

function followalltiles($authuserid,$cust_id)
{

	$json = array();
	if($authuserid > 0)
	{
		if(  ($authuserid> 0 || $cust_id > 0)){
			$result = mysql_query("call followuser_alltiles('$authuserid', '$cust_id')");

			if($result){
				$userfollowerid = mysql_fetch_object($result)->userfollowerid;
				$json['userfollowerid']=$userfollowerid;
				$response = generateResponse(TRUE, 'success', $json);
			}
			else{
				$response = generateResponse(FALSE,ALREADY_FOLLOWING);
			}
		}
		else{
			$response = generateResponse(FALSE, DATA, WRONG_DATA);
		}
	}
	else {
		$response = generateResponse(FALSE, UNUTHORISED_USER);
	}
	echo json_encode($response);

}

function settings_tagnote($authuserid)
{
	$client = new SoapClient(host);
	$sessionId = $client->login(username, password);
	$customerId = '';

	$query = mysql_query("select mageid from fn_users where userid='".$authid."' limit 1");

	if(mysql_num_rows($query)>0)
	{
		$obj = mysql_fetch_object($query);

		$customerId= $obj->mageid;

		$requestData     = array(
				'tagnote_id' => $customerId,
				'finao' => 'testing, testing, 123'
		);



		$tagnoteData = $client->call($sessionId, 'finao.update', array($requestData));

		echo $json=json_encode($tagnoteData);

	}
	else
	{	getStatusCode(401);
	$response = generateResponse(FALSE, UNUTHORISED_USER);
	echo json_encode($response);

	}
}


function upload_data($authuserid)
{
	$username = "Sayee.Gurumurthy"; // username
	$key = "0d5739ba0696428f885890282d3ba150"; // api key
	//Rackspace client
	$client = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
			'username' => $username,
			'apiKey'   => $key
	));
	
	//Authenticate client
	$client->authenticate();
	$service = $client->objectStoreService('cloudFiles');
	$container = $service->getContainer('userimages');
	
	//Figure out the user first name and last name based on the $name variable
	
	
	
	//We must have got some dimensions to crop the images, lets get that set
	$profile_image_crop_x = $_POST['x'];
	$profile_image_crop_y = $_POST['y'];
	$profile_image_crop_w = $_POST['w'];
	$profile_image_crop_h = $_POST['h'];
	
	if ($_FILES['profile_image']['tmp_name'] != "") {
		$imageProcessor = new ImageManipulator($_FILES['profile_image']['tmp_name']);
		if($profile_image_crop_w > 1 && $profile_image_crop_h > 1)
		{
			$croppedImage = $imageProcessor.crop($profile_image_crop_x, $profile_image_crop_y, $profile_image_crop_x + $profile_image_crop_w, $profile_image_crop_y + $profile_image_crop_h);
		}
			
		$imageProcessor->save($basePath.$target_profile_pic_name);
			
		//Read back the file so that we can now upload it to Rackspace CDN.
			
		//Common Meta
		$meta = array(
				'Author' => $name,
				'Origin' => 'FINAO Web'
		);
		$metaHeaders = DataObject::stockHeaders($meta);
			
		$data = fopen($basePath.$target_profile_pic_name, 'r+');
		$container->uploadObject($target_profile_pic_name, $data, $metaHeaders);
			
		$targ_w = 150;
		$targ_h = 150;
		$jpeg_quality = 90;
		$profile_thumb_image = $imageProcessor->resample($targ_w, $targ_h);
		$imageProcessor->save($basePath.$target_profile_pic_thumb);
			
		$data = fopen($basePath.$target_profile_pic_thumb, 'r+');
		$container->uploadObject($target_profile_pic_thumb, $data, $metaHeaders);
	}
	
	if ($_FILES['profile_bg_image']['tmp_name'] != "") {
		@move_uploaded_file($_FILES['profile_bg_image']['tmp_name'],
				'images/uploads/profileimages/'.$target_banner_pic_name);
		//Common Meta
		$meta = array(
				'Author' => $name,
				'Origin' => 'FINAO Web'
		);
		$metaHeaders = DataObject::stockHeaders($meta);
		$data = fopen($basePath.$target_banner_pic_name, 'r+');
		$container->uploadObject($target_banner_pic_name, $data, $metaHeaders);
	}
	
}
?>