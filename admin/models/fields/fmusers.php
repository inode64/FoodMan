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
 * Field to load a list of all users
 *
 * @since  3.9.0
 */
class JFormFieldFMUsers extends JFormFMFieldList
{
	/**
	 * The form field type.
	 *
	 * @var       string
	 * @since  3.9.0
	 */
	protected $type = 'FMUsers';

	/**
	 * The text for select in filter form
	 *
	 * @var         string
	 * @since  11.1
	 */
	protected $FieldSelectText = 'USER';

	protected function getInput()
	{
		$options = $this->preInput();

		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
			->select($db->quoteName('id'))
			->select($db->quoteName('username', 'name'))
			->from($db->quoteName('#__users'))
			->order($db->quoteName('username'));

		$db->setQuery((string) $query);
		$rows = $db->loadObjectList();

		foreach ($rows as $row)
		{
			$options[] = JHtml::_('select.option', $row->id, $row->name);
		}

		return $this->ShowInput($options);
	}

}
