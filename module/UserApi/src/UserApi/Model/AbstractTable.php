<?php

namespace UserApi\Model;

use Zend\Db\TableGateway\TableGateway;

/**
 * Class AbstractTable
 * @package UserApi\Model
 */
abstract class AbstractTable
{
	/**
	 * @var TableGateway
	 */
	protected $_gateway;

	/**
	 * Init
	 *
	 * @param TableGateway $gateway
	 */
	public function __construct(TableGateway $gateway)
	{
		$this->_gateway = $gateway;
	}

	/**
	 * Returns set of data from db
	 *
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function fetchAll()
	{
		$resultSet = $this->_gateway->select();
		return $resultSet;
	}

	/**
	 * @param int $id
	 * @return array|\ArrayObject|null
	 * @throws \Exception
	 */
	public function getById($id)
	{
		$id = (int)$id;
		$rowset = $this->_gateway->select(array('id' => $id));
		$row = $rowset->current();

		if (!$row) {
			throw new \Exception("Could not find row $id");
		}

		return $row;
	}
}