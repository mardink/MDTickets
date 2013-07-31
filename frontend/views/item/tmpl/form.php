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

// Load the Javascript framework for Joomla!
JHTML::_('behavior.framework');
// Load custom js file
FOFTemplateUtils::addJS('media://com_mdtickets/js/mdtickets.js');
// Load the editor
$editor = JFactory::getEditor();
?>
<form action="index.php" method="post" id="adminForm" xmlns="http://www.w3.org/1999/html">
    <input type="hidden" name="option" value="com_mdtickets" />
    <input type="hidden" name="view" value="item" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="mdtickets_item_id" value="<?php echo $this->item->mdtickets_item_id ?>" />
    <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />

    <div class="row-fluid">
        <div class="span12">
            <?php
            $num = $this->item->mdtickets_item_id;
            $ticketNum = sprintf("%04d", $num);
            if(!$num){?>
                    <h3>Nieuw Ticket</h3>
                <?php } else { ?>
                    <h3>Ticket <?php echo $ticketNum; ?></h3>
                <?php } ?>
            <div class="row">
                <div class="span3">
                    <label for="prio" class="control-label">Prioriteit</label>
                    <select name="prio" id="prio"/>
                        <?php
                        $priorities = array('Hoog', 'Normaal', 'Laag', 'Periodiek', 'tzt');
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
                <div class="span3">
                    <label for="category" class="control-label">Categorie</label>
                    <select name="category" id="category"/>
                    <?php
                    $categories = array('Budget Generator', 'Telefonie', 'Netwerk');
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
                <div class="span3">
                    <label for="requester" class="control-label">Requested by</label>
                    <input type="text" name="requester" id="requester" value="<?php echo $this->item->requester?>"/>
                </div>
                <div class="span3">
                    <label for="deadline" class="control-label">Deadline</label>
                    <input type="date" name="deadline" id="deadline" value="<?php echo $this->item->deadline?>"/>
                </div>
            </div>
            <div class="row">
                <label for="short" class="control-label">Korte omschrijving </label>
                <input type="text" name="short" id="short" size="100" maxlength="100" value="<?php echo $this->item->short?>"/>
            </div>
            <div class="row">
                <?php echo $editor->display('detail', $this->item->detail, '100%', '200', '60', '20', false); ?>
            </div>
            <div class="row">
                <div class="span3">
                    <label for="assigned" class="control-label">Assigned</label>
                    <select name="assigned" id="assigned"/>
                    <?php
                    $assign = array('MHI', 'HvT', 'MHI-HvT', 'ITON');
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
                 <div class="span3">
                    <label for="status" class="control-label">Status</label>
                    <select name="status" id="status"/>
                     <?php
                     $statussen = array('Not Started', 'Started', 'Pauzed', 'Waiting for ITON', 'Waiting for supplier', 'Waiting for info', 'Closed');
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
                <div class="span3">
                    <label for="completed_by" class="control-label">Completed by</label>
                    <input type="text" name="completed_by" id="completed_by" value="<?php echo $this->item->requester?>"/>
                </div>
                <div class="span3">
                    <label for="completion_date" class="control-label">Completion date</label>
                    <input type="date" name="completion_date" id="completion_date" value="<?php echo $this->item->completion_date?>"/>
                </div>
            </div>
            <div id="iton" class="row">
                <label for="itoncall" class="control-label">ITON Call</label>
                <input type="text" name="itoncall" id="itoncall" value="<?php echo $this->item->itoncall?>"/>
            </div>
            <div class="row">
                <?php echo $editor->display('remark', $this->item->remark, '100%', '200', '60', '20', false); ?>
            </div>
        </div>
    </div>
</form>