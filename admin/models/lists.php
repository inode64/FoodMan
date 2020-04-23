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
 * Methods supporting a list of list records.
 *
 * @since  1.6
 */
class FoodManModelLists extends FoodMan\Models\ModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see           JControllerLegacy
	 * @since         1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'groupid', 'a.groupid',
				'name', 'a.name',
				'state', 'a.state',
				'ordering', 'a.ordering',
				'featured', 'a.featured',
				'created', 'a.created',
				'g.name', 'group_name',
				'published'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  JDatabaseQuery
	 *
	 * @since   1.6
	 */
	protected function getListQuery()
	{
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id AS id,'
				. 'a.name AS name,'
				. 'a.groupid AS groupid,'
				. 'a.state AS state,'
				. 'a.featured AS featured,'
				. 'a.ordering AS ordering,'
				. 'a.groupid,'
				. 'a.checked_out as checked_out,'
				. 'a.checked_out_time as checked_out_time'
			)
		);
		$query->from($db->quoteName('#__foodman_lists', 'a'));

		$this->GetUsers($query);
		$this->FilterPublished($query);
		$this->FilterGroup($query);

		// Filter by search in name
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where($db->quoteName('a.id') . ' = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
				$query->where('(a.name LIKE ' . $search . ' OR g.name LIKE ' . $search . ')');
			}
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'a.name');
		$orderDirn = $this->state->get('list.direction', 'ASC');

		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return  string  A store id.
	 *
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.groupid');

		return parent::getStoreId($id);
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Lists', $prefix = 'FoodManTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function populateState($ordering = 'a.name', $direction = 'asc')
	{
		// Load the filter state.
		$this->setState('filter.groupid', $this->getUserStateFromRequest($this->context . '.filter.groupid', 'filter_groupid', '', 'int'));

		// List state information.
		parent::populateState($ordering, $direction);
	}


	/**
	 * Overrides the getItems method to attach additional metrics to the list.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 *
	 * @since   3.6
	 */
	public function getItems()
	{
		// Get a storage key.
		$store = $this->getStoreId('getItems');

		// Try to load the data from internal storage.
		if (!empty($this->cache[$store]))
		{
			return $this->cache[$store];
		}

		// Load the list items.
		$items = parent::getItems();

		// If empty or an error, just return.
		if (empty($items))
		{
			return array();
		}

		// Get the items in the list.
		$db       = $this->getDbo();
		$itemsIds = ArrayHelper::getColumn($items, 'id');

		$itemsIds = implode(',', $itemsIds);

		// Get the list pending for create count.
		$query = $db->getQuery(true)
			->select('listid, COUNT(id) AS count')
			->from('#__foodman_shopping')
			->where('state = 1')
			->where('process = ' . TYPE_PROCESS_CREATE)
			->where('listid IN (' . $itemsIds . ')')
			->group('listid');

		$db->setQuery($query);

		try
		{
			$count_list_create = $db->loadAssocList('listid', 'count');
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		// Get the list pending for buy count.
		$query->clear('where')
			->where('state = 1')
			->where('process = ' . TYPE_PROCESS_BUY)
			->where('listid IN (' . $itemsIds . ')')
			->group('listid');

		$db->setQuery($query);

		try
		{
			$count_list_buy = $db->loadAssocList('listid', 'count');
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		// Get the list pending for store count.
		$query->clear('where')
			->where('state = 1')
			->where('process = ' . TYPE_PROCESS_STORE)
			->where('listid IN (' . $itemsIds . ')')
			->group('listid');

		$db->setQuery($query);

		try
		{
			$count_list_store = $db->loadAssocList('listid', 'count');
		}
		catch (RuntimeException $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		// Inject the values back into the array.
		foreach ($items as $item)
		{
			$item->count_list_create = $count_list_create[$item->id] ?? 0;
			$item->count_list_buy    = $count_list_buy[$item->id] ?? 0;
			$item->count_list_store  = $count_list_store[$item->id] ?? 0;
		}

		// Add the items to the internal cache.
		$this->cache[$store] = $items;

		return $this->cache[$store];
	}
}
