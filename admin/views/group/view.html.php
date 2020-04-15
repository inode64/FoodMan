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

JLoader::register('FoodManHelper', JPATH_ADMINISTRATOR . '/components/com_foodman/helpers/foodman.php');

/**
 * View to edit a group.
 *
 * @since  1.5
 */
class FoodManViewGroup extends JViewLegacy
{
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
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		// Initialize variables.
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		JHtml::_('stylesheet', 'com_foodman/Font-Awesome/fontawesome.min.css', array(), true);
		JHtml::_('stylesheet', 'com_foodman/Font-Awesome/solid.min.css', array(), true);
		JHtml::_('stylesheet', 'com_foodman/foodman.css', array(), true);

		$this->addToolbar();

		return parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @throws Exception
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);

		// Since we don't track these assets at the item level
		$canDo = JHelperContent::getActions('com_foodman');

		JToolbarHelper::title($isNew ? JText::_('COM_FOODMAN_MANAGER_GROUP_NEW') : JText::_('COM_FOODMAN_MANAGER_GROUP_EDIT'), 'foodman fas fa-boxes');

		// If not checked out, can save the item.
		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::apply('group.apply');
			JToolbarHelper::save('group.save');

			if ($canDo->get('core.create'))
			{
				JToolbarHelper::save2new('group.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolbarHelper::save2copy('group.save2copy');
		}

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('group.cancel');
		}
		else
		{
			JToolbarHelper::cancel('group.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
