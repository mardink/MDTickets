<?php
defined('_JEXEC') or die();

JHTML::_('behavior.framework');
$this->loadHelper('select');
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
    <div class="row">
    <!-- Search in ticket number -->
    <input type="text" name="mdtickets_item_id" id="mdtickets_item_id"
           value="<?php echo $this->escape($this->getModel()->getState('mdtickets_item_id',''));?>"
           class="text_area" onchange="document.adminForm.submit();"
           placeholder="<?php echo JText::_('COM_MDTICKETS_SEARCH_TICKET') ?>"/>
    <button class="btn btn-small btn-success" onclick="this.form.submit();">
        <?php echo JText::_('JSEARCH_FILTER') ?>
    </button>
    <button class="btn btn-small btn-danger" onclick="document.adminForm.mdtickets_item_id.value='';this.form.submit();">
        <?php echo JText::_('JSEARCH_RESET') ?>
    </button>
    <!-- Search Short -->
        <input type="text" name="short" id="short"
           value="<?php echo $this->escape($this->getModel()->getState('short',''));?>"
           class="text_area" onchange="document.adminForm.submit();"
           placeholder="<?php echo JText::_('COM_MDTICKETS_SEARCH_SHORT') ?>"/>
        <button class="btn btn-small btn-success" onclick="this.form.submit();">
        <?php echo JText::_('JSEARCH_FILTER') ?>
    </button>
    <button class="btn btn-small btn-danger" onclick="document.adminForm.short.value='';this.form.submit();">
        <?php echo JText::_('JSEARCH_RESET') ?>
    </button>
    <!-- Search in all - Niet handig als er nummers in omschrijving staat Uitgezet
            <input type="text" name="search" id="search"
           value="<?php echo $this->escape($this->getModel()->getState('search',''));?>"
           class="text_area" onchange="document.adminForm.submit();"
           placeholder="<?php echo JText::_('COM_MDTICKETS_SEARCH') ?>"/>
    <button class="btn btn-small" onclick="this.form.submit();">
        <?php echo JText::_('JSEARCH_FILTER') ?>
    </button>
    <button class="btn btn-small" onclick="document.adminForm.search.value='';this.form.submit();">
        <?php echo JText::_('JSEARCH_RESET') ?>
    </button>
     Einde-->
        <!-- Search ITONCall -->
        <input type="text" name="itoncall" id="itoncall"
               value="<?php echo $this->escape($this->getModel()->getState('itoncall',''));?>"
               class="text_area" onchange="document.adminForm.submit();"
                placeholder="<?php echo JText::_('COM_MDTICKETS_SEARCH_ITONCALL') ?>"/>
        <button class="btn btn-small btn-success" onclick="this.form.submit();">
            <?php echo JText::_('JSEARCH_FILTER') ?>
        </button>
        <button class="btn btn-small btn-danger" onclick="document.adminForm.itoncall.value='';this.form.submit();">
            <?php echo JText::_('JSEARCH_RESET') ?>
        </button>
        <a class="btn btn-small btn-success pull-right" href="index.php?option=com_mdtickets&view=items&format=csv" ><?php echo JText::_('COM_MDTICKETS_DOWNLOAD_CSV') ?></a>
        <a class="btn btn-small btn-success pull-right" href="index.php?option=com_mdtickets&view=items&tmpl=component" ><?php echo JText::_('COM_MDTICKETS_PRINT') ?></a>

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
    <th width="50px">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_ID', 'mdticket_item_id', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="290px">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_SHORT', 'short', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_PRIO', 'prio', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_REQUESTER', 'requester', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_CATEGORY', 'category', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_STATUS', 'status', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_ASSIGNED', 'assigned', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_ITONCALL', 'itoncall', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_DEADLINE', 'deadline', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_MODIFIED', 'modified_on', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <!-- Onderstaand niet nodig?
    <th width="10%">
        <?php echo JHTML::_('grid.sort', 'JFIELD_ORDERING_LABEL', 'ordering', $this->lists->order_Dir, $this->lists->order); ?>
        <?php echo JHTML::_('grid.order', $this->items); ?>
    </th>
    <th width="8%">
        <?php echo JHTML::_('grid.sort', 'JPUBLISHED', 'published', $this->lists->order_Dir, $this->lists->order); ?>
    </th>-->
</tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo MdticketsHelperSelect::prio($this->getModel()->getState('prio'), 'prio', array('onchange'=>'this.form.submit();','class' => 'input-small')) ?></td>
            <td></td>
            <td><?php echo MdticketsHelperSelect::category($this->getModel()->getState('category'), 'category', array('onchange'=>'this.form.submit();','class' => 'input-small')) ?></td>
            <td><?php echo MdticketsHelperSelect::status($this->getModel()->getState('status'), 'status', array('onchange'=>'this.form.submit();','class' => 'input-small')) ?></td>
            <td><?php echo MdticketsHelperSelect::assigned($this->getModel()->getState('assigned'), 'assigned', array('onchange'=>'this.form.submit();','class' => 'input-small')) ?></td>
            <td></td>
            <td></td>
            <td></td>
            <!-- Werkt nog niet goed
            <td><?php echo MdticketsHelperSelect::published($this->getModel()->getState('published'), 'published', array('onchange'=>'this.form.submit();','class' => 'input-small')) ?></td>
        -->
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
    <td><span class="prio label <?php if ($item->prio=='Hoog'){?>label-important<?php }
        elseif ($item->prio=='Normaal'){?>label-success<?php }
        elseif ($item->prio=='Laag'){?>label-warning<?php }
        elseif ($item->prio=='Periodiek'){?>label-info<?php }
        elseif ($item->prio=='tzt'){?>label-inverse<?php }?>"><?php echo $item->prio;?></span></td>
    <td><span class="requester <?php if ($item->requester=='MHI'){?> label label-warning<?php }
        elseif ($item->requester=='HvT'){?>label label-warning<?php }?>"><?php echo $item->requester;?></span></td>
    <td><span class="category"><?php echo $item->category;?></span></td>
    <td><span class="status label
    <?php if ($item->status=='Not started'){?><?php }
        elseif ($item->status=='Started'){?>label-inverse<?php }
        elseif ($item->status=='Pauzed'){?>label-warning<?php }
        elseif ($item->status=='Waiting for ITON'){?>label-info<?php }
        elseif ($item->status=='Waiting for supplier'){?>label-info<?php }
        elseif ($item->status=='Waiting for other'){?>label-info<?php }
        elseif ($item->status=='Closed'){?>label-success<?php }
    elseif ($item->status=='Cancelled'){?>label-important<?php }?>"><?php echo $item->status;?></span></td>
    <td><span class="assigned label
    <?php if ($item->assigned=='ITON'){?>label-info<?php }
        elseif ($item->assigned=='MHI'){?>label-success<?php }
        elseif ($item->assigned=='HvT'){?>label-warning<?php }
        elseif ($item->assigned=='MHI-HvT'){?>label-important<?php }?>"><?php echo $item->assigned;?></span></td>
    <td><span class="itoncall">
            <?php if ($item->assigned=='ITON') {?>
            <a href="http://helpdesk.iton.nl/" target="_blank"><?php echo $item->itoncall;?></a></span>
        <?php } ?>
    </td>
    <td><span class="deadline"><?php
            $DateDeadline = $item->deadline;
            $newDateDeadline = date("d-m-Y", strtotime($DateDeadline));
            echo $newDateDeadline; ?></span></td>
    <td><span class="modified_on"><?php
            $DateModifiedOn = $item->modified_on;
            $newDateModifiedOn = date("d-m-Y", strtotime($DateModifiedOn));
            echo $newDateModifiedOn;?></span></td>
    <!-- Nog niet
    <td><span class="published">
            <?php if ($item->assigned=='ITON') {?>
            <a href="http://helpdesk.iton.nl/" target="_blank"><?php echo $item->published;?></a></span>
        <?php } ?></td>-->
</tr>
    <?php
    $i++;
endforeach;
    ?>
<?php else : ?>
    <tr>
        <td colspan="10" align="center"><?php echo JText::_('COM_MDTICKETS_COMMON_NOITEMS_LABEL') ?></td>
    </tr>
<?php endif ?>


</tbody>
    </table>
        </div>
    </div>
        </form>