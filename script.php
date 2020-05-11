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

/**
 * @package     ${NAMESPACE}
 *
 * @since       version
 */
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
	public function preflight($type, $parent)
	{
		if (!parent::preflight($type, $parent))
		{
			return false;
		}

		return true;
	}

	/**
	 * Called after any type of action
	 *
	 * @param   string      $action     Which action is happening (install|uninstall|discover_install|update)
	 * @param   JInstaller  $installer  The class calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.7.0
	 */
	function postflight($type, $parent)
	{
		if ($type !== 'install')
		{
			return true;
		}

		$languages = JLanguageHelper::getLanguages();

		foreach ($languages as $lang)
		{
			$file = JPATH_ADMINISTRATOR . '/components/com_foodman//sql/samples/' . $lang->lang_code . '.php';

			if (file_exists($file))
			{
				require_once($file);

				$class  = str_replace('-', '', $lang->lang_code);
				$sample = new $class;

				$this->InsertSample($sample->counter, '#__foodman_locations', $sample->locations(), $lang);
				$this->InsertSample($sample->counter, '#__foodman_shops', $sample->shops(), $lang);
				$this->InsertSample($sample->counter, '#__foodman_categories', $sample->categories(), $lang);
				$this->InsertSample($sample->counter, '#__foodman_products', $sample->products(), $lang);
			}
		}

		return true;
	}

	private function InsertSample($counter, $db, $samples, $lang)
	{
		$id = $counter;
		foreach ($samples as $sample)
		{
			$item = (object) $sample;
			$item->id       = $id;
			$item->language = $lang->lang_code;
			$item->state    = 1;

			if (isset($item->catid))
			{
				$item->catid += $counter;
			}

			JFactory::getDbo()->insertObject($db, $item);

			++$id;
		}

	}
}