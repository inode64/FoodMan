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

use Joomla\CMS\Date\Date;

/**
 * FoodMan component helper.
 *
 * @since  1.6
 */
class FoodManHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public static function addSubmenu($vName): void
	{
		foreach (FOODMAN_SUBMENU as $key => $item)
		{
			if (FoodManHelperAccess::AccessMenu($item))
			{
				JHtmlSidebar::addEntry(
					JText::_($item['title']),
					$item['url'],
					$vName == $key
				);
			}
		}
	}

	public static function manifest(): object
	{
		$LoadXML = file_get_contents(JPATH_ADMINISTRATOR . '/components/com_foodman/foodman.xml');

		return simplexml_load_string($LoadXML);
	}


	public static function DefaultTask(?string $task): bool
	{
		return $task === 'add' || $task === 'edit';
	}

	public static function CountItems(int $id, int $type): ?int
	{
		$db = JFactory::getDBO();

		$query = $db->getQuery(true)
			->select('COUNT(id) AS count')
			->from('#__foodman_shopping')
			->where('state = 1')
			->where('process = ' . $type)
			->where('listid = ' . $id);

		$db->setQuery($query);

		try
		{
			return $db->loadResult();
		}
		catch (RuntimeException $e)
		{
			return 0;
		}
	}

	/**
	 *
	 * Convert Date with locale format to SQL format
	 *
	 * @param   string|null  $string
	 * @param   bool         $tz
	 *
	 * @return string|null
	 *
	 * @since version
	 */
	public static function DateToSQL(?string &$string, bool $tz = false): void
	{
		if (empty($string))
		{
			return;
		}

		$date = new Date($string);

		if ($tz)
		{
			$offset = new \DateTimeZone(Factory::getApplication()->get('offset'));
			$date->setTimezone($offset);
		}

		$string = $date->toSql(true);
	}
}
