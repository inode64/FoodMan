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

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('list');

/**
 * Field to load a list of all users that have logged actions
 *
 * @since  3.9.0
 */
class JFormFieldFMUsers extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var	   string
	 * @since  3.9.0
	 */
	protected $type = 'FMUsers';

	/**
	 * The accepted user list.
	 *
	 * @var		 mixed
	 * @since  3.2
	 */
	protected $special = true;

	/**
	 * Cached array of the category items.
	 *
	 * @var	   array
	 * @since  3.9.0
	 */
	protected static $options = array();

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to get the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   3.2
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'special':
				return $this->$name;
				break;
		}

		return parent::__get($name);
	}

	/**
	 * Method to set certain otherwise inaccessible properties of the form field object.
	 *
	 * @param   string  $name   The property name for which to set the value.
	 * @param   mixed   $value  The value of the property.
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	public function __set($name, $value)
	{
		switch ($name)
		{
			case 'special':
				$this->$name = (bool) $value;
				break;

			default:
				parent::__set($name, $value);
		}
	}

	/**
	 * Method to get the options to populate list
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   3.9.0
	 */
	protected function getOptions()
	{
		// Accepted modifiers
		$hash = md5($this->element);

		if (!isset(static::$options[$hash]))
		{
			static::$options[$hash] = parent::getOptions();

			$db = Factory::getDbo();

			// Construct the query
			$query = $db->getQuery(true)
				->select($db->quoteName('u.id', 'value'))
				->select($db->quoteName('u.username', 'text'))
				->from($db->quoteName('#__users', 'u'))
				->order($db->quoteName('u.username'));

			// Setup the query
			$db->setQuery($query);

			// Return the result
			$options = $db->loadObjectList();
			$special = array();
			if ($this->special)
			{
				$special = array(array('value' => 0, 'text' => JText::_('COM_FOODMAN_CONTENT_ALL_USERS')));
			}

			static::$options[$hash] = array_merge(static::$options[$hash], $special, $options);
		}

		return static::$options[$hash];
	}

	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   SimpleXMLElement  $element	The SimpleXMLElement object representing the `<field>` tag for the form field object.
	 * @param   mixed	      $value	The form field value to validate.
	 * @param   string	      $group	The field name group control value. This acts as an array container for the field.
	 *					For example if the field has name="foo" and the group value is set to "bar" then the
	 *					full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @see		  JFormField::setup()
	 * @since	  3.2
	 */
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);

		if ($return)
		{
			if (isset($this->element['special']))
			{
				if (defined($this->element['special']))
				{
					$this->user = (bool) constant($this->element['special']);
				}
				else
				{
					$this->user = (bool) $this->element['special'];
				}
			}

		}

		return $return;
	}

}
