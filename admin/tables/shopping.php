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
	public $expiration;
	public $state;
	public $process;
	public $groupid;
	public $proid;
	public $listid;
	public $locid;
	public $ordering;
	public $featured;
	public $quantity = 0;
	public $bought = 0;
	public $price = 0;
	public $created;
	public $created_by;
	public $modified = 0;
	public $modified_by;
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
