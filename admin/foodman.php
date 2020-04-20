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
JHtml::_('behavior.tabstate');

if (!JFactory::getUser()->authorise('core.manage', 'com_foodman'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

require_once JPATH_COMPONENT_ADMINISTRATOR . '/includes/constants.php';

JLoader::import('components.com_foodman.libraries.models.table', JPATH_ADMINISTRATOR);
JLoader::import('components.com_foodman.libraries.models.controlerform', JPATH_ADMINISTRATOR);
JLoader::import('components.com_foodman.libraries.models.controleradmin', JPATH_ADMINISTRATOR);
JLoader::import('components.com_foodman.libraries.models.modellist', JPATH_ADMINISTRATOR);
JLoader::import('components.com_foodman.libraries.models.fieldlist', JPATH_ADMINISTRATOR);
JLoader::import('components.com_foodman.libraries.models.predefinedlist', JPATH_ADMINISTRATOR);

JLoader::register('FoodManHelper', JPATH_ADMINISTRATOR . '/components/com_foodman/helpers/foodman.php');
JLoader::register('FoodManHelperXref', JPATH_ADMINISTRATOR . '/components/com_foodman/helpers/xref.php');

// Execute the task.
$controller = JControllerLegacy::getInstance('FoodMan');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
