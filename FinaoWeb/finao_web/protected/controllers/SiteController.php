<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	//public function actionContact()
//	{
//		$model=new ContactForm;
//		if(isset($_POST['ContactForm']))
//		{
//			$model->attributes=$_POST['ContactForm'];
//			if($model->validate())
//			{
//				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
//				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
//				$headers="From: $name <{$model->email}>\r\n".
//					"Reply-To: {$model->email}\r\n".
//					"MIME-Version: 1.0\r\n".
//					"Content-Type: text/plain; charset=UTF-8";

//				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
//				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
//				$this->refresh();
//			}
//		}
//		$this->render('contact',array('model'=>$model));
//	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{       
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
        $return = Users::isLogin();
        if($return)
        {
            $this->redirect(array("myprofile"));
        }
        else
        {
            $this->render('login',array('model'=>$model));
        }        
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
        $return = Users::isLogin();
    
		Yii::app()->user->logout();
        setcookie("token", "", time()-3600);
        $this->redirect(array('site/login'));
        //$this->render('login');
		//$this->redirect(Yii::app()->homeUrl);
	}
    
    public function actionResetpassword()
    {    
        $this->render('resetpassword');
    }
    
    public function actionSignup()
    {
        $return = Users::isLogin();
        
        if($return)
        {
            SiteController::actionMyprofile();
        }
        else
        {   
            $this->redirect(array('site/signup'));
            //$this->render('signup');
        } 
    }
    
    public function actionSubmitsignup()
    {   
        require_once('recaptchalib.php');
        $privatekey = "6Ld2DfASAAAAAIqs1d8ePsBFjhiAYqAjsbgg-QCT";
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_GET["recaptcha_challenge_field"],
                                        $_GET["recaptcha_response_field"]);
        if (!$resp->is_valid)
        {
            echo "invalid_captcha_code";
            return;
        }

        $signup_info = $_GET['signup_info']; 
        $return = Users::submit_signup_info(1,$signup_info['email'],$signup_info['password'],$signup_info['first_name'],$signup_info['last_name']);
        echo $return;
    }
    
    public function actionSubmitlogin()
    {
        $login_form = $_GET['LoginForm'];
        $return = Users::validate_login($login_form['username'],$login_form['password']);
        if($return)
        {
            echo "true";
        }
        else
        {
            echo "false";
            //$this->redirect(('index.php?r=site/login'));
        }
    }
    
    public function actionExplore()
    {
        $this->render('explore');
    }
    public function actionNotifications()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $session_id = Users::getsessionid(); 
            Users::getnotifications($session_id);
        }
        //$this->render('notifications');
    }
    public function actionSearch()
    {
        $this->render('search');
    }
    public function actionSettings()
    {
        $this->render('settings');
    }
    
    public function actionEdit_Profile()
    {  
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $mytiles = Users::mytiles(); 
            //$unused_tiles = Users::getunusedtiles();
            $finao_list = Users::user_finao_list();
            $this->render('edit_profile',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }         
    }
    
    public function actionTagnotes()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $return = Users::Userprofiledetails();
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $tagnotes = Users::gettagnotes();
            $this->render('tagnotes',array('user_details'=>$return,'tagnotes'=>$tagnotes,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications,'mytiles'=>$mytiles));
        }
    }
    
    public function actionForgot_password()
    {
        $email = $_GET['forgot_email'];
        $return = Users::forgot_password($email);
        echo $return;
       
    }
    public function actionSearch_user()
    {
        $word = $_GET['searchword'];
        Users::search_user($word);
    }
    
    public function actionActivation()
    {
        $activationkey = trim($_GET["activationkey"]);
        $result = Users::verifyregistration($activationkey);
        $this->render('activation',array('result'=>$result));
    } 
    
    public static function actionMyprofile()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            Users::myprofiledetails();  
        }
    }
    
    public function actionHome()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            
            //$homepage_posts = Users::homepage_posts();
            $who_to_follows = Users::whotofollow(); 
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles(); 
            //$this->redirect(array("site/home"));                 
            //$this->render('home',array('user_details'=>$userdetails,'user_notifications'=>$mynotifications->res,'homepage_posts'=>$homepage_posts,'who_to_follow'=>$who_to_follow,'finao_list'=>$finao_list));
            $this->render('home',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications,'who_to_follows'=>$who_to_follows));
        }        
    }
    
    public function actionHomepostsmarkup()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $page = $_GET['page'];
            $userdetails = Users::Userprofiledetails(); 
            $homepage_posts = Users::homepage_posts(intval($page));
            $who_to_follows = Users::whotofollow(); 
            
            $this->renderPartial('homepage_posts_markup',array('homepage_posts'=>$homepage_posts, "userdetails"=>$userdetails));
        }        
    }

    public function actionUpdate_profile()
    {
        $profile_info = $_POST['profile_info'];
        $userid = $profile_info['userid'];
        $name = $profile_info['name'];
        $email = $profile_info['email'];
        $password = $profile_info['password'];
        $x = $profile_info['x'];
        $y = $profile_info['y'];
        $w = $profile_info['w'];
        $h = $profile_info['h'];
        $bannerx = $profile_info['bannerx'];
        $bannery = $profile_info['bannery'];
        $bannerw = $profile_info['bannerw'];
        $bannerh = $profile_info['bannerh'];
        $bio = $profile_info['bio'];

        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {   
            $return = Users::update_profile($userid,$name,$email,$password,$x,$y,$w,$h,$bannerx,$bannery,$bannerw,$bannerh,$bio);
            $this->redirect(array("edit_profile"));
        }
    }    
    
    public function actionSubmitfinao()
    {
        $finao_title = $_POST['finao_title'];
        $post_text = $_POST['post_text'];
        $isfinaopublic  = $_POST['isfinaopublic'];
        $tile_id = intval($_POST['tile_id']); 
        $videoid = "";
        $videostatus = "";
        $video_image = "";
        $caption = "";
        $poststate = 0;
        $return = Users::submitnewfinao($caption, $finao_title, $tile_id, $isfinaopublic, $videoid, $videostatus, $video_image);
        $finao_id = $return->finao_id;
        
        $postresult = Users::submitnewpost($finao_id, $post_text, $poststate, $_FILES);
        if ($postresult->IsSuccess)
        {
            echo $postresult->message;
        }
        else
        {
            echo $postresult->message;
        }
    }
    
  
    public function actionMyfinaos()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();// 
            $mytiles = Users::mytiles();             
            $finao_recent_posts = Users::finaorecentposts();        
            $this->render('myfinaos',array('user_details'=>$userdetails,'finao_recent_posts'=>$finao_recent_posts,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
            //$this->render('myfinaos',array('user_details'=>$userdetails,'user_notifications'=>$mynotifications->res,'finao_list'=>$finao_list));
        }    
            
    }
    
    public function actionMyposts()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list(); 
            $finao_recent_post = Users::finaorecentposts();
            $mytiles = Users::mytiles();             
            $this->render('myposts',array('user_details'=>$userdetails,'finao_recent_posts'=>$finao_recent_post,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        //$this->render('myposts');
    }
    
    public function actionFinao_posts()
    {
        $finao_id = intval($_REQUEST["finao_id"]);
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list(); 
            $finao_posts = Users::finao_posts($finao_id);
            $finao_recent_post = Users::finaorecentposts();
            $mytiles = Users::mytiles();             
            $this->render('finao_posts',array('user_details'=>$userdetails,'finao_recent_posts'=>$finao_recent_post,'finao_posts'=>$finao_posts,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        //$this->render('myposts');
    }
    
    public function actionMytiles()
    {
        $ispublic = 1;
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {   
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list(); 
            $mytiles = Users::mytiles();            
            $finao_recent_posts = Users::finaorecentposts();        
//            $this->render('mytiles',array('user_details'=>$userdetails,'user_notifications'=>$mynotifications->res,'homepage_posts'=>$homepage_posts,'finao_list'=>$finao_list,'homepage_posts'=>$homepage_posts));
            $this->render('mytiles',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_recent_posts'=>$finao_recent_posts,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
    }
    
    public function actionMyinspirations()
    {  
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $inspired_posts = Users::inspired_posts();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $finao_recent_posts = Users::finaorecentposts();
            $this->render('myinspirations',array('inspired_posts'=>$inspired_posts,'finao_recent_posts'=>$finao_recent_posts,'mytiles'=>$mytiles,'user_details'=>$userdetails,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
    }
    
    public function actionImfollowing()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails();
            $followings  =Users::imfollowing(); 
            $mynotifications = Users::getnotifications();
            $mytiles = Users::mytiles();             
            $finao_list = Users::user_finao_list(); 
            $finao_recent_posts = Users::finaorecentposts();
            $this->render('imfollowing',array('user_details'=>$userdetails,'finao_recent_posts'=>$finao_recent_posts,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'followings'=>$followings,'mynotifications'=>$mynotifications));
        }
    }
    
    public function actionMyfollowers()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $mytiles = Users::mytiles();             
            $finao_recent_posts = Users::finaorecentposts();
            $myfollowers = Users::myfollowers();
            $finao_list = Users::user_finao_list();
            $owntiles = Users::getowntiles();
            $this->render('myfollowers',array('user_details'=>$userdetails,'finao_recent_posts'=>$finao_recent_posts,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'myfollowers'=>$myfollowers,'mynotifications'=>$mynotifications,'owntiles'=>$owntiles));
        }
    }
    
    public function actionSortfollowerbytiles()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $tileid = intval($_GET['tile_id']);
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $mytiles = Users::mytiles();             
            $followersortbytile = Users::followersortbytile($tileid);
            $finao_list = Users::user_finao_list();
            $owntiles = Users::getowntiles();
                                      
            $this->render('myfollowers',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'myfollowers'=>$followersortbytile,'mynotifications'=>$mynotifications,'owntiles'=>$owntiles,'tileid'=>$tileid));
        }
    }
    
    public function actionKeepmeposted()
    {
        $splash_phone = $_POST['splash_phone'];
        $splash_email = $_POST['splash_email'];
        $remote_addr  = $_SERVER["REMOTE_ADDR"];
        $return = Users::keepmeposted($splash_email, $splash_phone, $remote_addr);
        echo $return;
    }

    public function action404()
    {
        $checklogin = Users::isLogin();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();            
            $this->render("404",array('user_details'=>$userdetails,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list,'mytiles'=>$mytiles));
        }
        else
        {
            $this->render("404");
        }
    }
    
    public function actionException()
    {
        $checklogin = Users::isLogin();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();            
            $this->render("exception",array('user_details'=>$userdetails,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list,'mytiles'=>$mytiles));
        }
        else
        {
            $this->render("exception");
        }
    }
    
    public function actionPrivacy()
    {
        $checklogin = Users::isLogin();
        if($checklogin)
        {
            $userdetails = Users::userprofiledetails(); 
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();            
            $this->render("privacy",array('user_details'=>$userdetails,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list,'mytiles'=>$mytiles));
        }
        else
        {
            $this->render("privacy");
        }
    }
    
    public function actionPublic_tiles()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $uname = $_GET["uname"];
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($uname);            
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $public_tiles = Users::public_tiles($uname);
            $public_tiles_view = Users::public_tiles_view($uname);
            //print_r($public_tiles_view);exit;
            //$public_user_posts = Users::public_user_post($uname);
            $this->render("public_tiles",array('user_details'=>$user_details,'mytiles'=>$mytiles,'public_tiles'=>$public_tiles,'public_tiles_view'=>$public_tiles_view,'public_profile_details'=>$public_profile_details,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list));
        }
    }
    
    public function actionPublic_finao_posts()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if ($checklogin)
        {
            $uname = $_GET["uname"];
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($uname);
            $public_user_posts = Users::public_user_post($uname);
            $public_tiles = Users::public_tiles($uname);         
            $mynotifications = Users::getnotifications();
            $mytiles = Users::mytiles();           
            $finao_list = Users::user_finao_list();
            $this->render("public_finao_posts",array('user_details'=>$user_details,'finao_list'=>$finao_list,'public_tiles'=>$public_tiles,'mytiles'=>$mytiles,'public_profile_details'=>$public_profile_details,'public_user_posts'=>$public_user_posts,'mynotifications'=>$mynotifications));
        }
    }
    
    public function actionPublic_user_finao_posts()
    {
        $checklogin = Users::ifNotLoginRedirect();        
        if ($checklogin)
        {
            $uname = $_GET["uname"];
            $finao_id = intval($_GET["finao_id"]);
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($uname);
            $public_user_posts = Users::finao_posts($finao_id);
            $mynotifications = Users::getnotifications();
            $mytiles = Users::mytiles();             
            $public_tiles = Users::public_tiles($uname);
            $finao_list = Users::user_finao_list();  
            $this->render("public_finao_posts",array('user_details'=>$user_details,'finao_list'=>$finao_list,'public_tiles'=>$public_tiles,'mytiles'=>$mytiles,'public_profile_details'=>$public_profile_details,'public_user_posts'=>$public_user_posts,'mynotifications'=>$mynotifications));
        }
    }
    
    public function actionPublic_finaos()
    {
        $checklogin = Users::ifNotLoginRedirect();        
        if ($checklogin)
        {
            $uname = $_GET["uname"];
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($uname);
            $finao_list = Users::user_public_finao_list($uname);
            $mynotifications = Users::getnotifications();
            $mytiles = Users::mytiles();
            $public_user_posts = Users::public_user_post($uname); 
            $public_tiles = Users::public_tiles($uname);            
            $this->render("public_finaos",array('user_details'=>$user_details,'public_user_posts'=>$public_user_posts,'public_tiles'=>$public_tiles,'public_profile_details'=>$public_profile_details,'mytiles'=>$mytiles,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list, 'userid' => $userid));   
        }
    }
    
    public function actionPublic_inspired()
    {
        $checklogin = Users::ifNotLoginRedirect();        
        if ($checklogin)
        {
            $uname = $_GET["uname"];
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($uname);            
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $public_inspired_posts = Users::public_inspired_posts($uname);
            $public_user_posts = Users::public_user_post($uname);
            $public_tiles = Users::public_tiles($uname);
            $this->render("public_inspired",array('user_details'=>$user_details,'public_tiles'=>$public_tiles,'public_user_posts'=>$public_user_posts,'public_inspired_posts'=>$public_inspired_posts,'public_profile_details'=>$public_profile_details,'mytiles'=>$mytiles,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list));
        }
    }
    
    public function actionPublic_photos()
    {
        $checklogin = Users::ifNotLoginRedirect();        
        if ($checklogin)
        {
            $userid = intval($_GET["userid"]);
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($userid);
            $public_user_posts = Users::public_user_post($userid);
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $this->render("public_photos",array('user_details'=>$user_details,'public_profile_details'=>$public_profile_details,'mytiles'=>$mytiles,'public_user_posts'=>$public_user_posts,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list));
        }
    }
    
    public function actionPublic_profile()
    {
        $checklogin = Users::ifNotLoginRedirect();        
        if ($checklogin)
        {
            $userid = intval($_GET["userid"]);
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($userid);
            $public_user_posts = Users::public_user_post($userid);
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $public_tiles = Users::public_tiles($userid);
            $this->render("public_profile",array('user_details'=>$user_details,'public_tiles'=>$public_tiles,'public_profile_details'=>$public_profile_details,'mytiles'=>$mytiles,'public_user_posts'=>$public_user_posts,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list));   
        }
    }
    
    public function actionPublic_followings()
    {
        $checklogin = Users::ifNotLoginRedirect();        
        if ($checklogin)
        {
            $uname = $_GET["uname"];
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($uname);
            $public_user_posts = Users::public_user_post($uname);
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $public_tiles = Users::public_tiles($uname);
            $followings = Users::publicfollowings($uname);
            $this->render("public_followings",array('user_details'=>$user_details,'public_tiles'=>$public_tiles,'followings'=>$followings,'public_profile_details'=>$public_profile_details,'mytiles'=>$mytiles,'public_user_posts'=>$public_user_posts,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list));
        }
    }
    
    public function actionSplash()
    {
        $this->render("splash");
    }
    
    public function actionSubmitpost()
    {
        $post_text = $_POST['post_text']; 
        $poststate = $_POST['finao_status']; 
        
        $finao_id = $_POST['finao_id'];
        $postresult = Users::submitnewpost($finao_id, $post_text, $poststate, $_FILES);
        if ($postresult->IsSuccess == 1)
        {
            echo $postresult->message;
        }
        else
        {
            echo $postresult->message;
        }   
    }
    
    public function Actionget_inspired_by_post()
    {
        $userpostid = $_GET["userpostid"];
        $return = Users::get_inspired_by_post($userpostid);
        echo $return;
    }
     
    public function Actionmark_inappropriate_post()
    {
        $userpostid = $_GET["userpostid"];
        $return = Users::mark_inappropriate_post($userpostid);
        echo $return;
    }
    
    public function Actionsharepost()
    {
        $userpostid = $_GET["userpostid"];
        $finaoid = $_GET["finaoid"];
        $return = Users::sharepost($userpostid, $finaoid);
        echo $return;
    }
    
    public static function actionChange_finao_status()
    {
        $finao_id = intval($_GET["finao_id"]);
        $finao_status = intval($_GET["finao_status"]);
        //$type = intval($_GET["type"]);
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {   
           $return = Users::change_finao_status($finao_id,$finao_status); 
        }   
    }
    
    public function Actiondeletepost()
    {
        $userpostid = $_GET["userpostid"];        
        $finaoid = $_GET["finaoid"];        
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $return = Users::deletepost($userpostid, $finaoid);
        }
    }
    
    public function Actionupdatepassword()
    {
        $reset_var = $_GET['profile_info'];        
        $return = Users::resetpassword($reset_var['password'],$reset_var['activkey']);
        echo $return;
    }
    
    public function Actionfollowuser()
    {
        $tileid = intval($_GET['tileid']);
        $followeduserid = intval($_GET['followeduserid']);
        $return = Users::followuser($followeduserid,$tileid);
        echo $return;
    }
    
    public function Actionunfollowuser()
    {
        $tileid = intval($_GET['tileid']);
        $followeduserid = intval($_GET['followeduserid']);
        $return = Users::unfollowuser($followeduserid,$tileid);
        echo $return;
    }
    
    public function Actionget_finao_msg()
    {
        $userid =  intval($_GET['user_id']);
        $tile_id = intval($_GET['tile_id']);
        $return = Users::get_finao_msg($tile_id,$userid);
        echo $return;
    }
    
    public function Actionget_finao_msg_public()
    {
        $userid =  intval($_GET['user_id']);
        $tile_id = intval($_GET['tile_id']);
        $return = Users::get_finao_msg_public($tile_id,$userid);
        echo $return;
    }
    
    public function Actionfollow_users_all_tile()
    {
        $user_id =  intval($_GET['user_id']);
        $uname =  $_GET['uname'];
        $return = Users::follow_users_all_tile($user_id, $uname);
        echo $return;
    }

    public function Actionsubmit_tagnotes()
    {
        $message =  $_POST['message'];
        $tagnote_id =  $_POST['tagnote_id'];        
        $return = Users::submit_tagnotes($message,$tagnote_id);
        if($return == "true"){
        $this->redirect(array("tagnotes"));
    }
    else
        {
        $this->redirect(array("tagnotes"));

        }
    }
    
    public function actionPublic_followers()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if($checklogin)
        {
            $userid = intval($_GET["userid"]);
            $user_details = Users::userprofiledetails();
            $public_profile_details = Users::public_user_details($userid);
            $public_user_posts = Users::public_user_post($userid);
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $public_tiles = Users::public_tiles($userid);
            $followers = Users::publicfollowers($userid);
            $this->render("public_followers",array('user_details'=>$user_details,'public_tiles'=>$public_tiles,'followers'=>$followers,'public_profile_details'=>$public_profile_details,'mytiles'=>$mytiles,'public_user_posts'=>$public_user_posts,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list));
        }
    }
    
    public function actionTiles()
    {
        $checklogin = Users::ifNotLoginRedirect();
        if ($checklogin)
        {
            $tile_id = intval($_GET["tile_id"]);
            $user_details = Users::userprofiledetails();            
            $mynotifications = Users::getnotifications();
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles(); 
            $tile_posts = Users::tiles_posts($tile_id);
            $finao_recent_posts = Users::finaorecentposts();
            $this->render("tiles",array('user_details'=>$user_details,'mytiles'=>$mytiles,'mynotifications'=>$mynotifications,'finao_list'=>$finao_list,'finao_recent_posts'=>$finao_recent_posts,'tile_posts'=>$tile_posts));
        }
    }
    
    public function actionPublic_posts_finao()
    {
    	
    }
    
    public function actionContact()
    {
        $return = Users::isLogin();
        if($return)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();                                  
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $this->render('contact',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        else
        {
            $this->render("contact");   
        }        
    } 
    
    public function actionSubmit_contactus()
    {
        require_once('recaptchalib.php');
        $privatekey = "6Ld2DfASAAAAAIqs1d8ePsBFjhiAYqAjsbgg-QCT";
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_GET["recaptcha_challenge_field"],
                                        $_GET["recaptcha_response_field"]);
        if (!$resp->is_valid)
        {
            echo "invalid_captcha_code";
            return;
        }        
        $name = $_GET['name'];
        $email = $_GET['email'];
        $phoneno = $_GET['phoneno'];
        $message = $_GET['message'];
        $return = Users::submit_contactus($name,$email,$phoneno,$message);
        echo $return;
    }
    
    public function actionPress_enquiries()
    {
        $return = Users::isLogin();
        if($return)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();                                  
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $this->render('press_enquiries',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        else
        {
            $this->render("press_enquiries");   
        }        
    }
    
    public function actionSubmit_enquiry()
    {   
        $fname = $_GET['fname'];
        $lname = $_GET['lname'];
        $title = $_GET['title'];
        $outletname = $_GET['outletname'];
        $website = $_GET['website'];
        $email = $_GET["email"];
        $phoneno = $_GET["phoneno"];
        $topic = $_GET['topic'];
        $deadline = $_GET["deadline"];
        $rfi_inperson = (isset($_GET["rfi_inperson"] ) ? 1 : 0);
        $rfi_phoneno = (isset($_GET["rfi_phoneno"] ) ? 1 : 0);
        $rfi_email = (isset($_GET["rfi_email"] ) ? 1 : 0);
        
//        require_once('recaptchalib.php');
//        $privatekey = "6Ld2DfASAAAAAIqs1d8ePsBFjhiAYqAjsbgg-QCT";
//        $resp = recaptcha_check_answer ($privatekey,
//                                        $_SERVER["REMOTE_ADDR"],
//                                        $_GET["recaptcha_challenge_field"],
//                                        $_GET["recaptcha_response_field"]);
//        if (!$resp->is_valid)
//        {
//            echo "invalid_captcha_code";
//            return;
//        }
        
        $return = Users::submit_enquiry($fname,$lname,$title,$outletname,$website,$email,$phoneno,$topic,$deadline,$rfi_inperson,$rfi_phoneno,$rfi_email);
        echo $return;
    }
    
    public function actionAboutus()
    {
        $return = Users::isLogin();
        if($return)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();                                  
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $this->render('aboutus',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        else
        {
            $this->render("aboutus");   
        }        
    }
    
    public function actionCompany_facts()
    {
        $return = Users::isLogin();
        if($return)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();                                  
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $this->render('company_facts',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        else
        {
            $this->render("company_facts");   
        }
    }
    public function actionIn_the_news()
    {
        $return = Users::isLogin();
        if($return)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();                                  
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $this->render('in_the_news',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        else
        {
            $this->render("in_the_news");   
        }
    }
    public function actionPress_release()
    {
        $return = Users::isLogin();
        if($return)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();                                  
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $this->render('press_release',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        else
        {
            $this->render("press_release");   
        }        
    }
    
    public function actionMedia_library()
    {
        $return = Users::isLogin();
        if($return)
        {
            $userdetails = Users::Userprofiledetails(); 
            $mynotifications = Users::getnotifications();                                  
            $finao_list = Users::user_finao_list();
            $mytiles = Users::mytiles();             
            $this->render('media_library',array('user_details'=>$userdetails,'mytiles'=>$mytiles,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        else
        {
            $this->render("media_library");   
        }        
    }
}