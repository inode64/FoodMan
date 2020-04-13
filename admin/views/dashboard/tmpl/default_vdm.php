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
<?php echo JHtml::_('image', 'com_foodman/foodman.png', $this->manifest->name, 'style="text-align:center"', true); ?>

<ul class="list-striped">
    <li><b><?php echo JText::_('COM_FOODMAN_VERSION'); ?>:</b> <?php echo $this->manifest->version; ?>
        &nbsp;&nbsp;<span class="update-notice"></span></li>
    <li><b><?php echo JText::_('COM_FOODMAN_DATE'); ?>:</b> <?php echo $this->manifest->creationDate; ?></li>
    <li><b><?php echo JText::_('COM_FOODMAN_AUTHOR'); ?>:</b> <a
                href="mailto:<?php echo $this->manifest->authorEmail; ?>"><?php echo $this->manifest->author; ?></a>
    </li>
    <li><b><?php echo JText::_('COM_FOODMAN_WEBSITE'); ?>:</b> <a href="<?php echo $this->manifest->authorUrl; ?>"
                                                                  target="_blank"><?php echo $this->manifest->authorUrl; ?></a>
    </li>
    <li><b><?php echo JText::_('COM_FOODMAN_LICENSE'); ?>:</b> <?php echo $this->manifest->license; ?></li>
    <li><b><?php echo $this->manifest->copyright; ?></b></li>
</ul>
<div class="clearfix"></div>
