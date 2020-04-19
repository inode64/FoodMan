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
 * Field to load a list of all shops
 *
 * @since  11.1
 */
class JFormFieldFMShop extends JFormFMFieldList
{
	/**
	 * The form field type.
	 *
	 * @var         string
	 * @since  11.1
	 */
	protected $type = 'FMShop';

	/**
	 * The text for select in filter form
	 *
	 * @var         string
	 * @since  11.1
	 */
	protected $FieldSelectText = 'SHOP';

	protected function getInput()
	{

		$options = $this->preInput();

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id', 'name')))
			->from($db->quoteName('#__foodman_shops'))
			->where($db->quoteName('language') . ' IN (' . $db->quote($this->lang) . ',' . $db->quote('*') . ')')
			->order($db->quoteName('name'));

		$db->setQuery((string) $query);
		$rows = $db->loadObjectList();

		foreach ($rows as $row)
		{
			$options[] = JHtml::_('select.option', $row->id, $row->name);
		}

		return $this->ShowInput($options);
	}

}
