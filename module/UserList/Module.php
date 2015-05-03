<?php

namespace UserList;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 * @package UserList
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
	/**
	 * Autoloader
	 *
	 * @return array
	 */
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	/**
	 * Includes module config
	 *
	 * @return mixed
	 */
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
}