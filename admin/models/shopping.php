<?php /** @noinspection ALL */

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
 * Shopping model.
 *
 * @since  1.6
 */
class FoodManModelShopping extends FoodManModelAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var          string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_FOODMAN_SHOPPING';

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
	public function getTable($type = 'Shopping', $prefix = 'FoodManTable', $config = array())
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
	 * @throws Exception
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{

		# TODO: Non support change attribute for subform (setFieldAttribute)

		$app    = JFactory::getApplication();
		$task   = $app->getUserState('com_foodman.edit.shopping.task');
		$layout = $app->getUserState('com_foodman.edit.shopping.layout', TASK_SHOPPING_EDIT);

		if (FoodManHelper::DefaultTask($task) && empty($layout))
		{
			$layout = 'edit';
		}
		// Get the form.
		$form = $this->loadForm('com_foodman.shopping', 'shopping_' . $layout, array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		$form->setFieldAttribute('shopid', 'listid', $this->getState('shopping.id'));

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
		$data = $app->getUserState('com_foodman.edit.shopping.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}
		$this->preprocessData('com_foodman.shopping', $data);

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
					->from('#__foodman_shopping');

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
			$this->setError(JText::_('COM_FOODMAN_SHOPPING_NO_ITEM_SELECTED'));

			return false;
		}

		$table = $this->getTable();

		try
		{
			$db = $this->getDbo();

			$query = $db->getQuery(true);
			$query->update('#__foodman_shopping');
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
	 * @param   array  $list
	 *
	 * @return array
	 *
	 * @since version
	 */
	private function GetFinishItems(array $list): array
	{
		$db      = $this->getDbo();
		$process = array(TYPE_PROCESS_BUY, TYPE_PROCESS_STORE);
		$query   = $db->getQuery(true)
			->select($db->quoteName(array('id', 'quantity', 'proid', 'price', 'bought', 'locid', 'process', 'groupid', 'expiration')))
			->from($db->quoteName('#__foodman_shopping'))
			->where('state = 1')
			->where('process IN (' . implode(',', $process) . ')')
			->where('listid = ' . $list['listid']);

		$db->setQuery($query);

		return $db->loadObjectList();
	}

	/**
	 * @param   array  $rows
	 * @param   array  $data
	 *
	 *
	 * @since version
	 */
	private function UpdateFinishItems(array $rows, array $data, int $shopid, int $listid): void
	{
		$table    = $this->getTable();
		$preserve = array();

		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_foodman/models', 'FoodManModel');
		$stock    = JModelLegacy::getInstance('Stock', 'FoodManModel');
		$movement = JModelLegacy::getInstance('Movement', 'FoodManModel');

		foreach ($data as $row)
		{
			$preserve[$row['id']] = (int) $row['preserve'];
		}

		foreach ($rows as $row)
		{
			$row->shopid = $shopid;
			$row->listid = $listid;

			// Product buy completely
			if ($row->bought >= $row->quantity)
			{
				$table->load($row->id);
				if (!$table->delete($row->id))
				{
					# TODO: Fix workflow in error
					$this->setError($table->getError());
				}

				// Update stock for complete product
				$stockId = $stock->update($row);
				if ($stockId !== false)
				{
					$movement->insert($row, TYPE_MOVEMENT_BUY, $stockId);
				}

				continue;
			}

			if (!$preserve[$row->id])
			{
				// No preserve item for next time
				$table->load($row->id);
				if (!$table->delete($row->id))
				{
					# TODO: Fix workflow in error
					$this->setError($table->getError());
				}
			}
			else
			{
				$object           = new stdClass();
				$object->id       = $row->id;
				$object->quantity = $row->quantity - $row->bought;
				$object->process  = TYPE_PROCESS_CREATE;
				// Reset bought but not reset location for remenber later
				$object->bought = 0;

				$result = JFactory::getDbo()->updateObject('#__foodman_shopping', $object, 'id');
			}

			// Update stock for imcomplete product
			$row->quantity = $row->bought;
			$stockId = $stock->update($row);

			if ($stockId !== false)
			{
				$movement->insert($row, TYPE_MOVEMENT_BUY, $stockId);
			}
		}
	}

	/**
	 * Method to save a item for shopping
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		if (JFactory::getApplication()->getUserState('com_foodman.edit.shopping.task') == TASK_SHOPPING_FINISH)
		{
			$rows = self::GetFinishItems($data);
			self::UpdateFinishItems($rows, $data['products'], $data['shopid'], $data['listid']);

			return true;
		}

		foreach ($data['products'] as $product)
		{
			foreach (array('proid', 'quantity', 'comments', 'locid', 'bought', 'process', 'price', 'id', 'expiration') as $key)
			{
				if (isset($product[$key]))
				{
					$data[$key] = $product[$key];
				}
			}

			//FoodManHelper::DateToSQL($data['expiration']);

			if ($data['process'] == TYPE_PROCESS_CREATE && $data['bought'] > 0)
			{
				$data['process'] = TYPE_PROCESS_BUY;
			}
			if ($data['process'] == TYPE_PROCESS_BUY && !empty($data['locid']))
			{
				$data['process'] = TYPE_PROCESS_STORE;
			}

			// If empty location downgrade to buy
			if (empty($data['locid']))
			{
				$data['process'] = TYPE_PROCESS_BUY;
			}

			// If empty bought downgrade to create
			if (empty($data['bought']))
			{
				$data['process'] = TYPE_PROCESS_CREATE;
			}

			switch ($data['process'])
			{
				case TASK_SHOPPING_CREATE:
					unset($data['locid'], $data['price'], $data['bought']);
					break;

				case TASK_SHOPPING_BUY:
					unset($data['locid']);
					break;
			}

			// Force a create new item to enabled
			if (isset($data['state']) && $data['state'] === null)
			{
				$data['state'] = 1;
			}

			if (!parent::save($data))
			{
				return false;
			}

			$this->checkin(array($data['id']));
		}

		return true;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 *
	 * @throws Exception
	 * @since   3.7.0
	 */
	public function getItem($pk = null)
	{
		$app    = JFactory::getApplication();
		$listid = $app->getUserState('com_foodman.edit.shopping.listid');

		$task = $app->getUserState('com_foodman.edit.shopping.task');

		if (FoodManHelper::DefaultTask($task) && empty($layout))
		{
			$result           = parent::getItem($listid);
			$result->process  = $result->process ?? TYPE_PROCESS_CREATE;
			$result->products = array();
			foreach (array('bought', 'comments', 'price', 'id', 'quantity', 'locid', 'proid', 'process', 'expiration') as $key)
			{
				if (isset($result->$key))
				{
					$result->products[0][$key] = $result->$key;
				}
			}

			return $result;
		}

		$db     = $this->getDbo();
		$layout = $app->getUserState('com_foodman.edit.shopping.layout');

		switch ($layout)
		{
			case TASK_SHOPPING_CREATE:
				$process = array(TYPE_PROCESS_CREATE);
				break;
			case TASK_SHOPPING_BUY:
				$process = array(TYPE_PROCESS_CREATE, TYPE_PROCESS_BUY);
				break;
			case TASK_SHOPPING_STORE:
				$process = array(TYPE_PROCESS_BUY, TYPE_PROCESS_STORE);
				break;
			case TASK_SHOPPING_FINISH:
				$process = array(TYPE_PROCESS_CREATE, TYPE_PROCESS_BUY, TYPE_PROCESS_STORE);
				break;
		}

		# TODO: Perform security get item support by user
		$query = $db->getQuery(true)
			->select($db->quoteName(array('id', 'groupid')))
			->from($db->quoteName('#__foodman_lists'))
			->where('id = ' . (int) $listid);

		$db->setQuery($query);

		try
		{
			$list = $db->loadObject();
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		$query = $db->getQuery(true)
			->select($db->quoteName(array('id', 'quantity', 'comments', 'proid', 'price', 'bought', 'locid', 'process', 'expiration')))
			->from($db->quoteName('#__foodman_shopping'))
			->where('state = 1')
			->where('process IN (' . implode(',', $process) . ')')
			->where('groupid = ' . $list->groupid)
			->where('listid = ' . $list->id);

		if ($layout === TASK_SHOPPING_FINISH)
		{
			$query->where($db->quoteName('quantity') . ' > ' . $db->quoteName('bought'));
		}

		$db->setQuery($query);

		try
		{
			$rows = $db->loadAssocList();
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		// Not exist, create new
		if (!$rows)
		{
			$result          = parent::getItem();
			$result->listid  = $list->id;
			$result->groupid = $list->groupid;

			if ($layout === TASK_SHOPPING_FINISH)
			{
				$result->process = TYPE_PROCESS_FINISH;
			}
			else
			{
				$result->process = TYPE_PROCESS_CREATE;
			}

			return $result;
		}

		// Checkin all items are editing for other users
		foreach ($rows as $key => $row)
		{
			// Amount left to buy
			$rows[$key]['rest'] = $row['quantity'] - $row['bought'];

			# TODO Checkout when create new items from list,
			/*
			if ($key !== 0)
			{
				if (!$this->checkout($row['id']))
				{
					return false;
				}
			}*/
		}

		$result = parent::getItem($rows[0]['id']);

		if ($result && !empty($result->id))
		{
			$result->products = $rows;
		}

		return $result;
	}

}
