<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU Lesser General Public License version 2.1 or later.
 */

namespace Windwalker\Filter\Cleaner;

/**
 * Interface FilterRuleInterface
 *
 * @since  2.0
 */
interface CleanerInterface
{
	/**
	 * Method to clean text by rule.
	 *
	 * @param   string  $source  The source to be clean.
	 *
	 * @return  mixed  The cleaned value.
	 */
	public function clean($source);
}
