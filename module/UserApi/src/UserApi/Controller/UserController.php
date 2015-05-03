<?php

namespace UserApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use UserApi\View\JsonViewModel;

/**
 * Class UserController
 * @package UserApi\Controller
 */
class UserController extends AbstractRestfulController
{
	/**
	 * @var \UserApi\Model\CompositeUserTable
	 */
	protected $_user_table;

	/**
	 * Returns list of resources
	 *
	 * @return JsonViewModel
	 */
	public function getList()
	{
		return new JsonViewModel($this->_getUserTable()->fetchAll()->toArray());
	}

	/**
	 * Returns single resource
	 *
	 * @param int $id
	 * @return JsonViewModel
	 * @throws \Exception
	 */
	public function get($id)
	{
		return new JsonViewModel($this->_getUserTable()->getUser($id)->toArray());
	}

	/**
	 * PUT request handler that updates entity and returns updated result
	 *
	 * @param int $id
	 * @param array $data
	 * @return JsonViewModel
	 */
	public function update($id, $data)
	{
		if (!empty($data['grade'])) {
			$this->_getUserTable()->updateUserGrade($id, $data['grade']);
		}

		return $this->get($id);
	}

	/**
	 * @return \UserApi\Model\CompositeUserTable
	 */
	protected function _getUserTable()
	{
		if (!$this->_user_table) {
			$service_locator = $this->getServiceLocator();
			$this->_user_table = $service_locator->get('UserApi\Model\CompositeUserTable');
		}

		return $this->_user_table;
	}
}