<?php

namespace UserApi\Model;

/**
 * Class UserTable
 * @package UserApi\Model
 */
class UserTable extends AbstractTable
{
	/**
	 * Returns user by id
	 *
	 * @param int $id
	 * @return array|\ArrayObject|null
	 * @throws \Exception
	 */
	public function getUser($id)
	{
		$id  = (int) $id;
		$rowset = $this->_gateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
}