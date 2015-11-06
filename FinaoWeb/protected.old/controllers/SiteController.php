<?php
class SiteController extends Controller
{
    //public $defaultAction = 'testSplashPage';
    /**
    
    * Declares class-based actions.
    
    */
    public $url;
    public $header;
    public $Isactive;
    public $organizationactive;
    public $popup;
    public $newuser;
    public $notFindMesg;
    public $layout = '/layouts/column3';
    public $selheader;
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'transparent' => true,
                'testLimit' => 1,
                'foreColor' => 0x348017
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction'
            )
        );
    }
    /**
    
    
    
    * This is the default 'index' action that is invoked
    
    
    
    * when an action is not explicitly requested by users.	 */
    public function actionIndex()
    {
        //echo 'u r in ';exit;
        if (isset(Yii::app()->session['login']['id'])) {
            $this->redirect(array(
                '/myhome'
            ));
        }
        $userinfo        = '';
        /*if(isset($_REQUEST["homepage"]))
        
        {*/
        $this->layout    = '/layouts/column2';
        /*}*/
        $this->selheader = "register";
        if (isset(Yii::app()->session['fbreg']))
            unset(Yii::app()->session['fbreg']);
        if ($_REQUEST['type']) {
            $type = $_REQUEST['type'];
        }
        if (isset($_REQUEST['url'])) {
            if ($_REQUEST['url'] == 'activation') {
                $this->Isactive = 'active';
            }
            if ($_REQUEST['url'] == 'aboutus') {
                $this->Isactive = 'aboutus';
            } else if ($_REQUEST['url'] == 'fberror') {
                $this->Isactive = 'fberror';
            } elseif ($_REQUEST['url'] == 'newfbreg') {
                if (isset($_REQUEST['error']) && ($_REQUEST['error'] == 'access_denied')) {
                    $this->redirect(array(
                        'site/index'
                    ));
                }
                $userinfo = Yii::app()->facebook->api('/me');
                if (isset($_REQUEST['error_reason']) && ($_REQUEST['error_reason'] == 'user_denied')) {
                    Yii::app()->user->setFlash('fbusererror', 'You are NOT LOGGED IN.You must allow basic permission access to Login from facebook');
                    $this->redirect(array(
                        '/'
                    ));
                }
                //Get Lists of facebook friends
                //if(Yii::app()->facebook->api('/me'))
                $lists    = Yii::app()->facebook->api('me/friends');
                $allemail = User::model()->findAll(array(
                    'condition' => 'status = 1'
                ));
                /*$allemail = User::model()->findAll(array('condition'=>'status = 1 AND usertypeid = 1'));*/
                $i        = 0;
                foreach ($allemail as $eachmail) {
                    $existedemails[$i++] = $eachmail->socialnetworkid;
                }
                //print_r($lists['data']);exit;
                $knownusers = array();
                $i          = 0;
                foreach ($lists['data'] as $key => $friendList) {
                    //echo $friendList['id']."<br >";
                    //$knownusers[$i++] = $friendList['id'];
                }
                for ($i = 0, $j = 0, $k = 0; $i < COUNT($lists); $i++) {
                    if (in_array($lists[$i]['id'], $existedemails)) {
                        $knownusers[$j++] = $lists[$i]['id'];
                    }
                }
                if (isset(Yii::app()->session['knownusers']))
                    unset(Yii::app()->session['knownusers']);
                if (isset(Yii::app()->session['fbusers']))
                    unset(Yii::app()->session['fbusers']);
                Yii::app()->session['knownusers'] = $knownusers;
                Yii::app()->session['fbusers']    = $lists['data'];
                //$email = $lists['email'];
                //End of gettting lists
                $email                            = $userinfo['email'];
                $IsUser                           = User::model()->findByAttributes(array(
                    'email' => $email
                ));
                if (isset($IsUser) && !empty($IsUser)) {
                    if ($IsUser->status == 1) {
                        if ($IsUser->socialnetworkid == 0) {
                            $IsUser->socialnetworkid = $userinfo['id'];
                            $IsUser->socialnetwork   = "facebook";
                            $IsUser->save(false);
                        }
                        $login = array();
                        if (isset(Yii::app()->session['login']))
                            unset(Yii::app()->session['login']);
                        if (isset(Yii::app()->session['userinfo']))
                            unset(Yii::app()->session['userinfo']);
                        $login["id"]                 = $IsUser->userid;
                        //$login["username"] = $IsUser->fname.'  '.$IsUser->lname;
                        $login["username"]           = $IsUser->fname;
                        $login["email"]              = $IsUser->email;
                        $login["socialnetworkid"]    = $IsUser->socialnetworkid;
                        $login["superuser"]          = $IsUser->superuser;
                        $userprofile                 = UserProfile::model()->findByAttributes(array(
                            'user_id' => $IsUser->userid
                        ));
                        $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
                        $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
                        Yii::app()->session['login'] = $login;
                        $IsSkipped                   = UserProfile::model()->findByAttributes(array(
                            'user_id' => $IsUser->userid
                        ));
                        $IsFinao                     = UserFinao::model()->findByAttributes(array(
                            'userid' => $IsUser->userid
                        ));
                        if (!empty($IsSkipped) && $IsSkipped->IsCompleted == "skipped") {
                            if (empty($IsFinao)) {
                                $this->redirect(array(
                                    '/finao/motivationmesg'
                                ));
                            } else {
                                $this->redirect(array(
                                    '/finao/motivationmesg'
                                ));
                            }
                        } elseif (!empty($IsSkipped) && $IsSkipped->IsCompleted == "saved") {
                            $this->redirect(array(
                                '/finao/motivationmesg'
                            ));
                        } else {
                            //$this->redirect(array('profile/profilelanding'));
                            $this->redirect(array(
                                'profile/landing'
                            ));
                        }
                    } else {
                        /** email id already exists **/
                    }
                } else {
                    /*$fbreg = array();
                    
                    if(isset(Yii::app()->session['fbreg']))
                    
                    unset(Yii::app()->session['fbreg']);
                    
                    $fbreg["first_name"] = $userinfo['first_name'];
                    
                    $fbreg["last_name"] = $userinfo['last_name'];
                    
                    $fbreg["email"] = $userinfo['email'];
                    
                    Yii::app()->session['fbreg'] = $fbreg;*/
                    $this->Isactive = 'newfbreg';
                    /*					$url="http://www.aweber.com/scripts/addlead.pl";
                    
                    $data = http_build_query(array(
                    
                    "meta_web_form_id" => "316572300",
                    
                    "meta_split_id" => "",
                    
                    "listname" => "finao_reg",
                    
                    "redirect" => "",
                    
                    "meta_redirect_onlist"  => "http://dev.skootweet.com",
                    
                    "meta_adtracking" => "Finao_Reg_Form",
                    
                    "meta_message" => "1",
                    
                    "meta_required" => "email",
                    
                    "meta_tooltip" => "",
                    
                    //The User data fetched from form
                    
                    "email" => $email,
                    
                    ));
                    
                    $this->post_send($url,$data);
                    
                    */
                }
            } elseif ($_REQUEST['url'] == 'newuser') {
                $this->newuser = 'newuser';
                $sesnewUser    = array();
                if (isset(Yii::app()->session['newUser'])) {
                    unset(Yii::app()->session['newUser']);
                }
                $sesnewUser['newUser']         = $this->newuser;
                Yii::app()->session['newuser'] = $this->newuser;
            } elseif ($_REQUEST['url'] == 'changepswd') {
                $this->popup = 'forgotchngpwd';
            } elseif ($_REQUEST['url'] == 'orgactivation') {
                $this->popup = 'orgactivation';
            }
        }
        /*if(isset($_REQUEST['request_ids']))
        
        
        
        {
        
        
        
        $this->newuser = 'fbinvite';
        
        
        
        echo "hiii";
        
        
        
        exit;
        
        
        
        }*/
        $model   = new User;
        /*if(isset(Yii::app()->session['login']))
        
        
        
        {
        
        
        
        if(isset(Yii::app()->session['userinfo']))
        
        
        
        unset(Yii::app()->session['userinfo']);
        
        
        
        }*/
        $gender  = Lookups::model()->findAllByAttributes(array(
            'lookup_type' => 'UIValues-Gender'
        ));
        $gender2 = CHtml::listData($gender, 'lookup_id', 'lookup_name');
        if (isset($_REQUEST["email"]) && isset($_REQUEST["uid"])) {
            $count = AweberLog::model()->findByAttributes(array(
                'email' => $_REQUEST["email"],
                'uid' => $_REQUEST["uid"]
            ));
            if ($count > 0)
                $this->Isactive = "newreg";
            else
                $this->redirect(Yii::app()->createUrl('site/index'));
        }
        $this->render('index', array(
            'gender' => $gender2,
            'model' => $model,
            'user_profile' => $userinfo,
            'joinnow' => isset($_REQUEST["joinnow"]) ? $_REQUEST["joinnow"] : "",
            'email' => isset($_REQUEST["email"]) ? $_REQUEST["email"] : "",
            'type' => $type
        ));
    }
    /* This action for Spearker promotion */
    public function actionEasyRegister()
    {
        $pid  = "";
        $type = "";
        if (!empty($_REQUEST['pid'])) {
            $pid = $_REQUEST['pid'];
        }
        if (!empty($_REQUEST['type'])) {
            $type = $_REQUEST['type'];
        }
        //echo $type;
        //echo $pid;exit;
        if (isset(Yii::app()->session['login']['id'])) {
            $this->redirect(array(
                '/myhome'
            ));
        }
        $tile      = $_REQUEST['tile'];
        $pieces    = explode("-", $tile);
        $tilename  = trim(ucfirst($pieces[0]) . ' ' . $pieces[1]); // piece2
        //echo $tilename;
        $tileimage = strtolower($pieces[0] . $pieces[1]);
        if (!empty($tileimage)) {
            //echo $tileimage;exit;
            $sql        = "SELECT *  FROM `fn_lookups` WHERE `lookup_name` = '" . $tilename . "'";
            $connection = Yii::app()->db;
            $command    = $connection->createCommand($sql);
            $tileids    = $command->queryAll();
        }
        $this->layout = '/layouts/column2';
        $this->render('speakerpromo', array(
            'ready' => (!empty($_REQUEST['tile'])) ? $_REQUEST['tile'] : '',
            'tileids' => $tileids,
            'type' => $type,
            'pid' => $pid
        ));
    }
    public function actionEasylogin()
    {
       // print_r($_POST);exit;
        $type        = $_POST['type'];
        $finaomesg   = $_POST['finaomsg'];
        $fname       = $_POST['name'];
        $email       = $_POST['email'];
        $phonenumber = $_POST['mobile'];
        $pwd         = md5($_POST['password']);
        if ($type == 'video') {
            $user  = User::model()->findByAttributes(array(
                'email' => $email
            ));
            $model = new User;
            if ($user['email'] != '' && $user['password'] != $pwd) {
                echo "0";
            } else {
                $user = User::model()->findByAttributes(array(
                    'email' => $email,
                    'password' => $pwd,
                    'status' => 1
                ));
                if ($user['email'] != '') {
                    $login                       = array();
                    $login["id"]                 = $user['userid'];
                    $login["username"]           = $user['fname'];
                    $login["socialnetworkid"]    = $user['socialnetworkid'];
                    $login["trackid"]            = $user['trackid'];
                    $userprofile                 = UserProfile::model()->findByAttributes(array(
                        'user_id' => $user['userid']
                    ));
                    $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
                    $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
                    Yii::app()->session['login'] = $login;
                    echo 'video-false-' . $_POST['utype'];
                    if (isset($_POST['sourceid']) != '') {
                        //
                        $vote = $this->registervote($_POST['voteduser'], $_POST['sourceid']);
                        echo $vote;
                    }
                } else {
                    //echo 'video-true';
                    $model                  = new User;
                    $model->fname           = $fname;
                    $model->email           = $email;
                    $model->password        = $pwd;
                    $model->usertypeid      = 1;
                    $model->createtime      = date('Y-m-d G:i:s');
                    $model->socialnetworkid = 0;
                    $model->status          = 1;
                    $model->trackid         = 66;
                    /* $mageid = $this->processshopreg($firstname,'',$email,$_POST['pwd']);
                    
                    if(!empty($mageid))
                    
                    {
                    
                    $model->mageid = $mageid;
                    
                    }*/
                    if ($model->save(false)) {
                        $userid                      = $model->userid;
                        //echo $userid;
                        $newuserprofile              = new UserProfile;
                        $newuserprofile->user_id     = $userid;
                        $newuserprofile->createdby   = $userid;
                        $newuserprofile->createddate = date('Y-m-d G:i:s');
                        $newuserprofile->updatedby   = $userid;
                        $newuserprofile->updateddate = date('Y-m-d G:i:s');
                        $newuserprofile->IsCompleted = "";
                        if ($newuserprofile->save(false)) {
                            $email     = $email;
                            $usercheck = User::model()->findByAttributes(array(
                                'email' => $email,
                                'status' => 1
                            ));
                            $password  = md5($usercheck->password);
                            if ($usercheck) {
                                $activkey  = md5(uniqid(rand(), true));
                                $forgoturl = $this->createAbsoluteUrl('/site/changepswdpopup', array(
                                    "activkey" => $activkey,
                                    "email" => $usercheck->email
                                ));
                                $subj      = "Reset Password";
                                $mesg      = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Registration Confirmation</title>

</head>



<body>



	<div style="width:670px; margin:0px auto; padding:0px; background:#FFF; border-left:solid 20px #dddddd; border-right:solid 20px #dddddd;">

	<div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Email_Header.png" style="padding:0; margin:0; border:0;" /></div>

    <div style="width:650px; padding:10px; margin:0px; font-family:Geneva, Arial, Helvetica, sans-serif;"><br />

    	<div style="color:rgb(244, 123, 32); font-weight:bold; font-size:16px; padding-bottom:5px;">Hi ' . ucfirst($usercheck->fname) . ' ,</div>

        

        

     <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;">

	 

	  Thank you for Joining FINAO Nation.<br /> <br />

      Please set your password and validate your account within next 24 hours by clicking on the link given below to login to the site in future.

 <br />' . $forgoturl . '<br /> <br /> If the link doesn\'t work, please copy and paste the URL into your browser instead.<br /> <br />

</div>

        <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;"> </div>

        

        <div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Signature.png" style="border:0; padding:0; margin:0;" /></div>

        

    </div>

	<div style="width:650px; margin:0px auto; text-align:right">

    	<ul style="list-style:none; margin:0px; padding:0px;">

            <a target="_blank" href="https://www.facebook.com/FINAONation"><li style="background:url(http://finaonation.com/images/soc-icons.png) 0 -38px; width:13px; height:29px; display:inline-block; list-style:none; margin:0 4px;"></li></a>

             <a target="_blank" href="http://pinterest.com/finaonation/"><li style="background:url(http://finaonation.com/images/soc-icons.png) -80px -38px; width:24px; height:30px; display:inline-block; list-style:none; margin:0 4px;"></li></a>

            <a target="_blank" href="http://www.linkedin.com/company/2253999"><li style="background:url(http://finaonation.com/images/soc-icons.png) -21px -38px; width:26px; height:27px; display:inline-block; list-style:none; margin:0 4px;"></li></a>

            <a target="_blank" href="https://twitter.com/FINAONation"><li style="background:url(http://finaonation.com/images/soc-icons.png) -53px -38px; width:20px; height:26px; display:inline-block; list-style:none; margin:0 4px;"></li></a>

       </ul>

    </div>

    <div style="background:#000; width:670px; font-size:11px; color:rgb(153, 153, 153); text-align:center; padding:10px 0; font-family:Geneva, Arial, Helvetica, sans-serif;">

        <div style="padding-bottom:5px;">This message was mailed to <span style="color:rgb(244, 123, 32)!important;">' . $email . '</span> by FINAO Nation.</div>

        <div style="padding-bottom:5px;">

            <a href="http://' . $_SERVER['HTTP_HOST'] . '" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">FINAO</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/contactus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Contact Us</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/aboutus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">About FINAO</a> | 

            <a href="mailto:unsubscribe@finaonation.com?Subject=Hello%20again" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Unsubscribe</a>

            

            

        </div>

        <div>

			<div style="padding:0px!important; margin:0px!important; line-height:18px;">To unsubscribe, click the link above, or send an email to: <a href="#" style="color:rgb(153, 153, 153)!important; text-decoration:none; cursor:default;">unsubscribe@finaonation.com</a>. Do not reply to this email address.</div> 

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">It is a notification only address and is not monitored for incoming email. </div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">Use of the FINAO Nation website and mobile app constitutes acceptance of our Terms of Use and Privacy Policy.</div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">&copy; ' . date("Y") . ' FINAO Nation, 13024 Beverly Park Rd, Mukilteo, WA 98275, U.S.A.</div>

        </div>

    </div>

</div>



</body>

</html>';
                                $headers   = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                                $headers .= "From: do-not-reply@finaonation.com";
                                mail($usercheck->email, $subj, $mesg, $headers);
                                $usercheck->activkey = $activkey;
                                $usercheck->save(FALSE);
                            }
                            $login                       = array();
                            $login["id"]                 = $userid;
                            $login["username"]           = $model->fname;
                            $login["socialnetworkid"]    = $model->socialnetworkid;
                            $login["trackid"]            = $user['trackid'];
                            $userprofile                 = UserProfile::model()->findByAttributes(array(
                                'user_id' => $userid
                            ));
                            $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
                            $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
                            Yii::app()->session['login'] = $login;
                            echo 'video-true-' . $_POST['utype'];
                        }
                    }
                }
            }
        } 
		else if ($type == 'easy') {
            $user  = User::model()->findByAttributes(array(
                'email' => $email
            ));
            $model = new User;
            if ($user['email'] != '' && $user['password'] != $pwd) {
                echo "0";
            } else {
				//echo 1;
                $user = User::model()->findByAttributes(array(
                    'email' => $email,
                    'password' => $pwd,
                    'status' => 1
                ));
                if ($user['email'] != '') {
                    $login                       = array();
                    $login["id"]                 = $user['userid'];
                    $login["username"]           = $user['fname'];
                    $login["socialnetworkid"]    = $user['socialnetworkid'];
                    $login["trackid"]            = $user['trackid'];
                    $userprofile                 = UserProfile::model()->findByAttributes(array(
                        'user_id' => $user['userid']
                    ));
                    $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
                    $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
                    Yii::app()->session['login'] = $login;
                    echo 'easy-false';
                    if (isset($_POST['sourceid']) != '') {
                        //
                        $vote = $this->registervote($_POST['voteduser'], $_POST['sourceid']);
                        echo $vote;
                    }
                } 
				else 
				{
					if(empty($fname))
					{
						echo '22';
					}
					else
					{
						
					
					
                    //echo 'video-true';
                    $model                  = new User;
                    $model->fname           = $fname;
                    $model->email           = $email;
                    $model->password        = $pwd;
                    $model->usertypeid      = 1;
                    $model->createtime      = date('Y-m-d G:i:s');
                    $model->socialnetworkid = 0;
                    $model->status          = 1;
                    $model->trackid         = 66;
                    /* $mageid = $this->processshopreg($firstname,'',$email,$_POST['pwd']);
                    
                    if(!empty($mageid))
                    
                    {
                    
                    $model->mageid = $mageid;
                    
                    }*/
                    if ($model->save(false)) {
                        $userid                      = $model->userid;
                        //echo $userid;
                        $newuserprofile              = new UserProfile;
                        $newuserprofile->user_id     = $userid;
                        $newuserprofile->createdby   = $userid;
                        $newuserprofile->createddate = date('Y-m-d G:i:s');
                        $newuserprofile->updatedby   = $userid;
                        $newuserprofile->updateddate = date('Y-m-d G:i:s');
                        $newuserprofile->IsCompleted = "";
                        if ($newuserprofile->save(false)) {
                            $email     = $email;
                            $usercheck = User::model()->findByAttributes(array(
                                'email' => $email,
                                'status' => 1
                            ));
                            $password  = md5($usercheck->password);
                            if ($usercheck) {
                                $activkey  = md5(uniqid(rand(), true));
                                $forgoturl = $this->createAbsoluteUrl('/site/changepswdpopup', array(
                                    "activkey" => $activkey,
                                    "email" => $usercheck->email
                                ));
                                $subj      = "Reset Password";
                                $mesg      = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Registration Confirmation</title>

</head>



<body>



	<div style="width:670px; margin:0px auto; padding:0px; background:#FFF; border-left:solid 20px #dddddd; border-right:solid 20px #dddddd;">

	<div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Email_Header.png" style="padding:0; margin:0; border:0;" /></div>

    <div style="width:650px; padding:10px; margin:0px; font-family:Geneva, Arial, Helvetica, sans-serif;"><br />

    	<div style="color:rgb(244, 123, 32); font-weight:bold; font-size:16px; padding-bottom:5px;">Hi ' . ucfirst($usercheck->fname) . ' ,</div>

        

        

     <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;">

	 

	  Thank you for Joining FINAO Nation.<br /> <br />

      Please set your password and validate your account within next 24 hours by clicking on the link given below to login to the site in future.

 <br />' . $forgoturl . '<br /> <br /> If the link doesn\'t work, please copy and paste the URL into your browser instead.<br /> <br />

</div>

        <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;"> </div>

        

        <div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Signature.png" style="border:0; padding:0; margin:0;" /></div>

        

    </div>

	<div style="width:650px; margin:0px auto; text-align:right">

    	<ul style="list-style:none; margin:0px; padding:0px;">

            <a target="_blank" href="https://www.facebook.com/FINAONation"><li style="background:url(http://finaonation.com/images/soc-icons.png) 0 -38px; width:13px; height:29px; display:inline-block; list-style:none; margin:0 4px;"></li></a>

             <a target="_blank" href="http://pinterest.com/finaonation/"><li style="background:url(http://finaonation.com/images/soc-icons.png) -80px -38px; width:24px; height:30px; display:inline-block; list-style:none; margin:0 4px;"></li></a>

            <a target="_blank" href="http://www.linkedin.com/company/2253999"><li style="background:url(http://finaonation.com/images/soc-icons.png) -21px -38px; width:26px; height:27px; display:inline-block; list-style:none; margin:0 4px;"></li></a>

            <a target="_blank" href="https://twitter.com/FINAONation"><li style="background:url(http://finaonation.com/images/soc-icons.png) -53px -38px; width:20px; height:26px; display:inline-block; list-style:none; margin:0 4px;"></li></a>

       </ul>

    </div>

    <div style="background:#000; width:670px; font-size:11px; color:rgb(153, 153, 153); text-align:center; padding:10px 0; font-family:Geneva, Arial, Helvetica, sans-serif;">

        <div style="padding-bottom:5px;">This message was mailed to <span style="color:rgb(244, 123, 32)!important;">' . $email . '</span> by FINAO Nation.</div>

        <div style="padding-bottom:5px;">

            <a href="http://' . $_SERVER['HTTP_HOST'] . '" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">FINAO</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/contactus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Contact Us</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/aboutus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">About FINAO</a> | 

            <a href="mailto:unsubscribe@finaonation.com?Subject=Hello%20again" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Unsubscribe</a>

            

            

        </div>

        <div>

			<div style="padding:0px!important; margin:0px!important; line-height:18px;">To unsubscribe, click the link above, or send an email to: <a href="#" style="color:rgb(153, 153, 153)!important; text-decoration:none; cursor:default;">unsubscribe@finaonation.com</a>. Do not reply to this email address.</div> 

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">It is a notification only address and is not monitored for incoming email. </div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">Use of the FINAO Nation website and mobile app constitutes acceptance of our Terms of Use and Privacy Policy.</div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">&copy; ' . date("Y") . ' FINAO Nation, 13024 Beverly Park Rd, Mukilteo, WA 98275, U.S.A.</div>

        </div>

    </div>

</div>



</body>

</html>';
                                $headers   = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                                $headers .= "From: do-not-reply@finaonation.com";
                                mail($usercheck->email, $subj, $mesg, $headers);
                                $usercheck->activkey = $activkey;
                                $usercheck->save(FALSE);
                            }
                            $login                       = array();
                            $login["id"]                 = $userid;
                            $login["username"]           = $model->fname;
                            $login["socialnetworkid"]    = $model->socialnetworkid;
                            $login["trackid"]            = $user['trackid'];
                            $userprofile                 = UserProfile::model()->findByAttributes(array(
                                'user_id' => $userid
                            ));
                            $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
                            $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
                            Yii::app()->session['login'] = $login;
                            echo 'easy-true';
                        }
                    }
                
					}
					
				}
            }
        } 
		else {
            //echo $type;exit;
            //print_r($_POST);exit;
            $tile       = $_POST['tilename'];
            $pieces     = explode("-", $tile);
            $tilename   = trim(ucfirst($pieces[0]) . ' ' . ($pieces[1])); // piece2
            //echo $tilename;
            $sql        = "SELECT *  FROM `fn_lookups` WHERE `lookup_name` = '" . $tilename . "'";
            $connection = Yii::app()->db;
            $command    = $connection->createCommand($sql);
            $tileids    = $command->queryAll();
            foreach ($tileids as $newtile) {
                $tileid = $newtile["lookup_id"];
            }
            $tileimage = strtolower($pieces[0] . $pieces[1]);
            // echo $tileimage;
            //echo $tileid;
            // exit;
            //echo $pwd;exit;
            $user      = User::model()->findByAttributes(array(
                'email' => $email,
                'password' => $pwd,
                'status' => 1
            ));
            $model     = new User;
            // $user['email'];exit;
           if($_POST['email']=='')
		   {
			   echo 0;
		   } 
		   else
		   {
			   if (!empty($user)) {
                if ($user['email'] != '') {
                    $userid              = $user['userid'];
                    $newfinao            = new UserFinao;
                    // for badword
                    $words               = str_word_count($_POST['finaomsg'], 1);
                    $lastWord            = array_pop($words);
                    $lastSpacePosition   = strrpos($_POST['finaomsg'], ' ');
                    $textWithoutLastWord = $_POST['finaomsg'];
                    $tiles               = FnProfanityWords::model()->findAll();
                    foreach ($tiles as $tiles) {
                        if (strtolower($lastWord) == strtolower($tiles->badword)) {
                            $textWithoutLastWord = substr($_POST['finaomsg'], 0, $lastSpacePosition);
                            $textWithoutLastWord .= ' **** ';
                        }
                    }
                    if (isset($_POST['finaomsg']) && $_POST['finaomsg'] != "")
                        $newfinao->finao_msg = $textWithoutLastWord;
                    $public                          = 1;
                    $newfinao->finao_status_Ispublic = $public;
                    $newfinao->userid                = $userid;
                    $newfinao->createddate           = new CDbExpression('NOW()');
                    $newfinao->updatedby             = $userid;
                    $newfinao->updateddate           = new CDbExpression('NOW()');
                    $newfinao->finao_status          = 38;
                    if ($newfinao->save(false)) {
                        $finao_id                     = $newfinao->user_finao_id;
                        $newtile                      = new UserFinaoTile;
                        $newtile->tile_id             = $tileid;
                        $newtile->tile_name           = $tilename;
                        $newtile->finao_id            = $newfinao->user_finao_id;
                        $tileimgurl                   = '' . $tileimage . '.jpg';
                        $newtile->tile_profileImagurl = $tileimgurl;
                        $newtile->userid              = $userid;
                        $newtile->status              = 1;
                        $newtile->createddate         = new CDbExpression('NOW()');
                        $newtile->createdby           = $userid;
                        $newtile->updateddate         = new CDbExpression('NOW()');
                        $newtile->updatedby           = $userid;
                        if ($newtile->save(false)) {
                            $tilename   = $tilename;
                            $istileinfo = TilesInfo::model()->findByAttributes(array(
                                'tilename' => $tilename,
                                'createdby' => $userid
                            ));
                            if (!isset($istileinfo) && empty($istileinfo)) {
                                $tileinfo                = new TilesInfo;
                                $tileinfo->tile_id       = $tileid;
                                $tileinfo->tilename      = $tilename;
                                $tileinfo->tile_imageurl = $tileimgurl;
                                $tileinfo->status        = 1;
                                $tileinfo->createdby     = $userid;
                                $tileinfo->createddate   = new CDbExpression('NOW()');
                                $tileinfo->updateddate   = new CDbExpression('NOW()');
                                $tileinfo->updatedby     = $userid;
                                $tileinfo->save(false);
                            }
                        }
                        $login                       = array();
                        $login["id"]                 = $userid;
                        $login["username"]           = $model->fname;
                        $login["socialnetworkid"]    = $model->socialnetworkid;
                        $login["trackid"]            = $user['trackid'];
                        $userprofile                 = UserProfile::model()->findByAttributes(array(
                            'user_id' => $userid
                        ));
                        $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
                        $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
                        Yii::app()->session['login'] = $login;
                        echo '2-' . $tileid;
                    } else {
                        echo "0"; //Enter fields
                    }
                } else {
                    echo "1";
                    //You are already subscribed or your account may not be activated
                }
            } else {
                //echo 'u r in';
                $model                  = new User;
                $model->fname           = $fname;
                $model->email           = $email;
                $model->password        = md5($email);
                $model->usertypeid      = 1;
                $model->createtime      = date('Y-m-d G:i:s');
                $model->socialnetworkid = 0;
                $model->trackid         = $tileid;
                $model->status          = 1;
                $mageid                 = $this->processshopreg($fname, '', $email, $_POST['pwd']);
                if ($mageid != '') {
                    $model->mageid = $mageid;
                }
                if ($model->save(false)) {
                    $userid                      = $model->userid;
                    //echo $userid;
                    $newuserprofile              = new UserProfile;
                    $newuserprofile->user_id     = $userid;
                    $newuserprofile->createdby   = $userid;
                    $newuserprofile->createddate = date('Y-m-d G:i:s');
                    $newuserprofile->updatedby   = $userid;
                    $newuserprofile->updateddate = date('Y-m-d G:i:s');
                    $newuserprofile->IsCompleted = "";
                    if ($newuserprofile->save(false)) {
                        $email     = $email;
                        $usercheck = User::model()->findByAttributes(array(
                            'email' => $email,
                            'status' => 1
                        ));
                        $password  = md5($usercheck->password);
                        if ($usercheck) {
                            $activkey  = md5(uniqid(rand(), true));
                            $forgoturl = $this->createAbsoluteUrl('/site/changepswdpopup', array(
                                "activkey" => $activkey,
                                "email" => $usercheck->email
                            ));
                            //$subj = "Reset Password";
                            $subj      = $_POST['finaomsg'];
                            $mesg      = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Registration Confirmation</title>

</head>



<body>



	<div style="width:670px; margin:0px auto; padding:0px; background:#FFF; border-left:solid 20px #dddddd; border-right:solid 20px #dddddd;">

	<div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Email_Header.png" style="padding:0; margin:0; border:0;" /></div>

    <div style="width:650px; padding:10px; margin:0px; font-family:Geneva, Arial, Helvetica, sans-serif;"><br />

    	<div style="color:rgb(244, 123, 32); font-weight:bold; font-size:16px; padding-bottom:5px;">Hi ' . ucfirst($usercheck->fname) . ' ,</div>

        

        

     <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;">

	 

	  <p> What a great FINAO!   Thank you for sharing.  You are now a part of a national movement to make it fun and cool to live a goal oriented life.  Click on the link below and begin.  Our mission is to support yours by helping you accomplish your dreams.</p>



<p>Finao will allow you to follow others, and be exposed to content that will allow you to connect with like minded people.  Victory is in the Pursuit.  Let the Journey begin.

.</p><br /> <br />

      Please set your password and validate your account within next 24 hours by clicking on the link given below to login to the site in future.

 <br />' . $forgoturl . '<br /> <br /> If the link doesn\'t work, please copy and paste the URL into your browser instead.<br /> <br />

</div>

        <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;"> </div>

        

        <div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Signature.png" style="border:0; padding:0; margin:0;" /></div>

        

    </div>

	<div style="width:650px; margin:0px auto; text-align:right; padding-bottom:5px;">

     <ul style="list-style:none; margin:0px; padding:0px;">

            <a href="https://www.facebook.com/FINAONation" target="_blank" title="facebook"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-facebook.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

			<a href="http://www.linkedin.com/company/2253999" target="_blank" title="linkedin"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-linkedin.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

             <a href="http://pinterest.com/finaonation/" target="_blank" title="pinterest"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-pinterest.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

            <a href="https://twitter.com/FINAONation" target="_blank" title="twitter"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-twitter.png" style="border:0; padding:0;" /></a>

       </ul>

    </div>

    <div style="background:#000; width:670px; font-size:11px; color:rgb(153, 153, 153); text-align:center; padding:10px 0; font-family:Geneva, Arial, Helvetica, sans-serif;">

        <div style="padding-bottom:5px;">This message was mailed to <span style="color:rgb(244, 123, 32)!important;">' . $email . '</span> by FINAO Nation.</div>

        <div style="padding-bottom:5px;">

            <a href="http://' . $_SERVER['HTTP_HOST'] . '" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">FINAO</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/contactus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Contact Us</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/aboutus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">About FINAO</a> | 

            <a href="mailto:unsubscribe@finaonation.com?Subject=Hello%20again" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Unsubscribe</a>

            

            

        </div>

        <div>

			<div style="padding:0px!important; margin:0px!important; line-height:18px;">To unsubscribe, click the link above, or send an email to: <a href="#" style="color:rgb(153, 153, 153)!important; text-decoration:none; cursor:default;">unsubscribe@finaonation.com</a>. Do not reply to this email address.</div> 

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">It is a notification only address and is not monitored for incoming email. </div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">Use of the FINAO Nation website and mobile app constitutes acceptance of our Terms of Use and Privacy Policy.</div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">&copy; ' . date("Y") . ' FINAO Nation, 13024 Beverly Park Rd, Mukilteo, WA 98275, U.S.A.</div>

        </div>

    </div>

</div>



</body>

</html>';
                            $headers   = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                            $headers .= "From: do-not-reply@finaonation.com";
                            mail($usercheck->email, $subj, $mesg, $headers);
                            $usercheck->activkey = $activkey;
                            if ($usercheck->save(FALSE))
                                echo "4-"; //Succesful email
                        }
                        $newuserprofile->user_profile_id;
                        $newfinao            = new UserFinao;
                        // for badword
                        $words               = str_word_count($_POST['finaomsg'], 1);
                        $lastWord            = array_pop($words);
                        $lastSpacePosition   = strrpos($_POST['finaomsg'], ' ');
                        $textWithoutLastWord = $_POST['finaomsg'];
                        $tiles               = FnProfanityWords::model()->findAll();
                        foreach ($tiles as $tiles) {
                            if (strtolower($lastWord) == strtolower($tiles->badword)) {
                                $textWithoutLastWord = substr($_POST['finaomsg'], 0, $lastSpacePosition);
                                $textWithoutLastWord .= ' **** ';
                            }
                        }
                        if (isset($_POST['finaomsg']) && $_POST['finaomsg'] != "")
                            $newfinao->finao_msg = $textWithoutLastWord;
                        $public                          = 1;
                        $newfinao->finao_status_Ispublic = $public;
                        $newfinao->userid                = $userid;
                        $newfinao->createddate           = new CDbExpression('NOW()');
                        $newfinao->updatedby             = $userid;
                        $newfinao->updateddate           = new CDbExpression('NOW()');
                        $newfinao->finao_status          = 38;
                        if ($newfinao->save(false)) {
                            $finao_id                     = $newfinao->user_finao_id;
                            $newtile                      = new UserFinaoTile;
                            $newtile->tile_id             = $tileid;
                            $newtile->tile_name           = $tilename;
                            $newtile->finao_id            = $newfinao->user_finao_id;
                            $tileimgurl                   = '' . $tileimage . '.jpg';
                            $newtile->tile_profileImagurl = $tileimgurl;
                            $newtile->userid              = $userid;
                            $newtile->status              = 1;
                            $newtile->createddate         = new CDbExpression('NOW()');
                            $newtile->createdby           = $userid;
                            $newtile->updateddate         = new CDbExpression('NOW()');
                            $newtile->updatedby           = $userid;
                            if ($newtile->save(false)) {
                                $tilename   = $tilename;
                                $istileinfo = TilesInfo::model()->findByAttributes(array(
                                    'tilename' => $tilename,
                                    'createdby' => $userid
                                ));
                                if (!isset($istileinfo) && empty($istileinfo)) {
                                    $tileinfo                = new TilesInfo;
                                    $tileinfo->tile_id       = $tileid;
                                    $tileinfo->tilename      = $tilename;
                                    $tileinfo->tile_imageurl = $tileimgurl;
                                    $tileinfo->status        = 1;
                                    $tileinfo->createdby     = $userid;
                                    $tileinfo->createddate   = new CDbExpression('NOW()');
                                    $tileinfo->updateddate   = new CDbExpression('NOW()');
                                    $tileinfo->updatedby     = $userid;
                                    $tileinfo->save(false);
                                }
                            }
                            $login                       = array();
                            $login["id"]                 = $userid;
                            $login["username"]           = $model->fname;
                            $login["socialnetworkid"]    = $model->socialnetworkid;
                            $login["trackid"]            = $user['trackid'];
                            $userprofile                 = UserProfile::model()->findByAttributes(array(
                                'user_id' => $userid
                            ));
                            $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
                            $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
                            Yii::app()->session['login'] = $login;
                            echo '2-' . $tileid;
                        } else {
                            echo "Something went wrong";
                        }
                    }
                }
            }
		   }
        }
    }
    public function actionActivationEmailSender()
    {
        if (isset($_REQUEST["email"])) {
            $status = $this->precheckaweber($_REQUEST["email"]);
            if ($status == 2) //checked in user table
                {
                $this->redirect(Yii::app()->createUrl('site/index', array(
                    'userstatus' => $status
                )));
            } else if ($status == 1) //checked in aweberlog table
                {
                $this->redirect(Yii::app()->createUrl('site/index', array(
                    'userstatus' => $status
                )));
            } else //new user
                {
                $email     = $_REQUEST["email"];
                $getuid    = AweberLog::model()->findByAttributes(array(
                    'email' => $email
                ));
                $uid       = $getuid->uid;
                $activeurl = $this->createAbsoluteUrl('/site/index', array(
                    "joinnow" => '1',
                    "email" => $email,
                    "uid" => $uid
                ));
                $subj      = "Registration with FINAO";
                $mesg      = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Registration Confirmation</title>

</head>



<body>

	<div style="width:670px; margin:0px auto; padding:0px; background:#FFF; border-left:solid 20px #dddddd; border-right:solid 20px #dddddd;">

	<div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Email_Header.png" style="padding:0; margin:0; border:0;" /></div>

    <div style="width:650px; padding:10px; margin:0px; font-family:Geneva, Arial, Helvetica, sans-serif;"><br />

    	<div style="color:rgb(244, 123, 32); font-weight:bold; font-size:16px; padding-bottom:5px;">We\'re excited to welcome you to the FINAO Nation.</div>

         <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;">Please click the button to confirm your registration.</div> 

        

		<a style="text-decoration:none;" href="' . $activeurl . '"><div style="width:159px; height:19px; padding:8px 0; color:#FFF; background-color: #d84724; cursor:pointer; text-align:center; font-size:14px; -moz-box-shadow:2px 4px 6px 0px #4d4d4d; -webkit-box-shadow:2px 4px 6px 0px #4d4d4d; box-shadow:2px 4px 6px 0px #4d4d4d;">Confirm Registration

            

        </div></a>

		

         

	    <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-top:15px; padding-bottom:15px;">If you did not register at <a href="http://finaonation.com" target="_blank" style="color:rgb(77,77,77)!important; text-decoration:none; cursor:default;">www.finaonation.com</a>, you can ignore this e-mail.</div>

         

        <div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Signature.png" style="border:0; padding:0; margin:0;" /></div>

        

    </div>

	<div style="width:650px; margin:0px auto; text-align:right; padding-bottom:5px;">

            <a href="https://www.facebook.com/FINAONation" target="_blank" title="facebook"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-facebook.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

			<a href="http://www.linkedin.com/company/2253999" target="_blank" title="linkedin"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-linkedin.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

             <a href="http://pinterest.com/finaonation/" target="_blank" title="pinterest"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-pinterest.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

            <a href="https://twitter.com/FINAONation" target="_blank" title="twitter"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-twitter.png" style="border:0; padding:0;" /></a>

    </div>

    <div style="background:#000; width:670px; font-size:11px; color:rgb(153, 153, 153); text-align:center; padding:10px 0; font-family:Geneva, Arial, Helvetica, sans-serif;">

        <div style="padding-bottom:5px;">This message was mailed to <a href="#" style="color:rgb(244, 123, 32)!important; text-decoration:none; cursor:default;">' . $_REQUEST["email"] . '</a> by FINAO Nation.</div>

        <div style="padding-bottom:5px;">

            <a href="http://' . $_SERVER['HTTP_HOST'] . '" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">FINAO</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/contactus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Contact Us</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/aboutus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">About FINAO</a> | 

            <a href="mailto:unsubscribe@finaonation.com?Subject=Hello%20again" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Unsubscribe</a>

            

            

        </div>

        <div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">To unsubscribe, click the link above, or send an email to: <a href="#" style="color:rgb(153, 153, 153)!important; text-decoration:none; cursor:default;">unsubscribe@finaonation.com</a>. Do not reply to this email address.</div> 

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">It is a notification only address and is not monitored for incoming email. </div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">Use of the FINAO Nation website and mobile app constitutes acceptance of our Terms of Use and Privacy Policy.</div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">&copy; ' . date("Y") . ' FINAO Nation, 13024 Beverly Park Rd, Mukilteo, WA 98275, U.S.A.</div>

        </div>

    </div>

</div>



</body>

</html>

';
                // Always set content-type when sending HTML email
                $headers   = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                $headers .= "From: Finao Nation <signup@finaonation.com>";
                if (mail($email, $subj, $mesg, $headers)) {
                    $this->redirect(Yii::app()->createUrl('site/index', array(
                        'joinnow' => '1'
                    )));
                }
            }
        }
    }
    /**Adde for to check the aweber status
    
    */
    public function precheckaweber($email)
    {
        $userexist = User::model()->findByAttributes(array(
            'email' => $email
        ));
        if (count($userexist) > 0) {
            return 2; // registered
        } else {
            $check = AweberLog::model()->findByAttributes(array(
                'email' => $email,
                'status' => 1,
                'flag' => 0
            ));
            $count = count($check);
            if ($count > 0) {
                return 1; // user joined exists
            } else {
                $model = new AweberLog;
                if ($_POST['email']) {
                    $uidd          = $this->randomstring();
                    $model->email  = $_POST['email'];
                    $model->status = 1;
                    $model->uid    = $uidd;
                    if ($model->save(false)) {
                        return 0; //user in process
                    }
                }
            }
        }
    }
    /* Modified on 10-1-13 used in new reg page to check if the email exists in two columns  */
    public function actionValidEmail()
    {
        $email      = $_POST['email'];
        $emailexist = User::model()->findAll(array(
            'condition' => '(email=:email) AND status=:status',
            'params' => array(
                ':email' => $email,
                ':status' => 1
            )
        ));
        if ($emailexist) {
            echo "Already Activated";
        } else {
            $emailexist = User::model()->findAll(array(
                'condition' => 'email=:email OR secondary_email=:email',
                'params' => array(
                    ':email' => $email
                )
            ));
            if ($emailexist)
                echo "Not Activated";
            else
                echo "Email not exists";
        }
    }
    public function actionCheckEmail()
    {
        $email      = $_POST['email'];
        $emailexist = User::model()->findByAttributes(array(
            'email' => $email,
            'status' => 1
        ));
        if ($emailexist) {
            echo "1-" . $emailexist->fname;
        } else {
            $emailexist = User::model()->findAll(array(
                'condition' => 'email=:email OR secondary_email=:email',
                'params' => array(
                    ':email' => $email
                )
            ));
            if ($emailexist)
                echo "Not Activated";
            else
                echo "2";
        }
    }
    public function actionFbReg()
    {
        $this->allowjs = "allowminjs";
        if ($_REQUEST['url'] == 'fbreg') {
            $model   = new User;
            $gender  = Lookups::model()->findAllByAttributes(array(
                'lookup_type' => 'UIValues-Gender'
            ));
            $gender2 = CHtml::listData($gender, 'lookup_id', 'lookup_name');
            // renders the view file 'protected/views/site/index.php'
            // using the default layout 'protected/views/layouts/main.php'
            $this->render('fbregpage', array(
                'model' => $model,
                'gender' => $gender2,
                'fbreg' => 1
            ));
        } elseif ($_REQUEST['url'] == 'frnds') {
            $model   = new User;
            $gender  = Lookups::model()->findAllByAttributes(array(
                'lookup_type' => 'UIValues-Gender'
            ));
            $gender2 = CHtml::listData($gender, 'lookup_id', 'lookup_name');
            // renders the view file 'protected/views/site/index.php'
            // using the default layout 'protected/views/layouts/main.php'
            $this->render('fbregpage', array(
                'model' => $model,
                'gender' => $gender2,
                'fbreg' => 1,
                'frnds' => 'frnds'
            ));
        }
    }
    /* Modified on 10-1-13 to show invite frnds page by checking whether the user reg with fb or not*/
    public function actionInvitefbfriends()
    {
        $this->layout  = '/layouts/column1';
        $this->header  = 'network';
        $this->allowjs = "allowminjs";
        if (isset(Yii::app()->session['login'])) {
            $id = Yii::app()->session['login']['id'];
            Yii::import('application.modules.hybridauth.models.*');
            $checkfbid = HaLogin::model()->findByAttributes(array(
                'userId' => $id,
                'loginProvider' => 'facebook'
            ));
            /*print_r($checkfbid->loginProviderIdentifier);
            
            
            
            exit;*/
            if ($checkfbid) {
                $fbid = $checkfbid->loginProviderIdentifier;
                $this->render('invitefbfriends', array(
                    'userid' => $id,
                    'fbid' => $fbid
                ));
            } else {
                $fbid = 1;
                $this->render('invitefbfriends', array(
                    'userid' => $id,
                    'fbid' => $fbid
                ));
            }
        } else {
            $this->redirect(array(
                '/'
            ));
        }
    }
    //Changed on 28022013
    public function actionGetReginfo()
    {
        Yii::import('ext.runactions.components.ERunActions');
        $firstname = $_POST['fname'];
        $lastname  = $_POST['lname'];
        $username  = (isset($_POST['uname'])) ? $_POST['uname'] : "";
        $email     = $_POST['email'];
        $pwd       = $_POST['pwd'];
        $gender    = (isset($_POST['gender'])) ? $_POST['gender'] : "";
        $socialid  = $_POST['socialid'];
        $dob       = Yii::app()->dateFormatter->format('yyyy-M-dd', strtotime($_POST['dob']));
        $zip       = $_POST['zip'];
        $user      = User::model()->findByAttributes(array(
            'email' => $email
        ));
        $model     = new User;
        if ($email == '' || $pwd == '') {
            echo "Enter fields";
        } elseif ($user['email'] != '') {
            echo "You are already subscribed or your account may not be activated";
        } else {
            if (isset(Yii::app()->session['userinfo'])) {
                if (isset(Yii::app()->session['login'])) {
                    $id                     = Yii::app()->session['login']['id'];
                    $model                  = User::model()->findByPk($id);
                    $model->secondary_email = $email;
                    $model->updatedby       = $id;
                    $model->updatedate      = date('Y-m-d G:i:s');
                } else {
                    $model             = new User;
                    $model->fname      = $firstname;
                    $model->lname      = $lastname;
                    $model->uname      = $username;
                    $model->email      = $email;
                    $model->password   = md5($pwd);
                    $model->gender     = $gender;
                    $model->dob        = $dob;
                    $model->zipcode    = $zip;
                    $model->usertypeid = 1;
                }
                $socialid               = Yii::app()->session['userinfo']['SocialNetworkID'];
                $model->socialnetworkid = $socialid;
                $social                 = Yii::app()->session['userinfo']['SocialNetwork'];
                $model->socialnetwork   = $social;
                /* Modified on 10-1-13 to get image from facebook reg becoz we r nt getng image for other  social networks*/
                if ($model->socialnetwork == "facebook") {
                    /************* Awber code *******************/
                    $url  = "http://www.aweber.com/scripts/addlead.pl";
                    $data = http_build_query(array(
                        "meta_web_form_id" => "1185568484",
                        "meta_split_id" => "",
                        "listname" => "finao_fbreges",
                        "redirect" => "",
                        "meta_adtracking" => "FBREG",
                        "meta_message" => "1",
                        "meta_required" => "email",
                        "meta_tooltip" => "",
                        //The User data fetched from form
                        "email" => $email
                    ));
                    $this->post_send($url, $data);
                    /************* END of Awber code *******************/
                    $image        = Yii::app()->session['userinfo']['photourl'];
                    $rnd          = rand(0, 9999);
                    $img_file     = file_get_contents($image);
                    $file_loc     = Yii::app()->basePath . '/../images/uploads/profileimages/' . $rnd . '.jpg';
                    $file_handler = fopen($file_loc, 'w');
                    if (fwrite($file_handler, $img_file) == false) {
                        echo 'error';
                    }
                    fclose($file_handler);
                    $img   = "images/uploads/profileimages/" . $rnd . '.jpg';
                    $image = Yii::app()->image->load($img);
                    $image->resize(140, 140);
                    $image->save("images/uploads/backgroundimages/" . $model->profile_bg_image);
                    $model->profile_image = $rnd . '.jpg';
                } else {
                    $model->profile_image = 'default-yahoo.jpg';
                }
                $model->status = 1;
                if ($gender != '') {
                    $model->gender = $gender;
                }
                if (isset(Yii::app()->session['login'])) {
                    if ($model->save(false)) {
                        if ($saved) {
                            if (isset(Yii::app()->session['login']))
                                unset(Yii::app()->session['login']);
                            $login["id"]              = $model->userid;
                            $login["username"]        = $model->uname;
                            $login["socialnetworkid"] = $model->socialnetworkid;
                            $login["superuser"]       = $model->superuser;
                            if ($model->usertypeid == 1)
                                $login["userType"] = "parent";
                            if ($model->usertypeid == 3)
                                $login["userType"] = "organization";
                            Yii::app()->session['login'] = $login;
                            echo "frnds redirect";
                        }
                    }
                } else {
                    if ($model->save(false)) {
                        /* Added on 10-1-13 to save fb details in login details. This is used for normal register want to invite his friends*/
                        $command = Yii::app()->db->createCommand();
                        $saved   = $command->insert('ha_logins', array(
                            'userId' => $model->userid,
                            'loginProvider' => $model->socialnetwork,
                            'loginProviderIdentifier' => $model->socialnetworkid
                        ));
                        if ($saved) {
                            $userdet               = array();
                            $userdet['firstname']  = $model->fname;
                            $userdet['lastname']   = $model->lname;
                            $userdet['email']      = $model->email;
                            $userdet['password']   = "W3lc0m3!";
                            $userdet['store_id']   = 1;
                            $userdet['website_id'] = 1;
                            $url1                  = Yii::app()->createAbsoluteUrl('site/Processshopreg', array(
                                'userdet' => $userdet
                            ));
                            ERunActions::touchUrl($url1);
                            //$login = array();
                            if (isset(Yii::app()->session['login']))
                                unset(Yii::app()->session['login']);
                            $login["id"]              = $model->userid;
                            $login["username"]        = $uname;
                            $login["socialnetworkid"] = $model->socialnetworkid;
                            $login["superuser"]       = $model->superuser;
                            if ($model->usertypeid == 1)
                                $login["userType"] = "parent";
                            if ($model->usertypeid == 3)
                                $login["userType"] = "organization";
                            Yii::app()->session['login'] = $login;
                            //$this->redirect('site/index');
                            echo "fb registration success";
                        }
                    }
                }
            } else {
                if (isset(Yii::app()->session['login'])) {
                    echo "Loged user";
                    exit;
                }
                $model->fname      = $firstname;
                $model->lname      = $lastname;
                $model->uname      = $username;
                $model->email      = $email;
                $model->password   = md5($pwd);
                $model->dob        = $dob;
                $model->zipcode    = $zip;
                $model->usertypeid = 63;
                if ($socialid != 0) {
                    $model->status = 1;
                } else {
                    $model->status = 0;
                }
                $model->superuser       = 0;
                $model->socialnetworkid = $socialid;
                /*$model->socialnetwork = "facebook";*/
                if ($gender != '') {
                    $model->gender = $gender;
                }
                $model->activkey   = ""; //md5(uniqid(rand(), true));
                $model->status     = 1;
                $model->createtime = date('Y-m-d G:i:s');
                $model->createdby  = 1;
                $mageid            = $this->processshopreg($firstname, $lastname, $email, $pwd);
                if ($mageid != '') {
                    $model->mageid = $mageid;
                }
                if ($model->save(false)) {
                    /*					$mageid = $this->processshopreg($firstname,$lastname,$email,$pwd);
                    
                    
                    
                    if(!$mageid == 'exists')
                    
                    {
                    
                    $model->mageid = $mageid;
                    
                    //echo $mageid; exit;
                    
                    $model->save();
                    
                    }
                    
                    */
                    if ($model->socialnetworkid != 0) {
                        $image        = "http://graph.facebook.com/" . $model->socialnetworkid . "/picture?type=normal";
                        $img_file     = file_get_contents($image);
                        $file_loc     = Yii::app()->basePath . '/../images/uploads/profileimages/' . $model->userid . '.jpg';
                        $file_handler = fopen($file_loc, 'w');
                        if (fwrite($file_handler, $img_file) == false) {
                            echo 'error';
                        }
                        fclose($file_handler);
                        $img   = "images/uploads/profileimages/" . $model->userid . '.jpg';
                        $image = Yii::app()->image->load($img);
                        $image->resize(140, 140);
                        $image->save("images/uploads/profileimages/" . $model->userid . '.jpg');
                        $newuserprofile                = new UserProfile;
                        $newuserprofile->user_id       = $model->userid;
                        $newuserprofile->profile_image = $model->userid . '.jpg';
                        $newuserprofile->createdby     = $model->userid;
                        $newuserprofile->createddate   = date('Y-m-d G:i:s');
                        $newuserprofile->updatedby     = $model->userid;
                        $newuserprofile->updateddate   = date('Y-m-d G:i:s');
                        $newuserprofile->IsCompleted   = "";
                        $newuserprofile->save(false);
                        $login = array();
                        if (isset(Yii::app()->session['login']))
                            unset(Yii::app()->session['login']);
                        if (isset(Yii::app()->session['userinfo']))
                            unset(Yii::app()->session['userinfo']);
                        $login["id"]                 = $model->userid;
                        $login["username"]           = $model->fname . '  ' . $model->lname;
                        $login["email"]              = $model->email;
                        $login["socialnetworkid"]    = $model->socialnetworkid;
                        $login["superuser"]          = $model->superuser;
                        $userprofile                 = UserProfile::model()->findByAttributes(array(
                            'user_id' => $model->userid
                        ));
                        $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
                        $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
                        Yii::app()->session['login'] = $login;
                        echo "fb registration success";
                    } else {
                        if (isset(Yii::app()->session['login']))
                            unset(Yii::app()->session['login']);
                        $login                    = array();
                        $login["id"]              = $model->userid;
                        $login["username"]        = $model->uname;
                        $login["socialnetworkid"] = $model->socialnetworkid;
                        $login["superuser"]       = $model->superuser;
                        if ($model->usertypeid == 1)
                            $login["userType"] = "parent";
                        if ($model->usertypeid == 3)
                            $login["userType"] = "organization";
                        Yii::app()->session['login'] = $login;
                        echo "reg success";
                    }
                } else {
                    echo "Enter the fields correctly";
                }
            }
        }
    }
    //Ended on 28022013
    //Register into Finao Shop - RathanKalluri
    public function Processshopreg($firstname, $lastname, $email, $pwd)
    {
        $data = Yii::app()->db2->createCommand()->select('*')->from('customer_entity')->where('email=:email1', array(
            ':email1' => $email
        ))->queryRow();
        if (is_numeric($data['entity_id'])) {
            $newpass = md5($pwd);
            $this->Processshopupdatepwd($data['entity_id'], $newpass);
            return $data['entity_id'];
        } else {
            $connection    = Yii::app()->db;
            $newCustomer   = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password_hash' => md5($pwd),
                'store_id' => 1,
                'website_id' => 1
            );
            $client        = new SoapClient('http://' . $_SERVER['SERVER_NAME'] . '/shop/api/soap/?wsdl');
            $sessionId     = $client->login('apiintegrator', 'ap11ntegrator');
            $newCustomerId = $client->call($sessionId, 'customer.create', array(
                $newCustomer
            ));
            return $newCustomerId;
        }
    }
    public function Processshopupdatepwd($mageid, $newpswd)
    {
        $client    = new SoapClient('http://' . $_SERVER['SERVER_NAME'] . '/shop/api/soap/?wsdl');
        $sessionId = $client->login('apiintegrator', 'ap11ntegrator');
        $result    = $client->call($sessionId, 'customer.update', array(
            'customerId' => $mageid,
            'customerData' => array(
                'password_hash' => $newpswd
            )
        ));
        /* if($result)
        
        echo $mageid.' '.$rawpass.'success';*/
        $client->endSession($sessionId);
    }
    public function actionForgotpwd()
    {
        $email     = $_POST['forgotemail'];
        $usercheck = User::model()->findByAttributes(array(
            'email' => $email,
            'status' => 1
        ));
        $password  = md5($usercheck->password);
        if ($usercheck) {
            $activkey  = md5(uniqid(rand(), true));
            $forgoturl = $this->createAbsoluteUrl('/site/changepswdpopup', array(
                "activkey" => $activkey,
                "email" => $usercheck->email
            ));
            $subj      = "Forgot Password";
            $mesg      = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Registration Confirmation</title>

</head>



<body>



	<div style="width:670px; margin:0px auto; padding:0px; background:#FFF; border-left:solid 20px #dddddd; border-right:solid 20px #dddddd;">

	<div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Email_Header.png" style="padding:0; margin:0; border:0;" /></div>

    <div style="width:650px; padding:10px; margin:0px; font-family:Geneva, Arial, Helvetica, sans-serif;"><br />

    	<div style="color:rgb(244, 123, 32); font-weight:bold; font-size:16px; padding-bottom:5px;">Hi ' . $usercheck->fname . ' ,</div>

        

        

     <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;">

	 

	  We just got a request to change the password for your FINAO Nation account.  



This may have been someone who just wishes they had your game, but if not, go ahead and change your password at the following link:<br />

 <br />' . $forgoturl . '<br /> <br /> If the link doesn\'t work, please copy and paste the URL into your browser instead.<br /> <br />

</div>

        <div style="color:rgb(77,77,77); font-size:12px; line-height:18px; padding-bottom:15px;">If you did not request to change your password, just ignore this message and your password will stay the same.</div>

        

        <div><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/Signature.png" style="border:0; padding:0; margin:0;" /></div>

        

    </div>

	<div style="width:650px; margin:0px auto; text-align:right; padding-bottom:5px;">

     <ul style="list-style:none; margin:0px; padding:0px;">

            <a href="https://www.facebook.com/FINAONation" target="_blank" title="facebook"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-facebook.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

			<a href="http://www.linkedin.com/company/2253999" target="_blank" title="linkedin"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-linkedin.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

             <a href="http://pinterest.com/finaonation/" target="_blank" title="pinterest"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-pinterest.png" style="border:0; padding:0; margin-right:4px!important;" /></a>

            <a href="https://twitter.com/FINAONation" target="_blank" title="twitter"><img src="http://' . $_SERVER['HTTP_HOST'] . '/images/mail-icons/icon-twitter.png" style="border:0; padding:0;" /></a>

       </ul>

    </div>

    <div style="background:#000; width:670px; font-size:11px; color:rgb(153, 153, 153); text-align:center; padding:10px 0; font-family:Geneva, Arial, Helvetica, sans-serif;">

        <div style="padding-bottom:5px;">This message was mailed to <span style="color:rgb(244, 123, 32)!important;">' . $_REQUEST["email"] . '</span> by FINAO Nation.</div>

        <div style="padding-bottom:5px;">

            <a href="http://' . $_SERVER['HTTP_HOST'] . '" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">FINAO</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/contactus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Contact Us</a> | 

            <a href="http://' . $_SERVER['HTTP_HOST'] . '/profile/aboutus" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">About FINAO</a> | 

            <a href="mailto:unsubscribe@finaonation.com?Subject=Hello%20again" style="color:rgb(244, 123, 32); padding:0 5px; text-decoration:underline;">Unsubscribe</a>

            

            

        </div>

        <div>

			<div style="padding:0px!important; margin:0px!important; line-height:18px;">To unsubscribe, click the link above, or send an email to: <a href="#" style="color:rgb(153, 153, 153)!important; text-decoration:none; cursor:default;">unsubscribe@finaonation.com</a>. Do not reply to this email address.</div> 

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">It is a notification only address and is not monitored for incoming email. </div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">Use of the FINAO Nation website and mobile app constitutes acceptance of our Terms of Use and Privacy Policy.</div>

            <div style="padding:0px!important; margin:0px!important; line-height:18px;">&copy; ' . date("Y") . ' FINAO Nation, 13024 Beverly Park Rd, Mukilteo, WA 98275, U.S.A.</div>

        </div>

    </div>

</div>



</body>

</html>';
            $headers   = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers .= "From: do-not-reply@finaonation.com";
            mail($usercheck->email, $subj, $mesg, $headers);
            $usercheck->activkey = $activkey;
            if ($usercheck->save(FALSE));
            echo "Succesful email"; //
        } else {
            $userntact = User::model()->findByAttributes(array(
                'email' => $email
            ));
            if ($userntact) {
                echo "You Are not activated.";
            } else {
                echo "Not valid email";
            }
        }
    }
    public function actionChangepswdpopup($activkey, $email)
    {
        $model = User::model()->findByAttributes(array(
            'email' => $email,
            'activkey' => $activkey
        ));
        if ($model) {
            $this->popup = 'showforgotchangepswd';
            $newpwd      = array();
            if (isset(Yii::app()->session['newpwd']))
                unset(Yii::app()->session['newpwd']);
            $newpwd["id"]                 = $model->userid;
            $newpwd["email"]              = $model->email;
            Yii::app()->session['newpwd'] = $newpwd;
            $this->redirect(Yii::app()->createUrl('site/index', array(
                'url' => 'changepswd'
            )));
        } else {
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
    }
    public function actionNewPswd()
    {
        $newpswd = md5($_POST['newpswd']);
        if (isset(Yii::app()->session['newpwd'])) {
            $email             = Yii::app()->session['newpwd']['email'];
            $editpwd           = User::model()->findByAttributes(array(
                'email' => $email
            ));
            $editpwd->password = $newpswd;
            $editpwd->activkey = '';
            $mageid            = $editpwd->mageid;
            if ($editpwd->save(false)) {
                $this->processshopupdatepwd($mageid, $newpswd);
                // If you don't need the session anymore
                //$client->endSession($session);
                echo "Saved Successfully";
            } else {
                echo "not saved";
            }
        }
    }
    public function actionChangePassword()
    {
        if (isset(Yii::app()->session['login'])) {
            $id        = Yii::app()->session['login']['id'];
            $changepwd = User::model()->findByPk($id);
            if ($changepwd) {
                $newpwd              = md5($_POST['npswd']);
                $changepwd->password = $newpwd;
                if ($changepwd->save(false)) {
                    echo "changed succesfully";
                } else {
                    echo "not saved";
                }
            }
        } else {
            $this->render('index');
        }
    }
    public function actionValidPassword()
    {
        if (isset(Yii::app()->session['login'])) {
            $id        = Yii::app()->session['login']['id'];
            $changepwd = User::model()->findByPk($id);
            if ($changepwd) {
                $cpwd = md5($_POST['cpwd']);
                if ($changepwd->password == $cpwd) {
                    echo "Password is correct";
                } else {
                    echo "Password not correct";
                }
            }
        } else {
            $this->render('index');
        }
    }
    public function actionActivation($activkey, $email, $userTypeAct)
    {
        $model   = User::model()->findByAttributes(array(
            'email' => $email,
            'activkey' => $activkey
        ));
        $userdat = User::model()->findByAttributes(array(
            'email' => $email
        ));
        if ($model) {
            $model->status   = 1;
            $model->activkey = '';
            if ($model->save(false)) {
                $this->redirect(Yii::app()->createUrl('site/index', array(
                    'url' => 'activation'
                )));
            }
        } else {
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
    }
    public function actionPopulatedata()
    {
        if (isset($_REQUEST['queryString'])) {
            $queryString   = $_REQUEST['queryString'];
            $targetControl = isset($_REQUEST['targetControl']) ? (($_REQUEST['targetControl'] != "") ? $_REQUEST['targetControl'] : "") : "";
            /*$statevalue = isset($_REQUEST['state']) ? (($_REQUEST['state'] != "") ? $_REQUEST['state'] : "%" ) : "%";
            
            
            
            $cityvalue = isset($_REQUEST['city']) ? (($_REQUEST['city'] != "") ? $_REQUEST['city'] : "%" ) : "%";
            
            
            
            $schoolvalue = isset($_REQUEST['school']) ? (($_REQUEST['school'] != "") ? $_REQUEST['school'] : "%" ) : "%";*/
            //added for autopopulate for create blog
            /*$tagvalue = isset($_REQUEST['tags']) ? (($_REQUEST['tags'] != "") ? $_REQUEST['tags'] : "%" ) : "%";*/
            $targetid      = isset($_REQUEST['targetid']) ? (($_REQUEST['targetid'] != "") ? $_REQUEST['targetid'] : "%") : "%";
            ;
            /* Added on 29-01-2013 to search people in parentvalet */
            $emailvalue = isset($_REQUEST['useremail']) ? (($_REQUEST['useremail'] != "") ? $_REQUEST['useremail'] : "%") : "%";
            $tilevalue  = isset($_REQUEST['usertile']) ? (($_REQUEST['usertile'] != "") ? $_REQUEST['usertile'] : "%") : "%";
            // ended on 29-01-2013
            if (strlen($queryString) > 0 && $targetControl != "") {
                $model = $this->getData($targetControl, $queryString, $emailvalue, $tilevalue);
                if (count($model) > 0) {
                    //print_r($model);
                    echo $this->getliData($targetControl, $model, $targetid);
                } else {
                    echo '';
                }
            }
        }
    }
    //Changed on 07012013-For activity finder organization list
    public function getData($targetControl, $queryString, $emailvalue, $tilevalue)
    {
        switch ($targetControl) {
            /* Added on 29-01-2013 to search people in parentvalet */
            case 'useremail':
                return User::model()->findAll(array(
                    'select' => 'fname,userid,lname,socialnetworkid',
                    'condition' => "fname like '" . $emailvalue . "%' or lname like '" . $emailvalue . "%' and userid not like " . Yii::app()->session['login']['id'] . " and status = 1 ",
                    'limit' => 20,
                    'group' => 'fname,userid,lname,socialnetworkid'
                ));
            //return User::model()->findAll(array('select'=>'fname','condition'=>"fname like '".$emailvalue."%'", 'limit'=>20));		//return $criteria->condition;
            case 'usertile':
                $Criteria            = new CDbCriteria();
                $Criteria->select    = "t.tile_id, t2.tilename, case when t2.is_customtile = 0  then CONCAT( LCASE( t2.tilename ) ,  '.jpg' )  else t2.tile_imageurl end as tile_imageurl, COUNT(DISTINCT t.userid ) as Usercnt";
                $Criteria->join      = " join fn_user_finao t1 ON t.finao_id = t1.user_finao_id

											AND t1.finao_status_Ispublic =1 AND t.status =1 AND t1.finao_activestatus = 1

										join fn_tilesinfo t2 ON t.tile_id = t2.tile_id AND t.userid = t2.createdby";
                $Criteria->group     = " t2.tilename ";
                $Criteria->condition = " t2.tilename like '" . $tilevalue . "%'";
                //$Criteria->limit = 20;
                return UserFinaoTile::model()->findAll($Criteria);
            /* Ended on 29-01-2013 */
            case 'User':
                $Criteria         = new CDbCriteria();
                $Criteria->select = "pa.name";
                $Criteria->join   = "LEFT JOIN fn_lookups AS pl ON t.usertypeid = pl.fn_lookup_id";
                $Criteria->join .= " LEFT JOIN fn_address AS pa ON t.userid = pa.userid";
                $Criteria->condition = "pl.lookup_type = 'UserData' AND pl.lookup_name = 'Organization' AND pa.name IS NOT NULL AND pa.name LIKE '" . $queryString . "%'";
                //print_r($Criteria);
                $orgdet              = User::model()->findAll($Criteria);
                //print_r($orgdet);
                return $orgdet;
        }
    }
    //Ended on 07012013
    //Changed on 07012013-For activity finder organization list
    public function getliData($targetControl, $model, $targetid)
    {
        $listData = "";
        switch ($targetControl) {
            case 'useremail':
                $knownusers = array();
                //$listData .= '<div class="auto-suggest" style="height:250px; overflow-y:scroll;"><ul>';
                $listData .= '<ul>';
                foreach ($model as $email) {
                    //print_r(Yii::app()->session['knownusers']);
                    $getimage = UserProfile::model()->findByAttributes(array(
                        'user_id' => $email->userid
                    ));
                    if (isset($getimage->profile_image) && $getimage->profile_image != "") {
                        $profileimage = Yii::app()->baseUrl . '/images/uploads/profileimages/' . $getimage->profile_image;
                    } else {
                        $profileimage = Yii::app()->baseUrl . '/images/no-image.jpg';
                    }
                    $listData .= '<a href="' . Yii::app()->createUrl('finao/motivationmesg/frndid/' . $email->userid) . '"><li onClick="fill(\'' . $email->fname . '\',\'' . $targetid . '\',\'suggestions-email\');"><span style="float:left;"><img src="' . $profileimage . '" alt="profile_image" width="40" /></span><span class="left auto-suggest-right">' . $email->fname . '  ' . $email->lname . '</span></li></a>';
                }
                //	$listData .= '</ul></div>';
                $listData .= '</ul>';
                return $listData;
            case 'usertile':
                //$listData .= '<div class="auto-suggest" style="height:250px; overflow-y:scroll;"><ul>';
                $listData .= '<ul>';
                foreach ($model as $name) {
                    $tileimageurl = str_replace("'", "", str_replace(" ", "", $name->tile_imageurl));
                    if (preg_match('/.jpg/', $tileimageurl) || preg_match('/.jpeg/', $tileimageurl) || preg_match('/.png/', $tileimageurl))
                        $src = $tileimageurl; //str_replace(" ","",$name->image);
                    else
                        $src = $tileimageurl . '.jpg';
                    $listData .= ' <a href="' . Yii::app()->createUrl('finao/Getprofiledetails', array(
                        'tile_name' => $name->tilename
                    )) . '"><li onClick="fill(\'' . $name->tilename . '\',\'' . $targetid . '\',\'suggestions-tile\');"> <span style="float:left;"><img src="' . Yii::app()->baseurl . "/images/tiles/" . $src . '" alt="' . $name->tilename . '" width="40" /></span><span class="left auto-suggest-right">' . $name->tilename . ' - (' . $name->Usercnt . ' ) </span>

					</li></a>   ';
                }
                $listData .= '</ul>';
                return $listData;
            /* Ended on 29-01-2013 */
            case 'User':
                foreach ($model as $data) {
                    $listData .= ' <li onClick="fill(\'' . $data->name . '\',\'txtsearchorg\',\'suggestions-organization\');" style="width:160px;">' . $data->name . '</li>';
                }
                return $listData;
        }
    }
    //Ended on 07012013
    /**
    
    
    
    * This is the action to handle external exceptions.
    
    
    
    */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            //$this->render('error', $error);
            else {
                $this->layout = '/layouts/column1';
                $this->render('error', $error);
            }
        }
    }
    /**
    
    
    
    * Displays the contact page
    
    
    
    */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name    = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" . "Reply-To: {$model->email}\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/plain; charset=UTF-8";
                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array(
            'model' => $model
        ));
    }
    /**
    
    
    
    * Displays the login page
    
    
    
    */
    public function actionLogin()
    {
        $uname      = $_POST['uname'];
        $pwd        = md5($_POST['pwd']);
        $remember   = $_POST['remember'];
        $currenturl = Yii::app()->request->urlReferrer;
        $model      = User::model()->findByAttributes(array(
            'email' => $uname,
            'password' => $pwd,
            'status' => 1
        ));
        if ($model) {
            $login = array();
            if (isset(Yii::app()->session['login']))
                unset(Yii::app()->session['login']);
            if (isset(Yii::app()->session['userinfo']))
                unset(Yii::app()->session['userinfo']);
            $login["id"]                 = $model->userid;
            $login["username"]           = $model->fname;
            $login["email"]              = $model->email;
            $login["socialnetworkid"]    = $model->socialnetworkid;
            $login["trackid"]            = $model->trackid;
            $login["superuser"]          = $model->superuser;
            /* code added by gowri for bg image */
            $userprofile                 = UserProfile::model()->findByAttributes(array(
                'user_id' => $model->userid
            ));
            $login["profImage"]          = (isset($userprofile->profile_image)) ? $userprofile->profile_image : "";
            $login["bgImage"]            = (isset($userprofile->profile_bg_image)) ? $userprofile->profile_bg_image : "";
            Yii::app()->session['login'] = $login;
            //$passwordcookie = base64_encode($_POST['pwd']);
            $passwordcookie              = base64_encode($_POST['pwd']);
            //Changed on 26022013
            $imgsrc                      = "http://" . $_SERVER['SERVER_NAME'] . "/images/uploads/profileimages/" . Yii::app()->session['login']['profImage'];
            $shopusercookie              = new CHttpCookie('shop_uname', $imgsrc);
            $shopusercookie->expire      = time() + 2 * 604800;
            //Ended on 260222013
            if ($remember == "true") {
                $usercookie                                   = new CHttpCookie('login_usernme', $uname);
                $usercookie->expire                           = time() + 2 * 604800;
                $passcookie                                   = new CHttpCookie('login_paswrd', $_POST['pwd']);
                $passcookie->expire                           = time() + 2 * 604800;
                Yii::app()->request->cookies['login_usernme'] = $usercookie;
                Yii::app()->request->cookies['login_paswrd']  = $passcookie;
            }
            //Added on 26022013
            Yii::app()->request->cookies['shop_uname'] = $shopusercookie;
            //Ended on 26022013
            /*if($remember == "false")
            
            
            
            {
            
            
            
            unset(Yii::app()->request->cookies['login_usernme']);
            
            
            
            unset(Yii::app()->request->cookies['login_paswrd']);
            
            
            
            }*/
            $IsSkipped                                 = UserProfile::model()->findByAttributes(array(
                'user_id' => $model->userid
            ));
            $IsFinao                                   = UserFinao::model()->findByAttributes(array(
                'userid' => $model->userid
            ));
            if (!empty($IsSkipped) && $IsSkipped->IsCompleted == "skipped") {
                if (!isset($IsFinao) || empty($IsFinao)) {
                    echo "AddFinao";
                } else {
                    echo "MotivationMesg";
                }
            } elseif ($IsSkipped->IsCompleted == "saved") {
                if (!isset($IsFinao) || empty($IsFinao)) {
                    echo "AddFinao";
                } else {
                    echo "MotivationMesg";
                }
            } else {
                echo "MyProfile";
            }
        } else {
            $notactivate = User::model()->findByAttributes(array(
                'email' => $uname,
                'password' => $pwd
            ));
            if ($notactivate) {
                echo "Your account is not activated";
            } else {
                echo "not-login";
            }
            //exit;
        }
    }
    /**
    
    
    
    * Logs out the current user and redirect to homepage.
    
    
    
    */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        if (isset(Yii::app()->session['login']))
            unset(Yii::app()->session['login']);
        Yii::app()->request->cookies->clear();
        //  unset($_COOKIE['SID']);
        /*if (isset($_SERVER['HTTP_COOKIE'])) {
        
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        
        foreach($cookies as $cookie) {
        
        $parts = explode('=', $cookie);
        
        $name = trim($parts[0]);
        
        setcookie($name, '', time()-1000);
        
        setcookie($name, '', time()-1000, '/');
        
        }
        
        }*/
        //$logouturl = Yii::app()->facebook->getLogoutUrl();
        /*echo $logouturl;
        
        
        
        echo "<a href={$logouturl}>Facebook logout</a>";
        
        
        
        exit();*/
        Yii::app()->facebook->setAccessToken($acstk = NULL);
        $this->redirect(Yii::app()->homeUrl);
    }
    public function actionAcceptInvite()
    {
        $uid         = $_POST['uid'];
        //print_r($uid);
        $ufbid       = $_POST['fbid'];
        $responseid  = $_POST['request_ids'];
        $responseid  = explode(',', $responseid);
        $responseids = array();
        for ($i = 0; $i < count($responseid); $i++) {
            $responseids[$i] = explode('_', $responseid[$i]);
        }
        for ($i = 0; $i < count($responseids); $i++) {
            for ($j = 0; $j < 2; $j++) {
                $reqid              = $responseids[$i][$j];
                $j                  = $j + 1;
                $fbid               = $responseids[$i][$j];
                $command            = Yii::app()->db->createCommand();
                $childinterestsaved = $command->insert('fn_invite_friend', array(
                    'source' => 'facebook',
                    'invited_request_id' => $reqid,
                    'invitee_social_network_id' => $fbid,
                    'invited_by_social_network_id' => $ufbid,
                    'invited_by_user_id' => $uid,
                    'invited_date' => date('Y-m-d G:i:s'),
                    'status' => 0
                ));
            }
        }
    }
    public function actionGetFilterDetails()
    {
        $userid           = Yii::app()->session['login']['id'];
        $regtargetSource  = $_REQUEST["targetSource"];
        $userDetailsarray = array();
        $userDet          = array();
        switch ($regtargetSource) {
            case 'interests':
                $reqInterestid = $_REQUEST["interestid"];
                $inviteeuserId = "";
                /*print_r($reqInterestid);
                
                
                
                break;*/
                if ($reqInterestid != 0) {
                    $intuser = UserChildInterests::model()->findAll(array(
                        'condition' => ' interestid = ' . $reqInterestid . ' and user_child_id = 0 and status = 1',
                        'select' => 'userid'
                    ));
                    foreach ($intuser as $foreachuser)
                        $inviteeuserId .= $foreachuser->userid . ",";
                    $inviteeuserId = substr($inviteeuserId, 0, strlen($inviteeuserId) - 1);
                }
                /*print_r($inviteeuserId);
                
                
                
                break;*/
                $userDetailsarray = $this->populateUserDetails(($inviteeuserId != "") ? $inviteeuserId : "");
                $userDet          = $userDetailsarray['userDet'];
                break;
            case 'tags':
                $reqInterestid = $_REQUEST["interestid"];
                $inviteeuserId = "";
                if ($reqInterestid != 0) {
                    $intuser = Tags::model()->findAll(array(
                        'condition' => ' tag_id = ' . $reqInterestid . ' and status = 1',
                        'select' => 'user_id'
                    ));
                    foreach ($intuser as $foreachuser)
                        $inviteeuserId .= $foreachuser->user_id . ",";
                    $inviteeuserId = substr($inviteeuserId, 0, strlen($inviteeuserId) - 1);
                }
                $userDetailsarray = $this->populateUserDetails(($inviteeuserId != "") ? $inviteeuserId : "");
                $userDet          = $userDetailsarray['userDet'];
                /*print_r($userDet);
                
                
                
                break;*/
                break;
        }
        $this->renderPartial('_networkmiddlepage', array(
            'userDet' => $userDet
        ));
    }
    public function actionUploadDetail()
    {
        $userid       = $_REQUEST["id"];
        $uploadoption = $_REQUEST["uploadoption"];
        $model        = User::model()->findbyPK($userid);
        switch ($uploadoption) {
            case 'changeName':
                $fname             = $_REQUEST["fname"];
                $lname             = $_REQUEST["lname"];
                $model->fname      = $fname;
                $model->lname      = $lname;
                $model->updatedate = new CDbExpression('NOW()');
                $model->updatedby  = $userid;
                if ($model->save(false))
                    echo "success";
                else
                    echo "error";
                break;
            case 'changeDescription':
                $description        = $_REQUEST["description"];
                $model->description = $description;
                $model->updatedate  = new CDbExpression('NOW()');
                $model->updatedby   = $userid;
                if ($model->save(false))
                    echo "success";
                else
                    echo "error";
                break;
            case 'changeInterest':
                $selectInt      = $_REQUEST["selectInt"];
                $selectInterest = array();
                $saved          = false;
                $modelUserInt   = UserChildInterests::model()->findAll(array(
                    'condition' => 'userid = ' . $userid . ' and user_child_id = 0'
                ));
                if ($modelUserInt != "") {
                    UserChildInterests::model()->deleteAll(array(
                        'condition' => 'userid = ' . $userid . ' and user_child_id = 0'
                    ));
                }
                if (is_array($selectInt)) {
                    foreach ($selectInt as $selected) {
                        $modelUserInt                  = new UserChildInterests;
                        $modelUserInt->userid          = $userid;
                        $modelUserInt->user_child_id   = 0;
                        $modelUserInt->interestid      = $selected;
                        $modelUserInt->status          = 1;
                        $modelUserInt->createdby       = $userid;
                        $modelUserInt->createddatetime = new CDbExpression('NOW()');
                        if ($modelUserInt->save(false))
                            $saved = true;
                    }
                } else {
                    $modelUserInt                  = new UserChildInterests;
                    $modelUserInt->userid          = $userid;
                    $modelUserInt->user_child_id   = 0;
                    $modelUserInt->interestid      = $selectInt;
                    $modelUserInt->status          = 1;
                    $modelUserInt->createdby       = $userid;
                    $modelUserInt->createddatetime = new CDbExpression('NOW()');
                    if ($modelUserInt->save(false))
                        $saved = true;
                }
                if ($saved)
                    echo "success";
                else
                    echo "error";
                break;
        }
    }
    public function actionUpdateTags()
    {
        $selectedtags  = $_REQUEST['selectedtags'];
        $userid        = $_REQUEST['userid'];
        $selectedtags  = explode(",", $selectedtags);
        //echo $selectedtags."-".$userid;
        //exit;
        $command       = Yii::app()->db->createCommand();
        $checkprevtags = Tags::model()->findAllByAttributes(array(
            'user_id' => $userid
        ));
        if (isset($checkprevtags)) {
            $command->delete('pv_tags', 'user_id = :user_id ', array(
                ':user_id' => $userid
            ));
        }
        foreach ($selectedtags as $eachtag) {
            $newtag               = new Tags;
            $newtag->tag_id       = $eachtag;
            $newtag->user_id      = $userid;
            $newtag->status       = 1;
            $newtag->created_date = new CDbExpression('NOW()');
            if ($newtag->save(FALSE))
                $saved = true;
        }
        if ($saved)
            echo "saved";
        else
            echo "error";
    }
    public function actionContactus()
    {
        $this->allowjs = "allowminjs";
        $model         = new Contactus('captchaRequired');
        if (isset($_POST['Contactus'])) {
            $model->attributes = $_POST['Contactus'];
            if ($model->save(false)) {
                //send a mail to Coach .repalce the static mail id using $to
                $to      = 'coach email address';
                $subject = 'Request from Contact Us';
                //Need to add from email address
                $headers = "From: " . $model->contact_email . "\r\n";
                //$headers .= "CC: info@wincito.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $message = '<html><body>';
                $message .= '<br><br>Hai Admin,<br><br>';
                $message .= 'This is ' . $model->contact_name . '<br> This is the Help I need :<br><i>' . $model->contact_help . '</i><br><br>';
                $message .= 'Thanks ,<br>' . $model->contact_name . '<br>' . $model->contact_email;
                /*$message .= ;
                
                
                
                $message .= ;
                
                
                
                $message .= ;
                
                
                
                $message .= */
                $message .= "</body></html>";
                if (mail('krishna.d@wincito.com', $subject, $message, $headers)) {
                    Yii::app()->user->setFlash('contactus', 'Thanks for contacting us!!We will get back to you soon.');
                }
                $this->refresh();
            } else {
                /* Yii::app()->user->setFlash('contactus','Please fill in all details!!.');*/
                /* $this->redirect(array('create'));*/
            }
        }
        $this->render('contactus', array(
            'model' => $model
        ));
    }
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contactus-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    // NETWORK ADDED BY MANOJ 28 FEB 2013-------------------------------------------------
    public function populateUserDetails($addCondition = false)
    {
        $userid          = Yii::app()->session['login']['id'];
        $fbid            = Yii::app()->session['login']['socialnetworkid'];
        $availableAlpha  = array();
        $inviteeConditon = "";
        $userdetails     = array();
        $select          = " distinct SUBSTRING( fname, 1, 1 ) as sbstr ";
        $sql             = "select " . $select . " from fn_users where userid != " . $userid;
        $connection      = Yii::app()->db;
        $command         = $connection->createCommand($sql);
        $availableAlpha  = $command->queryAll(); // execute a query SQL
        $select          = " * ";
        $sql             = "select " . $select . " from fn_users where userid != " . $userid;
        $connection      = Yii::app()->db;
        $command         = $connection->createCommand($sql);
        $userdetails     = $command->queryAll();
        $userDet         = array();
        $userAlpha       = array();
        $i               = 0;
        $firstCon        = true;
        $firstConUserid  = 0;
        $childInfo       = array();
        $firstConnection = array();
        foreach ($availableAlpha as $alpha) {
            $userDet[$i]["alpha"] = $alpha["sbstr"];
            $j                    = 0;
            foreach ($userdetails as $usr) {
                if (substr($usr["fname"], 0, 1) == $alpha["sbstr"]) {
                    $userAlpha[$j]["userid"]          = $usr["userid"];
                    $userAlpha[$j]["email"]           = $usr["email"];
                    $userAlpha[$j]["profile_image"]   = $usr["profile_image"];
                    $userAlpha[$j]["lname"]           = $usr["lname"];
                    $userAlpha[$j]["location"]        = $usr["location"];
                    $userAlpha[$j]["fname"]           = $usr["fname"];
                    $userAlpha[$j]["description"]     = $usr["description"];
                    $userAlpha[$j]["socialnetworkid"] = $usr["socialnetworkid"];
                    //$userAlpha["socialnetworkid"] = $usr["socialnetworkid"];
                    if ($firstCon) {
                        $firstCon        = false;
                        $firstConUserid  = $usr["userid"];
                        $firstConnection = $userAlpha[$j];
                    }
                    $j++;
                }
            }
            $userDet[$i++]["details"] = $userAlpha;
        }
        return array(
            'userDet' => $userDet,
            'firstConUserid' => $firstConUserid,
            'firstConnection' => $firstConnection,
            'userdetails' => $userdetails
        );
    }
    public function actionNetworkConnections()
    {
        //$this->header = 'network';
        $this->networkheader = 'network'; // Added on 29-01-2013 to commonheader
        if (isset(Yii::app()->session['login'])) {
            $userid = Yii::app()->session['login']['id'];
            if (isset($_REQUEST['frndid'])) {
                $frndid = $_REQUEST['frndid'];
                if ($userid != $frndid) {
                    $userid = $frndid;
                }
            }
        } else {
            $this->redirect(array(
                '/'
            ));
        }
        $userid            = Yii::app()->session['login']['id'];
        $invitedfdsocialid = "";
        $userdetails       = "";
        $displaydata       = "connections";
        //$this->allowjs = "allowminjs";
        $editprof          = new User;
        if (isset($_REQUEST["displaydata"])) {
            $displaydata = $_REQUEST["displaydata"];
            if ($displaydata == "connections")
                $this->networkheader = 'network'; // Added on 29-01-2013
            elseif ($displaydata == "proflieOrg")
                $this->networkheader = 'profileorg';
        }
        $usertiles    = UserTile::model()->findAll(array(
            'condition' => 'userid = "' . $userid . '" AND status = 1'
        ));
        $displaytiles = array();
        foreach ($usertiles as $tilename) {
            $displaytiles[$tilename->tile_name] = $tilename->tile_name;
        }
        $userDet           = array();
        //$userAlpha = array();
        $i                 = 0;
        $firstCon          = true;
        $firstConUserid    = 0;
        $childInfo         = array();
        $firstConnection   = array();
        $userDetailsarray  = array();
        $userDetailsarray  = $this->populateUserDetails();
        $userDet           = $userDetailsarray['userDet'];
        $firstConUserid    = $userDetailsarray['firstConUserid'];
        $firstConnection   = $userDetailsarray['firstConnection'];
        $userdetails       = $userDetailsarray['userdetails'];
        $firstUserTag      = Tags::model()->findAll(array(
            'condition' => 'user_id = ' . $firstConUserid . ' and status = 1'
        ));
        $firstUserTagValue = array();
        foreach ($firstUserTag as $usrtagid) {
            foreach ($alltags as $allintval) {
                if ($usrtagid->tag_id == $allintval->pv_lookup_id) {
                    $firstUserTagValue[$allintval->pv_lookup_id] = $allintval->lookup_name;
                }
            }
        }
        $firstusertiles    = UserTile::model()->findAll(array(
            'condition' => 'userid = "' . $firstConUserid . '" '
        ));
        /*$firstdisplaytiles = array();
        
        
        
        foreach($firstusertiles as $tilename)
        
        
        
        {
        
        
        
        $firstdisplaytiles[$tilename->tile_name] = $tilename->tile_name;
        
        
        
        
        
        
        
        } */
        /********* Getting all the Intererest from lookup table    *****************/
        /** need to implement to display in option group *****/
        $allinterest       = array();
        $allinterest       = Lookups::model()->findAll(array(
            'condition' => "lookup_type='interests' and lookup_parentid != 0 and lookup_status=1"
        ));
        /*$childintrst = Lookups::model()->findAllByAttributes(array('lookup_type'=>'interests','lookup_parentid'=>0,'lookup_status'=>1));
        
        
        
        
        
        
        
        $i=0;
        
        
        
        foreach($childintrst as $childPar)
        
        
        
        {
        
        
        
        $allinterest[$i]["parentname"] = $childPar->lookup_name;
        
        
        
        $allinterest[$i]["parentid"] = $childPar->fn_lookup_id;
        
        
        
        $allinterest[$i++]["childint"] = Lookups::model()->findAllByAttributes(array('lookup_type'=>'interests','lookup_parentid'=>$childPar->fn_lookup_id,'lookup_status'=>1));
        
        
        
        } */
        /********** End of FirstUser Interest **************/
        /***** Getting the total available filter Interest *********/
        $inviteeuserId     = "";
        $invteusrcondition = "";
        if ($userdetails != "" && count($userdetails) > 0) {
            foreach ($userdetails as $foreachuser)
                $inviteeuserId .= $foreachuser["userid"] . ",";
            $inviteeuserId     = substr($inviteeuserId, 0, strlen($inviteeuserId) - 1);
            $invteusrcondition = "";
            if ($userdetails != "")
                $invteusrcondition = ' userid in (' . $inviteeuserId . ') and ';
        }
        /****  End of tags ****/
        /* Profile page details */
        $myprofile   = User::model()->findAll(array(
            "condition" => "userid = " . $userid . " and status = 1"
        ));
        $addresstags = Lookups::model()->findAll(array(
            'condition' => 'lookup_type = "address" and lookup_name in ("Home","Work") and lookup_status = 1'
        ));
        if (!isset($_REQUEST["displaydata"]))
            if ($displaydata == "connections") {
                $displaydata = ($userdetails != "") ? $displaydata : "invitefriend";
            }
        $this->render('network', array(
            'userDet' => $userDet,
            'displaydata' => $displaydata,
            'totalConnections' => ($userdetails != "") ? count($userdetails) : 0,
            'childInfo' => $childInfo,
            'myprofile' => $myprofile,
            'editprof' => $editprof
            //,'myaddress'=>$myaddress
                ,
            'allinterest' => $allinterest,
            'firstConnection' => $firstConnection,
            'userid' => $userid,
            'usertiles' => $usertiles
            // ,'displaytiles'=>$displaytiles
                ,
            'displaytiles' => $firstusertiles
        ));
    }
    public function actionGetConnectionDetails()
    {
        $userid      = $_REQUEST["id"];
        $userAlpha   = array();
        //$userBeta = array();
        $userdetails = User::model()->findAll(array(
            "condition" => "userid = " . $userid
        ));
        $usertiles   = UserTile::model()->findAll(array(
            'condition' => 'userid = "' . $userid . '" AND status = 1'
        ));
        /*$displaytiles = array();
        
        
        
        foreach($usertiles as $tilename)
        
        
        
        {
        
        
        
        $displaytiles[$tilename->tile_name] = $tilename->tile_name;
        
        
        
        
        
        
        
        } */
        foreach ($userdetails as $usr) {
            $userAlpha["userid"]        = $usr->userid;
            $userAlpha["email"]         = $usr->email;
            $userAlpha["profile_image"] = $usr->profile_image;
            $userAlpha["lname"]         = $usr->lname;
            $userAlpha["location"]      = $usr->location;
            $userAlpha["fname"]         = $usr->fname;
            $userAlpha["description"]   = $usr->description;
            //$userAlpha["socialnetworkid"] = $usr->socialnetworkid;
        }
        /*foreach($userdetails as $tile)
        
        
        
        {
        
        
        
        
        
        
        
        $userBeta["tile_name"] = $usr->tile_name;
        
        
        
        
        
        
        
        }*/
        $alltags = Lookups::model()->findAll(array(
            'condition' => "lookup_type = 'tag' and lookup_status=1"
        ));
        $this->renderPartial('_networkDetail', array(
            'firstConnection' => $userAlpha,
            'displaytiles' => $usertiles
        ));
    }
    // NETWORK END-------------------------------------------------
    //Code Added By Rathan - Facebook OpenGraph
    protected function afterRender($view, &$output)
    {
        parent::afterRender($view, $output);
        //Yii::app()->facebook->addJsCallback($js);
        // use this if you are registering any $js code you want to run asyc
        Yii::app()->facebook->initJs($output);
        // this initializes the Facebook JS SDK on all pages
        Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
        return true;
    }
    public function post_send($url, $data, $optional_headers = null)
    {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => $data
            )
        );
        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }
        $ctx = stream_context_create($params);
        $fp  = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new Exception("Problem with $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problem reading data from $url, $php_errormsg");
        }
        return $response;
    }
    public function actionGetUserDetails()
    {
        $userdet  = User::model()->findAll(array(
            'condition' => 'status = 1'
        ));
        $usrarray = array();
        foreach ($userdet as $ud) {
            $usrpar = array(
                'usrid' => $ud->userid,
                'userfn' => $ud->fname,
                'userln' => $ud->lname
            );
            array_push($usrarray, $usrpar);
        }
        $postdata = json_encode($usrarray);
        print_r($postdata);
        return $postdata;
    }
    /*	SHOPPING SEEMLESS INTEGRATION FUNCTIONS  */
    public function actionShopping()
    {
        $pathi = __DIR__ . '/file.php';
        echo $pathi;
        exit;
        include(__DIR__ . '/file.php');
        $magepath = Yii::app()->basePath . '/../shopnew/app/Mage.php';
        include($magepath);
        umask(0);
        Mage::app();
        /*
        
        $sql='SELECT * FROM customer_entity where email='.Yii::app()->session['login']['email'];
        
        $command=Yii::app()->db->createCommand($sql);
        
        $column = $command->queryColumn();
        
        print_r($column); exit;
        
        */
    }
    public function randomstring($length = 15)
    {
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    public function actionPromo()
    {
        $this->redirect(Yii::app()->createUrl('/home?type=promo'));
    }
    public function actionDeleteLoggedUser()
    {
        /*Start of User Deleter*/
        if (Yii::app()->session['login']['id']) {
            $uid = Yii::app()->session['login']['id'];
            print("The user with UserID :" . $uid . " is being deleted;");
            $delsql = "'delete from fn_uploaddetails where uploadedby ='.$uid";
            $delsql .= "'delete from fn_tracking where tracked_userid ='.$uid";
            $delsql .= "'delete from fn_tracking where tracker_userid ='.$uid";
            $delsql .= "'delete from fn_tracking where tracked_tileid in(select distinct tile_id from fn_user_finao_tile where userid ='.$uid.')'";
            $delsql .= "'delete from fn_trackingnotifications where createdby ='.$uid";
            $delsql .= "'delete from fn_trackingnotifications where tracker_userid ='.$uid";
            $delsql .= "'delete from fn_trackingnotifications where tile_id in (select distinct tile_id from fn_user_finao_tile where userid ='.$uid.')'";
            $delsql .= "'delete from fn_user_finao_journal where user_id ='.$uid";
            $delsql .= "'delete from fn_user_finao_tile where userid ='.$uid";
            $delsql .= "'delete from fn_user_finao where userid ='.$uid";
            $delsql .= "'delete from fn_user_profile where user_id ='.$uid";
            $delsql .= "'delete from fn_invite_friend where invited_by_user_id ='.$uid";
            $delsql .= "'delete from fn_users where userid ='.$uid";
            $command = Yii::app()->db->createCommand($delsql);
            if ($command) {
                print_r($command);
                exit;
            } else {
                print("No Data");
                exit;
            }
        } else {
            print("Not Logged");
            exit;
        }
        /*End of User Deleter*/
    }
    public function actionAboutus()
    {
        $this->layout = '/layouts/column4';
        $this->render('aboutus');
    }
    public function actionContestRules()
    {
        $this->layout = '/layouts/column4';
        $this->render('contestrules');
    }
    public function actionPrivacy()
    {
        $this->layout = '/layouts/column4';
        $this->render('privacy');
    }
    public function actionContactuss()
    {
        $this->layout = '/layouts/column4';
        $name         = $_POST['name'];
        $email        = $_POST['email'];
        $phone        = $_POST['phone'];
        $comment      = $_POST['comment'];
        if ($name != "" && $email != "" && $phone != "" && $comment != "") {
            $to      = "askus@finaonation.com";
            $subject = "Contact";
            $message = '<html>



						<head>



						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



						<title>FINAO Nation</title>						



						</head>						



						<body>



						<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="allborder">



						<style type="text/css">



						<!--



						/*



						*based



						*/



						body,td,th {



							color: #333333;



							font-family: Tahoma, Verdana,sans-serif, Arial, Helvetica;



						}



						.allborder {



							/*border: 10px solid #EEEEEE;*/



							  border: 0px;



						}



						body {



							background-color: #FFFFFF;



							margin-left: 0px;



							margin-top: 0px;



							margin-right: 0px;



							margin-bottom: 0px;



						}



						.pressrelease{



							color:#1A61AF;



							font-size:14px;



							padding-top:5px;



							padding-bottom: 2px;



							padding-right: 5px;



							font-weight: bold;



						}



						



						.con{



							color:#3a3372;



							font-size:12px;



							padding-top: 20px;



							padding-right: 20px;



							padding-bottom: 20px;



							padding-left: 20px;



						}



						.taball {



							padding: 5px;



							border: 1px dashed #CCCCCC;



						}



						.bluetext {color: #000066 font-size: 13px}



						



						-->



						 </style>



						



						  <tr>



							<td width="100%" valign="top" bgcolor="#f3f8fc">



							



							<table width="100%" border="0" cellspacing="0" cellpadding="0">



							  



							</table>



							  <table width="100%" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td bgcolor="#FFFFFF" align="center"><!-- <img src="http://finaonation.com/images/mh.png" width="100%" height ="auto"> --></td>



								</tr>



							  </table>  



							  <table width="100%" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td height="10" bgcolor="#EEEEEE" ></td>



								</tr>



							  </table>



							  <table width="100%" height="1" border="0" cellspacing="0" cellpadding="0">



								<tr>



								  <td></td>



								</tr>



							  </table> 



							  <table width="100%" height="407" border="0" align="center" cellpadding="0" cellspacing="0">



								<tr>



								  <td height="auto" valign="top" class="con" style="padding-left:7px;"><p><strong>Hello ,</strong></p>



									<p>We received a Contact Request to Finaonation.com from this email address "' . $email . '".</p>



									</td></tr>



									<tr>



									<td>Name : ' . $name . '</td>



									</tr>



									<tr>



									<td>Email : ' . $email . '</td>



									</tr>



									<tr>



									<td>Phone : ' . $phone . '</td>



									</tr>



									



									<tr>



									<td><p>Comment : ' . $comment . '</p></td>



									</tr>								



									<tr><td>



														



									<p style="font-size:18px;">Life is full of options. Failure is not one of them.</p>



									<p align="left">Thanks,</p>



									<p align="left">FINAONation.com</p>



									<p align="justify"></p></td>



								</tr>



								<tr>



								  <td height="26" align="center"><p>



									  <a href="#"><!-- <img src="http://finaonation.com/images/mf.png" width="100%" > --></a></p>



								  </td>



								</tr>



							  </table>



							  </td>



						  </tr>



						</table>



						</body>



						</html>';
            //$message = "Name : $name \n Email : $email\n Phone : $phone\n Quantity : $group\n Comment : $comment";
            $from    = $email;
            //$headers = "From:" . $from;
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers .= "From: Finao Nation <do-notreply@finaonation.com>";
            //$message = "Name : $name \n Email : $email\n Phone : $phone\n Comment : $comment";
            //$from = $email;
            //$headers = "From:" . $from;
            mail($to, $subject, $message, $headers);
            echo "success";
        }
        $this->render('contactuss');
    }
    public function actionTerms()
    {
        $this->layout = '/layouts/column4';
        $this->render('terms');
    }
    public function actionlogout1()
    {
        Yii::app()->user->logout();
        if (isset(Yii::app()->session['login']))
            unset(Yii::app()->session['login']);
        Yii::app()->request->cookies->clear();
        $this->redirect('/careercatapult-hbcu');
    }
    /*Code is updated HBCU Registet + vote */
    public function registervote($voteduser, $sourceid)
    {
        //return $voteduser;
        $voteruserid = Yii::app()->session['login']['id'];
        $check       = VideoVote::model()->findByAttributes(array(
            'voter_userid' => $voteruserid,
            'voted_userid' => $voteduser,
            'voted_sourceid' => $sourceid
        ));
        if (!$check) {
            $newvote                 = new VideoVote;
            $newvote->voter_userid   = $voteruserid;
            $newvote->voted_userid   = $voteduser;
            $newvote->voted_sourceid = $sourceid;
            $newvote->createddate    = new CDbExpression('NOW()');
            $newvote->status         = 1;
            if ($newvote->save(false)) {
                return '-true'; //voted success
            }
        } else {
            return '-false'; //already voted
        }
    }
}