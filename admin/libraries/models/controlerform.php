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
 * Stock controller class.
 *
 * @since  1.6
 */
abstract class FoodManControllerForm extends \Joomla\CMS\MVC\Controller\FormController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var          string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_FOODMAN';

	/**
	 * Method to check if you can edit an existing record.
	 *
	 * Only edit.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key; default is id.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;

		if ($recordId)
		{
			if (FoodManHelperAccess::canEditAllGroup((int) $this->getModel()->getItem($recordId)->groupid))
			{
				return false;
			}
		}

		return parent::allowEdit($data, $key);
	}
}
