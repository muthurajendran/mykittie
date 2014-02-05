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
        'application.extensions.PasswordHash',
        'application.extensions.EUploadedImage',
        'application.extensions.S3',
        'application.vendor.AWS.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
	
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'muthu',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	
	),

	'theme' => 'abound',
	// application components
	'components'=>array(
		'user'=>array(
            'class'=>'application.components.EWebUser',
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'/' => 'content/admin',
				'login' => 'site/login',
				'gii' => 'gii',
                'gii/<controller:\w+>' => 'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'iwi' => array(
            'class' => 'application.extensions.iwi.IwiComponent',
            // GD or ImageMagick
            'driver' => 'GD',
        ),
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'connectionString' => 'mysql:host=mydbtastery.cruad6p5de5i.us-east-1.rds.amazonaws.com;dbname=wpplugin',
			'emulatePrepare' => true,
			'username' => 'tastery',
			'password' => 'tastery123',
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
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

		'widgetFactory'=>array(
            'widgets'=>array(
                'CGridView'=>array(
					'itemsCssClass'=>'table table-striped table-bordered table-hover',
					//'pagerCssClass'=>'pager-class'
                ),
                'CJuiTabs'=>array(
                    'htmlOptions'=>array('class'=>'shadowtabs'),
                ),
                'CJuiAccordion'=>array(
                    'htmlOptions'=>array('class'=>'shadowaccordion'),
                ),
                'CJuiProgressBar'=>array(
                   'htmlOptions'=>array('class'=>'shadowprogressbar'),
                ),
                'CJuiSlider'=>array(
                    'htmlOptions'=>array('class'=>'shadowslider'),
                ),
                'CJuiSliderInput'=>array(
                    'htmlOptions'=>array('class'=>'shadowslider'),
                ),
                'CJuiButton'=>array(
                    'htmlOptions'=>array('class'=>'shadowbutton'),
                ),
                'CJuiButton'=>array(
                    'htmlOptions'=>array('class'=>'shadowbutton'),
                ),
                'CJuiButton'=>array(
                    'htmlOptions'=>array('class'=>'button green'),
                ),
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