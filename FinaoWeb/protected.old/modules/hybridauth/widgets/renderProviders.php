<?php

class renderProviders extends CWidget {

	public $config;
	private $_assetsUrl;
	//Added by varam on 08-01-13 at 5.40pm to get only facebook icon for registering at friends page
	public $invitefrnd;
	public $Isfb;
	
	public function init() {
		// this method is called by CController::beginWidget()
		$this->config = Yii::app()->getModule('hybridauth')->getConfig();
		$this->_assetsUrl = Yii::app()->getModule('hybridauth')->getAssetsUrl();
	}

	public function run() {
		
		// this method is called by CController::endWidget()
		$cs = Yii::app()->getClientScript();
		
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
		$cs->registerCssFile($cs->getCoreScriptUrl(). '/jui/css/base/jquery-ui.css'); 
		$cs->registerScriptFile($this->_assetsUrl . '/script.js');
		$cs->registerCssFile($this->_assetsUrl . '/styles.css');
		if(isset($this->invitefrnd))
		{
			if($this->invitefrnd=="facebook")
			{
				$providers = "facebook";
				$this->Isfb = "facebook";
				//print_r($providers);
				//exit;
			}
			elseif($this->invitefrnd=="all")
			{
				//echo "hiii";
				//$providers = $this->config['providers'];
				$providers = "google";
				$this->Isfb = "all";
				$invitefriends = array();
				if (isset(Yii::app()->session['invitefriends']))
					unset(Yii::app()->session['invitefriends']);
				$invitefriends["inviteallfriends"] = "network-page";
				Yii::app()->session['invitefriends'] = $invitefriends;
				/*foreach ($providers as &$provider) {
					$provider['active']=false;
				}
					if (isset(Yii::app()->session['login'])) {
				//echo "hiii--".Yii::app()->session['login']['id']."--no id";
				foreach (HaLogin::getLogins(Yii::app()->session['login']['id']) as $login) {
					$providers[$login->loginProvider]['active']=true;
				}
			}*/
			}
		}
		else
		{
			/*if(isset(Yii::app()->session['userinfo']))
				unset(Yii::app()->session['userinfo']);*/
			$providers = $this->config['providers'];
			$this->Isfb = "no";
			foreach ($providers as &$provider) {
				$provider['active']=false;
			}
				if (isset(Yii::app()->session['login'])) {
			//echo "hiii--".Yii::app()->session['login']['id']."--no id";
			foreach (HaLogin::getLogins(Yii::app()->session['login']['id']) as $login) {
				$providers[$login->loginProvider]['active']=true;
			}
		}
		}
		
		
	
		$this->render('providers', array(
			'baseUrl'=>$this->config['baseUrl'],
			'providers' => $providers,
			'assetsUrl' =>  $this->_assetsUrl,
			'isFb' => $this->Isfb,
		));

	}
}