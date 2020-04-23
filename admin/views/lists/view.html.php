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
class FoodManViewLists extends FoodMan\Models\ViewList
{

	/**
	 * The Context
	 *
	 * @var        Context
	 */
	protected $context = 'lists';

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

		JToolbarHelper::addNew('list.add');

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('list.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.published') != 2)
			{
				JToolbarHelper::publish('lists.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('lists.unpublish', 'JTOOLBAR_UNPUBLISH', true);
				JToolbarHelper::custom('lists.featured', 'featured.png', 'featured_f2.png', 'JFEATURE', true);
				JToolbarHelper::custom('lists.unfeatured', 'unfeatured.png', 'featured_f2.png', 'JUNFEATURE', true);
			}

			if ($this->state->get('filter.published') != -2)
			{
				if ($this->state->get('filter.published') != 2)
				{
					JToolbarHelper::archiveList('lists.archive');
				}
				elseif ($this->state->get('filter.published') == 2)
				{
					JToolbarHelper::unarchiveList('lists.publish');
				}
			}

			JToolbarHelper::custom('finish.list', 'finish.png', 'finish_h2.png', 'COM_FOODMAN_FINISH_LIST', true);
		}
		if ($canDo->get('core.edit') || JFactory::getUser()->authorise('core.manage', 'com_checkin'))
		{
			JToolBarHelper::checkin('lists.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'lists.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('lists.trash');
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
		JToolbarHelper::title(JText::_('COM_FOODMAN_MANAGER_LISTS'), 'foodman list');
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
			'a.id'       => JText::_('JGRID_HEADING_ID'),
		);
	}
}
