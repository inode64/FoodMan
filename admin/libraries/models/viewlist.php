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
 * List view model class.
 *
 * @since  1.6
 */
abstract class ViewList extends AbstractView
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
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Include the component HTML helpers.
		\JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
	}

}
