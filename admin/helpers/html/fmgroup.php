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

JLoader::register('FoodManHelper', JPATH_ADMINISTRATOR . '/components/com_foodman/helpers/foodman.php');

/**
 * JHtmlGroup HTML class.
 *
 * @since  2.5
 */
abstract class JHtmlFMGroup
{
	/**
	 * Show the featured/not-featured icon.
	 *
	 * @param   integer  $value      The featured value.
	 * @param   integer  $i          Id of the item.
	 * @param   boolean  $canChange  Whether the value can be changed or not.
	 *
	 * @return  string    The anchor tag to toggle featured/unfeatured contacts.
	 *
	 * @since   1.6
	 */
	public static function featured($value = 0, $i, $canChange = true)
	{

		// Array of image, task, title, action
		$states = array(
			0 => array('unfeatured', 'groups.featured', 'COM_FOODMAN_GROUP_UNFEATURED', 'JGLOBAL_TOGGLE_FEATURED'),
			1 => array('featured', 'groups.unfeatured', 'COM_FOODMAN_GROUP_FEATURED', 'JGLOBAL_TOGGLE_FEATURED'),
		);
		$state  = ArrayHelper::getValue($states, (int) $value, $states[1]);
		$icon   = $state[0];

		if ($canChange)
		{
			$html = '<a href="#" onclick="return listItemTask(\'cb' . $i . '\',\'' . $state[1] . '\')" class="btn btn-micro hasTooltip'
				. ($value == 1 ? ' active' : '') . '" title="' . JHtml::_('tooltipText', $state[3])
				. '"><span class="icon-' . $icon . '" aria-hidden="true"></span></a>';
		}
		else
		{
			$html = '<a class="btn btn-micro hasTooltip disabled' . ($value == 1 ? ' active' : '') . '" title="'
				. JHtml::_('tooltipText', $state[2]) . '"><span class="icon-' . $icon . '" aria-hidden="true"></span></a>';
		}

		return $html;
	}

}
