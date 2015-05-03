<?php

namespace UserApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use UserApi\View\JsonViewModel;

/**
 * Class UserController
 * @package UserApi\Controller
 */
class GradeController extends AbstractRestfulController
{
	/**
	 * @var \UserApi\Model\GradeTable
	 */
	protected $_grade_table;

	/**
	 * Returns the list of items
	 *
	 * @return JsonViewModel
	 */
	public function getList()
	{
		return new JsonViewModel($this->_getGradeTable()->fetchAll()->toArray());
	}

	/**
	 * @return \UserApi\Model\GradeTable
	 */
	protected function _getGradeTable()
	{
		if (!$this->_grade_table) {
			$service_locator = $this->getServiceLocator();
			$this->_grade_table = $service_locator->get('UserApi\Model\GradeTable');
		}
		return $this->_grade_table;
	}
}