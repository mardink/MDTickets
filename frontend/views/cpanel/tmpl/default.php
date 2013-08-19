<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martijn
 * Date: 14-8-13
 * Time: 19:45
 * To change this template use File | Settings | File Templates.
 */
defined('_JEXEC') or die();
// Load helper
$this->loadHelper('dashboard');
JHTML::_('behavior.framework');
// eerst JQuery toevoegen
JHtml::_('bootstrap.framework');

FOFTemplateUtils::addJS('media://com_mdtickets/js/mdtickets_dashboard.js');
FOFTemplateUtils::addJS('media://com_mdtickets/js/mdtickets_login.js');

//variables
$user = JFactory::getUser();
$username =  $user->get('username');
$user_id = $user->id;
// set the return page after succesfull login
$return = "index.php?option=com_mdtickets&view=cpanel";
$return = urlencode(base64_encode($return));

?>
<!-- begin login / logout form -->
<div class="row" xmlns="http://www.w3.org/1999/html">
        <?php if ($user_id != "0"){ ?>
            <div class="offset10">
        <?php echo JText::_( 'COM_MDTICKETS_WELCOME' );
        echo " " . $username;?>
        <a href="index.php?option=com_users&task=user.logout&<?php echo JSession::getFormToken(); ?>=1">
            <input  type="button" name="Submit" class="btn btn-primary" value="Logout">
        </a>
    </div>
    <?php } else {?>

            <form id="mylogin" class="pull-right" action="<?php echo JURI::root()?>index.php?option=com_users&task=user.login" method="POST">
                <input type="text" name="username" id="username" placeholder="username.." />
               <input type="password" name="password" id="password" placeholder="Password..." />
                <input type="hidden" name="return" value="<?php echo $return; ?>" />
                <?php echo JHtml::_('form.token');?>
               <input type="submit" id="btn_login" name="btn_login" class="btn btn-primary" value="Login" />
            </form>
        <?php } ?>


</div> <!-- End of the login/logout form -->
<!-- Begin content -->
<div id="mdtickets-dashboard">
    <div class="row">
        <div class="well span5">
            <h5><?php echo JText::_('COM_MDTICKETS_DASHBOARD_LATESTNEW');?></h5>
        <?php $latestitems = MdticketsHelperDashboard::getLatestNew(5);
        foreach ($latestitems as $latestitem){
            $id = $latestitem->mdtickets_item_id;
            $ticketID = sprintf("%04d", $id);
            $showLatestDate = date("d-m-y", strtotime($latestitem->created_on));
            ?>
            <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $latestitem->mdtickets_item_id;?>"><?php echo $ticketID; ?></a>
            <?php echo " - " . $latestitem->short;?><span class="pull-right"><?php echo $showLatestDate;?></span><br/>
        <?php }
        ?>
        </div>
        <div class="well span5">
            <h5><?php echo JText::_('COM_MDTICKETS_DASHBOARD_LATESTCHANGED');?></h5>
            <?php $latestitemschanged = MdticketsHelperDashboard::getLatestChanged(5);
            foreach ($latestitemschanged as $latestitemchanged){
                $id_changed = $latestitemchanged->mdtickets_item_id;
                $ticketID_changed = sprintf("%04d", $id_changed);
                $showLatestDateChanged = date("d-m-y", strtotime($latestitemchanged->modified_on));
                ?>
                <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $latestitemchanged->mdtickets_item_id;?>"><?php echo $ticketID_changed; ?></a>
                <?php echo " - " . $latestitemchanged->short;?><span class="pull-right"><?php echo $showLatestDateChanged;?></span><br/>
            <?php }
            ?>
        </div>
        <div class="well span2">
            <!-- Begin load a joomla module position. Module posname Dashboard -->
            <?php jimport('joomla.application.module.helper');
            // this is where you want to load your module position
            $modules = JModuleHelper::getModules('dashboard');
            foreach($modules as $module)
            {
            echo JModuleHelper::renderModule($module);
            }
            ?>
            <!-- End load a joomla module position. Module posname Dashboard -->
        </div>
    </div>
    <div class="row">
        <div class="well span5">
            <h5><?php echo JText::_('COM_MDTICKETS_DASHBOARD_LATESTFINISHED');?></h5>
            <?php $finisheditems = MdticketsHelperDashboard::getLatestFinished(5);
            foreach ($finisheditems as $finisheditem){
                $id_finished = $finisheditem->mdtickets_item_id;
                $ticketID_finished = sprintf("%04d", $id_finished);
                $showfinishedDate = date("d-m-y", strtotime($finisheditem->completion_date));
                ?>
                <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $latestitem->mdtickets_item_id;?>"><?php echo $ticketID_finished; ?></a>
                <?php echo " - " . $finisheditem->short;?><span class="pull-right"><?php echo $showfinishedDate;?></span><br/>
            <?php }
            ?>
        </div>


</div><!-- End content -->