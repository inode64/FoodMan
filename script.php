<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

defined('_JEXEC') or die();

class com_FoodManInstallerScript extends \Joomla\CMS\Installer\InstallerScript
{
	protected $minimumPhp = '7.2.0';
	protected $minimumJoomla = '3.9.0';

	/**
	 * Function called before extension installation/update/removal procedure commences
	 *
	 * @param   string            $type    The type of change (install, update or discover_install, not uninstall)
	 * @param   InstallerAdapter  $parent  The class calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.6
	 */
	function preflight($type, $parent)
	{
		if (!parent::preflight($type, $parent))
		{
			return false;
		}
	}
}