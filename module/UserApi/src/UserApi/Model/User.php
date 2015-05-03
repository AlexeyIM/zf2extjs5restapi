<?php

namespace UserApi\Model;

/**
 * Class User contains only really existing table columns
 * @package UserApi\Model
 */
class User
{
	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var int
	 */
	public $grades_id;
}