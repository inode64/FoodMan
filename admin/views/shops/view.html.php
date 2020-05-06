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
 * View class for a list of foodman.
 *
 * @since  1.6
 */
class FoodManViewShops extends FoodMan\Models\ViewList
{
	/**
	 * The Context
	 *
	 * @var        Context
	 */
	protected $context = 'shops';

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		$canDo = JHelperContent::getActions('com_foodman');
		$user  = JFactory::getUser();

		JToolbarHelper::addNew('shop.add');

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('shop.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.published') != 2)
			{
				JToolbarHelper::publish('shops.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('shops.unpublish', 'JTOOLBAR_UNPUBLISH', true);
				JToolbarHelper::custom('shops.featured', 'featured.png', 'featured_f2.png', 'JFEATURE');
				JToolbarHelper::custom('shops.unfeatured', 'unfeatured.png', 'featured_f2.png', 'JUNFEATURE');
			}

			if ($this->state->get('filter.published') != -2)
			{
				if ($this->state->get('filter.published') != 2)
				{
					JToolbarHelper::archiveList('shops.archive');
				}
				elseif ($this->state->get('filter.published') == 2)
				{
					JToolbarHelper::unarchiveList('shops.publish');
				}
			}
		}
		if ($canDo->get('core.edit') || JFactory::getUser()->authorise('core.manage', 'com_checkin'))
		{
			JToolBarHelper::checkin('shops.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'shops.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('shops.trash');
		}

		if ($user->authorise('core.admin', 'com_foodman') || $user->authorise('core.options', 'com_foodman'))
		{
			JToolbarHelper::preferences('com_foodman');
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
		JToolbarHelper::title(JText::_('COM_FOODMAN_MANAGER_SHOPS'), 'foodman fas fa-store-alt');
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'ordering'   => JText::_('JGRID_HEADING_ORDERING'),
			'a.state'    => JText::_('JSTATUS'),
			'a.name'     => JText::_('COM_FOODMAN_HEADING_NAME'),
			'a.featured' => JText::_('JFEATURED'),
			'g.name'     => JText::_('COM_FOODMAN_HEADING_GROUP'),
			'a.language' => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.id'       => JText::_('JGRID_HEADING_ID'),
		);
	}
}
