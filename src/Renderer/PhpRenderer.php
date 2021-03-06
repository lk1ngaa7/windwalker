<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2008 - 2014 Asikart.com. All rights reserved.
 * @license    GNU Lesser General Public License version 2.1 or later.
 */

namespace Windwalker\Renderer;

use Windwalker\Data\Data;

/**
 * Class PhpRenderer
 *
 * @since 2.0
 */
class PhpRenderer extends AbstractRenderer
{
	/**
	 * Property block.
	 *
	 * @var  array
	 */
	protected $block = array();

	/**
	 * Property blockQueue.
	 *
	 * @var  \SplQueue
	 */
	protected $blockQueue = null;

	/**
	 * Property currentBlock.
	 *
	 * @var  string
	 */
	protected $currentBlock = null;

	/**
	 * Property extends.
	 *
	 * @var  string
	 */
	protected $extend = null;

	/**
	 * Property parent.
	 *
	 * @var  PhpRenderer
	 */
	protected $parent = null;

	/**
	 * Property data.
	 *
	 * @var  Data
	 */
	protected $data = null;

	/**
	 * Property file.
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * render
	 *
	 * @param string  $file
	 * @param Data    $data
	 *
	 * @throws  \UnexpectedValueException
	 * @return  string
	 */
	public function render($file, $data = null)
	{
		$this->data = $data = ($data instanceof Data) ? $data : new Data($data);

		$this->prepareData($data);

		$filePath = $this->findFile($file);

		if (!$filePath)
		{
			$paths = array_values(iterator_to_array(clone $this->paths));

			$paths = "\n " . implode(" |\n ", $paths);

			throw new \UnexpectedValueException(sprintf('File: %s not found. Paths in queue: %s', $file, $paths));
		}

		// Start an output buffer.
		ob_start();

		// Load the layout.
		include $filePath;

		// Get the layout contents.
		$output = ob_get_clean();

		// Handler extend
		if (!$this->extend)
		{
			return $output;
		}

		/** @var $parent phpRenderer */
		$parent = new static($this->paths, $this->config);

		foreach ($this->block as $name => $block)
		{
			$parent->setBlock($name, $block);
		}

		$output = $parent->render($this->extend, $data);

		return $output;
	}

	/**
	 * finFile
	 *
	 * @param string $file
	 * @param string $ext
	 *
	 * @return  string
	 */
	public function findFile($file, $ext = 'php')
	{
		return parent::findFile($file, $ext);
	}

	/**
	 * load
	 *
	 * @param string $file
	 * @param array  $data
	 *
	 * @return  string
	 */
	public function load($file, $data = null)
	{
		$data = $this->data->bind(new Data($data));

		$renderer = new static($this->paths, $this->config);

		return $renderer->render($file, $data);
	}

	/**
	 * prepareData
	 *
	 * @param   Data &$data
	 *
	 * @return  void
	 */
	protected function prepareData(&$data)
	{
	}

	/**
	 * getParent
	 *
	 * @return  mixed|null
	 */
	public function parent()
	{
		if (!$this->extend)
		{
			return null;
		}

		if (!$this->parent)
		{
			$this->parent = new static($this->paths);

			$this->parent->render($this->extend, $this->data);
		}

		return $this->parent->getBlock($this->currentBlock);
	}

	/**
	 * extend
	 *
	 * @param string $name
	 *
	 * @return  void
	 *
	 * @throws \LogicException
	 */
	public function extend($name)
	{
		if ($this->extend)
		{
			throw new \LogicException('Please just extend one file.');
		}

		$this->extend = $name;
	}

	/**
	 * getBlock
	 *
	 * @param string $name
	 *
	 * @return  mixed
	 */
	public function getBlock($name)
	{
		return !empty($this->block[$name]) ? $this->block[$name] : null;
	}

	/**
	 * setBlock
	 *
	 * @param string $name
	 * @param string $content
	 *
	 * @return  PhpRenderer  Return self to support chaining.
	 */
	public function setBlock($name, $content = '')
	{
		$this->block[$name] = $content;

		return $this;
	}

	/**
	 * setBlock
	 *
	 * @param  string $name
	 *
	 * @return void
	 */
	public function block($name)
	{
		$this->currentBlock = $name;

		$this->getBlockQueue()->push($name);

		// Start an output buffer.
		ob_start();
	}

	/**
	 * endblock
	 *
	 * @return  void
	 */
	public function endblock()
	{
		$name = $this->getBlockQueue()->pop();

		// If this block name not exists on parent level, we just echo inner content.
		if (!empty($this->block[$name]))
		{
			ob_get_clean();

			echo $this->block[$name];

			return;
		}

		// Get the layout contents.
		echo $this->block[$name] = ob_get_clean();
	}

	/**
	 * getBlockQueue
	 *
	 * @return  \SplQueue
	 */
	public function getBlockQueue()
	{
		if (!$this->blockQueue)
		{
			$this->blockQueue = new \SplStack;
		}

		return $this->blockQueue;
	}

	/**
	 * reset
	 *
	 * @return  static
	 */
	public function reset()
	{
		$this->file   = null;
		$this->extend = null;
		$this->parent = null;
		$this->data   = null;
		$this->block  = array();
		$this->blockQueue   = null;
		$this->currentBlock = null;

		return $this;
	}
}
