<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
	 'admin' => [
        'class' => 'hail812\adminlte3\Module',
    ],
	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
			'baseUrl' => '/admin',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'errorHandler' => [
				'errorAction' => 'site/error',
			],
		'urlManager' => [
		'enablePrettyUrl' => true,
		'showScriptName' => false,
		'rules' => [
			'' => 'site/index',                                
			'<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
		],
		
	],
    ],
    'params' => $params,
];
