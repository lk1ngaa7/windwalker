<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\DataMapper\Compare;

/**
 * Class NeqCompare
 *
 * @since 1.0
 */
class NeqCompare extends StringCompare
{
	/**
	 * Property operator.
	 *
	 * @var  string
	 */
	protected $operator = '!=';
}
