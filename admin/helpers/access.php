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
 * Class FoodMan helper for Access Level.
 *
 * @since  1.6
 */
class FoodManHelperAccess
{
	/**
	 * Method for check if user can have permission this object or not
	 *
	 * @param   int  $userId  ID of user. If null, use current user.
	 *
	 * @return  int              ID group
	 *
	 * @since  0.1.0
	 */
	public static function getGroup(?int $userId = null): ?int
	{
		$user = $userId ?? JFactory::getUser()->id;

		$group = FoodManHelperXref::getPrimary(XREF_GROUP, $user, XREF_USER);

		return empty($group) ? null : $group[0];
	}

	public static function AccessMenu(array $item, ?int $userId = null): bool
	{
		$user = JFactory::getUser($userId ?? JFactory::getUser()->id);

		return empty($item['access'])|| $user->authorise($item['access'], 'com_foodman');
	}

	public static function canEditAllGroup(int $groupid): bool
	{
		return $groupid !== 0 || JHelperContent::getActions('com_foodman')->get('group.manage');
	}
}
