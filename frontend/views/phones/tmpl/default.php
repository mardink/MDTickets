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
JHtml::_('bootstrap.framework');
// Load custom js file
$document = JFactory::getDocument();
$document->addScript('media/com_mdtickets/js/mdtickets-list.js');
// Load helper
$this->loadHelper('phones');
jimport('joomla.application.component.helper');
$hasAjaxOrderingSupport = $this->hasAjaxOrderingSupport();
// variables
$user = JFactory::getUser();
$user_id = $user->id;
//Get the previouslogin date and time
$lastlogin = MdticketsHelperPhones::getLastlogin($user_id);
//Get options
$warning_days = JComponentHelper::getParams('com_mdtickets')->get('warning_days');
$menu_id = JComponentHelper::getParams('com_mdtickets')->get('menu_item_id');
$Start_order = JComponentHelper::getParams('com_mdtickets')->get('start_order');
JHTML::_( 'behavior.calendar' );
JHTML::_( 'behavior.tooltip' );
?>
<div class="row-fluid">
    <div class="span12">

    <form name="adminForm" id="adminForm" action="index.php?option=com_mdtickets&view=phones&Itemid=<?php echo $menu_id;?>" method="post">
        <input type="hidden" name="option" id="option" value="com_mdtickets" />
        <input type="hidden" name="view" id="view" value="phones" />
        <input type="hidden" name="task" id="task" value="browse" />
        <input type="hidden" name="boxchecked" id="boxchecked" value="0" />
        <input type="hidden" name="hidemainmenu" id="hidemainmenu" value="0" />
        <input type="hidden" name="filter_order" id="filter_order" value="<?php echo $this->lists->order; ?>" />
        <input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $Start_order; ?>" />
        <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
    <div id="mdtickets_toolbar" class="row span12">
        <button href="#" onclick="Joomla.submitbutton('add')" class="btn">
            <i class="icon-star ">
            </i>
            <?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_NEW' );?>
        </button>
        <input type="button" id="print_btn" class="btn pull-right" value="<?php echo Jtext::_('COM_MDTICKETS_PRINT') ?>" onclick="window.print();">
    </div>

    <table class="adminlist table table-striped span12" id="itemsList">
            <thead>
<tr>
    <?php if($hasAjaxOrderingSupport !== false): ?>
        <th class="span1">
            <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $this->lists->order_Dir, $this->lists->order, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
        </th>
    <?php endif; ?>

    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_COMPUTERNAME', 'computername', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_USER', 'user', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_COMPUTERDESC', 'computerdesc', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_COMPUTERS_FIELD_TYPE', 'type', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_COMPUTERS_FIELD_COUNTRY', 'country', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_WINDOWS', 'windows', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_OFFICE', 'office', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_SOFTWARE1', 'software1', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_SOFTWARE2', 'software2', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_REMARK', 'remark', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDTICKETS_LABEL_PUBLISHED', 'published', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
        </tr>
        <tr>
            <td></td>
            <td><?php echo MdticketsHelperComputers::user($this->getModel()->getState('user'), 'user', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td></td>
            <td><?php echo MdticketsHelperComputers::type($this->getModel()->getState('type'), 'type', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td><?php echo MdticketsHelperComputers::country($this->getModel()->getState('country'), 'country', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td><?php echo MdticketsHelperComputers::windows($this->getModel()->getState('windows'), 'windows', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td><?php echo MdticketsHelperComputers::office($this->getModel()->getState('office'), 'office', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td><?php echo MdticketsHelperComputers::virus($this->getModel()->getState('software1'), 'software1', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td><?php echo MdticketsHelperComputers::PDF($this->getModel()->getState('software2'), 'software2', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
            <td></td>
            <td><?php echo MdticketsHelperComputers::inuse($this->getModel()->getState('inuse'), 'inuse', array('onchange'=>'this.form.submit();','class' => 'input-mini')) ?></td>
        </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="7">
            <?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
        </td>
        <td style="padding-top: 29px;" colspan="4"><span><?php echo JText::_('COM_MDTICKETS_PAGINATION') ?></span>
        <?php echo MdticketsHelperComputers::pagination($this->getModel()->getState('limit'), 'limit', array('onchange'=>'this.form.submit();','class' => 'input-small')) ?></td>
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
<tr class="row<?php echo $m?><?php if($item->published=='0') {echo " row-finished";} ?>">
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
    <td><span class="mdtickets_computername"><?php

            $creation_date = $item->created_on;
            $DateModifiedOn = $item->modified_on;
            if ($user_id !=''){
            if ($lastlogin<= $creation_date) {
                ?><i class="icon-star"></i><?php
            } elseif ($lastlogin<= $DateModifiedOn) {
              ?><i class="icon-warning"></i><?php
            }?>

        <a href="index.php?option=com_mdtickets&view=computer&task=edit&id=<?php echo $item->mdtickets_computer_id;?>"><?php echo $item->computername; ?></a><?php }
            else {
                echo $item->computername;
            }?>
         </span></td>
    <td><span class="user"><a href="index.php?option=com_mdtickets&view=users&task=edit&id=<?php echo $item->user_id;?>"><?php echo MdticketsHelperComputers::username_short($item->user_id); ?></a></span></td>
    <td><span class="short"><?php echo $item->computerdesc;?></span></td>
    <td><span class="type"><?php echo $item->type;?></span></td>
    <td><span class="country"><?php echo $item->country;?></span></td>
    <td><span class="windows"><?php echo $item->windows;?></span></td>
    <td><span class="office"><?php echo $item->office;?></span></td>
    <td><span class="software1"><?php echo $item->software1;?></span></td>
    <td><span class="software2"><?php echo $item->software2;?></span></td>
    <td><span class="remark"><?php echo $item->remark;?></span></td>
    <td><span class="published"><?php $published = $item->published;
            if ($published == '1') {
                ?><i class="icon-ok"></i><?php
            } else {
                ?><i class="icon-remove"></i><?php
            }?></span></td>

</tr>
        <?php
    $i++;
endforeach;
    ?>
<?php else : ?>
    <tr>
        <td></td>
        <td colspan="10" align="center"><?php echo JText::_('COM_MDTICKETS_COMMON_NOITEMS_LABEL') ?></td>
    </tr>
<?php endif;?>




</tbody>
    </table>
        </div>
    </div>
        </form>