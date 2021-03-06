<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU Lesser General Public License version 2.1 or later.
 */

namespace Windwalker\Model;

/**
 * The DatabaseModelInterface class.
 * 
 * @since  2.0
 */
interface DatabaseModelInterface extends ModelInterface
{
	/**
	 * Get the database driver.
	 *
	 * @return  object  The database driver.
	 */
	public function getDb();

	/**
	 * Set the database driver.
	 *
	 * @param   object  $db  The database driver.
	 *
	 * @return  void
	 */
	public function setDb($db);
}
