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
        'ext.Search.*',
        'application.helpers.*',
        'ext.galleryManager.models.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

	'session' => array (
		'sessionName' => 'stdiamond',
		'class'=>'CHttpSession',
		'useTransparentSessionID' => (isset($_POST['PHPSESSID'])) ? true : false,
		/*'useTransparentSessionID' => ($_POST['PHPSESSID']) ? true : false,*/
		'autoStart' => 'false',
		'cookieMode' => 'only',
		'savePath' => $_SERVER['DOCUMENT_ROOT'].'/tmp',
		'timeout' => 300
	),


		'urlManager'=>array(
			'class'=>'application.components.UrlManager',
			'urlFormat'=>'path',

			'rules'=>array
			(
				'<language:(ua|en)>/' => 'site/index',
				'' => 'site/index',

				'<language:(ua|en)>/<controller:\w+>/' => '<controller>/index',
				'<controller:\w+>/' => '<controller>/index',

				'<language:(ua|en)>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',

				'<language:(ua|en)>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',

				'<language:(ua|en)>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>'
			),
			'showScriptName' => false
		),
		'viewRenderer' => array(
				'class' => 'ext.Twig.ETwigViewRenderer',
				'fileExtension' => '.twig',
				'options' => array(
					'autoescape' => true,
                    'cache' => false,
                    'debug' => true,
				),
				'extensions' => array(
					'YiiTwigExtension',
				),
			),
        'mp' => array(
            'class' => 'application.components.StaticMapper',
        ),
        'image'=>array(
            'class'=>'ext.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            //'params'=>array('directory'=>'D:/Program Files/ImageMagick-6.4.8-Q16'),
        ),
        'statePersister'=>array(
            'class'=>'application.components.DbStatePersister'
        ),
        'CURL' => array(
            'class' => 'application.extensions.curl.Curl',
            'options' => array(
                'timeout' => 0
            )
        ),

		'db'=>array(
			//'class'=>'application.extensions.PHPPDO.CPdoDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=wedding',
			'emulatePrepare' => true,
			'username' => 'wedding',
			'password' => 'x2T4ba77BvT4a2',
			'charset' => 'utf8',
            'schemaCachingDuration' => 300,
            'enableProfiling'=>true,
		),
    'cache'=>array(
        'class'=>'CDbCache',
        'connectionID'=>'db'
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
		'language' => 'ru',
'locales' => array('ua' => 'uk_UA','en' => 'en_GB'),
		//'main_site_url' => 'http://diamond.ua/'
	 'main_site_url' => 'http://diamond.project.test/'
	),
	'sourceLanguage'=>'ru_RU',
	'language'=>'ru_RU',
	
);