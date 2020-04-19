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
 * List model.
 *
 * @since  1.6
 */
class FoodManModelList extends JModelAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var          string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_FOODMAN_LIST';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to delete the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canDelete($record)
	{
		if (empty($record->id) || $record->state != -2)
		{
			return false;
		}

		return parent::canDelete($record);
	}

	/**
	 * Method to test whether a record can have its state changed.
	 *
	 * @param   object  $record  A record object.
	 *
	 * @return  boolean  True if allowed to change the state of the record. Defaults to the permission set in the component.
	 *
	 * @since   1.6
	 */
	protected function canEditState($record)
	{
		// Default to component settings if list not known.
		return parent::canEditState($record);
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 *
	 * @since   3.7.0
	 */
	public function getItem($pk = null)
	{
		$result = parent::getItem($pk);

		if ($result && !empty($result->id))
		{
			$result->shops = FoodManHelperXref::get(XREF_LIST, $result->id, XREF_SHOP);
		}

		return $result;
	}

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
	public function getTable($type = 'Lists', $prefix = 'FoodManTable', $config = array())
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
		$form = $this->loadForm('com_foodman.list', 'list', array('control' => 'jform', 'load_data' => $loadData));

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
		$data = $app->getUserState('com_foodman.edit.list.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		$this->preprocessData('com_foodman.list', $data);

		return $data;
	}

	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param   JTable  $table  A record object.
	 *
	 * @return  array  An array of conditions to add to add to ordering queries.
	 *
	 * @since   1.6
	 */
	protected function getReorderConditions($table)
	{
		return array(
			'state >= 0'
		);
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
					->from('#__foodman_lists');

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
			$this->setError(JText::_('COM_FOODMAN_LIST_NO_ITEM_SELECTED'));

			return false;
		}

		$table = $this->getTable();

		try
		{
			$db = $this->getDbo();

			$query = $db->getQuery(true);
			$query->update('#__foodman_lists');
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
	 * Override JModelAdmin::preprocessForm to ensure the correct plugin group is loaded
	 *
	 * @param   JForm   $form   The form object
	 * @param   array   $data   The data to be merged into the form object
	 * @param   string  $group  The plugin group to be executed
	 *
	 * @return  void
	 *
	 * @throws Exception
	 * @since    3.6.1
	 */
	protected function preprocessForm(JForm $form, $data, $group = 'content')
	{
		parent::preprocessForm($form, $data, $group);
	}

	/**
	 * Method to save list
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		if (!parent::save($data))
		{
			return false;
		}

		$item       = $this->getItem();
		$data['id'] = $item->get('id');

		FoodManHelperXref::update(XREF_LIST, $data['id'], XREF_SHOP, $data['shops']);

		return true;
	}

	/**
	 * Method to delete one or more records.
	 *
	 * @param   array  $pks  An array of record primary keys.
	 *
	 * @return  boolean  True if successful, false if an error occurs.
	 *
	 * @since   3.7.0
	 */
	public function delete(&$pks)
	{
		$success = parent::delete($pks);

		if ($success)
		{
			$pks = (array) $pks;
			$pks = ArrayHelper::toInteger($pks);
			$pks = array_filter($pks);

			if (!empty($pks))
			{
				foreach ($pks as $id)
				{
					$this->DeleteShops($id);
					FoodManHelperXref::delete(XREF_LIST, $id);

				}
			}
		}

		return $success;
	}
}
