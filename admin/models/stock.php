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

use Joomla\Utilities\ArrayHelper;

/**
 * Stock model.
 *
 * @since  1.6
 */
class FoodManModelStock extends FoodManModelAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var          string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_FOODMAN_STOCK';

	/**
	 * Returns a JTable object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate. [optional]
	 * @param   string  $prefix  A prefix for the table class name. [optional]
	 * @param   array   $config  Configuration array for model. [optional]
	 *
	 * @return  JTable  A database object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Stocks', $prefix = 'FoodManTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form. [optional]
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not. [optional]
	 *
	 * @return  JForm|boolean  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_foodman.stock', 'stock', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data))
		{
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('state', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('state', 'filter', 'unset');
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @throws Exception
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app  = JFactory::getApplication();
		$data = $app->getUserState('com_foodman.edit.stock.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		$this->preprocessData('com_foodman.stock', $data);

		return $data;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @param   JTable  $table  A JTable object.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		if (empty($table->id))
		{
			// Set the values
			$table->created    = $date->toSql();
			$table->created_by = $user->id;

			// Set ordering to the last item if not set
			if (empty($table->ordering))
			{
				$db    = $this->getDbo();
				$query = $db->getQuery(true)
					->select('MAX(ordering)')
					->from('#__foodman_stocks');

				$db->setQuery($query);
				$max = $db->loadResult();

				$table->ordering = $max + 1;
			}
		}
		else
		{
			// Set the values
			$table->modified    = $date->toSql();
			$table->modified_by = $user->id;
		}
	}

	/**
	 * Method to toggle the featured setting of contacts.
	 *
	 * @param   array    $pks    The ids of the items to toggle.
	 * @param   integer  $value  The value to toggle to.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function featured($pks, $value = 0)
	{
		// Sanitize the ids.
		$pks = ArrayHelper::toInteger((array) $pks);

		if (empty($pks))
		{
			$this->setError(JText::_('COM_FOODMAN_STOCK_NO_ITEM_SELECTED'));

			return false;
		}

		$table = $this->getTable();

		try
		{
			$db = $this->getDbo();

			$query = $db->getQuery(true);
			$query->update('#__foodman_stocks');
			$query->set('featured = ' . (int) $value);
			$query->where('id IN (' . implode(',', $pks) . ')');
			$db->setQuery($query);

			$db->execute();
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		$table->reorder();

		// Clean component's cache
		$this->cleanCache();

		return true;
	}

	/**
	 * Method to save a stock
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		$isNew = ($data['id'] == 0);

		if (!$isNew)
		{
			$item_old = $this->getItem($data['id']);
		}

		if (!parent::save($data))
		{
			return false;
		}

		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_foodman/models', 'FoodManModel');
		$movement = JModelLegacy::getInstance('Movement', 'FoodManModel');

		$stockId = $this->getState('stock.id');

		if ($isNew)
		{
			return $movement->insert((object) $data, TYPE_MOVEMENT_REGULARIZE, $stockId);
		}

		if ($data['locid'] != $item_old->locid)
		{
			return $movement->insert((object) $data, TYPE_MOVEMENT_MOVE, $stockId);
		}

		return true;
	}

	/**
	 * @param   object  $data
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function update(object $data)
	{
		$db    = $this->getDbo();
		$table = $this->getTable();

		$query = $db->getQuery(true)
			->select($db->quoteName(array('id', 'quantity')))
			->from($db->quoteName('#__foodman_stocks'))
			->where('state = 1')
			->where('proid = ' . $data->proid)
			->where('groupid = ' . $data->groupid)
			->where('expiration = ' . $db->quote($data->expiration))
			->where('locid = ' . $data->locid);

		$db->setQuery($query);

		try
		{
			$row = $db->loadAssoc();
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());

			return false;
		}
		if (empty($row['id']))
		{
			$data->id = 0;
		}
		else
		{
			$data->id       = $row['id'];
			$data->quantity += $row['quantity'];
		}

		$data->state = 1;
		$table->bind((array) $data);

		$this->prepareTable($table);

		$result = $table->store($data);

		if ($result)
		{
			// Get ID for insert or update stock
			$this->cleanCache();

			$key = $table->getKeyName();

			return $table->$key;
		}

		return $result;
	}
}
