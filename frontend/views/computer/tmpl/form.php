<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

// Load the CSS file
FOFTemplateUtils::addCSS('media://com_mdtickets/css/mdtickets.css');

// eerst JQuery toevoegen
JHtml::_('bootstrap.framework');

//load joomla validation
JHTML::_('behavior.formvalidation');

// Load the editor
$editor = JFactory::getEditor();
//Get options
jimport('joomla.application.component.helper');
$menu_id = JComponentHelper::getParams('com_mdtickets')->get('menu_item_id');
?>

<form action="index.php" method="post" id="adminForm" class="form-validate" onsubmit="return isValid()"
      enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html"> <!-- added onsubmit="return isValid()"  to prevent saaving-->
    <input type="hidden" name="option" value="com_mdtickets" />
    <input type="hidden" name="view" value="computer" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" id="mdtickets_computer_id" name="mdtickets_computer_id" value="<?php echo $this->item->mdtickets_computer_id ?>" />
    <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
    <div id="mdtickets_toolbar" class="row well btn-toolbar">
        <div id="btn_save" class="btn-group">
            <button href="#" onclick="Joomla.submitbutton('apply')" class="btn  btn-success">
                <i class="icon-apply icon-white">
                </i>
                <?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_SAVE' );?>
            </button>
            <button href="#" onclick="Joomla.submitbutton('save')" class="btn">
                <i class="icon-save ">
                </i>
                <?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_SAVE_CLOSE' );?>
            </button>
            <button href="#" onclick="Joomla.submitbutton('savenew')" class="btn">
                <i class="icon-save-new "></i>
                <?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_SAVE_NEW' );?>
            </button>
            <a href="index.php?option=com_mdtickets&view=computers&Itemid=<?php echo $menu_id;?>"  class="btn">
                <i class="icon-undo"></i>&nbsp;<?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_CANCEL' );?></a>
        </div>
      </div><!-- End of toolbar -->
    <div class="row-fluid">
        <div class="span12">
            <div id="form_edit">
                <h3><?php echo JText::_('COM_MDTICKETS_COMPUTERS_GROUP_BASIC') ?></h3>
            <div class="row">
                <div class="span1">
                    <label for="computername" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_COMPUTERNAME') ?></label>
                </div>
                <div class="span4">
                    <input type="text" name="computername" id="computername"  value="<?php echo $this->item->computername?>" class="required"/>
                </div>
            </div>
            <div class="row">
                <div class="span1">
                    <label for="computerdesc" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_COMPUTERDESC') ?></label>
                </div>
                <div class="span4">
                    <input type="text" name="computerdesc" id="computerdesc"  value="<?php echo $this->item->computerdesc?>" />
                </div>
                </div>
        </div>
    </div>

</form>
