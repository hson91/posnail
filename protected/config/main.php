<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'POSnail',
	'sourceLanguage'=>'en',
    'language'=>'en',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'son91!@#',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin'=>array(
            'defaultController' => 'site',
        ),
	),

	// application components
	'components'=>array(
        'assetManager' => array(
            'linkAssets' => false,
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
        'db'=>array(
			'connectionString'=>'mysql:host=localhost;dbname=posnail',
			'emulatePrepare'=>true,
			'username'=>'root',
			'password'=>'',
			'charset'=>'utf8',
            'tablePrefix'=>'',
		),
        'mail' => array(
            'class' => 'ext.yiimail.YiiMail',
            'transportType'=>'smtp',
            'transportOptions'=>array(
               'host'=>'smtp.gmail.com',
                'username'=>'feedback.posnail@gmail.com',
                'password'=>'posnail@#$hlt',
                'port'=>'465',
                'encryption'=> 'ssl',
             ),
            'logging' => true,
            'dryRun' => false,
        ),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'authitem',
            'itemChildTable'=>'authitemchild',
            'assignmentTable'=>'authassignment',
        ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
			'rules'=>array(
                ''=>array('site/index','urlSuffix'=>'html'),
                'passwordReset/<alias:.+>' => 'admin/site/passwordReset',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<alias:[a-zA-Z0-9\_\-.]+>'=>'<controller>/index',
				'<module:\w+>'=>'<module>',
				'<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<alias:[a-zA-Z0-9\_\-.]+>'=>'<module>/<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
			),
		),
        
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
        'phpThumb'=>array(
            'class'=>'ext.PhpThumb.EPhpThumb',
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
        /*
        'cache'  => array(
            'class'=>'system.caching.CFileCache',
        ),
        */
	),
	'params'=>require_once('params.php'),
);