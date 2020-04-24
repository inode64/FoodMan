<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

namespace FoodMan\Models;

defined('_JEXEC') or die;

/**
 * Form view model class.
 *
 * @since  1.6
 */
abstract class ViewForm extends AbstractView
{
	/**
	 * Do we have to display a sidebar ?
	 *
	 * @var  boolean
	 */
	protected $displaySidebar = false;

	/**
	 * The JForm object
	 *
	 * @var        JForm
	 */
	protected $form;

	/**
	 * The active item
	 *
	 * @var        object
	 */
	protected $item;

	/**
	 * The model state
	 *
	 * @var        object
	 */
	protected $state;

	/**
	 * Is a new item
	 *
	 * @var        object
	 */
	protected $isNew;

	/**
	 * Method for run before display to initial variables.
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return  void
	 *
	 * @since   2.0.6
	 */
	public function beforeDisplay(?string &$tpl): void
	{
		// Initialize variables.
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');

		$this->isNew = ($this->item->id == 0);

		$user = \JFactory::getUser();
		$lang = \JFactory::getLanguage()->getTag();

		// Set default group for a rest of fields
		if ($this->isNew)
		{
			if (!$this->canDo->get('group.manage'))
			{
				$this->item->groupid = \FoodManHelperAccess::getGroup();

				$this->form->setFieldAttribute('groupid', 'default', $this->item->groupid);
			}
		}

		if (!$this->canDo->get('group.manage'))
		{
			$this->form->setFieldAttribute('groupid', 'readonly', 'true');
		}

		if (!$user->authorise('core.admin'))
		{
			$this->item->lang = $lang;

			$this->form->setFieldAttribute('language', 'readonly', 'true');
			$this->form->setFieldAttribute('language', 'default', $this->item->lang);
		}

		if (isset($this->item->groupid))
		{
			$this->form->setFieldAttribute('listid', 'groupid', $this->item->groupid);
			$this->form->setFieldAttribute('shopid', 'groupid', $this->item->groupid);
			$this->form->setFieldAttribute('proid', 'groupid', $this->item->groupid);
			$this->form->setFieldAttribute('locid', 'groupid', $this->item->groupid);
		}

		if (isset($this->item->lang))
		{
			$this->form->setFieldAttribute('listid', 'lang', $this->item->lang);
			$this->form->setFieldAttribute('shopid', 'lang', $this->item->lang);
			$this->form->setFieldAttribute('proid', 'lang', $this->item->lang);
			$this->form->setFieldAttribute('locid', 'lang', $this->item->lang);
		}
	}
}
