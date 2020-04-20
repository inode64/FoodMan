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

/**
 * Methods supporting a list of movement records.
 *
 * @since  1.6
 */
class FoodManModelMovements extends FoodManModelList
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
				'locid', 'a.locid',
				'listid', 'a.listid',
				'shopid', 'a.shopid',
				'quantity', 'a.quantity',
				'price', 'a.price',
				'state', 'a.state',
				'type', 'a.type',
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
				. 'a.groupid AS groupid,'
				. 'a.quantity AS quantity,'
				. 'a.price AS price,'
				. 'a.state AS state,'
				. 'a.featured AS featured,'
				. 'a.ordering AS ordering,'
				. 'a.type AS type,'
				. 'a.checked_out as checked_out,'
				. 'a.checked_out_time as checked_out_time'
			)
		);
		$query->from($db->quoteName('#__foodman_movements', 'a'));

		// Join over the group
		$query->select($db->quoteName('g.name', 'group_name'))
			->join('LEFT', $db->quoteName('#__foodman_groups', 'g') . ' ON g.id = a.groupid');

		// Join over the product
		$query->select($db->quoteName('p.name', 'product'))
			->join('LEFT', $db->quoteName('#__foodman_products', 'p') . ' ON p.id = a.proid');

		// Join over the list
		$query->select($db->quoteName('li.name', 'list'))
			->join('LEFT', $db->quoteName('#__foodman_lists', 'li') . ' ON li.id = a.listid');

		// Join over the location
		$query->select($db->quoteName('lo.name', 'location'))
			->join('LEFT', $db->quoteName('#__foodman_locations', 'lo') . ' ON lo.id = a.locid');

		// Join over the shop
		$query->select($db->quoteName('s.name', 'shop'))
			->join('LEFT', $db->quoteName('#__foodman_shops', 's') . ' ON s.id = a.shopid');

		// Join with users table to get the username of the person who checked the record out
		$query->select($db->quoteName('u2.username', 'editor'))
			->join('LEFT', $db->quoteName('#__users', 'u2') . ' ON u2.id = a.checked_out');

		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published))
		{
			$query->where($db->quoteName('a.state') . ' = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where($db->quoteName('a.state') . ' IN (0, 1)');
		}

		// Filter by type movement.
		$type = $this->getState('filter.type');

		if (is_numeric($type))
		{
			$query->where($db->quoteName('a.type') . ' = ' . (int) $type);
		}

		// Filter by shop.
		$shopid = $this->getState('filter.shopid');

		if (is_numeric($shopid))
		{
			$query->where($db->quoteName('a.shopid') . ' = ' . (int) $shopid);
		}

		// Filter by list.
		$listid = $this->getState('filter.listid');

		if (is_numeric($listid))
		{
			$query->where($db->quoteName('a.listid') . ' = ' . (int) $listid);
		}

		// Filter by product.
		$proid = $this->getState('filter.proid');

		if (is_numeric($proid))
		{
			$query->where($db->quoteName('a.proid') . ' = ' . (int) $proid);
		}

		// Filter by location.
		$locid = $this->getState('filter.locid');

		if (is_numeric($locid))
		{
			$query->where($db->quoteName('a.locid') . ' = ' . (int) $locid);
		}
		// Filter by group.
		$groupid = $this->getState('filter.groupid');

		if (is_numeric($groupid))
		{
			$query->where($db->quoteName('a.groupid') . ' = ' . (int) $groupid);
		}

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
				$query->where('(a.comments LIKE ' . $search . ' OR g.name LIKE ' . $search . ')');
			}
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'a.proid');
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
		$id .= ':' . $this->getState('filter.type');
		$id .= ':' . $this->getState('filter.listid');
		$id .= ':' . $this->getState('filter.locationid');
		$id .= ':' . $this->getState('filter.shopid');
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
	public function getTable($type = 'Movements', $prefix = 'FoodManTable', $config = array())
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
	protected function populateState($ordering = 'a.proid', $direction = 'asc')
	{
		// Load the filter state.
		$this->setState('filter.groupid', $this->getUserStateFromRequest($this->context . '.filter.groupid', 'filter_groupid', '', 'int'));
		$this->setState('filter.locid', $this->getUserStateFromRequest($this->context . '.filter.locid', 'filter_locid', '', 'int'));
		$this->setState('filter.shopid', $this->getUserStateFromRequest($this->context . '.filter.shopid', 'filter_shopid', '', 'int'));
		$this->setState('filter.listid', $this->getUserStateFromRequest($this->context . '.filter.listid', 'filter_listid', '', 'int'));
		$this->setState('filter.type', $this->getUserStateFromRequest($this->context . '.filter.typeid', 'filter_typeid', '', 'int'));

		// Load the parameters.
		$this->setState('params', JComponentHelper::getParams('com_foodman'));

		// List state information.
		parent::populateState($ordering, $direction);
	}
}
