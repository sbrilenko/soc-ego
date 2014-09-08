<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Ego network',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
    ),

    'modules'=> array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'root',
        ),
        'admin'=>array(
        ),
        'user' => array(
            'debug' => true,
            'userTable' => 'user',
            'translationTable' => 'translation',
        ),
        'usergroup' => array(
            'usergroupTable' => 'usergroup',
            'usergroupMessageTable' => 'user_group_message',
        ),
        'membership' => array(
            'membershipTable' => 'membership',
            'paymentTable' => 'payment',
        ),
        'friendship' => array(
            'friendshipTable' => 'friendship',
        ),
        'profile' => array(
            'privacySettingTable' => 'privacysetting',
            'profileTable' => 'profile',
            'profileCommentTable' => 'profile_comment',
            'profileVisitTable' => 'profile_visit',
        ),
        'role' => array(
            'roleTable' => 'role',
            'userRoleTable' => 'user_role',
            'actionTable' => 'action',
            'permissionTable' => 'permission',
        ),
        'message' => array(
            'messageTable' => 'message',
        ),
        'locationmanager'=>array(
            'locationmanagerTable' => 'locationmanager',
        ),
        'badgemanager'=>array(
        ),
        'files'=>array(

        ),
        'levellist'=>array(

        ),
        'gamificationmanager'=>array(
            'gamificationmanagerTable' => 'gamificationmanager',
        ),
    ),
    // uncomment the following to enable the Gii tool

//		'gii'=>array(
//			'class'=>'system.gii.GiiModule',
//			'password'=>'admin',
//			// If removed, Gii defaults to localhost only. Edit carefully to taste.
//			'ipFilters'=>array('127.0.0.1','::1'),
//		),



    // application components
    'components'=>array(
        'cache' => array('class' => 'system.caching.CDummyCache'),
        'user'=>array(
            'class' => 'application.modules.user.components.YumWebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('//user/user/login'),
        ),

        // uncomment the following to enable URLs in path-format

        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'caseSensitive'=>false,
            'rules'=>array(
                '/install/default/<action:\w+>'                                   => '/install/default/<action>',
                '/gii/<controller:\w+>/<action:\w+>'                              => 'gii/<controller>/<action>',
                '/<action:\w+>'                                                   => 'site/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),


        // database settings are configured in database.php
        'db'=>require(dirname(__FILE__).'/database.php'),

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
        'adminName'=>'Ego network - administration part',
    ),
);
