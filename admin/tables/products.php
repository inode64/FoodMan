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
 * Products table
 *
 * @since  1.5
 */
class FoodManTableProducts extends FoodManTable
{

	public $name = '';
	public $expires;
	public $catid;
	public $state;
	public $groupid;
	public $description = '';
	public $ordering;
	public $daysopen = 0;
	public $minstock = 0;
	public $maxstock = 0;
	public $featured;
	public $language = '';
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
		parent::__construct('#__foodman_products', 'id', $db);
	}
}
