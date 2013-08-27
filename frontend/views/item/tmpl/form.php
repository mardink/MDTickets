<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martijn
 * Date: 29-7-13
 * Time: 20:49
 * To change this template use File | Settings | File Templates.
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
?>
<form action="index.php" method="post" id="adminForm" class="form-validate" onsubmit="return isValid()"> <!-- added onsubmit="return isValid()"  to prevent saaving-->
    <input type="hidden" name="option" value="com_mdtickets" />
    <input type="hidden" name="view" value="item" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" id="mdtickets_item_id" name="mdtickets_item_id" value="<?php echo $this->item->mdtickets_item_id ?>" />
    <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
    <div id="mdtickets_toolbar" class="row well">
    <button href="#" onclick="Joomla.submitbutton('apply')" class="btn btn-small btn-success">
        <i class="icon-apply icon-white">
        </i>
        <?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_SAVE' );?>
    </button>

    <button href="#" onclick="Joomla.submitbutton('save')" class="btn btn-small">
        <i class="icon-save ">
        </i>
        <?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_SAVE_CLOSE' );?>
    </button>

    <button href="#" onclick="Joomla.submitbutton('savenew')" class="btn btn-small">
        <i class="icon-save-new ">
        </i>
        <?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_SAVE_NEW' );?>
    </button>
<!-- onderstaande werkt niet als het veld leeg is door de validator if statement nodig
    <button href="#" onclick="Joomla.submitbutton('cancel')" class="btn btn-small">
        <i class="icon-cancel ">
        </i>
        Annuleren
    </button> -->
        <a href="index.php?option=com_mdtickets&view=items&Itemid=116"  class="btn btn-small">
            <i class="icon-cancel ">
            </i>
            <?php echo JText::_( 'COM_MDTICKETS_TOOLBAR_CANCEL' );?>
        </a>
        <input type="button" id="print_btn" class="btn btn-small btn-success" value="<?php echo Jtext::_('COM_MDTICKETS_PRINT') ?>" onclick="window.print();">
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?php
            $num = $this->item->mdtickets_item_id;
            $ticketNum = sprintf("%04d", $num);
            $user_id = $this->item->created_by;
            $user = JFactory::getUser($user_id);
            $username =  $user->get('username');

            if(!$num){?>
                    <h3>Nieuw Ticket</h3>
                <?php } else { ?>
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
                    <label for="short" class="control-label">Korte omschrijving(max 54 characters) </label>
                    <input type="text" name="short" id="short" maxlength="54" value="<?php echo $this->item->short?>" class="required"/>
                </div>
                <div class="span2">
                    <label for="prio" class="control-label">Prioriteit</label>
                    <select name="prio" id="prio"/>
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
                    <label for="category" class="control-label">Categorie</label>
                    <select name="category" id="category"/>
                    <?php
                    $categories = array('Telefonie', 'Mob-telefonie', 'Netwerk', 'Applicaties', 'Software', 'Hardware', 'Beheer', 'Security', 'Internet');
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
                    <label for="requester" class="control-label">Requested by</label>
                    <input type="text" name="requester" id="requester" value="<?php echo $this->item->requester?>"/>
                </div>
                <div class="span1">
                    <label for="deadline" class="control-label">Deadline</label>
                    <input type="date" name="deadline" id="deadline" value="<?php echo $this->item->deadline;;?>"/>
                </div>

            </div>
            <div class="row">
                <div class="span2">
                    <label for="status" class="control-label">Status</label>
                    <select name="status" id="status"/>
                     <?php
                     $statussen = array('Not Started', 'Started', 'Pauzed', 'Waiting for ITON', 'Waiting for supplier', 'Waiting for other', 'Closed', 'Cancelled');
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
                    <label for="completed_by" class="control-label">Completed by</label>
                    <input type="text" name="completed_by" id="completed_by" value="<?php echo $this->item->requester?>"/>
                </div>
                <div id="completedate"class="span2">
                    <label for="completion_date" class="control-label">Completion date</label>
                    <input type="date" name="completion_date" id="completion_date" value="<?php echo $this->item->completion_date?>"/>
                </div>
                <div class="span2">
                    <label for="assigned" class="control-label">Assigned</label>
                    <select name="assigned" id="assigned"/>
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

                <div id="iton" class="span2">
                    <label for="itoncall" class="control-label">ITON Call</label>
                    <input type="text" name="itoncall" id="itoncall" value="<?php echo $this->item->itoncall?>"/>

                </div>
            </div>

            <?php
            // check if document is new or edit
            $doc_id = $this->item->mdtickets_item_id;
            if (!$doc_id) {?>
                <p class="control-label">Detail description</p>
                <div class="row" id="detail-editor">
                    <?php echo $editor->display('detail', $this->item->detail, '100%', '300', '60', '20', false); ?>
            </div> <?php
            } else {
            ?>
                <button id="edit-button" class="btn btn-small btn-primary" type="button">Edit</button><button id="toevoegen" class="btn btn-small btn-success" type="button">Toevoegen</button>
            <div class="row" id="show-detail">
                <label for="showdetail" class="control-label">Detail description</label>
                <div id="tekst" class="well"><?php echo $this->item->detail?></div>
            </div>
                <div id="show-edit"><?php echo $editor->display('detail', $this->item->detail, '100%', '300', '60', '20', false); ?></div>
            <?php } ?>

        </div>
        </div>
        <div id="show-update">
            <h3>Update</h3>
            <?php echo $editor->display('remark', $this->item->remark, '100%', '300', '60', '20', false); ?></div>
    </div>
</form>
