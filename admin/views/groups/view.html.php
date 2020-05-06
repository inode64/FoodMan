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
class FoodManViewGroups extends FoodMan\Models\ViewList
{
	/**
	 * The Context
	 *
	 * @var        Context
	 */
	protected $context = 'groups';

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		if (!$this->canDo->get('group.manage'))
		{
			throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
		}

		$user  = JFactory::getUser();

		JToolbarHelper::addNew('group.add');

		if ($this->canDo->get('core.edit'))
		{
			JToolbarHelper::editList('group.edit');
		}

		if ($this->canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.published') != 2)
			{
				JToolbarHelper::publish('groups.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('groups.unpublish', 'JTOOLBAR_UNPUBLISH', true);
				JToolbarHelper::custom('groups.featured', 'featured.png', 'featured_f2.png', 'JFEATURE');
				JToolbarHelper::custom('groups.unfeatured', 'unfeatured.png', 'featured_f2.png', 'JUNFEATURE');
			}

			if ($this->state->get('filter.published') != -2)
			{
				if ($this->state->get('filter.published') != 2)
				{
					JToolbarHelper::archiveList('groups.archive');
				}
				elseif ($this->state->get('filter.published') == 2)
				{
					JToolbarHelper::unarchiveList('groups.publish');
				}
			}
		}
		if ($this->canDo->get('core.edit') || JFactory::getUser()->authorise('core.manage', 'com_checkin'))
		{
			JToolBarHelper::checkin('groups.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $this->canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'groups.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($this->canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('groups.trash');
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
		JToolbarHelper::title(JText::_('COM_FOODMAN_MANAGER_GROUPS'), 'foodman group');
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
			'u.name'     => JText::_('COM_FOODMAN_HEADING_USER'),
			'a.language' => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.id'       => JText::_('JGRID_HEADING_ID'),
		);
	}
}
