<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version 3 or later; see LICENSE.txt
 * @link       http://www.inode64.com
 */

defined('_JEXEC') or die;

/**
 * Display the view
 *
 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
 *
 * @return  mixed  A string if successful, otherwise an Error object.
 * @throws Exception
 */
class FoodManViewDashBoard extends JViewLegacy
{

	public $stats = array();
	public $manifest;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @see     \JViewLegacy::loadTemplate()
	 * @since   3.0
	 */
	public function display($tpl = null)
	{


		$this->stats = $this->get('AllStats');

		$this->manifest = FoodManHelper::manifest();

		JHtml::_('stylesheet', 'com_foodman/dashboard.css', array(), true);

		$this->addToolbar();

		parent::display($tpl);
	}

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
		$user = JFactory::getUser();

		JToolBarHelper::title(JText::_('COM_FOODMAN_MANAGER_DASHBOARD'), 'grid-2');

		if ($user->authorise('core.admin', 'com_foodman') || $user->authorise('core.options', 'com_foodman'))
		{
			JToolBarHelper::preferences('com_foodman');
			JToolbarHelper::divider();
		}
	}
}
