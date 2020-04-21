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
 * View to edit a stock.
 *
 * @since  1.5
 */
class FoodManViewStock extends FoodMan\Models\ViewForm
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
		// Since we don't track these assets at the item level
		$canDo = JHelperContent::getActions('com_foodman');

		// If not checked out, can save the item.
		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::apply('stock.apply');
			JToolbarHelper::save('stock.save');

			if ($canDo->get('core.create'))
			{
				JToolbarHelper::save2new('stock.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if (!$this->isNew && $canDo->get('core.create'))
		{
			JToolbarHelper::save2copy('stock.save2copy');
		}

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('stock.cancel');
		}
		else
		{
			JToolbarHelper::cancel('stock.cancel', 'JTOOLBAR_CLOSE');
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
		JToolbarHelper::title($this->isNew ? JText::_('COM_FOODMAN_MANAGER_STOCK_NEW') : JText::_('COM_FOODMAN_MANAGER_STOCK_EDIT'), 'foodman fas fa-boxes');
	}
}
