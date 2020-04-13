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
<div id="j-main-container">
    <div class="span9">
		<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_left', array('active' => 'main')); ?>
		<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_left', JText::_('COM_FOODMAN_SUBMENU_DASHBOARD'), 'main'); ?>
		<?php echo $this->loadTemplate('main'); ?>
		<?php echo JHtml::_('bootstrap.endSlide'); ?>

		<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_left', JText::_('COM_FOODMAN_STATS'), 'stats'); ?>
		<?php echo $this->loadTemplate('stats'); ?>
		<?php echo JHtml::_('bootstrap.endSlide'); ?>

		<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_left', JText::_('COM_FOODMAN_HOW_IT_WORKS'), 'help'); ?>
		<?php echo $this->loadTemplate('help'); ?>
		<?php echo JHtml::_('bootstrap.endSlide'); ?>

		<?php echo JHtml::_('bootstrap.endAccordion'); ?>
    </div>

    <div class="span3">
		<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_right', array('active' => 'vdm')); ?>
		<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_right', JText::_('COM_FOODMAN_MODULE'), 'vdm'); ?>
		<?php echo $this->loadTemplate('vdm'); ?>
		<?php echo JHtml::_('bootstrap.endSlide'); ?>
		<?php echo JHtml::_('bootstrap.endAccordion'); ?>
    </div>
</div>