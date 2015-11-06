<?php

/**
 * This is the model class for table "fn_users".
 *
 * The followings are the available columns in table 'fn_users':
 * @property integer $userid
 * @property string $password
 * @property string $uname
 * @property string $email
 * @property string $secondary_email
 * @property string $activkey
 * @property integer $lastvisit
 * @property integer $superuser
 * @property string $profile_image
 * @property string $fname
 * @property string $lname
 * @property integer $gender
 * @property string $location
 * @property string $description
 * @property string $dob
 * @property string $age
 * @property integer $mageid
 * @property string $socialnetwork
 * @property string $socialnetworkid
 * @property integer $usertypeid
 * @property integer $status
 * @property integer $zipcode
 * @property string $createtime
 * @property integer $createdby
 * @property integer $updatedby
 * @property string $updatedate
 * @property integer $trackid
 *
 * The followings are the available model relations:
 * @property Blogs[] $blogs
 * @property Comments[] $comments
 * @property InviteFriend[] $inviteFriends
 * @property Like[] $likes
 * @property Logactivities[] $logactivities
 * @property Profileview[] $profileviews
 * @property Profileview[] $profileviews1
 * @property Tracking[] $trackings
 * @property Tracking[] $trackings1
 * @property Trackingnotifications[] $trackingnotifications
 * @property Trackingnotifications[] $trackingnotifications1
 * @property Trackingnotifications[] $trackingnotifications2
 * @property UserFinao[] $userFinaos
 * @property UserFinao[] $userFinaos1
 * @property UserFinaoJournal[] $userFinaoJournals
 * @property UserFinaoJournal[] $userFinaoJournals1
 * @property UserFinaoTile[] $userFinaoTiles
 * @property UserFinaoTile[] $userFinaoTiles1
 * @property UserFinaoTile[] $userFinaoTiles2
 * @property UserProfile[] $userProfiles
 * @property UserProfile[] $userProfiles1
 * @property Lookups $gender0
 * @property Lookups $usertype
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'fn_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, uname, email, dob, mageid, zipcode, createtime, createdby', 'required'),
			array('lastvisit, superuser, gender, mageid, usertypeid, status, zipcode, createdby, updatedby, trackid', 'numerical', 'integerOnly'=>true),
			array('password, email, secondary_email, activkey', 'length', 'max'=>128),
			array('uname', 'length', 'max'=>55),
			array('profile_image', 'length', 'max'=>750),
			array('fname, lname, location', 'length', 'max'=>100),
			array('description', 'length', 'max'=>500),
			array('age', 'length', 'max'=>20),
			array('socialnetwork', 'length', 'max'=>45),
			array('socialnetworkid', 'length', 'max'=>150),
			array('updatedate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userid, password, uname, email, secondary_email, activkey, lastvisit, superuser, profile_image, fname, lname, gender, location, description, dob, age, mageid, socialnetwork, socialnetworkid, usertypeid, status, zipcode, createtime, createdby, updatedby, updatedate, trackid', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'blogs' => array(self::HAS_MANY, 'Blogs', 'createdby'),
			'comments' => array(self::HAS_MANY, 'Comments', 'comment_author_id'),
			'inviteFriends' => array(self::HAS_MANY, 'InviteFriend', 'invited_by_user_id'),
			'likes' => array(self::HAS_MANY, 'Like', 'user_id'),
			'logactivities' => array(self::HAS_MANY, 'Logactivities', 'userid'),
			'profileviews' => array(self::HAS_MANY, 'Profileview', 'viewed_userid'),
			'profileviews1' => array(self::HAS_MANY, 'Profileview', 'viewer_userid'),
			'trackings' => array(self::HAS_MANY, 'Tracking', 'tracked_userid'),
			'trackings1' => array(self::HAS_MANY, 'Tracking', 'tracker_userid'),
			'trackingnotifications' => array(self::HAS_MANY, 'Trackingnotifications', 'createdby'),
			'trackingnotifications1' => array(self::HAS_MANY, 'Trackingnotifications', 'tracker_userid'),
			'trackingnotifications2' => array(self::HAS_MANY, 'Trackingnotifications', 'updateby'),
			'userFinaos' => array(self::HAS_MANY, 'UserFinao', 'updatedby'),
			'userFinaos1' => array(self::HAS_MANY, 'UserFinao', 'userid'),
			'userFinaoJournals' => array(self::HAS_MANY, 'UserFinaoJournal', 'createdby'),
			'userFinaoJournals1' => array(self::HAS_MANY, 'UserFinaoJournal', 'updatedby'),
			'userFinaoTiles' => array(self::HAS_MANY, 'UserFinaoTile', 'createdby'),
			'userFinaoTiles1' => array(self::HAS_MANY, 'UserFinaoTile', 'updatedby'),
			'userFinaoTiles2' => array(self::HAS_MANY, 'UserFinaoTile', 'userid'),
			'userProfiles' => array(self::HAS_MANY, 'UserProfile', 'createdby'),
			'userProfiles1' => array(self::HAS_MANY, 'UserProfile', 'updatedby'),
			'gender0' => array(self::BELONGS_TO, 'Lookups', 'gender'),
			'usertype' => array(self::BELONGS_TO, 'Lookups', 'usertypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userid' => 'Userid',
			'password' => 'Password',
			'uname' => 'Uname',
			'email' => 'Email',
			'secondary_email' => 'Secondary Email',
			'activkey' => 'Activkey',
			'lastvisit' => 'Lastvisit',
			'superuser' => 'Superuser',
			'profile_image' => 'Profile Image',
			'fname' => 'Fname',
			'lname' => 'Lname',
			'gender' => 'Gender',
			'location' => 'Location',
			'description' => 'Description',
			'dob' => 'Dob',
			'age' => 'Age',
			'mageid' => 'Mageid',
			'socialnetwork' => 'Socialnetwork',
			'socialnetworkid' => 'Socialnetworkid',
			'usertypeid' => 'Usertypeid',
			'status' => 'Status',
			'zipcode' => 'Zipcode',
			'createtime' => 'Createtime',
			'createdby' => 'Createdby',
			'updatedby' => 'Updatedby',
			'updatedate' => 'Updatedate',
			'trackid' => 'Trackid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('userid',$this->userid);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('uname',$this->uname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('secondary_email',$this->secondary_email,true);
		$criteria->compare('activkey',$this->activkey,true);
		$criteria->compare('lastvisit',$this->lastvisit);
		$criteria->compare('superuser',$this->superuser);
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('fname',$this->fname,true);
		$criteria->compare('lname',$this->lname,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('age',$this->age,true);
		$criteria->compare('mageid',$this->mageid);
		$criteria->compare('socialnetwork',$this->socialnetwork,true);
		$criteria->compare('socialnetworkid',$this->socialnetworkid,true);
		$criteria->compare('usertypeid',$this->usertypeid);
		$criteria->compare('status',$this->status);
		$criteria->compare('zipcode',$this->zipcode);
		$criteria->compare('createtime',$this->createtime,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updatedate',$this->updatedate,true);
		$criteria->compare('trackid',$this->trackid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function validate_login($username, $password)
    {               
       include ("configuration/configuration.php");   
       $fields = array(
                        'username'=>($username),
                        'password'=>urlencode(md5($password)),
                        'json'=>"login"
        );
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string=rtrim($fields_string,'&'); 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, ($username . ":" . $password));
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);     
        curl_close($ch);
        $result = utf8_encode($result);
        $user = json_decode($result);
        //echo json_last_error();
        
        if (isset($user->IsSuccess))
        {  
            if ($user->IsSuccess == 1)
            {    
                $randomno = Users::rand_string(15);
                $userdetail = new stdClass();
                $userdetail->userid = $user->item->userid;
                $userdetail->username = $username;
                $userdetail->password = $password;
                $userdetail->randomno = $randomno;
                $token = Users::ecbfhx(json_encode($userdetail),PUBLIC_KEY,IV);
                
                $expiretime=time()+(60*120); 
                setcookie("token", $token, $expiretime);
                
                return TRUE;
                
            }
        }
        else
        {
            return FALSE;
            //redirect back to login with invalid username/password error
        }
    }

   
    public static function ecbfhx($cleartext, $key, $iv)
    {
        $cipher = mcrypt_module_open(MCRYPT_BLOWFISH, '', MCRYPT_MODE_CBC, '');
        if (mcrypt_generic_init($cipher, $key, $iv) != -1)
        {
            //$cleartext=bin2hex($cleartext);
            // PHP pads with NULL bytes if $cleartext is not a multiple of the block size..
            $cipherText = mcrypt_generic($cipher,$cleartext );
            //echo $cipherText;
            mcrypt_generic_deinit($cipher);
            // Display the result in hex.
            mcrypt_module_close($cipher);
            return bin2hex($cipherText);
        }
    }

    public static function dcbfhx($ciphertext_hex, $key, $iv)
    {
        $cipherText= Users::hex2bin($ciphertext_hex);
        $cipher = mcrypt_module_open(MCRYPT_BLOWFISH, '', MCRYPT_MODE_CBC, '');
        if (mcrypt_generic_init($cipher, $key, $iv) != -1)
        {
            $clearText = mdecrypt_generic($cipher,$cipherText);
            mcrypt_generic_deinit($cipher);
            mcrypt_module_close($cipher);
            // Display the result in hex.
            return rtrim($clearText,"\0\4");
        }
    }

    public static function hex2bin($str)
    {
        $build = '';
        while(strlen($str) > 1) {
            $build .= chr(hexdec(substr($str, 0, 2)));
            $str = substr($str, 2, strlen($str)-2);
        }
        return $build;
    }
    
    public static function submit_signup_info($type, $email, $password, $first_name, $last_name)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'type'=>urlencode($type),
                    'email'=>urlencode($email),
                    'password'=>urlencode(md5($password)),
                    'fname'=>urlencode($first_name),
                    'lname'=>urlencode($last_name),
                    'json'=>"registration"
        );
        $fields_string = "";
        $fields_string = ""; 
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);  
        $result_json = curl_exec($ch);
        ///echo $result_json;exit;
        curl_close($ch);
             
        $result = json_decode($result_json);
        $return = "";
        if ($result->IsSuccess)
        {
            $return = "You have successfully registered to Finaonation. Account activation link sent to your email address.";
            return $return;
        }
        else
        {
            $return = "You are already registered. Want to recover your password?";
            return $return;
        }
        curl_close($ch); 
    }
    
    public static function forgot_password($email)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'email'=>urlencode($email),
                    'json'=>'forgotpassword'
        );
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);  
        $result_json = curl_exec($ch);
        $result = json_decode($result_json);
        curl_close($ch);
        return $result->res;
    }
    
    public static function search_user($search)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'search'=>urldecode($search),
                    'json'=>'search'
        );        
        $search_item_json = Users::webservice_query($url,$fields);        
        $search_item = json_decode($search_item_json);
        //echo $search_item_json;exit;

        if ($search_item->IsSuccess == 1)
        {    
            $html = ""; 
            if(!empty($search_item->item))
            {    
                $html .= "<li>";
                $html .= "<div class='arrow1'></div>";
                $html .= "</li>";
                foreach ($search_item->item as $response)
                {
                    $href = "";
                    $href = ($response->resulttype  == "user" ? "index.php?r=site/public_finao_posts&uname=" . $response->uname : "index.php?r=site/tiles&tile_id=" . $response->resultid);                       
                    $html .= "<li>";
                    $html .= "<a class='searchlist' href='". $href ."'><div class='text-align-left col-md-12 col-sm-12 search-top-padding devider-header'>";
                    $html .= "<div class='col-md-3 col-sm-3'>"; 
                    if($response->resulttype == "user")
                    {
                        $html .= "<img style='height:48px;width:48px; right-margin:-15px' src='" . ($response->image != "" ?  $response->image : $image_path . "no-image.png") ."'/>";    
                    }
                    else if ($response->resulttype == "tile")
                    {                 
                        $html .= "<img style='height:30px;width:30px;' src='" . ($response->image != "" ?  $response->image : $image_path . "tile.png") ."'/>";
                    }
                    $html .= "</div>";
                    $html .= "<div class='col-sm-9 font-18px search-text' style='margin-left:-12px; margin-top:15px;'>";
                    $html .= "<span class='margin-top-15px'>" . $response->name. "</span>";
                    $html .= "</div>";
                    $html .= "</div></a>";
                    $html .= "</li>";
                } 
            }
            echo $html;
        }
    }
    
    public static function activate_login($link)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'link'=>urlencode($link),
        );
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }

        $fields_string=rtrim($fields_string,'&'); 
       // echo $fields_string;
//        exit;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        $result = curl_exec($ch);
        $user = json_decode($result);
        return "Your account has been activated";
        curl_close($ch);              
    }
    
    
    public static function getnotifications()
    {   
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'getnotifications'
        );
        
        $result_json = Users::webservice_query($url,$fields);
        //print_r($result_json);exit;
        $result = json_decode($result_json);                 
        $return = "";
        if($result->IsSuccess == 1)
        {
            if (!empty($result->item))
            {
                $return = $result->item;
            }
        }
        else
        {
            $return = $result->message;
        }
        return $return;
    }
    
    
    public static function userprofiledetails()
    {       
        include ("configuration/configuration.php");
        
        $islogin = Users::isLogin();
        if($islogin)
        {
            $token = $_COOKIE['token'];   
        }
        else
        {
            Yii::app()->getController()->render('login');
        }
        
        $userinfo = json_decode(Users:: dcbfhx($token,PUBLIC_KEY,IV)); 
        $fields = array(
                    'json'=>'user_details',
                    'userid'=>$userinfo->userid 
        );   
                 
        $user_details_json = Users::webservice_query($url,$fields);
        $user_details  = json_decode($user_details_json);
        //print_r($user_details);exit;
        //$notifications = users::getnotifications();
//        $who_to_follow = Users::whotofollow();
//        $posts = Users::finaorecentposts();
//        $finao_list = Users::user_finao_list();
        
        if ($user_details->IsSuccess)
        {
            //print_r($user_details->item[0]);exit;
            return $user_details->item[0];   
        }
    }
    
    public static function whotofollow()
    {       
        include ("configuration/configuration.php"); 
        $fields = array(
                    'json'=>'whotofollow' 
        );   
                                                           
        $who_to_follow_json = Users::webservice_query($url,$fields);                                                                 
        $who_to_follow  = json_decode($who_to_follow_json);
    
        if($who_to_follow->IsSuccess)
        {
            return $who_to_follow->item;
        }
        else
        {
            return $who_to_follow->message;
        }           
    }
    
    public static function myprofiledetails()
    {       
        include ("configuration/configuration.php");
        $token = $_COOKIE['token'];  
        
        $userinfo = json_decode(Users:: dcbfhx($token,PUBLIC_KEY,IV)); 
        
        $fields = array(
                    'json'=>'user_details',
                    'userid'=> $userinfo->userid
        ); 
                                            
        $return_json = Users::webservice_query($url,$fields);
        $mynotifications = Users::getnotifications();
        $finao_recent_post = Users::finaorecentposts();
        $finao_list = Users::user_finao_list();
        $mytiles = Users::mytiles(); 
        $return = json_decode($return_json);
        if($return->IsSuccess == 1)
        {
            Yii::app()->getController()->render('myprofile',array('user_details'=>$return->item[0],'mytiles'=>$mytiles,'finao_recent_posts'=>$finao_recent_post,'finao_list'=>$finao_list,'mynotifications'=>$mynotifications));
        }
        else
        {
            setcookie("token","",0);
            Yii::app()->getController()->redirect(array('login')); 
        }
    } 
    
    public static function ifNotLoginRedirect()
    {
        if (isset($_COOKIE['token']))
        {    
            $cookie_value = $_COOKIE['token'];
            if($cookie_value != "")
            {
                $expiretime=time()+(60*120); 
                setcookie("token", $cookie_value, $expiretime);
                return true;
            }
            else
            {
                $this->render('login');
                return false;
            }   
        }
        else
        {   
            Yii::app()->getController()->redirect(array('login')); 
        }
    }
    
    public static function isLogin()
    {
        if (isset($_COOKIE['token']))
        {    
            $cookie_value = $_COOKIE['token'];
            if($cookie_value != "")
            {
                $expiretime=time()+(60*120); 
                setcookie("token", $cookie_value, $expiretime);
                return true;
            }
            else
            {
                return false;
            }   
        }
        else
        {    
            return false;
        }
    }
    
    public static function getsessionid()
    {
        if (isset($_COOKIE['token']))
        {
            $session_id = $_COOKIE['token'];
            return $session_id;            
        }
    }
    
    public static function user_logout()
    {    
        include ("configuration/configuration.php"); 
        $fields = array(
                    'json'=>'logout' 
        ); 
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }

        $fields_string=rtrim($fields_string,'&'); 
    
        $token = $_COOKIE["token"];
                                      
        $ch = curl_init($url);    
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('authtoken: ' . $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        
        $result_json = curl_exec($ch);
        $result = json_decode($result_json);
        
        if (isset($result->IsSuccess))
        {
            return true;
        }
        else
        {
            return false;
        }
        curl_close($ch);    
    }
    
    public static function update_profile($userid,$name,$email,$password,$x,$y,$w,$h,$bannerx,$bannery,$bannerw,$bannerh,$bio)
    {   
//        print_r($_FILES);
//        echo $name."-".$email."-".$password."-".$x."-".$y."-".$w."-".$h."-".$bannerx."-".$bannery."-".$bannerw."-".$bannerh."-".$bio;
//        exit;
        $profile_image = @$_FILES['profile_image']['tmp_name'];
        $profile_banner_image = @$_FILES['profile_banner_image']['tmp_name'];
        
        if ($password != "")
        {
            $password = md5($password);
        }
        include ("configuration/configuration.php"); 
        $fields = array(
                    'json'=>'updateprofile',
                    'name'=>$name,
                    'email'=>$email,
                    'password'=>$password,
                    'x'=>$x,
                    'y'=>$y,
                    'w'=>$w,
                    'h'=>$h,
                    'banner-x'=>$bannerx,
                    'banner-y'=>$bannery,
                    'banner-w'=>$bannerw,
                    'banner-h'=>$bannerh,
                    'profile_image'=>($profile_image == "" ? "" : '@'.$profile_image),
                    'profile_bg_image'=> ($profile_banner_image == "" ? "" : '@'.$profile_banner_image),
                    'bio'=>$bio
        ); 
        $return_json = Users::webservice_query($url,$fields);
        $result = json_decode($return_json);
        
        if ($result->IsSuccess == "1")
        {
            return $result->message;
        }
        else
        {
            return $result->message;
        }    
    }
    
    public static function webservice_query($url,$fields)
    {
        $token = $_COOKIE['token'];        
        
        $userinfo = json_decode(Users:: dcbfhx($token,PUBLIC_KEY,IV));
        
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string=rtrim($fields_string,'&'); 
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, ($userinfo->username .":". $userinfo->password));
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
        //curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $result = curl_exec($ch);
        //echo $result;
        //exit;
        $user = json_decode($result);
        curl_close($ch);
        
        return $result;       
    }
    
    public static function finaorecentposts()
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'finaorecentposts'
        );                                                           
        $return_json = Users::webservice_query($url,$fields);        
        $result = json_decode($return_json);
        //print_r($result);exit;
        if ($result->IsSuccess)
        {  
            if(!empty($result->item))
            {
                return $result->item;   
            }    
        }
        else
        {
            return false;
        }    
    }
    
    public static function finao_posts($finao_id)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'public_posts',
                    'finao_id' => $finao_id
        );                                                           
        $return_json = Users::webservice_query($url,$fields);        
        $result = json_decode($return_json);
        //print_r($result);exit;
        if ($result->IsSuccess)
        {  
            if(!empty($result->item))
            {
                return $result->item;   
            }    
        }
        else
        {
            return false;
        }    
    }
    
    public static function user_finao_list()
    {
       include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'finao_list',
        );                                                           
        $return_json = Users::webservice_query($url,$fields);       
        $result = json_decode($return_json);
     
        if ($result->IsSuccess)
        {
            
            if(isset($result->item))
            {   
                return $result->item;   
            }
            else
            {
                return "no finaos present.";
            }
        } 
    }
    
    public static function user_public_finao_list($otherid)
    {
       include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'finao_list',
                    'otherid' => $otherid,
                    'type' => 1
        );                                                           
        $return_json = Users::webservice_query($url,$fields);       
        $result = json_decode($return_json);
     
        if ($result->IsSuccess)
        {
            
            if(isset($result->item))
            {   
                return $result->item;   
            }
            else
            {
                return "no finaos present.";
            }
        } 
    }
    
    public static function submitnewfinao($caption, $finao_title, $tile_id, $isfinaopublic, $videoid, $videostatus, $video_image)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'createfiano',
                    'caption'=>$caption,
                    'finao_msg'=>$finao_title,
                    'tile_id'=>$tile_id,
                    'finao_status_ispublic'=>$isfinaopublic,
                    'videoid'=>$videoid,
                    'videostatus'=>$videostatus,
                    'video_image'=>$video_image
        );                                                           
        $return_json = Users::webservice_query($url,$fields);       
        $result = json_decode($return_json);
        return $result;
    }
    
    public static function submitnewpost($finao_id, $postdata, $poststate, $files)
    {
        include ("configuration/configuration.php");
        $fields = array(
                        'json'=>'createpost',
                        'finao_id'=>$finao_id,
                        'postdata'=>$postdata,
                        'poststate'=>$poststate
                    );
        foreach($files["post_image"]["name"] as $key => $image_name)
        {
            if ($image_name != "")
            {
                $fields["postimage" . $key] = '@' . $files["post_image"]["tmp_name"][$key];
                $fields["postimage" . $key . "-x"] = $_POST["x"][$key];
                $fields["postimage" . $key . "-y"] = $_POST["y"][$key];
                $fields["postimage" . $key . "-w"] = $_POST["w"][$key];
                $fields["postimage" . $key . "-h"] = $_POST["h"][$key];
            }
        }
        foreach($files["post_video"]["name"] as $key => $video_name)
        {
            if ($video_name != "")
            {
                $fields["postvideo" . $key] = '@' . $files["post_video"]["tmp_name"][$key];
            }
        }
        $return_json = Users::webservice_query($url,$fields);
        $result = json_decode($return_json);    
        return $result;
    }
    
    public static function rand_string($length)
    {
        $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for($i = 0; $i < $length; $i++)
        {
            $random_int = mt_rand();
            $str .=  $charset[$random_int % strlen($charset)];
        }
        return $str;
    }
    
    public static function imfollowing()
    {
        include ("configuration/configuration.php");
        $islogin = Users::isLogin();
        if($islogin)
        {
            $token = $_COOKIE['token'];   
        }
        else
        {
            Yii::app()->getController()->render('login');
        }
         
        $userinfo = json_decode(Users:: dcbfhx($token,PUBLIC_KEY,IV)); 
        $fields = array(
                    'json'=>'followings',
                    'userid'=>urlencode($userinfo->userid) 
        );   
                 
        $following_list_json = Users::webservice_query($url,$fields);
        $following_list = json_decode($following_list_json);
        return $following_list->res;
    }
    
    public static function myfollowers()
    {
        include ("configuration/configuration.php");
        $islogin = Users::isLogin();
        if($islogin)
        {
            $token = $_COOKIE['token'];   
        }
        else
        {
            Yii::app()->getController()->render('login');
        }
         
        $userinfo = json_decode(Users:: dcbfhx($token,PUBLIC_KEY,IV)); 
        $fields = array(
                    'json'=>'followers'
        );   
                 
        $my_followers_json = Users::webservice_query($url,$fields);
        $my_followers = json_decode($my_followers_json);
        
        return $my_followers->res;
    }
    
    public static function followersortbytile($tileid)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'sorttiles',
                    'tileid'=>$tileid); 
        $my_followers_json = Users::webservice_query($url,$fields);
        $my_followers = json_decode($my_followers_json);
        
        return $my_followers->res;   
    }
    
    public static function mytiles()
    {
        include ("configuration/configuration.php");
        $islogin = Users::isLogin();
        if($islogin)
        {
            $token = $_COOKIE['token'];   
        }
        else
        {
            Yii::app()->getController()->render('login');
        }
         
//        $userinfo = json_decode(Users:: dcbfhx($token,PUBLIC_KEY,IV)); 
//        $fields = array(
//                    'json'=>'usertiles_old',
//                    'userid'=>urlencode($userinfo->userid) 
//        ); 
        $iscomplete=0;
        $fields = array(
                    'json'=>'mytiles'                    
        );
        $mytiles_json = Users::webservice_query($url,$fields);
        $mytiles = json_decode($mytiles_json);//print_r($mytiles);exit;
        $return = "";
        if($mytiles->IsSuccess)
        {
            if(!empty($mytiles->item))
            {
                $return = $mytiles->item;
            }
        }
        return $return;    
    }
    
    public static function inspired_posts()
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'getinspired'
        );                                                           
        $result_json = Users::webservice_query($url,$fields);        
        $result = json_decode($result_json);
        $return = "";
        if($result->IsSuccess == 1)
        {
            if(!empty($result->item))
            {
                $return = $result->item;
            }
        }
        else
        {
            $return = $result->message;
        }
        return $return;  
    }
    
    public static function homepage_posts($page)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'homepage_user',
                    'start_index' => (intval($page) -1 ) * intval($posts_per_page),
                    'count' => intval($posts_per_page)
        );
        $return_json = Users::webservice_query($url,$fields);
        $result = json_decode($return_json);
        
        if ($result->IsSuccess)
        {
            return $result->item;
        }
        else
        {
            return $result->message;
        }     
    }
    
    public static function get_inspired_by_post($userpostid)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'getinspiredfrompost',
                    'userpostid'=>$userpostid
        );                                                           
        $return_json = Users::webservice_query($url,$fields);        
        $result = json_decode($return_json);

        if ($result->IsSuccess)
        {
            return $result->message;
        }
        else
        {
            return $result->message;
        }     
    }
    
    public static function mark_inappropriate_post($userpostid)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'markinappropriatepost',
                    'userpostid'=>$userpostid
        );                                                           
        $return_json = Users::webservice_query($url,$fields);        
        $result = json_decode($return_json);
        
        if ($result->IsSuccess)
        {
            return $result->message;
        }
        else
        {
            return $result->message;
        }     
    }
    
    public static function change_finao_status($finao_id,$finao_status)
    {
        include ("configuration/configuration.php");
        $fields = array(
            'json'=>'changefinaostatus',
            'finaoid'=> $finao_id,
            'status'=>$finao_status,
        ); 
                                            
        $return_json = Users::webservice_query($url,$fields);
        $return = json_decode($return_json);
        if($return->IsSuccess == 1)
        {
            echo "ok";
        }
        return;
    }
    
    public static function deletepost($userpostid,$finao_id)
    {
        include ("configuration/configuration.php");
        $fields = array(
            'json'=>'deletepost',
            'finao_id'=> $finao_id,
            'userpostid'=>$userpostid,
        ); 
        $return_json = Users::webservice_query($url,$fields);
        echo $return_json;exit;
        $return = json_decode($return_json);
        if($return->IsSuccess == 1)
        {
            echo "ok";
        }
        return;
    }
    
    public static function sharepost($userpostid, $finaoid)
    {
        include ("configuration/configuration.php");
        $fields = array(
            'json'=>'sharepost',
            'userpostid'=>$userpostid,
            'finaoid'=>$finaoid
        );                                                           
        $return_json = Users::webservice_query($url,$fields);
        $result = json_decode($return_json);
        
        if ($result->IsSuccess)
        {
            return $result->message;
        }
        else
        {
            return $result->message;
        }     
    }
    
    public static function verifyregistration($activationkey)
    {
        include ("configuration/configuration.php");
        $fields = array(
            'json'=>'verifyregistration',
            'activation'=>$activationkey            
        );
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string=rtrim($fields_string,'&'); 
        $ch = curl_init($url);        
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $result_json = curl_exec($ch);
        $result = json_decode($result_json);
        curl_close($ch);        
        $return = "";
        if($result->IsSuccess == 1)
        {
            if(!(empty($result->item)))
            {
                $return = $result->item;
            }
        }
        else
        {
            $return = $result->message;
        }
        return $return;
    }
    
    public static function resetpassword($password,$activkey)
    {
        include ("configuration/configuration.php");
        $fields = array(
            'json'=>'resetpassword',            
            'activkey'=>$activkey,
            'password'=>md5($password)            
        );
        
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string=rtrim($fields_string,'&'); 
        $ch = curl_init($url);        
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
        $result_json = curl_exec($ch);
        $result = json_decode($result_json);
        curl_close($ch);        
        return $result->res;    
    }
    
    public static function public_user_details($uname)
    {
        include ("configuration/configuration.php");                         
        $fields = array(
            'json'=>'user_details',
            'userid'=>$uname            
        );  
        $return_json = Users::webservice_query($url,$fields);
        $result = json_decode($return_json);
        $return = "";        
        if ($result->IsSuccess)
        {
            if(!empty($result->item))
            {
                $return = $result->item[0];   
            }
        }
        else
        {
            $return = $result->message;
        }
        return $return;
    }
    
    public static function public_user_post($userid)
    {
        include ("configuration/configuration.php");
        $fields = array(
            'json'=>'finaorecentposts',
            'userid'=>$userid            
        );                                                           
        $return_json = Users::webservice_query($url,$fields);        
        $result = json_decode($return_json);
        $return = "";        
        if ($result->IsSuccess)
        {
            if(!empty($result->item))
            {
                $return = $result->item;   
            }
        }
        else
        {
            $return = $result->message;
        }    
        return $return;
    }   
    
    //public static function public_user_post($userid)
//    {
//        include ("configuration/configuration.php");
//        $fields = array(
//            'json'=>'finaorecentposts',
//            'userid'=>$userid            
//        );                                                           
//        $return_json = Users::webservice_query($url,$fields);        
//        $result = json_decode($return_json);
//        $return = "";        
//        if ($result->IsSuccess)
//        {
//            if(!empty($result->item))
//            {
//                $return = $result->item;   
//            }
//        }
//        else
//        {
//            $return = $result->message;
//        }    
//        return $return;
//    } 
    
    public static function followuser($followeduserid, $tileid)
    {                                               
        include ("configuration/configuration.php");
        
        $fields = array(
            'json'=>'followuser',
            'followeduserid'=>$followeduserid,
            'tileid'=>$tileid
        );
        $return_json = Users::webservice_query($url,$fields);
        $result = json_decode($return_json);
        $return = "";
        $remaining_to_follow = "";
        $tiles_count = "";
        if ($result->IsSuccess)
        {
            $tiles_count = Users::public_tiles($followeduserid);
            if(is_array($tiles_count))
            {
                $total_tiles_count = count($tiles_count); 
                $total_followed_tiles = 0;   
                foreach ($tiles_count as $tile_after)
                {
                    if($tile_after->type == 1)
                    {
                        ++ $total_followed_tiles;
                    }
                }
                if($total_tiles_count > $total_followed_tiles)
                {
                    $remaining_to_follow = "avail";
                }
                else
                {
                    $remaining_to_follow = "notavail";
                }
            }                           
            $return = array("return"=>$result->message,"status"=>$remaining_to_follow);
        }
        else
        { 
            $return = array("return"=>$result->message,"status"=>$remaining_to_follow);
        }    
        return json_encode($return);
    }
    
    public static function unfollowuser($followeduserid, $tileid)
    {                                               
        include ("configuration/configuration.php");
        
        $fields = array(
            'json'=>'unfollow',
            'followeduserid'=>$followeduserid,
            'tileid'=>$tileid
        );
        $return_json = Users::webservice_query($url,$fields);        
        $result = json_decode($return_json);
        $return = "";
        $remaining_to_follow = "";
        if ($result->IsSuccess)
        {
            $tiles_count = Users::public_tiles($followeduserid);
            if(is_array($tiles_count))
            {
                $total_tiles_count = count($tiles_count); 
                $total_followed_tiles = 0;   
                foreach ($tiles_count as $tile_after)
                {
                    if($tile_after->type == 1)
                    {
                        ++ $total_followed_tiles;
                    }
                }
                if($total_tiles_count > $total_followed_tiles)
                {
                    $remaining_to_follow = "avail";
                }
                else
                {
                    $remaining_to_follow = "notavail";
                }
            }             
            $return = array("return"=>$result->message,"status"=>$remaining_to_follow);
        }
        else
        {
            $return = array("return"=>$result->message,"status"=>$remaining_to_follow);
        }    
        return json_encode($return);
    }
    
    public static function getowntiles()
    {
        include ("configuration/configuration.php");
        $fields = array(
            'json'=>'getowntiles'
        );                      
        $return_json = Users::webservice_query($url,$fields);
        $result = json_decode($return_json);
        //print_r($result);exit;
        $return="";
        
        if ($result->IsSuccess)
        {
            if(!empty($result->item))
            {
                $return = $result->item;
            }
        }
        else
        {
            $return = "false";
        }  
        return $return;  
    }
    
    public static function gettagnotes()
    {
        include ("configuration/configuration.php");
        $fields = array(
            'json'=>'tagnote'
        );
        $return_json = Users::webservice_query($url,$fields);
        $result = json_decode($return_json);
	 $return = "";
	 if((@$result->message) != "")
        {
            $return = @$result->message;
	 }       
        
        if(!empty($result->res))
        {
         $return = $result->res;
        }          
        return $return;    
    }
    
    public static function public_tiles($userid)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'public_followedtile',
                    'userid'=>$userid,
        ); 
        $public_tiles_json = Users::webservice_query($url,$fields);
        $public_tiles = json_decode($public_tiles_json);
        $return = "";
        if($public_tiles->IsSuccess)
        {
            if(!empty($public_tiles->item))
            {
                $return = $public_tiles->item;
            }
        }
        else
        {
            $return = "false";
        }
        return $return;    
    }
    
    public static function public_tiles_view($userid)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'mytiles',
                    'id'=>$userid,
        ); 
        $public_tiles_json = Users::webservice_query($url,$fields);
        $public_tiles = json_decode($public_tiles_json);
        //echo $userid;
//        print_r($public_tiles);exit;
        $return = "";
        if($public_tiles->IsSuccess)
        {
            if(!empty($public_tiles->item))
            {
                $return = $public_tiles->item;
            }
        }
        else
        {
            $return = "false";
        }
        return $return;    
    }
    
    public static function public_inspired_posts($userid)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'getinspired',
                    'id'=>$userid
        );
        $result_json = Users::webservice_query($url,$fields);        
        $result = json_decode($result_json);
        $return = "";
        if($result->IsSuccess == 1)
        {
            if(!empty($result->item))
            {
                $return = $result->item;
            }
        }
        else
        {
            $return = $result->message;
        }
        return $return;  
    }
    
    public static function keepmeposted($splash_email, $splash_phone, $remote_addr)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'keepmeposted',
                    'splash_email' => urlencode($splash_email),
                    'splash_phone' => urlencode($splash_phone),
                    'remote_addr' => urlencode($remote_addr)
        );
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);  
        $result_json = curl_exec($ch);
        $result = json_decode($result_json);
        curl_close($ch);
        $return = "";
        if($result->IsSuccess == "1")
        {
            $return = $result->message;
        }
        else
        {
            $return = $result->message;
        }
        return $return;
    }
    public static function get_finao_msg($tile_id,$user_id)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'public_finao',
                    'tile_id'=>$tile_id
        );
        $result_json = Users::webservice_query($url,$fields);
        $result = json_decode($result_json);
        $return = "";
        $html = "";
        if($result->IsSuccess == 1)
        {
            if(!empty($result->item)) 
            {
                $i = 0;
                foreach ($result->item as $item)
                {
                    ++$i;
                    $html .= "<li style='margin-left:3px;'><a href='index.php?r=site/finao_posts&finao_id=" . $item->finao_id ."'>". $item->finao_msg ."</a></li>";
                    if($i == $tiles_finao_count)
                    {
                        break;
                    }
                }
            }
        }
        else
        {
            $return = $result->message;
            $html .= "<li style='margin-left:3px;'>". $return ."</li>";
        }
        return $html;  
    }
    
    public static function get_finao_msg_public($tile_id,$user_id)
    {
        include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'public_finao',
                    'tile_id'=>$tile_id,
                    'id'=>$user_id
        );
        $result_json = Users::webservice_query($url,$fields);        
        $result = json_decode($result_json);
        $return = "";
        $html = "";
        if($result->IsSuccess == 1)
        {
            if(!empty($result->item)) 
            {
                $i = 0;
                foreach ($result->item as $item)
                {
                    ++$i;
                    $html .= "<li style='margin-left:3px;'><a href='index.php?r=site/finao_posts&finao_id=" . $item->finao_id ."'>". $item->finao_msg ."</a></li>";
                    if($i == $tiles_finao_count)
                    {
                        break;
                    }
                }
            }
        }
        else
        {
            $return = $result->message;
            $html .= "<li style='margin-left:3px;'>". $return ."</li>";
        }
        return $html;  
    }
    
    public static function follow_users_all_tile($user_id, $uname)
    {
        include ("configuration/configuration.php");
        
        $tiles_count = Users::public_tiles($uname);
        $total_tiles_count = count($tiles_count); 
        $total_followed_tiles = 0;   
        foreach ($tiles_count as $tile_after)
        {
            if($tile_after->type == 1)
            {
                ++ $total_followed_tiles;
            }
        }
        
        if($total_followed_tiles >= $total_tiles_count)
        {
             $fields = array(
                    'json'=>'unfollowalltiles',                    
                        'id'=>$user_id
            );
            $result_json = Users::webservice_query($url,$fields);        
            $result = json_decode($result_json);        
            $return = "";
                    
            if($result->IsSuccess == 1)
            {
                if($result->message == "success")
                {
                    $return = "unfollow_all";   
                }
            }
            else
            {
                $return = $result->message;            
            }   
        }
        else
        {
            $fields = array(
                    'json'=>'followalltiles',                    
                        'id'=>$user_id
            );
            $result_json = Users::webservice_query($url,$fields);        
            $result = json_decode($result_json);        
            $return = "";
                    
            if($result->IsSuccess == 1)
            {
                if($result->message == "success")
                {
                    $return = "follow_all";   
                }
            }
            else
            {
                $return = $result->message;            
            }
        }
        return $return;
    }
    public static function submit_tagnotes($message,$tagnote_id)
    {
       include ("configuration/configuration.php");
        $fields = array(
                    'json'=>'settings_tagnote',                    
                    'message'=>$message,
                    'tagnote_id'=>$tagnote_id
        );
        $result_json = Users::webservice_query($url,$fields);
        $result = json_decode($result_json);        
        $return = "";
                
        if($result->isSuccess == 1)
        {
            $return = "true";
        }
        else
        {
            $return = "false";            
        }
        return $return;
    }
    
    public static function publicfollowings($userid)
    {
        include ("configuration/configuration.php");
        $islogin = Users::isLogin();
        if($islogin)
        {
            $token = $_COOKIE['token'];   
        }
        else
        {
            Yii::app()->getController()->render('login');
        }
         
        $fields = array(
                    'json'=>'followings',
                    'id'=>$userid
        );   
                 
        $public_followings_json = Users::webservice_query($url,$fields);
        $public_followings = json_decode($public_followings_json);
        
        return $public_followings->res;    
    }
    
    public static function publicfollowers($userid)
    {
        include ("configuration/configuration.php");
        $islogin = Users::isLogin();
        if($islogin)
        {
            $token = $_COOKIE['token'];   
        }
        else
        {
            Yii::app()->getController()->render('login');
        }
         
        $fields = array(
                    'json'=>'followers',
                    'id'=>$userid
        );   
                 
        $public_followers_json = Users::webservice_query($url,$fields);
        $public_followers = json_decode($public_followers_json);
        
        return $public_followers->res;    
    }
    
    public static function tiles_posts($tile_id)
    {
        include ("configuration/configuration.php");
        $islogin = Users::isLogin();
        if($islogin)
        {
            $token = $_COOKIE['token'];   
        }
        else
        {
            Yii::app()->getController()->render('login');
        }
        $limit = 10; 
        $fields = array(
                    'json'=>'tile_post',
                    'tile_id'=>$tile_id,
                    'limit'=>$limit
        );   
                 
        $tile_posts_json = Users::webservice_query($url,$fields);
        $tile_posts = json_decode($tile_posts_json);    
        $return = "";
        if($tile_posts->IsSuccess == 1)
        {
            if(!empty($tile_posts->item))
            {
                $return = $tile_posts->item;
            }
        }
        else
        {
            return "false";
        }
        return $return;
    }
    
    public static function submit_contactus($name,$email,$phoneno,$message)
    {
        include ("configuration/configuration.php");        
        $fields = array(
                    'json'=>'contactus',
                    'name'=>$name,
                    'email'=>$email,
                    'phone'=>$phoneno,
                    'message'=>$message
        );
        
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);  
        $result_json = curl_exec($ch);        
        $result = json_decode($result_json);
        curl_close($ch);
        $return = "";
        if($result->IsSuccess == "1")
        {
            $return = $result->message;
        }
        else
        {
            $return = $result->message;
        }
        return $return;
    }
    
    public static function submit_enquiry($fname,$lname,$title,$outletname,$website,$email,$phoneno,$topic,$deadline,$rfi_inperson,$rfi_phoneno,$rfi_email)
    {
        include ("configuration/configuration.php");        
        $fields = array(
                    'json'=>'inqueries',
                    'fname'=>$fname,
                    'lname'=>$lname,
                    'title'=>$title,
                    'outletname'=>$outletname,
                    'website'=>$website,
                    'email'=>$email,
                    'phoneno'=>$phoneno,
                    'topic'=>$topic,
                    'deadline'=>$deadline,
                    'rfi_inperson'=>$rfi_inperson,
                    'rfi_email'=>$rfi_email,
                    'rfi_phone'=>$rfi_phoneno                    
        );
        
        $fields_string = "";
        foreach($fields as $key=>$value)
        {
            $fields_string .= $key.'='.$value.'&';
        }
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);  
        $result_json = curl_exec($ch);
        $result = json_decode($result_json);
        
        curl_close($ch);
        $return = "";
        if($result->IsSuccess == "1")
        {
            $return = $result->message;
        }
        else
        {
            $return = $result->message;
        }
        return $return;    
    }
}