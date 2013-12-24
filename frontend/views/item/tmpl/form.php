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
// Load custom js file
$document = JFactory::getDocument();
$document->addScript('media/com_mdtickets/js/mdtickets.js');

//load joomla validation
JHTML::_('behavior.formvalidation');

// Load the editor
$editor = JFactory::getEditor();

//some variables
$num = $this->item->mdtickets_item_id;
//Get options
jimport('joomla.application.component.helper');
$location = JComponentHelper::getParams('com_mdtickets')->get('location');
$warning_days = JComponentHelper::getParams('com_mdtickets')->get('warning_days');
$menu_id = JComponentHelper::getParams('com_mdtickets')->get('menu_item_id');

// Give a notice when it is periodical item
if ($this->item->prio == "Periodiek") {
JFactory::getApplication()->enqueueMessage(Jtext::_('COM_MDTICKETS_PRIO_MESSAGE'), 'info');
}

// Current date and warningdate to show a warning or alert when deadline is overdue
$current_date = date("Y-m-d");
$warning_date = date("Y-m-d", strtotime("+ $warning_days day"));
$DateDeadline = $this->item->deadline;
if($DateDeadline < $current_date && $DateDeadline!= '0000-00-00' && $num) {
    JFactory::getApplication()->enqueueMessage(Jtext::_('COM_MDTICKETS_PRIO_OVERDUE'), 'error');
} elseif($DateDeadline <= $warning_date && $DateDeadline!= '0000-00-00' && $num) {
    JFactory::getApplication()->enqueueMessage(Jtext::_('COM_MDTICKETS_PRIO_WARNING'), 'warning');
}

?>
<form action="index.php" method="post" id="adminForm" class="form-validate" onsubmit="return isValid()"
      enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html"> <!-- added onsubmit="return isValid()"  to prevent saaving-->
    <input type="hidden" name="option" value="com_mdtickets" />
    <input type="hidden" name="view" value="item" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" id="mdtickets_item_id" name="mdtickets_item_id" value="<?php echo $this->item->mdtickets_item_id ?>" />
    <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
    <div id="mdtickets_toolbar" class="row well btn-toolbar">
        <span class="btn-group">
    <button id="edit-button" class="btn <?php if(!$num){?> hide <?php } ?>" type="button"><i class="icon-pencil"></i>&nbsp;<?php echo Jtext::_('COM_MDTICKETS_TICKET_EDIT') ?></button>
    <button href="#myModal" role="button" class="btn <?php if(!$num){?> hide <?php } ?>" data-toggle="modal"><i class="icon-comments"></i>&nbsp;<?php echo Jtext::_('COM_MDTICKETS_TICKET_UPDATE') ?></button>
    <a href="index.php?option=com_mdtickets&view=items&Itemid=<?php echo $menu_id;?>"  class="btn">
        <i class="icon-undo"></i>&nbsp;<?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_CANCEL' );?></a>
        <button id="print_btn" class="btn" onclick="window.print();"><i class="icon-printer"></i>&nbsp;<?php echo Jtext::_('COM_MDTICKETS_PRINT'); ?></button>
        </span>
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
        </div>
      </div>
    <div class="row-fluid">
        <div class="span12">
            <?php
            $ticketNum = sprintf("%04d", $num);
            $user_id = $this->item->created_by;
            $user = JFactory::getUser($user_id);
            $username =  $user->get('username');

            if(!$num){?>
                <!-- ony for new document -->
                    <h3><?php echo JText::_('COM_MDTICKETS_ITEM_NEW') ?></h3>
                <?php } else { ?>
            <!-- ony for existing document -->
                <div class="row">
                <h3 class="span2">Ticket <?php echo $ticketNum;?></h3> <h4><?php echo JText::_( 'COM_MDTICKETS_CREATED_DATE' );
                        $originalDate = $this->item->created_on;
                        $newDate = date("d-m-Y", strtotime($originalDate));
                        echo  $newDate;
                    echo JText::_( 'COM_MDTICKETS_CREATED_BY' );
                    echo $username;
                    echo " " . JText::_( 'COM_MDTICKETS_MODIFIED_TEXT' );
                        $modifiedDate = $this->item->modified_on;
                        $modifiedDate = date("d-m-Y", strtotime($modifiedDate));
                    echo " " . $modifiedDate;
                        ?>

                    </h4>
                <?php } ?>
                </div>
            <div id="form_edit">
            <div class="row">
                <div class="span4">
                    <label for="short" class="control-label"><?php echo JText::_('COM_MDTICKETS_ITEM_SHORT') ?></label>
                    <input type="text" name="short" id="short" maxlength="100" value="<?php echo $this->item->short?>" class="required changeEdit"/>
                </div>
                <div class="span2">
                    <label for="prio" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_PRIO') ?></label>
                    <select name="prio" id="prio" class="changeEdit"/>
                        <?php
                        $priorities = array('Normaal', 'Hoog', 'Laag', 'Periodiek', 'tzt');
                        $current_prio = $this->item->prio;

                        foreach($priorities as $prio) {
                        if($prio == $current_prio) {
                            echo '<option selected="selected">'.$prio.'</option>';
                        } else {
                                echo '<option>'.$prio.'</option>';
                            }
                        }
                        ?>
                    </select>


                </div>
                <div class="span2">
                    <label for="category" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_CATEGORY') ?></label>
                    <select name="category" id="category" class="changeEdit"/>
                    <?php
                    $categories = array('Telefonie', 'Netwerk', 'Applicaties', 'Software', 'Hardware', 'Beheer', 'Security', 'Internet');
                    $current_category = $this->item->category;

                    foreach($categories as $category) {
                        if($category == $current_category) {
                            echo '<option selected="selected">'.$category.'</option>';
                        } else {
                            echo '<option>'.$category.'</option>';
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="span1">
                    <label for="requester" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_REQUESTER') ?></label>
                    <input type="text" name="requester" id="requester" class="required changeEdit" value="<?php echo $this->item->requester?>"/>
                </div>
                <div class="span1">
                    <label for="deadline" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_DEADLINE') ?></label>
                    <?php echo JHTML::_('calendar', $this->item->deadline, 'deadline', 'deadline', '%Y-%m-%d', array('class' => 'changeEdit')); ?>
                </div>

            </div>
            <div class="row">
                <div class="span2">
                    <label for="status" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_STATUS') ?></label>
                    <select name="status" id="status" class="changeEdit  input-medium"/>
                     <?php
                     $statussen = array('Not Started', 'Started', 'Pauzed', 'Waiting for ITON', 'Waiting for supplier', 'Waiting for other', 'Re-opened', 'Closed', 'Cancelled');
                     $current_status = $this->item->status;

                     foreach($statussen as $status) {
                         if($status == $current_status) {
                             echo '<option selected="selected">'.$status.'</option>';
                         } else {
                             echo '<option>'.$status.'</option>';
                         }
                     }
                     ?>
                    </select>
                </div>
                <div id="completeby" class="span2">
                    <label for="completed_by" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_COMPLETED') ?></label>
                    <input type="text" name="completed_by" id="completed_by" class="changeEdit" value="<?php echo $this->item->completed_by?>"/>
                </div>
                <div id="completedate"class="span3">
                    <label for="completion_date" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_COMPLETED_DATE') ?></label>
                    <?php echo JHTML::_('calendar', $this->item->completion_date, 'completion_date', 'completion_date', '%Y-%m-%d', array('class' => 'changeEdit')); ?>
                  </div>
                <div class="span2">
                    <label for="actie" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_ACTION') ?></label>
                    <select name="actie" id="actie" class="changeEdit input-medium"/>
                    <?php
                    $acties = array('Orienteren', 'Bestellen', 'Implementeren', 'Rapporteren', 'Instructie', 'Programeren', 'Geen actie');
                    $current_actie = $this->item->actie;

                    foreach($acties as $actie) {
                        if($actie == $current_actie) {
                            echo '<option selected="selected">'.$actie.'</option>';
                        } else {
                            echo '<option>'.$actie.'</option>';
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="span1">
                    <label for="assigned" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_ASSIGNED') ?></label>
                    <select name="assigned" id="assigned" class="changeEdit input-small"/>
                    <?php
                    $assign = array('MHI', 'HvT', 'MHI-HvT', 'ITON', 'Other');
                    $current_assigned = $this->item->assigned;

                    foreach($assign as $assigned) {
                        if($assigned == $current_assigned) {
                            echo '<option selected="selected">'.$assigned.'</option>';
                        } else {
                            echo '<option>'.$assigned.'</option>';
                        }
                    }
                    ?>
                    </select>
                </div>

                <div id="iton" class="span2"> <!-- Only shown when assigned is ITON CALL -->
                    <label for="itoncall" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_ITONCALL') ?></label>
                    <input type="text" name="itoncall" id="itoncall" class="changeEdit input-small" value="<?php echo $this->item->itoncall?>"/>

                </div>
            </div>

            <?php
            // check if document is new or edit
            $doc_id = $this->item->mdtickets_item_id;
            if (!$doc_id) {?>
                <!-- For new document -->
                <p class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_DETAIL') ?></p>
                <div class="row" id="detail-editor">
                    <?php echo $editor->display('detail', $this->item->detail, '100%', '300', '60', '20', false); ?>
            </div> <?php
            } else {
            ?>
                <!-- start of showing detail info no edit  show by default-->
                <div class="row" id="show-detail">
                <label for="showdetail" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_DETAIL') ?></label>
                <div id="tekst" class="well"><?php echo $this->item->detail?></div>
            </div><!-- start of showing detail info no edit -->
                                  <!-- start of edit detail when tickets is not new hidden by default -->
                <div id="show-edit"><?php echo $editor->display('detail', $this->item->detail, '100%', '300', '60', '20', false); ?></div>
            <?php } ?>

        </div>
        </div>

    <!-- Modal voor update -->
    <div id="myModal" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?php echo Jtext::_('COM_MDTICKETS_MODAL_UPDATE') ?></h3>
        </div>
        <div class="modal-body">
            <?php echo $editor->display('remark', $this->item->remark, '100%', '300', '60', '20', false); ?>
            <p></p>
            <h4><?php echo Jtext::_('COM_MDTICKETS_ITEM_ATTACHMENT_ADD') ?></h4>
            <p><input type="file" name="bijlage[test][]"></p>
            <!--<p><input type="file" name="bijlage[test][]"></p>
            <p><input type="file" name="bijlage[test][]"></p> eentje genoeg -->
        </div>
        <div class="modal-footer">
            <span class="btn-group">
            <button href="#" onclick="Joomla.submitbutton('apply')" class="btn btn-success">
                <i class="icon-apply icon-white"></i><?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_SAVE' );?>
            </button>
            <button type="button" class="btn" data-dismiss="modal" aria-hidden="true"><?php echo Jtext::_('COM_MDTICKETS_TOOLBAR_CANCEL') ?></button>
        </span>
        </div>
    </div> <!-- End of Modal -->
    <div id="files" class="row"> <!-- Start of showing attachments or comment when empty -->
        <div class="well">
            <?php if(!$num){?>
                <h4><?php echo Jtext::_('COM_MDTICKETS_ITEM_ATTACHMENT_ADD') ?></h4>
                <p><input type="file" name="bijlage[test][]"></p>
                <!-- <input type="file" name="bijlage[test][]"></p>
                <p><input type="file" name="bijlage[test][]"></p> eentje is genoeg -->
            <?php } else {
        //Import filesystem libraries. Perhaps not necessary, but does not hurt
        jimport('joomla.filesystem.file');
        jimport('joomla.filesystem.folder');

        $searchpath = JPATH_BASE . "/" . $location . DS . $ticketNum;
        if (JFolder::exists($searchpath)) {
        $jpg_files = JFolder::files($searchpath, '.*');
        if ($jpg_files) { ?>
            <h4><?php echo Jtext::_('COM_MDTICKETS_ITEM_ATTACHMENT') ?></h4>
            <p><?php echo Jtext::_('COM_MDTICKETS_ITEM_ATTACHMENT_TIP') ?></p>
            <?php foreach ($jpg_files as $jpg_file)
            { ?>
            <a href="<?php echo JURI::root()  . $location . "/" . $ticketNum . DS . $jpg_file;?>" target="_blank"><?php echo $jpg_file; ?></a><br/>
            <?php }
        } else { ?>
            <h4><?php echo Jtext::_('COM_MDTICKETS_ITEM_ATTACHMENT_NO'); ?> </h4> <?php
        }
        } else { ?>
            <h4><?php echo Jtext::_('COM_MDTICKETS_ITEM_ATTACHMENT_NO'); ?> </h4> <?php
        }
            }?>
        </div>
    </div> <!-- End of showing attachments or comment when empty -->
</form>
