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
 * FoodMan component helper for table xref.
 *
 * @since  1.6
 */
class FoodManHelperXref
{

	private static function query(string $KeyPrimary, int $primary, ?string $KeySecondary = null, ?int $group = null): object
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
			->where($db->quoteName('KeyPrimary') . ' = ' . $db->quote($KeyPrimary))
			->where($db->quoteName('primary') . ' = ' . $primary);

		if ($KeySecondary !== null)
		{
			$query->where($db->quoteName('KeySecondary') . ' = ' . $db->quote($KeySecondary));
		}
		if ($group !== null)
		{
			$query->where($db->quoteName('groupid') . ' = ' . $group);
		}

		return $query;

	}

	public static function delete(string $KeyPrimary, int $primary, ?string $KeySecondary = null, ?int $group = null): void
	{
		$query = self::query($KeyPrimary, $primary, $KeySecondary, $group);
		$db    = JFactory::getDbo();

		$query->delete($db->quoteName('#__foodman_xref'));

		$db->setQuery($query);
		$db->execute();
	}

	public static function get(string $KeyPrimary, int $primary, string $KeySecondary, ?int $group = null): ?array
	{
		$query = self::query($KeyPrimary, $primary, $KeySecondary, $group);
		$db    = JFactory::getDbo();

		$query->select($db->quoteName('secondary'))
			->from($db->quoteName('#__foodman_xref'));

		$db->setQuery($query);

		return $db->loadColumn();
	}

	public static function update(string $KeyPrimary, int $primary, string $KeySecondary, ?array $items, ?int $group = null): void
	{
		self::delete($KeyPrimary, $primary, $KeySecondary, $group);

		if (!empty($items))
		{
			$db = JFactory::getDbo();

			$object = (object) [
				'KeyPrimary'   => $KeyPrimary,
				'KeySecondary' => $KeySecondary,
				'primary'      => $primary
			];

			if ($group)
			{
				$object->group = $group;
			}

			foreach ($items as $item)
			{
				$object->secondary = $item;
				$db->insertObject('#__foodman_xref', $object);
			}
		}
	}
}
