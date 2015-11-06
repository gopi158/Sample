<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.hybridauth.components.*',
		'application.modules.hybridauth.*',
		'application.modules.hybridauth.controllers.*',
	),

	'modules'=>array(
		'hybridauth' => array(
            'baseUrl' => 'http://'. $_SERVER['SERVER_NAME'] . '/index.php/hybridauth', 
            'withYiiUser' => false, // Set to true if using yii-user  '. $_SERVER['SERVER_NAME'] . '
            "providers" => array ( 
                "openid" => array (
                    "enabled" => false
                ),
 
                "yahoo" => array ( 
                    "enabled" => false, 
                ),
 
                "google" => array ( 
                    "enabled" => false,
                    "keys"    => array ( "id" => "395403559742-fd58t10s35u8pig36rbpv0dn743gvaka.apps.googleusercontent.com", "secret" => "YBhgZG5_1p-SnKZvSkNafBwd" ),
                    "scope"   => ""
                ),
 
                "facebook" => array ( 
                    "enabled" => true,
                    "keys"    => array ( "id" => "136800189829902", "secret" => "0b08898cd6d32b74f9941eaf51d08a38" ),
                    "scope"   => "email,publish_stream,read_friendlists", 
                   // "display" => "" 
                ),
 
                "twitter" => array ( 
                    "enabled" => false,
                    "keys"    => array ( "key" => "MN6GdWkradV9WdKaW9bm1Q", "secret" => "0XfZSND3oaxNLLyOnkZyz9UPofPBHN9fgenFUPm5EP0" ) 
                )
            )
        ),		
		// this is for mailbox integration      
		'mailbox'=>
		    array(  
		    'userClass' => 'User',
		    'userIdColumn' => 'userid',
		    'usernameColumn' =>  'email',
		        
		),
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
	'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
	
		//Start of facebook extension - Rathan added this 
		'facebook'=>array(
	    'class' => 'ext.yii-facebook-opengraph.SFacebook',
	    'appId'=>'450729818350904', // needed for JS SDK, Social Plugins and PHP SDK
	    'secret'=>'4a3659459ae298cfba87939509f068bd',  // needed for the PHP SDK
	    //'fileUpload'=>false, // needed to support API POST requests which send files
	    //'trustForwarded'=>false, // trust HTTP_X_FORWARDED_* headers ?
	    //'locale'=>'en_US', // override locale setting (defaults to en_US)
	    //'jsSdk'=>true, // don't include JS SDK
	    //'async'=>true, // load JS SDK asynchronously
	    //'jsCallback'=>false, // declare if you are going to be inserting any JS callbacks to the async JS SDK loader
	    //'status'=>true, // JS SDK - check login status
	    //'cookie'=>true, // JS SDK - enable cookies to allow the server to access the session
	    //'oauth'=>true,  // JS SDK - enable OAuth 2.0
	    //'xfbml'=>true,  // JS SDK - parse XFBML / html5 Social Plugins
	    //'frictionlessRequests'=>true, // JS SDK - enable frictionless requests for request dialogs
	    //'html5'=>true,  // use html5 Social Plugins instead of XFBML
	    //'ogTags'=>array(  // set default OG tags
	        //'title'=>'MY_WEBSITE_NAME',
	        //'description'=>'MY_WEBSITE_DESCRIPTION',
	        //'image'=>'URL_TO_WEBSITE_LOGO',
	    //),
  ),
	 // End of facebook extension	
	
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		'vidler' => array(
           'user' => 'nageshvenkata',
           'pwd' => 'V1d30Pl@y3r',
           'appkey' => '1mn4s66e3c44f11rx1xd',
          ),
		
		// uncomment the following to enable URLs in path-format
	
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		*/
	/*	'db'=>array(
			'connectionString' => 'mysql:host=parentvalet.db.5263695.hostedresource.com;dbname=parentvalet',
			'emulatePrepare' => true,
			'username' => 'parentvalet',
			'password' => 'P@ssw0rd',
			'charset' => 'utf8',
			'tablePrefix' => 'pv_',
		),*/
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=wincito_finao',
			'emulatePrepare' => true,
			'username' => 'wincito_finao',
			'password' => 'HMa12JqH!1K.',
			'charset' => 'utf8',
			'tablePrefix' => 'fn_',
			'attributes'=>array(
    PDO::MYSQL_ATTR_LOCAL_INFILE
  ),
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	 
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);