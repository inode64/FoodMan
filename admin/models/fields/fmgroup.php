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
 * Form Field class for the Joomla Platform.
 * Supports a generic list of options.
 *
 * @since  11.1
 */
class JFormFieldFMGroup extends JFormFMFieldList
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since  11.1
	 */
	protected $type = 'FMGroup';

	/**
	 * The text for select in filter form
	 *
	 * @var         string
	 * @since  11.1
	 */
	protected $FieldSelectText = 'GROUP';

	/**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   3.7.0
	 */
	protected function getInput()
	{

		$options = $this->preInput();

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id', 'name')))
			->from($db->quoteName('#__foodman_groups'))
			->where($db->quoteName('language') . ' IN (' . $db->quote($this->lang) . ',' . $db->quote('*') . ')')
			->order($db->quoteName('name'));

		$db->setQuery((string) $query);
		$rows = $db->loadObjectList();

		if ($this->admin)
		{
			$options[] = JHtml::_('select.option', 0, JText::_('COM_FOODMAN_CONTENT_ALL_GROUPS'));
		}

		foreach ($rows as $row)
		{
			$options[] = JHtml::_('select.option', $row->id, $row->name);
		}

		return $this->ShowInput($options);

	}
}
