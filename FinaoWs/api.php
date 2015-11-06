<?php
$globalpath = "../../mobilewebservices/";
include_once("connect.php");
include_once("resizeclass.php");
include_once("errorconstants.php");
include_once("functions.php");


global $authuserid;

$method = $_REQUEST['json'];

if ($method != 'registration') {
	if (!empty($_SERVER['PHP_AUTH_USER'])) {
		$username   = $_SERVER['PHP_AUTH_USER'];
		$password   = $_SERVER['PHP_AUTH_PW'];
		$authuserid = validateLogin($username, $password);

	} 
}

switch ($method) {
	case "finaorecentposts":
		$userid= mysql_real_escape_string($_POST['userid']);
		if($userid!=null)
		{
			finaorecentposts($userid);
		}
		else{
			finaorecentposts($authuserid);
		}
		break;

	case "login":
		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);

		login($authuserid, $username, $password);
		break;

	case "getnotifications":

		getNotifications($authuserid);
		break;
	case "getowntiles":
		$userid=mysql_real_escape_string($_POST['userid']);
		if($userid!=null)
		{
			getowntiles($userid);
		}
		else{
		getowntiles($authuserid);
		}
		break;

	case "sorttiles":
		$tileid = mysql_real_escape_string($_POST['tileid']);
		$userid=mysql_real_escape_string($_POST['userid']);
		sorttiles($tileid,$userid);
	 break;
	case "homepage_public":
		$id = mysql_real_escape_string($_POST['id']);
		homepage_public($authuserid);
		break;
	case "userpublic_detail":
		$id = mysql_real_escape_string($_POST['id']);
		userpublic_detail($id);
		break;

	case "deletepost":
		$finao_id = mysql_real_escape_string($_POST['finao_id']);
		$userpostid = mysql_real_escape_string($_POST['userpostid']);

		deletepost($authuserid,$finao_id,$userpostid);
		break;
	case "registration":
		$type     = mysql_real_escape_string($_POST['type']);
		$email    = mysql_real_escape_string($_POST['email']);
		$password = mysql_real_escape_string($_POST['password']);
		$fname    = mysql_real_escape_string($_POST['fname']);
		$lname    = mysql_real_escape_string($_POST['lname']);
		$fbid     = 0;
		if ($type == 2) {
			$fbid = mysql_real_escape_string($_POST['facebook_id']);
		}
		registration($type, $email, $password, $fname, $lname, $fbid);
		break;
	case "whotofollow":
		whotofollow($authuserid);
		break;

	case "followalltiles":
		$cust_id= mysql_real_escape_string($_POST['id']);
		followalltiles($authuserid,$cust_id);
		break;

	case  "getinspiredfrompost" :
		$userpostid = mysql_real_escape_string($_POST['userpostid']);
		getinspiredfrompost($authuserid, $userpostid);

		break;
	case  "getinspired" :
		$id = mysql_real_escape_string($_POST['id']);
		if ($id!=null)
		{
			getinspired($id);
		}
		else
		{
			getinspired($authuserid);
		}
		break;
	case "tagnote":
		gettagnotes($authuserid);
		break;
	case "settings_tagnote":
		settings_tagnote($authuserid);
		break;

	case "updateprofiledetails":
		$name = mysql_real_escape_string($_POST['name']);
		$email = mysql_real_escape_string($_POST['email']);
		$password = mysql_real_escape_string($_POST['password']);
		$profile_image = mysql_real_escape_string($_POST['profile_image']);
		$profile_banner_image = mysql_real_escape_string($_POST['profile_banner_image']);
		$mystory = mysql_real_escape_string($_POST['bio']);
		updateprofiledetails($authuserid, $name, $email, $password, $profile_image, $profile_banner_image, $mystory);
		break;

	case "updateprofile":
		$name = mysql_real_escape_string($_POST['name']);
		$email = mysql_real_escape_string($_POST['email']);
		$password = mysql_real_escape_string($_POST['password']);
		$mystory = mysql_real_escape_string($_POST['bio']);
		updateprofile($authuserid, $name, $email, $password, $mystory);
		break;

	case "createpost":

		$finao_id = mysql_real_escape_string($_POST['finao_id']);
		$postdata = mysql_real_escape_string($_POST['postdata']);

		createpost($finao_id,$postdata,$authuserid);
		break;
			
	case "getdefaulttiles":

		getdefaulttiles();
		break;
	case "getunusedtiles":

		getunusedtiles($authuserid);
		break;

	case "followuser":
		$followeduserid = mysql_real_escape_string($_POST['followeduserid']);
		$tileid = mysql_real_escape_string($_POST['tileid']);
		followuser($authuserid, $followeduserid , $tileid);
		break;
	case "unfollow":
		$followeduserid = mysql_real_escape_string($_POST['followeduserid']);
		$tileid = mysql_real_escape_string($_POST['tileid']);
		unfollowuser($authuserid, $followeduserid, $tileid);
		break;

	case "markinappropriatepost":
		$userpostid = mysql_real_escape_string($_POST['userpostid']);
		markinappropriatepost($authuserid, $userpostid);
		break;
			
	case "profiledetails":
		profiledetails($authuserid);
		break;

	case "updateexplorefinao":
		$tileid = mysql_real_escape_string($_POST['tile_id']);
		updateexplorefinao($tileid);
		break;

	case "explorefinao":
		$userid = mysql_real_escape_string($_POST['userid']);
		explorefinao($userid, $viddler_session_id);
		break;
	case "verifyregistration":
		$activationkey= mysql_real_escape_string($_POST['activation']);
		activateacccount($activationkey);
		break;
	case "finao_details":
		$userid  = mysql_real_escape_string($_POST['userid']);
		$finaoid = mysql_real_escape_string($_POST['finaoid']);
		finao_details($userid, $finaoid, $viddler_session_id);
		break;

	case "List":
		//LIST is keyword,
		//as we cannot create a function name with keyword
		//we altered method name to List_finao function
		List_finao();
		break;

	case "searchtiles":
		$search = mysql_real_escape_string($_POST['search']);
		searchtiles($search);
		break;

	case "SendInvites":
		$to = strtolower(trim($_POST['to']));
		SendInvites($to);
		break;

	case "homelist":
		$userid = mysql_real_escape_string($_POST['userid']);
		homelist($userid, $viddler_session_id);
		break;

	case "changepassword":
		$userid          = mysql_real_escape_string($_POST['userid']);
		$oldpassword     = mysql_real_escape_string(md5($_POST['oldpassword']));
		$newpassword     = mysql_real_escape_string($_POST['newpassword']);
		$confirmpassword = mysql_real_escape_string($_POST['confirmpassword']);
		$email           = mysql_real_escape_string($_POST['email']);
		changepassword($userid, $oldpassword, $newpassword, $confirmpassword, $email);
		break;

	case "user_details":
		$userid = $authuserid;
		user_details($userid);
		break;

	case "searchusers":
		//$tile_name = strtolower(trim($_POST['tile_name']));
		$username  = strtolower(trim($_POST['username']));
		//searchusers($username, $tile_name);
		searchdata($username);
		break;
	case "search":
		$search=$_POST['search'];
		searchdata($search);
		break;
	case "searchusers_new":
		$tile_name = strtolower(trim($_POST['tile_name']));
		$username  = strtolower(trim($_POST['username']));
		searchusers_new($username, $tile_name);
		break;

	case "forgotpassword":
		$email = mysql_real_escape_string($_POST['email']);
		forgotpassword($email);
		break;
	case "resetpassword":

		$newpassword=$_POST['password'];
		$acktkey=$_POST['activkey'];
		resetpassword($newpassword,$acktkey);
		break;
	case "register":
		$email           = mysql_real_escape_string($_POST['email']);
		$password        = mysql_real_escape_string($_POST['password']);
		$user_id         = mysql_real_escape_string($_POST['user_id']);
		$secondary_email = mysql_real_escape_string($_POST['secondary_email']);
		$fname           = mysql_real_escape_string($_POST['fname']);
		$lname           = mysql_real_escape_string($_POST['lname']);
		$gender          = mysql_real_escape_string($_POST['gender']);
		$location        = mysql_real_escape_string($_POST['location']);
		$dob             = mysql_real_escape_string($_POST['dob']);
		$age             = mysql_real_escape_string($_POST['age']);
		$socialnetwork   = mysql_real_escape_string($_POST['socialnetwork']);
		$socialnetworkid = mysql_real_escape_string($_POST['socialnetworkid']);
		$usertypeid      = mysql_real_escape_string($_POST['usertypeid']);
		$status          = mysql_real_escape_string($_POST['status']);
		$zipcode         = mysql_real_escape_string($_POST['zipcode']);
		register($email, $password, $user_id, $secondary_email, $fname, $lname, $gender, $location, $dob, $age, $socialnetwork, $socialnetworkid, $usertypeid, $status, $zipcode);
		break;

	case "journaldetails":
		$finaoid = mysql_real_escape_string($_POST['finaoid']);
		journaldetails($finaoid);
		break;

	case "userlogon":
		//at one instance, socialnetwork id is cheked with password...
		$email           = mysql_real_escape_string($_POST['email']);
		$password        = mysql_real_escape_string(md5($_POST['pwd']));
		$socialnetworkid = mysql_real_escape_string($_POST['socialnetworkid']);
		userlogon($email, $password, $socialnetworkid);
		break;

	case "listfinos_old":
		$actual_user_id = mysql_real_escape_string($_POST['actual_user_id']);
		$tile_id        = mysql_real_escape_string($_POST['tile_id']);
		$user_id        = mysql_real_escape_string($_POST['user_id']);
		$ispublic       = mysql_real_escape_string($_POST['ispublic']);
		listfinos_old($actual_user_id, $tile_id, $user_id, $ispublic);
		break;

	case "listfinos":
		$actual_user_id = mysql_real_escape_string($_POST['actual_user_id']);
		$tile_id        = mysql_real_escape_string($_POST['tile_id']);
		$user_id        = mysql_real_escape_string($_POST['user_id']);
		$ispublic       = mysql_real_escape_string($_POST['ispublic']);
		listfinos($actual_user_id, $tile_id, $user_id, $ispublic);
		break;

	case "finaosdetails":
		$finao_id = mysql_real_escape_string($_POST['finao_id']);
		finaosdetails($finao_id);
		break;

	case "userdata":
		$user_id = $_POST['user_id'];
		userdata($user_id);
		break;

	case "listjournals":
		$finao_id = $_POST['finao_id'];
		listjournals($finao_id);
		break;

	case "userprofiledata":
		$user_id = $_POST['user_id'];
		userprofiledata($user_id);
		break;

	case "usertiles":

		$id=mysql_real_escape_string($_POST['id']);
		$isstatuscompleted = mysql_real_escape_string($_POST['iscomplete']);
		$ispublic= mysql_real_escape_string($_POST['ispublic']);

		if($id!=null)
		{
			getusertiles($id,$ispublic,$isstatuscompleted);

		}
		else {
			getusertiles($authuserid,$ispublic,$isstatuscompleted);
		}

		break;

	case "usertiles_new":
		$ispublic = $_POST['ispublic'];
		$user_id  = $authuserid;
		usertiles_new($ispublic,$user_id);
		break;

	case "usertiles_old":
		$ispublic = $_POST['ispublic'];
		$user_id  = $_POST['user_id'];
		usertiles_old($ispublic, $user_id);
		break;

	case "movefinao":
		$finao_id      = $_POST['finao_id'];
		$user_id       = $_POST['user_id'];
		$srctile_id    = $_POST['srctile_id'];
		$targettile_id = $_POST['targettile_id'];
		movefinao($finao_id, $user_id, $srctile_id, $targettile_id);
		break;

	case "deletefinao":
		$id      = $_POST['id'];
		$user_id = $_POST['user_id'];
		deletefinao($id, $user_id);
		break;

	case "getfinaoimageorvideo":
		$type    = $_POST['type']; //Image/Video
		$srctype = $_POST['srctype']; //tile/finao/journal
		$srcid   = $_POST['srcid'];
		$user_id = $_POST['user_id'];
		getfinaoimageorvideo($type, $srctype, $srcid, $user_id);
		break;

	case "createfiano_live":
		$userid                = mysql_real_escape_string($_POST['user_id']);
		$finao_msg             = mysql_real_escape_string($_POST['finao_msg']);
		$tile_id               = mysql_real_escape_string($_POST['tile_id']);
		$tile_name             = mysql_real_escape_string($_POST['tile_name']);
		$finao_status_ispublic = mysql_real_escape_string($_POST['finao_status_ispublic']);
		$updatedby             = mysql_real_escape_string($_POST['user_id']);
		$finao_status          = mysql_real_escape_string($_POST['finao_status']);
		$iscompleted           = mysql_real_escape_string($_POST['iscompleted']);
		$caption               = $_POST['caption'];
		$videoid               = $_POST['videoid'];
		$videostatus           = $_POST['videostatus'];
		$video_img             = $_POST['video_img'];
		createfiano_live($userid, $finao_msg, $tile_id, $tile_name, $finao_status_ispublic, $updatedby, $finao_status, $iscompleted, $caption, $videoid, $videostatus, $video_img);
		break;

	case "createfiano":
		$caption               = mysql_real_escape_string(trim($_POST['caption']));
		$userid                = $authuserid;
		$finao_msg             = mysql_real_escape_string($_POST['finao_msg']);
		$tile_id               = mysql_real_escape_string($_POST['tile_id']);
		$atile_id              = mysql_real_escape_string($_POST['tile_id']);
		$tile_name             = mysql_real_escape_string($_POST['tile_name']);
		$finao_status_ispublic = mysql_real_escape_string($_POST['finao_status_ispublic']);
		$updatedby             = $authuserid;
		$finao_status          = 38;
		$videoid               = $_POST['videoid'];
		$videostatus           = $_POST['videostatus'];
		$video_img             = $_POST['video_img'];
		$iscompleted           = 0;
		createfiano($caption, $finao_msg, $tile_id, $atile_id, $tile_name, $userid, $finao_status_ispublic, $updatedby, $finao_status, $videoid, $videostatus, $video_img, $iscompleted);
		break;

	case "addjournal":
		$finao_id       = mysql_real_escape_string($_POST['finao_id']);
		$finao_journal  = mysql_real_escape_string($_POST['finao_journal']);
		$journal_status = mysql_real_escape_string($_POST['journal_status']);
		$user_id        = mysql_real_escape_string($_POST['user_id']);
		$status_value   = mysql_real_escape_string($_POST['status_value']);
		$createdby      = mysql_real_escape_string($_POST['user_id']);
		$updatedby      = mysql_real_escape_string($_POST['user_id']);
		addjournal($finao_id, $finao_journal, $journal_status, $user_id, $status_value, $createdby, $updatedby);
		break;

	case "addNotification":
		$tracker_userid      = $_POST['tracker_userid'];
		$user_id             = $_POST['user_id'];
		$tile_id             = $_POST['tile_id'];
		$finao_id            = $_POST['finao_id'];
		$journal_id          = $_POST['journal_id'];
		$notification_action = $_POST['notification_action'];
		$updatedby           = $user_id;
		$createdby           = $user_id;
		addNotification($tracker_userid, $user_id, $tile_id, $finao_id, $journal_id, $notification_action, $updatedby, $createdby);
		break;

	case "addTracker":
		$tracker_userid = $_POST['tracker_userid'];
		$tracked_userid = $_POST['tracked_userid'];
		$tracked_tileid = $_POST['tracked_tileid'];
		$status         = $_POST['status'];
		addTracker($tracker_userid, $tracked_userid, $tracked_tileid, $status);
		break;

	case "updateTracker":
		$tracker_userid = $_POST['tracker_userid'];
		$tracked_userid = $_POST['tracked_userid'];
		$tracked_tileid = $_POST['tracked_tileid'];
		$tracking_id    = $_POST['tracking_id'];
		$status         = $_POST['status'];
		updateTracker($tracker_userid, $tracked_userid, $tracked_tileid, $tracking_id, $status);
		break;

	case "addTrackerInfo":
		$tracker_userid      = $_POST['tracker_userid'];
		$tracked_userid      = $_POST['tracked_userid'];
		$tracked_tileid      = $_POST['tracked_tileid'];
		$notification_action = $_POST['notification_action'];
		$tile_id             = $_POST['tile_id'];
		$finao_id            = $_POST['finao_id'];
		$journal_id          = $_POST['journal_id'];
		addTrackerInfo($tracker_userid, $tracked_userid, $tracked_tileid, $notification_action, $tile_id, $finao_id, $journal_id);
		break;

	case "IamTrackings":
		$tracker_userid = $_POST['tracker_userid'];
		$finao_id       = $_POST['finao_id'];
		IamTrackings($tracker_userid, $finao_id);
		break;

	case "followers":
		$id = mysql_real_escape_string($_POST['id']);
		if ($id!=null)
		{
			$user_id=$id;
		}
		else{
			$user_id = $authuserid;
		}
		followers($user_id);
		break;

	case "followings":
		$id = mysql_real_escape_string($_POST['id']);
		if ($id!=null)
		{
			$user_id=$id;
		}
		else{
			$user_id = $authuserid;
		}
		followings($user_id);
		break;

	case "MyTrackings":
		$tracker_userid = $_POST['tracker_userid'];
		$finao_id       = $_POST['finao_id'];
		MyTrackings($tracker_userid, $finao_id);
		break;

	case "IamTracking":
		$updateby = $_POST['updateby'];
		$finao_id = $_POST['finao_id'];
		IamTracking($updateby, $finao_id);
		break;

	case "ListTrackerUsingFiano":
		$tracker_userid      = $_POST['tracker_userid'];
		$notification_action = $_POST['notification_action'];
		$tile_id             = $_POST['tile_id'];
		$finao_id            = $_POST['finao_id'];
		$status              = $_POST['status'];
		ListTrackerUsingFiano($tracker_userid, $notification_action, $tile_id, $finao_id, $status);
		break;

	case "modifyjournal":
		$finao_journal_id = mysql_real_escape_string($_POST['finao_journal_id']);
		$finao_journal    = mysql_real_escape_string($_POST['finao_journal']);
		$journal_status   = mysql_real_escape_string($_POST['journal_status']);
		$user_id          = mysql_real_escape_string($_POST['user_id']);
		$status_value     = mysql_real_escape_string($_POST['status_value']);
		$updatedby        = mysql_real_escape_string($_POST['user_id']);
		modifyjournal($finao_journal_id, $finao_journal, $journal_status, $user_id, $status_value, $updatedby);
		break;

	case "modifyfiano":
		$finao_id              = mysql_real_escape_string($_POST['finao_id']);
		$userid                = mysql_real_escape_string($_POST['user_id']);
		$finao_msg             = mysql_real_escape_string($_POST['finao_msg']);
		$finao_status_ispublic = mysql_real_escape_string($_POST['finao_status_ispublic']);
		$updatedby             = mysql_real_escape_string($_POST['updatedby']);
		$finao_status          = mysql_real_escape_string($_POST['finao_status']);
		$iscompleted           = mysql_real_escape_string($_POST['iscompleted']);
		modifyfiano($finao_id, $userid, $finao_msg, $finao_status_ispublic, $updatedby, $finao_status, $iscompleted);
		break;

	case "changefinao":
		$finao_id  = mysql_real_escape_string($_POST['finao_id']);
		$user_id   = mysql_real_escape_string($_POST['user_id']);
		$finao_msg = mysql_real_escape_string($_POST['finao_msg']);
		changefinao($finao_id, $user_id, $finao_msg);
		break;

	case "editprofile":
		$user_profile_msg        = $_POST['user_profile_msg'];
		$user_location           = $_POST['user_location'];
		$profile_image           = $_POST['profile_image'];
		$profile_bg_image        = $_POST['profile_bg_image'];
		$profile_status_Ispublic = $_POST['profile_status_Ispublic'];
		$updatedby               = $_POST['updatedby'];
		$mystory                 = $_POST['mystory'];
		$iscompleted             = $_POST['Iscompleted'];
		$user_id                 = $_POST['user_id'];
		$email                   = $_POST['email'];
		$secondary_email         = $_POST['secondary_email'];
		$fname                   = $_POST['fname'];
		$lname                   = $_POST['lname'];
		$gender                  = $_POST['gender'];
		$location                = $_POST['location'];
		$dob                     = $_POST['dob'];
		$age                     = $_POST['age'];
		$socialnetwork           = $_POST['socialnetwork'];
		$socialnetworkid         = $_POST['socialnetworkid'];
		$usertypeid              = $_POST['usertypeid'];
		$status                  = $_POST['status'];
		$zipcode                 = $_POST['zipcode'];
		$uname                   = $_POST['uname'];
		editprofile($user_profile_msg, $user_location, $profile_image, $profile_bg_image, $profile_status_Ispublic, $updatedby, $mystory, $iscompleted, $user_id, $email, $secondary_email, $fname, $lname, $gender, $location, $dob, $age, $socialnetwork, $socialnetworkid, $usertypeid, $status, $zipcode, $uname);
		break;

	case "uploadvideoorimage_old":
		$response    = $v->viddler_videos_prepareUpload(array(
		'sessionid' => $viddler_session_id
		));
		$videostatus = $_POST['videostatus'];
		$id          = $_POST['id'];
		$user_id     = $_POST['user_id'];
		$caption     = $_POST['caption'];
		$type        = $_POST['type'];
		uploadvideoorimage_old($response, $videostatus, $id, $user_id, $caption, $type);
		break;

	case "uploadvideoorimage":
		$response    = $v->viddler_videos_prepareUpload(array(
		'sessionid' => $viddler_session_id
		));
		$id          = $_POST['id'];
		$user_id     = $_POST['user_id'];
		$type        = $_POST['type'];
		$videostatus = $_POST['videostatus'];
		$upload_text = mysql_real_escape_string(addslashes($_POST['upload_text']));
		$caption     = mysql_real_escape_string(trim($_POST['caption']));
		uploadvideoorimage($response);
		break;

	case "getimageorvideo":
		$type    = strtolower($_POST['type']); //Image/Video
		$srctype = strtolower($_POST['srctype']); //tile/finao/journal
		$srcid   = $_POST['srcid'];
		$user_id = $_POST['user_id'];
		getimageorvideo($viddler_session_id, $type, $srctype, $srcid, $user_id);
		break;

	case "getuser_finaocounts":
		$userid         = $authuserid;
		$actual_user_id = $_POST['actual_user_id'];
		getuser_finaocounts($user_id, $actual_user_id);
		break;

	case "homepage_user":
		homepage_user($authuserid);
		break;

	case "mytiles":
		mytiles($authuserid);
		break;
	case "finao_list":
		$type = $_POST['type'];
		$otherid = 0;
		if ($type == 1) {
			$otherid = $_POST['otherid'];
		}
		
		finao_list($authuserid, $type, $otherid);
		break;

	case "finaodetails":
		$finaoid = $_POST['finaoid'];
		finaodetails($finaoid);
		break;

	case "public_finao":
		$tileid = $_POST['tile_id'];
		$cust_id=$_POST['id'];
		
		if($cust_id!=null)
		{
			finao_public($cust_id,$tileid);
		}
		else{
			finao_public($authuserid,$tileid);
		}
		
		break;
	case "public_posts":
		$finao_id = $_POST['finao_id'];

		public_posts($finao_id );
		break;

	case "uploadimagesfinao":
		$finaoid    = $_POST['finaoid'];
		$type       = $_POST['type']; // finao or tile
		$uploadtext = $_POST['upload_text'];
		$captions   = json_decode($_POST['captiondata']);
		uploadimagesfinao($authuserid, $finaoid, $type, $uploadtext, $captions);
		break;

	case "changefinaostatus":
		$type                  = mysql_real_escape_string($_POST['type']); // 1=public/private status, 2=finaostatus, 3=completedstatus
		$userid                = $authuserid;
		$finao_id              = mysql_real_escape_string($_POST['finaoid']);
		$finao_status_ispublic = mysql_real_escape_string($_POST['finao_status_ispublic']);
		$finaostatus           = mysql_real_escape_string($_POST['status']);
		changefinaostatus($userid, $type, $finao_id, $finao_status_ispublic, $finaostatus);
		break;

}

function getImageOrVideodetails($type, $srctype, $srcid, $user_id)
{
	$sqlSelect    = "select * from fn_lookups where lookup_type='uploadtype' and Lower(lookup_name)='" . strtolower($type) . "'";
	$sqlSelectRes = mysql_query($sqlSelect);
	if (mysql_num_rows($sqlSelectRes) > 0) {
		while ($sqlSelectDet = mysql_fetch_assoc($sqlSelectRes)) {
			$lookup_id = $sqlSelectDet['lookup_id'];
		}
	}
	$sqlSelectSrctype    = "select * from fn_lookups where lookup_type='uploadsourcetype' and Lower(lookup_name)='" . strtolower($srctype) . "'";
	$sqlSelectSrctypeRes = mysql_query($sqlSelectSrctype);
	if (mysql_num_rows($sqlSelectSrctypeRes) > 0) {
		while ($sqlSelectSrctypeDet = mysql_fetch_assoc($sqlSelectSrctypeRes)) {
			$srclookup_id = $sqlSelectSrctypeDet['lookup_id'];
		}
	}

	$sqlSelectUpload = "select * from fn_uploaddetails where uploadtype='" . $lookup_id . "' and upload_sourcetype='" . strtolower($srclookup_id) . "' and upload_sourceid='" . $srcid . "' and uploadedby='" . $user_id . "'";

	$sqlSelectUploadRes = mysql_query($sqlSelectUpload);
	if (mysql_num_rows($sqlSelectUploadRes) > 0) {
		while ($sqlSelectUploadDet = mysql_fetch_assoc($sqlSelectUploadRes)) {
			$rows[] = unstrip_array($sqlSelectUploadDet);
		}
	}


	return $rows;
}
function stripslashes_deep($value)
{
	$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);

	return $value;
}
function unstrip_array($array)
{
	foreach ($array as &$val) {
		if (is_array($val)) {
			$val = unstrip_array($val);
		} else {
			$val = stripslashes($val);
		}
	}
	return $array;
}
mysql_close();
function url_get_contents($Url)
{
	if (!function_exists('curl_init')) {
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
	$curl      = curl_init();
	$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';

	curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.

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
	$totalfollowings   = 0;
	$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = '" . $userid . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
	$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
	$totalfollowings   = mysql_num_rows($sqlMyTrackingsRes);
	return $totalfollowings;
}
function fngetTotalFinaos($userid, $actual_user_id)
{
	$totalfinaos    = 0;
	$sqlFianosCount = "SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid ='" . $userid . "' AND f.finao_activestatus =1 and finao_status_Ispublic = 1";
	$sqlFinaosCount = "SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid ='" . $userid . "' AND f.finao_activestatus =1";
	
	$sqlSelectCountRes = mysql_query($sqlFinaosCount);

	//	echo $sqlFinaosCount;

	$totalfinaos = mysql_num_rows($sqlSelectCountRes);
	return $totalfinaos;
}

function fngetTotalTiles($userid, $actual_user_id)
{
	$totaltiles    = 0;
	$sqlTilesCount = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='" . $userid . "' AND finao_activestatus !=2 ";
	if ($actual_user_id != "")
		$sqlTilesCount .= " and Iscompleted =0 ";
	if ($actual_user_id != "")
		$actual_user_id .= " and `finao_status_Ispublic` =1";
	if ($actual_user_id == "search")
		$sqlTilesCount .= " and `finao_status_Ispublic` =1 ";
	$sqlTilesCount .= " GROUP BY tile_id ";

	$sqlTilesCountRes = mysql_query($sqlTilesCount);
	$totaltiles       = mysql_num_rows($sqlTilesCountRes);
	return $totaltiles;
}
function fngetTotalTiles_counts($userid, $actual_user_id)
{
	$totaltiles    = 0;
	$sqlTilesCount = "SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='" . $userid . "' AND finao_activestatus !=2 ";
	//if($actual_user_id!="")
	$sqlTilesCount .= " and Iscompleted =0 ";
	if ($actual_user_id != "")
		$sqlTilesCount .= " and `finao_status_Ispublic` =1";
	$sqlTilesCount .= " GROUP BY tile_id ";


	$sqlTilesCountRes = mysql_query($sqlTilesCount);
	$totaltiles       = mysql_num_rows($sqlTilesCountRes);
	return $totaltiles;
}
function fngetTotalFollowers($userid)
{
	$sqlMyTrackings    = "select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracker_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracked_userid = '" . $userid . "' and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname";
	$sqlMyTrackingsRes = mysql_query($sqlMyTrackings);
	$totalfollowers    = mysql_num_rows($sqlMyTrackingsRes);
	return $totalfollowers;
}
function rand_string($length)
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size  = strlen($chars);
	for ($i = 0; $i < $length; $i++) {
		$str .= $chars[rand(0, $size - 1)];
	}
	return $str;
}
?>
