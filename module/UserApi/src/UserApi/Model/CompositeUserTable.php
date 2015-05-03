<?php

namespace UserApi\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\Expression;

/**
 * Class CompositeUserTable
 * @package UserApi\Model
 */
class CompositeUserTable extends UserTable
{
	/**
	 * Just returns set of rows
	 *
	 * @return null|\Zend\Db\ResultSet\ResultSetInterface
	 */
	public function fetchAll()
	{
		$result_set = $this->_gateway->selectWith($this->_buildQuery());
		return $result_set;
	}

	/**
	 * Returns user by id
	 *
	 * @param int $id
	 * @return \Zend\Db\ResultSet\ResultSetInterface
	 * @throws \Exception
	 */
	public function getUser($id)
	{
		$query = $this->_buildQuery();
		$query->where(array('users.id' => (int)$id));
		$row = $this->_gateway->selectWith($query);

		if (!$row) {
			throw new \Exception("Could not find row $id");
		}

		return $row;
	}

	/**
	 * Updates the user field and returns count of affected rows
	 *
	 * @param int $id
	 * @param string $grade
	 * @return int
	 */
	public function updateUserGrade($id, $grade)
	{
		$grade_record = $this->_obtainGradeRecord($grade);
		if (empty($grade_record)) {
			return 0;
		}

		$data = array(
			'grades_id' => $grade_record['id'],
		);

		$sql = new Sql($this->_gateway->adapter);
		$update = $sql->update();
		$update->table('users');
		$update->set($data);
		$update->where(array('id' => $id));
		$statement = $sql->prepareStatementForSqlObject($update);

		try {
			$result = $statement->execute();
		} catch (\Exception $e) {
			return 0;
		}

		return $result->count();
	}

	/**
	 * Returns query with essencial joins
	 *
	 * @return Select
	 */
	protected function _buildQuery()
	{
		$sql_select = $this->_gateway->getSql()->select();

		$sql_select->columns(array('id', 'name'))
			->join(array('uc' => 'users_cities'), 'uc.users_id = users.id', Select::SQL_STAR, Select::JOIN_LEFT)
			->join(array('c' => 'cities'), 'uc.cities_id = c.id', array(
					'cities' => new Expression('GROUP_CONCAT(c.title SEPARATOR ", ")')
				), Select::JOIN_LEFT)
			->join(array('g' => 'grades'), 'users.grades_id = g.id', array('grade' => 'title'), Select::JOIN_LEFT)
			->group('users.id');

		return $sql_select;
	}

	/**
	 * Returns grade by it's title
	 *
	 * @param string $grade
	 * @return mixed
	 */
	private function _obtainGradeRecord($grade)
	{
		$sql = new Sql($this->_gateway->adapter);
		$select = $sql->select();
		$select->from('grades');
		$select->where(array('title' => $grade));

		$statement = $sql->prepareStatementForSqlObject($select);
		$results = $statement->execute();

		return $results->current();
	}
}