<?php
/**
 * @package      foodman
 * @subpackage
 *
 * @copyright    A copyright
 * @license      A "Slug" license name e.g. GPL2
 */

const TYPE_MOVEMENT_BUY   = 1;
const TYPE_MOVEMENT_TRASH = 2;
const TYPE_MOVEMENT_LOST  = 3;
const TYPE_MOVEMENT_USE   = 4;

const TYPE_MOVEMENT = array(
	TYPE_MOVEMENT_BUY   => 'COM_FOODMAN_TYPE_BUY',
	TYPE_MOVEMENT_TRASH => 'COM_FOODMAN_TYPE_TRASH',
	TYPE_MOVEMENT_LOST  => 'COM_FOODMAN_TYPE_LOST',
	TYPE_MOVEMENT_USE   => 'COM_FOODMAN_TYPE_USE'
);

const TYPE_PROCESS_CREATE = 1;
const TYPE_PROCESS_BUY    = 2;
const TYPE_PROCESS_STORE  = 3;
const TYPE_PROCESS_FINISH = 4;

const TYPE_PROCESS = array(
	TYPE_PROCESS_CREATE => 'COM_FOODMAN_PROCESS_CREATE',
	TYPE_PROCESS_BUY    => 'COM_FOODMAN_PROCESS_BUY',
	TYPE_PROCESS_STORE  => 'COM_FOODMAN_PROCESS_STORE',
	TYPE_PROCESS_FINISH => 'COM_FOODMAN_PROCESS_FINISH'
);

const TASK_SHOPPING_EDIT   = 'edit';
const TASK_SHOPPING_CREATE = 'create';
const TASK_SHOPPING_BUY    = 'buy';
const TASK_SHOPPING_STORE  = 'store';
const TASK_SHOPPING_FINISH = 'finish';

const VIEW_SHOPPING = array(
	TYPE_PROCESS_CREATE => TASK_SHOPPING_CREATE,
	TYPE_PROCESS_BUY    => TASK_SHOPPING_BUY,
	TYPE_PROCESS_STORE  => TASK_SHOPPING_STORE,
	TYPE_PROCESS_FINISH => TASK_SHOPPING_FINISH
);

const FOODMAN_TABLES_PRIMARY = array(
	'#__foodman_groups'     => 'COM_FOODMAN_SUBMENU_GROUPS',
	'#__foodman_shops'      => 'COM_FOODMAN_SUBMENU_SHOPS',
	'#__foodman_locations'  => 'COM_FOODMAN_SUBMENU_LOCATIONS',
	'#__foodman_categories' => 'COM_FOODMAN_SUBMENU_CATEGORIES',
	'#__foodman_lists'      => 'COM_FOODMAN_SUBMENU_LISTS',
	'#__foodman_products'   => 'COM_FOODMAN_SUBMENU_PRODUCTS',
	'#__foodman_stocks'     => 'COM_FOODMAN_SUBMENU_STOCKS',
	'#__foodman_shopping'   => 'COM_FOODMAN_SUBMENU_SHOPPINGS',
	'#__foodman_movement'   => 'COM_FOODMAN_SUBMENU_MOVEMENT'
);

const FOODMAN_TABLES_SECONDARY = array(
	'#__foodman_xref'
);

const FOODMAN_SUBMENU = array(
	'dashboard'  => array(
		'title' => 'COM_FOODMAN_SUBMENU_DASHBOARD',
		'url'   => 'index.php?option=com_foodman&view=dashboard',
		'alt'   => null,
		'image' => 'dashboard.png'
	),
	'groups'     => array(
		'title' => 'COM_FOODMAN_SUBMENU_GROUPS',
		'url'   => 'index.php?option=com_foodman&view=groups',
		'alt'   => null,
		'image' => 'groups.png'
	),
	'shops'      => array(
		'title' => 'COM_FOODMAN_SUBMENU_SHOPS',
		'url'   => 'index.php?option=com_foodman&view=shops',
		'alt'   => null,
		'image' => 'shops.png'
	),
	'locations'  => array(
		'title' => 'COM_FOODMAN_SUBMENU_LOCATIONS',
		'url'   => 'index.php?option=com_foodman&view=locations',
		'alt'   => null,
		'image' => 'locations.png'
	),
	'categories' => array(
		'title' => 'COM_FOODMAN_SUBMENU_CATEGORIES',
		'url'   => 'index.php?option=com_foodman&view=categories',
		'alt'   => null,
		'image' => 'categories.png'
	),
	'lists'      => array(
		'title' => 'COM_FOODMAN_SUBMENU_LISTS',
		'url'   => 'index.php?option=com_foodman&view=lists',
		'alt'   => null,
		'image' => 'lists.png'
	),
	'products'   => array(
		'title' => 'COM_FOODMAN_SUBMENU_PRODUCTS',
		'url'   => 'index.php?option=com_foodman&view=products',
		'alt'   => null,
		'image' => 'products.png'
	),
	'stocks'     => array(
		'title' => 'COM_FOODMAN_SUBMENU_STOCKS',
		'url'   => 'index.php?option=com_foodman&view=stocks',
		'alt'   => null,
		'image' => 'stocks.png'
	),
	'shoppings'  => array(
		'title' => 'COM_FOODMAN_SUBMENU_SHOPPINGS',
		'url'   => 'index.php?option=com_foodman&view=shoppings',
		'alt'   => null,
		'image' => 'shoppings.png'
	),
	'movements'  => array(
		'title' => 'COM_FOODMAN_SUBMENU_MOVEMENTS',
		'url'   => 'index.php?option=com_foodman&view=movements',
		'alt'   => null,
		'image' => 'movements.png'
	)
);

const XREF_GROUP = 'group';
const XREF_USER = 'user';
const XREF_USER_ADMIN = 'user_admin';
const XREF_CATEGORY = 'category';
const XREF_LIST = 'list';
const XREF_PRODUCT = 'product';
const XREF_SHOP = 'shop';
const XREF_LOCATION = 'location';
