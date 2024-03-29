<?php

// Define a path alias for the Bootstrap extension as it's used internally.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
define('SHORT_BASE_URL', '1p4l.com');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'1p4l',

	// preloading 'log' component
	'preload'=>array('log', 'efontawesome'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.yii-mail.YiiMailMessage',
		'ext.qrcode.QRCodeGenerator',
	),
	
    'theme'=>'bootstrap',

	'modules'=>array(
		// enable the Gii tool
		'gii'=>array(
            'generatorPaths'=>array(
                'bootstrap.gii',
            ),
			'class'=>'system.gii.GiiModule',
			'password'=>'126143',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'WebUser', // extends CWebUser
			'allowAutoLogin'=>true, // enable cookie-based authentication
			'loginUrl' => array('/user/login'),
		),
        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
		// enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'caseSensitive' => false,
			'rules'=>array(
				'static/<view>' => 'site/static',
				'user/<action>' => 'user/<action>',
				'<imprint:\w+>/update' => 'page/update',
				'<imprint:\w+>/customize' => 'imprint/customize',
				'<imprint:\w+>'=>'page/index',
			),
		),
        
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=1p4l',
			'emulatePrepare' => true,
			'username' => '1p4l',
			'password' => '1p4l',
			'charset' => 'utf8',
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
					'logFile'=>'warning.log',
				),
				/* next only while development
				array(
					'class'=>'CWebLogRoute',
					'categories'=>array('apps.*', 'application', 'system.db.*'), // all levels of "apps", "application" and db categories
				),
				array(
					'class'=>'CFileLogRoute',
					'logFile'=>'debug.log',
					'categories'=>array('apps.*', 'application', 'system.db.*'), // all levels of "apps", "application" and db categories
				),*/
                 
			),
		),
		'mail' => array(
			'class' => 'ext.yii-mail.YiiMail',
			'transportType' => 'php',
			'viewPath' => 'application.views.email',
			'logging' => true,
			'dryRun' => false
		),
		 'image' => array(
			'class' => 'application.extensions.image.CImageComponent',
			'driver' => 'ImageMagick', // GD or ImageMagick
			'params' => array('directory' => '/usr/bin'), // ImageMagick setup path
		),
	),
	
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'adminEmail' => 'contact@seizam.com', // this is used in contact page
		'emailFrom' => array( 'contact@seizam.com' => '1P4L' ), // used for email sending
		'admins' => array('clement@seizam.com', 'yann@seizam.com'), //user allowed to admin
	),
);