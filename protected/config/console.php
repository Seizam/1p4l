<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'1p4l Console',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=1p4l',
			'emulatePrepare' => true,
			'username' => '1p4l',
			'password' => '1p4l',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);