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
class FoodManViewProducts extends JViewLegacy
{

	/**
	 * An array of items
	 *
	 * @var        array
	 */
	protected $items;

	/**
	 * The pagination object
	 *
	 * @var        JPagination
	 */
	protected $pagination;

	/**
	 * The model state
	 *
	 * @var        object
	 */
	protected $state;

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @throws Exception
	 * @since   1.6
	 */
	public function display($tpl = null)
	{
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		JHtml::_('stylesheet', 'com_foodman/Font-Awesome/fontawesome.min.css', array(), true);
		JHtml::_('stylesheet', 'com_foodman/Font-Awesome/solid.min.css', array(), true);
		JHtml::_('stylesheet', 'com_foodman/foodman.css', array(), true);

		FoodManHelper::addSubmenu('products');

		$this->addToolbar();

		// Include the component HTML helpers.
		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

		$this->sidebar = JHtmlSidebar::render();

		return parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JLoader::register('FoodManHelper', JPATH_ADMINISTRATOR . '/components/com_foodman/helpers/foodman.php');

		$canDo = JHelperContent::getActions('com_foodman');
		$user  = JFactory::getUser();

		JToolbarHelper::title(JText::_('COM_FOODMAN_MANAGER_PRODUCTS'), 'foodman product');

		JToolbarHelper::addNew('product.add');

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('product.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.published') != 2)
			{
				JToolbarHelper::publish('products.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('products.unpublish', 'JTOOLBAR_UNPUBLISH', true);
				JToolbarHelper::custom('products.featured', 'featured.png', 'featured_f2.png', 'JFEATURE', true);
				JToolbarHelper::custom('products.unfeatured', 'unfeatured.png', 'featured_f2.png', 'JUNFEATURE', true);
			}

			if ($this->state->get('filter.published') != -1)
			{
				if ($this->state->get('filter.published') != 2)
				{
					JToolbarHelper::archiveList('products.archive');
				}
				elseif ($this->state->get('filter.published') == 2)
				{
					JToolbarHelper::unarchiveList('products.publish');
				}
			}
		}
		if ($canDo->get('core.edit') || JFactory::getUser()->authorise('core.manage', 'com_checkin'))
		{
			JToolBarHelper::checkin('products.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'products.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('products.trash');
		}

		if ($user->authorise('core.admin', 'com_foodman') || $user->authorise('core.options', 'com_foodman'))
		{
			JToolbarHelper::preferences('com_foodman');
		}
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
