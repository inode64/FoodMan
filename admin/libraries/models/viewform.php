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
	}
}
