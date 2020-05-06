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
 * Base model JViewLegacy class.
 *
 * @since  1.6
 */
abstract class AbstractView extends \Joomla\CMS\MVC\View\HtmlView
{
	/**
	 * Do we have to display a sidebar ?
	 *
	 * @var  boolean
	 */
	protected $displaySidebar = true;

	/**
	 * The Context
	 *
	 * @var        Context
	 */
	protected $context;

	/**
	 * @var  Object
	 */
	public $canDo;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 *
	 * @throws  \Exception
	 */
	public function display($tpl = null)
	{
		$this->generatePermission();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \Exception(implode("\n", $errors), 500);
		}

		\JHtml::_('stylesheet', 'com_foodman/Font-Awesome/fontawesome.min.css', array(), true);
		\JHtml::_('stylesheet', 'com_foodman/Font-Awesome/solid.min.css', array(), true);
		\JHtml::_('stylesheet', 'com_foodman/foodman.css', array(), true);

		// Before display
		$this->beforeDisplay($tpl);

		if ($this->displaySidebar)
		{
			\FoodManHelper::addSubmenu($this->context);
			$this->sidebar = \JHtmlSidebar::render();
		}
		else
		{
			\JFactory::getApplication()->input->set('hidemainmenu', true);
		}

		// Add page title
		$this->addTitle();

		if (\JFactory::getApplication()->isClient('site'))
		{
			// Add page PathWay
			$this->addPathWay();
		}

		// Add toolbar
		$this->addToolbar();

		return parent::display($tpl);
	}

	/**
	 * Method for generate permission.
	 * @todo Select correct view an include levels (create, view, edit, delete, etc..)
	 *
	 * @return  void
	 *
	 * @since   0.1.0
	 */
	protected function generatePermission(): void
	{
		$this->canDo = \JHelperContent::getActions('com_foodman');
	}

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
		\JToolbarHelper::title($this->getTitle());
	}

	/**
	 * Method for get page title.
	 *
	 * @return  string
	 *
	 * @since   2.0.6
	 */
	public function getTitle(): string
	{
	}

	/**
	 * Add the page PathWay.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addPathWay(): void
	{
		\JToolbarHelper::title($this->getPathWay());
	}

	/**
	 * Method for get pathway.
	 *
	 * @return  string
	 *
	 * @since   2.0.6
	 */
	public function getPathWay(): string
	{
	}

	/**
	 * Method for add toolbar.
	 *
	 * @return  void
	 *
	 * @since   2.0.6
	 */
	protected function addToolbar(): void
	{
	}
}
