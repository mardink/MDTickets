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

//variables
$user = JFactory::getUser();
$username =  $user->get('username');

?>
<div class="row">
    <div class="offset10">
        <?php echo JText::_( 'COM_MDTICKETS_WELCOME' );
        echo " " . $username;?>
        <a href="index.php?option=com_users&task=user.logout&<?php echo JSession::getFormToken(); ?>=1">
            <input  type="button" name="Submit" class="btn btn-primary" value="Logout">
        </a>
    </div>

</div>
<?php
$test = MdticketsHelperDashboard::test();
echo $test;
$sqls = MdticketsHelperDashboard::sql();
foreach ($sqls as $sql) {
echo $sql['short'];
}

?>
