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
		

		$identity = new RemoteUserIdentity($_GET['provider'],$this->module->getHybridauth());
		/*print_r($identity);
		exit;*/
		if ($identity->authenticate()) {
			//echo "hiii--authenticated";
			//exit;
			// They have authenticated AND we have a user record associated with that provider
			// User is existed in db and registered in yahoo and logged in....
			if (isset(Yii::app()->session['login'])) {
				/*echo "hii---loggeeduser";
				exit;*/
				$this->_loginUser($identity);
			} else {//User is existed in db and registered with yahoo and not logged in then do something...
				//echo "not loggedin--".Yii::app()->user->returnUrl;
				//print_r($identity);
				//exit;
				$login = array();
				if(isset(Yii::app()->session['login']))
					unset(Yii::app()->session['login']);
				$login["id"] = $identity->userid;
				$login["username"] = $identity->username;
				$login["socialnetworkid"] = $identity->loginProviderIdentifier;
				if($identity->userData == 1)
				{
					$login["userType"] = "parent";
					Yii::app()->session['login'] = $login;
					$this->redirect(array('/educationalPlan/educationalPlans'));
				}
				if($identity->userData == 3)
				{
					$login["userType"] = "organization";
					Yii::app()->session['login'] = $login;
					$this->redirect(array('/organizationActivities/view'));
				}
					
				//they shouldn't get here because they are already logged in AND have a record for
				// that provider.  Just bounce them on
				//$this->redirect(Yii::app()->user->returnUrl);
			}
		} 
		// User not registered with yahoo then this condition works
		else if ($identity->errorCode == RemoteUserIdentity::ERROR_USERNAME_INVALID) {
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
					
					
					$this->redirect(array('/site/fbreg','url'=>'fbreg'));
				}
				//print_r(Yii::app()->session['userinfo']);
				//print_r("hiiii");
				//exit;
			/*	if (isset($_POST['User'])) {
					//Save the form
					$user->attributes = $_POST['User'];

					if ($user->validate() && $user->save()) {
						if ($this->module->withYiiUser == true) {
							$profile = new Profile();
							$profile->first_name='firstname';
							$profile->last_name='lastname';
							$profile->user_id=$user->id;
							$profile->save();
						}
						
						$identity->id = $user->id;
						$identity->username = $user->username;
						$this->_linkProvider($identity);
						$this->_loginUser($identity);
					} // } else { do nothing } => the form will get redisplayed
				} else {
					//Display the form with some entries prefilled if we have the info.
					if (isset($identity->userData->email)) {
						$user->email = $identity->userData->email;
						$email = explode('@', $user->email);
						$user->username = $email[0];
					}
				}*/

				
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
}