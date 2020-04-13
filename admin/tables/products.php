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
	public $expiration = null;
	public $catid = null;
	public $state = null;
	public $userid = null;
	public $description = '';
	public $ordering = null;
	public $daysopen = 0;
	public $minstock = 0;
	public $maxstock = 0;
	public $featured = null;
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
		parent::__construct('#__foodman_products', 'id', $db);
	}
}