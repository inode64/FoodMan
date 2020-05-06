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
 * Methods supporting a list of stock records.
 *
 * @since  1.6
 */
class FoodManModelStocks extends FoodMan\Models\ModelList
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
				'proid', 'p.name', 'product',
				'locid', 'n.name', 'location',
				'state', 'a.state',
				'quantity', 'a.quantity',
				'expiration', 'a.expiration',
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
	 * @throws Exception
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
				. 'a.state AS state,'
				. 'a.featured AS featured,'
				. 'a.ordering AS ordering,'
				. 'a.groupid,'
				. 'a.quantity,'
				. 'a.expiration,'
				. 'a.checked_out as checked_out,'
				. 'a.checked_out_time as checked_out_time'
			)
		);
		$query->from($db->quoteName('#__foodman_stocks', 'a'));

		$this->GetUsers($query);
		$this->FilterPublished($query);
		$this->FilterGroup($query);
		$this->FilterProduct($query);
		$this->FilterLocation($query);

		// Add filter for registration ranges select list
		$expiration = $this->getState('filter.expiration');

		// Apply the range filter.
		if ($expiration)
		{
			$dates = $this->buildDateRange($expiration);

			$query->where(
				$db->quoteName('a.expiration') . ' >= ' . $db->quote($dates['dStart']->format('Y-m-d H:i:s')) .
				' AND ' . $db->quoteName('a.expiration') . ' <= ' . $db->quote($dates['dEnd']->format('Y-m-d H:i:s'))
			);
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
				$query->where('(g.name LIKE ' . $search . ')');
			}
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'p.name');
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
		$id .= ':' . $this->getState('filter.locid');
		$id .= ':' . $this->getState('filter.proid');

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
	public function getTable($type = 'Stocks', $prefix = 'FoodManTable', $config = array())
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
	protected function populateState($ordering = 'p.name', $direction = 'asc')
	{
		// Load the filter state.
		$this->setState('filter.groupid', $this->getUserStateFromRequest($this->context . '.filter.groupid', 'filter_groupid', '', 'int'));
		$this->setState('filter.locid', $this->getUserStateFromRequest($this->context . '.filter.locid', 'filter_locid', '', 'int'));
		$this->setState('filter.proid', $this->getUserStateFromRequest($this->context . '.filter.proid', 'filter_proid', '', 'int'));

		// List state information.
		parent::populateState($ordering, $direction);
	}

	/**
	 * Construct the date range to filter on.
	 *
	 * @param   string  $range  The textual range to construct the filter for.
	 *
	 * @return array The date range to filter on.
	 *
	 * @throws Exception
	 * @since   3.6.0
	 */
	private function buildDateRange($range)
	{

		$app    = JFactory::getApplication();
		$offset = $app->get('offset');

		// Reset the start time to be the beginning of today, local time.
		$dStart = new JDate('now', $offset);
		$dStart->setTime(0, 0);

		// Now change the timezone back to UTC.
		$tz = new DateTimeZone('GMT');
		$dStart->setTimezone($tz);
		$dEnd = clone $dStart;

		switch ($range)
		{
			case 'last_week':
				$dStart->modify('-7 day');
				$dEnd->modify('-1 day');
				break;

			case 'yesterday':
				$dStart->modify('-1 day');
				$dEnd->modify('-1 day');
				break;

			case 'today':
				break;

			case 'tomorrow':
				$dStart->modify('1 day');
				$dEnd->modify('2 day');
				break;

			case 'this_week':
				$dEnd->modify('7 day');
				break;

			case 'this_1month':
				$dEnd->modify('1 month');
				break;
		}

		return array('dEnd' => $dEnd, 'dStart' => $dStart);
	}

}
