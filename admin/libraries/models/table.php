<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * FoodMan table
 *
 * @since  1.5
 */
abstract class FoodManTable extends \Joomla\CMS\Table\Table
{

	public $id;

	/**
	 * Constructor
	 *
	 * @param                    $table
	 * @param                    $key
	 * @param   JDatabaseDriver  $db  Database connector object
	 *
	 * @since   1.5
	 */
	public function __construct($table, $key, &$db)
	{
		parent::__construct($table, $key, $db);

		$this->created = JFactory::getDate()->toSql();
		$this->setColumnAlias('published', 'state');
	}

	/**
	 * Overloaded check function
	 *
	 * @return  boolean
	 *
	 * @see	       JTable::check
	 * @since      1.5
	 */
	public function check()
	{

		// Set name
		if (isset($this->name))
		{
			$this->name = htmlspecialchars_decode($this->name, ENT_QUOTES);
		}

		// Set ordering
		if ($this->state < 0)
		{
			// Set ordering to 0 if state is archived or trashed
			$this->ordering = 0;
		}
		elseif (empty($this->ordering))
		{
			$this->ordering = 0;
		}

		if (empty($this->modified))
		{
			$this->modified = $this->getDbo()->getNullDate();
		}

		return true;
	}

	/**
	 * Overloaded bind function
	 *
	 * @param   mixed  $array   An associative array or object to bind to the JTable instance.
	 * @param   mixed  $ignore  An optional array or space separated list of properties to ignore while binding.
	 *
	 * @return  boolean  True on success
	 *
	 * @since   1.5
	 */
	public function bind($array, $ignore = array())
	{
		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new Registry($array['params']);

			$array['params'] = (string) $registry;
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Method to store a row
	 *
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success, false on failure.
	 */
	public function store($updateNulls = false)
	{
		// Store the new row
		parent::store($updateNulls);

		return count($this->getErrors()) == 0;
	}

}
