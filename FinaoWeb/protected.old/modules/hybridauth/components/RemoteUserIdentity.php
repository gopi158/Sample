<?php

class RemoteUserIdentity extends CBaseUserIdentity {

	public $userid;
	public $userData;
	public $useremail;
	public $loginProvider;
	public $loginProviderIdentifier;
	private $_adapter;
	private $_hybridAuth;
	public $username;
	public $Issuperuser;
	public $userContacts;
	public $password;
	/**
	 * @param string The provider you are using
	 * @param Hybrid_Auth An instance of Hybrid_Auth 
	 */
	public function __construct($provider,Hybrid_Auth $hybridAuth) {
		$this->loginProvider = $provider;
		$this->_hybridAuth = $hybridAuth;
	}

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		if (strtolower($this->loginProvider) == 'openid') {
			if (!isset($_GET['openid-identity'])) {
				throw new Exception('You chose OpenID but didn\'t provide an OpenID identifier');
			} else {
				$params = array( "openid_identifier" => $_GET['openid-identity']);
			}
		} else {
			$params = array();
		}
		
		$adapter = $this->_hybridAuth->authenticate($this->loginProvider,$params);
		if ($adapter->isUserConnected()) {
			$this->_adapter = $adapter;
			$this->loginProviderIdentifier = $this->_adapter->getUserProfile()->identifier;
			$user_profile = $this->_adapter->getUserProfile();
			$this->userContacts = $this->_adapter->getUserContacts();
			/*$user_contacts = $this->_adapter->getUserContacts();
			print_r($user_contacts);
			exit;*/
			$userinfo = array();
			if(isset(Yii::app()->session['userinfo']))
				unset(Yii::app()->session['userinfo']);
			$userinfo["fname"] = $user_profile->firstName;
			$userinfo["lname"] = $user_profile->lastName;
			$userinfo["email"] = $user_profile->email;
			$userinfo["zip"] = $user_profile->zip;
			$userinfo["gender"] = $user_profile->gender;
			$userinfo["photourl"] = $user_profile->photoURL;
			$userinfo["country"] = $user_profile->country;
			$userinfo["region"] = $user_profile->region;
			$userinfo["city"] = $user_profile->city;
			$userinfo["age"] = $user_profile->age;
			$userinfo["birthday"] = $user_profile->birthDay;
			$userinfo["birthmonth"] = $user_profile->birthMonth;
			$userinfo["birthyear"] = $user_profile->birthYear;
			
			$userinfo["SocialNetworkID"] = $user_profile->identifier;
			$userinfo["SocialNetwork"] = $this->loginProvider;
			if($user_profile->birthDay != "")
			{
				$userinfo["dob"] = $user_profile->birthDay."-".$user_profile->birthMonth."-".$user_profile->birthYear;
			}
			Yii::app()->session['userinfo'] = $userinfo;
			$user = HaLogin::getUser($this->loginProvider, $this->loginProviderIdentifier);
			//print_r($user);
			//exit;
			if ($user == null) {
				$this->errorCode = self::ERROR_USERNAME_INVALID;
			} else {
				$this->userid = $user->userid;
				$this->useremail = $user->email;
				$this->username = $user->fname." ".$user->lname;
				$this->userData = $user->usertypeid;
				$this->Issuperuser = $user->superuser;
				$this->password = "password";
				$this->errorCode = self::ERROR_NONE;
			}
			return $this->errorCode == self::ERROR_NONE;
		}
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId() {
		return $this->userid;
	}
	public function getPassword()
	{
		return $this->password;
	}
	/**
	 * @return string the username of the user record
	 */
	 //added by varalakshmi 07-01-13 at 06:06 pm to maintain session login
	public function getEmail() {
		return $this->useremail;
	}
	public function getName()
	{
		return $this->username;
	}
	public function getIssuperuser()
	{
		return $this->Issuperuser;
	}
	public function getUserData()
	{
		return $this->userData;
	}
		/* Added by varalakshmi	on 16-01-13 at 2.45pm to fetch the usercontacts in a variable */
	
	public function getUserContacts()
	{
		return $this->userContacts;
	}
	/**
	 * Returns the Adapter provided by Hybrid_Auth.  See http://hybridauth.sourceforge.net
	 * for details on how to use this
	 * @return Hybrid_Provider_Adapter adapter
	 */
	public function getAdapter() {
		return $this->_adapter;
	}
}