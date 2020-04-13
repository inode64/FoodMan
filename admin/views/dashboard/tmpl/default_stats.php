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
?>

<ul class="list-striped">
	<?php foreach ($this->stats as $title => $count) { ?>
        <li><b><?php echo JText::_($title); ?></b></li>
        <li><?php echo JText::sprintf('COM_FOODMAN_STATS_PUBLISHED', $count->published); ?></li>
        <li><?php echo JText::sprintf('COM_FOODMAN_STATS_UNPUBLISHED', $count->unpublished); ?></li>
        <li><?php echo JText::sprintf('COM_FOODMAN_STATS_ARCHIVED', $count->archived); ?></li>
        <li><?php echo JText::sprintf('COM_FOODMAN_STATS_TRASHED', $count->trashed); ?></li>
	<?php } ?>
</ul>
<div class="clearfix"></div>
