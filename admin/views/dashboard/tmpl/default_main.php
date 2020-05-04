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

foreach (FOODMAN_SUBMENU as $key => $item)
{
	if (FoodManHelperAccess::AccessMenu($item) && $key !== 'dashboard' )
	{
		?>
        <div class="dashboard-wrapper">
            <div class="dashboard-content">
                <a class="icon" href="<?php echo $item['url']; ?>">
					<?php echo JHtml::_('image', 'com_foodman/' . $item['image'], JText::_($item['title']), null, true); ?>
                    <span class="dashboard-title"><?php echo JText::_($item['title']); ?></span>
                </a>
            </div>
        </div>
	<?php }
} ?>
<div class="clearfix"></div>