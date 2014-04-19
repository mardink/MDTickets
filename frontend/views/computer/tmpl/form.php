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
                <div class="span2">
                    <label for="computername" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_COMPUTERNAME') ?></label>
                </div>
                <div class="span4">
                    <input type="text" name="computername" id="computername"  value="<?php echo $this->item->computername?>" class="required"/>
                </div>
            </div>
            <div class="row">
                <div class="span2">
                    <label for="computerdesc" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_COMPUTERDESC') ?></label>
                </div>
                <div class="span4">
                    <input type="text" name="computerdesc" id="computerdesc"  value="<?php echo $this->item->computerdesc?>" />
                </div>
            </div>
                <div class="row"><!-- User selection start-->
                    <div class="span2">
                        <label for="user_id" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_USER') ?></label>
                    </div>
                    <div class="span4">
                        <select name="user_id" id="user_id" class="changeEdit input-medium"/>
                        <?php
                        $db = JFactory::getDBO();

                        $query = 'SELECT mdtickets_user_id, shortname'
                            . ' FROM #__mdtickets_users'
                            . ' ORDER BY shortname ASC';
                        $db->setQuery( $query );
                        $users = $db->loadObjectList( );
                        $current_user = $this->item->user_id;

                        foreach($users as $user) {
                            if($user == $current_user) {
                                echo '<option value="'.$user->mdtickets_user_id.'" selected="selected">'.$user->shortname.'</option>';
                            } else {
                                echo '<option value="'.$user->mdtickets_user_id.'">'.$user->shortname.'</option>';
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div><!-- User selection end-->
                <div class="row">
                    <div class="span2">
                        <label for="password" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_PASSWORD') ?></label>
                    </div>
                    <div class="span4">
                        <input type="text" name="password" id="password"  value="<?php echo $this->item->password?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="span2">
                        <label for="computersn" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_SERIAL') ?></label>
                    </div>
                    <div class="span4">
                        <input type="text" name="computersn" id="computersn"  value="<?php echo $this->item->computersn?>" />
                    </div>
                </div>
                <div class="row"><!-- Type of computer-->
                    <div class="span2">
                        <label for="type" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_TYPE') ?></label>
                    </div>
                    <div class="span2">
                        <select name="type" id="type" class="changeEdit input-medium"/>
                        <?php
                        $computer_types = array('Desktop', 'Laptop');
                        $current_type = $this->item->type;

                        foreach($computer_types as $computer_type) {
                            if($computer_type == $current_type) {
                                echo '<option selected="selected">'.$computer_type.'</option>';
                            } else {
                                echo '<option>'.$computer_type.'</option>';
                            }
                        }
                        ?>
                        </select>
                        </div>
                    <div class="span1">
                        <label for="country" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_COUNTRY') ?></label>
                    </div>
                    <div class="span2">
                        <select name="country" id="country" class="changeEdit input-medium"/>
                        <?php
                        $countries = array('NL', 'LV', 'UK', 'FR', 'PL');
                        $current_country = $this->item->country;

                        foreach($countries as $country) {
                            if($country == $current_country) {
                                echo '<option selected="selected">'.$country.'</option>';
                            } else {
                                echo '<option>'.$country.'</option>';
                            }
                        }
                        ?>
                        </select>
                    </div>
                    </div><!-- Type of computer selection end-->
                <h4><?php echo JText::_('COM_MDTICKETS_COMPUTERS_GROUP_SOFTWARE') ?></h4>
                <div class="row"><!-- Wundows version selection start-->
                    <div class="span2">
                    <label for="windows" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_WINDOWS') ?></label>
                    </div>
                    <div class="span2">
                <select name="windows" id="windows" class="changeEdit input-medium"/>
                <?php
                $win_versions = array('Windows XP', 'Windows 7', 'Windows 8');
                $current_windows = $this->item->windows;

                foreach($win_versions as $win_version) {
                    if($win_version == $current_windows) {
                        echo '<option selected="selected">'.$win_version.'</option>';
                    } else {
                        echo '<option>'.$win_version.'</option>';
                    }
                }
                ?>
                </select>
                    </div>
                    <div class="span1">
                        <label for="windows_sn" class="control-label">Product key</label>
                    </div>
                    <div class="span2">
                        <input type="text" name="windows_sn" id="windows_sn"  value="<?php echo $this->item->windows_sn?>"/>
                    </div>
                        </div><!-- Windows version selection end-->
                    <div class="row"><!-- Office version selection start-->
                        <div class="span2">
                            <label for="office" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_OFFICE') ?></label>
                        </div>
                        <div class="span2">
                            <select name="office" id="office" class="changeEdit input-medium"/>
                            <?php
                            $office_versions = array('Office 2010', 'Office 2013', 'Office 2007');
                            $current_office = $this->item->office;

                            foreach($office_versions as $office_version) {
                                if($office_version == $current_office) {
                                    echo '<option selected="selected">'.$office_version.'</option>';
                                } else {
                                    echo '<option>'.$office_version.'</option>';
                                }
                            }
                            ?>
                            </select>
                        </div>
                        <div class="span1">
                            <label for="office_sn" class="control-label">Product key</label>
                        </div>
                        <div class="span2">
                            <input type="text" name="office_sn" id="office_sn"  value="<?php echo $this->item->office_sn?>"/>
                        </div>
                        </div><!-- Office version selection end-->
                        <div class="row"><!-- Virus scanner selection start-->
                            <div class="span2">
                                <label for="software1" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_SOFTWARE1') ?></label>
                            </div>
                            <div class="span2">
                                <select name="software1" id="software1" class="changeEdit input-medium"/>
                                <?php
                                $virus_versions = array('Trendmicro', 'AVG', 'Geen');
                                $current_virus = $this->item->software1;

                                foreach($virus_versions as $virus_version) {
                                    if($virus_version == $current_virus) {
                                        echo '<option selected="selected">'.$virus_version.'</option>';
                                    } else {
                                        echo '<option>'.$virus_version.'</option>';
                                    }
                                }
                                ?>
                                </select>
                                </div>
                            <div class="span1">
                                <label for="software1_sn" class="control-label">Product key</label>
                            </div>
                            <div class="span2">
                                <input type="text" name="software1_sn" id="software1_sn"  value="<?php echo $this->item->software1_sn?>"/>
                            </div>
                            </div><!-- Virus software selection end-->
                            <div class="row"><!-- PDF Software selection start-->
                                <div class="span2">
                                    <label for="software2" class="control-label"><?php echo JText::_('COM_MDTICKETS_LABEL_SOFTWARE2') ?></label>
                                </div>
                                <div class="span2">
                                    <select name="software2" id="software2" class="changeEdit input-medium"/>
                                    <?php
                                    $pdf_versions = array('Nitropdf', 'Adobe std', 'Geen');
                                    $current_pdf = $this->item->software2;

                                    foreach($pdf_versions as $pdf_version) {
                                        if($pdf_version == $current_pdf) {
                                            echo '<option selected="selected">'.$pdf_version.'</option>';
                                        } else {
                                            echo '<option>'.$pdf_version.'</option>';
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="span1">
                                    <label for="software2_sn" class="control-label">Product key</label>
                                </div>
                                <div class="span2">
                                    <input type="text" name="software2_sn" id="software2_sn"  value="<?php echo $this->item->software2_sn?>"/>
                                </div>
                                </div><!-- PDF software selection end-->
                <h4><?php echo JText::_('COM_MDTICKETS_COMPUTERS_GROUP_BUY') ?></h4>
                <div class="row">
                    <div class="span2">
                        <label for="bought_at" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_BOUGHT_AT') ?></label>
                    </div>
                    <div class="span2">
                        <input type="text" name="bought_at" id="bought_at"  value="<?php echo $this->item->bought_at?>"/>
                    </div>
                    <div class="span1">
                    <label for="completion_date" class="control-label"><?php echo JText::_('COM_MDTICKETS_COMPUTERS_FIELD_BOUGHT_ON') ?></label>
                        </div>
                    <div class="span2">
                    <?php echo JHTML::_('calendar', $this->item->bought_on, 'bought_on', 'bought_on', '%Y-%m-%d', array('class' => 'changeEdit')); ?>
                </div>
                    </div>
                <h4<?php echo JText::_('COM_MDTICKETS_COMPUTER_REMARK') ?></h4>
                <div class="row" id="remark-editor">
                    <?php echo $editor->display('remark', $this->item->remark, '100%', '300', '60', '20', false); ?>
                </div>
        </div>
    </div>

</form>
