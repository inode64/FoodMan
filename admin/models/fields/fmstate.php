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
 * Field to load a list of all states
 *
 * @since  3.2
 */
class FMStateField extends JFormFMFieldPredefinedList
{
	/**
	 * The form field type.
	 *
	 * @var           string
	 * @since   3.2
	 */
	protected $type = 'FMState';

	/**
	 * Available options
	 *
	 * @var        array
	 * @since  3.2
	 */
	protected $predefinedOptions = array(
		1  => 'JPUBLISHED',
		0  => 'JUNPUBLISHED',
		2  => 'JARCHIVED',
		-2 => 'JTRASHED'
	);
}
