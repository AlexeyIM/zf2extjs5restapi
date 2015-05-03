<?php

return array(
	'router' => array(
		'routes' => array(
			'user' => array(
				'type'    => 'segment',
				'options' => array(
					'route'       => '/api/user[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'UserApi\Controller\User',
					),
				),
			),
			'grade' => array(
				'type'    => 'segment',
				'options' => array(
					'route'       => '/api/grade[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'UserApi\Controller\Grade',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'UserApi\Controller\User'  => 'UserApi\Controller\UserController',
			'UserApi\Controller\Grade' => 'UserApi\Controller\GradeController',
		),
	),
	'view_manager' => array(
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
	'db' => array(
		'driver'         => 'Pdo',
		'dsn'            => 'mysql:dbname=userapi;host=localhost',
		'username'       => 'root',
		'password'       => 'root',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
	),
	'service_manager' => array(
		'factories' => array(
			'Zend\Db\Adapter\Adapter'
			=> 'Zend\Db\Adapter\AdapterServiceFactory',
		),
	),
);