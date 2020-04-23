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

$item = $displayData;

if ($item->userid == 0)
{
	echo JText::_('COM_FOODMAN_CONTENT_ALL_USERS');
}
else
{
	echo $this->escape($item->user_name);
}
