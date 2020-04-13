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
 * Shoppings table
 *
 * @since  1.5
 */
class FoodManTableShopping extends FoodManTable
{

	public $comments = '';
	public $expiration = null;
	public $state = null;
	public $process = null;
	public $userid = null;
	public $proid = null;
	public $listid = null;
	public $locid = null;
	public $ordering = null;
	public $featured = null;
	public $quantity = 0;
	public $bought = 0;
	public $price = 0;
	public $language = '';
	public $created = null;
	public $created_by = null;
	public $modified = 0;
	public $modified_by = null;
	public $checked_out = 0;
	public $checked_out_time = 0;

	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  $db  Database connector object
	 *
	 * @since   1.5
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__foodman_shopping', 'id', $db);
	}
}
