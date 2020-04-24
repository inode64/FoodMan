<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

namespace FoodMan\Models;

defined('_JEXEC') or die;

/**
 * Stock controller class.
 *
 * @since  1.6
 */
abstract class ModelList extends \Joomla\CMS\MVC\Model\ListModel
{
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

		return parent::getStoreId($id);
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
	protected function populateState($ordering = '', $direction = '')
	{
		// Load the filter state.
		$this->setState('filter.search', $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search', '', 'string'));
		$this->setState('filter.published', $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '', 'string'));

		// Load the parameters.
		$this->setState('params', \JComponentHelper::getParams('com_foodman'));

		// List state information.
		parent::populateState($ordering, $direction);
	}

	/**
	 * Get the filter form
	 *
	 * @param   array    $data      data
	 * @param   boolean  $loadData  load current data
	 *
	 * @return  \JForm|boolean  The \JForm object or false on error
	 *
	 * @since   3.2
	 */
	public function getFilterForm($data = array(), $loadData = true)
	{
		$form = parent::getFilterForm($data, $loadData);

		if ($form)
		{
			if (!\JFactory::getUser()->authorise('group.manage', 'com_foodman'))
			{
				$form->removeField('groupid', 'filter');
			}
			if (!\JFactory::getUser()->authorise('core.admin'))
			{
				$form->removeField('language', 'filter');
			}
		}

		return $form;
	}

	protected function FilterLang(object &$query): void
	{
		$db = $this->getDbo();

		// Join over the language
		$query->select('l.title AS language_title, l.image AS language_image')
			->join('LEFT', $db->quoteName('#__languages', 'l') . ' ON l.lang_code = a.language');

		if (\JFactory::getUser()->authorise('core.admin'))
		{
			// Filter on the language.
			if ($language = $this->getState('filter.language'))
			{
				$query->where($db->quoteName('a.language') . ' = ' . $db->quote($language));
			}
		}
		else
		{
			$query->where($db->quoteName('a.language') . ' IN (' . $db->quote(\JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		}
	}

	protected function FilterPublished(object &$query): void
	{
		$db = $this->getDbo();

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
	}

	protected function FilterGroup(object &$query): void
	{
		$db = $this->getDbo();

		// Join over the group
		$query->select($db->quoteName('g.name', 'group_name'))
			->join('LEFT', $db->quoteName('#__foodman_groups', 'g') . ' ON g.id = a.groupid');

		if (\JHelperContent::getActions('com_foodman')->get('group.manage'))
		{
			// Filter by group.
			$groupid = $this->getState('filter.groupid');

			if (is_numeric($groupid) && !empty($groupid))
			{
				$query->where($db->quoteName('a.groupid') . ' = ' . (int) $groupid);
			}
		}
		else
		{
			$query->where($db->quoteName('a.groupid') . ' IN (0, ' . \FoodManHelperAccess::getGroup() . ')');
		}
	}

	protected function GetUsers(object &$query): void
	{
		$db = $this->getDbo();

		// Join with users table to get the username of the person who checked the record out
		$query->select($db->quoteName('u1.username', 'editor'))
			->join('LEFT', $db->quoteName('#__users', 'u1') . ' ON u1.id = a.checked_out');

		$query->select($db->quoteName('u2.username', 'created'))
			->join('LEFT', $db->quoteName('#__users', 'u2') . ' ON u2.id = a.created_by');

		$query->select($db->quoteName('u3.username', 'modified'))
			->join('LEFT', $db->quoteName('#__users', 'u3') . ' ON u3.id = a.modified_by');
	}

	protected function FilterProduct(object &$query): void
	{
		$db = $this->getDbo();

		// Join over the product
		$query->select($db->quoteName('p.name', 'product_name'))
			->join('LEFT', $db->quoteName('#__foodman_products', 'p') . ' ON p.id = a.proid');

		// Filter by product
		$proid = $this->getState('filter.proid');

		if (is_numeric($proid))
		{
			$query->where($db->quoteName('a.proid') . ' = ' . (int) $proid);
		}
	}

	protected function FilterList(object &$query): void
	{
		$db = $this->getDbo();

		// Join over the list
		$query->select($db->quoteName('t.name', 'list_name'))
			->join('LEFT', $db->quoteName('#__foodman_lists', 't') . ' ON t.id = a.listid');

		// Filter by list
		$listid = $this->getState('filter.listid');

		if (is_numeric($listid))
		{
			$query->where($db->quoteName('a.listid') . ' = ' . (int) $listid);
		}
	}

	protected function FilterProcess(object &$query): void
	{
		$db = $this->getDbo();

		// Filter by process
		$process = $this->getState('filter.process');

		if (is_numeric($process))
		{
			$query->where($db->quoteName('a.process') . ' = ' . (int) $process);
		}
	}

	protected function FilterLocation(object &$query): void
	{
		$db = $this->getDbo();

		// Join over the location
		$query->select($db->quoteName('n.name', 'location'))
			->join('LEFT', $db->quoteName('#__foodman_locations', 'n') . ' ON n.id = a.locid');

		// Filter by location.
		$locid = $this->getState('filter.locid');

		if (is_numeric($locid))
		{
			$query->where($db->quoteName('a.locid') . ' = ' . (int) $locid);
		}
	}

	protected function FilterShop(object &$query): void
	{
		$db = $this->getDbo();

		// Join over the shop
		$query->select($db->quoteName('s.name', 'shop'))
			->join('LEFT', $db->quoteName('#__foodman_shops', 's') . ' ON s.id = a.shopid');

		// Filter by shop.
		$shopid = $this->getState('filter.shopid');

		if (is_numeric($shopid))
		{
			$query->where($db->quoteName('a.shopid') . ' = ' . (int) $shopid);
		}
	}

	protected function FilterMovement(object &$query): void
	{
		$db = $this->getDbo();

		// Filter by type movement.
		$type = $this->getState('filter.type');

		if (is_numeric($type))
		{
			$query->where($db->quoteName('a.type') . ' = ' . (int) $type);
		}
	}
}