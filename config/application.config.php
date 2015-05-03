<?php

return array(
	'modules' => array(
		'UserApi',
		'UserList',
	),
	'module_listener_options' => array(
		'module_paths' => array(
			'./module',
			'./vendor',
		),
		// local/global config location when needed
		//'config_glob_paths' => array(
		//    'config/autoload/{,*.}{global,local}.php',
		//),
	),
);