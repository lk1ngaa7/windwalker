<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2008 - 2014 Asikart.com. All rights reserved.
 * @license    GNU Lesser General Public License version 2.1 or later.
 */

namespace Windwalker\Language\Format;

/**
 * Class IniFormat
 *
 * @since 2.0
 */
class PhpFormat extends AbstractFormat
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = 'php';

	/**
	 * parse
	 *
	 * @param array $array
	 *
	 * @return  array
	 */
	public function parse($array)
	{
		return $this->toOneDimension($array);
	}
}

