<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

JHTML::_('behavior.framework');
// Load the CSS file
FOFTemplateUtils::addCSS('media://com_mdtickets/css/mdtickets-list.css');

// eerst JQuery toevoegen
JHtml::_('bootstrap.framework');
// Load custom js file
$document = JFactory::getDocument();
$document->addScript('media/com_mdtickets/js/mdtickets-list.js');
// Load helper
$this->loadHelper('select');
$hasAjaxOrderingSupport = $this->hasAjaxOrderingSupport();
// variables
$user = JFactory::getUser();
$user_id = $user->id;
//Get the previouslogin date and time
$lastlogin = MdticketsHelperSelect::getLastlogin($user_id);
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
        <input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="ASC" />
        <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

<table class="adminlist table table-striped span12" id="itemsList">
    <div class="row span12">
    <!-- Search in ticket number -->
    <input type="text" name="mdtickets_item_id" id="mdtickets_item_id"
           value="<?php echo $this->escape($this->getModel()->getState('mdtickets_item_id',''));?>"
           class="text_area" onchange="document.adminForm.submit();"
           placeholder="<?php echo JText::_('COM_MDTICKETS_SEARCH_TICKET') ?>"/>
    <button class="btn btn-small btn-success" onclick="this.form.submit();">
        <?php echo JText::_('COM_MDTICKETS_SEARCH_FILTER') ?>
    </button>
    <button class="btn btn-small btn-danger" onclick="document.adminForm.mdtickets_item_id.value='';this.form.submit();">
        <?php echo JText::_('COM_MDTICKETS_SEARCH_RESET') ?>
    </button>
    <!-- Search Short -->
        <input type="text" name="short" id="short"
           value="<?php echo $this->escape($this->getModel()->getState('short',''));?>"
           class="text_area" onchange="document.adminForm.submit();"
           placeholder="<?php echo JText::_('COM_MDTICKETS_SEARCH_SHORT') ?>"/>
        <button class="btn btn-small btn-success" onclick="this.form.submit();">
        <?php echo JText::_('COM_MDTICKETS_SEARCH_FILTER') ?>
    </button>
    <button class="btn btn-small btn-danger" onclick="document.adminForm.short.value='';this.form.submit();">
        <?php echo JText::_('COM_MDTICKETS_SEARCH_RESET') ?>
    </button>
    <!-- Search ITONCall -->
        <input type="text" name="itoncall" id="itoncall"
               value="<?php echo $this->escape($this->getModel()->getState('itoncall',''));?>"
               class="text_area" onchange="document.adminForm.submit();"
                placeholder="<?php echo JText::_('COM_MDTICKETS_SEARCH_ITONCALL') ?>"/>
        <button class="btn btn-small btn-success" onclick="this.form.submit();">
            <?php echo JText::_('COM_MDTICKETS_SEARCH_FILTER') ?>
        </button>
        <button class="btn btn-small btn-danger" onclick="document.adminForm.itoncall.value='';this.form.submit();">
            <?php echo JText::_('COM_MDTICKETS_SEARCH_RESET') ?>
        </button>
    <?php echo JText::_('COM_MDTICKETS_FINSIHED') ?><?php echo MdticketsHelperSelect::finished($this->getModel()->getState('finished'), 'finished', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?>
        <input type="button" id="print_btn" class="btn btn-small btn-success" value="<?php echo Jtext::_('COM_MDTICKETS_PRINT') ?>" onclick="window.print();">
   </div>
            <thead>
<tr>
    <?php if($hasAjaxOrderingSupport !== false): ?>
        <th width="10px">
            <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $this->lists->order_Dir, $this->lists->order, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
        </th>
    <?php endif; ?>
    <th width="20px">
        <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
    </th>
    <th width="70px">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_ID', 'mdticket_item_id', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="400px">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_SHORT', 'short', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_PRIO', 'prio', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_REQUESTER', 'requester', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
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
    </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo MdticketsHelperSelect::prio($this->getModel()->getState('prio'), 'prio', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td></td>
            <td><?php echo MdticketsHelperSelect::category($this->getModel()->getState('category'), 'category', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td><?php echo MdticketsHelperSelect::status($this->getModel()->getState('status'), 'status', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td><?php echo MdticketsHelperSelect::assigned($this->getModel()->getState('assigned'), 'assigned', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="20">
            <?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
        </td>
        <td class="noprint"><?php echo JText::_('COM_MDTICKETS_PAGINATION') ?></td>
        <td><?php echo MdticketsHelperSelect::pagination($this->getModel()->getState('limit'), 'limit', array('onchange'=>'this.form.submit();','class' => 'input-mini noprint')) ?></td>
    </tr>
    </tfoot>
<tbody>
<?php if($count = count($this->items)): ?>
<?php
$i = 0;
$m = 1;
foreach($this->items as $item):
$m = 1 - $m;


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
        $ticketNum = sprintf("%04d", $num);
            $creation_date = $item->created_on;
            $DateModifiedOn = $item->modified_on;
            if ($lastlogin<= $creation_date) {
                ?><i class="icon-star"></i><?php
            } elseif ($lastlogin<= $DateModifiedOn) {
              ?><i class="icon-warning"></i><?php
            } ?>
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
    <td><span class="deadline <?php
        $current_date = date("Y-m-d");
        $warning_date = date("Y-m-d", strtotime("+ 8 day"));
        $DateDeadline = $item->deadline;
        $newDateDeadline = date("d-m-y", strtotime($DateDeadline));
        if($DateDeadline < $current_date && $DateDeadline!= '0000-00-00') { echo "deadline_error";
        } elseif($DateDeadline <= $warning_date) { echo "deadline_warning";
        }?>"><?php
            if ($DateDeadline!= '0000-00-00'){
            echo $newDateDeadline;} else { echo "-"; } ?></span></td>
    <td><span class="modified_on"><?php
            $newDateModifiedOn = date("d-m-y", strtotime($DateModifiedOn));
            echo $newDateModifiedOn;?></span></td>
</tr>
    <?php
    $i++;
endforeach;
    ?>
<?php else : ?>
    <tr>
        <td colspan="10" align="center"><?php echo JText::_('COM_MDTICKETS_COMMON_NOITEMS_LABEL') ?></td>
    </tr>
<?php endif;?>




</tbody>
    </table>
        </div>
    </div>
        </form>