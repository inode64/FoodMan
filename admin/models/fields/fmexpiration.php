<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

namespace Joomla\CMS\Form\Field;

defined('JPATH_PLATFORM') or die;

/**
 * Registration Date Range field.
 *
 * @since  3.2
 */
class FMExpirationField extends JFormFMFieldPredefinedList
{
	/**
	 * The form field type.
	 *
	 * @var           string
	 * @since   3.2
	 */
	protected $type = 'FMExpiration';

	/**
	 * Available options
	 *
	 * @var        array
	 * @since  3.2
	 */
	protected $predefinedOptions = array(
		'last_week'   => 'COM_FOODMAN_OPTION_RANGE_LAST_WEEK',
		'yesterday'   => 'COM_FOODMAN_OPTION_RANGE_YESTERDAY',
		'today'       => 'COM_FOODMAN_OPTION_RANGE_TODAY',
		'tomorrow'    => 'COM_FOODMAN_OPTION_RANGE_TOMORROW',
		'this_week'   => 'COM_FOODMAN_OPTION_RANGE_THIS_WEEK',
		'this_1month' => 'COM_FOODMAN_OPTION_RANGE_THIS_1MONTH'
	);
}
