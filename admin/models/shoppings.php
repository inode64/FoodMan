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
 * Methods supporting a list of shopping records.
 *
 * @since  1.6
 */
class FoodManModelShoppings extends JModelList
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
				'userid', 'a.userid',
				'listid', 'l.name', 'list_name',
				'proid', 'p.name', 'product_name',
				'state', 'a.state',
				'process', 'a.process',
				'ordering', 'a.ordering',
				'featured', 'a.featured',
				'language', 'a.language',
				'created', 'a.created',
				'u.name', 'user_name',
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
				. 'a.listid AS listid,'
				. 'a.state AS state,'
				. 'a.featured AS featured,'
				. 'a.ordering AS ordering,'
				. 'a.userid,'
				. 'a.language,'
				. 'a.process,'
				. 'a.quantity AS quantity,'
				. 'a.comments AS comments,'
				. 'a.checked_out AS checked_out,'
				. 'a.checked_out_time AS checked_out_time'
			)
		);
		$query->from($db->quoteName('#__foodman_shopping', 'a'));

		// Join over the user
		$query->select($db->quoteName('u.name', 'user_name'))
			->join('LEFT', $db->quoteName('#__users', 'u') . ' ON u.id = a.userid');

		// Join over the list
		$query->select($db->quoteName('t.name', 'list_name'))
			->join('LEFT', $db->quoteName('#__foodman_lists', 't') . ' ON t.id = a.listid');

		// Join over the product
		$query->select($db->quoteName('p.name', 'product_name'))
			->join('LEFT', $db->quoteName('#__foodman_products', 'p') . ' ON p.id = a.proid');

		// Join over the language
		$query->select('l.title AS language_title, l.image AS language_image')
			->join('LEFT', $db->quoteName('#__languages', 'l') . ' ON l.lang_code = a.language');

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

		// Filter by user.
		$userid = $this->getState('filter.userid');

		if (is_numeric($userid))
		{
			$query->where($db->quoteName('a.userid') . ' = ' . (int) $userid);
		}

		// Filter by list
		$listid = $this->getState('filter.listid');

		if (is_numeric($listid))
		{
			$query->where($db->quoteName('a.listid') . ' = ' . (int) $listid);
		}

		// Filter by product
		$proid = $this->getState('filter.proid');

		if (is_numeric($proid))
		{
			$query->where($db->quoteName('a.proid') . ' = ' . (int) $proid);
		}

		// Filter by process
		$process = $this->getState('filter.process');

		if (is_numeric($process))
		{
			$query->where($db->quoteName('a.process') . ' = ' . (int) $process);
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
				$query->where('(t.name LIKE ' . $search . ' OR u.name LIKE ' . $search . ')');
			}
		}

		// Filter on the language.
		if ($language = $this->getState('filter.language'))
		{
			$query->where($db->quoteName('a.language') . ' = ' . $db->quote($language));
		}

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 't.name');
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
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.userid');
		$id .= ':' . $this->getState('filter.listid');
		$id .= ':' . $this->getState('filter.proid');
		$id .= ':' . $this->getState('filter.process');
		$id .= ':' . $this->getState('filter.language');

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
	public function getTable($type = 'Shopping', $prefix = 'FoodManTable', $config = array())
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
	protected function populateState($ordering = 't.name', $direction = 'asc')
	{
		// Load the filter state.
		$this->setState('filter.search', $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search', '', 'string'));
		$this->setState('filter.published', $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '', 'string'));
		$this->setState('filter.userid', $this->getUserStateFromRequest($this->context . '.filter.userid', 'filter_userid', '', 'int'));
		$this->setState('filter.listid', $this->getUserStateFromRequest($this->context . '.filter.listid', 'filter_listid', '', 'int'));
		$this->setState('filter.proid', $this->getUserStateFromRequest($this->context . '.filter.proid', 'filter_proid', '', 'int'));
		$this->setState('filter.process', $this->getUserStateFromRequest($this->context . '.filter.process', 'filter_process', '', 'int'));
		$this->setState('filter.language', $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '', 'string'));

		// Load the parameters.
		$this->setState('params', JComponentHelper::getParams('com_foodman'));

		// List state information.
		parent::populateState($ordering, $direction);
	}
}
