<?php
/**
 * Part of Windwalker RAD framework package.
 *
 * @author     Simon Asika <asika32764@gmail.com>
 * @copyright  Copyright (C) 2014 Asikart. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Windwalker\Component;

use Windwalker\DI\Container;

/**
 * Class Component
 *
 * @since 2.0
 */
class Component
{
	/**
	 * Property application.
	 *
	 * @var \JApplicationCms
	 */
	protected $application;

	/**
	 * Property container.
	 *
	 * @var \Joomla\DI\Container
	 */
	protected $container;

	/**
	 * Property input.
	 *
	 * @var \JInput
	 */
	protected $input;

	/**
	 * Property name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Property reflection.
	 *
	 * @var \ReflectionClass
	 */
	protected $reflection;

	/**
	 * Constructor.
	 *
	 * @param string           $name
	 * @param \JInput          $input
	 * @param \JApplicationCms $application
	 * @param Container        $container
	 *
	 * @throws \Exception
	 */
	public function __construct($name = null, $input = null, $application = null, $container = null)
	{
		$this->application = $application ?: \JFactory::getApplication();
		$this->input       = $input       ?: $this->application->input;
		$this->name        = $name;

		$this->prepare();

		if (!$this->name)
		{
			$reflection = $this->getReflection();

			$this->name = $reflection->getShortName();

			$this->name = str_replace('Component', '', $this->name);

			if (!$this->name)
			{
				throw new \Exception('Component need name.');
			}
		}

		$this->container = $container   ?: Container::getInstance($this->name);
	}

	/**
	 * execute
	 *
	 * @return void
	 */
	public function execute()
	{
		$this->loadConfiguration();

		$this->init();

		$this->doExecute();
	}

	/**
	 * doExecute
	 *
	 * @return void
	 */
	protected function doExecute()
	{
		$controller = \JControllerLegacy::getInstance($this->name);

		$controller->execute($this->input->get('task'));

		$controller->redirect();
	}

	/**
	 * init
	 *
	 * @return void
	 */
	protected function init()
	{
	}

	/**
	 * prepare
	 *
	 * @return void
	 */
	protected function prepare()
	{
	}

	/**
	 * getContainer
	 *
	 * @return Container
	 */
	public function getContainer()
	{
		return $this->container;
	}

	/**
	 * setContainer
	 *
	 * @param Container $container
	 *
	 * @return Component
	 */
	public function setContainer(Container $container)
	{
		$this->container = $container;

		return $this;
	}

	/**
	 * getApplication
	 *
	 * @return \JApplicationCms
	 */
	public function getApplication()
	{
		return $this->application;
	}

	/**
	 * setApplication
	 *
	 * @param \JApplicationBase $application
	 *
	 * @return $this
	 */
	public function setApplication(\JApplicationBase $application)
	{
		$this->application = $application;

		return $this;
	}

	/**
	 * getInput
	 *
	 * @return \JInput
	 */
	public function getInput()
	{
		return $this->input;
	}

	/**
	 * setInput
	 *
	 * @param \JInput $input
	 *
	 * @return $this
	 */
	public function setInput(\JInput $input)
	{
		$this->input = $input;

		return $this;
	}

	/**
	 * loadConfiguration
	 *
	 * @return void
	 */
	protected function loadConfiguration()
	{
	}

	/**
	 * getReflection
	 *
	 * @return \ReflectionClass
	 */
	public function getReflection()
	{
		if ($this->reflection)
		{
			return $this->reflection;
		}

		$this->reflection = new \ReflectionClass($this);

		return $this->reflection;
	}
}