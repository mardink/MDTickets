<?php
defined('_JEXEC') or die();

JHTML::_('behavior.framework');
?>
    <form name="adminForm" id="adminForm" action="index.php" method="post">
        <input type="hidden" name="option" id="option" value="com_mdtickets" />
        <input type="hidden" name="view" id="view" value="items" />
        <input type="hidden" name="task" id="task" value="browse" />
        <input type="hidden" name="boxchecked" id="boxchecked" value="0" />
        <input type="hidden" name="hidemainmenu" id="hidemainmenu" value="0" />
        <input type="hidden" name="filter_order" id="filter_order" value="<?php echo $this->lists->order; ?>" />
        <input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="<?php echo $this->lists->order_Dir; ?>" />
        <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

<table class="adminlist">
    <thead>
<tr>
    <th width="20">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ) + 1; ?>);" />
    </th>
    <th>
        <?php echo JHTML::_('grid.sort', 'COM_TODO_ITEMS_FIELD_TITLE', 'title', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="12%">
        <?php echo JHTML::_('grid.sort', 'COM_TODO_ITEMS_FIELD_DUE', 'due', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="10%">
        <?php echo JHTML::_('grid.sort', 'JFIELD_ORDERING_LABEL', 'ordering', $this->lists->order_Dir, $this->lists->order); ?>
        <?php echo JHTML::_('grid.order', $this->items); ?>
    </th>
    <th width="8%">
        <?php echo JHTML::_('grid.sort', 'JPUBLISHED', 'enabled', $this->lists->order_Dir, $this->lists->order); ?>
    </th>
</tr>
<tr>
    <td></td>
    <td>
        <input type="text" name="title" id="title"
               value="<?php echo $this->escape($this->getModel()->getState('short',''));?>"
               class="text_area" onchange="document.adminForm.submit();" />
        <button onclick="this.form.submit();">
            <?php echo JText::_('JSEARCH_FILTER') ?>
        </button>
        <button onclick="document.adminForm.title.value='';this.form.submit();">
            <?php echo JText::_('JSEARCH_RESET') ?>
        </button>
    </td>
    <td></td>
    <td></td>
    <td>

    </td>
</tr>
</thead>
    <tfoot>
    <tr>
        <td colspan="20">
            <?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
        </td>
    </tr>
    </tfoot>
    </table>
<?php
foreach ($this->items as $item){

    echo $item->short; // add echo statements for the fields you want to display, along with your custom HTML, CSS classes, etc.
}
?>
    </form>