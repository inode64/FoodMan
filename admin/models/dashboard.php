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

jimport('joomla.application.component.model');

/**
 * DashBoard model.
 *
 * @since  1.6
 */
class FoodManModelDashBoard extends JModelLegacy
{
	/**
	 * Get number of items for given states of a table
	 *
	 * @param   string  $tablename  Name of the table
	 * @param   array   $map        Maps state name to state number
	 *
	 * @return stdClass
	 */
	protected function getStateData($tablename, &$map = null)
	{
		$db = JFactory::getDbo();

		if ($map == null)
		{
			$map = array('published' => 1, 'unpublished' => 0, 'archived' => 2, 'trashed' => -2);
		}

		// Get nr of all states of events
		$query = $db->getQuery(true);
		$query->select(array('state', 'COUNT(state) as num'));
		$query->from($db->quoteName($tablename));
		$query->group('state');

		$db->setQuery($query);
		$result = $db->loadObjectList('state');

		$data        = new stdClass();
		$data->total = 0;

		foreach ($map as $key => $value)
		{
			if ($result)
			{
				// Check whether we have the current state in the DB result
				if (array_key_exists($value, $result))
				{
					$data->$key  = $result[$value]->num;
					$data->total += $data->$key;
				}
				else
				{
					$data->$key = 0;
				}
			}
			else
			{
				$data->$key = 0;
			}
		}

		return $data;
	}

	/**
	 * Returns number of events for all possible states
	 *
	 * @return array
	 */
	public function getAllStats(): array
	{
		$stats = array();
		foreach (FOODMAN_TABLES_PRIMARY as $table => $title)
		{
			$stats[$title] = $this->getStateData($table);
		}

		return $stats;
	}
}


