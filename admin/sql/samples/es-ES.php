<?php
/**
 * @package    FoodMan
 *
 * @author     Fco.Javier Félix <ffelix@inode64.com>
 * @copyright  Copyright (C) 2020. All Rights Reserved
 * @license    GNU General Public License version v3 or later; see LICENSE.txt
 * @link       https://github.com/inode64/FoodMan
 */

class esES
{

	public $counter = 100;

	public function locations(): array
	{
		return [['name' => 'Nevera'],
			['name' => 'Congelador'],
			['name' => 'Cuarto de baño'],
			['name' => 'Armario'],
			['name' => 'Garaje'],
			['name' => 'Caja de las especies']];
	}

	public function shops(): array
	{
		return [['name' => 'Supermercado'],
			['name' => 'Centro comercial'],
			['name' => 'Tienda de barrio'],
			['name' => 'Carnicería'],
			['name' => 'Farmacia'],
			['name' => 'Ferretería'],
			['name' => 'Frutería'],
			['name' => 'Herboristería'],
			['name' => 'Hipermercado'],
			['name' => 'Lechería'],
			['name' => 'Mercado'],
			['name' => 'Licorería'],
			['name' => 'Panadería'],
			['name' => 'Tienda de café'],
			['name' => 'Pescadería'],
			['name' => 'Delicatessen'],
			['name' => 'Lidel'],
			['name' => 'Mercadona'],
			['name' => 'Consum'],
			['name' => 'Carrefour'],
			['name' => 'Charter']];
	}

	public function categories(): array
	{
		return [['name' => 'Verduras'],
			['name' => 'Frutas'],
			['name' => 'Productos lácteos'],
			['name' => 'Carnes'],
			['name' => 'Pescados'],
			['name' => 'Granos y legumbres'],
			['name' => 'Bebidas'],
			['name' => 'Bebidas alcohólicas'],
			['name' => 'Congelados'],
			['name' => 'Comida rápida'],
			['name' => 'Productos de limpieza'],
			['name' => 'Frutos secos'],
			['name' => 'Especies'],
			['name' => 'Huevos'],
			['name' => 'Tubérculos'],
			['name' => 'Cereales'],
			['name' => 'Postres']];
	}

	public function products(): array
	{
		return [['name' => 'Patatas', 'catid' => 14, 'expiration' => true],
			['name' => 'Tomates', 'catid' => 0, 'expiration' => true],
			['name' => 'Pizza', 'catid' => 9, 'expiration' => true],
			['name' => 'Agua mineral', 'catid' => 6, 'expiration' => true],
			['name' => 'ternera', 'catid' => 3, 'expiration' => true],
			['name' => 'Huevo', 'catid' => 13, 'expiration' => true],
			['name' => 'Zanahoria', 'catid' => 0, 'expiration' => true],
			['name' => 'Coca - cola', 'catid' => 6, 'expiration' => true],
			['name' => 'Salmón', 'catid' => 4, 'expiration' => true],
			['name' => 'Pistachos', 'catid' => 11, 'expiration' => true],
			['name' => 'Comino', 'catid' => 12, 'expiration' => true],
			['name' => 'Pan', 'catid' => 15, 'expiration' => true],
			['name' => 'Hamburguesa', 'catid' => 3, 'expiration' => true],
			['name' => 'lentejas', 'catid' => 5, 'expiration' => true],
			['name' => 'Garbanzos', 'catid' => 5, 'expiration' => true],
			['name' => 'Sandia', 'catid' => 1, 'expiration' => true],
			['name' => 'Helado', 'catid' => 16, 'expiration' => true],
			['name' => 'Servilletas', 'catid' => 10, 'expiration' => false],
			['name' => 'Salchicas', 'catid' => 3, 'expiration' => true],
			['name' => 'Fresas', 'catid' => 1, 'expiration' => true]
		];
	}
}