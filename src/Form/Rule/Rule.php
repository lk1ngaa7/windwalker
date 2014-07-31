<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Form\Rule;

/**
 * The NullRule class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class Rule implements RuleInterface
{
	/**
	 * test
	 *
	 * @param mixed $value
	 *
	 * @return  boolean
	 */
	public function test($value)
	{
		return true;
	}
}
 