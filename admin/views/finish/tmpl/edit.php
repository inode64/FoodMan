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
		if (task == "finish.cancel" || document.formvalidator.isValid(document.getElementById("finish-form")))
		{
			Joomla.submitform(task, document.getElementById("finish-form"));
		}
	};
');
?>

<form action="<?php echo JRoute::_('index.php?option=com_foodman&view=finish&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="finish-form" class="form-validate">

    <div class="row-fluid">
		<?php echo $this->form->renderField('name'); ?>
		<?php echo $this->form->renderField('userid'); ?>
		<?php echo $this->form->renderField('shopid'); ?>

        <div class="form-horizontal">
			<?php echo $this->form->renderField('products'); ?>
			<?php echo $this->form->renderField('proid'); ?>
			<?php echo $this->form->renderField('quantity'); ?>
			<?php echo $this->form->renderField('bought'); ?>
			<?php echo $this->form->renderField('comments'); ?>
			<?php echo $this->form->renderField('shops'); ?>
        </div>


    </div>

    <input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>
</form>
