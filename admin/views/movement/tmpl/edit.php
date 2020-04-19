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
		if (task == "movement.cancel" || document.formvalidator.isValid(document.getElementById("movement-form")))
		{
			Joomla.submitform(task, document.getElementById("movement-form"));
		}
	};
');
?>

<form action="<?php echo JRoute::_('index.php?option=com_foodman&view=movement&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="movement-form" class="form-validate">

	<?php echo $this->form->renderField('name'); ?>

    <div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'movementTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'movementTab', 'details', JText::_('COM_FOODMAN_LABEL_DETAILS')); ?>
        <div class="row-fluid">
            <div class="span9">
				<?php echo $this->form->renderField('type'); ?>
				<?php echo $this->form->renderField('proid'); ?>
				<?php echo $this->form->renderField('quantity'); ?>
				<?php echo $this->form->renderField('price'); ?>
				<?php echo $this->form->renderField('locid'); ?>

				<?php echo $this->form->renderField('shopid'); ?>
				<?php echo $this->form->renderField('groupid'); ?>
				<?php echo $this->form->renderField('comments'); ?>
            </div>
            <div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
            </div>
        </div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>

    <input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>
</form>
