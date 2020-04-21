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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_foodman&task=list.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo JRoute::_('index.php?option=com_foodman&view=lists'); ?>" method="post" name="adminForm"
      id="adminForm">
    <div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
		<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
		?>
		<?php if (empty($this->items)) : ?>
            <div class="alert alert-no-items">
				<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
            </div>
		<?php else : ?>
            <table class="table table-striped" id="articleList">
                <thead>
                <tr>
                    <th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                    </th>
                    <th width="1%" class="center">
						<?php echo JHtml::_('grid.checkall'); ?>
                    </th>
                    <th width="1%" class="nowrap center">
						<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
                    </th>
                    <th>
						<?php echo JHtml::_('searchtools.sort', 'COM_FOODMAN_HEADING_NAME', 'a.name', $listDirn, $listOrder); ?>
                    </th>
                    <th width="10%" class="nowrap hidden-phone">
						<?php echo JHtml::_('searchtools.sort', 'COM_FOODMAN_HEADING_GROUP', 'g.name', $listDirn, $listOrder); ?>
                    </th>
                    <th width="1%" class="nowrap center hidden-phone hidden-tablet">
			<span class="icon-publish hasTooltip" aria-hidden="true"
                  title="<?php echo JText::_('COM_FOODMAN_COUNT_CREATE_ITEMS'); ?>"><span
                        class="element-invisible"><?php echo JText::_('COM_FOODMAN_COUNT_LIST_ITEMS'); ?></span></span>
                    </th>
                    <th width="1%" class="nowrap center hidden-phone hidden-tablet">
			<span class="icon-publish hasTooltip" aria-hidden="true"
                  title="<?php echo JText::_('COM_FOODMAN_COUNT_BUY_ITEMS'); ?>"><span
                        class="element-invisible"><?php echo JText::_('COM_FOODMAN_COUNT_LIST_ITEMS'); ?></span></span>
                    </th>
                    <th width="1%" class="nowrap center hidden-phone hidden-tablet">
			<span class="icon-publish hasTooltip" aria-hidden="true"
                  title="<?php echo JText::_('COM_FOODMAN_COUNT_STORE_ITEMS'); ?>"><span
                        class="element-invisible"><?php echo JText::_('COM_FOODMAN_COUNT_LIST_ITEMS'); ?></span></span>
                    </th>
                    <th width="1%" class="nowrap hidden-phone">
						<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                    </th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="9">
						<?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
                </tfoot>
                <tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering = ($listOrder == 'ordering');
					$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
					?>
                    <tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $item->id; ?>">
                        <td class="order nowrap center hidden-phone">
							<?php
							$iconClass  = '';
							$canChange  = true;
							$ItemsStore = FoodManHelper::CountItems($item->id, TYPE_PROCESS_STORE);
							$ItemsBuy   = FoodManHelper::CountItems($item->id, TYPE_PROCESS_BUY);
							?>

                            <span class="sortable-handler <?php echo $iconClass ?>">
									<span class="icon-menu" aria-hidden="true"></span>
								</span>
							<?php if ($saveOrder) : ?>
                                <input type="text" style="display:none" name="order[]" size="5"
                                       value="<?php echo $item->ordering; ?>" class="width-20 text-area-order"/>
							<?php endif; ?>
                        </td>
                        <td class="center">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <td class="center">
                            <div class="btn-group">
								<?php echo JHtml::_('jgrid.published', $item->state, $i, 'lists.', $canChange); ?>
								<?php echo JHtml::_('fmlist.featured', $item->featured, $i, $canChange); ?>
								<?php // Create dropdown items and render the dropdown list.
								if ($canChange)
								{
									JHtml::_('actionsdropdown.' . ((int) $item->state === 2 ? 'un' : '') . 'archive', 'cb' . $i, 'lists');
									JHtml::_('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'lists');
									echo JHtml::_('actionsdropdown.render', $this->escape($item->name));
								}
								?>
                            </div>
                        </td>
                        <td class="has-context">
                            <div class="pull-left break-word">
								<?php if ($item->checked_out) : ?>
									<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'lists.', $canCheckin); ?>
								<?php endif; ?>

                                <a href="<?php echo JRoute::_('index.php?option=com_foodman&task=list.edit&id=' . (int) $item->id); ?>">
									<?php echo $this->escape($item->name); ?></a>

                                <a class="badge badge-success"
                                   href="<?php echo JRoute::_('index.php?option=com_foodman&task=shopping.' . TASK_SHOPPING_CREATE . '&layout=' . VIEW_SHOPPING[TYPE_PROCESS_CREATE] . '&id=' . (int) $item->id) ?>">
									<?php echo JText::_('COM_FOODMAN_LIST_SHOPPING_CREATE'); ?></a>

								<?php if ($item->count_list_create > 0) { ?>
                                    <a class="badge badge-success"
                                       href="<?php echo JRoute::_('index.php?option=com_foodman&task=shopping.' . TASK_SHOPPING_BUY . '&layout=' . VIEW_SHOPPING[TYPE_PROCESS_BUY] . '&id=' . (int) $item->id); ?>">
										<?php echo JText::_('COM_FOODMAN_LIST_SHOPPING_BUY'); ?></a>
								<?php } ?>

								<?php if ($item->count_list_buy > 0 || $item->count_list_store > 0) { ?>
                                    <a class="badge badge-success"
                                       href="<?php echo JRoute::_('index.php?option=com_foodman&task=shopping.' . TASK_SHOPPING_STORE . '&layout=' . VIEW_SHOPPING[TYPE_PROCESS_STORE] . '&id=' . (int) $item->id); ?>">
										<?php echo JText::_('COM_FOODMAN_LIST_SHOPPING_STORE'); ?></a>
								<?php } ?>
								<?php if ($item->count_list_store > 0) { ?>
									<?php if ($item->count_list_buy > 0) { ?>
                                        <span class="badge badge-important">
					    <?php echo JText::_('COM_FOODMAN_LIST_SHOPPING_FINISH'); ?>
					</span>
									<?php } else { ?>
										<?php if ($item->count_list_create > 0) { ?>
                                            <a class="badge badge-warning"
                                               href="<?php echo JRoute::_('index.php?option=com_foodman&task=shopping.' . TASK_SHOPPING_FINISH . '&layout=' . TASK_SHOPPING_FINISH . '&id=' . (int) $item->id); ?>">
												<?php echo JText::_('COM_FOODMAN_LIST_SHOPPING_FINISH'); ?></a>
										<?php } else { ?>
                                            <a class="badge badge-info"
                                               href="<?php echo JRoute::_('index.php?option=com_foodman&task=shopping.' . TASK_SHOPPING_FINISH . '&layout=' . TASK_SHOPPING_FINISH . '&id=' . (int) $item->id); ?>">
												<?php echo JText::_('COM_FOODMAN_LIST_SHOPPING_FINISH'); ?></a>
										<?php } ?>
									<?php } ?>
								<?php } ?>
                            </div>
                        </td>

                        <td class="small hidden-phone">
							<?php echo JLayoutHelper::render('foodman.content.group', $item); ?>
                        </td>
                        <td class="center btns hidden-phone hidden-tablet">
                            <a class="badge <?php if ($item->count_list_create > 0) echo 'badge-important'; ?>"
                               href="<?php echo JRoute::_('index.php?option=com_foodman&view=shoppings&filter[listid]=' . (int) $item->id . '&filter[process]=' . TYPE_PROCESS_CREATE); ?>">
								<?php echo $item->count_list_create; ?></a>
                        </td>
                        <td class="center btns hidden-phone hidden-tablet">
                            <a class="badge <?php if ($item->count_list_buy > 0) echo 'badge-important'; ?>"
                               href="<?php echo JRoute::_('index.php?option=com_foodman&view=shoppings&filter[listid]=' . (int) $item->id . '&filter[process]=' . TYPE_PROCESS_BUY); ?>">
								<?php echo $item->count_list_buy; ?></a>
                        </td>
                        <td class="center btns hidden-phone hidden-tablet">
                            <a class="badge <?php if ($item->count_list_store > 0) echo 'badge-important'; ?>"
                               href="<?php echo JRoute::_('index.php?option=com_foodman&view=shoppings&filter[listid]=' . (int) $item->id . '&filter[process]=' . TYPE_PROCESS_STORE); ?>">
								<?php echo $item->count_list_store; ?></a>
                        </td>

                        <td class="hidden-phone">
							<?php echo $item->id; ?>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>
		<?php endif; ?>

        <input type="hidden" name="task" value=""/>
        <input type="hidden" name="boxchecked" value="0"/>
		<?php echo JHtml::_('form.token'); ?>
    </div>
</form>
