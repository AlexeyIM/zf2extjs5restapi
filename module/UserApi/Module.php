<?php

namespace UserApi;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use UserApi\Model as UAModel;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;

/**
 * Class Module
 * @package UserApi
 */
class Module
{
	/**
	 * Bind some error events
	 *
	 * @param MvcEvent $exception
	 */
	public function onBootstrap(MvcEvent $exception)
	{
		$eventManager        = $exception->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), 0);
		$eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onRenderError'), 0);
	}

	/**
	 * @param MvcEvent $exception
	 * @return void|JsonModel
	 */
	public function onDispatchError($exception)
	{
		return $this->_getJsonModelError($exception);
	}

	/**
	 * @param MvcEvent $exception
	 * @return void|JsonModel
	 */
	public function onRenderError($exception)
	{
		return $this->_getJsonModelError($exception);
	}

	/**
	 * @param MvcEvent $exception
	 * @return void|JsonModel
	 */
	public function _getJsonModelError($exception)
	{
		$error = $exception->getError();
		if (!$error) {
			return;
		}

		$exception_param = $exception->getParam('exception');
		$error_details = array();
		if ($exception_param) {
			$error_details = array(
				'class'      => get_class($exception_param),
				'file'       => $exception_param->getFile(),
				'line'       => $exception_param->getLine(),
				'message'    => $exception_param->getMessage(),
				'stacktrace' => $exception_param->getTraceAsString()
			);
		}

		$result = array(
			'message'   => 'An error occurred during execution; please try again later.',
			'error'     => $error,
			'exception' => $error_details,
		);
		if ($error == 'error-router-no-match') {
			$result['message'] = 'Resource not found.';
		}

		$model = new JsonModel(array('errors' => array($result)));
		$exception->setResult($model);

		return $model;
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
	 * Sort of DI Container
	 *
	 * @return array
	 */
	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'UserApi\Model\CompositeUserTable' =>  function($service_locator) {
					$tableGateway = $service_locator->get('CompositeUserTableGateway');
					$table = new UAModel\CompositeUserTable($tableGateway);
					return $table;
				},
				'CompositeUserTableGateway' => function ($service_locator) {
					$dbAdapter = $service_locator->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new HydratingResultSet();
					$resultSetPrototype->setObjectPrototype(new UAModel\CompositeUser());
					$resultSetPrototype->setHydrator(new ReflectionHydrator());
					return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
				},
				'UserApi\Model\GradeTable' =>  function($service_locator) {
					$tableGateway = $service_locator->get('GradeTableGateway');
					$table = new UAModel\GradeTable($tableGateway);
					return $table;
				},
				'GradeTableGateway' => function ($service_locator) {
					$dbAdapter = $service_locator->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new HydratingResultSet();
					$resultSetPrototype->setObjectPrototype(new UAModel\Grade());
					$resultSetPrototype->setHydrator(new ReflectionHydrator());
					return new TableGateway('grades', $dbAdapter, null, $resultSetPrototype);
				},
			),
		);
	}
}