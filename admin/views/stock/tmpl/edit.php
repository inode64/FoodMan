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
		if (task == "stock.cancel" || document.formvalidator.isValid(document.getElementById("stock-form")))
		{
			Joomla.submitform(task, document.getElementById("stock-form"));
		}
	};
	jQuery(document).ready(function ($){
		$("#jform_type").on("change", function (a, params) {

			var v = typeof(params) !== "object" ? $("#jform_type").val() : params.selected;

			var img_url = $("#image, #url");
			var custom  = $("#custom");

			switch (v) {
				case "0":
					// Image
					img_url.show();
					custom.hide();
					break;
				case "1":
					// Custom
					img_url.hide();
					custom.show();
					break;
			}
		}).trigger("change");
	});
');
?>

<form action="<?php echo JRoute::_('index.php?option=com_foodman&view=stock&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="stock-form" class="form-validate">

    <div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'stockTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'stockTab', 'details', JText::_('COM_FOODMAN_LABEL_DETAILS')); ?>
        <div class="row-fluid">
            <div class="span9">
				<?php echo $this->form->renderField('groupid'); ?>
				<?php echo $this->form->renderField('quantity'); ?>
				<?php echo $this->form->renderField('proid'); ?>
				<?php echo $this->form->renderField('expiration'); ?>
				<?php echo $this->form->renderField('open'); ?>
				<?php echo $this->form->renderField('locid'); ?>

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
