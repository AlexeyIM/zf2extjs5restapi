<?php

namespace UserApi\View;

use Zend\View\Model\JsonModel;
use Traversable;

/**
 * Class JsonViewModel
 * @package UserApi\View
 */
class JsonViewModel extends JsonModel
{
	/**
	 * Constructor
	 *
	 * @param  null|array|Traversable $variables
	 * @param  array|Traversable $options
	 */
	public function __construct($variables = null, $options = null)
	{
		parent::__construct(array('data' => $variables), $options);
	}
}