<?php

class DefaultController extends Controller {

	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * Public login action.  It swallows exceptions from Hybrid_Auth. Comment try..catch to bubble exceptions up. 
	 */
	public function actionLogin() {
		
		try {
			//if(isset(Yii::app()->session['login']))
			if (!isset(Yii::app()->session['hybridauth-ref'])) {
				Yii::app()->session['hybridauth-ref'] = Yii::app()->request->urlReferrer;
			}
			$this->_doLogin();
		} catch (Exception $e) {
			Yii::app()->user->setFlash('hybridauth-error', "Something went wrong, did you cancel?");
			$this->redirect(Yii::app()->session['hybridauth-ref'], true);
		}
	}

	/**
	 * Main method to handle login attempts.  If the user passes authentication with their
	 * chosen provider then it displays a form for them to choose their username and email.
	 * The email address they choose is *not* verified.
	 * 
	 * If they are already logged in then it links the new provider to their account
	 * 
	 * @throws Exception if a provider isn't supplied, or it has non-alpha characters
	 */
	private function _doLogin() {
		if (!isset($_GET['provider']))
			throw new Exception("You haven't supplied a provider");

		if (!ctype_alpha($_GET['provider'])) {
			throw new Exception("Invalid characters in provider string");
		}
		//$this->module->getHybridauth()

		$identity = new RemoteUserIdentity($_GET['provider'],$this->module->getHybridauth());
		//$identity = new RemoteUserIdentity($_GET['provider'],Yii::app()->getModule('hybridauth')->getHybridAuth());
		/*print_r($identity);
		exit;*/
		if ($identity->authenticate()) {
			$this->importContacts($identity->loginProvider,$identity->userContacts);
			//echo "hiii--authenticated";
			//exit;
			/* This piece of code is for checking friend is invited or not if exists then add as friend*/
			/*if($identity->loginProvider == "facebook")
			{
				$chckfrnd = InviteFriend::model()->findAllByAttributes(array('invitee_social_network_id'=>$identity->loginProviderIdentifier,'status'=>0));
				if(isset($chckfrnd))
				{
					foreach($chckfrnd as $eachfrnd)
					{
						$eachfrnd->status = 1;
						/*print_r($eachfrnd->status);
						exit;
						$eachfrnd->save(false);
					}
				}
			}*/
			// Check whether the page is from invite friends if it is then render invitefriends page nd to fetch contacts
			/*if (isset(Yii::app()->session['invitefriends']) && Yii::app()->session['invitefriends']['inviteallfriends']=='network-page')
			{
				//echo "invite";
				if($identity->loginProvider == "facebook")
				{
					
					$this->redirect(array("/network/invitefbfriends"));
				}
				else
				{
					$this->importContacts($identity->loginProvider,$identity->userContacts);
				}
				//$this->redirect($this->createUrl('/network/getContacts', array('known_contacts'=>$knownusers,'unknown_contacts'=>$notknownusers)));
				//$this->render('importcontacts',array('known_contacts'=>$knownusers));
			}*/
			// They have authenticated AND we have a user record associated with that provider
			// User is existed in db and registered in yahoo and logged in....
			if (isset(Yii::app()->session['login'])) {
				/*echo "hii---loggeeduser";
				exit;*/
				$this->_loginUser($identity);
			} else {//User is existed in db and registered with yahoo and not logged in then do something...
				//echo "not loggedin--".Yii::app()->user->returnUrl;
				//exit;
				
				//they shouldn't get here because they are already logged in AND have a record for
				// that provider.  Just bounce them on
				$login = array();
				if(isset(Yii::app()->session['login']))
					unset(Yii::app()->session['login']);
				$login["id"] = $identity->userid;
				$login["username"] = $identity->username;
				$login["email"] = $identity->email;
				$login["socialnetworkid"] = $identity->loginProviderIdentifier;
				$login["superuser"] = $identity->Issuperuser;
				$shopusercookie = new CHttpCookie('shop_uname',$identity->email);
	            $shopusercookie->expire = time()+2*604800; 
				$shoppasscookie = new CHttpCookie('shop_upwd',base64_encode($identity->password));
	            $shoppasscookie->expire = time()+2*604800;
				Yii::app()->request->cookies['shop_uname'] = $shopusercookie;
				Yii::app()->request->cookies['shop_upwd'] = $shoppasscookie;
				if($identity->userData == 1)
				{
					$login["userType"] = "parent";
					Yii::app()->session['login'] = $login;
					$this->redirect(array('/'));
				}
				if($identity->userData == 3)
				{
					$login["userType"] = "organization";
					Yii::app()->session['login'] = $login;
					$this->redirect(array('/'));
				}
			}
		} 
		// User not registered with yahoo then this condition works
		else if ($identity->errorCode == RemoteUserIdentity::ERROR_USERNAME_INVALID) {
		
		//Same as above added on 24-01-2013
			/*if($identity->loginProvider == "facebook")
			{
				$chckfrnd = InviteFriend::model()->findAllByAttributes(array('invitee_social_network_id'=>$identity->loginProviderIdentifier,'status'=>0));
				if(isset($chckfrnd))
				{
					foreach($chckfrnd as $eachfrnd)
					{
						$eachfrnd->status = 1;
						/*print_r($eachfrnd->status);
						exit;
						$eachfrnd->save(false);
					}
				}
			}*/
			/*if (isset(Yii::app()->session['invitefriends']) && Yii::app()->session['invitefriends']['inviteallfriends']=='network-page')
			{
				//echo "hiiii--- else";
				//condition added on 19-01-13 for not to fetch or import contacts from facebook
				$identity->userid = Yii::app()->session['login']['id'];
				$this->_linkProvider($identity);
				if($identity->loginProvider == "facebook")
				{
					$this->redirect(array("/network/invitefbfriends"));
				}
				else
				{
					$this->importContacts($identity->loginProvider,$identity->userContacts);
				}
			}*/
			// They have authenticated to their provider but we don't have a matching HaLogin entry
			if (!isset(Yii::app()->session['login'])) {
 				// They aren't logged in => display a form to choose their username & email 
				// (we might not get it from the provider)
				if ($this->module->withYiiUser == true) {
					Yii::import('application.modules.user.models.*');
				} else {
					Yii::import('application.models.*');
				}
				
				$user = new User;
				if(isset(Yii::app()->session['userinfo']))
				{
					$existeduser = User::model()->findByAttributes(array('email'=>Yii::app()->session['userinfo']['email']));
					$model = User::model()->findByAttributes(array('email'=>Yii::app()->session['userinfo']['email'],'status'=>1));
					if($existeduser['email']!='' && isset($model))
					{
						$this->importContacts($identity->loginProvider,$identity->userContacts);
						$identity->userid = $model->userid;
						$this->_linkProvider($identity);
						$login = array();
						if(isset(Yii::app()->session['login']))
							unset(Yii::app()->session['login']);
						$login["id"] = $model->userid;
						$login["username"] = $model->fname.' '.$model->lname;
						$login["email"] = $model->email;
						$login["socialnetworkid"] = $model->socialnetworkid;
						$login["superuser"] = $model->superuser;
						$shopusercookie = new CHttpCookie('shop_uname',$identity->email);
			            $shopusercookie->expire = time()+2*604800; 
						$shoppasscookie = new CHttpCookie('shop_upwd',base64_encode($identity->password));
			            $shoppasscookie->expire = time()+2*604800;
						Yii::app()->request->cookies['shop_uname'] = $shopusercookie;
						Yii::app()->request->cookies['shop_upwd'] = $shoppasscookie;
						if($model->usertypeid == 1)
						{
							$login["userType"] == "parent";
							Yii::app()->session['login'] = $login;
							$this->redirect(array('/site/index'));
						}
						elseif($model->usertypeid == 3)
						{
							$login["userType"] == "organization";
							Yii::app()->session['login'] = $login;
							$this->redirect(array('/organizationActivities/view'));
						}
					}
					else
					{
						
						//$this->redirect(array('/site/fbreg','url'=>'fbreg'));
						$this->redirect(array('/site/index','url'=>'newfbreg'));
					}
					
				}
				else
				{
					$this->redirect(Yii::app()->user->returnUrl);
				}
			} else {
				// They are already logged in, link their user account with new provider
				$identity->userid = Yii::app()->session['login']['id'];
				$this->_linkProvider($identity);
				//$this->redirect(Yii::app()->session['hybridauth-ref']);
				$this->redirect(Yii::app()->user->returnUrl);
				unset(Yii::app()->session['hybridauth-ref']);
			}
		}
	}
	
	private function _linkProvider($identity) {
		$haLogin = new HaLogin();
		$haLogin->loginProviderIdentifier = $identity->loginProviderIdentifier;
		$haLogin->loginProvider = $identity->loginProvider;
		$haLogin->userId = $identity->userid;
		$haLogin->save();
	}
	
	private function _loginUser($identity) {
		/*echo Yii::app()->user->login($identity, 0);
		exit;*/
		Yii::app()->user->login($identity, 0);
		$this->redirect(Yii::app()->user->returnUrl);
	}

	/** 
	 * Action for URL that Hybrid_Auth redirects to when coming back from providers.
	 * Calls Hybrid_Auth to process login. 
	 */
	public function actionCallback() {
		require dirname(__FILE__) . '/../Hybrid/Endpoint.php';
		Hybrid_Endpoint::process();
	}
	
	public function actionUnlink() {
		$login = HaLogin::getLogin(Yii::app()->user->getid(),$_POST['hybridauth-unlinkprovider']);
		$login->delete();
		$this->redirect(Yii::app()->getRequest()->urlReferrer);
	}
		private function importContacts($provider,$contacts)
	{
		//echo $provider;
		$allcontacts = array();
		//$allcontacts = $identity->userContacts;
		$allcontacts = $contacts;
		Yii::app()->session['allcontacts'] = $allcontacts;
		//print_r($allcontacts);
		//echo count($allcontacts);
		$existedemails = array();
		$allemail = User::model()->findAll(array('condition'=>'status = 1 AND usertypeid = 1'));
		$i = 0;
		foreach($allemail as $eachmail)
		{
			$existedemails[$i++] = $eachmail->socialnetworkid;
		}
		$knownusers = array();
		$notknownusers = array();
		//print_r($existedemails);
		for($i=0,$j=0,$k=0;$i<COUNT($allcontacts);$i++){
			//echo "<br>".$allcontacts[$i]->identifier;
			
			if(in_array($allcontacts[$i]->identifier , $existedemails))
			{
				$knownusers[$j++] = $allcontacts[$i]->identifier;
				//echo "<br/>".$knownusers[$j]["identifier"];
				//$knownusers[$j]["email"] = $allcontacts[$i]->email;
				//$knownusers[$j]["displayName"] = $allcontacts[$i]->displayName;
				//$knownusers[$j++]["photoURL"] = $allcontacts[$i]->photoURL;
			}
			else
			{
				/*$notknownusers[$k][$allcontacts[$i]->identifier] = $allcontacts[$i]->identifier;
				$notknownusers[$k][$allcontacts[$i]->email] = $allcontacts[$i]->email;
				$notknownusers[$k][$allcontacts[$i]->displayName] = $allcontacts[$i]->displayName;
				$notknownusers[$k++][$allcontacts[$i]->photoURL] = $allcontacts[$i]->photoURL;*/
				$notknownusers[$k++] = $allcontacts[$i]->identifier;
				//$notknownusers[$k]["email"] = $allcontacts[$i]->email;
				//$notknownusers[$k]["displayName"] = $allcontacts[$i]->displayName;
				//$notknownusers[$k++]["photoURL"] = $allcontacts[$i]->photoURL;
			}
			//echo "<br />";print_r($knownusers);
		}
		//print_r($knownusers);
		//exit;
		if(isset(Yii::app()->session['knownusers']))
			unset(Yii::app()->session['knownusers']);
		Yii::app()->session['knownusers'] = $knownusers;
		if(isset(Yii::app()->session['notknownusers']))
			unset(Yii::app()->session['notknownusers']);
		Yii::app()->session['notknownusers'] = $notknownusers;
		//$this->redirect(array('/network/getContacts','source'=>$provider));
	}
}