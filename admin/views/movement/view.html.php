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
 * View to edit a movement.
 *
 * @since  1.5
 */
class FoodManViewMovement extends FoodMan\Models\ViewForm
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
		$canDo = JHelperContent::getActions('com_foodman');

		// If not checked out, can save the item.
		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::apply('movement.apply');
			JToolbarHelper::save('movement.save');
		}

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('movement.cancel');
		}
		else
		{
			JToolbarHelper::cancel('movement.cancel', 'JTOOLBAR_CLOSE');
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
		JToolbarHelper::title(JText::_('COM_FOODMAN_MANAGER_MOVEMENT_EDIT'), 'foodman fas fa-boxes');
	}

}
