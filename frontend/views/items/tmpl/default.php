<?php
defined('_JEXEC') or die();

JHTML::_('behavior.framework');
$hasAjaxOrderingSupport = $this->hasAjaxOrderingSupport();
?>
<div class="row-fluid">
    <div class="span12">
    <form name="adminForm" id="adminForm" action="index.php" method="post">
        <input type="hidden" name="option" id="option" value="com_mdtickets" />
        <input type="hidden" name="view" id="view" value="items" />
        <input type="hidden" name="task" id="task" value="browse" />
        <input type="hidden" name="boxchecked" id="boxchecked" value="0" />
        <input type="hidden" name="hidemainmenu" id="hidemainmenu" value="0" />
        <input type="hidden" name="filter_order" id="filter_order" value="<?php echo $this->lists->order; ?>" />
        <input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $this->lists->order_Dir; ?>" />
        <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

<table class="adminlist table table-striped" id="itemsList">
    <input type="text" name="title" id="title"
           value="<?php echo $this->escape($this->getModel()->getState('short',''));?>"
           class="text_area" onchange="document.adminForm.submit();" />
    <button onclick="this.form.submit();">
        <?php echo JText::_('JSEARCH_FILTER') ?>
    </button>
    <button onclick="document.adminForm.title.value='';this.form.submit();">
        <?php echo JText::_('JSEARCH_RESET') ?>
    </button>
    <thead>
<tr>
    <?php if($hasAjaxOrderingSupport !== false): ?>
        <th width="20px">
            <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $this->lists->order_Dir, $this->lists->order, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
        </th>
    <?php endif; ?>
    <th width="20px">
        <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
    </th>
    <th width="75px">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_ID', 'mdticket_item_id', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="250px">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_SHORT', 'short', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="12%">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_PRIO', 'prio', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="12%">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_CATEGORY', 'category', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="12%">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_STATUS', 'status', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="12%">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_ASSIGNED', 'assigned', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="12%">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_ITONCALL', 'itoncall', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th >
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_DEADLINE', 'deadline', $this->lists->order_Dir, $this->lists->order) ?>
    </th><!-- Onderstaand niet nodig?
    <th width="10%">
        <?php echo JHTML::_('grid.sort', 'JFIELD_ORDERING_LABEL', 'ordering', $this->lists->order_Dir, $this->lists->order); ?>
        <?php echo JHTML::_('grid.order', $this->items); ?>
    </th>
    <th width="8%">
        <?php echo JHTML::_('grid.sort', 'JPUBLISHED', 'enabled', $this->lists->order_Dir, $this->lists->order); ?>
    </th>-->
</tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="20">
            <?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
        </td>
    </tr>
    </tfoot>
<tbody>
<?php if($count = count($this->items)): ?>
<?php
$i = 0;
$m = 1;
foreach($this->items as $item):
$m = 1 - $m;

//$checkedout = ($item->checked_out != 0);

//$ordering = $this->lists->order == 'ordering';

// This is a stupid requirement of JHTML. Go figure!
//switch($item->access) {
//    case 0: $item->groupname = JText::_('public'); break;
//    case 1: $item->groupname = JText::_('registered'); break;
//    case 2: $item->groupname = JText::_('special'); break;
//}

//$icon = $base_folder.'/media/com_ars/icons/' . (empty($item->groups) ? 'unlocked_16.png' : 'locked_16.png');
?>
<tr class="row<?php echo $m?>">
    <?php if($hasAjaxOrderingSupport !== false): ?>
        <td class="order nowrap center hidden-phone">
            <?php if ($this->perms->editstate) :
                $disableClassName = '';
                $disabledLabel	  = '';
                if (!$hasAjaxOrderingSupport['saveOrder']) :
                    $disabledLabel    = JText::_('JORDERINGDISABLED');
                    $disableClassName = 'inactive tip-top';
                endif; ?>
                <span class="sortable-handler <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>" rel="tooltip">
					<i class="icon-menu"></i>
				</span>
                <input type="text" style="display:none"  name="order[]" size="5"
                       value="<?php echo $item->ordering;?>" class="input-mini text-area-order " />
            <?php else : ?>
                <span class="sortable-handler inactive" >
					<i class="icon-menu"></i>
				</span>
            <?php endif; ?>
        </td>
    <?php endif; ?>
    <td><?php echo JHTML::_('grid.id', $i, $item->mdtickets_item_id); ?></td>
    <td><span class="ticket"><?php
        $num = $item->mdtickets_item_id;
        $ticketNum = sprintf("%04d", $num);?>
        <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $item->mdtickets_item_id;?>"><?php echo $ticketNum; ?></a>
        </span></td>
    <td><span class="short"><?php echo $item->short;?></span></td>
    <td><span class="prio"><?php echo $item->prio;?></span></td>
    <td><span class="category"><?php echo $item->category;?></span></td>
    <td><span class="status label"><?php echo $item->status;?></span></td>
    <td><span class="assigned label <?php if ($item->assigned=='ITON'){?>label-info<?php } elseif ($item->assigned=='MHI'){?>label-success<?php }?>"><?php echo $item->assigned;?></span></td>
    <td><span class="itoncall"><?php echo $item->itoncall;?></span></td>
    <td><span class="deadline"><?php echo $item->deadline;?></span></td>
</tr>
    <?php
    $i++;
endforeach;
    ?>
<?php else : ?>
    <tr>
        <td colspan="10" align="center"><?php echo JText::_('COM_ARS_COMMON_NOITEMS_LABEL') ?></td>
    </tr>
<?php endif ?>


</tbody>
    </table>
        </div>
    </div>
        </form>