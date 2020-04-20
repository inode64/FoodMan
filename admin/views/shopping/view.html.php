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
 * View to edit a shopping.
 *
 * @since  1.5
 */
class FoodManViewShopping extends FoodMan\Models\ViewForm
{

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @throws Exception
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		$app  = JFactory::getApplication();
		$task = $app->getUserState('com_foodman.edit.shopping.task');

		$isNew = ($this->item->id == 0);

		// Since we don't track these assets at the item level
		$canDo = JHelperContent::getActions('com_foodman');

		if ($task === TASK_SHOPPING_FINISH)
		{
			JToolbarHelper::apply('shopping.apply', 'COM_FOODMAN_FINISH_LIST');
		}
		else
		{
			// If not checked out, can save the item.
			if ($canDo->get('core.edit'))
			{
				JToolbarHelper::apply('shopping.apply');
				JToolbarHelper::save('shopping.save');

				if ($canDo->get('core.create') && FoodManHelper::DefaultTask($task))
				{
					JToolbarHelper::save2new('shopping.save2new');
				}
			}

			// If an existing item, can save to a copy.
			if (!$isNew && $canDo->get('core.create') && FoodManHelper::DefaultTask($task))
			{
				JToolbarHelper::save2copy('shopping.save2copy');
			}
		}
		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('shopping.cancel');
		}
		else
		{
			JToolbarHelper::cancel('shopping.cancel', 'JTOOLBAR_CLOSE');
		}
	}

	/**
	 * Add the page title.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addTitle(): void
	{
		$isNew = ($this->item->id == 0);

		JToolbarHelper::title($isNew ? JText::_('COM_FOODMAN_MANAGER_SHOPPING_NEW') : JText::_('COM_FOODMAN_MANAGER_SHOPPING_EDIT'), 'foodman fas fa-boxes');
	}
}
