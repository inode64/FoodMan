<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

class enGB
{

	public $counter = 1;

	public function locations(): array
	{
		return [['name' => 'Fridge'],
			['name' => 'Freezer'],
			['name' => 'Bath room'],
			['name' => 'Cupboard'],
			['name' => 'Garage'],
			['name' => 'Spice box']];
	}

	public function shops(): array
	{
		return [['name' => 'Supermarkets'],
			['name' => 'Shopping centre'],
			['name' => 'Corner shop'],
			['name' => 'Butcher’s'],
			['name' => 'Chemist’s'],
			['name' => 'Ironmonger’s'],
			['name' => 'Fruit shop'],
			['name' => 'Herbalist’s shop'],
			['name' => 'Superstore'],
			['name' => 'Creamery'],
			['name' => 'Market'],
			['name' => 'Liquor store'],
			['name' => 'Baker’s'],
			['name' => 'Cake shop'],
			['name' => 'Fishmonger’s'],
			['name' => 'Delicatessen']];
	}

	public function categories(): array
	{
		return [['name' => 'Vegetables'],
			['name' => 'Fruits'],
			['name' => 'Dairy products'],
			['name' => 'Meat'],
			['name' => 'Fish'],
			['name' => 'Grains and Legumes'],
			['name' => 'Drinks'],
			['name' => 'Spirit drinks'],
			['name' => 'Frozen foods'],
			['name' => 'Fast food'],
			['name' => 'Cleaning products'],
			['name' => 'Nuts'],
			['name' => 'Spices'],
			['name' => 'Eggs'],
			['name' => 'Tubercles'],
			['name' => 'Cereals'],
			['name' => 'desserts']];
	}

	public function products(): array
	{
		return [['name' => 'Potatoes', 'catid' => 14, 'expiration' => true],
			['name' => 'Tomatoes', 'catid' => 0, 'expiration' => true],
			['name' => 'Pizza', 'catid' => 9, 'expiration' => true],
			['name' => 'Mineral Water', 'catid' => 6, 'expiration' => true],
			['name' => 'Beef', 'catid' => 3, 'expiration' => true],
			['name' => 'Eggs', 'catid' => 13, 'expiration' => true],
			['name' => 'Carrot', 'catid' => 0, 'expiration' => true],
			['name' => 'Coca - cola', 'catid' => 6, 'expiration' => true],
			['name' => 'Salmon', 'catid' => 4, 'expiration' => true],
			['name' => 'Pistachios', 'catid' => 11, 'expiration' => true],
			['name' => 'Cumin', 'catid' => 12, 'expiration' => true],
			['name' => 'Bread', 'catid' => 15, 'expiration' => true],
			['name' => 'Burger', 'catid' => 3, 'expiration' => true],
			['name' => 'Lentils', 'catid' => 5, 'expiration' => true],
			['name' => 'Chickpeas', 'catid' => 5, 'expiration' => true],
			['name' => 'Sandia', 'catid' => 1, 'expiration' => true],
			['name' => 'Ice cream', 'catid' => 16, 'expiration' => true],
			['name' => 'Napkins', 'catid' => 10, 'expiration' => false],
			['name' => 'Sausage', 'catid' => 3, 'expiration' => true],
			['name' => 'Strawberries', 'catid' => 1, 'expiration' => true]
		];
	}
}