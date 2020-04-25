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

JFormHelper::loadFieldClass('list');

/**
 * Form Field class for the FoodMan Platform.
 * Supports a generic list of options.
 *
 * @since  11.1
 */
abstract class JFormFMFieldList extends JFormFieldList
{
	/**
	 * is used in administrator.
	 *
	 * @var         mixed
	 * @since  3.2
	 */
	protected $admin = false;

	/**
	 * is used in a filter list.
	 *
	 * @var         mixed
	 * @since  3.2
	 */
	protected $filter = false;

	/**
	 * Id GroupId for filter.
	 *
	 * @var         mixed
	 * @since  3.2
	 */
	protected $groupId;

	/**
	 * The accepted lang list.
	 *
	 * @var         mixed
	 * @since  3.2
	 */
	protected $lang;

	/**
	 * Id ListId for filter.
	 *
	 * @var         mixed
	 * @since  3.2
	 */
	protected $listId;

	/**
	 * The accepted user list.
	 *
	 * @var         mixed
	 * @since  3.2
	 */
	protected $user;

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
			case 'admin':
			case 'filter':
			case 'groupid':
			case 'lang':
			case 'listid':
			case 'user':
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
			case 'admin':
			case 'filter':
				$this->$name = (bool) $value;
				break;

			case 'groupid':
			case 'listid':
			case 'user':
				$this->$name = (int) $value;
				break;

			case 'lang':
				$this->$name = (string) $value;
				break;

			default:
				parent::__set($name, $value);
		}
	}

	protected function PreInput(): array
	{

		if (!isset($this->user))
		{
			$this->user = JFactory::getUser()->get('id');
		}
		if (!isset($this->lang))
		{
			$this->lang = JFactory::getLanguage()->getTag();
		}

		// Get the field options.
		return (array) $this->getOptions();

	}

	protected function ShowInput(?array $options): string
	{

		$html = array();
		$attr = '';

		// Initialize some field attributes.
		$attr .= !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$attr .= $this->multiple ? ' multiple' : '';
		$attr .= $this->required ? ' required aria-required="true"' : '';
		$attr .= $this->autofocus ? ' autofocus' : '';

		if ((string) $this->readonly == '1' || (string) $this->readonly == 'true' || (string) $this->disabled == '1' || (string) $this->disabled == 'true')
		{
			$attr .= ' disabled="disabled"';

			// Prevent lost the item when field is readonly
			$html[] = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '"/>';
		}

		// Initialize JavaScript field attributes.
		$attr .= $this->onchange ? ' onchange="' . $this->onchange . '"' : '';

		if ((count($options) > 1 || $this->filter) && !$this->multiple)
		{
			$options[-1] = JHtml::_('select.option', '', JText::_('COM_FOODMAN_SELECT_' . $this->FieldSelectText));
			ksort($options);
		}

		// Create a read-only list (no name) with hidden input(s) to store the value(s).
		if ((string) $this->readonly == '1' || (string) $this->readonly == 'true')
		{
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
		}
		else
			// Create a regular list.
		{
			$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		}

		return implode($html);
	}

	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
	 * @param   mixed             $value    The form field value to validate.
	 * @param   string            $group    The field name group control value. This acts as an array container for the field.
	 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                      full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @see          JFormField::setup()
	 * @since        3.2
	 */
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);

		if ($return)
		{
			if (isset($this->element['admin']))
			{
				if (defined($this->element['admin']))
				{
					$this->admin = (bool) constant($this->element['admin']);
				}
				else
				{
					$this->admin = (bool) $this->element['admin'];
				}
			}

			if (isset($this->element['filter']))
			{
				if (defined($this->element['filter']))
				{
					$this->filter = (bool) constant($this->element['filter']);
				}
				else
				{
					$this->filter = (bool) $this->element['filter'];
				}
			}

			if (isset($this->element['groupid']))
			{
				if (defined($this->element['groupid']))
				{
					$this->groupId = (int) constant($this->element['groupid']);
				}
				else
				{
					$this->groupId = (int) $this->element['groupid'];
				}
			}

			if (isset($this->element['lang']))
			{
				if (defined($this->element['lang']))
				{
					$this->lang = (string) constant($this->element['lang']);
				}
				else
				{
					$this->lang = (string) $this->element['lang'];
				}
			}

			if (isset($this->element['listid']))
			{
				if (defined($this->element['listid']))
				{
					$this->listId = (int) constant($this->element['listid']);
				}
				else
				{
					$this->listId = (int) $this->element['listid'];
				}
			}

			if (isset($this->element['user']))
			{
				if (defined($this->element['user']))
				{
					$this->user = (int) constant($this->element['user']);
				}
				else
				{
					$this->user = (int) $this->element['user'];
				}
			}
		}

		return $return;
	}

	public function FilterLang(object &$query): void
	{
		$db = JFactory::getDbo();

		if ($this->lang !== null)
		{
			$query->where($db->quoteName('a.language') . ' IN (' . $db->quote($this->lang) . ',' . $db->quote('*') . ')');
		}
		else
		{
			if (!\JFactory::getUser()->authorise('core.admin'))
			{
				$query->where($db->quoteName('a.language') . ' IN (' . $db->quote(\JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
			}
		}
	}

	public function FilterGroup(object &$query): void
	{
		$db = JFactory::getDbo();

		if ($this->groupId !== null)
		{
			$query->where($db->quoteName('a.groupid') . ' IN (0, ' . $this->groupId . ')');
		}
		else
		{
			$canDo = \JHelperContent::getActions('com_foodman');

			if (!$canDo->get('group.manage'))
			{
				$query->where($db->quoteName('a.groupid') . ' IN (0, ' . \FoodManHelperAccess::getGroup() . ')');
			}
		}
	}

	public function FilterXref(string $primary, string $secondary, ?int $id, object &$query): void
	{
		if (is_numeric($id))
		{
			$db = JFactory::getDbo();

			$refs = FoodManHelperXref::get($primary, $id, $secondary);
			if (!empty($refs))
			{
				$query->where($db->quoteName('id') . ' IN (' . implode(',', $refs) . ')');
			}
		}
	}
}
