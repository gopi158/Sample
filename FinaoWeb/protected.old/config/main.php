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
		'application.controllers.*',
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
	
		//Start of facebook extension - Rathan added this Facebook app name is dev.finaonation
		'facebook'=>array(
    	    'class' => 'ext.yii-facebook-opengraph.SFacebook',
	        'appId'=>'424392384305767', // needed for JS SDK, Social Plugins and PHP SDK
	        'secret'=>'5300e3fb7aee9bcb1ce1d9a60abaf725',  // needed for the PHP SDK
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
			'showScriptName'=>false,
			'rules'=>array(
				'home'=>'site/index',
				'myhome'=>'finao/motivationmesg',
				'easyregister'=>'site/EasyRegister',
				'careercatapult-hbcu'=>'finao/hbcupromo',
				'promo'=>'site/promo',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=10.208.142.190;dbname=finaonation',
			'emulatePrepare' => true,
			'username' => 'finao_admin',
			'password' => 'U29yJF5C7noJjKL6',
			'charset' => 'utf8',
			'tablePrefix' => 'fn_',
			'attributes'=>array(
                 PDO::MYSQL_ATTR_LOCAL_INFILE
             ),
		),

        'db2'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=10.208.142.190;dbname=shop',
			'emulatePrepare' => true,
			'username' => 'shop-www',
			'password' => 'cheizeNgaequahngaiquuej0',
			'charset' => 'utf8',
			'tablePrefix' => 'customer_',
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
		'adminEmail'=>'nagesh@finaonation.com',
        'cdnUrl' => 'http://cdn.finaonation.com'
	),
);