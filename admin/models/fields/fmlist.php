<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

defined('JPATH_PLATFORM') or die;

/**
 * Field to load a list of all lists
 *
 * @since  11.1
 */
class JFormFieldFMList extends JFormFMFieldList
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since  11.1
	 */
	protected $type = 'FMList';

	/**
	 * The text for select in filter form
	 *
	 * @var         string
	 * @since  11.1
	 */
	protected $FieldSelectText = 'LIST';

	protected function getInput()
	{

		$options = $this->preInput();

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id', 'name')))
			->from($db->quoteName('#__foodman_lists', 'a'))
			->order($db->quoteName('name'));

		$this->FilterGroup($query);

		$db->setQuery((string) $query);
		$rows = $db->loadObjectList();

		foreach ($rows as $row)
		{
			$options[] = JHtml::_('select.option', $row->id, $row->name);
		}

		return $this->ShowInput($options);
	}
}
