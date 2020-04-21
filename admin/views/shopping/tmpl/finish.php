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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('jquery.framework');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "shopping.cancel" || document.formvalidator.isValid(document.getElementById("shopping-form")))
		{
			Joomla.submitform(task, document.getElementById("shopping-form"));
		}
	};
');
?>

<form action="<?php echo JRoute::_('index.php?option=com_foodman&view=shopping&layout=finish&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="shopping-form" class="form-validate">

	<?php echo $this->form->renderField('name'); ?>

    <div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'shoppingTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'shoppingTab', 'details', JText::_('COM_FOODMAN_LABEL_DETAILS')); ?>
        <div class="row-fluid">
            <div class="span9">
				<?php echo $this->form->renderField('shopid'); ?>
				<?php echo $this->form->renderField('groupid'); ?>
				<?php echo $this->form->renderField('listid'); ?>
				<?php echo $this->form->renderField('products'); ?>
            </div>
        </div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>

	<?php echo $this->form->renderField('process'); ?>

    <input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>
</form>
