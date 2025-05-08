<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Anoli Wood',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'Rbac' => [
            'class' => 'caupohelvik\yii2rbac\modules\Rbac',
        ],
    ],
    'controllerMap' => [
        'management' => 'caupohelvik\yii2rbac\modules\controllers\DefaultController',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Fd3Zx7jCrLd9uhzzIheK7ooS2rKKjiPl',
        ],
        'response' => [
            'on beforeSend' => function ($event) {
                $event->sender->headers->add('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            },
        ],
        'cartService' => [
            'class' => 'app\components\CartService',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/vendor/caupohelvik/yii2-rbac/modules/views' => '@app/views/YOUR-WANTED-FOLDERNAME',
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'caupohelvik\yii2rbac\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SendmailTransport',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://aw-anoli-wood:sCoWurephOmenAly@localhost:27017/aw-anoli-wood',
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'cart/add-to-cart' => 'cart/add-to-cart',
                'cart/view-cart' => 'cart/view-cart'
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => [],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => [],
    ];
}

return $config;
